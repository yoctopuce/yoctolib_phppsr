<?php
namespace Yoctopuce\YoctoAPI;
//
// YAPI Context
//
// This class provides the high-level entry points to access Functions, stores
// an indexes instances of the Device object and of FunctionType collections.
//

const NOTIFY_NETPKT_NAME = '0';
const NOTIFY_NETPKT_CHILD = '2';
const NOTIFY_NETPKT_FUNCNAME = '4';
const NOTIFY_NETPKT_FUNCVAL = '5';
const NOTIFY_NETPKT_LOG = '7';
const NOTIFY_NETPKT_FUNCNAMEYDX = '8';
const NOTIFY_NETPKT_CONFCHGYDX = 's';
const NOTIFY_NETPKT_FLUSHV2YDX = 't';
const NOTIFY_NETPKT_FUNCV2YDX = 'u';
const NOTIFY_NETPKT_TIMEV2YDX = 'v';
const NOTIFY_NETPKT_DEVLOGYDX = 'w';
const NOTIFY_NETPKT_TIMEVALYDX = 'x';
const NOTIFY_NETPKT_FUNCVALYDX = 'y';
const NOTIFY_NETPKT_TIMEAVGYDX = 'z';
const NOTIFY_NETPKT_NOT_SYNC = '@';
const NOTIFY_NETPKT_STOP = 10; // =\n

const NOTIFY_V2_LEGACY = 0;       // unused (reserved for compatibility with legacy notifications)
const NOTIFY_V2_6RAWBYTES = 1;    // largest type: data is always 6 bytes
const NOTIFY_V2_TYPEDDATA = 2;    // other types: first data byte holds the decoding format
const NOTIFY_V2_FLUSHGROUP = 3;   // no data associated

const PUBVAL_LEGACY = 0;   // 0-6 ASCII characters (normally sent as YSTREAM_NOTICE)
const PUBVAL_1RAWBYTE = 1;   // 1 raw byte  (=2 characters)
const PUBVAL_2RAWBYTES = 2;   // 2 raw bytes (=4 characters)
const PUBVAL_3RAWBYTES = 3;   // 3 raw bytes (=6 characters)
const PUBVAL_4RAWBYTES = 4;   // 4 raw bytes (=8 characters)
const PUBVAL_5RAWBYTES = 5;   // 5 raw bytes (=10 characters)
const PUBVAL_6RAWBYTES = 6;   // 6 hex bytes (=12 characters) (sent as V2_6RAWBYTES)
const PUBVAL_C_LONG = 7;   // 32-bit C signed integer
const PUBVAL_C_FLOAT = 8;   // 32-bit C float
const PUBVAL_YOCTO_FLOAT_E3 = 9;   // 32-bit Yocto fixed-point format (e-3)
const PUBVAL_YOCTO_FLOAT_E6 = 10;   // 32-bit Yocto fixed-point format (e-6)

// Calibration types
const YOCTO_CALIB_TYPE_OFS = 30;

// Maximum device request timeout
const YAPI_BLOCKING_REQUEST_TIMEOUT = 20000;
const YIO_DEFAULT_TCP_TIMEOUT = 20000;
const YIO_1_MINUTE_TCP_TIMEOUT = 60000;
const YIO_10_MINUTES_TCP_TIMEOUT = 600000;

const YOCTO_PUBVAL_LEN = 16;
const YOCTO_PUBVAL_SIZE = 6;
const YOCTO_SERIAL_LEN = 20;
const YOCTO_BASE_SERIAL_LEN = 8;


class YAPI
{

    const INVALID_STRING = "!INVALID!";
    const INVALID_INT = 0x7fffffff;
    const INVALID_UINT = -1;
    const INVALID_DOUBLE = -66666666.66666666;
    const INVALID_LONG = 0x7fffffffffffffff;
    const HASH_BUF_SIZE = 28;
    const MIN_DOUBLE = -INF;
    const MAX_DOUBLE = INF;

//--- (generated code: YFunction return codes)
    const SUCCESS               = 0;       // everything worked all right
    const NOT_INITIALIZED       = -1;      // call yInitAPI() first !
    const INVALID_ARGUMENT      = -2;      // one of the arguments passed to the function is invalid
    const NOT_SUPPORTED         = -3;      // the operation attempted is (currently) not supported
    const DEVICE_NOT_FOUND      = -4;      // the requested device is not reachable
    const VERSION_MISMATCH      = -5;      // the device firmware is incompatible with this API version
    const DEVICE_BUSY           = -6;      // the device is busy with another task and cannot answer
    const TIMEOUT               = -7;      // the device took too long to provide an answer
    const IO_ERROR              = -8;      // there was an I/O problem while talking to the device
    const NO_MORE_DATA          = -9;      // there is no more data to read from
    const EXHAUSTED             = -10;     // you have run out of a limited resource, check the documentation
    const DOUBLE_ACCES          = -11;     // you have two process that try to access to the same device
    const UNAUTHORIZED          = -12;     // unauthorized access to password-protected device
    const RTC_NOT_READY         = -13;     // real-time clock has not been initialized (or time was lost)
    const FILE_NOT_FOUND        = -14;     // the file is not found
    const SSL_ERROR             = -15;     // Error reported by mbedSSL
    const RFID_SOFT_ERROR       = -16;     // Recoverable error with RFID tag (eg. tag out of reach), check YRfidStatus for details
    const RFID_HARD_ERROR       = -17;     // Serious RFID error (eg. write-protected, out-of-boundary), check YRfidStatus for details
    const BUFFER_TOO_SMALL      = -18;     // The buffer provided is too small
    const DNS_ERROR             = -19;     // Error during name resolutions (invalid hostname or dns communication error)
    const SSL_UNK_CERT          = -20;     // The certificate is not correctly signed by the trusted CA
    // TLS / SSL definitions
    const NO_TRUSTED_CA_CHECK   = 1;       // Disables certificate checking
    const NO_EXPIRATION_CHECK   = 2;       // Disables certificate expiration date checking
    const NO_HOSTNAME_CHECK     = 4;       // Disable hostname checking
    const LEGACY                = 8;       // Allow non secure connection (similar to v1.10)
//--- (end of generated code: YFunction return codes)

    // yInitAPI constants (not really useful in JavaScript)
    const DETECT_NONE = 0;
    const DETECT_USB = 1;
    const DETECT_NET = 2;
    const DETECT_ALL = 3;

    // Abstract function BaseTypes
    public static array $BASETYPES = array(
        'Function' => 0,
        'Sensor' => 1
    );

    /**
     * @var YTcpHub[]
     */
    private static ?array $_hubs = null;           // array of root urls
    /**
     * @var YDevice[]
     */
    protected static array $_devs = [];           // hash table of devices, by serial number
    protected static array $_snByUrl = [];        // serial number for each device, by URL
    protected static array $_snByName = [];       // serial number for each device, by name
    /**
     * @var YFunctionType[]
     */
    protected static array $_fnByType;       // functions by type
    protected static int $_lastErrorType;
    protected static string $_lastErrorMsg;
    protected static bool $_firstArrival;
    protected static array $_pendingCallbacks;
    protected static mixed $_arrivalCallback;
    protected static mixed $_namechgCallback;
    protected static mixed $_removalCallback;
    protected static array $_data_events;
    /** @var  YTcpReq[] */
    protected static array $_pendingRequests;
    protected static array $_beacons;
    protected static array $_calibHandlers;
    protected static array $_decExp;

    public static ?string $_jzonCacheDir;

    public static YAPIContext $_yapiContext;

    // PUBLIC GLOBAL SETTINGS

    // Default cache validity (in [ms]) before reloading data from device. This saves a lots of trafic.
    // Note that a value under 2 ms makes little sense since a USB bus itself has a 2ms roundtrip period
    public static float $defaultCacheValidity = 5;

    // Switch to turn off exceptions and use return codes instead, for source-code compatibility
    // with languages without exception support like C
    public static bool $exceptionsDisabled = false;  // set to true if you want error codes instead of exceptions

    public static function _init(): void
    {
        // private
        self::$_hubs = array();
        self::$_devs = array();
        self::$_snByUrl = array();
        self::$_snByName = array();
        self::$_fnByType = array();
        self::$_lastErrorType = YAPI::SUCCESS;
        self::$_lastErrorMsg = 'no error';
        self::$_firstArrival = true;
        self::$_pendingCallbacks = array();
        self::$_arrivalCallback = null;
        self::$_namechgCallback = null;
        self::$_removalCallback = null;
        self::$_data_events = array();
        self::$_pendingRequests = array();
        self::$_beacons = array();
        self::$_jzonCacheDir = null;
        self::$_yapiContext = new YAPIContext();

        self::$_decExp = array(
            1.0e-6,
            1.0e-5,
            1.0e-4,
            1.0e-3,
            1.0e-2,
            1.0e-1,
            1.0,
            1.0e1,
            1.0e2,
            1.0e3,
            1.0e4,
            1.0e5,
            1.0e6,
            1.0e7,
            1.0e8,
            1.0e9
        );
        self::$_fnByType['Module'] = new YFunctionType('Module');
        for ($yHdlrIdx = 1; $yHdlrIdx <= 20; $yHdlrIdx++) {
            YAPI::RegisterCalibrationHandler($yHdlrIdx, 'Yoctopuce\YoctoAPI\YAPI::LinearCalibrationHandler');
        }
        YAPI::RegisterCalibrationHandler(YOCTO_CALIB_TYPE_OFS, 'Yoctopuce\YoctoAPI\YAPI::LinearCalibrationHandler');
        register_shutdown_function('Yoctopuce\YoctoAPI\YAPI::flushConnections');
    }

    // numeric strpos helper

    public static function Ystrpos(string $haystack, string $needle): int
    {
        $res = strpos($haystack, $needle);
        if ($res === false) {
            $res = -1;
        }
        return $res;
    }

    /**
     * Throw an exception, keeping track of it in the object itself
     * @param int $int_errType
     * @param string $str_errMsg
     * @param mixed $obj_retVal
     * @return mixed
     * @throws YAPI_Exception
     */
    protected static function _throw(int $int_errType, string $str_errMsg, mixed $obj_retVal): mixed
    {
        self::$_lastErrorType = $int_errType;
        self::$_lastErrorMsg = $str_errMsg;

        if (self::$exceptionsDisabled) {
            return $obj_retVal;
        }
        // throw an exception
        throw new YAPI_Exception($str_errMsg, $int_errType);
    }

    // Update the list of known devices internally

