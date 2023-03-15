<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YTcpHub Class (used internally)
 *
 * Instances of this class represent a VirtualHub or a networked Yoctopuce device
 * to which we can connect to get access to device functions. For historical reasons,
 * this class is mostly used like a structure, rather than a real object.
 */
class YTcpHub
{
    // attributes
    public string $rooturl;                    // root url of the hub (without auth parameters)
    public string $streamaddr;                 // stream address of the hub ("tcp://addr:port")
    public array $url_info;                   // $url parsed
    public string $notifurl;                   // notification file used by this hub
    public bool $use_pure_http;              // boolean that is true if the hub is VirtualHub-4web
    public ?YTcpReq $notifReq;                   // notification request, or null if not open
    public int $notifPos;                   // absolute position in notification stream
    public bool $isNotifWorking;            // boolean that is true when we receive ping notification
    public float $devListExpires;             // timestamp of next useful updateDeviceList
    public ?YTcpReq $devListReq;                 // updateDeviceList request, or null if not open
    public array $serialByYdx;                // serials by hub-specific devYdx
    public float $retryDelay;                 // delay before reconnecting in case of error
    public float $retryExpires;               // timestamp of next reconnection attempt
    public array $missing;                    // list of missing devices during updateDeviceList
    public bool $writeProtected;             // true if an adminPassword is set
    public string $user;                       // user for authentication
    public mixed $callbackData;               // raw HTTP callback data received
    public ?array $callbackCache;              // pre-parsed cache for callback-based API
    public mixed $reuseskt;                   // keep-alive socket to be reused
    protected string $realm;                   // hub authentication realm
    protected string $pwd;                     // password for authentication
    protected string $nonce;                   // lasPrint(t received nonce
    protected string $opaque;                  // last received opaque
    protected string $ha1;                     // our authentication ha1 string
    protected string $nc;                      // nounce usage count

    function __construct(array $url_info)
    {
        $this->rooturl = $url_info['rooturl'];
        $this->url_info = $url_info;
        $this->streamaddr = str_replace('http://', 'tcp://', $this->rooturl);
        $this->streamaddr = str_replace('https://', 'tls://', $this->streamaddr);
        $colon = strpos($url_info['auth'], ':');
        if ($colon === false) {
            $this->user = $url_info['auth'];
            $this->pwd = '';
        } else {
            $this->user = substr($url_info['auth'], 0, $colon);
            $this->pwd = substr($url_info['auth'], $colon + 1);
        }
        $this->notifurl = 'not.byn';
        $this->notifPos = -1;
        $this->isNotifWorking = false;
        $this->devListExpires = 0;
        $this->serialByYdx = array();
        $this->retryDelay = 15;
        $this->retryExpires = 0;
        $this->writeProtected = false;
        $this->use_pure_http = false;
        $this->reuseskt = null;
        $this->notifReq = null;
        $this->realm = '';
    }

    static function decodeJZONReq(mixed $jzon, mixed $ref): mixed
    {
        $res = array();
        $ofs = 0;
        if (is_array($ref)) {
            foreach ($ref as $key => $value) {
                if (key_exists($key, $jzon)) {
                    $res[$key] = self::decodeJZONReq($jzon[$key], $value);
                } elseif (isset($jzon[$ofs])) {
                    $res[$key] = self::decodeJZONReq($jzon[$ofs], $value);
                }
                $ofs++;
            }
            return $res;
        }
        return $jzon;
    }

    static function decodeJZONService(array $jzon, array $ref): array
    {
        $wp = array();
        $yp = array();
        foreach ($jzon[0] as $wp_entry) {
            $wp[] = self::decodeJZONReq($wp_entry, $ref['whitePages'][0]);
        }


        $yp_entry_ref = $ref['yellowPages'][array_key_first($ref['yellowPages'])][0];
        foreach ($jzon[1] as $yp_type => $yp_entries) {
            $yp[$yp_type] = array();
            foreach ($yp_entries as $yp_entry) {
                $yp[$yp_type][] = self::decodeJZONReq($yp_entry, $yp_entry_ref);
            }
        }
        return ['whitePages' => $wp, 'yellowPages' => $yp];
    }


    static function decodeJZON(array $jzon, array $ref): mixed
    {
        $decoded = self::decodeJZONReq($jzon, $ref);
        if (array_key_exists('services', $ref)) {
            $ofs = sizeof($jzon) - 1;
            if (isset($jzon[$ofs])) {
                $decoded['services'] = self::decodeJZONService($jzon[$ofs], $ref['services']);
            }
        }
        return $decoded;
    }


