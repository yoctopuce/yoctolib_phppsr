<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YTvoc Class: Total Volatile Organic Compound sensor control interface, available for instance in
 * the Yocto-VOC-V3
 *
 * The YTvoc class allows you to read and configure Yoctopuce Total Volatile Organic Compound sensors.
 * It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, and to access the autonomous datalogger.
 */
class YTvoc extends YSensor
{
    //--- (end of YTvoc declaration)

    //--- (YTvoc attributes)

    //--- (end of YTvoc attributes)

    function __construct($str_func)
    {
        //--- (YTvoc constructor)
        parent::__construct($str_func);
        $this->_className = 'Tvoc';

        //--- (end of YTvoc constructor)
    }

    //--- (YTvoc implementation)

    /**
     * Retrieves a Total  Volatile Organic Compound sensor for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the Total  Volatile Organic Compound sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the Total  Volatile Organic Compound sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * a Total  Volatile Organic Compound sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the Total  Volatile Organic Compound
     * sensor, for instance
     *         YVOCMK03.tvoc.
     *
     * @return YTvoc  a YTvoc object allowing you to drive the Total  Volatile Organic Compound sensor.
     */
    public static function FindTvoc(string $func): ?YTvoc
    {
        // $obj                    is a YTvoc;
        $obj = YFunction::_FindFromCache('Tvoc', $func);
        if ($obj == null) {
            $obj = new YTvoc($func);
            YFunction::_AddToCache('Tvoc', $func, $obj);
        }
        return $obj;
    }

    /**
     * Continues the enumeration of Total Volatile Organic Compound sensors started using yFirstTvoc().
     * Caution: You can't make any assumption about the returned Total Volatile Organic Compound sensors order.
     * If you want to find a specific a Total  Volatile Organic Compound sensor, use Tvoc.findTvoc()
     * and a hardwareID or a logical name.
     *
     * @return YTvoc  a pointer to a YTvoc object, corresponding to
     *         a Total  Volatile Organic Compound sensor currently online, or a null pointer
     *         if there are no more Total Volatile Organic Compound sensors to enumerate.
     */
    public function nextTvoc(): ?YTvoc
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindTvoc($next_hwid);
    }

    /**
     * Starts the enumeration of Total Volatile Organic Compound sensors currently accessible.
     * Use the method YTvoc::nextTvoc() to iterate on
     * next Total Volatile Organic Compound sensors.
     *
     * @return YTvoc  a pointer to a YTvoc object, corresponding to
     *         the first Total Volatile Organic Compound sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstTvoc()
    {
        $next_hwid = YAPI::getFirstHardwareId('Tvoc');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindTvoc($next_hwid);
    }

    //--- (end of YTvoc implementation)

}
