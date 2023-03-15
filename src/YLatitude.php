<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YLatitude Class: latitude sensor control interface, available for instance in the Yocto-GPS-V2
 *
 * The YLatitude class allows you to read and configure Yoctopuce latitude sensors.
 * It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, and to access the autonomous datalogger.
 */
class YLatitude extends YSensor
{
    //--- (end of YLatitude declaration)

    //--- (YLatitude attributes)

    //--- (end of YLatitude attributes)

    function __construct(string $str_func)
    {
        //--- (YLatitude constructor)
        parent::__construct($str_func);
        $this->_className = 'Latitude';

        //--- (end of YLatitude constructor)
    }

    //--- (YLatitude implementation)

    /**
     * Retrieves a latitude sensor for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the latitude sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the latitude sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a latitude sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the latitude sensor, for instance
     *         YGNSSMK2.latitude.
     *
     * @return YLatitude  a YLatitude object allowing you to drive the latitude sensor.
     */
    public static function FindLatitude(string $func): YLatitude
    {
        // $obj                    is a YLatitude;
        $obj = YFunction::_FindFromCache('Latitude', $func);
        if ($obj == null) {
            $obj = new YLatitude($func);
            YFunction::_AddToCache('Latitude', $func, $obj);
        }
        return $obj;
    }

    /**
     * Continues the enumeration of latitude sensors started using yFirstLatitude().
     * Caution: You can't make any assumption about the returned latitude sensors order.
     * If you want to find a specific a latitude sensor, use Latitude.findLatitude()
     * and a hardwareID or a logical name.
     *
     * @return ?YLatitude  a pointer to a YLatitude object, corresponding to
     *         a latitude sensor currently online, or a null pointer
     *         if there are no more latitude sensors to enumerate.
     */
    public function nextLatitude(): ?YLatitude
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindLatitude($next_hwid);
    }

    /**
     * Starts the enumeration of latitude sensors currently accessible.
     * Use the method YLatitude::nextLatitude() to iterate on
     * next latitude sensors.
     *
     * @return ?YLatitude  a pointer to a YLatitude object, corresponding to
     *         the first latitude sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstLatitude(): ?YLatitude
    {
        $next_hwid = YAPI::getFirstHardwareId('Latitude');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindLatitude($next_hwid);
    }

    //--- (end of YLatitude implementation)

}
