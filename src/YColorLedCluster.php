<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YColorLedCluster Class: RGB LED cluster control interface, available for instance in the
 * Yocto-Color-V2, the Yocto-MaxiBuzzer or the Yocto-MaxiKnob
 *
 * The YColorLedCluster class allows you to drive a
 * color LED cluster. Unlike the ColorLed class, the YColorLedCluster
 * class allows to handle several LEDs at once. Color changes can be done using RGB
 * coordinates as well as HSL coordinates.
 * The module performs all conversions form RGB to HSL automatically. It is then
 * self-evident to turn on a LED with a given hue and to progressively vary its
 * saturation or lightness. If needed, you can find more information on the
 * difference between RGB and HSL in the section following this one.
 */
class YColorLedCluster extends YFunction
{
    const ACTIVELEDCOUNT_INVALID = YAPI::INVALID_UINT;
    const LEDTYPE_RGB = 0;
    const LEDTYPE_RGBW = 1;
    const LEDTYPE_WS2811 = 2;
    const LEDTYPE_INVALID = -1;
    const MAXLEDCOUNT_INVALID = YAPI::INVALID_UINT;
    const DYNAMICLEDCOUNT_INVALID = YAPI::INVALID_UINT;
    const BLINKSEQMAXCOUNT_INVALID = YAPI::INVALID_UINT;
    const BLINKSEQMAXSIZE_INVALID = YAPI::INVALID_UINT;
    const COMMAND_INVALID = YAPI::INVALID_STRING;
    //--- (end of YColorLedCluster declaration)

    //--- (YColorLedCluster attributes)
    protected int $_activeLedCount = self::ACTIVELEDCOUNT_INVALID; // UInt31
    protected int $_ledType = self::LEDTYPE_INVALID;        // LedType
    protected int $_maxLedCount = self::MAXLEDCOUNT_INVALID;    // UInt31
    protected int $_dynamicLedCount = self::DYNAMICLEDCOUNT_INVALID; // UInt31
    protected int $_blinkSeqMaxCount = self::BLINKSEQMAXCOUNT_INVALID; // UInt31
    protected int $_blinkSeqMaxSize = self::BLINKSEQMAXSIZE_INVALID; // UInt31
    protected string $_command = self::COMMAND_INVALID;        // Text

    //--- (end of YColorLedCluster attributes)

    function __construct(string $str_func)
    {
        //--- (YColorLedCluster constructor)
        parent::__construct($str_func);
        $this->_className = 'ColorLedCluster';

        //--- (end of YColorLedCluster constructor)
    }

