<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YDataLogger Class: DataLogger control interface, available on most Yoctopuce sensors.
 *
 * A non-volatile memory for storing ongoing measured data is available on most Yoctopuce
 * sensors. Recording can happen automatically, without requiring a permanent
 * connection to a computer.
 * The YDataLogger class controls the global parameters of the internal data
 * logger. Recording control (start/stop) as well as data retrieval is done at
 * sensor objects level.
 */
class YDataLogger extends YFunction
{
    const CURRENTRUNINDEX_INVALID = YAPI::INVALID_UINT;
    const TIMEUTC_INVALID = YAPI::INVALID_LONG;
    const RECORDING_OFF = 0;
    const RECORDING_ON = 1;
    const RECORDING_PENDING = 2;
    const RECORDING_INVALID = -1;
    const AUTOSTART_OFF = 0;
    const AUTOSTART_ON = 1;
    const AUTOSTART_INVALID = -1;
    const BEACONDRIVEN_OFF = 0;
    const BEACONDRIVEN_ON = 1;
    const BEACONDRIVEN_INVALID = -1;
    const USAGE_INVALID = YAPI::INVALID_UINT;
    const CLEARHISTORY_FALSE = 0;
    const CLEARHISTORY_TRUE = 1;
    const CLEARHISTORY_INVALID = -1;
    //--- (end of generated code: YDataLogger declaration)

    //--- (generated code: YDataLogger attributes)
    protected int $_currentRunIndex = self::CURRENTRUNINDEX_INVALID; // UInt31
    protected float $_timeUTC = self::TIMEUTC_INVALID;        // UTCTime
    protected int $_recording = self::RECORDING_INVALID;      // OffOnPending
    protected int $_autoStart = self::AUTOSTART_INVALID;      // OnOff
    protected int $_beaconDriven = self::BEACONDRIVEN_INVALID;   // OnOff
    protected int $_usage = self::USAGE_INVALID;          // Percent
    protected int $_clearHistory = self::CLEARHISTORY_INVALID;   // Bool

    //--- (end of generated code: YDataLogger attributes)
    protected ?string $dataLoggerURL = null;

    function __construct(string $str_func)
    {
        //--- (generated code: YDataLogger constructor)
        parent::__construct($str_func);
        $this->_className = 'DataLogger';

        //--- (end of generated code: YDataLogger constructor)
    }

    // Internal function to retrieve datalogger memory
    //
    public function getData(int $runIdx, ?int $timeIdx, string &$loadval): int
    {
        if (is_null($this->dataLoggerURL)) {
            $this->dataLoggerURL = "/logger.json";
        }

        // get the device serial number
        $devid = $this->module()->get_serialNumber();
        if ($devid == YModule::SERIALNUMBER_INVALID) {
            return $this->get_errorType();
        }
        $httpreq = "GET " . $this->dataLoggerURL;
        if (!is_null($timeIdx)) {
            $httpreq .= "?run={$runIdx}&time={$timeIdx}";
        }
        $yreq = YAPI::devRequest($devid, $httpreq);
        if ($yreq->errorType != YAPI::SUCCESS) {
            if (strpos($yreq->errorMsg, 'HTTP status 404') !== false && $this->dataLoggerURL != "/dataLogger.json") {
                $this->dataLoggerURL = "/dataLogger.json";
                return $this->getData($runIdx, $timeIdx, $loadval);
            }
            return $yreq->errorType;
        }
        $loadval = json_decode($yreq->result, true);

        return YAPI::SUCCESS;
    }

