<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YDataStream Class: Unformatted data sequence
 *
 * DataStream objects represent bare recorded measure sequences,
 * exactly as found within the data logger present on Yoctopuce
 * sensors.
 *
 * In most cases, it is not necessary to use DataStream objects
 * directly, as the DataSet objects (returned by the
 * get_recordedData() method from sensors and the
 * get_dataSets() method from the data logger) provide
 * a more convenient interface.
 */
class YDataStream
{
    //--- (end of generated code: YDataStream declaration)
    const DATA_INVALID = YAPI::INVALID_DOUBLE;

    //--- (generated code: YDataStream attributes)
    protected ?YFunction $_parent = null;                         // YFunction
    protected int $_runNo = 0;                            // int
    protected float $_utcStamp = 0;                            // u32
    protected int $_nCols = 0;                            // int
    protected int $_nRows = 0;                            // int
    protected float $_startTime = 0;                            // float
    protected float $_duration = 0;                            // float
    protected float $_dataSamplesInterval = 0;                            // float
    protected float $_firstMeasureDuration = 0;                            // float
    protected array $_columnNames = [];                           // strArr
    protected string $_functionId = "";                           // str
    protected bool $_isClosed = false;                        // bool
    protected bool $_isAvg = false;                        // bool
    protected float $_minVal = 0;                            // float
    protected float $_avgVal = 0;                            // float
    protected float $_maxVal = 0;                            // float
    protected int $_caltyp = 0;                            // int
    protected array $_calpar = [];                           // intArr
    protected array $_calraw = [];                           // floatArr
    protected array $_calref = [];                           // floatArr
    protected array $_values = [];                           // floatArrArr
    protected bool $_isLoaded = false;                        // bool

    //--- (end of generated code: YDataStream attributes)
    private mixed $_calhdl;

    public function __construct($obj_parent, $obj_dataset = null, $encoded = null)
    {
        //--- (generated code: YDataStream constructor)
        //--- (end of generated code: YDataStream constructor)
        $this->_parent = $obj_parent;
        $this->_calhdl = null;
        if (!is_null($obj_dataset)) {
            $this->_initFromDataSet($obj_dataset, $encoded);
        }
    }

    //--- (generated code: YDataStream implementation)

    public function _initFromDataSet(?YDataSet $dataset, array $encoded): int
    {
        // $val                    is a int;
        // $i                      is a int;
        // $maxpos                 is a int;
        // $ms_offset              is a int;
        // $samplesPerHour         is a int;
        // $fRaw                   is a float;
        // $fRef                   is a float;
        $iCalib = [];           // intArr;
        // decode sequence header to extract data
        $this->_runNo = $encoded[0] + ((($encoded[1]) << (16)));
        $this->_utcStamp = $encoded[2] + ((($encoded[3]) << (16)));
        $val = $encoded[4];
        $this->_isAvg = ((($val) & (0x100)) == 0);
        $samplesPerHour = (($val) & (0xff));
        if ((($val) & (0x100)) != 0) {
            $samplesPerHour = $samplesPerHour * 3600;
        } else {
            if ((($val) & (0x200)) != 0) {
                $samplesPerHour = $samplesPerHour * 60;
            }
        }
        $this->_dataSamplesInterval = 3600.0 / $samplesPerHour;
        $ms_offset = $encoded[6];
        if ($ms_offset < 1000) {
            // new encoding -> add the ms to the UTC timestamp
            $this->_startTime = $this->_utcStamp + ($ms_offset / 1000.0);
        } else {
            // legacy encoding subtract the measure interval form the UTC timestamp
            $this->_startTime = $this->_utcStamp -  $this->_dataSamplesInterval;
        }
        $this->_firstMeasureDuration = $encoded[5];
        if (!($this->_isAvg)) {
            $this->_firstMeasureDuration = $this->_firstMeasureDuration / 1000.0;
        }
        $val = $encoded[7];
        $this->_isClosed = ($val != 0xffff);
        if ($val == 0xffff) {
            $val = 0;
        }
        $this->_nRows = $val;
        if ($this->_nRows > 0) {
            if ($this->_firstMeasureDuration > 0) {
                $this->_duration = $this->_firstMeasureDuration + ($this->_nRows - 1) * $this->_dataSamplesInterval;
            } else {
                $this->_duration = $this->_nRows * $this->_dataSamplesInterval;
            }
        } else {
            $this->_duration = 0;
        }
        // precompute decoding parameters
        $iCalib = $dataset->_get_calibration();
        $this->_caltyp = $iCalib[0];
        if ($this->_caltyp != 0) {
            $this->_calhdl = YAPI::_getCalibrationHandler($this->_caltyp);
            $maxpos = sizeof($iCalib);
            while (sizeof($this->_calpar) > 0) {
                array_pop($this->_calpar);
            };
            while (sizeof($this->_calraw) > 0) {
                array_pop($this->_calraw);
            };
            while (sizeof($this->_calref) > 0) {
                array_pop($this->_calref);
            };
            $i = 1;
            while ($i < $maxpos) {
                $this->_calpar[] = $iCalib[$i];
                $i = $i + 1;
            }
            $i = 1;
            while ($i + 1 < $maxpos) {
                $fRaw = $iCalib[$i];
                $fRaw = $fRaw / 1000.0;
                $fRef = $iCalib[$i + 1];
                $fRef = $fRef / 1000.0;
                $this->_calraw[] = $fRaw;
                $this->_calref[] = $fRef;
                $i = $i + 2;
            }
        }
        // preload column names for backward-compatibility
        $this->_functionId = $dataset->get_functionId();
        if ($this->_isAvg) {
            while (sizeof($this->_columnNames) > 0) {
                array_pop($this->_columnNames);
            };
            $this->_columnNames[] = sprintf('%s_min', $this->_functionId);
            $this->_columnNames[] = sprintf('%s_avg', $this->_functionId);
            $this->_columnNames[] = sprintf('%s_max', $this->_functionId);
            $this->_nCols = 3;
        } else {
            while (sizeof($this->_columnNames) > 0) {
                array_pop($this->_columnNames);
            };
            $this->_columnNames[] = $this->_functionId;
            $this->_nCols = 1;
        }
        // decode min/avg/max values for the sequence
        if ($this->_nRows > 0) {
            $this->_avgVal = $this->_decodeAvg($encoded[8] + ((((($encoded[9]) ^ (0x8000))) << (16))), 1);
            $this->_minVal = $this->_decodeVal($encoded[10] + ((($encoded[11]) << (16))));
            $this->_maxVal = $this->_decodeVal($encoded[12] + ((($encoded[13]) << (16))));
        }
        return 0;
    }

