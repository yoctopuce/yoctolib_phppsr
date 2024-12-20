<?php
namespace Yoctopuce\YoctoAPI;
use Exception;

/**
 * YDataSet Class: Recorded data sequence, as returned by sensor.get_recordedData()
 *
 * YDataSet objects make it possible to retrieve a set of recorded measures
 * for a given sensor and a specified time interval. They can be used
 * to load data points with a progress report. When the YDataSet object is
 * instantiated by the sensor.get_recordedData()  function, no data is
 * yet loaded from the module. It is only when the loadMore()
 * method is called over and over than data will be effectively loaded
 * from the dataLogger.
 *
 * A preview of available measures is available using the function
 * get_preview() as soon as loadMore() has been called
 * once. Measures themselves are available using function get_measures()
 * when loaded by subsequent calls to loadMore().
 *
 * This class can only be used on devices that use a relatively recent firmware,
 * as YDataSet objects are not supported by firmwares older than version 13000.
 */
class YDataSet
{
    //--- (end of generated code: YDataSet declaration)
    const DATA_INVALID = YAPI::INVALID_DOUBLE;

    //--- (generated code: YDataSet attributes)
    protected ?YFunction $_parent = null;                         // YFunction
    protected string $_hardwareId = "";                           // str
    protected string $_functionId = "";                           // str
    protected string $_unit = "";                           // str
    protected int $_bulkLoad = 0;                            // int
    protected float $_startTimeMs = 0;                            // float
    protected float $_endTimeMs = 0;                            // float
    protected int $_progress = 0;                            // int
    protected array $_calib = [];                           // intArr
    protected array $_streams = [];                           // YDataStreamArr
    protected ?YMeasure $_summary = null;                         // YMeasure
    protected array $_preview = [];                           // YMeasureArr
    protected array $_measures = [];                           // YMeasureArr
    protected float $_summaryMinVal = 0;                            // float
    protected float $_summaryMaxVal = 0;                            // float
    protected float $_summaryTotalAvg = 0;                            // float
    protected float $_summaryTotalTime = 0;                            // float

    //--- (end of generated code: YDataSet attributes)

    public function __construct(YFunction $obj_parent, ?string $str_functionId = null, ?string $str_unit = null, ?float $float_startTime = null, ?float $float_endTime = null)
    {
        //--- (generated code: YDataSet constructor)
        //--- (end of generated code: YDataSet constructor)
        $this->_summary = new YMeasure(0, 0, 0, 0, 0);
        $this->_parent = $obj_parent;
        if (is_null($str_unit)) {
            // 1st version of constructor, called from YDataLogger
            $this->_startTimeMs = 0;
            $this->_endTimeMs = 0;
        } else {
            // 2nd version of constructor, called from YFunction
            $this->_functionId = $str_functionId;
            $this->_unit = $str_unit;
            $this->_startTimeMs = $float_startTime * 1000;
            $this->_endTimeMs = $float_endTime * 1000;
            $this->_progress = -1;
        }
    }

    //--- (generated code: YDataSet implementation)

