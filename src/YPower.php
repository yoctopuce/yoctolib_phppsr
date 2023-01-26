<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YPower Class: electrical power sensor control interface, available for instance in the Yocto-Watt
 *
 * The YPower class allows you to read and configure Yoctopuce electrical power sensors.
 * It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, and to access the autonomous datalogger.
 * This class adds the ability to access the energy counter and the power factor.
 */
class YPower extends YSensor
{
    const COSPHI_INVALID = YAPI::INVALID_DOUBLE;
    const METER_INVALID = YAPI::INVALID_DOUBLE;
    const DELIVEREDENERGYMETER_INVALID = YAPI::INVALID_DOUBLE;
    const RECEIVEDENERGYMETER_INVALID = YAPI::INVALID_DOUBLE;
    const METERTIMER_INVALID = YAPI::INVALID_UINT;
    //--- (end of YPower declaration)

    //--- (YPower attributes)
    protected float $_cosPhi = self::COSPHI_INVALID;         // MeasureVal
    protected float $_meter = self::METER_INVALID;          // MeasureVal
    protected float $_deliveredEnergyMeter = self::DELIVEREDENERGYMETER_INVALID; // MeasureVal
    protected float $_receivedEnergyMeter = self::RECEIVEDENERGYMETER_INVALID; // MeasureVal
    protected int $_meterTimer = self::METERTIMER_INVALID;     // UInt31

    //--- (end of YPower attributes)

    function __construct($str_func)
    {
        //--- (YPower constructor)
        parent::__construct($str_func);
        $this->_className = 'Power';

        //--- (end of YPower constructor)
    }

    //--- (YPower implementation)

    function _parseAttr($name, $val): int
    {
        switch ($name) {
        case 'cosPhi':
            $this->_cosPhi = round($val / 65.536) / 1000.0;
            return 1;
        case 'meter':
            $this->_meter = round($val / 65.536) / 1000.0;
            return 1;
        case 'deliveredEnergyMeter':
            $this->_deliveredEnergyMeter = round($val / 65.536) / 1000.0;
            return 1;
        case 'receivedEnergyMeter':
            $this->_receivedEnergyMeter = round($val / 65.536) / 1000.0;
            return 1;
        case 'meterTimer':
            $this->_meterTimer = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the power factor (the ratio between the real power consumed,
     * measured in W, and the apparent power provided, measured in VA).
     *
     * @return float  a floating point number corresponding to the power factor (the ratio between the
     * real power consumed,
     *         measured in W, and the apparent power provided, measured in VA)
     *
     * On failure, throws an exception or returns YPower::COSPHI_INVALID.
     */
    public function get_cosPhi(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::COSPHI_INVALID;
            }
        }
        $res = $this->_cosPhi;
        return $res;
    }

    public function set_meter(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("meter", $rest_val);
    }

    /**
     * Returns the energy counter, maintained by the wattmeter by integrating the
     * power consumption over time. This is the sum of forward and backwad energy transfers,
     * if you are insterested in only one direction, use  get_receivedEnergyMeter() or
     * get_deliveredEnergyMeter(). Note that this counter is reset at each start of the device.
     *
     * @return float  a floating point number corresponding to the energy counter, maintained by the
     * wattmeter by integrating the
     *         power consumption over time
     *
     * On failure, throws an exception or returns YPower::METER_INVALID.
     */
    public function get_meter(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::METER_INVALID;
            }
        }
        $res = $this->_meter;
        return $res;
    }

    /**
     * Returns the energy counter, maintained by the wattmeter by integrating the power consumption over time,
     * but only when positive. Note that this counter is reset at each start of the device.
     *
     * @return float  a floating point number corresponding to the energy counter, maintained by the
     * wattmeter by integrating the power consumption over time,
     *         but only when positive
     *
     * On failure, throws an exception or returns YPower::DELIVEREDENERGYMETER_INVALID.
     */
    public function get_deliveredEnergyMeter(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DELIVEREDENERGYMETER_INVALID;
            }
        }
        $res = $this->_deliveredEnergyMeter;
        return $res;
    }

    /**
     * Returns the energy counter, maintained by the wattmeter by integrating the power consumption over time,
     * but only when negative. Note that this counter is reset at each start of the device.
     *
     * @return float  a floating point number corresponding to the energy counter, maintained by the
     * wattmeter by integrating the power consumption over time,
     *         but only when negative
     *
     * On failure, throws an exception or returns YPower::RECEIVEDENERGYMETER_INVALID.
     */
    public function get_receivedEnergyMeter(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::RECEIVEDENERGYMETER_INVALID;
            }
        }
        $res = $this->_receivedEnergyMeter;
        return $res;
    }

    /**
     * Returns the elapsed time since last energy counter reset, in seconds.
     *
     * @return int  an integer corresponding to the elapsed time since last energy counter reset, in seconds
     *
     * On failure, throws an exception or returns YPower::METERTIMER_INVALID.
     */
    public function get_meterTimer(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::METERTIMER_INVALID;
            }
        }
        $res = $this->_meterTimer;
        return $res;
    }

    /**
     * Retrieves a electrical power sensor for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the electrical power sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the electrical power sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a electrical power sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the electrical power sensor, for instance
     *         YWATTMK1.power.
     *
     * @return YPower  a YPower object allowing you to drive the electrical power sensor.
     */
    public static function FindPower(string $func): ?YPower
    {
        // $obj                    is a YPower;
        $obj = YFunction::_FindFromCache('Power', $func);
        if ($obj == null) {
            $obj = new YPower($func);
            YFunction::_AddToCache('Power', $func, $obj);
        }
        return $obj;
    }

    /**
     * Resets the energy counters.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function reset(): int
    {
        return $this->set_meter(0);
    }

    public function cosPhi(): float
{
    return $this->get_cosPhi();
}

    public function setMeter(float $newval)
{
    return $this->set_meter($newval);
}

    public function meter(): float
{
    return $this->get_meter();
}

    public function deliveredEnergyMeter(): float
{
    return $this->get_deliveredEnergyMeter();
}

    public function receivedEnergyMeter(): float
{
    return $this->get_receivedEnergyMeter();
}

    public function meterTimer(): int
{
    return $this->get_meterTimer();
}

    /**
     * Continues the enumeration of electrical power sensors started using yFirstPower().
     * Caution: You can't make any assumption about the returned electrical power sensors order.
     * If you want to find a specific a electrical power sensor, use Power.findPower()
     * and a hardwareID or a logical name.
     *
     * @return YPower  a pointer to a YPower object, corresponding to
     *         a electrical power sensor currently online, or a null pointer
     *         if there are no more electrical power sensors to enumerate.
     */
    public function nextPower(): ?YPower
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindPower($next_hwid);
    }

    /**
     * Starts the enumeration of electrical power sensors currently accessible.
     * Use the method YPower::nextPower() to iterate on
     * next electrical power sensors.
     *
     * @return YPower  a pointer to a YPower object, corresponding to
     *         the first electrical power sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstPower()
    {
        $next_hwid = YAPI::getFirstHardwareId('Power');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindPower($next_hwid);
    }

    //--- (end of YPower implementation)

}
