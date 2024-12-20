<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YWakeUpSchedule Class: wake up schedule control interface, available for instance in the
 * YoctoHub-GSM-4G, the YoctoHub-Wireless-SR, the YoctoHub-Wireless-g or the YoctoHub-Wireless-n
 *
 * The YWakeUpSchedule class implements a wake up condition. The wake up time is
 * specified as a set of months and/or days and/or hours and/or minutes when the
 * wake up should happen.
 */
class YWakeUpSchedule extends YFunction
{
    const MINUTESA_INVALID = YAPI::INVALID_UINT;
    const MINUTESB_INVALID = YAPI::INVALID_UINT;
    const HOURS_INVALID = YAPI::INVALID_UINT;
    const WEEKDAYS_INVALID = YAPI::INVALID_UINT;
    const MONTHDAYS_INVALID = YAPI::INVALID_UINT;
    const MONTHS_INVALID = YAPI::INVALID_UINT;
    const SECONDSBEFORE_INVALID = YAPI::INVALID_UINT;
    const NEXTOCCURENCE_INVALID = YAPI::INVALID_LONG;
    //--- (end of YWakeUpSchedule declaration)

    //--- (YWakeUpSchedule attributes)
    protected int $_minutesA = self::MINUTESA_INVALID;       // MinOfHalfHourBits
    protected int $_minutesB = self::MINUTESB_INVALID;       // MinOfHalfHourBits
    protected int $_hours = self::HOURS_INVALID;          // HoursOfDayBits
    protected int $_weekDays = self::WEEKDAYS_INVALID;       // DaysOfWeekBits
    protected int $_monthDays = self::MONTHDAYS_INVALID;      // DaysOfMonthBits
    protected int $_months = self::MONTHS_INVALID;         // MonthsOfYearBits
    protected int $_secondsBefore = self::SECONDSBEFORE_INVALID;  // UInt31
    protected float $_nextOccurence = self::NEXTOCCURENCE_INVALID;  // UTCTime

    //--- (end of YWakeUpSchedule attributes)

    function __construct(string $str_func)
    {
        //--- (YWakeUpSchedule constructor)
        parent::__construct($str_func);
        $this->_className = 'WakeUpSchedule';

        //--- (end of YWakeUpSchedule constructor)
    }

