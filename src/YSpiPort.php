<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YSpiPort Class: SPI port control interface, available for instance in the Yocto-SPI
 *
 * The YSpiPort class allows you to fully drive a Yoctopuce SPI port.
 * It can be used to send and receive data, and to configure communication
 * parameters (baud rate, bit count, parity, flow control and protocol).
 * Note that Yoctopuce SPI ports are not exposed as virtual COM ports.
 * They are meant to be used in the same way as all Yoctopuce devices.
 */
class YSpiPort extends YFunction
{
    const RXCOUNT_INVALID = YAPI::INVALID_UINT;
    const TXCOUNT_INVALID = YAPI::INVALID_UINT;
    const ERRCOUNT_INVALID = YAPI::INVALID_UINT;
    const RXMSGCOUNT_INVALID = YAPI::INVALID_UINT;
    const TXMSGCOUNT_INVALID = YAPI::INVALID_UINT;
    const LASTMSG_INVALID = YAPI::INVALID_STRING;
    const CURRENTJOB_INVALID = YAPI::INVALID_STRING;
    const STARTUPJOB_INVALID = YAPI::INVALID_STRING;
    const JOBMAXTASK_INVALID = YAPI::INVALID_UINT;
    const JOBMAXSIZE_INVALID = YAPI::INVALID_UINT;
    const COMMAND_INVALID = YAPI::INVALID_STRING;
    const PROTOCOL_INVALID = YAPI::INVALID_STRING;
    const VOLTAGELEVEL_OFF = 0;
    const VOLTAGELEVEL_TTL3V = 1;
    const VOLTAGELEVEL_TTL3VR = 2;
    const VOLTAGELEVEL_TTL5V = 3;
    const VOLTAGELEVEL_TTL5VR = 4;
    const VOLTAGELEVEL_RS232 = 5;
    const VOLTAGELEVEL_RS485 = 6;
    const VOLTAGELEVEL_TTL1V8 = 7;
    const VOLTAGELEVEL_SDI12 = 8;
    const VOLTAGELEVEL_INVALID = -1;
    const SPIMODE_INVALID = YAPI::INVALID_STRING;
    const SSPOLARITY_ACTIVE_LOW = 0;
    const SSPOLARITY_ACTIVE_HIGH = 1;
    const SSPOLARITY_INVALID = -1;
    const SHIFTSAMPLING_OFF = 0;
    const SHIFTSAMPLING_ON = 1;
    const SHIFTSAMPLING_INVALID = -1;
    //--- (end of generated code: YSpiPort declaration)

    //--- (generated code: YSpiPort attributes)
    protected int $_rxCount = self::RXCOUNT_INVALID;        // UInt31
    protected int $_txCount = self::TXCOUNT_INVALID;        // UInt31
    protected int $_errCount = self::ERRCOUNT_INVALID;       // UInt31
    protected int $_rxMsgCount = self::RXMSGCOUNT_INVALID;     // UInt31
    protected int $_txMsgCount = self::TXMSGCOUNT_INVALID;     // UInt31
    protected string $_lastMsg = self::LASTMSG_INVALID;        // Text
    protected string $_currentJob = self::CURRENTJOB_INVALID;     // Text
    protected string $_startupJob = self::STARTUPJOB_INVALID;     // Text
    protected int $_jobMaxTask = self::JOBMAXTASK_INVALID;     // UInt31
    protected int $_jobMaxSize = self::JOBMAXSIZE_INVALID;     // UInt31
    protected string $_command = self::COMMAND_INVALID;        // Text
    protected string $_protocol = self::PROTOCOL_INVALID;       // Protocol
    protected int $_voltageLevel = self::VOLTAGELEVEL_INVALID;   // SerialVoltageLevel
    protected string $_spiMode = self::SPIMODE_INVALID;        // SpiMode
    protected int $_ssPolarity = self::SSPOLARITY_INVALID;     // Polarity
    protected int $_shiftSampling = self::SHIFTSAMPLING_INVALID;  // OnOff
    protected int $_rxptr = 0;                            // int
    protected string $_rxbuff = "";                           // bin
    protected int $_rxbuffptr = 0;                            // int
    protected int $_eventPos = 0;                            // int

    //--- (end of generated code: YSpiPort attributes)

    function __construct($str_func)
    {
        //--- (generated code: YSpiPort constructor)
        parent::__construct($str_func);
        $this->_className = 'SpiPort';

        //--- (end of generated code: YSpiPort constructor)
    }

