<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YSegmentedDisplay Class: segmented display control interface
 *
 * The SegmentedDisplay class allows you to drive segmented displays.
 */
class YSegmentedDisplay extends YFunction
{
    const DISPLAYEDTEXT_INVALID = YAPI::INVALID_STRING;
    const DISPLAYMODE_DISCONNECTED = 0;
    const DISPLAYMODE_MANUAL = 1;
    const DISPLAYMODE_AUTO1 = 2;
    const DISPLAYMODE_AUTO60 = 3;
    const DISPLAYMODE_INVALID = -1;
    //--- (end of YSegmentedDisplay declaration)

    //--- (YSegmentedDisplay attributes)
    protected string $_displayedText = self::DISPLAYEDTEXT_INVALID;  // Text
    protected int $_displayMode = self::DISPLAYMODE_INVALID;    // DisplayMode

    //--- (end of YSegmentedDisplay attributes)

    function __construct($str_func)
    {
        //--- (YSegmentedDisplay constructor)
        parent::__construct($str_func);
        $this->_className = 'SegmentedDisplay';

        //--- (end of YSegmentedDisplay constructor)
    }

    //--- (YSegmentedDisplay implementation)

    function _parseAttr($name, $val): int
    {
        switch ($name) {
        case 'displayedText':
            $this->_displayedText = $val;
            return 1;
        case 'displayMode':
            $this->_displayMode = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the text currently displayed on the screen.
     *
     * @return string  a string corresponding to the text currently displayed on the screen
     *
     * On failure, throws an exception or returns YSegmentedDisplay::DISPLAYEDTEXT_INVALID.
     */
    public function get_displayedText(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DISPLAYEDTEXT_INVALID;
            }
        }
        $res = $this->_displayedText;
        return $res;
    }

    /**
     * Changes the text currently displayed on the screen.
     *
     * @param string $newval : a string corresponding to the text currently displayed on the screen
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_displayedText(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("displayedText", $rest_val);
    }

    public function get_displayMode(): int
    {
        // $res                    is a enumDISPLAYMODE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DISPLAYMODE_INVALID;
            }
        }
        $res = $this->_displayMode;
        return $res;
    }

    public function set_displayMode(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("displayMode", $rest_val);
    }

    /**
     * Retrieves a segmented display for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the segmented display is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the segmented display is
     * indeed online at a given time. In case of ambiguity when looking for
     * a segmented display by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the segmented display, for instance
     *         MyDevice.segmentedDisplay.
     *
     * @return YSegmentedDisplay  a YSegmentedDisplay object allowing you to drive the segmented display.
     */
    public static function FindSegmentedDisplay(string $func): ?YSegmentedDisplay
    {
        // $obj                    is a YSegmentedDisplay;
        $obj = YFunction::_FindFromCache('SegmentedDisplay', $func);
        if ($obj == null) {
            $obj = new YSegmentedDisplay($func);
            YFunction::_AddToCache('SegmentedDisplay', $func, $obj);
        }
        return $obj;
    }

    public function displayedText(): string
{
    return $this->get_displayedText();
}

    public function setDisplayedText(string $newval)
{
    return $this->set_displayedText($newval);
}

    public function displayMode(): int
{
    return $this->get_displayMode();
}

    public function setDisplayMode(int $newval)
{
    return $this->set_displayMode($newval);
}

    /**
     * Continues the enumeration of segmented displays started using yFirstSegmentedDisplay().
     * Caution: You can't make any assumption about the returned segmented displays order.
     * If you want to find a specific a segmented display, use SegmentedDisplay.findSegmentedDisplay()
     * and a hardwareID or a logical name.
     *
     * @return YSegmentedDisplay  a pointer to a YSegmentedDisplay object, corresponding to
     *         a segmented display currently online, or a null pointer
     *         if there are no more segmented displays to enumerate.
     */
    public function nextSegmentedDisplay(): ?YSegmentedDisplay
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindSegmentedDisplay($next_hwid);
    }

    /**
     * Starts the enumeration of segmented displays currently accessible.
     * Use the method YSegmentedDisplay::nextSegmentedDisplay() to iterate on
     * next segmented displays.
     *
     * @return YSegmentedDisplay  a pointer to a YSegmentedDisplay object, corresponding to
     *         the first segmented display currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstSegmentedDisplay()
    {
        $next_hwid = YAPI::getFirstHardwareId('SegmentedDisplay');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindSegmentedDisplay($next_hwid);
    }

    //--- (end of YSegmentedDisplay implementation)

}
