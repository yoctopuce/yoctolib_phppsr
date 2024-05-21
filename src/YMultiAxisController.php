<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YMultiAxisController Class: MultiAxisController function interface
 *
 * The YMultiAxisController class allows you to drive multiple stepper motors
 * synchronously.
 */
class YMultiAxisController extends YFunction
{
    const NAXIS_INVALID = YAPI::INVALID_UINT;
    const GLOBALSTATE_ABSENT = 0;
    const GLOBALSTATE_ALERT = 1;
    const GLOBALSTATE_HI_Z = 2;
    const GLOBALSTATE_STOP = 3;
    const GLOBALSTATE_RUN = 4;
    const GLOBALSTATE_BATCH = 5;
    const GLOBALSTATE_INVALID = -1;
    const COMMAND_INVALID = YAPI::INVALID_STRING;
    //--- (end of YMultiAxisController declaration)

    //--- (YMultiAxisController attributes)
    protected int $_nAxis = self::NAXIS_INVALID;          // UInt31
    protected int $_globalState = self::GLOBALSTATE_INVALID;    // StepperState
    protected string $_command = self::COMMAND_INVALID;        // Text

    //--- (end of YMultiAxisController attributes)

    function __construct(string $str_func)
    {
        //--- (YMultiAxisController constructor)
        parent::__construct($str_func);
        $this->_className = 'MultiAxisController';

        //--- (end of YMultiAxisController constructor)
    }

