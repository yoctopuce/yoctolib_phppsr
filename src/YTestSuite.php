<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YTestSuite Class: Test suite control interface
 *
 * Missing documentation in the subfunction
 */
class YTestSuite extends YFunction
{
    //--- (end of generated code: YTestSuite declaration)
    protected $_logfile = "";                           // str
    //--- (generated code: YTestSuite attributes)
    protected string $_hub_ip = "";                           // str
    protected string $_hub_serial = "";                           // str
    protected string $_meteo_serial = "";                           // str
    protected string $_pwm_tx_id = "";                           // str
    protected string $_pwm_rx_id = "";                           // str
    protected string $_usb_pwm_tx_id = "";                           // str
    protected string $_usb_pwm_rx_id = "";                           // str
    protected string $_datalogger_id = "";                           // str
    protected string $_datalogger_10s_id = "";                           // str
    protected string $_gh_ip = "";                           // str
    protected string $_gh_subdomain = "";                           // str
    protected string $_gh_hubpass = "";                           // str
    protected string $_gh_user = "";                           // str
    protected string $_gh_pass = "";                           // str
    protected float $_last_timed_avg = 0;                            // float
    protected float $_last_timed_min = 0;                            // float
    protected float $_last_timed_max = 0;                            // float
    protected array $_timed_values = [];                           // YMeasureArr
    protected int $_nb_timed_not = 0;                            // int
    protected float $_timed_min = 0;                            // float
    protected float $_timed_max = 0;                            // float
    protected float $_first_timed_not = 0;                            // float
    protected float $_last_timed_not = 0;                            // float
    protected string $_cbError = "";                           // str
    protected bool $_use_avg_notifications = false;                        // bool

    //--- (end of generated code: YTestSuite attributes)

    protected $_lang;

    function __construct($str_func)
    {
        //--- (generated code: YTestSuite constructor)
        parent::__construct($str_func);
        $this->_className = 'TestSuite';

        //--- (end of generated code: YTestSuite constructor)
        $this->_lang = 'PHP';
    }


    private function test_fail(string $string)
    {
        $this->test_log("ERROR:" . $string);
        $this->SignalEnd(false);
        return $string;
    }

    private function test_log(string $string)
    {
        print($string . "\n");
        file_put_contents($this->_logfile, $this->get_TStamp() . "$string\n", FILE_APPEND);
    }

    private function get_TStamp()
    {
        return date("[Y-m-d H:i:s] ");
    }

    public function Init(string $logfile)
    {
        $this->_logfile = $logfile;
        file_put_contents($this->_logfile, $this->get_TStamp() . "Test Suite PHP\n");

    }


    //--- (generated code: YTestSuite implementation)

    /**
     * Retrieves a function for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the function is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the function is
     * indeed online at a given time. In case of ambiguity when looking for
     * a function by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the function, for instance
     *         MyDevice.testSuite.
     *
     * @return YTestSuite  a YTestSuite object allowing you to drive the function.
     */
    public static function FindTestSuite(string $func): ?YTestSuite
    {
        // $obj                    is a YTestSuite;
        $obj = YFunction::_FindFromCache('TestSuite', $func);
        if ($obj == null) {
            $obj = new YTestSuite($func);
            YFunction::_AddToCache('TestSuite', $func, $obj);
        }
        return $obj;
    }

    /**
     * Test JSON functions.
     *
     * @return an empty string.
     *
     * On failure, throws an exception or returns a string that start with the error message.
     */
    public function test_json(): string
    {
        // $bin_val                is a bin;
        // $val                    is a str;
        // $json                   is a str;
        // $json_api_ref           is a str;
        // $json_files_ref         is a str;
        // $json_extra_ref         is a str;
        // $json_extra_extracted   is a str;
        // $json_api_extracted     is a str;
        $wlanlist = [];         // strArr;
        $extras = [];           // strArr;
        $bin_val = '"abcd1234\'\\"abcd"';
        //may throw an exception
        $val = $this->_json_get_string($bin_val);
        if (!($val == 'abcd1234\'"abcd')) {
            return 'Error in _json_get_string  ("abcd1234\'\\"abcd")';
        }
        $val = '';
        $val = $this->_decode_json_string($val);
        if (!($val == '')) {
            return 'Error in _json_get_string ("")';
        }
        $json = '{"module": {"productName": "YoctoHub-Ethernet","serialNumber": "YHUBETH1-10EEB","logicalName": "","productId": 14,"upTime": -33793,"emptyArr":[]},"network": {"ipConfig": "DHCP:169.254.45.138/16/169.254.0.1","callbackUrl": "http://e.g/i/post.json?apikey=c4a35&json=","callbackMethod": 1,"poeCurrent": 150},"services": {"whitePages": [{"serialNumber": "YHUBETH1-10EEB","logicalName": "[\\"\'\\\\]","productName": "YoctoHub-Ethernet","networkUrl": "/api"},{"serialNumber": "LIGHTMK2-39087","logicalName": "","productName": "Yocto-Light-V2","networkUrl": "/bySerial/LIGHTMK2-39087/api"}],"yellowPages": {"HubPort": [{"baseType": 0,"advertisedValue": "ON"},{"baseType": 0,"advertisedValue": "ON"}]}}}';
        $val = $this->_get_json_path($json, 'module|serialNumber');
        if (!($val == '"YHUBETH1-10EEB"')) {
            return 'Error in _get_json_path("module|serialNumber"';
        }
        $val = $this->_decode_json_string($val);
        if (!($val == 'YHUBETH1-10EEB')) {
            return 'Error in _decode_json_string("\\"YHUBETH1-10EEB\\""';
        }
        $val = $this->_get_json_path($json, 'module|productId');
        if (!($val == '14')) {
            return 'Error in _json_get_path function("module|productId"';
        }
        $val = $this->_get_json_path($json, 'services|whitePages|1|networkUrl');
        $val = $this->_decode_json_string($val);
        if (!($val == '/bySerial/LIGHTMK2-39087/api')) {
            return 'Error in _json_get_path("services|whitePages|1|networkUrl"';
        }
        $val = $this->_get_json_path($json, 'network');
        if (strlen($val) < 143) {
            return 'Error in _json_get_path("network"';
        }
        $json =''."\n".'[{"ssid":"SWEETSHORTWPA","channel":3,"sec":"WPA2","rssi":85}'."\n".',{"ssid":"YOCTOLAND","channel":9,"sec":"WPA2","rssi":66}]';
        $bin_val = $json;
        $wlanlist = $this->_json_get_array($bin_val);
        if (!(sizeof($wlanlist) ==2)) return $this->test_fail('Invalid json array size');
        $json =''."\r".''."\n".'[{"ssid":"SWEETSHORTWPA","channel":3,"sec":"WPA2","rssi":85}'."\r".''."\n".',{"ssid":"YOCTOLAND","channel":9,"sec":"WPA2","rssi":66}]';
        $bin_val = $json;
        $wlanlist = $this->_json_get_array($bin_val);
        if (!(sizeof($wlanlist) ==2)) return $this->test_fail('Invalid json array size (with cr)');
        $json = $wlanlist[0];
        $val = $this->_get_json_path($json, 'ssid');
        $val = $this->_decode_json_string($val);
        if (!($val == 'SWEETSHORTWPA')) return $this->test_fail('Unable to parse json (not SWEETSHORTWPA)');
        $json = $wlanlist[1];
        $val = $this->_get_json_path($json, 'ssid');
        $val = $this->_decode_json_string($val);
        if (!($val == 'YOCTOLAND')) return $this->test_fail('Unable to parse json (not YOCTOLAND)');
        $json_api_ref='';
        $json_extra_ref = '';
        $json_api_ref = $json_api_ref . '{'."\n".'' . '"module":{"productName":"Yocto-Thermistor-C","serialNumber":"THRMSTR1-32DD7","logicalName":"T-SH1-2","productId":77,"productRelease":1,"firmwareRelease":"45886","persistentSettings":1,"luminosity":50,"beacon":0,"upTime":328479,"usbCurrent":101,"rebootCountdown":0,"userVar":0},'."\n".'' . '"temperature1":{"logicalName":"r4c1","advertisedValue":"26.05","unit":"°C","currentValue":1706885,"lowestValue":1676869,"highestValue":1706885,"currentRawValue":1706885,"logFrequency":"1/s","reportFrequency":"OFF","advMode":0,"calibrationParam":"0,","resolution":655,"sensorState":0,"sensorType":12,"signalValue":630199812,"signalUnit":"ohms","command":""},'."\n".'' . '"temperature2":{"logicalName":"r4c2","advertisedValue":"26.19","unit":"°C","currentValue":1716060,"lowestValue":1677983,"highestValue":1716060,"currentRawValue":1716060,"logFrequency":"1/s","reportFrequency":"OFF","advMode":0,"calibrationParam":"0,","resolution":655,"sensorState":0,"sensorType":12,"signalValue":626923929,"signalUnit":"ohms","command":""},'."\n".'' . '"temperature3":{"logicalName":"r4c3","advertisedValue":"26.27","unit":"°C","currentValue":1721827,"lowestValue":1687552,"highestValue":1721827,"currentRawValue":1721827,"logFrequency":"1/s","reportFrequency":"OFF","advMode":0,"calibrationParam":"0,","resolution":655,"sensorState":0,"sensorType":12,"signalValue":624865443,"signalUnit":"ohms","command":""},'."\n".'' . '"temperature4":{"logicalName":"r4c4","advertisedValue":"26.16","unit":"°C","currentValue":1714356,"lowestValue":1680867,"highestValue":1714421,"currentRawValue":1714356,"logFrequency":"1/s","reportFrequency":"OFF","advMode":0,"calibrationParam":"0,","resolution":655,"sensorState":0,"sensorType":12,"signalValue":627526533,"signalUnit":"ohms","command":""},'."\n".'' . '"temperature5":{"logicalName":"r4c5","advertisedValue":"26.23","unit":"°C","currentValue":1719140,"lowestValue":1689387,"highestValue":1719140,"currentRawValue":1719140,"logFrequency":"1/s","reportFrequency":"OFF","advMode":0,"calibrationParam":"0,","resolution":655,"sensorState":0,"sensorType":12,"signalValue":625818861,"signalUnit":"ohms","command":""},'."\n".'' . '"temperature6":{"logicalName":"r4c6","advertisedValue":"26.02","unit":"°C","currentValue":1705312,"lowestValue":1679032,"highestValue":1705508,"currentRawValue":1705312,"logFrequency":"1/s","reportFrequency":"OFF","advMode":0,"calibrationParam":"0,","resolution":655,"sensorState":0,"sensorType":12,"signalValue":630774824,"signalUnit":"ohms","command":""},'."\n".'' . '"dataLogger":{"logicalName":"","advertisedValue":"OFF","currentRunIndex":0,"timeUTC":1634808226,"recording":0,"autoStart":0,"beaconDriven":0,"usage":0,"clearHistory":0}}';
        $json_extra_ref = $json_extra_ref . '[{"fid":"temperature6", "json":[1052317,100000,10000000,25000]}'."\n".'' . ',{"fid":"temperature5", "json":[1052317,100000,10000000,25000]}'."\n".'' . ',{"fid":"temperature4", "json":[1052317,100000,10000000,25000]}'."\n".'' . ',{"fid":"temperature3", "json":[1052317,100000,10000000,25000]}'."\n".'' . ',{"fid":"temperature2", "json":[1052317,100000,10000000,25000]}'."\n".'' . ',{"fid":"temperature1", "json":[1052317,100000,10000000,25000]}'."\n".'' . ']';
        $json_files_ref = '[]';
        $json = '{ "api":' . $json_api_ref . ', "extras":' . $json_extra_ref . ','."\n".'"files":' . $json_files_ref . '}'."\n".'';
        $json_api_extracted = $this->_get_json_path($json, 'api');
        $val = $this->_get_json_path($json_api_extracted, 'module|logicalName');
        $val = $this->_decode_json_string($val);
        if (!($val == 'T-SH1-2')) return $this->test_fail('Unable to parse json (not T-SH1-2)');
        $val = $this->_get_json_path($json_api_extracted, 'temperature4|unit');
        $val = $this->_decode_json_string($val);
        if (!($val == '°C')) return $this->test_fail('Unable to parse json (not °C)');
        $val = $this->_get_json_path($json_api_extracted, 'temperature4');
        $val = $this->_get_json_path($val, 'logFrequency');
        $val = $this->_decode_json_string($val);
        if (!($val == '1/s')) return $this->test_fail('Unable to parse json (not 1/s)');
        $val = $this->_get_json_path($json, 'file');
        if (!($val == '')) return $this->test_fail('_get_json_path of "file" (without \'s\') should fail');
        $val = $this->_get_json_path($json, 'files');
        if (!($val == $json_files_ref)) return $this->test_fail('_get_json_path failed to get "files"');
        $extras = $this->_json_get_array($val);
        if (!(sizeof($extras) ==0)) return $this->test_fail('Error with _json_get_array  (invalid array size on empty array)');
        $json_extra_extracted = $this->_get_json_path($json, 'extras');
        $extras = $this->_json_get_array($json_extra_extracted);
        if (!(sizeof($extras) ==6)) return $this->test_fail('Error with _json_get_array  (invalid array size)');
        foreach ( $extras as $each) {
            $val = $this->_get_json_path($each, 'json');
            $wlanlist = $this->_json_get_array($val);
            if (!(sizeof($wlanlist) ==4)) return $this->test_fail('Error with _json_get_array  (invalid array size)');
            if (!($wlanlist[0] == '1052317')) return $this->test_fail('Error with _json_get_array  (invalid value at ofs 0)');
            if (!($wlanlist[1] == '100000')) return $this->test_fail('Error with _json_get_array  (invalid value at ofs 1)');
            if (!($wlanlist[2] == '10000000')) return $this->test_fail('Error with _json_get_array  (invalid value at ofs 2)');
            if (!($wlanlist[3] == '25000')) return $this->test_fail('Error with _json_get_array  (invalid value at ofs 3)');
        }
        return '';
    }

