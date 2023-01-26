<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YVoltage Class: voltage sensor control interface, available for instance in the Yocto-Motor-DC, the
 * Yocto-Volt or the Yocto-Watt
 *
 * The YVoltage class allows you to read and configure Yoctopuce voltage sensors.
 * It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, and to access the autonomous datalogger.
 */
class YVoltage extends YSensor
{
    const ENABLED_FALSE = 0;
    const ENABLED_TRUE = 1;
    const ENABLED_INVALID = -1;
    //--- (end of YVoltage declaration)

    //--- (YVoltage attributes)
    protected int $_enabled = self::ENABLED_INVALID;        // Bool

    //--- (end of YVoltage attributes)

    function __construct($str_func)
    {
        //--- (YVoltage constructor)
        parent::__construct($str_func);
        $this->_className = 'Voltage';

        //--- (end of YVoltage constructor)
    }

    //--- (YVoltage implementation)

    function _parseAttr($name, $val): int
    {
        switch ($name) {
        case 'enabled':
            $this->_enabled = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the activation state of this input.
     *
     * @return int  either YVoltage::ENABLED_FALSE or YVoltage::ENABLED_TRUE, according to the activation
     * state of this input
     *
     * On failure, throws an exception or returns YVoltage::ENABLED_INVALID.
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
     * Changes the activation state of this voltage input. When AC measurements are disabled,
     * the device will always assume a DC signal, and vice-versa. When both AC and DC measurements
     * are active, the device switches between AC and DC mode based on the relative amplitude
     * of variations compared to the average value.
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param int $newval : either YVoltage::ENABLED_FALSE or YVoltage::ENABLED_TRUE, according to the
     * activation state of this voltage input
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_enabled(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("enabled", $rest_val);
    }

    /**
     * Retrieves a voltage sensor for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the voltage sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the voltage sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a voltage sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the voltage sensor, for instance
     *         MOTORCTL.voltage.
     *
     * @return YVoltage  a YVoltage object allowing you to drive the voltage sensor.
     */
    public static function FindVoltage(string $func): ?YVoltage
    {
        // $obj                    is a YVoltage;
        $obj = YFunction::_FindFromCache('Voltage', $func);
        if ($obj == null) {
            $obj = new YVoltage($func);
            YFunction::_AddToCache('Voltage', $func, $obj);
        }
        return $obj;
    }

    public function enabled(): int
{
    return $this->get_enabled();
}

    public function setEnabled(int $newval)
{
    return $this->set_enabled($newval);
}

    /**
     * Continues the enumeration of voltage sensors started using yFirstVoltage().
     * Caution: You can't make any assumption about the returned voltage sensors order.
     * If you want to find a specific a voltage sensor, use Voltage.findVoltage()
     * and a hardwareID or a logical name.
     *
     * @return YVoltage  a pointer to a YVoltage object, corresponding to
     *         a voltage sensor currently online, or a null pointer
     *         if there are no more voltage sensors to enumerate.
     */
    public function nextVoltage(): ?YVoltage
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindVoltage($next_hwid);
    }

    /**
     * Starts the enumeration of voltage sensors currently accessible.
     * Use the method YVoltage::nextVoltage() to iterate on
     * next voltage sensors.
     *
     * @return YVoltage  a pointer to a YVoltage object, corresponding to
     *         the first voltage sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstVoltage()
    {
        $next_hwid = YAPI::getFirstHardwareId('Voltage');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindVoltage($next_hwid);
    }

    //--- (end of YVoltage implementation)

}
