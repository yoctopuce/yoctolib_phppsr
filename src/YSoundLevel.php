<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YSoundLevel Class: sound pressure level meter control interface
 *
 * The YSoundLevel class allows you to read and configure Yoctopuce sound pressure level meters.
 * It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, and to access the autonomous datalogger.
 */
class YSoundLevel extends YSensor
{
    const LABEL_INVALID = YAPI::INVALID_STRING;
    const INTEGRATIONTIME_INVALID = YAPI::INVALID_UINT;
    //--- (end of YSoundLevel declaration)

    //--- (YSoundLevel attributes)
    protected string $_label = self::LABEL_INVALID;          // Text
    protected int $_integrationTime = self::INTEGRATIONTIME_INVALID; // UInt31

    //--- (end of YSoundLevel attributes)

    function __construct(string $str_func)
    {
        //--- (YSoundLevel constructor)
        parent::__construct($str_func);
        $this->_className = 'SoundLevel';

        //--- (end of YSoundLevel constructor)
    }

    //--- (YSoundLevel implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'label':
            $this->_label = $val;
            return 1;
        case 'integrationTime':
            $this->_integrationTime = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Changes the measuring unit for the sound pressure level (dBA, dBC or dBZ).
     * That unit will directly determine frequency weighting to be used to compute
     * the measured value. Remember to call the saveToFlash() method of the
     * module if the modification must be kept.
     *
     * @param string $newval : a string corresponding to the measuring unit for the sound pressure level
     * (dBA, dBC or dBZ)
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_unit(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("unit", $rest_val);
    }

    /**
     * Returns the label for the sound pressure level measurement, as per
     * IEC standard 61672-1:2013.
     *
     * @return string  a string corresponding to the label for the sound pressure level measurement, as per
     *         IEC standard 61672-1:2013
     *
     * On failure, throws an exception or returns YSoundLevel::LABEL_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_label(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration == 0) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LABEL_INVALID;
            }
        }
        $res = $this->_label;
        return $res;
    }

    /**
     * Returns the integration time in milliseconds for measuring the sound pressure level.
     *
     * @return int  an integer corresponding to the integration time in milliseconds for measuring the
     * sound pressure level
     *
     * On failure, throws an exception or returns YSoundLevel::INTEGRATIONTIME_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_integrationTime(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::INTEGRATIONTIME_INVALID;
            }
        }
        $res = $this->_integrationTime;
        return $res;
    }

    /**
     * Retrieves a sound pressure level meter for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the sound pressure level meter is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the sound pressure level meter is
     * indeed online at a given time. In case of ambiguity when looking for
     * a sound pressure level meter by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the sound pressure level meter, for instance
     *         MyDevice.soundLevel1.
     *
     * @return YSoundLevel  a YSoundLevel object allowing you to drive the sound pressure level meter.
     */
    public static function FindSoundLevel(string $func): YSoundLevel
    {
        // $obj                    is a YSoundLevel;
        $obj = YFunction::_FindFromCache('SoundLevel', $func);
        if ($obj == null) {
            $obj = new YSoundLevel($func);
            YFunction::_AddToCache('SoundLevel', $func, $obj);
        }
        return $obj;
    }

    /**
     * @throws YAPI_Exception
     */
    public function setUnit(string $newval): int
{
    return $this->set_unit($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function label(): string
{
    return $this->get_label();
}

    /**
     * @throws YAPI_Exception
     */
    public function integrationTime(): int
{
    return $this->get_integrationTime();
}

    /**
     * Continues the enumeration of sound pressure level meters started using yFirstSoundLevel().
     * Caution: You can't make any assumption about the returned sound pressure level meters order.
     * If you want to find a specific a sound pressure level meter, use SoundLevel.findSoundLevel()
     * and a hardwareID or a logical name.
     *
     * @return ?YSoundLevel  a pointer to a YSoundLevel object, corresponding to
     *         a sound pressure level meter currently online, or a null pointer
     *         if there are no more sound pressure level meters to enumerate.
     */
    public function nextSoundLevel(): ?YSoundLevel
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindSoundLevel($next_hwid);
    }

    /**
     * Starts the enumeration of sound pressure level meters currently accessible.
     * Use the method YSoundLevel::nextSoundLevel() to iterate on
     * next sound pressure level meters.
     *
     * @return ?YSoundLevel  a pointer to a YSoundLevel object, corresponding to
     *         the first sound pressure level meter currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstSoundLevel(): ?YSoundLevel
    {
        $next_hwid = YAPI::getFirstHardwareId('SoundLevel');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindSoundLevel($next_hwid);
    }

    //--- (end of YSoundLevel implementation)

}
