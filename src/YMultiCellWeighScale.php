<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YMultiCellWeighScale Class: multi-cell weighing scale sensor control interface, available for
 * instance in the Yocto-MaxiBridge
 *
 * The YMultiCellWeighScale class provides a weight measurement from a set of ratiometric
 * sensors. It can be used to control the bridge excitation parameters, in order to avoid
 * measure shifts caused by temperature variation in the electronics, and can also
 * automatically apply an additional correction factor based on temperature to
 * compensate for offsets in the load cells themselves.
 */
class YMultiCellWeighScale extends YSensor
{
    const CELLCOUNT_INVALID = YAPI::INVALID_UINT;
    const EXTERNALSENSE_FALSE = 0;
    const EXTERNALSENSE_TRUE = 1;
    const EXTERNALSENSE_INVALID = -1;
    const EXCITATION_OFF = 0;
    const EXCITATION_DC = 1;
    const EXCITATION_AC = 2;
    const EXCITATION_INVALID = -1;
    const TEMPAVGADAPTRATIO_INVALID = YAPI::INVALID_DOUBLE;
    const TEMPCHGADAPTRATIO_INVALID = YAPI::INVALID_DOUBLE;
    const COMPTEMPAVG_INVALID = YAPI::INVALID_DOUBLE;
    const COMPTEMPCHG_INVALID = YAPI::INVALID_DOUBLE;
    const COMPENSATION_INVALID = YAPI::INVALID_DOUBLE;
    const ZEROTRACKING_INVALID = YAPI::INVALID_DOUBLE;
    const COMMAND_INVALID = YAPI::INVALID_STRING;
    //--- (end of YMultiCellWeighScale declaration)

    //--- (YMultiCellWeighScale attributes)
    protected int $_cellCount = self::CELLCOUNT_INVALID;      // UInt31
    protected int $_externalSense = self::EXTERNALSENSE_INVALID;  // Bool
    protected int $_excitation = self::EXCITATION_INVALID;     // ExcitationMode
    protected float $_tempAvgAdaptRatio = self::TEMPAVGADAPTRATIO_INVALID; // MeasureVal
    protected float $_tempChgAdaptRatio = self::TEMPCHGADAPTRATIO_INVALID; // MeasureVal
    protected float $_compTempAvg = self::COMPTEMPAVG_INVALID;    // MeasureVal
    protected float $_compTempChg = self::COMPTEMPCHG_INVALID;    // MeasureVal
    protected float $_compensation = self::COMPENSATION_INVALID;   // MeasureVal
    protected float $_zeroTracking = self::ZEROTRACKING_INVALID;   // MeasureVal
    protected string $_command = self::COMMAND_INVALID;        // Text

    //--- (end of YMultiCellWeighScale attributes)

    function __construct(string $str_func)
    {
        //--- (YMultiCellWeighScale constructor)
        parent::__construct($str_func);
        $this->_className = 'MultiCellWeighScale';

        //--- (end of YMultiCellWeighScale constructor)
    }

