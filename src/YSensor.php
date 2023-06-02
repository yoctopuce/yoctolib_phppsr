<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YSensor Class: Sensor function interface.
 *
 * The YSensor class is the parent class for all Yoctopuce sensor types. It can be
 * used to read the current value and unit of any sensor, read the min/max
 * value, configure autonomous recording frequency and access recorded data.
 * It also provide a function to register a callback invoked each time the
 * observed value changes, or at a predefined interval. Using this class rather
 * than a specific subclass makes it possible to create generic applications
 * that work with any Yoctopuce sensor, even those that do not yet exist.
 * Note: The YAnButton class is the only analog input which does not inherit
 * from YSensor::
 */
class YSensor extends YFunction
{
    const UNIT_INVALID = YAPI::INVALID_STRING;
    const CURRENTVALUE_INVALID = YAPI::INVALID_DOUBLE;
    const LOWESTVALUE_INVALID = YAPI::INVALID_DOUBLE;
    const HIGHESTVALUE_INVALID = YAPI::INVALID_DOUBLE;
    const CURRENTRAWVALUE_INVALID = YAPI::INVALID_DOUBLE;
    const LOGFREQUENCY_INVALID = YAPI::INVALID_STRING;
    const REPORTFREQUENCY_INVALID = YAPI::INVALID_STRING;
    const ADVMODE_IMMEDIATE = 0;
    const ADVMODE_PERIOD_AVG = 1;
    const ADVMODE_PERIOD_MIN = 2;
    const ADVMODE_PERIOD_MAX = 3;
    const ADVMODE_INVALID = -1;
    const CALIBRATIONPARAM_INVALID = YAPI::INVALID_STRING;
    const RESOLUTION_INVALID = YAPI::INVALID_DOUBLE;
    const SENSORSTATE_INVALID = YAPI::INVALID_INT;
    //--- (end of generated code: YSensor declaration)
    const DATA_INVALID = YAPI::INVALID_DOUBLE;

    //--- (generated code: YSensor attributes)
    protected string $_unit = self::UNIT_INVALID;           // Text
    protected float $_currentValue = self::CURRENTVALUE_INVALID;   // MeasureVal
    protected float $_lowestValue = self::LOWESTVALUE_INVALID;    // MeasureVal
    protected float $_highestValue = self::HIGHESTVALUE_INVALID;   // MeasureVal
    protected float $_currentRawValue = self::CURRENTRAWVALUE_INVALID; // MeasureVal
    protected string $_logFrequency = self::LOGFREQUENCY_INVALID;   // YFrequency
    protected string $_reportFrequency = self::REPORTFREQUENCY_INVALID; // YFrequency
    protected int $_advMode = self::ADVMODE_INVALID;        // AdvertisingMode
    protected string $_calibrationParam = self::CALIBRATIONPARAM_INVALID; // CalibParams
    protected float $_resolution = self::RESOLUTION_INVALID;     // MeasureVal
    protected int $_sensorState = self::SENSORSTATE_INVALID;    // Int
    protected mixed $_timedReportCallbackSensor = null;                         // YSensorTimedReportCallback
    protected float $_prevTimedReport = 0;                            // float
    protected float $_iresol = 0;                            // float
    protected float $_offset = 0;                            // float
    protected float $_scale = 0;                            // float
    protected float $_decexp = 0;                            // float
    protected int $_caltyp = 0;                            // int
    protected array $_calpar = [];                           // intArr
    protected array $_calraw = [];                           // floatArr
    protected array $_calref = [];                           // floatArr
    protected mixed $_calhdl = null;                         // yCalibrationHandler

    //--- (end of generated code: YSensor attributes)

    function __construct(string $str_func)
    {
        //--- (generated code: YSensor constructor)
        parent::__construct($str_func);
        $this->_className = 'Sensor';

        //--- (end of generated code: YSensor constructor)
    }

    public function _getTimedReportCallback(): callable
    {
        return $this->_timedReportCallbackSensor;
    }

