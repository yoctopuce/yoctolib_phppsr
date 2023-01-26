<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YMotor Class: motor control interface, available for instance in the Yocto-Motor-DC
 *
 * The YMotor class allows you to drive a DC motor. It can be used to configure the
 * power sent to the motor to make it turn both ways, but also to drive accelerations
 * and decelerations. The motor will then accelerate automatically: you will not
 * have to monitor it. The API also allows to slow down the motor by shortening
 * its terminals: the motor will then act as an electromagnetic brake.
 */
class YMotor extends YFunction
{
    const MOTORSTATUS_IDLE = 0;
    const MOTORSTATUS_BRAKE = 1;
    const MOTORSTATUS_FORWD = 2;
    const MOTORSTATUS_BACKWD = 3;
    const MOTORSTATUS_LOVOLT = 4;
    const MOTORSTATUS_HICURR = 5;
    const MOTORSTATUS_HIHEAT = 6;
    const MOTORSTATUS_FAILSF = 7;
    const MOTORSTATUS_INVALID = -1;
    const DRIVINGFORCE_INVALID = YAPI::INVALID_DOUBLE;
    const BRAKINGFORCE_INVALID = YAPI::INVALID_DOUBLE;
    const CUTOFFVOLTAGE_INVALID = YAPI::INVALID_DOUBLE;
    const OVERCURRENTLIMIT_INVALID = YAPI::INVALID_UINT;
    const FREQUENCY_INVALID = YAPI::INVALID_DOUBLE;
    const STARTERTIME_INVALID = YAPI::INVALID_UINT;
    const FAILSAFETIMEOUT_INVALID = YAPI::INVALID_UINT;
    const COMMAND_INVALID = YAPI::INVALID_STRING;
    //--- (end of YMotor declaration)

    //--- (YMotor attributes)
    protected int $_motorStatus = self::MOTORSTATUS_INVALID;    // MotorState
    protected float $_drivingForce = self::DRIVINGFORCE_INVALID;   // MeasureVal
    protected float $_brakingForce = self::BRAKINGFORCE_INVALID;   // MeasureVal
    protected float $_cutOffVoltage = self::CUTOFFVOLTAGE_INVALID;  // MeasureVal
    protected int $_overCurrentLimit = self::OVERCURRENTLIMIT_INVALID; // UInt31
    protected float $_frequency = self::FREQUENCY_INVALID;      // MeasureVal
    protected int $_starterTime = self::STARTERTIME_INVALID;    // UInt31
    protected int $_failSafeTimeout = self::FAILSAFETIMEOUT_INVALID; // UInt31
    protected string $_command = self::COMMAND_INVALID;        // Text

    //--- (end of YMotor attributes)

    function __construct($str_func)
    {
        //--- (YMotor constructor)
        parent::__construct($str_func);
        $this->_className = 'Motor';

        //--- (end of YMotor constructor)
    }

    //--- (YMotor implementation)

