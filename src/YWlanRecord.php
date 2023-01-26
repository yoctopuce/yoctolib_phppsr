<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YWlanRecord Class: Wireless network description, returned by wireless.get_detectedWlans method
 *
 * YWlanRecord objects are used to describe a wireless network.
 * These objects are  used in particular in conjunction with the
 * YWireless class.
 */
class YWlanRecord
{
    //--- (end of generated code: YWlanRecord declaration)

    //--- (generated code: YWlanRecord attributes)
    protected string $_ssid = "";                           // str
    protected int $_channel = 0;                            // int
    protected string $_sec = "";                           // str
    protected int $_rssi = 0;                            // int

    //--- (end of generated code: YWlanRecord attributes)

    function __construct($str_json)
    {
        //--- (generated code: YWlanRecord constructor)
        //--- (end of generated code: YWlanRecord constructor)

        $loadval = json_decode($str_json, TRUE);
        $this->_ssid = $loadval['ssid'];
        $this->_channel = $loadval['channel'];
        $this->_sec = $loadval['sec'];
        $this->_rssi  = $loadval['rssi'];
    }

    //--- (generated code: YWlanRecord implementation)

    /**
     * Returns the name of the wireless network (SSID).
     *
     * @return string  a string with the name of the wireless network (SSID).
     */
    public function get_ssid(): string
    {
        return $this->_ssid;
    }

    /**
     * Returns the 802.11 b/g/n channel number used by this network.
     *
     * @return int  an integer corresponding to the channel.
     */
    public function get_channel(): int
    {
        return $this->_channel;
    }

    /**
     * Returns the security algorithm used by the wireless network.
     * If the network implements to security, the value is "OPEN".
     *
     * @return string  a string with the security algorithm.
     */
    public function get_security(): string
    {
        return $this->_sec;
    }

    /**
     * Returns the quality of the wireless network link, in per cents.
     *
     * @return int  an integer between 0 and 100 corresponding to the signal quality.
     */
    public function get_linkQuality(): int
    {
        return $this->_rssi;
    }

    //--- (end of generated code: YWlanRecord implementation)
}
