<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YOsControl Class: Operating system control interface via the VirtualHub application
 *
 * The YOScontrol class provides some control over the operating system running a VirtualHub.
 * YOsControl is available on VirtualHub software only. This feature must be activated at the VirtualHub
 * start up with -o option.
 */
class YOsControl extends YFunction
{
    const SHUTDOWNCOUNTDOWN_INVALID = YAPI::INVALID_UINT;
    //--- (end of YOsControl declaration)

    //--- (YOsControl attributes)
    protected int $_shutdownCountdown = self::SHUTDOWNCOUNTDOWN_INVALID; // UInt31

    //--- (end of YOsControl attributes)

    function __construct($str_func)
    {
        //--- (YOsControl constructor)
        parent::__construct($str_func);
        $this->_className = 'OsControl';

        //--- (end of YOsControl constructor)
    }

    //--- (YOsControl implementation)

    function _parseAttr($name, $val): int
    {
        switch ($name) {
        case 'shutdownCountdown':
            $this->_shutdownCountdown = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the remaining number of seconds before the OS shutdown, or zero when no
     * shutdown has been scheduled.
     *
     * @return int  an integer corresponding to the remaining number of seconds before the OS shutdown, or zero when no
     *         shutdown has been scheduled
     *
     * On failure, throws an exception or returns YOsControl::SHUTDOWNCOUNTDOWN_INVALID.
     */
    public function get_shutdownCountdown(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SHUTDOWNCOUNTDOWN_INVALID;
            }
        }
        $res = $this->_shutdownCountdown;
        return $res;
    }

    public function set_shutdownCountdown(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("shutdownCountdown", $rest_val);
    }

    /**
     * Retrieves OS control for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the OS control is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the OS control is
     * indeed online at a given time. In case of ambiguity when looking for
     * OS control by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the OS control, for instance
     *         MyDevice.osControl.
     *
     * @return YOsControl  a YOsControl object allowing you to drive the OS control.
     */
    public static function FindOsControl(string $func): ?YOsControl
    {
        // $obj                    is a YOsControl;
        $obj = YFunction::_FindFromCache('OsControl', $func);
        if ($obj == null) {
            $obj = new YOsControl($func);
            YFunction::_AddToCache('OsControl', $func, $obj);
        }
        return $obj;
    }

    /**
     * Schedules an OS shutdown after a given number of seconds.
     *
     * @param int $secBeforeShutDown : number of seconds before shutdown
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function shutdown(int $secBeforeShutDown): int
    {
        return $this->set_shutdownCountdown($secBeforeShutDown);
    }

    public function shutdownCountdown(): int
{
    return $this->get_shutdownCountdown();
}

    public function setShutdownCountdown(int $newval)
{
    return $this->set_shutdownCountdown($newval);
}

    /**
     * Continues the enumeration of OS control started using yFirstOsControl().
     * Caution: You can't make any assumption about the returned OS control order.
     * If you want to find a specific OS control, use OsControl.findOsControl()
     * and a hardwareID or a logical name.
     *
     * @return YOsControl  a pointer to a YOsControl object, corresponding to
     *         OS control currently online, or a null pointer
     *         if there are no more OS control to enumerate.
     */
    public function nextOsControl(): ?YOsControl
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindOsControl($next_hwid);
    }

    /**
     * Starts the enumeration of OS control currently accessible.
     * Use the method YOsControl::nextOsControl() to iterate on
     * next OS control.
     *
     * @return YOsControl  a pointer to a YOsControl object, corresponding to
     *         the first OS control currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstOsControl()
    {
        $next_hwid = YAPI::getFirstHardwareId('OsControl');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindOsControl($next_hwid);
    }

    //--- (end of YOsControl implementation)

}
