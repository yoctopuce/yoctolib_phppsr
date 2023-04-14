<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YRealTimeClock Class: real-time clock control interface, available for instance in the
 * YoctoHub-GSM-4G, the YoctoHub-Wireless-SR, the YoctoHub-Wireless-g or the YoctoHub-Wireless-n
 *
 * The YRealTimeClock class provide access to the embedded real-time clock available on some Yoctopuce
 * devices. It can provide current date and time, even after a power outage
 * lasting several days. It is the base for automated wake-up functions provided by the WakeUpScheduler.
 * The current time may represent a local time as well as an UTC time, but no automatic time change
 * will occur to account for daylight saving time.
 */
class YRealTimeClock extends YFunction
{
    const UNIXTIME_INVALID = YAPI::INVALID_LONG;
    const DATETIME_INVALID = YAPI::INVALID_STRING;
    const UTCOFFSET_INVALID = YAPI::INVALID_INT;
    const TIMESET_FALSE = 0;
    const TIMESET_TRUE = 1;
    const TIMESET_INVALID = -1;
    const DISABLEHOSTSYNC_FALSE = 0;
    const DISABLEHOSTSYNC_TRUE = 1;
    const DISABLEHOSTSYNC_INVALID = -1;
    //--- (end of YRealTimeClock declaration)

    //--- (YRealTimeClock attributes)
    protected float $_unixTime = self::UNIXTIME_INVALID;       // UTCTime
    protected string $_dateTime = self::DATETIME_INVALID;       // Text
    protected int $_utcOffset = self::UTCOFFSET_INVALID;      // Int
    protected int $_timeSet = self::TIMESET_INVALID;        // Bool
    protected int $_disableHostSync = self::DISABLEHOSTSYNC_INVALID; // Bool

    //--- (end of YRealTimeClock attributes)

    function __construct(string $str_func)
    {
        //--- (YRealTimeClock constructor)
        parent::__construct($str_func);
        $this->_className = 'RealTimeClock';

        //--- (end of YRealTimeClock constructor)
    }

