<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YWeighScale Class: weighing scale sensor control interface, available for instance in the
 * Yocto-Bridge or the Yocto-MaxiBridge
 *
 * The YWeighScale class provides a weight measurement from a ratiometric sensor.
 * It can be used to control the bridge excitation parameters, in order to avoid
 * measure shifts caused by temperature variation in the electronics, and can also
 * automatically apply an additional correction factor based on temperature to
 * compensate for offsets in the load cell itself.
 */
class YWeighScale extends YSensor
{
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
    //--- (end of YWeighScale declaration)

    //--- (YWeighScale attributes)
    protected int $_excitation = self::EXCITATION_INVALID;     // ExcitationMode
    protected float $_tempAvgAdaptRatio = self::TEMPAVGADAPTRATIO_INVALID; // MeasureVal
    protected float $_tempChgAdaptRatio = self::TEMPCHGADAPTRATIO_INVALID; // MeasureVal
    protected float $_compTempAvg = self::COMPTEMPAVG_INVALID;    // MeasureVal
    protected float $_compTempChg = self::COMPTEMPCHG_INVALID;    // MeasureVal
    protected float $_compensation = self::COMPENSATION_INVALID;   // MeasureVal
    protected float $_zeroTracking = self::ZEROTRACKING_INVALID;   // MeasureVal
    protected string $_command = self::COMMAND_INVALID;        // Text

    //--- (end of YWeighScale attributes)

    function __construct(string $str_func)
    {
        //--- (YWeighScale constructor)
        parent::__construct($str_func);
        $this->_className = 'WeighScale';

        //--- (end of YWeighScale constructor)
    }

