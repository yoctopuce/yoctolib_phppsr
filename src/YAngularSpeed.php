<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YAngularSpeed Class: tachometer control interface
 *
 * The YAngularSpeed class allows you to read and configure Yoctopuce tachometers.
 * It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, and to access the autonomous datalogger.
 */
class YAngularSpeed extends YSensor
{
    //--- (end of YAngularSpeed declaration)

    //--- (YAngularSpeed attributes)

    //--- (end of YAngularSpeed attributes)

    function __construct(string $str_func)
    {
        //--- (YAngularSpeed constructor)
        parent::__construct($str_func);
        $this->_className = 'AngularSpeed';

        //--- (end of YAngularSpeed constructor)
    }

    //--- (YAngularSpeed implementation)

    /**
     * Retrieves a tachometer for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the rtachometer is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the rtachometer is
     * indeed online at a given time. In case of ambiguity when looking for
     * a tachometer by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the rtachometer, for instance
     *         MyDevice.angularSpeed.
     *
     * @return YAngularSpeed  a YAngularSpeed object allowing you to drive the rtachometer.
     */
    public static function FindAngularSpeed(string $func): YAngularSpeed
    {
        // $obj                    is a YAngularSpeed;
        $obj = YFunction::_FindFromCache('AngularSpeed', $func);
        if ($obj == null) {
            $obj = new YAngularSpeed($func);
            YFunction::_AddToCache('AngularSpeed', $func, $obj);
        }
        return $obj;
    }

    /**
     * Continues the enumeration of tachometers started using yFirstAngularSpeed().
     * Caution: You can't make any assumption about the returned tachometers order.
     * If you want to find a specific a tachometer, use AngularSpeed.findAngularSpeed()
     * and a hardwareID or a logical name.
     *
     * @return ?YAngularSpeed  a pointer to a YAngularSpeed object, corresponding to
     *         a tachometer currently online, or a null pointer
     *         if there are no more tachometers to enumerate.
     */
    public function nextAngularSpeed(): ?YAngularSpeed
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindAngularSpeed($next_hwid);
    }

    /**
     * Starts the enumeration of tachometers currently accessible.
     * Use the method YAngularSpeed::nextAngularSpeed() to iterate on
     * next tachometers.
     *
     * @return ?YAngularSpeed  a pointer to a YAngularSpeed object, corresponding to
     *         the first tachometer currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstAngularSpeed(): ?YAngularSpeed
    {
        $next_hwid = YAPI::getFirstHardwareId('AngularSpeed');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindAngularSpeed($next_hwid);
    }

    //--- (end of YAngularSpeed implementation)

}
