<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YProximity Class: proximity sensor control interface, available for instance in the Yocto-Proximity
 *
 * The YProximity class allows you to read and configure Yoctopuce proximity sensors.
 * It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, and to access the autonomous datalogger.
 * This class adds the ability to set up a detection threshold and to count the
 * number of detected state changes.
 */
class YProximity extends YSensor
{
    const SIGNALVALUE_INVALID = YAPI::INVALID_DOUBLE;
    const DETECTIONTHRESHOLD_INVALID = YAPI::INVALID_UINT;
    const DETECTIONHYSTERESIS_INVALID = YAPI::INVALID_UINT;
    const PRESENCEMINTIME_INVALID = YAPI::INVALID_UINT;
    const REMOVALMINTIME_INVALID = YAPI::INVALID_UINT;
    const ISPRESENT_FALSE = 0;
    const ISPRESENT_TRUE = 1;
    const ISPRESENT_INVALID = -1;
    const LASTTIMEAPPROACHED_INVALID = YAPI::INVALID_LONG;
    const LASTTIMEREMOVED_INVALID = YAPI::INVALID_LONG;
    const PULSECOUNTER_INVALID = YAPI::INVALID_LONG;
    const PULSETIMER_INVALID = YAPI::INVALID_LONG;
    const PROXIMITYREPORTMODE_NUMERIC = 0;
    const PROXIMITYREPORTMODE_PRESENCE = 1;
    const PROXIMITYREPORTMODE_PULSECOUNT = 2;
    const PROXIMITYREPORTMODE_INVALID = -1;
    //--- (end of YProximity declaration)

    //--- (YProximity attributes)
    protected float $_signalValue = self::SIGNALVALUE_INVALID;    // MeasureVal
    protected int $_detectionThreshold = self::DETECTIONTHRESHOLD_INVALID; // UInt31
    protected int $_detectionHysteresis = self::DETECTIONHYSTERESIS_INVALID; // UInt31
    protected int $_presenceMinTime = self::PRESENCEMINTIME_INVALID; // UInt31
    protected int $_removalMinTime = self::REMOVALMINTIME_INVALID; // UInt31
    protected int $_isPresent = self::ISPRESENT_INVALID;      // Bool
    protected float $_lastTimeApproached = self::LASTTIMEAPPROACHED_INVALID; // Time
    protected float $_lastTimeRemoved = self::LASTTIMEREMOVED_INVALID; // Time
    protected float $_pulseCounter = self::PULSECOUNTER_INVALID;   // UInt
    protected float $_pulseTimer = self::PULSETIMER_INVALID;     // Time
    protected int $_proximityReportMode = self::PROXIMITYREPORTMODE_INVALID; // ProximityReportModeType

    //--- (end of YProximity attributes)

    function __construct(string $str_func)
    {
        //--- (YProximity constructor)
        parent::__construct($str_func);
        $this->_className = 'Proximity';

        //--- (end of YProximity constructor)
    }

