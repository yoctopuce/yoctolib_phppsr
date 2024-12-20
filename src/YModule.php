<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YModule Class: Global parameters control interface for all Yoctopuce devices
 *
 * The YModule class can be used with all Yoctopuce USB devices.
 * It can be used to control the module global parameters, and
 * to enumerate the functions provided by each module.
 */
class YModule extends YFunction
{
    const PRODUCTNAME_INVALID = YAPI::INVALID_STRING;
    const SERIALNUMBER_INVALID = YAPI::INVALID_STRING;
    const PRODUCTID_INVALID = YAPI::INVALID_UINT;
    const PRODUCTRELEASE_INVALID = YAPI::INVALID_UINT;
    const FIRMWARERELEASE_INVALID = YAPI::INVALID_STRING;
    const PERSISTENTSETTINGS_LOADED = 0;
    const PERSISTENTSETTINGS_SAVED = 1;
    const PERSISTENTSETTINGS_MODIFIED = 2;
    const PERSISTENTSETTINGS_INVALID = -1;
    const LUMINOSITY_INVALID = YAPI::INVALID_UINT;
    const BEACON_OFF = 0;
    const BEACON_ON = 1;
    const BEACON_INVALID = -1;
    const UPTIME_INVALID = YAPI::INVALID_LONG;
    const USBCURRENT_INVALID = YAPI::INVALID_UINT;
    const REBOOTCOUNTDOWN_INVALID = YAPI::INVALID_INT;
    const USERVAR_INVALID = YAPI::INVALID_INT;
    //--- (end of generated code: YModule declaration)

    //--- (generated code: YModule attributes)
    protected string $_productName = self::PRODUCTNAME_INVALID;    // Text
    protected string $_serialNumber = self::SERIALNUMBER_INVALID;   // Text
    protected int $_productId = self::PRODUCTID_INVALID;      // XWord
    protected int $_productRelease = self::PRODUCTRELEASE_INVALID; // XWord
    protected string $_firmwareRelease = self::FIRMWARERELEASE_INVALID; // Text
    protected int $_persistentSettings = self::PERSISTENTSETTINGS_INVALID; // FlashSettings
    protected int $_luminosity = self::LUMINOSITY_INVALID;     // Percent
    protected int $_beacon = self::BEACON_INVALID;         // OnOff
    protected float $_upTime = self::UPTIME_INVALID;         // Time
    protected int $_usbCurrent = self::USBCURRENT_INVALID;     // UsedCurrent
    protected int $_rebootCountdown = self::REBOOTCOUNTDOWN_INVALID; // Int
    protected int $_userVar = self::USERVAR_INVALID;        // Int
    protected mixed $_logCallback = null;                         // YModuleLogCallback
    protected mixed $_confChangeCallback = null;                         // YModuleConfigChangeCallback
    protected mixed $_beaconCallback = null;                         // YModuleBeaconCallback

    //--- (end of generated code: YModule attributes)
    protected static array $_moduleCallbackList = array();

    function __construct(string $str_func)
    {
        //--- (generated code: YModule constructor)
        parent::__construct($str_func);
        $this->_className = 'Module';

        //--- (end of generated code: YModule constructor)
    }

    private static function _updateModuleCallbackList(YModule $module, bool $add): void
    {
    }

    /**
     * Return the internal device object hosting the function
     * @throws YAPI_Exception
     */
    protected function _getDev(): ?YDevice
    {
        $devid = $this->_func;
        $dotidx = strpos($devid, '.');
        if ($dotidx !== false) {
            $devid = substr($devid, 0, $dotidx);
        }
        $dev = YAPI::getDevice($devid);
        if (is_null($dev)) {
            $this->_throw(YAPI::DEVICE_NOT_FOUND, "Device [$devid] is not online", null);
        }
        return $dev;
    }

    /**
     * Returns the number of functions (beside the "module" interface) available on the module.
     *
     * @return int  the number of functions on the module
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function functionCount(): int
    {
        $dev = $this->_getDev();
        return $dev->functionCount();
    }

    /**
     * Retrieves the hardware identifier of the <i>n</i>th function on the module.
     *
     * @param int $functionIndex : the index of the function for which the information is desired,
     * starting at 0 for the first function.
     *
     * @return string  a string corresponding to the unambiguous hardware identifier of the requested module function
     *
     * On failure, throws an exception or returns an empty string.
     * @throws YAPI_Exception on error
     */
    public function functionId(int $functionIndex): string
    {
        $dev = $this->_getDev();
        return $dev->functionId($functionIndex);
    }

    public function functionIdByFunYdx(int $functionIndex): string
    {
        $dev = $this->_getDev();
        return $dev->functionIdByFunYdx($functionIndex);
    }

    /**
     * Retrieves the type of the <i>n</i>th function on the module. Yoctopuce functions type names match
     * their class names without the <i>Y</i> prefix, for instance <i>Relay</i>, <i>Temperature</i> etc..
     *
     * @param int $functionIndex : the index of the function for which the information is desired,
     * starting at 0 for the first function.
     *
     * @return string  a string corresponding to the type of the function.
     *
     * On failure, throws an exception or returns an empty string.
     * @throws YAPI_Exception on error
     */
    public function functionType(int $functionIndex): string
    {
        $dev = $this->_getDev();
        return $dev->functionType($functionIndex);
    }

    /**
     * Retrieves the base type of the <i>n</i>th function on the module.
     * For instance, the base type of all measuring functions is "Sensor".
     *
     * @param int $functionIndex : the index of the function for which the information is desired,
     * starting at 0 for the first function.
     *
     * @return string  a string corresponding to the base type of the function
     *
     * On failure, throws an exception or returns an empty string.
     * @throws YAPI_Exception on error
     */
    public function functionBaseType(int $functionIndex): string
    {
        $dev = $this->_getDev();
        return $dev->functionBaseType($functionIndex);
    }


    /**
     * Retrieves the logical name of the <i>n</i>th function on the module.
     *
     * @param int $functionIndex : the index of the function for which the information is desired,
     * starting at 0 for the first function.
     *
     * @return string  a string corresponding to the logical name of the requested module function
     *
     * On failure, throws an exception or returns an empty string.
     * @throws YAPI_Exception on error
     */
    public function functionName(int $functionIndex): string
    {
        $devid = $this->_func;
        $dotidx = strpos($devid, '.');
        if ($dotidx !== false) {
            $devid = substr($devid, 0, $dotidx);
        }
        $dev = YAPI::getDevice($devid);
        return $dev->functionName($functionIndex);
    }

    /**
     * Retrieves the advertised value of the <i>n</i>th function on the module.
     *
     * @param int $functionIndex : the index of the function for which the information is desired,
     * starting at 0 for the first function.
     *
     * @return string  a short string (up to 6 characters) corresponding to the advertised value of the
     * requested module function
     *
     * On failure, throws an exception or returns an empty string.
     * @throws YAPI_Exception on error
     */
    public function functionValue(int $functionIndex): string
    {
        $dev = $this->_getDev();
        return $dev->functionValue($functionIndex);
    }