    /**
     * @throws YAPI_Exception
     */
    public static function _updateDeviceList_internal(bool $bool_forceupdate, bool $bool_invokecallbacks): YAPI_YReq
    {
        if (self::$_firstArrival && $bool_invokecallbacks && !is_null(self::$_arrivalCallback)) {
            $bool_forceupdate = true;
        }
        $now = self::GetTickCount();
        if ($bool_forceupdate) {
            foreach (self::$_hubs as $hub) {
                $hub->devListExpires = $now;
            }
        }

        // Prepare to scan all expired hubs
        $hubs = array();
        foreach (self::$_hubs as $hub) {
            if (!$hub->isEnable()) {
                continue;
            }
            if ($hub->devListExpires <= $now) {
                $tcpreq = new YTcpReq($hub, 'GET /api.json', false, '', $hub->get_networkTimeout());
                self::$_pendingRequests[] = $tcpreq;
                $hubs[] = $hub;
                $hub->devListReq = $tcpreq;
                $hub->missing = array();
            }
        }

        // assume all device as unpluged, unless proved wrong
        foreach (self::$_devs as $serial => $dev) {
            $rooturl = $dev->getRootUrl();
            foreach ($hubs as $hub) {
                if (!$hub->isEnable()) {
                    continue;
                }
                $huburl = $hub->getRooturl();
                if (substr($rooturl, 0, strlen($huburl)) == $huburl) {
                    $hub->missing[$serial] = true;
                }
            }
        }

        // Wait until all hubs are complete, and process replies as they come
        $timeout = self::GetTickCount() + YAPI::$_yapiContext->_networkTimeoutMs;
        while (self::GetTickCount() < $timeout) {
            self::_handleEvents_internal(100);
            $alldone = true;
            foreach ($hubs as $hub) {
                /** @var YTcpHub $hub */
                if (!$hub->isEnable()) {
                    continue;
                }
                $req = $hub->devListReq;
                if (!$req->eof()) {
                    $alldone = false;
                    continue;
                }
                if ($req->errorType != YAPI::SUCCESS) {
                    // report problems later
                    continue;
                }
                $loadval = json_decode(iconv("ISO-8859-1", "UTF-8", $req->reply), true);
                if (!$loadval) {
                    $req->errorType = YAPI::IO_ERROR;
                    continue;
                }
                if (!isset($loadval['services']) || !isset($loadval['services']['whitePages'])) {
                    $req->errorType = YAPI::INVALID_ARGUMENT;
                    continue;
                }
                if (isset($loadval['network']) && isset($loadval['network']['adminPassword'])) {
                    $hub->writeProtected = ($loadval['network']['adminPassword'] != '');
                }
                $whitePages = $loadval['services']['whitePages'];
                // Reindex all functions from yellow pages
                $refresh = array();
                $yellowPages = $loadval["services"]["yellowPages"];
                foreach ($yellowPages as $classname => $obj_yprecs) {
                    if (!isset(self::$_fnByType[$classname])) {
                        self::$_fnByType[$classname] = new YFunctionType($classname);
                    }
                    $ftype = self::$_fnByType[$classname];
                    foreach ($obj_yprecs as $yprec) {
                        $hwid = $yprec["hardwareId"];
                        $basetype = (isset($yprec["baseType"]) ? $yprec["baseType"] : null);
                        if ($ftype->reindexFunction($hwid, $yprec["logicalName"], $yprec["advertisedValue"], $basetype)) {
                            // logical name discrepency detected, force a refresh from device
                            $serial = substr($hwid, 0, strpos($hwid, '.'));
                            $refresh[$serial] = true;
                        }
                    }
                }
                // Reindex all devices from white pages
                foreach ($whitePages as $devinfo) {
                    $serial = $devinfo['serialNumber'];
                    $rooturl = substr($devinfo['networkUrl'], 0, -3);
                    if ($rooturl[0] == '/') {
                        $rooturl = $hub->getRooturl() . $rooturl;
                    }
                    $currdev = null;
                    if (isset(self::$_devs[$serial])) {
                        $currdev = self::$_devs[$serial];
                        foreach (YFunction::$_ValueCallbackList as $fun) {
                            $hwId = $fun->_getHwId();
                            if (!$hwId) {
                                YAPI::addRefreshEvent($fun);
                            }
                        }
                    }
                    if (isset($devinfo['index'])) {
                        $devydx = $devinfo['index'];
                        $hub->serialByYdx[$devydx] = $serial;
                    }
                    if (!isset(self::$_devs[$serial])) {
                        // Add new device
                        new YDevice($rooturl, $devinfo, $loadval["services"]["yellowPages"]);
                        if (!is_null(self::$_arrivalCallback)) {
                            self::$_pendingCallbacks[] = "+$serial";
                        }
                    } elseif ($currdev->getLogicalName() != $devinfo['logicalName']) {
                        // Reindex device from its own data
                        $currdev->refresh();
                        if (!is_null(self::$_namechgCallback)) {
                            self::$_pendingCallbacks[] = "/$serial";
                        }
                    } elseif (isset($refresh[$serial]) || $currdev->getRootUrl() != $rooturl ||
                        $currdev->getBeacon() != $devinfo['beacon']) {
                        // Reindex device from its own data in case of discrepency
                        $currdev->refresh();
                    }
                    $hub->missing[$serial] = false;
                }

                // Keep track of all unplugged devices on this hub
                foreach ($hub->missing as $serial => $missing) {
                    if ($missing) {
                        if (!is_null(self::$_removalCallback)) {
                            self::$_pendingCallbacks[] = "-$serial";
                        } else {
                            self::forgetDevice(self::$_devs[$serial]);
                        }
                    }
                }

                // enable monitoring for this hub if not yet done
                self::monitorEvents($hub);
                if ($hub->isNotifWorking) {
                    $hub->devListExpires = $now + YAPI::$_yapiContext->_deviceListValidityMs;
                } else {
                    $hub->devListExpires = $now + 500;
                }
            }
            if ($alldone) {
                break;
            }
        }

        // after processing all hubs, invoke pending callbacks if required
        if ($bool_invokecallbacks) {
            $nbevents = sizeof(self::$_pendingCallbacks);
            for ($i = 0; $i < $nbevents; $i++) {
                $evt = self::$_pendingCallbacks[$i];
                $serial = substr($evt, 1);
                switch (substr($evt, 0, 1)) {
                    case '+':
                        if (!is_null(self::$_arrivalCallback)) {
                            $cb = self::$_arrivalCallback;
                            $cb(YModule::FindModule($serial . ".module"));
                        }
                        break;
                    case '/':
                        if (!is_null(self::$_namechgCallback)) {
                            $cb = self::$_namechgCallback;
                            $cb(YModule::FindModule($serial . ".module"));
                        }
                        break;
                    case '-':
                        if (!is_null(self::$_removalCallback)) {
                            $cb = self::$_removalCallback;
                            $cb(YModule::FindModule($serial . ".module"));
                        }
                        self::forgetDevice(self::$_devs[$serial]);
                        break;
                }
            }
            self::$_pendingCallbacks = array_slice(self::$_pendingCallbacks, $nbevents);
            if (!is_null(self::$_arrivalCallback) && self::$_firstArrival) {
                self::$_firstArrival = false;
            }
        }

        // report any error seen during scan
        foreach ($hubs as $hub) {
            if (!$hub->isEnable()) {
                continue;
            }
            $req = $hub->devListReq;
            if ($req->errorType != YAPI::SUCCESS) {
                return new YAPI_YReq("", $req->errorType,
                    'Error while scanning ' . $hub->getRooturl() . ': ' . $req->errorMsg,
                    $req->errorType);
            }
        }
        return new YAPI_YReq("", YAPI::SUCCESS, "no error", YAPI::SUCCESS);
    }

    /**
     * @throws YAPI_Exception
     */
    public static function _handleEvents_internal(int $int_maxwait): bool
    {
        $something_done = false;

        // start event monitoring if needed
        foreach (self::$_hubs as $hub) {
            if (!$hub->isEnable()) {
                continue;
            }
            $req = $hub->notifReq;
            if ($req) {
                if ($req->eof()) {
                    //Printf("Event channel at eof, reopen\n");
                    $something_done = true;
                    $hub->notifReq = $req = null;
                    self::monitorEvents($hub);
                }
            } elseif ($hub->retryExpires > 0 && $hub->retryExpires <= self::GetTickCount()) {
                Printf("RetryExpires, calling monitorEvents\n");
                $something_done = true;
                self::monitorEvents($hub);
            }
        }

        // Monitor all pending request for logs
        foreach (self::$_devs as $dev) {
            $dev->triggerLogPull();
        }


        // monitor all pending requests
        $streams = array();
        foreach (self::$_pendingRequests as $req) {
            /** @noinspection PhpConditionCheckedByNextConditionInspection */
            if (is_null($req->skt) || !is_resource($req->skt)) {
                $req->process();
            }
            /** @noinspection PhpConditionCheckedByNextConditionInspection */
            if (!is_null($req->skt) && is_resource($req->skt)) {
                $streams[] = $req->skt;
            }
        }

        if (sizeof($streams) == 0) {
            usleep($int_maxwait * 1000);
            return false;
        }
        $wr = null;
        $ex = null;
        /** @noinspection PhpUnusedLocalVariableInspection */
        if (false === ($select_res = stream_select($streams, $wr, $ex, 0, $int_maxwait * 1000))) {
            Printf("stream_select error\n");
            return false;
        }
        for ($idx = 0; $idx < sizeof(self::$_pendingRequests); $idx++) {
            $req = self::$_pendingRequests[$idx];
            $hub = $req->hub;
            // generic request processing
            $req->process();
            if ($req->eof()) {
                array_splice(self::$_pendingRequests, $idx, 1);
            }
            // handle notification channel
            if ($req === $hub->notifReq) {
                $linepos = strpos($req->reply, "\n");
                while ($linepos !== false) {
                    $ev = trim(substr($req->reply, 0, $linepos));
                    $req->reply = substr($req->reply, $linepos + 1);
                    $linepos = strpos($req->reply, "\n");
                    $firstCode = substr($ev, 0, 1);
                    if (strlen($ev) == 0) {
                        // empty line to send ping
                        continue;
                    }
                    if (strlen($ev) >= 3 && $firstCode >= NOTIFY_NETPKT_CONFCHGYDX && $firstCode <= NOTIFY_NETPKT_TIMEAVGYDX) {
                        // function value ydx (tiny notification)
                        $hub->isNotifWorking = true;
                        $hub->retryDelay = 15;
                        if ($hub->notifPos >= 0) {
                            $hub->notifPos += strlen($ev) + 1;
                        }
                        $devydx = ord($ev[1]) - 65; // from 'A'
                        $funydx = ord($ev[2]) - 48; // from '0'
                        if ($funydx >= 64) { // high bit of devydx is on second character
                            $funydx -= 64;
                            $devydx += 128;
                        }
                        if (isset($hub->serialByYdx[$devydx])) {
                            $serial = $hub->serialByYdx[$devydx];
                            if (isset(self::$_devs[$serial])) {
                                $funcid = ($funydx == 0xf ? 'time' : self::$_devs[$serial]->functionIdByFunYdx($funydx));
                                if ($funcid != "") {
                                    $value = substr($ev, 3);
                                    switch ($firstCode) {
                                        case NOTIFY_NETPKT_FUNCVALYDX:
                                            // function value ydx (tiny notification)
                                            $value = explode("\0", $value);
                                            $value = $value[0];
                                            YAPI::setFunctionValue($serial . '.' . $funcid, $value);
                                            break;
                                        case NOTIFY_NETPKT_DEVLOGYDX:
                                            // log notification
                                            $dev = self::$_devs[$serial];
                                            $dev->setDeviceLogPending();
                                            break;
                                        case NOTIFY_NETPKT_CONFCHGYDX:
                                            // configuration change notification
                                            YAPI::setConfChange($serial);
                                            break;
                                        case NOTIFY_NETPKT_TIMEVALYDX:
                                        case NOTIFY_NETPKT_TIMEAVGYDX:
                                        case NOTIFY_NETPKT_TIMEV2YDX:
                                            // timed value report
                                            $arr = array($firstCode == 'x' ? 0 : ($firstCode == 'z' ? 1 : 2));
                                            for ($pos = 0; $pos < strlen($value); $pos += 2) {
                                                $arr[] = hexdec(substr($value, $pos, 2));
                                            }
                                            $dev = self::$_devs[$serial];
                                            if ($funcid == 'time') {
                                                $time = $arr[1] + 0x100 * $arr[2] + 0x10000 * $arr[3] + 0x1000000 * $arr[4];
                                                $ms = $arr[5] * 4;
                                                if (sizeof($arr) >= 7) {
                                                    $ms += $arr[6] >> 6;
                                                    $duration_ms = $arr[7];
                                                    $duration_ms += ($arr[6] & 0xf) * 0x100;
                                                    if ($arr[6] & 0x10) {
                                                        $duration = $duration_ms;
                                                    } else {
                                                        $duration = $duration_ms / 1000.0;
                                                    }
                                                } else {
                                                    $duration = 0.0;
                                                }
                                                $dev->setTimeRef($time + $ms / 1000.0, $duration);
                                            } else {
                                                YAPI::setTimedReport($serial . '.' . $funcid, $dev->getLastTimeRef(), $dev->getLastDuration(), $arr);
                                            }
                                            break;
                                        case NOTIFY_NETPKT_FUNCV2YDX:
                                            $rawval = YAPI::decodeNetFuncValV2($value);
                                            if ($rawval != null) {
                                                $decodedval = YAPI::decodePubVal($rawval[0], $rawval, 1, 6);
                                                YAPI::setFunctionValue($serial . '.' . $funcid, $decodedval);
                                            }
                                            break;
                                        case NOTIFY_NETPKT_FLUSHV2YDX:
                                            // To be implemented later
                                        default:
                                            break;
                                    }
                                }
                            }
                        }
                    } elseif (strlen($ev) > 5 && substr($ev, 0, 4) == 'YN01') {
                        $hub->isNotifWorking = true;
                        $hub->retryDelay = 15;
                        if ($hub->notifPos >= 0) {
                            $hub->notifPos += strlen($ev) + 1;
                        }
                        $notype = substr($ev, 4, 1);
                        if ($notype == NOTIFY_NETPKT_NOT_SYNC) {
                            $hub->notifPos = intVal(substr($ev, 5));
                        } else {
                            switch (intVal($notype)) {
                                /** @noinspection PhpMissingBreakStatementInspection */
                                case 0: // device name change, or arrival
                                    $parts = explode(',', substr($ev, 5));
                                    YAPI::setBeaconChange($parts[0], intval($parts[2]));
                                // no break on purpose
                                case 2: // device plug/unplug
                                case 4: // function name change
                                case 8: // function name change (ydx)
                                    $hub->devListExpires = 0;
                                    break;
                                case 5: // function value (long notification)
                                    $parts = explode(',', substr($ev, 5));
                                    $value = explode("\0", $parts[2]);
                                    YAPI::setFunctionValue($parts[0] . '.' . $parts[1], $value[0]);
                                    break;
                            }
                        }
                    } else {
                        // oops, bad notification ? be safe until a good one comes
                        $hub->isNotifWorking = false;
                        $hub->devListExpires = 0;
                        $hub->notifPos = -1;
                    }
                }
            }
        }

        return $something_done;
    }

    public static function flushConnections(): void
    {
        foreach (self::$_pendingRequests as $req) {
            if ($req->async) {
                while (!$req->eof()) {
                    try {
                        self::_handleEvents_internal(200);
                    } catch (YAPI_Exception $ignore) {
                    }
                }
            }
        }
    }

