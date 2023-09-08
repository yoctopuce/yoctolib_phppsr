<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YTcpReq Class (used internally)
 *
 * Instances of this class represent an open TCP connection to an HTTP socket.
 * The class handles digest authorization transparently.
 */
class YTcpReq
{
    // attributes
    public YTcpHub $hub;                        // the YTcpHub to which we connect
    public bool $async;                      // true if the request is async
    public mixed $skt;                        // stream socket
    public string $request;                    // request to be sent
    public string $reqbody;                    // request body to send, if any
    public string $boundary;                   // request body boundary, if used
    public string $meta;                       // HTTP headers received in reply
    public string $reply;                      // reply buffer
    public int $retryCount;                 // number of retries for this request
    // the following attributes should not be taken for granted unless eof() returns true
    public int $errorType;                  // status of current connection
    public string $errorMsg;                   // last error message
    public int $reqcnt;

    public static int $totalTcpReqs = 0;
    private int $mstimeout;

    function __construct(YTcpHub $hub, string $request, bool $async, string $reqbody = '', int $mstimeout = YAPI_BLOCKING_REQUEST_TIMEOUT)
    {
        $pos = strpos($request, "\r");
        if ($pos !== false) {
            $request = substr($request, 0, $pos);
        }
        $boundary = '';
        if ($reqbody != '') {
            do {
                $boundary = sprintf("Zz%06xzZ", mt_rand(0, 0xffffff));
            } while (strpos($reqbody, $boundary) !== false);
            $reqbody = "--{$boundary}\r\n{$reqbody}\r\n--{$boundary}--\r\n";
        }
        $this->hub = $hub;
        $this->async = $async;
        $this->request = trim($request);
        $this->reqbody = $reqbody;
        $this->boundary = $boundary;
        $this->meta = '';
        $this->reply = '';
        $this->retryCount = 0;
        $this->mstimeout = $mstimeout;
        $this->errorType = YAPI::IO_ERROR;
        $this->errorMsg = 'could not open connection';
        $this->reqcnt = ++YTcpReq::$totalTcpReqs;
        $this->skt = null;
    }

    function eof(): bool
    {
        if (!is_null($this->skt)) {
            // there is still activity going on
            return false;
        }
        if ($this->meta != '' && $this->errorType == YAPI::SUCCESS) {
            // connection was done and ended successfully
            // check we need to unchunk the response
            $t_ofs = strpos($this->meta, "Transfer-Encoding");
            if ($t_ofs > 0) {
                $t_ofs += 17;
                $t_endl = strpos($this->meta, "\r\n", $t_ofs);
                $t_chunk = strpos($this->meta, "chunked", $t_ofs);
                if ($t_chunk !== false && $t_endl !== false && $t_chunk < $t_endl) {
                    // chuck encoded
                    $new = $this->http_chunked_decode($this->reply);
                    $this->reply = $new;
                    $this->meta = substr($this->meta, 0, $t_ofs) . substr($this->meta, $t_endl + 2);
                }
            }

            return true;
        }
        if ($this->retryCount > 3) {
            // connection permanently failed
            return true;
        }
        // connection is expected to be reopened
        return false;
    }


    function http_chunked_decode(string $data): string
    {
        $data_length = strlen($data);
        $dechunk = '';
        $ofs = 0;
        do {
            $hexstr = '';
            while ($ofs < $data_length && ($c = $data[$ofs]) != "\n") {
                if (($c >= '0' && $c <= '9') || ($c >= 'A' && $c <= 'F') || ($c >= 'a' && $c <= 'f')) {
                    $hexstr .= $c;
                }
                $ofs++;
            }
            if ($ofs < $data_length) {
                $len = hexdec($hexstr);
                if ($ofs + 3 + $len < $data_length) {
                    $ofs++;
                    $dechunk .= substr($data, $ofs, $len);
                    $ofs += 2;
                } else {
                    $ofs += 1;
                }
            }
        } while ($ofs < $data_length);
        return $dechunk;
    }

    function newsocket(int &$errno, string &$errstr, int $mstimeout): mixed
    {
        // for now, use client socket only since server sockets
        // for callbacks are not reliably available on a public server
        $addr = $this->hub->streamaddr;
        $pos = strpos($addr, '/', 9);
        if ($pos !== false) {
            $addr = substr($addr, 0, $pos);
        }
        if (substr($addr,0,6) == 'tls://') {
            $ssl_options = [];
            if (YAPI::$_yapiContext->_sslCertOptions & YAPI::NO_TRUSTED_CA_CHECK) {
                $ssl_options['verify_peer'] = false;
            }
            if (YAPI::$_yapiContext->_sslCertOptions & YAPI::NO_HOSTNAME_CHECK) {
                $ssl_options['verify_peer_name'] = false;
            }
            if (YAPI::$_yapiContext->_sslCertPath  !='') {
                $ssl_options['cafile'] = YAPI::$_yapiContext->_sslCertPath;
            }
            $sslContext = stream_context_create(['ssl' => $ssl_options]);
            $resource = @stream_socket_client($addr, $errno, $errstr, $mstimeout / 1000,STREAM_CLIENT_CONNECT,$sslContext);
        } else{
            $resource = @stream_socket_client($addr, $errno, $errstr, $mstimeout / 1000);

        }
        return $resource;
    }


