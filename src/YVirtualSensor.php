<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YVirtualSensor Class: virtual sensor control interface
 *
 * The YVirtualSensor class allows you to use Yoctopuce virtual sensors.
 * These sensors make it possible to show external data collected by the user
 * as a Yoctopuce Sensor. This class inherits from YSensor class the core
 * functions to read measurements, to register callback functions, and to access
 * the autonomous datalogger. It adds the ability to change the sensor value as
 * needed, or to mark current value as invalid.
 */
class YVirtualSensor extends YSensor
{
    const INVALIDVALUE_INVALID = YAPI::INVALID_DOUBLE;
    //--- (end of YVirtualSensor declaration)

    //--- (YVirtualSensor attributes)
    protected float $_invalidValue = self::INVALIDVALUE_INVALID;   // MeasureVal

    //--- (end of YVirtualSensor attributes)

    function __construct(string $str_func)
    {
        //--- (YVirtualSensor constructor)
        parent::__construct($str_func);
        $this->_className = 'VirtualSensor';

        //--- (end of YVirtualSensor constructor)
    }

    //--- (YVirtualSensor implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'invalidValue':
            $this->_invalidValue = round($val / 65.536) / 1000.0;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Changes the measuring unit for the measured value.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param string $newval : a string corresponding to the measuring unit for the measured value
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_unit(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("unit", $rest_val);
    }

    /**
     * Changes the current value of the sensor (raw value, before calibration).
     *
     * @param float $newval : a floating point number corresponding to the current value of the sensor
     * (raw value, before calibration)
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_currentRawValue(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("currentRawValue", $rest_val);
    }

    /**
     * @throws YAPI_Exception
     */
    public function set_sensorState(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("sensorState", $rest_val);
    }

    /**
     * Changes the invalid value of the sensor, returned if the sensor is read when in invalid state
     * (for instance before having been set). Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param float $newval : a floating point number corresponding to the invalid value of the sensor,
     * returned if the sensor is read when in invalid state
     *         (for instance before having been set)
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_invalidValue(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("invalidValue", $rest_val);
    }

    /**
     * Returns the invalid value of the sensor, returned if the sensor is read when in invalid state
     * (for instance before having been set).
     *
     * @return float  a floating point number corresponding to the invalid value of the sensor, returned
     * if the sensor is read when in invalid state
     *         (for instance before having been set)
     *
     * On failure, throws an exception or returns YVirtualSensor::INVALIDVALUE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_invalidValue(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::INVALIDVALUE_INVALID;
            }
        }
        $res = $this->_invalidValue;
        return $res;
    }

    /**
     * Retrieves a virtual sensor for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the virtual sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the virtual sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a virtual sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the virtual sensor, for instance
     *         MyDevice.virtualSensor1.
     *
     * @return YVirtualSensor  a YVirtualSensor object allowing you to drive the virtual sensor.
     */
    public static function FindVirtualSensor(string $func): YVirtualSensor
    {
        // $obj                    is a YVirtualSensor;
        $obj = YFunction::_FindFromCache('VirtualSensor', $func);
        if ($obj == null) {
            $obj = new YVirtualSensor($func);
            YFunction::_AddToCache('VirtualSensor', $func, $obj);
        }
        return $obj;
    }

    /**
     * Changes the current sensor state to invalid (as if no value would have been ever set).
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_sensorAsInvalid(): int
    {
        return $this->set_sensorState(1);
    }

    /**
     * @throws YAPI_Exception
     */
    public function setUnit(string $newval): int
{
    return $this->set_unit($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function setCurrentRawValue(float $newval): int
{
    return $this->set_currentRawValue($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function setSensorState(int $newval): int
{
    return $this->set_sensorState($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function setInvalidValue(float $newval): int
{
    return $this->set_invalidValue($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function invalidValue(): float
{
    return $this->get_invalidValue();
}

    /**
     * Continues the enumeration of virtual sensors started using yFirstVirtualSensor().
     * Caution: You can't make any assumption about the returned virtual sensors order.
     * If you want to find a specific a virtual sensor, use VirtualSensor.findVirtualSensor()
     * and a hardwareID or a logical name.
     *
     * @return ?YVirtualSensor  a pointer to a YVirtualSensor object, corresponding to
     *         a virtual sensor currently online, or a null pointer
     *         if there are no more virtual sensors to enumerate.
     */
    public function nextVirtualSensor(): ?YVirtualSensor
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindVirtualSensor($next_hwid);
    }

    /**
     * Starts the enumeration of virtual sensors currently accessible.
     * Use the method YVirtualSensor::nextVirtualSensor() to iterate on
     * next virtual sensors.
     *
     * @return ?YVirtualSensor  a pointer to a YVirtualSensor object, corresponding to
     *         the first virtual sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstVirtualSensor(): ?YVirtualSensor
    {
        $next_hwid = YAPI::getFirstHardwareId('VirtualSensor');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindVirtualSensor($next_hwid);
    }

    //--- (end of YVirtualSensor implementation)

}
