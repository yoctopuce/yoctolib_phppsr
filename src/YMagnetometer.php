<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YMagnetometer Class: magnetometer control interface, available for instance in the Yocto-3D-V2
 *
 * The YSensor class is the parent class for all Yoctopuce sensor types. It can be
 * used to read the current value and unit of any sensor, read the min/max
 * value, configure autonomous recording frequency and access recorded data.
 * It also provide a function to register a callback invoked each time the
 * observed value changes, or at a predefined interval. Using this class rather
 * than a specific subclass makes it possible to create generic applications
 * that work with any Yoctopuce sensor, even those that do not yet exist.
 * Note: The YAnButton class is the only analog input which does not inherit
 * from YSensor.
 */
class YMagnetometer extends YSensor
{
    const BANDWIDTH_INVALID = YAPI::INVALID_UINT;
    const XVALUE_INVALID = YAPI::INVALID_DOUBLE;
    const YVALUE_INVALID = YAPI::INVALID_DOUBLE;
    const ZVALUE_INVALID = YAPI::INVALID_DOUBLE;
    //--- (end of YMagnetometer declaration)

    //--- (YMagnetometer attributes)
    protected int $_bandwidth = self::BANDWIDTH_INVALID;      // UInt31
    protected float $_xValue = self::XVALUE_INVALID;         // MeasureVal
    protected float $_yValue = self::YVALUE_INVALID;         // MeasureVal
    protected float $_zValue = self::ZVALUE_INVALID;         // MeasureVal

    //--- (end of YMagnetometer attributes)

    function __construct(string $str_func)
    {
        //--- (YMagnetometer constructor)
        parent::__construct($str_func);
        $this->_className = 'Magnetometer';

        //--- (end of YMagnetometer constructor)
    }

    //--- (YMagnetometer implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'bandwidth':
            $this->_bandwidth = intval($val);
            return 1;
        case 'xValue':
            $this->_xValue = round($val / 65.536) / 1000.0;
            return 1;
        case 'yValue':
            $this->_yValue = round($val / 65.536) / 1000.0;
            return 1;
        case 'zValue':
            $this->_zValue = round($val / 65.536) / 1000.0;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the measure update frequency, measured in Hz.
     *
     * @return int  an integer corresponding to the measure update frequency, measured in Hz
     *
     * On failure, throws an exception or returns YMagnetometer::BANDWIDTH_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_bandwidth(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::BANDWIDTH_INVALID;
            }
        }
        $res = $this->_bandwidth;
        return $res;
    }

    /**
     * Changes the measure update frequency, measured in Hz. When the
     * frequency is lower, the device performs averaging.
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param int $newval : an integer corresponding to the measure update frequency, measured in Hz
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_bandwidth(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("bandwidth", $rest_val);
    }

    /**
     * Returns the X component of the magnetic field, as a floating point number.
     *
     * @return float  a floating point number corresponding to the X component of the magnetic field, as a
     * floating point number
     *
     * On failure, throws an exception or returns YMagnetometer::XVALUE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_xValue(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::XVALUE_INVALID;
            }
        }
        $res = $this->_xValue;
        return $res;
    }

    /**
     * Returns the Y component of the magnetic field, as a floating point number.
     *
     * @return float  a floating point number corresponding to the Y component of the magnetic field, as a
     * floating point number
     *
     * On failure, throws an exception or returns YMagnetometer::YVALUE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_yValue(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::YVALUE_INVALID;
            }
        }
        $res = $this->_yValue;
        return $res;
    }

    /**
     * Returns the Z component of the magnetic field, as a floating point number.
     *
     * @return float  a floating point number corresponding to the Z component of the magnetic field, as a
     * floating point number
     *
     * On failure, throws an exception or returns YMagnetometer::ZVALUE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_zValue(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::ZVALUE_INVALID;
            }
        }
        $res = $this->_zValue;
        return $res;
    }

    /**
     * Retrieves a magnetometer for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the magnetometer is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the magnetometer is
     * indeed online at a given time. In case of ambiguity when looking for
     * a magnetometer by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the magnetometer, for instance
     *         Y3DMK002.magnetometer.
     *
     * @return YMagnetometer  a YMagnetometer object allowing you to drive the magnetometer.
     */
    public static function FindMagnetometer(string $func): YMagnetometer
    {
        // $obj                    is a YMagnetometer;
        $obj = YFunction::_FindFromCache('Magnetometer', $func);
        if ($obj == null) {
            $obj = new YMagnetometer($func);
            YFunction::_AddToCache('Magnetometer', $func, $obj);
        }
        return $obj;
    }

    /**
     * @throws YAPI_Exception
     */
    public function bandwidth(): int
{
    return $this->get_bandwidth();
}

    /**
     * @throws YAPI_Exception
     */
    public function setBandwidth(int $newval): int
{
    return $this->set_bandwidth($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function xValue(): float
{
    return $this->get_xValue();
}

    /**
     * @throws YAPI_Exception
     */
    public function yValue(): float
{
    return $this->get_yValue();
}

    /**
     * @throws YAPI_Exception
     */
    public function zValue(): float
{
    return $this->get_zValue();
}

    /**
     * Continues the enumeration of magnetometers started using yFirstMagnetometer().
     * Caution: You can't make any assumption about the returned magnetometers order.
     * If you want to find a specific a magnetometer, use Magnetometer.findMagnetometer()
     * and a hardwareID or a logical name.
     *
     * @return ?YMagnetometer  a pointer to a YMagnetometer object, corresponding to
     *         a magnetometer currently online, or a null pointer
     *         if there are no more magnetometers to enumerate.
     */
    public function nextMagnetometer(): ?YMagnetometer
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindMagnetometer($next_hwid);
    }

    /**
     * Starts the enumeration of magnetometers currently accessible.
     * Use the method YMagnetometer::nextMagnetometer() to iterate on
     * next magnetometers.
     *
     * @return ?YMagnetometer  a pointer to a YMagnetometer object, corresponding to
     *         the first magnetometer currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstMagnetometer(): ?YMagnetometer
    {
        $next_hwid = YAPI::getFirstHardwareId('Magnetometer');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindMagnetometer($next_hwid);
    }

    //--- (end of YMagnetometer implementation)

}
