<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YWireless Class: wireless LAN interface control interface, available for instance in the
 * YoctoHub-Wireless, the YoctoHub-Wireless-SR, the YoctoHub-Wireless-g or the YoctoHub-Wireless-n
 *
 * The YWireless class provides control over wireless network parameters
 * and status for devices that are wireless-enabled.
 * Note that TCP/IP parameters are configured separately, using class YNetwork.
 */
class YWireless extends YFunction
{
    const LINKQUALITY_INVALID = YAPI::INVALID_UINT;
    const SSID_INVALID = YAPI::INVALID_STRING;
    const CHANNEL_INVALID = YAPI::INVALID_UINT;
    const SECURITY_UNKNOWN = 0;
    const SECURITY_OPEN = 1;
    const SECURITY_WEP = 2;
    const SECURITY_WPA = 3;
    const SECURITY_WPA2 = 4;
    const SECURITY_INVALID = -1;
    const MESSAGE_INVALID = YAPI::INVALID_STRING;
    const WLANCONFIG_INVALID = YAPI::INVALID_STRING;
    const WLANSTATE_DOWN = 0;
    const WLANSTATE_SCANNING = 1;
    const WLANSTATE_CONNECTED = 2;
    const WLANSTATE_REJECTED = 3;
    const WLANSTATE_INVALID = -1;
    //--- (end of generated code: YWireless declaration)

    //--- (generated code: YWireless attributes)
    protected int $_linkQuality = self::LINKQUALITY_INVALID;    // Percent
    protected string $_ssid = self::SSID_INVALID;           // Text
    protected int $_channel = self::CHANNEL_INVALID;        // UInt31
    protected int $_security = self::SECURITY_INVALID;       // WLANSec
    protected string $_message = self::MESSAGE_INVALID;        // YFSText
    protected string $_wlanConfig = self::WLANCONFIG_INVALID;     // WLANConfig
    protected int $_wlanState = self::WLANSTATE_INVALID;      // WLANState

    //--- (end of generated code: YWireless attributes)

    function __construct($str_func)
    {
        //--- (generated code: YWireless constructor)
        parent::__construct($str_func);
        $this->_className = 'Wireless';

        //--- (end of generated code: YWireless constructor)
    }

    //--- (generated code: YWireless implementation)

    function _parseAttr($name, $val): int
    {
        switch ($name) {
        case 'linkQuality':
            $this->_linkQuality = intval($val);
            return 1;
        case 'ssid':
            $this->_ssid = $val;
            return 1;
        case 'channel':
            $this->_channel = intval($val);
            return 1;
        case 'security':
            $this->_security = intval($val);
            return 1;
        case 'message':
            $this->_message = $val;
            return 1;
        case 'wlanConfig':
            $this->_wlanConfig = $val;
            return 1;
        case 'wlanState':
            $this->_wlanState = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the link quality, expressed in percent.
     *
     * @return int  an integer corresponding to the link quality, expressed in percent
     *
     * On failure, throws an exception or returns YWireless::LINKQUALITY_INVALID.
     */
    public function get_linkQuality(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LINKQUALITY_INVALID;
            }
        }
        $res = $this->_linkQuality;
        return $res;
    }

