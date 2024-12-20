<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YSpectralSensor Class: spectral sensor control interface
 *
 * The YSpectralSensor class allows you to read and configure Yoctopuce spectral sensors.
 * It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, and to access the autonomous datalogger.
 */
class YSpectralSensor extends YFunction
{
    const LEDCURRENT_INVALID = YAPI::INVALID_INT;
    const RESOLUTION_INVALID = YAPI::INVALID_DOUBLE;
    const INTEGRATIONTIME_INVALID = YAPI::INVALID_INT;
    const GAIN_INVALID = YAPI::INVALID_INT;
    const ESTIMATIONMODEL_REFLECTION = 0;
    const ESTIMATIONMODEL_EMISSION = 1;
    const ESTIMATIONMODEL_INVALID = -1;
    const SATURATION_INVALID = YAPI::INVALID_UINT;
    const ESTIMATEDRGB_INVALID = YAPI::INVALID_UINT;
    const ESTIMATEDHSL_INVALID = YAPI::INVALID_UINT;
    const ESTIMATEDXYZ_INVALID = YAPI::INVALID_STRING;
    const ESTIMATEDOKLAB_INVALID = YAPI::INVALID_STRING;
    const NEARRAL1_INVALID = YAPI::INVALID_STRING;
    const NEARRAL2_INVALID = YAPI::INVALID_STRING;
    const NEARRAL3_INVALID = YAPI::INVALID_STRING;
    const NEARHTMLCOLOR_INVALID = YAPI::INVALID_STRING;
    const LEDCURRENTATPOWERON_INVALID = YAPI::INVALID_INT;
    const INTEGRATIONTIMEATPOWERON_INVALID = YAPI::INVALID_INT;
    const GAINATPOWERON_INVALID = YAPI::INVALID_INT;
    //--- (end of YSpectralSensor declaration)

    //--- (YSpectralSensor attributes)
    protected int $_ledCurrent = self::LEDCURRENT_INVALID;     // Int
    protected float $_resolution = self::RESOLUTION_INVALID;     // MeasureVal
    protected int $_integrationTime = self::INTEGRATIONTIME_INVALID; // Int
    protected int $_gain = self::GAIN_INVALID;           // Int
    protected int $_estimationModel = self::ESTIMATIONMODEL_INVALID; // EstimationModel
    protected int $_saturation = self::SATURATION_INVALID;     // SaturationBits
    protected int $_estimatedRGB = self::ESTIMATEDRGB_INVALID;   // U24Color
    protected int $_estimatedHSL = self::ESTIMATEDHSL_INVALID;   // U24Color
    protected string $_estimatedXYZ = self::ESTIMATEDXYZ_INVALID;   // ColorCoord
    protected string $_estimatedOkLab = self::ESTIMATEDOKLAB_INVALID; // ColorCoord
    protected string $_nearRAL1 = self::NEARRAL1_INVALID;       // Text
    protected string $_nearRAL2 = self::NEARRAL2_INVALID;       // Text
    protected string $_nearRAL3 = self::NEARRAL3_INVALID;       // Text
    protected string $_nearHTMLColor = self::NEARHTMLCOLOR_INVALID;  // Text
    protected int $_ledCurrentAtPowerOn = self::LEDCURRENTATPOWERON_INVALID; // Int
    protected int $_integrationTimeAtPowerOn = self::INTEGRATIONTIMEATPOWERON_INVALID; // Int
    protected int $_gainAtPowerOn = self::GAINATPOWERON_INVALID;  // Int

    //--- (end of YSpectralSensor attributes)

    function __construct(string $str_func)
    {
        //--- (YSpectralSensor constructor)
        parent::__construct($str_func);
        $this->_className = 'SpectralSensor';

        //--- (end of YSpectralSensor constructor)
    }

