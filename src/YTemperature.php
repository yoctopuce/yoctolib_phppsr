<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YTemperature Class: temperature sensor control interface, available for instance in the
 * Yocto-Meteo-V2, the Yocto-PT100, the Yocto-Temperature or the Yocto-Thermocouple
 *
 * The YTemperature class allows you to read and configure Yoctopuce temperature sensors.
 * It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, and to access the autonomous datalogger.
 * This class adds the ability to configure some specific parameters
 * for some sensors (connection type, temperature mapping table).
 */
class YTemperature extends YSensor
{
    const SENSORTYPE_DIGITAL = 0;
    const SENSORTYPE_TYPE_K = 1;
    const SENSORTYPE_TYPE_E = 2;
    const SENSORTYPE_TYPE_J = 3;
    const SENSORTYPE_TYPE_N = 4;
    const SENSORTYPE_TYPE_R = 5;
    const SENSORTYPE_TYPE_S = 6;
    const SENSORTYPE_TYPE_T = 7;
    const SENSORTYPE_PT100_4WIRES = 8;
    const SENSORTYPE_PT100_3WIRES = 9;
    const SENSORTYPE_PT100_2WIRES = 10;
    const SENSORTYPE_RES_OHM = 11;
    const SENSORTYPE_RES_NTC = 12;
    const SENSORTYPE_RES_LINEAR = 13;
    const SENSORTYPE_RES_INTERNAL = 14;
    const SENSORTYPE_IR = 15;
    const SENSORTYPE_RES_PT1000 = 16;
    const SENSORTYPE_CHANNEL_OFF = 17;
    const SENSORTYPE_INVALID = -1;
    const SIGNALVALUE_INVALID = YAPI::INVALID_DOUBLE;
    const SIGNALUNIT_INVALID = YAPI::INVALID_STRING;
    const COMMAND_INVALID = YAPI::INVALID_STRING;
    //--- (end of YTemperature declaration)

    //--- (YTemperature attributes)
    protected int $_sensorType = self::SENSORTYPE_INVALID;     // TempSensorTypeAll
    protected float $_signalValue = self::SIGNALVALUE_INVALID;    // MeasureVal
    protected string $_signalUnit = self::SIGNALUNIT_INVALID;     // Text
    protected string $_command = self::COMMAND_INVALID;        // Text

    //--- (end of YTemperature attributes)

    function __construct(string $str_func)
    {
        //--- (YTemperature constructor)
        parent::__construct($str_func);
        $this->_className = 'Temperature';

        //--- (end of YTemperature constructor)
    }

