<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YDaisyChain Class: Module chain configuration interface
 *
 * The YDaisyChain class can be used to verify that devices that
 * are daisy-chained directly from device to device, without a hub,
 * are detected properly.
 */
class YDaisyChain extends YFunction
{
    const DAISYSTATE_READY = 0;
    const DAISYSTATE_IS_CHILD = 1;
    const DAISYSTATE_FIRMWARE_MISMATCH = 2;
    const DAISYSTATE_CHILD_MISSING = 3;
    const DAISYSTATE_CHILD_LOST = 4;
    const DAISYSTATE_INVALID = -1;
    const CHILDCOUNT_INVALID = YAPI::INVALID_UINT;
    const REQUIREDCHILDCOUNT_INVALID = YAPI::INVALID_UINT;
    //--- (end of YDaisyChain declaration)

    //--- (YDaisyChain attributes)
    protected int $_daisyState = self::DAISYSTATE_INVALID;     // DaisyState
    protected int $_childCount = self::CHILDCOUNT_INVALID;     // UInt31
    protected int $_requiredChildCount = self::REQUIREDCHILDCOUNT_INVALID; // UInt31

    //--- (end of YDaisyChain attributes)

    function __construct(string $str_func)
    {
        //--- (YDaisyChain constructor)
        parent::__construct($str_func);
        $this->_className = 'DaisyChain';

        //--- (end of YDaisyChain constructor)
    }

    //--- (YDaisyChain implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'daisyState':
            $this->_daisyState = intval($val);
            return 1;
        case 'childCount':
            $this->_childCount = intval($val);
            return 1;
        case 'requiredChildCount':
            $this->_requiredChildCount = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the state of the daisy-link between modules.
     *
     * @return int  a value among YDaisyChain::DAISYSTATE_READY, YDaisyChain::DAISYSTATE_IS_CHILD,
     * YDaisyChain::DAISYSTATE_FIRMWARE_MISMATCH, YDaisyChain::DAISYSTATE_CHILD_MISSING and
     * YDaisyChain::DAISYSTATE_CHILD_LOST corresponding to the state of the daisy-link between modules
     *
     * On failure, throws an exception or returns YDaisyChain::DAISYSTATE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_daisyState(): int
    {
        // $res                    is a enumDAISYSTATE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DAISYSTATE_INVALID;
            }
        }
        $res = $this->_daisyState;
        return $res;
    }

    /**
     * Returns the number of child nodes currently detected.
     *
     * @return int  an integer corresponding to the number of child nodes currently detected
     *
     * On failure, throws an exception or returns YDaisyChain::CHILDCOUNT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_childCount(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CHILDCOUNT_INVALID;
            }
        }
        $res = $this->_childCount;
        return $res;
    }

    /**
     * Returns the number of child nodes expected in normal conditions.
     *
     * @return int  an integer corresponding to the number of child nodes expected in normal conditions
     *
     * On failure, throws an exception or returns YDaisyChain::REQUIREDCHILDCOUNT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_requiredChildCount(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::REQUIREDCHILDCOUNT_INVALID;
            }
        }
        $res = $this->_requiredChildCount;
        return $res;
    }

    /**
     * Changes the number of child nodes expected in normal conditions.
     * If the value is zero, no check is performed. If it is non-zero, the number
     * child nodes is checked on startup and the status will change to error if
     * the count does not match. Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param int $newval : an integer corresponding to the number of child nodes expected in normal conditions
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_requiredChildCount(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("requiredChildCount", $rest_val);
    }

    /**
     * Retrieves a module chain for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the module chain is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the module chain is
     * indeed online at a given time. In case of ambiguity when looking for
     * a module chain by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the module chain, for instance
     *         MyDevice.daisyChain.
     *
     * @return YDaisyChain  a YDaisyChain object allowing you to drive the module chain.
     */
    public static function FindDaisyChain(string $func): YDaisyChain
    {
        // $obj                    is a YDaisyChain;
        $obj = YFunction::_FindFromCache('DaisyChain', $func);
        if ($obj == null) {
            $obj = new YDaisyChain($func);
            YFunction::_AddToCache('DaisyChain', $func, $obj);
        }
        return $obj;
    }

    /**
     * @throws YAPI_Exception
     */
    public function daisyState(): int
{
    return $this->get_daisyState();
}

    /**
     * @throws YAPI_Exception
     */
    public function childCount(): int
{
    return $this->get_childCount();
}

    /**
     * @throws YAPI_Exception
     */
    public function requiredChildCount(): int
{
    return $this->get_requiredChildCount();
}

    /**
     * @throws YAPI_Exception
     */
    public function setRequiredChildCount(int $newval): int
{
    return $this->set_requiredChildCount($newval);
}

    /**
     * Continues the enumeration of module chains started using yFirstDaisyChain().
     * Caution: You can't make any assumption about the returned module chains order.
     * If you want to find a specific a module chain, use DaisyChain.findDaisyChain()
     * and a hardwareID or a logical name.
     *
     * @return ?YDaisyChain  a pointer to a YDaisyChain object, corresponding to
     *         a module chain currently online, or a null pointer
     *         if there are no more module chains to enumerate.
     */
    public function nextDaisyChain(): ?YDaisyChain
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindDaisyChain($next_hwid);
    }

    /**
     * Starts the enumeration of module chains currently accessible.
     * Use the method YDaisyChain::nextDaisyChain() to iterate on
     * next module chains.
     *
     * @return ?YDaisyChain  a pointer to a YDaisyChain object, corresponding to
     *         the first module chain currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstDaisyChain(): ?YDaisyChain
    {
        $next_hwid = YAPI::getFirstHardwareId('DaisyChain');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindDaisyChain($next_hwid);
    }

    //--- (end of YDaisyChain implementation)

}