    public static function monitorEvents(YTcpHub $hub): void
    {
        if (!is_null($hub->notifReq)) {
            return;
        }
        if ($hub->retryExpires > self::GetTickCount()) {
            return;
        }
        if ($hub->isCachedHub()) {
            return;
        }

        $url = $hub->notifurl . '?len=0';
        if ($hub->notifPos >= 0) {
            $url .= '&abs=' . $hub->notifPos;
        }
        $req = new YTcpReq($hub, 'GET /' . $url, false);
        $errmsg = '';
        if ($req->process($errmsg) != YAPI::SUCCESS) {
            if ($hub->retryDelay == 0) {
                $hub->retryDelay = 15;
            } elseif ($hub->retryDelay < 15000) {
                $hub->retryDelay = 2 * $hub->retryDelay;
            }
            $hub->retryExpires = self::GetTickCount() + $hub->retryDelay;
            return;
        }
        self::$_pendingRequests[] = $req;
        $hub->notifReq = $req;
    }

    // Convert Yoctopuce 16-bit decimal floats to standard double-precision floats
    //
    public static function _decimalToDouble(int $val): float
    {
        $negate = false;
        $mantis = $val & 2047;
        if ($mantis == 0) {
            return 0.0;
        }
        if ($val > 32767) {
            $negate = true;
            $val = 65536 - $val;
        } elseif ($val < 0) {
            $negate = true;
            $val = -$val;
        }
        $decexp = self::$_decExp[$val >> 11];
        if ($decexp >= 1.0) {
            $res = ($mantis) * $decexp;
        } else {
            $res = ($mantis) / round(1.0 / $decexp);
        }

        return ($negate ? -$res : $res);
    }

    // Convert standard double-precision floats to Yoctopuce 16-bit decimal floats
    //
    public static function _doubleToDecimal(float $val): float
    {
        $negate = false;

        if ($val == 0.0) {
            return 0;
        }
        if ($val < 0) {
            $negate = true;
            $val = -$val;
        }
        $comp = $val / 1999.0;
        $decpow = 0;
        while ($comp > self::$_decExp[$decpow] && $decpow < 15) {
            $decpow++;
        }
        $mant = $val / self::$_decExp[$decpow];
        if ($decpow == 15 && $mant > 2047.0) {
            $res = (15 << 11) + 2047; // overflow
        } else {
            $res = ($decpow << 11) + round($mant);
        }
        return ($negate ? -$res : $res);
    }

    // Return the calibration handler for a given type
    public static function _getCalibrationHandler(int $calibType): ?callable
    {
        if (!isset(self::$_calibHandlers[strVal($calibType)])) {
            return null;
        }
        return self::$_calibHandlers[strVal($calibType)];
    }

    // Parse an array of u16 encoded in a base64-like string with memory-based compresssion
    public static function _decodeWords(string $data): array
    {
        $datalen = strlen($data);
        $udata = array();
        for ($i = 0; $i < $datalen;) {
            $c = $data[$i];
            if ($c == '*') {
                $val = 0;
                $i++;
            } elseif ($c == 'X') {
                $val = 0xffff;
                $i++;
            } elseif ($c == 'Y') {
                $val = 0x7fff;
                $i++;
            } elseif ($c >= 'a') {
                $srcpos = sizeof($udata) - 1 - (ord($data[$i++]) - 97);
                if ($srcpos < 0) {
                    $val = 0;
                } else {
                    $val = $udata[$srcpos];
                }
            } else {
                if ($i + 2 > $datalen) {
                    return [];
                }
                $val = ord($data[$i++]) - 48;
                $val += (ord($data[$i++]) - 48) << 5;
                if ($data[$i] == 'z') {
                    $data[$i] = '\\';
                }
                $val += (ord($data[$i++]) - 48) << 10;
            }
            $udata[] = $val;
        }
        return $udata;
    }

    // Parse an array of u16 encoded in a base64-like string with memory-based compresssion
    public static function _decodeFloats(string $data): array
    {
        $datalen = strlen($data);
        $idata = array();
        $p = 0;
        while ($p < $datalen) {
            $val = 0;
            $sign = 1;
            $dec = 0;
            $decInc = 0;
            $c = $data[$p++];
            while ($c != '-' && ($c < '0' || $c > '9')) {
                if ($p >= $datalen) {
                    return $idata;
                }
                $c = $data[$p++];
            }
            if ($c == '-') {
                if ($p >= $datalen) {
                    return $idata;
                }
                $sign = -$sign;
                $c = $data[$p++];
            }
            while (($c >= '0' && $c <= '9') || $c == '.') {
                if ($c == '.') {
                    $decInc = 1;
                } elseif ($dec < 3) {
                    $val = $val * 10 + (ord($c) - 48);
                    $dec += $decInc;
                }
                if ($p < $datalen) {
                    $c = $data[$p++];
                } else {
                    $c = '\0';
                }
            }
            if ($dec < 3) {
                if ($dec == 0) {
                    $val *= 1000;
                } elseif ($dec == 1) {
                    $val *= 100;
                } else {
                    $val *= 10;
                }
            }
            $idata[] = $sign * $val;
        }
        return $idata;
    }

    public static function _bytesToHexStr(string $data): string
    {
        return strtoupper(bin2hex($data));
    }

    public static function _hexStrToBin(string $data): string
    {
        $pos = 0;
        $result = '';
        while ($pos < strlen($data)) {
            $code = hexdec(substr($data, $pos, 2));
            $pos = $pos + 2;
            $result .= chr($code);
        }
        return $result;
    }


    /**
     * Return a Device object for a specified URL, serial number or logical device name
     * This function will not cause any network access
     * @param string $str_device a specified URL, serial number or logical device name
     * @return ?YDevice
     */
    public static function getDevice(string $str_device): ?YDevice
    {
        $dev = null;

        if (substr($str_device, 0, 7) == 'http://' || substr($str_device, 0, 8) == 'https://') {
            if (isset(self::$_snByUrl[$str_device])) {
                $serial = self::$_snByUrl[$str_device];
                if (isset(self::$_devs[$serial])) {
                    $dev = self::$_devs[$serial];
                }
            }
        } else {
            // lookup by serial
            if (isset(self::$_devs[$str_device])) {
                $dev = self::$_devs[$str_device];
            } else {
                // fallback to lookup by logical name
                if (isset(self::$_snByName[$str_device])) {
                    $serial = self::$_snByName[$str_device];
                    $dev = self::$_devs[$serial];
                }
            }
        }
        return $dev;
    }

    // Return the class name for a given function ID or full Hardware Id
    // Also make sure that the function type is registered in the API
    public static function functionClass(string $str_funcid): string
    {
        $dotpos = strpos($str_funcid, '.');
        if ($dotpos !== false) {
            $str_funcid = substr($str_funcid, $dotpos + 1);
        }
        $classlen = strlen($str_funcid);
        while (ord($str_funcid[$classlen - 1]) <= 57) {
            $classlen--;
        }
        $classname = strtoupper($str_funcid[0]) . substr($str_funcid, 1, $classlen - 1);
        if (!isset(self::$_fnByType[$classname])) {
            self::$_fnByType[$classname] = new YFunctionType($classname);
        }

        return $classname;
    }

    // Reindex a device in YAPI after a name change detected by device refresh

    /**
     * @throws YAPI_Exception
     */
    public static function reindexDevice(YDevice $obj_dev): void
    {
        $rootUrl = $obj_dev->getRootUrl();
        $serial = $obj_dev->getSerialNumber();
        $lname = $obj_dev->getLogicalName();
        self::$_devs[$serial] = $obj_dev;
        self::$_snByUrl[$rootUrl] = $serial;
        if ($lname != '') {
            self::$_snByName[$lname] = $serial;
        }
        self::$_fnByType['Module']->reindexFunction("$serial.module", $lname, null, null);
        $count = $obj_dev->functionCount();
        for ($i = 0; $i < $count; $i++) {
            $funcid = $obj_dev->functionId($i);
            $funcname = $obj_dev->functionName($i);
            $classname = self::functionClass($funcid);
            self::$_fnByType[$classname]->reindexFunction("$serial.$funcid", $funcname, null, null);
        }
    }

    // Remove a device from YAPI after an unplug detected by device refresh

    /**
     * @throws YAPI_Exception
     */
    public static function forgetDevice(YDevice $obj_dev): void
    {
        $rootUrl = $obj_dev->getRootUrl();
        $serial = $obj_dev->getSerialNumber();
        $lname = $obj_dev->getLogicalName();
        unset(self::$_devs[$serial]);
        unset(self::$_snByUrl[$rootUrl]);
        if (isset(self::$_snByName[$lname]) && self::$_snByName[$lname] == $serial) {
            unset(self::$_snByName[$lname]);
        }
        self::$_fnByType['Module']->forgetFunction("$serial.module");
        $count = $obj_dev->functionCount();
        for ($i = 0; $i < $count; $i++) {
            $funcid = $obj_dev->functionId($i);
            $classname = self::functionClass($funcid);
            self::$_fnByType[$classname]->forgetFunction("$serial.$funcid");
        }
    }

    /**
     * Find the best known identifier (hardware Id) for a given function
     * @param string $str_className
     * @param string $str_func
     * @return YAPI_YReq
     */
    public static function resolveFunction(string $str_className, string $str_func): YAPI_YReq
    {
        if (!isset(self::$BASETYPES[$str_className])) {
            // using a regular function type
            if (!isset(self::$_fnByType[$str_className])) {
                self::$_fnByType[$str_className] = new YFunctionType($str_className);
            }
            return self::$_fnByType[$str_className]->resolve($str_func);
        }
        // using an abstract baseType
        $baseType = self::$BASETYPES[$str_className];
        /** @noinspection PhpForeachVariableOverwritesAlreadyDefinedVariableInspection */
        foreach (self::$_fnByType as $str_className => $funtype) {
            if ($funtype->matchBaseType($baseType)) {
                $res = $funtype->resolve($str_func);
                if ($res->errorType == YAPI::SUCCESS) {
                    return $res;
                }
            }
        }
        return new YAPI_YReq($str_func,
            YAPI::DEVICE_NOT_FOUND,
            "No $str_className [$str_func] found (old firmware?)",
            null);
    }

    // return a firendly name for of a given function

    public static function getFriendlyNameFunction(string $str_className, string $str_func): YAPI_YReq
    {
        if (!isset(self::$BASETYPES[$str_className])) {
            // using a regular function type
            if (!isset(self::$_fnByType[$str_className])) {
                self::$_fnByType[$str_className] = new YFunctionType($str_className);
            }
            return self::$_fnByType[$str_className]->getFriendlyName($str_func);
        }
        // using an abstract baseType
        $baseType = self::$BASETYPES[$str_className];
        /** @noinspection PhpForeachVariableOverwritesAlreadyDefinedVariableInspection */
        foreach (self::$_fnByType as $str_className => $funtype) {
            if ($funtype->matchBaseType($baseType)) {
                $res = $funtype->getFriendlyName($str_func);
                if ($res->errorType == YAPI::SUCCESS) {
                    return $res;
                }
            }
        }
        return new YAPI_YReq($str_func,
            YAPI::DEVICE_NOT_FOUND,
            "No $str_className [$str_func] found (old firmware?)",
            null);
    }

    /**
     * Retrieve a function object by hardware id, updating the indexes on the fly if needed
     * @throws YAPI_Exception
     */
    public static function setFunction(string $str_className, string $str_func, YFunction $obj_func): void
    {
        if (!isset(self::$_fnByType[$str_className])) {
            self::$_fnByType[$str_className] = new YFunctionType($str_className);
        }
        self::$_fnByType[$str_className]->setFunction($str_func, $obj_func);
    }

    /**
     * Retrieve a function object by hardware id, updating the indexes on the fly if needed
     * @throws YAPI_Exception
     */
    public static function getFunction(string $str_className, string $str_func): ?YFunction
    {
        if (is_null(self::$_hubs)) {
            self::_init();
        }

        if (!isset(self::$_fnByType[$str_className])) {
            self::$_fnByType[$str_className] = new YFunctionType($str_className);
        }
        return self::$_fnByType[$str_className]->getFunction($str_func);
    }

    /**
     * Set a function advertised value by hardware id
     * @throws YAPI_Exception
     */
    public static function setFunctionValue(string $str_hwid, string $str_pubval): void
    {
        $classname = self::functionClass($str_hwid);
        self::$_fnByType[$classname]->setFunctionValue($str_hwid, $str_pubval);
    }

    /**
     * Set add a timed value report for a function
     * @throws YAPI_Exception
     */
    public static function setTimedReport(string $str_hwid, float $float_timestamp, float $float_duration, array $arr_report): void
    {
        $classname = self::functionClass($str_hwid);
        self::$_fnByType[$classname]->setTimedReport($str_hwid, $float_timestamp, $float_duration, $arr_report);
    }

    /**
     * Publish a configuration change event
     */
    public static function setConfChange(string $str_serial): void
    {
        $module = YModule::FindModule($str_serial . ".module");
        $module->_invokeConfigChangeCallback();
    }

    // Publish a configuration change event
    public static function setBeaconChange(string $str_serial, int $int_beacon): void
    {
        if (!array_key_exists($str_serial, self::$_beacons) || self::$_beacons[$str_serial] != $int_beacon) {
            self::$_beacons[$str_serial] = $int_beacon;
            $module = YModule::FindModule($str_serial . ".module");
            $module->_invokeBeaconCallback($int_beacon);
        }
    }

