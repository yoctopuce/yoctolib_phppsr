<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YColorSensor Class: color sensor control interface
 *
 * The YColorSensor class allows you to read and configure Yoctopuce color sensors.
 * It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, and to access the autonomous datalogger.
 */
class YColorSensor extends YFunction
{
    const ESTIMATIONMODEL_REFLECTION = 0;
    const ESTIMATIONMODEL_EMISSION = 1;
    const ESTIMATIONMODEL_INVALID = -1;
    const WORKINGMODE_AUTO = 0;
    const WORKINGMODE_EXPERT = 1;
    const WORKINGMODE_INVALID = -1;
    const SATURATION_INVALID = YAPI::INVALID_UINT;
    const LEDCURRENT_INVALID = YAPI::INVALID_UINT;
    const LEDCALIBRATION_INVALID = YAPI::INVALID_UINT;
    const INTEGRATIONTIME_INVALID = YAPI::INVALID_UINT;
    const GAIN_INVALID = YAPI::INVALID_UINT;
    const ESTIMATEDRGB_INVALID = YAPI::INVALID_UINT;
    const ESTIMATEDHSL_INVALID = YAPI::INVALID_UINT;
    const ESTIMATEDXYZ_INVALID = YAPI::INVALID_STRING;
    const ESTIMATEDOKLAB_INVALID = YAPI::INVALID_STRING;
    const NEARRAL1_INVALID = YAPI::INVALID_STRING;
    const NEARRAL2_INVALID = YAPI::INVALID_STRING;
    const NEARRAL3_INVALID = YAPI::INVALID_STRING;
    const NEARHTMLCOLOR_INVALID = YAPI::INVALID_STRING;
    const NEARSIMPLECOLOR_INVALID = YAPI::INVALID_STRING;
    const NEARSIMPLECOLORINDEX_BROWN = 0;
    const NEARSIMPLECOLORINDEX_RED = 1;
    const NEARSIMPLECOLORINDEX_ORANGE = 2;
    const NEARSIMPLECOLORINDEX_YELLOW = 3;
    const NEARSIMPLECOLORINDEX_WHITE = 4;
    const NEARSIMPLECOLORINDEX_GRAY = 5;
    const NEARSIMPLECOLORINDEX_BLACK = 6;
    const NEARSIMPLECOLORINDEX_GREEN = 7;
    const NEARSIMPLECOLORINDEX_BLUE = 8;
    const NEARSIMPLECOLORINDEX_PURPLE = 9;
    const NEARSIMPLECOLORINDEX_PINK = 10;
    const NEARSIMPLECOLORINDEX_INVALID = -1;
    //--- (end of YColorSensor declaration)

    //--- (YColorSensor attributes)
    protected int $_estimationModel = self::ESTIMATIONMODEL_INVALID; // EstimationModel
    protected int $_workingMode = self::WORKINGMODE_INVALID;    // WorkingMode
    protected int $_saturation = self::SATURATION_INVALID;     // SaturationBits
    protected int $_ledCurrent = self::LEDCURRENT_INVALID;     // UInt31
    protected int $_ledCalibration = self::LEDCALIBRATION_INVALID; // UInt31
    protected int $_integrationTime = self::INTEGRATIONTIME_INVALID; // UInt31
    protected int $_gain = self::GAIN_INVALID;           // UInt31
    protected int $_estimatedRGB = self::ESTIMATEDRGB_INVALID;   // U24Color
    protected int $_estimatedHSL = self::ESTIMATEDHSL_INVALID;   // U24Color
    protected string $_estimatedXYZ = self::ESTIMATEDXYZ_INVALID;   // ColorCoord
    protected string $_estimatedOkLab = self::ESTIMATEDOKLAB_INVALID; // ColorCoord
    protected string $_nearRAL1 = self::NEARRAL1_INVALID;       // Text
    protected string $_nearRAL2 = self::NEARRAL2_INVALID;       // Text
    protected string $_nearRAL3 = self::NEARRAL3_INVALID;       // Text
    protected string $_nearHTMLColor = self::NEARHTMLCOLOR_INVALID;  // Text
    protected string $_nearSimpleColor = self::NEARSIMPLECOLOR_INVALID; // Text
    protected int $_nearSimpleColorIndex = self::NEARSIMPLECOLORINDEX_INVALID; // SimpleColor