    //--- (YMultiCellWeighScale implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'cellCount':
            $this->_cellCount = intval($val);
            return 1;
        case 'externalSense':
            $this->_externalSense = intval($val);
            return 1;
        case 'excitation':
            $this->_excitation = intval($val);
            return 1;
        case 'tempAvgAdaptRatio':
            $this->_tempAvgAdaptRatio = round($val / 65.536) / 1000.0;
            return 1;
        case 'tempChgAdaptRatio':
            $this->_tempChgAdaptRatio = round($val / 65.536) / 1000.0;
            return 1;
        case 'compTempAvg':
            $this->_compTempAvg = round($val / 65.536) / 1000.0;
            return 1;
        case 'compTempChg':
            $this->_compTempChg = round($val / 65.536) / 1000.0;
            return 1;
        case 'compensation':
            $this->_compensation = round($val / 65.536) / 1000.0;
            return 1;
        case 'zeroTracking':
            $this->_zeroTracking = round($val / 65.536) / 1000.0;
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Changes the measuring unit for the weight.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param string $newval : a string corresponding to the measuring unit for the weight
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
     * Returns the number of load cells in use.
     *
     * @return int  an integer corresponding to the number of load cells in use
     *
     * On failure, throws an exception or returns YMultiCellWeighScale::CELLCOUNT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_cellCount(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CELLCOUNT_INVALID;
            }
        }
        $res = $this->_cellCount;
        return $res;
    }

    /**
     * Changes the number of load cells in use. Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param int $newval : an integer corresponding to the number of load cells in use
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_cellCount(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("cellCount", $rest_val);
    }

    /**
     * Returns true if entry 4 is used as external sense for 6-wires load cells.
     *
     * @return int  either YMultiCellWeighScale::EXTERNALSENSE_FALSE or
     * YMultiCellWeighScale::EXTERNALSENSE_TRUE, according to true if entry 4 is used as external sense for
     * 6-wires load cells
     *
     * On failure, throws an exception or returns YMultiCellWeighScale::EXTERNALSENSE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_externalSense(): int
    {
        // $res                    is a enumBOOL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::EXTERNALSENSE_INVALID;
            }
        }
        $res = $this->_externalSense;
        return $res;
    }

    /**
     * Changes the configuration to tell if entry 4 is used as external sense for
     * 6-wires load cells. Remember to call the saveToFlash() method of the
     * module if the modification must be kept.
     *
     * @param int $newval : either YMultiCellWeighScale::EXTERNALSENSE_FALSE or
     * YMultiCellWeighScale::EXTERNALSENSE_TRUE, according to the configuration to tell if entry 4 is used
     * as external sense for
     *         6-wires load cells
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_externalSense(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("externalSense", $rest_val);
    }

    /**
     * Returns the current load cell bridge excitation method.
     *
     * @return int  a value among YMultiCellWeighScale::EXCITATION_OFF, YMultiCellWeighScale::EXCITATION_DC
     * and YMultiCellWeighScale::EXCITATION_AC corresponding to the current load cell bridge excitation method
     *
     * On failure, throws an exception or returns YMultiCellWeighScale::EXCITATION_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_excitation(): int
    {
        // $res                    is a enumEXCITATIONMODE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::EXCITATION_INVALID;
            }
        }
        $res = $this->_excitation;
        return $res;
    }

    /**
     * Changes the current load cell bridge excitation method.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param int $newval : a value among YMultiCellWeighScale::EXCITATION_OFF,
     * YMultiCellWeighScale::EXCITATION_DC and YMultiCellWeighScale::EXCITATION_AC corresponding to the
     * current load cell bridge excitation method
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_excitation(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("excitation", $rest_val);
    }

    /**
     * Changes the averaged temperature update rate, in per mille.
     * The purpose of this adaptation ratio is to model the thermal inertia of the load cell.
     * The averaged temperature is updated every 10 seconds, by applying this adaptation rate
     * to the difference between the measures ambient temperature and the current compensation
     * temperature. The standard rate is 0.2 per mille, and the maximal rate is 65 per mille.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param float $newval : a floating point number corresponding to the averaged temperature update
     * rate, in per mille
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_tempAvgAdaptRatio(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("tempAvgAdaptRatio", $rest_val);
    }

    /**
     * Returns the averaged temperature update rate, in per mille.
     * The purpose of this adaptation ratio is to model the thermal inertia of the load cell.
     * The averaged temperature is updated every 10 seconds, by applying this adaptation rate
     * to the difference between the measures ambient temperature and the current compensation
     * temperature. The standard rate is 0.2 per mille, and the maximal rate is 65 per mille.
     *
     * @return float  a floating point number corresponding to the averaged temperature update rate, in per mille
     *
     * On failure, throws an exception or returns YMultiCellWeighScale::TEMPAVGADAPTRATIO_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_tempAvgAdaptRatio(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::TEMPAVGADAPTRATIO_INVALID;
            }
        }
        $res = $this->_tempAvgAdaptRatio;
        return $res;
    }

    /**
     * Changes the temperature change update rate, in per mille.
     * The temperature change is updated every 10 seconds, by applying this adaptation rate
     * to the difference between the measures ambient temperature and the current temperature used for
     * change compensation. The standard rate is 0.6 per mille, and the maximal rate is 65 per mille.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param float $newval : a floating point number corresponding to the temperature change update rate, in per mille
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_tempChgAdaptRatio(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("tempChgAdaptRatio", $rest_val);
    }

    /**
     * Returns the temperature change update rate, in per mille.
     * The temperature change is updated every 10 seconds, by applying this adaptation rate
     * to the difference between the measures ambient temperature and the current temperature used for
     * change compensation. The standard rate is 0.6 per mille, and the maximal rate is 65 per mille.
     *
     * @return float  a floating point number corresponding to the temperature change update rate, in per mille
     *
     * On failure, throws an exception or returns YMultiCellWeighScale::TEMPCHGADAPTRATIO_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_tempChgAdaptRatio(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::TEMPCHGADAPTRATIO_INVALID;
            }
        }
        $res = $this->_tempChgAdaptRatio;
        return $res;
    }

    /**
     * Returns the current averaged temperature, used for thermal compensation.
     *
     * @return float  a floating point number corresponding to the current averaged temperature, used for
     * thermal compensation
     *
     * On failure, throws an exception or returns YMultiCellWeighScale::COMPTEMPAVG_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_compTempAvg(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::COMPTEMPAVG_INVALID;
            }
        }
        $res = $this->_compTempAvg;
        return $res;
    }

    /**
     * Returns the current temperature variation, used for thermal compensation.
     *
     * @return float  a floating point number corresponding to the current temperature variation, used for
     * thermal compensation
     *
     * On failure, throws an exception or returns YMultiCellWeighScale::COMPTEMPCHG_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_compTempChg(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::COMPTEMPCHG_INVALID;
            }
        }
        $res = $this->_compTempChg;
        return $res;
    }

    /**
     * Returns the current current thermal compensation value.
     *
     * @return float  a floating point number corresponding to the current current thermal compensation value
     *
     * On failure, throws an exception or returns YMultiCellWeighScale::COMPENSATION_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_compensation(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::COMPENSATION_INVALID;
            }
        }
        $res = $this->_compensation;
        return $res;
    }

    /**
     * Changes the zero tracking threshold value. When this threshold is larger than
     * zero, any measure under the threshold will automatically be ignored and the
     * zero compensation will be updated.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param float $newval : a floating point number corresponding to the zero tracking threshold value
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_zeroTracking(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("zeroTracking", $rest_val);
    }

    /**
     * Returns the zero tracking threshold value. When this threshold is larger than
     * zero, any measure under the threshold will automatically be ignored and the
     * zero compensation will be updated.
     *
     * @return float  a floating point number corresponding to the zero tracking threshold value
     *
     * On failure, throws an exception or returns YMultiCellWeighScale::ZEROTRACKING_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_zeroTracking(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::ZEROTRACKING_INVALID;
            }
        }
        $res = $this->_zeroTracking;
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
     * Retrieves a multi-cell weighing scale sensor for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the multi-cell weighing scale sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the multi-cell weighing scale sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a multi-cell weighing scale sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the multi-cell weighing scale sensor, for instance
     *         YWMBRDG1.multiCellWeighScale.
     *
     * @return YMultiCellWeighScale  a YMultiCellWeighScale object allowing you to drive the multi-cell
     * weighing scale sensor.
     */
    public static function FindMultiCellWeighScale(string $func): YMultiCellWeighScale
    {
        // $obj                    is a YMultiCellWeighScale;
        $obj = YFunction::_FindFromCache('MultiCellWeighScale', $func);
        if ($obj == null) {
            $obj = new YMultiCellWeighScale($func);
            YFunction::_AddToCache('MultiCellWeighScale', $func, $obj);
        }
        return $obj;
    }

    /**
     * Adapts the load cell signal bias (stored in the corresponding genericSensor)
     * so that the current signal corresponds to a zero weight. Remember to call the
     * saveToFlash() method of the module if the modification must be kept.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function tare(): int
    {
        return $this->set_command('T');
    }

    /**
     * Configures the load cells span parameters (stored in the corresponding genericSensors)
     * so that the current signal corresponds to the specified reference weight.
     *
     * @param float $currWeight : reference weight presently on the load cell.
     * @param float $maxWeight : maximum weight to be expected on the load cell.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function setupSpan(float $currWeight, float $maxWeight): int
    {
        return $this->set_command(sprintf('S%d:%d', intval(round(1000*$currWeight)), intval(round(1000*$maxWeight))));
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
    public function cellCount(): int
{
    return $this->get_cellCount();
}

    /**
     * @throws YAPI_Exception
     */
    public function setCellCount(int $newval): int
{
    return $this->set_cellCount($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function externalSense(): int
{
    return $this->get_externalSense();
}

    /**
     * @throws YAPI_Exception
     */
    public function setExternalSense(int $newval): int
{
    return $this->set_externalSense($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function excitation(): int
{
    return $this->get_excitation();
}

    /**
     * @throws YAPI_Exception
     */
    public function setExcitation(int $newval): int
{
    return $this->set_excitation($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function setTempAvgAdaptRatio(float $newval): int
{
    return $this->set_tempAvgAdaptRatio($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function tempAvgAdaptRatio(): float
{
    return $this->get_tempAvgAdaptRatio();
}

    /**
     * @throws YAPI_Exception
     */
    public function setTempChgAdaptRatio(float $newval): int
{
    return $this->set_tempChgAdaptRatio($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function tempChgAdaptRatio(): float
{
    return $this->get_tempChgAdaptRatio();
}

    /**
     * @throws YAPI_Exception
     */
    public function compTempAvg(): float
{
    return $this->get_compTempAvg();
}

    /**
     * @throws YAPI_Exception
     */
    public function compTempChg(): float
{
    return $this->get_compTempChg();
}

    /**
     * @throws YAPI_Exception
     */
    public function compensation(): float
{
    return $this->get_compensation();
}

    /**
     * @throws YAPI_Exception
     */
    public function setZeroTracking(float $newval): int
{
    return $this->set_zeroTracking($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function zeroTracking(): float
{
    return $this->get_zeroTracking();
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
     * Continues the enumeration of multi-cell weighing scale sensors started using yFirstMultiCellWeighScale().
     * Caution: You can't make any assumption about the returned multi-cell weighing scale sensors order.
     * If you want to find a specific a multi-cell weighing scale sensor, use
     * MultiCellWeighScale.findMultiCellWeighScale()
     * and a hardwareID or a logical name.
     *
     * @return ?YMultiCellWeighScale  a pointer to a YMultiCellWeighScale object, corresponding to
     *         a multi-cell weighing scale sensor currently online, or a null pointer
     *         if there are no more multi-cell weighing scale sensors to enumerate.
     */
    public function nextMultiCellWeighScale(): ?YMultiCellWeighScale
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindMultiCellWeighScale($next_hwid);
    }

    /**
     * Starts the enumeration of multi-cell weighing scale sensors currently accessible.
     * Use the method YMultiCellWeighScale::nextMultiCellWeighScale() to iterate on
     * next multi-cell weighing scale sensors.
     *
     * @return ?YMultiCellWeighScale  a pointer to a YMultiCellWeighScale object, corresponding to
     *         the first multi-cell weighing scale sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstMultiCellWeighScale(): ?YMultiCellWeighScale
    {
        $next_hwid = YAPI::getFirstHardwareId('MultiCellWeighScale');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindMultiCellWeighScale($next_hwid);
    }

    //--- (end of YMultiCellWeighScale implementation)

}
