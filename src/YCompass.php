<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YCompass Class: compass function control interface, available for instance in the Yocto-3D-V2
 *
 * The YCompass class allows you to read and configure Yoctopuce compass functions.
 * It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, and to access the autonomous datalogger.
 */
class YCompass extends YSensor
{
    const BANDWIDTH_INVALID = YAPI::INVALID_UINT;
    const AXIS_X = 0;
    const AXIS_Y = 1;
    const AXIS_Z = 2;
    const AXIS_INVALID = -1;
    const MAGNETICHEADING_INVALID = YAPI::INVALID_DOUBLE;
    //--- (end of YCompass declaration)

    //--- (YCompass attributes)
    protected int $_bandwidth = self::BANDWIDTH_INVALID;      // UInt31
    protected int $_axis = self::AXIS_INVALID;           // Axis
    protected float $_magneticHeading = self::MAGNETICHEADING_INVALID; // MeasureVal

    //--- (end of YCompass attributes)

    function __construct(string $str_func)
    {
        //--- (YCompass constructor)
        parent::__construct($str_func);
        $this->_className = 'Compass';

        //--- (end of YCompass constructor)
    }

    //--- (YCompass implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'bandwidth':
            $this->_bandwidth = intval($val);
            return 1;
        case 'axis':
            $this->_axis = intval($val);
            return 1;
        case 'magneticHeading':
            $this->_magneticHeading = round($val / 65.536) / 1000.0;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the measure update frequency, measured in Hz.
     *
     * @return int  an integer corresponding to the measure update frequency, measured in Hz
     *
     * On failure, throws an exception or returns YCompass::BANDWIDTH_INVALID.
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
     * Returns the magnetic heading, regardless of the configured bearing.
     *
     * @return float  a floating point number corresponding to the magnetic heading, regardless of the
     * configured bearing
     *
     * On failure, throws an exception or returns YCompass::MAGNETICHEADING_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_magneticHeading(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::MAGNETICHEADING_INVALID;
            }
        }
        $res = $this->_magneticHeading;
        return $res;
    }

    /**
     * Retrieves a compass function for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the compass function is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the compass function is
     * indeed online at a given time. In case of ambiguity when looking for
     * a compass function by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the compass function, for instance
     *         Y3DMK002.compass.
     *
     * @return YCompass  a YCompass object allowing you to drive the compass function.
     */
    public static function FindCompass(string $func): YCompass
    {
        // $obj                    is a YCompass;
        $obj = YFunction::_FindFromCache('Compass', $func);
        if ($obj == null) {
            $obj = new YCompass($func);
            YFunction::_AddToCache('Compass', $func, $obj);
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
    public function axis(): int
{
    return $this->get_axis();
}

    /**
     * @throws YAPI_Exception
     */
    public function magneticHeading(): float
{
    return $this->get_magneticHeading();
}

    /**
     * Continues the enumeration of compass functions started using yFirstCompass().
     * Caution: You can't make any assumption about the returned compass functions order.
     * If you want to find a specific a compass function, use Compass.findCompass()
     * and a hardwareID or a logical name.
     *
     * @return ?YCompass  a pointer to a YCompass object, corresponding to
     *         a compass function currently online, or a null pointer
     *         if there are no more compass functions to enumerate.
     */
    public function nextCompass(): ?YCompass
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindCompass($next_hwid);
    }

    /**
     * Starts the enumeration of compass functions currently accessible.
     * Use the method YCompass::nextCompass() to iterate on
     * next compass functions.
     *
     * @return ?YCompass  a pointer to a YCompass object, corresponding to
     *         the first compass function currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstCompass(): ?YCompass
    {
        $next_hwid = YAPI::getFirstHardwareId('Compass');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindCompass($next_hwid);
    }

    //--- (end of YCompass implementation)

}
