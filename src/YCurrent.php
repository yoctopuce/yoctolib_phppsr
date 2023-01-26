<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YCurrent Class: current sensor control interface, available for instance in the Yocto-Amp, the
 * Yocto-Motor-DC or the Yocto-Watt
 *
 * The YCurrent class allows you to read and configure Yoctopuce current sensors.
 * It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, and to access the autonomous datalogger.
 */
class YCurrent extends YSensor
{
    const ENABLED_FALSE = 0;
    const ENABLED_TRUE = 1;
    const ENABLED_INVALID = -1;
    //--- (end of YCurrent declaration)

    //--- (YCurrent attributes)
    protected int $_enabled = self::ENABLED_INVALID;        // Bool

    //--- (end of YCurrent attributes)

    function __construct($str_func)
    {
        //--- (YCurrent constructor)
        parent::__construct($str_func);
        $this->_className = 'Current';

        //--- (end of YCurrent constructor)
    }

    //--- (YCurrent implementation)

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
     * @return int  either YCurrent::ENABLED_FALSE or YCurrent::ENABLED_TRUE, according to the activation
     * state of this input
     *
     * On failure, throws an exception or returns YCurrent::ENABLED_INVALID.
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
     * @param int $newval : either YCurrent::ENABLED_FALSE or YCurrent::ENABLED_TRUE, according to the
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
     * Retrieves a current sensor for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the current sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the current sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a current sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the current sensor, for instance
     *         YAMPMK01.current1.
     *
     * @return YCurrent  a YCurrent object allowing you to drive the current sensor.
     */
    public static function FindCurrent(string $func): ?YCurrent
    {
        // $obj                    is a YCurrent;
        $obj = YFunction::_FindFromCache('Current', $func);
        if ($obj == null) {
            $obj = new YCurrent($func);
            YFunction::_AddToCache('Current', $func, $obj);
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
     * Continues the enumeration of current sensors started using yFirstCurrent().
     * Caution: You can't make any assumption about the returned current sensors order.
     * If you want to find a specific a current sensor, use Current.findCurrent()
     * and a hardwareID or a logical name.
     *
     * @return YCurrent  a pointer to a YCurrent object, corresponding to
     *         a current sensor currently online, or a null pointer
     *         if there are no more current sensors to enumerate.
     */
    public function nextCurrent(): ?YCurrent
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindCurrent($next_hwid);
    }

    /**
     * Starts the enumeration of current sensors currently accessible.
     * Use the method YCurrent::nextCurrent() to iterate on
     * next current sensors.
     *
     * @return YCurrent  a pointer to a YCurrent object, corresponding to
     *         the first current sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstCurrent()
    {
        $next_hwid = YAPI::getFirstHardwareId('Current');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindCurrent($next_hwid);
    }

    //--- (end of YCurrent implementation)

}