    /**
     * Returns the wireless network name (SSID).
     *
     * @return string  a string corresponding to the wireless network name (SSID)
     *
     * On failure, throws an exception or returns YWireless::SSID_INVALID.
     */
    public function get_ssid(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SSID_INVALID;
            }
        }
        $res = $this->_ssid;
        return $res;
    }

    /**
     * Returns the 802.11 channel currently used, or 0 when the selected network has not been found.
     *
     * @return int  an integer corresponding to the 802.11 channel currently used, or 0 when the selected
     * network has not been found
     *
     * On failure, throws an exception or returns YWireless::CHANNEL_INVALID.
     */
    public function get_channel(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CHANNEL_INVALID;
            }
        }
        $res = $this->_channel;
        return $res;
    }

    /**
     * Returns the security algorithm used by the selected wireless network.
     *
     * @return int  a value among YWireless::SECURITY_UNKNOWN, YWireless::SECURITY_OPEN,
     * YWireless::SECURITY_WEP, YWireless::SECURITY_WPA and YWireless::SECURITY_WPA2 corresponding to the
     * security algorithm used by the selected wireless network
     *
     * On failure, throws an exception or returns YWireless::SECURITY_INVALID.
     */
    public function get_security(): int
    {
        // $res                    is a enumWLANSEC;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SECURITY_INVALID;
            }
        }
        $res = $this->_security;
        return $res;
    }

    /**
     * Returns the latest status message from the wireless interface.
     *
     * @return string  a string corresponding to the latest status message from the wireless interface
     *
     * On failure, throws an exception or returns YWireless::MESSAGE_INVALID.
     */
    public function get_message(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::MESSAGE_INVALID;
            }
        }
        $res = $this->_message;
        return $res;
    }

    public function get_wlanConfig(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::WLANCONFIG_INVALID;
            }
        }
        $res = $this->_wlanConfig;
        return $res;
    }

    public function set_wlanConfig(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("wlanConfig", $rest_val);
    }

    /**
     * Returns the current state of the wireless interface. The state YWireless::WLANSTATE_DOWN means that
     * the network interface is
     * not connected to a network. The state YWireless::WLANSTATE_SCANNING means that the network interface
     * is scanning available
     * frequencies. During this stage, the device is not reachable, and the network settings are not yet
     * applied. The state
     * YWireless::WLANSTATE_CONNECTED means that the network settings have been successfully applied ant
     * that the device is reachable
     * from the wireless network. If the device is configured to use ad-hoc or Soft AP mode, it means that
     * the wireless network
     * is up and that other devices can join the network. The state YWireless::WLANSTATE_REJECTED means
     * that the network interface has
     * not been able to join the requested network. The description of the error can be obtain with the
     * get_message() method.
     *
     * @return int  a value among YWireless::WLANSTATE_DOWN, YWireless::WLANSTATE_SCANNING,
     * YWireless::WLANSTATE_CONNECTED and YWireless::WLANSTATE_REJECTED corresponding to the current state
     * of the wireless interface
     *
     * On failure, throws an exception or returns YWireless::WLANSTATE_INVALID.
     */
    public function get_wlanState(): int
    {
        // $res                    is a enumWLANSTATE;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::WLANSTATE_INVALID;
            }
        }
        $res = $this->_wlanState;
        return $res;
    }

    /**
     * Retrieves a wireless LAN interface for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the wireless LAN interface is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the wireless LAN interface is
     * indeed online at a given time. In case of ambiguity when looking for
     * a wireless LAN interface by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the wireless LAN interface, for instance
     *         YHUBWLN1.wireless.
     *
     * @return YWireless  a YWireless object allowing you to drive the wireless LAN interface.
     */
    public static function FindWireless(string $func): ?YWireless
    {
        // $obj                    is a YWireless;
        $obj = YFunction::_FindFromCache('Wireless', $func);
        if ($obj == null) {
            $obj = new YWireless($func);
            YFunction::_AddToCache('Wireless', $func, $obj);
        }
        return $obj;
    }

    /**
     * Triggers a scan of the wireless frequency and builds the list of available networks.
     * The scan forces a disconnection from the current network. At then end of the process, the
     * the network interface attempts to reconnect to the previous network. During the scan, the wlanState
     * switches to YWireless::WLANSTATE_DOWN, then to YWireless::WLANSTATE_SCANNING. When the scan is completed,
     * get_wlanState() returns either YWireless::WLANSTATE_DOWN or YWireless::WLANSTATE_SCANNING. At this
     * point, the list of detected network can be retrieved with the get_detectedWlans() method.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function startWlanScan(): int
    {
        // $config                 is a str;
        $config = $this->get_wlanConfig();
        // a full scan is triggered when a config is applied
        return $this->set_wlanConfig($config);
    }

    /**
     * Changes the configuration of the wireless lan interface to connect to an existing
     * access point (infrastructure mode).
     * Remember to call the saveToFlash() method and then to reboot the module to apply this setting.
     *
     * @param string $ssid : the name of the network to connect to
     * @param string $securityKey : the network key, as a character string
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function joinNetwork(string $ssid, string $securityKey): int
    {
        return $this->set_wlanConfig(sprintf('INFRA:%s\\%s', $ssid, $securityKey));
    }

    /**
     * Changes the configuration of the wireless lan interface to create an ad-hoc
     * wireless network, without using an access point. On the YoctoHub-Wireless-g
     * and YoctoHub-Wireless-n,
     * you should use softAPNetwork() instead, which emulates an access point
     * (Soft AP) which is more efficient and more widely supported than ad-hoc networks.
     *
     * When a security key is specified for an ad-hoc network, the network is protected
     * by a WEP40 key (5 characters or 10 hexadecimal digits) or WEP128 key (13 characters
     * or 26 hexadecimal digits). It is recommended to use a well-randomized WEP128 key
     * using 26 hexadecimal digits to maximize security.
     * Remember to call the saveToFlash() method and then to reboot the module
     * to apply this setting.
     *
     * @param string $ssid : the name of the network to connect to
     * @param string $securityKey : the network key, as a character string
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function adhocNetwork(string $ssid, string $securityKey): int
    {
        return $this->set_wlanConfig(sprintf('ADHOC:%s\\%s', $ssid, $securityKey));
    }

    /**
     * Changes the configuration of the wireless lan interface to create a new wireless
     * network by emulating a WiFi access point (Soft AP). This function can only be
     * used with the YoctoHub-Wireless-g and the YoctoHub-Wireless-n.
     *
     * On the YoctoHub-Wireless-g, when a security key is specified for a SoftAP network,
     * the network is protected by a WEP40 key (5 characters or 10 hexadecimal digits) or
     * WEP128 key (13 characters or 26 hexadecimal digits). It is recommended to use a
     * well-randomized WEP128 key using 26 hexadecimal digits to maximize security.
     *
     * On the YoctoHub-Wireless-n, when a security key is specified for a SoftAP network,
     * the network will be protected by WPA2.
     *
     * Remember to call the saveToFlash() method and then to reboot the module to apply this setting.
     *
     * @param string $ssid : the name of the network to connect to
     * @param string $securityKey : the network key, as a character string
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function softAPNetwork(string $ssid, string $securityKey): int
    {
        return $this->set_wlanConfig(sprintf('SOFTAP:%s\\%s', $ssid, $securityKey));
    }

    /**
     * Returns a list of YWlanRecord objects that describe detected Wireless networks.
     * This list is not updated when the module is already connected to an access point (infrastructure mode).
     * To force an update of this list, startWlanScan() must be called.
     * Note that an languages without garbage collections, the returned list must be freed by the caller.
     *
     * @return YWlanRecord[]  a list of YWlanRecord objects, containing the SSID, channel,
     *         link quality and the type of security of the wireless network.
     *
     * On failure, throws an exception or returns an empty list.
     */
    public function get_detectedWlans(): array
    {
        // $json                   is a bin;
        $wlanlist = [];         // strArr;
        $res = [];              // YWlanRecordArr;

        $json = $this->_download('wlan.json?by=name');
        $wlanlist = $this->_json_get_array($json);
        while (sizeof($res) > 0) {
            array_pop($res);
        };
        foreach ($wlanlist as $each) {
            $res[] = new YWlanRecord($each);
        }
        return $res;
    }

    public function linkQuality(): int
{
    return $this->get_linkQuality();
}

    public function ssid(): string
{
    return $this->get_ssid();
}

    public function channel(): int
{
    return $this->get_channel();
}

    public function security(): int
{
    return $this->get_security();
}

    public function message(): string
{
    return $this->get_message();
}

    public function wlanConfig(): string
{
    return $this->get_wlanConfig();
}

    public function setWlanConfig(string $newval)
{
    return $this->set_wlanConfig($newval);
}

    public function wlanState(): int
{
    return $this->get_wlanState();
}

    /**
     * Continues the enumeration of wireless LAN interfaces started using yFirstWireless().
     * Caution: You can't make any assumption about the returned wireless LAN interfaces order.
     * If you want to find a specific a wireless LAN interface, use Wireless.findWireless()
     * and a hardwareID or a logical name.
     *
     * @return YWireless  a pointer to a YWireless object, corresponding to
     *         a wireless LAN interface currently online, or a null pointer
     *         if there are no more wireless LAN interfaces to enumerate.
     */
    public function nextWireless(): ?YWireless
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindWireless($next_hwid);
    }

    /**
     * Starts the enumeration of wireless LAN interfaces currently accessible.
     * Use the method YWireless::nextWireless() to iterate on
     * next wireless LAN interfaces.
     *
     * @return YWireless  a pointer to a YWireless object, corresponding to
     *         the first wireless LAN interface currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstWireless()
    {
        $next_hwid = YAPI::getFirstHardwareId('Wireless');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindWireless($next_hwid);
    }

    //--- (end of generated code: YWireless implementation)
};