    /**
     * Retrieve a function advertised value by hardware id
     */
    public static function getFunctionValue(string $str_hwid): string
    {
        $classname = self::functionClass($str_hwid);
        return self::$_fnByType[$classname]->getFunctionValue($str_hwid);
    }

    /**
     * Retrieve a function base type
     */
    public static function getFunctionBaseType(string $str_hwid): int
    {
        $classname = self::functionClass($str_hwid);
        return self::$_fnByType[$classname]->getBaseType();
    }

    // Queue a function value event
    public static function addValueEvent(YFunction $obj_func, string $str_newval): void
    {
        self::$_data_events[] = array($obj_func, $str_newval);
    }


    // Queue a function value event
    public static function addRefreshEvent(YFunction $obj_func): void
    {
        self::$_data_events[] = array($obj_func);
    }

    // Queue a function value event
    public static function addTimedReportEvent(YFunction $obj_func, float $float_timestamp, float $float_duration, array $arr_report): void
    {
        self::$_data_events[] = array($obj_func, $float_timestamp, $float_duration, $arr_report);
    }

    /**
     * Find the hardwareId for the first instance of a given function class
     */
    public static function getFirstHardwareId(string $str_className): ?string
    {
        if (is_null(self::$_hubs)) {
            self::_init();
        }

        if (!isset(self::$BASETYPES[$str_className])) {
            // enumeration of a regular function type
            if (!isset(self::$_fnByType[$str_className])) {
                self::$_fnByType[$str_className] = new YFunctionType($str_className);
            }
            return self::$_fnByType[$str_className]->getFirstHardwareId();
        }
        // enumeration of an abstract class
        $baseType = self::$BASETYPES[$str_className];
        foreach (self::$_fnByType as $funtype) {
            if ($funtype->matchBaseType($baseType)) {
                $res = $funtype->getFirstHardwareId();
                if (!is_null($res)) {
                    return $res;
                }
            }
        }
        return null;
    }

    /**
     * Find the hardwareId for the next instance of a given function class
     */
    public static function getNextHardwareId(string $str_className, string $str_hwid): ?string
    {
        if (!isset(self::$BASETYPES[$str_className])) {
            // enumeration of a regular function type
            return self::$_fnByType[$str_className]->getNextHardwareId($str_hwid);
        }

        // enumeration of an abstract class
        $baseType = self::$BASETYPES[$str_className];
        $prevclass = self::functionClass($str_hwid);
        $res = self::$_fnByType[$prevclass]->getNextHardwareId($str_hwid);
        if (!is_null($res)) {
            return $res;
        }
        foreach (self::$_fnByType as $str_className => $funtype) {
            if ($prevclass != "") {
                if ($str_className != $prevclass) {
                    continue;
                }
                $prevclass = "";
                continue;
            }
            if ($funtype->matchBaseType($baseType)) {
                $res = $funtype->getFirstHardwareId();
                if (!is_null($res)) {
                    return $res;
                }
            }
        }
        /** @noinspection PhpExpressionAlwaysNullInspection */
        return $res;
    }

    /**
     * Perform an HTTP request on a device, by URL or identifier.
     * When loading the REST API from a device by identifier, the device cache will be used
     * @param string $str_device
     * @param string $str_request
     * @param bool $async
     * @param string $body
     * @return YAPI_YReq a strucure including errorType, errorMsg and result
     * @throws YAPI_Exception
     */
    public static function devRequest(string $str_device, string $str_request, bool $async = false, string $body = ''): YAPI_YReq
    {
        $lines = explode("\n", $str_request);
        $dev = null;
        $baseUrl = $str_device;
        if (substr($str_device, 0, 7) == 'http://' || substr($str_device, 0, 8) == 'https://') {
            if (substr($baseUrl, -1) != '/') {
                $baseUrl .= '/';
            }
            if (isset(self::$_snByUrl[$baseUrl])) {
                $serial = self::$_snByUrl[$baseUrl];
                if (isset(self::$_devs[$serial])) {
                    $dev = self::$_devs[$serial];
                }
            }
        } else {
            $dev = self::getDevice($str_device);
            if (!$dev) {
                return new YAPI_YReq("", YAPI::DEVICE_NOT_FOUND,
                    "Device [$str_device] not online",
                    null);
            }
            // use the device cache when loading the whole API
            if ($lines[0] == 'GET /api.json') {
                return $dev->requestAPI();
            }
            $baseUrl = $dev->getRootUrl();
        }
        // map str_device to a URL
        $words = explode(' ', $lines[0]);
        if (sizeof($words) < 2) {
            return new YAPI_YReq("", YAPI::INVALID_ARGUMENT,
                'Invalid request, not enough words; expected a method name and a URL',
                null);
        } elseif (sizeof($words) > 2) {
            return new YAPI_YReq("", YAPI::INVALID_ARGUMENT,
                'Invalid request, too many words; make sure the URL is URI-encoded',
                null);
        }
        $method = $words[0];
        $devUrl = $words[1];
        $pos = strpos($baseUrl, '/bySerial');
        if ($pos !== false) {
            // $baseURL end with a / and $devUrl start with / -> remove first char or $devUrl
            $devUrl = substr($baseUrl, $pos) . substr($devUrl, 1);
            $rooturl = substr($baseUrl, 0, $pos);
        } else {
            $devUrl = "$devUrl";
            if (substr($baseUrl, -1) == '/') {
                $rooturl = substr($baseUrl, 0, -1);
            } else {
                $rooturl = $baseUrl;
            }
        }
        if (!isset(self::$_hubs[$rooturl])) {
            return new YAPI_YReq("", YAPI::DEVICE_NOT_FOUND, 'No hub registered on ' . $rooturl, null);
        }
        $hub = self::$_hubs[$rooturl];
        if ($async && $hub->writeProtected && $hub->user != 'admin' && !$hub->isCachedHub()) {
            // async query, make sure the hub is not write-protected
            return new YAPI_YReq("", YAPI::UNAUTHORIZED,
                'Access denied: admin credentials required',
                null);
        }
        if (strpos($devUrl, '@YCB+') && !$hub->isCachedHub()) {
            return new YAPI_YReq("", YAPI::INVALID_ARGUMENT,
                'Preloading of URL is only supported for HTTP callback.',
                null);
        }
        $tcpreq = new YTcpReq($hub, "$method $devUrl", $async, $body);
        if (!is_null($dev)) {
            $dev->prepRequest($tcpreq);
        }
        if ($tcpreq->process() != YAPI::SUCCESS) {
            return new YAPI_YReq("", $tcpreq->errorType, $tcpreq->errorMsg, null);
        }
        self::$_pendingRequests[] = $tcpreq;
        if (!$async) {
            // normal query, wait for completion until timeout
            $mstimeout = YIO_DEFAULT_TCP_TIMEOUT;
            if (strpos($devUrl, '/testcb.txt') !== false) {
                $mstimeout = YIO_1_MINUTE_TCP_TIMEOUT;
            } elseif (strpos($devUrl, '/logger.json') !== false) {
                $mstimeout = YIO_1_MINUTE_TCP_TIMEOUT;
            } elseif (strpos($devUrl, '/rxmsg.json') !== false) {
                $mstimeout = YIO_1_MINUTE_TCP_TIMEOUT;
            } elseif (strpos($devUrl, '/rxdata.bin') !== false) {
                $mstimeout = YIO_1_MINUTE_TCP_TIMEOUT;
            } elseif (strpos($devUrl, '/at.txt') !== false) {
                $mstimeout = YIO_1_MINUTE_TCP_TIMEOUT;
            } elseif (strpos($devUrl, '/files.json') !== false) {
                $mstimeout = YIO_1_MINUTE_TCP_TIMEOUT;
            } elseif (strpos($devUrl, '/upload.html') !== false) {
                $mstimeout = YIO_10_MINUTES_TCP_TIMEOUT;
            } elseif (strpos($devUrl, '/flash.json') !== false) {
                $mstimeout = YIO_10_MINUTES_TCP_TIMEOUT;
            }
            if ($mstimeout < $hub->get_networkTimeout()) {
                $mstimeout = $hub->get_networkTimeout();
            }
            $timeout = YAPI::GetTickCount() + $mstimeout;
            do {
                self::_handleEvents_internal(100);
            } while (!$tcpreq->eof() && YAPI::GetTickCount() < $timeout);
            if (!$tcpreq->eof()) {
                $tcpreq->close();
                return new YAPI_YReq("", YAPI::TIMEOUT,
                    'Timeout waiting for device reply',
                    null);
            }
            if ($tcpreq->errorType == YAPI::UNAUTHORIZED) {
                return new YAPI_YReq("", YAPI::UNAUTHORIZED,
                    'Access denied, authorization required',
                    null);
            } elseif ($tcpreq->errorType != YAPI::SUCCESS) {
                return new YAPI_YReq("", $tcpreq->errorType,
                    'Network error while reading from device',
                    null);
            }
            if (strpos($tcpreq->meta, "OK\r\n") === 0) {
                return new YAPI_YReq("", YAPI::SUCCESS,
                    'no error',
                    $tcpreq->reply);
            }
            if (strpos($tcpreq->meta, "0K\r\n") === 0) {
                return new YAPI_YReq("", YAPI::SUCCESS,
                    'no error',
                    $tcpreq->reply);
            }
            $matches = null;
            $preg_match = preg_match('/^HTTP[^ ]* (?P<status>\d+) (?P<statusmsg>.)+\r\n/', $tcpreq->meta, $matches);
            if (!$preg_match) {
                return new YAPI_YReq("", YAPI::IO_ERROR,
                    'Unexpected HTTP response header: ' . $tcpreq->meta,
                    null);
            }
            if ($matches['status'] != '200' && $matches['status'] != '304') {
                return new YAPI_YReq("", YAPI::IO_ERROR,
                    'Received HTTP status ' . $matches['status'] . ' (' . $matches['statusmsg'] . ')',
                    null);
            }
        }

        return new YAPI_YReq("", YAPI::SUCCESS,
            'no error',
            $tcpreq->reply);
    }


    public static function isReadOnly(string $str_device): bool
    {
        $dev = self::getDevice($str_device);
        if (!$dev) {
            return true;
        }
        $rooturl = $dev->getRootUrl();
        $pos = strpos($rooturl, '/bySerial', 7);
        if ($pos >= 0) {
            $rooturl = substr($rooturl, 0, $pos + 1);
        }
        if (substr($rooturl, -1) == '/') {
            $rooturl = substr($rooturl, 0, -1);
        }

        if (!isset(self::$_hubs[$rooturl])) {
            return true;
        }

        $hub = self::$_hubs[$rooturl];
        if ($hub->writeProtected && $hub->user != 'admin' && !$hub->isCachedHub()) {
            // async query, make sure the hub is not write-protected
            return true;
        }
        return false;
    }


    /**
     * Retrun the serialnummber of all subdevcies
     * @param string $str_device
     * @return array of string
     * @throws YAPI_Exception
     */
    public static function getSubDevicesFrom(string $str_device): array
    {
        $dev = self::getDevice($str_device);
        if (!$dev) {
            return [];
        }
        $baseUrl = $dev->getRootUrl();
        $pos = strpos($baseUrl, '/bySerial');
        if ($pos !== false) {
            $baseUrl = substr($baseUrl, 0, $pos);
        }
        if (substr($baseUrl, -1) == '/') {
            $baseUrl = substr($baseUrl, 0, -1);
        }
        $rooturl = $baseUrl;
        if (!isset(self::$_hubs[$rooturl])) {
            throw new YAPI_Exception('No hub registered on ' . $baseUrl, YAPI::DEVICE_NOT_FOUND);
        }
        $hub = self::$_hubs[$rooturl];
        if ($hub->serialByYdx[0] == $str_device) {
            return array_slice($hub->serialByYdx, 1);
        }
        return array();
    }


    /**
     * Retrun the serialnumber of the hub
     * @param string $str_device
     * @return string the serial of the hub on which the device is plugged
     * @throws YAPI_Exception
     */
    public static function getHubSerialFrom(string $str_device): string
    {
        $dev = self::getDevice($str_device);
        if (!$dev) {
            return '';
        }
        $baseUrl = $dev->getRootUrl();
        $pos = strpos($baseUrl, '/bySerial');
        if ($pos !== false) {
            $baseUrl = substr($baseUrl, 0, $pos);
        }
        if (substr($baseUrl, -1) == '/') {
            $baseUrl = substr($baseUrl, 0, -1);
        }
        $rooturl = $baseUrl;
        if (!isset(self::$_hubs[$rooturl])) {
            throw new YAPI_Exception('No hub registered on ' . $baseUrl, YAPI::DEVICE_NOT_FOUND);
        }
        $hub = self::$_hubs[$rooturl];
        return $hub->serialByYdx[0];
    }