    /**
     * Test STR2INT yc functions.
     *
     * @return an empty string.
     *
     * On failure, throws an exception or returns a string that start with the error message.
     */
    public function test_atoi(): string
    {
        // $val                    is a str;
        // $res                    is a int;
        $val = '32';
        $res = intVal($val);
        if ($res != 32) {
            return $val;
        }
        $val = '+32';
        $res = intVal($val);
        if ($res != 32) {
            return $val;
        }
        $val = '-32';
        $res = intVal($val);
        if ($res != -32) {
            return $val;
        }
        $val = '32.54';
        $res = intVal($val);
        if ($res != 32) {
            return $val;
        }
        $val = 'asasdf';
        $res = intVal($val);
        if ($res != 0) {
            return $val;
        }
        $val = '   32';
        $res = intVal($val);
        if ($res != 32) {
            return $val;
        }
        $val = '   -32pouet';
        $res = intVal($val);
        if ($res != -32) {
            return $val;
        }
        $val = '-32.8';
        $res = intVal($val);
        if ($res != -32) {
            return $val;
        }
        $val = '';
        $res = intVal($val);
        if ($res != 0) {
            return 'empty';
        }
        $val = sprintf('%04x%04X', 0xfe, 0xef);
        if (!($val == '00fe00EF')) {
            return 'Error in YPRINTF of %x or %X';
        }
        $val = '00';
        $res = hexdec($val);
        if (!($res == 0)) return $this->test_fail('error in HEX2INT("00")');
        $val = '0';
        $res = hexdec($val);
        if (!($res == 0)) return $this->test_fail('error in HEX2INT("0")');
        $val = '08';
        $res = hexdec($val);
        if (!($res == 8)) return $this->test_fail('error in HEX2INT("08")');
        $val = '8';
        $res = hexdec($val);
        if (!($res == 8)) return $this->test_fail('error in HEX2INT("8")');
        $val = '1234abcd';
        $res = hexdec($val);
        if (!($res == 0x1234abcd)) return $this->test_fail('error in HEX2INT("1234abcd")');
        $val = '1234ABCD';
        $res = hexdec($val);
        if (!($res == 0x1234abcd)) return $this->test_fail('error in HEX2INT("1234ABCD")');
        //fl = 1544000159.5;
        //val = YPRINTF("%F",fl);
        //T_ASSERT(STR_EQUAL(val, "1544000159.5"), "Error in YPRINTF of %F (1544000159.5)")
        //fl = -2345.234;
        //val = YPRINTF("%F",fl);
        //T_ASSERT(STR_EQUAL(val, "-2345.234"), "Error in YPRINTF of %F (-2345.234)")
        return '';
    }

    /**
     * Test conversion hsl to rgb in yc.
     *
     * @return an empty string.
     *
     * On failure, throws an exception or returns a string that start with the error message.
     */
    public function test_hsl_rgb(): string
    {
        // $val                    is a int;
        // $res                    is a int;
        // $cluster                is a YColorLedCluster;
        $cluster = YColorLedCluster::FindColorLedCluster('dummy');
        $val = 0xff0000;
        $res = $cluster->hsl2rgb($val);
        if ($res != 0) {
            return 'bad conversion of hsl value 0xff0000';
        }
        $val = 0xff00;
        $res = $cluster->hsl2rgb($val);
        if ($res != 0) {
            return 'bad conversion of hsl value 0xff00';
        }
        $val = 0xff;
        $res = $cluster->hsl2rgb($val);
        if ($res != 0xffffff) {
            return 'bad conversion of hsl value 0xff';
        }
        $val = 0x00FF80;
        $res = $cluster->hsl2rgb($val);
        if ($res != 0xff0101) {
            return 'bad conversion of hsl value 00FF80 (red)';
        }
        $val = 0x55FF80;
        $res = $cluster->hsl2rgb($val);
        if ($res != 0x01ff01) {
            return 'bad conversion of hsl value 55FF80 (green)';
        }
        $val = 0xAAFF80;
        $res = $cluster->hsl2rgb($val);
        if ($res != 0x0101ff) {
            return 'bad conversion of hsl value AAFF80 (blue)';
        }
        return '';
    }

    /**
     * Test save and restore of settings.
     *
     * @return an empty string.
     *
     * On failure, throws an exception or returns a string that start with the error message.
     */
    public function TestSaveSettings(): string
    {
        // $m                      is a YModule;
        // $f                      is a YFiles;
        // $allSettings            is a bin;
        // $tmp                    is a str;
        // $hub_serial             is a str;
        $hub_serial = $this->_hub_serial;

        $m = YModule::FindModule($hub_serial . '.module');
        $f = YFiles::FindFiles($hub_serial . '.files');
        $this->test_log('  Prepare hub for test.');
        $m->set_logicalName('ok');
        $this->test_log('   - format fs');
        $f->format_fs();
        $this->test_log('   - upload test file');
        $f->upload('test_file.txt','This Is a Test{"task1":{"interval":500,"script":[{"writeHex":"61"},{"expect":"($1:BYTE)"}]}}');
        $this->test_log('   - upload done');
        $tmp = $m->get_logicalName();
        if (!($tmp == 'ok')) {
            return 'Error:  YModule.set_logicalname(ok)';
        }
        $this->test_log('   - get file count');
        if ($f->get_filesCount() != 1) {
            return 'Error: YFiles.upload()';
        }
        $this->test_log('  Get all settings.');
        $allSettings = $m->get_allSettings();
        $tmp = $allSettings;
        $this->test_log('  Set invalid settings.');
        $m->set_logicalName('error');
        $this->test_log('   - format fs');
        $f->format_fs();
        $tmp = $m->get_logicalName();
        if (!($tmp == 'error')) {
            return 'Error: YModule.set_logicalname(error)';
        }
        $this->test_log('   - get file count');
        if ($f->get_filesCount() != 0) {
            return 'Error: YFiles.format_fs()';
        }
        $this->test_log('  Restore all settings and files.');
        $m->set_allSettingsAndFiles($allSettings);
        $this->test_log('   - verify settings and files.');
        $tmp = $m->get_logicalName();
        if (!($tmp == 'ok')) {
            return 'Error: logical name not restored';
        }
        if ($f->get_filesCount() != 1) {
            return 'Error: files not restored';
        }
        $this->test_log('  Cleanup m hub.');
        $m->set_logicalName('error');
        $this->test_log('  Restore settings only.');
        $m->set_allSettings($allSettings);
        $this->test_log('   - verify settings only.');
        $tmp = $m->get_logicalName();
        if (!($tmp == 'ok')) {
            return 'Error: settings not restored';
        }
        $this->test_log('  TestSaveSettings success.');
        return '';
    }

