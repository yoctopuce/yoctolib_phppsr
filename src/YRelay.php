<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YRelay Class: relay control interface, available for instance in the Yocto-LatchedRelay, the
 * Yocto-MaxiPowerRelay, the Yocto-PowerRelay-V3 or the Yocto-Relay
 *
 * The YRelay class allows you to drive a Yoctopuce relay or optocoupled output.
 * It can be used to simply switch the output on or off, but also to automatically generate short
 * pulses of determined duration.
 * On devices with two output for each relay (double throw), the two outputs are named A and B,
 * with output A corresponding to the idle position (normally closed) and the output B corresponding to the
 * active state (normally open).
 */
class YRelay extends YFunction
{
    const STATE_A = 0;
    const STATE_B = 1;
    const STATE_INVALID = -1;
    const STATEATPOWERON_UNCHANGED = 0;
    const STATEATPOWERON_A = 1;
    const STATEATPOWERON_B = 2;
    const STATEATPOWERON_INVALID = -1;
    const MAXTIMEONSTATEA_INVALID = YAPI::INVALID_LONG;
    const MAXTIMEONSTATEB_INVALID = YAPI::INVALID_LONG;
    const OUTPUT_OFF = 0;
    const OUTPUT_ON = 1;
    const OUTPUT_INVALID = -1;
    const PULSETIMER_INVALID = YAPI::INVALID_LONG;
    const DELAYEDPULSETIMER_INVALID = null;
    const COUNTDOWN_INVALID = YAPI::INVALID_LONG;
    //--- (end of YRelay declaration)

    //--- (YRelay attributes)
    protected int $_state = self::STATE_INVALID;          // Toggle
    protected int $_stateAtPowerOn = self::STATEATPOWERON_INVALID; // ToggleAtPowerOn
    protected float $_maxTimeOnStateA = self::MAXTIMEONSTATEA_INVALID; // Time
    protected float $_maxTimeOnStateB = self::MAXTIMEONSTATEB_INVALID; // Time
    protected int $_output = self::OUTPUT_INVALID;         // OnOff
    protected float $_pulseTimer = self::PULSETIMER_INVALID;     // Time
    protected mixed $_delayedPulseTimer = self::DELAYEDPULSETIMER_INVALID; // DelayedPulse
    protected float $_countdown = self::COUNTDOWN_INVALID;      // Time
    protected int $_firm = 0;                            // int

    //--- (end of YRelay attributes)

    function __construct($str_func)
    {
        //--- (YRelay constructor)
        parent::__construct($str_func);
        $this->_className = 'Relay';

        //--- (end of YRelay constructor)
    }

    //--- (YRelay implementation)

    function _parseAttr($name, $val): int
    {
        switch ($name) {
        case 'state':
            $this->_state = intval($val);
            return 1;
        case 'stateAtPowerOn':
            $this->_stateAtPowerOn = intval($val);
            return 1;
        case 'maxTimeOnStateA':
            $this->_maxTimeOnStateA = intval($val);
            return 1;
        case 'maxTimeOnStateB':
            $this->_maxTimeOnStateB = intval($val);
            return 1;
        case 'output':
            $this->_output = intval($val);
            return 1;
        case 'pulseTimer':
            $this->_pulseTimer = intval($val);
            return 1;
        case 'delayedPulseTimer':
            $this->_delayedPulseTimer = $val;
            return 1;
        case 'countdown':
            $this->_countdown = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the state of the relays (A for the idle position, B for the active position).
     *
     * @return int  either YRelay::STATE_A or YRelay::STATE_B, according to the state of the relays (A for
     * the idle position, B for the active position)
     *
     * On failure, throws an exception or returns YRelay::STATE_INVALID.
     */
    public function get_state(): int
    {
        // $res                    is a enumTOGGLE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::STATE_INVALID;
            }
        }
        $res = $this->_state;
        return $res;
    }

