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
    public int $_sslCertOptions = 0;
    public string $_sslCertPath = '';
    //--- (generated code: YAPIContext attributes)
    protected float $_defaultCacheValidity = 5;                            // ulong

    //--- (end of generated code: YAPIContext attributes)
    private array $_yhub_cache = [];

    function __construct()
    {
        //--- (generated code: YAPIContext constructor)
        //--- (end of generated code: YAPIContext constructor)
    }

    private function GetYAPISharedLibraryPath_internal()
    {
        return "";
    }
    private function AddUdevRule_internal(bool $force): string
    {
        return "error: Not supported in PHP";
    }


    /**
     * Download the TLS/SSL certificate from the hub. This function allows to download a TLS/SSL certificate to add it
     * to the list of trusted certificates using the AddTrustedCertificates method.
     *
     * @param string $url : the root URL of the VirtualHub V2 or HTTP server.
     * @param float $mstimeout : the number of milliseconds available to download the certificate.
     *
     * @return string  a string containing the certificate. In case of error, returns a string starting with "error:".
     */
    private function DownloadHostCertificate_internal(string $url, float $mstimeout): string
    {
        $contextOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'allow_self_signed' => true,
                'verify_peer_name' => false,
                'capture_peer_cert_chain' => true
            )
        );
        $url = str_replace('http://', 'tls://', $url);
        $url = str_replace('https://', 'tls://', $url);
        if (strpos($url, 'tls://') !== 0) {
            $url = 'tls://' . $url;
        }

        $sslContext = @stream_context_create($contextOptions);
        $resource = @stream_socket_client($url, $errno, $errstr, 10, STREAM_CLIENT_CONNECT, $sslContext);
        if ($resource) {
            $params = stream_context_get_params($resource);
            $ca = "";
            foreach ($params["options"]["ssl"]["peer_certificate_chain"] as $cert) {
                openssl_x509_export($cert, $output);
                $ca .= $output;
            }
            return $ca;
        }
        return "";
    }

    private function AddTrustedCertificates_internal(string $certificate): string
    {
        return "error:AddTrustedCertificates is not supported in PHP";
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
     * Returns the path to the dynamic YAPI library. This function is useful for debugging problems loading the
     * dynamic library YAPI:: This function is supported by the C#, Python and VB languages. The other
     * libraries return an
     * empty string.
     *
     * @return string  a string containing the path of the YAPI dynamic library.
     */
    public function GetYAPISharedLibraryPath(): string
    {
        return $this->GetYAPISharedLibraryPath_internal();
    }

    //cannot be generated for PHP:
    //private function GetYAPISharedLibraryPath_internal()

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
     * Download the TLS/SSL certificate from the hub. This function allows to download a TLS/SSL certificate to add it
     * to the list of trusted certificates using the AddTrustedCertificates method.
     *
     * @param string $url : the root URL of the VirtualHub V2 or HTTP server.
     * @param float $mstimeout : the number of milliseconds available to download the certificate.
     *
     * @return string  a string containing the certificate. In case of error, returns a string starting with "error:".
     */
    public function DownloadHostCertificate(string $url, float $mstimeout): string
    {
        return $this->DownloadHostCertificate_internal($url, $mstimeout);
    }

    //cannot be generated for PHP:
    //private function DownloadHostCertificate_internal(string $url, float $mstimeout)

    /**
     * Adds a TLS/SSL certificate to the list of trusted certificates. By default, the library
     * library will reject TLS/SSL connections to servers whose certificate is not known. This function
     * function allows to add a list of known certificates. It is also possible to disable the verification
     * using the SetNetworkSecurityOptions method.
     *
     * @param string $certificate : a string containing one or more certificates.
     *
     * @return string  an empty string if the certificate has been added correctly.
     *         In case of error, returns a string starting with "error:".
     */
    public function AddTrustedCertificates(string $certificate): string
    {
        return $this->AddTrustedCertificates_internal($certificate);
    }

    //cannot be generated for PHP:
    //private function AddTrustedCertificates_internal(string $certificate)

    /**
     * Set the path of Certificate Authority file on local filesystem. This method takes as a parameter
     * the path of a file containing all certificates in PEM format.
     * For technical reasons, only one file can be specified. So if you need to connect to several Hubs
     * instances with self-signed certificates, you'll need to use
     * a single file containing all the certificates end-to-end. Passing a empty string will restore the
     * default settings. This option is only supported by PHP library.
     *
     * @param string $certificatePath : the path of the file containing all certificates in PEM format.
     *
     * @return string  an empty string if the certificate has been added correctly.
     *         In case of error, returns a string starting with "error:".
     */
    public function SetTrustedCertificatesList(string $certificatePath): string
    {
        return $this->SetTrustedCertificatesList_internal($certificatePath);
    }

    //cannot be generated for PHP:
    //private function SetTrustedCertificatesList_internal(string $certificatePath)

    /**
     * Enables or disables certain TLS/SSL certificate checks.
     *
     * @param int $opts : The options are YAPI::NO_TRUSTED_CA_CHECK,
     *         YAPI::NO_EXPIRATION_CHECK, YAPI::NO_HOSTNAME_CHECK.
     *
     * @return string  an empty string if the options are taken into account.
     *         On error, returns a string beginning with "error:".
     */
    public function SetNetworkSecurityOptions(int $opts): string
    {
        return $this->SetNetworkSecurityOptions_internal($opts);
    }

    //cannot be generated for PHP:
    //private function SetNetworkSecurityOptions_internal(int $opts)

    /**
     * Modifies the network connection delay for yRegisterHub() and yUpdateDeviceList().
     * This delay impacts only the YoctoHubs and VirtualHub
     * which are accessible through the network. By default, this delay is of 20000 milliseconds,
     * but depending on your network you may want to change this delay,
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
     * but depending on your network you may want to change this delay,
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

    public function GetDeviceListValidity_internal(): int
    {
        return intval($this->_deviceListValidityMs / 1000);
    }


    public function SetNetworkTimeout_internal(float $networkMsTimeout): void
    {
        $this->_networkTimeoutMs = (int)$networkMsTimeout;
    }

    public function SetTrustedCertificatesList_internal(string $certificatePath): string
    {
        if ($certificatePath == '' || file_exists($certificatePath)) {
            $this->_sslCertPath = $certificatePath;
            return "";
        } else {
            return "error: Invalid path";
        }
    }

    private function SetNetworkSecurityOptions_internal(int $options): string
    {
        $this->_sslCertOptions = $options;
        return "";
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