    /**
     * Test Run perf test on available devices.
     *
     * @return an empty string.
     *
     * On failure, throws an exception or returns a string that start with the error message.
     */
    public function RunPerfTest(): string
    {
        // $m                      is a YModule;
        // $relay1                 is a YRelay;
        // $input1                 is a YAnButton;
        // $i                      is a int;
        // $sum1                   is a int;
        // $cnt1                   is a int;
        // $reftime                is a u64;
        // $pulse_counter          is a long;
        // $res                    is a int;
        // $errmsg                 is a str;

        $this->test_log('  Using lib ' . YAPI::GetAPIVersion());
        $input1 = YAnButton::FindAnButton('input1');
        if (!($input1->isOnline())) {
            return 'No AnButton named \'input1\' found, check cable!';
        }
        $m = $input1->get_module();
        $this->test_log('  Use Knob ' . $m->get_serialNumber() . ' (' . $m->get_firmwareRelease() . ')');
        $relay1 = YRelay::FindRelay('relay1');
        if (!($input1->isOnline()) || !($relay1->isOnline())) {
            return 'No Relay named \'relay1\' found, check cable!';
        }
        $m = $relay1->get_module();
        $this->test_log('  Use Relay ' . $m->get_serialNumber() . ' (' . $m->get_firmwareRelease() . ')');
        $reftime = YAPI::GetTickCount();
        $i = 0;
        while ($i < 64) {
            $relay1->set_state(YRelay::STATE_B);
            $relay1->set_state(YRelay::STATE_A);
            $i = $i + 1;
        }
        $reftime = YAPI::GetTickCount() - $reftime;
        $this->test_log(sprintf('   - Average \'set\'     time: %d / 128 = %Fms', $reftime, $reftime / 128.0));
        $res = YAPI::Sleep(3000);
        if ($res < 0) {
            return 'error during Sleep:';
        }
        $reftime = YAPI::GetTickCount();
        $i = 0;
        while ($i < 32) {
            if ((($i) & (1)) == 1) {
                $relay1->set_state(YRelay::STATE_A);
            } else {
                $relay1->set_state(YRelay::STATE_B);
            }
            $relay1->get_state();
            $i = $i + 1;
        }
        $reftime = YAPI::GetTickCount() - $reftime;
        $this->test_log(sprintf('   - Average \'set/get\' time: %d / 32 = %Fms', $reftime, $reftime / 32));
        $input1->set_pulseCounter(0);
        $res = YAPI::Sleep(3000);
        if ($res < 0) {
            return 'error during Sleep:';
        }
        $sum1 = 0;
        $cnt1 = 0;
        $i = 0;
        while ($i < 32) {
            $reftime = YAPI::GetTickCount();
            $relay1->toggle();
            $reftime = YAPI::GetTickCount() - $reftime;
            $cnt1 = $cnt1 + 1;
            $sum1 = $sum1 + $reftime;
            $res = YAPI::Sleep(50);
            if ($res < 0) {
                return 'error during Sleep:';
            }
            $i = $i + 1;
        }
        $this->test_log(sprintf('   - Average command time:   %d / %d = %Fms', $sum1, $cnt1, $sum1 / $cnt1));
        $pulse_counter = $input1->get_pulseCounter();
        $this->test_log(sprintf('   - puse counter = %u', $pulse_counter));
        return '';
    }

    /**
     * update firmware of some modules
     *
     * @param allserials : an array of string with the serials of modules to update
     *
     * @return an empty string.
     *
     * On failure, throws an exception or returns a string that start with the error message.
     */
    public function upgradeSerialList(array $allserials): string
    {
        // $m                      is a YModule;
        // $current                is a str;
        // $product                is a str;
        // $newfirm                is a str;
        // $update                 is a YFirmwareUpdate;
        // $status                 is a int;
        // $newstatus              is a int;
        // $res                    is a int;
        // $errmsg                 is a str;
        //may throw an exception
        foreach ( $allserials as $each) {
            $m = YModule::FindModule($each);
            $product = $m->get_productName();
            $current = $m->get_firmwareRelease();
            // check if a new firmware is available on yoctopuce.com
            $newfirm = $m->checkFirmware('www.yoctopuce.com', true);
            if ($newfirm == '') {
                $this->test_log('  - ' . $product . ' ' . $each . '(rev=' . $current . ') is up to date');
            } else {
                $this->test_log('  - ' . $product . ' ' . $each . '(rev=' . $current . ') need be updated with firmware :');
                $this->test_log('      ' . $newfirm);
                // execute the firmware upgrade
                $update = $m->updateFirmware($newfirm);
                $status = $update->startUpdate();
                while (($status < 100) && ($status >=0)) {
                    $newstatus =  $update->get_progress();
                    if ($newstatus != $status) {
                        $this->test_log(sprintf('    %d %s', $newstatus, $update->get_progressMessage()));
                    }
                    $res = YAPI::Sleep(1000);
                    if ($res < 0) {
                        return 'error during Sleep:';
                    }
                    $status = $newstatus;
                }
                if ($status < 0) {
                    return $update->get_progressMessage();
                }
                if ($m->isOnline()) {
                    $this->test_log('Firmware Updated Successfully!');
                } else {
                    return $status . ' Firmware Update failed: module ' . $each . 'is not online';
                }
            }
        }
        return '';
    }

    /**
     * Test the firmware update on all usable module.
     *
     * @return an empty string.
     *
     * On failure, throws an exception or returns a string that start with the error message.
     */
    public function TestFwUpdate(): string
    {
        $hubs = [];             // strArr;
        $shields = [];          // strArr;
        $devices = [];          // strArr;
        // $m                      is a YModule;
        // $tmp                    is a str;
        // $serial                 is a str;
        // $product                is a str;
        //may throw an exception
        $m = YModule::FirstModule();
        while (!($m == null)) {
            $serial = $m->get_serialNumber();
            $product = $m->get_productName();
            if ($product == 'YoctoHub-Shield') {
                $shields[] = $serial;
            } else {
                $tmp = substr($product,  0, 8);
                if ($tmp == 'YoctoHub') {
                    $hubs[] = $serial;
                } else {
                    if (!($product == 'VirtualHub')) {
                        $devices[] = $serial;
                    }
                }
            }
            $m = $m->nextModule();
        }
        // first upgrades all Hubs->.
        $this->upgradeSerialList($hubs);
        // ->. then all shield->
        $this->upgradeSerialList($shields);
        // ->. and finaly all devices
        $this->upgradeSerialList($devices);
        return '';
    }

    /**
     * Test yc functions that convert binary object.
     *
     * @return an empty string.
     *
     * On failure, throws an exception or returns a string that start with the error message.
     */
    public function test_str_bin_hex(): string
    {
        // $org_str                is a str;
        // $bindata                is a bin;
        // $hex_str                is a str;
        // $final_str              is a str;
        $org_str = 'This Is a Test 2+2=4';
        $bindata = $org_str;
        $hex_str = YAPI::_bytesToHexStr($bindata);
        if (!($hex_str == '546869732049732061205465737420322B323D34')) {
            return 'Error: in string to bin to hex string';
        }
        $bindata = YAPI::_hexStrToBin($hex_str);
        $final_str = $bindata;
        if (!($final_str == $org_str)) {
            return 'Error: in hex string to bin to string';
        }
        return '';
    }

    public function sensorTimedReportCallBack(YSensor $sensor, YMeasure $measure): void
    {
        // $stop_                  is a float;
        // $start                  is a float;
        // $dur                    is a float;
        // $ref_dur                is a float;
        // $val                    is a str;
        // $timestr                is a str;
        // $hwid                   is a str;

        $hwid = $sensor->get_hardwareId();
        $start = $measure->get_startTimeUTC();
        $stop_ = $measure->get_endTimeUTC();
        $dur = $stop_ - $start;
        $this->_last_timed_max = $measure->get_maxValue();
        $this->_last_timed_avg = $measure->get_averageValue();
        $this->_last_timed_min = $measure->get_minValue();
        if ($this->_last_timed_min < $this->_timed_min) {
            $this->_timed_min = $this->_last_timed_min;
        }
        if ($this->_last_timed_max > $this->_timed_max) {
            $this->_timed_max = $this->_last_timed_max;
        }
        if ($this->_first_timed_not > $start) {
            $this->_first_timed_not = $start;
        }
        if ($this->_last_timed_not < $stop_) {
            $this->_last_timed_not = $stop_;
        }
        $val = sprintf('%F < %F < %F', $this->_last_timed_min, $this->_last_timed_avg, $this->_last_timed_max);
        $timestr = sprintf('%s + %Fs', _ytimeFloat2str($start), $dur);
        $this->test_log($hwid . ' ' . $timestr . ' => ' . $val);
        $dur = round($dur *1000);
        if ($this->_use_avg_notifications) {
            $ref_dur = 3000;
        } else {
            $ref_dur = 250;
        }
        if ($dur > $ref_dur) {
            $this->_cbError = sprintf('Invalid duration in timed notification (get %F expected %F)', $dur, $ref_dur);
        }
        $this->_timed_values[] = $measure;
        $this->_nb_timed_not = $this->_nb_timed_not + 1;
    }

