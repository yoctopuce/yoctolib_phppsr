<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YRangeFinder Class: range finder control interface, available for instance in the Yocto-RangeFinder
 *
 * The YRangeFinder class allows you to read and configure Yoctopuce range finders.
 * It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, and to access the autonomous datalogger.
 * This class adds the ability to easily perform a one-point linear calibration
 * to compensate the effect of a glass or filter placed in front of the sensor.
 */
class YRangeFinder extends YSensor
{
    const RANGEFINDERMODE_DEFAULT = 0;
    const RANGEFINDERMODE_LONG_RANGE = 1;
    const RANGEFINDERMODE_HIGH_ACCURACY = 2;
    const RANGEFINDERMODE_HIGH_SPEED = 3;
    const RANGEFINDERMODE_INVALID = -1;
    const TIMEFRAME_INVALID = YAPI::INVALID_LONG;
    const QUALITY_INVALID = YAPI::INVALID_UINT;
    const HARDWARECALIBRATION_INVALID = YAPI::INVALID_STRING;
    const CURRENTTEMPERATURE_INVALID = YAPI::INVALID_DOUBLE;
    const COMMAND_INVALID = YAPI::INVALID_STRING;
    //--- (end of YRangeFinder declaration)

    //--- (YRangeFinder attributes)
    protected int $_rangeFinderMode = self::RANGEFINDERMODE_INVALID; // RangeFinderMode
    protected float $_timeFrame = self::TIMEFRAME_INVALID;      // Time
    protected int $_quality = self::QUALITY_INVALID;        // Percent
    protected string $_hardwareCalibration = self::HARDWARECALIBRATION_INVALID; // RangeFinderCalib
    protected float $_currentTemperature = self::CURRENTTEMPERATURE_INVALID; // MeasureVal
    protected string $_command = self::COMMAND_INVALID;        // Text

    //--- (end of YRangeFinder attributes)

    function __construct(string $str_func)
    {
        //--- (YRangeFinder constructor)
        parent::__construct($str_func);
        $this->_className = 'RangeFinder';

        //--- (end of YRangeFinder constructor)
    }

