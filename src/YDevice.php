<?php
namespace Yoctopuce\YoctoAPI;

//
// YDevice Class (used internally)
//
// This class is used to store everything we know about connected Yocto-Devices.
// Instances are created when devices are discovered in the white pages
// (or registered manually, for root hubs) and then used to keep track of
// device naming changes. When a device or a function is renamed, this
// object forces the local indexes to be immediately updated, even if not
// yet fully propagated through the yellow pages of the device hub.
//
// In order to regroup multiple function queries on the same physical device,
// this class implements a device-wide API string cache (agnostic of API content).
// This is in addition to the function-specific cache implemented in YFunction.
//

class YDevice
{
    // private attributes, to be used within yocto_api only
    protected string $_rootUrl;
    protected string $_serialNumber;
    protected string $_logicalName;
    protected string $_productName;
    protected int $_productId;
    protected float $_lastTimeRef;
    protected float $_lastDuration;
    protected int $_beacon;
    protected int $_devYdx;
    protected array $_cache;
    protected float $_cacheExpiration;
    protected array $_functions;
    protected ?YTcpReq $_ongoingReq;
    public int $_lastErrorType;
    public string $_lastErrorMsg;
    private bool $_logNeedPulling;
    private bool $_logIsPulling;
    private mixed $_logCallback;
    private int $_logpos;

    function __construct(string $str_rooturl, ?array $obj_wpRec = null, ?array $obj_ypRecs = null)
    {
        $this->_rootUrl = $str_rooturl;
        $this->_serialNumber = '';
        $this->_logicalName = '';
        $this->_productName = '';
        $this->_productId = 0;
        $this->_beacon = 0;
        $this->_devYdx = -1;
        $this->_cache = array('_expiration' => 0, '_json' => '');
        $this->_functions = array();
        $this->_lastErrorType = YAPI::SUCCESS;
        $this->_lastErrorMsg = 'no error';
        $this->_ongoingReq = null;
        $this->_logCallback = null;
        $this->_logIsPulling = false;
        $this->_lastTimeRef = 0;
        $this->_lastDuration = 0;
        $this->_logNeedPulling = false;
        $this->_logpos = 0;
        if (!is_null($obj_wpRec)) {
            // preload values from white pages, if provided
            $this->_serialNumber = $obj_wpRec['serialNumber'];
            $this->_logicalName = $obj_wpRec['logicalName'];
            $this->_productName = $obj_wpRec['productName'];
            $this->_productId = $obj_wpRec['productId'];
            $this->_beacon = $obj_wpRec['beacon'];
            $this->_devYdx = (isset($obj_wpRec['index']) ? $obj_wpRec['index'] : -1);
            $this->_updateFromYP($obj_ypRecs);
            YAPI::reindexDevice($this);
        } else {
            // preload values from device directly
            $this->refresh();
        }
    }

    // Throw an exception, keeping track of it in the object itself

    /**
     * @param int $int_errType
     * @param string $str_errMsg
     * @param mixed $obj_retVal
     * @return mixed
     * @throws YAPI_Exception
     */
    protected function _throw(int $int_errType, string $str_errMsg, mixed $obj_retVal): mixed
    {
        $this->_lastErrorType = $int_errType;
        $this->_lastErrorMsg = $str_errMsg;

        if (YAPI::$exceptionsDisabled) {
            return $obj_retVal;
        }
        // throw an exception
        throw new YAPI_Exception($str_errMsg, $int_errType);
    }

    // Update device cache and YAPI function lists from yp records
    protected function _updateFromYP(array $obj_ypRecs): void
    {
        $funidx = 0;
        foreach ($obj_ypRecs as $ypRec) {
            foreach ($ypRec as $rec) {
                $hwid = $rec['hardwareId'];
                $dotpos = strpos($hwid, '.');
                if (substr($hwid, 0, $dotpos) == $this->_serialNumber) {
                    if (isset($rec['index'])) {
                        $funydx = $rec['index'];
                    } else {
                        $funydx = $funidx;
                    }
                    $this->_functions[$funydx] = array(substr($hwid, $dotpos + 1), $rec["logicalName"]);
                }
            }
        }
    }

    // Return the root URL used to access a device (including the trailing slash)
    public function getRootUrl(): string
    {
        return $this->_rootUrl;
    }

    // Return the serial number of the device, as found during discovery
    public function getSerialNumber(): string
    {
        return $this->_serialNumber;
    }

    // Return the logical name of the device, as found during discovery
    public function getLogicalName(): string
    {
        return $this->_logicalName;
    }

    // Return the product name of the device, as found during discovery
    public function getProductName(): string
    {
        return $this->_productName;
    }

    // Return the product Id of the device, as found during discovery
    public function getProductId(): int
    {
        return $this->_productId;
    }

    // Return the beacon state of the device, as found during discovery
    public function getBeacon(): int
    {
        return $this->_beacon;
    }

    public function getLastTimeRef(): float
    {
        return $this->_lastTimeRef;
    }

    public function getLastDuration(): float
    {
        return $this->_lastDuration;
    }

