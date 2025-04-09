<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YCellular Class: cellular interface control interface, available for instance in the
 * YoctoHub-GSM-2G, the YoctoHub-GSM-3G-EU, the YoctoHub-GSM-3G-NA or the YoctoHub-GSM-4G
 *
 * The YCellular class provides control over cellular network parameters
 * and status for devices that are GSM-enabled.
 * Note that TCP/IP parameters are configured separately, using class YNetwork.
 */
class YCellular extends YFunction
{
    const LINKQUALITY_INVALID = YAPI::INVALID_UINT;
    const CELLOPERATOR_INVALID = YAPI::INVALID_STRING;
    const CELLIDENTIFIER_INVALID = YAPI::INVALID_STRING;
    const CELLTYPE_GPRS = 0;
    const CELLTYPE_EGPRS = 1;
    const CELLTYPE_WCDMA = 2;
    const CELLTYPE_HSDPA = 3;
    const CELLTYPE_NONE = 4;
    const CELLTYPE_CDMA = 5;
    const CELLTYPE_LTE_M = 6;
    const CELLTYPE_NB_IOT = 7;
    const CELLTYPE_EC_GSM_IOT = 8;
    const CELLTYPE_INVALID = -1;
    const IMSI_INVALID = YAPI::INVALID_STRING;
    const MESSAGE_INVALID = YAPI::INVALID_STRING;
    const PIN_INVALID = YAPI::INVALID_STRING;
    const RADIOCONFIG_INVALID = YAPI::INVALID_STRING;
    const LOCKEDOPERATOR_INVALID = YAPI::INVALID_STRING;
    const AIRPLANEMODE_OFF = 0;
    const AIRPLANEMODE_ON = 1;
    const AIRPLANEMODE_INVALID = -1;
    const ENABLEDATA_HOMENETWORK = 0;
    const ENABLEDATA_ROAMING = 1;
    const ENABLEDATA_NEVER = 2;
    const ENABLEDATA_NEUTRALITY = 3;
    const ENABLEDATA_INVALID = -1;
    const APN_INVALID = YAPI::INVALID_STRING;
    const APNSECRET_INVALID = YAPI::INVALID_STRING;
    const PINGINTERVAL_INVALID = YAPI::INVALID_UINT;
    const DATASENT_INVALID = YAPI::INVALID_UINT;
    const DATARECEIVED_INVALID = YAPI::INVALID_UINT;
    const COMMAND_INVALID = YAPI::INVALID_STRING;
    //--- (end of generated code: YCellular declaration)

    //--- (generated code: YCellular attributes)
    protected int $_linkQuality = self::LINKQUALITY_INVALID;    // Percent
    protected string $_cellOperator = self::CELLOPERATOR_INVALID;   // Text
    protected string $_cellIdentifier = self::CELLIDENTIFIER_INVALID; // Text
    protected int $_cellType = self::CELLTYPE_INVALID;       // CellType
    protected string $_imsi = self::IMSI_INVALID;           // IMSI
    protected string $_message = self::MESSAGE_INVALID;        // YFSText
    protected string $_pin = self::PIN_INVALID;            // PinPassword
    protected string $_radioConfig = self::RADIOCONFIG_INVALID;    // RadioConfig
    protected string $_lockedOperator = self::LOCKEDOPERATOR_INVALID; // Text
    protected int $_airplaneMode = self::AIRPLANEMODE_INVALID;   // OnOff
    protected int $_enableData = self::ENABLEDATA_INVALID;     // ServiceScope
    protected string $_apn = self::APN_INVALID;            // Text
    protected string $_apnSecret = self::APNSECRET_INVALID;      // APNPassword
    protected int $_pingInterval = self::PINGINTERVAL_INVALID;   // UInt31
    protected int $_dataSent = self::DATASENT_INVALID;       // UInt31
    protected int $_dataReceived = self::DATARECEIVED_INVALID;   // UInt31
    protected string $_command = self::COMMAND_INVALID;        // Text

    //--- (end of generated code: YCellular attributes)