    public function _parseStream(string $sdata): int
    {
        // $idx                    is a int;
        $udat = [];             // intArr;
        $dat = [];              // floatArr;
        if ($this->_isLoaded && !($this->_isClosed)) {
            return YAPI::SUCCESS;
        }
        if (strlen($sdata) == 0) {
            $this->_nRows = 0;
            return YAPI::SUCCESS;
        }

        $udat = YAPI::_decodeWords($this->_parent->_json_get_string($sdata));
        while (sizeof($this->_values) > 0) {
            array_pop($this->_values);
        };
        $idx = 0;
        if ($this->_isAvg) {
            while ($idx + 3 < sizeof($udat)) {
                while (sizeof($dat) > 0) {
                    array_pop($dat);
                };
                if (($udat[$idx] == 65535) && ($udat[$idx + 1] == 65535)) {
                    $dat[] = NAN;
                    $dat[] = NAN;
                    $dat[] = NAN;
                } else {
                    $dat[] = $this->_decodeVal($udat[$idx + 2] + ((($udat[$idx + 3]) << (16))));
                    $dat[] = $this->_decodeAvg($udat[$idx] + ((((($udat[$idx + 1]) ^ (0x8000))) << (16))), 1);
                    $dat[] = $this->_decodeVal($udat[$idx + 4] + ((($udat[$idx + 5]) << (16))));
                }
                $idx = $idx + 6;
                $this->_values[] = $dat;
            }
        } else {
            while ($idx + 1 < sizeof($udat)) {
                while (sizeof($dat) > 0) {
                    array_pop($dat);
                };
                if (($udat[$idx] == 65535) && ($udat[$idx + 1] == 65535)) {
                    $dat[] = NAN;
                } else {
                    $dat[] = $this->_decodeAvg($udat[$idx] + ((((($udat[$idx + 1]) ^ (0x8000))) << (16))), 1);
                }
                $this->_values[] = $dat;
                $idx = $idx + 2;
            }
        }

        $this->_nRows = sizeof($this->_values);
        $this->_isLoaded = true;
        return YAPI::SUCCESS;
    }

    public function _wasLoaded(): bool
    {
        return $this->_isLoaded;
    }

    public function _get_url(): string
    {
        // $url                    is a str;
        $url = sprintf('logger.json?id=%s&run=%d&utc=%u',
                       $this->_functionId,$this->_runNo,$this->_utcStamp);
        return $url;
    }