    function _parseAttr($name, $val): int
    {
        switch ($name) {
        case 'motorStatus':
            $this->_motorStatus = intval($val);
            return 1;
        case 'drivingForce':
            $this->_drivingForce = round($val / 65.536) / 1000.0;
            return 1;
        case 'brakingForce':
            $this->_brakingForce = round($val / 65.536) / 1000.0;
            return 1;
        case 'cutOffVoltage':
            $this->_cutOffVoltage = round($val / 65.536) / 1000.0;
            return 1;
        case 'overCurrentLimit':
            $this->_overCurrentLimit = intval($val);
            return 1;
        case 'frequency':
            $this->_frequency = round($val / 65.536) / 1000.0;
            return 1;
        case 'starterTime':
            $this->_starterTime = intval($val);
            return 1;
        case 'failSafeTimeout':
            $this->_failSafeTimeout = intval($val);
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Return the controller state. Possible states are:
     * IDLE   when the motor is stopped/in free wheel, ready to start;
     * FORWD  when the controller is driving the motor forward;
     * BACKWD when the controller is driving the motor backward;
     * BRAKE  when the controller is braking;
     * LOVOLT when the controller has detected a low voltage condition;
     * HICURR when the controller has detected an over current condition;
     * HIHEAT when the controller has detected an overheat condition;
     * FAILSF when the controller switched on the failsafe security.
     *
     * When an error condition occurred (LOVOLT, HICURR, HIHEAT, FAILSF), the controller
     * status must be explicitly reset using the resetStatus function.
     *
     * @return int  a value among YMotor::MOTORSTATUS_IDLE, YMotor::MOTORSTATUS_BRAKE,
     * YMotor::MOTORSTATUS_FORWD, YMotor::MOTORSTATUS_BACKWD, YMotor::MOTORSTATUS_LOVOLT,
     * YMotor::MOTORSTATUS_HICURR, YMotor::MOTORSTATUS_HIHEAT and YMotor::MOTORSTATUS_FAILSF
     *
     * On failure, throws an exception or returns YMotor::MOTORSTATUS_INVALID.
     */
    public function get_motorStatus(): int
    {
        // $res                    is a enumMOTORSTATE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::MOTORSTATUS_INVALID;
            }
        }
        $res = $this->_motorStatus;
        return $res;
    }

    public function set_motorStatus(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("motorStatus", $rest_val);
    }

