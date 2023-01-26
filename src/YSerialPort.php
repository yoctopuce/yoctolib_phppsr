<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YSerialPort Class: serial port control interface, available for instance in the Yocto-RS232, the
 * Yocto-RS485-V2 or the Yocto-Serial
 *
 * The YSerialPort class allows you to fully drive a Yoctopuce serial port.
 * It can be used to send and receive data, and to configure communication
 * parameters (baud rate, bit count, parity, flow control and protocol).
 * Note that Yoctopuce serial ports are not exposed as virtual COM ports.
 * They are meant to be used in the same way as all Yoctopuce devices.
 */
class YSerialPort extends YFunction
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
    const SERIALMODE_INVALID = YAPI::INVALID_STRING;
    //--- (end of generated code: YSerialPort declaration)

    //--- (generated code: YSerialPort attributes)
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
    protected string $_serialMode = self::SERIALMODE_INVALID;     // SerialMode
    protected int $_rxptr = 0;                            // int
    protected string $_rxbuff = "";                           // bin
    protected int $_rxbuffptr = 0;                            // int
    protected int $_eventPos = 0;                            // int
    protected mixed $_eventCallback = null;                         // YSnoopingCallback

    //--- (end of generated code: YSerialPort attributes)

    function __construct($str_func)
    {
        //--- (generated code: YSerialPort constructor)
        parent::__construct($str_func);
        $this->_className = 'SerialPort';

        //--- (end of generated code: YSerialPort constructor)
    }

    //--- (generated code: YSerialPort implementation)

    function _parseAttr($name, $val): int
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
        case 'serialMode':
            $this->_serialMode = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the total number of bytes received since last reset.
     *
     * @return int  an integer corresponding to the total number of bytes received since last reset
     *
     * On failure, throws an exception or returns YSerialPort::RXCOUNT_INVALID.
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
     * On failure, throws an exception or returns YSerialPort::TXCOUNT_INVALID.
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
     * On failure, throws an exception or returns YSerialPort::ERRCOUNT_INVALID.
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
     * On failure, throws an exception or returns YSerialPort::RXMSGCOUNT_INVALID.
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
     * On failure, throws an exception or returns YSerialPort::TXMSGCOUNT_INVALID.
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
     * Returns the latest message fully received (for Line, Frame and Modbus protocols).
     *
     * @return string  a string corresponding to the latest message fully received (for Line, Frame and
     * Modbus protocols)
     *
     * On failure, throws an exception or returns YSerialPort::LASTMSG_INVALID.
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
     * On failure, throws an exception or returns YSerialPort::CURRENTJOB_INVALID.
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
     * On failure, throws an exception or returns YSerialPort::STARTUPJOB_INVALID.
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
     * On failure, throws an exception or returns YSerialPort::JOBMAXTASK_INVALID.
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
     * On failure, throws an exception or returns YSerialPort::JOBMAXSIZE_INVALID.
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

    public function set_command(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("command", $rest_val);
    }

    /**
     * Returns the type of protocol used over the serial line, as a string.
     * Possible values are "Line" for ASCII messages separated by CR and/or LF,
     * "StxEtx" for ASCII messages delimited by STX/ETX codes,
     * "Frame:[timeout]ms" for binary messages separated by a delay time,
     * "Modbus-ASCII" for MODBUS messages in ASCII mode,
     * "Modbus-RTU" for MODBUS messages in RTU mode,
     * "Wiegand-ASCII" for Wiegand messages in ASCII mode,
     * "Wiegand-26","Wiegand-34", etc for Wiegand messages in byte mode,
     * "Char" for a continuous ASCII stream or
     * "Byte" for a continuous binary stream.
     *
     * @return string  a string corresponding to the type of protocol used over the serial line, as a string
     *
     * On failure, throws an exception or returns YSerialPort::PROTOCOL_INVALID.
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
     * "StxEtx" for ASCII messages delimited by STX/ETX codes,
     * "Frame:[timeout]ms" for binary messages separated by a delay time,
     * "Modbus-ASCII" for MODBUS messages in ASCII mode,
     * "Modbus-RTU" for MODBUS messages in RTU mode,
     * "Wiegand-ASCII" for Wiegand messages in ASCII mode,
     * "Wiegand-26","Wiegand-34", etc for Wiegand messages in byte mode,
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
     */
    public function set_protocol(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("protocol", $rest_val);
    }

    /**
     * Returns the voltage level used on the serial line.
     *
     * @return int  a value among YSerialPort::VOLTAGELEVEL_OFF, YSerialPort::VOLTAGELEVEL_TTL3V,
     * YSerialPort::VOLTAGELEVEL_TTL3VR, YSerialPort::VOLTAGELEVEL_TTL5V, YSerialPort::VOLTAGELEVEL_TTL5VR,
     * YSerialPort::VOLTAGELEVEL_RS232, YSerialPort::VOLTAGELEVEL_RS485, YSerialPort::VOLTAGELEVEL_TTL1V8 and
     * YSerialPort::VOLTAGELEVEL_SDI12 corresponding to the voltage level used on the serial line
     *
     * On failure, throws an exception or returns YSerialPort::VOLTAGELEVEL_INVALID.
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
     * @param int $newval : a value among YSerialPort::VOLTAGELEVEL_OFF, YSerialPort::VOLTAGELEVEL_TTL3V,
     * YSerialPort::VOLTAGELEVEL_TTL3VR, YSerialPort::VOLTAGELEVEL_TTL5V, YSerialPort::VOLTAGELEVEL_TTL5VR,
     * YSerialPort::VOLTAGELEVEL_RS232, YSerialPort::VOLTAGELEVEL_RS485, YSerialPort::VOLTAGELEVEL_TTL1V8 and
     * YSerialPort::VOLTAGELEVEL_SDI12 corresponding to the voltage type used on the serial line
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_voltageLevel(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("voltageLevel", $rest_val);
    }

    /**
     * Returns the serial port communication parameters, as a string such as
     * "9600,8N1". The string includes the baud rate, the number of data bits,
     * the parity, and the number of stop bits. An optional suffix is included
     * if flow control is active: "CtsRts" for hardware handshake, "XOnXOff"
     * for logical flow control and "Simplex" for acquiring a shared bus using
     * the RTS line (as used by some RS485 adapters for instance).
     *
     * @return string  a string corresponding to the serial port communication parameters, as a string such as
     *         "9600,8N1"
     *
     * On failure, throws an exception or returns YSerialPort::SERIALMODE_INVALID.
     */
    public function get_serialMode(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SERIALMODE_INVALID;
            }
        }
        $res = $this->_serialMode;
        return $res;
    }

    /**
     * Changes the serial port communication parameters, with a string such as
     * "9600,8N1". The string includes the baud rate, the number of data bits,
     * the parity, and the number of stop bits. An optional suffix can be added
     * to enable flow control: "CtsRts" for hardware handshake, "XOnXOff"
     * for logical flow control and "Simplex" for acquiring a shared bus using
     * the RTS line (as used by some RS485 adapters for instance).
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param string $newval : a string corresponding to the serial port communication parameters, with a
     * string such as
     *         "9600,8N1"
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_serialMode(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("serialMode", $rest_val);
    }

    /**
     * Retrieves a serial port for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the serial port is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the serial port is
     * indeed online at a given time. In case of ambiguity when looking for
     * a serial port by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the serial port, for instance
     *         RS232MK1.serialPort.
     *
     * @return YSerialPort  a YSerialPort object allowing you to drive the serial port.
     */
    public static function FindSerialPort(string $func): ?YSerialPort
    {
        // $obj                    is a YSerialPort;
        $obj = YFunction::_FindFromCache('SerialPort', $func);
        if ($obj == null) {
            $obj = new YSerialPort($func);
            YFunction::_AddToCache('SerialPort', $func, $obj);
        }
        return $obj;
    }

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
     */
    public function readLine(): string
    {
        // $url                    is a str;
        // $msgbin                 is a bin;
        $msgarr = [];           // strArr;
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
        $this->_rxptr = intVal($msgarr[$msglen]);
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
     */
    public function readMessages(string $pattern, int $maxWait): array
    {
        // $url                    is a str;
        // $msgbin                 is a bin;
        $msgarr = [];           // strArr;
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
        $this->_rxptr = intVal($msgarr[$msglen]);
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
        $availPosStr = $databin;
        $atPos = YAPI::Ystrpos($availPosStr,'@');
        $res = intVal(substr($availPosStr,  0, $atPos));
        return $res;
    }

    public function end_tell(): int
    {
        // $availPosStr            is a str;
        // $atPos                  is a int;
        // $res                    is a int;
        // $databin                is a bin;

        $databin = $this->_download(sprintf('rxcnt.bin?pos=%d', $this->_rxptr));
        $availPosStr = $databin;
        $atPos = YAPI::Ystrpos($availPosStr,'@');
        $res = intVal(substr($availPosStr,  $atPos+1, strlen($availPosStr)-$atPos-1));
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
     */
    public function queryLine(string $query, int $maxWait): string
    {
        // $prevpos                is a int;
        // $url                    is a str;
        // $msgbin                 is a bin;
        $msgarr = [];           // strArr;
        // $msglen                 is a int;
        // $res                    is a str;
        if (strlen($query) <= 80) {
            // fast query
            $url = sprintf('rxmsg.json?len=1&maxw=%d&cmd=!%s', $maxWait, $this->_escapeAttr($query));
        } else {
            // long query
            $prevpos = $this->end_tell();
            $this->_upload('txdata', $query . ''."\r".''."\n".'');
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
        $this->_rxptr = intVal($msgarr[$msglen]);
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
     */
    public function queryHex(string $hexString, int $maxWait): string
    {
        // $prevpos                is a int;
        // $url                    is a str;
        // $msgbin                 is a bin;
        $msgarr = [];           // strArr;
        // $msglen                 is a int;
        // $res                    is a str;
        if (strlen($hexString) <= 80) {
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
        $this->_rxptr = intVal($msgarr[$msglen]);
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
     */
    public function uploadJob(string $jobfile, string $jsonDef): int
    {
        $this->_upload($jobfile, $jsonDef);
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
     */
    public function writeStr(string $text): int
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $idx                    is a int;
        // $ch                     is a int;
        $buff = $text;
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
     */
    public function writeHex(string $hexString): int
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $idx                    is a int;
        // $hexb                   is a int;
        // $res                    is a int;
        $bufflen = strlen($hexString);
        if ($bufflen < 100) {
            return $this->sendCommand(sprintf('$%s',$hexString));
        }
        $bufflen = (($bufflen) >> (1));
        $buff = ($bufflen > 0 ? pack('C',array_fill(0, $bufflen, 0)) : '');
        $idx = 0;
        while ($idx < $bufflen) {
            $hexb = hexdec(substr($hexString,  2 * $idx, 2));
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
     */
    public function writeLine(string $text): int
    {
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $idx                    is a int;
        // $ch                     is a int;
        $buff = sprintf('%s'."\r".''."\n".'', $text);
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
        $res = substr($buff,  0, $bufflen);
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
     * Emits a BREAK condition on the serial interface. When the specified
     * duration is 0, the BREAK signal will be exactly one character wide.
     * When the duration is between 1 and 100, the BREAK condition will
     * be hold for the specified number of milliseconds.
     *
     * @param int $duration : 0 for a standard BREAK, or duration between 1 and 100 ms
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function sendBreak(int $duration): int
    {
        return $this->sendCommand(sprintf('B%d',$duration));
    }

    /**
     * Manually sets the state of the RTS line. This function has no effect when
     * hardware handshake is enabled, as the RTS line is driven automatically.
     *
     * @param int $val : 1 to turn RTS on, 0 to turn RTS off
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_RTS(int $val): int
    {
        return $this->sendCommand(sprintf('R%d',$val));
    }

    /**
     * Reads the level of the CTS line. The CTS line is usually driven by
     * the RTS signal of the connected serial device.
     *
     * @return int  1 if the CTS line is high, 0 if the CTS line is low.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function get_CTS(): int
    {
        // $buff                   is a bin;
        // $res                    is a int;

        $buff = $this->_download('cts.txt');
        if (!(strlen($buff) == 1)) return $this->_throw( YAPI::IO_ERROR, 'invalid CTS reply',YAPI::IO_ERROR);
        $res = ord($buff[0]) - 48;
        return $res;
    }

    /**
     * Retrieves messages (both direction) in the serial port buffer, starting at current position.
     * This function will only compare and return printable characters in the message strings.
     * Binary protocols are handled as hexadecimal strings.
     *
     * If no message is found, the search waits for one up to the specified maximum timeout
     * (in milliseconds).
     *
     * @param int $maxWait : the maximum number of milliseconds to wait for a message if none is found
     *         in the receive buffer.
     *
     * @return YSnoopingRecord[]  an array of YSnoopingRecord objects containing the messages found, if any.
     *         Binary messages are converted to hexadecimal representation.
     *
     * On failure, throws an exception or returns an empty array.
     */
    public function snoopMessages(int $maxWait): array
    {
        // $url                    is a str;
        // $msgbin                 is a bin;
        $msgarr = [];           // strArr;
        // $msglen                 is a int;
        $res = [];              // YSnoopingRecordArr;
        // $idx                    is a int;

        $url = sprintf('rxmsg.json?pos=%d&maxw=%d&t=0', $this->_rxptr, $maxWait);
        $msgbin = $this->_download($url);
        $msgarr = $this->_json_get_array($msgbin);
        $msglen = sizeof($msgarr);
        if ($msglen == 0) {
            return $res;
        }
        // last element of array is the new position
        $msglen = $msglen - 1;
        $this->_rxptr = intVal($msgarr[$msglen]);
        $idx = 0;
        while ($idx < $msglen) {
            $res[] = new YSnoopingRecord($msgarr[$idx]);
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * Registers a callback function to be called each time that a message is sent or
     * received by the serial port. The callback is invoked only during the execution of
     * ySleep or yHandleEvents. This provides control over the time when
     * the callback is triggered. For good responsiveness, remember to call one of these
     * two functions periodically. To unregister a callback, pass a null pointer as argument.
     *
     * @param callable $callback : the callback function to call, or a null pointer.
     *         The callback function should take four arguments:
     *         the YSerialPort object that emitted the event, and
     *         the YSnoopingRecord object that describes the message
     *         sent or received.
     *         On failure, throws an exception or returns a negative error code.
     */
    public function registerSnoopingCallback(mixed $callback): int
    {
        if (!is_null($callback)) {
            $this->registerValueCallback('yInternalEventCallback');
        } else {
            $this->registerValueCallback(null);
        }
        // register user callback AFTER the internal pseudo-event,
        // to make sure we start with future events only
        $this->_eventCallback = $callback;
        return 0;
    }

    public function _internalEventHandler(string $advstr): int
    {
        // $url                    is a str;
        // $msgbin                 is a bin;
        $msgarr = [];           // strArr;
        // $msglen                 is a int;
        // $idx                    is a int;
        if (!(!is_null($this->_eventCallback))) {
            // first simulated event, use it only to initialize reference values
            $this->_eventPos = 0;
        }

        $url = sprintf('rxmsg.json?pos=%d&maxw=0&t=0', $this->_eventPos);
        $msgbin = $this->_download($url);
        $msgarr = $this->_json_get_array($msgbin);
        $msglen = sizeof($msgarr);
        if ($msglen == 0) {
            return YAPI::SUCCESS;
        }
        // last element of array is the new position
        $msglen = $msglen - 1;
        if (!(!is_null($this->_eventCallback))) {
            // first simulated event, use it only to initialize reference values
            $this->_eventPos = intVal($msgarr[$msglen]);
            return YAPI::SUCCESS;
        }
        $this->_eventPos = intVal($msgarr[$msglen]);
        $idx = 0;
        while ($idx < $msglen) {
            call_user_func($this->_eventCallback, $this, new YSnoopingRecord($msgarr[$idx]));
            $idx = $idx + 1;
        }
        return YAPI::SUCCESS;
    }

    /**
     * Sends an ASCII string to the serial port, preceeded with an STX code and
     * followed by an ETX code.
     *
     * @param string $text : the text string to send
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function writeStxEtx(string $text): int
    {
        // $buff                   is a bin;
        $buff = sprintf('%c%s%c', 2, $text, 3);
        // send string using file upload
        return $this->_upload('txdata', $buff);
    }

    /**
     * Sends a MODBUS message (provided as a hexadecimal string) to the serial port.
     * The message must start with the slave address. The MODBUS CRC/LRC is
     * automatically added by the function. This function does not wait for a reply.
     *
     * @param string $hexString : a hexadecimal message string, including device address but no CRC/LRC
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function writeMODBUS(string $hexString): int
    {
        return $this->sendCommand(sprintf(':%s',$hexString));
    }

    /**
     * Sends a message to a specified MODBUS slave connected to the serial port, and reads the
     * reply, if any. The message is the PDU, provided as a vector of bytes.
     *
     * @param int $slaveNo : the address of the slave MODBUS device to query
     * @param Integer[] $pduBytes : the message to send (PDU), as a vector of bytes. The first byte of the
     *         PDU is the MODBUS function code.
     *
     * @return Integer[]  the received reply, as a vector of bytes.
     *
     * On failure, throws an exception or returns an empty array (or a MODBUS error reply).
     */
    public function queryMODBUS(int $slaveNo, array $pduBytes): array
    {
        // $funCode                is a int;
        // $nib                    is a int;
        // $i                      is a int;
        // $cmd                    is a str;
        // $prevpos                is a int;
        // $url                    is a str;
        // $pat                    is a str;
        // $msgs                   is a bin;
        $reps = [];             // strArr;
        // $rep                    is a str;
        $res = [];              // intArr;
        // $replen                 is a int;
        // $hexb                   is a int;
        $funCode = $pduBytes[0];
        $nib = (($funCode) >> (4));
        $pat = sprintf('%02X[%X%X]%X.*', $slaveNo, $nib, ($nib+8), (($funCode) & (15)));
        $cmd = sprintf('%02X%02X', $slaveNo, $funCode);
        $i = 1;
        while ($i < sizeof($pduBytes)) {
            $cmd = sprintf('%s%02X', $cmd, (($pduBytes[$i]) & (0xff)));
            $i = $i + 1;
        }
        if (strlen($cmd) <= 80) {
            // fast query
            $url = sprintf('rxmsg.json?cmd=:%s&pat=:%s', $cmd, $pat);
        } else {
            // long query
            $prevpos = $this->end_tell();
            $this->_upload('txdata:', YAPI::_hexStrToBin($cmd));
            $url = sprintf('rxmsg.json?pos=%d&maxw=2000&pat=:%s', $prevpos, $pat);
        }

        $msgs = $this->_download($url);
        $reps = $this->_json_get_array($msgs);
        if (!(sizeof($reps) > 1)) return $this->_throw( YAPI::IO_ERROR, 'no reply from MODBUS slave',$res);
        if (sizeof($reps) > 1) {
            $rep = $this->_json_get_string($reps[0]);
            $replen = ((strlen($rep) - 3) >> (1));
            $i = 0;
            while ($i < $replen) {
                $hexb = hexdec(substr($rep, 2 * $i + 3, 2));
                $res[] = $hexb;
                $i = $i + 1;
            }
            if ($res[0] != $funCode) {
                $i = $res[1];
                if (!($i > 1)) return $this->_throw( YAPI::NOT_SUPPORTED, 'MODBUS error: unsupported function code',$res);
                if (!($i > 2)) return $this->_throw( YAPI::INVALID_ARGUMENT, 'MODBUS error: illegal data address',$res);
                if (!($i > 3)) return $this->_throw( YAPI::INVALID_ARGUMENT, 'MODBUS error: illegal data value',$res);
                if (!($i > 4)) return $this->_throw( YAPI::INVALID_ARGUMENT, 'MODBUS error: failed to execute function',$res);
            }
        }
        return $res;
    }

    /**
     * Reads one or more contiguous internal bits (or coil status) from a MODBUS serial device.
     * This method uses the MODBUS function code 0x01 (Read Coils).
     *
     * @param int $slaveNo : the address of the slave MODBUS device to query
     * @param int $pduAddr : the relative address of the first bit/coil to read (zero-based)
     * @param int $nBits : the number of bits/coils to read
     *
     * @return Integer[]  a vector of integers, each corresponding to one bit.
     *
     * On failure, throws an exception or returns an empty array.
     */
    public function modbusReadBits(int $slaveNo, int $pduAddr, int $nBits): array
    {
        $pdu = [];              // intArr;
        $reply = [];            // intArr;
        $res = [];              // intArr;
        // $bitpos                 is a int;
        // $idx                    is a int;
        // $val                    is a int;
        // $mask                   is a int;
        $pdu[] = 0x01;
        $pdu[] = (($pduAddr) >> (8));
        $pdu[] = (($pduAddr) & (0xff));
        $pdu[] = (($nBits) >> (8));
        $pdu[] = (($nBits) & (0xff));

        $reply = $this->queryMODBUS($slaveNo, $pdu);
        if (sizeof($reply) == 0) {
            return $res;
        }
        if ($reply[0] != $pdu[0]) {
            return $res;
        }
        $bitpos = 0;
        $idx = 2;
        $val = $reply[$idx];
        $mask = 1;
        while ($bitpos < $nBits) {
            if ((($val) & ($mask)) == 0) {
                $res[] = 0;
            } else {
                $res[] = 1;
            }
            $bitpos = $bitpos + 1;
            if ($mask == 0x80) {
                $idx = $idx + 1;
                $val = $reply[$idx];
                $mask = 1;
            } else {
                $mask = (($mask) << (1));
            }
        }
        return $res;
    }

    /**
     * Reads one or more contiguous input bits (or discrete inputs) from a MODBUS serial device.
     * This method uses the MODBUS function code 0x02 (Read Discrete Inputs).
     *
     * @param int $slaveNo : the address of the slave MODBUS device to query
     * @param int $pduAddr : the relative address of the first bit/input to read (zero-based)
     * @param int $nBits : the number of bits/inputs to read
     *
     * @return Integer[]  a vector of integers, each corresponding to one bit.
     *
     * On failure, throws an exception or returns an empty array.
     */
    public function modbusReadInputBits(int $slaveNo, int $pduAddr, int $nBits): array
    {
        $pdu = [];              // intArr;
        $reply = [];            // intArr;
        $res = [];              // intArr;
        // $bitpos                 is a int;
        // $idx                    is a int;
        // $val                    is a int;
        // $mask                   is a int;
        $pdu[] = 0x02;
        $pdu[] = (($pduAddr) >> (8));
        $pdu[] = (($pduAddr) & (0xff));
        $pdu[] = (($nBits) >> (8));
        $pdu[] = (($nBits) & (0xff));

        $reply = $this->queryMODBUS($slaveNo, $pdu);
        if (sizeof($reply) == 0) {
            return $res;
        }
        if ($reply[0] != $pdu[0]) {
            return $res;
        }
        $bitpos = 0;
        $idx = 2;
        $val = $reply[$idx];
        $mask = 1;
        while ($bitpos < $nBits) {
            if ((($val) & ($mask)) == 0) {
                $res[] = 0;
            } else {
                $res[] = 1;
            }
            $bitpos = $bitpos + 1;
            if ($mask == 0x80) {
                $idx = $idx + 1;
                $val = $reply[$idx];
                $mask = 1;
            } else {
                $mask = (($mask) << (1));
            }
        }
        return $res;
    }

    /**
     * Reads one or more contiguous internal registers (holding registers) from a MODBUS serial device.
     * This method uses the MODBUS function code 0x03 (Read Holding Registers).
     *
     * @param int $slaveNo : the address of the slave MODBUS device to query
     * @param int $pduAddr : the relative address of the first holding register to read (zero-based)
     * @param int $nWords : the number of holding registers to read
     *
     * @return Integer[]  a vector of integers, each corresponding to one 16-bit register value.
     *
     * On failure, throws an exception or returns an empty array.
     */
    public function modbusReadRegisters(int $slaveNo, int $pduAddr, int $nWords): array
    {
        $pdu = [];              // intArr;
        $reply = [];            // intArr;
        $res = [];              // intArr;
        // $regpos                 is a int;
        // $idx                    is a int;
        // $val                    is a int;
        if (!($nWords<=256)) return $this->_throw( YAPI::INVALID_ARGUMENT, 'Cannot read more than 256 words',$res);
        $pdu[] = 0x03;
        $pdu[] = (($pduAddr) >> (8));
        $pdu[] = (($pduAddr) & (0xff));
        $pdu[] = (($nWords) >> (8));
        $pdu[] = (($nWords) & (0xff));

        $reply = $this->queryMODBUS($slaveNo, $pdu);
        if (sizeof($reply) == 0) {
            return $res;
        }
        if ($reply[0] != $pdu[0]) {
            return $res;
        }
        $regpos = 0;
        $idx = 2;
        while ($regpos < $nWords) {
            $val = (($reply[$idx]) << (8));
            $idx = $idx + 1;
            $val = $val + $reply[$idx];
            $idx = $idx + 1;
            $res[] = $val;
            $regpos = $regpos + 1;
        }
        return $res;
    }

    /**
     * Reads one or more contiguous input registers (read-only registers) from a MODBUS serial device.
     * This method uses the MODBUS function code 0x04 (Read Input Registers).
     *
     * @param int $slaveNo : the address of the slave MODBUS device to query
     * @param int $pduAddr : the relative address of the first input register to read (zero-based)
     * @param int $nWords : the number of input registers to read
     *
     * @return Integer[]  a vector of integers, each corresponding to one 16-bit input value.
     *
     * On failure, throws an exception or returns an empty array.
     */
    public function modbusReadInputRegisters(int $slaveNo, int $pduAddr, int $nWords): array
    {
        $pdu = [];              // intArr;
        $reply = [];            // intArr;
        $res = [];              // intArr;
        // $regpos                 is a int;
        // $idx                    is a int;
        // $val                    is a int;
        $pdu[] = 0x04;
        $pdu[] = (($pduAddr) >> (8));
        $pdu[] = (($pduAddr) & (0xff));
        $pdu[] = (($nWords) >> (8));
        $pdu[] = (($nWords) & (0xff));

        $reply = $this->queryMODBUS($slaveNo, $pdu);
        if (sizeof($reply) == 0) {
            return $res;
        }
        if ($reply[0] != $pdu[0]) {
            return $res;
        }
        $regpos = 0;
        $idx = 2;
        while ($regpos < $nWords) {
            $val = (($reply[$idx]) << (8));
            $idx = $idx + 1;
            $val = $val + $reply[$idx];
            $idx = $idx + 1;
            $res[] = $val;
            $regpos = $regpos + 1;
        }
        return $res;
    }

    /**
     * Sets a single internal bit (or coil) on a MODBUS serial device.
     * This method uses the MODBUS function code 0x05 (Write Single Coil).
     *
     * @param int $slaveNo : the address of the slave MODBUS device to drive
     * @param int $pduAddr : the relative address of the bit/coil to set (zero-based)
     * @param int $value : the value to set (0 for OFF state, non-zero for ON state)
     *
     * @return int  the number of bits/coils affected on the device (1)
     *
     * On failure, throws an exception or returns zero.
     */
    public function modbusWriteBit(int $slaveNo, int $pduAddr, int $value): int
    {
        $pdu = [];              // intArr;
        $reply = [];            // intArr;
        // $res                    is a int;
        $res = 0;
        if ($value != 0) {
            $value = 0xff;
        }
        $pdu[] = 0x05;
        $pdu[] = (($pduAddr) >> (8));
        $pdu[] = (($pduAddr) & (0xff));
        $pdu[] = $value;
        $pdu[] = 0x00;

        $reply = $this->queryMODBUS($slaveNo, $pdu);
        if (sizeof($reply) == 0) {
            return $res;
        }
        if ($reply[0] != $pdu[0]) {
            return $res;
        }
        $res = 1;
        return $res;
    }

    /**
     * Sets several contiguous internal bits (or coils) on a MODBUS serial device.
     * This method uses the MODBUS function code 0x0f (Write Multiple Coils).
     *
     * @param int $slaveNo : the address of the slave MODBUS device to drive
     * @param int $pduAddr : the relative address of the first bit/coil to set (zero-based)
     * @param Integer[] $bits : the vector of bits to be set (one integer per bit)
     *
     * @return int  the number of bits/coils affected on the device
     *
     * On failure, throws an exception or returns zero.
     */
    public function modbusWriteBits(int $slaveNo, int $pduAddr, array $bits): int
    {
        // $nBits                  is a int;
        // $nBytes                 is a int;
        // $bitpos                 is a int;
        // $val                    is a int;
        // $mask                   is a int;
        $pdu = [];              // intArr;
        $reply = [];            // intArr;
        // $res                    is a int;
        $res = 0;
        $nBits = sizeof($bits);
        $nBytes = ((($nBits + 7)) >> (3));
        $pdu[] = 0x0f;
        $pdu[] = (($pduAddr) >> (8));
        $pdu[] = (($pduAddr) & (0xff));
        $pdu[] = (($nBits) >> (8));
        $pdu[] = (($nBits) & (0xff));
        $pdu[] = $nBytes;
        $bitpos = 0;
        $val = 0;
        $mask = 1;
        while ($bitpos < $nBits) {
            if ($bits[$bitpos] != 0) {
                $val = (($val) | ($mask));
            }
            $bitpos = $bitpos + 1;
            if ($mask == 0x80) {
                $pdu[] = $val;
                $val = 0;
                $mask = 1;
            } else {
                $mask = (($mask) << (1));
            }
        }
        if ($mask != 1) {
            $pdu[] = $val;
        }

        $reply = $this->queryMODBUS($slaveNo, $pdu);
        if (sizeof($reply) == 0) {
            return $res;
        }
        if ($reply[0] != $pdu[0]) {
            return $res;
        }
        $res = (($reply[3]) << (8));
        $res = $res + $reply[4];
        return $res;
    }

    /**
     * Sets a single internal register (or holding register) on a MODBUS serial device.
     * This method uses the MODBUS function code 0x06 (Write Single Register).
     *
     * @param int $slaveNo : the address of the slave MODBUS device to drive
     * @param int $pduAddr : the relative address of the register to set (zero-based)
     * @param int $value : the 16 bit value to set
     *
     * @return int  the number of registers affected on the device (1)
     *
     * On failure, throws an exception or returns zero.
     */
    public function modbusWriteRegister(int $slaveNo, int $pduAddr, int $value): int
    {
        $pdu = [];              // intArr;
        $reply = [];            // intArr;
        // $res                    is a int;
        $res = 0;
        $pdu[] = 0x06;
        $pdu[] = (($pduAddr) >> (8));
        $pdu[] = (($pduAddr) & (0xff));
        $pdu[] = (($value) >> (8));
        $pdu[] = (($value) & (0xff));

        $reply = $this->queryMODBUS($slaveNo, $pdu);
        if (sizeof($reply) == 0) {
            return $res;
        }
        if ($reply[0] != $pdu[0]) {
            return $res;
        }
        $res = 1;
        return $res;
    }

    /**
     * Sets several contiguous internal registers (or holding registers) on a MODBUS serial device.
     * This method uses the MODBUS function code 0x10 (Write Multiple Registers).
     *
     * @param int $slaveNo : the address of the slave MODBUS device to drive
     * @param int $pduAddr : the relative address of the first internal register to set (zero-based)
     * @param Integer[] $values : the vector of 16 bit values to set
     *
     * @return int  the number of registers affected on the device
     *
     * On failure, throws an exception or returns zero.
     */
    public function modbusWriteRegisters(int $slaveNo, int $pduAddr, array $values): int
    {
        // $nWords                 is a int;
        // $nBytes                 is a int;
        // $regpos                 is a int;
        // $val                    is a int;
        $pdu = [];              // intArr;
        $reply = [];            // intArr;
        // $res                    is a int;
        $res = 0;
        $nWords = sizeof($values);
        $nBytes = 2 * $nWords;
        $pdu[] = 0x10;
        $pdu[] = (($pduAddr) >> (8));
        $pdu[] = (($pduAddr) & (0xff));
        $pdu[] = (($nWords) >> (8));
        $pdu[] = (($nWords) & (0xff));
        $pdu[] = $nBytes;
        $regpos = 0;
        while ($regpos < $nWords) {
            $val = $values[$regpos];
            $pdu[] = (($val) >> (8));
            $pdu[] = (($val) & (0xff));
            $regpos = $regpos + 1;
        }

        $reply = $this->queryMODBUS($slaveNo, $pdu);
        if (sizeof($reply) == 0) {
            return $res;
        }
        if ($reply[0] != $pdu[0]) {
            return $res;
        }
        $res = (($reply[3]) << (8));
        $res = $res + $reply[4];
        return $res;
    }

    /**
     * Sets several contiguous internal registers (holding registers) on a MODBUS serial device,
     * then performs a contiguous read of a set of (possibly different) internal registers.
     * This method uses the MODBUS function code 0x17 (Read/Write Multiple Registers).
     *
     * @param int $slaveNo : the address of the slave MODBUS device to drive
     * @param int $pduWriteAddr : the relative address of the first internal register to set (zero-based)
     * @param Integer[] $values : the vector of 16 bit values to set
     * @param int $pduReadAddr : the relative address of the first internal register to read (zero-based)
     * @param int $nReadWords : the number of 16 bit values to read
     *
     * @return Integer[]  a vector of integers, each corresponding to one 16-bit register value read.
     *
     * On failure, throws an exception or returns an empty array.
     */
    public function modbusWriteAndReadRegisters(int $slaveNo, int $pduWriteAddr, array $values, int $pduReadAddr, int $nReadWords): array
    {
        // $nWriteWords            is a int;
        // $nBytes                 is a int;
        // $regpos                 is a int;
        // $val                    is a int;
        // $idx                    is a int;
        $pdu = [];              // intArr;
        $reply = [];            // intArr;
        $res = [];              // intArr;
        $nWriteWords = sizeof($values);
        $nBytes = 2 * $nWriteWords;
        $pdu[] = 0x17;
        $pdu[] = (($pduReadAddr) >> (8));
        $pdu[] = (($pduReadAddr) & (0xff));
        $pdu[] = (($nReadWords) >> (8));
        $pdu[] = (($nReadWords) & (0xff));
        $pdu[] = (($pduWriteAddr) >> (8));
        $pdu[] = (($pduWriteAddr) & (0xff));
        $pdu[] = (($nWriteWords) >> (8));
        $pdu[] = (($nWriteWords) & (0xff));
        $pdu[] = $nBytes;
        $regpos = 0;
        while ($regpos < $nWriteWords) {
            $val = $values[$regpos];
            $pdu[] = (($val) >> (8));
            $pdu[] = (($val) & (0xff));
            $regpos = $regpos + 1;
        }

        $reply = $this->queryMODBUS($slaveNo, $pdu);
        if (sizeof($reply) == 0) {
            return $res;
        }
        if ($reply[0] != $pdu[0]) {
            return $res;
        }
        $regpos = 0;
        $idx = 2;
        while ($regpos < $nReadWords) {
            $val = (($reply[$idx]) << (8));
            $idx = $idx + 1;
            $val = $val + $reply[$idx];
            $idx = $idx + 1;
            $res[] = $val;
            $regpos = $regpos + 1;
        }
        return $res;
    }

    public function rxCount(): int
{
    return $this->get_rxCount();
}

    public function txCount(): int
{
    return $this->get_txCount();
}

    public function errCount(): int
{
    return $this->get_errCount();
}

    public function rxMsgCount(): int
{
    return $this->get_rxMsgCount();
}

    public function txMsgCount(): int
{
    return $this->get_txMsgCount();
}

    public function lastMsg(): string
{
    return $this->get_lastMsg();
}

    public function currentJob(): string
{
    return $this->get_currentJob();
}

    public function setCurrentJob(string $newval)
{
    return $this->set_currentJob($newval);
}

    public function startupJob(): string
{
    return $this->get_startupJob();
}

    public function setStartupJob(string $newval)
{
    return $this->set_startupJob($newval);
}

    public function jobMaxTask(): int
{
    return $this->get_jobMaxTask();
}

    public function jobMaxSize(): int
{
    return $this->get_jobMaxSize();
}

    public function command(): string
{
    return $this->get_command();
}

    public function setCommand(string $newval)
{
    return $this->set_command($newval);
}

    public function protocol(): string
{
    return $this->get_protocol();
}

    public function setProtocol(string $newval)
{
    return $this->set_protocol($newval);
}

    public function voltageLevel(): int
{
    return $this->get_voltageLevel();
}

    public function setVoltageLevel(int $newval)
{
    return $this->set_voltageLevel($newval);
}

    public function serialMode(): string
{
    return $this->get_serialMode();
}

    public function setSerialMode(string $newval)
{
    return $this->set_serialMode($newval);
}

    /**
     * Continues the enumeration of serial ports started using yFirstSerialPort().
     * Caution: You can't make any assumption about the returned serial ports order.
     * If you want to find a specific a serial port, use SerialPort.findSerialPort()
     * and a hardwareID or a logical name.
     *
     * @return YSerialPort  a pointer to a YSerialPort object, corresponding to
     *         a serial port currently online, or a null pointer
     *         if there are no more serial ports to enumerate.
     */
    public function nextSerialPort(): ?YSerialPort
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindSerialPort($next_hwid);
    }

    /**
     * Starts the enumeration of serial ports currently accessible.
     * Use the method YSerialPort::nextSerialPort() to iterate on
     * next serial ports.
     *
     * @return YSerialPort  a pointer to a YSerialPort object, corresponding to
     *         the first serial port currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstSerialPort()
    {
        $next_hwid = YAPI::getFirstHardwareId('SerialPort');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindSerialPort($next_hwid);
    }

    //--- (end of generated code: YSerialPort implementation)

};
