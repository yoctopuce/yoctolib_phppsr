<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YGroundSpeed Class: ground speed sensor control interface, available for instance in the Yocto-GPS-V2
 *
 * The YGroundSpeed class allows you to read and configure Yoctopuce ground speed sensors.
 * It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, and to access the autonomous datalogger.
 */
class YGroundSpeed extends YSensor
{
    //--- (end of YGroundSpeed declaration)

    //--- (YGroundSpeed attributes)

    //--- (end of YGroundSpeed attributes)

    function __construct(string $str_func)
    {
        //--- (YGroundSpeed constructor)
        parent::__construct($str_func);
        $this->_className = 'GroundSpeed';

        //--- (end of YGroundSpeed constructor)
    }

    //--- (YGroundSpeed implementation)

    /**
     * Retrieves a ground speed sensor for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the ground speed sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the ground speed sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a ground speed sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the ground speed sensor, for instance
     *         YGNSSMK2.groundSpeed.
     *
     * @return YGroundSpeed  a YGroundSpeed object allowing you to drive the ground speed sensor.
     */
    public static function FindGroundSpeed(string $func): YGroundSpeed
    {
        // $obj                    is a YGroundSpeed;
        $obj = YFunction::_FindFromCache('GroundSpeed', $func);
        if ($obj == null) {
            $obj = new YGroundSpeed($func);
            YFunction::_AddToCache('GroundSpeed', $func, $obj);
        }
        return $obj;
    }

    /**
     * Continues the enumeration of ground speed sensors started using yFirstGroundSpeed().
     * Caution: You can't make any assumption about the returned ground speed sensors order.
     * If you want to find a specific a ground speed sensor, use GroundSpeed.findGroundSpeed()
     * and a hardwareID or a logical name.
     *
     * @return ?YGroundSpeed  a pointer to a YGroundSpeed object, corresponding to
     *         a ground speed sensor currently online, or a null pointer
     *         if there are no more ground speed sensors to enumerate.
     */
    public function nextGroundSpeed(): ?YGroundSpeed
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindGroundSpeed($next_hwid);
    }

    /**
     * Starts the enumeration of ground speed sensors currently accessible.
     * Use the method YGroundSpeed::nextGroundSpeed() to iterate on
     * next ground speed sensors.
     *
     * @return ?YGroundSpeed  a pointer to a YGroundSpeed object, corresponding to
     *         the first ground speed sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstGroundSpeed(): ?YGroundSpeed
    {
        $next_hwid = YAPI::getFirstHardwareId('GroundSpeed');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindGroundSpeed($next_hwid);
    }

    //--- (end of YGroundSpeed implementation)

}
