<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YAirQuality Class: air quality sensor control interface
 *
 * The YAirQuality class allows you to read and configure Yoctopuce air quality sensors.
 * It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, and to access the autonomous datalogger.
 */
class YAirQuality extends YSensor
{
    const UBAINDEX_INVALID = YAPI::INVALID_DOUBLE;
    const RELATIVEINDEX_INVALID = YAPI::INVALID_DOUBLE;
    const AQIMODE_RELATIVE = 0;
    const AQIMODE_UBA = 1;
    const AQIMODE_INVALID = -1;
    //--- (end of YAirQuality declaration)

    //--- (YAirQuality attributes)
    protected float $_ubaIndex = self::UBAINDEX_INVALID;       // MeasureVal
    protected float $_relativeIndex = self::RELATIVEINDEX_INVALID;  // MeasureVal
    protected int $_aqiMode = self::AQIMODE_INVALID;        // AirQualityIndexType

    //--- (end of YAirQuality attributes)

    function __construct(string $str_func)
    {
        //--- (YAirQuality constructor)
        parent::__construct($str_func);
        $this->_className = 'AirQuality';

        //--- (end of YAirQuality constructor)
    }

    //--- (YAirQuality implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'ubaIndex':
            $this->_ubaIndex = round($val / 65.536) / 1000.0;
            return 1;
        case 'relativeIndex':
            $this->_relativeIndex = round($val / 65.536) / 1000.0;
            return 1;
        case 'aqiMode':
            $this->_aqiMode = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the current air quality index, according to UBA (from 1 to 5).
     *
     * @return float  a floating point number corresponding to the current air quality index, according to
     * UBA (from 1 to 5)
     *
     * On failure, throws an exception or returns YAirQuality::UBAINDEX_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_ubaIndex(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::UBAINDEX_INVALID;
            }
        }
        $res = $this->_ubaIndex;
        return $res;
    }

    /**
     * Returns the relative air quality index, according to ScioSense (from 0 to 500).
     * A value below 100 indicates better-than-average air quality compared to the past 24 hours,
     * while a value above 100 indicates poorer-than-average air quality compared to the past 24 hours.
     *
     * @return float  a floating point number corresponding to the relative air quality index, according
     * to ScioSense (from 0 to 500)
     *
     * On failure, throws an exception or returns YAirQuality::RELATIVEINDEX_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_relativeIndex(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::RELATIVEINDEX_INVALID;
            }
        }
        $res = $this->_relativeIndex;
        return $res;
    }

    /**
     * Returns the type of index reported by the get_currentValue function and callbacks (UBA index or relative index).
     *
     * @return int  either YAirQuality::AQIMODE_RELATIVE or YAirQuality::AQIMODE_UBA, according to the type
     * of index reported by the get_currentValue function and callbacks (UBA index or relative index)
     *
     * On failure, throws an exception or returns YAirQuality::AQIMODE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_aqiMode(): int
    {
        // $res                    is a enumAIRQUALITYINDEXTYPE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::AQIMODE_INVALID;
            }
        }
        $res = $this->_aqiMode;
        return $res;
    }

    /**
     * Changes the the type of index reported by the get_currentValue function and callbacks (UBA index or
     * relative index).
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @param int $newval : either YAirQuality::AQIMODE_RELATIVE or YAirQuality::AQIMODE_UBA, according to
     * the the type of index reported by the get_currentValue function and callbacks (UBA index or relative index)
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_aqiMode(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("aqiMode", $rest_val);
    }

    /**
     * Retrieves a air quality sensor for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the air quality sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the air quality sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a air quality sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the air quality sensor, for instance
     *         MyDevice.airQuality.
     *
     * @return YAirQuality  a YAirQuality object allowing you to drive the air quality sensor.
     */
    public static function FindAirQuality(string $func): YAirQuality
    {
        // $obj                    is a YAirQuality;
        $obj = YFunction::_FindFromCache('AirQuality', $func);
        if ($obj == null) {
            $obj = new YAirQuality($func);
            YFunction::_AddToCache('AirQuality', $func, $obj);
        }
        return $obj;
    }

    /**
     * @throws YAPI_Exception
     */
    public function ubaIndex(): float
{
    return $this->get_ubaIndex();
}

    /**
     * @throws YAPI_Exception
     */
    public function relativeIndex(): float
{
    return $this->get_relativeIndex();
}

    /**
     * @throws YAPI_Exception
     */
    public function aqiMode(): int
{
    return $this->get_aqiMode();
}

    /**
     * @throws YAPI_Exception
     */
    public function setAqiMode(int $newval): int
{
    return $this->set_aqiMode($newval);
}

    /**
     * Continues the enumeration of air quality sensors started using yFirstAirQuality().
     * Caution: You can't make any assumption about the returned air quality sensors order.
     * If you want to find a specific a air quality sensor, use AirQuality.findAirQuality()
     * and a hardwareID or a logical name.
     *
     * @return ?YAirQuality  a pointer to a YAirQuality object, corresponding to
     *         a air quality sensor currently online, or a null pointer
     *         if there are no more air quality sensors to enumerate.
     */
    public function nextAirQuality(): ?YAirQuality
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindAirQuality($next_hwid);
    }

    /**
     * Starts the enumeration of air quality sensors currently accessible.
     * Use the method YAirQuality::nextAirQuality() to iterate on
     * next air quality sensors.
     *
     * @return ?YAirQuality  a pointer to a YAirQuality object, corresponding to
     *         the first air quality sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstAirQuality(): ?YAirQuality
    {
        $next_hwid = YAPI::getFirstHardwareId('AirQuality');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindAirQuality($next_hwid);
    }

    //--- (end of YAirQuality implementation)

}
