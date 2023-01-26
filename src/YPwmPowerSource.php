<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YPwmPowerSource Class: PWM generator power source control interface, available for instance in the Yocto-PWM-Tx
 *
 * The YPwmPowerSource class allows you to configure
 * the voltage source used by all PWM outputs on the same device.
 */
class YPwmPowerSource extends YFunction
{
    const POWERMODE_USB_5V = 0;
    const POWERMODE_USB_3V = 1;
    const POWERMODE_EXT_V = 2;
    const POWERMODE_OPNDRN = 3;
    const POWERMODE_INVALID = -1;
    //--- (end of YPwmPowerSource declaration)

    //--- (YPwmPowerSource attributes)
    protected int $_powerMode = self::POWERMODE_INVALID;      // PwmPwrState

    //--- (end of YPwmPowerSource attributes)

    function __construct($str_func)
    {
        //--- (YPwmPowerSource constructor)
        parent::__construct($str_func);
        $this->_className = 'PwmPowerSource';

        //--- (end of YPwmPowerSource constructor)
    }

    //--- (YPwmPowerSource implementation)

    function _parseAttr($name, $val): int
    {
        switch ($name) {
        case 'powerMode':
            $this->_powerMode = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the selected power source for the PWM on the same device.
     *
     * @return int  a value among YPwmPowerSource::POWERMODE_USB_5V, YPwmPowerSource::POWERMODE_USB_3V,
     * YPwmPowerSource::POWERMODE_EXT_V and YPwmPowerSource::POWERMODE_OPNDRN corresponding to the selected
     * power source for the PWM on the same device
     *
     * On failure, throws an exception or returns YPwmPowerSource::POWERMODE_INVALID.
     */
    public function get_powerMode(): int
    {
        // $res                    is a enumPWMPWRMODE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::POWERMODE_INVALID;
            }
        }
        $res = $this->_powerMode;
        return $res;
    }

    /**
     * Changes  the PWM power source. PWM can use isolated 5V from USB, isolated 3V from USB or
     * voltage from an external power source. The PWM can also work in open drain  mode. In that
     * mode, the PWM actively pulls the line down.
     * Warning: this setting is common to all PWM on the same device. If you change that parameter,
     * all PWM located on the same device are  affected.
     * If you want the change to be kept after a device reboot, make sure  to call the matching
     * module saveToFlash().
     *
     * @param int $newval : a value among YPwmPowerSource::POWERMODE_USB_5V,
     * YPwmPowerSource::POWERMODE_USB_3V, YPwmPowerSource::POWERMODE_EXT_V and
     * YPwmPowerSource::POWERMODE_OPNDRN corresponding to  the PWM power source
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_powerMode(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("powerMode", $rest_val);
    }

    /**
     * Retrieves a PWM generator power source for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the PWM generator power source is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the PWM generator power source is
     * indeed online at a given time. In case of ambiguity when looking for
     * a PWM generator power source by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the PWM generator power source, for instance
     *         YPWMTX01.pwmPowerSource.
     *
     * @return YPwmPowerSource  a YPwmPowerSource object allowing you to drive the PWM generator power source.
     */
    public static function FindPwmPowerSource(string $func): ?YPwmPowerSource
    {
        // $obj                    is a YPwmPowerSource;
        $obj = YFunction::_FindFromCache('PwmPowerSource', $func);
        if ($obj == null) {
            $obj = new YPwmPowerSource($func);
            YFunction::_AddToCache('PwmPowerSource', $func, $obj);
        }
        return $obj;
    }

    public function powerMode(): int
{
    return $this->get_powerMode();
}

    public function setPowerMode(int $newval)
{
    return $this->set_powerMode($newval);
}

    /**
     * Continues the enumeration of PWM generator power sources started using yFirstPwmPowerSource().
     * Caution: You can't make any assumption about the returned PWM generator power sources order.
     * If you want to find a specific a PWM generator power source, use PwmPowerSource.findPwmPowerSource()
     * and a hardwareID or a logical name.
     *
     * @return YPwmPowerSource  a pointer to a YPwmPowerSource object, corresponding to
     *         a PWM generator power source currently online, or a null pointer
     *         if there are no more PWM generator power sources to enumerate.
     */
    public function nextPwmPowerSource(): ?YPwmPowerSource
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindPwmPowerSource($next_hwid);
    }

    /**
     * Starts the enumeration of PWM generator power sources currently accessible.
     * Use the method YPwmPowerSource::nextPwmPowerSource() to iterate on
     * next PWM generator power sources.
     *
     * @return YPwmPowerSource  a pointer to a YPwmPowerSource object, corresponding to
     *         the first PWM generator power source currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstPwmPowerSource()
    {
        $next_hwid = YAPI::getFirstHardwareId('PwmPowerSource');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindPwmPowerSource($next_hwid);
    }

    //--- (end of YPwmPowerSource implementation)

}
