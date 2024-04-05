<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YAltitude Class: altimeter control interface, available for instance in the Yocto-Altimeter-V2 or
 * the Yocto-GPS-V2
 *
 * The YAltitude class allows you to read and configure Yoctopuce altimeters.
 * It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, and to access the autonomous datalogger.
 * This class adds the ability to configure the barometric pressure adjusted to
 * sea level (QNH) for barometric sensors.
 */
class YAltitude extends YSensor
{
    const QNH_INVALID = YAPI::INVALID_DOUBLE;
    const TECHNOLOGY_INVALID = YAPI::INVALID_STRING;
    //--- (end of YAltitude declaration)

    //--- (YAltitude attributes)
    protected float $_qnh = self::QNH_INVALID;            // MeasureVal
    protected string $_technology = self::TECHNOLOGY_INVALID;     // Text

    //--- (end of YAltitude attributes)

    function __construct(string $str_func)
    {
        //--- (YAltitude constructor)
        parent::__construct($str_func);
        $this->_className = 'Altitude';

        //--- (end of YAltitude constructor)
    }

    //--- (YAltitude implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'qnh':
            $this->_qnh = round($val / 65.536) / 1000.0;
            return 1;
        case 'technology':
            $this->_technology = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Changes the current estimated altitude. This allows one to compensate for
     * ambient pressure variations and to work in relative mode.
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param float $newval : a floating point number corresponding to the current estimated altitude
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_currentValue(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("currentValue", $rest_val);
    }

    /**
     * Changes the barometric pressure adjusted to sea level used to compute
     * the altitude (QNH). This enables you to compensate for atmospheric pressure
     * changes due to weather conditions. Applicable to barometric altimeters only.
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param float $newval : a floating point number corresponding to the barometric pressure adjusted to
     * sea level used to compute
     *         the altitude (QNH)
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_qnh(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("qnh", $rest_val);
    }

    /**
     * Returns the barometric pressure adjusted to sea level used to compute
     * the altitude (QNH). Applicable to barometric altimeters only.
     *
     * @return float  a floating point number corresponding to the barometric pressure adjusted to sea
     * level used to compute
     *         the altitude (QNH)
     *
     * On failure, throws an exception or returns YAltitude::QNH_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_qnh(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::QNH_INVALID;
            }
        }
        $res = $this->_qnh;
        return $res;
    }

    /**
     * Returns the technology used by the sesnor to compute
     * altitude. Possibles values are  "barometric" and "gps"
     *
     * @return string  a string corresponding to the technology used by the sesnor to compute
     *         altitude
     *
     * On failure, throws an exception or returns YAltitude::TECHNOLOGY_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_technology(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::TECHNOLOGY_INVALID;
            }
        }
        $res = $this->_technology;
        return $res;
    }

    /**
     * Retrieves an altimeter for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the altimeter is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the altimeter is
     * indeed online at a given time. In case of ambiguity when looking for
     * an altimeter by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the altimeter, for instance
     *         YALTIMK2.altitude.
     *
     * @return YAltitude  a YAltitude object allowing you to drive the altimeter.
     */
    public static function FindAltitude(string $func): YAltitude
    {
        // $obj                    is a YAltitude;
        $obj = YFunction::_FindFromCache('Altitude', $func);
        if ($obj == null) {
            $obj = new YAltitude($func);
            YFunction::_AddToCache('Altitude', $func, $obj);
        }
        return $obj;
    }

    /**
     * @throws YAPI_Exception
     */
    public function setCurrentValue(float $newval): int
{
    return $this->set_currentValue($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function setQnh(float $newval): int
{
    return $this->set_qnh($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function qnh(): float
{
    return $this->get_qnh();
}

    /**
     * @throws YAPI_Exception
     */
    public function technology(): string
{
    return $this->get_technology();
}

    /**
     * Continues the enumeration of altimeters started using yFirstAltitude().
     * Caution: You can't make any assumption about the returned altimeters order.
     * If you want to find a specific an altimeter, use Altitude.findAltitude()
     * and a hardwareID or a logical name.
     *
     * @return ?YAltitude  a pointer to a YAltitude object, corresponding to
     *         an altimeter currently online, or a null pointer
     *         if there are no more altimeters to enumerate.
     */
    public function nextAltitude(): ?YAltitude
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindAltitude($next_hwid);
    }

    /**
     * Starts the enumeration of altimeters currently accessible.
     * Use the method YAltitude::nextAltitude() to iterate on
     * next altimeters.
     *
     * @return ?YAltitude  a pointer to a YAltitude object, corresponding to
     *         the first altimeter currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstAltitude(): ?YAltitude
    {
        $next_hwid = YAPI::getFirstHardwareId('Altitude');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindAltitude($next_hwid);
    }

    //--- (end of YAltitude implementation)

}