    function process(string &$errmsg = ''): int
    {
        if ($this->eof()) {
            if ($this->errorType != YAPI::SUCCESS) {
                $errmsg = $this->errorMsg;
            }
            return $this->errorType;
        }
        if (!is_null($this->skt) && !is_resource($this->skt)) {
            // connection died, need to reopen
            $this->skt = null;
        }
        if (is_null($this->skt)) {
            // need to reopen connection
            if ($this->hub->isCachedHub()) {
                // special handling for "connection-less" callback mode
                $data = $this->hub->cachedQuery($this->request, $this->reqbody);
                if (is_null($data)) {
                    $this->errorType = YAPI::NOT_SUPPORTED;
                    $this->errorMsg = "query is not available in callback mode";
                    $this->retryCount = 99;
                    return YAPI::SUCCESS; // will propagate error later if needed
                }
                $skt = fopen('data:text/plain;base64,' . base64_encode($data), 'rb');
                if ($skt === false) {
                    $this->errorType = YAPI::IO_ERROR;
                    $this->errorMsg = "failed to open data stream";
                    $this->retryCount = 99;
                    return YAPI::SUCCESS; // will propagate error later if needed
                }
                stream_set_blocking($skt, false);
            } else {
                $skt = null;
                if (!is_null($this->hub->reuseskt)) {
                    $skt = $this->hub->reuseskt;
                    $this->hub->reuseskt = null;
                    if (!is_resource($skt)) {
                        // reusable socket is no more valid
                        $skt = null;
                    }
                }
                if (is_null($skt)) {
                    $errno = 0;
                    $errstr = '';
                    $skt = $this->newsocket($errno, $errstr, $this->mstimeout);
                    if ($skt === false) {
                        $this->errorType = YAPI::IO_ERROR;
                        $this->errorMsg = "failed to open socket ($errno): $errstr";
                        $this->retryCount++;
                        return YAPI::SUCCESS; // will retry later
                    }
                }
                stream_set_blocking($skt, false);
                $request = $this->format_request();
                $reqlen = strlen($request);
                if (fwrite($skt, $request, $reqlen) != $reqlen) {
                    fclose($skt);
                    $this->errorType = YAPI::IO_ERROR;
                    $this->errorMsg = "failed to write to socket";
                    $this->retryCount++;
                    return YAPI::SUCCESS; // will retry later
                }
            }
            $this->skt = $skt;
        } else {
            // read anything available on current socket, and process authentication headers
            while (true) {
                $data = fread($this->skt, 8192);
                if ($data === false) {
                    $this->errorType = YAPI::IO_ERROR;
                    $this->errorMsg = "failed to read from socket";
                    $this->retryCount++;
                    return YAPI::SUCCESS; // will retry later
                }
                //Printf("[read %d bytes]\n",strlen($data));
                if (strlen($data) == 0) {
                    break;
                }
                if ($this->reply == '' && strpos($this->meta, "\r\n\r\n") === false) {
                    $this->meta .= $data;
                    $eoh = strpos($this->meta, "\r\n\r\n");
                    if ($eoh !== false) {
                        // fully received header
                        $this->reply = substr($this->meta, $eoh + 4);
                        $this->meta = substr($this->meta, 0, $eoh + 4);
                        $firstline = substr($this->meta, 0, strpos($this->meta, "\r"));
                        if (substr($firstline, 0, 12) == 'HTTP/1.1 401') {
                            // authentication required
                            $this->errorType = YAPI::UNAUTHORIZED;
                            $this->errorMsg = "Authentication required";
                            fclose($this->skt);
                            $this->skt = null;
                            $this->hub->parseWWWAuthenticate($this->meta);
                            if ($this->hub->user != '') {
                                $this->meta = '';
                                $this->reply = '';
                                $this->retryCount++;
                            } else {
                                $this->retryCount = 99;
                            }
                            return YAPI::SUCCESS; // will propagate error later if needed
                        }
                    }
                } else {
                    $this->reply .= $data;
                }
                // so far so good
                $this->errorType = YAPI::SUCCESS;
            }
            // write request body, if any, once header is fully received
            if ($this->reqbody != '') {
                $bodylen = strlen($this->reqbody);
                $written = fwrite($this->skt, $this->reqbody, $bodylen);
                if ($written > 0) {
                    $this->reqbody = substr($this->reqbody, $written);
                }
            }
            if (!is_resource($this->skt)) {
                // socket dropped dead
                $this->skt = null;
            } elseif (feof($this->skt)) {
                fclose($this->skt);
                $this->skt = null;
            } elseif ($this->meta == "0K\r\n\r\n" && $this->reply == "\r\n") {
                if (is_null($this->hub->reuseskt)) {
                    $this->hub->reuseskt = $this->skt;
                } else {
                    fclose($this->skt);
                }
                $this->skt = null;
            }
        }
        return YAPI::SUCCESS;
    }

    function format_request(): string
    {
        $parts = explode(' ', $this->request);
        if (sizeof($parts) == 2) {
            $req = $parts[0] . ' ' . $this->hub->url_info['subdomain'] . $parts[1];
        } else {
            $req = $this->request;
        }
        if ($this->hub->use_pure_http) {
            $request = $req . " HTTP/1.1\r\n";
            $host = $this->hub->url_info['host'];
            $request .= "Host: " . $host . "\r\n";
        } else {
            $request = $req . " \r\n"; // no HTTP/1.1 suffix for light queries
        }
        $request .= $this->hub->getAuthorization($req);
        if ($this->boundary != '') {
            $request .= "Content-Type: x-upload; boundary={$this->boundary}\r\n";
            $body_size = strlen($this->reqbody);
            $request .= "Content-Length: {$body_size}\r\n";
        }
        if (substr($this->request, -2) == "&." && !$this->hub->use_pure_http) {
            $request .= "\r\n";
        } else {
            $request .= "Connection: close\r\n\r\n";
        }
        return $request;
    }

    function close(): void
    {
        if ($this->skt) {
            fclose($this->skt);
        }
    }
}