    //--- (YColorLedCluster implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'activeLedCount':
            $this->_activeLedCount = intval($val);
            return 1;
        case 'ledType':
            $this->_ledType = intval($val);
            return 1;
        case 'maxLedCount':
            $this->_maxLedCount = intval($val);
            return 1;
        case 'dynamicLedCount':
            $this->_dynamicLedCount = intval($val);
            return 1;
        case 'blinkSeqMaxCount':
            $this->_blinkSeqMaxCount = intval($val);
            return 1;
        case 'blinkSeqMaxSize':
            $this->_blinkSeqMaxSize = intval($val);
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the number of LEDs currently handled by the device.
     *
     * @return int  an integer corresponding to the number of LEDs currently handled by the device
     *
     * On failure, throws an exception or returns YColorLedCluster::ACTIVELEDCOUNT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_activeLedCount(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::ACTIVELEDCOUNT_INVALID;
            }
        }
        $res = $this->_activeLedCount;
        return $res;
    }

    /**
     * Changes the number of LEDs currently handled by the device.
     * Remember to call the matching module
     * saveToFlash() method to save the setting permanently.
     *
     * @param int $newval : an integer corresponding to the number of LEDs currently handled by the device
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_activeLedCount(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("activeLedCount", $rest_val);
    }

    /**
     * Returns the RGB LED type currently handled by the device.
     *
     * @return int  a value among YColorLedCluster::LEDTYPE_RGB, YColorLedCluster::LEDTYPE_RGBW and
     * YColorLedCluster::LEDTYPE_WS2811 corresponding to the RGB LED type currently handled by the device
     *
     * On failure, throws an exception or returns YColorLedCluster::LEDTYPE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_ledType(): int
    {
        // $res                    is a enumLEDTYPE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LEDTYPE_INVALID;
            }
        }
        $res = $this->_ledType;
        return $res;
    }

    /**
     * Changes the RGB LED type currently handled by the device.
     * Remember to call the matching module
     * saveToFlash() method to save the setting permanently.
     *
     * @param int $newval : a value among YColorLedCluster::LEDTYPE_RGB, YColorLedCluster::LEDTYPE_RGBW and
     * YColorLedCluster::LEDTYPE_WS2811 corresponding to the RGB LED type currently handled by the device
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_ledType(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("ledType", $rest_val);
    }

    /**
     * Returns the maximum number of LEDs that the device can handle.
     *
     * @return int  an integer corresponding to the maximum number of LEDs that the device can handle
     *
     * On failure, throws an exception or returns YColorLedCluster::MAXLEDCOUNT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_maxLedCount(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration == 0) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::MAXLEDCOUNT_INVALID;
            }
        }
        $res = $this->_maxLedCount;
        return $res;
    }

    /**
     * Returns the maximum number of LEDs that can perform autonomous transitions and sequences.
     *
     * @return int  an integer corresponding to the maximum number of LEDs that can perform autonomous
     * transitions and sequences
     *
     * On failure, throws an exception or returns YColorLedCluster::DYNAMICLEDCOUNT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_dynamicLedCount(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration == 0) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DYNAMICLEDCOUNT_INVALID;
            }
        }
        $res = $this->_dynamicLedCount;
        return $res;
    }

    /**
     * Returns the maximum number of sequences that the device can handle.
     *
     * @return int  an integer corresponding to the maximum number of sequences that the device can handle
     *
     * On failure, throws an exception or returns YColorLedCluster::BLINKSEQMAXCOUNT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_blinkSeqMaxCount(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration == 0) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::BLINKSEQMAXCOUNT_INVALID;
            }
        }
        $res = $this->_blinkSeqMaxCount;
        return $res;
    }

    /**
     * Returns the maximum length of sequences.
     *
     * @return int  an integer corresponding to the maximum length of sequences
     *
     * On failure, throws an exception or returns YColorLedCluster::BLINKSEQMAXSIZE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_blinkSeqMaxSize(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration == 0) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::BLINKSEQMAXSIZE_INVALID;
            }
        }
        $res = $this->_blinkSeqMaxSize;
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
     * Retrieves a RGB LED cluster for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the RGB LED cluster is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the RGB LED cluster is
     * indeed online at a given time. In case of ambiguity when looking for
     * a RGB LED cluster by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the RGB LED cluster, for instance
     *         YRGBLED2.colorLedCluster.
     *
     * @return YColorLedCluster  a YColorLedCluster object allowing you to drive the RGB LED cluster.
     */
    public static function FindColorLedCluster(string $func): YColorLedCluster
    {
        // $obj                    is a YColorLedCluster;
        $obj = YFunction::_FindFromCache('ColorLedCluster', $func);
        if ($obj == null) {
            $obj = new YColorLedCluster($func);
            YFunction::_AddToCache('ColorLedCluster', $func, $obj);
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
     * Changes the current color of consecutive LEDs in the cluster, using a RGB color. Encoding is done
     * as follows: 0xRRGGBB.
     *
     * @param int $ledIndex :  index of the first affected LED.
     * @param int $count    :  affected LED count.
     * @param int $rgbValue :  new color.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_rgbColor(int $ledIndex, int $count, int $rgbValue): int
    {
        return $this->sendCommand(sprintf('SR%d,%d,%x',$ledIndex,$count,$rgbValue));
    }

    /**
     * Changes the  color at device startup of consecutive LEDs in the cluster, using a RGB color.
     * Encoding is done as follows: 0xRRGGBB. Don't forget to call saveLedsConfigAtPowerOn()
     * to make sure the modification is saved in the device flash memory.
     *
     * @param int $ledIndex :  index of the first affected LED.
     * @param int $count    :  affected LED count.
     * @param int $rgbValue :  new color.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_rgbColorAtPowerOn(int $ledIndex, int $count, int $rgbValue): int
    {
        return $this->sendCommand(sprintf('SC%d,%d,%x',$ledIndex,$count,$rgbValue));
    }

    /**
     * Changes the  color at device startup of consecutive LEDs in the cluster, using a HSL color.
     * Encoding is done as follows: 0xHHSSLL. Don't forget to call saveLedsConfigAtPowerOn()
     * to make sure the modification is saved in the device flash memory.
     *
     * @param int $ledIndex :  index of the first affected LED.
     * @param int $count    :  affected LED count.
     * @param int $hslValue :  new color.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_hslColorAtPowerOn(int $ledIndex, int $count, int $hslValue): int
    {
        // $rgbValue               is a int;
        $rgbValue = $this->hsl2rgb($hslValue);
        return $this->sendCommand(sprintf('SC%d,%d,%x',$ledIndex,$count,$rgbValue));
    }

    /**
     * Changes the current color of consecutive LEDs in the cluster, using a HSL color. Encoding is done
     * as follows: 0xHHSSLL.
     *
     * @param int $ledIndex :  index of the first affected LED.
     * @param int $count    :  affected LED count.
     * @param int $hslValue :  new color.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_hslColor(int $ledIndex, int $count, int $hslValue): int
    {
        return $this->sendCommand(sprintf('SH%d,%d,%x',$ledIndex,$count,$hslValue));
    }

    /**
     * Allows you to modify the current color of a group of adjacent LEDs to another color, in a seamless and
     * autonomous manner. The transition is performed in the RGB space.
     *
     * @param int $ledIndex :  index of the first affected LED.
     * @param int $count    :  affected LED count.
     * @param int $rgbValue :  new color (0xRRGGBB).
     * @param int $delay    :  transition duration in ms
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function rgb_move(int $ledIndex, int $count, int $rgbValue, int $delay): int
    {
        return $this->sendCommand(sprintf('MR%d,%d,%x,%d',$ledIndex,$count,$rgbValue,$delay));
    }

    /**
     * Allows you to modify the current color of a group of adjacent LEDs  to another color, in a seamless and
     * autonomous manner. The transition is performed in the HSL space. In HSL, hue is a circular
     * value (0..360°). There are always two paths to perform the transition: by increasing
     * or by decreasing the hue. The module selects the shortest transition.
     * If the difference is exactly 180°, the module selects the transition which increases
     * the hue.
     *
     * @param int $ledIndex :  index of the first affected LED.
     * @param int $count    :  affected LED count.
     * @param int $hslValue :  new color (0xHHSSLL).
     * @param int $delay    :  transition duration in ms
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function hsl_move(int $ledIndex, int $count, int $hslValue, int $delay): int
    {
        return $this->sendCommand(sprintf('MH%d,%d,%x,%d',$ledIndex,$count,$hslValue,$delay));
    }

    /**
     * Adds an RGB transition to a sequence. A sequence is a transition list, which can
     * be executed in loop by a group of LEDs.  Sequences are persistent and are saved
     * in the device flash memory as soon as the saveBlinkSeq() method is called.
     *
     * @param int $seqIndex :  sequence index.
     * @param int $rgbValue :  target color (0xRRGGBB)
     * @param int $delay    :  transition duration in ms
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function addRgbMoveToBlinkSeq(int $seqIndex, int $rgbValue, int $delay): int
    {
        return $this->sendCommand(sprintf('AR%d,%x,%d',$seqIndex,$rgbValue,$delay));
    }

    /**
     * Adds an HSL transition to a sequence. A sequence is a transition list, which can
     * be executed in loop by an group of LEDs.  Sequences are persistent and are saved
     * in the device flash memory as soon as the saveBlinkSeq() method is called.
     *
     * @param int $seqIndex : sequence index.
     * @param int $hslValue : target color (0xHHSSLL)
     * @param int $delay    : transition duration in ms
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function addHslMoveToBlinkSeq(int $seqIndex, int $hslValue, int $delay): int
    {
        return $this->sendCommand(sprintf('AH%d,%x,%d',$seqIndex,$hslValue,$delay));
    }

    /**
     * Adds a mirror ending to a sequence. When the sequence will reach the end of the last
     * transition, its running speed will automatically be reversed so that the sequence plays
     * in the reverse direction, like in a mirror. After the first transition of the sequence
     * is played at the end of the reverse execution, the sequence starts again in
     * the initial direction.
     *
     * @param int $seqIndex : sequence index.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function addMirrorToBlinkSeq(int $seqIndex): int
    {
        return $this->sendCommand(sprintf('AC%d,0,0',$seqIndex));
    }

    /**
     * Adds to a sequence a jump to another sequence. When a pixel will reach this jump,
     * it will be automatically relinked to the new sequence, and will run it starting
     * from the beginning.
     *
     * @param int $seqIndex : sequence index.
     * @param int $linkSeqIndex : index of the sequence to chain.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function addJumpToBlinkSeq(int $seqIndex, int $linkSeqIndex): int
    {
        return $this->sendCommand(sprintf('AC%d,100,%d,1000',$seqIndex,$linkSeqIndex));
    }

    /**
     * Adds a to a sequence a hard stop code. When a pixel will reach this stop code,
     * instead of restarting the sequence in a loop it will automatically be unlinked
     * from the sequence.
     *
     * @param int $seqIndex : sequence index.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function addUnlinkToBlinkSeq(int $seqIndex): int
    {
        return $this->sendCommand(sprintf('AC%d,100,-1,1000',$seqIndex));
    }

    /**
     * Links adjacent LEDs to a specific sequence. These LEDs start to execute
     * the sequence as soon as  startBlinkSeq is called. It is possible to add an offset
     * in the execution: that way we  can have several groups of LED executing the same
     * sequence, with a  temporal offset. A LED cannot be linked to more than one sequence.
     *
     * @param int $ledIndex :  index of the first affected LED.
     * @param int $count    :  affected LED count.
     * @param int $seqIndex :  sequence index.
     * @param int $offset   :  execution offset in ms.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function linkLedToBlinkSeq(int $ledIndex, int $count, int $seqIndex, int $offset): int
    {
        return $this->sendCommand(sprintf('LS%d,%d,%d,%d',$ledIndex,$count,$seqIndex,$offset));
    }

    /**
     * Links adjacent LEDs to a specific sequence at device power-on. Don't forget to configure
     * the sequence auto start flag as well and call saveLedsConfigAtPowerOn(). It is possible to add an offset
     * in the execution: that way we  can have several groups of LEDs executing the same
     * sequence, with a  temporal offset. A LED cannot be linked to more than one sequence.
     *
     * @param int $ledIndex :  index of the first affected LED.
     * @param int $count    :  affected LED count.
     * @param int $seqIndex :  sequence index.
     * @param int $offset   :  execution offset in ms.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function linkLedToBlinkSeqAtPowerOn(int $ledIndex, int $count, int $seqIndex, int $offset): int
    {
        return $this->sendCommand(sprintf('LO%d,%d,%d,%d',$ledIndex,$count,$seqIndex,$offset));
    }

    /**
     * Links adjacent LEDs to a specific sequence. These LED start to execute
     * the sequence as soon as  startBlinkSeq is called. This function automatically
     * introduces a shift between LEDs so that the specified number of sequence periods
     * appears on the group of LEDs (wave effect).
     *
     * @param int $ledIndex :  index of the first affected LED.
     * @param int $count    :  affected LED count.
     * @param int $seqIndex :  sequence index.
     * @param int $periods  :  number of periods to show on LEDs.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function linkLedToPeriodicBlinkSeq(int $ledIndex, int $count, int $seqIndex, int $periods): int
    {
        return $this->sendCommand(sprintf('LP%d,%d,%d,%d',$ledIndex,$count,$seqIndex,$periods));
    }

    /**
     * Unlinks adjacent LEDs from a  sequence.
     *
     * @param int $ledIndex  :  index of the first affected LED.
     * @param int $count     :  affected LED count.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function unlinkLedFromBlinkSeq(int $ledIndex, int $count): int
    {
        return $this->sendCommand(sprintf('US%d,%d',$ledIndex,$count));
    }

    /**
     * Starts a sequence execution: every LED linked to that sequence starts to
     * run it in a loop. Note that a sequence with a zero duration can't be started.
     *
     * @param int $seqIndex :  index of the sequence to start.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function startBlinkSeq(int $seqIndex): int
    {
        return $this->sendCommand(sprintf('SS%d',$seqIndex));
    }

    /**
     * Stops a sequence execution. If started again, the execution
     * restarts from the beginning.
     *
     * @param int $seqIndex :  index of the sequence to stop.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function stopBlinkSeq(int $seqIndex): int
    {
        return $this->sendCommand(sprintf('XS%d',$seqIndex));
    }

    /**
     * Stops a sequence execution and resets its contents. LEDs linked to this
     * sequence are not automatically updated anymore.
     *
     * @param int $seqIndex :  index of the sequence to reset
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function resetBlinkSeq(int $seqIndex): int
    {
        return $this->sendCommand(sprintf('ZS%d',$seqIndex));
    }

    /**
     * Configures a sequence to make it start automatically at device
     * startup. Note that a sequence with a zero duration can't be started.
     * Don't forget to call saveBlinkSeq() to make sure the
     * modification is saved in the device flash memory.
     *
     * @param int $seqIndex :  index of the sequence to reset.
     * @param int $autostart : 0 to keep the sequence turned off and 1 to start it automatically.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_blinkSeqStateAtPowerOn(int $seqIndex, int $autostart): int
    {
        return $this->sendCommand(sprintf('AS%d,%d',$seqIndex,$autostart));
    }

    /**
     * Changes the execution speed of a sequence. The natural execution speed is 1000 per
     * thousand. If you configure a slower speed, you can play the sequence in slow-motion.
     * If you set a negative speed, you can play the sequence in reverse direction.
     *
     * @param int $seqIndex :  index of the sequence to start.
     * @param int $speed :     sequence running speed (-1000...1000).
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_blinkSeqSpeed(int $seqIndex, int $speed): int
    {
        return $this->sendCommand(sprintf('CS%d,%d',$seqIndex,$speed));
    }

    /**
     * Saves the LEDs power-on configuration. This includes the start-up color or
     * sequence binding for all LEDs. Warning: if some LEDs are linked to a sequence, the
     * method saveBlinkSeq() must also be called to save the sequence definition.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function saveLedsConfigAtPowerOn(): int
    {
        return $this->sendCommand('WL');
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function saveLedsState(): int
    {
        return $this->sendCommand('WL');
    }

    /**
     * Saves the definition of a sequence. Warning: only sequence steps and flags are saved.
     * to save the LEDs startup bindings, the method saveLedsConfigAtPowerOn()
     * must be called.
     *
     * @param int $seqIndex :  index of the sequence to start.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function saveBlinkSeq(int $seqIndex): int
    {
        return $this->sendCommand(sprintf('WS%d',$seqIndex));
    }

    /**
     * Sends a binary buffer to the LED RGB buffer, as is.
     * First three bytes are RGB components for LED specified as parameter, the
     * next three bytes for the next LED, etc.
     *
     * @param int $ledIndex : index of the first LED which should be updated
     * @param string $buff : the binary buffer to send
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_rgbColorBuffer(int $ledIndex, string $buff): int
    {
        return $this->_upload(sprintf('rgb:0:%d', $ledIndex), $buff);
    }

    /**
     * Sends 24bit RGB colors (provided as a list of integers) to the LED RGB buffer, as is.
     * The first number represents the RGB value of the LED specified as parameter, the second
     * number represents the RGB value of the next LED, etc.
     *
     * @param int $ledIndex : index of the first LED which should be updated
     * @param Integer[] $rgbList : a list of 24bit RGB codes, in the form 0xRRGGBB
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_rgbColorArray(int $ledIndex, array $rgbList): int
    {
        // $listlen                is a int;
        // $buff                   is a bin;
        // $idx                    is a int;
        // $rgb                    is a int;
        // $res                    is a int;
        $listlen = sizeof($rgbList);
        $buff = (3*$listlen > 0 ? pack('C',array_fill(0, 3*$listlen, 0)) : '');
        $idx = 0;
        while ($idx < $listlen) {
            $rgb = $rgbList[$idx];
            $buff[3*$idx] = pack('C', (((($rgb) >> (16))) & (255)));
            $buff[3*$idx+1] = pack('C', (((($rgb) >> (8))) & (255)));
            $buff[3*$idx+2] = pack('C', (($rgb) & (255)));
            $idx = $idx + 1;
        }

        $res = $this->_upload(sprintf('rgb:0:%d', $ledIndex), $buff);
        return $res;
    }

    /**
     * Sets up a smooth RGB color transition to the specified pixel-by-pixel list of RGB
     * color codes. The first color code represents the target RGB value of the first LED,
     * the next color code represents the target value of the next LED, etc.
     *
     * @param int $ledIndex : index of the first LED which should be updated
     * @param Integer[] $rgbList : a list of target 24bit RGB codes, in the form 0xRRGGBB
     * @param int $delay   : transition duration in ms
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function rgbArrayOfs_move(int $ledIndex, array $rgbList, int $delay): int
    {
        // $listlen                is a int;
        // $buff                   is a bin;
        // $idx                    is a int;
        // $rgb                    is a int;
        // $res                    is a int;
        $listlen = sizeof($rgbList);
        $buff = (3*$listlen > 0 ? pack('C',array_fill(0, 3*$listlen, 0)) : '');
        $idx = 0;
        while ($idx < $listlen) {
            $rgb = $rgbList[$idx];
            $buff[3*$idx] = pack('C', (((($rgb) >> (16))) & (255)));
            $buff[3*$idx+1] = pack('C', (((($rgb) >> (8))) & (255)));
            $buff[3*$idx+2] = pack('C', (($rgb) & (255)));
            $idx = $idx + 1;
        }

        $res = $this->_upload(sprintf('rgb:%d:%d',$delay,$ledIndex), $buff);
        return $res;
    }

    /**
     * Sets up a smooth RGB color transition to the specified pixel-by-pixel list of RGB
     * color codes. The first color code represents the target RGB value of the first LED,
     * the next color code represents the target value of the next LED, etc.
     *
     * @param Integer[] $rgbList : a list of target 24bit RGB codes, in the form 0xRRGGBB
     * @param int $delay   : transition duration in ms
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function rgbArray_move(array $rgbList, int $delay): int
    {
        // $res                    is a int;

        $res = $this->rgbArrayOfs_move(0,$rgbList,$delay);
        return $res;
    }

    /**
     * Sends a binary buffer to the LED HSL buffer, as is.
     * First three bytes are HSL components for the LED specified as parameter, the
     * next three bytes for the second LED, etc.
     *
     * @param int $ledIndex : index of the first LED which should be updated
     * @param string $buff : the binary buffer to send
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_hslColorBuffer(int $ledIndex, string $buff): int
    {
        return $this->_upload(sprintf('hsl:0:%d', $ledIndex), $buff);
    }

    /**
     * Sends 24bit HSL colors (provided as a list of integers) to the LED HSL buffer, as is.
     * The first number represents the HSL value of the LED specified as parameter, the second number represents
     * the HSL value of the second LED, etc.
     *
     * @param int $ledIndex : index of the first LED which should be updated
     * @param Integer[] $hslList : a list of 24bit HSL codes, in the form 0xHHSSLL
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_hslColorArray(int $ledIndex, array $hslList): int
    {
        // $listlen                is a int;
        // $buff                   is a bin;
        // $idx                    is a int;
        // $hsl                    is a int;
        // $res                    is a int;
        $listlen = sizeof($hslList);
        $buff = (3*$listlen > 0 ? pack('C',array_fill(0, 3*$listlen, 0)) : '');
        $idx = 0;
        while ($idx < $listlen) {
            $hsl = $hslList[$idx];
            $buff[3*$idx] = pack('C', (((($hsl) >> (16))) & (255)));
            $buff[3*$idx+1] = pack('C', (((($hsl) >> (8))) & (255)));
            $buff[3*$idx+2] = pack('C', (($hsl) & (255)));
            $idx = $idx + 1;
        }

        $res = $this->_upload(sprintf('hsl:0:%d', $ledIndex), $buff);
        return $res;
    }

    /**
     * Sets up a smooth HSL color transition to the specified pixel-by-pixel list of HSL
     * color codes. The first color code represents the target HSL value of the first LED,
     * the second color code represents the target value of the second LED, etc.
     *
     * @param Integer[] $hslList : a list of target 24bit HSL codes, in the form 0xHHSSLL
     * @param int $delay   : transition duration in ms
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function hslArray_move(array $hslList, int $delay): int
    {
        // $res                    is a int;

        $res = $this->hslArrayOfs_move(0,$hslList, $delay);
        return $res;
    }

    /**
     * Sets up a smooth HSL color transition to the specified pixel-by-pixel list of HSL
     * color codes. The first color code represents the target HSL value of the first LED,
     * the second color code represents the target value of the second LED, etc.
     *
     * @param int $ledIndex : index of the first LED which should be updated
     * @param Integer[] $hslList : a list of target 24bit HSL codes, in the form 0xHHSSLL
     * @param int $delay   : transition duration in ms
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function hslArrayOfs_move(int $ledIndex, array $hslList, int $delay): int
    {
        // $listlen                is a int;
        // $buff                   is a bin;
        // $idx                    is a int;
        // $hsl                    is a int;
        // $res                    is a int;
        $listlen = sizeof($hslList);
        $buff = (3*$listlen > 0 ? pack('C',array_fill(0, 3*$listlen, 0)) : '');
        $idx = 0;
        while ($idx < $listlen) {
            $hsl = $hslList[$idx];
            $buff[3*$idx] = pack('C', (((($hsl) >> (16))) & (255)));
            $buff[3*$idx+1] = pack('C', (((($hsl) >> (8))) & (255)));
            $buff[3*$idx+2] = pack('C', (($hsl) & (255)));
            $idx = $idx + 1;
        }

        $res = $this->_upload(sprintf('hsl:%d:%d',$delay,$ledIndex), $buff);
        return $res;
    }

    /**
     * Returns a binary buffer with content from the LED RGB buffer, as is.
     * First three bytes are RGB components for the first LED in the interval,
     * the next three bytes for the second LED in the interval, etc.
     *
     * @param int $ledIndex : index of the first LED which should be returned
     * @param int $count    : number of LEDs which should be returned
     *
     * @return string  a binary buffer with RGB components of selected LEDs.
     *
     * On failure, throws an exception or returns an empty binary buffer.
     * @throws YAPI_Exception on error
     */
    public function get_rgbColorBuffer(int $ledIndex, int $count): string
    {
        return $this->_download(sprintf('rgb.bin?typ=0&pos=%d&len=%d',3*$ledIndex,3*$count));
    }

    /**
     * Returns a list on 24bit RGB color values with the current colors displayed on
     * the RGB LEDs. The first number represents the RGB value of the first LED,
     * the second number represents the RGB value of the second LED, etc.
     *
     * @param int $ledIndex : index of the first LED which should be returned
     * @param int $count    : number of LEDs which should be returned
     *
     * @return Integer[]  a list of 24bit color codes with RGB components of selected LEDs, as 0xRRGGBB.
     *
     * On failure, throws an exception or returns an empty array.
     * @throws YAPI_Exception on error
     */
    public function get_rgbColorArray(int $ledIndex, int $count): array
    {
        // $buff                   is a bin;
        $res = [];              // intArr;
        // $idx                    is a int;
        // $r                      is a int;
        // $g                      is a int;
        // $b                      is a int;

        $buff = $this->_download(sprintf('rgb.bin?typ=0&pos=%d&len=%d',3*$ledIndex,3*$count));
        while (sizeof($res) > 0) {
            array_pop($res);
        };
        $idx = 0;
        while ($idx < $count) {
            $r = ord($buff[3*$idx]);
            $g = ord($buff[3*$idx+1]);
            $b = ord($buff[3*$idx+2]);
            $res[] = $r*65536+$g*256+$b;
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * Returns a list on 24bit RGB color values with the RGB LEDs startup colors.
     * The first number represents the startup RGB value of the first LED,
     * the second number represents the RGB value of the second LED, etc.
     *
     * @param int $ledIndex : index of the first LED  which should be returned
     * @param int $count    : number of LEDs which should be returned
     *
     * @return Integer[]  a list of 24bit color codes with RGB components of selected LEDs, as 0xRRGGBB.
     *
     * On failure, throws an exception or returns an empty array.
     * @throws YAPI_Exception on error
     */
    public function get_rgbColorArrayAtPowerOn(int $ledIndex, int $count): array
    {
        // $buff                   is a bin;
        $res = [];              // intArr;
        // $idx                    is a int;
        // $r                      is a int;
        // $g                      is a int;
        // $b                      is a int;

        $buff = $this->_download(sprintf('rgb.bin?typ=4&pos=%d&len=%d',3*$ledIndex,3*$count));
        while (sizeof($res) > 0) {
            array_pop($res);
        };
        $idx = 0;
        while ($idx < $count) {
            $r = ord($buff[3*$idx]);
            $g = ord($buff[3*$idx+1]);
            $b = ord($buff[3*$idx+2]);
            $res[] = $r*65536+$g*256+$b;
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * Returns a list on sequence index for each RGB LED. The first number represents the
     * sequence index for the the first LED, the second number represents the sequence
     * index for the second LED, etc.
     *
     * @param int $ledIndex : index of the first LED which should be returned
     * @param int $count    : number of LEDs which should be returned
     *
     * @return Integer[]  a list of integers with sequence index
     *
     * On failure, throws an exception or returns an empty array.
     * @throws YAPI_Exception on error
     */
    public function get_linkedSeqArray(int $ledIndex, int $count): array
    {
        // $buff                   is a bin;
        $res = [];              // intArr;
        // $idx                    is a int;
        // $seq                    is a int;

        $buff = $this->_download(sprintf('rgb.bin?typ=1&pos=%d&len=%d',$ledIndex,$count));
        while (sizeof($res) > 0) {
            array_pop($res);
        };
        $idx = 0;
        while ($idx < $count) {
            $seq = ord($buff[$idx]);
            $res[] = $seq;
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * Returns a list on 32 bit signatures for specified blinking sequences.
     * Since blinking sequences cannot be read from the device, this can be used
     * to detect if a specific blinking sequence is already programmed.
     *
     * @param int $seqIndex : index of the first blinking sequence which should be returned
     * @param int $count    : number of blinking sequences which should be returned
     *
     * @return Integer[]  a list of 32 bit integer signatures
     *
     * On failure, throws an exception or returns an empty array.
     * @throws YAPI_Exception on error
     */
    public function get_blinkSeqSignatures(int $seqIndex, int $count): array
    {
        // $buff                   is a bin;
        $res = [];              // intArr;
        // $idx                    is a int;
        // $hh                     is a int;
        // $hl                     is a int;
        // $lh                     is a int;
        // $ll                     is a int;

        $buff = $this->_download(sprintf('rgb.bin?typ=2&pos=%d&len=%d',4*$seqIndex,4*$count));
        while (sizeof($res) > 0) {
            array_pop($res);
        };
        $idx = 0;
        while ($idx < $count) {
            $hh = ord($buff[4*$idx]);
            $hl = ord($buff[4*$idx+1]);
            $lh = ord($buff[4*$idx+2]);
            $ll = ord($buff[4*$idx+3]);
            $res[] = (($hh) << (24))+(($hl) << (16))+(($lh) << (8))+$ll;
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * Returns a list of integers with the current speed for specified blinking sequences.
     *
     * @param int $seqIndex : index of the first sequence speed which should be returned
     * @param int $count    : number of sequence speeds which should be returned
     *
     * @return Integer[]  a list of integers, 0 for sequences turned off and 1 for sequences running
     *
     * On failure, throws an exception or returns an empty array.
     * @throws YAPI_Exception on error
     */
    public function get_blinkSeqStateSpeed(int $seqIndex, int $count): array
    {
        // $buff                   is a bin;
        $res = [];              // intArr;
        // $idx                    is a int;
        // $lh                     is a int;
        // $ll                     is a int;

        $buff = $this->_download(sprintf('rgb.bin?typ=6&pos=%d&len=%d',$seqIndex,$count));
        while (sizeof($res) > 0) {
            array_pop($res);
        };
        $idx = 0;
        while ($idx < $count) {
            $lh = ord($buff[2*$idx]);
            $ll = ord($buff[2*$idx+1]);
            $res[] = (($lh) << (8))+$ll;
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * Returns a list of integers with the "auto-start at power on" flag state for specified blinking sequences.
     *
     * @param int $seqIndex : index of the first blinking sequence which should be returned
     * @param int $count    : number of blinking sequences which should be returned
     *
     * @return Integer[]  a list of integers, 0 for sequences turned off and 1 for sequences running
     *
     * On failure, throws an exception or returns an empty array.
     * @throws YAPI_Exception on error
     */
    public function get_blinkSeqStateAtPowerOn(int $seqIndex, int $count): array
    {
        // $buff                   is a bin;
        $res = [];              // intArr;
        // $idx                    is a int;
        // $started                is a int;

        $buff = $this->_download(sprintf('rgb.bin?typ=5&pos=%d&len=%d',$seqIndex,$count));
        while (sizeof($res) > 0) {
            array_pop($res);
        };
        $idx = 0;
        while ($idx < $count) {
            $started = ord($buff[$idx]);
            $res[] = $started;
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * Returns a list of integers with the started state for specified blinking sequences.
     *
     * @param int $seqIndex : index of the first blinking sequence which should be returned
     * @param int $count    : number of blinking sequences which should be returned
     *
     * @return Integer[]  a list of integers, 0 for sequences turned off and 1 for sequences running
     *
     * On failure, throws an exception or returns an empty array.
     * @throws YAPI_Exception on error
     */
    public function get_blinkSeqState(int $seqIndex, int $count): array
    {
        // $buff                   is a bin;
        $res = [];              // intArr;
        // $idx                    is a int;
        // $started                is a int;

        $buff = $this->_download(sprintf('rgb.bin?typ=3&pos=%d&len=%d',$seqIndex,$count));
        while (sizeof($res) > 0) {
            array_pop($res);
        };
        $idx = 0;
        while ($idx < $count) {
            $started = ord($buff[$idx]);
            $res[] = $started;
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function hsl2rgbInt(int $temp1, int $temp2, int $temp3): int
    {
        if ($temp3 >= 170) {
            return intVal((($temp1 + 127)) / (255));
        }
        if ($temp3 > 42) {
            if ($temp3 <= 127) {
                return intVal((($temp2 + 127)) / (255));
            }
            $temp3 = 170 - $temp3;
        }
        return intVal((($temp1*255 + ($temp2-$temp1) * (6 * $temp3) + 32512)) / (65025));
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function hsl2rgb(int $hslValue): int
    {
        // $R                      is a int;
        // $G                      is a int;
        // $B                      is a int;
        // $H                      is a int;
        // $S                      is a int;
        // $L                      is a int;
        // $temp1                  is a int;
        // $temp2                  is a int;
        // $temp3                  is a int;
        // $res                    is a int;
        $L = (($hslValue) & (0xff));
        $S = (((($hslValue) >> (8))) & (0xff));
        $H = (((($hslValue) >> (16))) & (0xff));
        if ($S==0) {
            $res = (($L) << (16))+(($L) << (8))+$L;
            return $res;
        }
        if ($L<=127) {
            $temp2 = $L * (255 + $S);
        } else {
            $temp2 = ($L+$S) * 255 - $L*$S;
        }
        $temp1 = 510 * $L - $temp2;
        // R
        $temp3 = ($H + 85);
        if ($temp3 > 255) {
            $temp3 = $temp3-255;
        }
        $R = $this->hsl2rgbInt($temp1, $temp2, $temp3);
        // G
        $temp3 = $H;
        if ($temp3 > 255) {
            $temp3 = $temp3-255;
        }
        $G = $this->hsl2rgbInt($temp1, $temp2, $temp3);
        // B
        if ($H >= 85) {
            $temp3 = $H - 85 ;
        } else {
            $temp3 = $H + 170;
        }
        $B = $this->hsl2rgbInt($temp1, $temp2, $temp3);
        // just in case
        if ($R>255) {
            $R=255;
        }
        if ($G>255) {
            $G=255;
        }
        if ($B>255) {
            $B=255;
        }
        $res = (($R) << (16))+(($G) << (8))+$B;
        return $res;
    }

    /**
     * @throws YAPI_Exception
     */
    public function activeLedCount(): int
{
    return $this->get_activeLedCount();
}

    /**
     * @throws YAPI_Exception
     */
    public function setActiveLedCount(int $newval): int
{
    return $this->set_activeLedCount($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function ledType(): int
{
    return $this->get_ledType();
}

    /**
     * @throws YAPI_Exception
     */
    public function setLedType(int $newval): int
{
    return $this->set_ledType($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function maxLedCount(): int
{
    return $this->get_maxLedCount();
}

    /**
     * @throws YAPI_Exception
     */
    public function dynamicLedCount(): int
{
    return $this->get_dynamicLedCount();
}

    /**
     * @throws YAPI_Exception
     */
    public function blinkSeqMaxCount(): int
{
    return $this->get_blinkSeqMaxCount();
}

    /**
     * @throws YAPI_Exception
     */
    public function blinkSeqMaxSize(): int
{
    return $this->get_blinkSeqMaxSize();
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
     * Continues the enumeration of RGB LED clusters started using yFirstColorLedCluster().
     * Caution: You can't make any assumption about the returned RGB LED clusters order.
     * If you want to find a specific a RGB LED cluster, use ColorLedCluster.findColorLedCluster()
     * and a hardwareID or a logical name.
     *
     * @return ?YColorLedCluster  a pointer to a YColorLedCluster object, corresponding to
     *         a RGB LED cluster currently online, or a null pointer
     *         if there are no more RGB LED clusters to enumerate.
     */
    public function nextColorLedCluster(): ?YColorLedCluster
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindColorLedCluster($next_hwid);
    }

    /**
     * Starts the enumeration of RGB LED clusters currently accessible.
     * Use the method YColorLedCluster::nextColorLedCluster() to iterate on
     * next RGB LED clusters.
     *
     * @return ?YColorLedCluster  a pointer to a YColorLedCluster object, corresponding to
     *         the first RGB LED cluster currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstColorLedCluster(): ?YColorLedCluster
    {
        $next_hwid = YAPI::getFirstHardwareId('ColorLedCluster');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindColorLedCluster($next_hwid);
    }

    //--- (end of YColorLedCluster implementation)

}