    //--- (YWeighScale implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
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
     * Returns the current load cell bridge excitation method.
     *
     * @return int  a value among YWeighScale::EXCITATION_OFF, YWeighScale::EXCITATION_DC and
     * YWeighScale::EXCITATION_AC corresponding to the current load cell bridge excitation method
     *
     * On failure, throws an exception or returns YWeighScale::EXCITATION_INVALID.
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
     * @param int $newval : a value among YWeighScale::EXCITATION_OFF, YWeighScale::EXCITATION_DC and
     * YWeighScale::EXCITATION_AC corresponding to the current load cell bridge excitation method
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
     * On failure, throws an exception or returns YWeighScale::TEMPAVGADAPTRATIO_INVALID.
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
     * On failure, throws an exception or returns YWeighScale::TEMPCHGADAPTRATIO_INVALID.
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
     * On failure, throws an exception or returns YWeighScale::COMPTEMPAVG_INVALID.
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
     * On failure, throws an exception or returns YWeighScale::COMPTEMPCHG_INVALID.
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
     * On failure, throws an exception or returns YWeighScale::COMPENSATION_INVALID.
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
     * On failure, throws an exception or returns YWeighScale::ZEROTRACKING_INVALID.
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
     * Retrieves a weighing scale sensor for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the weighing scale sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the weighing scale sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a weighing scale sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the weighing scale sensor, for instance
     *         YWBRIDG1.weighScale1.
     *
     * @return YWeighScale  a YWeighScale object allowing you to drive the weighing scale sensor.
     */
    public static function FindWeighScale(string $func): YWeighScale
    {
        // $obj                    is a YWeighScale;
        $obj = YFunction::_FindFromCache('WeighScale', $func);
        if ($obj == null) {
            $obj = new YWeighScale($func);
            YFunction::_AddToCache('WeighScale', $func, $obj);
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
     * Configures the load cell span parameters (stored in the corresponding genericSensor)
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
     * @throws YAPI_Exception on error
     */
    public function setCompensationTable(int $tableIndex, array $tempValues, array $compValues): int
    {
        // $siz                    is a int;
        // $res                    is a int;
        // $idx                    is a int;
        // $found                  is a int;
        // $prev                   is a float;
        // $curr                   is a float;
        // $currComp               is a float;
        // $idxTemp                is a float;
        $siz = sizeof($tempValues);
        if (!($siz != 1)) return $this->_throw( YAPI::INVALID_ARGUMENT, 'thermal compensation table must have at least two points',YAPI::INVALID_ARGUMENT);
        if (!($siz == sizeof($compValues))) return $this->_throw( YAPI::INVALID_ARGUMENT, 'table sizes mismatch',YAPI::INVALID_ARGUMENT);

        $res = $this->set_command(sprintf('%dZ', $tableIndex));
        if (!($res==YAPI::SUCCESS)) return $this->_throw( YAPI::IO_ERROR, 'unable to reset thermal compensation table',YAPI::IO_ERROR);
        // add records in growing temperature value
        $found = 1;
        $prev = -999999.0;
        while ($found > 0) {
            $found = 0;
            $curr = 99999999.0;
            $currComp = -999999.0;
            $idx = 0;
            while ($idx < $siz) {
                $idxTemp = $tempValues[$idx];
                if (($idxTemp > $prev) && ($idxTemp < $curr)) {
                    $curr = $idxTemp;
                    $currComp = $compValues[$idx];
                    $found = 1;
                }
                $idx = $idx + 1;
            }
            if ($found > 0) {
                $res = $this->set_command(sprintf('%dm%d:%d', $tableIndex, intval(round(1000*$curr)), intval(round(1000*$currComp))));
                if (!($res==YAPI::SUCCESS)) return $this->_throw( YAPI::IO_ERROR, 'unable to set thermal compensation table',YAPI::IO_ERROR);
                $prev = $curr;
            }
        }
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function loadCompensationTable(int $tableIndex, array &$tempValues, array &$compValues): int
    {
        // $id                     is a str;
        // $bin_json               is a bin;
        $paramlist = [];        // strArr;
        // $siz                    is a int;
        // $idx                    is a int;
        // $temp                   is a float;
        // $comp                   is a float;

        $id = $this->get_functionId();
        $id = substr($id,  10, strlen($id) - 10);
        $bin_json = $this->_download(sprintf('extra.json?page=%d',(4*intVal($id))+$tableIndex));
        $paramlist = $this->_json_get_array($bin_json);
        // convert all values to float and append records
        $siz = ((sizeof($paramlist)) >> (1));
        while (sizeof($tempValues) > 0) {
            array_pop($tempValues);
        };
        while (sizeof($compValues) > 0) {
            array_pop($compValues);
        };
        $idx = 0;
        while ($idx < $siz) {
            $temp = floatval($paramlist[2*$idx])/1000.0;
            $comp = floatval($paramlist[2*$idx+1])/1000.0;
            $tempValues[] = $temp;
            $compValues[] = $comp;
            $idx = $idx + 1;
        }
        return YAPI::SUCCESS;
    }

    /**
     * Records a weight offset thermal compensation table, in order to automatically correct the
     * measured weight based on the averaged compensation temperature.
     * The weight correction will be applied by linear interpolation between specified points.
     *
     * @param float[] $tempValues : array of floating point numbers, corresponding to all averaged
     *         temperatures for which an offset correction is specified.
     * @param float[] $compValues : array of floating point numbers, corresponding to the offset correction
     *         to apply for each of the temperature included in the first
     *         argument, index by index.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_offsetAvgCompensationTable(array $tempValues, array $compValues): int
    {
        return $this->setCompensationTable(0, $tempValues, $compValues);
    }

    /**
     * Retrieves the weight offset thermal compensation table previously configured using the
     * set_offsetAvgCompensationTable function.
     * The weight correction is applied by linear interpolation between specified points.
     *
     * @param float[] $tempValues : array of floating point numbers, that is filled by the function
     *         with all averaged temperatures for which an offset correction is specified.
     * @param float[] $compValues : array of floating point numbers, that is filled by the function
     *         with the offset correction applied for each of the temperature
     *         included in the first argument, index by index.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function loadOffsetAvgCompensationTable(array &$tempValues, array &$compValues): int
    {
        return $this->loadCompensationTable(0, $tempValues, $compValues);
    }

    /**
     * Records a weight offset thermal compensation table, in order to automatically correct the
     * measured weight based on the variation of temperature.
     * The weight correction will be applied by linear interpolation between specified points.
     *
     * @param float[] $tempValues : array of floating point numbers, corresponding to temperature
     *         variations for which an offset correction is specified.
     * @param float[] $compValues : array of floating point numbers, corresponding to the offset correction
     *         to apply for each of the temperature variation included in the first
     *         argument, index by index.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_offsetChgCompensationTable(array $tempValues, array $compValues): int
    {
        return $this->setCompensationTable(1, $tempValues, $compValues);
    }

    /**
     * Retrieves the weight offset thermal compensation table previously configured using the
     * set_offsetChgCompensationTable function.
     * The weight correction is applied by linear interpolation between specified points.
     *
     * @param float[] $tempValues : array of floating point numbers, that is filled by the function
     *         with all temperature variations for which an offset correction is specified.
     * @param float[] $compValues : array of floating point numbers, that is filled by the function
     *         with the offset correction applied for each of the temperature
     *         variation included in the first argument, index by index.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function loadOffsetChgCompensationTable(array &$tempValues, array &$compValues): int
    {
        return $this->loadCompensationTable(1, $tempValues, $compValues);
    }

    /**
     * Records a weight span thermal compensation table, in order to automatically correct the
     * measured weight based on the compensation temperature.
     * The weight correction will be applied by linear interpolation between specified points.
     *
     * @param float[] $tempValues : array of floating point numbers, corresponding to all averaged
     *         temperatures for which a span correction is specified.
     * @param float[] $compValues : array of floating point numbers, corresponding to the span correction
     *         (in percents) to apply for each of the temperature included in the first
     *         argument, index by index.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_spanAvgCompensationTable(array $tempValues, array $compValues): int
    {
        return $this->setCompensationTable(2, $tempValues, $compValues);
    }

    /**
     * Retrieves the weight span thermal compensation table previously configured using the
     * set_spanAvgCompensationTable function.
     * The weight correction is applied by linear interpolation between specified points.
     *
     * @param float[] $tempValues : array of floating point numbers, that is filled by the function
     *         with all averaged temperatures for which an span correction is specified.
     * @param float[] $compValues : array of floating point numbers, that is filled by the function
     *         with the span correction applied for each of the temperature
     *         included in the first argument, index by index.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function loadSpanAvgCompensationTable(array &$tempValues, array &$compValues): int
    {
        return $this->loadCompensationTable(2, $tempValues, $compValues);
    }

    /**
     * Records a weight span thermal compensation table, in order to automatically correct the
     * measured weight based on the variation of temperature.
     * The weight correction will be applied by linear interpolation between specified points.
     *
     * @param float[] $tempValues : array of floating point numbers, corresponding to all variations of
     *         temperatures for which a span correction is specified.
     * @param float[] $compValues : array of floating point numbers, corresponding to the span correction
     *         (in percents) to apply for each of the temperature variation included
     *         in the first argument, index by index.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_spanChgCompensationTable(array $tempValues, array $compValues): int
    {
        return $this->setCompensationTable(3, $tempValues, $compValues);
    }

    /**
     * Retrieves the weight span thermal compensation table previously configured using the
     * set_spanChgCompensationTable function.
     * The weight correction is applied by linear interpolation between specified points.
     *
     * @param float[] $tempValues : array of floating point numbers, that is filled by the function
     *         with all variation of temperature for which an span correction is specified.
     * @param float[] $compValues : array of floating point numbers, that is filled by the function
     *         with the span correction applied for each of variation of temperature
     *         included in the first argument, index by index.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function loadSpanChgCompensationTable(array &$tempValues, array &$compValues): int
    {
        return $this->loadCompensationTable(3, $tempValues, $compValues);
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
     * Continues the enumeration of weighing scale sensors started using yFirstWeighScale().
     * Caution: You can't make any assumption about the returned weighing scale sensors order.
     * If you want to find a specific a weighing scale sensor, use WeighScale.findWeighScale()
     * and a hardwareID or a logical name.
     *
     * @return ?YWeighScale  a pointer to a YWeighScale object, corresponding to
     *         a weighing scale sensor currently online, or a null pointer
     *         if there are no more weighing scale sensors to enumerate.
     */
    public function nextWeighScale(): ?YWeighScale
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindWeighScale($next_hwid);
    }

    /**
     * Starts the enumeration of weighing scale sensors currently accessible.
     * Use the method YWeighScale::nextWeighScale() to iterate on
     * next weighing scale sensors.
     *
     * @return ?YWeighScale  a pointer to a YWeighScale object, corresponding to
     *         the first weighing scale sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstWeighScale(): ?YWeighScale
    {
        $next_hwid = YAPI::getFirstHardwareId('WeighScale');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindWeighScale($next_hwid);
    }

    //--- (end of YWeighScale implementation)

}
