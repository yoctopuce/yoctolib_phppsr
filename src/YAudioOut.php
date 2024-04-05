<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YAudioOut Class: audio output control interface
 *
 * The YAudioOut class allows you to configure the volume of an audio output.
 */
class YAudioOut extends YFunction
{
    const VOLUME_INVALID = YAPI::INVALID_UINT;
    const MUTE_FALSE = 0;
    const MUTE_TRUE = 1;
    const MUTE_INVALID = -1;
    const VOLUMERANGE_INVALID = YAPI::INVALID_STRING;
    const SIGNAL_INVALID = YAPI::INVALID_INT;
    const NOSIGNALFOR_INVALID = YAPI::INVALID_INT;
    //--- (end of YAudioOut declaration)

    //--- (YAudioOut attributes)
    protected int $_volume = self::VOLUME_INVALID;         // Percent
    protected int $_mute = self::MUTE_INVALID;           // Bool
    protected string $_volumeRange = self::VOLUMERANGE_INVALID;    // ValueRange
    protected int $_signal = self::SIGNAL_INVALID;         // Int
    protected int $_noSignalFor = self::NOSIGNALFOR_INVALID;    // Int

    //--- (end of YAudioOut attributes)

    function __construct(string $str_func)
    {
        //--- (YAudioOut constructor)
        parent::__construct($str_func);
        $this->_className = 'AudioOut';

        //--- (end of YAudioOut constructor)
    }

    //--- (YAudioOut implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'volume':
            $this->_volume = intval($val);
            return 1;
        case 'mute':
            $this->_mute = intval($val);
            return 1;
        case 'volumeRange':
            $this->_volumeRange = $val;
            return 1;
        case 'signal':
            $this->_signal = intval($val);
            return 1;
        case 'noSignalFor':
            $this->_noSignalFor = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns audio output volume, in per cents.
     *
     * @return int  an integer corresponding to audio output volume, in per cents
     *
     * On failure, throws an exception or returns YAudioOut::VOLUME_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_volume(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::VOLUME_INVALID;
            }
        }
        $res = $this->_volume;
        return $res;
    }

    /**
     * Changes audio output volume, in per cents.
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param int $newval : an integer corresponding to audio output volume, in per cents
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_volume(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("volume", $rest_val);
    }

    /**
     * Returns the state of the mute function.
     *
     * @return int  either YAudioOut::MUTE_FALSE or YAudioOut::MUTE_TRUE, according to the state of the mute function
     *
     * On failure, throws an exception or returns YAudioOut::MUTE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_mute(): int
    {
        // $res                    is a enumBOOL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::MUTE_INVALID;
            }
        }
        $res = $this->_mute;
        return $res;
    }

    /**
     * Changes the state of the mute function. Remember to call the matching module
     * saveToFlash() method to save the setting permanently.
     *
     * @param int $newval : either YAudioOut::MUTE_FALSE or YAudioOut::MUTE_TRUE, according to the state of
     * the mute function
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_mute(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("mute", $rest_val);
    }

    /**
     * Returns the supported volume range. The low value of the
     * range corresponds to the minimal audible value. To
     * completely mute the sound, use set_mute()
     * instead of the set_volume().
     *
     * @return string  a string corresponding to the supported volume range
     *
     * On failure, throws an exception or returns YAudioOut::VOLUMERANGE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_volumeRange(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::VOLUMERANGE_INVALID;
            }
        }
        $res = $this->_volumeRange;
        return $res;
    }

    /**
     * Returns the detected output current level.
     *
     * @return int  an integer corresponding to the detected output current level
     *
     * On failure, throws an exception or returns YAudioOut::SIGNAL_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_signal(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SIGNAL_INVALID;
            }
        }
        $res = $this->_signal;
        return $res;
    }

    /**
     * Returns the number of seconds elapsed without detecting a signal.
     *
     * @return int  an integer corresponding to the number of seconds elapsed without detecting a signal
     *
     * On failure, throws an exception or returns YAudioOut::NOSIGNALFOR_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_noSignalFor(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::NOSIGNALFOR_INVALID;
            }
        }
        $res = $this->_noSignalFor;
        return $res;
    }

    /**
     * Retrieves an audio output for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the audio output is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the audio output is
     * indeed online at a given time. In case of ambiguity when looking for
     * an audio output by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the audio output, for instance
     *         MyDevice.audioOut1.
     *
     * @return YAudioOut  a YAudioOut object allowing you to drive the audio output.
     */
    public static function FindAudioOut(string $func): YAudioOut
    {
        // $obj                    is a YAudioOut;
        $obj = YFunction::_FindFromCache('AudioOut', $func);
        if ($obj == null) {
            $obj = new YAudioOut($func);
            YFunction::_AddToCache('AudioOut', $func, $obj);
        }
        return $obj;
    }

    /**
     * @throws YAPI_Exception
     */
    public function volume(): int
{
    return $this->get_volume();
}

    /**
     * @throws YAPI_Exception
     */
    public function setVolume(int $newval): int
{
    return $this->set_volume($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function mute(): int
{
    return $this->get_mute();
}

    /**
     * @throws YAPI_Exception
     */
    public function setMute(int $newval): int
{
    return $this->set_mute($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function volumeRange(): string
{
    return $this->get_volumeRange();
}

    /**
     * @throws YAPI_Exception
     */
    public function signal(): int
{
    return $this->get_signal();
}

    /**
     * @throws YAPI_Exception
     */
    public function noSignalFor(): int
{
    return $this->get_noSignalFor();
}

    /**
     * Continues the enumeration of audio outputs started using yFirstAudioOut().
     * Caution: You can't make any assumption about the returned audio outputs order.
     * If you want to find a specific an audio output, use AudioOut.findAudioOut()
     * and a hardwareID or a logical name.
     *
     * @return ?YAudioOut  a pointer to a YAudioOut object, corresponding to
     *         an audio output currently online, or a null pointer
     *         if there are no more audio outputs to enumerate.
     */
    public function nextAudioOut(): ?YAudioOut
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindAudioOut($next_hwid);
    }

    /**
     * Starts the enumeration of audio outputs currently accessible.
     * Use the method YAudioOut::nextAudioOut() to iterate on
     * next audio outputs.
     *
     * @return ?YAudioOut  a pointer to a YAudioOut object, corresponding to
     *         the first audio output currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstAudioOut(): ?YAudioOut
    {
        $next_hwid = YAPI::getFirstHardwareId('AudioOut');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindAudioOut($next_hwid);
    }

    //--- (end of YAudioOut implementation)

}
