<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YMicroPython Class: MicroPython interpreter control interface
 *
 * The YMicroPython class provides control of the MicroPython interpreter
 * that can be found on some Yoctopuce devices.
 */
class YMicroPython extends YFunction
{
    const LASTMSG_INVALID = YAPI::INVALID_STRING;
    const HEAPUSAGE_INVALID = YAPI::INVALID_UINT;
    const XHEAPUSAGE_INVALID = YAPI::INVALID_UINT;
    const CURRENTSCRIPT_INVALID = YAPI::INVALID_STRING;
    const STARTUPSCRIPT_INVALID = YAPI::INVALID_STRING;
    const DEBUGMODE_OFF = 0;
    const DEBUGMODE_ON = 1;
    const DEBUGMODE_INVALID = -1;
    const COMMAND_INVALID = YAPI::INVALID_STRING;
    //--- (end of YMicroPython declaration)

    //--- (YMicroPython attributes)
    protected string $_lastMsg = self::LASTMSG_INVALID;        // Text
    protected int $_heapUsage = self::HEAPUSAGE_INVALID;      // Percent
    protected int $_xheapUsage = self::XHEAPUSAGE_INVALID;     // Percent
    protected string $_currentScript = self::CURRENTSCRIPT_INVALID;  // Text
    protected string $_startupScript = self::STARTUPSCRIPT_INVALID;  // Text
    protected int $_debugMode = self::DEBUGMODE_INVALID;      // OnOff
    protected string $_command = self::COMMAND_INVALID;        // Text
    protected mixed $_logCallback = null;                         // YMicroPythonLogCallback
    protected bool $_isFirstCb = false;                        // bool
    protected int $_prevCbPos = 0;                            // int
    protected int $_logPos = 0;                            // int
    protected string $_prevPartialLog = "";                           // str

    //--- (end of YMicroPython attributes)

    function __construct(string $str_func)
    {
        //--- (YMicroPython constructor)
        parent::__construct($str_func);
        $this->_className = 'MicroPython';

        //--- (end of YMicroPython constructor)
    }

