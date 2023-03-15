<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YBuzzer Class: buzzer control interface, available for instance in the Yocto-Buzzer, the
 * Yocto-MaxiBuzzer or the Yocto-MaxiKnob
 *
 * The YBuzzer class allows you to drive a buzzer. You can
 * choose the frequency and the volume at which the buzzer must sound.
 * You can also pre-program a play sequence.
 */
class YBuzzer extends YFunction
{
    const FREQUENCY_INVALID = YAPI::INVALID_DOUBLE;
    const VOLUME_INVALID = YAPI::INVALID_UINT;
    const PLAYSEQSIZE_INVALID = YAPI::INVALID_UINT;
    const PLAYSEQMAXSIZE_INVALID = YAPI::INVALID_UINT;
    const PLAYSEQSIGNATURE_INVALID = YAPI::INVALID_UINT;
    const COMMAND_INVALID = YAPI::INVALID_STRING;
    //--- (end of YBuzzer declaration)

    //--- (YBuzzer attributes)
    protected float $_frequency = self::FREQUENCY_INVALID;      // MeasureVal
    protected int $_volume = self::VOLUME_INVALID;         // Percent
    protected int $_playSeqSize = self::PLAYSEQSIZE_INVALID;    // UInt31
    protected int $_playSeqMaxSize = self::PLAYSEQMAXSIZE_INVALID; // UInt31
    protected int $_playSeqSignature = self::PLAYSEQSIGNATURE_INVALID; // UInt31
    protected string $_command = self::COMMAND_INVALID;        // Text

    //--- (end of YBuzzer attributes)

    function __construct(string $str_func)
    {
        //--- (YBuzzer constructor)
        parent::__construct($str_func);
        $this->_className = 'Buzzer';

        //--- (end of YBuzzer constructor)
    }

    //--- (YBuzzer implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'frequency':
            $this->_frequency = round($val / 65.536) / 1000.0;
            return 1;
        case 'volume':
            $this->_volume = intval($val);
            return 1;
        case 'playSeqSize':
            $this->_playSeqSize = intval($val);
            return 1;
        case 'playSeqMaxSize':
            $this->_playSeqMaxSize = intval($val);
            return 1;
        case 'playSeqSignature':
            $this->_playSeqSignature = intval($val);
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Changes the frequency of the signal sent to the buzzer. A zero value stops the buzzer.
     *
     * @param float $newval : a floating point number corresponding to the frequency of the signal sent to the buzzer
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_frequency(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("frequency", $rest_val);
    }