    //--- (end of YColorSensor attributes)

    function __construct(string $str_func)
    {
        //--- (YColorSensor constructor)
        parent::__construct($str_func);
        $this->_className = 'ColorSensor';

        //--- (end of YColorSensor constructor)
    }

    //--- (YColorSensor implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'estimationModel':
            $this->_estimationModel = intval($val);
            return 1;
        case 'workingMode':
            $this->_workingMode = intval($val);
            return 1;
        case 'saturation':
            $this->_saturation = intval($val);
            return 1;
        case 'ledCurrent':
            $this->_ledCurrent = intval($val);
            return 1;
        case 'ledCalibration':
            $this->_ledCalibration = intval($val);
            return 1;
        case 'integrationTime':
            $this->_integrationTime = intval($val);
            return 1;
        case 'gain':
            $this->_gain = intval($val);
            return 1;
        case 'estimatedRGB':
            $this->_estimatedRGB = intval($val);
            return 1;
        case 'estimatedHSL':
            $this->_estimatedHSL = intval($val);
            return 1;
        case 'estimatedXYZ':
            $this->_estimatedXYZ = $val;
            return 1;
        case 'estimatedOkLab':
            $this->_estimatedOkLab = $val;
            return 1;
        case 'nearRAL1':
            $this->_nearRAL1 = $val;
            return 1;
        case 'nearRAL2':
            $this->_nearRAL2 = $val;
            return 1;
        case 'nearRAL3':
            $this->_nearRAL3 = $val;
            return 1;
        case 'nearHTMLColor':
            $this->_nearHTMLColor = $val;
            return 1;
        case 'nearSimpleColor':
            $this->_nearSimpleColor = $val;
            return 1;
        case 'nearSimpleColorIndex':
            $this->_nearSimpleColorIndex = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the model for color estimation.
     *
     * @return int  either YColorSensor::ESTIMATIONMODEL_REFLECTION or
     * YColorSensor::ESTIMATIONMODEL_EMISSION, according to the model for color estimation
     *
     * On failure, throws an exception or returns YColorSensor::ESTIMATIONMODEL_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_estimationModel(): int
    {
        // $res                    is a enumESTIMATIONMODEL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::ESTIMATIONMODEL_INVALID;
            }
        }
        $res = $this->_estimationModel;
        return $res;
    }

    /**
     * Changes the model for color estimation.
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @param int $newval : either YColorSensor::ESTIMATIONMODEL_REFLECTION or
     * YColorSensor::ESTIMATIONMODEL_EMISSION, according to the model for color estimation
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_estimationModel(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("estimationModel", $rest_val);
    }

    /**
     * Returns the active working mode.
     *
     * @return int  either YColorSensor::WORKINGMODE_AUTO or YColorSensor::WORKINGMODE_EXPERT, according to
     * the active working mode
     *
     * On failure, throws an exception or returns YColorSensor::WORKINGMODE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_workingMode(): int
    {
        // $res                    is a enumWORKINGMODE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::WORKINGMODE_INVALID;
            }
        }
        $res = $this->_workingMode;
        return $res;
    }

    /**
     * Changes the operating mode.
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @param int $newval : either YColorSensor::WORKINGMODE_AUTO or YColorSensor::WORKINGMODE_EXPERT,
     * according to the operating mode
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_workingMode(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("workingMode", $rest_val);
    }

    /**
     * Returns the current saturation of the sensor.
     * This function updates the sensor's saturation value.
     *
     * @return int  an integer corresponding to the current saturation of the sensor
     *
     * On failure, throws an exception or returns YColorSensor::SATURATION_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_saturation(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SATURATION_INVALID;
            }
        }
        $res = $this->_saturation;
        return $res;
    }

    /**
     * Returns the current value of the LED.
     *
     * @return int  an integer corresponding to the current value of the LED
     *
     * On failure, throws an exception or returns YColorSensor::LEDCURRENT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_ledCurrent(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LEDCURRENT_INVALID;
            }
        }
        $res = $this->_ledCurrent;
        return $res;
    }

    /**
     * Changes the luminosity of the module leds. The parameter is a
     * value between 0 and 254.
     *
     * @param int $newval : an integer corresponding to the luminosity of the module leds
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_ledCurrent(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("ledCurrent", $rest_val);
    }

    /**
     * Returns the LED current at calibration.
     *
     * @return int  an integer corresponding to the LED current at calibration
     *
     * On failure, throws an exception or returns YColorSensor::LEDCALIBRATION_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_ledCalibration(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LEDCALIBRATION_INVALID;
            }
        }
        $res = $this->_ledCalibration;
        return $res;
    }

    /**
     * Sets the LED current for calibration.
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @param int $newval : an integer
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_ledCalibration(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("ledCalibration", $rest_val);
    }

    /**
     * Returns the current integration time.
     * This method retrieves the integration time value
     * used for data processing and returns it as an integer or an object.
     *
     * @return int  an integer corresponding to the current integration time
     *
     * On failure, throws an exception or returns YColorSensor::INTEGRATIONTIME_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_integrationTime(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::INTEGRATIONTIME_INVALID;
            }
        }
        $res = $this->_integrationTime;
        return $res;
    }

    /**
     * Changes the integration time for data processing.
     * This method takes a parameter and assigns it
     * as the new integration time. This affects the duration
     * for which data is integrated before being processed.
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @param int $newval : an integer corresponding to the integration time for data processing
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_integrationTime(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("integrationTime", $rest_val);
    }

    /**
     * Returns the current gain.
     * This method updates the gain value.
     *
     * @return int  an integer corresponding to the current gain
     *
     * On failure, throws an exception or returns YColorSensor::GAIN_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_gain(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::GAIN_INVALID;
            }
        }
        $res = $this->_gain;
        return $res;
    }

    /**
     * Changes the gain for signal processing.
     * This method takes a parameter and assigns it
     * as the new gain. This affects the sensitivity and
     * intensity of the processed signal.
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @param int $newval : an integer corresponding to the gain for signal processing
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_gain(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("gain", $rest_val);
    }

    /**
     * Returns the estimated color in RGB format (0xRRGGBB).
     *
     * @return int  an integer corresponding to the estimated color in RGB format (0xRRGGBB)
     *
     * On failure, throws an exception or returns YColorSensor::ESTIMATEDRGB_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_estimatedRGB(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::ESTIMATEDRGB_INVALID;
            }
        }
        $res = $this->_estimatedRGB;
        return $res;
    }

    /**
     * Returns the estimated color in HSL (Hue, Saturation, Lightness) format.
     *
     * @return int  an integer corresponding to the estimated color in HSL (Hue, Saturation, Lightness) format
     *
     * On failure, throws an exception or returns YColorSensor::ESTIMATEDHSL_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_estimatedHSL(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::ESTIMATEDHSL_INVALID;
            }
        }
        $res = $this->_estimatedHSL;
        return $res;
    }

    /**
     * Returns the estimated color in XYZ format.
     *
     * @return string  a string corresponding to the estimated color in XYZ format
     *
     * On failure, throws an exception or returns YColorSensor::ESTIMATEDXYZ_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_estimatedXYZ(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::ESTIMATEDXYZ_INVALID;
            }
        }
        $res = $this->_estimatedXYZ;
        return $res;
    }

    /**
     * Returns the estimated color in OkLab format.
     *
     * @return string  a string corresponding to the estimated color in OkLab format
     *
     * On failure, throws an exception or returns YColorSensor::ESTIMATEDOKLAB_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_estimatedOkLab(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::ESTIMATEDOKLAB_INVALID;
            }
        }
        $res = $this->_estimatedOkLab;
        return $res;
    }

    /**
     * Returns the estimated color in RAL format.
     *
     * @return string  a string corresponding to the estimated color in RAL format
     *
     * On failure, throws an exception or returns YColorSensor::NEARRAL1_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_nearRAL1(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::NEARRAL1_INVALID;
            }
        }
        $res = $this->_nearRAL1;
        return $res;
    }

    /**
     * Returns the estimated color in RAL format.
     *
     * @return string  a string corresponding to the estimated color in RAL format
     *
     * On failure, throws an exception or returns YColorSensor::NEARRAL2_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_nearRAL2(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::NEARRAL2_INVALID;
            }
        }
        $res = $this->_nearRAL2;
        return $res;
    }

    /**
     * Returns the estimated color in RAL format.
     *
     * @return string  a string corresponding to the estimated color in RAL format
     *
     * On failure, throws an exception or returns YColorSensor::NEARRAL3_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_nearRAL3(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::NEARRAL3_INVALID;
            }
        }
        $res = $this->_nearRAL3;
        return $res;
    }

    /**
     * Returns the estimated HTML color .
     *
     * @return string  a string corresponding to the estimated HTML color
     *
     * On failure, throws an exception or returns YColorSensor::NEARHTMLCOLOR_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_nearHTMLColor(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::NEARHTMLCOLOR_INVALID;
            }
        }
        $res = $this->_nearHTMLColor;
        return $res;
    }

    /**
     * Returns the estimated color .
     *
     * @return string  a string corresponding to the estimated color
     *
     * On failure, throws an exception or returns YColorSensor::NEARSIMPLECOLOR_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_nearSimpleColor(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::NEARSIMPLECOLOR_INVALID;
            }
        }
        $res = $this->_nearSimpleColor;
        return $res;
    }

    /**
     * Returns the estimated color as an index.
     *
     * @return int  a value among YColorSensor::NEARSIMPLECOLORINDEX_BROWN,
     * YColorSensor::NEARSIMPLECOLORINDEX_RED, YColorSensor::NEARSIMPLECOLORINDEX_ORANGE,
     * YColorSensor::NEARSIMPLECOLORINDEX_YELLOW, YColorSensor::NEARSIMPLECOLORINDEX_WHITE,
     * YColorSensor::NEARSIMPLECOLORINDEX_GRAY, YColorSensor::NEARSIMPLECOLORINDEX_BLACK,
     * YColorSensor::NEARSIMPLECOLORINDEX_GREEN, YColorSensor::NEARSIMPLECOLORINDEX_BLUE,
     * YColorSensor::NEARSIMPLECOLORINDEX_PURPLE and YColorSensor::NEARSIMPLECOLORINDEX_PINK corresponding
     * to the estimated color as an index
     *
     * On failure, throws an exception or returns YColorSensor::NEARSIMPLECOLORINDEX_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_nearSimpleColorIndex(): int
    {
        // $res                    is a enumSIMPLECOLOR;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::NEARSIMPLECOLORINDEX_INVALID;
            }
        }
        $res = $this->_nearSimpleColorIndex;
        return $res;
    }

    /**
     * Retrieves a color sensor for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the color sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the color sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a color sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the color sensor, for instance
     *         MyDevice.colorSensor.
     *
     * @return YColorSensor  a YColorSensor object allowing you to drive the color sensor.
     */
    public static function FindColorSensor(string $func): YColorSensor
    {
        // $obj                    is a YColorSensor;
        $obj = YFunction::_FindFromCache('ColorSensor', $func);
        if ($obj == null) {
            $obj = new YColorSensor($func);
            YFunction::_AddToCache('ColorSensor', $func, $obj);
        }
        return $obj;
    }

    /**
     * Turns on the LEDs at the current used during calibration.
     * On failure, throws an exception or returns YColorSensor::DATA_INVALID.
     * @throws YAPI_Exception on error
     */
    public function turnLedOn(): int
    {
        return $this->set_ledCurrent($this->get_ledCalibration());
    }

    /**
     * Turns off the LEDs.
     * On failure, throws an exception or returns YColorSensor::DATA_INVALID.
     * @throws YAPI_Exception on error
     */
    public function turnLedOff(): int
    {
        return $this->set_ledCurrent(0);
    }

    /**
     * @throws YAPI_Exception
     */
    public function estimationModel(): int
{
    return $this->get_estimationModel();
}

    /**
     * @throws YAPI_Exception
     */
    public function setEstimationModel(int $newval): int
{
    return $this->set_estimationModel($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function workingMode(): int
{
    return $this->get_workingMode();
}

    /**
     * @throws YAPI_Exception
     */
    public function setWorkingMode(int $newval): int
{
    return $this->set_workingMode($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function saturation(): int
{
    return $this->get_saturation();
}

    /**
     * @throws YAPI_Exception
     */
    public function ledCurrent(): int
{
    return $this->get_ledCurrent();
}

    /**
     * @throws YAPI_Exception
     */
    public function setLedCurrent(int $newval): int
{
    return $this->set_ledCurrent($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function ledCalibration(): int
{
    return $this->get_ledCalibration();
}

    /**
     * @throws YAPI_Exception
     */
    public function setLedCalibration(int $newval): int
{
    return $this->set_ledCalibration($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function integrationTime(): int
{
    return $this->get_integrationTime();
}

    /**
     * @throws YAPI_Exception
     */
    public function setIntegrationTime(int $newval): int
{
    return $this->set_integrationTime($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function gain(): int
{
    return $this->get_gain();
}

    /**
     * @throws YAPI_Exception
     */
    public function setGain(int $newval): int
{
    return $this->set_gain($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function estimatedRGB(): int
{
    return $this->get_estimatedRGB();
}

    /**
     * @throws YAPI_Exception
     */
    public function estimatedHSL(): int
{
    return $this->get_estimatedHSL();
}

    /**
     * @throws YAPI_Exception
     */
    public function estimatedXYZ(): string
{
    return $this->get_estimatedXYZ();
}

    /**
     * @throws YAPI_Exception
     */
    public function estimatedOkLab(): string
{
    return $this->get_estimatedOkLab();
}

    /**
     * @throws YAPI_Exception
     */
    public function nearRAL1(): string
{
    return $this->get_nearRAL1();
}

    /**
     * @throws YAPI_Exception
     */
    public function nearRAL2(): string
{
    return $this->get_nearRAL2();
}

    /**
     * @throws YAPI_Exception
     */
    public function nearRAL3(): string
{
    return $this->get_nearRAL3();
}

    /**
     * @throws YAPI_Exception
     */
    public function nearHTMLColor(): string
{
    return $this->get_nearHTMLColor();
}

    /**
     * @throws YAPI_Exception
     */
    public function nearSimpleColor(): string
{
    return $this->get_nearSimpleColor();
}

    /**
     * @throws YAPI_Exception
     */
    public function nearSimpleColorIndex(): int
{
    return $this->get_nearSimpleColorIndex();
}

    /**
     * Continues the enumeration of color sensors started using yFirstColorSensor().
     * Caution: You can't make any assumption about the returned color sensors order.
     * If you want to find a specific a color sensor, use ColorSensor.findColorSensor()
     * and a hardwareID or a logical name.
     *
     * @return ?YColorSensor  a pointer to a YColorSensor object, corresponding to
     *         a color sensor currently online, or a null pointer
     *         if there are no more color sensors to enumerate.
     */
    public function nextColorSensor(): ?YColorSensor
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindColorSensor($next_hwid);
    }

    /**
     * Starts the enumeration of color sensors currently accessible.
     * Use the method YColorSensor::nextColorSensor() to iterate on
     * next color sensors.
     *
     * @return ?YColorSensor  a pointer to a YColorSensor object, corresponding to
     *         the first color sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstColorSensor(): ?YColorSensor
    {
        $next_hwid = YAPI::getFirstHardwareId('ColorSensor');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindColorSensor($next_hwid);
    }

    //--- (end of YColorSensor implementation)

}