    public function DumpDatset(YDataSet $dataset): void
    {
        // $i                      is a int;
        // $size                   is a int;
        // $line                   is a str;
        $details = [];          // YMeasureArr;
        // $m_data                 is a YMeasure;
        //may throw an exception
        $details = $dataset->get_measures();
        $size = sizeof($details);
        $i = 0;
        while ($i < $size) {
            $m_data = $details[$i];
            $line = sprintf('from %s to %s : min=%F avg=%F max=%F',
            _ytimeFloat2str($m_data->get_startTimeUTC()), _ytimeFloat2str($m_data->get_endTimeUTC()), $m_data->get_minValue(),
            $m_data->get_averageValue(),  $m_data->get_maxValue());
            $this->test_log($line);
            $i = $i + 1;
        }
    }

    public function ValidateDataLoggerRes(YSensor $sensor, bool $useAvg, int $notifsize): string
    {
        // $i                      is a int;
        // $size                   is a int;
        // $progress               is a int;
        // $line                   is a str;
        // $summary                is a YMeasure;
        // $m_data                 is a YMeasure;
        // $m_not                  is a YMeasure;
        // $dataset                is a YDataSet;
        $details = [];          // YMeasureArr;
        $preview = [];          // YMeasureArr;

        $this->test_log(sprintf('loading summary %s -> %s', _ytimeFloat2str($this->_first_timed_not), _ytimeFloat2str($this->_last_timed_not)));
        $this->test_log(sprintf('   get_recordedData(%F,%F)->.', $this->_first_timed_not, $this->_last_timed_not));
        $dataset = $sensor->get_recordedData($this->_first_timed_not, $this->_last_timed_not);
        $dataset->loadMore();
        $summary = $dataset->get_summary();
        $line = sprintf('Summary: %s to %s => min=%F avg=%F max=%F',
                      _ytimeFloat2str($summary->get_startTimeUTC()), _ytimeFloat2str($summary->get_endTimeUTC()), $summary->get_minValue(),
                      $summary->get_averageValue(),  $summary->get_maxValue());
        $this->test_log($line);
        if (!($summary->get_startTimeUTC() == $this->_first_timed_not)) return $this->test_fail('Invalid start time in summary');
        if (!($summary->get_endTimeUTC() == $this->_last_timed_not)) return $this->test_fail('Invalid end time in summary');
        if (!($summary->get_minValue() == $this->_timed_min)) return $this->test_fail('Invalid min value in summary');
        if (!($summary->get_maxValue() == $this->_timed_max)) return $this->test_fail('Invalid max value in summary');
        $preview = $dataset->get_preview();
        $size = sizeof($preview);
        if (!(($size > 0) && ($size <= 2))) return $this->test_fail('Invalid preview size');
        $m_data = $preview[0];
        $line = sprintf('Preview: %s to %s => min=%F avg=%F max=%F',
                      _ytimeFloat2str($m_data->get_startTimeUTC()), _ytimeFloat2str($m_data->get_endTimeUTC()), $m_data->get_minValue(),
                      $m_data->get_averageValue(),  $m_data->get_maxValue());
        $this->test_log($line);
        if (!($m_data->get_startTimeUTC() == $this->_first_timed_not)) return $this->test_fail('Invalid start time in preview');
        $m_data = $preview[($size -1)];
        $line = sprintf('Preview: %s to %s => min=%F avg=%F max=%F',
                      _ytimeFloat2str($m_data->get_startTimeUTC()), _ytimeFloat2str($m_data->get_endTimeUTC()), $m_data->get_minValue(),
                      $m_data->get_averageValue(),  $m_data->get_maxValue());
        $this->test_log($line);
        if (!($m_data->get_endTimeUTC() == $this->_last_timed_not)) return $this->test_fail('Invalid end time in preview');
        $progress = 0;
        while ($progress < 100) {
            $progress = $dataset->loadMore();
            if ($progress < 0) {
                return 'loadMore failed:' . $progress;
            }
        }
        $this->DumpDatset($dataset);
        $details = $dataset->get_measures();
        $size = sizeof($details);
        if (!($size == $notifsize)) return $this->test_fail(sprintf('Invalid number of measure in datalogger (%d notifications vs %d in datalogger)', $notifsize, $size));
        $i = 0;
        while ($i < $size) {
            $m_not = $this->_timed_values[$i];
            $m_data = $details[$i];
            if (!($m_not->get_startTimeUTC() == $m_data->get_startTimeUTC())) return $this->test_fail('invalid start time in measure');
            if (!($m_not->get_endTimeUTC() == $m_data->get_endTimeUTC())) return $this->test_fail('invalid stop time in measure');
            if (!($m_not->get_minValue() == $m_data->get_minValue())) return $this->test_fail('invalid min value in measure');
            if (!($m_not->get_averageValue() == $m_data->get_averageValue())) return $this->test_fail('invalid avg value in measure');
            if (!($m_not->get_maxValue() == $m_data->get_maxValue())) return $this->test_fail('invalid max value in measure');
            $i = $i + 1;
        }
        return '';
    }

    public function TestTimedCB(bool $useAvg, string $pwm_rx_id, string $pwm_tx_id): string
    {
        global $testRef;
        // $pwmin                  is a YPwmInput;
        // $sensor                 is a YSensor;
        // $pwmOut                 is a YPwmOutput;
        // $ires                   is a int;
        // $size                   is a int;
        // $move_duration          is a int;
        // $res                    is a str;
        // $dataLogger             is a YDataLogger;
        // $errmsg                 is a str;
        if ($useAvg) {
            $this->test_log('  - test timed notifications (avg)');
        } else {
            $this->test_log('  - test timed notifications (immediat)');
        }

        $testRef = $this;
        $this->_last_timed_max = YAPI::MIN_DOUBLE;
        $this->_last_timed_avg = 0;
        $this->_last_timed_min = YAPI::MAX_DOUBLE;
        $this->_timed_min = $this->_last_timed_min;
        $this->_timed_max = $this->_last_timed_max;
        $this->_first_timed_not = YAPI::MAX_DOUBLE;
        $this->_last_timed_not = YAPI::MIN_DOUBLE;
        $this->_cbError = '';
        $this->_nb_timed_not =0;
        while (sizeof($this->_timed_values) > 0) {
            array_pop($this->_timed_values);
        };
        $pwmOut = YPwmOutput::FindPwmOutput($pwm_tx_id);
        if (!($pwmOut->isOnline())) return $this->test_fail($pwm_tx_id . ' is not online');
        $pwmOut->set_frequency(10000);
        $pwmOut->set_dutyCycle(50);
        $pwmOut->set_enabled(YPwmOutput::ENABLED_TRUE);
        $pwmin = YPwmInput::FindPwmInput($pwm_rx_id);
        if (!($pwmin->isOnline())) return $this->test_fail($pwm_rx_id . ' is not online');
        if (!($pwmin->isSensorReady())) return $this->test_fail($pwm_rx_id . ' sensor is not ready');
        $pwmin->set_reportFrequency('OFF');
        $pwmin->stopDataLogger();
        $pwmin->set_pwmReportMode(YPwmInput::PWMREPORTMODE_PWM_FREQUENCY);
        $sensor = $pwmin;
        $dataLogger = $sensor->get_dataLogger();
        if (!(!($dataLogger == null))) return $this->test_fail('get_dataLogger returned null');
        if (!($dataLogger->isOnline())) return $this->test_fail('dataLogger is not online');
        $dataLogger->forgetAllDataStreams();
        // wait 2 second to get everybody ready
        $ires = YAPI::Sleep(2000);
        if (!($ires == 0)) return $this->test_fail('error during Sleep:');
        if ($useAvg) {
            $move_duration = 6000;
            $sensor->set_logFrequency('30/m');
        } else {
            $move_duration = 500;
            $sensor->set_logFrequency('4/s');
        }
        $sensor->startDataLogger();
        if ($useAvg) {
            $sensor->set_reportFrequency('30/m');
        } else {
            $sensor->set_reportFrequency('4/s');
        }
        $this->_use_avg_notifications = $useAvg;
        $sensor->registerTimedReportCallback('timedCbHop');
        if ($useAvg) {
            $ires = YAPI::Sleep(8000);
        } else {
            $ires = YAPI::Sleep(1000);
        }
        if (!($ires == 0)) return $this->test_fail('error during Sleep:');
        if (!(($this->_last_timed_avg  > 9800) && ($this->_last_timed_avg  < 10200))) return $this->test_fail('No timed notification received');
        if (!(($this->_timed_min  > 9800) && ($this->_timed_min  < 10200))) return $this->test_fail('Invalid min notification received (expected 10000)');
        if (!(($this->_timed_max  > 9800) && ($this->_timed_max  < 10200))) return $this->test_fail('Invalid max notification received (expected 10000)');
        $pwmOut->frequencyMove(20000, $move_duration);
        if ($useAvg) {
            $ires = YAPI::Sleep(8000);
        } else {
            $ires = YAPI::Sleep(1000);
        }
        if (!($ires == 0)) return $this->test_fail('error during Sleep:');
        if ($useAvg) {
            if (!($this->_last_timed_min < $this->_last_timed_avg)) return $this->test_fail('Invalid min value');
            if (!($this->_last_timed_max > $this->_last_timed_avg)) return $this->test_fail('Invalid max value');
        }
        if (!(($this->_timed_min  > 9800) && ($this->_timed_min  < 10200))) return $this->test_fail('Invalid min notification received (moving from 10000)');
        if (!(($this->_timed_max  > 9800) && ($this->_timed_max  < 20400))) return $this->test_fail('Invalid max notification received (moving to 20000)');
        $sensor->registerTimedReportCallback(null);
        $sensor->stopDataLogger();
        $sensor->set_reportFrequency('OFF');
        $sensor->set_logFrequency('OFF');
        if (!($this->_cbError == '')) return $this->test_fail($this->_cbError);
        $size = sizeof($this->_timed_values);
        //size = $this->_nb_timed_not;
        $this->test_log(sprintf('%d notifications received',$size));
        if (!(($size >= 6) && ($size <=9))) return $this->test_fail(sprintf('Missing notifications (expected 8 or 9 received %d)', $size));
        $res = $this->ValidateDataLoggerRes($sensor, $useAvg, $size);
        if (!($res == '')) return $this->test_fail($res);
        $this->test_log('      done.');
        return '';
    }

