<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YPwmOutput Class: PWM generator control interface, available for instance in the Yocto-PWM-Tx
 *
 * The YPwmOutput class allows you to drive a pulse-width modulated output (PWM).
 * You can configure the frequency as well as the duty cycle, and setup progressive
 * transitions.
 */
class YPwmOutput extends YFunction
{
    const ENABLED_FALSE = 0;
    const ENABLED_TRUE = 1;
    const ENABLED_INVALID = -1;
    const FREQUENCY_INVALID = YAPI::INVALID_DOUBLE;
    const PERIOD_INVALID = YAPI::INVALID_DOUBLE;
    const DUTYCYCLE_INVALID = YAPI::INVALID_DOUBLE;
    const PULSEDURATION_INVALID = YAPI::INVALID_DOUBLE;
    const PWMTRANSITION_INVALID = YAPI::INVALID_STRING;
    const INVERTEDOUTPUT_FALSE = 0;
    const INVERTEDOUTPUT_TRUE = 1;
    const INVERTEDOUTPUT_INVALID = -1;
    const ENABLEDATPOWERON_FALSE = 0;
    const ENABLEDATPOWERON_TRUE = 1;
    const ENABLEDATPOWERON_INVALID = -1;
    const DUTYCYCLEATPOWERON_INVALID = YAPI::INVALID_DOUBLE;
    //--- (end of YPwmOutput declaration)

    //--- (YPwmOutput attributes)
    protected int $_enabled = self::ENABLED_INVALID;        // Bool
    protected float $_frequency = self::FREQUENCY_INVALID;      // MeasureVal
    protected float $_period = self::PERIOD_INVALID;         // MeasureVal
    protected float $_dutyCycle = self::DUTYCYCLE_INVALID;      // MeasureVal
    protected float $_pulseDuration = self::PULSEDURATION_INVALID;  // MeasureVal
    protected string $_pwmTransition = self::PWMTRANSITION_INVALID;  // Text
    protected int $_invertedOutput = self::INVERTEDOUTPUT_INVALID; // Bool
    protected int $_enabledAtPowerOn = self::ENABLEDATPOWERON_INVALID; // Bool
    protected float $_dutyCycleAtPowerOn = self::DUTYCYCLEATPOWERON_INVALID; // MeasureVal

    //--- (end of YPwmOutput attributes)

    function __construct(string $str_func)
    {
        //--- (YPwmOutput constructor)
        parent::__construct($str_func);
        $this->_className = 'PwmOutput';

        //--- (end of YPwmOutput constructor)
    }

