<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YOrientation Class: orientation sensor control interface
 *
 * The YOrientation class allows you to read and configure Yoctopuce orientation sensors.
 * It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, and to access the autonomous datalogger.
 */
class YOrientation extends YSensor
{
    //--- (end of YOrientation declaration)

    //--- (YOrientation attributes)

    //--- (end of YOrientation attributes)

    function __construct(string $str_func)
    {
        //--- (YOrientation constructor)
        parent::__construct($str_func);
        $this->_className = 'Orientation';

        //--- (end of YOrientation constructor)
    }

    //--- (YOrientation implementation)

    /**
     * Retrieves an orientation sensor for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the orientation sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the orientation sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * an orientation sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the orientation sensor, for instance
     *         MyDevice.orientation.
     *
     * @return YOrientation  a YOrientation object allowing you to drive the orientation sensor.
     */
    public static function FindOrientation(string $func): YOrientation
    {
        // $obj                    is a YOrientation;
        $obj = YFunction::_FindFromCache('Orientation', $func);
        if ($obj == null) {
            $obj = new YOrientation($func);
            YFunction::_AddToCache('Orientation', $func, $obj);
        }
        return $obj;
    }

    /**
     * Continues the enumeration of orientation sensors started using yFirstOrientation().
     * Caution: You can't make any assumption about the returned orientation sensors order.
     * If you want to find a specific an orientation sensor, use Orientation.findOrientation()
     * and a hardwareID or a logical name.
     *
     * @return ?YOrientation  a pointer to a YOrientation object, corresponding to
     *         an orientation sensor currently online, or a null pointer
     *         if there are no more orientation sensors to enumerate.
     */
    public function nextOrientation(): ?YOrientation
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindOrientation($next_hwid);
    }

    /**
     * Starts the enumeration of orientation sensors currently accessible.
     * Use the method YOrientation::nextOrientation() to iterate on
     * next orientation sensors.
     *
     * @return ?YOrientation  a pointer to a YOrientation object, corresponding to
     *         the first orientation sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstOrientation(): ?YOrientation
    {
        $next_hwid = YAPI::getFirstHardwareId('Orientation');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindOrientation($next_hwid);
    }

    //--- (end of YOrientation implementation)

}
