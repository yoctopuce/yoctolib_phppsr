<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YDigitalIO Class: digital IO port control interface, available for instance in the Yocto-IO or the
 * Yocto-Maxi-IO-V2
 *
 * The YDigitalIO class allows you drive a Yoctopuce digital input/output port.
 * It can be used to setup the direction of each channel, to read the state of each channel
 * and to switch the state of each channel configures as an output.
 * You can work on all channels at once, or one by one. Most functions
 * use a binary representation for channels where bit 0 matches channel #0 , bit 1 matches channel
 * #1 and so on. If you are not familiar with numbers binary representation, you will find more
 * information here: https://en.wikipedia.org/wiki/Binary_number#Representation. It is also possible
 * to automatically generate short pulses of a determined duration. Electrical behavior
 * of each I/O can be modified (open drain and reverse polarity).
 */
class YDigitalIO extends YFunction
{
    const PORTSTATE_INVALID = YAPI::INVALID_UINT;
    const PORTDIRECTION_INVALID = YAPI::INVALID_UINT;
    const PORTOPENDRAIN_INVALID = YAPI::INVALID_UINT;
    const PORTPOLARITY_INVALID = YAPI::INVALID_UINT;
    const PORTDIAGS_INVALID = YAPI::INVALID_UINT;
    const PORTSIZE_INVALID = YAPI::INVALID_UINT;
    const OUTPUTVOLTAGE_USB_5V = 0;
    const OUTPUTVOLTAGE_USB_3V = 1;
    const OUTPUTVOLTAGE_EXT_V = 2;
    const OUTPUTVOLTAGE_INVALID = -1;
    const COMMAND_INVALID = YAPI::INVALID_STRING;
    //--- (end of YDigitalIO declaration)

    //--- (YDigitalIO attributes)
    protected int $_portState = self::PORTSTATE_INVALID;      // BitByte
    protected int $_portDirection = self::PORTDIRECTION_INVALID;  // BitByte
    protected int $_portOpenDrain = self::PORTOPENDRAIN_INVALID;  // BitByte
    protected int $_portPolarity = self::PORTPOLARITY_INVALID;   // BitByte
    protected int $_portDiags = self::PORTDIAGS_INVALID;      // DigitalIODiags
    protected int $_portSize = self::PORTSIZE_INVALID;       // UInt31
    protected int $_outputVoltage = self::OUTPUTVOLTAGE_INVALID;  // IOVoltage
    protected string $_command = self::COMMAND_INVALID;        // Text

    //--- (end of YDigitalIO attributes)

    function __construct(string $str_func)
    {
        //--- (YDigitalIO constructor)
        parent::__construct($str_func);
        $this->_className = 'DigitalIO';

        //--- (end of YDigitalIO constructor)
    }

