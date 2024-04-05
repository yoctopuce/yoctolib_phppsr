<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YServo Class: RC servo motor control interface, available for instance in the Yocto-Servo
 *
 * The YServo class is designed to drive remote-control servo motors
 * outputs. This class allows you not only to move
 * a servo to a given position, but also to specify the time interval
 * in which the move should be performed. This makes it possible to
 * synchronize two servos involved in a same move.
 */
class YServo extends YFunction
{
    const POSITION_INVALID = YAPI::INVALID_INT;
    const ENABLED_FALSE = 0;
    const ENABLED_TRUE = 1;
    const ENABLED_INVALID = -1;
    const RANGE_INVALID = YAPI::INVALID_UINT;
    const NEUTRAL_INVALID = YAPI::INVALID_UINT;
    const MOVE_INVALID = null;
    const POSITIONATPOWERON_INVALID = YAPI::INVALID_INT;
    const ENABLEDATPOWERON_FALSE = 0;
    const ENABLEDATPOWERON_TRUE = 1;
    const ENABLEDATPOWERON_INVALID = -1;
    //--- (end of YServo declaration)

    //--- (YServo attributes)
    protected int $_position = self::POSITION_INVALID;       // Int
    protected int $_enabled = self::ENABLED_INVALID;        // Bool
    protected int $_range = self::RANGE_INVALID;          // Percent
    protected int $_neutral = self::NEUTRAL_INVALID;        // MicroSeconds
    protected mixed $_move = self::MOVE_INVALID;           // Move
    protected int $_positionAtPowerOn = self::POSITIONATPOWERON_INVALID; // Int
    protected int $_enabledAtPowerOn = self::ENABLEDATPOWERON_INVALID; // Bool

    //--- (end of YServo attributes)

    function __construct(string $str_func)
    {
        //--- (YServo constructor)
        parent::__construct($str_func);
        $this->_className = 'Servo';

        //--- (end of YServo constructor)
    }

