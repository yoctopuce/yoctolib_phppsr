<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YWatchdog Class: watchdog control interface, available for instance in the Yocto-WatchdogDC
 *
 * The YWatchdog class allows you to drive a Yoctopuce watchdog.
 * A watchdog works like a relay, with an extra timer that can automatically
 * trigger a brief power cycle to an appliance after a preset delay, to force this
 * appliance to reset if a problem occurs. During normal use, the watchdog timer
 * is reset periodically by the application to prevent the automated power cycle.
 * Whenever the application dies, the watchdog will automatically trigger the power cycle.
 * The watchdog can also be driven directly with pulse and delayedPulse
 * methods to switch off an appliance for a given duration.
 */
class YWatchdog extends YFunction
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
    const AUTOSTART_OFF = 0;
    const AUTOSTART_ON = 1;
    const AUTOSTART_INVALID = -1;
    const RUNNING_OFF = 0;
    const RUNNING_ON = 1;
    const RUNNING_INVALID = -1;
    const TRIGGERDELAY_INVALID = YAPI::INVALID_LONG;
    const TRIGGERDURATION_INVALID = YAPI::INVALID_LONG;
    const LASTTRIGGER_INVALID = YAPI::INVALID_UINT;
    //--- (end of YWatchdog declaration)

    //--- (YWatchdog attributes)
    protected int $_state = self::STATE_INVALID;          // Toggle
    protected int $_stateAtPowerOn = self::STATEATPOWERON_INVALID; // ToggleAtPowerOn
    protected float $_maxTimeOnStateA = self::MAXTIMEONSTATEA_INVALID; // Time
    protected float $_maxTimeOnStateB = self::MAXTIMEONSTATEB_INVALID; // Time
    protected int $_output = self::OUTPUT_INVALID;         // OnOff
    protected float $_pulseTimer = self::PULSETIMER_INVALID;     // Time
    protected  $_delayedPulseTimer = self::DELAYEDPULSETIMER_INVALID; // DelayedPulse
    protected float $_countdown = self::COUNTDOWN_INVALID;      // Time
    protected int $_autoStart = self::AUTOSTART_INVALID;      // OnOff
    protected int $_running = self::RUNNING_INVALID;        // OnOff
    protected float $_triggerDelay = self::TRIGGERDELAY_INVALID;   // Time
    protected float $_triggerDuration = self::TRIGGERDURATION_INVALID; // Time
    protected int $_lastTrigger = self::LASTTRIGGER_INVALID;    // UInt31
    protected int $_firm = 0;                            // int

    //--- (end of YWatchdog attributes)

    function __construct($str_func)
    {
        //--- (YWatchdog constructor)
        parent::__construct($str_func);
        $this->_className = 'Watchdog';

        //--- (end of YWatchdog constructor)
    }

    //--- (YWatchdog implementation)

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
        case 'autoStart':
            $this->_autoStart = intval($val);
            return 1;
        case 'running':
            $this->_running = intval($val);
            return 1;
        case 'triggerDelay':
            $this->_triggerDelay = intval($val);
            return 1;
        case 'triggerDuration':
            $this->_triggerDuration = intval($val);
            return 1;
        case 'lastTrigger':
            $this->_lastTrigger = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the state of the watchdog (A for the idle position, B for the active position).
     *
     * @return int  either YWatchdog::STATE_A or YWatchdog::STATE_B, according to the state of the watchdog
     * (A for the idle position, B for the active position)
     *
     * On failure, throws an exception or returns YWatchdog::STATE_INVALID.
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
     * Changes the state of the watchdog (A for the idle position, B for the active position).
     *
     * @param int $newval : either YWatchdog::STATE_A or YWatchdog::STATE_B, according to the state of the
     * watchdog (A for the idle position, B for the active position)
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
     * Returns the state of the watchdog at device startup (A for the idle position,
     * B for the active position, UNCHANGED to leave the relay state as is).
     *
     * @return int  a value among YWatchdog::STATEATPOWERON_UNCHANGED, YWatchdog::STATEATPOWERON_A and
     * YWatchdog::STATEATPOWERON_B corresponding to the state of the watchdog at device startup (A for the
     * idle position,
     *         B for the active position, UNCHANGED to leave the relay state as is)
     *
     * On failure, throws an exception or returns YWatchdog::STATEATPOWERON_INVALID.
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
     * Changes the state of the watchdog at device startup (A for the idle position,
     * B for the active position, UNCHANGED to leave the relay state as is).
     * Remember to call the matching module saveToFlash()
     * method, otherwise this call will have no effect.
     *
     * @param int $newval : a value among YWatchdog::STATEATPOWERON_UNCHANGED, YWatchdog::STATEATPOWERON_A
     * and YWatchdog::STATEATPOWERON_B corresponding to the state of the watchdog at device startup (A for
     * the idle position,
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
     * Returns the maximum time (ms) allowed for the watchdog to stay in state
     * A before automatically switching back in to B state. Zero means no time limit.
     *
     * @return float  an integer corresponding to the maximum time (ms) allowed for the watchdog to stay in state
     *         A before automatically switching back in to B state
     *
     * On failure, throws an exception or returns YWatchdog::MAXTIMEONSTATEA_INVALID.
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
     * Changes the maximum time (ms) allowed for the watchdog to stay in state A
     * before automatically switching back in to B state. Use zero for no time limit.
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param float $newval : an integer corresponding to the maximum time (ms) allowed for the watchdog
     * to stay in state A
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
     * Retourne the maximum time (ms) allowed for the watchdog to stay in state B
     * before automatically switching back in to A state. Zero means no time limit.
     *
     * @return float  an integer
     *
     * On failure, throws an exception or returns YWatchdog::MAXTIMEONSTATEB_INVALID.
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
     * Changes the maximum time (ms) allowed for the watchdog to stay in state B before
     * automatically switching back in to A state. Use zero for no time limit.
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param float $newval : an integer corresponding to the maximum time (ms) allowed for the watchdog
     * to stay in state B before
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
     * Returns the output state of the watchdog, when used as a simple switch (single throw).
     *
     * @return int  either YWatchdog::OUTPUT_OFF or YWatchdog::OUTPUT_ON, according to the output state of
     * the watchdog, when used as a simple switch (single throw)
     *
     * On failure, throws an exception or returns YWatchdog::OUTPUT_INVALID.
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
     * Changes the output state of the watchdog, when used as a simple switch (single throw).
     *
     * @param int $newval : either YWatchdog::OUTPUT_OFF or YWatchdog::OUTPUT_ON, according to the output
     * state of the watchdog, when used as a simple switch (single throw)
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
     * Returns the number of milliseconds remaining before the watchdog is returned to idle position
     * (state A), during a measured pulse generation. When there is no ongoing pulse, returns zero.
     *
     * @return float  an integer corresponding to the number of milliseconds remaining before the watchdog
     * is returned to idle position
     *         (state A), during a measured pulse generation
     *
     * On failure, throws an exception or returns YWatchdog::PULSETIMER_INVALID.
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
    public function pulse(int $ms_duration)
    {
        $rest_val = strval($ms_duration);
        return $this->_setAttr("pulseTimer",$rest_val);
    }

    public function get_delayedPulseTimer(): ?YDelayedPulse
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

    public function set_delayedPulseTimer(YDelayedPulse $newval): int
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
    public function delayedPulse(int $ms_delay,int $ms_duration)
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
     * On failure, throws an exception or returns YWatchdog::COUNTDOWN_INVALID.
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
     * Returns the watchdog running state at module power on.
     *
     * @return int  either YWatchdog::AUTOSTART_OFF or YWatchdog::AUTOSTART_ON, according to the watchdog
     * running state at module power on
     *
     * On failure, throws an exception or returns YWatchdog::AUTOSTART_INVALID.
     */
    public function get_autoStart(): int
    {
        // $res                    is a enumONOFF;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::AUTOSTART_INVALID;
            }
        }
        $res = $this->_autoStart;
        return $res;
    }

    /**
     * Changes the watchdog running state at module power on. Remember to call the
     * saveToFlash() method and then to reboot the module to apply this setting.
     *
     * @param int $newval : either YWatchdog::AUTOSTART_OFF or YWatchdog::AUTOSTART_ON, according to the
     * watchdog running state at module power on
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_autoStart(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("autoStart", $rest_val);
    }

    /**
     * Returns the watchdog running state.
     *
     * @return int  either YWatchdog::RUNNING_OFF or YWatchdog::RUNNING_ON, according to the watchdog running state
     *
     * On failure, throws an exception or returns YWatchdog::RUNNING_INVALID.
     */
    public function get_running(): int
    {
        // $res                    is a enumONOFF;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::RUNNING_INVALID;
            }
        }
        $res = $this->_running;
        return $res;
    }

    /**
     * Changes the running state of the watchdog.
     *
     * @param int $newval : either YWatchdog::RUNNING_OFF or YWatchdog::RUNNING_ON, according to the running
     * state of the watchdog
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_running(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("running", $rest_val);
    }

    /**
     * Resets the watchdog. When the watchdog is running, this function
     * must be called on a regular basis to prevent the watchdog to
     * trigger
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function resetWatchdog()
    {
        $rest_val = '1';
        return $this->_setAttr("running",$rest_val);
    }

    /**
     * Returns  the waiting duration before a reset is automatically triggered by the watchdog, in milliseconds.
     *
     * @return float  an integer corresponding to  the waiting duration before a reset is automatically
     * triggered by the watchdog, in milliseconds
     *
     * On failure, throws an exception or returns YWatchdog::TRIGGERDELAY_INVALID.
     */
    public function get_triggerDelay(): float
    {
        // $res                    is a long;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::TRIGGERDELAY_INVALID;
            }
        }
        $res = $this->_triggerDelay;
        return $res;
    }

    /**
     * Changes the waiting delay before a reset is triggered by the watchdog,
     * in milliseconds. Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param float $newval : an integer corresponding to the waiting delay before a reset is triggered by
     * the watchdog,
     *         in milliseconds
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_triggerDelay(float $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("triggerDelay", $rest_val);
    }

    /**
     * Returns the duration of resets caused by the watchdog, in milliseconds.
     *
     * @return float  an integer corresponding to the duration of resets caused by the watchdog, in milliseconds
     *
     * On failure, throws an exception or returns YWatchdog::TRIGGERDURATION_INVALID.
     */
    public function get_triggerDuration(): float
    {
        // $res                    is a long;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::TRIGGERDURATION_INVALID;
            }
        }
        $res = $this->_triggerDuration;
        return $res;
    }

    /**
     * Changes the duration of resets caused by the watchdog, in milliseconds.
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param float $newval : an integer corresponding to the duration of resets caused by the watchdog,
     * in milliseconds
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_triggerDuration(float $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("triggerDuration", $rest_val);
    }

    /**
     * Returns the number of seconds spent since the last output power-up event.
     *
     * @return int  an integer corresponding to the number of seconds spent since the last output power-up event
     *
     * On failure, throws an exception or returns YWatchdog::LASTTRIGGER_INVALID.
     */
    public function get_lastTrigger(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LASTTRIGGER_INVALID;
            }
        }
        $res = $this->_lastTrigger;
        return $res;
    }

    /**
     * Retrieves a watchdog for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the watchdog is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the watchdog is
     * indeed online at a given time. In case of ambiguity when looking for
     * a watchdog by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the watchdog, for instance
     *         WDOGDC01.watchdog1.
     *
     * @return YWatchdog  a YWatchdog object allowing you to drive the watchdog.
     */
    public static function FindWatchdog(string $func): ?YWatchdog
    {
        // $obj                    is a YWatchdog;
        $obj = YFunction::_FindFromCache('Watchdog', $func);
        if ($obj == null) {
            $obj = new YWatchdog($func);
            YFunction::_AddToCache('Watchdog', $func, $obj);
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

    public function delayedPulseTimer(): YDelayedPulse
{
    return $this->get_delayedPulseTimer();
}

    public function setDelayedPulseTimer(YDelayedPulse $newval)
{
    return $this->set_delayedPulseTimer($newval);
}

    public function countdown(): float
{
    return $this->get_countdown();
}

    public function autoStart(): int
{
    return $this->get_autoStart();
}

    public function setAutoStart(int $newval)
{
    return $this->set_autoStart($newval);
}

    public function running(): int
{
    return $this->get_running();
}

    public function setRunning(int $newval)
{
    return $this->set_running($newval);
}

    public function triggerDelay(): float
{
    return $this->get_triggerDelay();
}

    public function setTriggerDelay(float $newval)
{
    return $this->set_triggerDelay($newval);
}

    public function triggerDuration(): float
{
    return $this->get_triggerDuration();
}

    public function setTriggerDuration(float $newval)
{
    return $this->set_triggerDuration($newval);
}

    public function lastTrigger(): int
{
    return $this->get_lastTrigger();
}

    /**
     * Continues the enumeration of watchdog started using yFirstWatchdog().
     * Caution: You can't make any assumption about the returned watchdog order.
     * If you want to find a specific a watchdog, use Watchdog.findWatchdog()
     * and a hardwareID or a logical name.
     *
     * @return YWatchdog  a pointer to a YWatchdog object, corresponding to
     *         a watchdog currently online, or a null pointer
     *         if there are no more watchdog to enumerate.
     */
    public function nextWatchdog(): ?YWatchdog
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindWatchdog($next_hwid);
    }

    /**
     * Starts the enumeration of watchdog currently accessible.
     * Use the method YWatchdog::nextWatchdog() to iterate on
     * next watchdog.
     *
     * @return YWatchdog  a pointer to a YWatchdog object, corresponding to
     *         the first watchdog currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstWatchdog()
    {
        $next_hwid = YAPI::getFirstHardwareId('Watchdog');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindWatchdog($next_hwid);
    }

    //--- (end of YWatchdog implementation)

}