    //--- (YWakeUpSchedule implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'minutesA':
            $this->_minutesA = intval($val);
            return 1;
        case 'minutesB':
            $this->_minutesB = intval($val);
            return 1;
        case 'hours':
            $this->_hours = intval($val);
            return 1;
        case 'weekDays':
            $this->_weekDays = intval($val);
            return 1;
        case 'monthDays':
            $this->_monthDays = intval($val);
            return 1;
        case 'months':
            $this->_months = intval($val);
            return 1;
        case 'secondsBefore':
            $this->_secondsBefore = intval($val);
            return 1;
        case 'nextOccurence':
            $this->_nextOccurence = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the minutes in the 00-29 interval of each hour scheduled for wake up.
     *
     * @return int  an integer corresponding to the minutes in the 00-29 interval of each hour scheduled for wake up
     *
     * On failure, throws an exception or returns YWakeUpSchedule::MINUTESA_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_minutesA(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::MINUTESA_INVALID;
            }
        }
        $res = $this->_minutesA;
        return $res;
    }

    /**
     * Changes the minutes in the 00-29 interval when a wake up must take place.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param int $newval : an integer corresponding to the minutes in the 00-29 interval when a wake up
     * must take place
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_minutesA(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("minutesA", $rest_val);
    }

    /**
     * Returns the minutes in the 30-59 interval of each hour scheduled for wake up.
     *
     * @return int  an integer corresponding to the minutes in the 30-59 interval of each hour scheduled for wake up
     *
     * On failure, throws an exception or returns YWakeUpSchedule::MINUTESB_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_minutesB(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::MINUTESB_INVALID;
            }
        }
        $res = $this->_minutesB;
        return $res;
    }

    /**
     * Changes the minutes in the 30-59 interval when a wake up must take place.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param int $newval : an integer corresponding to the minutes in the 30-59 interval when a wake up
     * must take place
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_minutesB(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("minutesB", $rest_val);
    }

    /**
     * Returns the hours scheduled for wake up.
     *
     * @return int  an integer corresponding to the hours scheduled for wake up
     *
     * On failure, throws an exception or returns YWakeUpSchedule::HOURS_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_hours(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::HOURS_INVALID;
            }
        }
        $res = $this->_hours;
        return $res;
    }

    /**
     * Changes the hours when a wake up must take place.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param int $newval : an integer corresponding to the hours when a wake up must take place
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_hours(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("hours", $rest_val);
    }

    /**
     * Returns the days of the week scheduled for wake up.
     *
     * @return int  an integer corresponding to the days of the week scheduled for wake up
     *
     * On failure, throws an exception or returns YWakeUpSchedule::WEEKDAYS_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_weekDays(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::WEEKDAYS_INVALID;
            }
        }
        $res = $this->_weekDays;
        return $res;
    }

    /**
     * Changes the days of the week when a wake up must take place.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param int $newval : an integer corresponding to the days of the week when a wake up must take place
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_weekDays(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("weekDays", $rest_val);
    }

    /**
     * Returns the days of the month scheduled for wake up.
     *
     * @return int  an integer corresponding to the days of the month scheduled for wake up
     *
     * On failure, throws an exception or returns YWakeUpSchedule::MONTHDAYS_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_monthDays(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::MONTHDAYS_INVALID;
            }
        }
        $res = $this->_monthDays;
        return $res;
    }

    /**
     * Changes the days of the month when a wake up must take place.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param int $newval : an integer corresponding to the days of the month when a wake up must take place
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_monthDays(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("monthDays", $rest_val);
    }

    /**
     * Returns the months scheduled for wake up.
     *
     * @return int  an integer corresponding to the months scheduled for wake up
     *
     * On failure, throws an exception or returns YWakeUpSchedule::MONTHS_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_months(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::MONTHS_INVALID;
            }
        }
        $res = $this->_months;
        return $res;
    }

    /**
     * Changes the months when a wake up must take place.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param int $newval : an integer corresponding to the months when a wake up must take place
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_months(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("months", $rest_val);
    }

    /**
     * Returns the number of seconds to anticipate wake-up time to allow
     * the system to power-up.
     *
     * @return int  an integer corresponding to the number of seconds to anticipate wake-up time to allow
     *         the system to power-up
     *
     * On failure, throws an exception or returns YWakeUpSchedule::SECONDSBEFORE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_secondsBefore(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SECONDSBEFORE_INVALID;
            }
        }
        $res = $this->_secondsBefore;
        return $res;
    }

    /**
     * Changes the number of seconds to anticipate wake-up time to allow
     * the system to power-up.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param int $newval : an integer corresponding to the number of seconds to anticipate wake-up time to allow
     *         the system to power-up
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_secondsBefore(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("secondsBefore", $rest_val);
    }

    /**
     * Returns the date/time (seconds) of the next wake up occurrence.
     *
     * @return float  an integer corresponding to the date/time (seconds) of the next wake up occurrence
     *
     * On failure, throws an exception or returns YWakeUpSchedule::NEXTOCCURENCE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_nextOccurence(): float
    {
        // $res                    is a long;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::NEXTOCCURENCE_INVALID;
            }
        }
        $res = $this->_nextOccurence;
        return $res;
    }

    /**
     * Retrieves a wake up schedule for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the wake up schedule is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the wake up schedule is
     * indeed online at a given time. In case of ambiguity when looking for
     * a wake up schedule by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the wake up schedule, for instance
     *         YHUBGSM5.wakeUpSchedule1.
     *
     * @return YWakeUpSchedule  a YWakeUpSchedule object allowing you to drive the wake up schedule.
     */
    public static function FindWakeUpSchedule(string $func): YWakeUpSchedule
    {
        // $obj                    is a YWakeUpSchedule;
        $obj = YFunction::_FindFromCache('WakeUpSchedule', $func);
        if ($obj == null) {
            $obj = new YWakeUpSchedule($func);
            YFunction::_AddToCache('WakeUpSchedule', $func, $obj);
        }
        return $obj;
    }

    /**
     * Returns all the minutes of each hour that are scheduled for wake up.
     */
    public function get_minutes(): float
    {
        // $res                    is a long;

        $res = $this->get_minutesB();
        $res = (($res) << 30);
        $res = $res + $this->get_minutesA();
        return $res;
    }

    /**
     * Changes all the minutes where a wake up must take place.
     *
     * @param float $bitmap : Minutes 00-59 of each hour scheduled for wake up.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_minutes(float $bitmap): int
    {
        $this->set_minutesA((($bitmap) & 0x3fffffff));
        $bitmap = (($bitmap) >> 30);
        return $this->set_minutesB((($bitmap) & 0x3fffffff));
    }

    /**
     * @throws YAPI_Exception
     */
    public function minutesA(): int
{
    return $this->get_minutesA();
}

    /**
     * @throws YAPI_Exception
     */
    public function setMinutesA(int $newval): int
{
    return $this->set_minutesA($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function minutesB(): int
{
    return $this->get_minutesB();
}

    /**
     * @throws YAPI_Exception
     */
    public function setMinutesB(int $newval): int
{
    return $this->set_minutesB($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function hours(): int
{
    return $this->get_hours();
}

    /**
     * @throws YAPI_Exception
     */
    public function setHours(int $newval): int
{
    return $this->set_hours($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function weekDays(): int
{
    return $this->get_weekDays();
}

    /**
     * @throws YAPI_Exception
     */
    public function setWeekDays(int $newval): int
{
    return $this->set_weekDays($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function monthDays(): int
{
    return $this->get_monthDays();
}

    /**
     * @throws YAPI_Exception
     */
    public function setMonthDays(int $newval): int
{
    return $this->set_monthDays($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function months(): int
{
    return $this->get_months();
}

    /**
     * @throws YAPI_Exception
     */
    public function setMonths(int $newval): int
{
    return $this->set_months($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function secondsBefore(): int
{
    return $this->get_secondsBefore();
}

    /**
     * @throws YAPI_Exception
     */
    public function setSecondsBefore(int $newval): int
{
    return $this->set_secondsBefore($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function nextOccurence(): float
{
    return $this->get_nextOccurence();
}

    /**
     * Continues the enumeration of wake up schedules started using yFirstWakeUpSchedule().
     * Caution: You can't make any assumption about the returned wake up schedules order.
     * If you want to find a specific a wake up schedule, use WakeUpSchedule.findWakeUpSchedule()
     * and a hardwareID or a logical name.
     *
     * @return ?YWakeUpSchedule  a pointer to a YWakeUpSchedule object, corresponding to
     *         a wake up schedule currently online, or a null pointer
     *         if there are no more wake up schedules to enumerate.
     */
    public function nextWakeUpSchedule(): ?YWakeUpSchedule
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindWakeUpSchedule($next_hwid);
    }

    /**
     * Starts the enumeration of wake up schedules currently accessible.
     * Use the method YWakeUpSchedule::nextWakeUpSchedule() to iterate on
     * next wake up schedules.
     *
     * @return ?YWakeUpSchedule  a pointer to a YWakeUpSchedule object, corresponding to
     *         the first wake up schedule currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstWakeUpSchedule(): ?YWakeUpSchedule
    {
        $next_hwid = YAPI::getFirstHardwareId('WakeUpSchedule');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindWakeUpSchedule($next_hwid);
    }

    //--- (end of YWakeUpSchedule implementation)

}
