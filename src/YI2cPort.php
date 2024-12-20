<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YI2cPort Class: I2C port control interface, available for instance in the Yocto-I2C
 *
 * The YI2cPort classe allows you to fully drive a Yoctopuce I2C port.
 * It can be used to send and receive data, and to configure communication
 * parameters (baud rate, etc).
 * Note that Yoctopuce I2C ports are not exposed as virtual COM ports.
 * They are meant to be used in the same way as all Yoctopuce devices.
 */
class YI2cPort extends YFunction
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
    const I2CVOLTAGELEVEL_OFF = 0;
    const I2CVOLTAGELEVEL_3V3 = 1;
    const I2CVOLTAGELEVEL_1V8 = 2;
    const I2CVOLTAGELEVEL_INVALID = -1;
    const I2CMODE_INVALID = YAPI::INVALID_STRING;
    //--- (end of generated code: YI2cPort declaration)

    //--- (generated code: YI2cPort attributes)
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
    protected int $_i2cVoltageLevel = self::I2CVOLTAGELEVEL_INVALID; // I2cVoltageLevel
    protected string $_i2cMode = self::I2CMODE_INVALID;        // I2cMode
    protected int $_rxptr = 0;                            // int
    protected string $_rxbuff = "";                           // bin
    protected int $_rxbuffptr = 0;                            // int

    //--- (end of generated code: YI2cPort attributes)

    function __construct(string $str_func)
    {
        //--- (generated code: YI2cPort constructor)
        parent::__construct($str_func);
        $this->_className = 'I2cPort';

        //--- (end of generated code: YI2cPort constructor)
    }

    //--- (generated code: YI2cPort implementation)

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
        case 'i2cVoltageLevel':
            $this->_i2cVoltageLevel = intval($val);
            return 1;
        case 'i2cMode':
            $this->_i2cMode = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the total number of bytes received since last reset.
     *
     * @return int  an integer corresponding to the total number of bytes received since last reset
     *
     * On failure, throws an exception or returns YI2cPort::RXCOUNT_INVALID.
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
     * On failure, throws an exception or returns YI2cPort::TXCOUNT_INVALID.
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
     * On failure, throws an exception or returns YI2cPort::ERRCOUNT_INVALID.
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
     * On failure, throws an exception or returns YI2cPort::RXMSGCOUNT_INVALID.
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
     * On failure, throws an exception or returns YI2cPort::TXMSGCOUNT_INVALID.
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
     * On failure, throws an exception or returns YI2cPort::LASTMSG_INVALID.
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
     * On failure, throws an exception or returns YI2cPort::CURRENTJOB_INVALID.
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
     * On failure, throws an exception or returns YI2cPort::STARTUPJOB_INVALID.
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
     * On failure, throws an exception or returns YI2cPort::JOBMAXTASK_INVALID.
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
     * On failure, throws an exception or returns YI2cPort::JOBMAXSIZE_INVALID.
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
     * Returns the type of protocol used to send I2C messages, as a string.
     * Possible values are
     * "Line" for messages separated by LF or
     * "Char" for continuous stream of codes.
     *
     * @return string  a string corresponding to the type of protocol used to send I2C messages, as a string
     *
     * On failure, throws an exception or returns YI2cPort::PROTOCOL_INVALID.
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
     * Changes the type of protocol used to send I2C messages.
     * Possible values are
     * "Line" for messages separated by LF or
     * "Char" for continuous stream of codes.
     * The suffix "/[wait]ms" can be added to reduce the transmit rate so that there
     * is always at lest the specified number of milliseconds between each message sent.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param string $newval : a string corresponding to the type of protocol used to send I2C messages
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
     * Returns the voltage level used on the I2C bus.
     *
     * @return int  a value among YI2cPort::I2CVOLTAGELEVEL_OFF, YI2cPort::I2CVOLTAGELEVEL_3V3 and
     * YI2cPort::I2CVOLTAGELEVEL_1V8 corresponding to the voltage level used on the I2C bus
     *
     * On failure, throws an exception or returns YI2cPort::I2CVOLTAGELEVEL_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_i2cVoltageLevel(): int
    {
        // $res                    is a enumI2CVOLTAGELEVEL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::I2CVOLTAGELEVEL_INVALID;
            }
        }
        $res = $this->_i2cVoltageLevel;
        return $res;
    }

    /**
     * Changes the voltage level used on the I2C bus.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param int $newval : a value among YI2cPort::I2CVOLTAGELEVEL_OFF, YI2cPort::I2CVOLTAGELEVEL_3V3 and
     * YI2cPort::I2CVOLTAGELEVEL_1V8 corresponding to the voltage level used on the I2C bus
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_i2cVoltageLevel(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("i2cVoltageLevel", $rest_val);
    }

    /**
     * Returns the I2C port communication parameters, as a string such as
     * "400kbps,2000ms,NoRestart". The string includes the baud rate, the
     * recovery delay after communications errors, and if needed the option
     * NoRestart to use a Stop/Start sequence instead of the
     * Restart state when performing read on the I2C bus.
     *
     * @return string  a string corresponding to the I2C port communication parameters, as a string such as
     *         "400kbps,2000ms,NoRestart"
     *
     * On failure, throws an exception or returns YI2cPort::I2CMODE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_i2cMode(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::I2CMODE_INVALID;
            }
        }
        $res = $this->_i2cMode;
        return $res;
    }

    /**
     * Changes the I2C port communication parameters, with a string such as
     * "400kbps,2000ms". The string includes the baud rate, the
     * recovery delay after communications errors, and if needed the option
     * NoRestart to use a Stop/Start sequence instead of the
     * Restart state when performing read on the I2C bus.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param string $newval : a string corresponding to the I2C port communication parameters, with a string such as
     *         "400kbps,2000ms"
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_i2cMode(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("i2cMode", $rest_val);
    }

    /**
     * Retrieves an I2C port for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the I2C port is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the I2C port is
     * indeed online at a given time. In case of ambiguity when looking for
     * an I2C port by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the I2C port, for instance
     *         YI2CMK01.i2cPort.
     *
     * @return YI2cPort  a YI2cPort object allowing you to drive the I2C port.
     */
    public static function FindI2cPort(string $func): YI2cPort
    {
        // $obj                    is a YI2cPort;
        $obj = YFunction::_FindFromCache('I2cPort', $func);
        if ($obj == null) {
            $obj = new YI2cPort($func);
            YFunction::_AddToCache('I2cPort', $func, $obj);
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
        $this->_rxptr = 0;
        $this->_rxbuffptr = 0;
        $this->_rxbuff = '';

        return $this->sendCommand('Z');
    }

    /**
     * Sends a one-way message (provided as a a binary buffer) to a device on the I2C bus.
     * This function checks and reports communication errors on the I2C bus.
     *
     * @param int $slaveAddr : the 7-bit address of the slave device (without the direction bit)
     * @param string $buff : the binary buffer to be sent
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function i2cSendBin(int $slaveAddr, string $buff): int
    {
        // $nBytes                 is a int;
        // $idx                    is a int;
        // $val                    is a int;
        // $msg                    is a str;
        // $reply                  is a str;
        $msg = sprintf('@%02x:', $slaveAddr);
        $nBytes = strlen($buff);
        $idx = 0;
        while ($idx < $nBytes) {
            $val = ord($buff[$idx]);
            $msg = sprintf('%s%02x', $msg, $val);
            $idx = $idx + 1;
        }

        $reply = $this->queryLine($msg,1000);
        if (!(mb_strlen($reply) > 0)) return $this->_throw(YAPI::IO_ERROR,'No response from I2C device',YAPI::IO_ERROR);
        $idx = YAPI::Ystrpos($reply,'[N]!');
        if (!($idx < 0)) return $this->_throw(YAPI::IO_ERROR,'No I2C ACK received',YAPI::IO_ERROR);
        $idx = YAPI::Ystrpos($reply,'!');
        if (!($idx < 0)) return $this->_throw(YAPI::IO_ERROR,'I2C protocol error',YAPI::IO_ERROR);
        return YAPI::SUCCESS;
    }

    /**
     * Sends a one-way message (provided as a list of integer) to a device on the I2C bus.
     * This function checks and reports communication errors on the I2C bus.
     *
     * @param int $slaveAddr : the 7-bit address of the slave device (without the direction bit)
     * @param Integer[] $values : a list of data bytes to be sent
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function i2cSendArray(int $slaveAddr, array $values): int
    {
        // $nBytes                 is a int;
        // $idx                    is a int;
        // $val                    is a int;
        // $msg                    is a str;
        // $reply                  is a str;
        $msg = sprintf('@%02x:', $slaveAddr);
        $nBytes = sizeof($values);
        $idx = 0;
        while ($idx < $nBytes) {
            $val = $values[$idx];
            $msg = sprintf('%s%02x', $msg, $val);
            $idx = $idx + 1;
        }

        $reply = $this->queryLine($msg,1000);
        if (!(mb_strlen($reply) > 0)) return $this->_throw(YAPI::IO_ERROR,'No response from I2C device',YAPI::IO_ERROR);
        $idx = YAPI::Ystrpos($reply,'[N]!');
        if (!($idx < 0)) return $this->_throw(YAPI::IO_ERROR,'No I2C ACK received',YAPI::IO_ERROR);
        $idx = YAPI::Ystrpos($reply,'!');
        if (!($idx < 0)) return $this->_throw(YAPI::IO_ERROR,'I2C protocol error',YAPI::IO_ERROR);
        return YAPI::SUCCESS;
    }

    /**
     * Sends a one-way message (provided as a a binary buffer) to a device on the I2C bus,
     * then read back the specified number of bytes from device.
     * This function checks and reports communication errors on the I2C bus.
     *
     * @param int $slaveAddr : the 7-bit address of the slave device (without the direction bit)
     * @param string $buff : the binary buffer to be sent
     * @param int $rcvCount : the number of bytes to receive once the data bytes are sent
     *
     * @return string  a list of bytes with the data received from slave device.
     *
     * On failure, throws an exception or returns an empty binary buffer.
     * @throws YAPI_Exception on error
     */
    public function i2cSendAndReceiveBin(int $slaveAddr, string $buff, int $rcvCount): string
    {
        // $nBytes                 is a int;
        // $idx                    is a int;
        // $val                    is a int;
        // $msg                    is a str;
        // $reply                  is a str;
        // $rcvbytes               is a bin;
        $rcvbytes = '';
        if (!($rcvCount<=512)) return $this->_throw(YAPI::INVALID_ARGUMENT,'Cannot read more than 512 bytes',$rcvbytes);
        $msg = sprintf('@%02x:', $slaveAddr);
        $nBytes = strlen($buff);
        $idx = 0;
        while ($idx < $nBytes) {
            $val = ord($buff[$idx]);
            $msg = sprintf('%s%02x', $msg, $val);
            $idx = $idx + 1;
        }
        $idx = 0;
        if ($rcvCount > 54) {
            while ($rcvCount - $idx > 255) {
                $msg = sprintf('%sxx*FF', $msg);
                $idx = $idx + 255;
            }
            if ($rcvCount - $idx > 2) {
                $msg = sprintf('%sxx*%02X', $msg, ($rcvCount - $idx));
                $idx = $rcvCount;
            }
        }
        while ($idx < $rcvCount) {
            $msg = sprintf('%sxx', $msg);
            $idx = $idx + 1;
        }

        $reply = $this->queryLine($msg,1000);
        if (!(mb_strlen($reply) > 0)) return $this->_throw(YAPI::IO_ERROR,'No response from I2C device',$rcvbytes);
        $idx = YAPI::Ystrpos($reply,'[N]!');
        if (!($idx < 0)) return $this->_throw(YAPI::IO_ERROR,'No I2C ACK received',$rcvbytes);
        $idx = YAPI::Ystrpos($reply,'!');
        if (!($idx < 0)) return $this->_throw(YAPI::IO_ERROR,'I2C protocol error',$rcvbytes);
        $reply = substr($reply, mb_strlen($reply)-2*$rcvCount, 2*$rcvCount);
        $rcvbytes = YAPI::_hexStrToBin($reply);
        return $rcvbytes;
    }

    /**
     * Sends a one-way message (provided as a list of integer) to a device on the I2C bus,
     * then read back the specified number of bytes from device.
     * This function checks and reports communication errors on the I2C bus.
     *
     * @param int $slaveAddr : the 7-bit address of the slave device (without the direction bit)
     * @param Integer[] $values : a list of data bytes to be sent
     * @param int $rcvCount : the number of bytes to receive once the data bytes are sent
     *
     * @return Integer[]  a list of bytes with the data received from slave device.
     *
     * On failure, throws an exception or returns an empty array.
     * @throws YAPI_Exception on error
     */
    public function i2cSendAndReceiveArray(int $slaveAddr, array $values, int $rcvCount): array
    {
        // $nBytes                 is a int;
        // $idx                    is a int;
        // $val                    is a int;
        // $msg                    is a str;
        // $reply                  is a str;
        // $rcvbytes               is a bin;
        $res = [];              // intArr;
        while (sizeof($res) > 0) {
            array_pop($res);
        };
        if (!($rcvCount<=512)) return $this->_throw(YAPI::INVALID_ARGUMENT,'Cannot read more than 512 bytes',$res);
        $msg = sprintf('@%02x:', $slaveAddr);
        $nBytes = sizeof($values);
        $idx = 0;
        while ($idx < $nBytes) {
            $val = $values[$idx];
            $msg = sprintf('%s%02x', $msg, $val);
            $idx = $idx + 1;
        }
        $idx = 0;
        if ($rcvCount > 54) {
            while ($rcvCount - $idx > 255) {
                $msg = sprintf('%sxx*FF', $msg);
                $idx = $idx + 255;
            }
            if ($rcvCount - $idx > 2) {
                $msg = sprintf('%sxx*%02X', $msg, ($rcvCount - $idx));
                $idx = $rcvCount;
            }
        }
        while ($idx < $rcvCount) {
            $msg = sprintf('%sxx', $msg);
            $idx = $idx + 1;
        }

        $reply = $this->queryLine($msg,1000);
        if (!(mb_strlen($reply) > 0)) return $this->_throw(YAPI::IO_ERROR,'No response from I2C device',$res);
        $idx = YAPI::Ystrpos($reply,'[N]!');
        if (!($idx < 0)) return $this->_throw(YAPI::IO_ERROR,'No I2C ACK received',$res);
        $idx = YAPI::Ystrpos($reply,'!');
        if (!($idx < 0)) return $this->_throw(YAPI::IO_ERROR,'I2C protocol error',$res);
        $reply = substr($reply, mb_strlen($reply)-2*$rcvCount, 2*$rcvCount);
        $rcvbytes = YAPI::_hexStrToBin($reply);
        while (sizeof($res) > 0) {
            array_pop($res);
        };
        $idx = 0;
        while ($idx < $rcvCount) {
            $val = ord($rcvbytes[$idx]);
            $res[] = $val;
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * Sends a text-encoded I2C code stream to the I2C bus, as is.
     * An I2C code stream is a string made of hexadecimal data bytes,
     * but that may also include the I2C state transitions code:
     * "{S}" to emit a start condition,
     * "{R}" for a repeated start condition,
     * "{P}" for a stop condition,
     * "xx" for receiving a data byte,
     * "{A}" to ack a data byte received and
     * "{N}" to nack a data byte received.
     * If a newline ("\n") is included in the stream, the message
     * will be terminated and a newline will also be added to the
     * receive stream.
     *
     * @param string $codes : the code stream to send
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function writeStr(string $codes): int
    {
        // $bufflen                is a int;
        // $buff                   is a bin;
        // $idx                    is a int;
        // $ch                     is a int;
        $buff = YAPI::Ystr2bin($codes);
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
                return $this->sendCommand(sprintf('+%s',$codes));
            }
        }
        // send string using file upload
        return $this->_upload('txdata', $buff);
    }

    /**
     * Sends a text-encoded I2C code stream to the I2C bus, and terminate
     * the message en relâchant le bus.
     * An I2C code stream is a string made of hexadecimal data bytes,
     * but that may also include the I2C state transitions code:
     * "{S}" to emit a start condition,
     * "{R}" for a repeated start condition,
     * "{P}" for a stop condition,
     * "xx" for receiving a data byte,
     * "{A}" to ack a data byte received and
     * "{N}" to nack a data byte received.
     * At the end of the stream, a stop condition is added if missing
     * and a newline is added to the receive buffer as well.
     *
     * @param string $codes : the code stream to send
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function writeLine(string $codes): int
    {
        // $bufflen                is a int;
        // $buff                   is a bin;
        $bufflen = mb_strlen($codes);
        if ($bufflen < 100) {
            return $this->sendCommand(sprintf('!%s',$codes));
        }
        // send string using file upload
        $buff = YAPI::Ystr2bin(sprintf('%s'."\n".'', $codes));
        return $this->_upload('txdata', $buff);
    }

    /**
     * Sends a single byte to the I2C bus. Depending on the I2C bus state, the byte
     * will be interpreted as an address byte or a data byte.
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
        return $this->sendCommand(sprintf('+%02X', $code));
    }

    /**
     * Sends a byte sequence (provided as a hexadecimal string) to the I2C bus.
     * Depending on the I2C bus state, the first byte will be interpreted as an
     * address byte or a data byte.
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
        // $bufflen                is a int;
        // $buff                   is a bin;
        $bufflen = mb_strlen($hexString);
        if ($bufflen < 100) {
            return $this->sendCommand(sprintf('+%s',$hexString));
        }
        $buff = YAPI::Ystr2bin($hexString);

        return $this->_upload('txdata', $buff);
    }

    /**
     * Sends a binary buffer to the I2C bus, as is.
     * Depending on the I2C bus state, the first byte will be interpreted
     * as an address byte or a data byte.
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
        // $nBytes                 is a int;
        // $idx                    is a int;
        // $val                    is a int;
        // $msg                    is a str;
        $msg = '';
        $nBytes = strlen($buff);
        $idx = 0;
        while ($idx < $nBytes) {
            $val = ord($buff[$idx]);
            $msg = sprintf('%s%02x', $msg, $val);
            $idx = $idx + 1;
        }

        return $this->writeHex($msg);
    }

    /**
     * Sends a byte sequence (provided as a list of bytes) to the I2C bus.
     * Depending on the I2C bus state, the first byte will be interpreted as an
     * address byte or a data byte.
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
        // $nBytes                 is a int;
        // $idx                    is a int;
        // $val                    is a int;
        // $msg                    is a str;
        $msg = '';
        $nBytes = sizeof($byteList);
        $idx = 0;
        while ($idx < $nBytes) {
            $val = $byteList[$idx];
            $msg = sprintf('%s%02x', $msg, $val);
            $idx = $idx + 1;
        }

        return $this->writeHex($msg);
    }

    /**
     * Retrieves messages (both direction) in the I2C port buffer, starting at current position.
     *
     * If no message is found, the search waits for one up to the specified maximum timeout
     * (in milliseconds).
     *
     * @param int $maxWait : the maximum number of milliseconds to wait for a message if none is found
     *         in the receive buffer.
     * @param int $maxMsg : the maximum number of messages to be returned by the function; up to 254.
     *
     * @return YI2cSnoopingRecord[]  an array of YI2cSnoopingRecord objects containing the messages found, if any.
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
        $res = [];              // YI2cSnoopingRecordArr;
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
            $res[] = new YI2cSnoopingRecord(YAPI::Ybin2str($msgarr[$idx]));
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * Retrieves messages (both direction) in the I2C port buffer, starting at current position.
     *
     * If no message is found, the search waits for one up to the specified maximum timeout
     * (in milliseconds).
     *
     * @param int $maxWait : the maximum number of milliseconds to wait for a message if none is found
     *         in the receive buffer.
     *
     * @return YI2cSnoopingRecord[]  an array of YI2cSnoopingRecord objects containing the messages found, if any.
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
    public function i2cVoltageLevel(): int
{
    return $this->get_i2cVoltageLevel();
}

    /**
     * @throws YAPI_Exception
     */
    public function setI2cVoltageLevel(int $newval): int
{
    return $this->set_i2cVoltageLevel($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function i2cMode(): string
{
    return $this->get_i2cMode();
}

    /**
     * @throws YAPI_Exception
     */
    public function setI2cMode(string $newval): int
{
    return $this->set_i2cMode($newval);
}

    /**
     * Continues the enumeration of I2C ports started using yFirstI2cPort().
     * Caution: You can't make any assumption about the returned I2C ports order.
     * If you want to find a specific an I2C port, use I2cPort.findI2cPort()
     * and a hardwareID or a logical name.
     *
     * @return ?YI2cPort  a pointer to a YI2cPort object, corresponding to
     *         an I2C port currently online, or a null pointer
     *         if there are no more I2C ports to enumerate.
     */
    public function nextI2cPort(): ?YI2cPort
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindI2cPort($next_hwid);
    }

    /**
     * Starts the enumeration of I2C ports currently accessible.
     * Use the method YI2cPort::nextI2cPort() to iterate on
     * next I2C ports.
     *
     * @return ?YI2cPort  a pointer to a YI2cPort object, corresponding to
     *         the first I2C port currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstI2cPort(): ?YI2cPort
    {
        $next_hwid = YAPI::getFirstHardwareId('I2cPort');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindI2cPort($next_hwid);
    }

    //--- (end of generated code: YI2cPort implementation)

}

;