    public function setTimeRef(float $float_timestamp, float $float_duration)
    {
        $this->_lastTimeRef = $float_timestamp;
        $this->_lastDuration = $float_duration;
    }


    public function triggerLogPull(): void
    {
        if ($this->_logCallback == null || $this->_logIsPulling) {
            return;
        }
        $this->_logIsPulling = true;
        $request = "GET /logs.txt?pos=" . $this->_logpos;
        $yreq = YAPI::devRequest($this->_rootUrl, $request);
        if ($yreq->errorType != YAPI::SUCCESS) {
            return;
        }

        /** @noinspection PhpConditionAlreadyCheckedInspection */
        if ($this->_logCallback == null) {
            $this->_logIsPulling = false;
            return;
        }
        $resultStr = YAPI::Ybin2str($yreq->result);
        $pos = strrpos($resultStr, "\n@");
        if ($pos < 0) {
            $this->_logIsPulling = false;
            return;
        }
        $logs = substr($resultStr, 0, $pos);
        if (strlen($logs) > 0) {
            $posStr = substr($resultStr, $pos + 2);
            $this->_logpos = (int)$posStr;
            $module = YModule::FindModule($this->_serialNumber . ".module");
            $lines = explode("\n", rtrim($logs));
            foreach ($lines as $line) {
                call_user_func($this->_logCallback, $module, $line);
            }
        }
        $this->_logIsPulling = false;
    }

    public function setDeviceLogPending(): void
    {
        $this->_logNeedPulling = true;
    }

    public function registerLogCallback(?callable $obj_callback): void
    {
        $this->_logCallback = $obj_callback;
        if ($obj_callback != null) {
            $this->triggerLogPull();
        }
    }

    // Return the hub-specific devYdx of the device, as found during discovery
    public function getDevYdx(): int
    {
        return $this->_devYdx;
    }

    // Return a string that describes the device (serial number, logical name or root URL)
    public function describe(): string
    {
        $res = $this->_rootUrl;
        if ($this->_serialNumber != '') {
            $res = $this->_serialNumber;
            if ($this->_logicalName != '') {
                $res .= ' (' . ($this->_logicalName) . ')';
            }
        }
        return $this->_productName . ' ' . $res;
    }

    /**
     * Prepare to run a request on a device (finish any async device before if needed
     *(called by devRequest)
     * @param YTcpReq $tcpreq
     */
    public function prepRequest(YTcpReq $tcpreq): void
    {
        if (!is_null($this->_ongoingReq)) {
            while (!$this->_ongoingReq->eof()) {
                YAPI::_handleEvents_internal(100);
            }
        }
        $this->_ongoingReq = $tcpreq;
    }

    /**
     * Get the whole REST API string for a device, from cache if possible
     * @return YAPI_YReq
     */
    public function requestAPI(): YAPI_YReq
    {
        if ($this->_cache['_expiration'] > YAPI::GetTickCount()) {
            return new YAPI_YReq($this->_serialNumber . ".module",
                YAPI::SUCCESS, 'no error', $this->_cache['_json'], $this->_cache['_precooked']);
        }
        $req = 'GET /api.json';
        $use_jzon = false;
        if (isset($this->_cache['_precooked']) && $this->_cache['_precooked']['module']['firmwareRelease']) {
            $req .= "?fw=" . urlencode($this->_cache['_precooked']['module']['firmwareRelease']);
            $use_jzon = true;
        }
        $yreq = YAPI::devRequest($this->_rootUrl, $req);
        if ($yreq->errorType != YAPI::SUCCESS) {
            return $yreq;
        }
        $json_req = json_decode(YAPI::Ybin2str($yreq->result), true);
        if (json_last_error() != JSON_ERROR_NONE) {
            return $this->_throw(YAPI::IO_ERROR, 'Request failed, could not parse API result for ' . $this->_rootUrl,
                YAPI::IO_ERROR);
        }
        if ($use_jzon && !key_exists('module', $json_req)) {
            $decoded = YTcpHub::decodeJZON($json_req, $this->_cache['_precooked']);
            $this->_cache['_json'] = json_encode($decoded);
            $this->_cache['_precooked'] = $decoded;
        } else {
            $this->_cache['_json'] = $yreq->result;
            $this->_cache['_precooked'] = $json_req;
        }
        $this->_cacheExpiration = YAPI::GetTickCount() + YAPI::$defaultCacheValidity;

        return new YAPI_YReq($this->_serialNumber . ".module",
            YAPI::SUCCESS, 'no error', $this->_cache['_json'], $this->_cache['_precooked']);
    }