    //--- (generated code: YSpiPort implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'rxCount':
            $this->_rxCount = intval($val);
            return 1;
        case 'txCount':
            $this->_txCount = intval($val);
            return 1;
        case 'errCount':
            $this->_errCount = intval($val);
            return 1;
        case 'rxMsgCount':
            $this->_rxMsgCount = intval($val);
            return 1;
        case 'txMsgCount':
            $this->_txMsgCount = intval($val);
            return 1;
        case 'lastMsg':
            $this->_lastMsg = $val;
            return 1;
        case 'currentJob':
            $this->_currentJob = $val;
            return 1;
        case 'startupJob':
            $this->_startupJob = $val;
            return 1;
        case 'jobMaxTask':
            $this->_jobMaxTask = intval($val);
            return 1;
        case 'jobMaxSize':
            $this->_jobMaxSize = intval($val);
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        case 'protocol':
            $this->_protocol = $val;
            return 1;
        case 'voltageLevel':
            $this->_voltageLevel = intval($val);
            return 1;
        case 'spiMode':
            $this->_spiMode = $val;
            return 1;
        case 'ssPolarity':
            $this->_ssPolarity = intval($val);
            return 1;
        case 'shiftSampling':
            $this->_shiftSampling = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the total number of bytes received since last reset.
     *
     * @return int  an integer corresponding to the total number of bytes received since last reset
     *
     * On failure, throws an exception or returns YSpiPort::RXCOUNT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_rxCount(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::RXCOUNT_INVALID;
            }
        }
        $res = $this->_rxCount;
        return $res;
    }

    /**
     * Returns the total number of bytes transmitted since last reset.
     *
     * @return int  an integer corresponding to the total number of bytes transmitted since last reset
     *
     * On failure, throws an exception or returns YSpiPort::TXCOUNT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_txCount(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::TXCOUNT_INVALID;
            }
        }
        $res = $this->_txCount;
        return $res;
    }

    /**
     * Returns the total number of communication errors detected since last reset.
     *
     * @return int  an integer corresponding to the total number of communication errors detected since last reset
     *
     * On failure, throws an exception or returns YSpiPort::ERRCOUNT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_errCount(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::ERRCOUNT_INVALID;
            }
        }
        $res = $this->_errCount;
        return $res;
    }

    /**
     * Returns the total number of messages received since last reset.
     *
     * @return int  an integer corresponding to the total number of messages received since last reset
     *
     * On failure, throws an exception or returns YSpiPort::RXMSGCOUNT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_rxMsgCount(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::RXMSGCOUNT_INVALID;
            }
        }
        $res = $this->_rxMsgCount;
        return $res;
    }

    /**
     * Returns the total number of messages send since last reset.
     *
     * @return int  an integer corresponding to the total number of messages send since last reset
     *
     * On failure, throws an exception or returns YSpiPort::TXMSGCOUNT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_txMsgCount(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::TXMSGCOUNT_INVALID;
            }
        }
        $res = $this->_txMsgCount;
        return $res;
    }

    /**
     * Returns the latest message fully received (for Line and Frame protocols).
     *
     * @return string  a string corresponding to the latest message fully received (for Line and Frame protocols)
     *
     * On failure, throws an exception or returns YSpiPort::LASTMSG_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_lastMsg(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LASTMSG_INVALID;
            }
        }
        $res = $this->_lastMsg;
        return $res;
    }

    /**
     * Returns the name of the job file currently in use.
     *
     * @return string  a string corresponding to the name of the job file currently in use
     *
     * On failure, throws an exception or returns YSpiPort::CURRENTJOB_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_currentJob(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CURRENTJOB_INVALID;
            }
        }
        $res = $this->_currentJob;
        return $res;
    }

    /**
     * Selects a job file to run immediately. If an empty string is
     * given as argument, stops running current job file.
     *
     * @param string $newval : a string
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_currentJob(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("currentJob", $rest_val);
    }

    /**
     * Returns the job file to use when the device is powered on.
     *
     * @return string  a string corresponding to the job file to use when the device is powered on
     *
     * On failure, throws an exception or returns YSpiPort::STARTUPJOB_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_startupJob(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::STARTUPJOB_INVALID;
            }
        }
        $res = $this->_startupJob;
        return $res;
    }

    /**
     * Changes the job to use when the device is powered on.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param string $newval : a string corresponding to the job to use when the device is powered on
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_startupJob(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("startupJob", $rest_val);
    }

    /**
     * Returns the maximum number of tasks in a job that the device can handle.
     *
     * @return int  an integer corresponding to the maximum number of tasks in a job that the device can handle
     *
     * On failure, throws an exception or returns YSpiPort::JOBMAXTASK_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_jobMaxTask(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration == 0) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::JOBMAXTASK_INVALID;
            }
        }
        $res = $this->_jobMaxTask;
        return $res;
    }

    /**
     * Returns maximum size allowed for job files.
     *
     * @return int  an integer corresponding to maximum size allowed for job files
     *
     * On failure, throws an exception or returns YSpiPort::JOBMAXSIZE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_jobMaxSize(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration == 0) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::JOBMAXSIZE_INVALID;
            }
        }
        $res = $this->_jobMaxSize;
        return $res;
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
     * Returns the type of protocol used over the serial line, as a string.
     * Possible values are "Line" for ASCII messages separated by CR and/or LF,
     * "Frame:[timeout]ms" for binary messages separated by a delay time,
     * "Char" for a continuous ASCII stream or
     * "Byte" for a continuous binary stream.
     *
     * @return string  a string corresponding to the type of protocol used over the serial line, as a string
     *
     * On failure, throws an exception or returns YSpiPort::PROTOCOL_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_protocol(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PROTOCOL_INVALID;
            }
        }
        $res = $this->_protocol;
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
    public function set_protocol(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("protocol", $rest_val);
    }

    /**
     * Returns the voltage level used on the serial line.
     *
     * @return int  a value among YSpiPort::VOLTAGELEVEL_OFF, YSpiPort::VOLTAGELEVEL_TTL3V,
     * YSpiPort::VOLTAGELEVEL_TTL3VR, YSpiPort::VOLTAGELEVEL_TTL5V, YSpiPort::VOLTAGELEVEL_TTL5VR,
     * YSpiPort::VOLTAGELEVEL_RS232, YSpiPort::VOLTAGELEVEL_RS485, YSpiPort::VOLTAGELEVEL_TTL1V8 and
     * YSpiPort::VOLTAGELEVEL_SDI12 corresponding to the voltage level used on the serial line
     *
     * On failure, throws an exception or returns YSpiPort::VOLTAGELEVEL_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_voltageLevel(): int
    {
        // $res                    is a enumSERIALVOLTAGELEVEL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::VOLTAGELEVEL_INVALID;
            }
        }
        $res = $this->_voltageLevel;
        return $res;
    }

    /**
     * Changes the voltage type used on the serial line. Valid
     * values  will depend on the Yoctopuce device model featuring
     * the serial port feature.  Check your device documentation
     * to find out which values are valid for that specific model.
     * Trying to set an invalid value will have no effect.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param int $newval : a value among YSpiPort::VOLTAGELEVEL_OFF, YSpiPort::VOLTAGELEVEL_TTL3V,
     * YSpiPort::VOLTAGELEVEL_TTL3VR, YSpiPort::VOLTAGELEVEL_TTL5V, YSpiPort::VOLTAGELEVEL_TTL5VR,
     * YSpiPort::VOLTAGELEVEL_RS232, YSpiPort::VOLTAGELEVEL_RS485, YSpiPort::VOLTAGELEVEL_TTL1V8 and
     * YSpiPort::VOLTAGELEVEL_SDI12 corresponding to the voltage type used on the serial line
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_voltageLevel(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("voltageLevel", $rest_val);
    }

    /**
     * Returns the SPI port communication parameters, as a string such as
     * "125000,0,msb". The string includes the baud rate, the SPI mode (between
     * 0 and 3) and the bit order.
     *
     * @return string  a string corresponding to the SPI port communication parameters, as a string such as
     *         "125000,0,msb"
     *
     * On failure, throws an exception or returns YSpiPort::SPIMODE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_spiMode(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SPIMODE_INVALID;
            }
        }
        $res = $this->_spiMode;
        return $res;
    }

    /**
     * Changes the SPI port communication parameters, with a string such as
     * "125000,0,msb". The string includes the baud rate, the SPI mode (between
     * 0 and 3) and the bit order.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param string $newval : a string corresponding to the SPI port communication parameters, with a string such as
     *         "125000,0,msb"
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_spiMode(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("spiMode", $rest_val);
    }

    /**
     * Returns the SS line polarity.
     *
     * @return int  either YSpiPort::SSPOLARITY_ACTIVE_LOW or YSpiPort::SSPOLARITY_ACTIVE_HIGH, according to
     * the SS line polarity
     *
     * On failure, throws an exception or returns YSpiPort::SSPOLARITY_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_ssPolarity(): int
    {
        // $res                    is a enumPOLARITY;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SSPOLARITY_INVALID;
            }
        }
        $res = $this->_ssPolarity;
        return $res;
    }

    /**
     * Changes the SS line polarity.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param int $newval : either YSpiPort::SSPOLARITY_ACTIVE_LOW or YSpiPort::SSPOLARITY_ACTIVE_HIGH,
     * according to the SS line polarity
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_ssPolarity(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("ssPolarity", $rest_val);
    }

    /**
     * Returns true when the SDI line phase is shifted with regards to the SDO line.
     *
     * @return int  either YSpiPort::SHIFTSAMPLING_OFF or YSpiPort::SHIFTSAMPLING_ON, according to true when
     * the SDI line phase is shifted with regards to the SDO line
     *
     * On failure, throws an exception or returns YSpiPort::SHIFTSAMPLING_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_shiftSampling(): int
    {
        // $res                    is a enumONOFF;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SHIFTSAMPLING_INVALID;
            }
        }
        $res = $this->_shiftSampling;
        return $res;
    }

    /**
     * Changes the SDI line sampling shift. When disabled, SDI line is
     * sampled in the middle of data output time. When enabled, SDI line is
     * samples at the end of data output time.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param int $newval : either YSpiPort::SHIFTSAMPLING_OFF or YSpiPort::SHIFTSAMPLING_ON, according to
     * the SDI line sampling shift
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_shiftSampling(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("shiftSampling", $rest_val);
    }

    /**
     * Retrieves an SPI port for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the SPI port is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the SPI port is
     * indeed online at a given time. In case of ambiguity when looking for
     * an SPI port by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the SPI port, for instance
     *         YSPIMK01.spiPort.
     *
     * @return YSpiPort  a YSpiPort object allowing you to drive the SPI port.
     */
    public static function FindSpiPort(string $func): YSpiPort
    {
        // $obj                    is a YSpiPort;
        $obj = YFunction::_FindFromCache('SpiPort', $func);
        if ($obj == null) {
            $obj = new YSpiPort($func);
            YFunction::_AddToCache('SpiPort', $func, $obj);
        }
        return $obj;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function sendCommand(string $text): int
    {
        return $this->set_command($text);
    }

    /**
     * Reads a single line (or message) from the receive buffer, starting at current stream position.
     * This function is intended to be used when the serial port is configured for a message protocol,
     * such as 'Line' mode or frame protocols.
     *
     * If data at current stream position is not available anymore in the receive buffer,
     * the function returns the oldest available line and moves the stream position just after.
     * If no new full line is received, the function returns an empty line.
     *
     * @return string  a string with a single line of text
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function readLine(): string
    {
        // $url                    is a str;
        // $msgbin                 is a bin;
        $msgarr = [];           // binArr;
        // $msglen                 is a int;
        // $res                    is a str;

        $url = sprintf('rxmsg.json?pos=%d&len=1&maxw=1', $this->_rxptr);
        $msgbin = $this->_download($url);
        $msgarr = $this->_json_get_array($msgbin);
        $msglen = sizeof($msgarr);
        if ($msglen == 0) {
            return '';
        }
        // last element of array is the new position
        $msglen = $msglen - 1;
        $this->_rxptr = $this->_decode_json_int($msgarr[$msglen]);
        if ($msglen == 0) {
            return '';
        }
        $res = $this->_json_get_string($msgarr[0]);
        return $res;
    }

    /**
     * Searches for incoming messages in the serial port receive buffer matching a given pattern,
     * starting at current position. This function will only compare and return printable characters
     * in the message strings. Binary protocols are handled as hexadecimal strings.
     *
     * The search returns all messages matching the expression provided as argument in the buffer.
     * If no matching message is found, the search waits for one up to the specified maximum timeout
     * (in milliseconds).
     *
     * @param string $pattern : a limited regular expression describing the expected message format,
     *         or an empty string if all messages should be returned (no filtering).
     *         When using binary protocols, the format applies to the hexadecimal
     *         representation of the message.
     * @param int $maxWait : the maximum number of milliseconds to wait for a message if none is found
     *         in the receive buffer.
     *
     * @return string[]  an array of strings containing the messages found, if any.
     *         Binary messages are converted to hexadecimal representation.
     *
     * On failure, throws an exception or returns an empty array.
     * @throws YAPI_Exception on error
     */
    public function readMessages(string $pattern, int $maxWait): array
    {
        // $url                    is a str;
        // $msgbin                 is a bin;
        $msgarr = [];           // binArr;
        // $msglen                 is a int;
        $res = [];              // strArr;
        // $idx                    is a int;

        $url = sprintf('rxmsg.json?pos=%d&maxw=%d&pat=%s', $this->_rxptr, $maxWait, $pattern);
        $msgbin = $this->_download($url);
        $msgarr = $this->_json_get_array($msgbin);
        $msglen = sizeof($msgarr);
        if ($msglen == 0) {
            return $res;
        }
        // last element of array is the new position
        $msglen = $msglen - 1;
        $this->_rxptr = $this->_decode_json_int($msgarr[$msglen]);
        $idx = 0;
        while ($idx < $msglen) {
            $res[] = $this->_json_get_string($msgarr[$idx]);
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * Changes the current internal stream position to the specified value. This function
     * does not affect the device, it only changes the value stored in the API object
     * for the next read operations.
     *
     * @param int $absPos : the absolute position index for next read operations.
     *
     * @return int  nothing.
     */
    public function read_seek(int $absPos): int
    {
        $this->_rxptr = $absPos;
        return YAPI::SUCCESS;
    }

    /**
     * Returns the current absolute stream position pointer of the API object.
     *
     * @return int  the absolute position index for next read operations.
     */
    public function read_tell(): int
    {
        return $this->_rxptr;
    }

    /**
     * Returns the number of bytes available to read in the input buffer starting from the
     * current absolute stream position pointer of the API object.
     *
     * @return int  the number of bytes available to read
     */
    public function read_avail(): int
    {
        // $availPosStr            is a str;
        // $atPos                  is a int;
        // $res                    is a int;
        // $databin                is a bin;

        $databin = $this->_download(sprintf('rxcnt.bin?pos=%d', $this->_rxptr));
        $availPosStr = YAPI::Ybin2str($databin);
        $atPos = YAPI::Ystrpos($availPosStr,'@');
        $res = intVal(substr($availPosStr, 0, $atPos));
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function end_tell(): int
    {
        // $availPosStr            is a str;
        // $atPos                  is a int;
        // $res                    is a int;
        // $databin                is a bin;

        $databin = $this->_download(sprintf('rxcnt.bin?pos=%d', $this->_rxptr));
        $availPosStr = YAPI::Ybin2str($databin);
        $atPos = YAPI::Ystrpos($availPosStr,'@');
        $res = intVal(substr($availPosStr, $atPos+1, mb_strlen($availPosStr)-$atPos-1));
        return $res;
    }

    /**
     * Sends a text line query to the serial port, and reads the reply, if any.
     * This function is intended to be used when the serial port is configured for 'Line' protocol.
     *
     * @param string $query : the line query to send (without CR/LF)
     * @param int $maxWait : the maximum number of milliseconds to wait for a reply.
     *
     * @return string  the next text line received after sending the text query, as a string.
     *         Additional lines can be obtained by calling readLine or readMessages.
     *
     * On failure, throws an exception or returns an empty string.
     * @throws YAPI_Exception on error
     */
    public function queryLine(string $query, int $maxWait): string
    {
        // $prevpos                is a int;
        // $url                    is a str;
        // $msgbin                 is a bin;
        $msgarr = [];           // binArr;
        // $msglen                 is a int;
        // $res                    is a str;
        if (mb_strlen($query) <= 80) {
            // fast query
            $url = sprintf('rxmsg.json?len=1&maxw=%d&cmd=!%s', $maxWait, $this->_escapeAttr($query));
        } else {
            // long query
            $prevpos = $this->end_tell();
            $this->_upload('txdata', YAPI::Ystr2bin($query . ''."\r".''."\n".''));
            $url = sprintf('rxmsg.json?len=1&maxw=%d&pos=%d', $maxWait, $prevpos);
        }

        $msgbin = $this->_download($url);
        $msgarr = $this->_json_get_array($msgbin);
        $msglen = sizeof($msgarr);
        if ($msglen == 0) {
            return '';
        }
        // last element of array is the new position
        $msglen = $msglen - 1;
        $this->_rxptr = $this->_decode_json_int($msgarr[$msglen]);
        if ($msglen == 0) {
            return '';
        }
        $res = $this->_json_get_string($msgarr[0]);
        return $res;
    }

    /**
     * Sends a binary message to the serial port, and reads the reply, if any.
     * This function is intended to be used when the serial port is configured for
     * Frame-based protocol.
     *
     * @param string $hexString : the message to send, coded in hexadecimal
     * @param int $maxWait : the maximum number of milliseconds to wait for a reply.
     *
     * @return string  the next frame received after sending the message, as a hex string.
     *         Additional frames can be obtained by calling readHex or readMessages.
     *
     * On failure, throws an exception or returns an empty string.
     * @throws YAPI_Exception on error
     */
    public function queryHex(string $hexString, int $maxWait): string
    {
        // $prevpos                is a int;
        // $url                    is a str;
        // $msgbin                 is a bin;
        $msgarr = [];           // binArr;
        // $msglen                 is a int;
        // $res                    is a str;
        if (mb_strlen($hexString) <= 80) {
            // fast query
            $url = sprintf('rxmsg.json?len=1&maxw=%d&cmd=$%s', $maxWait, $hexString);
        } else {
            // long query
            $prevpos = $this->end_tell();
            $this->_upload('txdata', YAPI::_hexStrToBin($hexString));
            $url = sprintf('rxmsg.json?len=1&maxw=%d&pos=%d', $maxWait, $prevpos);
        }

        $msgbin = $this->_download($url);
        $msgarr = $this->_json_get_array($msgbin);
        $msglen = sizeof($msgarr);
        if ($msglen == 0) {
            return '';
        }
        // last element of array is the new position
        $msglen = $msglen - 1;
        $this->_rxptr = $this->_decode_json_int($msgarr[$msglen]);
        if ($msglen == 0) {
            return '';
        }
        $res = $this->_json_get_string($msgarr[0]);
        return $res;
    }

    /**
     * Saves the job definition string (JSON data) into a job file.
     * The job file can be later enabled using selectJob().
     *
     * @param string $jobfile : name of the job file to save on the device filesystem
     * @param string $jsonDef : a string containing a JSON definition of the job
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function uploadJob(string $jobfile, string $jsonDef): int
    {
        $this->_upload($jobfile, YAPI::Ystr2bin($jsonDef));
        return YAPI::SUCCESS;
    }

    /**
     * Load and start processing the specified job file. The file must have
     * been previously created using the user interface or uploaded on the
     * device filesystem using the uploadJob() function.
     *
     * @param string $jobfile : name of the job file (on the device filesystem)
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function selectJob(string $jobfile): int
    {
        return $this->set_currentJob($jobfile);
    }

    /**
     * Clears the serial port buffer and resets counters to zero.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function reset(): int
    {
        $this->_eventPos = 0;
        $this->_rxptr = 0;
        $this->_rxbuffptr = 0;
        $this->_rxbuff = '';

        return $this->sendCommand('Z');
    }

    /**
     * Sends a single byte to the serial port.
     *
     * @param int $code : the byte to send
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function writeByte(int $code): int
    {
        return $this->sendCommand(sprintf('$%02X', $code));
    }

    /**
     * Sends an ASCII string to the serial port, as is.
     *
     * @param string $text : the text string to send
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function writeStr(string $text): int
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $idx                    is a int;
        // $ch                     is a int;
        $buff = YAPI::Ystr2bin($text);
        $bufflen = strlen($buff);
        if ($bufflen < 100) {
            // if string is pure text, we can send it as a simple command (faster)
            $ch = 0x20;
            $idx = 0;
            while (($idx < $bufflen) && ($ch != 0)) {
                $ch = ord($buff[$idx]);
                if (($ch >= 0x20) && ($ch < 0x7f)) {
                    $idx = $idx + 1;
                } else {
                    $ch = 0;
                }
            }
            if ($idx >= $bufflen) {
                return $this->sendCommand(sprintf('+%s',$text));
            }
        }
        // send string using file upload
        return $this->_upload('txdata', $buff);
    }

    /**
     * Sends a binary buffer to the serial port, as is.
     *
     * @param string $buff : the binary buffer to send
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function writeBin(string $buff): int
    {
        return $this->_upload('txdata', $buff);
    }

    /**
     * Sends a byte sequence (provided as a list of bytes) to the serial port.
     *
     * @param Integer[] $byteList : a list of byte codes
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function writeArray(array $byteList): int
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $idx                    is a int;
        // $hexb                   is a int;
        // $res                    is a int;
        $bufflen = sizeof($byteList);
        $buff = ($bufflen > 0 ? pack('C',array_fill(0, $bufflen, 0)) : '');
        $idx = 0;
        while ($idx < $bufflen) {
            $hexb = $byteList[$idx];
            $buff[$idx] = pack('C', $hexb);
            $idx = $idx + 1;
        }

        $res = $this->_upload('txdata', $buff);
        return $res;
    }

    /**
     * Sends a byte sequence (provided as a hexadecimal string) to the serial port.
     *
     * @param string $hexString : a string of hexadecimal byte codes
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function writeHex(string $hexString): int
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $idx                    is a int;
        // $hexb                   is a int;
        // $res                    is a int;
        $bufflen = mb_strlen($hexString);
        if ($bufflen < 100) {
            return $this->sendCommand(sprintf('$%s',$hexString));
        }
        $bufflen = (($bufflen) >> 1);
        $buff = ($bufflen > 0 ? pack('C',array_fill(0, $bufflen, 0)) : '');
        $idx = 0;
        while ($idx < $bufflen) {
            $hexb = hexdec(substr($hexString, 2 * $idx, 2));
            $buff[$idx] = pack('C', $hexb);
            $idx = $idx + 1;
        }

        $res = $this->_upload('txdata', $buff);
        return $res;
    }

    /**
     * Sends an ASCII string to the serial port, followed by a line break (CR LF).
     *
     * @param string $text : the text string to send
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function writeLine(string $text): int
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $idx                    is a int;
        // $ch                     is a int;
        $buff = YAPI::Ystr2bin(sprintf('%s'."\r".''."\n".'', $text));
        $bufflen = strlen($buff)-2;
        if ($bufflen < 100) {
            // if string is pure text, we can send it as a simple command (faster)
            $ch = 0x20;
            $idx = 0;
            while (($idx < $bufflen) && ($ch != 0)) {
                $ch = ord($buff[$idx]);
                if (($ch >= 0x20) && ($ch < 0x7f)) {
                    $idx = $idx + 1;
                } else {
                    $ch = 0;
                }
            }
            if ($idx >= $bufflen) {
                return $this->sendCommand(sprintf('!%s',$text));
            }
        }
        // send string using file upload
        return $this->_upload('txdata', $buff);
    }

    /**
     * Reads one byte from the receive buffer, starting at current stream position.
     * If data at current stream position is not available anymore in the receive buffer,
     * or if there is no data available yet, the function returns YAPI::NO_MORE_DATA.
     *
     * @return int  the next byte
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function readByte(): int
    {
        // $currpos                is a int;
        // $reqlen                 is a int;
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $mult                   is a int;
        // $endpos                 is a int;
        // $res                    is a int;
        // first check if we have the requested character in the look-ahead buffer
        $bufflen = strlen($this->_rxbuff);
        if (($this->_rxptr >= $this->_rxbuffptr) && ($this->_rxptr < $this->_rxbuffptr+$bufflen)) {
            $res = ord($this->_rxbuff[$this->_rxptr-$this->_rxbuffptr]);
            $this->_rxptr = $this->_rxptr + 1;
            return $res;
        }
        // try to preload more than one byte to speed-up byte-per-byte access
        $currpos = $this->_rxptr;
        $reqlen = 1024;
        $buff = $this->readBin($reqlen);
        $bufflen = strlen($buff);
        if ($this->_rxptr == $currpos+$bufflen) {
            $res = ord($buff[0]);
            $this->_rxptr = $currpos+1;
            $this->_rxbuffptr = $currpos;
            $this->_rxbuff = $buff;
            return $res;
        }
        // mixed bidirectional data, retry with a smaller block
        $this->_rxptr = $currpos;
        $reqlen = 16;
        $buff = $this->readBin($reqlen);
        $bufflen = strlen($buff);
        if ($this->_rxptr == $currpos+$bufflen) {
            $res = ord($buff[0]);
            $this->_rxptr = $currpos+1;
            $this->_rxbuffptr = $currpos;
            $this->_rxbuff = $buff;
            return $res;
        }
        // still mixed, need to process character by character
        $this->_rxptr = $currpos;

        $buff = $this->_download(sprintf('rxdata.bin?pos=%d&len=1', $this->_rxptr));
        $bufflen = strlen($buff) - 1;
        $endpos = 0;
        $mult = 1;
        while (($bufflen > 0) && (ord($buff[$bufflen]) != 64)) {
            $endpos = $endpos + $mult * (ord($buff[$bufflen]) - 48);
            $mult = $mult * 10;
            $bufflen = $bufflen - 1;
        }
        $this->_rxptr = $endpos;
        if ($bufflen == 0) {
            return YAPI::NO_MORE_DATA;
        }
        $res = ord($buff[0]);
        return $res;
    }

    /**
     * Reads data from the receive buffer as a string, starting at current stream position.
     * If data at current stream position is not available anymore in the receive buffer, the
     * function performs a short read.
     *
     * @param int $nChars : the maximum number of characters to read
     *
     * @return string  a string with receive buffer contents
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function readStr(int $nChars): string
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $mult                   is a int;
        // $endpos                 is a int;
        // $res                    is a str;
        if ($nChars > 65535) {
            $nChars = 65535;
        }

        $buff = $this->_download(sprintf('rxdata.bin?pos=%d&len=%d', $this->_rxptr, $nChars));
        $bufflen = strlen($buff) - 1;
        $endpos = 0;
        $mult = 1;
        while (($bufflen > 0) && (ord($buff[$bufflen]) != 64)) {
            $endpos = $endpos + $mult * (ord($buff[$bufflen]) - 48);
            $mult = $mult * 10;
            $bufflen = $bufflen - 1;
        }
        $this->_rxptr = $endpos;
        $res = substr(YAPI::Ybin2str($buff), 0, $bufflen);
        return $res;
    }

    /**
     * Reads data from the receive buffer as a binary buffer, starting at current stream position.
     * If data at current stream position is not available anymore in the receive buffer, the
     * function performs a short read.
     *
     * @param int $nChars : the maximum number of bytes to read
     *
     * @return string  a binary object with receive buffer contents
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function readBin(int $nChars): string
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $mult                   is a int;
        // $endpos                 is a int;
        // $idx                    is a int;
        // $res                    is a bin;
        if ($nChars > 65535) {
            $nChars = 65535;
        }

        $buff = $this->_download(sprintf('rxdata.bin?pos=%d&len=%d', $this->_rxptr, $nChars));
        $bufflen = strlen($buff) - 1;
        $endpos = 0;
        $mult = 1;
        while (($bufflen > 0) && (ord($buff[$bufflen]) != 64)) {
            $endpos = $endpos + $mult * (ord($buff[$bufflen]) - 48);
            $mult = $mult * 10;
            $bufflen = $bufflen - 1;
        }
        $this->_rxptr = $endpos;
        $res = ($bufflen > 0 ? pack('C',array_fill(0, $bufflen, 0)) : '');
        $idx = 0;
        while ($idx < $bufflen) {
            $res[$idx] = pack('C', ord($buff[$idx]));
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * Reads data from the receive buffer as a list of bytes, starting at current stream position.
     * If data at current stream position is not available anymore in the receive buffer, the
     * function performs a short read.
     *
     * @param int $nChars : the maximum number of bytes to read
     *
     * @return Integer[]  a sequence of bytes with receive buffer contents
     *
     * On failure, throws an exception or returns an empty array.
     * @throws YAPI_Exception on error
     */
    public function readArray(int $nChars): array
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $mult                   is a int;
        // $endpos                 is a int;
        // $idx                    is a int;
        // $b                      is a int;
        $res = [];              // intArr;
        if ($nChars > 65535) {
            $nChars = 65535;
        }

        $buff = $this->_download(sprintf('rxdata.bin?pos=%d&len=%d', $this->_rxptr, $nChars));
        $bufflen = strlen($buff) - 1;
        $endpos = 0;
        $mult = 1;
        while (($bufflen > 0) && (ord($buff[$bufflen]) != 64)) {
            $endpos = $endpos + $mult * (ord($buff[$bufflen]) - 48);
            $mult = $mult * 10;
            $bufflen = $bufflen - 1;
        }
        $this->_rxptr = $endpos;
        while (sizeof($res) > 0) {
            array_pop($res);
        };
        $idx = 0;
        while ($idx < $bufflen) {
            $b = ord($buff[$idx]);
            $res[] = $b;
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * Reads data from the receive buffer as a hexadecimal string, starting at current stream position.
     * If data at current stream position is not available anymore in the receive buffer, the
     * function performs a short read.
     *
     * @param int $nBytes : the maximum number of bytes to read
     *
     * @return string  a string with receive buffer contents, encoded in hexadecimal
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function readHex(int $nBytes): string
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $mult                   is a int;
        // $endpos                 is a int;
        // $ofs                    is a int;
        // $res                    is a str;
        if ($nBytes > 65535) {
            $nBytes = 65535;
        }

        $buff = $this->_download(sprintf('rxdata.bin?pos=%d&len=%d', $this->_rxptr, $nBytes));
        $bufflen = strlen($buff) - 1;
        $endpos = 0;
        $mult = 1;
        while (($bufflen > 0) && (ord($buff[$bufflen]) != 64)) {
            $endpos = $endpos + $mult * (ord($buff[$bufflen]) - 48);
            $mult = $mult * 10;
            $bufflen = $bufflen - 1;
        }
        $this->_rxptr = $endpos;
        $res = '';
        $ofs = 0;
        while ($ofs + 3 < $bufflen) {
            $res = sprintf('%s%02X%02X%02X%02X', $res, ord($buff[$ofs]), ord($buff[$ofs + 1]), ord($buff[$ofs + 2]), ord($buff[$ofs + 3]));
            $ofs = $ofs + 4;
        }
        while ($ofs < $bufflen) {
            $res = sprintf('%s%02X', $res, ord($buff[$ofs]));
            $ofs = $ofs + 1;
        }
        return $res;
    }

    /**
     * Manually sets the state of the SS line. This function has no effect when
     * the SS line is handled automatically.
     *
     * @param int $val : 1 to turn SS active, 0 to release SS.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_SS(int $val): int
    {
        return $this->sendCommand(sprintf('S%d',$val));
    }

    /**
     * Retrieves messages (both direction) in the SPI port buffer, starting at current position.
     *
     * If no message is found, the search waits for one up to the specified maximum timeout
     * (in milliseconds).
     *
     * @param int $maxWait : the maximum number of milliseconds to wait for a message if none is found
     *         in the receive buffer.
     * @param int $maxMsg : the maximum number of messages to be returned by the function; up to 254.
     *
     * @return YSpiSnoopingRecord[]  an array of YSpiSnoopingRecord objects containing the messages found, if any.
     *
     * On failure, throws an exception or returns an empty array.
     * @throws YAPI_Exception on error
     */
    public function snoopMessagesEx(int $maxWait, int $maxMsg): array
    {
        // $url                    is a str;
        // $msgbin                 is a bin;
        $msgarr = [];           // binArr;
        // $msglen                 is a int;
        $res = [];              // YSpiSnoopingRecordArr;
        // $idx                    is a int;

        $url = sprintf('rxmsg.json?pos=%d&maxw=%d&t=0&len=%d', $this->_rxptr, $maxWait, $maxMsg);
        $msgbin = $this->_download($url);
        $msgarr = $this->_json_get_array($msgbin);
        $msglen = sizeof($msgarr);
        if ($msglen == 0) {
            return $res;
        }
        // last element of array is the new position
        $msglen = $msglen - 1;
        $this->_rxptr = $this->_decode_json_int($msgarr[$msglen]);
        $idx = 0;
        while ($idx < $msglen) {
            $res[] = new YSpiSnoopingRecord(YAPI::Ybin2str($msgarr[$idx]));
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * Retrieves messages (both direction) in the SPI port buffer, starting at current position.
     *
     * If no message is found, the search waits for one up to the specified maximum timeout
     * (in milliseconds).
     *
     * @param int $maxWait : the maximum number of milliseconds to wait for a message if none is found
     *         in the receive buffer.
     *
     * @return YSpiSnoopingRecord[]  an array of YSpiSnoopingRecord objects containing the messages found, if any.
     *
     * On failure, throws an exception or returns an empty array.
     * @throws YAPI_Exception on error
     */
    public function snoopMessages(int $maxWait): array
    {
        return $this->snoopMessagesEx($maxWait, 255);
    }

    /**
     * @throws YAPI_Exception
     */
    public function rxCount(): int
{
    return $this->get_rxCount();
}

    /**
     * @throws YAPI_Exception
     */
    public function txCount(): int
{
    return $this->get_txCount();
}

    /**
     * @throws YAPI_Exception
     */
    public function errCount(): int
{
    return $this->get_errCount();
}

    /**
     * @throws YAPI_Exception
     */
    public function rxMsgCount(): int
{
    return $this->get_rxMsgCount();
}

    /**
     * @throws YAPI_Exception
     */
    public function txMsgCount(): int
{
    return $this->get_txMsgCount();
}

    /**
     * @throws YAPI_Exception
     */
    public function lastMsg(): string
{
    return $this->get_lastMsg();
}

    /**
     * @throws YAPI_Exception
     */
    public function currentJob(): string
{
    return $this->get_currentJob();
}

    /**
     * @throws YAPI_Exception
     */
    public function setCurrentJob(string $newval): int
{
    return $this->set_currentJob($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function startupJob(): string
{
    return $this->get_startupJob();
}

    /**
     * @throws YAPI_Exception
     */
    public function setStartupJob(string $newval): int
{
    return $this->set_startupJob($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function jobMaxTask(): int
{
    return $this->get_jobMaxTask();
}

    /**
     * @throws YAPI_Exception
     */
    public function jobMaxSize(): int
{
    return $this->get_jobMaxSize();
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
     * @throws YAPI_Exception
     */
    public function protocol(): string
{
    return $this->get_protocol();
}

    /**
     * @throws YAPI_Exception
     */
    public function setProtocol(string $newval): int
{
    return $this->set_protocol($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function voltageLevel(): int
{
    return $this->get_voltageLevel();
}

    /**
     * @throws YAPI_Exception
     */
    public function setVoltageLevel(int $newval): int
{
    return $this->set_voltageLevel($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function spiMode(): string
{
    return $this->get_spiMode();
}

    /**
     * @throws YAPI_Exception
     */
    public function setSpiMode(string $newval): int
{
    return $this->set_spiMode($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function ssPolarity(): int
{
    return $this->get_ssPolarity();
}

    /**
     * @throws YAPI_Exception
     */
    public function setSsPolarity(int $newval): int
{
    return $this->set_ssPolarity($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function shiftSampling(): int
{
    return $this->get_shiftSampling();
}

    /**
     * @throws YAPI_Exception
     */
    public function setShiftSampling(int $newval): int
{
    return $this->set_shiftSampling($newval);
}

    /**
     * Continues the enumeration of SPI ports started using yFirstSpiPort().
     * Caution: You can't make any assumption about the returned SPI ports order.
     * If you want to find a specific an SPI port, use SpiPort.findSpiPort()
     * and a hardwareID or a logical name.
     *
     * @return ?YSpiPort  a pointer to a YSpiPort object, corresponding to
     *         an SPI port currently online, or a null pointer
     *         if there are no more SPI ports to enumerate.
     */
    public function nextSpiPort(): ?YSpiPort
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindSpiPort($next_hwid);
    }

    /**
     * Starts the enumeration of SPI ports currently accessible.
     * Use the method YSpiPort::nextSpiPort() to iterate on
     * next SPI ports.
     *
     * @return ?YSpiPort  a pointer to a YSpiPort object, corresponding to
     *         the first SPI port currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstSpiPort(): ?YSpiPort
    {
        $next_hwid = YAPI::getFirstHardwareId('SpiPort');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindSpiPort($next_hwid);
    }

    //--- (end of generated code: YSpiPort implementation)

};

//--- (generated code: YSpiPort functions)

/**
 * Retrieves an SPI port for a given identifier.
 * The identifier can be specified using several formats:
 *
 * - FunctionLogicalName
 * - ModuleSerialNumber.FunctionIdentifier
 * - ModuleSerialNumber.FunctionLogicalName
 * - ModuleLogicalName.FunctionIdentifier
 * - ModuleLogicalName.FunctionLogicalName
 *
 *
 * This function does not require that the SPI port is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method isOnline() to test if the SPI port is
 * indeed online at a given time. In case of ambiguity when looking for
 * an SPI port by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the SPI port, for instance
 *         YSPIMK01.spiPort.
 *
 * @return YSpiPort  a YSpiPort object allowing you to drive the SPI port.
 */
function yFindSpiPort(string $func): YSpiPort
{
    return YSpiPort::FindSpiPort($func);
}

/**
 * Starts the enumeration of SPI ports currently accessible.
 * Use the method YSpiPort::nextSpiPort() to iterate on
 * next SPI ports.
 *
 * @return ?YSpiPort  a pointer to a YSpiPort object, corresponding to
 *         the first SPI port currently online, or a null pointer
 *         if there are none.
 */
function yFirstSpiPort(): ?YSpiPort
{
    return YSpiPort::FirstSpiPort();
}

//--- (end of generated code: YSpiPort functions)

