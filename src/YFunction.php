<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YFunction Class: Common function interface
 *
 * This is the parent class for all public objects representing device functions documented in
 * the high-level programming API. This abstract class does all the real job, but without
 * knowledge of the specific function attributes.
 *
 * Instantiating a child class of YFunction does not cause any communication.
 * The instance simply keeps track of its function identifier, and will dynamically bind
 * to a matching device at the time it is really being used to read or set an attribute.
 * In order to allow true hot-plug replacement of one device by another, the binding stay
 * dynamic through the life of the object.
 *
 * The YFunction class implements a generic high-level cache for the attribute values of
 * the specified function, pre-parsed from the REST API string.
 */
class YFunction
{
    const LOGICALNAME_INVALID = YAPI::INVALID_STRING;
    const ADVERTISEDVALUE_INVALID = YAPI::INVALID_STRING;
    //--- (end of generated code: YFunction declaration)
    const FUNCTIONDESCRIPTOR_INVALID = YAPI::INVALID_STRING;
    const HARDWAREID_INVALID = YAPI::INVALID_STRING;
    const FUNCTIONID_INVALID = YAPI::INVALID_STRING;
    const FRIENDLYNAME_INVALID = YAPI::INVALID_STRING;

    /** @var YFunction[] */
    public static $_TimedReportCallbackList = array();
    /** @var YFunction[] */
    public static $_ValueCallbackList = array();

    protected $_className = 'Function';
    protected $_func;
    protected $_lastErrorType = YAPI::SUCCESS;
    protected $_lastErrorMsg = 'no error';
    protected $_dataStreams;
    protected $_userData = null;
    protected $_cache;
    //--- (generated code: YFunction attributes)
    protected string $_logicalName = self::LOGICALNAME_INVALID;    // Text
    protected string $_advertisedValue = self::ADVERTISEDVALUE_INVALID; // PubText
    protected mixed $_valueCallbackFunction = null;                         // YFunctionValueCallback
    protected float $_cacheExpiration = 0;                            // ulong
    protected string $_serial = "";                           // str
    protected string $_funId = "";                           // str
    protected string $_hwId = "";                           // str

    //--- (end of generated code: YFunction attributes)

    function __construct($str_func)
    {
        $this->_func = $str_func;
        $this->_cache = array('_expiration' => 0);
        $this->_dataStreams = array();

        //--- (generated code: YFunction constructor)
        //--- (end of generated code: YFunction constructor)
    }

    // internal helper for YFunctionType
    function _getHwId()
    {
        return $this->_hwId;
    }


    private function isReadOnly_internal()
    {
        try {
            $serial = $this->get_serialNumber();
            return YAPI::isReadOnly($serial);
        } catch (Exception $ignore) {
            return true;
        }
    }


    //--- (generated code: YFunction implementation)

    function _parseAttr($name, $val): int
    {
        switch ($name) {
            case '_expiration':
                $this->_cacheExpiration = $val;
                return 1;
        case 'logicalName':
            $this->_logicalName = $val;
            return 1;
        case 'advertisedValue':
            $this->_advertisedValue = $val;
            return 1;
        }
        return 0;
    }