    public function _get_baseurl(): string
    {
        // $url                    is a str;
        $url = sprintf('logger.json?id=%s&run=%d&utc=',
                       $this->_functionId,$this->_runNo);
        return $url;
    }

    public function _get_urlsuffix(): string
    {
        // $url                    is a str;
        $url = sprintf('%u',$this->_utcStamp);
        return $url;
    }

    public function loadStream(): int
    {
        return $this->_parseStream($this->_parent->_download($this->_get_url()));
    }

    public function _decodeVal(int $w): float
    {
        // $val                    is a float;
        $val = $w;
        $val = $val / 1000.0;
        if ($this->_caltyp != 0) {
            if (!is_null($this->_calhdl)) {
                $val = call_user_func($this->_calhdl, $val, $this->_caltyp, $this->_calpar, $this->_calraw, $this->_calref);
            }
        }
        return $val;
    }

    public function _decodeAvg(int $dw, int $count): float
    {
        // $val                    is a float;
        $val = $dw;
        $val = $val / 1000.0;
        if ($this->_caltyp != 0) {
            if (!is_null($this->_calhdl)) {
                $val = call_user_func($this->_calhdl, $val, $this->_caltyp, $this->_calpar, $this->_calraw, $this->_calref);
            }
        }
        return $val;
    }

    public function isClosed(): bool
    {
        return $this->_isClosed;
    }

    /**
     * Returns the run index of the data stream. A run can be made of
     * multiple datastreams, for different time intervals.
     *
     * @return int  an unsigned number corresponding to the run index.
     */
    public function get_runIndex(): int
    {
        return $this->_runNo;
    }

    /**
     * Returns the relative start time of the data stream, measured in seconds.
     * For recent firmwares, the value is relative to the present time,
     * which means the value is always negative.
     * If the device uses a firmware older than version 13000, value is
     * relative to the start of the time the device was powered on, and
     * is always positive.
     * If you need an absolute UTC timestamp, use get_realStartTimeUTC().
     *
     * <b>DEPRECATED</b>: This method has been replaced by get_realStartTimeUTC().
     *
     * @return int  an unsigned number corresponding to the number of seconds
     *         between the start of the run and the beginning of this data
     *         stream.
     */
    public function get_startTime(): int
    {
        return $this->_utcStamp - time();
    }

    /**
     * Returns the start time of the data stream, relative to the Jan 1, 1970.
     * If the UTC time was not set in the datalogger at the time of the recording
     * of this data stream, this method returns 0.
     *
     * <b>DEPRECATED</b>: This method has been replaced by get_realStartTimeUTC().
     *
     * @return float  an unsigned number corresponding to the number of seconds
     *         between the Jan 1, 1970 and the beginning of this data
     *         stream (i.e. Unix time representation of the absolute time).
     */
    public function get_startTimeUTC(): float
    {
        return round($this->_startTime);
    }

    /**
     * Returns the start time of the data stream, relative to the Jan 1, 1970.
     * If the UTC time was not set in the datalogger at the time of the recording
     * of this data stream, this method returns 0.
     *
     * @return float  a floating-point number  corresponding to the number of seconds
     *         between the Jan 1, 1970 and the beginning of this data
     *         stream (i.e. Unix time representation of the absolute time).
     */
    public function get_realStartTimeUTC(): float
    {
        return $this->_startTime;
    }

    /**
     * Returns the number of milliseconds between two consecutive
     * rows of this data stream. By default, the data logger records one row
     * per second, but the recording frequency can be changed for
     * each device function
     *
     * @return int  an unsigned number corresponding to a number of milliseconds.
     */
    public function get_dataSamplesIntervalMs(): int
    {
        return round($this->_dataSamplesInterval*1000);
    }

    public function get_dataSamplesInterval(): float
    {
        return $this->_dataSamplesInterval;
    }

    public function get_firstDataSamplesInterval(): float
    {
        return $this->_firstMeasureDuration;
    }

    /**
     * Returns the number of data rows present in this stream.
     *
     * If the device uses a firmware older than version 13000,
     * this method fetches the whole data stream from the device
     * if not yet done, which can cause a little delay.
     *
     * @return int  an unsigned number corresponding to the number of rows.
     *
     * On failure, throws an exception or returns zero.
     */
    public function get_rowCount(): int
    {
        if (($this->_nRows != 0) && $this->_isClosed) {
            return $this->_nRows;
        }
        $this->loadStream();
        return $this->_nRows;
    }