    public static function getHubURLFrom(string $str_device): string
    {
        $dev = self::getDevice($str_device);
        if (!$dev) {
            return '';
        }
        $baseUrl = $dev->getRootUrl();
        $devurl = "";
        $pos = strpos($baseUrl, '/bySerial');
        if ($pos !== false) {
            $devurl = substr($baseUrl, $pos + 1);
            $baseUrl = substr($baseUrl, 0, $pos);
        }
        if (substr($baseUrl, -1) == '/') {
            $baseUrl = substr($baseUrl, 0, -1);
        }
        if (!isset(self::$_hubs[$baseUrl])) {
            throw new YAPI_Exception('No hub registered on ' . $baseUrl, YAPI::DEVICE_NOT_FOUND);
        }
        $hub = self::$_hubs[$baseUrl];
        $url = $hub->getBaseURL() . $devurl;
        return $url;
    }


    /**
     * Load and parse the REST API for a function given by class name and identifier, possibly applying changes
     * Device cache will be preloaded when loading function "module" and leveraged for other modules
     * @param string $str_className
     * @param string $str_func
     * @param string $str_extra
     * @return YAPI_YReq
     * @throws YAPI_Exception
     */
    public static function funcRequest(string $str_className, string $str_func, string $str_extra): YAPI_YReq
    {
        $resolve = self::resolveFunction($str_className, $str_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            if ($resolve->errorType == YAPI::DEVICE_NOT_FOUND && sizeof(self::$_hubs) == 0) {
                // when USB is supported, check if no USB device is connected before outputing this message
                $resolve->errorMsg = "Impossible to contact any device because no hub has been registered";
            } else {
                $resolve = self::_updateDeviceList_internal(true, false);
                if ($resolve->errorType != YAPI::SUCCESS) {
                    return $resolve;
                }
                $resolve = self::resolveFunction($str_className, $str_func);
            }
            if ($resolve->errorType != YAPI::SUCCESS) {
                return $resolve;
            }
        }
        $str_func = $resolve->result;
        $dotpos = strpos($str_func, '.');
        $devid = substr($str_func, 0, $dotpos);
        $funcid = substr($str_func, $dotpos + 1);
        $dev = self::getDevice($devid);
        if (!$dev) {
            // try to force a device list update to check if the device arrived in between
            $resolve = self::_updateDeviceList_internal(true, false);
            if ($resolve->errorType != YAPI::SUCCESS) {
                return $resolve;
            }
            $dev = self::getDevice($devid);
            if (!$dev) {
                return new YAPI_YReq("{$devid}.{$funcid}", YAPI::DEVICE_NOT_FOUND,
                    "Device [$devid] not online",
                    null);
            }
        }
        $loadval = false;
        if ($str_extra == '') {
            // use a cached API string, without reloading unless module is requested
            $yreq = $dev->requestAPI();
            if (!is_null($yreq)) {
                $yreq->hwid = "{$devid}.{$funcid}";
                $yreq->deviceid = $devid;
                $yreq->functionid = $funcid;
                if ($yreq->errorType != YAPI::SUCCESS) {
                    return $yreq;
                }
                $loadval = json_decode(iconv("ISO-8859-1", "UTF-8", $yreq->result), true);
                $loadval = $loadval[$funcid];
            }
        } else {
            $dev->dropCache();
            $yreq = new YAPI_YReq("{$devid}.{$funcid}", YAPI::NOT_INITIALIZED, "dummy", null);
        }
        if (!$loadval) {
            // request specified function only to minimize traffic
            if ($str_extra == "") {
                $httpreq = "GET /api/{$funcid}.json";
                $yreq = self::devRequest($devid, $httpreq);
                $yreq->hwid = "{$devid}.{$funcid}";
                $yreq->deviceid = $devid;
                $yreq->functionid = $funcid;
                if ($yreq->errorType != YAPI::SUCCESS) {
                    return $yreq;
                }
                $loadval = json_decode(iconv("ISO-8859-1", "UTF-8", $yreq->result), true);
            } else {
                $httpreq = "GET /api/{$funcid}{$str_extra}";
                $yreq = self::devRequest($devid, $httpreq, true);
                $yreq->hwid = "{$devid}.{$funcid}";
                $yreq->deviceid = $devid;
                $yreq->functionid = $funcid;
                return $yreq;
            }
        }
        if (!$loadval) {
            return new YAPI_YReq("{$devid}.{$funcid}", YAPI::IO_ERROR,
                "Request failed, could not parse API value for function $str_func",
                null);
        }
        $yreq->result = $loadval;
        return $yreq;
    }

    /**
     * Perform an HTTP request on a device and return the result string
     * Throw an exception (or return YAPI_ERROR_STRING on error)
     * @throws YAPI_Exception
     */
    public static function HTTPRequest(string $str_device, string $str_request): string
    {
        $res = self::devRequest($str_device, $str_request);
        if ($res->errorType != YAPI::SUCCESS) {
            return self::_throw($res->errorType, $res->errorMsg, null);
        }
        return $res->result;
    }



//--- (generated code: YAPIContext yapiwrapper)

    /**
     * Modifies the delay between each forced enumeration of the used YoctoHubs.
     * By default, the library performs a full enumeration every 10 seconds.
     * To reduce network traffic, you can increase this delay.
     * It's particularly useful when a YoctoHub is connected to the GSM network
     * where traffic is billed. This parameter doesn't impact modules connected by USB,
     * nor the working of module arrival/removal callbacks.
     * Note: you must call this function after yInitAPI.
     *
     * @param int $deviceListValidity : nubmer of seconds between each enumeration.
     * @noreturn
     */
    public static function SetDeviceListValidity(int $deviceListValidity): void
    {
        if (is_null(self::$_hubs)) {
            self::_init();
        }
        self::$_yapiContext->SetDeviceListValidity($deviceListValidity);
    }
    /**
     * Returns the delay between each forced enumeration of the used YoctoHubs.
     * Note: you must call this function after yInitAPI.
     *
     * @return int  the number of seconds between each enumeration.
     */
    public static function GetDeviceListValidity(): int
    {
        if (is_null(self::$_hubs)) {
            self::_init();
        }
        return self::$_yapiContext->GetDeviceListValidity();
    }
    /**
     * Adds a UDEV rule which authorizes all users to access Yoctopuce modules
     * connected to the USB ports. This function works only under Linux. The process that
     * calls this method must have root privileges because this method changes the Linux configuration.
     *
     * @param boolean $force : if true, overwrites any existing rule.
     *
     * @return string  an empty string if the rule has been added.
     *
     * On failure, returns a string that starts with "error:".
     */
    public static function AddUdevRule(bool $force): string
    {
        if (is_null(self::$_hubs)) {
            self::_init();
        }
        return self::$_yapiContext->AddUdevRule($force);
    }
    /**
     * Download the TLS/SSL certificate from the hub. This function allows to download a TLS/SSL certificate to add it
     * to the list of trusted certificates using the AddTrustedCertificates method.
     *
     * @param string $url : the root URL of the VirtualHub V2 or HTTP server.
     * @param float $mstimeout : the number of milliseconds available to download the certificate.
     *
     * @return string  a string containing the certificate. In case of error, returns a string starting with "error:".
     */
    public static function DownloadHostCertificate(string $url, float $mstimeout): string
    {
        if (is_null(self::$_hubs)) {
            self::_init();
        }
        return self::$_yapiContext->DownloadHostCertificate($url, $mstimeout);
    }
    /**
     * Adds a TLS/SSL certificate to the list of trusted certificates. By default, the library
     * library will reject TLS/SSL connections to servers whose certificate is not known. This function
     * function allows to add a list of known certificates. It is also possible to disable the verification
     * using the SetNetworkSecurityOptions method.
     *
     * @param string $certificate : a string containing one or more certificates.
     *
     * @return string  an empty string if the certificate has been added correctly.
     *         In case of error, returns a string starting with "error:".
     */
    public static function AddTrustedCertificates(string $certificate): string
    {
        if (is_null(self::$_hubs)) {
            self::_init();
        }
        return self::$_yapiContext->AddTrustedCertificates($certificate);
    }
    /**
     * Set the path of Certificate Authority file on local filesystem. This method takes as a parameter
     * the path of a file containing all certificates in PEM format.
     * For technical reasons, only one file can be specified. So if you need to connect to several Hubs
     * instances with self-signed certificates, you'll need to use
     * a single file containing all the certificates end-to-end. Passing a empty string will restore the
     * default settings. This option is only supported by PHP library.
     *
     * @param string $certificatePath : the path of the file containing all certificates in PEM format.
     *
     * @return string  an empty string if the certificate has been added correctly.
     *         In case of error, returns a string starting with "error:".
     */
    public static function SetTrustedCertificatesList(string $certificatePath): string
    {
        if (is_null(self::$_hubs)) {
            self::_init();
        }
        return self::$_yapiContext->SetTrustedCertificatesList($certificatePath);
    }
    /**
     * Enables or disables certain TLS/SSL certificate checks.
     *
     * @param int $opts : The options are YAPI::NO_TRUSTED_CA_CHECK,
     *         YAPI::NO_EXPIRATION_CHECK, YAPI::NO_HOSTNAME_CHECK.
     *
     * @return string  an empty string if the options are taken into account.
     *         On error, returns a string beginning with "error:".
     */
    public static function SetNetworkSecurityOptions(int $opts): string
    {
        if (is_null(self::$_hubs)) {
            self::_init();
        }
        return self::$_yapiContext->SetNetworkSecurityOptions($opts);
    }
    /**
     * Modifies the network connection delay for yRegisterHub() and yUpdateDeviceList().
     * This delay impacts only the YoctoHubs and VirtualHub
     * which are accessible through the network. By default, this delay is of 20000 milliseconds,
     * but depending or you network you may want to change this delay,
     * gor example if your network infrastructure is based on a GSM connection.
     *
     * @param int $networkMsTimeout : the network connection delay in milliseconds.
     * @noreturn
     */
    public static function SetNetworkTimeout(int $networkMsTimeout): void
    {
        if (is_null(self::$_hubs)) {
            self::_init();
        }
        self::$_yapiContext->SetNetworkTimeout($networkMsTimeout);
    }
    /**
     * Returns the network connection delay for yRegisterHub() and yUpdateDeviceList().
     * This delay impacts only the YoctoHubs and VirtualHub
     * which are accessible through the network. By default, this delay is of 20000 milliseconds,
     * but depending or you network you may want to change this delay,
     * for example if your network infrastructure is based on a GSM connection.
     *
     * @return int  the network connection delay in milliseconds.
     */
    public static function GetNetworkTimeout(): int
    {
        if (is_null(self::$_hubs)) {
            self::_init();
        }
        return self::$_yapiContext->GetNetworkTimeout();
    }
    /**
     * Change the validity period of the data loaded by the library.
     * By default, when accessing a module, all the attributes of the
     * module functions are automatically kept in cache for the standard
     * duration (5 ms). This method can be used to change this standard duration,
     * for example in order to reduce network or USB traffic. This parameter
     * does not affect value change callbacks
     * Note: This function must be called after yInitAPI.
     *
     * @param float $cacheValidityMs : an integer corresponding to the validity attributed to the
     *         loaded function parameters, in milliseconds.
     * @noreturn
     */
    public static function SetCacheValidity(float $cacheValidityMs): void
    {
        if (is_null(self::$_hubs)) {
            self::_init();
        }
        self::$_yapiContext->SetCacheValidity($cacheValidityMs);
    }
    /**
     * Returns the validity period of the data loaded by the library.
     * This method returns the cache validity of all attributes
     * module functions.
     * Note: This function must be called after yInitAPI .
     *
     * @return float  an integer corresponding to the validity attributed to the
     *         loaded function parameters, in milliseconds
     */
    public static function GetCacheValidity(): float
    {
        if (is_null(self::$_hubs)) {
            self::_init();
        }
        return self::$_yapiContext->GetCacheValidity();
    }
    /**
     * @throws YAPI_Exception on error
     */
    public static function nextHubInUseInternal(int $hubref): ?YHub
    {
        if (is_null(self::$_hubs)) {
            self::_init();
        }
        return self::$_yapiContext->nextHubInUseInternal($hubref);
    }
    /**
     * @throws YAPI_Exception on error
     */
    public static function getYHubObj(int $hubref): ?YHub
    {
        if (is_null(self::$_hubs)) {
            self::_init();
        }
        return self::$_yapiContext->getYHubObj($hubref);
    }
   #--- (end of generated code: YAPIContext yapiwrapper)


    /**
     * Returns the version identifier for the Yoctopuce library in use.
     * The version is a string in the form "Major.Minor.Build",
     * for instance "1.01.5535". For languages using an external
     * DLL (for instance C#, VisualBasic or Delphi), the character string
     * includes as well the DLL version, for instance
     * "1.01.5535 (1.01.5439)".
     *
     * If you want to verify in your code that the library version is
     * compatible with the version that you have used during development,
     * verify that the major number is strictly equal and that the minor
     * number is greater or equal. The build number is not relevant
     * with respect to the library compatibility.
     *
     * @return string  a character string describing the library version.
     */
    public static function GetAPIVersion(): string
    {
        return "2.0.61148";
    }

