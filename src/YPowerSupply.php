<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YPowerSupply Class: regulated power supply control interface
 *
 * The YPowerSupply class allows you to drive a Yoctopuce power supply.
 * It can be use to change the voltage and current limits, and to enable/disable
 * the output.
 */
class YPowerSupply extends YFunction
{
    const VOLTAGELIMIT_INVALID = YAPI::INVALID_DOUBLE;
    const CURRENTLIMIT_INVALID = YAPI::INVALID_DOUBLE;
    const POWEROUTPUT_OFF = 0;
    const POWEROUTPUT_ON = 1;
    const POWEROUTPUT_INVALID = -1;
    const MEASUREDVOLTAGE_INVALID = YAPI::INVALID_DOUBLE;
    const MEASUREDCURRENT_INVALID = YAPI::INVALID_DOUBLE;
    const INPUTVOLTAGE_INVALID = YAPI::INVALID_DOUBLE;
    const VOLTAGETRANSITION_INVALID = YAPI::INVALID_STRING;
    const VOLTAGELIMITATSTARTUP_INVALID = YAPI::INVALID_DOUBLE;
    const CURRENTLIMITATSTARTUP_INVALID = YAPI::INVALID_DOUBLE;
    const POWEROUTPUTATSTARTUP_OFF = 0;
    const POWEROUTPUTATSTARTUP_ON = 1;
    const POWEROUTPUTATSTARTUP_INVALID = -1;
    const COMMAND_INVALID = YAPI::INVALID_STRING;
    //--- (end of YPowerSupply declaration)

    //--- (YPowerSupply attributes)
    protected float $_voltageLimit = self::VOLTAGELIMIT_INVALID;   // MeasureVal
    protected float $_currentLimit = self::CURRENTLIMIT_INVALID;   // MeasureVal
    protected int $_powerOutput = self::POWEROUTPUT_INVALID;    // OnOff
    protected float $_measuredVoltage = self::MEASUREDVOLTAGE_INVALID; // MeasureVal
    protected float $_measuredCurrent = self::MEASUREDCURRENT_INVALID; // MeasureVal
    protected float $_inputVoltage = self::INPUTVOLTAGE_INVALID;   // MeasureVal
    protected string $_voltageTransition = self::VOLTAGETRANSITION_INVALID; // AnyFloatTransition
    protected float $_voltageLimitAtStartUp = self::VOLTAGELIMITATSTARTUP_INVALID; // MeasureVal
    protected float $_currentLimitAtStartUp = self::CURRENTLIMITATSTARTUP_INVALID; // MeasureVal
    protected int $_powerOutputAtStartUp = self::POWEROUTPUTATSTARTUP_INVALID; // OnOff
    protected string $_command = self::COMMAND_INVALID;        // Text

    //--- (end of YPowerSupply attributes)

    function __construct(string $str_func)
    {
        //--- (YPowerSupply constructor)
        parent::__construct($str_func);
        $this->_className = 'PowerSupply';

        //--- (end of YPowerSupply constructor)
    }

    //--- (YPowerSupply implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'voltageLimit':
            $this->_voltageLimit = round($val / 65.536) / 1000.0;
            return 1;
        case 'currentLimit':
            $this->_currentLimit = round($val / 65.536) / 1000.0;
            return 1;
        case 'powerOutput':
            $this->_powerOutput = intval($val);
            return 1;
        case 'measuredVoltage':
            $this->_measuredVoltage = round($val / 65.536) / 1000.0;
            return 1;
        case 'measuredCurrent':
            $this->_measuredCurrent = round($val / 65.536) / 1000.0;
            return 1;
        case 'inputVoltage':
            $this->_inputVoltage = round($val / 65.536) / 1000.0;
            return 1;
        case 'voltageTransition':
            $this->_voltageTransition = $val;
            return 1;
        case 'voltageLimitAtStartUp':
            $this->_voltageLimitAtStartUp = round($val / 65.536) / 1000.0;
            return 1;
        case 'currentLimitAtStartUp':
            $this->_currentLimitAtStartUp = round($val / 65.536) / 1000.0;
            return 1;
        case 'powerOutputAtStartUp':
            $this->_powerOutputAtStartUp = intval($val);
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Changes the voltage limit, in V.
     *
     * @param float $newval : a floating point number corresponding to the voltage limit, in V
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_voltageLimit(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("voltageLimit", $rest_val);
    }