    public function RunDeviceTest(): string
    {
        // $temp                   is a YTemperature;
        // $hport                  is a YHubPort;
        // $min                    is a float;
        // $max                    is a float;
        // $res                    is a int;
        // $ison                   is a bool;
        // $hwid                   is a str;
        // $tmp                    is a str;
        // $errmsg                 is a str;
        //may throw an exception
        $this->test_log('  - test basic device access->.');
        $hwid = $this->_meteo_serial . '.temperature';
        $temp = YTemperature::FindTemperature($hwid);
        $this->test_log(' - test device isOnline.');
        try {
            $ison = $temp->isOnline();
            if (!($ison)) return $this->test_fail('isOnline returned false instead of true');
            $hport = YHubPort::FindHubPort('YHUBSHL1-30369.hubPort1');
            $hport->set_enabled(YHubPort::ENABLED_FALSE);
            $res = YAPI::Sleep(500);
            if (!($res == YAPI::SUCCESS )) return $this->test_fail('error during Sleep:');
            $ison = $temp->isOnline();
            if (!(!($ison))) return $this->test_fail('isOnline returned true instead of false');
            $hport->set_enabled(YHubPort::ENABLED_TRUE);
            $res = YAPI::Sleep(1000);
            if (!($res == YAPI::SUCCESS )) return $this->test_fail('error during Sleep:');
            $ison = $temp->isOnline();
            if (!($ison)) return $this->test_fail('isOnline returned false instead of true');
        } catch (Exception $ex) {
            return ' isOnline throw an exception.';
        }
        $tmp = $temp->get_serialNumber();
        if (!($tmp == $this->_meteo_serial )) return $this->test_fail('get_serialNumber on functions is not working');
        $temp->set_lowestValue(100);
        $temp->set_highestValue(0);
        $res = YAPI::Sleep(2500);
        if ($res < 0) {
            return 'error during Sleep:';
        }
        if (!($res == YAPI::SUCCESS )) return $this->test_fail('error during Sleep:');
        $min = $temp->get_lowestValue();
        $max = $temp->get_highestValue();
        if ($min < 15) {
            return 'Error: min value of ambiant temperature too low';
        }
        if ($min > 40) {
            return 'Error: min value of ambiant temperature too high';
        }
        if ($max < 15) {
            return 'Error: max value of ambiant temperature too low';
        }
        if ($max > 40) {
            return 'Error: max value of ambiant temperature too high';
        }
        $temp->set_lowestValue(-40000);
        $temp->set_highestValue(40000);
        $min = $temp->get_lowestValue();
        $max = $temp->get_highestValue();
        if ($min != -40000) {
            return 'Error: min value value overflow';
        }
        if ($max != 40000) {
            return 'Error: min value value overflow';
        }
        return '';
    }

    public function RunDataLoggerTest(): string
    {
        // $sensor                 is a YSensor;
        // $size                   is a int;
        // $progress               is a int;
        // $ref_val                is a float;
        // $ref_val_end            is a float;
        // $line                   is a str;
        // $summary                is a YMeasure;
        // $m_data                 is a YMeasure;
        // $dataset                is a YDataSet;
        $preview = [];          // YMeasureArr;
        $details = [];          // YMeasureArr;
        //may throw an exception
        $this->test_log('  - test large datalogger access->.');
        $sensor = YSensor::FindSensor($this->_datalogger_id);

        $dataset = $sensor->get_recordedData(0, 0);
        $dataset->loadMore();
        $summary = $dataset->get_summary();
        $line = sprintf('Summary: %s to %s => min=%F avg=%F max=%F',
                      _ytimeFloat2str($summary->get_startTimeUTC()), _ytimeFloat2str($summary->get_endTimeUTC()), $summary->get_minValue(),
                      $summary->get_averageValue(),  $summary->get_maxValue());
        $this->test_log($line);
        $ref_val = 1543500325.0;
        if (!($summary->get_startTimeUTC() == $ref_val)) return $this->test_fail('Invalid start time in summary');
        $ref_val = 1543929720.0;
        if (!($summary->get_endTimeUTC() == $ref_val)) return $this->test_fail('Invalid end time in summary');
        $ref_val = 12.880000000000001;
        if (!($summary->get_minValue() == $ref_val)) return $this->test_fail('Invalid min value in summary');
        $ref_val = 15.785713915298185;
        if (!($summary->get_averageValue() == $ref_val)) return $this->test_fail('Invalid get_averageValue value in summary');
        $ref_val = 20.01;
        if (!($summary->get_maxValue() == $ref_val)) return $this->test_fail('Invalid max value in summary');
        $preview = $dataset->get_preview();
        $size = sizeof($preview);
        if (!($size == 13)) return $this->test_fail('Invalid preview size');
        $m_data = $preview[0];
        $line = sprintf('Preview 0 : %s to %s => min=%F avg=%F max=%F',
                      _ytimeFloat2str($m_data->get_startTimeUTC()), _ytimeFloat2str($m_data->get_endTimeUTC()), $m_data->get_minValue(),
                      $m_data->get_averageValue(),  $m_data->get_maxValue());
        $this->test_log($line);
        $ref_val = 1543500325.0;
        if (!($m_data->get_startTimeUTC() == $ref_val)) return $this->test_fail('Invalid start time in preview');
        $ref_val = 1543500359.0;
        if (!($m_data->get_endTimeUTC() == $ref_val)) return $this->test_fail('Invalid end time in preview');
        $ref_val = 16.114;
        if (!($m_data->get_minValue() == $ref_val)) return $this->test_fail('Invalid min value in preview');
        $ref_val = 17.416;
        if (!($m_data->get_averageValue() == $ref_val)) return $this->test_fail('Invalid get_averageValue value in preview');
        $ref_val = 19.397;
        if (!($m_data->get_maxValue() == $ref_val)) return $this->test_fail('Invalid max value in preview');
        $m_data = $preview[7];
        $line = sprintf('Preview 7 : %s to %s => min=%F avg=%F max=%F',
                      _ytimeFloat2str($m_data->get_startTimeUTC()), _ytimeFloat2str($m_data->get_endTimeUTC()), $m_data->get_minValue(),
                      $m_data->get_averageValue(),  $m_data->get_maxValue());
        $this->test_log($line);
        $ref_val = 1543500719.0;
        if (!($m_data->get_startTimeUTC() == $ref_val)) return $this->test_fail('Invalid start time in preview');
        $ref_val = 1543500779.0;
        if (!($m_data->get_endTimeUTC() == $ref_val)) return $this->test_fail('Invalid end time in preview');
        $ref_val = 16.1;
        if (!($m_data->get_minValue() == $ref_val)) return $this->test_fail('Invalid min value in preview');
        $ref_val = 17.075;
        if (!($m_data->get_averageValue() == $ref_val)) return $this->test_fail('Invalid get_averageValue value in preview');
        $ref_val = 19.55;
        if (!($m_data->get_maxValue() == $ref_val)) return $this->test_fail('Invalid max value in preview');
        $m_data = $preview[11];
        $line = sprintf('Preview 11 : %s to %s => min=%F avg=%F max=%F',
                      _ytimeFloat2str($m_data->get_startTimeUTC()), _ytimeFloat2str($m_data->get_endTimeUTC()), $m_data->get_minValue(),
                      $m_data->get_averageValue(),  $m_data->get_maxValue());
        $this->test_log($line);
        $ref_val = 1543500959.0;
        if (!($m_data->get_startTimeUTC() == $ref_val)) return $this->test_fail('Invalid start time in preview');
        $ref_val = 1543500960.0;
        if (!($m_data->get_endTimeUTC() == $ref_val)) return $this->test_fail('Invalid end time in preview');
        $ref_val = 15.87;
        if (!($m_data->get_minValue() == $ref_val)) return $this->test_fail('Invalid min value in preview');
        $ref_val = 17.221;
        if (!($m_data->get_averageValue() == $ref_val)) return $this->test_fail('Invalid get_averageValue value in preview');
        $ref_val = 18.63;
        if (!($m_data->get_maxValue() == $ref_val)) return $this->test_fail('Invalid max value in preview');

        $this->test_log('Test datalogger access outside data range');
        $dataset = $sensor->get_recordedData(15, 30);
        $progress = $dataset->loadMore();
        if (!($progress == 100)) return $this->test_fail('Invalid preview size');
        $summary = $dataset->get_summary();
        $ref_val = 0.0;
        if (!($summary->get_startTimeUTC() == $ref_val)) return $this->test_fail('Invalid start time in summary');
        $ref_val = 0.0;
        if (!($summary->get_endTimeUTC() == $ref_val)) return $this->test_fail('Invalid end time in summary');
        if (!($summary->get_minValue() == YAPI::INVALID_DOUBLE)) return $this->test_fail('Invalid min value in summary');
        if (!($summary->get_averageValue() == YAPI::INVALID_DOUBLE)) return $this->test_fail('Invalid get_averageValue value in summary');
        if (!($summary->get_maxValue() == YAPI::INVALID_DOUBLE)) return $this->test_fail('Invalid max value in summary');
        $preview = $dataset->get_preview();
        $size = sizeof($preview);
        if (!($size == 0)) return $this->test_fail('Invalid preview size');
        //13:15:30
        $ref_val = 1543929330;
        //13:18:30
        $ref_val_end = 1543929510;
        $dataset = $sensor->get_recordedData($ref_val, $ref_val_end);
        $progress = $dataset->loadMore();
        $summary = $dataset->get_summary();
        $line = sprintf('Summary: %s to %s => min=%F avg=%F max=%F',
                      _ytimeFloat2str($summary->get_startTimeUTC()), _ytimeFloat2str($summary->get_endTimeUTC()), $summary->get_minValue(),
                      $summary->get_averageValue(),  $summary->get_maxValue());
        $this->test_log($line);
        if (!($summary->get_startTimeUTC() == 1543929300)) return $this->test_fail('Invalid start time in summary');
        if (!($summary->get_endTimeUTC() == 1543929540)) return $this->test_fail('Invalid end time in summary');
        $preview = $dataset->get_preview();
        $size = sizeof($preview);
        if (!($size == 1)) return $this->test_fail('Invalid preview size');
        while ($progress < 100) {
            $progress = $dataset->loadMore();
            if ($progress < 0) {
                return 'loadMore failed:' . $progress;
            }
        }
        $details = $dataset->get_measures();
        $size = sizeof($details);
        if (!($size == 4)) return $this->test_fail('Missing value on non aligned frequency');

        $this->test_log('Test datalogger sub second alignment');
        $sensor = YSensor::FindSensor($this->_datalogger_10s_id);
        $ref_val = 1543925890;
        $ref_val_end = $ref_val + 10;
        $dataset = $sensor->get_recordedData($ref_val, $ref_val_end);
        $progress = $dataset->loadMore();
        $summary = $dataset->get_summary();
        if (!($summary->get_startTimeUTC() == $ref_val)) return $this->test_fail('Invalid start time in summary');
        if (!($summary->get_endTimeUTC() == $ref_val_end)) return $this->test_fail('Invalid end time in summary');
        $preview = $dataset->get_preview();
        $size = sizeof($preview);
        if (!($size == 2)) return $this->test_fail('Invalid preview size');
        while ($progress < 100) {
            $progress = $dataset->loadMore();
            if ($progress < 0) {
                return 'loadMore failed:' . $progress;
            }
        }
        $details = $dataset->get_measures();
        $size = sizeof($details);
        if (!($size == 100)) return $this->test_fail('Missing value on non aligned frequency');
        //m_data = ARRAYAT(details,0);
        //ref_val = 0.1;
        //ref_val_end = m_data->force_imm_get_endTimeUTC() - m_data->force_imm_get_startTimeUTC();
        //T_ASSERT(ref_val == ref_val_end, "Invalid duration in measurements");
        return '';
    }