    /**
     * Enables the HTTP callback cache. When enabled, this cache reduces the quantity of data sent to the
     * PHP script by 50% to 70%. To enable this cache, the method ySetHTTPCallbackCacheDir()
     * must be called before any call to yRegisterHub(). This method takes in parameter the path
     * of the directory used for saving data between each callback. This folder must exist and the
     * PHP script needs to have write access to it. It is recommended to use a folder that is not published
     * on the Web server since the library will save some data of Yoctopuce devices into this folder.
     *
     * Note: This feature is supported by YoctoHub and VirtualHub since version 27750.
     *
     * @param string $directory : the path of the folder that will be used as cache.
     *
     * On failure, throws an exception.
     * @throws YAPI_Exception on error
     */
    public static function SetHTTPCallbackCacheDir(string $directory): void
    {
        if (is_null(self::$_hubs)) {
            self::_init();
        }
        if (!is_dir($directory)) {
            throw new YAPI_Exception("Directory does not exist");
        }
        if (!is_dir($directory)) {
            throw new YAPI_Exception("Directory does not exist");
        }
        if (!is_writable($directory)) {
            throw new YAPI_Exception("Directory is not writable");
        }

        if (substr($directory, -1) != '/') {
            $directory .= '/';
        }
        self::$_jzonCacheDir = $directory;
    }

    /**
     * Disables the HTTP callback cache. This method disables the HTTP callback cache, and
     * can additionally cleanup the cache directory.
     *
     * @param boolean $removeFiles : True to clear the content of the cache.
     *         On failure, throws an exception.
     * @throws YAPI_Exception on error
     */
    public static function ClearHTTPCallbackCacheDir(bool $removeFiles): void
    {
        if (is_null(self::$_hubs) or is_null(self::$_jzonCacheDir)) {
            return;
        }

        if ($removeFiles && is_dir(self::$_jzonCacheDir)) {
            $files = glob(self::$_jzonCacheDir . "{,.}*.json", GLOB_BRACE); // get all file names
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
        }
        self::$_jzonCacheDir = null;
    }

    /**
     * Initializes the Yoctopuce programming library explicitly.
     * It is not strictly needed to call yInitAPI(), as the library is
     * automatically  initialized when calling yRegisterHub() for the
     * first time.
     *
     * When YAPI::DETECT_NONE is used as detection mode,
     * you must explicitly use yRegisterHub() to point the API to the
     * VirtualHub on which your devices are connected before trying to access them.
     *
     * @param int $mode : an integer corresponding to the type of automatic
     *         device detection to use. Possible values are
     *         YAPI::DETECT_NONE, YAPI::DETECT_USB, YAPI::DETECT_NET,
     *         and YAPI::DETECT_ALL.
     * @param string $errmsg : a string passed by reference to receive any error message.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure returns a negative error code.
     */
    public static function InitAPI(int $mode = YAPI::DETECT_NONE, string &$errmsg = ''): int
    {
        if (is_null(self::$_hubs)) {
            self::_init();
        }
        $errmsg = '';

        return YAPI::SUCCESS;
    }

    /**
     * Waits for all pending communications with Yoctopuce devices to be
     * completed then frees dynamically allocated resources used by
     * the Yoctopuce library.
     *
     * From an operating system standpoint, it is generally not required to call
     * this function since the OS will automatically free allocated resources
     * once your program is completed. However there are two situations when
     * you may really want to use that function:
     *
     * - Free all dynamically allocated memory blocks in order to
     * track a memory leak.
     *
     * - Send commands to devices right before the end
     * of the program. Since commands are sent in an asynchronous way
     * the program could exit before all commands are effectively sent.
     *
     * You should not call any other library function after calling
     * yFreeAPI(), or your program will crash.
     */
    public static function FreeAPI(): void
    {
        // leave max 10 second to finish pending requests
        $timeout = YAPI::GetTickCount() + 10000;
        foreach (self::$_pendingRequests as $tcpreq) {
            $request = trim($tcpreq->request);
            if (substr($request, 0, 12) == 'GET /not.byn') {
                continue;
            }
            while (!$tcpreq->eof() && YAPI::GetTickCount() < $timeout) {
                try {
                    self::_handleEvents_internal(100);
                } catch (YAPI_Exception $ignore) {
                }
            }
        }
        // clear all caches
        self::_init();
    }

    /**
     * Disables the use of exceptions to report runtime errors.
     * When exceptions are disabled, every function returns a specific
     * error value which depends on its type and which is documented in
     * this reference manual.
     */
    public static function DisableExceptions(): void
    {
        if (is_null(self::$_hubs)) {
            self::_init();
        }

        self::$exceptionsDisabled = true;
    }

    /**
     * Re-enables the use of exceptions for runtime error handling.
     * Be aware than when exceptions are enabled, every function that fails
     * triggers an exception. If the exception is not caught by the user code,
     * it either fires the debugger or aborts (i.e. crash) the program.
     */
    public static function EnableExceptions(): void
    {
        if (is_null(self::$_hubs)) {
            self::_init();
        }

        self::$exceptionsDisabled = false;
    }

    private static function _parseRegisteredURL(string $str_url): array
    {
        $res = [];
        $res['org_url'] = $str_url;
        $res['proto'] = 'auto';
        $res['port'] = 4444;
        $rh_proto = 'http';


        if (substr($str_url, 0, 7) == 'auto://') {
            $str_url = substr($str_url, 7);
        } elseif (substr($str_url, 0, 7) == 'http://') {
            $str_url = substr($str_url, 7);
            $res['proto'] = "http";
        } elseif (substr($str_url, 0, 8) == 'https://') {
            $str_url = substr($str_url, 8);
            $res['port'] = 4443;
            $res['proto'] = "https";
            $rh_proto = 'https';
        } elseif (substr($str_url, 0, 5) == 'ws://') {
            $str_url = substr($str_url, 5);
            $res['proto'] = "ws";
            $rh_proto = 'ws';
        } elseif (substr($str_url, 0, 6) == 'wss://') {
            $str_url = substr($str_url, 6);
            $res['proto'] = "wss";
            $rh_proto = 'wss';
        } elseif (substr($str_url, 0, 9) == 'secure://') {
            $str_url = substr($str_url, 9);
            $res['proto'] = "secure";
            $rh_proto = 'https';
            $res['port'] = 4443;

        }
        $subdompos = strpos($str_url, '/');
        if ($subdompos === false) {
            $res['subdomain'] = '';
        } else {
            $res['subdomain'] = substr($str_url, $subdompos);
            while (substr($res['subdomain'], -1) == '/') {
                $res['subdomain'] = substr($res['subdomain'], 0, -1);
            }
            $str_url = substr($str_url, 0, $subdompos);
        }
        $authpos = strpos($str_url, '@');
        if ($authpos === false) {
            $res['auth'] = '';
        } else {
            $res['auth'] = substr($str_url, 0, $authpos);
            $str_url = substr($str_url, $authpos + 1);
        }
        $p_ofs = strpos($str_url, ':');
        if ($p_ofs !== false) {
            $res['host'] = substr($str_url, 0, $p_ofs);
            $res['port'] = (int)substr($str_url, $p_ofs + 1);
        } else {
            $res['host'] = $str_url;
            if ($res['subdomain'] != '') {
                if ($rh_proto == 'http') {
                    $res['port'] = 80;
                } elseif ($rh_proto == 'https') {
                    $res['port'] = 443;
                }
            }
        }
        if (strcasecmp(substr($str_url, 0, 8), "callback") == 0) {
            $res['rooturl'] = "http://" . strtoupper($str_url);
        } else {
            $res['rooturl'] = "{$rh_proto}://{$res['host']}:{$res['port']}";
        }
        return $res;
    }

    private static function getHubFromUrl(string $url): array
    {
        if (is_null(self::$_hubs)) {
            return [];
        }
        $res = [];
        $url_detail = self::_parseRegisteredURL($url);
        /** @var YTcpHub $hub */
        foreach (self::$_hubs as $hub_url => $hub) {
            if ($url == $hub->url_info['org_url']) {
                $res[] = $hub;
            }else if ($hub_url == $url_detail['rooturl']) {
                $res[] = $hub;
            } else {
                if ($hub->isURLKnown($url)) {
                    $res[] = $hub;
                }
            }
        }
        return $res;
    }


    /**
     * Setup the Yoctopuce library to use modules connected on a given machine. Idealy this
     * call will be made once at the begining of your application.  The
     * parameter will determine how the API will work. Use the following values:
     *
     * <b>usb</b>: When the usb keyword is used, the API will work with
     * devices connected directly to the USB bus. Some programming languages such a JavaScript,
     * PHP, and Java don't provide direct access to USB hardware, so usb will
     * not work with these. In this case, use a VirtualHub or a networked YoctoHub (see below).
     *
     * <b><i>x.x.x.x</i></b> or <b><i>hostname</i></b>: The API will use the devices connected to the
     * host with the given IP address or hostname. That host can be a regular computer
     * running a <i>native VirtualHub</i>, a <i>VirtualHub for web</i> hosted on a server,
     * or a networked YoctoHub such as YoctoHub-Ethernet or
     * YoctoHub-Wireless. If you want to use the VirtualHub running on you local
     * computer, use the IP address 127.0.0.1. If the given IP is unresponsive, yRegisterHub
     * will not return until a time-out defined by ySetNetworkTimeout has elapsed.
     * However, it is possible to preventively test a connection  with yTestHub.
     * If you cannot afford a network time-out, you can use the non blocking yPregisterHub
     * function that will establish the connection as soon as it is available.
     *
     *
     * <b>callback</b>: that keyword make the API run in "<i>HTTP Callback</i>" mode.
     * This a special mode allowing to take control of Yoctopuce devices
     * through a NAT filter when using a VirtualHub or a networked YoctoHub. You only
     * need to configure your hub to call your server script on a regular basis.
     * This mode is currently available for PHP and Node.JS only.
     *
     * Be aware that only one application can use direct USB access at a
     * given time on a machine. Multiple access would cause conflicts
     * while trying to access the USB modules. In particular, this means
     * that you must stop the VirtualHub software before starting
     * an application that uses direct USB access. The workaround
     * for this limitation is to setup the library to use the VirtualHub
     * rather than direct USB access.
     *
     * If access control has been activated on the hub, virtual or not, you want to
     * reach, the URL parameter should look like:
     *
     * http://username:password@address:port
     *
     * You can call <i>RegisterHub</i> several times to connect to several machines. On
     * the other hand, it is useless and even counterproductive to call <i>RegisterHub</i>
     * with to same address multiple times during the life of the application.
     *
     * @param string $url : a string containing either "usb","callback" or the
     *         root URL of the hub to monitor
     * @param string $errmsg : a string passed by reference to receive any error message.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure returns a negative error code.
     */
    public static function RegisterHub(string $url, string &$errmsg = ''): int
    {
        if (is_null(self::$_hubs)) {
            self::_init();
        }

        $previousHub = self::getHubFromUrl($url);
        if (sizeof($previousHub) > 0) {
            /** @var YTcpHub $h */
            foreach ($previousHub as $h) {
                if ($h->isEnable()) {
                    $h->addKnownUrl($url);
                    $h->setMandatory(true);
                }
            }
            return YAPI::SUCCESS;
        }
        $url_detail = self::_parseRegisteredURL($url);
        if ($url_detail['proto'] == "wss" || $url_detail['proto'] == "ws") {
            $errmsg = "Websocket is not available in PHP";
            return YAPI::NOT_SUPPORTED;
        }
        // Test hub
        $tcphub = new YTcpHub($url_detail, true);
        $res = $tcphub->verfiyStreamAddr(true, $errmsg);
        if ($res < 0) {
            return YAPI::IO_ERROR;
        }

        $timeout = YAPI::GetTickCount() + $tcphub->get_networkTimeout();
        $tcpreq = new YTcpReq($tcphub, "GET /api/module.json", false, '', $tcphub->get_networkTimeout());
        if ($tcpreq->process($errmsg) != YAPI::SUCCESS) {
            return $tcpreq->errorType;
        }
        self::$_pendingRequests[] = $tcpreq;
        do {
            self::_handleEvents_internal(100);
        } while (!$tcpreq->eof() && YAPI::GetTickCount() < $timeout);
        if (!$tcpreq->eof()) {
            $tcpreq->close();
            $errmsg = 'Timeout waiting for device reply';
            return YAPI::TIMEOUT;
        }
        if ($tcpreq->errorType == YAPI::UNAUTHORIZED) {
            $errmsg = 'Access denied, authorization required';
            return YAPI::UNAUTHORIZED;
        } elseif ($tcpreq->errorType != YAPI::SUCCESS) {
            $errmsg = 'Network error while testing hub :' . $tcpreq->errorMsg;
            return $tcpreq->errorType;
        }
        /** @var YTcpHub $hub */
        foreach (self::$_hubs as $hub) {
            if ($hub->getSerialNumber() == $tcphub->getSerialNumber()) {
                print("Find duplicate hub: new=" . $tcphub->url_info['org_url'] . " old=" . $hub->url_info['org_url'] . "\n");
                $hub->mergeFrom($tcphub);
                return YAPI::SUCCESS;
            }
        }
        // Add hub to known list
        if (!isset(self::$_hubs[$url_detail['rooturl']])) {
            self::$_hubs[$url_detail['rooturl']] = $tcphub;
        }

        // Register device list
        $yreq = self::_updateDeviceList_internal(true, false);
        if ($yreq->errorType != YAPI::SUCCESS) {
            $errmsg = $yreq->errorMsg;
            return $yreq->errorType;
        }

        return YAPI::SUCCESS;
    }