    /**
     * @throws YAPI_Exception on error
     */
    public function _get_calibration(): array
    {
        return $this->_calib;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function loadSummary(string $data): int
    {
        $dataRows = [];         // floatArrArr;
        // $tim                    is a float;
        // $mitv                   is a float;
        // $itv                    is a float;
        // $fitv                   is a float;
        // $end_                   is a float;
        // $nCols                  is a int;
        // $minCol                 is a int;
        // $avgCol                 is a int;
        // $maxCol                 is a int;
        // $res                    is a int;
        // $m_pos                  is a int;
        // $previewTotalTime       is a float;
        // $previewTotalAvg        is a float;
        // $previewMinVal          is a float;
        // $previewMaxVal          is a float;
        // $previewAvgVal          is a float;
        // $previewStartMs         is a float;
        // $previewStopMs          is a float;
        // $previewDuration        is a float;
        // $streamStartTimeMs      is a float;
        // $streamDuration         is a float;
        // $streamEndTimeMs        is a float;
        // $minVal                 is a float;
        // $avgVal                 is a float;
        // $maxVal                 is a float;
        // $summaryStartMs         is a float;
        // $summaryStopMs          is a float;
        // $summaryTotalTime       is a float;
        // $summaryTotalAvg        is a float;
        // $summaryMinVal          is a float;
        // $summaryMaxVal          is a float;
        // $url                    is a str;
        // $strdata                is a str;
        $measure_data = [];     // floatArr;

        if ($this->_progress < 0) {
            $strdata = YAPI::Ybin2str($data);
            if ($strdata == '{}') {
                $this->_parent->_throw(YAPI::VERSION_MISMATCH, 'device firmware is too old');
                return YAPI::VERSION_MISMATCH;
            }
            $res = $this->_parse($strdata);
            if ($res < 0) {
                return $res;
            }
        }
        $summaryTotalTime = 0;
        $summaryTotalAvg = 0;
        $summaryMinVal = YAPI::MAX_DOUBLE;
        $summaryMaxVal = YAPI::MIN_DOUBLE;
        $summaryStartMs = YAPI::MAX_DOUBLE;
        $summaryStopMs = YAPI::MIN_DOUBLE;

        // Parse complete streams
        foreach ($this->_streams as $each) {
            $streamStartTimeMs = round($each->get_realStartTimeUTC() * 1000);
            $streamDuration = $each->get_realDuration();
            $streamEndTimeMs = $streamStartTimeMs + round($streamDuration * 1000);
            if (($streamStartTimeMs >= $this->_startTimeMs) && (($this->_endTimeMs == 0) || ($streamEndTimeMs <= $this->_endTimeMs))) {
                // stream that are completely inside the dataset
                $previewMinVal = $each->get_minValue();
                $previewAvgVal = $each->get_averageValue();
                $previewMaxVal = $each->get_maxValue();
                $previewStartMs = $streamStartTimeMs;
                $previewStopMs = $streamEndTimeMs;
                $previewDuration = $streamDuration;
            } else {
                // stream that are partially in the dataset
                // we need to parse data to filter value outside the dataset
                if (!($each->_wasLoaded())) {
                    $url = $each->_get_url();
                    $data = $this->_parent->_download($url);
                    $each->_parseStream($data);
                }
                $dataRows = $each->get_dataRows();
                if (sizeof($dataRows) == 0) {
                    return $this->get_progress();
                }
                $tim = $streamStartTimeMs;
                $fitv = round($each->get_firstDataSamplesInterval() * 1000);
                $itv = round($each->get_dataSamplesInterval() * 1000);
                $nCols = sizeof($dataRows[0]);
                $minCol = 0;
                if ($nCols > 2) {
                    $avgCol = 1;
                } else {
                    $avgCol = 0;
                }
                if ($nCols > 2) {
                    $maxCol = 2;
                } else {
                    $maxCol = 0;
                }
                $previewTotalTime = 0;
                $previewTotalAvg = 0;
                $previewStartMs = $streamEndTimeMs;
                $previewStopMs = $streamStartTimeMs;
                $previewMinVal = YAPI::MAX_DOUBLE;
                $previewMaxVal = YAPI::MIN_DOUBLE;
                $m_pos = 0;
                while ($m_pos < sizeof($dataRows)) {
                    $measure_data = $dataRows[$m_pos];
                    if ($m_pos == 0) {
                        $mitv = $fitv;
                    } else {
                        $mitv = $itv;
                    }
                    $end_ = $tim + $mitv;
                    if (($end_ > $this->_startTimeMs) && (($this->_endTimeMs == 0) || ($tim < $this->_endTimeMs))) {
                        $minVal = $measure_data[$minCol];
                        $avgVal = $measure_data[$avgCol];
                        $maxVal = $measure_data[$maxCol];
                        if ($previewStartMs > $tim) {
                            $previewStartMs = $tim;
                        }
                        if ($previewStopMs < $end_) {
                            $previewStopMs = $end_;
                        }
                        if ($previewMinVal > $minVal) {
                            $previewMinVal = $minVal;
                        }
                        if ($previewMaxVal < $maxVal) {
                            $previewMaxVal = $maxVal;
                        }
                        if (!(is_nan($avgVal))) {
                            $previewTotalAvg = $previewTotalAvg + ($avgVal * $mitv);
                            $previewTotalTime = $previewTotalTime + $mitv;
                        }
                    }
                    $tim = $end_;
                    $m_pos = $m_pos + 1;
                }
                if ($previewTotalTime > 0) {
                    $previewAvgVal = $previewTotalAvg / $previewTotalTime;
                    $previewDuration = ($previewStopMs - $previewStartMs) / 1000.0;
                } else {
                    $previewAvgVal = 0.0;
                    $previewDuration = 0.0;
                }
            }
            $this->_preview[] = new YMeasure($previewStartMs / 1000.0, $previewStopMs / 1000.0, $previewMinVal, $previewAvgVal, $previewMaxVal);
            if ($summaryMinVal > $previewMinVal) {
                $summaryMinVal = $previewMinVal;
            }
            if ($summaryMaxVal < $previewMaxVal) {
                $summaryMaxVal = $previewMaxVal;
            }
            if ($summaryStartMs > $previewStartMs) {
                $summaryStartMs = $previewStartMs;
            }
            if ($summaryStopMs < $previewStopMs) {
                $summaryStopMs = $previewStopMs;
            }
            $summaryTotalAvg = $summaryTotalAvg + ($previewAvgVal * $previewDuration);
            $summaryTotalTime = $summaryTotalTime + $previewDuration;
        }
        if (($this->_startTimeMs == 0) || ($this->_startTimeMs > $summaryStartMs)) {
            $this->_startTimeMs = $summaryStartMs;
        }
        if (($this->_endTimeMs == 0) || ($this->_endTimeMs < $summaryStopMs)) {
            $this->_endTimeMs = $summaryStopMs;
        }
        if ($summaryTotalTime > 0) {
            $this->_summary = new YMeasure($summaryStartMs / 1000.0, $summaryStopMs / 1000.0, $summaryMinVal, $summaryTotalAvg / $summaryTotalTime, $summaryMaxVal);
        } else {
            $this->_summary = new YMeasure(0.0, 0.0, YAPI::INVALID_DOUBLE, YAPI::INVALID_DOUBLE, YAPI::INVALID_DOUBLE);
        }
        return $this->get_progress();
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function processMore(int $progress, string $data): int
    {
        // $stream                 is a YDataStream;
        $dataRows = [];         // floatArrArr;
        // $tim                    is a float;
        // $itv                    is a float;
        // $fitv                   is a float;
        // $avgv                   is a float;
        // $end_                   is a float;
        // $nCols                  is a int;
        // $minCol                 is a int;
        // $avgCol                 is a int;
        // $maxCol                 is a int;
        // $firstMeasure           is a bool;
        // $baseurl                is a str;
        // $url                    is a str;
        // $suffix                 is a str;
        $suffixes = [];         // strArr;
        // $idx                    is a int;
        // $bulkFile               is a bin;
        // $urlIdx                 is a int;
        $streamBin = [];        // binArr;

        if ($progress != $this->_progress) {
            return $this->_progress;
        }
        if ($this->_progress < 0) {
            return $this->loadSummary($data);
        }
        $stream = $this->_streams[$this->_progress];
        if (!($stream->_wasLoaded())) {
            $stream->_parseStream($data);
        }
        $dataRows = $stream->get_dataRows();
        $this->_progress = $this->_progress + 1;
        if (sizeof($dataRows) == 0) {
            return $this->get_progress();
        }
        $tim = round($stream->get_realStartTimeUTC() * 1000);
        $fitv = round($stream->get_firstDataSamplesInterval() * 1000);
        $itv = round($stream->get_dataSamplesInterval() * 1000);
        if ($fitv == 0) {
            $fitv = $itv;
        }
        if ($tim < $itv) {
            $tim = $itv;
        }
        $nCols = sizeof($dataRows[0]);
        $minCol = 0;
        if ($nCols > 2) {
            $avgCol = 1;
        } else {
            $avgCol = 0;
        }
        if ($nCols > 2) {
            $maxCol = 2;
        } else {
            $maxCol = 0;
        }

        $firstMeasure = true;
        foreach ($dataRows as $each) {
            if ($firstMeasure) {
                $end_ = $tim + $fitv;
                $firstMeasure = false;
            } else {
                $end_ = $tim + $itv;
            }
            $avgv = $each[$avgCol];
            if (($end_ > $this->_startTimeMs) && (($this->_endTimeMs == 0) || ($tim < $this->_endTimeMs)) && !(is_nan($avgv))) {
                $this->_measures[] = new YMeasure($tim / 1000, $end_ / 1000, $each[$minCol], $avgv, $each[$maxCol]);
            }
            $tim = $end_;
        }
        // Perform bulk preload to speed-up network transfer
        if (($this->_bulkLoad > 0) && ($this->_progress < sizeof($this->_streams))) {
            $stream = $this->_streams[$this->_progress];
            if ($stream->_wasLoaded()) {
                return $this->get_progress();
            }
            $baseurl = $stream->_get_baseurl();
            $url = $stream->_get_url();
            $suffix = $stream->_get_urlsuffix();
            $suffixes[] = $suffix;
            $idx = $this->_progress + 1;
            while (($idx < sizeof($this->_streams)) && (sizeof($suffixes) < $this->_bulkLoad)) {
                $stream = $this->_streams[$idx];
                if (!($stream->_wasLoaded()) && ($stream->_get_baseurl() == $baseurl)) {
                    $suffix = $stream->_get_urlsuffix();
                    $suffixes[] = $suffix;
                    $url = $url . ',' . $suffix;
                }
                $idx = $idx + 1;
            }
            $bulkFile = $this->_parent->_download($url);
            $streamBin = $this->_parent->_json_get_array($bulkFile);
            $urlIdx = 0;
            $idx = $this->_progress;
            while (($idx < sizeof($this->_streams)) && ($urlIdx < sizeof($suffixes)) && ($urlIdx < sizeof($streamBin))) {
                $stream = $this->_streams[$idx];
                if (($stream->_get_baseurl() == $baseurl) && ($stream->_get_urlsuffix() == $suffixes[$urlIdx])) {
                    $stream->_parseStream($streamBin[$urlIdx]);
                    $urlIdx = $urlIdx + 1;
                }
                $idx = $idx + 1;
            }
        }
        return $this->get_progress();
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_privateDataStreams(): array
    {
        return $this->_streams;
    }

    /**
     * Returns the unique hardware identifier of the function who performed the measures,
     * in the form SERIAL.FUNCTIONID. The unique hardware identifier is composed of the
     * device serial number and of the hardware identifier of the function
     * (for example THRMCPL1-123456.temperature1)
     *
     * @return string  a string that uniquely identifies the function (ex: THRMCPL1-123456.temperature1)
     *
     * On failure, throws an exception or returns  YDataSet::HARDWAREID_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_hardwareId(): string
    {
        // $mo                     is a YModule;
        if (!($this->_hardwareId == '')) {
            return $this->_hardwareId;
        }
        $mo = $this->_parent->get_module();
        $this->_hardwareId = sprintf('%s.%s', $mo->get_serialNumber(), $this->get_functionId());
        return $this->_hardwareId;
    }

    /**
     * Returns the hardware identifier of the function that performed the measure,
     * without reference to the module. For example temperature1.
     *
     * @return string  a string that identifies the function (ex: temperature1)
     */
    public function get_functionId(): string
    {
        return $this->_functionId;
    }

    /**
     * Returns the measuring unit for the measured value.
     *
     * @return string  a string that represents a physical unit.
     *
     * On failure, throws an exception or returns  YDataSet::UNIT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_unit(): string
    {
        return $this->_unit;
    }

    /**
     * Returns the start time of the dataset, relative to the Jan 1, 1970.
     * When the YDataSet object is created, the start time is the value passed
     * in parameter to the get_dataSet() function. After the
     * very first call to loadMore(), the start time is updated
     * to reflect the timestamp of the first measure actually found in the
     * dataLogger within the specified range.
     *
     * <b>DEPRECATED</b>: This method has been replaced by get_summary()
     * which contain more precise informations.
     *
     * @return float  an unsigned number corresponding to the number of seconds
     *         between the Jan 1, 1970 and the beginning of this data
     *         set (i.e. Unix time representation of the absolute time).
     */
    public function get_startTimeUTC(): float
    {
        return $this->imm_get_startTimeUTC();
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function imm_get_startTimeUTC(): float
    {
        return ($this->_startTimeMs / 1000.0);
    }

    /**
     * Returns the end time of the dataset, relative to the Jan 1, 1970.
     * When the YDataSet object is created, the end time is the value passed
     * in parameter to the get_dataSet() function. After the
     * very first call to loadMore(), the end time is updated
     * to reflect the timestamp of the last measure actually found in the
     * dataLogger within the specified range.
     *
     * <b>DEPRECATED</b>: This method has been replaced by get_summary()
     * which contain more precise informations.
     *
     * @return float  an unsigned number corresponding to the number of seconds
     *         between the Jan 1, 1970 and the end of this data
     *         set (i.e. Unix time representation of the absolute time).
     */
    public function get_endTimeUTC(): float
    {
        return $this->imm_get_endTimeUTC();
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function imm_get_endTimeUTC(): float
    {
        return round($this->_endTimeMs / 1000.0);
    }

    /**
     * Returns the progress of the downloads of the measures from the data logger,
     * on a scale from 0 to 100. When the object is instantiated by get_dataSet,
     * the progress is zero. Each time loadMore() is invoked, the progress
     * is updated, to reach the value 100 only once all measures have been loaded.
     *
     * @return int  an integer in the range 0 to 100 (percentage of completion).
     */
    public function get_progress(): int
    {
        if ($this->_progress < 0) {
            return 0;
        }
        // index not yet loaded
        if ($this->_progress >= sizeof($this->_streams)) {
            return 100;
        }
        return intVal((1 + (1 + $this->_progress) * 98) / ((1 + sizeof($this->_streams))));
    }

    /**
     * Loads the next block of measures from the dataLogger, and updates
     * the progress indicator.
     *
     * @return int  an integer in the range 0 to 100 (percentage of completion),
     *         or a negative error code in case of failure.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function loadMore(): int
    {
        // $url                    is a str;
        // $stream                 is a YDataStream;
        if ($this->_progress < 0) {
            $url = sprintf('logger.json?id=%s',$this->_functionId);
            if ($this->_startTimeMs != 0) {
                $url = sprintf('%s&from=%u',$url,$this->imm_get_startTimeUTC());
            }
            if ($this->_endTimeMs != 0) {
                $url = sprintf('%s&to=%u',$url,$this->imm_get_endTimeUTC() + 1);
            }
        } else {
            if ($this->_progress >= sizeof($this->_streams)) {
                return 100;
            } else {
                $stream = $this->_streams[$this->_progress];
                if ($stream->_wasLoaded()) {
                    // Do not reload stream if it was already loaded
                    return $this->processMore($this->_progress, YAPI::Ystr2bin(''));
                }
                $url = $stream->_get_url();
            }
        }
        try {
            return $this->processMore($this->_progress, $this->_parent->_download($url));
        } catch (Exception $ex) {
            return $this->processMore($this->_progress, $this->_parent->_download($url));
        }
    }

    /**
     * Returns an YMeasure object which summarizes the whole
     * YDataSet:: In includes the following information:
     * - the start of a time interval
     * - the end of a time interval
     * - the minimal value observed during the time interval
     * - the average value observed during the time interval
     * - the maximal value observed during the time interval
     *
     * This summary is available as soon as loadMore() has
     * been called for the first time.
     *
     * @return ?YMeasure  an YMeasure object
     */
    public function get_summary(): ?YMeasure
    {
        return $this->_summary;
    }

    /**
     * Returns a condensed version of the measures that can
     * retrieved in this YDataSet, as a list of YMeasure
     * objects. Each item includes:
     * - the start of a time interval
     * - the end of a time interval
     * - the minimal value observed during the time interval
     * - the average value observed during the time interval
     * - the maximal value observed during the time interval
     *
     * This preview is available as soon as loadMore() has
     * been called for the first time.
     *
     * @return YMeasure[]  a table of records, where each record depicts the
     *         measured values during a time interval
     *
     * On failure, throws an exception or returns an empty array.
     * @throws YAPI_Exception on error
     */
    public function get_preview(): array
    {
        return $this->_preview;
    }

    /**
     * Returns the detailed set of measures for the time interval corresponding
     * to a given condensed measures previously returned by get_preview().
     * The result is provided as a list of YMeasure objects.
     *
     * @param YMeasure $measure : condensed measure from the list previously returned by
     *         get_preview().
     *
     * @return YMeasure[]  a table of records, where each record depicts the
     *         measured values during a time interval
     *
     * On failure, throws an exception or returns an empty array.
     * @throws YAPI_Exception on error
     */
    public function get_measuresAt(YMeasure $measure): array
    {
        // $startUtcMs             is a float;
        // $stream                 is a YDataStream;
        $dataRows = [];         // floatArrArr;
        $measures = [];         // YMeasureArr;
        // $tim                    is a float;
        // $itv                    is a float;
        // $end_                   is a float;
        // $nCols                  is a int;
        // $minCol                 is a int;
        // $avgCol                 is a int;
        // $maxCol                 is a int;

        $startUtcMs = $measure->get_startTimeUTC() * 1000;
        $stream = null;
        foreach ($this->_streams as $each) {
            if (round($each->get_realStartTimeUTC() *1000) == $startUtcMs) {
                $stream = $each;
            }
        }
        if ($stream == null) {
            return $measures;
        }
        $dataRows = $stream->get_dataRows();
        if (sizeof($dataRows) == 0) {
            return $measures;
        }
        $tim = round($stream->get_realStartTimeUTC() * 1000);
        $itv = round($stream->get_dataSamplesInterval() * 1000);
        if ($tim < $itv) {
            $tim = $itv;
        }
        $nCols = sizeof($dataRows[0]);
        $minCol = 0;
        if ($nCols > 2) {
            $avgCol = 1;
        } else {
            $avgCol = 0;
        }
        if ($nCols > 2) {
            $maxCol = 2;
        } else {
            $maxCol = 0;
        }

        foreach ($dataRows as $each) {
            $end_ = $tim + $itv;
            if (($end_ > $this->_startTimeMs) && (($this->_endTimeMs == 0) || ($tim < $this->_endTimeMs))) {
                $measures[] = new YMeasure($tim / 1000.0, $end_ / 1000.0, $each[$minCol], $each[$avgCol], $each[$maxCol]);
            }
            $tim = $end_;
        }
        return $measures;
    }

    /**
     * Returns all measured values currently available for this DataSet,
     * as a list of YMeasure objects. Each item includes:
     * - the start of the measure time interval
     * - the end of the measure time interval
     * - the minimal value observed during the time interval
     * - the average value observed during the time interval
     * - the maximal value observed during the time interval
     *
     * Before calling this method, you should call loadMore()
     * to load data from the device. You may have to call loadMore()
     * several time until all rows are loaded, but you can start
     * looking at available data rows before the load is complete.
     *
     * The oldest measures are always loaded first, and the most
     * recent measures will be loaded last. As a result, timestamps
     * are normally sorted in ascending order within the measure table,
     * unless there was an unexpected adjustment of the datalogger UTC
     * clock.
     *
     * @return YMeasure[]  a table of records, where each record depicts the
     *         measured value for a given time interval
     *
     * On failure, throws an exception or returns an empty array.
     * @throws YAPI_Exception on error
     */
    public function get_measures(): array
    {
        return $this->_measures;
    }

    //--- (end of generated code: YDataSet implementation)

    // YDataSet parser for stream list
    public function _parse(string $str_json)
    {
        $loadval = json_decode(YAPI::Ybin2str($str_json), true);

        $this->_functionId = $loadval['id'];
        $this->_unit = $loadval['unit'];
        $this->_bulkLoad = (isset($loadval['bulk']) ? intval($loadval['bulk']) : 0);
        if (isset($loadval['calib'])) {
            $this->_calib = YAPI::_decodeFloats($loadval['calib']);
            $this->_calib[0] = intVal($this->_calib[0] / 1000);
        } else {
            $this->_calib = YAPI::_decodeWords($loadval['cal']);
        }
        $this->_summary = new YMeasure(0, 0, 0, 0, 0);
        $this->_streams = array();
        $this->_preview = array();
        $this->_measures = array();
        for ($i = 0; $i < sizeof($loadval['streams']); $i++) {
            /** @var YDataStream $stream */
            $stream = $this->_parent->_findDataStream($this, $loadval['streams'][$i]);
            $streamStartTime = $stream->get_realstartTimeUTC() * 1000;
            $streamEndTime = $streamStartTime + $stream->get_realDuration() * 1000;
            /** @noinspection PhpStatementHasEmptyBodyInspection */
            if ($this->_startTimeMs > 0 && $streamEndTime <= $this->_startTimeMs) {
                // this stream is too early, drop it
            } else {
                /** @noinspection PhpStatementHasEmptyBodyInspection */
                if ($this->_endTimeMs > 0 && $streamStartTime >= $this->_endTimeMs) {
                    // this stream is too late, drop it
                } else {
                    $this->_streams[] = $stream;
                }
            }
        }
        $this->_progress = 0;
        return $this->get_progress();
    }
}