    public function deviceLogCallBack(YModule $sensor, string $line): void
    {
        $this->_cbError = $line;
        //T_LOG(str_line);
    }

    public function T_LOGCB(): string
    {
        global $testRef;
        // $m                      is a YModule;
        // $ires                   is a int;
        // $retry                  is a int;
        // $msg                    is a str;
        // $errmsg                 is a str;
        $this->test_log('  - test log callback');

        $testRef = $this;
        $this->_cbError = '';
        $m = YModule::FindModule($this->_hub_serial . '.module');
        if (!($m->isOnline())) {
            return $this->_hub_serial . ' is not online';
        }
        $m->registerLogCallback('devLogCbHop');
        $msg = sprintf('Test_log:%d', time());
        $m->log($msg . ''."\n".'');
        $retry = 0;
        while ($retry < 10) {
            $ires = YAPI::Sleep(1000);
            if ($ires < 0) {
                return 'error during Sleep:';
            }
            if ($msg == $this->_cbError) {
                $retry = 11;
            } else {
                $retry = $retry + 1;
            }
        }
        if (!($msg == $this->_cbError)) {
            return 'Log callback in not working:' . $this->_cbError;
        }
        $m->registerLogCallback(null);
        $this->test_log('      done.');
        return '';
    }

    /**
     * Run some test on the Test bench.
     *
     * @param url : the url to use for the test
     *
     * @return an empty string.
     *
     * On failure, throws an exception or returns a string that start with the error message.
     */
    public function RunTestOnBench(string $url): string
    {
        // $m                      is a YModule;
        // $eth                    is a YModule;
        // $serial                 is a str;
        // $product                is a str;
        // $firmware               is a str;
        // $tmp                    is a str;
        // $res                    is a int;
        // $ison                   is a bool;
        // $errmsg                 is a str;
        //may throw an exception
        $res = YAPI::TestHub($url, 1000);
        if ($res < 0) {
            return 'unable to TestHub ' . $url . ':';
        }

        $this->test_log('  Register url with url: ' . $url);
        $res = YAPI::RegisterHub($url);
        if ($res < 0) {
            return 'unable to RegisterHub ' . $url . ':';
        }
        $eth = YModule::FindModule($this->_hub_serial . '.module');
        $eth->log('TSuite'."\n".'');
        $this->test_log('  List connected devices:');
        $m = YModule::FirstModule();
        while (!($m == null)) {
            $serial = $m->get_serialNumber();
            $product = $m->get_productName();
            $firmware = $m->get_firmwareRelease();
            $tmp = '   - ' . $product . ': ' . $serial . ' (firm=' . $firmware . ')';
            $this->test_log($tmp);
            $m = $m->nextModule();
        }
        $m = YModule::FindModule('invalid.hardwareId');
        try {
            $ison = $m->isOnline();
            if (!(!($ison))) return $this->test_fail('isOnline test failed');
        } catch (Exception $ex) {
            return ' isOnline throw an exception.';
        }
        $serial = 'YTEMPIR1-ECD4B';
        //tmp = $this->TestFunctionId(serial,10);
        //IF(NOT(STR_EQUAL(tmp,"")), RETURN(tmp));
        //tmp = $this->TestFunctionId(serial,2);
        //IF(NOT(STR_EQUAL(tmp,"")), RETURN(tmp));
        // run some basic test with Yocto-Meteo
        $tmp = $this->RunDeviceTest();
        if (!($tmp == '')) {
            return $tmp;
        }
        // some more test with large datalogger
        $tmp = $this->RunDataLoggerTest();
        if (!($tmp == '')) {
            return $tmp;
        }
        // Test device log function
        //tmp = $this->T_LOGCB();
        if (!($tmp == '')) {
            return $tmp;
        }
        // test timed notifications with Yocto-PWM TX+RX
        $tmp = $this->TestTimedCB(false, $this->_pwm_rx_id, $this->_pwm_tx_id);
        if (!($tmp == '')) {
            return $tmp;
        }
        $tmp = $this->TestTimedCB(true, $this->_pwm_rx_id, $this->_pwm_tx_id);
        if (!($tmp == '')) {
            return $tmp;
        }
        // run perfomance test
        $this->test_log('  Run perfomance test');
        $tmp = $this->RunPerfTest();
        if (!($tmp == '')) {
            return $tmp;
        }
        // run save/restore settings
        $this->test_log('  Run save/restore settings test');
        $tmp = $this->TestSaveSettings();
        if (!($tmp == '')) {
            return $tmp;
        }
        // run save/restore settings
        //T_LOG("  Run Firmware update");
        //tmp = $this->TestFwUpdate();
        //IF(NOT(STR_EQUAL(tmp,"")), RETURN(tmp));
        YAPI::UnregisterHub($url);
        return '';
    }

    public function RunOnUSB(): string
    {
        // $m                      is a YModule;
        // $s                      is a YSensor;
        // $serial                 is a str;
        // $product                is a str;
        // $firmware               is a str;
        // $tmp                    is a str;
        // $res                    is a int;
        // $ison                   is a bool;
        // $errmsg                 is a str;

        $this->test_log('  Register url with url: usb');
        $res = YAPI::RegisterHub('usb');
        if ($res < 0) {
            return $this->test_fail('unable to RegisterHub usb:');
        }
        $this->test_log('  List connected devices:');
        $m = YModule::FirstModule();
        while (!($m == null)) {
            $serial = $m->get_serialNumber();
            $product = $m->get_productName();
            $firmware = $m->get_firmwareRelease();
            $tmp = '   - ' . $product . ': ' . $serial . ' (firm=' . $firmware . ')';
            $this->test_log($tmp);
            $m = $m->nextModule();
        }
        $s = YSensor::FindSensor($this->_usb_pwm_rx_id);
        $m = $s->get_module();
        $this->test_log(' - test device isOnline (USB).');
        try {
            $ison = $m->isOnline();
            if (!($ison)) return $this->test_fail('isOnline returned false instead of true');
            $m->reboot(1);
            $res = YAPI::Sleep(1100);
            if (!($res == YAPI::SUCCESS )) return $this->test_fail('error during Sleep:');
            $ison = $m->isOnline();
            if (!(!($ison))) return $this->test_fail('isOnline returned true instead of false');
            $res = YAPI::Sleep(4000);
            if (!($res == YAPI::SUCCESS )) return $this->test_fail('error during Sleep:');
            $ison = $m->isOnline();
            if (!($ison)) return $this->test_fail('isOnline returned false instead of true');
        } catch (Exception $ex) {
            return ' isOnline throw an exception.';
        }
        // test timed notifications with Yocto-PWM TX+RX
        $tmp = $this->TestTimedCB(false, $this->_usb_pwm_rx_id, $this->_usb_pwm_tx_id);
        if (!($tmp == '')) {
            return $tmp;
        }
        $tmp = $this->TestTimedCB(true, $this->_usb_pwm_rx_id, $this->_usb_pwm_tx_id);
        if (!($tmp == '')) {
            return $tmp;
        }
        // run perfomance test
        $this->test_log('  Run perfomance test');
        $tmp = $this->RunPerfTest();
        if (!($tmp == '')) {
            return $tmp;
        }
        // run save/restore settings
        //T_LOG("  Run Firmware update");
        //tmp = $this->TestFwUpdate();
        //IF(NOT(STR_EQUAL(tmp,"")), RETURN(tmp));
        YAPI::UnregisterHub('usb');
        return '';
    }

