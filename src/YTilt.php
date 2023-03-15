<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YTilt Class: tilt sensor control interface, available for instance in the Yocto-3D-V2 or the Yocto-Inclinometer
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
class YTilt extends YSensor
{
    const BANDWIDTH_INVALID = YAPI::INVALID_UINT;
    const AXIS_X = 0;
    const AXIS_Y = 1;
    const AXIS_Z = 2;
    const AXIS_INVALID = -1;
    //--- (end of YTilt declaration)

    //--- (YTilt attributes)
    protected int $_bandwidth = self::BANDWIDTH_INVALID;      // UInt31
    protected int $_axis = self::AXIS_INVALID;           // Axis

    //--- (end of YTilt attributes)

    function __construct(string $str_func)
    {
        //--- (YTilt constructor)
        parent::__construct($str_func);
        $this->_className = 'Tilt';

        //--- (end of YTilt constructor)
    }

    //--- (YTilt implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'bandwidth':
            $this->_bandwidth = intval($val);
            return 1;
        case 'axis':
            $this->_axis = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the measure update frequency, measured in Hz.
     *
     * @return int  an integer corresponding to the measure update frequency, measured in Hz
     *
     * On failure, throws an exception or returns YTilt::BANDWIDTH_INVALID.
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
     * @throws YAPI_Exception on error
     */
    public function get_axis(): int
    {
        // $res                    is a enumAXIS;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::AXIS_INVALID;
            }
        }
        $res = $this->_axis;
        return $res;
    }

    /**
     * Retrieves a tilt sensor for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the tilt sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the tilt sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a tilt sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the tilt sensor, for instance
     *         Y3DMK002.tilt1.
     *
     * @return YTilt  a YTilt object allowing you to drive the tilt sensor.
     */
    public static function FindTilt(string $func): YTilt
    {
        // $obj                    is a YTilt;
        $obj = YFunction::_FindFromCache('Tilt', $func);
        if ($obj == null) {
            $obj = new YTilt($func);
            YFunction::_AddToCache('Tilt', $func, $obj);
        }
        return $obj;
    }

    /**
     * Performs a zero calibration for the tilt measurement (Yocto-Inclinometer only).
     * When this method is invoked, a simple shift (translation)
     * is applied so that the current position is reported as a zero angle.
     * Be aware that this shift will also affect the measurement boundaries.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function calibrateToZero(): int
    {
        // $currentRawVal          is a float;
        $rawVals = [];          // floatArr;
        $refVals = [];          // floatArr;
        $currentRawVal = $this->get_currentRawValue();
        while (sizeof($rawVals) > 0) {
            array_pop($rawVals);
        };
        while (sizeof($refVals) > 0) {
            array_pop($refVals);
        };
        $rawVals[] = $currentRawVal;
        $refVals[] = 0.0;
        return $this->calibrateFromPoints($rawVals, $refVals);
    }

    /**
     * Cancels any previous zero calibration for the tilt measurement (Yocto-Inclinometer only).
     * This function restores the factory zero calibration.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function restoreZeroCalibration(): int
    {
        return $this->_setAttr('calibrationParam', '0');
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
    public function axis(): int
{
    return $this->get_axis();
}

    /**
     * Continues the enumeration of tilt sensors started using yFirstTilt().
     * Caution: You can't make any assumption about the returned tilt sensors order.
     * If you want to find a specific a tilt sensor, use Tilt.findTilt()
     * and a hardwareID or a logical name.
     *
     * @return ?YTilt  a pointer to a YTilt object, corresponding to
     *         a tilt sensor currently online, or a null pointer
     *         if there are no more tilt sensors to enumerate.
     */
    public function nextTilt(): ?YTilt
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindTilt($next_hwid);
    }

    /**
     * Starts the enumeration of tilt sensors currently accessible.
     * Use the method YTilt::nextTilt() to iterate on
     * next tilt sensors.
     *
     * @return ?YTilt  a pointer to a YTilt object, corresponding to
     *         the first tilt sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstTilt(): ?YTilt
    {
        $next_hwid = YAPI::getFirstHardwareId('Tilt');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindTilt($next_hwid);
    }

    //--- (end of YTilt implementation)

}