    /**
     * Changes the state of the relays (A for the idle position, B for the active position).
     *
     * @param int $newval : either YRelay::STATE_A or YRelay::STATE_B, according to the state of the relays
     * (A for the idle position, B for the active position)
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_state(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("state", $rest_val);
    }

    /**
     * Returns the state of the relays at device startup (A for the idle position,
     * B for the active position, UNCHANGED to leave the relay state as is).
     *
     * @return int  a value among YRelay::STATEATPOWERON_UNCHANGED, YRelay::STATEATPOWERON_A and
     * YRelay::STATEATPOWERON_B corresponding to the state of the relays at device startup (A for the idle position,
     *         B for the active position, UNCHANGED to leave the relay state as is)
     *
     * On failure, throws an exception or returns YRelay::STATEATPOWERON_INVALID.
     */
    public function get_stateAtPowerOn(): int
    {
        // $res                    is a enumTOGGLEATPOWERON;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::STATEATPOWERON_INVALID;
            }
        }
        $res = $this->_stateAtPowerOn;
        return $res;
    }

    /**
     * Changes the state of the relays at device startup (A for the idle position,
     * B for the active position, UNCHANGED to leave the relay state as is).
     * Remember to call the matching module saveToFlash()
     * method, otherwise this call will have no effect.
     *
     * @param int $newval : a value among YRelay::STATEATPOWERON_UNCHANGED, YRelay::STATEATPOWERON_A and
     * YRelay::STATEATPOWERON_B corresponding to the state of the relays at device startup (A for the idle position,
     *         B for the active position, UNCHANGED to leave the relay state as is)
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_stateAtPowerOn(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("stateAtPowerOn", $rest_val);
    }

    /**
     * Returns the maximum time (ms) allowed for the relay to stay in state
     * A before automatically switching back in to B state. Zero means no time limit.
     *
     * @return float  an integer corresponding to the maximum time (ms) allowed for the relay to stay in state
     *         A before automatically switching back in to B state
     *
     * On failure, throws an exception or returns YRelay::MAXTIMEONSTATEA_INVALID.
     */
    public function get_maxTimeOnStateA(): float
    {
        // $res                    is a long;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::MAXTIMEONSTATEA_INVALID;
            }
        }
        $res = $this->_maxTimeOnStateA;
        return $res;
    }

    /**
     * Changes the maximum time (ms) allowed for the relay to stay in state A
     * before automatically switching back in to B state. Use zero for no time limit.
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param float $newval : an integer corresponding to the maximum time (ms) allowed for the relay to
     * stay in state A
     *         before automatically switching back in to B state
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_maxTimeOnStateA(float $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("maxTimeOnStateA", $rest_val);
    }

    /**
     * Retourne the maximum time (ms) allowed for the relay to stay in state B
     * before automatically switching back in to A state. Zero means no time limit.
     *
     * @return float  an integer
     *
     * On failure, throws an exception or returns YRelay::MAXTIMEONSTATEB_INVALID.
     */
    public function get_maxTimeOnStateB(): float
    {
        // $res                    is a long;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::MAXTIMEONSTATEB_INVALID;
            }
        }
        $res = $this->_maxTimeOnStateB;
        return $res;
    }

    /**
     * Changes the maximum time (ms) allowed for the relay to stay in state B before
     * automatically switching back in to A state. Use zero for no time limit.
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param float $newval : an integer corresponding to the maximum time (ms) allowed for the relay to
     * stay in state B before
     *         automatically switching back in to A state
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_maxTimeOnStateB(float $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("maxTimeOnStateB", $rest_val);
    }

    /**
     * Returns the output state of the relays, when used as a simple switch (single throw).
     *
     * @return int  either YRelay::OUTPUT_OFF or YRelay::OUTPUT_ON, according to the output state of the
     * relays, when used as a simple switch (single throw)
     *
     * On failure, throws an exception or returns YRelay::OUTPUT_INVALID.
     */
    public function get_output(): int
    {
        // $res                    is a enumONOFF;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::OUTPUT_INVALID;
            }
        }
        $res = $this->_output;
        return $res;
    }

    /**
     * Changes the output state of the relays, when used as a simple switch (single throw).
     *
     * @param int $newval : either YRelay::OUTPUT_OFF or YRelay::OUTPUT_ON, according to the output state of
     * the relays, when used as a simple switch (single throw)
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_output(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("output", $rest_val);
    }

    /**
     * Returns the number of milliseconds remaining before the relays is returned to idle position
     * (state A), during a measured pulse generation. When there is no ongoing pulse, returns zero.
     *
     * @return float  an integer corresponding to the number of milliseconds remaining before the relays
     * is returned to idle position
     *         (state A), during a measured pulse generation
     *
     * On failure, throws an exception or returns YRelay::PULSETIMER_INVALID.
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

    public function set_pulseTimer(float $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("pulseTimer", $rest_val);
    }

    /**
     * Sets the relay to output B (active) for a specified duration, then brings it
     * automatically back to output A (idle state).
     *
     * @param int $ms_duration : pulse duration, in milliseconds
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function pulse(int $ms_duration): int
    {
        $rest_val = strval($ms_duration);
        return $this->_setAttr("pulseTimer",$rest_val);
    }

    public function get_delayedPulseTimer(): mixed
    {
        // $res                    is a YDelayedPulse;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DELAYEDPULSETIMER_INVALID;
            }
        }
        $res = $this->_delayedPulseTimer;
        return $res;
    }

    public function set_delayedPulseTimer(mixed $newval): int
    {
        $rest_val = $newval["target"].':'.$newval["ms"];
        return $this->_setAttr("delayedPulseTimer", $rest_val);
    }

    /**
     * Schedules a pulse.
     *
     * @param int $ms_delay : waiting time before the pulse, in milliseconds
     * @param int $ms_duration : pulse duration, in milliseconds
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function delayedPulse(int $ms_delay,int $ms_duration): int
    {
        $rest_val = $ms_delay.':'.$ms_duration;
        return $this->_setAttr("delayedPulseTimer",$rest_val);
    }

    /**
     * Returns the number of milliseconds remaining before a pulse (delayedPulse() call)
     * When there is no scheduled pulse, returns zero.
     *
     * @return float  an integer corresponding to the number of milliseconds remaining before a pulse
     * (delayedPulse() call)
     *         When there is no scheduled pulse, returns zero
     *
     * On failure, throws an exception or returns YRelay::COUNTDOWN_INVALID.
     */
    public function get_countdown(): float
    {
        // $res                    is a long;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::COUNTDOWN_INVALID;
            }
        }
        $res = $this->_countdown;
        return $res;
    }

    /**
     * Retrieves a relay for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the relay is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the relay is
     * indeed online at a given time. In case of ambiguity when looking for
     * a relay by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the relay, for instance
     *         YLTCHRL1.relay1.
     *
     * @return YRelay  a YRelay object allowing you to drive the relay.
     */
    public static function FindRelay(string $func): ?YRelay
    {
        // $obj                    is a YRelay;
        $obj = YFunction::_FindFromCache('Relay', $func);
        if ($obj == null) {
            $obj = new YRelay($func);
            YFunction::_AddToCache('Relay', $func, $obj);
        }
        return $obj;
    }

    /**
     * Switch the relay to the opposite state.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function toggle(): int
    {
        // $sta                    is a int;
        // $fw                     is a str;
        // $mo                     is a YModule;
        if ($this->_firm == 0) {
            $mo = $this->get_module();
            $fw = $mo->get_firmwareRelease();
            if ($fw == YModule::FIRMWARERELEASE_INVALID) {
                return self::STATE_INVALID;
            }
            $this->_firm = intVal($fw);
        }
        if ($this->_firm < 34921) {
            $sta = $this->get_state();
            if ($sta == self::STATE_INVALID) {
                return self::STATE_INVALID;
            }
            if ($sta == self::STATE_B) {
                $this->set_state(self::STATE_A);
            } else {
                $this->set_state(self::STATE_B);
            }
            return YAPI::SUCCESS;
        } else {
            return $this->_setAttr('state','X');
        }
    }

    public function state(): int
{
    return $this->get_state();
}

    public function setState(int $newval)
{
    return $this->set_state($newval);
}

    public function stateAtPowerOn(): int
{
    return $this->get_stateAtPowerOn();
}

    public function setStateAtPowerOn(int $newval)
{
    return $this->set_stateAtPowerOn($newval);
}

    public function maxTimeOnStateA(): float
{
    return $this->get_maxTimeOnStateA();
}

    public function setMaxTimeOnStateA(float $newval)
{
    return $this->set_maxTimeOnStateA($newval);
}

    public function maxTimeOnStateB(): float
{
    return $this->get_maxTimeOnStateB();
}

    public function setMaxTimeOnStateB(float $newval)
{
    return $this->set_maxTimeOnStateB($newval);
}

    public function output(): int
{
    return $this->get_output();
}

    public function setOutput(int $newval)
{
    return $this->set_output($newval);
}

    public function pulseTimer(): float
{
    return $this->get_pulseTimer();
}

    public function setPulseTimer(float $newval)
{
    return $this->set_pulseTimer($newval);
}

    public function delayedPulseTimer(): mixed
{
    return $this->get_delayedPulseTimer();
}

    public function setDelayedPulseTimer(mixed $newval)
{
    return $this->set_delayedPulseTimer($newval);
}

    public function countdown(): float
{
    return $this->get_countdown();
}

    /**
     * Continues the enumeration of relays started using yFirstRelay().
     * Caution: You can't make any assumption about the returned relays order.
     * If you want to find a specific a relay, use Relay.findRelay()
     * and a hardwareID or a logical name.
     *
     * @return YRelay  a pointer to a YRelay object, corresponding to
     *         a relay currently online, or a null pointer
     *         if there are no more relays to enumerate.
     */
    public function nextRelay(): ?YRelay
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindRelay($next_hwid);
    }

    /**
     * Starts the enumeration of relays currently accessible.
     * Use the method YRelay::nextRelay() to iterate on
     * next relays.
     *
     * @return YRelay  a pointer to a YRelay object, corresponding to
     *         the first relay currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstRelay()
    {
        $next_hwid = YAPI::getFirstHardwareId('Relay');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindRelay($next_hwid);
    }

    //--- (end of YRelay implementation)

}