    //--- (YDigitalIO implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'portState':
            $this->_portState = intval($val);
            return 1;
        case 'portDirection':
            $this->_portDirection = intval($val);
            return 1;
        case 'portOpenDrain':
            $this->_portOpenDrain = intval($val);
            return 1;
        case 'portPolarity':
            $this->_portPolarity = intval($val);
            return 1;
        case 'portDiags':
            $this->_portDiags = intval($val);
            return 1;
        case 'portSize':
            $this->_portSize = intval($val);
            return 1;
        case 'outputVoltage':
            $this->_outputVoltage = intval($val);
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the digital IO port state as an integer with each bit
     * representing a channel.
     * value 0 = 0b00000000 -> all channels are OFF
     * value 1 = 0b00000001 -> channel #0 is ON
     * value 2 = 0b00000010 -> channel #1 is ON
     * value 3 = 0b00000011 -> channels #0 and #1 are ON
     * value 4 = 0b00000100 -> channel #2 is ON
     * and so on...
     *
     * @return int  an integer corresponding to the digital IO port state as an integer with each bit
     *         representing a channel
     *
     * On failure, throws an exception or returns YDigitalIO::PORTSTATE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_portState(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PORTSTATE_INVALID;
            }
        }
        $res = $this->_portState;
        return $res;
    }

    /**
     * Changes the state of all digital IO port's channels at once: the parameter
     * is an integer where each bit represents a channel, with bit 0 matching channel #0.
     * To set all channels to  0 -> 0b00000000 -> parameter = 0
     * To set channel #0 to 1 -> 0b00000001 -> parameter =  1
     * To set channel #1 to  1 -> 0b00000010 -> parameter = 2
     * To set channel #0 and #1 -> 0b00000011 -> parameter =  3
     * To set channel #2 to 1 -> 0b00000100 -> parameter =  4
     * an so on....
     * Only channels configured as outputs will be affecter, according to the value
     * configured using set_portDirection.
     *
     * @param int $newval : an integer corresponding to the state of all digital IO port's channels at
     * once: the parameter
     *         is an integer where each bit represents a channel, with bit 0 matching channel #0
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_portState(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("portState", $rest_val);
    }

    /**
     * Returns the I/O direction of all channels of the port (bitmap): 0 makes a bit an input, 1 makes it an output.
     *
     * @return int  an integer corresponding to the I/O direction of all channels of the port (bitmap): 0
     * makes a bit an input, 1 makes it an output
     *
     * On failure, throws an exception or returns YDigitalIO::PORTDIRECTION_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_portDirection(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PORTDIRECTION_INVALID;
            }
        }
        $res = $this->_portDirection;
        return $res;
    }

    /**
     * Changes the I/O direction of all channels of the port (bitmap): 0 makes a bit an input, 1 makes it an output.
     * Remember to call the saveToFlash() method  to make sure the setting is kept after a reboot.
     *
     * @param int $newval : an integer corresponding to the I/O direction of all channels of the port
     * (bitmap): 0 makes a bit an input, 1 makes it an output
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_portDirection(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("portDirection", $rest_val);
    }

    /**
     * Returns the electrical interface for each bit of the port. For each bit set to 0  the matching I/O
     * works in the regular,
     * intuitive way, for each bit set to 1, the I/O works in reverse mode.
     *
     * @return int  an integer corresponding to the electrical interface for each bit of the port
     *
     * On failure, throws an exception or returns YDigitalIO::PORTOPENDRAIN_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_portOpenDrain(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PORTOPENDRAIN_INVALID;
            }
        }
        $res = $this->_portOpenDrain;
        return $res;
    }

    /**
     * Changes the electrical interface for each bit of the port. 0 makes a bit a regular input/output, 1 makes
     * it an open-drain (open-collector) input/output. Remember to call the
     * saveToFlash() method  to make sure the setting is kept after a reboot.
     *
     * @param int $newval : an integer corresponding to the electrical interface for each bit of the port
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_portOpenDrain(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("portOpenDrain", $rest_val);
    }

    /**
     * Returns the polarity of all the bits of the port.  For each bit set to 0, the matching I/O works the regular,
     * intuitive way; for each bit set to 1, the I/O works in reverse mode.
     *
     * @return int  an integer corresponding to the polarity of all the bits of the port
     *
     * On failure, throws an exception or returns YDigitalIO::PORTPOLARITY_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_portPolarity(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PORTPOLARITY_INVALID;
            }
        }
        $res = $this->_portPolarity;
        return $res;
    }

    /**
     * Changes the polarity of all the bits of the port: For each bit set to 0, the matching I/O works the regular,
     * intuitive way; for each bit set to 1, the I/O works in reverse mode.
     * Remember to call the saveToFlash() method  to make sure the setting will be kept after a reboot.
     *
     * @param int $newval : an integer corresponding to the polarity of all the bits of the port: For each
     * bit set to 0, the matching I/O works the regular,
     *         intuitive way; for each bit set to 1, the I/O works in reverse mode
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_portPolarity(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("portPolarity", $rest_val);
    }

    /**
     * Returns the port state diagnostics. Bit 0 indicates a shortcut on output 0, etc.
     * Bit 8 indicates a power failure, and bit 9 signals overheating (overcurrent).
     * During normal use, all diagnostic bits should stay clear.
     *
     * @return int  an integer corresponding to the port state diagnostics
     *
     * On failure, throws an exception or returns YDigitalIO::PORTDIAGS_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_portDiags(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PORTDIAGS_INVALID;
            }
        }
        $res = $this->_portDiags;
        return $res;
    }

    /**
     * Returns the number of bits (i.e. channels)implemented in the I/O port.
     *
     * @return int  an integer corresponding to the number of bits (i.e
     *
     * On failure, throws an exception or returns YDigitalIO::PORTSIZE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_portSize(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration == 0) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PORTSIZE_INVALID;
            }
        }
        $res = $this->_portSize;
        return $res;
    }

    /**
     * Returns the voltage source used to drive output bits.
     *
     * @return int  a value among YDigitalIO::OUTPUTVOLTAGE_USB_5V, YDigitalIO::OUTPUTVOLTAGE_USB_3V and
     * YDigitalIO::OUTPUTVOLTAGE_EXT_V corresponding to the voltage source used to drive output bits
     *
     * On failure, throws an exception or returns YDigitalIO::OUTPUTVOLTAGE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_outputVoltage(): int
    {
        // $res                    is a enumIOVOLTAGE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::OUTPUTVOLTAGE_INVALID;
            }
        }
        $res = $this->_outputVoltage;
        return $res;
    }

    /**
     * Changes the voltage source used to drive output bits.
     * Remember to call the saveToFlash() method  to make sure the setting is kept after a reboot.
     *
     * @param int $newval : a value among YDigitalIO::OUTPUTVOLTAGE_USB_5V, YDigitalIO::OUTPUTVOLTAGE_USB_3V
     * and YDigitalIO::OUTPUTVOLTAGE_EXT_V corresponding to the voltage source used to drive output bits
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_outputVoltage(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("outputVoltage", $rest_val);
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
     * Retrieves a digital IO port for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the digital IO port is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the digital IO port is
     * indeed online at a given time. In case of ambiguity when looking for
     * a digital IO port by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the digital IO port, for instance
     *         YMINIIO0.digitalIO.
     *
     * @return YDigitalIO  a YDigitalIO object allowing you to drive the digital IO port.
     */
    public static function FindDigitalIO(string $func): YDigitalIO
    {
        // $obj                    is a YDigitalIO;
        $obj = YFunction::_FindFromCache('DigitalIO', $func);
        if ($obj == null) {
            $obj = new YDigitalIO($func);
            YFunction::_AddToCache('DigitalIO', $func, $obj);
        }
        return $obj;
    }

    /**
     * Sets a single bit (i.e. channel) of the I/O port.
     *
     * @param int $bitno : the bit number; lowest bit has index 0
     * @param int $bitstate : the state of the bit (1 or 0)
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_bitState(int $bitno, int $bitstate): int
    {
        if (!($bitstate >= 0)) return $this->_throw( YAPI::INVALID_ARGUMENT, 'invalid bit state',YAPI::INVALID_ARGUMENT);
        if (!($bitstate <= 1)) return $this->_throw( YAPI::INVALID_ARGUMENT, 'invalid bit state',YAPI::INVALID_ARGUMENT);
        return $this->set_command(sprintf('%c%d',82+$bitstate, $bitno));
    }

    /**
     * Returns the state of a single bit (i.e. channel)  of the I/O port.
     *
     * @param int $bitno : the bit number; lowest bit has index 0
     *
     * @return int  the bit state (0 or 1)
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function get_bitState(int $bitno): int
    {
        // $portVal                is a int;
        $portVal = $this->get_portState();
        return (((($portVal) >> ($bitno))) & (1));
    }

    /**
     * Reverts a single bit (i.e. channel) of the I/O port.
     *
     * @param int $bitno : the bit number; lowest bit has index 0
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function toggle_bitState(int $bitno): int
    {
        return $this->set_command(sprintf('T%d', $bitno));
    }

    /**
     * Changes  the direction of a single bit (i.e. channel) from the I/O port.
     *
     * @param int $bitno : the bit number; lowest bit has index 0
     * @param int $bitdirection : direction to set, 0 makes the bit an input, 1 makes it an output.
     *         Remember to call the   saveToFlash() method to make sure the setting is kept after a reboot.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_bitDirection(int $bitno, int $bitdirection): int
    {
        if (!($bitdirection >= 0)) return $this->_throw( YAPI::INVALID_ARGUMENT, 'invalid direction',YAPI::INVALID_ARGUMENT);
        if (!($bitdirection <= 1)) return $this->_throw( YAPI::INVALID_ARGUMENT, 'invalid direction',YAPI::INVALID_ARGUMENT);
        return $this->set_command(sprintf('%c%d',73+6*$bitdirection, $bitno));
    }

    /**
     * Returns the direction of a single bit (i.e. channel) from the I/O port (0 means the bit is an
     * input, 1  an output).
     *
     * @param int $bitno : the bit number; lowest bit has index 0
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function get_bitDirection(int $bitno): int
    {
        // $portDir                is a int;
        $portDir = $this->get_portDirection();
        return (((($portDir) >> ($bitno))) & (1));
    }

    /**
     * Changes the polarity of a single bit from the I/O port.
     *
     * @param int $bitno : the bit number; lowest bit has index 0.
     * @param int $bitpolarity : polarity to set, 0 makes the I/O work in regular mode, 1 makes the I/O 
     * works in reverse mode.
     *         Remember to call the   saveToFlash() method to make sure the setting is kept after a reboot.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_bitPolarity(int $bitno, int $bitpolarity): int
    {
        if (!($bitpolarity >= 0)) return $this->_throw( YAPI::INVALID_ARGUMENT, 'invalid bit polarity',YAPI::INVALID_ARGUMENT);
        if (!($bitpolarity <= 1)) return $this->_throw( YAPI::INVALID_ARGUMENT, 'invalid bit polarity',YAPI::INVALID_ARGUMENT);
        return $this->set_command(sprintf('%c%d',110+4*$bitpolarity, $bitno));
    }

    /**
     * Returns the polarity of a single bit from the I/O port (0 means the I/O works in regular mode, 1
     * means the I/O  works in reverse mode).
     *
     * @param int $bitno : the bit number; lowest bit has index 0
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function get_bitPolarity(int $bitno): int
    {
        // $portPol                is a int;
        $portPol = $this->get_portPolarity();
        return (((($portPol) >> ($bitno))) & (1));
    }

    /**
     * Changes  the electrical interface of a single bit from the I/O port.
     *
     * @param int $bitno : the bit number; lowest bit has index 0
     * @param int $opendrain : 0 makes a bit a regular input/output, 1 makes
     *         it an open-drain (open-collector) input/output. Remember to call the
     *         saveToFlash() method to make sure the setting is kept after a reboot.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_bitOpenDrain(int $bitno, int $opendrain): int
    {
        if (!($opendrain >= 0)) return $this->_throw( YAPI::INVALID_ARGUMENT, 'invalid state',YAPI::INVALID_ARGUMENT);
        if (!($opendrain <= 1)) return $this->_throw( YAPI::INVALID_ARGUMENT, 'invalid state',YAPI::INVALID_ARGUMENT);
        return $this->set_command(sprintf('%c%d',100-32*$opendrain, $bitno));
    }

    /**
     * Returns the type of electrical interface of a single bit from the I/O port. (0 means the bit is an
     * input, 1  an output).
     *
     * @param int $bitno : the bit number; lowest bit has index 0
     *
     * @return int    0 means the a bit is a regular input/output, 1 means the bit is an open-drain
     *         (open-collector) input/output.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function get_bitOpenDrain(int $bitno): int
    {
        // $portOpenDrain          is a int;
        $portOpenDrain = $this->get_portOpenDrain();
        return (((($portOpenDrain) >> ($bitno))) & (1));
    }

    /**
     * Triggers a pulse on a single bit for a specified duration. The specified bit
     * will be turned to 1, and then back to 0 after the given duration.
     *
     * @param int $bitno : the bit number; lowest bit has index 0
     * @param int $ms_duration : desired pulse duration in milliseconds. Be aware that the device time
     *         resolution is not guaranteed up to the millisecond.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function pulse(int $bitno, int $ms_duration): int
    {
        return $this->set_command(sprintf('Z%d,0,%d', $bitno,$ms_duration));
    }

    /**
     * Schedules a pulse on a single bit for a specified duration. The specified bit
     * will be turned to 1, and then back to 0 after the given duration.
     *
     * @param int $bitno : the bit number; lowest bit has index 0
     * @param int $ms_delay : waiting time before the pulse, in milliseconds
     * @param int $ms_duration : desired pulse duration in milliseconds. Be aware that the device time
     *         resolution is not guaranteed up to the millisecond.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function delayedPulse(int $bitno, int $ms_delay, int $ms_duration): int
    {
        return $this->set_command(sprintf('Z%d,%d,%d',$bitno,$ms_delay,$ms_duration));
    }

    /**
     * @throws YAPI_Exception
     */
    public function portState(): int
{
    return $this->get_portState();
}

    /**
     * @throws YAPI_Exception
     */
    public function setPortState(int $newval): int
{
    return $this->set_portState($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function portDirection(): int
{
    return $this->get_portDirection();
}

    /**
     * @throws YAPI_Exception
     */
    public function setPortDirection(int $newval): int
{
    return $this->set_portDirection($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function portOpenDrain(): int
{
    return $this->get_portOpenDrain();
}

    /**
     * @throws YAPI_Exception
     */
    public function setPortOpenDrain(int $newval): int
{
    return $this->set_portOpenDrain($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function portPolarity(): int
{
    return $this->get_portPolarity();
}

    /**
     * @throws YAPI_Exception
     */
    public function setPortPolarity(int $newval): int
{
    return $this->set_portPolarity($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function portDiags(): int
{
    return $this->get_portDiags();
}

    /**
     * @throws YAPI_Exception
     */
    public function portSize(): int
{
    return $this->get_portSize();
}

    /**
     * @throws YAPI_Exception
     */
    public function outputVoltage(): int
{
    return $this->get_outputVoltage();
}

    /**
     * @throws YAPI_Exception
     */
    public function setOutputVoltage(int $newval): int
{
    return $this->set_outputVoltage($newval);
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
     * Continues the enumeration of digital IO ports started using yFirstDigitalIO().
     * Caution: You can't make any assumption about the returned digital IO ports order.
     * If you want to find a specific a digital IO port, use DigitalIO.findDigitalIO()
     * and a hardwareID or a logical name.
     *
     * @return ?YDigitalIO  a pointer to a YDigitalIO object, corresponding to
     *         a digital IO port currently online, or a null pointer
     *         if there are no more digital IO ports to enumerate.
     */
    public function nextDigitalIO(): ?YDigitalIO
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindDigitalIO($next_hwid);
    }

    /**
     * Starts the enumeration of digital IO ports currently accessible.
     * Use the method YDigitalIO::nextDigitalIO() to iterate on
     * next digital IO ports.
     *
     * @return ?YDigitalIO  a pointer to a YDigitalIO object, corresponding to
     *         the first digital IO port currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstDigitalIO(): ?YDigitalIO
    {
        $next_hwid = YAPI::getFirstHardwareId('DigitalIO');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindDigitalIO($next_hwid);
    }

    //--- (end of YDigitalIO implementation)

}
