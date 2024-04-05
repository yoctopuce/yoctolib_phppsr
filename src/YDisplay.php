<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YDisplay Class: display control interface, available for instance in the Yocto-Display, the
 * Yocto-MaxiDisplay, the Yocto-MaxiDisplay-G or the Yocto-MiniDisplay
 *
 * The YDisplay class allows to drive Yoctopuce displays.
 * Yoctopuce display interface has been designed to easily
 * show information and images. The device provides built-in
 * multi-layer rendering. Layers can be drawn offline, individually,
 * and freely moved on the display. It can also replay recorded
 * sequences (animations).
 *
 * In order to draw on the screen, you should use the
 * display.get_displayLayer method to retrieve the layer(s) on
 * which you want to draw, and then use methods defined in
 * YDisplayLayer to draw on the layers.
 */
class YDisplay extends YFunction
{
    const ENABLED_FALSE = 0;
    const ENABLED_TRUE = 1;
    const ENABLED_INVALID = -1;
    const STARTUPSEQ_INVALID = YAPI::INVALID_STRING;
    const BRIGHTNESS_INVALID = YAPI::INVALID_UINT;
    const ORIENTATION_LEFT = 0;
    const ORIENTATION_UP = 1;
    const ORIENTATION_RIGHT = 2;
    const ORIENTATION_DOWN = 3;
    const ORIENTATION_INVALID = -1;
    const DISPLAYWIDTH_INVALID = YAPI::INVALID_UINT;
    const DISPLAYHEIGHT_INVALID = YAPI::INVALID_UINT;
    const DISPLAYTYPE_MONO = 0;
    const DISPLAYTYPE_GRAY = 1;
    const DISPLAYTYPE_RGB = 2;
    const DISPLAYTYPE_INVALID = -1;
    const LAYERWIDTH_INVALID = YAPI::INVALID_UINT;
    const LAYERHEIGHT_INVALID = YAPI::INVALID_UINT;
    const LAYERCOUNT_INVALID = YAPI::INVALID_UINT;
    const COMMAND_INVALID = YAPI::INVALID_STRING;
    //--- (end of generated code: YDisplay declaration)

    //--- (generated code: YDisplay attributes)
    protected int $_enabled = self::ENABLED_INVALID;        // Bool
    protected string $_startupSeq = self::STARTUPSEQ_INVALID;     // Text
    protected int $_brightness = self::BRIGHTNESS_INVALID;     // Percent
    protected int $_orientation = self::ORIENTATION_INVALID;    // Orientation
    protected int $_displayWidth = self::DISPLAYWIDTH_INVALID;   // UInt31
    protected int $_displayHeight = self::DISPLAYHEIGHT_INVALID;  // UInt31
    protected int $_displayType = self::DISPLAYTYPE_INVALID;    // DisplayType
    protected int $_layerWidth = self::LAYERWIDTH_INVALID;     // UInt31
    protected int $_layerHeight = self::LAYERHEIGHT_INVALID;    // UInt31
    protected int $_layerCount = self::LAYERCOUNT_INVALID;     // UInt31
    protected string $_command = self::COMMAND_INVALID;        // Text
    protected array $_allDisplayLayers = [];                           // YDisplayLayerArr

    //--- (end of generated code: YDisplay attributes)
    protected bool $_recording;
    protected string $_sequence;

    function __construct(string $str_func)
    {
        //--- (generated code: YDisplay constructor)
        parent::__construct($str_func);
        $this->_className = 'Display';

        //--- (end of generated code: YDisplay constructor)
        $this->_recording = false;
        $this->_sequence = '';
    }