    //--- (YSpectralSensor implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'ledCurrent':
            $this->_ledCurrent = intval($val);
            return 1;
        case 'resolution':
            $this->_resolution = round($val / 65.536) / 1000.0;
            return 1;
        case 'integrationTime':
            $this->_integrationTime = intval($val);
            return 1;
        case 'gain':
            $this->_gain = intval($val);
            return 1;
        case 'estimationModel':
            $this->_estimationModel = intval($val);
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
        case 'ledCurrentAtPowerOn':
            $this->_ledCurrentAtPowerOn = intval($val);
            return 1;
        case 'integrationTimeAtPowerOn':
            $this->_integrationTimeAtPowerOn = intval($val);
            return 1;
        case 'gainAtPowerOn':
            $this->_gainAtPowerOn = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the current value of the LED.
     * This method retrieves the current flowing through the LED
     * and returns it as an integer or an object.
     *
     * @return int  an integer corresponding to the current value of the LED
     *
     * On failure, throws an exception or returns YSpectralSensor::LEDCURRENT_INVALID.
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
     * value between 0 and 100.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
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
     * On failure, throws an exception or returns YSpectralSensor::RESOLUTION_INVALID.
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
     * Returns the current integration time.
     * This method retrieves the integration time value
     * used for data processing and returns it as an integer or an object.
     *
     * @return int  an integer corresponding to the current integration time
     *
     * On failure, throws an exception or returns YSpectralSensor::INTEGRATIONTIME_INVALID.
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
     * Sets the integration time for data processing.
     * This method takes a parameter `val` and assigns it
     * as the new integration time. This affects the duration
     * for which data is integrated before being processed.
     *
     * @param int $newval : an integer
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
     * Retrieves the current gain.
     * This method updates the gain value.
     *
     * @return int  an integer
     *
     * On failure, throws an exception or returns YSpectralSensor::GAIN_INVALID.
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
     * Sets the gain for signal processing.
     * This method takes a parameter `val` and assigns it
     * as the new gain. This affects the sensitivity and
     * intensity of the processed signal.
     *
     * @param int $newval : an integer
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
     * Return the model for the estimation colors.
     *
     * @return int  either YSpectralSensor::ESTIMATIONMODEL_REFLECTION or YSpectralSensor::ESTIMATIONMODEL_EMISSION
     *
     * On failure, throws an exception or returns YSpectralSensor::ESTIMATIONMODEL_INVALID.
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
     * Change the model for the estimation colors.
     *
     * @param int $newval : either YSpectralSensor::ESTIMATIONMODEL_REFLECTION or
     * YSpectralSensor::ESTIMATIONMODEL_EMISSION
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
     * Returns the current saturation of the sensor.
     * This function updates the sensor's saturation value.
     *
     * @return int  an integer corresponding to the current saturation of the sensor
     *
     * On failure, throws an exception or returns YSpectralSensor::SATURATION_INVALID.
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
     * Returns the estimated color in RGB format.
     * This method retrieves the estimated color values
     * and returns them as an RGB object or structure.
     *
     * @return int  an integer corresponding to the estimated color in RGB format
     *
     * On failure, throws an exception or returns YSpectralSensor::ESTIMATEDRGB_INVALID.
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
     * Returns the estimated color in HSL format.
     * This method retrieves the estimated color values
     * and returns them as an HSL object or structure.
     *
     * @return int  an integer corresponding to the estimated color in HSL format
     *
     * On failure, throws an exception or returns YSpectralSensor::ESTIMATEDHSL_INVALID.
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
     * This method retrieves the estimated color values
     * and returns them as an XYZ object or structure.
     *
     * @return string  a string corresponding to the estimated color in XYZ format
     *
     * On failure, throws an exception or returns YSpectralSensor::ESTIMATEDXYZ_INVALID.
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
     * This method retrieves the estimated color values
     * and returns them as an OkLab object or structure.
     *
     * @return string  a string corresponding to the estimated color in OkLab format
     *
     * On failure, throws an exception or returns YSpectralSensor::ESTIMATEDOKLAB_INVALID.
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
     * @throws YAPI_Exception on error
     */
    public function get_ledCurrentAtPowerOn(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LEDCURRENTATPOWERON_INVALID;
            }
        }
        $res = $this->_ledCurrentAtPowerOn;
        return $res;
    }

    /**
     * Sets the LED current at power-on.
     * This method takes a parameter `val` and assigns it to startupLumin, representing the LED current defined
     * at startup.
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @param int $newval : an integer
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_ledCurrentAtPowerOn(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("ledCurrentAtPowerOn", $rest_val);
    }

    /**
     * Retrieves the integration time at power-on.
     * This method updates the power-on integration time value.
     *
     * @return int  an integer
     *
     * On failure, throws an exception or returns YSpectralSensor::INTEGRATIONTIMEATPOWERON_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_integrationTimeAtPowerOn(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::INTEGRATIONTIMEATPOWERON_INVALID;
            }
        }
        $res = $this->_integrationTimeAtPowerOn;
        return $res;
    }

    /**
     * Sets the integration time at power-on.
     * This method takes a parameter `val` and assigns it to startupIntegTime, representing the integration time
     * defined at startup.
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @param int $newval : an integer
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_integrationTimeAtPowerOn(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("integrationTimeAtPowerOn", $rest_val);
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_gainAtPowerOn(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::GAINATPOWERON_INVALID;
            }
        }
        $res = $this->_gainAtPowerOn;
        return $res;
    }

    /**
     * Sets the gain at power-on.
     * This method takes a parameter `val` and assigns it to startupGain, representing the gain defined at startup.
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @param int $newval : an integer
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_gainAtPowerOn(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("gainAtPowerOn", $rest_val);
    }

    /**
     * Retrieves a spectral sensor for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the spectral sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the spectral sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a spectral sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the spectral sensor, for instance
     *         MyDevice.spectralSensor.
     *
     * @return YSpectralSensor  a YSpectralSensor object allowing you to drive the spectral sensor.
     */
    public static function FindSpectralSensor(string $func): YSpectralSensor
    {
        // $obj                    is a YSpectralSensor;
        $obj = YFunction::_FindFromCache('SpectralSensor', $func);
        if ($obj == null) {
            $obj = new YSpectralSensor($func);
            YFunction::_AddToCache('SpectralSensor', $func, $obj);
        }
        return $obj;
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
    public function ledCurrentAtPowerOn(): int
{
    return $this->get_ledCurrentAtPowerOn();
}

    /**
     * @throws YAPI_Exception
     */
    public function setLedCurrentAtPowerOn(int $newval): int
{
    return $this->set_ledCurrentAtPowerOn($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function integrationTimeAtPowerOn(): int
{
    return $this->get_integrationTimeAtPowerOn();
}

    /**
     * @throws YAPI_Exception
     */
    public function setIntegrationTimeAtPowerOn(int $newval): int
{
    return $this->set_integrationTimeAtPowerOn($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function gainAtPowerOn(): int
{
    return $this->get_gainAtPowerOn();
}

    /**
     * @throws YAPI_Exception
     */
    public function setGainAtPowerOn(int $newval): int
{
    return $this->set_gainAtPowerOn($newval);
}

    /**
     * Continues the enumeration of spectral sensors started using yFirstSpectralSensor().
     * Caution: You can't make any assumption about the returned spectral sensors order.
     * If you want to find a specific a spectral sensor, use SpectralSensor.findSpectralSensor()
     * and a hardwareID or a logical name.
     *
     * @return ?YSpectralSensor  a pointer to a YSpectralSensor object, corresponding to
     *         a spectral sensor currently online, or a null pointer
     *         if there are no more spectral sensors to enumerate.
     */
    public function nextSpectralSensor(): ?YSpectralSensor
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindSpectralSensor($next_hwid);
    }

    /**
     * Starts the enumeration of spectral sensors currently accessible.
     * Use the method YSpectralSensor::nextSpectralSensor() to iterate on
     * next spectral sensors.
     *
     * @return ?YSpectralSensor  a pointer to a YSpectralSensor object, corresponding to
     *         the first spectral sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstSpectralSensor(): ?YSpectralSensor
    {
        $next_hwid = YAPI::getFirstHardwareId('SpectralSensor');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindSpectralSensor($next_hwid);
    }

    //--- (end of YSpectralSensor implementation)

}