    //--- (YTemperature implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'sensorType':
            $this->_sensorType = intval($val);
            return 1;
        case 'signalValue':
            $this->_signalValue = round($val / 65.536) / 1000.0;
            return 1;
        case 'signalUnit':
            $this->_signalUnit = $val;
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Changes the measuring unit for the measured temperature. That unit is a string.
     * If that strings end with the letter F all temperatures values will returned in
     * Fahrenheit degrees. If that String ends with the letter K all values will be
     * returned in Kelvin degrees. If that string ends with the letter C all values will be
     * returned in Celsius degrees.  If the string ends with any other character the
     * change will be ignored. Remember to call the
     * saveToFlash() method of the module if the modification must be kept.
     * WARNING: if a specific calibration is defined for the temperature function, a
     * unit system change will probably break it.
     *
     * @param string $newval : a string corresponding to the measuring unit for the measured temperature
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
     * Returns the temperature sensor type.
     *
     * @return int  a value among YTemperature::SENSORTYPE_DIGITAL, YTemperature::SENSORTYPE_TYPE_K,
     * YTemperature::SENSORTYPE_TYPE_E, YTemperature::SENSORTYPE_TYPE_J, YTemperature::SENSORTYPE_TYPE_N,
     * YTemperature::SENSORTYPE_TYPE_R, YTemperature::SENSORTYPE_TYPE_S, YTemperature::SENSORTYPE_TYPE_T,
     * YTemperature::SENSORTYPE_PT100_4WIRES, YTemperature::SENSORTYPE_PT100_3WIRES,
     * YTemperature::SENSORTYPE_PT100_2WIRES, YTemperature::SENSORTYPE_RES_OHM,
     * YTemperature::SENSORTYPE_RES_NTC, YTemperature::SENSORTYPE_RES_LINEAR,
     * YTemperature::SENSORTYPE_RES_INTERNAL, YTemperature::SENSORTYPE_IR,
     * YTemperature::SENSORTYPE_RES_PT1000 and YTemperature::SENSORTYPE_CHANNEL_OFF corresponding to the
     * temperature sensor type
     *
     * On failure, throws an exception or returns YTemperature::SENSORTYPE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_sensorType(): int
    {
        // $res                    is a enumTEMPSENSORTYPEALL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SENSORTYPE_INVALID;
            }
        }
        $res = $this->_sensorType;
        return $res;
    }

    /**
     * Changes the temperature sensor type.  This function is used
     * to define the type of thermocouple (K,E...) used with the device.
     * It has no effect if module is using a digital sensor or a thermistor.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param int $newval : a value among YTemperature::SENSORTYPE_DIGITAL, YTemperature::SENSORTYPE_TYPE_K,
     * YTemperature::SENSORTYPE_TYPE_E, YTemperature::SENSORTYPE_TYPE_J, YTemperature::SENSORTYPE_TYPE_N,
     * YTemperature::SENSORTYPE_TYPE_R, YTemperature::SENSORTYPE_TYPE_S, YTemperature::SENSORTYPE_TYPE_T,
     * YTemperature::SENSORTYPE_PT100_4WIRES, YTemperature::SENSORTYPE_PT100_3WIRES,
     * YTemperature::SENSORTYPE_PT100_2WIRES, YTemperature::SENSORTYPE_RES_OHM,
     * YTemperature::SENSORTYPE_RES_NTC, YTemperature::SENSORTYPE_RES_LINEAR,
     * YTemperature::SENSORTYPE_RES_INTERNAL, YTemperature::SENSORTYPE_IR,
     * YTemperature::SENSORTYPE_RES_PT1000 and YTemperature::SENSORTYPE_CHANNEL_OFF corresponding to the
     * temperature sensor type
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_sensorType(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("sensorType", $rest_val);
    }

    /**
     * Returns the current value of the electrical signal measured by the sensor.
     *
     * @return float  a floating point number corresponding to the current value of the electrical signal
     * measured by the sensor
     *
     * On failure, throws an exception or returns YTemperature::SIGNALVALUE_INVALID.
     * @throws YAPI_Exception on error
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
     * On failure, throws an exception or returns YTemperature::SIGNALUNIT_INVALID.
     * @throws YAPI_Exception on error
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
     * @throws YAPI_Exception on error
     */
    public function get_command(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::COMMAND_INVALID;
            }
        }
        $res = $this->_command;
        return $res;
    }

    /**
     * @throws YAPI_Exception
     */
    public function set_command(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("command", $rest_val);
    }

    /**
     * Retrieves a temperature sensor for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the temperature sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the temperature sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a temperature sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the temperature sensor, for instance
     *         METEOMK2.temperature.
     *
     * @return YTemperature  a YTemperature object allowing you to drive the temperature sensor.
     */
    public static function FindTemperature(string $func): YTemperature
    {
        // $obj                    is a YTemperature;
        $obj = YFunction::_FindFromCache('Temperature', $func);
        if ($obj == null) {
            $obj = new YTemperature($func);
            YFunction::_AddToCache('Temperature', $func, $obj);
        }
        return $obj;
    }

    /**
     * Configures NTC thermistor parameters in order to properly compute the temperature from
     * the measured resistance. For increased precision, you can enter a complete mapping
     * table using set_thermistorResponseTable. This function can only be used with a
     * temperature sensor based on thermistors.
     *
     * @param float $res25 : thermistor resistance at 25 degrees Celsius
     * @param float $beta : Beta value
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_ntcParameters(float $res25, float $beta): int
    {
        // $t0                     is a float;
        // $t1                     is a float;
        // $res100                 is a float;
        $tempValues = [];       // floatArr;
        $resValues = [];        // floatArr;
        $t0 = 25.0+273.15;
        $t1 = 100.0+273.15;
        $res100 = $res25 * exp($beta*(1.0/$t1 - 1.0/$t0));
        while (sizeof($tempValues) > 0) {
            array_pop($tempValues);
        };
        while (sizeof($resValues) > 0) {
            array_pop($resValues);
        };
        $tempValues[] = 25.0;
        $resValues[] = $res25;
        $tempValues[] = 100.0;
        $resValues[] = $res100;
        return $this->set_thermistorResponseTable($tempValues, $resValues);
    }

    /**
     * Records a thermistor response table, in order to interpolate the temperature from
     * the measured resistance. This function can only be used with a temperature
     * sensor based on thermistors.
     *
     * @param float[] $tempValues : array of floating point numbers, corresponding to all
     *         temperatures (in degrees Celsius) for which the resistance of the
     *         thermistor is specified.
     * @param float[] $resValues : array of floating point numbers, corresponding to the resistance
     *         values (in Ohms) for each of the temperature included in the first
     *         argument, index by index.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_thermistorResponseTable(array $tempValues, array $resValues): int
    {
        // $siz                    is a int;
        // $res                    is a int;
        // $idx                    is a int;
        // $found                  is a int;
        // $prev                   is a float;
        // $curr                   is a float;
        // $currTemp               is a float;
        // $idxres                 is a float;
        $siz = sizeof($tempValues);
        if (!($siz >= 2)) return $this->_throw(YAPI::INVALID_ARGUMENT,'thermistor response table must have at least two points',YAPI::INVALID_ARGUMENT);
        if (!($siz == sizeof($resValues))) return $this->_throw(YAPI::INVALID_ARGUMENT,'table sizes mismatch',YAPI::INVALID_ARGUMENT);

        $res = $this->set_command('Z');
        if (!($res==YAPI::SUCCESS)) return $this->_throw(YAPI::IO_ERROR,'unable to reset thermistor parameters',YAPI::IO_ERROR);
        // add records in growing resistance value
        $found = 1;
        $prev = 0.0;
        while ($found > 0) {
            $found = 0;
            $curr = 99999999.0;
            $currTemp = -999999.0;
            $idx = 0;
            while ($idx < $siz) {
                $idxres = $resValues[$idx];
                if (($idxres > $prev) && ($idxres < $curr)) {
                    $curr = $idxres;
                    $currTemp = $tempValues[$idx];
                    $found = 1;
                }
                $idx = $idx + 1;
            }
            if ($found > 0) {
                $res = $this->set_command(sprintf('m%d:%d', intval(round(1000*$curr)), intval(round(1000*$currTemp))));
                if (!($res==YAPI::SUCCESS)) return $this->_throw(YAPI::IO_ERROR,'unable to reset thermistor parameters',YAPI::IO_ERROR);
                $prev = $curr;
            }
        }
        return YAPI::SUCCESS;
    }

    /**
     * Retrieves the thermistor response table previously configured using the
     * set_thermistorResponseTable function. This function can only be used with a
     * temperature sensor based on thermistors.
     *
     * @param float[] $tempValues : array of floating point numbers, that is filled by the function
     *         with all temperatures (in degrees Celsius) for which the resistance
     *         of the thermistor is specified.
     * @param float[] $resValues : array of floating point numbers, that is filled by the function
     *         with the value (in Ohms) for each of the temperature included in the
     *         first argument, index by index.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function loadThermistorResponseTable(array &$tempValues, array &$resValues): int
    {
        // $id                     is a str;
        // $bin_json               is a bin;
        $paramlist = [];        // binArr;
        $templist = [];         // floatArr;
        // $siz                    is a int;
        // $idx                    is a int;
        // $temp                   is a float;
        // $found                  is a int;
        // $prev                   is a float;
        // $curr                   is a float;
        // $currRes                is a float;
        while (sizeof($tempValues) > 0) {
            array_pop($tempValues);
        };
        while (sizeof($resValues) > 0) {
            array_pop($resValues);
        };

        $id = $this->get_functionId();
        $id = substr($id, 11, mb_strlen($id) - 11);
        if ($id == '') {
            $id = '1';
        }
        $bin_json = $this->_download(sprintf('extra.json?page=%s', $id));
        $paramlist = $this->_json_get_array($bin_json);
        // first convert all temperatures to float
        $siz = ((sizeof($paramlist)) >> 1);
        while (sizeof($templist) > 0) {
            array_pop($templist);
        };
        $idx = 0;
        while ($idx < $siz) {
            $temp = floatval(YAPI::Ybin2str($paramlist[2*$idx+1]))/1000.0;
            $templist[] = $temp;
            $idx = $idx + 1;
        }
        // then add records in growing temperature value
        while (sizeof($tempValues) > 0) {
            array_pop($tempValues);
        };
        while (sizeof($resValues) > 0) {
            array_pop($resValues);
        };
        $found = 1;
        $prev = -999999.0;
        while ($found > 0) {
            $found = 0;
            $curr = 999999.0;
            $currRes = -999999.0;
            $idx = 0;
            while ($idx < $siz) {
                $temp = $templist[$idx];
                if (($temp > $prev) && ($temp < $curr)) {
                    $curr = $temp;
                    $currRes = floatval(YAPI::Ybin2str($paramlist[2*$idx]))/1000.0;
                    $found = 1;
                }
                $idx = $idx + 1;
            }
            if ($found > 0) {
                $tempValues[] = $curr;
                $resValues[] = $currRes;
                $prev = $curr;
            }
        }
        return YAPI::SUCCESS;
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
    public function sensorType(): int
{
    return $this->get_sensorType();
}

    /**
     * @throws YAPI_Exception
     */
    public function setSensorType(int $newval): int
{
    return $this->set_sensorType($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function signalValue(): float
{
    return $this->get_signalValue();
}

    /**
     * @throws YAPI_Exception
     */
    public function signalUnit(): string
{
    return $this->get_signalUnit();
}

    /**
     * @throws YAPI_Exception
     */
    public function command(): string
{
    return $this->get_command();
}

    /**
     * @throws YAPI_Exception
     */
    public function setCommand(string $newval): int
{
    return $this->set_command($newval);
}

    /**
     * Continues the enumeration of temperature sensors started using yFirstTemperature().
     * Caution: You can't make any assumption about the returned temperature sensors order.
     * If you want to find a specific a temperature sensor, use Temperature.findTemperature()
     * and a hardwareID or a logical name.
     *
     * @return ?YTemperature  a pointer to a YTemperature object, corresponding to
     *         a temperature sensor currently online, or a null pointer
     *         if there are no more temperature sensors to enumerate.
     */
    public function nextTemperature(): ?YTemperature
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindTemperature($next_hwid);
    }

    /**
     * Starts the enumeration of temperature sensors currently accessible.
     * Use the method YTemperature::nextTemperature() to iterate on
     * next temperature sensors.
     *
     * @return ?YTemperature  a pointer to a YTemperature object, corresponding to
     *         the first temperature sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstTemperature(): ?YTemperature
    {
        $next_hwid = YAPI::getFirstHardwareId('Temperature');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindTemperature($next_hwid);
    }

    //--- (end of YTemperature implementation)

}
