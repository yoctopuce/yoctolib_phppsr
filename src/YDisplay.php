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
    const AUTOINVERTDELAY_INVALID = YAPI::INVALID_UINT;
    const ORIENTATION_LEFT = 0;
    const ORIENTATION_UP = 1;
    const ORIENTATION_RIGHT = 2;
    const ORIENTATION_DOWN = 3;
    const ORIENTATION_INVALID = -1;
    const DISPLAYPANEL_INVALID = YAPI::INVALID_STRING;
    const DISPLAYWIDTH_INVALID = YAPI::INVALID_UINT;
    const DISPLAYHEIGHT_INVALID = YAPI::INVALID_UINT;
    const DISPLAYTYPE_MONO = 0;
    const DISPLAYTYPE_EPAPER_BW = 1;
    const DISPLAYTYPE_EPAPER_BWR = 2;
    const DISPLAYTYPE_EPAPER_BWRY = 3;
    const DISPLAYTYPE_INVALID = -1;
    const LAYERWIDTH_INVALID = YAPI::INVALID_UINT;
    const LAYERHEIGHT_INVALID = YAPI::INVALID_UINT;
    const LAYERCOUNT_INVALID = YAPI::INVALID_UINT;
    const COMMAND_INVALID = YAPI::INVALID_STRING;
    const FASTREFRESH_WHENEVER_POSSIBLE  = 0;
    const FASTREFRESH_WHENEVER_SUPPORTED = 1;
    const FASTREFRESH_NEVER              = 2;
    const FASTREFRESH_INVALID            = 3;
    const REGENERATE_ON_REQUEST_ONLY     = 0;
    const REGENERATE_EVERY_DAY           = 1;
    const REGENERATE_EVERY_12H           = 2;
    const REGENERATE_EVERY_6H            = 3;
    const REGENERATE_EVERY_3H            = 4;
    const REGENERATE_EVERY_2H            = 5;
    const REGENERATE_EVERY_HOUR          = 6;
    const REGENERATE_EVERY_30MIN         = 7;
    const REGENERATE_EVERY_15MIN         = 8;
    const REGENERATE_EVERY_480           = 9;
    const REGENERATE_EVERY_432           = 10;
    const REGENERATE_EVERY_360           = 11;
    const REGENERATE_EVERY_288           = 12;
    const REGENERATE_EVERY_240           = 13;
    const REGENERATE_EVERY_192           = 14;
    const REGENERATE_EVERY_144           = 15;
    const REGENERATE_EVERY_96            = 16;
    const REGENERATE_EVERY_48            = 17;
    const REGENERATE_EVERY_36            = 18;
    const REGENERATE_EVERY_24            = 19;
    const REGENERATE_EVERY_12            = 20;
    const REGENERATE_EVERY_10            = 21;
    const REGENERATE_EVERY_8             = 22;
    const REGENERATE_EVERY_6             = 23;
    const REGENERATE_EVERY_4             = 24;
    const REGENERATE_ALWAYS              = 25;
    const REGENERATE_INVALID             = 26;
    const DISPLAYSTATE_FAILURE           = 0;
    const DISPLAYSTATE_OFF               = 1;
    const DISPLAYSTATE_POWERING          = 2;
    const DISPLAYSTATE_IDLE              = 3;
    const DISPLAYSTATE_REFRESHING        = 4;
    const DISPLAYSTATE_INVALID           = 5;
    //--- (end of generated code: YDisplay declaration)

    //--- (generated code: YDisplay attributes)
    protected int $_enabled = self::ENABLED_INVALID;        // Bool
    protected string $_startupSeq = self::STARTUPSEQ_INVALID;     // Text
    protected int $_brightness = self::BRIGHTNESS_INVALID;     // Percent
    protected int $_autoInvertDelay = self::AUTOINVERTDELAY_INVALID; // UInt31
    protected int $_orientation = self::ORIENTATION_INVALID;    // DisplayOrientation
    protected string $_displayPanel = self::DISPLAYPANEL_INVALID;   // DisplayPanel
    protected int $_displayWidth = self::DISPLAYWIDTH_INVALID;   // UInt31
    protected int $_displayHeight = self::DISPLAYHEIGHT_INVALID;  // UInt31
    protected int $_displayType = self::DISPLAYTYPE_INVALID;    // DisplayType
    protected int $_layerWidth = self::LAYERWIDTH_INVALID;     // UInt31
    protected int $_layerHeight = self::LAYERHEIGHT_INVALID;    // UInt31
    protected int $_layerCount = self::LAYERCOUNT_INVALID;     // UInt31
    protected string $_command = self::COMMAND_INVALID;        // Text
    protected array $_allDisplayLayers = [];                           // YDisplayLayerArr
    protected float $_frozenUntil = 0;                            // u64
    protected bool $_recording = false;                        // bool
    protected string $_sequence = "";                           // str

    //--- (end of generated code: YDisplay attributes)

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
        case 'autoInvertDelay':
            $this->_autoInvertDelay = intval($val);
            return 1;
        case 'orientation':
            $this->_orientation = intval($val);
            return 1;
        case 'displayPanel':
            $this->_displayPanel = $val;
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
     * Changes the name of the sequence to play when the display is powered on.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param string $newval : a string corresponding to the name of the sequence to play when the display
     * is powered on
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
     * Returns the interval between automatic display inversions, or 0 if automatic
     * inversion is disabled. Using the automatic inversion mechanism reduces the
     * burn-in that occurs on OLED screens over long periods when the same content
     * remains displayed on the screen.
     *
     * @return int  an integer corresponding to the interval between automatic display inversions, or 0 if automatic
     *         inversion is disabled
     *
     * On failure, throws an exception or returns YDisplay::AUTOINVERTDELAY_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_autoInvertDelay(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::AUTOINVERTDELAY_INVALID;
            }
        }
        $res = $this->_autoInvertDelay;
        return $res;
    }

    /**
     * Changes the interval between automatic display inversions.
     * The parameter is the number of seconds, or 0 to disable automatic inversion.
     * Using the automatic inversion mechanism reduces the burn-in that occurs on OLED
     * screens over long periods when the same content remains displayed on the screen.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param int $newval : an integer corresponding to the interval between automatic display inversions
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_autoInvertDelay(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("autoInvertDelay", $rest_val);
    }

    /**
     * Returns the currently selected display orientation. The orientation is defined as the side of the
     * screen where the
     * USB connector (for OLED displays) or the ribbon cable (for ePaper panels) is located when the
     * display is up straight.
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
        // $res                    is a enumDISPLAYORIENTATION;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::ORIENTATION_INVALID;
            }
        }
        $res = $this->_orientation;
        return $res;
    }

    /**
     * Changes the display orientation. he orientation is defined as the side of the screen where the
     * USB connector (for OLED displays) or the ribbon cable (for ePaper panels) is located when the
     * display is up straight. Remember to call the saveToFlash()
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
        $res = $this->_setAttr("orientation", $rest_val);
        $this->_clearLazyCache();
        return $res;
    }

    /**
     * Returns the exact model of the display panel.
     *
     * @return string  a string corresponding to the exact model of the display panel
     *
     * On failure, throws an exception or returns YDisplay::DISPLAYPANEL_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_displayPanel(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DISPLAYPANEL_INVALID;
            }
        }
        $res = $this->_displayPanel;
        return $res;
    }

    /**
     * Changes the model of display to match the connected display panel.
     * This function has no effect if the module does not support the selected
     * display panel. Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param string $newval : a string corresponding to the model of display to match the connected display panel
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_displayPanel(string $newval): int
    {
        $rest_val = $newval;
        $res = $this->_setAttr("displayPanel", $rest_val);
        $this->_clearLazyCache();
        return $res;
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
     * Returns the display type: monochrome OLED, black and white ePaper, color ePaper, and so on.
     *
     * @return int  a value among YDisplay::DISPLAYTYPE_MONO, YDisplay::DISPLAYTYPE_EPAPER_BW,
     * YDisplay::DISPLAYTYPE_EPAPER_BWR and YDisplay::DISPLAYTYPE_EPAPER_BWRY corresponding to the display
     * type: monochrome OLED, black and white ePaper, color ePaper, and so on
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
     * @throws YAPI_Exception on error
     */
    public function sendCommand(string $cmd): int
    {
        if (!($this->_recording)) {
            return $this->set_command($cmd);
        }
        $this->_sequence = sprintf('%s%s'."\n".'', $this->_sequence, $cmd);
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function flushLayers(): int
    {
        foreach ($this->_allDisplayLayers as $ii_0) {
            if ($ii_0->must_be_flushed()) {
                $ii_0->flush_now();
            }
        }
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function resetHiddenLayerFlags(): int
    {
        foreach ($this->_allDisplayLayers as $ii_0) {
            $ii_0->resetHiddenFlag();
        }
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function isFrozen(): bool
    {
        if ($this->_frozenUntil == 0) {
            return false;
        }
        if ($this->_frozenUntil <= YAPI::GetTickCount()) {
            $this->_frozenUntil = 0;
            return false;
        }
        return true;
    }

    /**
     * Returns the fast refresh usage policy in use (ePaper displays only).
     * This setting is combined with the regenerate policy to determine when the screen
     * should be updated using a fast update versus or regenerated using a slower,
     * flickering full refresh.
     *
     * @return int  a value among the YDisplay::FASTREFRESH enumeration
     *         (YDisplay::FASTREFRESH_WHENEVER_POSSIBLE,
     *         YDisplay::FASTREFRESH_WHENEVER_SUPPORTED,
     *         YDisplay::FASTREFRESH_NEVER).
     *
     * On failure, throws an exception or returns YDisplay::FASTREFRESH_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_fastRefreshPolicy(): int
    {
        // $combined               is a int;
        // $fmod                   is a int;
        $combined = $this->get_brightness();
        if ($combined < 0) {
            return self::FASTREFRESH_INVALID;
        }
        $fmod = intVal($combined / 25);
        if ($fmod >= 2) {
            $fmod = $fmod - 2;
        }
        return $fmod;
    }

    /**
     * Returns the display regeneration minimal frequency (ePaper displays only).
     * This setting is combined with the fast refresh usage policy to determine
     * when the screen should be updated using a fast update versus or regenerated
     * using a slower, flickering full refresh. To change the display regeneration minimal
     * frequency, use methode set_fastRefreshPolicy().
     *
     * @return int  a value among the YDisplay::REGENERATE enumeration
     *         (YDisplay::REGENERATE_ON_REQUEST_ONLY,
     *         YDisplay::REGENERATE_EVERY_DAY, YDisplay::REGENERATE_EVERY_12H,
     *         YDisplay::REGENERATE_EVERY_6H, YDisplay::REGENERATE_EVERY_3H,
     *         YDisplay::REGENERATE_EVERY_2H, YDisplay::REGENERATE_EVERY_HOUR,
     *         YDisplay::REGENERATE_EVERY_30MIN, YDisplay::REGENERATE_EVERY_15MIN,
     *         YDisplay::REGENERATE_EVERY_480, YDisplay::REGENERATE_EVERY_432,
     *         YDisplay::REGENERATE_EVERY_360, YDisplay::REGENERATE_EVERY_288,
     *         YDisplay::REGENERATE_EVERY_240, YDisplay::REGENERATE_EVERY_192,
     *         YDisplay::REGENERATE_EVERY_144, YDisplay::REGENERATE_EVERY_96,
     *         YDisplay::REGENERATE_EVERY_48, YDisplay::REGENERATE_EVERY_36,
     *         YDisplay::REGENERATE_EVERY_24, YDisplay::REGENERATE_EVERY_12,
     *         YDisplay::REGENERATE_EVERY_10, YDisplay::REGENERATE_EVERY_8,
     *         YDisplay::REGENERATE_EVERY_6, YDisplay::REGENERATE_EVERY_4,
     *         YDisplay::REGENERATE_ALWAYS).
     *
     * On failure, throws an exception or returns YDisplay::REGENERATE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_regeneratePolicy(): int
    {
        // $combined               is a int;
        // $fval                   is a int;
        $combined= $this->get_brightness();
        if ($combined < 0) {
            return self::REGENERATE_INVALID;
        }
        if ($combined >= 100) {
            $fval = 25;
        } else {
            $fval = ($combined % 25);
        }
        return $fval;
    }

    /**
     * Changes the fast refresh usage policy and display regeneration minimal frequency
     * (ePaper displays only). These settings jointly determine when the screen should be
     * updated using a fast update versus or regenerated using a slower, flickering full
     * refresh.
     *
     * @param fastRefresh : a value among the YDisplay::FASTREFRESH enumeration
     *         (YDisplay::FASTREFRESH_WHENEVER_POSSIBLE,
     *         YDisplay::FASTREFRESH_WHENEVER_SUPPORTED,
     *         YDisplay::FASTREFRESH_NEVER),
     *         corresponding to the policy for using fast refresh.
     * @param regenerate : a value among the enumeration YRefFrame.REGENERATE
     *         (YDisplay::REGENERATE_ON_REQUEST_ONLY,
     *         YDisplay::REGENERATE_EVERY_DAY, YDisplay::REGENERATE_EVERY_12H,
     *         YDisplay::REGENERATE_EVERY_6H, YDisplay::REGENERATE_EVERY_3H,
     *         YDisplay::REGENERATE_EVERY_2H, YDisplay::REGENERATE_EVERY_HOUR,
     *         YDisplay::REGENERATE_EVERY_30MIN, YDisplay::REGENERATE_EVERY_15MIN,
     *         YDisplay::REGENERATE_EVERY_480, YDisplay::REGENERATE_EVERY_432,
     *         YDisplay::REGENERATE_EVERY_360, YDisplay::REGENERATE_EVERY_288,
     *         YDisplay::REGENERATE_EVERY_240, YDisplay::REGENERATE_EVERY_192,
     *         YDisplay::REGENERATE_EVERY_144, YDisplay::REGENERATE_EVERY_96,
     *         YDisplay::REGENERATE_EVERY_48, YDisplay::REGENERATE_EVERY_36,
     *         YDisplay::REGENERATE_EVERY_24, YDisplay::REGENERATE_EVERY_12,
     *         YDisplay::REGENERATE_EVERY_10, YDisplay::REGENERATE_EVERY_8,
     *         YDisplay::REGENERATE_EVERY_6, YDisplay::REGENERATE_EVERY_4,
     *         YDisplay::REGENERATE_ALWAYS),
     *         corresponding to the display minimal regeneration frequency.
     *
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_fastRefreshPolicy(int $fastRefresh, int $regenerate): int
    {
        // $combined               is a int;
        // $fmod                   is a int;
        // $fval                   is a int;
        $fmod = $fastRefresh;
        $fval = $regenerate;
        if (($fval == 25) || ($fmod == 2)) {
            $combined = 100;
        } else {
            $combined = 50 + $fmod * 25 + $fval;
        }
        return $this->set_brightness($combined);
    }

    /**
     * Clears the display screen and resets all display layers to their default state.
     * Using this function in a sequence will kill the sequence play-back. Do not use that
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
     * Forces an ePaper screen to perform a regenerative update using the slow
     * update method. Periodic use of the slow method (total panel update with
     * multiple inversions) prevents ghosting effects and improves contrast.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function regenerateDisplay(): int
    {
        return $this->sendCommand('z');
    }

    /**
     * Returns the current state of an ePaper display, specifically to
     * determine whether an update is in progress or whether a
     * configuration issue has been detected. If a display configuration
     * error has been detected, the error message can be retrieved.
     *
     * @param string $errmsg : a string passed by reference to receive the error message.
     *
     * @return int  a value among the enumeration YDisplay::DISPLAYSTATE
     *         (YDisplay::DISPLAYSTATE_FAILURE, YDisplay::DISPLAYSTATE_OFF,
     *         YDisplay::DISPLAYSTATE_POWERING, YDisplay::DISPLAYSTATE_IDLE,
     *         YDisplay::DISPLAYSTATE_REFRESHING)
     *         corresponding to the current display state.
     */
    public function get_ePaperState(string &$errmsg): int
    {
        // $json                   is a bin;
        // $dispError              is a str;
        // $dispState              is a int;

        if ($this->get_displayType() == self::DISPLAYTYPE_MONO) {
            $errmsg = 'Not an ePaper display';
            return 0;
        }
        $json = $this->_download('disp.json');
        if (strlen($json) == 0) {
            $errmsg = $this->get_errorMessage();
            return 0;
        } else {
            $dispError = $this->_json_get_string($this->_get_json_path($json, 'err'));
            $errmsg = $dispError;
            if (strlen($dispError) > 0) {
                return 0;
            }
            $dispState = intVal($this->_json_get_key($json, 'state'));
            if ($dispState > 10) {
                return 4;
            }
            if ($dispState == 10) {
                return 3;
            }
            if ($dispState > 0) {
                return 2;
            }
        }
        return 1;
    }

    /**
     * Disables screen refresh for a short period of time. The combination of
     * postponeRefresh and triggerRefresh can be used as an
     * alternative to double-buffering to avoid flickering during display updates.
     *
     * @param int $duration : duration of deactivation in milliseconds (max. 30 seconds)
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function postponeRefresh(int $duration): int
    {
        $this->_frozenUntil = YAPI::GetTickCount() + $duration;
        return $this->sendCommand(sprintf('H%d',$duration));
    }

    /**
     * Triggers an immediate screen refresh. The combination of
     * postponeRefresh and triggerRefresh can be used as an
     * alternative to double-buffering to avoid flickering during display updates.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function triggerRefresh(): int
    {
        $this->_frozenUntil = 0;
        $this->flushLayers();
        return $this->sendCommand('H0');
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
        $this->_upload($sequenceName, YAPI::Ystr2bin($this->_sequence));
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
        $this->flushLayers();
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
        if (!(($layerId >= 0) && ($layerId < $layercount))) return $this->_throw(YAPI::INVALID_ARGUMENT,'invalid DisplayLayer index',null);
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
     * Returns a color image with the current content of the display.
     * The image is returned as a binary object, where each byte represents a pixel,
     * from left to right and from top to bottom. The palette used to map byte
     * values to RGB colors is filled into the list provided as argument.
     * In all cases, the first palette entry (value 0) corresponds to the
     * screen default background color.
     * The image dimensions are given by the display width and height.
     *
     * @param Integer[] $palette : a list to be filled with the image palette
     *
     * @return string  a binary object if the call succeeds.
     *
     * On failure, throws an exception or returns an empty binary object.
     * @throws YAPI_Exception on error
     */
    public function readDisplay(array $palette): string
    {
        // $zipmap                 is a bin;
        // $zipsize                is a int;
        // $zipwidth               is a int;
        // $zipheight              is a int;
        // $ziprotate              is a int;
        // $zipcolors              is a int;
        // $zipcol                 is a int;
        // $zipbits                is a int;
        // $zipmask                is a int;
        // $srcpos                 is a int;
        // $endrun                 is a int;
        // $srcpat                 is a int;
        // $srcbit                 is a int;
        // $srcval                 is a int;
        // $srcx                   is a int;
        // $srcy                   is a int;
        // $srci                   is a int;
        // $pixmap                 is a bin;
        // $pixcount               is a int;
        // $pixval                 is a int;
        // $pixpos                 is a int;
        // $rotmap                 is a bin;
        $pixmap = '';
        // Check if the display firmware has autoInvertDelay and pixels.bin support

        if ($this->get_autoInvertDelay() < 0) {
            // Old firmware, use uncompressed GIF output to rebuild pixmap
            $zipmap = $this->_download('display.gif');
            $zipsize = strlen($zipmap);
            if ($zipsize == 0) {
                return $pixmap;
            }
            if (!($zipsize >= 32)) return $this->_throw(YAPI::IO_ERROR,'not a GIF image',$pixmap);
            if (!((ord($zipmap[0]) == 71) && (ord($zipmap[2]) == 70))) return $this->_throw(YAPI::INVALID_ARGUMENT,'not a GIF image',$pixmap);
            $zipwidth = ord($zipmap[6]) + 256 * ord($zipmap[7]);
            $zipheight = ord($zipmap[8]) + 256 * ord($zipmap[9]);
            while (sizeof($palette) > 0) {
                array_pop($palette);
            };
            $zipcol = ord($zipmap[13]) * 65536 + ord($zipmap[14]) * 256 + ord($zipmap[15]);
            $palette[] = $zipcol;
            $zipcol = ord($zipmap[16]) * 65536 + ord($zipmap[17]) * 256 + ord($zipmap[18]);
            $palette[] = $zipcol;
            $pixcount = $zipwidth * $zipheight;
            $pixmap = ($pixcount > 0 ? pack('C',array_fill(0, $pixcount, 0)) : '');
            $pixpos = 0;
            $srcpos = 30;
            $zipsize = $zipsize - 2;
            while ($srcpos < $zipsize) {
                // load next run size
                $endrun = $srcpos + 1 + ord($zipmap[$srcpos]);
                $srcpos = $srcpos + 1;
                while ($srcpos < $endrun) {
                    $srcval = ord($zipmap[$srcpos]);
                    $srcpos = $srcpos + 1;
                    $srcbit = 8;
                    while ($srcbit != 0) {
                        if ($srcbit < 3) {
                            $srcval = $srcval + (ord($zipmap[$srcpos]) << $srcbit);
                            $srcpos = $srcpos + 1;
                        }
                        $pixval = ($srcval & 7);
                        $srcval = ($srcval >> 3);
                        if (!(($pixval > 1) && ($pixval != 4))) return $this->_throw(YAPI::INVALID_ARGUMENT,'unexpected encoding',$pixmap);
                        $pixmap[$pixpos] = pack('C', $pixval);
                        $pixpos = $pixpos + 1;
                        $srcbit = $srcbit - 3;
                    }
                }
            }
            return $pixmap;
        }
        // New firmware, use compressed pixels.bin
        $zipmap = $this->_download('pixels.bin');
        $zipsize = strlen($zipmap);
        if ($zipsize == 0) {
            return $pixmap;
        }
        if (!($zipsize >= 16)) return $this->_throw(YAPI::IO_ERROR,'not a pixmap',$pixmap);
        if (!((ord($zipmap[0]) == 80) && (ord($zipmap[2]) == 88))) return $this->_throw(YAPI::INVALID_ARGUMENT,'not a pixmap',$pixmap);
        $zipwidth = ord($zipmap[4]) + 256 * ord($zipmap[5]);
        $zipheight = ord($zipmap[6]) + 256 * ord($zipmap[7]);
        $ziprotate = ord($zipmap[8]);
        $zipcolors = ord($zipmap[9]);
        while (sizeof($palette) > 0) {
            array_pop($palette);
        };
        $srcpos = 10;
        $srci = 0;
        while ($srci < $zipcolors) {
            $zipcol = ord($zipmap[$srcpos]) * 65536 + ord($zipmap[$srcpos+1]) * 256 + ord($zipmap[$srcpos+2]);
            $palette[] = $zipcol;
            $srcpos = $srcpos + 3;
            $srci = $srci + 1;
        }
        $zipbits = 1;
        while ((1 << $zipbits) < $zipcolors) {
            $zipbits = $zipbits + 1;
        }
        $zipmask = (1 << $zipbits) - 1;
        $pixcount = $zipwidth * $zipheight;
        $pixmap = ($pixcount > 0 ? pack('C',array_fill(0, $pixcount, 0)) : '');
        $srcx = 0;
        $srcy = 0;
        $srcval = 0;
        while ($srcpos < $zipsize) {
            // load next compression pattern byte
            $srcpat = ord($zipmap[$srcpos]);
            $srcpos = $srcpos + 1;
            $srcbit = 7;
            while ($srcbit >= 0) {
                // get next bitmap byte
                if (($srcpat & 128) != 0) {
                    $srcval = ord($zipmap[$srcpos]);
                    $srcpos = $srcpos + 1;
                    if ($zipbits > 1) {
                        $srcval = ($srcval << 8) + ord($zipmap[$srcpos]);
                        $srcpos = $srcpos + 1;
                    }
                }
                $srcpat = ($srcpat << 1);
                $pixpos = $srcy * $zipwidth + $srcx;
                // produce 8 pixels
                $srci = 7 * $zipbits;
                while ($srci >= 0) {
                    $pixval = (($srcval >> $srci) & $zipmask);
                    $pixmap[$pixpos] = pack('C', $pixval);
                    $pixpos = $pixpos + 1;
                    $srci = $srci - $zipbits;
                }
                $srcy = $srcy + 1;
                if ($srcy >= $zipheight) {
                    $srcy = 0;
                    $srcx = $srcx + 8;
                    // drop last bytes if image is not a multiple of 8
                    if ($srcx >= $zipwidth) {
                        $srcbit = 0;
                    }
                }
                $srcbit = $srcbit - 1;
            }
        }
        // rotate pixmap to match display orientation
        if ($ziprotate == 0) {
            return $pixmap;
        }
        if (($ziprotate & 2) != 0) {
            // rotate buffer 180 degrees by swapping pixels
            $srcpos = 0;
            $pixpos = $pixcount - 1;
            while ($srcpos < $pixpos) {
                $pixval = ord($pixmap[$srcpos]);
                $pixmap[$srcpos] = pack('C', ord($pixmap[$pixpos]));
                $pixmap[$pixpos] = pack('C', $pixval);
                $srcpos = $srcpos + 1;
                $pixpos = $pixpos - 1;
            }
        }
        if (($ziprotate & 1) == 0) {
            return $pixmap;
        }
        // rotate 90 ccw: first pixel is bottom left
        $rotmap = ($pixcount > 0 ? pack('C',array_fill(0, $pixcount, 0)) : '');
        $srcx = 0;
        $srcy = $zipwidth - 1;
        $srcpos = 0;
        while ($srcpos < $pixcount) {
            $pixval = ord($pixmap[$srcpos]);
            $pixpos = $srcy * $zipheight + $srcx;
            $rotmap[$pixpos] = pack('C', $pixval);
            $srcy = $srcy - 1;
            if ($srcy < 0) {
                $srcx = $srcx + 1;
                $srcy = $zipwidth - 1;
            }
            $srcpos = $srcpos + 1;
        }
        return $rotmap;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function gifEncode(string $pixmap, array $palette, int $w, bool $shortHdr): string
    {
        // $minCodeSize            is a int;
        // $LZW_CLRCODE            is a int;
        // $LZW_ENDCODE            is a int;
        // $LZW_1STCODE            is a int;
        // $codeSize               is a int;
        // $maxCode                is a int;
        $codes = [];            // intArr;
        // $nCodes                 is a int;
        // $pixmapSize             is a int;
        // $dataStream             is a bin;
        // $blockStart             is a int;
        // $blockEnd               is a int;
        // $prevCode               is a int;
        // $pixPos                 is a int;
        // $wrBits                 is a int;
        // $wrBitCnt               is a int;
        // $outPos                 is a int;
        // $nextVal                is a int;
        // $i                      is a int;
        // $hdrSize                is a int;
        // $res                    is a bin;
        // $h                      is a int;

        if (sizeof($palette) > 8) {
            $this->_throw(YAPI::INVALID_ARGUMENT, 'Palette should have no more than 8 colors');
            $res = '';
            return $res;
        }
        if (sizeof($palette) <= 4) {
            $minCodeSize = 2;
        } else {
            $minCodeSize = 3;
        }
        $LZW_CLRCODE = (1 << $minCodeSize);
        $LZW_ENDCODE = $LZW_CLRCODE + 1;
        $LZW_1STCODE = $LZW_ENDCODE + 1;
        $codeSize = $minCodeSize + 1;
        $maxCode = (1 << $codeSize) - 1 - $LZW_1STCODE;
        while (sizeof($codes) > 0) {
            array_pop($codes);
        };
        $nCodes = 0;
        $pixmapSize = strlen($pixmap);
        $dataStream = (intVal((2 * $pixmapSize) / 3) + 8 > 0 ? pack('C',array_fill(0, intVal((2 * $pixmapSize) / 3) + 8, 0)) : '');
        $outPos = 0;
        $wrBits = $LZW_CLRCODE;
        $wrBitCnt = 3;
        // prefetch first byte
        $prevCode = ord($pixmap[0]);
        $pixPos = 1;
        while ($pixPos < $pixmapSize + 3) {
            $blockStart = $outPos;
            $outPos = $blockStart + 1;
            $blockEnd = $blockStart + 256;
            // flush any carry-over output byte from previous data sub-block
            while ($wrBitCnt >= 8) {
                $dataStream[$outPos] = pack('C', ($wrBits & 0xff));
                $outPos = $outPos + 1;
                $wrBits = ($wrBits >> 8);
                $wrBitCnt = $wrBitCnt - 8;
            }
            while (($outPos < $blockEnd) && ($pixPos < $pixmapSize)) {
                // search for an existing code matching the running input segment
                // printf("[%d] ", rdBits >> 12);
                $nextVal = ($prevCode | (ord($pixmap[$pixPos]) << 12));
                $pixPos = $pixPos + 1;
                if ($prevCode < $LZW_1STCODE) {
                    $i = 0;
                } else {
                    $i = $prevCode - $LZW_ENDCODE;
                }
                while (($i < $nCodes) && ($codes[$i] != $nextVal)) {
                    $i = $i + 1;
                }
                if ($i >= $nCodes) {
                    // not found, emit prevCode and create new code
                    $wrBits = ($wrBits | ($prevCode << $wrBitCnt));
                    $wrBitCnt = $wrBitCnt + $codeSize;
                    if ($nCodes <= $maxCode) {
                        //fprintf(stderr, "#%d: #%d + %d\n", nextCode, nextVal & 63, nextVal >> 6);
                        $codes[] = $nextVal;
                        $nCodes = $nCodes + 1;
                    } else {
                        $codeSize = $codeSize + 1;
                        if ($codeSize <= 12) {
                            //fprintf(stderr, "#%d: #%d + %d\n", nextCode, nextVal & 63, nextVal >> 6);
                            $codes[] = $nextVal;
                            $nCodes = $nCodes + 1;
                        } else {
                            $wrBits = ($wrBits | ($LZW_CLRCODE << $wrBitCnt));
                            $wrBitCnt = $wrBitCnt + $codeSize;
                            while (sizeof($codes) > 0) {
                                array_pop($codes);
                            };
                            $nCodes = 0;
                            $codeSize = $minCodeSize + 1;
                        }
                        $maxCode = (1 << $codeSize) - 1 - $LZW_1STCODE;
                    }
                    // flush one (or two) codes to output stream
                    while (($wrBitCnt >= 8) && ($outPos < $blockEnd)) {
                        $dataStream[$outPos] = pack('C', ($wrBits & 0xff));
                        $outPos = $outPos + 1;
                        $wrBits = ($wrBits >> 8);
                        $wrBitCnt = $wrBitCnt - 8;
                    }
                    $prevCode = ($nextVal >> 12);
                } else {
                    $prevCode = $i + $LZW_1STCODE;
                }
            }
            if ($pixPos >= $pixmapSize) {
                if (($outPos < $blockEnd) && ($pixPos == $pixmapSize)) {
                    // append code for last run
                    $wrBits = ($wrBits | ($prevCode << $wrBitCnt));
                    $wrBitCnt = $wrBitCnt + $codeSize;
                    while (($wrBitCnt >= 8) && ($outPos < $blockEnd)) {
                        $dataStream[$outPos] = pack('C', ($wrBits & 0xff));
                        $outPos = $outPos + 1;
                        $wrBits = ($wrBits >> 8);
                        $wrBitCnt = $wrBitCnt - 8;
                    }
                    $pixPos = $pixPos + 1;
                }
                if (($outPos < $blockEnd) && ($pixPos == $pixmapSize + 1)) {
                    // append end code
                    $wrBits = ($wrBits | ($LZW_ENDCODE << $wrBitCnt));
                    $wrBitCnt = $wrBitCnt + $codeSize;
                    while (($wrBitCnt >= 8) && ($outPos < $blockEnd)) {
                        $dataStream[$outPos] = pack('C', ($wrBits & 0xff));
                        $outPos = $outPos + 1;
                        $wrBits = ($wrBits >> 8);
                        $wrBitCnt = $wrBitCnt - 8;
                    }
                    $pixPos = $pixPos + 1;
                }
                if (($outPos < $blockEnd) && ($pixPos == $pixmapSize + 2)) {
                    // flush last 0-7 bits
                    if ($wrBitCnt > 0) {
                        $dataStream[$outPos] = pack('C', ($wrBits & 0xff));
                        $outPos = $outPos + 1;
                        $wrBitCnt = 0;
                    }
                    $pixPos = $pixPos + 1;
                }
            }
            $dataStream[$blockStart] = pack('C', $outPos - ($blockStart + 1));
        }
        $blockEnd = $outPos;
        // Now write final buffer
        $hdrSize = 24 + $LZW_CLRCODE * 3;
        $res = ($hdrSize + $outPos + 2 > 0 ? pack('C',array_fill(0, $hdrSize + $outPos + 2, 0)) : '');
        // GIF89a header
        $res[0x00] = pack('C', 0x47);
        $res[0x01] = pack('C', 0x49);
        $res[0x02] = pack('C', 0x46);
        $res[0x03] = pack('C', 0x38);
        $res[0x04] = pack('C', 0x39);
        $res[0x05] = pack('C', 0x61);
        // Logical screen descriptor
        $h = intVal(strlen($pixmap) / $w);
        $res[0x06] = pack('C', ($w & 0xff));
        $res[0x07] = pack('C', ($w >> 8));
        $res[0x08] = pack('C', ($h & 0xff));
        $res[0x09] = pack('C', ($h >> 8));
        $res[0x0a] = pack('C', 0xf0 + $minCodeSize - 1);
        $res[0x0b] = pack('C', 0);
        $res[0x0c] = pack('C', 0);
        // Palette
        $outPos = 0x0d;
        $i = 0;
        while ($i < $LZW_CLRCODE) {
            if ($i < sizeof($palette)) {
                $wrBits = $palette[$i];
                $res[$outPos] = pack('C', (($wrBits >> 16) & 0xff));
                $res[$outPos + 1] = pack('C', (($wrBits >> 8) & 0xff));
                $res[$outPos + 2] = pack('C', ($wrBits & 0xff));
            }
            $outPos = $outPos + 3;
            $i = $i + 1;
        }
        // Image descriptor
        $res[$outPos] = pack('C', 0x2c);
        $res[$outPos + 5] = pack('C', ($w & 0xff));
        $res[$outPos + 6] = pack('C', ($w >> 8));
        $res[$outPos + 7] = pack('C', ($h & 0xff));
        $res[$outPos + 8] = pack('C', ($h >> 8));
        $outPos = $outPos + 10;
        // Prepare to append Image data
        $res[$outPos] = pack('C', $minCodeSize);
        $i = 0;
        while ($i < $blockEnd) {
            $outPos = $outPos + 1;
            $res[$outPos] = pack('C', ord($dataStream[$i]));
            $i = $i + 1;
        }
        // Append zero-block and trailer
        $outPos = $outPos + 1;
        $res[$outPos] = pack('C', 0);
        $outPos = $outPos + 1;
        $res[$outPos] = pack('C', 0x3b);
        return $res;
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
    public function autoInvertDelay(): int
{
    return $this->get_autoInvertDelay();
}

    /**
     * @throws YAPI_Exception
     */
    public function setAutoInvertDelay(int $newval): int
{
    return $this->set_autoInvertDelay($newval);
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
    public function displayPanel(): string
{
    return $this->get_displayPanel();
}

    /**
     * @throws YAPI_Exception
     */
    public function setDisplayPanel(string $newval): int
{
    return $this->set_displayPanel($newval);
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

}
