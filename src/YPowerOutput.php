<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YPowerOutput Class: power output control interface, available for instance in the Yocto-I2C, the
 * Yocto-MaxiMicroVolt-Rx, the Yocto-SPI or the Yocto-Serial
 *
 * The YPowerOutput class allows you to control
 * the power output featured on some Yoctopuce devices.
 */
class YPowerOutput extends YFunction
{
    const VOLTAGE_OFF = 0;
    const VOLTAGE_OUT3V3 = 1;
    const VOLTAGE_OUT5V = 2;
    const VOLTAGE_OUT4V7 = 3;
    const VOLTAGE_OUT1V8 = 4;
    const VOLTAGE_INVALID = -1;
    //--- (end of YPowerOutput declaration)

    //--- (YPowerOutput attributes)
    protected int $_voltage = self::VOLTAGE_INVALID;        // PowerOuputVoltage

    //--- (end of YPowerOutput attributes)

    function __construct($str_func)
    {
        //--- (YPowerOutput constructor)
        parent::__construct($str_func);
        $this->_className = 'PowerOutput';

        //--- (end of YPowerOutput constructor)
    }

    //--- (YPowerOutput implementation)

    function _parseAttr($name, $val): int
    {
        switch ($name) {
        case 'voltage':
            $this->_voltage = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the voltage on the power output featured by the module.
     *
     * @return int  a value among YPowerOutput::VOLTAGE_OFF, YPowerOutput::VOLTAGE_OUT3V3,
     * YPowerOutput::VOLTAGE_OUT5V, YPowerOutput::VOLTAGE_OUT4V7 and YPowerOutput::VOLTAGE_OUT1V8
     * corresponding to the voltage on the power output featured by the module
     *
     * On failure, throws an exception or returns YPowerOutput::VOLTAGE_INVALID.
     */
    public function get_voltage(): int
    {
        // $res                    is a enumPOWEROUPUTVOLTAGE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::VOLTAGE_INVALID;
            }
        }
        $res = $this->_voltage;
        return $res;
    }

    /**
     * Changes the voltage on the power output provided by the
     * module. Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param int $newval : a value among YPowerOutput::VOLTAGE_OFF, YPowerOutput::VOLTAGE_OUT3V3,
     * YPowerOutput::VOLTAGE_OUT5V, YPowerOutput::VOLTAGE_OUT4V7 and YPowerOutput::VOLTAGE_OUT1V8
     * corresponding to the voltage on the power output provided by the
     *         module
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_voltage(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("voltage", $rest_val);
    }

    /**
     * Retrieves a power output for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the power output is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the power output is
     * indeed online at a given time. In case of ambiguity when looking for
     * a power output by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the power output, for instance
     *         YI2CMK01.powerOutput.
     *
     * @return YPowerOutput  a YPowerOutput object allowing you to drive the power output.
     */
    public static function FindPowerOutput(string $func): ?YPowerOutput
    {
        // $obj                    is a YPowerOutput;
        $obj = YFunction::_FindFromCache('PowerOutput', $func);
        if ($obj == null) {
            $obj = new YPowerOutput($func);
            YFunction::_AddToCache('PowerOutput', $func, $obj);
        }
        return $obj;
    }

    public function voltage(): int
{
    return $this->get_voltage();
}

    public function setVoltage(int $newval)
{
    return $this->set_voltage($newval);
}

    /**
     * Continues the enumeration of power output started using yFirstPowerOutput().
     * Caution: You can't make any assumption about the returned power output order.
     * If you want to find a specific a power output, use PowerOutput.findPowerOutput()
     * and a hardwareID or a logical name.
     *
     * @return YPowerOutput  a pointer to a YPowerOutput object, corresponding to
     *         a power output currently online, or a null pointer
     *         if there are no more power output to enumerate.
     */
    public function nextPowerOutput(): ?YPowerOutput
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindPowerOutput($next_hwid);
    }

    /**
     * Starts the enumeration of power output currently accessible.
     * Use the method YPowerOutput::nextPowerOutput() to iterate on
     * next power output.
     *
     * @return YPowerOutput  a pointer to a YPowerOutput object, corresponding to
     *         the first power output currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstPowerOutput()
    {
        $next_hwid = YAPI::getFirstHardwareId('PowerOutput');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindPowerOutput($next_hwid);
    }

    //--- (end of YPowerOutput implementation)

}
