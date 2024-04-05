<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YAudioIn Class: audio input control interface
 *
 * The YAudioIn class allows you to configure the volume of an audio input.
 */
class YAudioIn extends YFunction
{
    const VOLUME_INVALID = YAPI::INVALID_UINT;
    const MUTE_FALSE = 0;
    const MUTE_TRUE = 1;
    const MUTE_INVALID = -1;
    const VOLUMERANGE_INVALID = YAPI::INVALID_STRING;
    const SIGNAL_INVALID = YAPI::INVALID_INT;
    const NOSIGNALFOR_INVALID = YAPI::INVALID_INT;
    //--- (end of YAudioIn declaration)

    //--- (YAudioIn attributes)
    protected int $_volume = self::VOLUME_INVALID;         // Percent
    protected int $_mute = self::MUTE_INVALID;           // Bool
    protected string $_volumeRange = self::VOLUMERANGE_INVALID;    // ValueRange
    protected int $_signal = self::SIGNAL_INVALID;         // Int
    protected int $_noSignalFor = self::NOSIGNALFOR_INVALID;    // Int

    //--- (end of YAudioIn attributes)

    function __construct(string $str_func)
    {
        //--- (YAudioIn constructor)
        parent::__construct($str_func);
        $this->_className = 'AudioIn';

        //--- (end of YAudioIn constructor)
    }

    //--- (YAudioIn implementation)

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
     * Returns audio input gain, in per cents.
     *
     * @return int  an integer corresponding to audio input gain, in per cents
     *
     * On failure, throws an exception or returns YAudioIn::VOLUME_INVALID.
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
     * Changes audio input gain, in per cents.
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param int $newval : an integer corresponding to audio input gain, in per cents
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
     * @return int  either YAudioIn::MUTE_FALSE or YAudioIn::MUTE_TRUE, according to the state of the mute function
     *
     * On failure, throws an exception or returns YAudioIn::MUTE_INVALID.
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
     * @param int $newval : either YAudioIn::MUTE_FALSE or YAudioIn::MUTE_TRUE, according to the state of
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
     * On failure, throws an exception or returns YAudioIn::VOLUMERANGE_INVALID.
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
     * Returns the detected input signal level.
     *
     * @return int  an integer corresponding to the detected input signal level
     *
     * On failure, throws an exception or returns YAudioIn::SIGNAL_INVALID.
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
     * On failure, throws an exception or returns YAudioIn::NOSIGNALFOR_INVALID.
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
     * Retrieves an audio input for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the audio input is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the audio input is
     * indeed online at a given time. In case of ambiguity when looking for
     * an audio input by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the audio input, for instance
     *         MyDevice.audioIn1.
     *
     * @return YAudioIn  a YAudioIn object allowing you to drive the audio input.
     */
    public static function FindAudioIn(string $func): YAudioIn
    {
        // $obj                    is a YAudioIn;
        $obj = YFunction::_FindFromCache('AudioIn', $func);
        if ($obj == null) {
            $obj = new YAudioIn($func);
            YFunction::_AddToCache('AudioIn', $func, $obj);
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
     * Continues the enumeration of audio inputs started using yFirstAudioIn().
     * Caution: You can't make any assumption about the returned audio inputs order.
     * If you want to find a specific an audio input, use AudioIn.findAudioIn()
     * and a hardwareID or a logical name.
     *
     * @return ?YAudioIn  a pointer to a YAudioIn object, corresponding to
     *         an audio input currently online, or a null pointer
     *         if there are no more audio inputs to enumerate.
     */
    public function nextAudioIn(): ?YAudioIn
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindAudioIn($next_hwid);
    }

    /**
     * Starts the enumeration of audio inputs currently accessible.
     * Use the method YAudioIn::nextAudioIn() to iterate on
     * next audio inputs.
     *
     * @return ?YAudioIn  a pointer to a YAudioIn object, corresponding to
     *         the first audio input currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstAudioIn(): ?YAudioIn
    {
        $next_hwid = YAPI::getFirstHardwareId('AudioIn');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindAudioIn($next_hwid);
    }

    //--- (end of YAudioIn implementation)

}
