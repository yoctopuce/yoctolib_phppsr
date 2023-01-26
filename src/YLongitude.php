<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YLongitude Class: longitude sensor control interface, available for instance in the Yocto-GPS-V2
 *
 * The YLongitude class allows you to read and configure Yoctopuce longitude sensors.
 * It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, and to access the autonomous datalogger.
 */
class YLongitude extends YSensor
{
    //--- (end of YLongitude declaration)

    //--- (YLongitude attributes)

    //--- (end of YLongitude attributes)

    function __construct($str_func)
    {
        //--- (YLongitude constructor)
        parent::__construct($str_func);
        $this->_className = 'Longitude';

        //--- (end of YLongitude constructor)
    }

    //--- (YLongitude implementation)

    /**
     * Retrieves a longitude sensor for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the longitude sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the longitude sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a longitude sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the longitude sensor, for instance
     *         YGNSSMK2.longitude.
     *
     * @return YLongitude  a YLongitude object allowing you to drive the longitude sensor.
     */
    public static function FindLongitude(string $func): ?YLongitude
    {
        // $obj                    is a YLongitude;
        $obj = YFunction::_FindFromCache('Longitude', $func);
        if ($obj == null) {
            $obj = new YLongitude($func);
            YFunction::_AddToCache('Longitude', $func, $obj);
        }
        return $obj;
    }

    /**
     * Continues the enumeration of longitude sensors started using yFirstLongitude().
     * Caution: You can't make any assumption about the returned longitude sensors order.
     * If you want to find a specific a longitude sensor, use Longitude.findLongitude()
     * and a hardwareID or a logical name.
     *
     * @return YLongitude  a pointer to a YLongitude object, corresponding to
     *         a longitude sensor currently online, or a null pointer
     *         if there are no more longitude sensors to enumerate.
     */
    public function nextLongitude(): ?YLongitude
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindLongitude($next_hwid);
    }

    /**
     * Starts the enumeration of longitude sensors currently accessible.
     * Use the method YLongitude::nextLongitude() to iterate on
     * next longitude sensors.
     *
     * @return YLongitude  a pointer to a YLongitude object, corresponding to
     *         the first longitude sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstLongitude()
    {
        $next_hwid = YAPI::getFirstHardwareId('Longitude');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindLongitude($next_hwid);
    }

    //--- (end of YLongitude implementation)

}
