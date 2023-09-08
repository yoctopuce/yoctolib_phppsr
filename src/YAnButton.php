<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YAnButton Class: analog input control interface, available for instance in the Yocto-Buzzer, the
 * Yocto-Knob, the Yocto-MaxiBuzzer or the Yocto-MaxiDisplay
 *
 * The YAnButton class provide access to basic resistive inputs.
 * Such inputs can be used to measure the state
 * of a simple button as well as to read an analog potentiometer (variable resistance).
 * This can be use for instance with a continuous rotating knob, a throttle grip
 * or a joystick. The module is capable to calibrate itself on min and max values,
 * in order to compute a calibrated value that varies proportionally with the
 * potentiometer position, regardless of its total resistance.
 */
class YAnButton extends YFunction
{
    const CALIBRATEDVALUE_INVALID = YAPI::INVALID_UINT;
    const RAWVALUE_INVALID = YAPI::INVALID_UINT;
    const ANALOGCALIBRATION_OFF = 0;
    const ANALOGCALIBRATION_ON = 1;
    const ANALOGCALIBRATION_INVALID = -1;
    const CALIBRATIONMAX_INVALID = YAPI::INVALID_UINT;
    const CALIBRATIONMIN_INVALID = YAPI::INVALID_UINT;
    const SENSITIVITY_INVALID = YAPI::INVALID_UINT;
    const ISPRESSED_FALSE = 0;
    const ISPRESSED_TRUE = 1;
    const ISPRESSED_INVALID = -1;
    const LASTTIMEPRESSED_INVALID = YAPI::INVALID_LONG;
    const LASTTIMERELEASED_INVALID = YAPI::INVALID_LONG;
    const PULSECOUNTER_INVALID = YAPI::INVALID_LONG;
    const PULSETIMER_INVALID = YAPI::INVALID_LONG;
    const INPUTTYPE_ANALOG_FAST = 0;
    const INPUTTYPE_DIGITAL4 = 1;
    const INPUTTYPE_ANALOG_SMOOTH = 2;
    const INPUTTYPE_DIGITAL_FAST = 3;
    const INPUTTYPE_INVALID = -1;
    //--- (end of YAnButton declaration)

    //--- (YAnButton attributes)
    protected int $_calibratedValue = self::CALIBRATEDVALUE_INVALID; // UInt31
    protected int $_rawValue = self::RAWVALUE_INVALID;       // UInt31
    protected int $_analogCalibration = self::ANALOGCALIBRATION_INVALID; // OnOff
    protected int $_calibrationMax = self::CALIBRATIONMAX_INVALID; // UInt31
    protected int $_calibrationMin = self::CALIBRATIONMIN_INVALID; // UInt31
    protected int $_sensitivity = self::SENSITIVITY_INVALID;    // UInt31
    protected int $_isPressed = self::ISPRESSED_INVALID;      // Bool
    protected float $_lastTimePressed = self::LASTTIMEPRESSED_INVALID; // Time
    protected float $_lastTimeReleased = self::LASTTIMERELEASED_INVALID; // Time
    protected float $_pulseCounter = self::PULSECOUNTER_INVALID;   // UInt
    protected float $_pulseTimer = self::PULSETIMER_INVALID;     // Time
    protected int $_inputType = self::INPUTTYPE_INVALID;      // InputType

    //--- (end of YAnButton attributes)

    function __construct(string $str_func)
    {
        //--- (YAnButton constructor)
        parent::__construct($str_func);
        $this->_className = 'AnButton';

        //--- (end of YAnButton constructor)
    }