    /**
     * Changes immediately the power sent to the motor. The value is a percentage between -100%
     * to 100%. If you want go easy on your mechanics and avoid excessive current consumption,
     * try to avoid brutal power changes. For example, immediate transition from forward full power
     * to reverse full power is a very bad idea. Each time the driving power is modified, the
     * braking power is set to zero.
     *
     * @param float $newval : a floating point number corresponding to immediately the power sent to the motor
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_drivingForce(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("drivingForce", $rest_val);
    }

    /**
     * Returns the power sent to the motor, as a percentage between -100% and +100%.
     *
     * @return float  a floating point number corresponding to the power sent to the motor, as a
     * percentage between -100% and +100%
     *
     * On failure, throws an exception or returns YMotor::DRIVINGFORCE_INVALID.
     */
    public function get_drivingForce(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DRIVINGFORCE_INVALID;
            }
        }
        $res = $this->_drivingForce;
        return $res;
    }

    /**
     * Changes immediately the braking force applied to the motor (in percents).
     * The value 0 corresponds to no braking (free wheel). When the braking force
     * is changed, the driving power is set to zero. The value is a percentage.
     *
     * @param float $newval : a floating point number corresponding to immediately the braking force
     * applied to the motor (in percents)
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_brakingForce(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("brakingForce", $rest_val);
    }

    /**
     * Returns the braking force applied to the motor, as a percentage.
     * The value 0 corresponds to no braking (free wheel).
     *
     * @return float  a floating point number corresponding to the braking force applied to the motor, as a percentage
     *
     * On failure, throws an exception or returns YMotor::BRAKINGFORCE_INVALID.
     */
    public function get_brakingForce(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::BRAKINGFORCE_INVALID;
            }
        }
        $res = $this->_brakingForce;
        return $res;
    }

    /**
     * Changes the threshold voltage under which the controller automatically switches to error state
     * and prevents further current draw. This setting prevent damage to a battery that can
     * occur when drawing current from an "empty" battery.
     * Note that whatever the cutoff threshold, the controller switches to undervoltage
     * error state if the power supply goes under 3V, even for a very brief time.
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param float $newval : a floating point number corresponding to the threshold voltage under which
     * the controller automatically switches to error state
     *         and prevents further current draw
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_cutOffVoltage(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("cutOffVoltage", $rest_val);
    }

    /**
     * Returns the threshold voltage under which the controller automatically switches to error state
     * and prevents further current draw. This setting prevents damage to a battery that can
     * occur when drawing current from an "empty" battery.
     *
     * @return float  a floating point number corresponding to the threshold voltage under which the
     * controller automatically switches to error state
     *         and prevents further current draw
     *
     * On failure, throws an exception or returns YMotor::CUTOFFVOLTAGE_INVALID.
     */
    public function get_cutOffVoltage(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CUTOFFVOLTAGE_INVALID;
            }
        }
        $res = $this->_cutOffVoltage;
        return $res;
    }

    /**
     * Returns the current threshold (in mA) above which the controller automatically
     * switches to error state. A zero value means that there is no limit.
     *
     * @return int  an integer corresponding to the current threshold (in mA) above which the controller automatically
     *         switches to error state
     *
     * On failure, throws an exception or returns YMotor::OVERCURRENTLIMIT_INVALID.
     */
    public function get_overCurrentLimit(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::OVERCURRENTLIMIT_INVALID;
            }
        }
        $res = $this->_overCurrentLimit;
        return $res;
    }

    /**
     * Changes the current threshold (in mA) above which the controller automatically
     * switches to error state. A zero value means that there is no limit. Note that whatever the
     * current limit is, the controller switches to OVERCURRENT status if the current
     * goes above 32A, even for a very brief time. Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param int $newval : an integer corresponding to the current threshold (in mA) above which the
     * controller automatically
     *         switches to error state
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_overCurrentLimit(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("overCurrentLimit", $rest_val);
    }

    /**
     * Changes the PWM frequency used to control the motor. Low frequency is usually
     * more efficient and may help the motor to start, but an audible noise might be
     * generated. A higher frequency reduces the noise, but more energy is converted
     * into heat. Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param float $newval : a floating point number corresponding to the PWM frequency used to control the motor
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_frequency(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("frequency", $rest_val);
    }

    /**
     * Returns the PWM frequency used to control the motor.
     *
     * @return float  a floating point number corresponding to the PWM frequency used to control the motor
     *
     * On failure, throws an exception or returns YMotor::FREQUENCY_INVALID.
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
     * Returns the duration (in ms) during which the motor is driven at low frequency to help
     * it start up.
     *
     * @return int  an integer corresponding to the duration (in ms) during which the motor is driven at
     * low frequency to help
     *         it start up
     *
     * On failure, throws an exception or returns YMotor::STARTERTIME_INVALID.
     */
    public function get_starterTime(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::STARTERTIME_INVALID;
            }
        }
        $res = $this->_starterTime;
        return $res;
    }

    /**
     * Changes the duration (in ms) during which the motor is driven at low frequency to help
     * it start up. Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param int $newval : an integer corresponding to the duration (in ms) during which the motor is
     * driven at low frequency to help
     *         it start up
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_starterTime(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("starterTime", $rest_val);
    }

    /**
     * Returns the delay in milliseconds allowed for the controller to run autonomously without
     * receiving any instruction from the control process. When this delay has elapsed,
     * the controller automatically stops the motor and switches to FAILSAFE error.
     * Failsafe security is disabled when the value is zero.
     *
     * @return int  an integer corresponding to the delay in milliseconds allowed for the controller to
     * run autonomously without
     *         receiving any instruction from the control process
     *
     * On failure, throws an exception or returns YMotor::FAILSAFETIMEOUT_INVALID.
     */
    public function get_failSafeTimeout(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::FAILSAFETIMEOUT_INVALID;
            }
        }
        $res = $this->_failSafeTimeout;
        return $res;
    }

    /**
     * Changes the delay in milliseconds allowed for the controller to run autonomously without
     * receiving any instruction from the control process. When this delay has elapsed,
     * the controller automatically stops the motor and switches to FAILSAFE error.
     * Failsafe security is disabled when the value is zero.
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param int $newval : an integer corresponding to the delay in milliseconds allowed for the
     * controller to run autonomously without
     *         receiving any instruction from the control process
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_failSafeTimeout(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("failSafeTimeout", $rest_val);
    }

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

    public function set_command(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("command", $rest_val);
    }

    /**
     * Retrieves a motor for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the motor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the motor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a motor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the motor, for instance
     *         MOTORCTL.motor.
     *
     * @return YMotor  a YMotor object allowing you to drive the motor.
     */
    public static function FindMotor(string $func): ?YMotor
    {
        // $obj                    is a YMotor;
        $obj = YFunction::_FindFromCache('Motor', $func);
        if ($obj == null) {
            $obj = new YMotor($func);
            YFunction::_AddToCache('Motor', $func, $obj);
        }
        return $obj;
    }

    /**
     * Rearms the controller failsafe timer. When the motor is running and the failsafe feature
     * is active, this function should be called periodically to prove that the control process
     * is running properly. Otherwise, the motor is automatically stopped after the specified
     * timeout. Calling a motor <i>set</i> function implicitly rearms the failsafe timer.
     */
    public function keepALive(): int
    {
        return $this->set_command('K');
    }

    /**
     * Reset the controller state to IDLE. This function must be invoked explicitly
     * after any error condition is signaled.
     */
    public function resetStatus(): int
    {
        return $this->set_motorStatus(self::MOTORSTATUS_IDLE);
    }

    /**
     * Changes progressively the power sent to the motor for a specific duration.
     *
     * @param float $targetPower : desired motor power, in percents (between -100% and +100%)
     * @param int $delay : duration (in ms) of the transition
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function drivingForceMove(float $targetPower, int $delay): int
    {
        return $this->set_command(sprintf('P%d,%d',round($targetPower*10),$delay));
    }

    /**
     * Changes progressively the braking force applied to the motor for a specific duration.
     *
     * @param float $targetPower : desired braking force, in percents
     * @param int $delay : duration (in ms) of the transition
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function brakingForceMove(float $targetPower, int $delay): int
    {
        return $this->set_command(sprintf('B%d,%d',round($targetPower*10),$delay));
    }

    public function motorStatus(): int
{
    return $this->get_motorStatus();
}

    public function setMotorStatus(int $newval)
{
    return $this->set_motorStatus($newval);
}

    public function setDrivingForce(float $newval)
{
    return $this->set_drivingForce($newval);
}

    public function drivingForce(): float
{
    return $this->get_drivingForce();
}

    public function setBrakingForce(float $newval)
{
    return $this->set_brakingForce($newval);
}

    public function brakingForce(): float
{
    return $this->get_brakingForce();
}

    public function setCutOffVoltage(float $newval)
{
    return $this->set_cutOffVoltage($newval);
}

    public function cutOffVoltage(): float
{
    return $this->get_cutOffVoltage();
}

    public function overCurrentLimit(): int
{
    return $this->get_overCurrentLimit();
}

    public function setOverCurrentLimit(int $newval)
{
    return $this->set_overCurrentLimit($newval);
}

    public function setFrequency(float $newval)
{
    return $this->set_frequency($newval);
}

    public function frequency(): float
{
    return $this->get_frequency();
}

    public function starterTime(): int
{
    return $this->get_starterTime();
}

    public function setStarterTime(int $newval)
{
    return $this->set_starterTime($newval);
}

    public function failSafeTimeout(): int
{
    return $this->get_failSafeTimeout();
}

    public function setFailSafeTimeout(int $newval)
{
    return $this->set_failSafeTimeout($newval);
}

    public function command(): string
{
    return $this->get_command();
}

    public function setCommand(string $newval)
{
    return $this->set_command($newval);
}

    /**
     * Continues the enumeration of motors started using yFirstMotor().
     * Caution: You can't make any assumption about the returned motors order.
     * If you want to find a specific a motor, use Motor.findMotor()
     * and a hardwareID or a logical name.
     *
     * @return YMotor  a pointer to a YMotor object, corresponding to
     *         a motor currently online, or a null pointer
     *         if there are no more motors to enumerate.
     */
    public function nextMotor(): ?YMotor
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindMotor($next_hwid);
    }

    /**
     * Starts the enumeration of motors currently accessible.
     * Use the method YMotor::nextMotor() to iterate on
     * next motors.
     *
     * @return YMotor  a pointer to a YMotor object, corresponding to
     *         the first motor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstMotor()
    {
        $next_hwid = YAPI::getFirstHardwareId('Motor');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindMotor($next_hwid);
    }

    //--- (end of YMotor implementation)

}
