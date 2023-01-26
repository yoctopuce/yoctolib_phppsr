<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YGenericSensor Class: GenericSensor control interface, available for instance in the
 * Yocto-0-10V-Rx, the Yocto-4-20mA-Rx, the Yocto-Bridge or the Yocto-milliVolt-Rx
 *
 * The YGenericSensor class allows you to read and configure Yoctopuce signal
 * transducers. It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, to access the autonomous datalogger.
 * This class adds the ability to configure the automatic conversion between the
 * measured signal and the corresponding engineering unit.
 */
class YGenericSensor extends YSensor
{
    const SIGNALVALUE_INVALID = YAPI::INVALID_DOUBLE;
    const SIGNALUNIT_INVALID = YAPI::INVALID_STRING;
    const SIGNALRANGE_INVALID = YAPI::INVALID_STRING;
    const VALUERANGE_INVALID = YAPI::INVALID_STRING;
    const SIGNALBIAS_INVALID = YAPI::INVALID_DOUBLE;
    const SIGNALSAMPLING_HIGH_RATE = 0;
    const SIGNALSAMPLING_HIGH_RATE_FILTERED = 1;
    const SIGNALSAMPLING_LOW_NOISE = 2;
    const SIGNALSAMPLING_LOW_NOISE_FILTERED = 3;
    const SIGNALSAMPLING_HIGHEST_RATE = 4;
    const SIGNALSAMPLING_AC = 5;
    const SIGNALSAMPLING_INVALID = -1;
    const ENABLED_FALSE = 0;
    const ENABLED_TRUE = 1;
    const ENABLED_INVALID = -1;
    //--- (end of YGenericSensor declaration)

    //--- (YGenericSensor attributes)
    protected float $_signalValue = self::SIGNALVALUE_INVALID;    // MeasureVal
    protected string $_signalUnit = self::SIGNALUNIT_INVALID;     // Text
    protected string $_signalRange = self::SIGNALRANGE_INVALID;    // ValueRange
    protected string $_valueRange = self::VALUERANGE_INVALID;     // ValueRange
    protected float $_signalBias = self::SIGNALBIAS_INVALID;     // MeasureVal
    protected int $_signalSampling = self::SIGNALSAMPLING_INVALID; // SignalSampling
    protected int $_enabled = self::ENABLED_INVALID;        // Bool

    //--- (end of YGenericSensor attributes)

    function __construct($str_func)
    {
        //--- (YGenericSensor constructor)
        parent::__construct($str_func);
        $this->_className = 'GenericSensor';

        //--- (end of YGenericSensor constructor)
    }

    //--- (YGenericSensor implementation)