    //--- (generated code: YDisplay implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'enabled':
            $this->_enabled = intval($val);
            return 1;
        case 'startupSeq':
            $this->_startupSeq = $val;
            return 1;
        case 'brightness':
            $this->_brightness = intval($val);
            return 1;
        case 'orientation':
            $this->_orientation = intval($val);
            return 1;
        case 'displayWidth':
            $this->_displayWidth = intval($val);
            return 1;
        case 'displayHeight':
            $this->_displayHeight = intval($val);
            return 1;
        case 'displayType':
            $this->_displayType = intval($val);
            return 1;
        case 'layerWidth':
            $this->_layerWidth = intval($val);
            return 1;
        case 'layerHeight':
            $this->_layerHeight = intval($val);
            return 1;
        case 'layerCount':
            $this->_layerCount = intval($val);
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns true if the screen is powered, false otherwise.
     *
     * @return int  either YDisplay::ENABLED_FALSE or YDisplay::ENABLED_TRUE, according to true if the
     * screen is powered, false otherwise
     *
     * On failure, throws an exception or returns YDisplay::ENABLED_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_enabled(): int
    {
        // $res                    is a enumBOOL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::ENABLED_INVALID;
            }
        }
        $res = $this->_enabled;
        return $res;
    }

    /**
     * Changes the power state of the display.
     *
     * @param int $newval : either YDisplay::ENABLED_FALSE or YDisplay::ENABLED_TRUE, according to the power
     * state of the display
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_enabled(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("enabled", $rest_val);
    }

    /**
     * Returns the name of the sequence to play when the displayed is powered on.
     *
     * @return string  a string corresponding to the name of the sequence to play when the displayed is powered on
     *
     * On failure, throws an exception or returns YDisplay::STARTUPSEQ_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_startupSeq(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::STARTUPSEQ_INVALID;
            }
        }
        $res = $this->_startupSeq;
        return $res;
    }

    /**
     * Changes the name of the sequence to play when the displayed is powered on.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param string $newval : a string corresponding to the name of the sequence to play when the
     * displayed is powered on
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_startupSeq(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("startupSeq", $rest_val);
    }

    /**
     * Returns the luminosity of the  module informative LEDs (from 0 to 100).
     *
     * @return int  an integer corresponding to the luminosity of the  module informative LEDs (from 0 to 100)
     *
     * On failure, throws an exception or returns YDisplay::BRIGHTNESS_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_brightness(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::BRIGHTNESS_INVALID;
            }
        }
        $res = $this->_brightness;
        return $res;
    }

    /**
     * Changes the brightness of the display. The parameter is a value between 0 and
     * 100. Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param int $newval : an integer corresponding to the brightness of the display
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_brightness(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("brightness", $rest_val);
    }

    /**
     * Returns the currently selected display orientation.
     *
     * @return int  a value among YDisplay::ORIENTATION_LEFT, YDisplay::ORIENTATION_UP,
     * YDisplay::ORIENTATION_RIGHT and YDisplay::ORIENTATION_DOWN corresponding to the currently selected
     * display orientation
     *
     * On failure, throws an exception or returns YDisplay::ORIENTATION_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_orientation(): int
    {
        // $res                    is a enumORIENTATION;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::ORIENTATION_INVALID;
            }
        }
        $res = $this->_orientation;
        return $res;
    }

    /**
     * Changes the display orientation. Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param int $newval : a value among YDisplay::ORIENTATION_LEFT, YDisplay::ORIENTATION_UP,
     * YDisplay::ORIENTATION_RIGHT and YDisplay::ORIENTATION_DOWN corresponding to the display orientation
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_orientation(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("orientation", $rest_val);
    }

    /**
     * Returns the display width, in pixels.
     *
     * @return int  an integer corresponding to the display width, in pixels
     *
     * On failure, throws an exception or returns YDisplay::DISPLAYWIDTH_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_displayWidth(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration == 0) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DISPLAYWIDTH_INVALID;
            }
        }
        $res = $this->_displayWidth;
        return $res;
    }

    /**
     * Returns the display height, in pixels.
     *
     * @return int  an integer corresponding to the display height, in pixels
     *
     * On failure, throws an exception or returns YDisplay::DISPLAYHEIGHT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_displayHeight(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration == 0) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DISPLAYHEIGHT_INVALID;
            }
        }
        $res = $this->_displayHeight;
        return $res;
    }

    /**
     * Returns the display type: monochrome, gray levels or full color.
     *
     * @return int  a value among YDisplay::DISPLAYTYPE_MONO, YDisplay::DISPLAYTYPE_GRAY and
     * YDisplay::DISPLAYTYPE_RGB corresponding to the display type: monochrome, gray levels or full color
     *
     * On failure, throws an exception or returns YDisplay::DISPLAYTYPE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_displayType(): int
    {
        // $res                    is a enumDISPLAYTYPE;
        if ($this->_cacheExpiration == 0) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DISPLAYTYPE_INVALID;
            }
        }
        $res = $this->_displayType;
        return $res;
    }

    /**
     * Returns the width of the layers to draw on, in pixels.
     *
     * @return int  an integer corresponding to the width of the layers to draw on, in pixels
     *
     * On failure, throws an exception or returns YDisplay::LAYERWIDTH_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_layerWidth(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration == 0) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LAYERWIDTH_INVALID;
            }
        }
        $res = $this->_layerWidth;
        return $res;
    }

    /**
     * Returns the height of the layers to draw on, in pixels.
     *
     * @return int  an integer corresponding to the height of the layers to draw on, in pixels
     *
     * On failure, throws an exception or returns YDisplay::LAYERHEIGHT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_layerHeight(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration == 0) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LAYERHEIGHT_INVALID;
            }
        }
        $res = $this->_layerHeight;
        return $res;
    }

    /**
     * Returns the number of available layers to draw on.
     *
     * @return int  an integer corresponding to the number of available layers to draw on
     *
     * On failure, throws an exception or returns YDisplay::LAYERCOUNT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_layerCount(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration == 0) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LAYERCOUNT_INVALID;
            }
        }
        $res = $this->_layerCount;
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
     * Retrieves a display for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the display is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the display is
     * indeed online at a given time. In case of ambiguity when looking for
     * a display by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the display, for instance
     *         YD128X32.display.
     *
     * @return YDisplay  a YDisplay object allowing you to drive the display.
     */
    public static function FindDisplay(string $func): YDisplay
    {
        // $obj                    is a YDisplay;
        $obj = YFunction::_FindFromCache('Display', $func);
        if ($obj == null) {
            $obj = new YDisplay($func);
            YFunction::_AddToCache('Display', $func, $obj);
        }
        return $obj;
    }

    /**
     * Clears the display screen and resets all display layers to their default state.
     * Using this function in a sequence will kill the sequence play-back. Don't use that
     * function to reset the display at sequence start-up.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function resetAll(): int
    {
        $this->flushLayers();
        $this->resetHiddenLayerFlags();
        return $this->sendCommand('Z');
    }

    /**
     * Smoothly changes the brightness of the screen to produce a fade-in or fade-out
     * effect.
     *
     * @param int $brightness : the new screen brightness
     * @param int $duration : duration of the brightness transition, in milliseconds.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function fade(int $brightness, int $duration): int
    {
        $this->flushLayers();
        return $this->sendCommand(sprintf('+%d,%d',$brightness,$duration));
    }

    /**
     * Starts to record all display commands into a sequence, for later replay.
     * The name used to store the sequence is specified when calling
     * saveSequence(), once the recording is complete.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function newSequence(): int
    {
        $this->flushLayers();
        $this->_sequence = '';
        $this->_recording = true;
        return YAPI::SUCCESS;
    }

    /**
     * Stops recording display commands and saves the sequence into the specified
     * file on the display internal memory. The sequence can be later replayed
     * using playSequence().
     *
     * @param string $sequenceName : the name of the newly created sequence
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function saveSequence(string $sequenceName): int
    {
        $this->flushLayers();
        $this->_recording = false;
        $this->_upload($sequenceName, $this->_sequence);
        //We need to use YPRINTF("") for Objective-C
        $this->_sequence = sprintf('');
        return YAPI::SUCCESS;
    }

    /**
     * Replays a display sequence previously recorded using
     * newSequence() and saveSequence().
     *
     * @param string $sequenceName : the name of the newly created sequence
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function playSequence(string $sequenceName): int
    {
        $this->flushLayers();
        return $this->sendCommand(sprintf('S%s',$sequenceName));
    }

    /**
     * Waits for a specified delay (in milliseconds) before playing next
     * commands in current sequence. This method can be used while
     * recording a display sequence, to insert a timed wait in the sequence
     * (without any immediate effect). It can also be used dynamically while
     * playing a pre-recorded sequence, to suspend or resume the execution of
     * the sequence. To cancel a delay, call the same method with a zero delay.
     *
     * @param int $delay_ms : the duration to wait, in milliseconds
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function pauseSequence(int $delay_ms): int
    {
        $this->flushLayers();
        return $this->sendCommand(sprintf('W%d',$delay_ms));
    }

    /**
     * Stops immediately any ongoing sequence replay.
     * The display is left as is.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function stopSequence(): int
    {
        $this->flushLayers();
        return $this->sendCommand('S');
    }

    /**
     * Uploads an arbitrary file (for instance a GIF file) to the display, to the
     * specified full path name. If a file already exists with the same path name,
     * its content is overwritten.
     *
     * @param string $pathname : path and name of the new file to create
     * @param string $content : binary buffer with the content to set
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function upload(string $pathname, string $content): int
    {
        return $this->_upload($pathname, $content);
    }

    /**
     * Copies the whole content of a layer to another layer. The color and transparency
     * of all the pixels from the destination layer are set to match the source pixels.
     * This method only affects the displayed content, but does not change any
     * property of the layer object.
     * Note that layer 0 has no transparency support (it is always completely opaque).
     *
     * @param int $srcLayerId : the identifier of the source layer (a number in range 0..layerCount-1)
     * @param int $dstLayerId : the identifier of the destination layer (a number in range 0..layerCount-1)
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function copyLayerContent(int $srcLayerId, int $dstLayerId): int
    {
        $this->flushLayers();
        return $this->sendCommand(sprintf('o%d,%d',$srcLayerId,$dstLayerId));
    }

    /**
     * Swaps the whole content of two layers. The color and transparency of all the pixels from
     * the two layers are swapped. This method only affects the displayed content, but does
     * not change any property of the layer objects. In particular, the visibility of each
     * layer stays unchanged. When used between one hidden layer and a visible layer,
     * this method makes it possible to easily implement double-buffering.
     * Note that layer 0 has no transparency support (it is always completely opaque).
     *
     * @param int $layerIdA : the first layer (a number in range 0..layerCount-1)
     * @param int $layerIdB : the second layer (a number in range 0..layerCount-1)
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function swapLayerContent(int $layerIdA, int $layerIdB): int
    {
        $this->flushLayers();
        return $this->sendCommand(sprintf('E%d,%d',$layerIdA,$layerIdB));
    }

    /**
     * Returns a YDisplayLayer object that can be used to draw on the specified
     * layer. The content is displayed only when the layer is active on the
     * screen (and not masked by other overlapping layers).
     *
     * @param int $layerId : the identifier of the layer (a number in range 0..layerCount-1)
     *
     * @return ?YDisplayLayer  an YDisplayLayer object
     *
     * On failure, throws an exception or returns null.
     * @throws YAPI_Exception on error
     */
    public function get_displayLayer(int $layerId): ?YDisplayLayer
    {
        // $layercount             is a int;
        // $idx                    is a int;
        $layercount = $this->get_layerCount();
        if (!(($layerId >= 0) && ($layerId < $layercount))) return $this->_throw( YAPI::INVALID_ARGUMENT, 'invalid DisplayLayer index',null);
        if (sizeof($this->_allDisplayLayers) == 0) {
            $idx = 0;
            while ($idx < $layercount) {
                $this->_allDisplayLayers[] = new YDisplayLayer($this, $idx);
                $idx = $idx + 1;
            }
        }
        return $this->_allDisplayLayers[$layerId];
    }

    /**
     * @throws YAPI_Exception
     */
    public function enabled(): int
{
    return $this->get_enabled();
}

    /**
     * @throws YAPI_Exception
     */
    public function setEnabled(int $newval): int
{
    return $this->set_enabled($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function startupSeq(): string
{
    return $this->get_startupSeq();
}

    /**
     * @throws YAPI_Exception
     */
    public function setStartupSeq(string $newval): int
{
    return $this->set_startupSeq($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function brightness(): int
{
    return $this->get_brightness();
}

    /**
     * @throws YAPI_Exception
     */
    public function setBrightness(int $newval): int
{
    return $this->set_brightness($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function orientation(): int
{
    return $this->get_orientation();
}

    /**
     * @throws YAPI_Exception
     */
    public function setOrientation(int $newval): int
{
    return $this->set_orientation($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function displayWidth(): int
{
    return $this->get_displayWidth();
}

    /**
     * @throws YAPI_Exception
     */
    public function displayHeight(): int
{
    return $this->get_displayHeight();
}

    /**
     * @throws YAPI_Exception
     */
    public function displayType(): int
{
    return $this->get_displayType();
}

    /**
     * @throws YAPI_Exception
     */
    public function layerWidth(): int
{
    return $this->get_layerWidth();
}

    /**
     * @throws YAPI_Exception
     */
    public function layerHeight(): int
{
    return $this->get_layerHeight();
}

    /**
     * @throws YAPI_Exception
     */
    public function layerCount(): int
{
    return $this->get_layerCount();
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
     * Continues the enumeration of displays started using yFirstDisplay().
     * Caution: You can't make any assumption about the returned displays order.
     * If you want to find a specific a display, use Display.findDisplay()
     * and a hardwareID or a logical name.
     *
     * @return ?YDisplay  a pointer to a YDisplay object, corresponding to
     *         a display currently online, or a null pointer
     *         if there are no more displays to enumerate.
     */
    public function nextDisplay(): ?YDisplay
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindDisplay($next_hwid);
    }

    /**
     * Starts the enumeration of displays currently accessible.
     * Use the method YDisplay::nextDisplay() to iterate on
     * next displays.
     *
     * @return ?YDisplay  a pointer to a YDisplay object, corresponding to
     *         the first display currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstDisplay(): ?YDisplay
    {
        $next_hwid = YAPI::getFirstHardwareId('Display');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindDisplay($next_hwid);
    }

    //--- (end of generated code: YDisplay implementation)

    public function flushLayers():int
    {
        foreach ($this->_allDisplayLayers as $layer) {
            $layer->flush_now();
        }
        return YAPI::SUCCESS;
    }

    public function resetHiddenLayerFlags():void
    {
        foreach ($this->_allDisplayLayers as $layer) {
            $layer->resetHiddenFlag();
        }
    }

    public function sendCommand(string $str_cmd): int
    {
        if (!$this->_recording) {
            return $this->set_command($str_cmd);
        }
        $this->_sequence .= str_replace("\n", "\x0b", $str_cmd) . "\n";
        return YAPI::SUCCESS;
    }
}
