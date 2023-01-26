<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YCurrentLoopOutput Class: 4-20mA output control interface, available for instance in the Yocto-4-20mA-Tx
 *
 * The YCurrentLoopOutput class allows you to drive a 4-20mA output
 * by regulating the current flowing through the current loop.
 * It can also provide information about the power state of the current loop.
 */
class YCurrentLoopOutput extends YFunction
{
    const CURRENT_INVALID = YAPI::INVALID_DOUBLE;
    const CURRENTTRANSITION_INVALID = YAPI::INVALID_STRING;
    const CURRENTATSTARTUP_INVALID = YAPI::INVALID_DOUBLE;
    const LOOPPOWER_NOPWR = 0;
    const LOOPPOWER_LOWPWR = 1;
    const LOOPPOWER_POWEROK = 2;
    const LOOPPOWER_INVALID = -1;
    //--- (end of YCurrentLoopOutput declaration)

    //--- (YCurrentLoopOutput attributes)
    protected float $_current = self::CURRENT_INVALID;        // MeasureVal
    protected string $_currentTransition = self::CURRENTTRANSITION_INVALID; // AnyFloatTransition
    protected float $_currentAtStartUp = self::CURRENTATSTARTUP_INVALID; // MeasureVal
    protected int $_loopPower = self::LOOPPOWER_INVALID;      // LoopPwrState

    //--- (end of YCurrentLoopOutput attributes)

    function __construct($str_func)
    {
        //--- (YCurrentLoopOutput constructor)
        parent::__construct($str_func);
        $this->_className = 'CurrentLoopOutput';

        //--- (end of YCurrentLoopOutput constructor)
    }

    //--- (YCurrentLoopOutput implementation)

    function _parseAttr($name, $val): int
    {
        switch ($name) {
        case 'current':
            $this->_current = round($val / 65.536) / 1000.0;
            return 1;
        case 'currentTransition':
            $this->_currentTransition = $val;
            return 1;
        case 'currentAtStartUp':
            $this->_currentAtStartUp = round($val / 65.536) / 1000.0;
            return 1;
        case 'loopPower':
            $this->_loopPower = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Changes the current loop, the valid range is from 3 to 21mA. If the loop is
     * not properly powered, the  target current is not reached and
     * loopPower is set to LOWPWR.
     *
     * @param float $newval : a floating point number corresponding to the current loop, the valid range
     * is from 3 to 21mA
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_current(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("current", $rest_val);
    }

    /**
     * Returns the loop current set point in mA.
     *
     * @return float  a floating point number corresponding to the loop current set point in mA
     *
     * On failure, throws an exception or returns YCurrentLoopOutput::CURRENT_INVALID.
     */
    public function get_current(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CURRENT_INVALID;
            }
        }
        $res = $this->_current;
        return $res;
    }