    //--- (YMultiAxisController implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'nAxis':
            $this->_nAxis = intval($val);
            return 1;
        case 'globalState':
            $this->_globalState = intval($val);
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the number of synchronized controllers.
     *
     * @return int  an integer corresponding to the number of synchronized controllers
     *
     * On failure, throws an exception or returns YMultiAxisController::NAXIS_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_nAxis(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::NAXIS_INVALID;
            }
        }
        $res = $this->_nAxis;
        return $res;
    }

    /**
     * Changes the number of synchronized controllers.
     *
     * @param int $newval : an integer corresponding to the number of synchronized controllers
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_nAxis(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("nAxis", $rest_val);
    }

    /**
     * Returns the stepper motor set overall state.
     *
     * @return int  a value among YMultiAxisController::GLOBALSTATE_ABSENT,
     * YMultiAxisController::GLOBALSTATE_ALERT, YMultiAxisController::GLOBALSTATE_HI_Z,
     * YMultiAxisController::GLOBALSTATE_STOP, YMultiAxisController::GLOBALSTATE_RUN and
     * YMultiAxisController::GLOBALSTATE_BATCH corresponding to the stepper motor set overall state
     *
     * On failure, throws an exception or returns YMultiAxisController::GLOBALSTATE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_globalState(): int
    {
        // $res                    is a enumSTEPPERSTATE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::GLOBALSTATE_INVALID;
            }
        }
        $res = $this->_globalState;
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
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

    /**
     * @throws YAPI_Exception
     */
    public function set_command(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("command", $rest_val);
    }

    /**
     * Retrieves a multi-axis controller for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the multi-axis controller is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the multi-axis controller is
     * indeed online at a given time. In case of ambiguity when looking for
     * a multi-axis controller by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the multi-axis controller, for instance
     *         MyDevice.multiAxisController.
     *
     * @return YMultiAxisController  a YMultiAxisController object allowing you to drive the multi-axis controller.
     */
    public static function FindMultiAxisController(string $func): YMultiAxisController
    {
        // $obj                    is a YMultiAxisController;
        $obj = YFunction::_FindFromCache('MultiAxisController', $func);
        if ($obj == null) {
            $obj = new YMultiAxisController($func);
            YFunction::_AddToCache('MultiAxisController', $func, $obj);
        }
        return $obj;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function sendCommand(string $command): int
    {
        // $url                    is a str;
        // $retBin                 is a bin;
        // $res                    is a int;
        $url = sprintf('cmd.txt?X=%s', $command);
        //may throw an exception
        $retBin = $this->_download($url);
        $res = ord($retBin[0]);
        if ($res < 58) {
            if (!($res == 48)) return $this->_throw( YAPI::DEVICE_BUSY, 'Motor command pipeline is full, try again later',YAPI::DEVICE_BUSY);
        } else {
            if (!($res == 48)) return $this->_throw( YAPI::IO_ERROR, 'Motor command failed permanently',YAPI::IO_ERROR);
        }
        return YAPI::SUCCESS;
    }

    /**
     * Reinitialize all controllers and clear all alert flags.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function reset(): int
    {
        return $this->set_command('Z');
    }

    /**
     * Starts all motors backward at the specified speeds, to search for the motor home position.
     *
     * @param float[] $speed : desired speed for all axis, in steps per second.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function findHomePosition(array $speed): int
    {
        // $cmd                    is a str;
        // $i                      is a int;
        // $ndim                   is a int;
        $ndim = sizeof($speed);
        $cmd = sprintf('H%d', intval(round(1000*$speed[0])));
        $i = 1;
        while ($i < $ndim) {
            $cmd = sprintf('%s,%d', $cmd, intval(round(1000*$speed[$i])));
            $i = $i + 1;
        }
        return $this->sendCommand($cmd);
    }

    /**
     * Starts all motors synchronously to reach a given absolute position.
     * The time needed to reach the requested position will depend on the lowest
     * acceleration and max speed parameters configured for all motors.
     * The final position will be reached on all axis at the same time.
     *
     * @param float[] $absPos : absolute position, measured in steps from each origin.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function moveTo(array $absPos): int
    {
        // $cmd                    is a str;
        // $i                      is a int;
        // $ndim                   is a int;
        $ndim = sizeof($absPos);
        $cmd = sprintf('M%d', intval(round(16*$absPos[0])));
        $i = 1;
        while ($i < $ndim) {
            $cmd = sprintf('%s,%d', $cmd, intval(round(16*$absPos[$i])));
            $i = $i + 1;
        }
        return $this->sendCommand($cmd);
    }

    /**
     * Starts all motors synchronously to reach a given relative position.
     * The time needed to reach the requested position will depend on the lowest
     * acceleration and max speed parameters configured for all motors.
     * The final position will be reached on all axis at the same time.
     *
     * @param float[] $relPos : relative position, measured in steps from the current position.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function moveRel(array $relPos): int
    {
        // $cmd                    is a str;
        // $i                      is a int;
        // $ndim                   is a int;
        $ndim = sizeof($relPos);
        $cmd = sprintf('m%d', intval(round(16*$relPos[0])));
        $i = 1;
        while ($i < $ndim) {
            $cmd = sprintf('%s,%d', $cmd, intval(round(16*$relPos[$i])));
            $i = $i + 1;
        }
        return $this->sendCommand($cmd);
    }

    /**
     * Keep the motor in the same state for the specified amount of time, before processing next command.
     *
     * @param int $waitMs : wait time, specified in milliseconds.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function pause(int $waitMs): int
    {
        return $this->sendCommand(sprintf('_%d',$waitMs));
    }

    /**
     * Stops the motor with an emergency alert, without taking any additional precaution.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function emergencyStop(): int
    {
        return $this->set_command('!');
    }

    /**
     * Stops the motor smoothly as soon as possible, without waiting for ongoing move completion.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function abortAndBrake(): int
    {
        return $this->set_command('B');
    }

    /**
     * Turn the controller into Hi-Z mode immediately, without waiting for ongoing move completion.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function abortAndHiZ(): int
    {
        return $this->set_command('z');
    }

    /**
     * @throws YAPI_Exception
     */
    public function nAxis(): int
{
    return $this->get_nAxis();
}

    /**
     * @throws YAPI_Exception
     */
    public function setNAxis(int $newval): int
{
    return $this->set_nAxis($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function globalState(): int
{
    return $this->get_globalState();
}

    /**
     * @throws YAPI_Exception
     */
    public function command(): string
{
    return $this->get_command();
}

    /**
     * @throws YAPI_Exception
     */
    public function setCommand(string $newval): int
{
    return $this->set_command($newval);
}

    /**
     * Continues the enumeration of multi-axis controllers started using yFirstMultiAxisController().
     * Caution: You can't make any assumption about the returned multi-axis controllers order.
     * If you want to find a specific a multi-axis controller, use MultiAxisController.findMultiAxisController()
     * and a hardwareID or a logical name.
     *
     * @return ?YMultiAxisController  a pointer to a YMultiAxisController object, corresponding to
     *         a multi-axis controller currently online, or a null pointer
     *         if there are no more multi-axis controllers to enumerate.
     */
    public function nextMultiAxisController(): ?YMultiAxisController
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindMultiAxisController($next_hwid);
    }

    /**
     * Starts the enumeration of multi-axis controllers currently accessible.
     * Use the method YMultiAxisController::nextMultiAxisController() to iterate on
     * next multi-axis controllers.
     *
     * @return ?YMultiAxisController  a pointer to a YMultiAxisController object, corresponding to
     *         the first multi-axis controller currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstMultiAxisController(): ?YMultiAxisController
    {
        $next_hwid = YAPI::getFirstHardwareId('MultiAxisController');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindMultiAxisController($next_hwid);
    }

    //--- (end of YMultiAxisController implementation)

}