    /**
     * Returns the logical name of the function.
     *
     * @return string  a string corresponding to the logical name of the function
     *
     * On failure, throws an exception or returns YFunction.LOGICALNAME_INVALID.
     */
    public function get_logicalName(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LOGICALNAME_INVALID;
            }
        }
        $res = $this->_logicalName;
        return $res;
    }

    /**
     * Changes the logical name of the function. You can use yCheckLogicalName()
     * prior to this call to make sure that your parameter is valid.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param string $newval : a string corresponding to the logical name of the function
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_logicalName(string $newval): int
    {
        if (!YAPI::CheckLogicalName($newval)) {
            return $this->_throw(YAPI::INVALID_ARGUMENT,'Invalid name :'.$newval);
        }
        $rest_val = $newval;
        return $this->_setAttr("logicalName", $rest_val);
    }

    /**
     * Returns a short string representing the current state of the function.
     *
     * @return string  a string corresponding to a short string representing the current state of the function
     *
     * On failure, throws an exception or returns YFunction.ADVERTISEDVALUE_INVALID.
     */
    public function get_advertisedValue(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::ADVERTISEDVALUE_INVALID;
            }
        }
        $res = $this->_advertisedValue;
        return $res;
    }

    public function set_advertisedValue(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("advertisedValue", $rest_val);
    }

    /**
     * Retrieves a function for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the function is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the function is
     * indeed online at a given time. In case of ambiguity when looking for
     * a function by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the function, for instance
     *         MyDevice..
     *
     * @return YFunction  a YFunction object allowing you to drive the function.
     */
    public static function FindFunction(string $func): ?YFunction
    {
        // $obj                    is a YFunction;
        $obj = YFunction::_FindFromCache('Function', $func);
        if ($obj == null) {
            $obj = new YFunction($func);
            YFunction::_AddToCache('Function', $func, $obj);
        }
        return $obj;
    }

    /**
     * Registers the callback function that is invoked on every change of advertised value.
     * The callback is invoked only during the execution of ySleep or yHandleEvents.
     * This provides control over the time when the callback is triggered. For good responsiveness, remember to call
     * one of these two functions periodically. To unregister a callback, pass a null pointer as argument.
     *
     * @param callable $callback : the callback function to call, or a null pointer. The callback function
     * should take two
     *         arguments: the function object of which the value has changed, and the character string describing
     *         the new advertised value.
     * @noreturn
     */
    public function registerValueCallback(mixed $callback): int
    {
        // $val                    is a str;
        if (!is_null($callback)) {
            YFunction::_UpdateValueCallbackList($this, true);
        } else {
            YFunction::_UpdateValueCallbackList($this, false);
        }
        $this->_valueCallbackFunction = $callback;
        // Immediately invoke value callback with current value
        if (!is_null($callback) && $this->isOnline()) {
            $val = $this->_advertisedValue;
            if (!($val == '')) {
                $this->_invokeValueCallback($val);
            }
        }
        return 0;
    }

    public function _invokeValueCallback(string $value): int
    {
        if (!is_null($this->_valueCallbackFunction)) {
            call_user_func($this->_valueCallbackFunction, $this, $value);
        } else {
        }
        return 0;
    }

    /**
     * Disables the propagation of every new advertised value to the parent hub.
     * You can use this function to save bandwidth and CPU on computers with limited
     * resources, or to prevent unwanted invocations of the HTTP callback.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function muteValueCallbacks(): int
    {
        return $this->set_advertisedValue('SILENT');
    }

    /**
     * Re-enables the propagation of every new advertised value to the parent hub.
     * This function reverts the effect of a previous call to muteValueCallbacks().
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function unmuteValueCallbacks(): int
    {
        return $this->set_advertisedValue('');
    }

    /**
     * Returns the current value of a single function attribute, as a text string, as quickly as
     * possible but without using the cached value.
     *
     * @param string $attrName : the name of the requested attribute
     *
     * @return string  a string with the value of the the attribute
     *
     * On failure, throws an exception or returns an empty string.
     */
    public function loadAttribute(string $attrName): string
    {
        // $url                    is a str;
        // $attrVal                is a bin;
        $url = sprintf('api/%s/%s', $this->get_functionId(), $attrName);
        $attrVal = $this->_download($url);
        return $attrVal;
    }

    /**
     * Test if the function is readOnly. Return true if the function is write protected
     * or that the function is not available.
     *
     * @return boolean  true if the function is readOnly or not online.
     */
    public function isReadOnly(): bool
    {
        return $this->isReadOnly_internal();
    }

    //cannot be generated for PHP:
    //private function isReadOnly_internal()

    /**
     * Returns the serial number of the module, as set by the factory.
     *
     * @return string  a string corresponding to the serial number of the module, as set by the factory.
     *
     * On failure, throws an exception or returns YFunction.SERIALNUMBER_INVALID.
     */
    public function get_serialNumber(): string
    {
        // $m                      is a YModule;
        $m = $this->get_module();
        return $m->get_serialNumber();
    }

    public function _parserHelper(): int
    {
        return 0;
    }

    public function logicalName(): string
{
    return $this->get_logicalName();
}

    public function setLogicalName(string $newval)
{
    return $this->set_logicalName($newval);
}

    public function advertisedValue(): string
{
    return $this->get_advertisedValue();
}

    public function setAdvertisedValue(string $newval)
{
    return $this->set_advertisedValue($newval);
}

    /**
     * comment from .yc definition
     */
    public function nextFunction(): ?YFunction
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindFunction($next_hwid);
    }

    /**
     * comment from .yc definition
     */
    public static function FirstFunction()
    {
        $next_hwid = YAPI::getFirstHardwareId('Function');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindFunction($next_hwid);
    }

    //--- (end of generated code: YFunction implementation)

    public static function _FindFromCache(string $className, string $func): ?YFunction
    {
        return YAPI::getFunction($className, $func);
    }

    public static function _AddToCache(string $className, string $func, YFunction $obj): void
    {
        YAPI::setFunction($className, $func, $obj);
    }

    public static function _ClearCache(): void
    {
        YAPI::_init();
    }

    /**
     * internal function
     * @param YFunction $obj_func
     * @param bool $bool_add
     */
    public static function _UpdateValueCallbackList($obj_func, $bool_add)
    {
        $index = array_search($obj_func, self::$_ValueCallbackList);
        if ($bool_add) {
            $obj_func->isOnline();
            if ($index === false) {
                self::$_ValueCallbackList[] = $obj_func;
            }
        } elseif ($index !== false) {
            array_splice(self::$_ValueCallbackList, $index, 1);
        }
    }

    /**
     * internal function
     * @param YFunction $obj_func
     * @param bool $bool_add
     */
    public static function _UpdateTimedReportCallbackList($obj_func, $bool_add)
    {
        $index = array_search($obj_func, self::$_TimedReportCallbackList);
        if ($bool_add) {
            $obj_func->isOnline();
            if ($index === false) {
                self::$_TimedReportCallbackList[] = $obj_func;
            }
        } elseif ($index !== false) {
            array_splice(self::$_TimedReportCallbackList, $index, 1);
        }
    }

    // Throw an exception, keeping track of it in the object itself
    public function _throw($int_errType, $str_errMsg, $obj_retVal = null)
    {
        $this->_lastErrorType = $int_errType;
        $this->_lastErrorMsg = $str_errMsg;

        if (YAPI::$exceptionsDisabled) {
            return $obj_retVal;
        }
        // throw an exception
        throw new YAPI_Exception($str_errMsg, $int_errType);
    }

    /**
     * Returns a short text that describes unambiguously the instance of the function in the form
     * TYPE(NAME)=SERIAL&#46;FUNCTIONID.
     * More precisely,
     * TYPE       is the type of the function,
     * NAME       it the name used for the first access to the function,
     * SERIAL     is the serial number of the module if the module is connected or "unresolved", and
     * FUNCTIONID is  the hardware identifier of the function if the module is connected.
     * For example, this method returns Relay(MyCustomName.relay1)=RELAYLO1-123456.relay1 if the
     * module is already connected or Relay(BadCustomeName.relay1)=unresolved if the module has
     * not yet been connected. This method does not trigger any USB or TCP transaction and can therefore be used in
     * a debugger.
     *
     * @return string  a string that describes the function
     *         (ex: Relay(MyCustomName.relay1)=RELAYLO1-123456.relay1)
     */
    public function describe()
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS && $resolve->result != $this->_func) {
            return $this->_className . "({$this->_func})=unresolved";
        }
        return $this->_className . "({$this->_func})={$resolve->result}";
    }

    /**
     * Returns the unique hardware identifier of the function in the form SERIAL.FUNCTIONID.
     * The unique hardware identifier is composed of the device serial
     * number and of the hardware identifier of the function (for example RELAYLO1-123456.relay1).
     *
     * @return string  a string that uniquely identifies the function (ex: RELAYLO1-123456.relay1)
     *
     * On failure, throws an exception or returns  YFunction.HARDWAREID_INVALID.
     */
    public function get_hardwareId()
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            $this->isOnline();
            $resolve = YAPI::resolveFunction($this->_className, $this->_func);
            if ($resolve->errorType != YAPI::SUCCESS) {
                return $this->_throw($resolve->errorType, $resolve->errorMsg, YFunction::HARDWAREID_INVALID);
            }
        }
        return $resolve->result;
    }

    /**
     * Returns the hardware identifier of the function, without reference to the module. For example
     * relay1
     *
     * @return string  a string that identifies the function (ex: relay1)
     *
     * On failure, throws an exception or returns  YFunction.FUNCTIONID_INVALID.
     */
    public function get_functionId()
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            $this->isOnline();
            $resolve = YAPI::resolveFunction($this->_className, $this->_func);
            if ($resolve->errorType != YAPI::SUCCESS) {
                return $this->_throw($resolve->errorType, $resolve->errorMsg, YFunction::FUNCTIONID_INVALID);
            }
        }
        return substr($resolve->result, strpos($resolve->result, '.') + 1);
    }

    /**
     * Returns a global identifier of the function in the format MODULE_NAME&#46;FUNCTION_NAME.
     * The returned string uses the logical names of the module and of the function if they are defined,
     * otherwise the serial number of the module and the hardware identifier of the function
     * (for example: MyCustomName.relay1)
     *
     * @return string  a string that uniquely identifies the function using logical names
     *         (ex: MyCustomName.relay1)
     *
     * On failure, throws an exception or returns  YFunction.FRIENDLYNAME_INVALID.
     */
    public function get_friendlyName()
    {
        $resolve = YAPI::getFriendlyNameFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            $this->isOnline();
            $resolve = YAPI::getFriendlyNameFunction($this->_className, $this->_func);
            if ($resolve->errorType != YAPI::SUCCESS) {
                return $this->_throw($resolve->errorType, $resolve->errorMsg, YFunction::FRIENDLYNAME_INVALID);
            }
        }
        return $resolve->result;
    }


    // Store and parse a an API request for current function
    //
    protected function _parse(YAPI_YReq $yreq, float $msValidity): void
    {
        // save the whole structure for backward-compatibility
        $yreq->result["_expiration"] = YAPI::GetTickCount() + $msValidity;
        $this->_serial = $yreq->deviceid;
        $this->_funId = $yreq->functionid;
        $this->_hwId = $yreq->hwid;
        $this->_cache = $yreq->result;
        // process each attribute in turn for class-oriented processing
        foreach ($yreq->result as $key => $val) {
            $this->_parseAttr($key, $val);
        }
        $this->_parserHelper();
    }

    // Return the value of an attribute from function cache, after reloading it from device if needed
    // Note: the function cache is a typed (parsed) cache, contrarily to the agnostic device cache
    protected function _getAttr(string $str_attr)
    {
        if ($this->_cache['_expiration'] <= YAPI::GetTickCount()) {
            // no valid cached value, reload from device
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI::SUCCESS) {
                return null;
            }
        }
        if (!isset($this->_cache[$str_attr])) {
            $this->_throw(YAPI::VERSION_MISMATCH, 'No such attribute $str_attr in function', null);
        }
        return $this->_cache[$str_attr];
    }

    // Return the value of an attribute from function cache, after loading it from device if never done
    protected function _getFixedAttr($str_attr)
    {
        if ($this->_cache['_expiration'] == 0) {
            // no cached value, load from device
            if ($this->load(YAPI::$defaultCacheValidity) != YAPI::SUCCESS) {
                return null;
            }
        }
        if (!isset($this->_cache[$str_attr])) {
            $this->_throw(YAPI::VERSION_MISMATCH, "No such attribute $str_attr in function", null);
        }
        return $this->_cache[$str_attr];
    }

    protected function _escapeAttr($str_newval)
    {
        // urlencode according to RFC 3986 instead of php default RFC 1738
        $safecodes = array('%21', '%23', '%24', '%27', '%28', '%29', '%2A', '%2C', '%2F', '%3A', '%3B', '%40', '%3F', '%5B', '%5D');
        $safechars = array('!', "#", "$", "'", "(", ")", '*', ",", "/", ":", ";", "@", "?", "[", "]");
        return str_replace($safecodes, $safechars, urlencode($str_newval));
    }


    // Change the value of an attribute on a device, and update cache on the fly
    // Note: the function cache is a typed (parsed) cache, contrarily to the agnostic device cache
    protected function _setAttr(string $str_attr, string $str_newval): int
    {
        if (!isset($str_newval)) {
            $this->_throw(YAPI::INVALID_ARGUMENT, "Undefined value to set for attribute $str_attr", null);
        }
        // urlencode according to RFC 3986 instead of php default RFC 1738
        $safecodes = array('%21', '%23', '%24', '%27', '%28', '%29', '%2A', '%2C', '%2F', '%3A', '%3B', '%40', '%3F', '%5B', '%5D');
        $safechars = array('!', "#", "$", "'", "(", ")", '*', ",", "/", ":", ";", "@", "?", "[", "]");
        $attrname = str_replace($safecodes, $safechars, urlencode($str_attr));
        $extra = "/$attrname?$attrname=" . $this->_escapeAttr($str_newval) . "&.";
        $yreq = YAPI::funcRequest($this->_className, $this->_func, $extra);
        if ($this->_cache['_expiration'] != 0) {
            $this->_cache['_expiration'] = YAPI::GetTickCount();
        }
        if ($yreq->errorType != YAPI::SUCCESS) {
            return $this->_throw($yreq->errorType, $yreq->errorMsg, $yreq->errorType);
        }
        return YAPI::SUCCESS;
    }

    // Execute an arbitrary HTTP GET request on the device and return the binary content
    //
    public function _download($str_path)
    {
        // get the device serial number
        $devid = $this->module()->get_serialNumber();
        if ($devid == YModule::SERIALNUMBER_INVALID) {
            return '';
        }
        $yreq = YAPI::devRequest($devid, "GET /$str_path");
        if ($yreq->errorType != YAPI::SUCCESS) {
            return $this->_throw($yreq->errorType, $yreq->errorMsg, '');
        }
        return $yreq->result;
    }

    // Upload a file to the filesystem, to the specified full path name.
    // If a file already exists with the same path name, its content is overwritten.
    //
    public function _upload($str_path, $bin_content)
    {
        // get the device serial number
        $devid = $this->module()->get_serialNumber();
        if ($devid == YModule::SERIALNUMBER_INVALID) {
            return $this->get_errorType();
        }
        if (is_array($bin_content)) {
            $bin_content = call_user_func_array('pack', array_merge(array("C*"), $bin_content));
        }
        $httpreq = 'POST /upload.html';
        $body = "Content-Disposition: form-data; name=\"$str_path\"; filename=\"api\"\r\n" .
            "Content-Type: application/octet-stream\r\n" .
            "Content-Transfer-Encoding: binary\r\n\r\n" . $bin_content;
        $yreq = YAPI::devRequest($devid, $httpreq, true, $body);
        if ($yreq->errorType != YAPI::SUCCESS) {
            return $yreq->errorType;
        }
        return YAPI::SUCCESS;
    }

    // Upload a file to the filesystem, to the specified full path name.
    // If a file already exists with the same path name, its content is overwritten.
    //
    public function _uploadEx($str_path, $bin_content)
    {
        // get the device serial number
        $devid = $this->module()->get_serialNumber();
        if ($devid == YModule::SERIALNUMBER_INVALID) {
            return $this->get_errorType();
        }
        if (is_array($bin_content)) {
            $bin_content = call_user_func_array('pack', array_merge(array("C*"), $bin_content));
        }
        $httpreq = 'POST /upload.html';
        $body = "Content-Disposition: form-data; name=\"$str_path\"; filename=\"api\"\r\n" .
            "Content-Type: application/octet-stream\r\n" .
            "Content-Transfer-Encoding: binary\r\n\r\n" . $bin_content;
        $yreq = YAPI::devRequest($devid, $httpreq, false, $body);
        if ($yreq->errorType != YAPI::SUCCESS) {
            return $this->_throw($yreq->errorType, $yreq->errorMsg, '');
        }
        return $yreq->result;
    }


    // Get a value from a JSON buffer
    //
    public function _json_get_key($bin_jsonbuff, $str_key)
    {
        $loadval = json_decode($bin_jsonbuff, true);
        if (isset($loadval[$str_key])) {
            return $loadval[$str_key];
        }
        return "";
    }

    // Get a string from a JSON buffer
    //
    public function _json_get_string($bin_jsonbuff)
    {
        return json_decode($bin_jsonbuff, true);
    }

    // Get an array of strings from a JSON buffer
    //
    public function _json_get_array($bin_jsonbuff)
    {
        $loadval = json_decode($bin_jsonbuff, true);
        $res = array();
        foreach ($loadval as $record) {
            $res[] = json_encode($record);
        }
        return $res;
    }

    public function _get_json_path($str_json, $path)
    {
        $json = json_decode($str_json, true);
        $paths = explode('|', $path);
        foreach ($paths as $key) {
            if (array_key_exists($key, $json)) {
                $json = $json[$key];
            } else {
                return '';
            }
        }
        return json_encode($json);
    }

    public function _decode_json_string($json)
    {
        $decoded = json_decode($json);
        return $decoded;
    }

    /**
     * Method used to cache DataStream objects (new DataLogger)
     * @param YDataSet $obj_dataset
     * @param string $str_def
     * @return YDataStream
     */
    public function _findDataStream($obj_dataset, $str_def)
    {
        $key = $obj_dataset->get_functionId() . ":" . $str_def;
        if (isset($this->_dataStreams[$key])) {
            return $this->_dataStreams[$key];
        }

        $words = YAPI::_decodeWords($str_def);
        if (sizeof($words) < 14) {
            $this->_throw(YAPI::VERSION_MISMATCH, "device firmware is too old");
            return null;
        }
        $newDataStream = new YDataStream($this, $obj_dataset, $words);
        $this->_dataStreams[$key] = $newDataStream;
        return $newDataStream;
    }

    // Method used to clear cache of DataStream object (undocumented)
    public function _clearDataStreamCache()
    {
        $this->_dataStreams = array();
    }


    public function _getValueCallback()
    {
        return $this->_valueCallbackFunction;
    }

    /**
     * Checks if the function is currently reachable, without raising any error.
     * If there is a cached value for the function in cache, that has not yet
     * expired, the device is considered reachable.
     * No exception is raised if there is an error while trying to contact the
     * device hosting the function.
     *
     * @return boolean  true if the function can be reached, and false otherwise
     */
    public function isOnline()
    {
        // A valid value in cache means that the device is online
        if ($this->_cache['_expiration'] > YAPI::GetTickCount()) {
            return true;
        }

        // Check that the function is available without throwing exceptions
        $yreq = YAPI::funcRequest($this->_className, $this->_func, '');
        if ($yreq->errorType != YAPI::SUCCESS) {
            return false;
        }
        // save result in cache anyway
        $this->_parse($yreq, YAPI::$defaultCacheValidity);

        return true;
    }

    /**
     * Returns the numerical error code of the latest error with the function.
     * This method is mostly useful when using the Yoctopuce library with
     * exceptions disabled.
     *
     * @return int  a number corresponding to the code of the latest error that occurred while
     *         using the function object
     */
    public function get_errorType()
    {
        return $this->_lastErrorType;
    }

    public function errorType()
    {
        return $this->_lastErrorType;
    }

    public function errType()
    {
        return $this->_lastErrorType;
    }

    /**
     * Returns the error message of the latest error with the function.
     * This method is mostly useful when using the Yoctopuce library with
     * exceptions disabled.
     *
     * @return string  a string corresponding to the latest error message that occured while
     *         using the function object
     */
    public function get_errorMessage()
    {
        return $this->_lastErrorMsg;
    }

    public function errorMessage()
    {
        return $this->_lastErrorMsg;
    }

    public function errMessage()
    {
        return $this->_lastErrorMsg;
    }

    /**
     * Preloads the function cache with a specified validity duration.
     * By default, whenever accessing a device, all function attributes
     * are kept in cache for the standard duration (5 ms). This method can be
     * used to temporarily mark the cache as valid for a longer period, in order
     * to reduce network traffic for instance.
     *
     * @param float $msValidity : an integer corresponding to the validity attributed to the
     *         loaded function parameters, in milliseconds
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function load(float $msValidity): int
    {
        $yreq = YAPI::funcRequest($this->_className, $this->_func, '');
        if ($yreq->errorType != YAPI::SUCCESS) {
            return $this->_throw($yreq->errorType, $yreq->errorMsg, $yreq->errorType);
        }
        $this->_parse($yreq, $msValidity);

        return YAPI::SUCCESS;
    }

    /**
     * Invalidates the cache. Invalidates the cache of the function attributes. Forces the
     * next call to get_xxx() or loadxxx() to use values that come from the device.
     *
     * @noreturn
     */
    public function clearCache()
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return;
        }
        $str_func = $resolve->result;
        $dotpos = strpos($str_func, '.');
        $devid = substr($str_func, 0, $dotpos);
        $funcid = substr($str_func, $dotpos + 1);
        $dev = YAPI::getDevice($devid);
        if (is_null($dev)) {
            return;
        }
        $dev->dropCache();
        if ($this->_cacheExpiration > 0) {
            $this->_cacheExpiration = YAPI::GetTickCount();
        }
    }

    /**
     * Gets the YModule object for the device on which the function is located.
     * If the function cannot be located on any module, the returned instance of
     * YModule is not shown as on-line.
     *
     * @return YModule  an instance of YModule
     */
    public function get_module()
    {
        // try to resolve the function name to a device id without query
        if ($this->_serial != '') {
            return YModule::FindModule($this->_serial . '.module');
        }
        $hwid = $this->_func;
        if (strpos($hwid, '.') === false) {
            $resolve = YAPI::resolveFunction($this->_className, $this->_func);
            if ($resolve->errorType == YAPI::SUCCESS) {
                $hwid = $resolve->result;
            }
        }
        $dotidx = strpos($hwid, '.');
        if ($dotidx !== false) {
            // resolution worked
            return YModule::FindModule(substr($hwid, 0, $dotidx) . '.module');
        }

        // device not resolved for now, force a communication for a last chance resolution
        if ($this->load(YAPI::$defaultCacheValidity) == YAPI::SUCCESS) {
            $resolve = YAPI::resolveFunction($this->_className, $this->_func);
            if ($resolve->errorType == YAPI::SUCCESS) {
                $hwid = $resolve->result;
            }
        }
        $dotidx = strpos($hwid, '.');
        if ($dotidx !== false) {
            // resolution worked
            return YModule::FindModule(substr($hwid, 0, $dotidx) . '.module');
        }
        // return a true YModule object even if it is not a module valid for communicating
        return YModule::FindModule('module_of_' . $this->_className . '_' . $this->_func);
    }

    public function module()
    {
        return $this->get_module();
    }

    /**
     * Returns a unique identifier of type YFUN_DESCR corresponding to the function.
     * This identifier can be used to test if two instances of YFunction reference the same
     * physical function on the same physical device.
     *
     * @return string  an identifier of type YFUN_DESCR.
     *
     * If the function has never been contacted, the returned value is Y$CLASSNAME$.FUNCTIONDESCRIPTOR_INVALID.
     */
    public function get_functionDescriptor()
    {
        // try to resolve the function name to a device id without query
        $hwid = $this->_func;
        if (strpos($hwid, '.') === false) {
            $resolve = YAPI::resolveFunction($this->_className, $this->_func);
            if ($resolve->errorType != YAPI::SUCCESS) {
                $hwid = $resolve->result;
            }
        }
        $dotidx = strpos($hwid, '.');
        if ($dotidx !== false) {
            // resolution worked
            return $hwid;
        }
        return YFunction::FUNCTIONDESCRIPTOR_INVALID;
    }

    public function getFunctionDescriptor()
    {
        return $this->get_functionDescriptor();
    }

    /**
     * Returns the value of the userData attribute, as previously stored using method
     * set_userData.
     * This attribute is never touched directly by the API, and is at disposal of the caller to
     * store a context.
     *
     * @return Object  the object stored previously by the caller.
     */
    public function get_userData()
    {
        return $this->_userData;
    }

    public function userData()
    {
        return $this->_userData;
    }

    /**
     * Stores a user context provided as argument in the userData attribute of the function.
     * This attribute is never touched by the API, and is at disposal of the caller to store a context.
     *
     * @param Object $data : any kind of object to be stored
     * @noreturn
     */
    public function set_userData($data)
    {
        $this->_userData = $data;
    }

    public function setUserData($data)
    {
        $this->_userData = $data;
    }
}