    //--- (YPwmOutput implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'enabled':
            $this->_enabled = intval($val);
            return 1;
        case 'frequency':
            $this->_frequency = round($val / 65.536) / 1000.0;
            return 1;
        case 'period':
            $this->_period = round($val / 65.536) / 1000.0;
            return 1;
        case 'dutyCycle':
            $this->_dutyCycle = round($val / 65.536) / 1000.0;
            return 1;
        case 'pulseDuration':
            $this->_pulseDuration = round($val / 65.536) / 1000.0;
            return 1;
        case 'pwmTransition':
            $this->_pwmTransition = $val;
            return 1;
        case 'invertedOutput':
            $this->_invertedOutput = intval($val);
            return 1;
        case 'enabledAtPowerOn':
            $this->_enabledAtPowerOn = intval($val);
            return 1;
        case 'dutyCycleAtPowerOn':
            $this->_dutyCycleAtPowerOn = round($val / 65.536) / 1000.0;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the state of the PWM generators.
     *
     * @return int  either YPwmOutput::ENABLED_FALSE or YPwmOutput::ENABLED_TRUE, according to the state of
     * the PWM generators
     *
     * On failure, throws an exception or returns YPwmOutput::ENABLED_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_enabled(): int
    {
        // $res                    is a enumBOOL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::ENABLED_INVALID;
            }
        }
        $res = $this->_enabled;
        return $res;
    }

    /**
     * Stops or starts the PWM.
     *
     * @param int $newval : either YPwmOutput::ENABLED_FALSE or YPwmOutput::ENABLED_TRUE
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_enabled(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("enabled", $rest_val);
    }

    /**
     * Changes the PWM frequency. The duty cycle is kept unchanged thanks to an
     * automatic pulse width change, in other words, the change will not be applied
     * before the end of the current period. This can significantly affect reaction
     * time at low frequencies. If you call the matching module saveToFlash()
     * method, the frequency will be kept after a device power cycle.
     * To stop the PWM signal, do not set the frequency to zero, use the set_enabled()
     * method instead.
     *
     * @param float $newval : a floating point number corresponding to the PWM frequency
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_frequency(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("frequency", $rest_val);
    }

    /**
     * Returns the PWM frequency in Hz.
     *
     * @return float  a floating point number corresponding to the PWM frequency in Hz
     *
     * On failure, throws an exception or returns YPwmOutput::FREQUENCY_INVALID.
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
     * Changes the PWM period in milliseconds. Caution: in order to avoid  random truncation of
     * the current pulse, the change will not be applied
     * before the end of the current period. This can significantly affect reaction
     * time at low frequencies. If you call the matching module saveToFlash()
     * method, the frequency will be kept after a device power cycle.
     *
     * @param float $newval : a floating point number corresponding to the PWM period in milliseconds
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_period(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("period", $rest_val);
    }

    /**
     * Returns the PWM period in milliseconds.
     *
     * @return float  a floating point number corresponding to the PWM period in milliseconds
     *
     * On failure, throws an exception or returns YPwmOutput::PERIOD_INVALID.
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
     * Changes the PWM duty cycle, in per cents.
     *
     * @param float $newval : a floating point number corresponding to the PWM duty cycle, in per cents
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_dutyCycle(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("dutyCycle", $rest_val);
    }

    /**
     * Returns the PWM duty cycle, in per cents.
     *
     * @return float  a floating point number corresponding to the PWM duty cycle, in per cents
     *
     * On failure, throws an exception or returns YPwmOutput::DUTYCYCLE_INVALID.
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
     * Changes the PWM pulse length, in milliseconds. A pulse length cannot be longer than period,
     * otherwise it is truncated.
     *
     * @param float $newval : a floating point number corresponding to the PWM pulse length, in milliseconds
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_pulseDuration(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("pulseDuration", $rest_val);
    }

    /**
     * Returns the PWM pulse length in milliseconds, as a floating point number.
     *
     * @return float  a floating point number corresponding to the PWM pulse length in milliseconds, as a
     * floating point number
     *
     * On failure, throws an exception or returns YPwmOutput::PULSEDURATION_INVALID.
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
     * @throws YAPI_Exception on error
     */
    public function get_pwmTransition(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PWMTRANSITION_INVALID;
            }
        }
        $res = $this->_pwmTransition;
        return $res;
    }

    /**
     * @throws YAPI_Exception
     */
    public function set_pwmTransition(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("pwmTransition", $rest_val);
    }

    /**
     * Returns true if the output signal is configured as inverted, and false otherwise.
     *
     * @return int  either YPwmOutput::INVERTEDOUTPUT_FALSE or YPwmOutput::INVERTEDOUTPUT_TRUE, according to
     * true if the output signal is configured as inverted, and false otherwise
     *
     * On failure, throws an exception or returns YPwmOutput::INVERTEDOUTPUT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_invertedOutput(): int
    {
        // $res                    is a enumBOOL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::INVERTEDOUTPUT_INVALID;
            }
        }
        $res = $this->_invertedOutput;
        return $res;
    }

    /**
     * Changes the inversion mode of the output signal.
     * Remember to call the matching module saveToFlash() method if you want
     * the change to be kept after power cycle.
     *
     * @param int $newval : either YPwmOutput::INVERTEDOUTPUT_FALSE or YPwmOutput::INVERTEDOUTPUT_TRUE,
     * according to the inversion mode of the output signal
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_invertedOutput(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("invertedOutput", $rest_val);
    }

    /**
     * Returns the state of the PWM at device power on.
     *
     * @return int  either YPwmOutput::ENABLEDATPOWERON_FALSE or YPwmOutput::ENABLEDATPOWERON_TRUE,
     * according to the state of the PWM at device power on
     *
     * On failure, throws an exception or returns YPwmOutput::ENABLEDATPOWERON_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_enabledAtPowerOn(): int
    {
        // $res                    is a enumBOOL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::ENABLEDATPOWERON_INVALID;
            }
        }
        $res = $this->_enabledAtPowerOn;
        return $res;
    }

    /**
     * Changes the state of the PWM at device power on. Remember to call the matching module saveToFlash()
     * method, otherwise this call will have no effect.
     *
     * @param int $newval : either YPwmOutput::ENABLEDATPOWERON_FALSE or YPwmOutput::ENABLEDATPOWERON_TRUE,
     * according to the state of the PWM at device power on
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_enabledAtPowerOn(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("enabledAtPowerOn", $rest_val);
    }

    /**
     * Changes the PWM duty cycle at device power on. Remember to call the matching
     * module saveToFlash() method, otherwise this call will have no effect.
     *
     * @param float $newval : a floating point number corresponding to the PWM duty cycle at device power on
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_dutyCycleAtPowerOn(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("dutyCycleAtPowerOn", $rest_val);
    }

    /**
     * Returns the PWM generators duty cycle at device power on as a floating point number between 0 and 100.
     *
     * @return float  a floating point number corresponding to the PWM generators duty cycle at device
     * power on as a floating point number between 0 and 100
     *
     * On failure, throws an exception or returns YPwmOutput::DUTYCYCLEATPOWERON_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_dutyCycleAtPowerOn(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DUTYCYCLEATPOWERON_INVALID;
            }
        }
        $res = $this->_dutyCycleAtPowerOn;
        return $res;
    }

    /**
     * Retrieves a PWM generator for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the PWM generator is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the PWM generator is
     * indeed online at a given time. In case of ambiguity when looking for
     * a PWM generator by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the PWM generator, for instance
     *         YPWMTX01.pwmOutput1.
     *
     * @return YPwmOutput  a YPwmOutput object allowing you to drive the PWM generator.
     */
    public static function FindPwmOutput(string $func): YPwmOutput
    {
        // $obj                    is a YPwmOutput;
        $obj = YFunction::_FindFromCache('PwmOutput', $func);
        if ($obj == null) {
            $obj = new YPwmOutput($func);
            YFunction::_AddToCache('PwmOutput', $func, $obj);
        }
        return $obj;
    }

    /**
     * Performs a smooth transition of the pulse duration toward a given value.
     * Any period, frequency, duty cycle or pulse width change will cancel any ongoing transition process.
     *
     * @param float $ms_target   : new pulse duration at the end of the transition
     *         (floating-point number, representing the pulse duration in milliseconds)
     * @param int $ms_duration : total duration of the transition, in milliseconds
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function pulseDurationMove(float $ms_target, int $ms_duration): int
    {
        // $newval                 is a str;
        if ($ms_target < 0.0) {
            $ms_target = 0.0;
        }
        $newval = sprintf('%dms:%d', round($ms_target*65536), $ms_duration);
        return $this->set_pwmTransition($newval);
    }

    /**
     * Performs a smooth change of the duty cycle toward a given value.
     * Any period, frequency, duty cycle or pulse width change will cancel any ongoing transition process.
     *
     * @param float $target      : new duty cycle at the end of the transition
     *         (percentage, floating-point number between 0 and 100)
     * @param int $ms_duration : total duration of the transition, in milliseconds
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function dutyCycleMove(float $target, int $ms_duration): int
    {
        // $newval                 is a str;
        if ($target < 0.0) {
            $target = 0.0;
        }
        if ($target > 100.0) {
            $target = 100.0;
        }
        $newval = sprintf('%d:%d', round($target*65536), $ms_duration);
        return $this->set_pwmTransition($newval);
    }

    /**
     * Performs a smooth frequency change toward a given value.
     * Any period, frequency, duty cycle or pulse width change will cancel any ongoing transition process.
     *
     * @param float $target      : new frequency at the end of the transition (floating-point number)
     * @param int $ms_duration : total duration of the transition, in milliseconds
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function frequencyMove(float $target, int $ms_duration): int
    {
        // $newval                 is a str;
        if ($target < 0.001) {
            $target = 0.001;
        }
        $newval = sprintf('%FHz:%d', $target, $ms_duration);
        return $this->set_pwmTransition($newval);
    }

    /**
     * Performs a smooth transition toward a specified value of the phase shift between this channel
     * and the other channel. The phase shift is executed by slightly changing the frequency
     * temporarily during the specified duration. This function only makes sense when both channels
     * are running, either at the same frequency, or at a multiple of the channel frequency.
     * Any period, frequency, duty cycle or pulse width change will cancel any ongoing transition process.
     *
     * @param float $target      : phase shift at the end of the transition, in milliseconds (floating-point number)
     * @param int $ms_duration : total duration of the transition, in milliseconds
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function phaseMove(float $target, int $ms_duration): int
    {
        // $newval                 is a str;
        $newval = sprintf('%Fps:%d', $target, $ms_duration);
        return $this->set_pwmTransition($newval);
    }

    /**
     * Trigger a given number of pulses of specified duration, at current frequency.
     * At the end of the pulse train, revert to the original state of the PWM generator.
     *
     * @param float $ms_target : desired pulse duration
     *         (floating-point number, representing the pulse duration in milliseconds)
     * @param int $n_pulses  : desired pulse count
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function triggerPulsesByDuration(float $ms_target, int $n_pulses): int
    {
        // $newval                 is a str;
        if ($ms_target < 0.0) {
            $ms_target = 0.0;
        }
        $newval = sprintf('%dms*%d', round($ms_target*65536), $n_pulses);
        return $this->set_pwmTransition($newval);
    }

    /**
     * Trigger a given number of pulses of specified duration, at current frequency.
     * At the end of the pulse train, revert to the original state of the PWM generator.
     *
     * @param float $target   : desired duty cycle for the generated pulses
     *         (percentage, floating-point number between 0 and 100)
     * @param int $n_pulses : desired pulse count
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function triggerPulsesByDutyCycle(float $target, int $n_pulses): int
    {
        // $newval                 is a str;
        if ($target < 0.0) {
            $target = 0.0;
        }
        if ($target > 100.0) {
            $target = 100.0;
        }
        $newval = sprintf('%d*%d', round($target*65536), $n_pulses);
        return $this->set_pwmTransition($newval);
    }

    /**
     * Trigger a given number of pulses at the specified frequency, using current duty cycle.
     * At the end of the pulse train, revert to the original state of the PWM generator.
     *
     * @param float $target   : desired frequency for the generated pulses (floating-point number)
     * @param int $n_pulses : desired pulse count
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function triggerPulsesByFrequency(float $target, int $n_pulses): int
    {
        // $newval                 is a str;
        if ($target < 0.001) {
            $target = 0.001;
        }
        $newval = sprintf('%FHz*%d', $target, $n_pulses);
        return $this->set_pwmTransition($newval);
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function markForRepeat(): int
    {
        return $this->set_pwmTransition(':');
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function repeatFromMark(): int
    {
        return $this->set_pwmTransition('R');
    }

    /**
     * @throws YAPI_Exception
     */
    public function enabled(): int
{
    return $this->get_enabled();
}

    /**
     * @throws YAPI_Exception
     */
    public function setEnabled(int $newval): int
{
    return $this->set_enabled($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function setFrequency(float $newval): int
{
    return $this->set_frequency($newval);
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
    public function setPeriod(float $newval): int
{
    return $this->set_period($newval);
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
    public function setDutyCycle(float $newval): int
{
    return $this->set_dutyCycle($newval);
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
    public function setPulseDuration(float $newval): int
{
    return $this->set_pulseDuration($newval);
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
    public function pwmTransition(): string
{
    return $this->get_pwmTransition();
}

    /**
     * @throws YAPI_Exception
     */
    public function setPwmTransition(string $newval): int
{
    return $this->set_pwmTransition($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function invertedOutput(): int
{
    return $this->get_invertedOutput();
}

    /**
     * @throws YAPI_Exception
     */
    public function setInvertedOutput(int $newval): int
{
    return $this->set_invertedOutput($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function enabledAtPowerOn(): int
{
    return $this->get_enabledAtPowerOn();
}

    /**
     * @throws YAPI_Exception
     */
    public function setEnabledAtPowerOn(int $newval): int
{
    return $this->set_enabledAtPowerOn($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function setDutyCycleAtPowerOn(float $newval): int
{
    return $this->set_dutyCycleAtPowerOn($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function dutyCycleAtPowerOn(): float
{
    return $this->get_dutyCycleAtPowerOn();
}

    /**
     * Continues the enumeration of PWM generators started using yFirstPwmOutput().
     * Caution: You can't make any assumption about the returned PWM generators order.
     * If you want to find a specific a PWM generator, use PwmOutput.findPwmOutput()
     * and a hardwareID or a logical name.
     *
     * @return ?YPwmOutput  a pointer to a YPwmOutput object, corresponding to
     *         a PWM generator currently online, or a null pointer
     *         if there are no more PWM generators to enumerate.
     */
    public function nextPwmOutput(): ?YPwmOutput
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindPwmOutput($next_hwid);
    }

    /**
     * Starts the enumeration of PWM generators currently accessible.
     * Use the method YPwmOutput::nextPwmOutput() to iterate on
     * next PWM generators.
     *
     * @return ?YPwmOutput  a pointer to a YPwmOutput object, corresponding to
     *         the first PWM generator currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstPwmOutput(): ?YPwmOutput
    {
        $next_hwid = YAPI::getFirstHardwareId('PwmOutput');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindPwmOutput($next_hwid);
    }

    //--- (end of YPwmOutput implementation)

}
