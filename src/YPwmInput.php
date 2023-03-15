<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YPwmInput Class: PWM input control interface, available for instance in the Yocto-PWM-Rx
 *
 * The YPwmInput class allows you to read and configure Yoctopuce PWM inputs.
 * It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, and to access the autonomous datalogger.
 * This class adds the ability to configure the signal parameter used to transmit
 * information: the duty cycle, the frequency or the pulse width.
 */
class YPwmInput extends YSensor
{
    const DUTYCYCLE_INVALID = YAPI::INVALID_DOUBLE;
    const PULSEDURATION_INVALID = YAPI::INVALID_DOUBLE;
    const FREQUENCY_INVALID = YAPI::INVALID_DOUBLE;
    const PERIOD_INVALID = YAPI::INVALID_DOUBLE;
    const PULSECOUNTER_INVALID = YAPI::INVALID_LONG;
    const PULSETIMER_INVALID = YAPI::INVALID_LONG;
    const PWMREPORTMODE_PWM_DUTYCYCLE = 0;
    const PWMREPORTMODE_PWM_FREQUENCY = 1;
    const PWMREPORTMODE_PWM_PULSEDURATION = 2;
    const PWMREPORTMODE_PWM_EDGECOUNT = 3;
    const PWMREPORTMODE_PWM_PULSECOUNT = 4;
    const PWMREPORTMODE_PWM_CPS = 5;
    const PWMREPORTMODE_PWM_CPM = 6;
    const PWMREPORTMODE_PWM_STATE = 7;
    const PWMREPORTMODE_PWM_FREQ_CPS = 8;
    const PWMREPORTMODE_PWM_FREQ_CPM = 9;
    const PWMREPORTMODE_PWM_PERIODCOUNT = 10;
    const PWMREPORTMODE_INVALID = -1;
    const DEBOUNCEPERIOD_INVALID = YAPI::INVALID_UINT;
    const BANDWIDTH_INVALID = YAPI::INVALID_UINT;
    const EDGESPERPERIOD_INVALID = YAPI::INVALID_UINT;
    //--- (end of YPwmInput declaration)

    //--- (YPwmInput attributes)
    protected float $_dutyCycle = self::DUTYCYCLE_INVALID;      // MeasureVal
    protected float $_pulseDuration = self::PULSEDURATION_INVALID;  // MeasureVal
    protected float $_frequency = self::FREQUENCY_INVALID;      // MeasureVal
    protected float $_period = self::PERIOD_INVALID;         // MeasureVal
    protected float $_pulseCounter = self::PULSECOUNTER_INVALID;   // UInt
    protected float $_pulseTimer = self::PULSETIMER_INVALID;     // Time
    protected int $_pwmReportMode = self::PWMREPORTMODE_INVALID;  // PwmReportModeType
    protected int $_debouncePeriod = self::DEBOUNCEPERIOD_INVALID; // UInt31
    protected int $_bandwidth = self::BANDWIDTH_INVALID;      // UInt31
    protected int $_edgesPerPeriod = self::EDGESPERPERIOD_INVALID; // UInt31

    //--- (end of YPwmInput attributes)

    function __construct(string $str_func)
    {
        //--- (YPwmInput constructor)
        parent::__construct($str_func);
        $this->_className = 'PwmInput';

        //--- (end of YPwmInput constructor)
    }