    //--- (YServo implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'position':
            $this->_position = intval($val);
            return 1;
        case 'enabled':
            $this->_enabled = intval($val);
            return 1;
        case 'range':
            $this->_range = intval($val);
            return 1;
        case 'neutral':
            $this->_neutral = intval($val);
            return 1;
        case 'move':
            $this->_move = $val;
            return 1;
        case 'positionAtPowerOn':
            $this->_positionAtPowerOn = intval($val);
            return 1;
        case 'enabledAtPowerOn':
            $this->_enabledAtPowerOn = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the current servo position.
     *
     * @return int  an integer corresponding to the current servo position
     *
     * On failure, throws an exception or returns YServo::POSITION_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_position(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::POSITION_INVALID;
            }
        }
        $res = $this->_position;
        return $res;
    }

    /**
     * Changes immediately the servo driving position.
     *
     * @param int $newval : an integer corresponding to immediately the servo driving position
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_position(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("position", $rest_val);
    }

    /**
     * Returns the state of the RC servo motors.
     *
     * @return int  either YServo::ENABLED_FALSE or YServo::ENABLED_TRUE, according to the state of the RC servo motors
     *
     * On failure, throws an exception or returns YServo::ENABLED_INVALID.
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
     * Stops or starts the RC servo motor.
     *
     * @param int $newval : either YServo::ENABLED_FALSE or YServo::ENABLED_TRUE
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
     * Returns the current range of use of the servo.
     *
     * @return int  an integer corresponding to the current range of use of the servo
     *
     * On failure, throws an exception or returns YServo::RANGE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_range(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::RANGE_INVALID;
            }
        }
        $res = $this->_range;
        return $res;
    }

    /**
     * Changes the range of use of the servo, specified in per cents.
     * A range of 100% corresponds to a standard control signal, that varies
     * from 1 [ms] to 2 [ms], When using a servo that supports a double range,
     * from 0.5 [ms] to 2.5 [ms], you can select a range of 200%.
     * Be aware that using a range higher than what is supported by the servo
     * is likely to damage the servo. Remember to call the matching module
     * saveToFlash() method, otherwise this call will have no effect.
     *
     * @param int $newval : an integer corresponding to the range of use of the servo, specified in per cents
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_range(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("range", $rest_val);
    }

    /**
     * Returns the duration in microseconds of a neutral pulse for the servo.
     *
     * @return int  an integer corresponding to the duration in microseconds of a neutral pulse for the servo
     *
     * On failure, throws an exception or returns YServo::NEUTRAL_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_neutral(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::NEUTRAL_INVALID;
            }
        }
        $res = $this->_neutral;
        return $res;
    }

    /**
     * Changes the duration of the pulse corresponding to the neutral position of the servo.
     * The duration is specified in microseconds, and the standard value is 1500 [us].
     * This setting makes it possible to shift the range of use of the servo.
     * Be aware that using a range higher than what is supported by the servo is
     * likely to damage the servo. Remember to call the matching module
     * saveToFlash() method, otherwise this call will have no effect.
     *
     * @param int $newval : an integer corresponding to the duration of the pulse corresponding to the
     * neutral position of the servo
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_neutral(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("neutral", $rest_val);
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_move(): mixed
    {
        // $res                    is a YMove;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::MOVE_INVALID;
            }
        }
        $res = $this->_move;
        return $res;
    }

    /**
     * @throws YAPI_Exception
     */
    public function set_move(mixed $newval): int
    {
        $rest_val = $newval["target"].':'.$newval["ms"];
        return $this->_setAttr("move", $rest_val);
    }

    /**
     * Performs a smooth move at constant speed toward a given position.
     *
     * @param int $target      : new position at the end of the move
     * @param int $ms_duration : total duration of the move, in milliseconds
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function move(int $target,int $ms_duration): int
    {
        $rest_val = $target.':'.$ms_duration;
        return $this->_setAttr("move",$rest_val);
    }

    /**
     * Returns the servo position at device power up.
     *
     * @return int  an integer corresponding to the servo position at device power up
     *
     * On failure, throws an exception or returns YServo::POSITIONATPOWERON_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_positionAtPowerOn(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::POSITIONATPOWERON_INVALID;
            }
        }
        $res = $this->_positionAtPowerOn;
        return $res;
    }

    /**
     * Configure the servo position at device power up. Remember to call the matching
     * module saveToFlash() method, otherwise this call will have no effect.
     *
     * @param int $newval : an integer
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_positionAtPowerOn(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("positionAtPowerOn", $rest_val);
    }

    /**
     * Returns the servo signal generator state at power up.
     *
     * @return int  either YServo::ENABLEDATPOWERON_FALSE or YServo::ENABLEDATPOWERON_TRUE, according to the
     * servo signal generator state at power up
     *
     * On failure, throws an exception or returns YServo::ENABLEDATPOWERON_INVALID.
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
     * Configure the servo signal generator state at power up. Remember to call the matching module saveToFlash()
     * method, otherwise this call will have no effect.
     *
     * @param int $newval : either YServo::ENABLEDATPOWERON_FALSE or YServo::ENABLEDATPOWERON_TRUE
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
     * Retrieves a RC servo motor for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the RC servo motor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the RC servo motor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a RC servo motor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the RC servo motor, for instance
     *         SERVORC1.servo1.
     *
     * @return YServo  a YServo object allowing you to drive the RC servo motor.
     */
    public static function FindServo(string $func): YServo
    {
        // $obj                    is a YServo;
        $obj = YFunction::_FindFromCache('Servo', $func);
        if ($obj == null) {
            $obj = new YServo($func);
            YFunction::_AddToCache('Servo', $func, $obj);
        }
        return $obj;
    }

    /**
     * @throws YAPI_Exception
     */
    public function position(): int
{
    return $this->get_position();
}

    /**
     * @throws YAPI_Exception
     */
    public function setPosition(int $newval): int
{
    return $this->set_position($newval);
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
    public function range(): int
{
    return $this->get_range();
}

    /**
     * @throws YAPI_Exception
     */
    public function setRange(int $newval): int
{
    return $this->set_range($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function neutral(): int
{
    return $this->get_neutral();
}

    /**
     * @throws YAPI_Exception
     */
    public function setNeutral(int $newval): int
{
    return $this->set_neutral($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function setMove(mixed $newval): int
{
    return $this->set_move($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function positionAtPowerOn(): int
{
    return $this->get_positionAtPowerOn();
}

    /**
     * @throws YAPI_Exception
     */
    public function setPositionAtPowerOn(int $newval): int
{
    return $this->set_positionAtPowerOn($newval);
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
     * Continues the enumeration of RC servo motors started using yFirstServo().
     * Caution: You can't make any assumption about the returned RC servo motors order.
     * If you want to find a specific a RC servo motor, use Servo.findServo()
     * and a hardwareID or a logical name.
     *
     * @return ?YServo  a pointer to a YServo object, corresponding to
     *         a RC servo motor currently online, or a null pointer
     *         if there are no more RC servo motors to enumerate.
     */
    public function nextServo(): ?YServo
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindServo($next_hwid);
    }

    /**
     * Starts the enumeration of RC servo motors currently accessible.
     * Use the method YServo::nextServo() to iterate on
     * next RC servo motors.
     *
     * @return ?YServo  a pointer to a YServo object, corresponding to
     *         the first RC servo motor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstServo(): ?YServo
    {
        $next_hwid = YAPI::getFirstHardwareId('Servo');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindServo($next_hwid);
    }

    //--- (end of YServo implementation)

}