    //--- (YRealTimeClock implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'unixTime':
            $this->_unixTime = intval($val);
            return 1;
        case 'dateTime':
            $this->_dateTime = $val;
            return 1;
        case 'utcOffset':
            $this->_utcOffset = intval($val);
            return 1;
        case 'timeSet':
            $this->_timeSet = intval($val);
            return 1;
        case 'disableHostSync':
            $this->_disableHostSync = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the current time in Unix format (number of elapsed seconds since Jan 1st, 1970).
     *
     * @return float  an integer corresponding to the current time in Unix format (number of elapsed
     * seconds since Jan 1st, 1970)
     *
     * On failure, throws an exception or returns YRealTimeClock::UNIXTIME_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_unixTime(): float
    {
        // $res                    is a long;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::UNIXTIME_INVALID;
            }
        }
        $res = $this->_unixTime;
        return $res;
    }

    /**
     * Changes the current time. Time is specifid in Unix format (number of elapsed seconds since Jan 1st, 1970).
     *
     * @param float $newval : an integer corresponding to the current time
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_unixTime(float $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("unixTime", $rest_val);
    }

    /**
     * Returns the current time in the form "YYYY/MM/DD hh:mm:ss".
     *
     * @return string  a string corresponding to the current time in the form "YYYY/MM/DD hh:mm:ss"
     *
     * On failure, throws an exception or returns YRealTimeClock::DATETIME_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_dateTime(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DATETIME_INVALID;
            }
        }
        $res = $this->_dateTime;
        return $res;
    }

    /**
     * Returns the number of seconds between current time and UTC time (time zone).
     *
     * @return int  an integer corresponding to the number of seconds between current time and UTC time (time zone)
     *
     * On failure, throws an exception or returns YRealTimeClock::UTCOFFSET_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_utcOffset(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::UTCOFFSET_INVALID;
            }
        }
        $res = $this->_utcOffset;
        return $res;
    }

    /**
     * Changes the number of seconds between current time and UTC time (time zone).
     * The timezone is automatically rounded to the nearest multiple of 15 minutes.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param int $newval : an integer corresponding to the number of seconds between current time and UTC
     * time (time zone)
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_utcOffset(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("utcOffset", $rest_val);
    }

    /**
     * Returns true if the clock has been set, and false otherwise.
     *
     * @return int  either YRealTimeClock::TIMESET_FALSE or YRealTimeClock::TIMESET_TRUE, according to true
     * if the clock has been set, and false otherwise
     *
     * On failure, throws an exception or returns YRealTimeClock::TIMESET_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_timeSet(): int
    {
        // $res                    is a enumBOOL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::TIMESET_INVALID;
            }
        }
        $res = $this->_timeSet;
        return $res;
    }

    /**
     * Returns true if the automatic clock synchronization with host has been disabled,
     * and false otherwise.
     *
     * @return int  either YRealTimeClock::DISABLEHOSTSYNC_FALSE or YRealTimeClock::DISABLEHOSTSYNC_TRUE,
     * according to true if the automatic clock synchronization with host has been disabled,
     *         and false otherwise
     *
     * On failure, throws an exception or returns YRealTimeClock::DISABLEHOSTSYNC_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_disableHostSync(): int
    {
        // $res                    is a enumBOOL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DISABLEHOSTSYNC_INVALID;
            }
        }
        $res = $this->_disableHostSync;
        return $res;
    }

    /**
     * Changes the automatic clock synchronization with host working state.
     * To disable automatic synchronization, set the value to true.
     * To enable automatic synchronization (default), set the value to false.
     *
     * If you want the change to be kept after a device reboot,
     * make sure  to call the matching module saveToFlash().
     *
     * @param int $newval : either YRealTimeClock::DISABLEHOSTSYNC_FALSE or
     * YRealTimeClock::DISABLEHOSTSYNC_TRUE, according to the automatic clock synchronization with host working state
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_disableHostSync(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("disableHostSync", $rest_val);
    }

    /**
     * Retrieves a real-time clock for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the real-time clock is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the real-time clock is
     * indeed online at a given time. In case of ambiguity when looking for
     * a real-time clock by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the real-time clock, for instance
     *         YHUBGSM5.realTimeClock.
     *
     * @return YRealTimeClock  a YRealTimeClock object allowing you to drive the real-time clock.
     */
    public static function FindRealTimeClock(string $func): YRealTimeClock
    {
        // $obj                    is a YRealTimeClock;
        $obj = YFunction::_FindFromCache('RealTimeClock', $func);
        if ($obj == null) {
            $obj = new YRealTimeClock($func);
            YFunction::_AddToCache('RealTimeClock', $func, $obj);
        }
        return $obj;
    }

    /**
     * @throws YAPI_Exception
     */
    public function unixTime(): float
{
    return $this->get_unixTime();
}

    /**
     * @throws YAPI_Exception
     */
    public function setUnixTime(float $newval): int
{
    return $this->set_unixTime($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function dateTime(): string
{
    return $this->get_dateTime();
}

    /**
     * @throws YAPI_Exception
     */
    public function utcOffset(): int
{
    return $this->get_utcOffset();
}

    /**
     * @throws YAPI_Exception
     */
    public function setUtcOffset(int $newval): int
{
    return $this->set_utcOffset($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function timeSet(): int
{
    return $this->get_timeSet();
}

    /**
     * @throws YAPI_Exception
     */
    public function disableHostSync(): int
{
    return $this->get_disableHostSync();
}

    /**
     * @throws YAPI_Exception
     */
    public function setDisableHostSync(int $newval): int
{
    return $this->set_disableHostSync($newval);
}

    /**
     * Continues the enumeration of real-time clocks started using yFirstRealTimeClock().
     * Caution: You can't make any assumption about the returned real-time clocks order.
     * If you want to find a specific a real-time clock, use RealTimeClock.findRealTimeClock()
     * and a hardwareID or a logical name.
     *
     * @return ?YRealTimeClock  a pointer to a YRealTimeClock object, corresponding to
     *         a real-time clock currently online, or a null pointer
     *         if there are no more real-time clocks to enumerate.
     */
    public function nextRealTimeClock(): ?YRealTimeClock
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindRealTimeClock($next_hwid);
    }

    /**
     * Starts the enumeration of real-time clocks currently accessible.
     * Use the method YRealTimeClock::nextRealTimeClock() to iterate on
     * next real-time clocks.
     *
     * @return ?YRealTimeClock  a pointer to a YRealTimeClock object, corresponding to
     *         the first real-time clock currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstRealTimeClock(): ?YRealTimeClock
    {
        $next_hwid = YAPI::getFirstHardwareId('RealTimeClock');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindRealTimeClock($next_hwid);
    }

    //--- (end of YRealTimeClock implementation)

}