    /**
     * Returns the voltage limit, in V.
     *
     * @return float  a floating point number corresponding to the voltage limit, in V
     *
     * On failure, throws an exception or returns YPowerSupply::VOLTAGELIMIT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_voltageLimit(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::VOLTAGELIMIT_INVALID;
            }
        }
        $res = $this->_voltageLimit;
        return $res;
    }

    /**
     * Changes the current limit, in mA.
     *
     * @param float $newval : a floating point number corresponding to the current limit, in mA
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_currentLimit(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("currentLimit", $rest_val);
    }

    /**
     * Returns the current limit, in mA.
     *
     * @return float  a floating point number corresponding to the current limit, in mA
     *
     * On failure, throws an exception or returns YPowerSupply::CURRENTLIMIT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_currentLimit(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CURRENTLIMIT_INVALID;
            }
        }
        $res = $this->_currentLimit;
        return $res;
    }

    /**
     * Returns the power supply output switch state.
     *
     * @return int  either YPowerSupply::POWEROUTPUT_OFF or YPowerSupply::POWEROUTPUT_ON, according to the
     * power supply output switch state
     *
     * On failure, throws an exception or returns YPowerSupply::POWEROUTPUT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_powerOutput(): int
    {
        // $res                    is a enumONOFF;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::POWEROUTPUT_INVALID;
            }
        }
        $res = $this->_powerOutput;
        return $res;
    }

    /**
     * Changes the power supply output switch state.
     *
     * @param int $newval : either YPowerSupply::POWEROUTPUT_OFF or YPowerSupply::POWEROUTPUT_ON, according
     * to the power supply output switch state
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_powerOutput(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("powerOutput", $rest_val);
    }

    /**
     * Returns the measured output voltage, in V.
     *
     * @return float  a floating point number corresponding to the measured output voltage, in V
     *
     * On failure, throws an exception or returns YPowerSupply::MEASUREDVOLTAGE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_measuredVoltage(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::MEASUREDVOLTAGE_INVALID;
            }
        }
        $res = $this->_measuredVoltage;
        return $res;
    }

    /**
     * Returns the measured output current, in mA.
     *
     * @return float  a floating point number corresponding to the measured output current, in mA
     *
     * On failure, throws an exception or returns YPowerSupply::MEASUREDCURRENT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_measuredCurrent(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::MEASUREDCURRENT_INVALID;
            }
        }
        $res = $this->_measuredCurrent;
        return $res;
    }

    /**
     * Returns the measured input voltage, in V.
     *
     * @return float  a floating point number corresponding to the measured input voltage, in V
     *
     * On failure, throws an exception or returns YPowerSupply::INPUTVOLTAGE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_inputVoltage(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::INPUTVOLTAGE_INVALID;
            }
        }
        $res = $this->_inputVoltage;
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_voltageTransition(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::VOLTAGETRANSITION_INVALID;
            }
        }
        $res = $this->_voltageTransition;
        return $res;
    }

    /**
     * @throws YAPI_Exception
     */
    public function set_voltageTransition(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("voltageTransition", $rest_val);
    }

    /**
     * Changes the voltage set point at device start up. Remember to call the matching
     * module saveToFlash() method, otherwise this call has no effect.
     *
     * @param float $newval : a floating point number corresponding to the voltage set point at device start up
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_voltageLimitAtStartUp(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("voltageLimitAtStartUp", $rest_val);
    }

    /**
     * Returns the selected voltage limit at device startup, in V.
     *
     * @return float  a floating point number corresponding to the selected voltage limit at device startup, in V
     *
     * On failure, throws an exception or returns YPowerSupply::VOLTAGELIMITATSTARTUP_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_voltageLimitAtStartUp(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::VOLTAGELIMITATSTARTUP_INVALID;
            }
        }
        $res = $this->_voltageLimitAtStartUp;
        return $res;
    }

    /**
     * Changes the current limit at device start up. Remember to call the matching
     * module saveToFlash() method, otherwise this call has no effect.
     *
     * @param float $newval : a floating point number corresponding to the current limit at device start up
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_currentLimitAtStartUp(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("currentLimitAtStartUp", $rest_val);
    }

    /**
     * Returns the selected current limit at device startup, in mA.
     *
     * @return float  a floating point number corresponding to the selected current limit at device startup, in mA
     *
     * On failure, throws an exception or returns YPowerSupply::CURRENTLIMITATSTARTUP_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_currentLimitAtStartUp(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CURRENTLIMITATSTARTUP_INVALID;
            }
        }
        $res = $this->_currentLimitAtStartUp;
        return $res;
    }

    /**
     * Returns the power supply output switch state.
     *
     * @return int  either YPowerSupply::POWEROUTPUTATSTARTUP_OFF or YPowerSupply::POWEROUTPUTATSTARTUP_ON,
     * according to the power supply output switch state
     *
     * On failure, throws an exception or returns YPowerSupply::POWEROUTPUTATSTARTUP_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_powerOutputAtStartUp(): int
    {
        // $res                    is a enumONOFF;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::POWEROUTPUTATSTARTUP_INVALID;
            }
        }
        $res = $this->_powerOutputAtStartUp;
        return $res;
    }

    /**
     * Changes the power supply output switch state at device start up. Remember to call the matching
     * module saveToFlash() method, otherwise this call has no effect.
     *
     * @param int $newval : either YPowerSupply::POWEROUTPUTATSTARTUP_OFF or
     * YPowerSupply::POWEROUTPUTATSTARTUP_ON, according to the power supply output switch state at device start up
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_powerOutputAtStartUp(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("powerOutputAtStartUp", $rest_val);
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
     * Retrieves a regulated power supply for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the regulated power supply is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the regulated power supply is
     * indeed online at a given time. In case of ambiguity when looking for
     * a regulated power supply by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the regulated power supply, for instance
     *         MyDevice.powerSupply.
     *
     * @return YPowerSupply  a YPowerSupply object allowing you to drive the regulated power supply.
     */
    public static function FindPowerSupply(string $func): YPowerSupply
    {
        // $obj                    is a YPowerSupply;
        $obj = YFunction::_FindFromCache('PowerSupply', $func);
        if ($obj == null) {
            $obj = new YPowerSupply($func);
            YFunction::_AddToCache('PowerSupply', $func, $obj);
        }
        return $obj;
    }