    //--- (generated code: YSensor implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'unit':
            $this->_unit = $val;
            return 1;
        case 'currentValue':
            $this->_currentValue = round($val / 65.536) / 1000.0;
            return 1;
        case 'lowestValue':
            $this->_lowestValue = round($val / 65.536) / 1000.0;
            return 1;
        case 'highestValue':
            $this->_highestValue = round($val / 65.536) / 1000.0;
            return 1;
        case 'currentRawValue':
            $this->_currentRawValue = round($val / 65.536) / 1000.0;
            return 1;
        case 'logFrequency':
            $this->_logFrequency = $val;
            return 1;
        case 'reportFrequency':
            $this->_reportFrequency = $val;
            return 1;
        case 'advMode':
            $this->_advMode = intval($val);
            return 1;
        case 'calibrationParam':
            $this->_calibrationParam = $val;
            return 1;
        case 'resolution':
            $this->_resolution = round($val / 65.536) / 1000.0;
            return 1;
        case 'sensorState':
            $this->_sensorState = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the measuring unit for the measure.
     *
     * @return string  a string corresponding to the measuring unit for the measure
     *
     * On failure, throws an exception or returns YSensor.UNIT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_unit(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::UNIT_INVALID;
            }
        }
        $res = $this->_unit;
        return $res;
    }

    /**
     * Returns the current value of the measure, in the specified unit, as a floating point number.
     * Note that a get_currentValue() call will *not* start a measure in the device, it
     * will just return the last measure that occurred in the device. Indeed, internally, each Yoctopuce
     * devices is continuously making measurements at a hardware specific frequency.
     *
     * If continuously calling  get_currentValue() leads you to performances issues, then
     * you might consider to switch to callback programming model. Check the "advanced
     * programming" chapter in in your device user manual for more information.
     *
     * @return float  a floating point number corresponding to the current value of the measure, in the
     * specified unit, as a floating point number
     *
     * On failure, throws an exception or returns YSensor.CURRENTVALUE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_currentValue(): float
    {
        // $res                    is a float;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CURRENTVALUE_INVALID;
            }
        }
        $res = $this->_applyCalibration($this->_currentRawValue);
        if ($res == self::CURRENTVALUE_INVALID) {
            $res = $this->_currentValue;
        }
        $res = $res * $this->_iresol;
        $res = round($res) / $this->_iresol;
        return $res;
    }

    /**
     * Changes the recorded minimal value observed. Can be used to reset the value returned
     * by get_lowestValue().
     *
     * @param float $newval : a floating point number corresponding to the recorded minimal value observed
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_lowestValue(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("lowestValue", $rest_val);
    }

    /**
     * Returns the minimal value observed for the measure since the device was started.
     * Can be reset to an arbitrary value thanks to set_lowestValue().
     *
     * @return float  a floating point number corresponding to the minimal value observed for the measure
     * since the device was started
     *
     * On failure, throws an exception or returns YSensor.LOWESTVALUE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_lowestValue(): float
    {
        // $res                    is a float;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LOWESTVALUE_INVALID;
            }
        }
        $res = $this->_lowestValue * $this->_iresol;
        $res = round($res) / $this->_iresol;
        return $res;
    }

    /**
     * Changes the recorded maximal value observed. Can be used to reset the value returned
     * by get_lowestValue().
     *
     * @param float $newval : a floating point number corresponding to the recorded maximal value observed
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_highestValue(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("highestValue", $rest_val);
    }

    /**
     * Returns the maximal value observed for the measure since the device was started.
     * Can be reset to an arbitrary value thanks to set_highestValue().
     *
     * @return float  a floating point number corresponding to the maximal value observed for the measure
     * since the device was started
     *
     * On failure, throws an exception or returns YSensor.HIGHESTVALUE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_highestValue(): float
    {
        // $res                    is a float;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::HIGHESTVALUE_INVALID;
            }
        }
        $res = $this->_highestValue * $this->_iresol;
        $res = round($res) / $this->_iresol;
        return $res;
    }

    /**
     * Returns the uncalibrated, unrounded raw value returned by the
     * sensor, in the specified unit, as a floating point number.
     *
     * @return float  a floating point number corresponding to the uncalibrated, unrounded raw value returned by the
     *         sensor, in the specified unit, as a floating point number
     *
     * On failure, throws an exception or returns YSensor.CURRENTRAWVALUE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_currentRawValue(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CURRENTRAWVALUE_INVALID;
            }
        }
        $res = $this->_currentRawValue;
        return $res;
    }

    /**
     * Returns the datalogger recording frequency for this function, or "OFF"
     * when measures are not stored in the data logger flash memory.
     *
     * @return string  a string corresponding to the datalogger recording frequency for this function, or "OFF"
     *         when measures are not stored in the data logger flash memory
     *
     * On failure, throws an exception or returns YSensor.LOGFREQUENCY_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_logFrequency(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LOGFREQUENCY_INVALID;
            }
        }
        $res = $this->_logFrequency;
        return $res;
    }

    /**
     * Changes the datalogger recording frequency for this function.
     * The frequency can be specified as samples per second,
     * as sample per minute (for instance "15/m") or in samples per
     * hour (eg. "4/h"). To disable recording for this function, use
     * the value "OFF". Note that setting the  datalogger recording frequency
     * to a greater value than the sensor native sampling frequency is useless,
     * and even counterproductive: those two frequencies are not related.
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @param string $newval : a string corresponding to the datalogger recording frequency for this function
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_logFrequency(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("logFrequency", $rest_val);
    }

    /**
     * Returns the timed value notification frequency, or "OFF" if timed
     * value notifications are disabled for this function.
     *
     * @return string  a string corresponding to the timed value notification frequency, or "OFF" if timed
     *         value notifications are disabled for this function
     *
     * On failure, throws an exception or returns YSensor.REPORTFREQUENCY_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_reportFrequency(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::REPORTFREQUENCY_INVALID;
            }
        }
        $res = $this->_reportFrequency;
        return $res;
    }

    /**
     * Changes the timed value notification frequency for this function.
     * The frequency can be specified as samples per second,
     * as sample per minute (for instance "15/m") or in samples per
     * hour (e.g. "4/h"). To disable timed value notifications for this
     * function, use the value "OFF". Note that setting the  timed value
     * notification frequency to a greater value than the sensor native
     * sampling frequency is unless, and even counterproductive: those two
     * frequencies are not related.
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @param string $newval : a string corresponding to the timed value notification frequency for this function
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_reportFrequency(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("reportFrequency", $rest_val);
    }

    /**
     * Returns the measuring mode used for the advertised value pushed to the parent hub.
     *
     * @return int  a value among YSensor.ADVMODE_IMMEDIATE, YSensor.ADVMODE_PERIOD_AVG,
     * YSensor.ADVMODE_PERIOD_MIN and YSensor.ADVMODE_PERIOD_MAX corresponding to the measuring mode used
     * for the advertised value pushed to the parent hub
     *
     * On failure, throws an exception or returns YSensor.ADVMODE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_advMode(): int
    {
        // $res                    is a enumADVERTISINGMODE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::ADVMODE_INVALID;
            }
        }
        $res = $this->_advMode;
        return $res;
    }

    /**
     * Changes the measuring mode used for the advertised value pushed to the parent hub.
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @param int $newval : a value among YSensor.ADVMODE_IMMEDIATE, YSensor.ADVMODE_PERIOD_AVG,
     * YSensor.ADVMODE_PERIOD_MIN and YSensor.ADVMODE_PERIOD_MAX corresponding to the measuring mode used
     * for the advertised value pushed to the parent hub
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_advMode(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("advMode", $rest_val);
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_calibrationParam(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CALIBRATIONPARAM_INVALID;
            }
        }
        $res = $this->_calibrationParam;
        return $res;
    }

    /**
     * @throws YAPI_Exception
     */
    public function set_calibrationParam(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("calibrationParam", $rest_val);
    }

    /**
     * Changes the resolution of the measured physical values. The resolution corresponds to the numerical precision
     * when displaying value. It does not change the precision of the measure itself.
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @param float $newval : a floating point number corresponding to the resolution of the measured physical values
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_resolution(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("resolution", $rest_val);
    }

    /**
     * Returns the resolution of the measured values. The resolution corresponds to the numerical precision
     * of the measures, which is not always the same as the actual precision of the sensor.
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @return float  a floating point number corresponding to the resolution of the measured values
     *
     * On failure, throws an exception or returns YSensor.RESOLUTION_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_resolution(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::RESOLUTION_INVALID;
            }
        }
        $res = $this->_resolution;
        return $res;
    }

    /**
     * Returns the sensor health state code, which is zero when there is an up-to-date measure
     * available or a positive code if the sensor is not able to provide a measure right now.
     *
     * @return int  an integer corresponding to the sensor health state code, which is zero when there is
     * an up-to-date measure
     *         available or a positive code if the sensor is not able to provide a measure right now
     *
     * On failure, throws an exception or returns YSensor.SENSORSTATE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_sensorState(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SENSORSTATE_INVALID;
            }
        }
        $res = $this->_sensorState;
        return $res;
    }

    /**
     * Retrieves a sensor for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the sensor, for instance
     *         MyDevice..
     *
     * @return YSensor  a YSensor object allowing you to drive the sensor.
     */
    public static function FindSensor(string $func): YSensor
    {
        // $obj                    is a YSensor;
        $obj = YFunction::_FindFromCache('Sensor', $func);
        if ($obj == null) {
            $obj = new YSensor($func);
            YFunction::_AddToCache('Sensor', $func, $obj);
        }
        return $obj;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _parserHelper(): int
    {
        // $position               is a int;
        // $maxpos                 is a int;
        $iCalib = [];           // intArr;
        // $iRaw                   is a int;
        // $iRef                   is a int;
        // $fRaw                   is a float;
        // $fRef                   is a float;
        $this->_caltyp = -1;
        $this->_scale = -1;
        while (sizeof($this->_calpar) > 0) {
            array_pop($this->_calpar);
        };
        while (sizeof($this->_calraw) > 0) {
            array_pop($this->_calraw);
        };
        while (sizeof($this->_calref) > 0) {
            array_pop($this->_calref);
        };
        // Store inverted resolution, to provide better rounding
        if ($this->_resolution > 0) {
            $this->_iresol = round(1.0 / $this->_resolution);
        } else {
            $this->_iresol = 10000;
            $this->_resolution = 0.0001;
        }
        // Old format: supported when there is no calibration
        if ($this->_calibrationParam == '' || $this->_calibrationParam == '0') {
            $this->_caltyp = 0;
            return 0;
        }
        if (YAPI::Ystrpos($this->_calibrationParam,',') >= 0) {
            // Plain text format
            $iCalib = YAPI::_decodeFloats($this->_calibrationParam);
            $this->_caltyp = intVal(($iCalib[0]) / (1000));
            if ($this->_caltyp > 0) {
                if ($this->_caltyp < YOCTO_CALIB_TYPE_OFS) {
                    // Unknown calibration type: calibrated value will be provided by the device
                    $this->_caltyp = -1;
                    return 0;
                }
                $this->_calhdl = YAPI::_getCalibrationHandler($this->_caltyp);
                if (!(!is_null($this->_calhdl))) {
                    // Unknown calibration type: calibrated value will be provided by the device
                    $this->_caltyp = -1;
                    return 0;
                }
            }
            // New 32 bits text format
            $this->_offset = 0;
            $this->_scale = 1000;
            $maxpos = sizeof($iCalib);
            while (sizeof($this->_calpar) > 0) {
                array_pop($this->_calpar);
            };
            $position = 1;
            while ($position < $maxpos) {
                $this->_calpar[] = $iCalib[$position];
                $position = $position + 1;
            }
            while (sizeof($this->_calraw) > 0) {
                array_pop($this->_calraw);
            };
            while (sizeof($this->_calref) > 0) {
                array_pop($this->_calref);
            };
            $position = 1;
            while ($position + 1 < $maxpos) {
                $fRaw = $iCalib[$position];
                $fRaw = $fRaw / 1000.0;
                $fRef = $iCalib[$position + 1];
                $fRef = $fRef / 1000.0;
                $this->_calraw[] = $fRaw;
                $this->_calref[] = $fRef;
                $position = $position + 2;
            }
        } else {
            // Recorder-encoded format, including encoding
            $iCalib = YAPI::_decodeWords($this->_calibrationParam);
            // In case of unknown format, calibrated value will be provided by the device
            if (sizeof($iCalib) < 2) {
                $this->_caltyp = -1;
                return 0;
            }
            // Save variable format (scale for scalar, or decimal exponent)
            $this->_offset = 0;
            $this->_scale = 1;
            $this->_decexp = 1.0;
            $position = $iCalib[0];
            while ($position > 0) {
                $this->_decexp = $this->_decexp * 10;
                $position = $position - 1;
            }
            // Shortcut when there is no calibration parameter
            if (sizeof($iCalib) == 2) {
                $this->_caltyp = 0;
                return 0;
            }
            $this->_caltyp = $iCalib[2];
            $this->_calhdl = YAPI::_getCalibrationHandler($this->_caltyp);
            // parse calibration points
            if ($this->_caltyp <= 10) {
                $maxpos = $this->_caltyp;
            } else {
                if ($this->_caltyp <= 20) {
                    $maxpos = $this->_caltyp - 10;
                } else {
                    $maxpos = 5;
                }
            }
            $maxpos = 3 + 2 * $maxpos;
            if ($maxpos > sizeof($iCalib)) {
                $maxpos = sizeof($iCalib);
            }
            while (sizeof($this->_calpar) > 0) {
                array_pop($this->_calpar);
            };
            while (sizeof($this->_calraw) > 0) {
                array_pop($this->_calraw);
            };
            while (sizeof($this->_calref) > 0) {
                array_pop($this->_calref);
            };
            $position = 3;
            while ($position + 1 < $maxpos) {
                $iRaw = $iCalib[$position];
                $iRef = $iCalib[$position + 1];
                $this->_calpar[] = $iRaw;
                $this->_calpar[] = $iRef;
                $this->_calraw[] = YAPI::_decimalToDouble($iRaw);
                $this->_calref[] = YAPI::_decimalToDouble($iRef);
                $position = $position + 2;
            }
        }
        return 0;
    }

    /**
     * Checks if the sensor is currently able to provide an up-to-date measure.
     * Returns false if the device is unreachable, or if the sensor does not have
     * a current measure to transmit. No exception is raised if there is an error
     * while trying to contact the device hosting $THEFUNCTION$.
     *
     * @return boolean  true if the sensor can provide an up-to-date measure, and false otherwise
     */
    public function isSensorReady(): bool
    {
        if (!($this->isOnline())) {
            return false;
        }
        if (!($this->_sensorState == 0)) {
            return false;
        }
        return true;
    }

    /**
     * Returns the YDatalogger object of the device hosting the sensor. This method returns an object
     * that can control global parameters of the data logger. The returned object
     * should not be freed.
     *
     * @return ?YDataLogger  an YDatalogger object, or null on error.
     */
    public function get_dataLogger(): ?YDataLogger
    {
        // $logger                 is a YDataLogger;
        // $modu                   is a YModule;
        // $serial                 is a str;
        // $hwid                   is a str;

        $modu = $this->get_module();
        $serial = $modu->get_serialNumber();
        if ($serial == YAPI::INVALID_STRING) {
            return null;
        }
        $hwid = $serial . '.dataLogger';
        $logger = YDataLogger::FindDataLogger($hwid);
        return $logger;
    }

    /**
     * Starts the data logger on the device. Note that the data logger
     * will only save the measures on this sensor if the logFrequency
     * is not set to "OFF".
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     */
    public function startDataLogger(): int
    {
        // $res                    is a bin;

        $res = $this->_download('api/dataLogger/recording?recording=1');
        if (!(strlen($res) > 0)) return $this->_throw( YAPI::IO_ERROR, 'unable to start datalogger',YAPI::IO_ERROR);
        return YAPI::SUCCESS;
    }

    /**
     * Stops the datalogger on the device.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     */
    public function stopDataLogger(): int
    {
        // $res                    is a bin;

        $res = $this->_download('api/dataLogger/recording?recording=0');
        if (!(strlen($res) > 0)) return $this->_throw( YAPI::IO_ERROR, 'unable to stop datalogger',YAPI::IO_ERROR);
        return YAPI::SUCCESS;
    }

    /**
     * Retrieves a YDataSet object holding historical data for this
     * sensor, for a specified time interval. The measures will be
     * retrieved from the data logger, which must have been turned
     * on at the desired time. See the documentation of the YDataSet
     * class for information on how to get an overview of the
     * recorded data, and how to load progressively a large set
     * of measures from the data logger.
     *
     * This function only works if the device uses a recent firmware,
     * as YDataSet objects are not supported by firmwares older than
     * version 13000.
     *
     * @param float $startTime : the start of the desired measure time interval,
     *         as a Unix timestamp, i.e. the number of seconds since
     *         January 1, 1970 UTC. The special value 0 can be used
     *         to include any measure, without initial limit.
     * @param float $endTime : the end of the desired measure time interval,
     *         as a Unix timestamp, i.e. the number of seconds since
     *         January 1, 1970 UTC. The special value 0 can be used
     *         to include any measure, without ending limit.
     *
     * @return ?YDataSet  an instance of YDataSet, providing access to historical
     *         data. Past measures can be loaded progressively
     *         using methods from the YDataSet object.
     */
    public function get_recordedData(float $startTime, float $endTime): ?YDataSet
    {
        // $funcid                 is a str;
        // $funit                  is a str;

        $funcid = $this->get_functionId();
        $funit = $this->get_unit();
        return new YDataSet($this, $funcid, $funit, $startTime, $endTime);
    }

    /**
     * Registers the callback function that is invoked on every periodic timed notification.
     * The callback is invoked only during the execution of ySleep or yHandleEvents.
     * This provides control over the time when the callback is triggered. For good responsiveness, remember to call
     * one of these two functions periodically. To unregister a callback, pass a null pointer as argument.
     *
     * @param callable $callback : the callback function to call, or a null pointer. The callback function
     * should take two
     *         arguments: the function object of which the value has changed, and an YMeasure object describing
     *         the new advertised value.
     * @noreturn
     */
    public function registerTimedReportCallback(mixed $callback): int
    {
        // $sensor                 is a YSensor;
        $sensor = $this;
        if (!is_null($callback)) {
            YFunction::_UpdateTimedReportCallbackList($sensor, true);
        } else {
            YFunction::_UpdateTimedReportCallbackList($sensor, false);
        }
        $this->_timedReportCallbackSensor = $callback;
        return 0;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _invokeTimedReportCallback(YMeasure $value): int
    {
        if (!is_null($this->_timedReportCallbackSensor)) {
            call_user_func($this->_timedReportCallbackSensor, $this, $value);
        }
        return 0;
    }

    /**
     * Configures error correction data points, in particular to compensate for
     * a possible perturbation of the measure caused by an enclosure. It is possible
     * to configure up to five correction points. Correction points must be provided
     * in ascending order, and be in the range of the sensor. The device will automatically
     * perform a linear interpolation of the error correction between specified
     * points. Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * For more information on advanced capabilities to refine the calibration of
     * sensors, please contact support@yoctopuce.com.
     *
     * @param float[] $rawValues : array of floating point numbers, corresponding to the raw
     *         values returned by the sensor for the correction points.
     * @param float[] $refValues : array of floating point numbers, corresponding to the corrected
     *         values for the correction points.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function calibrateFromPoints(array $rawValues, array $refValues): int
    {
        // $rest_val               is a str;
        // $res                    is a int;

        $rest_val = $this->_encodeCalibrationPoints($rawValues, $refValues);
        $res = $this->_setAttr('calibrationParam', $rest_val);
        return $res;
    }

    /**
     * Retrieves error correction data points previously entered using the method
     * calibrateFromPoints.
     *
     * @param float[] $rawValues : array of floating point numbers, that will be filled by the
     *         function with the raw sensor values for the correction points.
     * @param float[] $refValues : array of floating point numbers, that will be filled by the
     *         function with the desired values for the correction points.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function loadCalibrationPoints(array &$rawValues, array &$refValues): int
    {
        while (sizeof($rawValues) > 0) {
            array_pop($rawValues);
        };
        while (sizeof($refValues) > 0) {
            array_pop($refValues);
        };
        // Load function parameters if not yet loaded
        if ($this->_scale == 0) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return YAPI::DEVICE_NOT_FOUND;
            }
        }
        if ($this->_caltyp < 0) {
            $this->_throw(YAPI::NOT_SUPPORTED, 'Calibration parameters format mismatch. Please upgrade your library or firmware.');
            return YAPI::NOT_SUPPORTED;
        }
        while (sizeof($rawValues) > 0) {
            array_pop($rawValues);
        };
        while (sizeof($refValues) > 0) {
            array_pop($refValues);
        };
        foreach ($this->_calraw as $each) {
            $rawValues[] = $each;
        }
        foreach ($this->_calref as $each) {
            $refValues[] = $each;
        }
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _encodeCalibrationPoints(array $rawValues, array $refValues): string
    {
        // $res                    is a str;
        // $npt                    is a int;
        // $idx                    is a int;
        $npt = sizeof($rawValues);
        if ($npt != sizeof($refValues)) {
            $this->_throw(YAPI::INVALID_ARGUMENT, 'Invalid calibration parameters (size mismatch)');
            return YAPI::INVALID_STRING;
        }
        // Shortcut when building empty calibration parameters
        if ($npt == 0) {
            return '0';
        }
        // Load function parameters if not yet loaded
        if ($this->_scale == 0) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return YAPI::INVALID_STRING;
            }
        }
        // Detect old firmware
        if (($this->_caltyp < 0) || ($this->_scale < 0)) {
            $this->_throw(YAPI::NOT_SUPPORTED, 'Calibration parameters format mismatch. Please upgrade your library or firmware.');
            return '0';
        }
        // 32-bit fixed-point encoding
        $res = sprintf('%d', YOCTO_CALIB_TYPE_OFS);
        $idx = 0;
        while ($idx < $npt) {
            $res = sprintf('%s,%F,%F', $res, $rawValues[$idx], $refValues[$idx]);
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _applyCalibration(float $rawValue): float
    {
        if ($rawValue == self::CURRENTVALUE_INVALID) {
            return self::CURRENTVALUE_INVALID;
        }
        if ($this->_caltyp == 0) {
            return $rawValue;
        }
        if ($this->_caltyp < 0) {
            return self::CURRENTVALUE_INVALID;
        }
        if (!(!is_null($this->_calhdl))) {
            return self::CURRENTVALUE_INVALID;
        }
        return call_user_func($this->_calhdl, $rawValue, $this->_caltyp, $this->_calpar, $this->_calraw, $this->_calref);
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _decodeTimedReport(float $timestamp, float $duration, array $report): ?YMeasure
    {
        // $i                      is a int;
        // $byteVal                is a int;
        // $poww                   is a float;
        // $minRaw                 is a float;
        // $avgRaw                 is a float;
        // $maxRaw                 is a float;
        // $sublen                 is a int;
        // $difRaw                 is a float;
        // $startTime              is a float;
        // $endTime                is a float;
        // $minVal                 is a float;
        // $avgVal                 is a float;
        // $maxVal                 is a float;
        if ($duration > 0) {
            $startTime = $timestamp - $duration;
        } else {
            $startTime = $this->_prevTimedReport;
        }
        $endTime = $timestamp;
        $this->_prevTimedReport = $endTime;
        if ($startTime == 0) {
            $startTime = $endTime;
        }
        // 32 bits timed report format
        if (sizeof($report) <= 5) {
            // sub-second report, 1-4 bytes
            $poww = 1;
            $avgRaw = 0;
            $byteVal = 0;
            $i = 1;
            while ($i < sizeof($report)) {
                $byteVal = $report[$i];
                $avgRaw = $avgRaw + $poww * $byteVal;
                $poww = $poww * 0x100;
                $i = $i + 1;
            }
            if ((($byteVal) & (0x80)) != 0) {
                $avgRaw = $avgRaw - $poww;
            }
            $avgVal = $avgRaw / 1000.0;
            if ($this->_caltyp != 0) {
                if (!is_null($this->_calhdl)) {
                    $avgVal = call_user_func($this->_calhdl, $avgVal, $this->_caltyp, $this->_calpar, $this->_calraw, $this->_calref);
                }
            }
            $minVal = $avgVal;
            $maxVal = $avgVal;
        } else {
            // averaged report: avg,avg-min,max-avg
            $sublen = 1 + (($report[1]) & (3));
            $poww = 1;
            $avgRaw = 0;
            $byteVal = 0;
            $i = 2;
            while (($sublen > 0) && ($i < sizeof($report))) {
                $byteVal = $report[$i];
                $avgRaw = $avgRaw + $poww * $byteVal;
                $poww = $poww * 0x100;
                $i = $i + 1;
                $sublen = $sublen - 1;
            }
            if ((($byteVal) & (0x80)) != 0) {
                $avgRaw = $avgRaw - $poww;
            }
            $sublen = 1 + (((($report[1]) >> (2))) & (3));
            $poww = 1;
            $difRaw = 0;
            while (($sublen > 0) && ($i < sizeof($report))) {
                $byteVal = $report[$i];
                $difRaw = $difRaw + $poww * $byteVal;
                $poww = $poww * 0x100;
                $i = $i + 1;
                $sublen = $sublen - 1;
            }
            $minRaw = $avgRaw - $difRaw;
            $sublen = 1 + (((($report[1]) >> (4))) & (3));
            $poww = 1;
            $difRaw = 0;
            while (($sublen > 0) && ($i < sizeof($report))) {
                $byteVal = $report[$i];
                $difRaw = $difRaw + $poww * $byteVal;
                $poww = $poww * 0x100;
                $i = $i + 1;
                $sublen = $sublen - 1;
            }
            $maxRaw = $avgRaw + $difRaw;
            $avgVal = $avgRaw / 1000.0;
            $minVal = $minRaw / 1000.0;
            $maxVal = $maxRaw / 1000.0;
            if ($this->_caltyp != 0) {
                if (!is_null($this->_calhdl)) {
                    $avgVal = call_user_func($this->_calhdl, $avgVal, $this->_caltyp, $this->_calpar, $this->_calraw, $this->_calref);
                    $minVal = call_user_func($this->_calhdl, $minVal, $this->_caltyp, $this->_calpar, $this->_calraw, $this->_calref);
                    $maxVal = call_user_func($this->_calhdl, $maxVal, $this->_caltyp, $this->_calpar, $this->_calraw, $this->_calref);
                }
            }
        }
        return new YMeasure($startTime, $endTime, $minVal, $avgVal, $maxVal);
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _decodeVal(int $w): float
    {
        // $val                    is a float;
        $val = $w;
        if ($this->_caltyp != 0) {
            if (!is_null($this->_calhdl)) {
                $val = call_user_func($this->_calhdl, $val, $this->_caltyp, $this->_calpar, $this->_calraw, $this->_calref);
            }
        }
        return $val;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _decodeAvg(int $dw): float
    {
        // $val                    is a float;
        $val = $dw;
        if ($this->_caltyp != 0) {
            if (!is_null($this->_calhdl)) {
                $val = call_user_func($this->_calhdl, $val, $this->_caltyp, $this->_calpar, $this->_calraw, $this->_calref);
            }
        }
        return $val;
    }

    /**
     * @throws YAPI_Exception
     */
    public function unit(): string
{
    return $this->get_unit();
}

    /**
     * @throws YAPI_Exception
     */
    public function currentValue(): float
{
    return $this->get_currentValue();
}

    /**
     * @throws YAPI_Exception
     */
    public function setLowestValue(float $newval): int
{
    return $this->set_lowestValue($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function lowestValue(): float
{
    return $this->get_lowestValue();
}

    /**
     * @throws YAPI_Exception
     */
    public function setHighestValue(float $newval): int
{
    return $this->set_highestValue($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function highestValue(): float
{
    return $this->get_highestValue();
}

    /**
     * @throws YAPI_Exception
     */
    public function currentRawValue(): float
{
    return $this->get_currentRawValue();
}

    /**
     * @throws YAPI_Exception
     */
    public function logFrequency(): string
{
    return $this->get_logFrequency();
}

    /**
     * @throws YAPI_Exception
     */
    public function setLogFrequency(string $newval): int
{
    return $this->set_logFrequency($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function reportFrequency(): string
{
    return $this->get_reportFrequency();
}

    /**
     * @throws YAPI_Exception
     */
    public function setReportFrequency(string $newval): int
{
    return $this->set_reportFrequency($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function advMode(): int
{
    return $this->get_advMode();
}

    /**
     * @throws YAPI_Exception
     */
    public function setAdvMode(int $newval): int
{
    return $this->set_advMode($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function calibrationParam(): string
{
    return $this->get_calibrationParam();
}

    /**
     * @throws YAPI_Exception
     */
    public function setCalibrationParam(string $newval): int
{
    return $this->set_calibrationParam($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function setResolution(float $newval): int
{
    return $this->set_resolution($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function resolution(): float
{
    return $this->get_resolution();
}

    /**
     * @throws YAPI_Exception
     */
    public function sensorState(): int
{
    return $this->get_sensorState();
}

    /**
     * Continues the enumeration of sensors started using yFirstSensor().
     * Caution: You can't make any assumption about the returned sensors order.
     * If you want to find a specific a sensor, use Sensor.findSensor()
     * and a hardwareID or a logical name.
     *
     * @return ?YSensor  a pointer to a YSensor object, corresponding to
     *         a sensor currently online, or a null pointer
     *         if there are no more sensors to enumerate.
     */
    public function nextSensor(): ?YSensor
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindSensor($next_hwid);
    }

    /**
     * Starts the enumeration of sensors currently accessible.
     * Use the method YSensor::nextSensor() to iterate on
     * next sensors.
     *
     * @return ?YSensor  a pointer to a YSensor object, corresponding to
     *         the first sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstSensor(): ?YSensor
    {
        $next_hwid = YAPI::getFirstHardwareId('Sensor');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindSensor($next_hwid);
    }

    //--- (end of generated code: YSensor implementation)
}

