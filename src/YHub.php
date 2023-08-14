<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YHub Class: Hub Interface
 *
 *
 */
class YHub
{
    //--- (end of generated code: YHub declaration)

//--- (generated code: YHub attributes)
    protected ?YAPIContext $_ctx = null;                         // YAPIContext
    protected int $_hubref = 0;                            // int
    protected mixed $_userData = null;                         // any

    //--- (end of generated code: YHub attributes)

    function __construct(YAPIContext $ctx, int $_hubref)
    {
        //--- (generated code: YHub constructor)
        //--- (end of generated code: YHub constructor)
        $this->_hubref = $_hubref;
        $this->_ctx = $ctx;
    }

    private function _getStrAttr_internal(string $attrName): string
    {
        /** @var YTcpHub $hub */
        $hub = $this->_ctx->getTcpHubFromRef($this->_hubref);
        if ($hub == null) {
            return "";
        }
        switch ($attrName) {
            case "registeredUrl":
                return $hub->getRegisteredUrl();
            case "connectionUrl":
                return $hub->getBaseURL();
            case "serialNumber":
                return $hub->getSerialNumber();
            case "errorMessage":
                return $hub->getLastErrorMessage();
            default:
                return "";
        }
    }

    private function _getIntAttr_internal(string $attrName): int
    {
        /** @var YTcpHub $hub */
        $hub = $this->_ctx->getTcpHubFromRef($this->_hubref);
        if ($attrName == "isInUse") {
            return $hub != null ? 1 : 0;
        }
        if ($hub == null) {
            return -1;
        }
        switch ($attrName) {
            case "isOnline":
                return $hub->isOnline() ? 1 : 0;
            case "isReadOnly":
                return $hub->isReadOnly() ? 1 : 0;
            case "networkTimeout":
                return $hub->get_networkTimeout();
            case "errorType":
                return $hub->getLastErrorType();
            default:
                return -1;
        }
    }

    private function _setIntAttr_internal(string $attrName, int $value): void
    {
        /** @var YTcpHub $hub */
        $hub = $this->_ctx->getTcpHubFromRef($this->_hubref);
        if ($hub != null && $attrName == "networkTimeout") {
            $hub->set_networkTimeout($value);
        }
    }

    private function get_knownUrls_internal(): array
    {
        $hub = $this->_ctx->getTcpHubFromRef($this->_hubref);
        if ($hub != null) {
            return $hub->getKnownUrls();
        }
        return [];
    }

//--- (generated code: YHub implementation)

    /**
     * @throws YAPI_Exception on error
     */
    public function _getStrAttr(string $attrName): string
    {
        return $this->_getStrAttr_internal($attrName);
    }

    //cannot be generated for PHP:
    //private function _getStrAttr_internal(string $attrName)

    /**
     * @throws YAPI_Exception on error
     */
    public function _getIntAttr(string $attrName): int
    {
        return $this->_getIntAttr_internal($attrName);
    }

    //cannot be generated for PHP:
    //private function _getIntAttr_internal(string $attrName)

    /**
     * @throws YAPI_Exception on error
     */
    public function _setIntAttr(string $attrName, int $value): void
    {
        $this->_setIntAttr_internal($attrName, $value);
    }

    //cannot be generated for PHP:
    //private function _setIntAttr_internal(string $attrName, int $value)

    /**
     * Returns the URL that has been used first to register this hub.
     */
    public function get_registeredUrl(): string
    {
        return $this->_getStrAttr('registeredUrl');
    }

    /**
     * Returns all known URLs that have been used to register this hub.
     * URLs are pointing to the same hub when the devices connected
     * are sharing the same serial number.
     */
    public function get_knownUrls(): array
    {
        return $this->get_knownUrls_internal();
    }

    //cannot be generated for PHP:
    //private function get_knownUrls_internal()

    /**
     * Returns the URL currently in use to communicate with this hub.
     */
    public function get_connectionUrl(): string
    {
        return $this->_getStrAttr('connectionUrl');
    }

