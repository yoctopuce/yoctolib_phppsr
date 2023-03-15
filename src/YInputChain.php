<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YInputChain Class: InputChain function interface
 *
 * The YInputChain class provides access to separate
 * digital inputs connected in a chain.
 */
class YInputChain extends YFunction
{
    const EXPECTEDNODES_INVALID = YAPI::INVALID_UINT;
    const DETECTEDNODES_INVALID = YAPI::INVALID_UINT;
    const LOOPBACKTEST_OFF = 0;
    const LOOPBACKTEST_ON = 1;
    const LOOPBACKTEST_INVALID = -1;
    const REFRESHRATE_INVALID = YAPI::INVALID_UINT;
    const BITCHAIN1_INVALID = YAPI::INVALID_STRING;
    const BITCHAIN2_INVALID = YAPI::INVALID_STRING;
    const BITCHAIN3_INVALID = YAPI::INVALID_STRING;
    const BITCHAIN4_INVALID = YAPI::INVALID_STRING;
    const BITCHAIN5_INVALID = YAPI::INVALID_STRING;
    const BITCHAIN6_INVALID = YAPI::INVALID_STRING;
    const BITCHAIN7_INVALID = YAPI::INVALID_STRING;
    const WATCHDOGPERIOD_INVALID = YAPI::INVALID_UINT;
    const CHAINDIAGS_INVALID = YAPI::INVALID_UINT;
    //--- (end of YInputChain declaration)

    //--- (YInputChain attributes)
    protected int $_expectedNodes = self::EXPECTEDNODES_INVALID;  // UInt31
    protected int $_detectedNodes = self::DETECTEDNODES_INVALID;  // UInt31
    protected int $_loopbackTest = self::LOOPBACKTEST_INVALID;   // OnOff
    protected int $_refreshRate = self::REFRESHRATE_INVALID;    // UInt31
    protected string $_bitChain1 = self::BITCHAIN1_INVALID;      // Text
    protected string $_bitChain2 = self::BITCHAIN2_INVALID;      // Text
    protected string $_bitChain3 = self::BITCHAIN3_INVALID;      // Text
    protected string $_bitChain4 = self::BITCHAIN4_INVALID;      // Text
    protected string $_bitChain5 = self::BITCHAIN5_INVALID;      // Text
    protected string $_bitChain6 = self::BITCHAIN6_INVALID;      // Text
    protected string $_bitChain7 = self::BITCHAIN7_INVALID;      // Text
    protected int $_watchdogPeriod = self::WATCHDOGPERIOD_INVALID; // UInt31
    protected int $_chainDiags = self::CHAINDIAGS_INVALID;     // InputChainDiags
    protected mixed $_eventCallback = null;                         // YEventCallback
    protected int $_prevPos = 0;                            // int
    protected int $_eventPos = 0;                            // int
    protected int $_eventStamp = 0;                            // int
    protected array $_eventChains = [];                           // strArr

    //--- (end of YInputChain attributes)

    function __construct(string $str_func)
    {
        //--- (YInputChain constructor)
        parent::__construct($str_func);
        $this->_className = 'InputChain';

        //--- (end of YInputChain constructor)
    }