    //--- (generated code: YDataLogger implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'currentRunIndex':
            $this->_currentRunIndex = intval($val);
            return 1;
        case 'timeUTC':
            $this->_timeUTC = intval($val);
            return 1;
        case 'recording':
            $this->_recording = intval($val);
            return 1;
        case 'autoStart':
            $this->_autoStart = intval($val);
            return 1;
        case 'beaconDriven':
            $this->_beaconDriven = intval($val);
            return 1;
        case 'usage':
            $this->_usage = intval($val);
            return 1;
        case 'clearHistory':
            $this->_clearHistory = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the current run number, corresponding to the number of times the module was
     * powered on with the dataLogger enabled at some point.
     *
     * @return int  an integer corresponding to the current run number, corresponding to the number of
     * times the module was
     *         powered on with the dataLogger enabled at some point
     *
     * On failure, throws an exception or returns YDataLogger::CURRENTRUNINDEX_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_currentRunIndex(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CURRENTRUNINDEX_INVALID;
            }
        }
        $res = $this->_currentRunIndex;
        return $res;
    }

    /**
     * Returns the Unix timestamp for current UTC time, if known.
     *
     * @return float  an integer corresponding to the Unix timestamp for current UTC time, if known
     *
     * On failure, throws an exception or returns YDataLogger::TIMEUTC_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_timeUTC(): float
    {
        // $res                    is a long;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::TIMEUTC_INVALID;
            }
        }
        $res = $this->_timeUTC;
        return $res;
    }

    /**
     * Changes the current UTC time reference used for recorded data.
     *
     * @param float $newval : an integer corresponding to the current UTC time reference used for recorded data
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_timeUTC(float $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("timeUTC", $rest_val);
    }

    /**
     * Returns the current activation state of the data logger.
     *
     * @return int  a value among YDataLogger::RECORDING_OFF, YDataLogger::RECORDING_ON and
     * YDataLogger::RECORDING_PENDING corresponding to the current activation state of the data logger
     *
     * On failure, throws an exception or returns YDataLogger::RECORDING_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_recording(): int
    {
        // $res                    is a enumOFFONPENDING;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::RECORDING_INVALID;
            }
        }
        $res = $this->_recording;
        return $res;
    }

    /**
     * Changes the activation state of the data logger to start/stop recording data.
     *
     * @param int $newval : a value among YDataLogger::RECORDING_OFF, YDataLogger::RECORDING_ON and
     * YDataLogger::RECORDING_PENDING corresponding to the activation state of the data logger to
     * start/stop recording data
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_recording(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("recording", $rest_val);
    }

    /**
     * Returns the default activation state of the data logger on power up.
     *
     * @return int  either YDataLogger::AUTOSTART_OFF or YDataLogger::AUTOSTART_ON, according to the default
     * activation state of the data logger on power up
     *
     * On failure, throws an exception or returns YDataLogger::AUTOSTART_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_autoStart(): int
    {
        // $res                    is a enumONOFF;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::AUTOSTART_INVALID;
            }
        }
        $res = $this->_autoStart;
        return $res;
    }

    /**
     * Changes the default activation state of the data logger on power up.
     * Do not forget to call the saveToFlash() method of the module to save the
     * configuration change.  Note: if the device doesn't have any time source at his disposal when
     * starting up, it will wait for ~8 seconds before automatically starting to record  with
     * an arbitrary timestamp
     *
     * @param int $newval : either YDataLogger::AUTOSTART_OFF or YDataLogger::AUTOSTART_ON, according to the
     * default activation state of the data logger on power up
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_autoStart(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("autoStart", $rest_val);
    }

    /**
     * Returns true if the data logger is synchronised with the localization beacon.
     *
     * @return int  either YDataLogger::BEACONDRIVEN_OFF or YDataLogger::BEACONDRIVEN_ON, according to true
     * if the data logger is synchronised with the localization beacon
     *
     * On failure, throws an exception or returns YDataLogger::BEACONDRIVEN_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_beaconDriven(): int
    {
        // $res                    is a enumONOFF;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::BEACONDRIVEN_INVALID;
            }
        }
        $res = $this->_beaconDriven;
        return $res;
    }

    /**
     * Changes the type of synchronisation of the data logger.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param int $newval : either YDataLogger::BEACONDRIVEN_OFF or YDataLogger::BEACONDRIVEN_ON, according
     * to the type of synchronisation of the data logger
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_beaconDriven(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("beaconDriven", $rest_val);
    }

    /**
     * Returns the percentage of datalogger memory in use.
     *
     * @return int  an integer corresponding to the percentage of datalogger memory in use
     *
     * On failure, throws an exception or returns YDataLogger::USAGE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_usage(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::USAGE_INVALID;
            }
        }
        $res = $this->_usage;
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_clearHistory(): int
    {
        // $res                    is a enumBOOL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CLEARHISTORY_INVALID;
            }
        }
        $res = $this->_clearHistory;
        return $res;
    }

    /**
     * @throws YAPI_Exception
     */
    public function set_clearHistory(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("clearHistory", $rest_val);
    }

    /**
     * Retrieves a data logger for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the data logger is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the data logger is
     * indeed online at a given time. In case of ambiguity when looking for
     * a data logger by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the data logger, for instance
     *         LIGHTMK4.dataLogger.
     *
     * @return YDataLogger  a YDataLogger object allowing you to drive the data logger.
     */
    public static function FindDataLogger(string $func): YDataLogger
    {
        // $obj                    is a YDataLogger;
        $obj = YFunction::_FindFromCache('DataLogger', $func);
        if ($obj == null) {
            $obj = new YDataLogger($func);
            YFunction::_AddToCache('DataLogger', $func, $obj);
        }
        return $obj;
    }

    /**
     * Clears the data logger memory and discards all recorded data streams.
     * This method also resets the current run index to zero.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function forgetAllDataStreams(): int
    {
        return $this->set_clearHistory(self::CLEARHISTORY_TRUE);
    }

    /**
     * Returns a list of YDataSet objects that can be used to retrieve
     * all measures stored by the data logger.
     *
     * This function only works if the device uses a recent firmware,
     * as YDataSet objects are not supported by firmwares older than
     * version 13000.
     *
     * @return YDataSet[]  a list of YDataSet object.
     *
     * On failure, throws an exception or returns an empty list.
     * @throws YAPI_Exception on error
     */
    public function get_dataSets(): array
    {
        return $this->parse_dataSets($this->_download('logger.json'));
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function parse_dataSets(string $jsonbuff): array
    {
        $dslist = [];           // binArr;
        // $dataset                is a YDataSetPtr;
        $res = [];              // YDataSetArr;

        $dslist = $this->_json_get_array($jsonbuff);
        while (sizeof($res) > 0) {
            array_pop($res);
        };
        foreach ($dslist as $each) {
            $dataset = new YDataSet($this);
            $dataset->_parse(YAPI::Ybin2str($each));
            $res[] = $dataset;
        }
        return $res;
    }

    /**
     * @throws YAPI_Exception
     */
    public function currentRunIndex(): int
{
    return $this->get_currentRunIndex();
}

    /**
     * @throws YAPI_Exception
     */
    public function timeUTC(): float
{
    return $this->get_timeUTC();
}

    /**
     * @throws YAPI_Exception
     */
    public function setTimeUTC(float $newval): int
{
    return $this->set_timeUTC($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function recording(): int
{
    return $this->get_recording();
}

    /**
     * @throws YAPI_Exception
     */
    public function setRecording(int $newval): int
{
    return $this->set_recording($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function autoStart(): int
{
    return $this->get_autoStart();
}

    /**
     * @throws YAPI_Exception
     */
    public function setAutoStart(int $newval): int
{
    return $this->set_autoStart($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function beaconDriven(): int
{
    return $this->get_beaconDriven();
}

    /**
     * @throws YAPI_Exception
     */
    public function setBeaconDriven(int $newval): int
{
    return $this->set_beaconDriven($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function usage(): int
{
    return $this->get_usage();
}

    /**
     * @throws YAPI_Exception
     */
    public function clearHistory(): int
{
    return $this->get_clearHistory();
}

    /**
     * @throws YAPI_Exception
     */
    public function setClearHistory(int $newval): int
{
    return $this->set_clearHistory($newval);
}

    /**
     * Continues the enumeration of data loggers started using yFirstDataLogger().
     * Caution: You can't make any assumption about the returned data loggers order.
     * If you want to find a specific a data logger, use DataLogger.findDataLogger()
     * and a hardwareID or a logical name.
     *
     * @return ?YDataLogger  a pointer to a YDataLogger object, corresponding to
     *         a data logger currently online, or a null pointer
     *         if there are no more data loggers to enumerate.
     */
    public function nextDataLogger(): ?YDataLogger
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindDataLogger($next_hwid);
    }

    /**
     * Starts the enumeration of data loggers currently accessible.
     * Use the method YDataLogger::nextDataLogger() to iterate on
     * next data loggers.
     *
     * @return ?YDataLogger  a pointer to a YDataLogger object, corresponding to
     *         the first data logger currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstDataLogger(): ?YDataLogger
    {
        $next_hwid = YAPI::getFirstHardwareId('DataLogger');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindDataLogger($next_hwid);
    }

    //--- (end of generated code: YDataLogger implementation)
}