    //--- (YMicroPython implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'lastMsg':
            $this->_lastMsg = $val;
            return 1;
        case 'heapUsage':
            $this->_heapUsage = intval($val);
            return 1;
        case 'xheapUsage':
            $this->_xheapUsage = intval($val);
            return 1;
        case 'currentScript':
            $this->_currentScript = $val;
            return 1;
        case 'startupScript':
            $this->_startupScript = $val;
            return 1;
        case 'debugMode':
            $this->_debugMode = intval($val);
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the last message produced by a python script.
     *
     * @return string  a string corresponding to the last message produced by a python script
     *
     * On failure, throws an exception or returns YMicroPython::LASTMSG_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_lastMsg(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LASTMSG_INVALID;
            }
        }
        $res = $this->_lastMsg;
        return $res;
    }

    /**
     * Returns the percentage of micropython main memory in use,
     * as observed at the end of the last garbage collection.
     *
     * @return int  an integer corresponding to the percentage of micropython main memory in use,
     *         as observed at the end of the last garbage collection
     *
     * On failure, throws an exception or returns YMicroPython::HEAPUSAGE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_heapUsage(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::HEAPUSAGE_INVALID;
            }
        }
        $res = $this->_heapUsage;
        return $res;
    }

    /**
     * Returns the percentage of micropython external memory in use,
     * as observed at the end of the last garbage collection.
     *
     * @return int  an integer corresponding to the percentage of micropython external memory in use,
     *         as observed at the end of the last garbage collection
     *
     * On failure, throws an exception or returns YMicroPython::XHEAPUSAGE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_xheapUsage(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::XHEAPUSAGE_INVALID;
            }
        }
        $res = $this->_xheapUsage;
        return $res;
    }

    /**
     * Returns the name of currently active script, if any.
     *
     * @return string  a string corresponding to the name of currently active script, if any
     *
     * On failure, throws an exception or returns YMicroPython::CURRENTSCRIPT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_currentScript(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CURRENTSCRIPT_INVALID;
            }
        }
        $res = $this->_currentScript;
        return $res;
    }

    /**
     * Stops current running script, and/or selects a script to run immediately in a
     * fresh new environment. If the MicroPython interpreter is busy running a script,
     * this function will abort it immediately and reset the execution environment.
     * If a non-empty string is given as argument, the new script will be started.
     *
     * @param string $newval : a string
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_currentScript(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("currentScript", $rest_val);
    }

    /**
     * Returns the name of the script to run when the device is powered on.
     *
     * @return string  a string corresponding to the name of the script to run when the device is powered on
     *
     * On failure, throws an exception or returns YMicroPython::STARTUPSCRIPT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_startupScript(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::STARTUPSCRIPT_INVALID;
            }
        }
        $res = $this->_startupScript;
        return $res;
    }

    /**
     * Changes the script to run when the device is powered on.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param string $newval : a string corresponding to the script to run when the device is powered on
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_startupScript(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("startupScript", $rest_val);
    }

    /**
     * Returns the activation state of micropython debugging interface.
     *
     * @return int  either YMicroPython::DEBUGMODE_OFF or YMicroPython::DEBUGMODE_ON, according to the
     * activation state of micropython debugging interface
     *
     * On failure, throws an exception or returns YMicroPython::DEBUGMODE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_debugMode(): int
    {
        // $res                    is a enumONOFF;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DEBUGMODE_INVALID;
            }
        }
        $res = $this->_debugMode;
        return $res;
    }

    /**
     * Changes the activation state of micropython debugging interface.
     *
     * @param int $newval : either YMicroPython::DEBUGMODE_OFF or YMicroPython::DEBUGMODE_ON, according to
     * the activation state of micropython debugging interface
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_debugMode(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("debugMode", $rest_val);
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_command(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::COMMAND_INVALID;
            }
        }
        $res = $this->_command;
        return $res;
    }

    /**
     * @throws YAPI_Exception
     */
    public function set_command(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("command", $rest_val);
    }

    /**
     * Retrieves a MicroPython interpreter for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the MicroPython interpreter is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the MicroPython interpreter is
     * indeed online at a given time. In case of ambiguity when looking for
     * a MicroPython interpreter by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the MicroPython interpreter, for instance
     *         MyDevice.microPython.
     *
     * @return YMicroPython  a YMicroPython object allowing you to drive the MicroPython interpreter.
     */
    public static function FindMicroPython(string $func): YMicroPython
    {
        // $obj                    is a YMicroPython;
        $obj = YFunction::_FindFromCache('MicroPython', $func);
        if ($obj == null) {
            $obj = new YMicroPython($func);
            YFunction::_AddToCache('MicroPython', $func, $obj);
        }
        return $obj;
    }

    /**
     * Submit MicroPython code for execution in the interpreter.
     * If the MicroPython interpreter is busy, this function will
     * block until it becomes available. The code is then uploaded,
     * compiled and executed on the fly, without beeing stored on the device filesystem.
     *
     * There is no implicit reset of the MicroPython interpreter with
     * this function. Use method reset() if you need to start
     * from a fresh environment to run your code.
     *
     * Note that although MicroPython is mostly compatible with recent Python 3.x
     * interpreters, the limited ressources on the device impose some restrictions,
     * in particular regarding the libraries that can be used. Please refer to
     * the documentation for more details.
     *
     * @param string $codeName : name of the code file (used for error reporting only)
     * @param string $mpyCode : MicroPython code to compile and execute
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function eval(string $codeName, string $mpyCode): int
    {
        // $fullname               is a str;
        // $res                    is a int;
        $fullname = sprintf('mpy:%s', $codeName);
        $res = $this->_upload($fullname, YAPI::Ystr2bin($mpyCode));
        return $res;
    }

    /**
     * Stops current execution, and reset the MicroPython interpreter to initial state.
     * All global variables are cleared, and all imports are forgotten.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function reset(): int
    {
        // $res                    is a int;
        // $state                  is a str;

        $res = $this->set_command('Z');
        if (!($res == YAPI::SUCCESS)) return $this->_throw(YAPI::IO_ERROR,'unable to trigger MicroPython reset',YAPI::IO_ERROR);
        // Wait until the reset is effective
        $state = substr($this->get_advertisedValue(), 0, 1);
        while (!($state == 'z')) {
            YAPI::Sleep(50);
            $state = substr($this->get_advertisedValue(), 0, 1);
        }
        return YAPI::SUCCESS;
    }

    /**
     * Returns a string with last logs of the MicroPython interpreter.
     * This method return only logs that are still in the module.
     *
     * @return string  a string with last MicroPython logs.
     *         On failure, throws an exception or returns  YAPI::INVALID_STRING.
     * @throws YAPI_Exception on error
     */
    public function get_lastLogs(): string
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $res                    is a str;

        $buff = $this->_download('mpy.txt');
        $bufflen = strlen($buff) - 1;
        while (($bufflen > 0) && (ord($buff[$bufflen]) != 64)) {
            $bufflen = $bufflen - 1;
        }
        $res = substr(YAPI::Ybin2str($buff), 0, $bufflen);
        return $res;
    }

    /**
     * Registers a device log callback function. This callback will be called each time
     * microPython sends a new log message.
     *
     * @param callable $callback : the callback function to invoke, or a null pointer.
     *         The callback function should take two arguments:
     *         the module object that emitted the log message,
     *         and the character string containing the log.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function registerLogCallback(mixed $callback): int
    {
        // $serial                 is a str;

        $serial = $this->get_serialNumber();
        if ($serial == YAPI::INVALID_STRING) {
            return YAPI::DEVICE_NOT_FOUND;
        }
        $this->_logCallback = $callback;
        $this->_isFirstCb = true;
        if (!is_null($callback)) {
            $this->registerValueCallback('yInternalEventCallback');
        } else {
            $this->registerValueCallback(null);
        }
        return 0;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_logCallback(): mixed
    {
        return $this->_logCallback;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _internalEventHandler(string $cbVal): int
    {
        // $cbPos                  is a int;
        // $cbDPos                 is a int;
        // $url                    is a str;
        // $content                is a bin;
        // $endPos                 is a int;
        // $contentStr             is a str;
        $msgArr = [];           // strArr;
        // $arrLen                 is a int;
        // $lenStr                 is a str;
        // $arrPos                 is a int;
        // $logMsg                 is a str;
        // detect possible power cycle of the reader to clear event pointer
        $cbPos = hexdec(substr($cbVal, 1, mb_strlen($cbVal)-1));
        $cbDPos = (($cbPos - $this->_prevCbPos) & 0xfffff);
        $this->_prevCbPos = $cbPos;
        if ($cbDPos > 65536) {
            $this->_logPos = 0;
        }
        if (!(!is_null($this->_logCallback))) {
            return YAPI::SUCCESS;
        }
        if ($this->_isFirstCb) {
            // use first emulated value callback caused by registerValueCallback:
            // to retrieve current logs position
            $this->_logPos = 0;
            $this->_prevPartialLog = '';
            $url = 'mpy.txt';
        } else {
            // load all messages since previous call
            $url = sprintf('mpy.txt?pos=%d', $this->_logPos);
        }

        $content = $this->_download($url);
        $contentStr = YAPI::Ybin2str($content);
        // look for new position indicator at end of logs
        $endPos = strlen($content) - 1;
        while (($endPos >= 0) && (ord($content[$endPos]) != 64)) {
            $endPos = $endPos - 1;
        }
        if (!($endPos > 0)) return $this->_throw(YAPI::IO_ERROR,'fail to download micropython logs',YAPI::IO_ERROR);
        $lenStr = substr($contentStr, $endPos+1, mb_strlen($contentStr)-($endPos+1));
        // update processed event position pointer
        $this->_logPos = intVal($lenStr);
        if ($this->_isFirstCb) {
            // don't generate callbacks log messages before call to registerLogCallback
            $this->_isFirstCb = false;
            return YAPI::SUCCESS;
        }
        // now generate callbacks for each complete log line
        $endPos = $endPos - 1;
        if (!(ord($content[$endPos]) == 10)) return $this->_throw(YAPI::IO_ERROR,'fail to download micropython logs',YAPI::IO_ERROR);
        $contentStr = substr($contentStr, 0, $endPos);
        $msgArr = explode(''."\n".'', $contentStr);
        $arrLen = sizeof($msgArr) - 1;
        if ($arrLen > 0) {
            $logMsg = sprintf('%s%s', $this->_prevPartialLog, $msgArr[0]);
            if (!is_null($this->_logCallback)) {
                call_user_func($this->_logCallback, $this, $logMsg);
            }
            $this->_prevPartialLog = '';
            $arrPos = 1;
            while ($arrPos < $arrLen) {
                $logMsg = $msgArr[$arrPos];
                if (!is_null($this->_logCallback)) {
                    call_user_func($this->_logCallback, $this, $logMsg);
                }
                $arrPos = $arrPos + 1;
            }
        }
        $this->_prevPartialLog = sprintf('%s%s', $this->_prevPartialLog, $msgArr[$arrLen]);
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception
     */
    public function lastMsg(): string
{
    return $this->get_lastMsg();
}

    /**
     * @throws YAPI_Exception
     */
    public function heapUsage(): int
{
    return $this->get_heapUsage();
}

    /**
     * @throws YAPI_Exception
     */
    public function xheapUsage(): int
{
    return $this->get_xheapUsage();
}

    /**
     * @throws YAPI_Exception
     */
    public function currentScript(): string
{
    return $this->get_currentScript();
}

    /**
     * @throws YAPI_Exception
     */
    public function setCurrentScript(string $newval): int
{
    return $this->set_currentScript($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function startupScript(): string
{
    return $this->get_startupScript();
}

    /**
     * @throws YAPI_Exception
     */
    public function setStartupScript(string $newval): int
{
    return $this->set_startupScript($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function debugMode(): int
{
    return $this->get_debugMode();
}

    /**
     * @throws YAPI_Exception
     */
    public function setDebugMode(int $newval): int
{
    return $this->set_debugMode($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function command(): string
{
    return $this->get_command();
}

    /**
     * @throws YAPI_Exception
     */
    public function setCommand(string $newval): int
{
    return $this->set_command($newval);
}

    /**
     * Continues the enumeration of MicroPython interpreters started using yFirstMicroPython().
     * Caution: You can't make any assumption about the returned MicroPython interpreters order.
     * If you want to find a specific a MicroPython interpreter, use MicroPython.findMicroPython()
     * and a hardwareID or a logical name.
     *
     * @return ?YMicroPython  a pointer to a YMicroPython object, corresponding to
     *         a MicroPython interpreter currently online, or a null pointer
     *         if there are no more MicroPython interpreters to enumerate.
     */
    public function nextMicroPython(): ?YMicroPython
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindMicroPython($next_hwid);
    }

    /**
     * Starts the enumeration of MicroPython interpreters currently accessible.
     * Use the method YMicroPython::nextMicroPython() to iterate on
     * next MicroPython interpreters.
     *
     * @return ?YMicroPython  a pointer to a YMicroPython object, corresponding to
     *         the first MicroPython interpreter currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstMicroPython(): ?YMicroPython
    {
        $next_hwid = YAPI::getFirstHardwareId('MicroPython');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindMicroPython($next_hwid);
    }

    //--- (end of YMicroPython implementation)

}