    protected function _flattenJsonStruct_internal(string $jsoncomplex): string
    {
        $decoded = json_decode($jsoncomplex);
        if ($decoded == null) {
            $this->_throw(YAPI::INVALID_ARGUMENT, 'Invalid json structure');
            return "";
        }
        $attrs = array();
        foreach ($decoded as $function_name => $fuction_attrs) {
            if ($function_name == "services") {
                continue;
            }
            foreach ($fuction_attrs as $attr_name => $attr_value) {
                if (is_object($attr_value)) {
                    // skip complext attributes (move and pulse)
                    continue;
                }
                $flat = $function_name . '/' . $attr_name . '=' . $attr_value;
                $attrs[] = $flat;
            }
        }
        return json_encode($attrs);
    }

    private function get_subDevices_internal(): array
    {
        $serial = $this->get_serialNumber();
        return YAPI::getSubDevicesFrom($serial);
    }

    private function get_parentHub_internal(): string
    {
        $serial = $this->get_serialNumber();
        $hubserial = YAPI::getHubSerialFrom($serial);
        if ($hubserial == $serial) {
            return '';
        }
        return $hubserial;
    }

    private function get_url_internal(): string
    {
        $serial = $this->get_serialNumber();
        return YAPI::getHubURLFrom($serial);
    }

    private function _startStopDevLog_internal(string $str_serial, bool $bool_start): void
    {
        $dev = $this->_getDev();
        if (!($dev == null)) {
            $dev->registerLogCallback($this->_logCallback);
        }
    }

