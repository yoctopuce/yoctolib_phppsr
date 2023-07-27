<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YAPIContext Class: Yoctopuce I/O context configuration.
 *
 *
 */
class YAPIContext
{
    //--- (end of generated code: YAPIContext declaration)

    public float $_deviceListValidityMs = 10000;                        // ulong
    public int $_networkTimeoutMs = YAPI_BLOCKING_REQUEST_TIMEOUT;
    //--- (generated code: YAPIContext attributes)
    protected float $_defaultCacheValidity = 5;                            // ulong

    //--- (end of generated code: YAPIContext attributes)
    private array $_yhub_cache = [];

    function __construct()
    {
        //--- (generated code: YAPIContext constructor)
        //--- (end of generated code: YAPIContext constructor)
    }

    private function AddUdevRule_internal(bool $force): string
    {
        return "error: Not supported in PHP";
    }
    //--- (generated code: YAPIContext implementation)

    /**
     * Modifies the delay between each forced enumeration of the used YoctoHubs.
     * By default, the library performs a full enumeration every 10 seconds.
     * To reduce network traffic, you can increase this delay.
     * It's particularly useful when a YoctoHub is connected to the GSM network
     * where traffic is billed. This parameter doesn't impact modules connected by USB,
     * nor the working of module arrival/removal callbacks.
     * Note: you must call this function after yInitAPI.
     *
     * @param int $deviceListValidity : nubmer of seconds between each enumeration.
     * @noreturn
     */
    public function SetDeviceListValidity(int $deviceListValidity): void
    {
        $this->SetDeviceListValidity_internal($deviceListValidity);
    }

    //cannot be generated for PHP:
    //private function SetDeviceListValidity_internal(int $deviceListValidity)

    /**
     * Returns the delay between each forced enumeration of the used YoctoHubs.
     * Note: you must call this function after yInitAPI.
     *
     * @return int  the number of seconds between each enumeration.
     */
    public function GetDeviceListValidity(): int
    {
        return $this->GetDeviceListValidity_internal();
    }

    //cannot be generated for PHP:
    //private function GetDeviceListValidity_internal()

    /**
     * Adds a UDEV rule which authorizes all users to access Yoctopuce modules
     * connected to the USB ports. This function works only under Linux. The process that
     * calls this method must have root privileges because this method changes the Linux configuration.
     *
     * @param boolean $force : if true, overwrites any existing rule.
     *
     * @return string  an empty string if the rule has been added.
     *
     * On failure, returns a string that starts with "error:".
     */
    public function AddUdevRule(bool $force): string
    {
        return $this->AddUdevRule_internal($force);
    }

    //cannot be generated for PHP:
    //private function AddUdevRule_internal(bool $force)

    /**
     * Modifies the network connection delay for yRegisterHub() and yUpdateDeviceList().
     * This delay impacts only the YoctoHubs and VirtualHub
     * which are accessible through the network. By default, this delay is of 20000 milliseconds,
     * but depending or you network you may want to change this delay,
     * gor example if your network infrastructure is based on a GSM connection.
     *
     * @param int $networkMsTimeout : the network connection delay in milliseconds.
     * @noreturn
     */
    public function SetNetworkTimeout(int $networkMsTimeout): void
    {
        $this->SetNetworkTimeout_internal($networkMsTimeout);
    }

    //cannot be generated for PHP:
    //private function SetNetworkTimeout_internal(int $networkMsTimeout)

    /**
     * Returns the network connection delay for yRegisterHub() and yUpdateDeviceList().
     * This delay impacts only the YoctoHubs and VirtualHub
     * which are accessible through the network. By default, this delay is of 20000 milliseconds,
     * but depending or you network you may want to change this delay,
     * for example if your network infrastructure is based on a GSM connection.
     *
     * @return int  the network connection delay in milliseconds.
     */
    public function GetNetworkTimeout(): int
    {
        return $this->GetNetworkTimeout_internal();
    }

    //cannot be generated for PHP:
    //private function GetNetworkTimeout_internal()

    /**
     * Change the validity period of the data loaded by the library.
     * By default, when accessing a module, all the attributes of the
     * module functions are automatically kept in cache for the standard
     * duration (5 ms). This method can be used to change this standard duration,
     * for example in order to reduce network or USB traffic. This parameter
     * does not affect value change callbacks
     * Note: This function must be called after yInitAPI.
     *
     * @param float $cacheValidityMs : an integer corresponding to the validity attributed to the
     *         loaded function parameters, in milliseconds.
     * @noreturn
     */
    public function SetCacheValidity(float $cacheValidityMs): void
    {
        $this->_defaultCacheValidity = $cacheValidityMs;
    }

    /**
     * Returns the validity period of the data loaded by the library.
     * This method returns the cache validity of all attributes
     * module functions.
     * Note: This function must be called after yInitAPI .
     *
     * @return float  an integer corresponding to the validity attributed to the
     *         loaded function parameters, in milliseconds
     */
    public function GetCacheValidity(): float
    {
        return $this->_defaultCacheValidity;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function nextHubInUseInternal(int $hubref): ?YHub
    {
        return $this->nextHubInUseInternal_internal($hubref);
    }

    //cannot be generated for PHP:
    //private function nextHubInUseInternal_internal(int $hubref)

    /**
     * @throws YAPI_Exception on error
     */
    public function getYHubObj(int $hubref): ?YHub
    {
        // $obj                    is a YHub;
        $obj = $this->_findYHubFromCache($hubref);
        if ($obj == null) {
            $obj = new YHub($this, $hubref);
            $this->_addYHubToCache($hubref, $obj);
        }
        return $obj;
    }

    //--- (end of generated code: YAPIContext implementation)

    private function nextHubInUseInternal_internal(int $hubref): ?YHub
    {


        $nextref = YAPI::nextHubRef($hubref);
        if ($nextref >= 0) {
            return $this->getYHubObj($nextref);
        }
        return null;
    }

    private function _findYHubFromCache(int $hubref): ?YHub
    {
        if (array_key_exists($hubref, $this->_yhub_cache)) {
            return $this->_yhub_cache[$hubref];
        }
        return null;
    }

    private function _addYHubToCache(int $hubref, YHub $obj): void
    {
        $this->_yhub_cache[$hubref] = $obj;
    }
    public function SetDeviceListValidity_internal(float $deviceListValidity): void
    {
        $this->_deviceListValidityMs = $deviceListValidity * 1000;
    }

    public function GetDeviceListValidity_internal(): float
    {
        return intval($this->_deviceListValidityMs / 1000);
    }


    public function SetNetworkTimeout_internal(float $networkMsTimeout): void
    {
        $this->_networkTimeoutMs = $networkMsTimeout;
    }

    public function GetNetworkTimeout_internal(): int
    {
        return $this->_networkTimeoutMs;
    }

    public function getTcpHubFromRef(int $hubref): ?YTcpHub
    {
        return YAPI::getTcpHubFromRef($hubref);
    }

}

