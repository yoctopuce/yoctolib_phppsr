<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YPressure Class: pressure sensor control interface, available for instance in the
 * Yocto-Altimeter-V2, the Yocto-CO2-V2, the Yocto-Meteo-V2 or the Yocto-Pressure
 *
 * The YPressure class allows you to read and configure Yoctopuce pressure sensors.
 * It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, and to access the autonomous datalogger.
 */
class YPressure extends YSensor
{
    //--- (end of YPressure declaration)

    //--- (YPressure attributes)

    //--- (end of YPressure attributes)

    function __construct(string $str_func)
    {
        //--- (YPressure constructor)
        parent::__construct($str_func);
        $this->_className = 'Pressure';

        //--- (end of YPressure constructor)
    }

    //--- (YPressure implementation)

    /**
     * Retrieves a pressure sensor for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the pressure sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the pressure sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a pressure sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the pressure sensor, for instance
     *         YALTIMK2.pressure.
     *
     * @return YPressure  a YPressure object allowing you to drive the pressure sensor.
     */
    public static function FindPressure(string $func): YPressure
    {
        // $obj                    is a YPressure;
        $obj = YFunction::_FindFromCache('Pressure', $func);
        if ($obj == null) {
            $obj = new YPressure($func);
            YFunction::_AddToCache('Pressure', $func, $obj);
        }
        return $obj;
    }

    /**
     * Continues the enumeration of pressure sensors started using yFirstPressure().
     * Caution: You can't make any assumption about the returned pressure sensors order.
     * If you want to find a specific a pressure sensor, use Pressure.findPressure()
     * and a hardwareID or a logical name.
     *
     * @return ?YPressure  a pointer to a YPressure object, corresponding to
     *         a pressure sensor currently online, or a null pointer
     *         if there are no more pressure sensors to enumerate.
     */
    public function nextPressure(): ?YPressure
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindPressure($next_hwid);
    }

    /**
     * Starts the enumeration of pressure sensors currently accessible.
     * Use the method YPressure::nextPressure() to iterate on
     * next pressure sensors.
     *
     * @return ?YPressure  a pointer to a YPressure object, corresponding to
     *         the first pressure sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstPressure(): ?YPressure
    {
        $next_hwid = YAPI::getFirstHardwareId('Pressure');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindPressure($next_hwid);
    }

    //--- (end of YPressure implementation)

}
