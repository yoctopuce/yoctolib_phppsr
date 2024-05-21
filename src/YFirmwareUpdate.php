<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YFirmwareUpdate Class: Firmware update process control interface, returned by module.updateFirmware method.
 *
 * The YFirmwareUpdate class let you control the firmware update of a Yoctopuce
 * module. This class should not be instantiate directly, but instances should be retrieved
 * using the YModule method module.updateFirmware.
 */
class YFirmwareUpdate
{
    //--- (end of generated code: YFirmwareUpdate declaration)
    const DATA_INVALID = YAPI::INVALID_DOUBLE;

    //--- (generated code: YFirmwareUpdate attributes)
    protected string $_serial = "";                           // str
    protected string $_settings = "";                           // bin
    protected string $_firmwarepath = "";                           // str
    protected string $_progress_msg = "";                           // str
    protected int $_progress_c = 0;                            // int
    protected int $_progress = 0;                            // int
    protected int $_restore_step = 0;                            // int
    protected bool $_force = false;                        // bool

    //--- (end of generated code: YFirmwareUpdate attributes)

    public function __construct(string $serial, string $path, string $settings, bool $force)
    {
        //--- (generated code: YFirmwareUpdate constructor)
        //--- (end of generated code: YFirmwareUpdate constructor)
        $this->_serial = $serial;
        $this->_firmwarepath = $path;
        $this->_settings = $settings;
        $this->_force = $force;
    }

    private function _processMore_internal(int $i): int
    {
        //not yet implemented
        $this->_progress = -1;
        $this->_progress_msg = "Not supported in PHP";
        return $this->_progress;
    }

    private static function CheckFirmware_internal(string $serial, string $path, int $minrelease): string
    {
        if ($path == "http://www.yoctopuce.com" || $path == "http://www.yoctopuce.com" || $path == "www.yoctopuce.com") {
            $yoctopuce_infos = file_get_contents('https://www.yoctopuce.com/FR/common/getLastFirmwareLink.php?serial=' . $serial);
            if ($yoctopuce_infos === false) {
                return 'error: Unable to get last firmware info from www.yoctopuce.com';
            }
            $jsonData = json_decode($yoctopuce_infos, true);
            if (!array_key_exists('link', $jsonData) || !array_key_exists('version', $jsonData)) {
                return 'error: Invalid JSON response from www.yoctopuce.com';
            }
            $link = $jsonData['link'];
            $version = intVal($jsonData['version']);
            if ($minrelease > 0) {
                if ($version > $minrelease) {
                    return $link;
                }
            } else {
                return $link;
            }
            return '';
        } else {
            return 'error: Not yet supported in PHP';
        }
    }

    private static function GetAllBootLoaders_internal(): array
    {
        return array();
    }


    //--- (generated code: YFirmwareUpdate implementation)

    /**
     * @throws YAPI_Exception on error
     */
    public function _processMore(int $newupdate): int
    {
        return $this->_processMore_internal($newupdate);
    }

    //cannot be generated for PHP:
    //private function _processMore_internal(int $newupdate)

    /**
     * Returns a list of all the modules in "firmware update" mode.
     *
     * @return string[]  an array of strings containing the serial numbers of devices in "firmware update" mode.
     */
    public static function GetAllBootLoaders(): array
    {
        return self::GetAllBootLoaders_internal();
    }

    //cannot be generated for PHP:
    //private static function GetAllBootLoaders_internal()

    /**
     * Test if the byn file is valid for this module. It is possible to pass a directory instead of a file.
     * In that case, this method returns the path of the most recent appropriate byn file. This method will
     * ignore any firmware older than minrelease.
     *
     * @param string $serial : the serial number of the module to update
     * @param string $path : the path of a byn file or a directory that contains byn files
     * @param int $minrelease : a positive integer
     *
     * @return string  : the path of the byn file to use, or an empty string if no byn files matches the requirement
     *
     * On failure, returns a string that starts with "error:".
     */
    public static function CheckFirmware(string $serial, string $path, int $minrelease): string
    {
        return self::CheckFirmware_internal($serial, $path, $minrelease);
    }

    //cannot be generated for PHP:
    //private static function CheckFirmware_internal(string $serial, string $path, int $minrelease)

    /**
     * Returns the progress of the firmware update, on a scale from 0 to 100. When the object is
     * instantiated, the progress is zero. The value is updated during the firmware update process until
     * the value of 100 is reached. The 100 value means that the firmware update was completed
     * successfully. If an error occurs during the firmware update, a negative value is returned, and the
     * error message can be retrieved with get_progressMessage.
     *
     * @return int  an integer in the range 0 to 100 (percentage of completion)
     *         or a negative error code in case of failure.
     */
    public function get_progress(): int
    {
        if ($this->_progress >= 0) {
            $this->_processMore(0);
        }
        return $this->_progress;
    }

    /**
     * Returns the last progress message of the firmware update process. If an error occurs during the
     * firmware update process, the error message is returned
     *
     * @return string  a string  with the latest progress message, or the error message.
     */
    public function get_progressMessage(): string
    {
        return $this->_progress_msg;
    }

    /**
     * Starts the firmware update process. This method starts the firmware update process in background. This method
     * returns immediately. You can monitor the progress of the firmware update with the get_progress()
     * and get_progressMessage() methods.
     *
     * @return int  an integer in the range 0 to 100 (percentage of completion),
     *         or a negative error code in case of failure.
     *
     * On failure returns a negative error code.
     */
    public function startUpdate(): int
    {
        // $err                    is a str;
        // $leng                   is a int;
        $err = $this->_settings;
        $leng = strlen($err);
        if (($leng >= 6) && ('error:' == substr($err, 0, 6))) {
            $this->_progress = -1;
            $this->_progress_msg = substr($err,  6, $leng - 6);
        } else {
            $this->_progress = 0;
            $this->_progress_c = 0;
            $this->_processMore(1);
        }
        return $this->_progress;
    }

    //--- (end of generated code: YFirmwareUpdate implementation)
}