    static function cleanJsonRef(array $ref): array
    {
        $res = array();
        foreach ($ref as $key => $value) {
            if (is_array($value)) {
                $res[$key] = self::cleanJsonRef($value);
            } elseif ($key == "serialNumber") {
                $res[$key] = substr($value, 0, YOCTO_BASE_SERIAL_LEN);
            } elseif ($key == "firmwareRelease") {
                $res[$key] = $value;
            } else {
                $res[$key] = "";
            }
        }
        return $res;
    }


    function verfiyStreamAddr(bool $fullTest = true, string &$errmsg = ''): int
    {
        if ($this->streamaddr == 'tcp://CALLBACK') {

            if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] != 'POST') {
                $errmsg = "invalid request method";
                $this->callbackCache = array();
                return YAPI::IO_ERROR;
            }

            if (!isset($_SERVER['CONTENT_TYPE']) || $_SERVER['CONTENT_TYPE'] != 'application/json') {
                $errmsg = "invalid content type";
                $this->callbackCache = array();
                return YAPI::IO_ERROR;
            }
            if (!isset($_SERVER['HTTP_USER_AGENT'])) {
                $errmsg = "not agent provided";
                $this->callbackCache = array();
                return YAPI::IO_ERROR;
            }
            $useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
            $patern = 'yoctohub';
            if ($useragent != 'virtualhub' && substr($useragent, 0, strlen($patern)) != $patern) {
                $errmsg = "no user agent provided";
                $this->callbackCache = array();
                return YAPI::IO_ERROR;
            }