    /**
     * Returns the number of data columns present in this stream.
     * The meaning of the values present in each column can be obtained
     * using the method get_columnNames().
     *
     * If the device uses a firmware older than version 13000,
     * this method fetches the whole data stream from the device
     * if not yet done, which can cause a little delay.
     *
     * @return int  an unsigned number corresponding to the number of columns.
     *
     * On failure, throws an exception or returns zero.
     */
    public function get_columnCount(): int
    {
        if ($this->_nCols != 0) {
            return $this->_nCols;
        }
        $this->loadStream();
        return $this->_nCols;
    }

    /**
     * Returns the title (or meaning) of each data column present in this stream.
     * In most case, the title of the data column is the hardware identifier
     * of the sensor that produced the data. For streams recorded at a lower
     * recording rate, the dataLogger stores the min, average and max value
     * during each measure interval into three columns with suffixes _min,
     * _avg and _max respectively.
     *
     * If the device uses a firmware older than version 13000,
     * this method fetches the whole data stream from the device
     * if not yet done, which can cause a little delay.
     *
     * @return string[]  a list containing as many strings as there are columns in the
     *         data stream.
     *
     * On failure, throws an exception or returns an empty array.
     */
    public function get_columnNames(): array
    {
        if (sizeof($this->_columnNames) != 0) {
            return $this->_columnNames;
        }
        $this->loadStream();
        return $this->_columnNames;
    }

    /**
     * Returns the smallest measure observed within this stream.
     * If the device uses a firmware older than version 13000,
     * this method will always return YDataStream::DATA_INVALID.
     *
     * @return float  a floating-point number corresponding to the smallest value,
     *         or YDataStream::DATA_INVALID if the stream is not yet complete (still recording).
     *
     * On failure, throws an exception or returns YDataStream::DATA_INVALID.
     */
    public function get_minValue(): float
    {
        return $this->_minVal;
    }

    /**
     * Returns the average of all measures observed within this stream.
     * If the device uses a firmware older than version 13000,
     * this method will always return YDataStream::DATA_INVALID.
     *
     * @return float  a floating-point number corresponding to the average value,
     *         or YDataStream::DATA_INVALID if the stream is not yet complete (still recording).
     *
     * On failure, throws an exception or returns YDataStream::DATA_INVALID.
     */
    public function get_averageValue(): float
    {
        return $this->_avgVal;
    }

    /**
     * Returns the largest measure observed within this stream.
     * If the device uses a firmware older than version 13000,
     * this method will always return YDataStream::DATA_INVALID.
     *
     * @return float  a floating-point number corresponding to the largest value,
     *         or YDataStream::DATA_INVALID if the stream is not yet complete (still recording).
     *
     * On failure, throws an exception or returns YDataStream::DATA_INVALID.
     */
    public function get_maxValue(): float
    {
        return $this->_maxVal;
    }

    public function get_realDuration(): float
    {
        if ($this->_isClosed) {
            return $this->_duration;
        }
        return time() - $this->_utcStamp;
    }

    /**
     * Returns the whole data set contained in the stream, as a bidimensional
     * table of numbers.
     * The meaning of the values present in each column can be obtained
     * using the method get_columnNames().
     *
     * This method fetches the whole data stream from the device,
     * if not yet done.
     *
     * @return float[][]  a list containing as many elements as there are rows in the
     *         data stream. Each row itself is a list of floating-point
     *         numbers.
     *
     * On failure, throws an exception or returns an empty array.
     */
    public function get_dataRows(): array
    {
        if ((sizeof($this->_values) == 0) || !($this->_isClosed)) {
            $this->loadStream();
        }
        return $this->_values;
    }

    /**
     * Returns a single measure from the data stream, specified by its
     * row and column index.
     * The meaning of the values present in each column can be obtained
     * using the method get_columnNames().
     *
     * This method fetches the whole data stream from the device,
     * if not yet done.
     *
     * @param int $row : row index
     * @param int $col : column index
     *
     * @return float  a floating-point number
     *
     * On failure, throws an exception or returns YDataStream::DATA_INVALID.
     */
    public function get_data(int $row, int $col): float
    {
        if ((sizeof($this->_values) == 0) || !($this->_isClosed)) {
            $this->loadStream();
        }
        if ($row >= sizeof($this->_values)) {
            return self::DATA_INVALID;
        }
        if ($col >= sizeof($this->_values[$row])) {
            return self::DATA_INVALID;
        }
        return $this->_values[$row][$col];
    }

    //--- (end of generated code: YDataStream implementation)
}

