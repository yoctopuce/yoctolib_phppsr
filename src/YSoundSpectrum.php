<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YSoundSpectrum Class: sound spectrum analyzer control interface
 *
 * The YSoundSpectrum class allows you to read and configure Yoctopuce sound spectrum analyzers.
 * It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, and to access the autonomous datalogger.
 */
class YSoundSpectrum extends YFunction
{
    const INTEGRATIONTIME_INVALID = YAPI::INVALID_UINT;
    const SPECTRUMDATA_INVALID = YAPI::INVALID_STRING;
    //--- (end of YSoundSpectrum declaration)

    //--- (YSoundSpectrum attributes)
    protected int $_integrationTime = self::INTEGRATIONTIME_INVALID; // UInt31
    protected string $_spectrumData = self::SPECTRUMDATA_INVALID;   // BinaryBuffer

    //--- (end of YSoundSpectrum attributes)

    function __construct(string $str_func)
    {
        //--- (YSoundSpectrum constructor)
        parent::__construct($str_func);
        $this->_className = 'SoundSpectrum';

        //--- (end of YSoundSpectrum constructor)
    }

    //--- (YSoundSpectrum implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'integrationTime':
            $this->_integrationTime = intval($val);
            return 1;
        case 'spectrumData':
            $this->_spectrumData = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the integration time in milliseconds for calculating time
     * weighted spectrum data.
     *
     * @return int  an integer corresponding to the integration time in milliseconds for calculating time
     *         weighted spectrum data
     *
     * On failure, throws an exception or returns YSoundSpectrum::INTEGRATIONTIME_INVALID.
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
     * Changes the integration time in milliseconds for computing time weighted
     * spectrum data. Be aware that on some devices, changing the integration
     * time for time-weighted spectrum data may also affect the integration
     * period for one or more sound pressure level measurements.
     * Remember to call the saveToFlash() method of the
     * module if the modification must be kept.
     *
     * @param int $newval : an integer corresponding to the integration time in milliseconds for computing
     * time weighted
     *         spectrum data
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_integrationTime(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("integrationTime", $rest_val);
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_spectrumData(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SPECTRUMDATA_INVALID;
            }
        }
        $res = $this->_spectrumData;
        return $res;
    }

    /**
     * Retrieves a sound spectrum analyzer for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the sound spectrum analyzer is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the sound spectrum analyzer is
     * indeed online at a given time. In case of ambiguity when looking for
     * a sound spectrum analyzer by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the sound spectrum analyzer, for instance
     *         MyDevice.soundSpectrum.
     *
     * @return YSoundSpectrum  a YSoundSpectrum object allowing you to drive the sound spectrum analyzer.
     */
    public static function FindSoundSpectrum(string $func): YSoundSpectrum
    {
        // $obj                    is a YSoundSpectrum;
        $obj = YFunction::_FindFromCache('SoundSpectrum', $func);
        if ($obj == null) {
            $obj = new YSoundSpectrum($func);
            YFunction::_AddToCache('SoundSpectrum', $func, $obj);
        }
        return $obj;
    }

    /**
     * @throws YAPI_Exception
     */
    public function integrationTime(): int
{
    return $this->get_integrationTime();
}

    /**
     * @throws YAPI_Exception
     */
    public function setIntegrationTime(int $newval): int
{
    return $this->set_integrationTime($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function spectrumData(): string
{
    return $this->get_spectrumData();
}

    /**
     * comment from .yc definition
     */
    public function nextSoundSpectrum(): ?YSoundSpectrum
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindSoundSpectrum($next_hwid);
    }

    /**
     * comment from .yc definition
     */
    public static function FirstSoundSpectrum(): ?YSoundSpectrum
    {
        $next_hwid = YAPI::getFirstHardwareId('SoundSpectrum');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindSoundSpectrum($next_hwid);
    }

    //--- (end of YSoundSpectrum implementation)

}
