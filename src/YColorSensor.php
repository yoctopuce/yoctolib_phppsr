<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YColorSensor Class: color sensor control interface
 *
 * The YColorSensor class allows you to read and configure Yoctopuce color sensors.
 */
class YColorSensor extends YFunction
{
    const ESTIMATIONMODEL_REFLECTION = 0;
    const ESTIMATIONMODEL_EMISSION = 1;
    const ESTIMATIONMODEL_INVALID = -1;
    const WORKINGMODE_AUTO = 0;
    const WORKINGMODE_EXPERT = 1;
    const WORKINGMODE_INVALID = -1;
    const LEDCURRENT_INVALID = YAPI::INVALID_UINT;
    const LEDCALIBRATION_INVALID = YAPI::INVALID_UINT;
    const INTEGRATIONTIME_INVALID = YAPI::INVALID_UINT;
    const GAIN_INVALID = YAPI::INVALID_UINT;
    const SATURATION_INVALID = YAPI::INVALID_UINT;
    const ESTIMATEDRGB_INVALID = YAPI::INVALID_UINT;
    const ESTIMATEDHSL_INVALID = YAPI::INVALID_UINT;
    const ESTIMATEDXYZ_INVALID = YAPI::INVALID_STRING;
    const ESTIMATEDOKLAB_INVALID = YAPI::INVALID_STRING;
    const NEARRAL1_INVALID = YAPI::INVALID_STRING;
    const NEARRAL2_INVALID = YAPI::INVALID_STRING;
    const NEARRAL3_INVALID = YAPI::INVALID_STRING;
    const NEARHTMLCOLOR_INVALID = YAPI::INVALID_STRING;
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
    const NEARSIMPLECOLOR_INVALID = YAPI::INVALID_STRING;
    //--- (end of YColorSensor declaration)