    //--- (YPwmInput implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'dutyCycle':
            $this->_dutyCycle = round($val / 65.536) / 1000.0;
            return 1;
        case 'pulseDuration':
            $this->_pulseDuration = round($val / 65.536) / 1000.0;
            return 1;
        case 'frequency':
            $this->_frequency = round($val / 65.536) / 1000.0;
            return 1;
        case 'period':
            $this->_period = round($val / 65.536) / 1000.0;
            return 1;
        case 'pulseCounter':
            $this->_pulseCounter = intval($val);
            return 1;
        case 'pulseTimer':
            $this->_pulseTimer = intval($val);
            return 1;
        case 'pwmReportMode':
            $this->_pwmReportMode = intval($val);
            return 1;
        case 'debouncePeriod':
            $this->_debouncePeriod = intval($val);
            return 1;
        case 'bandwidth':
            $this->_bandwidth = intval($val);
            return 1;
        case 'edgesPerPeriod':
            $this->_edgesPerPeriod = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Changes the measuring unit for the measured quantity. That unit
     * is just a string which is automatically initialized each time
     * the measurement mode is changed. But is can be set to an
     * arbitrary value.
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @param string $newval : a string corresponding to the measuring unit for the measured quantity
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
     * Returns the PWM duty cycle, in per cents.
     *
     * @return float  a floating point number corresponding to the PWM duty cycle, in per cents
     *
     * On failure, throws an exception or returns YPwmInput::DUTYCYCLE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_dutyCycle(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DUTYCYCLE_INVALID;
            }
        }
        $res = $this->_dutyCycle;
        return $res;
    }

    /**
     * Returns the PWM pulse length in milliseconds, as a floating point number.
     *
     * @return float  a floating point number corresponding to the PWM pulse length in milliseconds, as a
     * floating point number
     *
     * On failure, throws an exception or returns YPwmInput::PULSEDURATION_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_pulseDuration(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PULSEDURATION_INVALID;
            }
        }
        $res = $this->_pulseDuration;
        return $res;
    }

    /**
     * Returns the PWM frequency in Hz.
     *
     * @return float  a floating point number corresponding to the PWM frequency in Hz
     *
     * On failure, throws an exception or returns YPwmInput::FREQUENCY_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_frequency(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::FREQUENCY_INVALID;
            }
        }
        $res = $this->_frequency;
        return $res;
    }

    /**
     * Returns the PWM period in milliseconds.
     *
     * @return float  a floating point number corresponding to the PWM period in milliseconds
     *
     * On failure, throws an exception or returns YPwmInput::PERIOD_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_period(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PERIOD_INVALID;
            }
        }
        $res = $this->_period;
        return $res;
    }

    /**
     * Returns the pulse counter value. Actually that
     * counter is incremented twice per period. That counter is
     * limited  to 1 billion.
     *
     * @return float  an integer corresponding to the pulse counter value
     *
     * On failure, throws an exception or returns YPwmInput::PULSECOUNTER_INVALID.
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
     * On failure, throws an exception or returns YPwmInput::PULSETIMER_INVALID.
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
     * Returns the parameter (frequency/duty cycle, pulse width, edges count) returned by the
     * get_currentValue function and callbacks. Attention
     *
     * @return int  a value among YPwmInput::PWMREPORTMODE_PWM_DUTYCYCLE,
     * YPwmInput::PWMREPORTMODE_PWM_FREQUENCY, YPwmInput::PWMREPORTMODE_PWM_PULSEDURATION,
     * YPwmInput::PWMREPORTMODE_PWM_EDGECOUNT, YPwmInput::PWMREPORTMODE_PWM_PULSECOUNT,
     * YPwmInput::PWMREPORTMODE_PWM_CPS, YPwmInput::PWMREPORTMODE_PWM_CPM,
     * YPwmInput::PWMREPORTMODE_PWM_STATE, YPwmInput::PWMREPORTMODE_PWM_FREQ_CPS,
     * YPwmInput::PWMREPORTMODE_PWM_FREQ_CPM and YPwmInput::PWMREPORTMODE_PWM_PERIODCOUNT corresponding to
     * the parameter (frequency/duty cycle, pulse width, edges count) returned by the get_currentValue
     * function and callbacks
     *
     * On failure, throws an exception or returns YPwmInput::PWMREPORTMODE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_pwmReportMode(): int
    {
        // $res                    is a enumPWMREPORTMODETYPE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PWMREPORTMODE_INVALID;
            }
        }
        $res = $this->_pwmReportMode;
        return $res;
    }

    /**
     * Changes the  parameter  type (frequency/duty cycle, pulse width, or edge count) returned by the
     * get_currentValue function and callbacks.
     * The edge count value is limited to the 6 lowest digits. For values greater than one million, use
     * get_pulseCounter().
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @param int $newval : a value among YPwmInput::PWMREPORTMODE_PWM_DUTYCYCLE,
     * YPwmInput::PWMREPORTMODE_PWM_FREQUENCY, YPwmInput::PWMREPORTMODE_PWM_PULSEDURATION,
     * YPwmInput::PWMREPORTMODE_PWM_EDGECOUNT, YPwmInput::PWMREPORTMODE_PWM_PULSECOUNT,
     * YPwmInput::PWMREPORTMODE_PWM_CPS, YPwmInput::PWMREPORTMODE_PWM_CPM,
     * YPwmInput::PWMREPORTMODE_PWM_STATE, YPwmInput::PWMREPORTMODE_PWM_FREQ_CPS,
     * YPwmInput::PWMREPORTMODE_PWM_FREQ_CPM and YPwmInput::PWMREPORTMODE_PWM_PERIODCOUNT corresponding to
     * the  parameter  type (frequency/duty cycle, pulse width, or edge count) returned by the
     * get_currentValue function and callbacks
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_pwmReportMode(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("pwmReportMode", $rest_val);
    }

    /**
     * Returns the shortest expected pulse duration, in ms. Any shorter pulse will be automatically ignored (debounce).
     *
     * @return int  an integer corresponding to the shortest expected pulse duration, in ms
     *
     * On failure, throws an exception or returns YPwmInput::DEBOUNCEPERIOD_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_debouncePeriod(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DEBOUNCEPERIOD_INVALID;
            }
        }
        $res = $this->_debouncePeriod;
        return $res;
    }

    /**
     * Changes the shortest expected pulse duration, in ms. Any shorter pulse will be automatically ignored (debounce).
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @param int $newval : an integer corresponding to the shortest expected pulse duration, in ms
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_debouncePeriod(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("debouncePeriod", $rest_val);
    }

    /**
     * Returns the input signal sampling rate, in kHz.
     *
     * @return int  an integer corresponding to the input signal sampling rate, in kHz
     *
     * On failure, throws an exception or returns YPwmInput::BANDWIDTH_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_bandwidth(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::BANDWIDTH_INVALID;
            }
        }
        $res = $this->_bandwidth;
        return $res;
    }

    /**
     * Changes the input signal sampling rate, measured in kHz.
     * A lower sampling frequency can be used to hide hide-frequency bounce effects,
     * for instance on electromechanical contacts, but limits the measure resolution.
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param int $newval : an integer corresponding to the input signal sampling rate, measured in kHz
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_bandwidth(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("bandwidth", $rest_val);
    }

    /**
     * Returns the number of edges detected per preiod. For a clean PWM signal, this should be exactly two,
     * but in cas the signal is created by a mechanical contact with bounces, it can get higher.
     *
     * @return int  an integer corresponding to the number of edges detected per preiod
     *
     * On failure, throws an exception or returns YPwmInput::EDGESPERPERIOD_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_edgesPerPeriod(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::EDGESPERPERIOD_INVALID;
            }
        }
        $res = $this->_edgesPerPeriod;
        return $res;
    }

    /**
     * Retrieves a PWM input for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the PWM input is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the PWM input is
     * indeed online at a given time. In case of ambiguity when looking for
     * a PWM input by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the PWM input, for instance
     *         YPWMRX01.pwmInput1.
     *
     * @return YPwmInput  a YPwmInput object allowing you to drive the PWM input.
     */
    public static function FindPwmInput(string $func): YPwmInput
    {
        // $obj                    is a YPwmInput;
        $obj = YFunction::_FindFromCache('PwmInput', $func);
        if ($obj == null) {
            $obj = new YPwmInput($func);
            YFunction::_AddToCache('PwmInput', $func, $obj);
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
    public function setUnit(string $newval): int
{
    return $this->set_unit($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function dutyCycle(): float
{
    return $this->get_dutyCycle();
}

    /**
     * @throws YAPI_Exception
     */
    public function pulseDuration(): float
{
    return $this->get_pulseDuration();
}

    /**
     * @throws YAPI_Exception
     */
    public function frequency(): float
{
    return $this->get_frequency();
}

    /**
     * @throws YAPI_Exception
     */
    public function period(): float
{
    return $this->get_period();
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
    public function pwmReportMode(): int
{
    return $this->get_pwmReportMode();
}

    /**
     * @throws YAPI_Exception
     */
    public function setPwmReportMode(int $newval): int
{
    return $this->set_pwmReportMode($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function debouncePeriod(): int
{
    return $this->get_debouncePeriod();
}

    /**
     * @throws YAPI_Exception
     */
    public function setDebouncePeriod(int $newval): int
{
    return $this->set_debouncePeriod($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function bandwidth(): int
{
    return $this->get_bandwidth();
}

    /**
     * @throws YAPI_Exception
     */
    public function setBandwidth(int $newval): int
{
    return $this->set_bandwidth($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function edgesPerPeriod(): int
{
    return $this->get_edgesPerPeriod();
}

    /**
     * Continues the enumeration of PWM inputs started using yFirstPwmInput().
     * Caution: You can't make any assumption about the returned PWM inputs order.
     * If you want to find a specific a PWM input, use PwmInput.findPwmInput()
     * and a hardwareID or a logical name.
     *
     * @return ?YPwmInput  a pointer to a YPwmInput object, corresponding to
     *         a PWM input currently online, or a null pointer
     *         if there are no more PWM inputs to enumerate.
     */
    public function nextPwmInput(): ?YPwmInput
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindPwmInput($next_hwid);
    }

    /**
     * Starts the enumeration of PWM inputs currently accessible.
     * Use the method YPwmInput::nextPwmInput() to iterate on
     * next PWM inputs.
     *
     * @return ?YPwmInput  a pointer to a YPwmInput object, corresponding to
     *         the first PWM input currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstPwmInput(): ?YPwmInput
    {
        $next_hwid = YAPI::getFirstHardwareId('PwmInput');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindPwmInput($next_hwid);
    }

    //--- (end of YPwmInput implementation)

}
