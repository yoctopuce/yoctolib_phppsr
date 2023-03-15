<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YQt Class: Base interface to access quaternion components, available for instance in the Yocto-3D-V2
 *
 * The YQt class provides direct access to the 3D attitude estimation
 * provided by Yoctopuce inertial sensors. The four instances of YQt
 * provide direct access to the individual quaternion components representing the
 * orientation. It is usually not needed to use the YQt class
 * directly, as the YGyro class provides a more convenient higher-level
 * interface.
 */
class YQt extends YSensor
{
    //--- (end of generated code: YQt declaration)

    //--- (generated code: YQt attributes)

    //--- (end of generated code: YQt attributes)

    function __construct(string $str_func)
    {
        //--- (generated code: YQt constructor)
        parent::__construct($str_func);
        $this->_className = 'Qt';

        //--- (end of generated code: YQt constructor)
    }

    //--- (generated code: YQt implementation)

    /**
     * Retrieves a quaternion component for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the quaternion component is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the quaternion component is
     * indeed online at a given time. In case of ambiguity when looking for
     * a quaternion component by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the quaternion component, for instance
     *         Y3DMK002.qt1.
     *
     * @return YQt  a YQt object allowing you to drive the quaternion component.
     */
    public static function FindQt(string $func): YQt
    {
        // $obj                    is a YQt;
        $obj = YFunction::_FindFromCache('Qt', $func);
        if ($obj == null) {
            $obj = new YQt($func);
            YFunction::_AddToCache('Qt', $func, $obj);
        }
        return $obj;
    }

    /**
     * Continues the enumeration of quaternion components started using yFirstQt().
     * Caution: You can't make any assumption about the returned quaternion components order.
     * If you want to find a specific a quaternion component, use Qt.findQt()
     * and a hardwareID or a logical name.
     *
     * @return ?YQt  a pointer to a YQt object, corresponding to
     *         a quaternion component currently online, or a null pointer
     *         if there are no more quaternion components to enumerate.
     */
    public function nextQt(): ?YQt
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindQt($next_hwid);
    }

    /**
     * Starts the enumeration of quaternion components currently accessible.
     * Use the method YQt::nextQt() to iterate on
     * next quaternion components.
     *
     * @return ?YQt  a pointer to a YQt object, corresponding to
     *         the first quaternion component currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstQt(): ?YQt
    {
        $next_hwid = YAPI::getFirstHardwareId('Qt');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindQt($next_hwid);
    }

    //--- (end of generated code: YQt implementation)

}


