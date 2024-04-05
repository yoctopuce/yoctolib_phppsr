<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YHubPort Class: YoctoHub slave port control interface, available for instance in the
 * YoctoHub-Ethernet, the YoctoHub-GSM-4G, the YoctoHub-Shield or the YoctoHub-Wireless-n
 *
 * The YHubPort class provides control over the power supply for slave ports
 * on a YoctoHub. It provide information about the device connected to it.
 * The logical name of a YHubPort is always automatically set to the
 * unique serial number of the Yoctopuce device connected to it.
 */
class YHubPort extends YFunction
{
    const ENABLED_FALSE = 0;
    const ENABLED_TRUE = 1;
    const ENABLED_INVALID = -1;
    const PORTSTATE_OFF = 0;
    const PORTSTATE_OVRLD = 1;
    const PORTSTATE_ON = 2;
    const PORTSTATE_RUN = 3;
    const PORTSTATE_PROG = 4;
    const PORTSTATE_INVALID = -1;
    const BAUDRATE_INVALID = YAPI::INVALID_UINT;
    //--- (end of YHubPort declaration)

    //--- (YHubPort attributes)
    protected int $_enabled = self::ENABLED_INVALID;        // Bool
    protected int $_portState = self::PORTSTATE_INVALID;      // PortState
    protected int $_baudRate = self::BAUDRATE_INVALID;       // BaudRate

    //--- (end of YHubPort attributes)

    function __construct(string $str_func)
    {
        //--- (YHubPort constructor)
        parent::__construct($str_func);
        $this->_className = 'HubPort';

        //--- (end of YHubPort constructor)
    }

    //--- (YHubPort implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'enabled':
            $this->_enabled = intval($val);
            return 1;
        case 'portState':
            $this->_portState = intval($val);
            return 1;
        case 'baudRate':
            $this->_baudRate = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns true if the YoctoHub port is powered, false otherwise.
     *
     * @return int  either YHubPort::ENABLED_FALSE or YHubPort::ENABLED_TRUE, according to true if the
     * YoctoHub port is powered, false otherwise
     *
     * On failure, throws an exception or returns YHubPort::ENABLED_INVALID.
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
     * Changes the activation of the YoctoHub port. If the port is enabled, the
     * connected module is powered. Otherwise, port power is shut down.
     *
     * @param int $newval : either YHubPort::ENABLED_FALSE or YHubPort::ENABLED_TRUE, according to the
     * activation of the YoctoHub port
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
     * Returns the current state of the YoctoHub port.
     *
     * @return int  a value among YHubPort::PORTSTATE_OFF, YHubPort::PORTSTATE_OVRLD, YHubPort::PORTSTATE_ON,
     * YHubPort::PORTSTATE_RUN and YHubPort::PORTSTATE_PROG corresponding to the current state of the YoctoHub port
     *
     * On failure, throws an exception or returns YHubPort::PORTSTATE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_portState(): int
    {
        // $res                    is a enumPORTSTATE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PORTSTATE_INVALID;
            }
        }
        $res = $this->_portState;
        return $res;
    }

    /**
     * Returns the current baud rate used by this YoctoHub port, in kbps.
     * The default value is 1000 kbps, but a slower rate may be used if communication
     * problems are encountered.
     *
     * @return int  an integer corresponding to the current baud rate used by this YoctoHub port, in kbps
     *
     * On failure, throws an exception or returns YHubPort::BAUDRATE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_baudRate(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::BAUDRATE_INVALID;
            }
        }
        $res = $this->_baudRate;
        return $res;
    }

    /**
     * Retrieves a YoctoHub slave port for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the YoctoHub slave port is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the YoctoHub slave port is
     * indeed online at a given time. In case of ambiguity when looking for
     * a YoctoHub slave port by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the YoctoHub slave port, for instance
     *         YHUBETH1.hubPort1.
     *
     * @return YHubPort  a YHubPort object allowing you to drive the YoctoHub slave port.
     */
    public static function FindHubPort(string $func): YHubPort
    {
        // $obj                    is a YHubPort;
        $obj = YFunction::_FindFromCache('HubPort', $func);
        if ($obj == null) {
            $obj = new YHubPort($func);
            YFunction::_AddToCache('HubPort', $func, $obj);
        }
        return $obj;
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
    public function portState(): int
{
    return $this->get_portState();
}

    /**
     * @throws YAPI_Exception
     */
    public function baudRate(): int
{
    return $this->get_baudRate();
}

    /**
     * Continues the enumeration of YoctoHub slave ports started using yFirstHubPort().
     * Caution: You can't make any assumption about the returned YoctoHub slave ports order.
     * If you want to find a specific a YoctoHub slave port, use HubPort.findHubPort()
     * and a hardwareID or a logical name.
     *
     * @return ?YHubPort  a pointer to a YHubPort object, corresponding to
     *         a YoctoHub slave port currently online, or a null pointer
     *         if there are no more YoctoHub slave ports to enumerate.
     */
    public function nextHubPort(): ?YHubPort
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindHubPort($next_hwid);
    }

    /**
     * Starts the enumeration of YoctoHub slave ports currently accessible.
     * Use the method YHubPort::nextHubPort() to iterate on
     * next YoctoHub slave ports.
     *
     * @return ?YHubPort  a pointer to a YHubPort object, corresponding to
     *         the first YoctoHub slave port currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstHubPort(): ?YHubPort
    {
        $next_hwid = YAPI::getFirstHardwareId('HubPort');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindHubPort($next_hwid);
    }

    //--- (end of YHubPort implementation)

}