    /**
     * Returns the  frequency of the signal sent to the buzzer/speaker.
     *
     * @return float  a floating point number corresponding to the  frequency of the signal sent to the buzzer/speaker
     *
     * On failure, throws an exception or returns YBuzzer::FREQUENCY_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_frequency(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::FREQUENCY_INVALID;
            }
        }
        $res = $this->_frequency;
        return $res;
    }

    /**
     * Returns the volume of the signal sent to the buzzer/speaker.
     *
     * @return int  an integer corresponding to the volume of the signal sent to the buzzer/speaker
     *
     * On failure, throws an exception or returns YBuzzer::VOLUME_INVALID.
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
     * Changes the volume of the signal sent to the buzzer/speaker. Remember to call the
     * saveToFlash() method of the module if the modification must be kept.
     *
     * @param int $newval : an integer corresponding to the volume of the signal sent to the buzzer/speaker
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
     * Returns the current length of the playing sequence.
     *
     * @return int  an integer corresponding to the current length of the playing sequence
     *
     * On failure, throws an exception or returns YBuzzer::PLAYSEQSIZE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_playSeqSize(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PLAYSEQSIZE_INVALID;
            }
        }
        $res = $this->_playSeqSize;
        return $res;
    }

    /**
     * Returns the maximum length of the playing sequence.
     *
     * @return int  an integer corresponding to the maximum length of the playing sequence
     *
     * On failure, throws an exception or returns YBuzzer::PLAYSEQMAXSIZE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_playSeqMaxSize(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration == 0) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PLAYSEQMAXSIZE_INVALID;
            }
        }
        $res = $this->_playSeqMaxSize;
        return $res;
    }

    /**
     * Returns the playing sequence signature. As playing
     * sequences cannot be read from the device, this can be used
     * to detect if a specific playing sequence is already
     * programmed.
     *
     * @return int  an integer corresponding to the playing sequence signature
     *
     * On failure, throws an exception or returns YBuzzer::PLAYSEQSIGNATURE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_playSeqSignature(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PLAYSEQSIGNATURE_INVALID;
            }
        }
        $res = $this->_playSeqSignature;
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
     * Retrieves a buzzer for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the buzzer is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the buzzer is
     * indeed online at a given time. In case of ambiguity when looking for
     * a buzzer by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the buzzer, for instance
     *         YBUZZER2.buzzer.
     *
     * @return YBuzzer  a YBuzzer object allowing you to drive the buzzer.
     */
    public static function FindBuzzer(string $func): YBuzzer
    {
        // $obj                    is a YBuzzer;
        $obj = YFunction::_FindFromCache('Buzzer', $func);
        if ($obj == null) {
            $obj = new YBuzzer($func);
            YFunction::_AddToCache('Buzzer', $func, $obj);
        }
        return $obj;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function sendCommand(string $command): int
    {
        return $this->set_command($command);
    }

    /**
     * Adds a new frequency transition to the playing sequence.
     *
     * @param int $freq    : desired frequency when the transition is completed, in Hz
     * @param int $msDelay : duration of the frequency transition, in milliseconds.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function addFreqMoveToPlaySeq(int $freq, int $msDelay): int
    {
        return $this->sendCommand(sprintf('A%d,%d',$freq,$msDelay));
    }

    /**
     * Adds a pulse to the playing sequence.
     *
     * @param int $freq : pulse frequency, in Hz
     * @param int $msDuration : pulse duration, in milliseconds.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function addPulseToPlaySeq(int $freq, int $msDuration): int
    {
        return $this->sendCommand(sprintf('B%d,%d',$freq,$msDuration));
    }

    /**
     * Adds a new volume transition to the playing sequence. Frequency stays untouched:
     * if frequency is at zero, the transition has no effect.
     *
     * @param int $volume    : desired volume when the transition is completed, as a percentage.
     * @param int $msDuration : duration of the volume transition, in milliseconds.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function addVolMoveToPlaySeq(int $volume, int $msDuration): int
    {
        return $this->sendCommand(sprintf('C%d,%d',$volume,$msDuration));
    }

    /**
     * Adds notes to the playing sequence. Notes are provided as text words, separated by
     * spaces. The pitch is specified using the usual letter from A to G. The duration is
     * specified as the divisor of a whole note: 4 for a fourth, 8 for an eight note, etc.
     * Some modifiers are supported: # and b to alter a note pitch,
     * ' and , to move to the upper/lower octave, . to enlarge
     * the note duration.
     *
     * @param string $notes : notes to be played, as a text string.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function addNotesToPlaySeq(string $notes): int
    {
        // $tempo                  is a int;
        // $prevPitch              is a int;
        // $prevDuration           is a int;
        // $prevFreq               is a int;
        // $note                   is a int;
        // $num                    is a int;
        // $typ                    is a int;
        // $ascNotes               is a bin;
        // $notesLen               is a int;
        // $i                      is a int;
        // $ch                     is a int;
        // $dNote                  is a int;
        // $pitch                  is a int;
        // $freq                   is a int;
        // $ms                     is a int;
        // $ms16                   is a int;
        // $rest                   is a int;
        $tempo = 100;
        $prevPitch = 3;
        $prevDuration = 4;
        $prevFreq = 110;
        $note = -99;
        $num = 0;
        $typ = 3;
        $ascNotes = $notes;
        $notesLen = strlen($ascNotes);
        $i = 0;
        while ($i < $notesLen) {
            $ch = ord($ascNotes[$i]);
            // A (note))
            if ($ch == 65) {
                $note = 0;
            }
            // B (note)
            if ($ch == 66) {
                $note = 2;
            }
            // C (note)
            if ($ch == 67) {
                $note = 3;
            }
            // D (note)
            if ($ch == 68) {
                $note = 5;
            }
            // E (note)
            if ($ch == 69) {
                $note = 7;
            }
            // F (note)
            if ($ch == 70) {
                $note = 8;
            }
            // G (note)
            if ($ch == 71) {
                $note = 10;
            }
            // '#' (sharp modifier)
            if ($ch == 35) {
                $note = $note + 1;
            }
            // 'b' (flat modifier)
            if ($ch == 98) {
                $note = $note - 1;
            }
            // ' (octave up)
            if ($ch == 39) {
                $prevPitch = $prevPitch + 12;
            }
            // , (octave down)
            if ($ch == 44) {
                $prevPitch = $prevPitch - 12;
            }
            // R (rest)
            if ($ch == 82) {
                $typ = 0;
            }
            // ! (staccato modifier)
            if ($ch == 33) {
                $typ = 1;
            }
            // ^ (short modifier)
            if ($ch == 94) {
                $typ = 2;
            }
            // _ (legato modifier)
            if ($ch == 95) {
                $typ = 4;
            }
            // - (glissando modifier)
            if ($ch == 45) {
                $typ = 5;
            }
            // % (tempo change)
            if (($ch == 37) && ($num > 0)) {
                $tempo = $num;
                $num = 0;
            }
            if (($ch >= 48) && ($ch <= 57)) {
                // 0-9 (number)
                $num = ($num * 10) + ($ch - 48);
            }
            if ($ch == 46) {
                // . (duration modifier)
                $num = intVal(($num * 2) / (3));
            }
            if ((($ch == 32) || ($i+1 == $notesLen)) && (($note > -99) || ($typ != 3))) {
                if ($num == 0) {
                    $num = $prevDuration;
                } else {
                    $prevDuration = $num;
                }
                $ms = round(320000.0 / ($tempo * $num));
                if ($typ == 0) {
                    $this->addPulseToPlaySeq(0, $ms);
                } else {
                    $dNote = $note - ((($prevPitch) % (12)));
                    if ($dNote > 6) {
                        $dNote = $dNote - 12;
                    }
                    if ($dNote <= -6) {
                        $dNote = $dNote + 12;
                    }
                    $pitch = $prevPitch + $dNote;
                    $freq = round(440 * exp($pitch * 0.05776226504666));
                    $ms16 = (($ms) >> (4));
                    $rest = 0;
                    if ($typ == 3) {
                        $rest = 2 * $ms16;
                    }
                    if ($typ == 2) {
                        $rest = 8 * $ms16;
                    }
                    if ($typ == 1) {
                        $rest = 12 * $ms16;
                    }
                    if ($typ == 5) {
                        $this->addPulseToPlaySeq($prevFreq, $ms16);
                        $this->addFreqMoveToPlaySeq($freq, 8 * $ms16);
                        $this->addPulseToPlaySeq($freq, $ms - 9 * $ms16);
                    } else {
                        $this->addPulseToPlaySeq($freq, $ms - $rest);
                        if ($rest > 0) {
                            $this->addPulseToPlaySeq(0, $rest);
                        }
                    }
                    $prevFreq = $freq;
                    $prevPitch = $pitch;
                }
                $note = -99;
                $num = 0;
                $typ = 3;
            }
            $i = $i + 1;
        }
        return YAPI::SUCCESS;
    }

    /**
     * Starts the preprogrammed playing sequence. The sequence
     * runs in loop until it is stopped by stopPlaySeq or an explicit
     * change. To play the sequence only once, use oncePlaySeq().
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function startPlaySeq(): int
    {
        return $this->sendCommand('S');
    }

    /**
     * Stops the preprogrammed playing sequence and sets the frequency to zero.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function stopPlaySeq(): int
    {
        return $this->sendCommand('X');
    }

    /**
     * Resets the preprogrammed playing sequence and sets the frequency to zero.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function resetPlaySeq(): int
    {
        return $this->sendCommand('Z');
    }

    /**
     * Starts the preprogrammed playing sequence and run it once only.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function oncePlaySeq(): int
    {
        return $this->sendCommand('s');
    }

    /**
     * Saves the preprogrammed playing sequence to flash memory.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function savePlaySeq(): int
    {
        return $this->sendCommand('W');
    }

    /**
     * Reloads the preprogrammed playing sequence from the flash memory.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function reloadPlaySeq(): int
    {
        return $this->sendCommand('R');
    }

    /**
     * Activates the buzzer for a short duration.
     *
     * @param int $frequency : pulse frequency, in hertz
     * @param int $duration : pulse duration in milliseconds
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function pulse(int $frequency, int $duration): int
    {
        return $this->set_command(sprintf('P%d,%d',$frequency,$duration));
    }

    /**
     * Makes the buzzer frequency change over a period of time.
     *
     * @param int $frequency : frequency to reach, in hertz. A frequency under 25Hz stops the buzzer.
     * @param int $duration :  pulse duration in milliseconds
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function freqMove(int $frequency, int $duration): int
    {
        return $this->set_command(sprintf('F%d,%d',$frequency,$duration));
    }

    /**
     * Makes the buzzer volume change over a period of time, frequency  stays untouched.
     *
     * @param int $volume : volume to reach in %
     * @param int $duration : change duration in milliseconds
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function volumeMove(int $volume, int $duration): int
    {
        return $this->set_command(sprintf('V%d,%d',$volume,$duration));
    }

    /**
     * Immediately play a note sequence. Notes are provided as text words, separated by
     * spaces. The pitch is specified using the usual letter from A to G. The duration is
     * specified as the divisor of a whole note: 4 for a fourth, 8 for an eight note, etc.
     * Some modifiers are supported: # and b to alter a note pitch,
     * ' and , to move to the upper/lower octave, . to enlarge
     * the note duration.
     *
     * @param string $notes : notes to be played, as a text string.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function playNotes(string $notes): int
    {
        $this->resetPlaySeq();
        $this->addNotesToPlaySeq($notes);
        return $this->oncePlaySeq();
    }

    /**
     * @throws YAPI_Exception
     */
    public function setFrequency(float $newval): int
{
    return $this->set_frequency($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function frequency(): float
{
    return $this->get_frequency();
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
    public function playSeqSize(): int
{
    return $this->get_playSeqSize();
}

    /**
     * @throws YAPI_Exception
     */
    public function playSeqMaxSize(): int
{
    return $this->get_playSeqMaxSize();
}

    /**
     * @throws YAPI_Exception
     */
    public function playSeqSignature(): int
{
    return $this->get_playSeqSignature();
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
     * Continues the enumeration of buzzers started using yFirstBuzzer().
     * Caution: You can't make any assumption about the returned buzzers order.
     * If you want to find a specific a buzzer, use Buzzer.findBuzzer()
     * and a hardwareID or a logical name.
     *
     * @return ?YBuzzer  a pointer to a YBuzzer object, corresponding to
     *         a buzzer currently online, or a null pointer
     *         if there are no more buzzers to enumerate.
     */
    public function nextBuzzer(): ?YBuzzer
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindBuzzer($next_hwid);
    }

    /**
     * Starts the enumeration of buzzers currently accessible.
     * Use the method YBuzzer::nextBuzzer() to iterate on
     * next buzzers.
     *
     * @return ?YBuzzer  a pointer to a YBuzzer object, corresponding to
     *         the first buzzer currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstBuzzer(): ?YBuzzer
    {
        $next_hwid = YAPI::getFirstHardwareId('Buzzer');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindBuzzer($next_hwid);
    }

    //--- (end of YBuzzer implementation)

}