    //--- (YProximity implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'signalValue':
            $this->_signalValue = round($val / 65.536) / 1000.0;
            return 1;
        case 'detectionThreshold':
            $this->_detectionThreshold = intval($val);
            return 1;
        case 'detectionHysteresis':
            $this->_detectionHysteresis = intval($val);
            return 1;
        case 'presenceMinTime':
            $this->_presenceMinTime = intval($val);
            return 1;
        case 'removalMinTime':
            $this->_removalMinTime = intval($val);
            return 1;
        case 'isPresent':
            $this->_isPresent = intval($val);
            return 1;
        case 'lastTimeApproached':
            $this->_lastTimeApproached = intval($val);
            return 1;
        case 'lastTimeRemoved':
            $this->_lastTimeRemoved = intval($val);
            return 1;
        case 'pulseCounter':
            $this->_pulseCounter = intval($val);
            return 1;
        case 'pulseTimer':
            $this->_pulseTimer = intval($val);
            return 1;
        case 'proximityReportMode':
            $this->_proximityReportMode = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the current value of signal measured by the proximity sensor.
     *
     * @return float  a floating point number corresponding to the current value of signal measured by the
     * proximity sensor
     *
     * On failure, throws an exception or returns YProximity::SIGNALVALUE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_signalValue(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SIGNALVALUE_INVALID;
            }
        }
        $res = round($this->_signalValue * 1000) / 1000;
        return $res;
    }

    /**
     * Returns the threshold used to determine the logical state of the proximity sensor, when considered
     * as a binary input (on/off).
     *
     * @return int  an integer corresponding to the threshold used to determine the logical state of the
     * proximity sensor, when considered
     *         as a binary input (on/off)
     *
     * On failure, throws an exception or returns YProximity::DETECTIONTHRESHOLD_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_detectionThreshold(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DETECTIONTHRESHOLD_INVALID;
            }
        }
        $res = $this->_detectionThreshold;
        return $res;
    }

    /**
     * Changes the threshold used to determine the logical state of the proximity sensor, when considered
     * as a binary input (on/off).
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @param int $newval : an integer corresponding to the threshold used to determine the logical state
     * of the proximity sensor, when considered
     *         as a binary input (on/off)
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_detectionThreshold(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("detectionThreshold", $rest_val);
    }

    /**
     * Returns the hysteresis used to determine the logical state of the proximity sensor, when considered
     * as a binary input (on/off).
     *
     * @return int  an integer corresponding to the hysteresis used to determine the logical state of the
     * proximity sensor, when considered
     *         as a binary input (on/off)
     *
     * On failure, throws an exception or returns YProximity::DETECTIONHYSTERESIS_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_detectionHysteresis(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DETECTIONHYSTERESIS_INVALID;
            }
        }
        $res = $this->_detectionHysteresis;
        return $res;
    }

    /**
     * Changes the hysteresis used to determine the logical state of the proximity sensor, when considered
     * as a binary input (on/off).
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @param int $newval : an integer corresponding to the hysteresis used to determine the logical state
     * of the proximity sensor, when considered
     *         as a binary input (on/off)
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_detectionHysteresis(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("detectionHysteresis", $rest_val);
    }

    /**
     * Returns the minimal detection duration before signalling a presence event. Any shorter detection is
     * considered as noise or bounce (false positive) and filtered out.
     *
     * @return int  an integer corresponding to the minimal detection duration before signalling a presence event
     *
     * On failure, throws an exception or returns YProximity::PRESENCEMINTIME_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_presenceMinTime(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PRESENCEMINTIME_INVALID;
            }
        }
        $res = $this->_presenceMinTime;
        return $res;
    }

    /**
     * Changes the minimal detection duration before signalling a presence event. Any shorter detection is
     * considered as noise or bounce (false positive) and filtered out.
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @param int $newval : an integer corresponding to the minimal detection duration before signalling a
     * presence event
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_presenceMinTime(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("presenceMinTime", $rest_val);
    }

    /**
     * Returns the minimal detection duration before signalling a removal event. Any shorter detection is
     * considered as noise or bounce (false positive) and filtered out.
     *
     * @return int  an integer corresponding to the minimal detection duration before signalling a removal event
     *
     * On failure, throws an exception or returns YProximity::REMOVALMINTIME_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_removalMinTime(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::REMOVALMINTIME_INVALID;
            }
        }
        $res = $this->_removalMinTime;
        return $res;
    }

    /**
     * Changes the minimal detection duration before signalling a removal event. Any shorter detection is
     * considered as noise or bounce (false positive) and filtered out.
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @param int $newval : an integer corresponding to the minimal detection duration before signalling a
     * removal event
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_removalMinTime(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("removalMinTime", $rest_val);
    }

    /**
     * Returns true if the input (considered as binary) is active (detection value is smaller than the
     * specified threshold), and false otherwise.
     *
     * @return int  either YProximity::ISPRESENT_FALSE or YProximity::ISPRESENT_TRUE, according to true if
     * the input (considered as binary) is active (detection value is smaller than the specified
     * threshold), and false otherwise
     *
     * On failure, throws an exception or returns YProximity::ISPRESENT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_isPresent(): int
    {
        // $res                    is a enumBOOL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::ISPRESENT_INVALID;
            }
        }
        $res = $this->_isPresent;
        return $res;
    }

    /**
     * Returns the number of elapsed milliseconds between the module power on and the last observed
     * detection (the input contact transitioned from absent to present).
     *
     * @return float  an integer corresponding to the number of elapsed milliseconds between the module
     * power on and the last observed
     *         detection (the input contact transitioned from absent to present)
     *
     * On failure, throws an exception or returns YProximity::LASTTIMEAPPROACHED_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_lastTimeApproached(): float
    {
        // $res                    is a long;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LASTTIMEAPPROACHED_INVALID;
            }
        }
        $res = $this->_lastTimeApproached;
        return $res;
    }

    /**
     * Returns the number of elapsed milliseconds between the module power on and the last observed
     * detection (the input contact transitioned from present to absent).
     *
     * @return float  an integer corresponding to the number of elapsed milliseconds between the module
     * power on and the last observed
     *         detection (the input contact transitioned from present to absent)
     *
     * On failure, throws an exception or returns YProximity::LASTTIMEREMOVED_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_lastTimeRemoved(): float
    {
        // $res                    is a long;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LASTTIMEREMOVED_INVALID;
            }
        }
        $res = $this->_lastTimeRemoved;
        return $res;
    }

    /**
     * Returns the pulse counter value. The value is a 32 bit integer. In case
     * of overflow (>=2^32), the counter will wrap. To reset the counter, just
     * call the resetCounter() method.
     *
     * @return float  an integer corresponding to the pulse counter value
     *
     * On failure, throws an exception or returns YProximity::PULSECOUNTER_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_pulseCounter(): float
    {
        // $res                    is a long;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PULSECOUNTER_INVALID;
            }
        }
        $res = $this->_pulseCounter;
        return $res;
    }

    /**
     * @throws YAPI_Exception
     */
    public function set_pulseCounter(float $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("pulseCounter", $rest_val);
    }

    /**
     * Returns the timer of the pulse counter (ms).
     *
     * @return float  an integer corresponding to the timer of the pulse counter (ms)
     *
     * On failure, throws an exception or returns YProximity::PULSETIMER_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_pulseTimer(): float
    {
        // $res                    is a long;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PULSETIMER_INVALID;
            }
        }
        $res = $this->_pulseTimer;
        return $res;
    }

    /**
     * Returns the parameter (sensor value, presence or pulse count) returned by the get_currentValue
     * function and callbacks.
     *
     * @return int  a value among YProximity::PROXIMITYREPORTMODE_NUMERIC,
     * YProximity::PROXIMITYREPORTMODE_PRESENCE and YProximity::PROXIMITYREPORTMODE_PULSECOUNT corresponding
     * to the parameter (sensor value, presence or pulse count) returned by the get_currentValue function and callbacks
     *
     * On failure, throws an exception or returns YProximity::PROXIMITYREPORTMODE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_proximityReportMode(): int
    {
        // $res                    is a enumPROXIMITYREPORTMODETYPE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PROXIMITYREPORTMODE_INVALID;
            }
        }
        $res = $this->_proximityReportMode;
        return $res;
    }

    /**
     * Changes the  parameter  type (sensor value, presence or pulse count) returned by the
     * get_currentValue function and callbacks.
     * The edge count value is limited to the 6 lowest digits. For values greater than one million, use
     * get_pulseCounter().
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @param int $newval : a value among YProximity::PROXIMITYREPORTMODE_NUMERIC,
     * YProximity::PROXIMITYREPORTMODE_PRESENCE and YProximity::PROXIMITYREPORTMODE_PULSECOUNT corresponding
     * to the  parameter  type (sensor value, presence or pulse count) returned by the get_currentValue
     * function and callbacks
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_proximityReportMode(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("proximityReportMode", $rest_val);
    }

    /**
     * Retrieves a proximity sensor for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the proximity sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the proximity sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a proximity sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the proximity sensor, for instance
     *         YPROXIM1.proximity1.
     *
     * @return YProximity  a YProximity object allowing you to drive the proximity sensor.
     */
    public static function FindProximity(string $func): YProximity
    {
        // $obj                    is a YProximity;
        $obj = YFunction::_FindFromCache('Proximity', $func);
        if ($obj == null) {
            $obj = new YProximity($func);
            YFunction::_AddToCache('Proximity', $func, $obj);
        }
        return $obj;
    }

    /**
     * Resets the pulse counter value as well as its timer.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function resetCounter(): int
    {
        return $this->set_pulseCounter(0);
    }

    /**
     * @throws YAPI_Exception
     */
    public function signalValue(): float
{
    return $this->get_signalValue();
}

    /**
     * @throws YAPI_Exception
     */
    public function detectionThreshold(): int
{
    return $this->get_detectionThreshold();
}

    /**
     * @throws YAPI_Exception
     */
    public function setDetectionThreshold(int $newval): int
{
    return $this->set_detectionThreshold($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function detectionHysteresis(): int
{
    return $this->get_detectionHysteresis();
}

    /**
     * @throws YAPI_Exception
     */
    public function setDetectionHysteresis(int $newval): int
{
    return $this->set_detectionHysteresis($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function presenceMinTime(): int
{
    return $this->get_presenceMinTime();
}

    /**
     * @throws YAPI_Exception
     */
    public function setPresenceMinTime(int $newval): int
{
    return $this->set_presenceMinTime($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function removalMinTime(): int
{
    return $this->get_removalMinTime();
}

    /**
     * @throws YAPI_Exception
     */
    public function setRemovalMinTime(int $newval): int
{
    return $this->set_removalMinTime($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function isPresent(): int
{
    return $this->get_isPresent();
}

    /**
     * @throws YAPI_Exception
     */
    public function lastTimeApproached(): float
{
    return $this->get_lastTimeApproached();
}

    /**
     * @throws YAPI_Exception
     */
    public function lastTimeRemoved(): float
{
    return $this->get_lastTimeRemoved();
}

    /**
     * @throws YAPI_Exception
     */
    public function pulseCounter(): float
{
    return $this->get_pulseCounter();
}

    /**
     * @throws YAPI_Exception
     */
    public function setPulseCounter(float $newval): int
{
    return $this->set_pulseCounter($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function pulseTimer(): float
{
    return $this->get_pulseTimer();
}

    /**
     * @throws YAPI_Exception
     */
    public function proximityReportMode(): int
{
    return $this->get_proximityReportMode();
}

    /**
     * @throws YAPI_Exception
     */
    public function setProximityReportMode(int $newval): int
{
    return $this->set_proximityReportMode($newval);
}

    /**
     * Continues the enumeration of proximity sensors started using yFirstProximity().
     * Caution: You can't make any assumption about the returned proximity sensors order.
     * If you want to find a specific a proximity sensor, use Proximity.findProximity()
     * and a hardwareID or a logical name.
     *
     * @return ?YProximity  a pointer to a YProximity object, corresponding to
     *         a proximity sensor currently online, or a null pointer
     *         if there are no more proximity sensors to enumerate.
     */
    public function nextProximity(): ?YProximity
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindProximity($next_hwid);
    }

    /**
     * Starts the enumeration of proximity sensors currently accessible.
     * Use the method YProximity::nextProximity() to iterate on
     * next proximity sensors.
     *
     * @return ?YProximity  a pointer to a YProximity object, corresponding to
     *         the first proximity sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstProximity(): ?YProximity
    {
        $next_hwid = YAPI::getFirstHardwareId('Proximity');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindProximity($next_hwid);
    }

    //--- (end of YProximity implementation)

}
