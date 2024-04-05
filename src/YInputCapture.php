<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YInputCapture Class: instant snapshot trigger control interface
 *
 * The YInputCapture class allows you to access data samples
 * measured by a Yoctopuce electrical sensor. The data capture can be
 * triggered manually, or be configured to detect specific events.
 */
class YInputCapture extends YFunction
{
    const LASTCAPTURETIME_INVALID = YAPI::INVALID_LONG;
    const NSAMPLES_INVALID = YAPI::INVALID_UINT;
    const SAMPLINGRATE_INVALID = YAPI::INVALID_UINT;
    const CAPTURETYPE_NONE = 0;
    const CAPTURETYPE_TIMED = 1;
    const CAPTURETYPE_V_MAX = 2;
    const CAPTURETYPE_V_MIN = 3;
    const CAPTURETYPE_I_MAX = 4;
    const CAPTURETYPE_I_MIN = 5;
    const CAPTURETYPE_P_MAX = 6;
    const CAPTURETYPE_P_MIN = 7;
    const CAPTURETYPE_V_AVG_MAX = 8;
    const CAPTURETYPE_V_AVG_MIN = 9;
    const CAPTURETYPE_V_RMS_MAX = 10;
    const CAPTURETYPE_V_RMS_MIN = 11;
    const CAPTURETYPE_I_AVG_MAX = 12;
    const CAPTURETYPE_I_AVG_MIN = 13;
    const CAPTURETYPE_I_RMS_MAX = 14;
    const CAPTURETYPE_I_RMS_MIN = 15;
    const CAPTURETYPE_P_AVG_MAX = 16;
    const CAPTURETYPE_P_AVG_MIN = 17;
    const CAPTURETYPE_PF_MIN = 18;
    const CAPTURETYPE_DPF_MIN = 19;
    const CAPTURETYPE_INVALID = -1;
    const CONDVALUE_INVALID = YAPI::INVALID_DOUBLE;
    const CONDALIGN_INVALID = YAPI::INVALID_UINT;
    const CAPTURETYPEATSTARTUP_NONE = 0;
    const CAPTURETYPEATSTARTUP_TIMED = 1;
    const CAPTURETYPEATSTARTUP_V_MAX = 2;
    const CAPTURETYPEATSTARTUP_V_MIN = 3;
    const CAPTURETYPEATSTARTUP_I_MAX = 4;
    const CAPTURETYPEATSTARTUP_I_MIN = 5;
    const CAPTURETYPEATSTARTUP_P_MAX = 6;
    const CAPTURETYPEATSTARTUP_P_MIN = 7;
    const CAPTURETYPEATSTARTUP_V_AVG_MAX = 8;
    const CAPTURETYPEATSTARTUP_V_AVG_MIN = 9;
    const CAPTURETYPEATSTARTUP_V_RMS_MAX = 10;
    const CAPTURETYPEATSTARTUP_V_RMS_MIN = 11;
    const CAPTURETYPEATSTARTUP_I_AVG_MAX = 12;
    const CAPTURETYPEATSTARTUP_I_AVG_MIN = 13;
    const CAPTURETYPEATSTARTUP_I_RMS_MAX = 14;
    const CAPTURETYPEATSTARTUP_I_RMS_MIN = 15;
    const CAPTURETYPEATSTARTUP_P_AVG_MAX = 16;
    const CAPTURETYPEATSTARTUP_P_AVG_MIN = 17;
    const CAPTURETYPEATSTARTUP_PF_MIN = 18;
    const CAPTURETYPEATSTARTUP_DPF_MIN = 19;
    const CAPTURETYPEATSTARTUP_INVALID = -1;
    const CONDVALUEATSTARTUP_INVALID = YAPI::INVALID_DOUBLE;
    //--- (end of generated code: YInputCapture declaration)