    //--- (YInputChain implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'expectedNodes':
            $this->_expectedNodes = intval($val);
            return 1;
        case 'detectedNodes':
            $this->_detectedNodes = intval($val);
            return 1;
        case 'loopbackTest':
            $this->_loopbackTest = intval($val);
            return 1;
        case 'refreshRate':
            $this->_refreshRate = intval($val);
            return 1;
        case 'bitChain1':
            $this->_bitChain1 = $val;
            return 1;
        case 'bitChain2':
            $this->_bitChain2 = $val;
            return 1;
        case 'bitChain3':
            $this->_bitChain3 = $val;
            return 1;
        case 'bitChain4':
            $this->_bitChain4 = $val;
            return 1;
        case 'bitChain5':
            $this->_bitChain5 = $val;
            return 1;
        case 'bitChain6':
            $this->_bitChain6 = $val;
            return 1;
        case 'bitChain7':
            $this->_bitChain7 = $val;
            return 1;
        case 'watchdogPeriod':
            $this->_watchdogPeriod = intval($val);
            return 1;
        case 'chainDiags':
            $this->_chainDiags = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the number of nodes expected in the chain.
     *
     * @return int  an integer corresponding to the number of nodes expected in the chain
     *
     * On failure, throws an exception or returns YInputChain::EXPECTEDNODES_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_expectedNodes(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::EXPECTEDNODES_INVALID;
            }
        }
        $res = $this->_expectedNodes;
        return $res;
    }

    /**
     * Changes the number of nodes expected in the chain.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param int $newval : an integer corresponding to the number of nodes expected in the chain
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_expectedNodes(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("expectedNodes", $rest_val);
    }

    /**
     * Returns the number of nodes detected in the chain.
     *
     * @return int  an integer corresponding to the number of nodes detected in the chain
     *
     * On failure, throws an exception or returns YInputChain::DETECTEDNODES_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_detectedNodes(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DETECTEDNODES_INVALID;
            }
        }
        $res = $this->_detectedNodes;
        return $res;
    }

    /**
     * Returns the activation state of the exhaustive chain connectivity test.
     * The connectivity test requires a cable connecting the end of the chain
     * to the loopback test connector.
     *
     * @return int  either YInputChain::LOOPBACKTEST_OFF or YInputChain::LOOPBACKTEST_ON, according to the
     * activation state of the exhaustive chain connectivity test
     *
     * On failure, throws an exception or returns YInputChain::LOOPBACKTEST_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_loopbackTest(): int
    {
        // $res                    is a enumONOFF;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LOOPBACKTEST_INVALID;
            }
        }
        $res = $this->_loopbackTest;
        return $res;
    }

    /**
     * Changes the activation state of the exhaustive chain connectivity test.
     * The connectivity test requires a cable connecting the end of the chain
     * to the loopback test connector.
     *
     * @param int $newval : either YInputChain::LOOPBACKTEST_OFF or YInputChain::LOOPBACKTEST_ON, according
     * to the activation state of the exhaustive chain connectivity test
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_loopbackTest(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("loopbackTest", $rest_val);
    }

    /**
     * Returns the desired refresh rate, measured in Hz.
     * The higher the refresh rate is set, the higher the
     * communication speed on the chain will be.
     *
     * @return int  an integer corresponding to the desired refresh rate, measured in Hz
     *
     * On failure, throws an exception or returns YInputChain::REFRESHRATE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_refreshRate(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::REFRESHRATE_INVALID;
            }
        }
        $res = $this->_refreshRate;
        return $res;
    }

    /**
     * Changes the desired refresh rate, measured in Hz.
     * The higher the refresh rate is set, the higher the
     * communication speed on the chain will be.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param int $newval : an integer corresponding to the desired refresh rate, measured in Hz
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_refreshRate(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("refreshRate", $rest_val);
    }

    /**
     * Returns the state of input 1 for all nodes of the input chain,
     * as a hexadecimal string. The node nearest to the controller
     * is the lowest bit of the result.
     *
     * @return string  a string corresponding to the state of input 1 for all nodes of the input chain,
     *         as a hexadecimal string
     *
     * On failure, throws an exception or returns YInputChain::BITCHAIN1_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_bitChain1(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::BITCHAIN1_INVALID;
            }
        }
        $res = $this->_bitChain1;
        return $res;
    }

    /**
     * Returns the state of input 2 for all nodes of the input chain,
     * as a hexadecimal string. The node nearest to the controller
     * is the lowest bit of the result.
     *
     * @return string  a string corresponding to the state of input 2 for all nodes of the input chain,
     *         as a hexadecimal string
     *
     * On failure, throws an exception or returns YInputChain::BITCHAIN2_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_bitChain2(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::BITCHAIN2_INVALID;
            }
        }
        $res = $this->_bitChain2;
        return $res;
    }

    /**
     * Returns the state of input 3 for all nodes of the input chain,
     * as a hexadecimal string. The node nearest to the controller
     * is the lowest bit of the result.
     *
     * @return string  a string corresponding to the state of input 3 for all nodes of the input chain,
     *         as a hexadecimal string
     *
     * On failure, throws an exception or returns YInputChain::BITCHAIN3_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_bitChain3(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::BITCHAIN3_INVALID;
            }
        }
        $res = $this->_bitChain3;
        return $res;
    }

    /**
     * Returns the state of input 4 for all nodes of the input chain,
     * as a hexadecimal string. The node nearest to the controller
     * is the lowest bit of the result.
     *
     * @return string  a string corresponding to the state of input 4 for all nodes of the input chain,
     *         as a hexadecimal string
     *
     * On failure, throws an exception or returns YInputChain::BITCHAIN4_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_bitChain4(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::BITCHAIN4_INVALID;
            }
        }
        $res = $this->_bitChain4;
        return $res;
    }

    /**
     * Returns the state of input 5 for all nodes of the input chain,
     * as a hexadecimal string. The node nearest to the controller
     * is the lowest bit of the result.
     *
     * @return string  a string corresponding to the state of input 5 for all nodes of the input chain,
     *         as a hexadecimal string
     *
     * On failure, throws an exception or returns YInputChain::BITCHAIN5_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_bitChain5(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::BITCHAIN5_INVALID;
            }
        }
        $res = $this->_bitChain5;
        return $res;
    }

    /**
     * Returns the state of input 6 for all nodes of the input chain,
     * as a hexadecimal string. The node nearest to the controller
     * is the lowest bit of the result.
     *
     * @return string  a string corresponding to the state of input 6 for all nodes of the input chain,
     *         as a hexadecimal string
     *
     * On failure, throws an exception or returns YInputChain::BITCHAIN6_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_bitChain6(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::BITCHAIN6_INVALID;
            }
        }
        $res = $this->_bitChain6;
        return $res;
    }

    /**
     * Returns the state of input 7 for all nodes of the input chain,
     * as a hexadecimal string. The node nearest to the controller
     * is the lowest bit of the result.
     *
     * @return string  a string corresponding to the state of input 7 for all nodes of the input chain,
     *         as a hexadecimal string
     *
     * On failure, throws an exception or returns YInputChain::BITCHAIN7_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_bitChain7(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::BITCHAIN7_INVALID;
            }
        }
        $res = $this->_bitChain7;
        return $res;
    }

    /**
     * Returns the wait time in seconds before triggering an inactivity
     * timeout error.
     *
     * @return int  an integer corresponding to the wait time in seconds before triggering an inactivity
     *         timeout error
     *
     * On failure, throws an exception or returns YInputChain::WATCHDOGPERIOD_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_watchdogPeriod(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::WATCHDOGPERIOD_INVALID;
            }
        }
        $res = $this->_watchdogPeriod;
        return $res;
    }

    /**
     * Changes the wait time in seconds before triggering an inactivity
     * timeout error. Remember to call the saveToFlash() method
     * of the module if the modification must be kept.
     *
     * @param int $newval : an integer corresponding to the wait time in seconds before triggering an inactivity
     *         timeout error
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_watchdogPeriod(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("watchdogPeriod", $rest_val);
    }

    /**
     * Returns the controller state diagnostics. Bit 0 indicates a chain length
     * error, bit 1 indicates an inactivity timeout and bit 2 indicates
     * a loopback test failure.
     *
     * @return int  an integer corresponding to the controller state diagnostics
     *
     * On failure, throws an exception or returns YInputChain::CHAINDIAGS_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_chainDiags(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CHAINDIAGS_INVALID;
            }
        }
        $res = $this->_chainDiags;
        return $res;
    }

    /**
     * Retrieves a digital input chain for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the digital input chain is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the digital input chain is
     * indeed online at a given time. In case of ambiguity when looking for
     * a digital input chain by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the digital input chain, for instance
     *         MyDevice.inputChain.
     *
     * @return YInputChain  a YInputChain object allowing you to drive the digital input chain.
     */
    public static function FindInputChain(string $func): YInputChain
    {
        // $obj                    is a YInputChain;
        $obj = YFunction::_FindFromCache('InputChain', $func);
        if ($obj == null) {
            $obj = new YInputChain($func);
            YFunction::_AddToCache('InputChain', $func, $obj);
        }
        return $obj;
    }

    /**
     * Resets the application watchdog countdown.
     * If you have setup a non-zero watchdogPeriod, you should
     * call this function on a regular basis to prevent the application
     * inactivity error to be triggered.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function resetWatchdog(): int
    {
        return $this->set_watchdogPeriod(-1);
    }

    /**
     * Returns a string with last events observed on the digital input chain.
     * This method return only events that are still buffered in the device memory.
     *
     * @return string  a string with last events observed (one per line).
     *
     * On failure, throws an exception or returns  YAPI::INVALID_STRING.
     * @throws YAPI_Exception on error
     */
    public function get_lastEvents(): string
    {
        // $content                is a bin;

        $content = $this->_download('events.txt');
        return $content;
    }

    /**
     * Registers a callback function to be called each time that an event is detected on the
     * input chain.The callback is invoked only during the execution of
     * ySleep or yHandleEvents. This provides control over the time when
     * the callback is triggered. For good responsiveness, remember to call one of these
     * two functions periodically. To unregister a callback, pass a null pointer as argument.
     *
     * @param callable $callback : the callback function to call, or a null pointer.
     *         The callback function should take four arguments:
     *         the YInputChain object that emitted the event, the
     *         UTC timestamp of the event, a character string describing
     *         the type of event and a character string with the event data.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function registerEventCallback(mixed $callback): int
    {
        if (!is_null($callback)) {
            $this->registerValueCallback('yInternalEventCallback');
        } else {
            $this->registerValueCallback(null);
        }
        // register user callback AFTER the internal pseudo-event,
        // to make sure we start with future events only
        $this->_eventCallback = $callback;
        return 0;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _internalEventHandler(string $cbpos): int
    {
        // $newPos                 is a int;
        // $url                    is a str;
        // $content                is a bin;
        // $contentStr             is a str;
        $eventArr = [];         // strArr;
        // $arrLen                 is a int;
        // $lenStr                 is a str;
        // $arrPos                 is a int;
        // $eventStr               is a str;
        // $eventLen               is a int;
        // $hexStamp               is a str;
        // $typePos                is a int;
        // $dataPos                is a int;
        // $evtStamp               is a int;
        // $evtType                is a str;
        // $evtData                is a str;
        // $evtChange              is a str;
        // $chainIdx               is a int;
        $newPos = intVal($cbpos);
        if ($newPos < $this->_prevPos) {
            $this->_eventPos = 0;
        }
        $this->_prevPos = $newPos;
        if ($newPos < $this->_eventPos) {
            return YAPI::SUCCESS;
        }
        if (!(!is_null($this->_eventCallback))) {
            // first simulated event, use it to initialize reference values
            $this->_eventPos = $newPos;
            while (sizeof($this->_eventChains) > 0) {
                array_pop($this->_eventChains);
            };
            $this->_eventChains[] = $this->get_bitChain1();
            $this->_eventChains[] = $this->get_bitChain2();
            $this->_eventChains[] = $this->get_bitChain3();
            $this->_eventChains[] = $this->get_bitChain4();
            $this->_eventChains[] = $this->get_bitChain5();
            $this->_eventChains[] = $this->get_bitChain6();
            $this->_eventChains[] = $this->get_bitChain7();
            return YAPI::SUCCESS;
        }
        $url = sprintf('events.txt?pos=%d', $this->_eventPos);

        $content = $this->_download($url);
        $contentStr = $content;
        $eventArr = explode(''."\n".'', $contentStr);
        $arrLen = sizeof($eventArr);
        if (!($arrLen > 0)) return $this->_throw( YAPI::IO_ERROR, 'fail to download events',YAPI::IO_ERROR);
        // last element of array is the new position preceeded by '@'
        $arrLen = $arrLen - 1;
        $lenStr = $eventArr[$arrLen];
        $lenStr = substr($lenStr,  1, strlen($lenStr)-1);
        // update processed event position pointer
        $this->_eventPos = intVal($lenStr);
        // now generate callbacks for each event received
        $arrPos = 0;
        while ($arrPos < $arrLen) {
            $eventStr = $eventArr[$arrPos];
            $eventLen = strlen($eventStr);
            if ($eventLen >= 1) {
                $hexStamp = substr($eventStr,  0, 8);
                $evtStamp = hexdec($hexStamp);
                $typePos = YAPI::Ystrpos($eventStr,':')+1;
                if (($evtStamp >= $this->_eventStamp) && ($typePos > 8)) {
                    $this->_eventStamp = $evtStamp;
                    $dataPos = YAPI::Ystrpos($eventStr,'=')+1;
                    $evtType = substr($eventStr,  $typePos, 1);
                    $evtData = '';
                    $evtChange = '';
                    if ($dataPos > 10) {
                        $evtData = substr($eventStr,  $dataPos, strlen($eventStr)-$dataPos);
                        if (YAPI::Ystrpos('1234567',$evtType) >= 0) {
                            $chainIdx = intVal($evtType) - 1;
                            $evtChange = $this->_strXor($evtData, $this->_eventChains[$chainIdx]);
                            $this->_eventChains[$chainIdx] = $evtData;
                        }
                    }
                    call_user_func($this->_eventCallback, $this, $evtStamp, $evtType, $evtData, $evtChange);
                }
            }
            $arrPos = $arrPos + 1;
        }
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _strXor(string $a, string $b): string
    {
        // $lenA                   is a int;
        // $lenB                   is a int;
        // $res                    is a str;
        // $idx                    is a int;
        // $digitA                 is a int;
        // $digitB                 is a int;
        // make sure the result has the same length as first argument
        $lenA = strlen($a);
        $lenB = strlen($b);
        if ($lenA > $lenB) {
            $res = substr($a,  0, $lenA-$lenB);
            $a = substr($a,  $lenA-$lenB, $lenB);
            $lenA = $lenB;
        } else {
            $res = '';
            $b = substr($b,  $lenA-$lenB, $lenA);
        }
        // scan strings and compare digit by digit
        $idx = 0;
        while ($idx < $lenA) {
            $digitA = hexdec(substr($a,  $idx, 1));
            $digitB = hexdec(substr($b,  $idx, 1));
            $res = sprintf('%s%x', $res, (($digitA) ^ ($digitB)));
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function hex2array(string $hexstr): array
    {
        // $hexlen                 is a int;
        $res = [];              // intArr;
        // $idx                    is a int;
        // $digit                  is a int;
        $hexlen = strlen($hexstr);
        while (sizeof($res) > 0) {
            array_pop($res);
        };
        $idx = $hexlen;
        while ($idx > 0) {
            $idx = $idx - 1;
            $digit = hexdec(substr($hexstr,  $idx, 1));
            $res[] = (($digit) & (1));
            $res[] = (((($digit) >> (1))) & (1));
            $res[] = (((($digit) >> (2))) & (1));
            $res[] = (((($digit) >> (3))) & (1));
        }
        return $res;
    }

    /**
     * @throws YAPI_Exception
     */
    public function expectedNodes(): int
{
    return $this->get_expectedNodes();
}

    /**
     * @throws YAPI_Exception
     */
    public function setExpectedNodes(int $newval): int
{
    return $this->set_expectedNodes($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function detectedNodes(): int
{
    return $this->get_detectedNodes();
}

    /**
     * @throws YAPI_Exception
     */
    public function loopbackTest(): int
{
    return $this->get_loopbackTest();
}

    /**
     * @throws YAPI_Exception
     */
    public function setLoopbackTest(int $newval): int
{
    return $this->set_loopbackTest($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function refreshRate(): int
{
    return $this->get_refreshRate();
}

    /**
     * @throws YAPI_Exception
     */
    public function setRefreshRate(int $newval): int
{
    return $this->set_refreshRate($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function bitChain1(): string
{
    return $this->get_bitChain1();
}

    /**
     * @throws YAPI_Exception
     */
    public function bitChain2(): string
{
    return $this->get_bitChain2();
}

    /**
     * @throws YAPI_Exception
     */
    public function bitChain3(): string
{
    return $this->get_bitChain3();
}

    /**
     * @throws YAPI_Exception
     */
    public function bitChain4(): string
{
    return $this->get_bitChain4();
}

    /**
     * @throws YAPI_Exception
     */
    public function bitChain5(): string
{
    return $this->get_bitChain5();
}

    /**
     * @throws YAPI_Exception
     */
    public function bitChain6(): string
{
    return $this->get_bitChain6();
}

    /**
     * @throws YAPI_Exception
     */
    public function bitChain7(): string
{
    return $this->get_bitChain7();
}

    /**
     * @throws YAPI_Exception
     */
    public function watchdogPeriod(): int
{
    return $this->get_watchdogPeriod();
}

    /**
     * @throws YAPI_Exception
     */
    public function setWatchdogPeriod(int $newval): int
{
    return $this->set_watchdogPeriod($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function chainDiags(): int
{
    return $this->get_chainDiags();
}

    /**
     * Continues the enumeration of digital input chains started using yFirstInputChain().
     * Caution: You can't make any assumption about the returned digital input chains order.
     * If you want to find a specific a digital input chain, use InputChain.findInputChain()
     * and a hardwareID or a logical name.
     *
     * @return ?YInputChain  a pointer to a YInputChain object, corresponding to
     *         a digital input chain currently online, or a null pointer
     *         if there are no more digital input chains to enumerate.
     */
    public function nextInputChain(): ?YInputChain
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindInputChain($next_hwid);
    }

    /**
     * Starts the enumeration of digital input chains currently accessible.
     * Use the method YInputChain::nextInputChain() to iterate on
     * next digital input chains.
     *
     * @return ?YInputChain  a pointer to a YInputChain object, corresponding to
     *         the first digital input chain currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstInputChain(): ?YInputChain
    {
        $next_hwid = YAPI::getFirstHardwareId('InputChain');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindInputChain($next_hwid);
    }

    //--- (end of YInputChain implementation)

}