    //--- (YAnButton implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'calibratedValue':
            $this->_calibratedValue = intval($val);
            return 1;
        case 'rawValue':
            $this->_rawValue = intval($val);
            return 1;
        case 'analogCalibration':
            $this->_analogCalibration = intval($val);
            return 1;
        case 'calibrationMax':
            $this->_calibrationMax = intval($val);
            return 1;
        case 'calibrationMin':
            $this->_calibrationMin = intval($val);
            return 1;
        case 'sensitivity':
            $this->_sensitivity = intval($val);
            return 1;
        case 'isPressed':
            $this->_isPressed = intval($val);
            return 1;
        case 'lastTimePressed':
            $this->_lastTimePressed = intval($val);
            return 1;
        case 'lastTimeReleased':
            $this->_lastTimeReleased = intval($val);
            return 1;
        case 'pulseCounter':
            $this->_pulseCounter = intval($val);
            return 1;
        case 'pulseTimer':
            $this->_pulseTimer = intval($val);
            return 1;
        case 'inputType':
            $this->_inputType = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the current calibrated input value (between 0 and 1000, included).
     *
     * @return int  an integer corresponding to the current calibrated input value (between 0 and 1000, included)
     *
     * On failure, throws an exception or returns YAnButton::CALIBRATEDVALUE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_calibratedValue(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CALIBRATEDVALUE_INVALID;
            }
        }
        $res = $this->_calibratedValue;
        return $res;
    }

    /**
     * Returns the current measured input value as-is (between 0 and 4095, included).
     *
     * @return int  an integer corresponding to the current measured input value as-is (between 0 and 4095, included)
     *
     * On failure, throws an exception or returns YAnButton::RAWVALUE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_rawValue(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::RAWVALUE_INVALID;
            }
        }
        $res = $this->_rawValue;
        return $res;
    }

    /**
     * Tells if a calibration process is currently ongoing.
     *
     * @return int  either YAnButton::ANALOGCALIBRATION_OFF or YAnButton::ANALOGCALIBRATION_ON
     *
     * On failure, throws an exception or returns YAnButton::ANALOGCALIBRATION_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_analogCalibration(): int
    {
        // $res                    is a enumONOFF;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::ANALOGCALIBRATION_INVALID;
            }
        }
        $res = $this->_analogCalibration;
        return $res;
    }

    /**
     * Starts or stops the calibration process. Remember to call the saveToFlash()
     * method of the module at the end of the calibration if the modification must be kept.
     *
     * @param int $newval : either YAnButton::ANALOGCALIBRATION_OFF or YAnButton::ANALOGCALIBRATION_ON
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_analogCalibration(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("analogCalibration", $rest_val);
    }

    /**
     * Returns the maximal value measured during the calibration (between 0 and 4095, included).
     *
     * @return int  an integer corresponding to the maximal value measured during the calibration (between
     * 0 and 4095, included)
     *
     * On failure, throws an exception or returns YAnButton::CALIBRATIONMAX_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_calibrationMax(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CALIBRATIONMAX_INVALID;
            }
        }
        $res = $this->_calibrationMax;
        return $res;
    }

    /**
     * Changes the maximal calibration value for the input (between 0 and 4095, included), without actually
     * starting the automated calibration.  Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param int $newval : an integer corresponding to the maximal calibration value for the input
     * (between 0 and 4095, included), without actually
     *         starting the automated calibration
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_calibrationMax(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("calibrationMax", $rest_val);
    }

    /**
     * Returns the minimal value measured during the calibration (between 0 and 4095, included).
     *
     * @return int  an integer corresponding to the minimal value measured during the calibration (between
     * 0 and 4095, included)
     *
     * On failure, throws an exception or returns YAnButton::CALIBRATIONMIN_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_calibrationMin(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CALIBRATIONMIN_INVALID;
            }
        }
        $res = $this->_calibrationMin;
        return $res;
    }

    /**
     * Changes the minimal calibration value for the input (between 0 and 4095, included), without actually
     * starting the automated calibration.  Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param int $newval : an integer corresponding to the minimal calibration value for the input
     * (between 0 and 4095, included), without actually
     *         starting the automated calibration
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_calibrationMin(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("calibrationMin", $rest_val);
    }

    /**
     * Returns the sensibility for the input (between 1 and 1000) for triggering user callbacks.
     *
     * @return int  an integer corresponding to the sensibility for the input (between 1 and 1000) for
     * triggering user callbacks
     *
     * On failure, throws an exception or returns YAnButton::SENSITIVITY_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_sensitivity(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SENSITIVITY_INVALID;
            }
        }
        $res = $this->_sensitivity;
        return $res;
    }

    /**
     * Changes the sensibility for the input (between 1 and 1000) for triggering user callbacks.
     * The sensibility is used to filter variations around a fixed value, but does not preclude the
     * transmission of events when the input value evolves constantly in the same direction.
     * Special case: when the value 1000 is used, the callback will only be thrown when the logical state
     * of the input switches from pressed to released and back.
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @param int $newval : an integer corresponding to the sensibility for the input (between 1 and 1000)
     * for triggering user callbacks
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_sensitivity(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("sensitivity", $rest_val);
    }

    /**
     * Returns true if the input (considered as binary) is active (closed contact), and false otherwise.
     *
     * @return int  either YAnButton::ISPRESSED_FALSE or YAnButton::ISPRESSED_TRUE, according to true if the
     * input (considered as binary) is active (closed contact), and false otherwise
     *
     * On failure, throws an exception or returns YAnButton::ISPRESSED_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_isPressed(): int
    {
        // $res                    is a enumBOOL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::ISPRESSED_INVALID;
            }
        }
        $res = $this->_isPressed;
        return $res;
    }

    /**
     * Returns the number of elapsed milliseconds between the module power on and the last time
     * the input button was pressed (the input contact transitioned from open to closed).
     *
     * @return float  an integer corresponding to the number of elapsed milliseconds between the module
     * power on and the last time
     *         the input button was pressed (the input contact transitioned from open to closed)
     *
     * On failure, throws an exception or returns YAnButton::LASTTIMEPRESSED_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_lastTimePressed(): float
    {
        // $res                    is a long;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LASTTIMEPRESSED_INVALID;
            }
        }
        $res = $this->_lastTimePressed;
        return $res;
    }

    /**
     * Returns the number of elapsed milliseconds between the module power on and the last time
     * the input button was released (the input contact transitioned from closed to open).
     *
     * @return float  an integer corresponding to the number of elapsed milliseconds between the module
     * power on and the last time
     *         the input button was released (the input contact transitioned from closed to open)
     *
     * On failure, throws an exception or returns YAnButton::LASTTIMERELEASED_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_lastTimeReleased(): float
    {
        // $res                    is a long;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LASTTIMERELEASED_INVALID;
            }
        }
        $res = $this->_lastTimeReleased;
        return $res;
    }

    /**
     * Returns the pulse counter value. The value is a 32 bit integer. In case
     * of overflow (>=2^32), the counter will wrap. To reset the counter, just
     * call the resetCounter() method.
     *
     * @return float  an integer corresponding to the pulse counter value
     *
     * On failure, throws an exception or returns YAnButton::PULSECOUNTER_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_pulseCounter(): float
    {
        // $res                    is a long;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PULSECOUNTER_INVALID;
            }
        }
        $res = $this->_pulseCounter;
        return $res;
    }

    /**
     * @throws YAPI_Exception
     */
    public function set_pulseCounter(float $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("pulseCounter", $rest_val);
    }

    /**
     * Returns the timer of the pulses counter (ms).
     *
     * @return float  an integer corresponding to the timer of the pulses counter (ms)
     *
     * On failure, throws an exception or returns YAnButton::PULSETIMER_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_pulseTimer(): float
    {
        // $res                    is a long;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PULSETIMER_INVALID;
            }
        }
        $res = $this->_pulseTimer;
        return $res;
    }

    /**
     * Returns the decoding method applied to the input (analog or multiplexed binary switches).
     *
     * @return int  a value among YAnButton::INPUTTYPE_ANALOG_FAST, YAnButton::INPUTTYPE_DIGITAL4,
     * YAnButton::INPUTTYPE_ANALOG_SMOOTH and YAnButton::INPUTTYPE_DIGITAL_FAST corresponding to the
     * decoding method applied to the input (analog or multiplexed binary switches)
     *
     * On failure, throws an exception or returns YAnButton::INPUTTYPE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_inputType(): int
    {
        // $res                    is a enumINPUTTYPE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::INPUTTYPE_INVALID;
            }
        }
        $res = $this->_inputType;
        return $res;
    }

    /**
     * Changes the decoding method applied to the input (analog or multiplexed binary switches).
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @param int $newval : a value among YAnButton::INPUTTYPE_ANALOG_FAST, YAnButton::INPUTTYPE_DIGITAL4,
     * YAnButton::INPUTTYPE_ANALOG_SMOOTH and YAnButton::INPUTTYPE_DIGITAL_FAST corresponding to the
     * decoding method applied to the input (analog or multiplexed binary switches)
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_inputType(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("inputType", $rest_val);
    }

    /**
     * Retrieves an analog input for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the analog input is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the analog input is
     * indeed online at a given time. In case of ambiguity when looking for
     * an analog input by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the analog input, for instance
     *         YBUZZER2.anButton1.
     *
     * @return YAnButton  a YAnButton object allowing you to drive the analog input.
     */
    public static function FindAnButton(string $func): YAnButton
    {
        // $obj                    is a YAnButton;
        $obj = YFunction::_FindFromCache('AnButton', $func);
        if ($obj == null) {
            $obj = new YAnButton($func);
            YFunction::_AddToCache('AnButton', $func, $obj);
        }
        return $obj;
    }

    /**
     * Returns the pulse counter value as well as its timer.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function resetCounter(): int
    {
        return $this->set_pulseCounter(0);
    }

    /**
     * @throws YAPI_Exception
     */
    public function calibratedValue(): int
{
    return $this->get_calibratedValue();
}

    /**
     * @throws YAPI_Exception
     */
    public function rawValue(): int
{
    return $this->get_rawValue();
}

    /**
     * @throws YAPI_Exception
     */
    public function analogCalibration(): int
{
    return $this->get_analogCalibration();
}

    /**
     * @throws YAPI_Exception
     */
    public function setAnalogCalibration(int $newval): int
{
    return $this->set_analogCalibration($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function calibrationMax(): int
{
    return $this->get_calibrationMax();
}

    /**
     * @throws YAPI_Exception
     */
    public function setCalibrationMax(int $newval): int
{
    return $this->set_calibrationMax($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function calibrationMin(): int
{
    return $this->get_calibrationMin();
}

    /**
     * @throws YAPI_Exception
     */
    public function setCalibrationMin(int $newval): int
{
    return $this->set_calibrationMin($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function sensitivity(): int
{
    return $this->get_sensitivity();
}

    /**
     * @throws YAPI_Exception
     */
    public function setSensitivity(int $newval): int
{
    return $this->set_sensitivity($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function isPressed(): int
{
    return $this->get_isPressed();
}

    /**
     * @throws YAPI_Exception
     */
    public function lastTimePressed(): float
{
    return $this->get_lastTimePressed();
}

    /**
     * @throws YAPI_Exception
     */
    public function lastTimeReleased(): float
{
    return $this->get_lastTimeReleased();
}

    /**
     * @throws YAPI_Exception
     */
    public function pulseCounter(): float
{
    return $this->get_pulseCounter();
}

    /**
     * @throws YAPI_Exception
     */
    public function setPulseCounter(float $newval): int
{
    return $this->set_pulseCounter($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function pulseTimer(): float
{
    return $this->get_pulseTimer();
}

    /**
     * @throws YAPI_Exception
     */
    public function inputType(): int
{
    return $this->get_inputType();
}

    /**
     * @throws YAPI_Exception
     */
    public function setInputType(int $newval): int
{
    return $this->set_inputType($newval);
}

    /**
     * Continues the enumeration of analog inputs started using yFirstAnButton().
     * Caution: You can't make any assumption about the returned analog inputs order.
     * If you want to find a specific an analog input, use AnButton.findAnButton()
     * and a hardwareID or a logical name.
     *
     * @return ?YAnButton  a pointer to a YAnButton object, corresponding to
     *         an analog input currently online, or a null pointer
     *         if there are no more analog inputs to enumerate.
     */
    public function nextAnButton(): ?YAnButton
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindAnButton($next_hwid);
    }

    /**
     * Starts the enumeration of analog inputs currently accessible.
     * Use the method YAnButton::nextAnButton() to iterate on
     * next analog inputs.
     *
     * @return ?YAnButton  a pointer to a YAnButton object, corresponding to
     *         the first analog input currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstAnButton(): ?YAnButton
    {
        $next_hwid = YAPI::getFirstHardwareId('AnButton');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindAnButton($next_hwid);
    }

    //--- (end of YAnButton implementation)

}