    public function SignalEnd(bool $success): string
    {
        // $buzzer                 is a YBuzzer;
        // $res                    is a int;
        // $errmsg                 is a str;

        $res = YAPI::RegisterHub($this->_hub_ip);
        if ($res < 0) {
            return 'unable to RegisterHub usb:';
        }
        $buzzer = YBuzzer::FirstBuzzer();
        if (!($buzzer == null)) {
            if ($success) {
                $buzzer->playNotes('200% \'G12 C E G6 E12 G2');
            } else {
                $buzzer->playNotes('200% ,E64_ -G6 R64 D#64_ -F#6 R64 D64_ -F6 R64 C#64_ -E8 -Eb10 -E12 -E14b -E16 -E24b -E32 E3');
            }
        }
        YAPI::UnregisterHub($this->_hub_ip);
        return '';
    }

    /**
     * Test authentication
     *
     * @param proto : the prototype to use ("http://"" ou "ws://")
     * @param url : The IP address of the YoctoHub
     *
     * @return an empty string.
     *
     * On failure, throws an exception or returns a string that start with the error message.
     */
    public function TestAuth(string $proto, string $url): string
    {
        // $n                      is a YNetwork;
        // $m                      is a YModule;
        // $subdev                 is a YModule;
        // $err                    is a str;
        // $tmp                    is a str;
        // $name                   is a str;
        // $baseurl                is a str;
        // $login_url              is a str;
        // $api_res                is a int;
        // $hub_serial             is a str;
        // $errmsg                 is a str;
        $hub_serial = $this->_hub_serial;

        // setup the API to use local VirtualHub
        $this->test_log('  Test public acess without password');
        $baseurl = $proto . $url;
        $api_res = YAPI::RegisterHub($baseurl);
        if (!($api_res == YAPI::SUCCESS)) return $this->test_fail('Unable to register hub without password:');
        $n = YNetwork::FindNetwork($hub_serial . '.network');
        $m = YModule::FindModule($hub_serial . '.module');
        $subdev = YModule::FindModule($this->_meteo_serial . '.module');
        //subdev = YSensor::FindSensor($this->_datalogger_id);
        try {
            $n->set_userPassword('abcdefghijklmnopqrstuvwxyz1234567890');
            return 'password length is not checked';
        } catch (Exception $ex) {
            $this->test_log('  password length check ok');
        }
        $m->set_logicalName('no_auth');
        $subdev->set_logicalName('no_auth_sub');
        $this->printAuthStatus($n, $m, $subdev);
        $this->test_log('     configure user pass');
        $n->set_userPassword('user_pwd');
        $n->clearCache();
        $this->test_log('  Test public acess with user password');
        try {
            $this->printAuthStatus($n, $m, $subdev);
            YAPI::UnregisterHub($baseurl);
            if ($proto == 'http://') {
                return 'user_pwd is not checked';
            }
        } catch (Exception $ex) {
            YAPI::UnregisterHub($baseurl);
        }
        $this->test_log('  Test user access with user password');
        $login_url = $proto . 'user:user_pwd@' . $url;
        $api_res = YAPI::RegisterHub($login_url);
        if (!($api_res == YAPI::SUCCESS)) return $this->test_fail('Unable to register hub with ' . $login_url . ' : ');
        $n = YNetwork::FindNetwork($hub_serial . '.network');
        $this->printAuthStatus($n, $m, $subdev);
        $subdev->set_logicalName('user_auth_sub');
        $m->set_logicalName('user_auth');
        $this->printAuthStatus($n, $m, $subdev);
        $name = $subdev->get_logicalName();
        if (!($name == 'user_auth_sub')) {
            YAPI::UnregisterHub($baseurl);
            return 'Unable to set attribute (logged as user, no admin pass, subdev)';
        }
        $name = $m->get_logicalName();
        if (!($name == 'user_auth')) {
            YAPI::UnregisterHub($baseurl);
            return 'Unable to set attribute (logged as user, no admin pass)';
        }
        $this->test_log('     configure admin pass');
        $n->set_adminPassword('admin_pwd');
        $this->test_log('  Test user access with user and admin password');
        try {
            $subdev->set_logicalName('admin_auth_sub');
            $name = $subdev->get_logicalName();
            if ($proto == 'http://' && $name == 'admin_auth_sub') {
                YAPI::UnregisterHub($baseurl);
                return 'user can set attribute (logged as user, with admin pass, sub)';
            }
        } catch (Exception $ex) {
            $this->test_log('  Test access with user and admin password ok');
        }
        try {
            $m->set_logicalName('admin_auth');
            $name = $m->get_logicalName();
            if ($proto == 'http://' && $name == 'admin_auth') {
                YAPI::UnregisterHub($baseurl);
                return 'user can set attribute (logged as user, with admin pass)';
            }
            YAPI::UnregisterHub($baseurl);
        } catch (Exception $ex) {
            YAPI::UnregisterHub($baseurl);
        }
        $this->test_log('  Test admin access with user and admin password');
        $login_url = $proto . 'admin:admin_pwd@' . $url;
        $api_res = YAPI::RegisterHub($login_url);
        if ($api_res != YAPI::SUCCESS) {
            return 'Unable to register hub with ' . $login_url . ' : ';
        }
        $n = YNetwork::FindNetwork($hub_serial . '.network');
        $this->printAuthStatus($n, $m, $subdev);
        $subdev->set_logicalName('admin_auth_sub');
        $name = $subdev->get_logicalName();
        if (!($name == 'admin_auth_sub')) {
            YAPI::UnregisterHub($baseurl);
            return 'Unable to set attribute (logged as admin, with admin pass, sub)';
        }
        $m->set_logicalName('admin_auth');
        $name = $m->get_logicalName();
        if (!($name == 'admin_auth')) {
            YAPI::UnregisterHub($baseurl);
            return 'Unable to set attribute (logged as admin, with admin pass)';
        }
        $this->test_log('     remove user pass');
        $n->set_userPassword('');
        YAPI::UnregisterHub($baseurl);
        $this->test_log('  Test public access with admin password only');
        $api_res = YAPI::RegisterHub($baseurl);
        if (!($api_res == YAPI::SUCCESS)) return $this->test_fail('Unable to register hub without password : ');
        $n = YNetwork::FindNetwork($hub_serial . '.network');
        $this->printAuthStatus($n, $m, $subdev);
        try {
            $subdev->set_logicalName('no_auth_2_sub');
            $name = $subdev->get_logicalName();
            if ($name == 'no_auth_2_sub') {
                $err = 'user can set attribute (not logged, with admin pass)';
            } else {
                $err = 'Set on hub with admin pass does raise an error';
            }
            YAPI::UnregisterHub($baseurl);
            return $err;
        } catch (Exception $ex) {
            $this->test_log('  Test datalogger access with admin password only');
        }
        $tmp = $this->RunDataLoggerTest();
        if (!($tmp == '')) {
            return $tmp;
        }
        $this->test_log('  Continue test public access with admin password only');
        try {
            $m->set_logicalName('no_auth_2');
            $name = $m->get_logicalName();
            if ($name == 'admin_auth') {
                $err = 'user can set attribute (not logged, with admin pass)';
            } else {
                $err = 'Set on hub with admin pass does raise an error';
            }
            YAPI::UnregisterHub($baseurl);
            return $err;
        } catch (Exception $ex) {
            YAPI::UnregisterHub($baseurl);
        }
        $this->test_log('  Clear all password');
        $login_url = $proto . 'admin:admin_pwd@' . $url;
        $api_res = YAPI::RegisterHub($login_url);
        if (!($api_res == YAPI::SUCCESS)) return $this->test_fail('Unable to register hub with ' . $login_url . ' : ');
        $n = YNetwork::FindNetwork($hub_serial . '.network');
        $this->printAuthStatus($n, $m, $subdev);
        $n->set_adminPassword('');
        $subdev->set_logicalName('');
        $m->set_logicalName('');
        $this->printAuthStatus($n, $m, $subdev);
        YAPI::UnregisterHub($baseurl);
        return '';
    }

    /**
     * Test authentication.
     *
     * @param enable : true or false
     *
     * @return an empty string.
     *
     * On failure, throws an exception or returns a string that start with the error message.
     */
    public function SetupGatewayHubCB(bool $enable): string
    {
        // $n                      is a YNetwork;
        // $api_res                is a int;
        // $baseurl                is a str;
        // $cburl                  is a str;
        // $value                  is a str;
        // $errmsg                 is a str;
        $baseurl = $this->_hub_ip;

        // setup the API to use local VirtualHub
        $api_res = YAPI::RegisterHub($baseurl);
        if ($api_res != YAPI::SUCCESS) {
            return 'Unable to register hub without password:';
        }
        $n = YNetwork::FirstNetwork();
        if ($n == null) {
            return 'No Network function available for hub ' . $baseurl;
        }
        $n->set_callbackUrl('');
        if ($enable) {
            $n->set_callbackEncoding(YNetwork::CALLBACKENCODING_YOCTO_API);
            $n->set_callbackMethod(YNetwork::CALLBACKMETHOD_GET);
            $value = 'ws:' . $this->_gh_hubpass;
            $n->set_callbackCredentials($value);
            $cburl = 'ws://' . $this->_gh_ip . ':44080/' . $this->_gh_subdomain . '/callback';
            $n->set_callbackUrl($cburl);
            $n->set_callbackSchedule('after 3s');
        }
        YAPI::UnregisterHub($baseurl);
        return '';
    }

    /**
     * Print password of a YNetwork function.
     *
     * @param n : the YNetwork function.
     *
     * @return an empty string.
     *
     * On failure, throws an exception or returns a string that start with the error message.
     */
    public function printAuthStatus(YNetwork $n, YModule $hub, YModule $sensor): string
    {
        // $userpass               is a str;
        // $adminpass              is a str;
        // $name                   is a str;
        // $subname                is a str;

        $n->clearCache();
        $hub->clearCache();
        $sensor->clearCache();
        $userpass = $n->get_userPassword();
        $adminpass = $n->get_adminPassword();
        $name = $hub->get_logicalName();
        $subname = $sensor->get_logicalName();
        $this->test_log(sprintf('   - user=%s admin=%s name = %s sub = %s', $userpass, $adminpass, $name, $subname));
        return '';
    }