    //--- (generated code: YModule implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'productName':
            $this->_productName = $val;
            return 1;
        case 'serialNumber':
            $this->_serialNumber = $val;
            return 1;
        case 'productId':
            $this->_productId = intval($val);
            return 1;
        case 'productRelease':
            $this->_productRelease = intval($val);
            return 1;
        case 'firmwareRelease':
            $this->_firmwareRelease = $val;
            return 1;
        case 'persistentSettings':
            $this->_persistentSettings = intval($val);
            return 1;
        case 'luminosity':
            $this->_luminosity = intval($val);
            return 1;
        case 'beacon':
            $this->_beacon = intval($val);
            return 1;
        case 'upTime':
            $this->_upTime = intval($val);
            return 1;
        case 'usbCurrent':
            $this->_usbCurrent = intval($val);
            return 1;
        case 'rebootCountdown':
            $this->_rebootCountdown = intval($val);
            return 1;
        case 'userVar':
            $this->_userVar = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the commercial name of the module, as set by the factory.
     *
     * @return string  a string corresponding to the commercial name of the module, as set by the factory
     *
     * On failure, throws an exception or returns YModule::PRODUCTNAME_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_productName(): string
    {
        // $res                    is a string;
        // $dev                    is a YDevice;
        if ($this->_cacheExpiration == 0) {
            $dev = $this->_getDev();
            if (!($dev == null)) {
                return $dev->getProductName();
            }
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PRODUCTNAME_INVALID;
            }
        }
        $res = $this->_productName;
        return $res;
    }

    /**
     * Returns the serial number of the module, as set by the factory.
     *
     * @return string  a string corresponding to the serial number of the module, as set by the factory
     *
     * On failure, throws an exception or returns YModule::SERIALNUMBER_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_serialNumber(): string
    {
        // $res                    is a string;
        // $dev                    is a YDevice;
        if ($this->_cacheExpiration == 0) {
            $dev = $this->_getDev();
            if (!($dev == null)) {
                return $dev->getSerialNumber();
            }
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SERIALNUMBER_INVALID;
            }
        }
        $res = $this->_serialNumber;
        return $res;
    }

    /**
     * Returns the USB device identifier of the module.
     *
     * @return int  an integer corresponding to the USB device identifier of the module
     *
     * On failure, throws an exception or returns YModule::PRODUCTID_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_productId(): int
    {
        // $res                    is a int;
        // $dev                    is a YDevice;
        if ($this->_cacheExpiration == 0) {
            $dev = $this->_getDev();
            if (!($dev == null)) {
                return $dev->getProductId();
            }
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PRODUCTID_INVALID;
            }
        }
        $res = $this->_productId;
        return $res;
    }

    /**
     * Returns the release number of the module hardware, preprogrammed at the factory.
     * The original hardware release returns value 1, revision B returns value 2, etc.
     *
     * @return int  an integer corresponding to the release number of the module hardware, preprogrammed at the factory
     *
     * On failure, throws an exception or returns YModule::PRODUCTRELEASE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_productRelease(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration == 0) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PRODUCTRELEASE_INVALID;
            }
        }
        $res = $this->_productRelease;
        return $res;
    }

    /**
     * Returns the version of the firmware embedded in the module.
     *
     * @return string  a string corresponding to the version of the firmware embedded in the module
     *
     * On failure, throws an exception or returns YModule::FIRMWARERELEASE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_firmwareRelease(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::FIRMWARERELEASE_INVALID;
            }
        }
        $res = $this->_firmwareRelease;
        return $res;
    }

    /**
     * Returns the current state of persistent module settings.
     *
     * @return int  a value among YModule::PERSISTENTSETTINGS_LOADED, YModule::PERSISTENTSETTINGS_SAVED and
     * YModule::PERSISTENTSETTINGS_MODIFIED corresponding to the current state of persistent module settings
     *
     * On failure, throws an exception or returns YModule::PERSISTENTSETTINGS_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_persistentSettings(): int
    {
        // $res                    is a enumFLASHSETTINGS;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PERSISTENTSETTINGS_INVALID;
            }
        }
        $res = $this->_persistentSettings;
        return $res;
    }

    /**
     * @throws YAPI_Exception
     */
    public function set_persistentSettings(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("persistentSettings", $rest_val);
    }

    /**
     * Returns the luminosity of the  module informative LEDs (from 0 to 100).
     *
     * @return int  an integer corresponding to the luminosity of the  module informative LEDs (from 0 to 100)
     *
     * On failure, throws an exception or returns YModule::LUMINOSITY_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_luminosity(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LUMINOSITY_INVALID;
            }
        }
        $res = $this->_luminosity;
        return $res;
    }

    /**
     * Changes the luminosity of the module informative leds. The parameter is a
     * value between 0 and 100.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param int $newval : an integer corresponding to the luminosity of the module informative leds
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_luminosity(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("luminosity", $rest_val);
    }

    /**
     * Returns the state of the localization beacon.
     *
     * @return int  either YModule::BEACON_OFF or YModule::BEACON_ON, according to the state of the localization beacon
     *
     * On failure, throws an exception or returns YModule::BEACON_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_beacon(): int
    {
        // $res                    is a enumONOFF;
        // $dev                    is a YDevice;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            $dev = $this->_getDev();
            if (!($dev == null)) {
                return $dev->getBeacon();
            }
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::BEACON_INVALID;
            }
        }
        $res = $this->_beacon;
        return $res;
    }

    /**
     * Turns on or off the module localization beacon.
     *
     * @param int $newval : either YModule::BEACON_OFF or YModule::BEACON_ON
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_beacon(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("beacon", $rest_val);
    }

    /**
     * Returns the number of milliseconds spent since the module was powered on.
     *
     * @return float  an integer corresponding to the number of milliseconds spent since the module was powered on
     *
     * On failure, throws an exception or returns YModule::UPTIME_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_upTime(): float
    {
        // $res                    is a long;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::UPTIME_INVALID;
            }
        }
        $res = $this->_upTime;
        return $res;
    }

    /**
     * Returns the current consumed by the module on the USB bus, in milli-amps.
     *
     * @return int  an integer corresponding to the current consumed by the module on the USB bus, in milli-amps
     *
     * On failure, throws an exception or returns YModule::USBCURRENT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_usbCurrent(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::USBCURRENT_INVALID;
            }
        }
        $res = $this->_usbCurrent;
        return $res;
    }

    /**
     * Returns the remaining number of seconds before the module restarts, or zero when no
     * reboot has been scheduled.
     *
     * @return int  an integer corresponding to the remaining number of seconds before the module
     * restarts, or zero when no
     *         reboot has been scheduled
     *
     * On failure, throws an exception or returns YModule::REBOOTCOUNTDOWN_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_rebootCountdown(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::REBOOTCOUNTDOWN_INVALID;
            }
        }
        $res = $this->_rebootCountdown;
        return $res;
    }

    /**
     * @throws YAPI_Exception
     */
    public function set_rebootCountdown(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("rebootCountdown", $rest_val);
    }

    /**
     * Returns the value previously stored in this attribute.
     * On startup and after a device reboot, the value is always reset to zero.
     *
     * @return int  an integer corresponding to the value previously stored in this attribute
     *
     * On failure, throws an exception or returns YModule::USERVAR_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_userVar(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::USERVAR_INVALID;
            }
        }
        $res = $this->_userVar;
        return $res;
    }

    /**
     * Stores a 32 bit value in the device RAM. This attribute is at programmer disposal,
     * should he need to store a state variable.
     * On startup and after a device reboot, the value is always reset to zero.
     *
     * @param int $newval : an integer
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_userVar(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("userVar", $rest_val);
    }

    /**
     * Allows you to find a module from its serial number or from its logical name.
     *
     * This function does not require that the module is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the module is
     * indeed online at a given time. In case of ambiguity when looking for
     * a module by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string containing either the serial number or
     *         the logical name of the desired module
     *
     * @return YModule  a YModule object allowing you to drive the module
     *         or get additional information on the module.
     */
    public static function FindModule(string $func): YModule
    {
        // $obj                    is a YModule;
        // $cleanHwId              is a str;
        // $modpos                 is a int;
        $cleanHwId = $func;
        $modpos = YAPI::Ystrpos($func,'.module');
        if ($modpos != (mb_strlen($func) - 7)) {
            $cleanHwId = $func . '.module';
        }
        $obj = YFunction::_FindFromCache('Module', $cleanHwId);
        if ($obj == null) {
            $obj = new YModule($cleanHwId);
            YFunction::_AddToCache('Module', $cleanHwId, $obj);
        }
        return $obj;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_productNameAndRevision(): string
    {
        // $prodname               is a str;
        // $prodrel                is a int;
        // $fullname               is a str;

        $prodname = $this->get_productName();
        $prodrel = $this->get_productRelease();
        if ($prodrel > 1) {
            $fullname = sprintf('%s rev. %c', $prodname, 64 + $prodrel);
        } else {
            $fullname = $prodname;
        }
        return $fullname;
    }

    /**
     * Saves current settings in the nonvolatile memory of the module.
     * Warning: the number of allowed save operations during a module life is
     * limited (about 100000 cycles). Do not call this function within a loop.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function saveToFlash(): int
    {
        return $this->set_persistentSettings(self::PERSISTENTSETTINGS_SAVED);
    }

    /**
     * Reloads the settings stored in the nonvolatile memory, as
     * when the module is powered on.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function revertFromFlash(): int
    {
        return $this->set_persistentSettings(self::PERSISTENTSETTINGS_LOADED);
    }

    /**
     * Schedules a simple module reboot after the given number of seconds.
     *
     * @param int $secBeforeReboot : number of seconds before rebooting
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function reboot(int $secBeforeReboot): int
    {
        return $this->set_rebootCountdown($secBeforeReboot);
    }

    /**
     * Schedules a module reboot into special firmware update mode.
     *
     * @param int $secBeforeReboot : number of seconds before rebooting
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function triggerFirmwareUpdate(int $secBeforeReboot): int
    {
        return $this->set_rebootCountdown(-$secBeforeReboot);
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _startStopDevLog(string $serial, bool $start): void
    {
        $this->_startStopDevLog_internal($serial, $start);
    }

    //cannot be generated for PHP:
    //private function _startStopDevLog_internal(string $serial, bool $start)

    /**
     * Registers a device log callback function. This callback will be called each time
     * that a module sends a new log message. Mostly useful to debug a Yoctopuce module.
     *
     * @param callable $callback : the callback function to call, or a null pointer.
     *         The callback function should take two
     *         arguments: the module object that emitted the log message,
     *         and the character string containing the log.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function registerLogCallback(mixed $callback): int
    {
        // $serial                 is a str;

        $serial = $this->get_serialNumber();
        if ($serial == YAPI::INVALID_STRING) {
            return YAPI::DEVICE_NOT_FOUND;
        }
        $this->_logCallback = $callback;
        $this->_startStopDevLog($serial, !is_null($callback));
        return 0;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_logCallback(): mixed
    {
        return $this->_logCallback;
    }

    /**
     * Register a callback function, to be called when a persistent settings in
     * a device configuration has been changed (e.g. change of unit, etc).
     *
     * @param callable $callback : a procedure taking a YModule parameter, or null
     *         to unregister a previously registered  callback.
     */
    public function registerConfigChangeCallback(mixed $callback): int
    {
        if (!is_null($callback)) {
            YModule::_updateModuleCallbackList($this, true);
        } else {
            YModule::_updateModuleCallbackList($this, false);
        }
        $this->_confChangeCallback = $callback;
        return 0;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _invokeConfigChangeCallback(): int
    {
        if (!is_null($this->_confChangeCallback)) {
            call_user_func($this->_confChangeCallback, $this);
        }
        return 0;
    }

    /**
     * Register a callback function, to be called when the localization beacon of the module
     * has been changed. The callback function should take two arguments: the YModule object of
     * which the beacon has changed, and an integer describing the new beacon state.
     *
     * @param callable $callback : The callback function to call, or null to unregister a
     *         previously registered callback.
     */
    public function registerBeaconCallback(mixed $callback): int
    {
        if (!is_null($callback)) {
            YModule::_updateModuleCallbackList($this, true);
        } else {
            YModule::_updateModuleCallbackList($this, false);
        }
        $this->_beaconCallback = $callback;
        return 0;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _invokeBeaconCallback(int $beaconState): int
    {
        if (!is_null($this->_beaconCallback)) {
            call_user_func($this->_beaconCallback, $this, $beaconState);
        }
        return 0;
    }

    /**
     * Triggers a configuration change callback, to check if they are supported or not.
     */
    public function triggerConfigChangeCallback(): int
    {
        $this->_setAttr('persistentSettings', '2');
        return 0;
    }

    /**
     * Tests whether the byn file is valid for this module. This method is useful to test if the module
     * needs to be updated.
     * It is possible to pass a directory as argument instead of a file. In this case, this method returns
     * the path of the most recent
     * appropriate .byn file. If the parameter onlynew is true, the function discards firmwares that are older or
     * equal to the installed firmware.
     *
     * @param string $path : the path of a byn file or a directory that contains byn files
     * @param boolean $onlynew : returns only files that are strictly newer
     *
     * @return string  the path of the byn file to use or a empty string if no byn files matches the requirement
     *
     * On failure, throws an exception or returns a string that start with "error:".
     * @throws YAPI_Exception on error
     */
    public function checkFirmware(string $path, bool $onlynew): string
    {
        // $serial                 is a str;
        // $release                is a int;
        // $tmp_res                is a str;
        if ($onlynew) {
            $release = intVal($this->get_firmwareRelease());
        } else {
            $release = 0;
        }
        //may throw an exception
        $serial = $this->get_serialNumber();
        $tmp_res = YFirmwareUpdate::CheckFirmware($serial, $path, $release);
        if (YAPI::Ystrpos($tmp_res,'error:') == 0) {
            $this->_throw(YAPI::INVALID_ARGUMENT, $tmp_res);
        }
        return $tmp_res;
    }

    /**
     * Prepares a firmware update of the module. This method returns a YFirmwareUpdate object which
     * handles the firmware update process.
     *
     * @param string $path : the path of the .byn file to use.
     * @param boolean $force : true to force the firmware update even if some prerequisites appear not to be met
     *
     * @return ?YFirmwareUpdate  a YFirmwareUpdate object or NULL on error.
     */
    public function updateFirmwareEx(string $path, bool $force): ?YFirmwareUpdate
    {
        // $serial                 is a str;
        // $settings               is a bin;

        $serial = $this->get_serialNumber();
        $settings = $this->get_allSettings();
        if (strlen($settings) == 0) {
            $this->_throw(YAPI::IO_ERROR, 'Unable to get device settings');
            $settings = YAPI::Ystr2bin('error:Unable to get device settings');
        }
        return new YFirmwareUpdate($serial, $path, $settings, $force);
    }

    /**
     * Prepares a firmware update of the module. This method returns a YFirmwareUpdate object which
     * handles the firmware update process.
     *
     * @param string $path : the path of the .byn file to use.
     *
     * @return ?YFirmwareUpdate  a YFirmwareUpdate object or NULL on error.
     */
    public function updateFirmware(string $path): ?YFirmwareUpdate
    {
        return $this->updateFirmwareEx($path, false);
    }

    /**
     * Returns all the settings and uploaded files of the module. Useful to backup all the
     * logical names, calibrations parameters, and uploaded files of a device.
     *
     * @return string  a binary buffer with all the settings.
     *
     * On failure, throws an exception or returns an binary object of size 0.
     * @throws YAPI_Exception on error
     */
    public function get_allSettings(): string
    {
        // $settings               is a bin;
        // $json                   is a bin;
        // $res                    is a bin;
        // $sep                    is a str;
        // $name                   is a str;
        // $item                   is a str;
        // $t_type                 is a str;
        // $pageid                 is a str;
        // $url                    is a str;
        // $file_data              is a str;
        // $file_data_bin          is a bin;
        // $temp_data_bin          is a bin;
        // $ext_settings           is a str;
        $filelist = [];         // binArr;
        $templist = [];         // strArr;

        $settings = $this->_download('api.json');
        if (strlen($settings) == 0) {
            return $settings;
        }
        $ext_settings = ', "extras":[';
        $templist = $this->get_functionIds('Temperature');
        $sep = '';
        foreach ($templist as $each) {
            if (intVal($this->get_firmwareRelease()) > 9000) {
                $url = sprintf('api/%s/sensorType',$each);
                $t_type = YAPI::Ybin2str($this->_download($url));
                if ($t_type == 'RES_NTC' || $t_type == 'RES_LINEAR') {
                    $pageid = substr($each, 11, mb_strlen($each) - 11);
                    if ($pageid == '') {
                        $pageid = '1';
                    }
                    $temp_data_bin = $this->_download(sprintf('extra.json?page=%s', $pageid));
                    if (strlen($temp_data_bin) > 0) {
                        $item = sprintf('%s{"fid":"%s", "json":%s}'."\n".'', $sep, $each, YAPI::Ybin2str($temp_data_bin));
                        $ext_settings = $ext_settings . $item;
                        $sep = ',';
                    }
                }
            }
        }
        $ext_settings = $ext_settings . '],'."\n".'"files":[';
        if ($this->hasFunction('files')) {
            $json = $this->_download('files.json?a=dir&f=');
            if (strlen($json) == 0) {
                return $json;
            }
            $filelist = $this->_json_get_array($json);
            $sep = '';
            foreach ($filelist as $each) {
                $name = $this->_json_get_key($each, 'name');
                if ((mb_strlen($name) > 0) && !($name == 'startupConf.json')) {
                    $file_data_bin = $this->_download($this->_escapeAttr($name));
                    $file_data = YAPI::_bytesToHexStr($file_data_bin);
                    $item = sprintf('%s{"name":"%s", "data":"%s"}'."\n".'', $sep, $name, $file_data);
                    $ext_settings = $ext_settings . $item;
                    $sep = ',';
                }
            }
        }
        $res = YAPI::Ystr2bin('{ "api":' . YAPI::Ybin2str($settings) . $ext_settings . ']}');
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function loadThermistorExtra(string $funcId, string $jsonExtra): int
    {
        $values = [];           // binArr;
        // $url                    is a str;
        // $curr                   is a str;
        // $binCurr                is a bin;
        // $currTemp               is a str;
        // $binCurrTemp            is a bin;
        // $ofs                    is a int;
        // $size                   is a int;
        $url = 'api/' . $funcId . '.json?command=Z';

        $this->_download($url);
        // add records in growing resistance value
        $values = $this->_json_get_array(YAPI::Ystr2bin($jsonExtra));
        $ofs = 0;
        $size = sizeof($values);
        while ($ofs + 1 < $size) {
            $binCurr = $values[$ofs];
            $binCurrTemp = $values[$ofs + 1];
            $curr = $this->_json_get_string($binCurr);
            $currTemp = $this->_json_get_string($binCurrTemp);
            $url = sprintf('api/%s.json?command=m%s:%s', $funcId, $curr, $currTemp);
            $this->_download($url);
            $ofs = $ofs + 2;
        }
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function set_extraSettings(string $jsonExtra): int
    {
        $extras = [];           // binArr;
        // $tmp                    is a bin;
        // $functionId             is a str;
        // $data                   is a bin;
        $extras = $this->_json_get_array(YAPI::Ystr2bin($jsonExtra));
        foreach ($extras as $each) {
            $tmp = $this->_get_json_path($each, 'fid');
            $functionId = $this->_json_get_string($tmp);
            $data = $this->_get_json_path($each, 'json');
            if ($this->hasFunction($functionId)) {
                $this->loadThermistorExtra($functionId, YAPI::Ybin2str($data));
            }
        }
        return YAPI::SUCCESS;
    }

    /**
     * Restores all the settings and uploaded files to the module.
     * This method is useful to restore all the logical names and calibrations parameters,
     * uploaded files etc. of a device from a backup.
     * Remember to call the saveToFlash() method of the module if the
     * modifications must be kept.
     *
     * @param string $settings : a binary buffer with all the settings.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_allSettingsAndFiles(string $settings): int
    {
        // $down                   is a bin;
        // $json_bin               is a bin;
        // $json_api               is a bin;
        // $json_files             is a bin;
        // $json_extra             is a bin;
        // $fuperror               is a int;
        // $globalres              is a int;
        $fuperror = 0;
        $json_api = $this->_get_json_path($settings, 'api');
        if (strlen($json_api) == 0) {
            return $this->set_allSettings($settings);
        }
        $json_extra = $this->_get_json_path($settings, 'extras');
        if (strlen($json_extra) > 0) {
            $this->set_extraSettings(YAPI::Ybin2str($json_extra));
        }
        $this->set_allSettings($json_api);
        if ($this->hasFunction('files')) {
            $files = [];            // binArr;
            // $res                    is a str;
            // $tmp                    is a bin;
            // $name                   is a str;
            // $data                   is a str;
            $down = $this->_download('files.json?a=format');
            $down = $this->_get_json_path($down, 'res');
            $res = $this->_json_get_string($down);
            if (!($res == 'ok')) return $this->_throw(YAPI::IO_ERROR,'format failed',YAPI::IO_ERROR);
            $json_files = $this->_get_json_path($settings, 'files');
            $files = $this->_json_get_array($json_files);
            foreach ($files as $each) {
                $tmp = $this->_get_json_path($each, 'name');
                $name = $this->_json_get_string($tmp);
                $tmp = $this->_get_json_path($each, 'data');
                $data = $this->_json_get_string($tmp);
                if ($name == '') {
                    $fuperror = $fuperror + 1;
                } else {
                    $this->_upload($name, YAPI::_hexStrToBin($data));
                }
            }
        }
        // Apply settings a second time for file-dependent settings and dynamic sensor nodes
        $globalres = $this->set_allSettings($json_api);
        if (!($fuperror == 0)) return $this->_throw(YAPI::IO_ERROR,'Error during file upload',YAPI::IO_ERROR);
        return $globalres;
    }

    /**
     * Tests if the device includes a specific function. This method takes a function identifier
     * and returns a boolean.
     *
     * @param string $funcId : the requested function identifier
     *
     * @return boolean  true if the device has the function identifier
     */
    public function hasFunction(string $funcId): bool
    {
        // $count                  is a int;
        // $i                      is a int;
        // $fid                    is a str;

        $count = $this->functionCount();
        $i = 0;
        while ($i < $count) {
            $fid = $this->functionId($i);
            if ($fid == $funcId) {
                return true;
            }
            $i = $i + 1;
        }
        return false;
    }

    /**
     * Retrieve all hardware identifier that match the type passed in argument.
     *
     * @param string $funType : The type of function (Relay, LightSensor, Voltage,...)
     *
     * @return string[]  an array of strings.
     */
    public function get_functionIds(string $funType): array
    {
        // $count                  is a int;
        // $i                      is a int;
        // $ftype                  is a str;
        $res = [];              // strArr;

        $count = $this->functionCount();
        $i = 0;
        while ($i < $count) {
            $ftype = $this->functionType($i);
            if ($ftype == $funType) {
                $res[] = $this->functionId($i);
            } else {
                $ftype = $this->functionBaseType($i);
                if ($ftype == $funType) {
                    $res[] = $this->functionId($i);
                }
            }
            $i = $i + 1;
        }
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _flattenJsonStruct(string $jsoncomplex): string
    {
        return $this->_flattenJsonStruct_internal($jsoncomplex);
    }

    //cannot be generated for PHP:
    //private function _flattenJsonStruct_internal(string $jsoncomplex)

    /**
     * @throws YAPI_Exception on error
     */
    public function calibVersion(string $cparams): int
    {
        if ($cparams == '0,') {
            return 3;
        }
        if (YAPI::Ystrpos($cparams,',') >= 0) {
            if (YAPI::Ystrpos($cparams,' ') > 0) {
                return 3;
            } else {
                return 1;
            }
        }
        if ($cparams == '' || $cparams == '0') {
            return 1;
        }
        if ((mb_strlen($cparams) < 2) || (YAPI::Ystrpos($cparams,'.') >= 0)) {
            return 0;
        } else {
            return 2;
        }
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function calibScale(string $unit_name, string $sensorType): int
    {
        if ($unit_name == 'g' || $unit_name == 'gauss' || $unit_name == 'W') {
            return 1000;
        }
        if ($unit_name == 'C') {
            if ($sensorType == '') {
                return 16;
            }
            if (intVal($sensorType) < 8) {
                return 16;
            } else {
                return 100;
            }
        }
        if ($unit_name == 'm' || $unit_name == 'deg') {
            return 10;
        }
        return 1;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function calibOffset(string $unit_name): int
    {
        if ($unit_name == '% RH' || $unit_name == 'mbar' || $unit_name == 'lx') {
            return 0;
        }
        return 32767;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function calibConvert(string $param, string $currentFuncValue, string $unit_name, string $sensorType): string
    {
        // $paramVer               is a int;
        // $funVer                 is a int;
        // $funScale               is a int;
        // $funOffset              is a int;
        // $paramScale             is a int;
        // $paramOffset            is a int;
        $words = [];            // intArr;
        $words_str = [];        // strArr;
        $calibData = [];        // floatArr;
        $iCalib = [];           // intArr;
        // $calibType              is a int;
        // $i                      is a int;
        // $maxSize                is a int;
        // $ratio                  is a float;
        // $nPoints                is a int;
        // $wordVal                is a float;
        // Initial guess for parameter encoding
        $paramVer = $this->calibVersion($param);
        $funVer = $this->calibVersion($currentFuncValue);
        $funScale = $this->calibScale($unit_name, $sensorType);
        $funOffset = $this->calibOffset($unit_name);
        $paramScale = $funScale;
        $paramOffset = $funOffset;
        if ($funVer < 3) {
            // Read the effective device scale if available
            if ($funVer == 2) {
                $words = YAPI::_decodeWords($currentFuncValue);
                if (($words[0] == 1366) && ($words[1] == 12500)) {
                    // Yocto-3D RefFrame used a special encoding
                    $funScale = 1;
                    $funOffset = 0;
                } else {
                    $funScale = $words[1];
                    $funOffset = $words[0];
                }
            } else {
                if ($funVer == 1) {
                    if ($currentFuncValue == '' || (intVal($currentFuncValue) > 10)) {
                        $funScale = 0;
                    }
                }
            }
        }
        while (sizeof($calibData) > 0) {
            array_pop($calibData);
        };
        $calibType = 0;
        if ($paramVer < 3) {
            // Handle old 16 bit parameters formats
            if ($paramVer == 2) {
                $words = YAPI::_decodeWords($param);
                if (($words[0] == 1366) && ($words[1] == 12500)) {
                    // Yocto-3D RefFrame used a special encoding
                    $paramScale = 1;
                    $paramOffset = 0;
                } else {
                    $paramScale = $words[1];
                    $paramOffset = $words[0];
                }
                if ((sizeof($words) >= 3) && ($words[2] > 0)) {
                    $maxSize = 3 + 2 * (($words[2]) % (10));
                    if ($maxSize > sizeof($words)) {
                        $maxSize = sizeof($words);
                    }
                    $i = 3;
                    while ($i < $maxSize) {
                        $calibData[] = $words[$i];
                        $i = $i + 1;
                    }
                }
            } else {
                if ($paramVer == 1) {
                    $words_str = explode(',', $param);
                    foreach ($words_str as $each) {
                        $words[] = intVal($each);
                    }
                    if ($param == '' || ($words[0] > 10)) {
                        $paramScale = 0;
                    }
                    if ((sizeof($words) > 0) && ($words[0] > 0)) {
                        $maxSize = 1 + 2 * (($words[0]) % (10));
                        if ($maxSize > sizeof($words)) {
                            $maxSize = sizeof($words);
                        }
                        $i = 1;
                        while ($i < $maxSize) {
                            $calibData[] = $words[$i];
                            $i = $i + 1;
                        }
                    }
                } else {
                    if ($paramVer == 0) {
                        $ratio = floatval($param);
                        if ($ratio > 0) {
                            $calibData[] = 0.0;
                            $calibData[] = 0.0;
                            $calibData[] = round(65535 / $ratio);
                            $calibData[] = 65535.0;
                        }
                    }
                }
            }
            $i = 0;
            while ($i < sizeof($calibData)) {
                if ($paramScale > 0) {
                    // scalar decoding
                    $calibData[$i] = ($calibData[$i] - $paramOffset) / $paramScale;
                } else {
                    // floating-point decoding
                    $calibData[$i] = YAPI::_decimalToDouble(intval(round($calibData[$i])));
                }
                $i = $i + 1;
            }
        } else {
            // Handle latest 32bit parameter format
            $iCalib = YAPI::_decodeFloats($param);
            $calibType = intval(round($iCalib[0] / 1000.0));
            if ($calibType >= 30) {
                $calibType = $calibType - 30;
            }
            $i = 1;
            while ($i < sizeof($iCalib)) {
                $calibData[] = $iCalib[$i] / 1000.0;
                $i = $i + 1;
            }
        }
        if ($funVer >= 3) {
            // Encode parameters in new format
            if (sizeof($calibData) == 0) {
                $param = '0,';
            } else {
                $param = 30 + $calibType;
                $i = 0;
                while ($i < sizeof($calibData)) {
                    if ((($i) & 1) > 0) {
                        $param = $param . ':';
                    } else {
                        $param = $param . ' ';
                    }
                    $param = $param . intval(round($calibData[$i] * 1000.0 / 1000.0));
                    $i = $i + 1;
                }
                $param = $param . ',';
            }
        } else {
            if ($funVer >= 1) {
                // Encode parameters for older devices
                $nPoints = intVal((sizeof($calibData)) / (2));
                $param = $nPoints;
                $i = 0;
                while ($i < 2 * $nPoints) {
                    if ($funScale == 0) {
                        $wordVal = YAPI::_doubleToDecimal(intval(round($calibData[$i])));
                    } else {
                        $wordVal = $calibData[$i] * $funScale + $funOffset;
                    }
                    $param = $param . ',' . round($wordVal);
                    $i = $i + 1;
                }
            } else {
                // Initial V0 encoding used for old Yocto-Light
                if (sizeof($calibData) == 4) {
                    $param = round(1000 * ($calibData[3] - $calibData[1]) / $calibData[2] - $calibData[0]);
                }
            }
        }
        return $param;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _tryExec(string $url): int
    {
        // $res                    is a int;
        // $done                   is a int;
        $res = YAPI::SUCCESS;
        $done = 1;
        try {
            $this->_download($url);
        } catch (Exception $ex) {
            $done = 0;
        }
        if ($done == 0) {
            // retry silently after a short wait
            try {
                YAPI::Sleep(500);
                $this->_download($url);
            } catch (Exception $ex) {
                // second failure, return error code
                $res = $this->get_errorType();
            }
        }
        return $res;
    }

    /**
     * Restores all the settings of the device. Useful to restore all the logical names and calibrations parameters
     * of a module from a backup.Remember to call the saveToFlash() method of the module if the
     * modifications must be kept.
     *
     * @param string $settings : a binary buffer with all the settings.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_allSettings(string $settings): int
    {
        $restoreLast = [];      // strArr;
        // $old_json_flat          is a bin;
        $old_dslist = [];       // binArr;
        $old_jpath = [];        // strArr;
        $old_jpath_len = [];    // intArr;
        $old_val_arr = [];      // strArr;
        // $actualSettings         is a bin;
        $new_dslist = [];       // binArr;
        $new_jpath = [];        // strArr;
        $new_jpath_len = [];    // intArr;
        $new_val_arr = [];      // strArr;
        // $cpos                   is a int;
        // $eqpos                  is a int;
        // $leng                   is a int;
        // $i                      is a int;
        // $j                      is a int;
        // $subres                 is a int;
        // $res                    is a int;
        // $njpath                 is a str;
        // $jpath                  is a str;
        // $fun                    is a str;
        // $attr                   is a str;
        // $value                  is a str;
        // $old_serial             is a str;
        // $new_serial             is a str;
        // $url                    is a str;
        // $tmp                    is a str;
        // $binTmp                 is a bin;
        // $sensorType             is a str;
        // $unit_name              is a str;
        // $newval                 is a str;
        // $oldval                 is a str;
        // $old_calib              is a str;
        // $each_str               is a str;
        // $do_update              is a bool;
        // $found                  is a bool;
        $res = YAPI::SUCCESS;
        $binTmp = $this->_get_json_path($settings, 'api');
        if (strlen($binTmp) > 0) {
            $settings = $binTmp;
        }
        $old_serial = '';
        $oldval = '';
        $newval = '';
        $old_json_flat = $this->_flattenJsonStruct($settings);
        $old_dslist = $this->_json_get_array($old_json_flat);
        foreach ($old_dslist as $each) {
            $each_str = $this->_json_get_string($each);
            // split json path and attr
            $leng = mb_strlen($each_str);
            $eqpos = YAPI::Ystrpos($each_str,'=');
            if (($eqpos < 0) || ($leng == 0)) {
                $this->_throw(YAPI::INVALID_ARGUMENT, 'Invalid settings');
                return YAPI::INVALID_ARGUMENT;
            }
            $jpath = substr($each_str, 0, $eqpos);
            $eqpos = $eqpos + 1;
            $value = substr($each_str, $eqpos, $leng - $eqpos);
            $old_jpath[] = $jpath;
            $old_jpath_len[] = mb_strlen($jpath);
            $old_val_arr[] = $value;
            if ($jpath == 'module/serialNumber') {
                $old_serial = $value;
            }
        }

        try {
            $actualSettings = $this->_download('api.json');
        } catch (Exception $ex) {
            // retry silently after a short wait
            YAPI::Sleep(500);
            $actualSettings = $this->_download('api.json');
        }
        $new_serial = $this->get_serialNumber();
        if ($old_serial == $new_serial || $old_serial == '') {
            $old_serial = '_NO_SERIAL_FILTER_';
        }
        $actualSettings = $this->_flattenJsonStruct($actualSettings);
        $new_dslist = $this->_json_get_array($actualSettings);
        foreach ($new_dslist as $each) {
            // remove quotes
            $each_str = $this->_json_get_string($each);
            // split json path and attr
            $leng = mb_strlen($each_str);
            $eqpos = YAPI::Ystrpos($each_str,'=');
            if (($eqpos < 0) || ($leng == 0)) {
                $this->_throw(YAPI::INVALID_ARGUMENT, 'Invalid settings');
                return YAPI::INVALID_ARGUMENT;
            }
            $jpath = substr($each_str, 0, $eqpos);
            $eqpos = $eqpos + 1;
            $value = substr($each_str, $eqpos, $leng - $eqpos);
            $new_jpath[] = $jpath;
            $new_jpath_len[] = mb_strlen($jpath);
            $new_val_arr[] = $value;
        }
        $i = 0;
        while ($i < sizeof($new_jpath)) {
            $njpath = $new_jpath[$i];
            $leng = mb_strlen($njpath);
            $cpos = YAPI::Ystrpos($njpath,'/');
            if (($cpos < 0) || ($leng == 0)) {
                continue;
            }
            $fun = substr($njpath, 0, $cpos);
            $cpos = $cpos + 1;
            $attr = substr($njpath, $cpos, $leng - $cpos);
            $do_update = true;
            if ($fun == 'services') {
                $do_update = false;
            }
            if ($do_update && ($attr == 'firmwareRelease')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'usbCurrent')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'upTime')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'persistentSettings')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'adminPassword')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'userPassword')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'rebootCountdown')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'advertisedValue')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'poeCurrent')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'readiness')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'ipAddress')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'subnetMask')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'router')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'linkQuality')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'ssid')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'channel')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'security')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'message')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'signalValue')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'currentValue')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'currentRawValue')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'currentRunIndex')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'pulseTimer')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'lastTimePressed')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'lastTimeReleased')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'filesCount')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'freeSpace')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'timeUTC')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'rtcTime')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'unixTime')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'dateTime')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'rawValue')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'lastMsg')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'delayedPulseTimer')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'rxCount')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'txCount')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'msgCount')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'rxMsgCount')) {
                $do_update = false;
            }
            if ($do_update && ($attr == 'txMsgCount')) {
                $do_update = false;
            }
            if ($do_update) {
                $do_update = false;
                $j = 0;
                $found = false;
                $newval = $new_val_arr[$i];
                while (($j < sizeof($old_jpath)) && !($found)) {
                    if (($new_jpath_len[$i] == $old_jpath_len[$j]) && ($new_jpath[$i] == $old_jpath[$j])) {
                        $found = true;
                        $oldval = $old_val_arr[$j];
                        if (!($newval == $oldval) && !($oldval == $old_serial)) {
                            $do_update = true;
                        }
                    }
                    $j = $j + 1;
                }
            }
            if ($do_update) {
                if ($attr == 'calibrationParam') {
                    $old_calib = '';
                    $unit_name = '';
                    $sensorType = '';
                    $j = 0;
                    $found = false;
                    while (($j < sizeof($old_jpath)) && !($found)) {
                        if (($new_jpath_len[$i] == $old_jpath_len[$j]) && ($new_jpath[$i] == $old_jpath[$j])) {
                            $found = true;
                            $old_calib = $old_val_arr[$j];
                        }
                        $j = $j + 1;
                    }
                    $tmp = $fun . '/unit';
                    $j = 0;
                    $found = false;
                    while (($j < sizeof($new_jpath)) && !($found)) {
                        if ($tmp == $new_jpath[$j]) {
                            $found = true;
                            $unit_name = $new_val_arr[$j];
                        }
                        $j = $j + 1;
                    }
                    $tmp = $fun . '/sensorType';
                    $j = 0;
                    $found = false;
                    while (($j < sizeof($new_jpath)) && !($found)) {
                        if ($tmp == $new_jpath[$j]) {
                            $found = true;
                            $sensorType = $new_val_arr[$j];
                        }
                        $j = $j + 1;
                    }
                    $newval = $this->calibConvert($old_calib, $new_val_arr[$i], $unit_name, $sensorType);
                    $url = 'api/' . $fun . '.json?' . $attr . '=' . $this->_escapeAttr($newval);
                    $subres = $this->_tryExec($url);
                    if (($res == YAPI::SUCCESS) && ($subres != YAPI::SUCCESS)) {
                        $res = $subres;
                    }
                } else {
                    $url = 'api/' . $fun . '.json?' . $attr . '=' . $this->_escapeAttr($oldval);
                    if ($attr == 'resolution') {
                        $restoreLast[] = $url;
                    } else {
                        $subres = $this->_tryExec($url);
                        if (($res == YAPI::SUCCESS) && ($subres != YAPI::SUCCESS)) {
                            $res = $subres;
                        }
                    }
                }
            }
            $i = $i + 1;
        }
        foreach ($restoreLast as $each) {
            $subres = $this->_tryExec($each);
            if (($res == YAPI::SUCCESS) && ($subres != YAPI::SUCCESS)) {
                $res = $subres;
            }
        }
        $this->clearCache();
        return $res;
    }

    /**
     * Adds a file to the uploaded data at the next HTTP callback.
     * This function only affects the next HTTP callback and only works in
     * HTTP callback mode.
     *
     * @param string $filename : the name of the file to upload at the next HTTP callback
     *
     * @return int  nothing.
     */
    public function addFileToHTTPCallback(string $filename): int
    {
        // $content                is a bin;

        $content = $this->_download('@YCB+' . $filename);
        if (strlen($content) == 0) {
            return YAPI::NOT_SUPPORTED;
        }
        return YAPI::SUCCESS;
    }

    /**
     * Returns the unique hardware identifier of the module.
     * The unique hardware identifier is made of the device serial
     * number followed by string ".module".
     *
     * @return string  a string that uniquely identifies the module
     */
    public function get_hardwareId(): string
    {
        // $serial                 is a str;

        $serial = $this->get_serialNumber();
        return $serial . '.module';
    }

    /**
     * Downloads the specified built-in file and returns a binary buffer with its content.
     *
     * @param string $pathname : name of the new file to load
     *
     * @return string  a binary buffer with the file content
     *
     * On failure, throws an exception or returns  YAPI::INVALID_STRING.
     * @throws YAPI_Exception on error
     */
    public function download(string $pathname): string
    {
        return $this->_download($pathname);
    }

    /**
     * Returns the icon of the module. The icon is a PNG image and does not
     * exceed 1536 bytes.
     *
     * @return string  a binary buffer with module icon, in png format.
     *         On failure, throws an exception or returns  YAPI::INVALID_STRING.
     * @throws YAPI_Exception on error
     */
    public function get_icon2d(): string
    {
        return $this->_download('icon2d.png');
    }

    /**
     * Returns a string with last logs of the module. This method return only
     * logs that are still in the module.
     *
     * @return string  a string with last logs of the module.
     *         On failure, throws an exception or returns  YAPI::INVALID_STRING.
     * @throws YAPI_Exception on error
     */
    public function get_lastLogs(): string
    {
        // $content                is a bin;

        $content = $this->_download('logs.txt');
        return YAPI::Ybin2str($content);
    }

    /**
     * Adds a text message to the device logs. This function is useful in
     * particular to trace the execution of HTTP callbacks. If a newline
     * is desired after the message, it must be included in the string.
     *
     * @param string $text : the string to append to the logs.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function log(string $text): int
    {
        return $this->_upload('logs.txt', YAPI::Ystr2bin($text));
    }

    /**
     * Returns a list of all the modules that are plugged into the current module.
     * This method only makes sense when called for a YoctoHub/VirtualHub.
     * Otherwise, an empty array will be returned.
     *
     * @return string[]  an array of strings containing the sub modules.
     */
    public function get_subDevices(): array
    {
        return $this->get_subDevices_internal();
    }

    //cannot be generated for PHP:
    //private function get_subDevices_internal()

    /**
     * Returns the serial number of the YoctoHub on which this module is connected.
     * If the module is connected by USB, or if the module is the root YoctoHub, an
     * empty string is returned.
     *
     * @return string  a string with the serial number of the YoctoHub or an empty string
     */
    public function get_parentHub(): string
    {
        return $this->get_parentHub_internal();
    }

    //cannot be generated for PHP:
    //private function get_parentHub_internal()

    /**
     * Returns the URL used to access the module. If the module is connected by USB, the
     * string 'usb' is returned.
     *
     * @return string  a string with the URL of the module.
     */
    public function get_url(): string
    {
        return $this->get_url_internal();
    }

    //cannot be generated for PHP:
    //private function get_url_internal()

    /**
     * @throws YAPI_Exception
     */
    public function productName(): string
{
    return $this->get_productName();
}

    /**
     * @throws YAPI_Exception
     */
    public function serialNumber(): string
{
    return $this->get_serialNumber();
}

    /**
     * @throws YAPI_Exception
     */
    public function productId(): int
{
    return $this->get_productId();
}

    /**
     * @throws YAPI_Exception
     */
    public function productRelease(): int
{
    return $this->get_productRelease();
}

    /**
     * @throws YAPI_Exception
     */
    public function firmwareRelease(): string
{
    return $this->get_firmwareRelease();
}

    /**
     * @throws YAPI_Exception
     */
    public function persistentSettings(): int
{
    return $this->get_persistentSettings();
}

    /**
     * @throws YAPI_Exception
     */
    public function setPersistentSettings(int $newval): int
{
    return $this->set_persistentSettings($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function luminosity(): int
{
    return $this->get_luminosity();
}

    /**
     * @throws YAPI_Exception
     */
    public function setLuminosity(int $newval): int
{
    return $this->set_luminosity($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function beacon(): int
{
    return $this->get_beacon();
}

    /**
     * @throws YAPI_Exception
     */
    public function setBeacon(int $newval): int
{
    return $this->set_beacon($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function upTime(): float
{
    return $this->get_upTime();
}

    /**
     * @throws YAPI_Exception
     */
    public function usbCurrent(): int
{
    return $this->get_usbCurrent();
}

    /**
     * @throws YAPI_Exception
     */
    public function rebootCountdown(): int
{
    return $this->get_rebootCountdown();
}

    /**
     * @throws YAPI_Exception
     */
    public function setRebootCountdown(int $newval): int
{
    return $this->set_rebootCountdown($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function userVar(): int
{
    return $this->get_userVar();
}

    /**
     * @throws YAPI_Exception
     */
    public function setUserVar(int $newval): int
{
    return $this->set_userVar($newval);
}

    /**
     * Continues the module enumeration started using yFirstModule().
     * Caution: You can't make any assumption about the returned modules order.
     * If you want to find a specific module, use Module.findModule()
     * and a hardwareID or a logical name.
     *
     * @return ?YModule  a pointer to a YModule object, corresponding to
     *         the next module found, or a null pointer
     *         if there are no more modules to enumerate.
     */
    public function nextModule(): ?YModule
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindModule($next_hwid);
    }

    /**
     * Starts the enumeration of modules currently accessible.
     * Use the method YModule::nextModule() to iterate on the
     * next modules.
     *
     * @return ?YModule  a pointer to a YModule object, corresponding to
     *         the first module currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstModule(): ?YModule
    {
        $next_hwid = YAPI::getFirstHardwareId('Module');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindModule($next_hwid);
    }

    //--- (end of generated code: YModule implementation)
}