    //--- (generated code: YInputCapture attributes)
    protected float $_lastCaptureTime = self::LASTCAPTURETIME_INVALID; // Time
    protected int $_nSamples = self::NSAMPLES_INVALID;       // UInt31
    protected int $_samplingRate = self::SAMPLINGRATE_INVALID;   // UInt31
    protected int $_captureType = self::CAPTURETYPE_INVALID;    // CaptureTypeAll
    protected float $_condValue = self::CONDVALUE_INVALID;      // MeasureVal
    protected int $_condAlign = self::CONDALIGN_INVALID;      // Percent
    protected int $_captureTypeAtStartup = self::CAPTURETYPEATSTARTUP_INVALID; // CaptureTypeAll
    protected float $_condValueAtStartup = self::CONDVALUEATSTARTUP_INVALID; // MeasureVal

    //--- (end of generated code: YInputCapture attributes)

    function __construct(string $str_func)
    {
        //--- (generated code: YInputCapture constructor)
        parent::__construct($str_func);
        $this->_className = 'InputCapture';

        //--- (end of generated code: YInputCapture constructor)
    }

    //--- (generated code: YInputCapture implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'lastCaptureTime':
            $this->_lastCaptureTime = intval($val);
            return 1;
        case 'nSamples':
            $this->_nSamples = intval($val);
            return 1;
        case 'samplingRate':
            $this->_samplingRate = intval($val);
            return 1;
        case 'captureType':
            $this->_captureType = intval($val);
            return 1;
        case 'condValue':
            $this->_condValue = round($val / 65.536) / 1000.0;
            return 1;
        case 'condAlign':
            $this->_condAlign = intval($val);
            return 1;
        case 'captureTypeAtStartup':
            $this->_captureTypeAtStartup = intval($val);
            return 1;
        case 'condValueAtStartup':
            $this->_condValueAtStartup = round($val / 65.536) / 1000.0;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the number of elapsed milliseconds between the module power on
     * and the last capture (time of trigger), or zero if no capture has been done.
     *
     * @return float  an integer corresponding to the number of elapsed milliseconds between the module power on
     *         and the last capture (time of trigger), or zero if no capture has been done
     *
     * On failure, throws an exception or returns YInputCapture::LASTCAPTURETIME_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_lastCaptureTime(): float
    {
        // $res                    is a long;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LASTCAPTURETIME_INVALID;
            }
        }
        $res = $this->_lastCaptureTime;
        return $res;
    }

    /**
     * Returns the number of samples that will be captured.
     *
     * @return int  an integer corresponding to the number of samples that will be captured
     *
     * On failure, throws an exception or returns YInputCapture::NSAMPLES_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_nSamples(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::NSAMPLES_INVALID;
            }
        }
        $res = $this->_nSamples;
        return $res;
    }

    /**
     * Changes the type of automatic conditional capture.
     * The maximum number of samples depends on the device memory.
     *
     * If you want the change to be kept after a device reboot,
     * make sure  to call the matching module saveToFlash().
     *
     * @param int $newval : an integer corresponding to the type of automatic conditional capture
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_nSamples(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("nSamples", $rest_val);
    }

    /**
     * Returns the sampling frequency, in Hz.
     *
     * @return int  an integer corresponding to the sampling frequency, in Hz
     *
     * On failure, throws an exception or returns YInputCapture::SAMPLINGRATE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_samplingRate(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SAMPLINGRATE_INVALID;
            }
        }
        $res = $this->_samplingRate;
        return $res;
    }

    /**
     * Returns the type of automatic conditional capture.
     *
     * @return int  a value among YInputCapture::CAPTURETYPE_NONE, YInputCapture::CAPTURETYPE_TIMED,
     * YInputCapture::CAPTURETYPE_V_MAX, YInputCapture::CAPTURETYPE_V_MIN, YInputCapture::CAPTURETYPE_I_MAX,
     * YInputCapture::CAPTURETYPE_I_MIN, YInputCapture::CAPTURETYPE_P_MAX, YInputCapture::CAPTURETYPE_P_MIN,
     * YInputCapture::CAPTURETYPE_V_AVG_MAX, YInputCapture::CAPTURETYPE_V_AVG_MIN,
     * YInputCapture::CAPTURETYPE_V_RMS_MAX, YInputCapture::CAPTURETYPE_V_RMS_MIN,
     * YInputCapture::CAPTURETYPE_I_AVG_MAX, YInputCapture::CAPTURETYPE_I_AVG_MIN,
     * YInputCapture::CAPTURETYPE_I_RMS_MAX, YInputCapture::CAPTURETYPE_I_RMS_MIN,
     * YInputCapture::CAPTURETYPE_P_AVG_MAX, YInputCapture::CAPTURETYPE_P_AVG_MIN,
     * YInputCapture::CAPTURETYPE_PF_MIN and YInputCapture::CAPTURETYPE_DPF_MIN corresponding to the type of
     * automatic conditional capture
     *
     * On failure, throws an exception or returns YInputCapture::CAPTURETYPE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_captureType(): int
    {
        // $res                    is a enumCAPTURETYPEALL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CAPTURETYPE_INVALID;
            }
        }
        $res = $this->_captureType;
        return $res;
    }

    /**
     * Changes the type of automatic conditional capture.
     *
     * @param int $newval : a value among YInputCapture::CAPTURETYPE_NONE, YInputCapture::CAPTURETYPE_TIMED,
     * YInputCapture::CAPTURETYPE_V_MAX, YInputCapture::CAPTURETYPE_V_MIN, YInputCapture::CAPTURETYPE_I_MAX,
     * YInputCapture::CAPTURETYPE_I_MIN, YInputCapture::CAPTURETYPE_P_MAX, YInputCapture::CAPTURETYPE_P_MIN,
     * YInputCapture::CAPTURETYPE_V_AVG_MAX, YInputCapture::CAPTURETYPE_V_AVG_MIN,
     * YInputCapture::CAPTURETYPE_V_RMS_MAX, YInputCapture::CAPTURETYPE_V_RMS_MIN,
     * YInputCapture::CAPTURETYPE_I_AVG_MAX, YInputCapture::CAPTURETYPE_I_AVG_MIN,
     * YInputCapture::CAPTURETYPE_I_RMS_MAX, YInputCapture::CAPTURETYPE_I_RMS_MIN,
     * YInputCapture::CAPTURETYPE_P_AVG_MAX, YInputCapture::CAPTURETYPE_P_AVG_MIN,
     * YInputCapture::CAPTURETYPE_PF_MIN and YInputCapture::CAPTURETYPE_DPF_MIN corresponding to the type of
     * automatic conditional capture
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_captureType(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("captureType", $rest_val);
    }

    /**
     * Changes current threshold value for automatic conditional capture.
     *
     * @param float $newval : a floating point number corresponding to current threshold value for
     * automatic conditional capture
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_condValue(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("condValue", $rest_val);
    }

    /**
     * Returns current threshold value for automatic conditional capture.
     *
     * @return float  a floating point number corresponding to current threshold value for automatic
     * conditional capture
     *
     * On failure, throws an exception or returns YInputCapture::CONDVALUE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_condValue(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CONDVALUE_INVALID;
            }
        }
        $res = $this->_condValue;
        return $res;
    }

    /**
     * Returns the relative position of the trigger event within the capture window.
     * When the value is 50%, the capture is centered on the event.
     *
     * @return int  an integer corresponding to the relative position of the trigger event within the capture window
     *
     * On failure, throws an exception or returns YInputCapture::CONDALIGN_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_condAlign(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CONDALIGN_INVALID;
            }
        }
        $res = $this->_condAlign;
        return $res;
    }

    /**
     * Changes the relative position of the trigger event within the capture window.
     * The new value must be between 10% (on the left) and 90% (on the right).
     * When the value is 50%, the capture is centered on the event.
     *
     * If you want the change to be kept after a device reboot,
     * make sure  to call the matching module saveToFlash().
     *
     * @param int $newval : an integer corresponding to the relative position of the trigger event within
     * the capture window
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_condAlign(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("condAlign", $rest_val);
    }

    /**
     * Returns the type of automatic conditional capture
     * applied at device power on.
     *
     * @return int  a value among YInputCapture::CAPTURETYPEATSTARTUP_NONE,
     * YInputCapture::CAPTURETYPEATSTARTUP_TIMED, YInputCapture::CAPTURETYPEATSTARTUP_V_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_V_MIN, YInputCapture::CAPTURETYPEATSTARTUP_I_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_I_MIN, YInputCapture::CAPTURETYPEATSTARTUP_P_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_P_MIN, YInputCapture::CAPTURETYPEATSTARTUP_V_AVG_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_V_AVG_MIN, YInputCapture::CAPTURETYPEATSTARTUP_V_RMS_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_V_RMS_MIN, YInputCapture::CAPTURETYPEATSTARTUP_I_AVG_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_I_AVG_MIN, YInputCapture::CAPTURETYPEATSTARTUP_I_RMS_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_I_RMS_MIN, YInputCapture::CAPTURETYPEATSTARTUP_P_AVG_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_P_AVG_MIN, YInputCapture::CAPTURETYPEATSTARTUP_PF_MIN and
     * YInputCapture::CAPTURETYPEATSTARTUP_DPF_MIN corresponding to the type of automatic conditional capture
     *         applied at device power on
     *
     * On failure, throws an exception or returns YInputCapture::CAPTURETYPEATSTARTUP_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_captureTypeAtStartup(): int
    {
        // $res                    is a enumCAPTURETYPEALL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CAPTURETYPEATSTARTUP_INVALID;
            }
        }
        $res = $this->_captureTypeAtStartup;
        return $res;
    }

    /**
     * Changes the type of automatic conditional capture
     * applied at device power on.
     *
     * If you want the change to be kept after a device reboot,
     * make sure  to call the matching module saveToFlash().
     *
     * @param int $newval : a value among YInputCapture::CAPTURETYPEATSTARTUP_NONE,
     * YInputCapture::CAPTURETYPEATSTARTUP_TIMED, YInputCapture::CAPTURETYPEATSTARTUP_V_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_V_MIN, YInputCapture::CAPTURETYPEATSTARTUP_I_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_I_MIN, YInputCapture::CAPTURETYPEATSTARTUP_P_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_P_MIN, YInputCapture::CAPTURETYPEATSTARTUP_V_AVG_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_V_AVG_MIN, YInputCapture::CAPTURETYPEATSTARTUP_V_RMS_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_V_RMS_MIN, YInputCapture::CAPTURETYPEATSTARTUP_I_AVG_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_I_AVG_MIN, YInputCapture::CAPTURETYPEATSTARTUP_I_RMS_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_I_RMS_MIN, YInputCapture::CAPTURETYPEATSTARTUP_P_AVG_MAX,
     * YInputCapture::CAPTURETYPEATSTARTUP_P_AVG_MIN, YInputCapture::CAPTURETYPEATSTARTUP_PF_MIN and
     * YInputCapture::CAPTURETYPEATSTARTUP_DPF_MIN corresponding to the type of automatic conditional capture
     *         applied at device power on
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_captureTypeAtStartup(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("captureTypeAtStartup", $rest_val);
    }

    /**
     * Changes current threshold value for automatic conditional
     * capture applied at device power on.
     *
     * If you want the change to be kept after a device reboot,
     * make sure  to call the matching module saveToFlash().
     *
     * @param float $newval : a floating point number corresponding to current threshold value for
     * automatic conditional
     *         capture applied at device power on
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_condValueAtStartup(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("condValueAtStartup", $rest_val);
    }

    /**
     * Returns the threshold value for automatic conditional
     * capture applied at device power on.
     *
     * @return float  a floating point number corresponding to the threshold value for automatic conditional
     *         capture applied at device power on
     *
     * On failure, throws an exception or returns YInputCapture::CONDVALUEATSTARTUP_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_condValueAtStartup(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CONDVALUEATSTARTUP_INVALID;
            }
        }
        $res = $this->_condValueAtStartup;
        return $res;
    }

    /**
     * Retrieves an instant snapshot trigger for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the instant snapshot trigger is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the instant snapshot trigger is
     * indeed online at a given time. In case of ambiguity when looking for
     * an instant snapshot trigger by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the instant snapshot trigger, for instance
     *         MyDevice.inputCapture.
     *
     * @return YInputCapture  a YInputCapture object allowing you to drive the instant snapshot trigger.
     */
    public static function FindInputCapture(string $func): YInputCapture
    {
        // $obj                    is a YInputCapture;
        $obj = YFunction::_FindFromCache('InputCapture', $func);
        if ($obj == null) {
            $obj = new YInputCapture($func);
            YFunction::_AddToCache('InputCapture', $func, $obj);
        }
        return $obj;
    }

    /**
     * Returns all details about the last automatic input capture.
     *
     * @return ?YInputCaptureData  an YInputCaptureData object including
     *         data series and all related meta-information.
     *         On failure, throws an exception or returns an capture object.
     * @throws YAPI_Exception on error
     */
    public function get_lastCapture(): ?YInputCaptureData
    {
        // $snapData               is a bin;

        $snapData = $this->_download('snap.bin');
        return new YInputCaptureData($this, $snapData);
    }

    /**
     * Returns a new immediate capture of the device inputs.
     *
     * @param int $msDuration : duration of the capture window,
     *         in milliseconds (eg. between 20 and 1000).
     *
     * @return ?YInputCaptureData  an YInputCaptureData object including
     *         data series for the specified duration.
     *         On failure, throws an exception or returns an capture object.
     * @throws YAPI_Exception on error
     */
    public function get_immediateCapture(int $msDuration): ?YInputCaptureData
    {
        // $snapUrl                is a str;
        // $snapData               is a bin;
        // $snapStart              is a int;
        if ($msDuration < 1) {
            $msDuration = 20;
        }
        if ($msDuration > 1000) {
            $msDuration = 1000;
        }
        $snapStart = intVal((-$msDuration) / (2));
        $snapUrl = sprintf('snap.bin?t=%d&d=%d', $snapStart, $msDuration);

        $snapData = $this->_download($snapUrl);
        return new YInputCaptureData($this, $snapData);
    }

    /**
     * @throws YAPI_Exception
     */
    public function lastCaptureTime(): float
{
    return $this->get_lastCaptureTime();
}

    /**
     * @throws YAPI_Exception
     */
    public function nSamples(): int
{
    return $this->get_nSamples();
}

    /**
     * @throws YAPI_Exception
     */
    public function setNSamples(int $newval): int
{
    return $this->set_nSamples($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function samplingRate(): int
{
    return $this->get_samplingRate();
}

    /**
     * @throws YAPI_Exception
     */
    public function captureType(): int
{
    return $this->get_captureType();
}

    /**
     * @throws YAPI_Exception
     */
    public function setCaptureType(int $newval): int
{
    return $this->set_captureType($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function setCondValue(float $newval): int
{
    return $this->set_condValue($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function condValue(): float
{
    return $this->get_condValue();
}

    /**
     * @throws YAPI_Exception
     */
    public function condAlign(): int
{
    return $this->get_condAlign();
}

    /**
     * @throws YAPI_Exception
     */
    public function setCondAlign(int $newval): int
{
    return $this->set_condAlign($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function captureTypeAtStartup(): int
{
    return $this->get_captureTypeAtStartup();
}

    /**
     * @throws YAPI_Exception
     */
    public function setCaptureTypeAtStartup(int $newval): int
{
    return $this->set_captureTypeAtStartup($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function setCondValueAtStartup(float $newval): int
{
    return $this->set_condValueAtStartup($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function condValueAtStartup(): float
{
    return $this->get_condValueAtStartup();
}

    /**
     * comment from .yc definition
     */
    public function nextInputCapture(): ?YInputCapture
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindInputCapture($next_hwid);
    }

    /**
     * comment from .yc definition
     */
    public static function FirstInputCapture(): ?YInputCapture
    {
        $next_hwid = YAPI::getFirstHardwareId('InputCapture');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindInputCapture($next_hwid);
    }

    //--- (end of generated code: YInputCapture implementation)

}

;