    /**
     * Returns the hub serial number, if the hub was already connected once.
     */
    public function get_serialNumber(): string
    {
        return $this->_getStrAttr('serialNumber');
    }

    /**
     * Tells if this hub is still registered within the API.
     *
     * @return boolean  true if the hub has not been unregistered.
     */
    public function isInUse(): bool
    {
        return $this->_getIntAttr('isInUse') > 0;
    }

    /**
     * Tells if there is an active communication channel with this hub.
     *
     * @return boolean  true if the hub is currently connected.
     */
    public function isOnline(): bool
    {
        return $this->_getIntAttr('isOnline') > 0;
    }

    /**
     * Tells if write access on this hub is blocked. Return true if it
     * is not possible to change attributes on this hub
     *
     * @return boolean  true if it is not possible to change attributes on this hub.
     */
    public function isReadOnly(): bool
    {
        return $this->_getIntAttr('isReadOnly') > 0;
    }

    /**
     * Modifies tthe network connection delay for this hub.
     * The default value is inherited from ySetNetworkTimeout
     * at the time when the hub is registered, but it can be updated
     * afterwards for each specific hub if necessary.
     *
     * @param int $networkMsTimeout : the network connection delay in milliseconds.
     * @noreturn
     */
    public function set_networkTimeout(int $networkMsTimeout): void
    {
        $this->_setIntAttr('networkTimeout',$networkMsTimeout);
    }

    /**
     * Returns the network connection delay for this hub.
     * The default value is inherited from ySetNetworkTimeout
     * at the time when the hub is registered, but it can be updated
     * afterwards for each specific hub if necessary.
     *
     * @return int  the network connection delay in milliseconds.
     */
    public function get_networkTimeout(): int
    {
        return $this->_getIntAttr('networkTimeout');
    }

    /**
     * Returns the numerical error code of the latest error with the hub.
     * This method is mostly useful when using the Yoctopuce library with
     * exceptions disabled.
     *
     * @return int  a number corresponding to the code of the latest error that occurred while
     *         using the hub object
     */
    public function get_errorType(): int
    {
        return $this->_getIntAttr('errorType');
    }

    /**
     * Returns the error message of the latest error with the hub.
     * This method is mostly useful when using the Yoctopuce library with
     * exceptions disabled.
     *
     * @return string  a string corresponding to the latest error message that occured while
     *         using the hub object
     */
    public function get_errorMessage(): string
    {
        return $this->_getStrAttr('errorMessage');
    }

    /**
     * Returns the value of the userData attribute, as previously stored
     * using method set_userData.
     * This attribute is never touched directly by the API, and is at
     * disposal of the caller to store a context.
     *
     * @return Object  the object stored previously by the caller.
     */
    public function get_userData(): mixed
    {
        return $this->_userData;
    }

    /**
     * Stores a user context provided as argument in the userData
     * attribute of the function.
     * This attribute is never touched by the API, and is at
     * disposal of the caller to store a context.
     *
     * @param Object $data : any kind of object to be stored
     * @noreturn
     */
    public function set_userData(mixed $data): void
    {
        $this->_userData = $data;
    }

    /**
     * Starts the enumeration of hubs currently in use by the API.
     * Use the method YHub::nextHubInUse() to iterate on the
     * next hubs.
     *
     * @return ?YHub  a pointer to a YHub object, corresponding to
     *         the first hub currently in use by the API, or a
     *         null pointer if none has been registered.
     */
    public static function FirstHubInUse(): ?YHub
    {
        return YAPI::nextHubInUseInternal(-1);
    }

    /**
     * Continues the module enumeration started using YHub::FirstHubInUse().
     * Caution: You can't make any assumption about the order of returned hubs.
     *
     * @return ?YHub  a pointer to a YHub object, corresponding to
     *         the next hub currenlty in use, or a null pointer
     *         if there are no more hubs to enumerate.
     */
    public function nextHubInUse(): ?YHub
    {
        return $this->_ctx->nextHubInUseInternal($this->_hubref);
    }

    //--- (end of generated code: YHub implementation)

}