    // Reload a device API (store in cache), and update YAPI function lists accordingly
    // Intended to be called within UpdateDeviceList only
    public function refresh(): int
    {
        $yreq = $this->requestAPI();
        if ($yreq->errorType != YAPI::SUCCESS) {
            return $this->_throw($yreq->errorType, $yreq->errorMsg, $yreq->errorType);
        }
        $loadval = $yreq->obj_result;
        $reindex = false;
        if ($this->_productName == "") {
            // parse module and function names for the first time
            foreach ($loadval as $func => $iface) {
                if ($func == 'module') {
                    $this->_serialNumber = $iface['serialNumber'];
                    $this->_logicalName = $iface['logicalName'];
                    $this->_productName = $iface['productName'];
                    $this->_productId = $iface['productId'];
                    $this->_beacon = $iface['beacon'];
                } elseif ($func == 'services') {
                    $this->_updateFromYP($iface['yellowPages']);
                }
            }
            $reindex = true;
        } else {
            // parse module and refresh names if needed
            foreach ($loadval as $func => $iface) {
                if ($func == 'module') {
                    if ($this->_logicalName != $iface['logicalName']) {
                        $this->_logicalName = $iface['logicalName'];
                        $reindex = true;
                    }
                    $this->_beacon = $iface['beacon'];
                } elseif ($func != 'services') {
                    if (isset($iface[$func]['logicalName'])) {
                        $name = $iface[$func]['logicalName'];
                    } else {
                        $name = $this->_logicalName;
                    }
                    if (isset($iface[$func]['advertisedValue'])) {
                        $pubval = $iface[$func]['advertisedValue'];
                        YAPI::setFunctionValue($this->_serialNumber . '.' . $func, $pubval);
                    }
                    foreach ($this->_functions as $funydx => $fundef) {
                        if ($fundef[0] == $func) {
                            if ($fundef[1] != $name) {
                                $this->_functions[$funydx][1] = $name;
                                $reindex = true;
                            }
                            break;
                        }
                    }
                }
            }
        }
        if ($reindex) {
            YAPI::reindexDevice($this);
        }
        return YAPI::SUCCESS;
    }

    // Force the REST API string in cache to expire immediately
    public function dropCache(): void
    {
        $this->_cache['_expiration'] = 0;
    }

    /**
     * Returns the number of functions (beside the "module" interface) available on the module.
     *
     * @return integer: the number of functions on the module
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function functionCount(): int
    {
        $funcPos = 0;
        foreach ($this->_functions as $fundef) {
            $funcPos++;
        }
        return $funcPos;
    }

    /**
     * Retrieves the hardware identifier of the <i>n</i>th function on the module.
     *
     * @param int $functionIndex : the index of the function for which the information is desired, starting at
     * 0 for the first function.
     *
     * @return string : a string corresponding to the unambiguous hardware identifier of the requested module function
     *
     * On failure, throws an exception or returns an empty string.
     */
    public function functionId(int $functionIndex): string
    {
        $funcPos = 0;
        foreach ($this->_functions as $fundef) {
            if ($functionIndex == $funcPos) {
                return $fundef[0];
            }
            $funcPos++;
        }
        return '';
    }

    public function functionBaseType(int $functionIndex): string
    {
        $fid = $this->functionId($functionIndex);
        if ($fid != '') {
            $ftype = YAPI::getFunctionBaseType($this->_serialNumber . '.' . $fid);
            foreach (YAPI::$BASETYPES as $name => $type) {
                if ($ftype === $type) {
                    return $name;
                }
            }
        }
        return 'Function';
    }

    public function functionType(int $functionIndex): string
    {
        $fid = $this->functionId($functionIndex);
        if ($fid != '') {
            for ($i = strlen($fid); $i > 0; $i--) {
                if ($fid[$i - 1] > '9') {
                    break;
                }
            }
            return strtoupper($fid[0]) . substr($fid, 1, $i - 1);
        }
        return '';
    }

    /**
     * Retrieves the logical name of the <i>n</i>th function on the module.
     *
     * @param $functionIndex : the index of the function for which the information is desired, starting at
     * 0 for the first function.
     *
     * @return string:  a string corresponding to the logical name of the requested module function
     *
     * On failure, throws an exception or returns an empty string.
     */
    public function functionName(int $functionIndex): string
    {
        $funcPos = 0;
        foreach ($this->_functions as $fundef) {
            if ($functionIndex == $funcPos) {
                return $fundef[1];
            }
            $funcPos++;
        }
        return '';
    }

    /**
     * Retrieves the advertised value of the <i>n</i>th function on the module.
     *
     * @param int functionIndex : the index of the function for which the information is desired, starting at
     * 0 for the first function.
     *
     * @return string : a short string (up to 6 characters) corresponding to the advertised value of the requested
     * module function
     *
     * On failure, throws an exception or returns an empty string.
     */
    public function functionValue(int $functionIndex): string
    {
        $fid = $this->functionId($functionIndex);
        if ($fid != '') {
            return YAPI::getFunctionValue($this->_serialNumber . '.' . $fid);
        }
        return '';
    }

    /**
     * Retrieves the hardware identifier of a function given its funydx (internal function identifier index)
     *
     * @param integer $funYdx : the internal function identifier index
     *
     * @return string : a string corresponding to the unambiguous hardware identifier of the requested module function
     *
     * On failure, throws an exception or returns an empty string.
     */
    public function functionIdByFunYdx(int $funYdx): string
    {
        if (isset($this->_functions[$funYdx])) {
            return $this->_functions[$funYdx][0];
        }
        return '';
    }
}

