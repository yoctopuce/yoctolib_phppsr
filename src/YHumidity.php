<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YHumidity Class: humidity sensor control interface, available for instance in the Yocto-CO2-V2, the
 * Yocto-Meteo-V2 or the Yocto-VOC-V3
 *
 * The YHumidity class allows you to read and configure Yoctopuce humidity sensors.
 * It inherits from YSensor class the core functions to read measures,
 * to register callback functions, and to access the autonomous datalogger.
 */
class YHumidity extends YSensor
{
    const RELHUM_INVALID = YAPI::INVALID_DOUBLE;
    const ABSHUM_INVALID = YAPI::INVALID_DOUBLE;
    //--- (end of YHumidity declaration)

    //--- (YHumidity attributes)
    protected float $_relHum = self::RELHUM_INVALID;         // MeasureVal
    protected float $_absHum = self::ABSHUM_INVALID;         // MeasureVal

    //--- (end of YHumidity attributes)

    function __construct(string $str_func)
    {
        //--- (YHumidity constructor)
        parent::__construct($str_func);
        $this->_className = 'Humidity';

        //--- (end of YHumidity constructor)
    }

    //--- (YHumidity implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'relHum':
            $this->_relHum = round($val / 65.536) / 1000.0;
            return 1;
        case 'absHum':
            $this->_absHum = round($val / 65.536) / 1000.0;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Changes the primary unit for measuring humidity. That unit is a string.
     * If that strings starts with the letter 'g', the primary measured value is the absolute
     * humidity, in g/m3. Otherwise, the primary measured value will be the relative humidity
     * (RH), in per cents.
     *
     * Remember to call the saveToFlash() method of the module if the modification
     * must be kept.
     *
     * @param string $newval : a string corresponding to the primary unit for measuring humidity
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
     * Returns the current relative humidity, in per cents.
     *
     * @return float  a floating point number corresponding to the current relative humidity, in per cents
     *
     * On failure, throws an exception or returns YHumidity::RELHUM_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_relHum(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::RELHUM_INVALID;
            }
        }
        $res = $this->_relHum;
        return $res;
    }

    /**
     * Returns the current absolute humidity, in grams per cubic meter of air.
     *
     * @return float  a floating point number corresponding to the current absolute humidity, in grams per
     * cubic meter of air
     *
     * On failure, throws an exception or returns YHumidity::ABSHUM_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_absHum(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::ABSHUM_INVALID;
            }
        }
        $res = $this->_absHum;
        return $res;
    }

    /**
     * Retrieves a humidity sensor for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the humidity sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the humidity sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a humidity sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the humidity sensor, for instance
     *         YCO2MK02.humidity.
     *
     * @return YHumidity  a YHumidity object allowing you to drive the humidity sensor.
     */
    public static function FindHumidity(string $func): YHumidity
    {
        // $obj                    is a YHumidity;
        $obj = YFunction::_FindFromCache('Humidity', $func);
        if ($obj == null) {
            $obj = new YHumidity($func);
            YFunction::_AddToCache('Humidity', $func, $obj);
        }
        return $obj;
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
    public function relHum(): float
{
    return $this->get_relHum();
}

    /**
     * @throws YAPI_Exception
     */
    public function absHum(): float
{
    return $this->get_absHum();
}

    /**
     * Continues the enumeration of humidity sensors started using yFirstHumidity().
     * Caution: You can't make any assumption about the returned humidity sensors order.
     * If you want to find a specific a humidity sensor, use Humidity.findHumidity()
     * and a hardwareID or a logical name.
     *
     * @return ?YHumidity  a pointer to a YHumidity object, corresponding to
     *         a humidity sensor currently online, or a null pointer
     *         if there are no more humidity sensors to enumerate.
     */
    public function nextHumidity(): ?YHumidity
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindHumidity($next_hwid);
    }

    /**
     * Starts the enumeration of humidity sensors currently accessible.
     * Use the method YHumidity::nextHumidity() to iterate on
     * next humidity sensors.
     *
     * @return ?YHumidity  a pointer to a YHumidity object, corresponding to
     *         the first humidity sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstHumidity(): ?YHumidity
    {
        $next_hwid = YAPI::getFirstHardwareId('Humidity');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindHumidity($next_hwid);
    }

    //--- (end of YHumidity implementation)

}
