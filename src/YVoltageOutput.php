<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YVoltageOutput Class: voltage output control interface, available for instance in the Yocto-0-10V-Tx
 *
 * The YVoltageOutput class allows you to drive a voltage output.
 */
class YVoltageOutput extends YFunction
{
    const CURRENTVOLTAGE_INVALID = YAPI::INVALID_DOUBLE;
    const VOLTAGETRANSITION_INVALID = YAPI::INVALID_STRING;
    const VOLTAGEATSTARTUP_INVALID = YAPI::INVALID_DOUBLE;
    //--- (end of YVoltageOutput declaration)

    //--- (YVoltageOutput attributes)
    protected float $_currentVoltage = self::CURRENTVOLTAGE_INVALID; // MeasureVal
    protected string $_voltageTransition = self::VOLTAGETRANSITION_INVALID; // AnyFloatTransition
    protected float $_voltageAtStartUp = self::VOLTAGEATSTARTUP_INVALID; // MeasureVal

    //--- (end of YVoltageOutput attributes)

    function __construct(string $str_func)
    {
        //--- (YVoltageOutput constructor)
        parent::__construct($str_func);
        $this->_className = 'VoltageOutput';

        //--- (end of YVoltageOutput constructor)
    }

    //--- (YVoltageOutput implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'currentVoltage':
            $this->_currentVoltage = round($val / 65.536) / 1000.0;
            return 1;
        case 'voltageTransition':
            $this->_voltageTransition = $val;
            return 1;
        case 'voltageAtStartUp':
            $this->_voltageAtStartUp = round($val / 65.536) / 1000.0;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Changes the output voltage, in V. Valid range is from 0 to 10V.
     *
     * @param float $newval : a floating point number corresponding to the output voltage, in V
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_currentVoltage(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("currentVoltage", $rest_val);
    }

    /**
     * Returns the output voltage set point, in V.
     *
     * @return float  a floating point number corresponding to the output voltage set point, in V
     *
     * On failure, throws an exception or returns YVoltageOutput::CURRENTVOLTAGE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_currentVoltage(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CURRENTVOLTAGE_INVALID;
            }
        }
        $res = $this->_currentVoltage;
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
     * Changes the output voltage at device start up. Remember to call the matching
     * module saveToFlash() method, otherwise this call has no effect.
     *
     * @param float $newval : a floating point number corresponding to the output voltage at device start up
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_voltageAtStartUp(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("voltageAtStartUp", $rest_val);
    }

    /**
     * Returns the selected voltage output at device startup, in V.
     *
     * @return float  a floating point number corresponding to the selected voltage output at device startup, in V
     *
     * On failure, throws an exception or returns YVoltageOutput::VOLTAGEATSTARTUP_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_voltageAtStartUp(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::VOLTAGEATSTARTUP_INVALID;
            }
        }
        $res = $this->_voltageAtStartUp;
        return $res;
    }

    /**
     * Retrieves a voltage output for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the voltage output is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the voltage output is
     * indeed online at a given time. In case of ambiguity when looking for
     * a voltage output by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the voltage output, for instance
     *         TX010V01.voltageOutput1.
     *
     * @return YVoltageOutput  a YVoltageOutput object allowing you to drive the voltage output.
     */
    public static function FindVoltageOutput(string $func): YVoltageOutput
    {
        // $obj                    is a YVoltageOutput;
        $obj = YFunction::_FindFromCache('VoltageOutput', $func);
        if ($obj == null) {
            $obj = new YVoltageOutput($func);
            YFunction::_AddToCache('VoltageOutput', $func, $obj);
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
        if ($V_target > 10.0) {
            $V_target = 10.0;
        }
        $newval = sprintf('%d:%d', intval(round($V_target*65536)), $ms_duration);

        return $this->set_voltageTransition($newval);
    }

    /**
     * @throws YAPI_Exception
     */
    public function setCurrentVoltage(float $newval): int
{
    return $this->set_currentVoltage($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function currentVoltage(): float
{
    return $this->get_currentVoltage();
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
    public function setVoltageAtStartUp(float $newval): int
{
    return $this->set_voltageAtStartUp($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function voltageAtStartUp(): float
{
    return $this->get_voltageAtStartUp();
}

    /**
     * Continues the enumeration of voltage outputs started using yFirstVoltageOutput().
     * Caution: You can't make any assumption about the returned voltage outputs order.
     * If you want to find a specific a voltage output, use VoltageOutput.findVoltageOutput()
     * and a hardwareID or a logical name.
     *
     * @return ?YVoltageOutput  a pointer to a YVoltageOutput object, corresponding to
     *         a voltage output currently online, or a null pointer
     *         if there are no more voltage outputs to enumerate.
     */
    public function nextVoltageOutput(): ?YVoltageOutput
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindVoltageOutput($next_hwid);
    }

    /**
     * Starts the enumeration of voltage outputs currently accessible.
     * Use the method YVoltageOutput::nextVoltageOutput() to iterate on
     * next voltage outputs.
     *
     * @return ?YVoltageOutput  a pointer to a YVoltageOutput object, corresponding to
     *         the first voltage output currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstVoltageOutput(): ?YVoltageOutput
    {
        $next_hwid = YAPI::getFirstHardwareId('VoltageOutput');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindVoltageOutput($next_hwid);
    }

    //--- (end of YVoltageOutput implementation)

}