    /**
     * Fault-tolerant alternative to yRegisterHub(). This function has the same
     * purpose and same arguments as yRegisterHub(), but does not trigger
     * an error when the selected hub is not available at the time of the function call.
     * If the connexion cannot be established immediately, a background task will automatically
     * perform periodic retries. This makes it possible to register a network hub independently of the current
     * connectivity, and to try to contact it only when a device is actively needed.
     *
     * @param string $url : a string containing either "usb","callback" or the
     *         root URL of the hub to monitor
     * @param string $errmsg : a string passed by reference to receive any error message.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure returns a negative error code.
     */
    public static function PreregisterHub(string $url, string &$errmsg = ''): int
    {
        if (is_null(self::$_hubs)) {
            self::_init();
        }
        $previousHub = self::getHubFromUrl($url);
        if (sizeof($previousHub) > 0) {
            /** @var YTcpHub $h */
            foreach ($previousHub as $h) {
                if ($h->isEnable()) {
                    $h->addKnownUrl($url);
                    $h->setMandatory(false);
                }
            }
            return YAPI::SUCCESS;
        }
        $url_detail = self::_parseRegisteredURL($url);
        if ($url_detail['proto'] == "wss" || $url_detail['proto'] == "ws") {
            $errmsg = "Websocket is not available in PHP";
            return YAPI::NOT_SUPPORTED;
        }
        // Add hub to known list
        if (!isset(self::$_hubs[$url_detail['rooturl']])) {
            self::$_hubs[$url_detail['rooturl']] = new YTcpHub($url_detail, false);
            if (self::$_hubs[$url_detail['rooturl']]->verfiyStreamAddr(true, $errmsg) < 0) {
                return YAPI::IO_ERROR;
            }
        }

        return YAPI::SUCCESS;
    }


    /**
     * Setup the Yoctopuce library to no more use modules connected on a previously
     * registered machine with RegisterHub.
     *
     * @param string $url : a string containing either "usb" or the
     *         root URL of the hub to monitor
     */
    public static function UnregisterHub(string $url): void
    {
        if (is_null(self::$_hubs)) {
            return;
        }

        /** @var YTcpHub[] $hubs */
        $hubs = self::getHubFromUrl($url);
        foreach ($hubs as $hub) {
            // leave max 10 second to finish pending requests
            $timeout = YAPI::GetTickCount() + 10000;
            foreach (self::$_pendingRequests as $tcpreq) {
                if ($tcpreq->hub->getRooturl() === $hub->getRooturl()) {
                    $request = trim($tcpreq->request);
                    if (substr($request, 0, 12) == 'GET /not.byn') {
                        continue;
                    }
                    while (!$tcpreq->eof() && YAPI::GetTickCount() < $timeout) {
                        self::_handleEvents_internal(100);
                    }
                }
            }
            // remove all connected devices
            foreach ($hub->serialByYdx as $serial) {
                if (!is_null(self::$_removalCallback)) {
                    self::$_pendingCallbacks[] = "-$serial";
                } else {
                    self::forgetDevice(self::$_devs[$serial]);
                }

            }
            if ($hub->notifReq) {
                $hub->notifReq->close();
                for ($idx = 0; $idx < sizeof(self::$_pendingRequests); $idx++) {
                    $req = self::$_pendingRequests[$idx];
                    if ($req == $hub->notifReq) {
                        array_splice(self::$_pendingRequests, $idx, 1);
                    }
                }
            }

            $key = array_search($hub, self::$_hubs, true);
            if ($key !== false) {
                unset(self::$_hubs[$key]);
            }
        }

    }

    /**
     * Test if the hub is reachable. This method do not register the hub, it only test if the
     * hub is usable. The url parameter follow the same convention as the yRegisterHub
     * method. This method is useful to verify the authentication parameters for a hub. It
     * is possible to force this method to return after mstimeout milliseconds.
     *
     * @param string $url : a string containing either "usb","callback" or the
     *         root URL of the hub to monitor
     * @param int $mstimeout : the number of millisecond available to test the connection.
     * @param string $errmsg : a string passed by reference to receive any error message.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure returns a negative error code.
     */
    public static function TestHub(string $url, int $mstimeout, string &$errmsg = ''): int
    {
        if (is_null(self::$_hubs)) {
            self::_init();
        }

        $url_detail = self::_parseRegisteredURL($url);
        if ($url_detail['proto'] == "wss" || $url_detail['proto'] == "ws") {
            $errmsg = "Websocket is not available in PHP";
            return YAPI::NOT_SUPPORTED;
        }
        // Test hub
        $tcphub = new YTcpHub($url_detail, false);
        $res = $tcphub->verfiyStreamAddr(false, $errmsg);
        if ($res < 0) {
            return YAPI::IO_ERROR;
        }
        if ($tcphub->streamaddr == 'tcp://CALLBACK') {
            return YAPI::SUCCESS;
        }
        $tcpreq = new YTcpReq($tcphub, "GET /api/module.json", false, '', $mstimeout);
        $timeout = YAPI::GetTickCount() + $mstimeout;
        do {
            if ($tcpreq->process($errmsg) != YAPI::SUCCESS) {
                return $tcpreq->errorType;
            }
        } while (!$tcpreq->eof() && YAPI::GetTickCount() < $timeout);
        if (!$tcpreq->eof()) {
            $tcpreq->close();
            $errmsg = 'Timeout waiting for device reply';
            return YAPI::TIMEOUT;
        }
        if ($tcpreq->errorType == YAPI::UNAUTHORIZED) {
            $errmsg = 'Access denied, authorization required';
            return YAPI::UNAUTHORIZED;
        } elseif ($tcpreq->errorType != YAPI::SUCCESS) {
            $errmsg = 'Network error while testing hub :' . $tcpreq->errorMsg;
            return $tcpreq->errorType;
        }
        return YAPI::SUCCESS;
    }

    /**
     * @param string $host
     * @param string $relurl
     * @param $cbdata
     * @param string $errmsg
     * @return int
     */
    static public function _forwardHTTPreq(string $proto, string $host, string $relurl, $cbdata, string &$errmsg): int
    {
        $errno = 0;
        $errstr = '';
        $implicitPort = '';
        if (strpos($host, ':') === false) {
            if ($proto == 'tls://') {
                $implicitPort = ':443';
            } else {
                $implicitPort = ':80';
            }
        }
        $skt = stream_socket_client($proto . $host . $implicitPort, $errno, $errstr, 10);
        if ($skt === false) {
            $errmsg = "failed to open socket ($errno): $errstr";
            return YAPI::IO_ERROR;
        }
        $request = "POST $relurl HTTP/1.1\r\nHost: $host\r\nConnection: close\r\n";
        $request .= "User-Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\r\n";
        $request .= "Content-Type: application/json\r\n";
        $request .= "Content-Length: " . strlen($cbdata) . "\r\n\r\n";
        $reqlen = strlen($request);
        if (fwrite($skt, $request, $reqlen) != $reqlen) {
            fclose($skt);
            $errmsg = "failed to write to socket";
            return YAPI::IO_ERROR;
        }
        $bodylen = strlen($cbdata);
        fwrite($skt, $cbdata, $bodylen);
        stream_set_blocking($skt, false);
        $header = '';
        $headerOK = false;
        $chunked = false;
        $chunkhdr = '';
        $chunksize = 0;
        while (true) {
            $data = fread($skt, 8192);
            if ($data === false || !is_resource($skt)) {
                fclose($skt);
                $errmsg = "failed to read from socket";
                return YAPI::IO_ERROR;
            }
            if (strlen($data) == 0) {
                if (feof($skt)) {
                    fclose($skt);
                    if (!$headerOK) {
                        $errmsg = "connection closed unexpectly";
                        return YAPI::IO_ERROR;
                    }
                    return YAPI::SUCCESS;
                } else {
                    $rd = array($skt);
                    $wr = null;
                    $ex = null;
                    /** @noinspection PhpUnusedLocalVariableInspection */
                    if (false === ($select_res = stream_select($rd, $wr, $ex, 0, 1000000))) {
                        $errmsg = "stream select error";
                        return YAPI::IO_ERROR;
                    }
                }
                continue;
            }
            if (!$headerOK) {
                $header .= $data;
                $data = '';
                $eoh = strpos($header, "\r\n\r\n");
                if ($eoh !== false) {
                    // fully received header
                    $headerOK = true;
                    $data = substr($header, $eoh + 4);
                    $header = substr($header, 0, $eoh + 4);
                    $lines = explode("\r\n", preg_replace('/\x0D\x0A[\x09\x20]+/', ' ', $header));
                    $meta = array();
                    foreach ($lines as $line) {
                        if (preg_match('/([^:]+): (.+)/m', $line, $match)) {
                            $match[1] = preg_replace_callback('/(?<=^|[\x09\x20\x2D])./', function ($matches) {
                                return strtoupper($matches[0]);
                            }, strtolower(trim($match[1])));
                            $meta[strtolower($match[1])] = trim($match[2]);
                        }
                    }
                    $firstline = $lines[0];
                    $words = explode(' ', $firstline);
                    $code = $words[1];
                    if ($code == '401') {
                        fclose($skt);
                        $errmsg = "HTTP Authentication not supported";
                        return YAPI::UNAUTHORIZED;
                    } elseif ($code == '101') {
                        fclose($skt);
                        $errmsg = "Websocket not supported";
                        return YAPI::NOT_SUPPORTED;
                    } elseif ($code >= '300' && $code <= '302' && isset($meta['location'])) {
                        fclose($skt);
                        return self::_forwardHTTPreq($proto, $host, $meta['location'], $cbdata, $errmsg);
                    } elseif (substr($code, 0, 2) != '20' || $code[2] == '3') {
                        fclose($skt);
                        $errmsg = "HTTP error" . substr($firstline, strlen($words[0]));
                        return YAPI::NOT_SUPPORTED;
                    }
                    $chunked = isset($meta['transfer-encoding']) && strtolower($meta['transfer-encoding']) == 'chunked';
                }
            }
            // process body according to encoding
            if (!$chunked) {
                print $data;
                continue;
            }
            // chunk decoding
            while (strlen($data) > 0) {
                if ($chunksize == 0) {
                    // reading chunk size
                    $chunkhdr .= $data;
                    if (substr($chunkhdr, 0, 2) == "\r\n") {
                        $chunkhdr = substr($chunkhdr, 2);
                    }
                    $endhdr = strpos($chunkhdr, "\r\n");
                    if ($endhdr !== false) {
                        $data = substr($chunkhdr, $endhdr + 2);
                        $sizestr = substr($chunkhdr, 0, $endhdr);
                        $chunksize = hexdec($sizestr);
                        $chunkhdr = '';
                    } else {
                        $data = '';
                    }
                } else {
                    // reading chunk data
                    $datalen = strlen($data);
                    if ($datalen > $chunksize) {
                        $datalen = $chunksize;
                    }
                    print(substr($data, 0, $datalen));
                    $data = substr($data, $datalen);
                    $chunksize -= $datalen;
                }
            }
        }
    }

    /**
     * Trigger an HTTP request to another server, and forward the HTTP callback data
     * previously received from a YoctoHub. This function only works after a successful
     * call to yRegisterHub("callback")
     *
     * @param string $url a string containing the URL of the server to which the HTTP callback
     *              should be forwarded
     * @param string $errmsg : a string passed by reference to receive any error message.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public static function ForwardHTTPCallback(string $url, string &$errmsg = ""): int
    {
        $url_detail = self::_parseRegisteredURL('callback');
        if (isset(self::$_hubs[$url_detail['rooturl']])) {
            $cb_hub = self::$_hubs[$url_detail['rooturl']];
            // data to post is found in $cb_hub->callbackData
            $fwd_proto = 'tcp://';
            if (strpos($url, 'http://') === 0) {
                $url = substr($url, 7);
            } elseif (strpos($url, 'https://') === 0) {
                $fwd_proto = 'tls://';
                $url = substr($url, 8);
            }
            $url = str_replace(['http://', 'https://'], ['', ''], $url);
            $pos = strpos($url, '/');
            if ($pos === false) {
                $relurl = '/';
            } else {
                $relurl = substr($url, $pos);
                $url = substr($url, 0, $pos);
            }
            return self::_forwardHTTPreq($fwd_proto, $url, $relurl, $cb_hub->callbackData, $errmsg);
        } else {
            $errmsg = 'ForwardHTTPCallback must be called AFTER RegisterHub("callback")';
            return YAPI::NOT_INITIALIZED;
        }
    }

    /**
     * Triggers a (re)detection of connected Yoctopuce modules.
     * The library searches the machines or USB ports previously registered using
     * yRegisterHub(), and invokes any user-defined callback function
     * in case a change in the list of connected devices is detected.
     *
     * This function can be called as frequently as desired to refresh the device list
     * and to make the application aware of hot-plug events. However, since device
     * detection is quite a heavy process, UpdateDeviceList shouldn't be called more
     * than once every two seconds.
     *
     * @param string $errmsg : a string passed by reference to receive any error message.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure returns a negative error code.
     */
    public static function UpdateDeviceList(string &$errmsg = ''): int
    {
        $yreq = self::_updateDeviceList_internal(false, true);
        if ($yreq->errorType != YAPI::SUCCESS) {
            $errmsg = $yreq->errorMsg;
            return self::_throw($yreq->errorType, $yreq->errorMsg, $yreq->errorType);
        }
        return YAPI::SUCCESS;
    }