    function __construct(string $str_func)
    {
        //--- (generated code: YCellular constructor)
        parent::__construct($str_func);
        $this->_className = 'Cellular';

        //--- (end of generated code: YCellular constructor)
    }

    //--- (generated code: YCellular implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'linkQuality':
            $this->_linkQuality = intval($val);
            return 1;
        case 'cellOperator':
            $this->_cellOperator = $val;
            return 1;
        case 'cellIdentifier':
            $this->_cellIdentifier = $val;
            return 1;
        case 'cellType':
            $this->_cellType = intval($val);
            return 1;
        case 'imsi':
            $this->_imsi = $val;
            return 1;
        case 'message':
            $this->_message = $val;
            return 1;
        case 'pin':
            $this->_pin = $val;
            return 1;
        case 'radioConfig':
            $this->_radioConfig = $val;
            return 1;
        case 'lockedOperator':
            $this->_lockedOperator = $val;
            return 1;
        case 'airplaneMode':
            $this->_airplaneMode = intval($val);
            return 1;
        case 'enableData':
            $this->_enableData = intval($val);
            return 1;
        case 'apn':
            $this->_apn = $val;
            return 1;
        case 'apnSecret':
            $this->_apnSecret = $val;
            return 1;
        case 'pingInterval':
            $this->_pingInterval = intval($val);
            return 1;
        case 'dataSent':
            $this->_dataSent = intval($val);
            return 1;
        case 'dataReceived':
            $this->_dataReceived = intval($val);
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the link quality, expressed in percent.
     *
     * @return int  an integer corresponding to the link quality, expressed in percent
     *
     * On failure, throws an exception or returns YCellular::LINKQUALITY_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_linkQuality(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LINKQUALITY_INVALID;
            }
        }
        $res = $this->_linkQuality;
        return $res;
    }

    /**
     * Returns the name of the cell operator currently in use.
     *
     * @return string  a string corresponding to the name of the cell operator currently in use
     *
     * On failure, throws an exception or returns YCellular::CELLOPERATOR_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_cellOperator(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CELLOPERATOR_INVALID;
            }
        }
        $res = $this->_cellOperator;
        return $res;
    }

    /**
     * Returns the unique identifier of the cellular antenna in use: MCC, MNC, LAC and Cell ID.
     *
     * @return string  a string corresponding to the unique identifier of the cellular antenna in use:
     * MCC, MNC, LAC and Cell ID
     *
     * On failure, throws an exception or returns YCellular::CELLIDENTIFIER_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_cellIdentifier(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CELLIDENTIFIER_INVALID;
            }
        }
        $res = $this->_cellIdentifier;
        return $res;
    }

    /**
     * Active cellular connection type.
     *
     * @return int  a value among YCellular::CELLTYPE_GPRS, YCellular::CELLTYPE_EGPRS,
     * YCellular::CELLTYPE_WCDMA, YCellular::CELLTYPE_HSDPA, YCellular::CELLTYPE_NONE,
     * YCellular::CELLTYPE_CDMA, YCellular::CELLTYPE_LTE_M, YCellular::CELLTYPE_NB_IOT and YCellular::CELLTYPE_EC_GSM_IOT
     *
     * On failure, throws an exception or returns YCellular::CELLTYPE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_cellType(): int
    {
        // $res                    is a enumCELLTYPE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CELLTYPE_INVALID;
            }
        }
        $res = $this->_cellType;
        return $res;
    }

    /**
     * Returns the International Mobile Subscriber Identity (MSI) that uniquely identifies
     * the SIM card. The first 3 digits represent the mobile country code (MCC), which
     * is followed by the mobile network code (MNC), either 2-digit (European standard)
     * or 3-digit (North American standard)
     *
     * @return string  a string corresponding to the International Mobile Subscriber Identity (MSI) that
     * uniquely identifies
     *         the SIM card
     *
     * On failure, throws an exception or returns YCellular::IMSI_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_imsi(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::IMSI_INVALID;
            }
        }
        $res = $this->_imsi;
        return $res;
    }

    /**
     * Returns the latest status message from the wireless interface.
     *
     * @return string  a string corresponding to the latest status message from the wireless interface
     *
     * On failure, throws an exception or returns YCellular::MESSAGE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_message(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::MESSAGE_INVALID;
            }
        }
        $res = $this->_message;
        return $res;
    }

    /**
     * Returns an opaque string if a PIN code has been configured in the device to access
     * the SIM card, or an empty string if none has been configured or if the code provided
     * was rejected by the SIM card.
     *
     * @return string  a string corresponding to an opaque string if a PIN code has been configured in the
     * device to access
     *         the SIM card, or an empty string if none has been configured or if the code provided
     *         was rejected by the SIM card
     *
     * On failure, throws an exception or returns YCellular::PIN_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_pin(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PIN_INVALID;
            }
        }
        $res = $this->_pin;
        return $res;
    }

    /**
     * Changes the PIN code used by the module to access the SIM card.
     * This function does not change the code on the SIM card itself, but only changes
     * the parameter used by the device to try to get access to it. If the SIM code
     * does not work immediately on first try, it will be automatically forgotten
     * and the message will be set to "Enter SIM PIN". The method should then be
     * invoked again with right correct PIN code. After three failed attempts in a row,
     * the message is changed to "Enter SIM PUK" and the SIM card PUK code must be
     * provided using method sendPUK.
     *
     * Remember to call the saveToFlash() method of the module to save the
     * new value in the device flash.
     *
     * @param string $newval : a string corresponding to the PIN code used by the module to access the SIM card
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_pin(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("pin", $rest_val);
    }

    /**
     * Returns the type of protocol used over the serial line, as a string.
     * Possible values are "Line" for ASCII messages separated by CR and/or LF,
     * "Frame:[timeout]ms" for binary messages separated by a delay time,
     * "Char" for a continuous ASCII stream or
     * "Byte" for a continuous binary stream.
     *
     * @return string  a string corresponding to the type of protocol used over the serial line, as a string
     *
     * On failure, throws an exception or returns YCellular::RADIOCONFIG_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_radioConfig(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::RADIOCONFIG_INVALID;
            }
        }
        $res = $this->_radioConfig;
        return $res;
    }

    /**
     * Changes the type of protocol used over the serial line.
     * Possible values are "Line" for ASCII messages separated by CR and/or LF,
     * "Frame:[timeout]ms" for binary messages separated by a delay time,
     * "Char" for a continuous ASCII stream or
     * "Byte" for a continuous binary stream.
     * The suffix "/[wait]ms" can be added to reduce the transmit rate so that there
     * is always at lest the specified number of milliseconds between each bytes sent.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param string $newval : a string corresponding to the type of protocol used over the serial line
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_radioConfig(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("radioConfig", $rest_val);
    }

    /**
     * Returns the name of the only cell operator to use if automatic choice is disabled,
     * or an empty string if the SIM card will automatically choose among available
     * cell operators.
     *
     * @return string  a string corresponding to the name of the only cell operator to use if automatic
     * choice is disabled,
     *         or an empty string if the SIM card will automatically choose among available
     *         cell operators
     *
     * On failure, throws an exception or returns YCellular::LOCKEDOPERATOR_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_lockedOperator(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LOCKEDOPERATOR_INVALID;
            }
        }
        $res = $this->_lockedOperator;
        return $res;
    }

    /**
     * Changes the name of the cell operator to be used. If the name is an empty
     * string, the choice will be made automatically based on the SIM card. Otherwise,
     * the selected operator is the only one that will be used.
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param string $newval : a string corresponding to the name of the cell operator to be used
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_lockedOperator(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("lockedOperator", $rest_val);
    }

    /**
     * Returns true if the airplane mode is active (radio turned off).
     *
     * @return int  either YCellular::AIRPLANEMODE_OFF or YCellular::AIRPLANEMODE_ON, according to true if
     * the airplane mode is active (radio turned off)
     *
     * On failure, throws an exception or returns YCellular::AIRPLANEMODE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_airplaneMode(): int
    {
        // $res                    is a enumONOFF;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::AIRPLANEMODE_INVALID;
            }
        }
        $res = $this->_airplaneMode;
        return $res;
    }

    /**
     * Changes the activation state of airplane mode (radio turned off).
     *
     * @param int $newval : either YCellular::AIRPLANEMODE_OFF or YCellular::AIRPLANEMODE_ON, according to
     * the activation state of airplane mode (radio turned off)
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_airplaneMode(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("airplaneMode", $rest_val);
    }

    /**
     * Returns the condition for enabling IP data services (GPRS).
     * When data services are disabled, SMS are the only mean of communication.
     *
     * @return int  a value among YCellular::ENABLEDATA_HOMENETWORK, YCellular::ENABLEDATA_ROAMING,
     * YCellular::ENABLEDATA_NEVER and YCellular::ENABLEDATA_NEUTRALITY corresponding to the condition for
     * enabling IP data services (GPRS)
     *
     * On failure, throws an exception or returns YCellular::ENABLEDATA_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_enableData(): int
    {
        // $res                    is a enumSERVICESCOPE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::ENABLEDATA_INVALID;
            }
        }
        $res = $this->_enableData;
        return $res;
    }

    /**
     * Changes the condition for enabling IP data services (GPRS).
     * The service can be either fully deactivated, or limited to the SIM home network,
     * or enabled for all partner networks (roaming). Caution: enabling data services
     * on roaming networks may cause prohibitive communication costs !
     *
     * When data services are disabled, SMS are the only mean of communication.
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param int $newval : a value among YCellular::ENABLEDATA_HOMENETWORK, YCellular::ENABLEDATA_ROAMING,
     * YCellular::ENABLEDATA_NEVER and YCellular::ENABLEDATA_NEUTRALITY corresponding to the condition for
     * enabling IP data services (GPRS)
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_enableData(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("enableData", $rest_val);
    }

    /**
     * Returns the Access Point Name (APN) to be used, if needed.
     * When left blank, the APN suggested by the cell operator will be used.
     *
     * @return string  a string corresponding to the Access Point Name (APN) to be used, if needed
     *
     * On failure, throws an exception or returns YCellular::APN_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_apn(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::APN_INVALID;
            }
        }
        $res = $this->_apn;
        return $res;
    }

    /**
     * Returns the Access Point Name (APN) to be used, if needed.
     * When left blank, the APN suggested by the cell operator will be used.
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param string $newval : a string
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_apn(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("apn", $rest_val);
    }

    /**
     * Returns an opaque string if APN authentication parameters have been configured
     * in the device, or an empty string otherwise.
     * To configure these parameters, use set_apnAuth().
     *
     * @return string  a string corresponding to an opaque string if APN authentication parameters have been configured
     *         in the device, or an empty string otherwise
     *
     * On failure, throws an exception or returns YCellular::APNSECRET_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_apnSecret(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::APNSECRET_INVALID;
            }
        }
        $res = $this->_apnSecret;
        return $res;
    }

    /**
     * @throws YAPI_Exception
     */
    public function set_apnSecret(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("apnSecret", $rest_val);
    }

    /**
     * Returns the automated connectivity check interval, in seconds.
     *
     * @return int  an integer corresponding to the automated connectivity check interval, in seconds
     *
     * On failure, throws an exception or returns YCellular::PINGINTERVAL_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_pingInterval(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PINGINTERVAL_INVALID;
            }
        }
        $res = $this->_pingInterval;
        return $res;
    }

    /**
     * Changes the automated connectivity check interval, in seconds.
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param int $newval : an integer corresponding to the automated connectivity check interval, in seconds
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_pingInterval(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("pingInterval", $rest_val);
    }

    /**
     * Returns the number of bytes sent so far.
     *
     * @return int  an integer corresponding to the number of bytes sent so far
     *
     * On failure, throws an exception or returns YCellular::DATASENT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_dataSent(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DATASENT_INVALID;
            }
        }
        $res = $this->_dataSent;
        return $res;
    }

    /**
     * Changes the value of the outgoing data counter.
     *
     * @param int $newval : an integer corresponding to the value of the outgoing data counter
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_dataSent(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("dataSent", $rest_val);
    }

    /**
     * Returns the number of bytes received so far.
     *
     * @return int  an integer corresponding to the number of bytes received so far
     *
     * On failure, throws an exception or returns YCellular::DATARECEIVED_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_dataReceived(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DATARECEIVED_INVALID;
            }
        }
        $res = $this->_dataReceived;
        return $res;
    }

    /**
     * Changes the value of the incoming data counter.
     *
     * @param int $newval : an integer corresponding to the value of the incoming data counter
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_dataReceived(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("dataReceived", $rest_val);
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_command(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::COMMAND_INVALID;
            }
        }
        $res = $this->_command;
        return $res;
    }

    /**
     * @throws YAPI_Exception
     */
    public function set_command(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("command", $rest_val);
    }

    /**
     * Retrieves a cellular interface for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the cellular interface is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the cellular interface is
     * indeed online at a given time. In case of ambiguity when looking for
     * a cellular interface by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the cellular interface, for instance
     *         YHUBGSM1.cellular.
     *
     * @return YCellular  a YCellular object allowing you to drive the cellular interface.
     */
    public static function FindCellular(string $func): YCellular
    {
        // $obj                    is a YCellular;
        $obj = YFunction::_FindFromCache('Cellular', $func);
        if ($obj == null) {
            $obj = new YCellular($func);
            YFunction::_AddToCache('Cellular', $func, $obj);
        }
        return $obj;
    }

    /**
     * Sends a PUK code to unlock the SIM card after three failed PIN code attempts, and
     * set up a new PIN into the SIM card. Only ten consecutive tentatives are permitted:
     * after that, the SIM card will be blocked permanently without any mean of recovery
     * to use it again. Note that after calling this method, you have usually to invoke
     * method set_pin() to tell the YoctoHub which PIN to use in the future.
     *
     * @param string $puk : the SIM PUK code
     * @param string $newPin : new PIN code to configure into the SIM card
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function sendPUK(string $puk, string $newPin): int
    {
        // $gsmMsg                 is a str;
        $gsmMsg = $this->get_message();
        if (!(substr($gsmMsg, 0, 13) == 'Enter SIM PUK')) return $this->_throw(YAPI::INVALID_ARGUMENT,'PUK not expected at $this time',YAPI::INVALID_ARGUMENT);
        if ($newPin == '') {
            return $this->set_command(sprintf('AT+CPIN=%s,0000;+CLCK=SC,0,0000',$puk));
        }
        return $this->set_command(sprintf('AT+CPIN=%s,%s',$puk,$newPin));
    }

    /**
     * Configure authentication parameters to connect to the APN. Both
     * PAP and CHAP authentication are supported.
     *
     * @param string $username : APN username
     * @param string $password : APN password
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_apnAuth(string $username, string $password): int
    {
        return $this->set_apnSecret(sprintf('%s,%s',$username,$password));
    }

    /**
     * Clear the transmitted data counters.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function clearDataCounters(): int
    {
        // $retcode                is a int;

        $retcode = $this->set_dataReceived(0);
        if ($retcode != YAPI::SUCCESS) {
            return $retcode;
        }
        $retcode = $this->set_dataSent(0);
        return $retcode;
    }

    /**
     * Sends an AT command to the GSM module and returns the command output.
     * The command will only execute when the GSM module is in standard
     * command state, and should leave it in the exact same state.
     * Use this function with great care !
     *
     * @param string $cmd : the AT command to execute, like for instance: "+CCLK?".
     *
     * @return string  a string with the result of the commands. Empty lines are
     *         automatically removed from the output.
     */
    public function _AT(string $cmd): string
    {
        // $chrPos                 is a int;
        // $cmdLen                 is a int;
        // $waitMore               is a int;
        // $res                    is a str;
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $buffstr                is a str;
        // $buffstrlen             is a int;
        // $idx                    is a int;
        // $suffixlen              is a int;
        // quote dangerous characters used in AT commands
        $cmdLen = mb_strlen($cmd);
        $chrPos = YAPI::Ystrpos($cmd,'#');
        while ($chrPos >= 0) {
            $cmd = sprintf('%s%c23%s', substr($cmd, 0, $chrPos), 37,
            substr($cmd, $chrPos+1, $cmdLen-$chrPos-1));
            $cmdLen = $cmdLen + 2;
            $chrPos = YAPI::Ystrpos($cmd,'#');
        }
        $chrPos = YAPI::Ystrpos($cmd,'+');
        while ($chrPos >= 0) {
            $cmd = sprintf('%s%c2B%s', substr($cmd, 0, $chrPos), 37,
            substr($cmd, $chrPos+1, $cmdLen-$chrPos-1));
            $cmdLen = $cmdLen + 2;
            $chrPos = YAPI::Ystrpos($cmd,'+');
        }
        $chrPos = YAPI::Ystrpos($cmd,'=');
        while ($chrPos >= 0) {
            $cmd = sprintf('%s%c3D%s', substr($cmd, 0, $chrPos), 37,
            substr($cmd, $chrPos+1, $cmdLen-$chrPos-1));
            $cmdLen = $cmdLen + 2;
            $chrPos = YAPI::Ystrpos($cmd,'=');
        }
        $cmd = sprintf('at.txt?cmd=%s',$cmd);
        $res = sprintf('');
        // max 2 minutes (each iteration may take up to 5 seconds if waiting)
        $waitMore = 24;
        while ($waitMore > 0) {
            $buff = $this->_download($cmd);
            $bufflen = strlen($buff);
            $buffstr = YAPI::Ybin2str($buff);
            $buffstrlen = mb_strlen($buffstr);
            $idx = $bufflen - 1;
            while (($idx > 0) && (ord($buff[$idx]) != 64) && (ord($buff[$idx]) != 10) && (ord($buff[$idx]) != 13)) {
                $idx = $idx - 1;
            }
            if (ord($buff[$idx]) == 64) {
                // continuation detected
                $suffixlen = $bufflen - $idx;
                $cmd = sprintf('at.txt?cmd=%s', substr($buffstr, $buffstrlen - $suffixlen, $suffixlen));
                $buffstr = substr($buffstr, 0, $buffstrlen - $suffixlen);
                $waitMore = $waitMore - 1;
            } else {
                // request complete
                $waitMore = 0;
            }
            $res = sprintf('%s%s', $res, $buffstr);
        }
        return $res;
    }

    /**
     * Returns the list detected cell operators in the neighborhood.
     * This function will typically take between 30 seconds to 1 minute to
     * return. Note that any SIM card can usually only connect to specific
     * operators. All networks returned by this function might therefore
     * not be available for connection.
     *
     * @return string[]  a list of string (cell operator names).
     */
    public function get_availableOperators(): array
    {
        // $cops                   is a str;
        // $idx                    is a int;
        // $slen                   is a int;
        $res = [];              // strArr;

        $cops = $this->_AT('+COPS=?');
        $slen = mb_strlen($cops);
        while (sizeof($res) > 0) {
            array_pop($res);
        };
        $idx = YAPI::Ystrpos($cops,'(');
        while ($idx >= 0) {
            $slen = $slen - ($idx+1);
            $cops = substr($cops, $idx+1, $slen);
            $idx = YAPI::Ystrpos($cops,'"');
            if ($idx > 0) {
                $slen = $slen - ($idx+1);
                $cops = substr($cops, $idx+1, $slen);
                $idx = YAPI::Ystrpos($cops,'"');
                if ($idx > 0) {
                    $res[] = substr($cops, 0, $idx);
                }
            }
            $idx = YAPI::Ystrpos($cops,'(');
        }
        return $res;
    }

    /**
     * Returns a list of nearby cellular antennas, as required for quick
     * geolocation of the device. The first cell listed is the serving
     * cell, and the next ones are the neighbor cells reported by the
     * serving cell.
     *
     * @return YCellRecord[]  a list of YCellRecords.
     */
    public function quickCellSurvey(): array
    {
        // $moni                   is a str;
        $recs = [];             // strArr;
        // $llen                   is a int;
        // $mccs                   is a str;
        // $mcc                    is a int;
        // $mncs                   is a str;
        // $mnc                    is a int;
        // $lac                    is a int;
        // $cellId                 is a int;
        // $dbms                   is a str;
        // $dbm                    is a int;
        // $tads                   is a str;
        // $tad                    is a int;
        // $oper                   is a str;
        $res = [];              // YCellRecordArr;

        $moni = $this->_AT('+CCED=0;#MONI=7;#MONI');
        $mccs = substr($moni, 7, 3);
        if (substr($mccs, 0, 1) == '0') {
            $mccs = substr($mccs, 1, 2);
        }
        if (substr($mccs, 0, 1) == '0') {
            $mccs = substr($mccs, 1, 1);
        }
        $mcc = intVal($mccs);
        $mncs = substr($moni, 11, 3);
        if (substr($mncs, 2, 1) == ',') {
            $mncs = substr($mncs, 0, 2);
        }
        if (substr($mncs, 0, 1) == '0') {
            $mncs = substr($mncs, 1, mb_strlen($mncs)-1);
        }
        $mnc = intVal($mncs);
        $recs = explode('#', $moni);
        // process each line in turn
        while (sizeof($res) > 0) {
            array_pop($res);
        };
        foreach ($recs as $each) {
            $llen = mb_strlen($each) - 2;
            if ($llen >= 44) {
                if (substr($each, 41, 3) == 'dbm') {
                    $lac = hexdec(substr($each, 16, 4));
                    $cellId = hexdec(substr($each, 23, 4));
                    $dbms = substr($each, 37, 4);
                    if (substr($dbms, 0, 1) == ' ') {
                        $dbms = substr($dbms, 1, 3);
                    }
                    $dbm = intVal($dbms);
                    if ($llen > 66) {
                        $tads = substr($each, 54, 2);
                        if (substr($tads, 0, 1) == ' ') {
                            $tads = substr($tads, 1, 3);
                        }
                        $tad = intVal($tads);
                        $oper = substr($each, 66, $llen-66);
                    } else {
                        $tad = -1;
                        $oper = '';
                    }
                    if ($lac < 65535) {
                        $res[] = new YCellRecord($mcc, $mnc, $lac, $cellId, $dbm, $tad, $oper);
                    }
                }
            }
        }
        return $res;
    }

    /**
     * Returns the cell operator brand for a given MCC/MNC pair (DEPRECATED).
     *
     * @param string $mccmnc : a string starting with a MCC code followed by a MNC code,
     *
     * @return string  a string containing the corresponding cell operator brand name.
     */
    public function decodePLMN(string $mccmnc): string
    {
        return $mccmnc;
    }

    /**
     * Returns the list available radio communication profiles, as a string array
     * (YoctoHub-GSM-4G only).
     * Each string is a made of a numerical ID, followed by a colon,
     * followed by the profile description.
     *
     * @return string[]  a list of string describing available radio communication profiles.
     */
    public function get_communicationProfiles(): array
    {
        // $profiles               is a str;
        $lines = [];            // strArr;
        // $nlines                 is a int;
        // $idx                    is a int;
        // $line                   is a str;
        // $cpos                   is a int;
        // $profno                 is a int;
        $res = [];              // strArr;

        $profiles = $this->_AT('+UMNOPROF=?');
        $lines = explode(''."\n".'', $profiles);
        $nlines = sizeof($lines);
        if (!($nlines > 0)) return $this->_throw(YAPI::IO_ERROR,'fail to retrieve profile list',$res);
        while (sizeof($res) > 0) {
            array_pop($res);
        };
        $idx = 0;
        while ($idx < $nlines) {
            $line = $lines[$idx];
            $cpos = YAPI::Ystrpos($line,':');
            if ($cpos > 0) {
                $profno = intVal(substr($line, 0, $cpos));
                if ($profno > 1) {
                    $res[] = $line;
                }
            }
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * @throws YAPI_Exception
     */
    public function linkQuality(): int
{
    return $this->get_linkQuality();
}

    /**
     * @throws YAPI_Exception
     */
    public function cellOperator(): string
{
    return $this->get_cellOperator();
}

    /**
     * @throws YAPI_Exception
     */
    public function cellIdentifier(): string
{
    return $this->get_cellIdentifier();
}

    /**
     * @throws YAPI_Exception
     */
    public function cellType(): int
{
    return $this->get_cellType();
}

    /**
     * @throws YAPI_Exception
     */
    public function imsi(): string
{
    return $this->get_imsi();
}

    /**
     * @throws YAPI_Exception
     */
    public function message(): string
{
    return $this->get_message();
}

    /**
     * @throws YAPI_Exception
     */
    public function pin(): string
{
    return $this->get_pin();
}

    /**
     * @throws YAPI_Exception
     */
    public function setPin(string $newval): int
{
    return $this->set_pin($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function radioConfig(): string
{
    return $this->get_radioConfig();
}

    /**
     * @throws YAPI_Exception
     */
    public function setRadioConfig(string $newval): int
{
    return $this->set_radioConfig($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function lockedOperator(): string
{
    return $this->get_lockedOperator();
}

    /**
     * @throws YAPI_Exception
     */
    public function setLockedOperator(string $newval): int
{
    return $this->set_lockedOperator($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function airplaneMode(): int
{
    return $this->get_airplaneMode();
}

    /**
     * @throws YAPI_Exception
     */
    public function setAirplaneMode(int $newval): int
{
    return $this->set_airplaneMode($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function enableData(): int
{
    return $this->get_enableData();
}

    /**
     * @throws YAPI_Exception
     */
    public function setEnableData(int $newval): int
{
    return $this->set_enableData($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function apn(): string
{
    return $this->get_apn();
}

    /**
     * @throws YAPI_Exception
     */
    public function setApn(string $newval): int
{
    return $this->set_apn($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function apnSecret(): string
{
    return $this->get_apnSecret();
}

    /**
     * @throws YAPI_Exception
     */
    public function setApnSecret(string $newval): int
{
    return $this->set_apnSecret($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function pingInterval(): int
{
    return $this->get_pingInterval();
}

    /**
     * @throws YAPI_Exception
     */
    public function setPingInterval(int $newval): int
{
    return $this->set_pingInterval($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function dataSent(): int
{
    return $this->get_dataSent();
}

    /**
     * @throws YAPI_Exception
     */
    public function setDataSent(int $newval): int
{
    return $this->set_dataSent($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function dataReceived(): int
{
    return $this->get_dataReceived();
}

    /**
     * @throws YAPI_Exception
     */
    public function setDataReceived(int $newval): int
{
    return $this->set_dataReceived($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function command(): string
{
    return $this->get_command();
}

    /**
     * @throws YAPI_Exception
     */
    public function setCommand(string $newval): int
{
    return $this->set_command($newval);
}

    /**
     * Continues the enumeration of cellular interfaces started using yFirstCellular().
     * Caution: You can't make any assumption about the returned cellular interfaces order.
     * If you want to find a specific a cellular interface, use Cellular.findCellular()
     * and a hardwareID or a logical name.
     *
     * @return ?YCellular  a pointer to a YCellular object, corresponding to
     *         a cellular interface currently online, or a null pointer
     *         if there are no more cellular interfaces to enumerate.
     */
    public function nextCellular(): ?YCellular
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindCellular($next_hwid);
    }

    /**
     * Starts the enumeration of cellular interfaces currently accessible.
     * Use the method YCellular::nextCellular() to iterate on
     * next cellular interfaces.
     *
     * @return ?YCellular  a pointer to a YCellular object, corresponding to
     *         the first cellular interface currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstCellular(): ?YCellular
    {
        $next_hwid = YAPI::getFirstHardwareId('Cellular');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindCellular($next_hwid);
    }

    //--- (end of generated code: YCellular implementation)

}