            if ($fullTest) {
                if (isset($_SERVER['HTTP_RAW_POST_DATA'])) {
                    $data = $_SERVER['HTTP_RAW_POST_DATA'];
                } else {
                    $data = file_get_contents('php://input');
                }
                $this->callbackData = $data;
                if ($data == "") {
                    $errmsg = "RegisterHub(callback) used without posting YoctoAPI data";
                    print("\n!YoctoAPI:$errmsg\n");
                    $this->callbackCache = array();
                    return YAPI::IO_ERROR;
                } else {
                    if (isset($_SERVER['HTTP_JSON_POST_DATA'])) {
                        $this->callbackCache = $_SERVER['HTTP_JSON_POST_DATA'];
                    } else {
                        $utf8_encode = utf8_encode($data);
                        $this->callbackCache = json_decode($utf8_encode, true);
                    }
                    if (is_null($this->callbackCache)) {
                        $errmsg = "invalid data:[\n$data\n]";
                        print("\n!YoctoAPI:$errmsg\n");
                        $this->callbackCache = array();
                        return YAPI::IO_ERROR;
                    }
                    if ($this->pwd != '') {
                        // callback data signed, verify signature
                        if (!isset($this->callbackCache['sign'])) {
                            $errmsg = "missing signature from incoming YoctoHub (callback password required)";
                            print("\n!YoctoAPI:$errmsg\n");
                            $this->callbackCache = array();
                            return YAPI::UNAUTHORIZED;
                        }
                        $sign = $this->callbackCache['sign'];
                        $salt = $this->pwd;
                        if (strlen($salt) != 32) {
                            $salt = md5($salt);
                        }
                        $data = str_replace($sign, strtolower($salt), $data);
                        $check = strtolower(md5($data));
                        if ($check != $sign) {
                            //Print("Computed signature: $check\n");
                            //Print("Received signature: $sign\n");
                            $errmsg = "invalid signature from incoming YoctoHub (invalid callback password)";
                            print("\n!YoctoAPI:$errmsg\n");
                            $this->callbackCache = array();
                            return YAPI::UNAUTHORIZED;
                        }
                    }
                    if (isset($this->callbackCache['serial']) && !is_null(YAPI::$_jzonCacheDir)) {
                        $jzonCacheDir = YAPI::$_jzonCacheDir;
                        $mergedCache = array();
                        $upToDate = true;
                        foreach ($this->callbackCache as $req => $value) {
                            $pos = strpos($req, "/api.json");
                            if ($pos !== false) {
                                $fwpos = strpos($req, "?fw=", $pos);
                                $isJZON = false;
                                if ($fwpos !== false) {
                                    if (key_exists('module', $value)) {
                                        // device did not return JZON (probably due to fw update)
                                        $req = substr($req, 0, $fwpos);
                                    } else {
                                        $isJZON = true;
                                    }
                                }
                                if ($isJZON) {
                                    if ($pos == 0) {
                                        $serial = $this->callbackCache['serial'];
                                    } else {
                                        // "/bySerial/" = 10 chars
                                        $serial = substr($req, 10, $pos - 10);
                                    }
                                    $firm = str_replace([' ', ':'], '_', substr($req, $fwpos + 4));
                                    $base = substr($serial, 0, YOCTO_BASE_SERIAL_LEN);
                                    if (!is_file("{$jzonCacheDir}{$base}_{$firm}.json")) {
                                        $errmsg = "No JZON reference file for {$serial}/{$firm}";
                                        print("\n!YoctoAPI:$errmsg\n");
                                        $this->callbackCache = array();
                                        print("\n@YoctoAPI:#!noref\n");
                                        return YAPI::IO_ERROR;
                                    }
                                    $ref = file_get_contents("{$jzonCacheDir}{$base}_{$firm}.json");
                                    $ref = json_decode($ref, true);
                                    $decoded = self::decodeJZON($value, $ref);
                                    if ($ref['module']['firmwareRelease'] != $decoded['module']['firmwareRelease']) {
                                        $errmsg = "invalid JZON data";
                                        print("\n!YoctoAPI:$errmsg\n");
                                        $this->callbackCache = array();
                                        print("\n@YoctoAPI:#!invalid\n");
                                        return YAPI::IO_ERROR;
                                    }
                                    $req = substr($req, 0, $fwpos);
                                    $mergedCache[$req] = $decoded;
                                    //Print("Use jzon data for {$serial}/{$firm}\n");
                                } else {
                                    $serial = $value['module']['serialNumber'];
                                    $base = substr($serial, 0, YOCTO_BASE_SERIAL_LEN);
                                    $firm = str_replace([' ', ':'], '_', $value['module']['firmwareRelease']);
                                    $clean_struct = self::cleanJsonRef($value);
                                    file_put_contents("{$jzonCacheDir}{$base}_{$firm}.json", json_encode($clean_struct));
                                    $mergedCache[$req] = $value;
                                    print("\n@YoctoAPI:#{$serial}/{$firm}\n");
                                    $upToDate = false;
                                }
                            } else {
                                $mergedCache[$req] = $value;
                            }
                        }
                        if ($upToDate) {
                            print("\n@YoctoAPI:#=\n");
                        }
                        $this->callbackCache = $mergedCache;
                    }
                    // decode binary content
                    foreach ($this->callbackCache as $url => $data) {
                        if (!is_string($data)) {
                            continue;
                        }
                        $len = strlen($url);
                        if ($len > 2 && substr($url, $len - 2) === '.#') {
                            $this->callbackCache[substr($url, 0, $len - 2)] = base64_decode($data);
                        }
                    }
                }
            }
        } else {
            $info_json_url = $this->rooturl . $this->url_info['subdomain'] . '/info.json';
            $info_json = @file_get_contents($info_json_url);
            $jsonData = json_decode($info_json, true);
            if ($jsonData != null && array_key_exists('protocol', $jsonData) && $jsonData['protocol'] == 'HTTP/1.1') {
                $this->use_pure_http = true;
            }
            $this->callbackCache = null;
        }
        return 0;
    }

    /**
     * Update the hub internal variables according
     * to a received header with WWW-Authenticate
     */
    function parseWWWAuthenticate(string $header): void
    {
        $pos = stripos($header, "\r\nWWW-Authenticate:");
        if ($pos === false) {
            return;
        }
        $header = substr($header, $pos + 19);
        $eol = strpos($header, "\r");
        if ($eol !== false) {
            $header = substr($header, 0, $eol);
        }
        $tags = null;
        if (preg_match_all('~(?<tag>\w+)="(?<value>[^"]*)"~m', $header, $tags) == false) {
            return;
        }
        $this->realm = '';
        $this->nonce = '';
        $this->opaque = '';
        for ($i = 0; $i < sizeof($tags['tag']); $i++) {
            if ($tags['tag'][$i] == "realm") {
                $this->realm = $tags['value'][$i];
            } elseif ($tags['tag'][$i] == "nonce") {
                $this->nonce = $tags['value'][$i];
            } elseif ($tags['tag'][$i] == "opaque") {
                $this->opaque = $tags['value'][$i];
            }
        }
        $this->nc = 0;
        $this->ha1 = md5($this->user . ':' . $this->realm . ':' . $this->pwd);
    }

    /**
     * Return an Authorization header for a given request
     * @param string $request
     * @return string
     */
    function getAuthorization(string $request): string
    {
        if ($this->user == '' || $this->realm == '') {
            return '';
        }
        $this->nc++;
        $pos = strpos($request, ' ');
        $method = substr($request, 0, $pos);
        $uri = substr($request, $pos + 1);
        $nc = sprintf("%08x", $this->nc);
        $cnonce = sprintf("%08x", mt_rand(0, 0x7fffffff));
        $ha1 = $this->ha1;
        $ha2 = md5("{$method}:{$uri}");
        $nonce = $this->nonce;
        $response = md5("{$ha1}:{$nonce}:{$nc}:{$cnonce}:auth:{$ha2}");
        $res = 'Authorization: Digest username="' . $this->user . '", realm="' . $this->realm . '",' .
            ' nonce="' . $this->nonce . '", uri="' . $uri . '", qop=auth, nc=' . $nc . ',' .
            ' cnonce="' . $cnonce . '", response="' . $response . '", opaque="' . $this->opaque . '"';
        return "$res\r\n";
    }

    // Return true if a hub is just a virtual cache (for callback mode)
    function isCachedHub(): bool
    {
        return !is_null($this->callbackCache);
    }

    // Execute a query for cached hub (for callback mode)
    function cachedQuery(string $str_query, string $str_body): ?string
    {
        // apply POST remotely
        if (substr($str_query, 0, 5) == 'POST ') {
            $boundary = '???';
            $endb = strpos($str_body, "\r");
            if (substr($str_body, 0, 2) == '--' && $endb > 2 && $endb < 20) {
                $boundary = substr($str_body, 2, $endb - 2);
            }
            Printf("\n@YoctoAPI:$str_query %d:%s\n%s", strlen($str_body), $boundary, $str_body);
            return "OK\r\n\r\n";
        }
        if (substr($str_query, 0, 4) != 'GET ') {
            return null;
        }
        // remove JZON trigger if present (not relevant in callback mode)
        $jzon = strpos($str_query, '?fw=');
        if ($jzon !== false && strpos($str_query, '&', $jzon) === false) {
            $str_query = substr($str_query, 0, $jzon);
        }
        // dispatch between cached get and remote set
        if (strpos($str_query, '?') === false ||
            strpos($str_query, '/@YCB+') !== false ||
            strpos($str_query, '/logs.txt') !== false ||
            strpos($str_query, '/tRep.bin') !== false ||
            strpos($str_query, '/logger.json') !== false ||
            strpos($str_query, '/ping.txt') !== false ||
            strpos($str_query, '/files.json?a=dir') !== false) {
            // read request, load from cache
            $parts = explode(' ', $str_query);
            $url = $parts[1];
            $getmodule = (strpos($url, 'api/module.json') !== false);
            if ($getmodule) {
                $url = str_replace('api/module.json', 'api.json', $url);
            }
            if (!isset($this->callbackCache[$url])) {
                if ($url == "/api.json") {
                    // /api.json is not present in cache. Report an error to force the hub
                    // to switch back to json encoding
                    print("\n!YoctoAPI:$url is in cache. Disable JZON encoding");
                    print("\n@YoctoAPI:#!invalid\n");
                    return null;
                }
                if (strpos($url, "@YCB+") !== false) {
                    // file has be requested by addFileToHTTPCallback
                    $url = str_replace('@YCB+', '', $url);
                    print("\n@YoctoAPI:+$url\n");
                    return "OK\r\n\r\n";
                } else {
                    print("\n!YoctoAPI:$url is not preloaded, adding to list");
                    print("\n@YoctoAPI:+$url\n");
                    return null;
                }
            }
            // Print("\n[$url found]\n");
            $jsonres = $this->callbackCache[$url];
            if ($getmodule) {
                $jsonres = $jsonres['module'];
            }
            if (strpos($str_query, '.json') !== false) {
                $jsonres = json_encode($jsonres);
            }
            return "OK\r\n\r\n$jsonres";
        } else {
            // change request, print to output stream
            print("\n@YoctoAPI:$str_query \n");
            return "OK\r\n\r\n";
        }
    }

    public function getBaseURL(): string
    {
        return $this->url_info['rooturl'] . $this->url_info['subdomain'] . '/';
    }
}