    public function TestFunctionId(string $serial, int $nbtemp): string
    {
        // $count                  is a int;
        // $res                    is a int;
        // $val                    is a double;
        // $tmp                    is a str;
        // $temp                   is a YTemperature;
        // $m                      is a YModule;
        $alltemps = [];         // strArr;
        // $msc                    is a YMultiSensController;
        // $errmsg                 is a str;

        $m = YModule::FindModule($serial . '.module');
        $msc = YMultiSensController::FindMultiSensController($serial . '.multiSensController');
        $msc->set_nSensors($nbtemp);
        $m->saveToFlash();
        $m->reboot(3);
        $res = YAPI::Sleep(8000);
        if (!($res == YAPI::SUCCESS )) return $this->test_fail('error during Sleep:');
        $count = $m->functionCount();
        if (!($count == ($nbtemp+3))) return $this->test_fail('invalid functionCount()');
        $alltemps = $m->get_functionIds('Temperature');
        if (!(sizeof($alltemps) == ($nbtemp + 1))) return $this->test_fail('Invalid number of function returned by get_functionIds(Temperature)');
        $count = 0;
        foreach ( $alltemps as $each) {
            $this->test_log(sprintf(' %d : %s', $count, $each));
            $temp = YTemperature::FindTemperature($serial . '.' . $each);
            if (!($temp->isOnline())) return $this->test_fail('function ' . $each . ' is not online');
            $val = $temp->get_currentValue();
            $tmp = $temp->get_functionId();
            if (!($tmp == $each)) return $this->test_fail('functionId ' . $each . ' is corrupted');
            $this->test_log(sprintf('    temp =%F', $val));
            $count = $count + 1;
        }
        return '';
    }

    public function SetupParameters(): void
    {
        $this->_hub_ip = '172.17.16.64';
        $this->_hub_serial = 'YHUBETH1-22D8A';
        $this->_meteo_serial = 'METEOMK1-2AE60';
        $this->_gh_ip = '172.17.16.97';
        $this->_gh_subdomain = 'test_suite';
        $this->_gh_hubpass = 'test_pass';
        $this->_gh_user = 'test_user';
        $this->_gh_pass = 'test_api_pass';
        $this->_pwm_rx_id = 'YPWMRX01-37288.pwmInput1';
        $this->_pwm_tx_id = 'YPWMTX01-269C7.pwmOutput1';
        $this->_usb_pwm_rx_id = 'YPWMRX01-AE391.pwmInput1';
        $this->_usb_pwm_tx_id = 'YPWMTX01-B9625.pwmOutput1';
        $this->_datalogger_id = 'LIGHTMK3-32067.lightSensor';
        $this->_datalogger_10s_id = 'YVOCMK02-AA4CB.voc';
    }

    public function RunFullTest(): string
    {
        // $res                    is a str;
        // $ires                   is a int;
        // $gwh_url                is a str;
        // $tmp_str                is a str;
        // $mbox                   is a YMessageBox;
        // $sms                    is a YSms;
        // $errmsg                 is a str;
        $res = 'Test API version: ' . YAPI::GetAPIVersion();
        $this->test_log($res);
        $this->test_log(' - test atoi functions.');
        $res = $this->test_atoi();
        if (!($res == '')) {
            return $res;
        }
        $this->test_log(' - test bin functions.');
        $res = $this->test_str_bin_hex();
        if (!($res == '')) {
            return $res;
        }
        $this->test_log(' - test hsl converstion.');
        $res = $this->test_hsl_rgb();
        if (!($res == '')) {
            return $res;
        }
        $this->test_log(' - test YSms constructor.');
        $mbox = YMessageBox::FindMessageBox('dummy');
        $sms = $mbox->newMessage('+41763872096');
        $sms->addText('Server room is too warm');
        $tmp_str = $sms->get_textData();
        if (!($tmp_str == 'Server room is too warm')) return $this->test_fail('Error int addText method of YSms');
        $this->test_log(' - test json functions.');
        //may throw an exception
        $res = $this->test_json();
        if (!($res == '')) {
            return $res;
        }
        if (!($this->_lang == 'PHP') && !($this->_lang == 'EcmaScript') && !($this->_lang == 'TypeScript')) {
            $this->test_log('Test USB connections.');
            //res = $this->RunOnUSB();
            if (!($res == '')) {
                return $res;
            }
        }
        $this->test_log(' - test YAPI::TestHub with wrong address.');
        $ires = YAPI::TestHub('http://172.17.17.1', 100);
        if ($ires == YAPI::SUCCESS) {
            return 'YAPI.TestHub failed for http';
        }
        $ires = YAPI::TestHub('ws://172.17.17.1', 100);
        if ($ires == YAPI::SUCCESS) {
            return 'YAPI.TestHub failed for ws';
        }
        // ensure no callback are configured on the hub
        $res = $this->SetupGatewayHubCB(false);
        if (!($res == '')) {
            return $res;
        }
        $this->test_log('Test HTTP connections.');
        $res = $this->RunTestOnBench('http://' . $this->_hub_ip);
        if (!($res == '')) {
            return $res;
        }
        if (!($this->_lang == 'EcmaScript') && !($this->_lang == 'TypeScript')) {
            $this->test_log('Test HTTP authentication.');
            $res = $this->TestAuth('http://', $this->_hub_ip);
            if (!($res == '')) {
                return $res;
            }
        } else {
            $this->test_log('HTTP authentication is not supported in EcmaScript.');
        }
        if (!($this->_lang == 'PHP')) {
            $this->test_log('Test WebSocket connections.');
            $res = $this->RunTestOnBench('ws://' . $this->_hub_ip);
            if (!($res == '')) {
                return $res;
            }
            $this->test_log('Test WebSocket authentication.');
            $res = $this->TestAuth('ws://', $this->_hub_ip);
            if (!($res == '')) {
                return $res;
            }
            $this->test_log('Test WebSocket thought GatewayHub.');
            $res = $this->SetupGatewayHubCB(true);
            if (!($res == '')) {
                return $res;
            }
            $ires = YAPI::Sleep(25000);
            if ($ires < 0) {
                return 'error during Sleep:';
            }
            $gwh_url = 'ws://' . $this->_gh_user . ':' . $this->_gh_pass . '@' . $this->_gh_ip . ':44080/' . $this->_gh_subdomain;
            $res = $this->RunTestOnBench($gwh_url);
            if (!($res  == '')) {
                return $res;
            }
            $res = $this->SetupGatewayHubCB(false);
            if (!($res == '')) {
                return $res;
            }
        } else {
            $this->test_log('PHP does not have support for WebSocket.');
        }
        $this->test_log('TestSuite success!');
        $this->SignalEnd(true);
        return '';
    }

    public function Run(): string
    {
        // $res                    is a str;
        //may throw an exception
        $this->test_log('Start test suite.');
        $this->SetupParameters();
        $res = $this->RunFullTest();
        if (!($res == '')) {
            return $res;
        }
        return '';
    }

    /**
     * Continues the enumeration of functions started using yFirstTestSuite().
     * Caution: You can't make any assumption about the returned functions order.
     * If you want to find a specific a function, use TestSuite.findTestSuite()
     * and a hardwareID or a logical name.
     *
     * @return YTestSuite  a pointer to a YTestSuite object, corresponding to
     *         a function currently online, or a null pointer
     *         if there are no more functions to enumerate.
     */
    public function nextTestSuite(): ?YTestSuite
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindTestSuite($next_hwid);
    }

    /**
     * Starts the enumeration of functions currently accessible.
     * Use the method YTestSuite::nextTestSuite() to iterate on
     * next functions.
     *
     * @return YTestSuite  a pointer to a YTestSuite object, corresponding to
     *         the first function currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstTestSuite()
    {
        $next_hwid = YAPI::getFirstHardwareId('TestSuite');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindTestSuite($next_hwid);
    }

    //--- (end of generated code: YTestSuite implementation)

}

;

//--- (generated code: YTestSuite functions)

/**
 * Retrieves a function for a given identifier.
 * The identifier can be specified using several formats:
 * <ul>
 * <li>FunctionLogicalName</li>
 * <li>ModuleSerialNumber.FunctionIdentifier</li>
 * <li>ModuleSerialNumber.FunctionLogicalName</li>
 * <li>ModuleLogicalName.FunctionIdentifier</li>
 * <li>ModuleLogicalName.FunctionLogicalName</li>
 * </ul>
 *
 * This function does not require that the function is online at the time
 * it is invoked. The returned object is nevertheless valid.
 * Use the method isOnline() to test if the function is
 * indeed online at a given time. In case of ambiguity when looking for
 * a function by logical name, no error is notified: the first instance
 * found is returned. The search is performed first by hardware name,
 * then by logical name.
 *
 * If a call to this object's is_online() method returns FALSE although
 * you are certain that the matching device is plugged, make sure that you did
 * call registerHub() at application initialization time.
 *
 * @param string $func : a string that uniquely characterizes the function, for instance
 *         MyDevice.testSuite.
 *
 * @return YTestSuite  a YTestSuite object allowing you to drive the function.
 */
function yFindTestSuite(string $func): YTestSuite
{
    return YTestSuite::FindTestSuite($func);
}

/**
 * Starts the enumeration of functions currently accessible.
 * Use the method YTestSuite::nextTestSuite() to iterate on
 * next functions.
 *
 * @return YTestSuite  a pointer to a YTestSuite object, corresponding to
 *         the first function currently online, or a null pointer
 *         if there are none.
 */
function yFirstTestSuite(): ?YTestSuite
{
    return YTestSuite::FirstTestSuite();
}

//--- (end of generated code: YTestSuite functions)
?>