    //--- (YColorSensor attributes)
    protected int $_estimationModel = self::ESTIMATIONMODEL_INVALID; // EstimationModel
    protected int $_workingMode = self::WORKINGMODE_INVALID;    // WorkingMode
    protected int $_ledCurrent = self::LEDCURRENT_INVALID;     // UInt31
    protected int $_ledCalibration = self::LEDCALIBRATION_INVALID; // UInt31
    protected int $_integrationTime = self::INTEGRATIONTIME_INVALID; // UInt31
    protected int $_gain = self::GAIN_INVALID;           // UInt31
    protected int $_saturation = self::SATURATION_INVALID;     // SaturationBits
    protected int $_estimatedRGB = self::ESTIMATEDRGB_INVALID;   // U24Color
    protected int $_estimatedHSL = self::ESTIMATEDHSL_INVALID;   // U24Color
    protected string $_estimatedXYZ = self::ESTIMATEDXYZ_INVALID;   // ColorCoord
    protected string $_estimatedOkLab = self::ESTIMATEDOKLAB_INVALID; // ColorCoord
    protected string $_nearRAL1 = self::NEARRAL1_INVALID;       // Text
    protected string $_nearRAL2 = self::NEARRAL2_INVALID;       // Text
    protected string $_nearRAL3 = self::NEARRAL3_INVALID;       // Text
    protected string $_nearHTMLColor = self::NEARHTMLCOLOR_INVALID;  // Text
    protected int $_nearSimpleColorIndex = self::NEARSIMPLECOLORINDEX_INVALID; // SimpleColor
    protected string $_nearSimpleColor = self::NEARSIMPLECOLOR_INVALID; // Text

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
        case 'saturation':
            $this->_saturation = intval($val);
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
        case 'nearSimpleColorIndex':
            $this->_nearSimpleColorIndex = intval($val);
            return 1;
        case 'nearSimpleColor':
            $this->_nearSimpleColor = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the predictive model used for color estimation (reflective or emissive).
     *
     * @return int  either YColorSensor::ESTIMATIONMODEL_REFLECTION or
     * YColorSensor::ESTIMATIONMODEL_EMISSION, according to the predictive model used for color estimation
     * (reflective or emissive)
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
     * Changes the predictive model to be used for color estimation (reflective or emissive).
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @param int $newval : either YColorSensor::ESTIMATIONMODEL_REFLECTION or
     * YColorSensor::ESTIMATIONMODEL_EMISSION, according to the predictive model to be used for color
     * estimation (reflective or emissive)
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
     * Returns the sensor working mode.
     * In Auto mode, sensor parameters are automatically set based on the selected estimation model.
     * In Expert mode, sensor parameters such as gain and integration time are configured manually.
     *
     * @return int  either YColorSensor::WORKINGMODE_AUTO or YColorSensor::WORKINGMODE_EXPERT, according to
     * the sensor working mode
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
     * Changes the sensor working mode.
     * In Auto mode, sensor parameters are automatically set based on the selected estimation model.
     * In Expert mode, sensor parameters such as gain and integration time are configured manually.
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @param int $newval : either YColorSensor::WORKINGMODE_AUTO or YColorSensor::WORKINGMODE_EXPERT,
     * according to the sensor working mode
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
     * Returns the amount of current sent to the illumination LEDs, for reflection measures.
     * The value is an integer ranging from 0 (LEDs off) to 254 (LEDs at maximum intensity).
     *
     * @return int  an integer corresponding to the amount of current sent to the illumination LEDs, for
     * reflection measures
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
     * Changes the amount of current sent to the illumination LEDs, for reflection measures.
     * The value is an integer ranging from 0 (LEDs off) to 254 (LEDs at maximum intensity).
     *
     * @param int $newval : an integer corresponding to the amount of current sent to the illumination
     * LEDs, for reflection measures
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
     * Returns the current sent to the illumination LEDs during the latest calibration.
     *
     * @return int  an integer corresponding to the current sent to the illumination LEDs during the latest calibration
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
     * Remember the LED current sent to the illumination LEDs during a calibration.
     * Thanks to this, the device is able to use the same current when taking measures.
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
     * Returns the current integration time for spectral measure, in milliseconds.
     * A longer integration time increase the sensitivity for low light conditions,
     * but reduces the measure taking rate and may lead to saturation for lighter colors.
     *
     * @return int  an integer corresponding to the current integration time for spectral measure, in milliseconds
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
     * Changes the integration time for spectral measure, in milliseconds.
     * A longer integration time increase the sensitivity for low light conditions,
     * but reduces the measure taking rate and may lead to saturation for lighter colors.
     * This method can only be used when the sensor is configured in expert mode;
     * when running in auto mode, the change is ignored.
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @param int $newval : an integer corresponding to the integration time for spectral measure, in milliseconds
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
     * Returns the current spectral channel detector gain exponent.
     * For a value n ranging from 0 to 12, the applied gain is 2^(n-1).
     * 0 corresponds to a gain of 0.5, and 12 corresponds to a gain of 2048.
     *
     * @return int  an integer corresponding to the current spectral channel detector gain exponent
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
     * Changes the spectral channel detector gain exponent.
     * For a value n ranging from 0 to 12, the applied gain is 2^(n-1).
     * 0 corresponds to a gain of 0.5, and 12 corresponds to a gain of 2048.
     * This method can only be used when the sensor is configured in expert mode;
     * when running in auto mode, the change is ignored.
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @param int $newval : an integer corresponding to the spectral channel detector gain exponent
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
     * Returns the current saturation state of the sensor, as an integer.
     * Bit 0 indicates saturation of the analog sensor, which can only
     * be corrected by reducing the gain parameters or the luminosity.
     * Bit 1 indicates saturation of the digital interface, which can
     * be corrected by reducing the integration time or the gain.
     *
     * @return int  an integer corresponding to the current saturation state of the sensor, as an integer
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
     * Returns the estimated color in RGB color model (0xRRGGBB).
     * The RGB color model describes each color using a combination of 3 components:
     * - Red (R): the intensity of red, in the 0...255 range
     * - Green (G): the intensity of green, in the 0...255 range
     * - Blue (B): the intensity of blue, in the 0...255 range
     *
     * @return int  an integer corresponding to the estimated color in RGB color model (0xRRGGBB)
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
     * Returns the estimated color in HSL color model (0xHHSSLL).
     * The HSL color model describes each color using a combination of 3 components:
     * - Hue (H): the angle on the color wheel (0-360 degrees), mapped to 0...255
     * - Saturation (S): the intensity of the color (0-100%), mapped to 0...255
     * - Lightness (L): the brightness of the color (0-100%), mapped to 0...255
     *
     * @return int  an integer corresponding to the estimated color in HSL color model (0xHHSSLL)
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
     * Returns the estimated color according to the CIE XYZ color model.
     * This color model is based on human vision and light perception, with three components
     * represented by real numbers between 0 and 1:
     * - X: corresponds to a component mixing sensitivity to red and green
     * - Y: represents luminance (perceived brightness)
     * - Z: corresponds to sensitivity to blue
     *
     * @return string  a string corresponding to the estimated color according to the CIE XYZ color model
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
     * Returns the estimated color according to the OkLab color model.
     * OkLab is a perceptual color model that aims to align human color perception with numerical
     * values, so that colors that are visually near are also numerically near. Colors are represented
     * using three components:
     * - L: lightness, a real number between 0 and 1
     * - a: color variations between green and red, between -0.5 and 0.5
     * - b: color variations between blue and yellow, between -0.5 and 0.5.
     *
     * @return string  a string corresponding to the estimated color according to the OkLab color model
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
     * Returns the RAL Classic color closest to the estimated color, with a similarity ratio.
     *
     * @return string  a string corresponding to the RAL Classic color closest to the estimated color,
     * with a similarity ratio
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
     * Returns the second closest RAL Classic color to the estimated color, with a similarity ratio.
     *
     * @return string  a string corresponding to the second closest RAL Classic color to the estimated
     * color, with a similarity ratio
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
     * Returns the third closest RAL Classic color to the estimated color, with a similarity ratio.
     *
     * @return string  a string corresponding to the third closest RAL Classic color to the estimated
     * color, with a similarity ratio
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
     * Returns the name of the HTML color closest to the estimated color.
     *
     * @return string  a string corresponding to the name of the HTML color closest to the estimated color
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
     * Returns the index of the basic color typically used to refer to the estimated color (enumerated value).
     * The list of basic colors recognized is:
     * - 0 - Brown
     * - 1 - Red
     * - 2 - Orange
     * - 3 - Yellow
     * - 4 - White
     * - 5 - Gray
     * - 6 - Black
     * - 7 - Green
     * - 8 - Blue
     * - 9 - Purple
     * - 10 - Pink
     *
     * @return int  a value among YColorSensor::NEARSIMPLECOLORINDEX_BROWN,
     * YColorSensor::NEARSIMPLECOLORINDEX_RED, YColorSensor::NEARSIMPLECOLORINDEX_ORANGE,
     * YColorSensor::NEARSIMPLECOLORINDEX_YELLOW, YColorSensor::NEARSIMPLECOLORINDEX_WHITE,
     * YColorSensor::NEARSIMPLECOLORINDEX_GRAY, YColorSensor::NEARSIMPLECOLORINDEX_BLACK,
     * YColorSensor::NEARSIMPLECOLORINDEX_GREEN, YColorSensor::NEARSIMPLECOLORINDEX_BLUE,
     * YColorSensor::NEARSIMPLECOLORINDEX_PURPLE and YColorSensor::NEARSIMPLECOLORINDEX_PINK corresponding
     * to the index of the basic color typically used to refer to the estimated color (enumerated value)
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
     * Returns the name of the basic color typically used to refer to the estimated color.
     *
     * @return string  a string corresponding to the name of the basic color typically used to refer to
     * the estimated color
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
     * Turns on the built-in illumination LEDs using the same current as used during the latest calibration.
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function turnLedOn(): int
    {
        return $this->set_ledCurrent($this->get_ledCalibration());
    }

    /**
     * Turns off the built-in illumination LEDs.
     * On failure, throws an exception or returns a negative error code.
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
    public function saturation(): int
{
    return $this->get_saturation();
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
    public function nearSimpleColorIndex(): int
{
    return $this->get_nearSimpleColorIndex();
}

    /**
     * @throws YAPI_Exception
     */
    public function nearSimpleColor(): string
{
    return $this->get_nearSimpleColor();
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
