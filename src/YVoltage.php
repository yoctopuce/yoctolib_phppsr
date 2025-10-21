<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YVoltage Class: voltage sensor control interface, available for instance in the Yocto-Motor-DC, the
 * Yocto-Volt or the Yocto-Watt
 *
 * The YVoltage class allows you to read and configure Yoctopuce voltage sensors.
 * It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, and to access the autonomous datalogger.
 */
class YVoltage extends YSensor
{
    const ENABLED_FALSE = 0;
    const ENABLED_TRUE = 1;
    const ENABLED_INVALID = -1;
    const SIGNALBIAS_INVALID = YAPI::INVALID_DOUBLE;
    //--- (end of YVoltage declaration)

    //--- (YVoltage attributes)
    protected int $_enabled = self::ENABLED_INVALID;        // Bool
    protected float $_signalBias = self::SIGNALBIAS_INVALID;     // MeasureVal

    //--- (end of YVoltage attributes)

    function __construct(string $str_func)
    {
        //--- (YVoltage constructor)
        parent::__construct($str_func);
        $this->_className = 'Voltage';

        //--- (end of YVoltage constructor)
    }

    //--- (YVoltage implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'enabled':
            $this->_enabled = intval($val);
            return 1;
        case 'signalBias':
            $this->_signalBias = round($val / 65.536) / 1000.0;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the activation state of this input.
     *
     * @return int  either YVoltage::ENABLED_FALSE or YVoltage::ENABLED_TRUE, according to the activation
     * state of this input
     *
     * On failure, throws an exception or returns YVoltage::ENABLED_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_enabled(): int
    {
        // $res                    is a enumBOOL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::ENABLED_INVALID;
            }
        }
        $res = $this->_enabled;
        return $res;
    }

    /**
     * Changes the activation state of this voltage input. When AC measurements are disabled,
     * the device will always assume a DC signal, and vice-versa. When both AC and DC measurements
     * are active, the device switches between AC and DC mode based on the relative amplitude
     * of variations compared to the average value.
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param int $newval : either YVoltage::ENABLED_FALSE or YVoltage::ENABLED_TRUE, according to the
     * activation state of this voltage input
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_enabled(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("enabled", $rest_val);
    }

    /**
     * Changes the DC bias configured for zero shift adjustment.
     * If your DC current reads positive when it should be zero, set up
     * a positive signalBias of the same value to fix the zero shift.
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param float $newval : a floating point number corresponding to the DC bias configured for zero shift adjustment
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_signalBias(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("signalBias", $rest_val);
    }

    /**
     * Returns the DC bias configured for zero shift adjustment.
     * A positive bias value is used to correct a positive DC bias,
     * while a negative bias value is used to correct a negative DC bias.
     *
     * @return float  a floating point number corresponding to the DC bias configured for zero shift adjustment
     *
     * On failure, throws an exception or returns YVoltage::SIGNALBIAS_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_signalBias(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SIGNALBIAS_INVALID;
            }
        }
        $res = $this->_signalBias;
        return $res;
    }

    /**
     * Retrieves a voltage sensor for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the voltage sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the voltage sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a voltage sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the voltage sensor, for instance
     *         MOTORCTL.voltage.
     *
     * @return YVoltage  a YVoltage object allowing you to drive the voltage sensor.
     */
    public static function FindVoltage(string $func): YVoltage
    {
        // $obj                    is a YVoltage;
        $obj = YFunction::_FindFromCache('Voltage', $func);
        if ($obj == null) {
            $obj = new YVoltage($func);
            YFunction::_AddToCache('Voltage', $func, $obj);
        }
        return $obj;
    }

    /**
     * Calibrate the device by adjusting signalBias so that the current
     * input voltage is precisely seen as zero. Before calling this method, make
     * sure to short the power source inputs as close as possible to the connector, and
     * to disconnect the load to ensure the wires don't capture radiated noise.
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function zeroAdjust(): int
    {
        // $currSignal             is a float;
        // $bias                   is a float;
        $currSignal = $this->get_currentRawValue();
        $bias = $this->get_signalBias() + $currSignal;
        if (!(($bias > -0.5) && ($bias < 0.5))) return $this->_throw(YAPI::INVALID_ARGUMENT,'suspicious zeroAdjust, please ensure that the power source inputs are shorted',YAPI::INVALID_ARGUMENT);
        return $this->set_signalBias($bias);
    }

    /**
     * @throws YAPI_Exception
     */
    public function enabled(): int
{
    return $this->get_enabled();
}

    /**
     * @throws YAPI_Exception
     */
    public function setEnabled(int $newval): int
{
    return $this->set_enabled($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function setSignalBias(float $newval): int
{
    return $this->set_signalBias($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function signalBias(): float
{
    return $this->get_signalBias();
}

    /**
     * Continues the enumeration of voltage sensors started using yFirstVoltage().
     * Caution: You can't make any assumption about the returned voltage sensors order.
     * If you want to find a specific a voltage sensor, use Voltage.findVoltage()
     * and a hardwareID or a logical name.
     *
     * @return ?YVoltage  a pointer to a YVoltage object, corresponding to
     *         a voltage sensor currently online, or a null pointer
     *         if there are no more voltage sensors to enumerate.
     */
    public function nextVoltage(): ?YVoltage
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindVoltage($next_hwid);
    }

    /**
     * Starts the enumeration of voltage sensors currently accessible.
     * Use the method YVoltage::nextVoltage() to iterate on
     * next voltage sensors.
     *
     * @return ?YVoltage  a pointer to a YVoltage object, corresponding to
     *         the first voltage sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstVoltage(): ?YVoltage
    {
        $next_hwid = YAPI::getFirstHardwareId('Voltage');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindVoltage($next_hwid);
    }

    //--- (end of YVoltage implementation)

}