    public function get_currentTransition(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CURRENTTRANSITION_INVALID;
            }
        }
        $res = $this->_currentTransition;
        return $res;
    }

    public function set_currentTransition(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("currentTransition", $rest_val);
    }

    /**
     * Changes the loop current at device start up. Remember to call the matching
     * module saveToFlash() method, otherwise this call has no effect.
     *
     * @param float $newval : a floating point number corresponding to the loop current at device start up
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_currentAtStartUp(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("currentAtStartUp", $rest_val);
    }

    /**
     * Returns the current in the loop at device startup, in mA.
     *
     * @return float  a floating point number corresponding to the current in the loop at device startup, in mA
     *
     * On failure, throws an exception or returns YCurrentLoopOutput::CURRENTATSTARTUP_INVALID.
     */
    public function get_currentAtStartUp(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CURRENTATSTARTUP_INVALID;
            }
        }
        $res = $this->_currentAtStartUp;
        return $res;
    }

    /**
     * Returns the loop powerstate.  POWEROK: the loop
     * is powered. NOPWR: the loop in not powered. LOWPWR: the loop is not
     * powered enough to maintain the current required (insufficient voltage).
     *
     * @return int  a value among YCurrentLoopOutput::LOOPPOWER_NOPWR, YCurrentLoopOutput::LOOPPOWER_LOWPWR
     * and YCurrentLoopOutput::LOOPPOWER_POWEROK corresponding to the loop powerstate
     *
     * On failure, throws an exception or returns YCurrentLoopOutput::LOOPPOWER_INVALID.
     */
    public function get_loopPower(): int
    {
        // $res                    is a enumLOOPPWRSTATE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LOOPPOWER_INVALID;
            }
        }
        $res = $this->_loopPower;
        return $res;
    }

    /**
     * Retrieves a 4-20mA output for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the 4-20mA output is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the 4-20mA output is
     * indeed online at a given time. In case of ambiguity when looking for
     * a 4-20mA output by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the 4-20mA output, for instance
     *         TX420MA1.currentLoopOutput.
     *
     * @return YCurrentLoopOutput  a YCurrentLoopOutput object allowing you to drive the 4-20mA output.
     */
    public static function FindCurrentLoopOutput(string $func): ?YCurrentLoopOutput
    {
        // $obj                    is a YCurrentLoopOutput;
        $obj = YFunction::_FindFromCache('CurrentLoopOutput', $func);
        if ($obj == null) {
            $obj = new YCurrentLoopOutput($func);
            YFunction::_AddToCache('CurrentLoopOutput', $func, $obj);
        }
        return $obj;
    }

    /**
     * Performs a smooth transition of current flowing in the loop. Any current explicit
     * change cancels any ongoing transition process.
     *
     * @param float $mA_target   : new current value at the end of the transition
     *         (floating-point number, representing the end current in mA)
     * @param int $ms_duration : total duration of the transition, in milliseconds
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     */
    public function currentMove(float $mA_target, int $ms_duration): int
    {
        // $newval                 is a str;
        if ($mA_target < 3.0) {
            $mA_target  = 3.0;
        }
        if ($mA_target > 21.0) {
            $mA_target = 21.0;
        }
        $newval = sprintf('%d:%d', round($mA_target*65536), $ms_duration);

        return $this->set_currentTransition($newval);
    }

    public function setCurrent(float $newval)
{
    return $this->set_current($newval);
}

    public function current(): float
{
    return $this->get_current();
}

    public function currentTransition(): string
{
    return $this->get_currentTransition();
}

    public function setCurrentTransition(string $newval)
{
    return $this->set_currentTransition($newval);
}

    public function setCurrentAtStartUp(float $newval)
{
    return $this->set_currentAtStartUp($newval);
}

    public function currentAtStartUp(): float
{
    return $this->get_currentAtStartUp();
}

    public function loopPower(): int
{
    return $this->get_loopPower();
}

    /**
     * Continues the enumeration of 4-20mA outputs started using yFirstCurrentLoopOutput().
     * Caution: You can't make any assumption about the returned 4-20mA outputs order.
     * If you want to find a specific a 4-20mA output, use CurrentLoopOutput.findCurrentLoopOutput()
     * and a hardwareID or a logical name.
     *
     * @return YCurrentLoopOutput  a pointer to a YCurrentLoopOutput object, corresponding to
     *         a 4-20mA output currently online, or a null pointer
     *         if there are no more 4-20mA outputs to enumerate.
     */
    public function nextCurrentLoopOutput(): ?YCurrentLoopOutput
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindCurrentLoopOutput($next_hwid);
    }

    /**
     * Starts the enumeration of 4-20mA outputs currently accessible.
     * Use the method YCurrentLoopOutput::nextCurrentLoopOutput() to iterate on
     * next 4-20mA outputs.
     *
     * @return YCurrentLoopOutput  a pointer to a YCurrentLoopOutput object, corresponding to
     *         the first 4-20mA output currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstCurrentLoopOutput()
    {
        $next_hwid = YAPI::getFirstHardwareId('CurrentLoopOutput');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindCurrentLoopOutput($next_hwid);
    }

    //--- (end of YCurrentLoopOutput implementation)

}