    function _parseAttr($name, $val): int
    {
        switch ($name) {
        case 'signalValue':
            $this->_signalValue = round($val / 65.536) / 1000.0;
            return 1;
        case 'signalUnit':
            $this->_signalUnit = $val;
            return 1;
        case 'signalRange':
            $this->_signalRange = $val;
            return 1;
        case 'valueRange':
            $this->_valueRange = $val;
            return 1;
        case 'signalBias':
            $this->_signalBias = round($val / 65.536) / 1000.0;
            return 1;
        case 'signalSampling':
            $this->_signalSampling = intval($val);
            return 1;
        case 'enabled':
            $this->_enabled = intval($val);
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
     */
    public function set_unit(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("unit", $rest_val);
    }

    /**
     * Returns the current value of the electrical signal measured by the sensor.
     *
     * @return float  a floating point number corresponding to the current value of the electrical signal
     * measured by the sensor
     *
     * On failure, throws an exception or returns YGenericSensor::SIGNALVALUE_INVALID.
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
     * Returns the measuring unit of the electrical signal used by the sensor.
     *
     * @return string  a string corresponding to the measuring unit of the electrical signal used by the sensor
     *
     * On failure, throws an exception or returns YGenericSensor::SIGNALUNIT_INVALID.
     */
    public function get_signalUnit(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration == 0) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SIGNALUNIT_INVALID;
            }
        }
        $res = $this->_signalUnit;
        return $res;
    }

    /**
     * Returns the input signal range used by the sensor.
     *
     * @return string  a string corresponding to the input signal range used by the sensor
     *
     * On failure, throws an exception or returns YGenericSensor::SIGNALRANGE_INVALID.
     */
    public function get_signalRange(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SIGNALRANGE_INVALID;
            }
        }
        $res = $this->_signalRange;
        return $res;
    }

    /**
     * Changes the input signal range used by the sensor.
     * When the input signal gets out of the planned range, the output value
     * will be set to an arbitrary large value, whose sign indicates the direction
     * of the range overrun.
     *
     * For a 4-20mA sensor, the default input signal range is "4...20".
     * For a 0-10V sensor, the default input signal range is "0.1...10".
     * For numeric communication interfaces, the default input signal range is
     * "-999999.999...999999.999".
     *
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param string $newval : a string corresponding to the input signal range used by the sensor
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_signalRange(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("signalRange", $rest_val);
    }

    /**
     * Returns the physical value range measured by the sensor.
     *
     * @return string  a string corresponding to the physical value range measured by the sensor
     *
     * On failure, throws an exception or returns YGenericSensor::VALUERANGE_INVALID.
     */
    public function get_valueRange(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::VALUERANGE_INVALID;
            }
        }
        $res = $this->_valueRange;
        return $res;
    }

    /**
     * Changes the output value range, corresponding to the physical value measured
     * by the sensor. The default output value range is the same as the input signal
     * range (1:1 mapping), but you can change it so that the function automatically
     * computes the physical value encoded by the input signal. Be aware that, as a
     * side effect, the range modification may automatically modify the display resolution.
     *
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param string $newval : a string corresponding to the output value range, corresponding to the
     * physical value measured
     *         by the sensor
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_valueRange(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("valueRange", $rest_val);
    }

    /**
     * Changes the electric signal bias for zero shift adjustment.
     * If your electric signal reads positive when it should be zero, setup
     * a positive signalBias of the same value to fix the zero shift.
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param float $newval : a floating point number corresponding to the electric signal bias for zero
     * shift adjustment
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_signalBias(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("signalBias", $rest_val);
    }

    /**
     * Returns the electric signal bias for zero shift adjustment.
     * A positive bias means that the signal is over-reporting the measure,
     * while a negative bias means that the signal is under-reporting the measure.
     *
     * @return float  a floating point number corresponding to the electric signal bias for zero shift adjustment
     *
     * On failure, throws an exception or returns YGenericSensor::SIGNALBIAS_INVALID.
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
     * Returns the electric signal sampling method to use.
     * The HIGH_RATE method uses the highest sampling frequency, without any filtering.
     * The HIGH_RATE_FILTERED method adds a windowed 7-sample median filter.
     * The LOW_NOISE method uses a reduced acquisition frequency to reduce noise.
     * The LOW_NOISE_FILTERED method combines a reduced frequency with the median filter
     * to get measures as stable as possible when working on a noisy signal.
     *
     * @return int  a value among YGenericSensor::SIGNALSAMPLING_HIGH_RATE,
     * YGenericSensor::SIGNALSAMPLING_HIGH_RATE_FILTERED, YGenericSensor::SIGNALSAMPLING_LOW_NOISE,
     * YGenericSensor::SIGNALSAMPLING_LOW_NOISE_FILTERED, YGenericSensor::SIGNALSAMPLING_HIGHEST_RATE and
     * YGenericSensor::SIGNALSAMPLING_AC corresponding to the electric signal sampling method to use
     *
     * On failure, throws an exception or returns YGenericSensor::SIGNALSAMPLING_INVALID.
     */
    public function get_signalSampling(): int
    {
        // $res                    is a enumSIGNALSAMPLING;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SIGNALSAMPLING_INVALID;
            }
        }
        $res = $this->_signalSampling;
        return $res;
    }

    /**
     * Changes the electric signal sampling method to use.
     * The HIGH_RATE method uses the highest sampling frequency, without any filtering.
     * The HIGH_RATE_FILTERED method adds a windowed 7-sample median filter.
     * The LOW_NOISE method uses a reduced acquisition frequency to reduce noise.
     * The LOW_NOISE_FILTERED method combines a reduced frequency with the median filter
     * to get measures as stable as possible when working on a noisy signal.
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param int $newval : a value among YGenericSensor::SIGNALSAMPLING_HIGH_RATE,
     * YGenericSensor::SIGNALSAMPLING_HIGH_RATE_FILTERED, YGenericSensor::SIGNALSAMPLING_LOW_NOISE,
     * YGenericSensor::SIGNALSAMPLING_LOW_NOISE_FILTERED, YGenericSensor::SIGNALSAMPLING_HIGHEST_RATE and
     * YGenericSensor::SIGNALSAMPLING_AC corresponding to the electric signal sampling method to use
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_signalSampling(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("signalSampling", $rest_val);
    }

    /**
     * Returns the activation state of this input.
     *
     * @return int  either YGenericSensor::ENABLED_FALSE or YGenericSensor::ENABLED_TRUE, according to the
     * activation state of this input
     *
     * On failure, throws an exception or returns YGenericSensor::ENABLED_INVALID.
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
     * Changes the activation state of this input. When an input is disabled,
     * its value is no more updated. On some devices, disabling an input can
     * improve the refresh rate of the other active inputs.
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param int $newval : either YGenericSensor::ENABLED_FALSE or YGenericSensor::ENABLED_TRUE, according
     * to the activation state of this input
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_enabled(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("enabled", $rest_val);
    }

    /**
     * Retrieves a generic sensor for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the generic sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the generic sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a generic sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the generic sensor, for instance
     *         RX010V01.genericSensor1.
     *
     * @return YGenericSensor  a YGenericSensor object allowing you to drive the generic sensor.
     */
    public static function FindGenericSensor(string $func): ?YGenericSensor
    {
        // $obj                    is a YGenericSensor;
        $obj = YFunction::_FindFromCache('GenericSensor', $func);
        if ($obj == null) {
            $obj = new YGenericSensor($func);
            YFunction::_AddToCache('GenericSensor', $func, $obj);
        }
        return $obj;
    }

    /**
     * Adjusts the signal bias so that the current signal value is need
     * precisely as zero. Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function zeroAdjust(): int
    {
        // $currSignal             is a float;
        // $currBias               is a float;
        $currSignal = $this->get_signalValue();
        $currBias = $this->get_signalBias();
        return $this->set_signalBias($currSignal + $currBias);
    }

    public function setUnit(string $newval)
{
    return $this->set_unit($newval);
}

    public function signalValue(): float
{
    return $this->get_signalValue();
}

    public function signalUnit(): string
{
    return $this->get_signalUnit();
}

    public function signalRange(): string
{
    return $this->get_signalRange();
}

    public function setSignalRange(string $newval)
{
    return $this->set_signalRange($newval);
}

    public function valueRange(): string
{
    return $this->get_valueRange();
}

    public function setValueRange(string $newval)
{
    return $this->set_valueRange($newval);
}

    public function setSignalBias(float $newval)
{
    return $this->set_signalBias($newval);
}

    public function signalBias(): float
{
    return $this->get_signalBias();
}

    public function signalSampling(): int
{
    return $this->get_signalSampling();
}

    public function setSignalSampling(int $newval)
{
    return $this->set_signalSampling($newval);
}

    public function enabled(): int
{
    return $this->get_enabled();
}

    public function setEnabled(int $newval)
{
    return $this->set_enabled($newval);
}

    /**
     * Continues the enumeration of generic sensors started using yFirstGenericSensor().
     * Caution: You can't make any assumption about the returned generic sensors order.
     * If you want to find a specific a generic sensor, use GenericSensor.findGenericSensor()
     * and a hardwareID or a logical name.
     *
     * @return YGenericSensor  a pointer to a YGenericSensor object, corresponding to
     *         a generic sensor currently online, or a null pointer
     *         if there are no more generic sensors to enumerate.
     */
    public function nextGenericSensor(): ?YGenericSensor
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindGenericSensor($next_hwid);
    }

    /**
     * Starts the enumeration of generic sensors currently accessible.
     * Use the method YGenericSensor::nextGenericSensor() to iterate on
     * next generic sensors.
     *
     * @return YGenericSensor  a pointer to a YGenericSensor object, corresponding to
     *         the first generic sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstGenericSensor()
    {
        $next_hwid = YAPI::getFirstHardwareId('GenericSensor');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindGenericSensor($next_hwid);
    }

    //--- (end of YGenericSensor implementation)

}