    //--- (YRangeFinder implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'rangeFinderMode':
            $this->_rangeFinderMode = intval($val);
            return 1;
        case 'timeFrame':
            $this->_timeFrame = intval($val);
            return 1;
        case 'quality':
            $this->_quality = intval($val);
            return 1;
        case 'hardwareCalibration':
            $this->_hardwareCalibration = $val;
            return 1;
        case 'currentTemperature':
            $this->_currentTemperature = round($val / 65.536) / 1000.0;
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Changes the measuring unit for the measured range. That unit is a string.
     * String value can be " or mm. Any other value is ignored.
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     * WARNING: if a specific calibration is defined for the rangeFinder function, a
     * unit system change will probably break it.
     *
     * @param string $newval : a string corresponding to the measuring unit for the measured range
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
     * Returns the range finder running mode. The rangefinder running mode
     * allows you to put priority on precision, speed or maximum range.
     *
     * @return int  a value among YRangeFinder::RANGEFINDERMODE_DEFAULT,
     * YRangeFinder::RANGEFINDERMODE_LONG_RANGE, YRangeFinder::RANGEFINDERMODE_HIGH_ACCURACY and
     * YRangeFinder::RANGEFINDERMODE_HIGH_SPEED corresponding to the range finder running mode
     *
     * On failure, throws an exception or returns YRangeFinder::RANGEFINDERMODE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_rangeFinderMode(): int
    {
        // $res                    is a enumRANGEFINDERMODE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::RANGEFINDERMODE_INVALID;
            }
        }
        $res = $this->_rangeFinderMode;
        return $res;
    }

    /**
     * Changes the rangefinder running mode, allowing you to put priority on
     * precision, speed or maximum range.
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @param int $newval : a value among YRangeFinder::RANGEFINDERMODE_DEFAULT,
     * YRangeFinder::RANGEFINDERMODE_LONG_RANGE, YRangeFinder::RANGEFINDERMODE_HIGH_ACCURACY and
     * YRangeFinder::RANGEFINDERMODE_HIGH_SPEED corresponding to the rangefinder running mode, allowing you
     * to put priority on
     *         precision, speed or maximum range
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_rangeFinderMode(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("rangeFinderMode", $rest_val);
    }

    /**
     * Returns the time frame used to measure the distance and estimate the measure
     * reliability. The time frame is expressed in milliseconds.
     *
     * @return float  an integer corresponding to the time frame used to measure the distance and estimate the measure
     *         reliability
     *
     * On failure, throws an exception or returns YRangeFinder::TIMEFRAME_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_timeFrame(): float
    {
        // $res                    is a long;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::TIMEFRAME_INVALID;
            }
        }
        $res = $this->_timeFrame;
        return $res;
    }

    /**
     * Changes the time frame used to measure the distance and estimate the measure
     * reliability. The time frame is expressed in milliseconds. A larger timeframe
     * improves stability and reliability, at the cost of higher latency, but prevents
     * the detection of events shorter than the time frame.
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @param float $newval : an integer corresponding to the time frame used to measure the distance and
     * estimate the measure
     *         reliability
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_timeFrame(float $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("timeFrame", $rest_val);
    }

    /**
     * Returns a measure quality estimate, based on measured dispersion.
     *
     * @return int  an integer corresponding to a measure quality estimate, based on measured dispersion
     *
     * On failure, throws an exception or returns YRangeFinder::QUALITY_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_quality(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::QUALITY_INVALID;
            }
        }
        $res = $this->_quality;
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_hardwareCalibration(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::HARDWARECALIBRATION_INVALID;
            }
        }
        $res = $this->_hardwareCalibration;
        return $res;
    }

    /**
     * @throws YAPI_Exception
     */
    public function set_hardwareCalibration(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("hardwareCalibration", $rest_val);
    }

    /**
     * Returns the current sensor temperature, as a floating point number.
     *
     * @return float  a floating point number corresponding to the current sensor temperature, as a
     * floating point number
     *
     * On failure, throws an exception or returns YRangeFinder::CURRENTTEMPERATURE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_currentTemperature(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CURRENTTEMPERATURE_INVALID;
            }
        }
        $res = $this->_currentTemperature;
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
     * Retrieves a range finder for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the range finder is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the range finder is
     * indeed online at a given time. In case of ambiguity when looking for
     * a range finder by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the range finder, for instance
     *         YRNGFND1.rangeFinder1.
     *
     * @return YRangeFinder  a YRangeFinder object allowing you to drive the range finder.
     */
    public static function FindRangeFinder(string $func): YRangeFinder
    {
        // $obj                    is a YRangeFinder;
        $obj = YFunction::_FindFromCache('RangeFinder', $func);
        if ($obj == null) {
            $obj = new YRangeFinder($func);
            YFunction::_AddToCache('RangeFinder', $func, $obj);
        }
        return $obj;
    }

    /**
     * Returns the temperature at the time when the latest calibration was performed.
     * This function can be used to determine if a new calibration for ambient temperature
     * is required.
     *
     * @return float  a temperature, as a floating point number.
     *         On failure, throws an exception or return YAPI::INVALID_DOUBLE.
     * @throws YAPI_Exception on error
     */
    public function get_hardwareCalibrationTemperature(): float
    {
        // $hwcal                  is a string;
        $hwcal = $this->get_hardwareCalibration();
        if (!(substr($hwcal, 0, 1) == '@')) {
            return YAPI::INVALID_DOUBLE;
        }
        return intVal(substr($hwcal, 1, strlen($hwcal)));
    }

    /**
     * Triggers a sensor calibration according to the current ambient temperature. That
     * calibration process needs no physical interaction with the sensor. It is performed
     * automatically at device startup, but it is recommended to start it again when the
     * temperature delta since the latest calibration exceeds 8°C.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function triggerTemperatureCalibration(): int
    {
        return $this->set_command('T');
    }

    /**
     * Triggers the photon detector hardware calibration.
     * This function is part of the calibration procedure to compensate for the effect
     * of a cover glass. Make sure to read the chapter about hardware calibration for details
     * on the calibration procedure for proper results.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function triggerSpadCalibration(): int
    {
        return $this->set_command('S');
    }

    /**
     * Triggers the hardware offset calibration of the distance sensor.
     * This function is part of the calibration procedure to compensate for the the effect
     * of a cover glass. Make sure to read the chapter about hardware calibration for details
     * on the calibration procedure for proper results.
     *
     * @param float $targetDist : true distance of the calibration target, in mm or inches, depending
     *         on the unit selected in the device
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function triggerOffsetCalibration(float $targetDist): int
    {
        // $distmm                 is a int;
        if ($this->get_unit() == '"') {
            $distmm = round($targetDist * 25.4);
        } else {
            $distmm = round($targetDist);
        }
        return $this->set_command(sprintf('O%d',$distmm));
    }

    /**
     * Triggers the hardware cross-talk calibration of the distance sensor.
     * This function is part of the calibration procedure to compensate for the effect
     * of a cover glass. Make sure to read the chapter about hardware calibration for details
     * on the calibration procedure for proper results.
     *
     * @param float $targetDist : true distance of the calibration target, in mm or inches, depending
     *         on the unit selected in the device
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function triggerXTalkCalibration(float $targetDist): int
    {
        // $distmm                 is a int;
        if ($this->get_unit() == '"') {
            $distmm = round($targetDist * 25.4);
        } else {
            $distmm = round($targetDist);
        }
        return $this->set_command(sprintf('X%d',$distmm));
    }

    /**
     * Cancels the effect of previous hardware calibration procedures to compensate
     * for cover glass, and restores factory settings.
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function cancelCoverGlassCalibrations(): int
    {
        return $this->set_hardwareCalibration('');
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
    public function rangeFinderMode(): int
{
    return $this->get_rangeFinderMode();
}

    /**
     * @throws YAPI_Exception
     */
    public function setRangeFinderMode(int $newval): int
{
    return $this->set_rangeFinderMode($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function timeFrame(): float
{
    return $this->get_timeFrame();
}

    /**
     * @throws YAPI_Exception
     */
    public function setTimeFrame(float $newval): int
{
    return $this->set_timeFrame($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function quality(): int
{
    return $this->get_quality();
}

    /**
     * @throws YAPI_Exception
     */
    public function hardwareCalibration(): string
{
    return $this->get_hardwareCalibration();
}

    /**
     * @throws YAPI_Exception
     */
    public function setHardwareCalibration(string $newval): int
{
    return $this->set_hardwareCalibration($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function currentTemperature(): float
{
    return $this->get_currentTemperature();
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
     * Continues the enumeration of range finders started using yFirstRangeFinder().
     * Caution: You can't make any assumption about the returned range finders order.
     * If you want to find a specific a range finder, use RangeFinder.findRangeFinder()
     * and a hardwareID or a logical name.
     *
     * @return ?YRangeFinder  a pointer to a YRangeFinder object, corresponding to
     *         a range finder currently online, or a null pointer
     *         if there are no more range finders to enumerate.
     */
    public function nextRangeFinder(): ?YRangeFinder
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindRangeFinder($next_hwid);
    }

    /**
     * Starts the enumeration of range finders currently accessible.
     * Use the method YRangeFinder::nextRangeFinder() to iterate on
     * next range finders.
     *
     * @return ?YRangeFinder  a pointer to a YRangeFinder object, corresponding to
     *         the first range finder currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstRangeFinder(): ?YRangeFinder
    {
        $next_hwid = YAPI::getFirstHardwareId('RangeFinder');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindRangeFinder($next_hwid);
    }

    //--- (end of YRangeFinder implementation)

}