    /**
     * Performs a smooth transition of output voltage. Any explicit voltage
     * change cancels any ongoing transition process.
     *
     * @param float $V_target   : new output voltage value at the end of the transition
     *         (floating-point number, representing the end voltage in V)
     * @param int $ms_duration : total duration of the transition, in milliseconds
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     */
    public function voltageMove(float $V_target, int $ms_duration): int
    {
        // $newval                 is a str;
        if ($V_target < 0.0) {
            $V_target  = 0.0;
        }
        $newval = sprintf('%d:%d', intval(round($V_target*65536)), $ms_duration);

        return $this->set_voltageTransition($newval);
    }

    /**
     * @throws YAPI_Exception
     */
    public function setVoltageLimit(float $newval): int
{
    return $this->set_voltageLimit($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function voltageLimit(): float
{
    return $this->get_voltageLimit();
}

    /**
     * @throws YAPI_Exception
     */
    public function setCurrentLimit(float $newval): int
{
    return $this->set_currentLimit($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function currentLimit(): float
{
    return $this->get_currentLimit();
}

    /**
     * @throws YAPI_Exception
     */
    public function powerOutput(): int
{
    return $this->get_powerOutput();
}

    /**
     * @throws YAPI_Exception
     */
    public function setPowerOutput(int $newval): int
{
    return $this->set_powerOutput($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function measuredVoltage(): float
{
    return $this->get_measuredVoltage();
}

    /**
     * @throws YAPI_Exception
     */
    public function measuredCurrent(): float
{
    return $this->get_measuredCurrent();
}

    /**
     * @throws YAPI_Exception
     */
    public function inputVoltage(): float
{
    return $this->get_inputVoltage();
}

    /**
     * @throws YAPI_Exception
     */
    public function voltageTransition(): string
{
    return $this->get_voltageTransition();
}

    /**
     * @throws YAPI_Exception
     */
    public function setVoltageTransition(string $newval): int
{
    return $this->set_voltageTransition($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function setVoltageLimitAtStartUp(float $newval): int
{
    return $this->set_voltageLimitAtStartUp($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function voltageLimitAtStartUp(): float
{
    return $this->get_voltageLimitAtStartUp();
}

    /**
     * @throws YAPI_Exception
     */
    public function setCurrentLimitAtStartUp(float $newval): int
{
    return $this->set_currentLimitAtStartUp($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function currentLimitAtStartUp(): float
{
    return $this->get_currentLimitAtStartUp();
}

    /**
     * @throws YAPI_Exception
     */
    public function powerOutputAtStartUp(): int
{
    return $this->get_powerOutputAtStartUp();
}

    /**
     * @throws YAPI_Exception
     */
    public function setPowerOutputAtStartUp(int $newval): int
{
    return $this->set_powerOutputAtStartUp($newval);
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
     * Continues the enumeration of regulated power supplies started using yFirstPowerSupply().
     * Caution: You can't make any assumption about the returned regulated power supplies order.
     * If you want to find a specific a regulated power supply, use PowerSupply.findPowerSupply()
     * and a hardwareID or a logical name.
     *
     * @return ?YPowerSupply  a pointer to a YPowerSupply object, corresponding to
     *         a regulated power supply currently online, or a null pointer
     *         if there are no more regulated power supplies to enumerate.
     */
    public function nextPowerSupply(): ?YPowerSupply
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindPowerSupply($next_hwid);
    }

    /**
     * Starts the enumeration of regulated power supplies currently accessible.
     * Use the method YPowerSupply::nextPowerSupply() to iterate on
     * next regulated power supplies.
     *
     * @return ?YPowerSupply  a pointer to a YPowerSupply object, corresponding to
     *         the first regulated power supply currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstPowerSupply(): ?YPowerSupply
    {
        $next_hwid = YAPI::getFirstHardwareId('PowerSupply');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindPowerSupply($next_hwid);
    }

    //--- (end of YPowerSupply implementation)

}