    /**
     * Maintains the device-to-library communication channel.
     * If your program includes significant loops, you may want to include
     * a call to this function to make sure that the library takes care of
     * the information pushed by the modules on the communication channels.
     * This is not strictly necessary, but it may improve the reactivity
     * of the library for the following commands.
     *
     * This function may signal an error in case there is a communication problem
     * while contacting a module.
     *
     * @param string $errmsg : a string passed by reference to receive any error message.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure returns a negative error code.
     */
    public static function HandleEvents(string &$errmsg = ''): int
    {
        // monitor hubs for events
        /** @noinspection PhpStatementHasEmptyBodyInspection */
        while (self::_handleEvents_internal(0)) {
        }

        // handle pending events
        $nEvents = sizeof(self::$_data_events);
        for ($i = 0; $i < $nEvents; $i++) {
            $evt = self::$_data_events[$i];
            if (sizeof($evt) == 1) {
                $evt[0]->isOnline();
            } else {
                if (is_string($evt[1])) {
                    /** @var YFunction $fun */
                    $fun = $evt[0];
                    // event object is an advertised value
                    $fun->_invokeValueCallback($evt[1]);

                } else {
                    /** @var YSensor $ysensor */
                    $ysensor = $evt[0];
                    // event object is an array of bytes (encoded timed report)
                    $dev = YAPI::getDevice($ysensor->get_module()->get_serialNumber());
                    if (!is_null($dev)) {
                        $report = $ysensor->_decodeTimedReport($evt[1], $evt[2], $evt[3]);
                        $ysensor->_invokeTimedReportCallback($report);
                    }
                }
            }
        }
        self::$_data_events = array_slice(self::$_data_events, $nEvents);
        $errmsg = '';

        return YAPI::SUCCESS;
    }

    /**
     * Pauses the execution flow for a specified duration.
     * This function implements a passive waiting loop, meaning that it does not
     * consume CPU cycles significantly. The processor is left available for
     * other threads and processes. During the pause, the library nevertheless
     * reads from time to time information from the Yoctopuce modules by
     * calling yHandleEvents(), in order to stay up-to-date.
     *
     * This function may signal an error in case there is a communication problem
     * while contacting a module.
     *
     * @param float $ms_duration : an integer corresponding to the duration of the pause,
     *         in milliseconds.
     * @param string $errmsg : a string passed by reference to receive any error message.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure returns a negative error code.
     */
    public static function Sleep(float $ms_duration, string &$errmsg = ''): int
    {
        $end = YAPI::GetTickCount() + $ms_duration;
        self::HandleEvents($errmsg);
        $remain = $end - YAPI::GetTickCount();
        while ($remain > 0) {
            if ($remain > 999) {
                $remain = 999;
            }
            self::_handleEvents_internal((int)$remain);
            self::HandleEvents($errmsg);
            $remain = $end - YAPI::GetTickCount();
        }
        $errmsg = '';

        return YAPI::SUCCESS;
    }

    /**
     * Returns the current value of a monotone millisecond-based time counter.
     * This counter can be used to compute delays in relation with
     * Yoctopuce devices, which also uses the millisecond as timebase.
     *
     * @return float  a long integer corresponding to the millisecond counter.
     */
    public static function GetTickCount(): float
    {
        return round(microtime(true) * 1000);
    }

    /**
     * Checks if a given string is valid as logical name for a module or a function.
     * A valid logical name has a maximum of 19 characters, all among
     * A..Z, a..z, 0..9, _, and -.
     * If you try to configure a logical name with an incorrect string,
     * the invalid characters are ignored.
     *
     * @param string $name : a string containing the name to check.
     *
     * @return boolean  true if the name is valid, false otherwise.
     */
    public static function CheckLogicalName(string $name): bool
    {
        if ($name == '') {
            return true;
        }
        if (!$name) {
            return false;
        }
        if (strlen($name) > 19) {
            return false;
        }
        return preg_match('/^[A-Za-z0-9_\-]*$/', $name) > 0;
    }

    /**
     * Register a callback function, to be called each time
     * a device is plugged. This callback will be invoked while yUpdateDeviceList
     * is running. You will have to call this function on a regular basis.
     *
     * @param callable $arrivalCallback : a procedure taking a YModule parameter, or null
     *         to unregister a previously registered  callback.
     */
    public static function RegisterDeviceArrivalCallback(?callable $arrivalCallback): void
    {
        self::$_arrivalCallback = $arrivalCallback;
    }

    /**
     * Register a device logical name change callback
     */
    public static function RegisterDeviceChangeCallback(?callable $changeCallback): void
    {
        self::$_namechgCallback = $changeCallback;
    }

    /**
     * Register a callback function, to be called each time
     * a device is unplugged. This callback will be invoked while yUpdateDeviceList
     * is running. You will have to call this function on a regular basis.
     *
     * @param callable $removalCallback : a procedure taking a YModule parameter, or null
     *         to unregister a previously registered  callback.
     */
    public static function RegisterDeviceRemovalCallback(?callable $removalCallback): void
    {
        self::$_removalCallback = $removalCallback;
    }

    // Register a new value calibration handler for a given calibration type
    //
    public static function RegisterCalibrationHandler(int $calibrationType, ?callable $calibrationHandler): void
    {
        self::$_calibHandlers[$calibrationType] = $calibrationHandler;
    }

    // Standard value calibration handler (n-point linear error correction)
    //
    public static function LinearCalibrationHandler(
        float $float_rawValue,
        int $int_calibType,
        array $arr_calibParams,
        array $arr_calibRawValues,
        array $arr_calibRefValues
    ): float {
        $x = $arr_calibRawValues[0];
        $adj = $arr_calibRefValues[0] - $x;
        $i = 0;

        if ($int_calibType < YOCTO_CALIB_TYPE_OFS) {
            // calibration types n=1..10 are meant for linear calibration using n points
            $npt = min($int_calibType % 10, sizeof($arr_calibRawValues), sizeof($arr_calibRefValues));
        } else {
            $npt = sizeof($arr_calibRefValues);
        }
        while ($float_rawValue > $arr_calibRawValues[$i] && ++$i < $npt) {
            $x2 = $x;
            $adj2 = $adj;

            $x = $arr_calibRawValues[$i];
            $adj = $arr_calibRefValues[$i] - $x;

            if ($float_rawValue < $x && $x > $x2) {
                $adj = $adj2 + ($adj - $adj2) * ($float_rawValue - $x2) / ($x - $x2);
            }
        }
        return $float_rawValue + $adj;
    }

    // Network notification format: 7x7bit (mapped to 7 chars in range 32..159)
    //                              used to represent 1 flag (RAW6BYTES) + 6 bytes
    // INPUT:  [R765432][1076543][2107654][3210765][4321076][5432107][6543210]
    // OUTPUT: 7 bytes array (1 byte for the funcTypeV2 and 6 bytes of USB like data
    //                     funcTypeV2 + [R][-byte 0][-byte 1-][-byte 2-][-byte 3-][-byte 4-][-byte 5-]
    //
    // return null on error
    //
    private static function decodeNetFuncValV2(string $p): ?array
    {
        $p_ofs = 0;
        $ch = ord($p[$p_ofs]);
        $len = 0;
        $funcVal = array_fill(0, 7, 0);

        if ($ch < 32 || $ch > 32 + 127) {
            return null;
        }
        // get the 7 first bits
        $ch -= 32;
        $funcVal[0] = (($ch & 0x40) != 0 ? NOTIFY_V2_6RAWBYTES : NOTIFY_V2_TYPEDDATA);
        // clear flag
        $ch &= 0x3f;
        while ($len < YOCTO_PUBVAL_SIZE) {
            $p_ofs++;
            if ($p_ofs >= strlen($p)) {
                break;
            }
            $newCh = ord($p[$p_ofs]);
            if ($newCh == NOTIFY_NETPKT_STOP) {
                break;
            }
            if ($newCh < 32 || $newCh > 32 + 127) {
                return null;
            }
            $newCh -= 32;
            $ch = ($ch << 7) + $newCh;
            $funcVal[$len + 1] = ($ch >> (5 - $len)) & 0xff;
            $len++;
        }
        return $funcVal;
    }

    private static function decodePubVal(int $typeV2, array $funcval, int $ofs, int $funcvalen): string
    {
        $buffer = "";
        if ($typeV2 == NOTIFY_V2_6RAWBYTES || $typeV2 == NOTIFY_V2_TYPEDDATA) {
            if ($typeV2 == NOTIFY_V2_6RAWBYTES) {
                $funcValType = PUBVAL_6RAWBYTES;
            } else {
                $funcValType = $funcval[$ofs++];
            }
            switch ($funcValType) {
                case PUBVAL_LEGACY:
                    // fallback to legacy handling, just in case
                    break;
                case PUBVAL_1RAWBYTE:
                case PUBVAL_2RAWBYTES:
                case PUBVAL_3RAWBYTES:
                case PUBVAL_4RAWBYTES:
                case PUBVAL_5RAWBYTES:
                case PUBVAL_6RAWBYTES:
                    // 1..5 hex bytes
                    for ($i = 0; $i < $funcValType; $i++) {
                        $c = $funcval[$ofs++];
                        $b = $c >> 4;
                        $buffer .= dechex($b);
                        $b = $c & 0xf;
                        $buffer .= dechex($b);
                    }
                    return $buffer;
                case PUBVAL_C_LONG:
                case PUBVAL_YOCTO_FLOAT_E3:
                    // 32bit integer in little endian format or Yoctopuce 10-3 format
                    $numVal = $funcval[$ofs++];
                    $numVal += $funcval[$ofs++] << 8;
                    $numVal += $funcval[$ofs++] << 16;
                    $numVal += $funcval[$ofs] << 24;
                    if ($funcValType == PUBVAL_C_LONG) {
                        return sprintf("%d", $numVal);
                    } else {
                        $buffer = sprintf("%.3f", $numVal / 1000.0);
                        $endp = strlen($buffer);
                        while ($endp > 0 && $buffer[$endp - 1] == '0') {
                            --$endp;
                        }
                        if ($endp > 0 && $buffer[$endp - 1] == '.') {
                            --$endp;
                            $buffer = substr($buffer, 0, $endp);
                        }
                        return $buffer;
                    }
                case PUBVAL_C_FLOAT:
                    // 32bit (short) float
                    $v = $funcval[$ofs++];
                    $v += $funcval[$ofs++] << 8;
                    $v += $funcval[$ofs++] << 16;
                    $v += $funcval[$ofs] << 24;
                    $fraction = ($v & ((1 << 23) - 1)) + (1 << 23) * ($v >> 31 | 1);
                    $exp = ($v >> 23 & 0xFF) - 127;
                    $floatVal = $fraction * pow(2, $exp - 23);
                    $buffer = sprintf("%.6f", $floatVal);
                    $endp = strlen($buffer);
                    while ($endp > 0 && $buffer[$endp - 1] == '0') {
                        --$endp;
                    }
                    if ($endp > 0 && $buffer[$endp - 1] == '.') {
                        --$endp;
                        $buffer = substr($buffer, 0, $endp);
                    }
                    return $buffer;
                default:
                    return "?";
            }
        }
        // Legacy handling: just pad with NUL up to 7 chars
        $len = 0;
        /** @noinspection PhpConditionAlreadyCheckedInspection */
        $buffer = '';
        while ($len < YOCTO_PUBVAL_SIZE && $len < $funcvalen) {
            if ($funcval[$len] == 0) {
                break;
            }
            $buffer .= chr($funcval[$len]);
            $len++;
        }
        return $buffer;
    }

    public static function nextHubRef(int $hubref): int
    {
        if (is_null(self::$_hubs)) {
            self::_init();
        }

        if ($hubref < 0) {
            $next = 0;
        } else {
            $next = $hubref + 1;
        }
        $c = 0;
        foreach (self::$_hubs as $hub) {
            /** @var YTcpHub $hub */
            if ($c == $next && $hub->isEnable()) {
                return $c;
            }
            $c++;
        }

        return -1;
    }

    public static function getTcpHubFromRef(int $hubref): ?YTcpHub
    {
        $c = 0;
        foreach (self::$_hubs as $hub) {
            /** @var YTcpHub $hub */
            if ($c == $hubref && $hub->isEnable()) {
                return $hub;
            }
            $c++;
        }
        return null;
    }

    public static function _checkForDuplicateHub(YTcpHub $newHub): bool
    {
        $serialNumber = $newHub->getSerialNumber();
        foreach (self::$_hubs as $hub) {
            if ($hub->isEnable() && $hub !== $newHub && $hub->getSerialNumber() == $serialNumber) {
                $hub->mergeFrom($newHub);
                return true;
            }
        }
        return false;
    }

}

