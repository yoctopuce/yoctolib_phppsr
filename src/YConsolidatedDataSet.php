<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YConsolidatedDataSet Class: Cross-sensor consolidated data sequence.
 *
 * YConsolidatedDataSet objects make it possible to retrieve a set of
 * recorded measures from multiple sensors, for a specified time interval.
 * They can be used to load data points progressively, and to receive
 * data records by timestamp, one by one..
 */
class YConsolidatedDataSet
{
    //--- (end of generated code: YConsolidatedDataSet declaration)

    //--- (generated code: YConsolidatedDataSet attributes)
    protected float $_start = 0;                            // float
    protected float $_end = 0;                            // float
    protected int $_nsensors = 0;                            // int
    protected array $_sensors = [];                           // YSensorArr
    protected array $_datasets = [];                           // YDataSetArr
    protected array $_progresss = [];                           // intArr
    protected array $_nextidx = [];                           // intArr
    protected array $_nexttim = [];                           // floatArr

    //--- (end of generated code: YConsolidatedDataSet attributes)

    public function __construct(float $float_startTime, float $float_endTime, array $obj_sensorList)
    {
        //--- (generated code: YConsolidatedDataSet constructor)
        //--- (end of generated code: YConsolidatedDataSet constructor)
        $this->imm_init($float_startTime, $float_endTime, $obj_sensorList);
    }

    //--- (generated code: YConsolidatedDataSet implementation)

    /**
     * @throws YAPI_Exception on error
     */
    public function imm_init(float $startt, float $endt, array $sensorList): int
    {
        $this->_start = $startt;
        $this->_end = $endt;
        $this->_sensors = $sensorList;
        $this->_nsensors = -1;
        return YAPI::SUCCESS;
    }

    /**
     * Returns an object holding historical data for multiple
     * sensors, for a specified time interval.
     * The measures will be retrieved from the data logger, which must have been turned
     * on at the desired time. The resulting object makes it possible to load progressively
     * a large set of measures from multiple sensors, consolidating data on the fly
     * to align records based on measurement timestamps.
     *
     * @param string[] $sensorNames : array of logical names or hardware identifiers of the sensors
     *         for which data must be loaded from their data logger.
     * @param float $startTime : the start of the desired measure time interval,
     *         as a Unix timestamp, i.e. the number of seconds since
     *         January 1, 1970 UTC. The special value 0 can be used
     *         to include any measure, without initial limit.
     * @param float $endTime : the end of the desired measure time interval,
     *         as a Unix timestamp, i.e. the number of seconds since
     *         January 1, 1970 UTC. The special value 0 can be used
     *         to include any measure, without ending limit.
     *
     * @return ?YConsolidatedDataSet  an instance of YConsolidatedDataSet, providing access to
     *         consolidated historical data. Records can be loaded progressively
     *         using the YConsolidatedDataSet::nextRecord() method.
     */
    public static function Init(array $sensorNames, float $startTime, float $endTime): ?YConsolidatedDataSet
    {
        // $nSensors               is a int;
        $sensorList = [];       // YSensorArr;
        // $idx                    is a int;
        // $sensorName             is a str;
        // $s                      is a YSensor;
        // $obj                    is a YConsolidatedDataSet;
        $nSensors = sizeof($sensorNames);
        while (sizeof($sensorList) > 0) {
            array_pop($sensorList);
        };
        $idx = 0;
        while ($idx < $nSensors) {
            $sensorName = $sensorNames[$idx];
            $s = YSensor::FindSensor($sensorName);
            $sensorList[] = $s;
            $idx = $idx + 1;
        }
        $obj = new YConsolidatedDataSet($startTime, $endTime, $sensorList);
        return $obj;
    }

    /**
     * Extracts the next data record from the data logger of all sensors linked to this
     * object.
     *
     * @param float[] $datarec : array of floating point numbers, that will be filled by the
     *         function with the timestamp of the measure in first position,
     *         followed by the measured value in next positions.
     *
     * @return int  an integer in the range 0 to 100 (percentage of completion),
     *         or a negative error code in case of failure.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function nextRecord(array &$datarec): int
    {
        // $s                      is a int;
        // $idx                    is a int;
        // $sensor                 is a YSensor;
        // $newdataset             is a YDataSet;
        // $globprogress           is a int;
        // $currprogress           is a int;
        // $currnexttim            is a float;
        // $newvalue               is a float;
        $measures = [];         // YMeasureArr;
        // $nexttime               is a float;
        //
        // Ensure the dataset have been retrieved
        //
        if ($this->_nsensors == -1) {
            $this->_nsensors = sizeof($this->_sensors);
            while (sizeof($this->_datasets) > 0) {
                array_pop($this->_datasets);
            };
            while (sizeof($this->_progresss) > 0) {
                array_pop($this->_progresss);
            };
            while (sizeof($this->_nextidx) > 0) {
                array_pop($this->_nextidx);
            };
            while (sizeof($this->_nexttim) > 0) {
                array_pop($this->_nexttim);
            };
            $s = 0;
            while ($s < $this->_nsensors) {
                $sensor = $this->_sensors[$s];
                $newdataset = $sensor->get_recordedData($this->_start, $this->_end);
                $this->_datasets[] = $newdataset;
                $this->_progresss[] = 0;
                $this->_nextidx[] = 0;
                $this->_nexttim[] = 0.0;
                $s = $s + 1;
            }
        }
        while (sizeof($datarec) > 0) {
            array_pop($datarec);
        };
        //
        // Find next timestamp to process
        //
        $nexttime = 0;
        $s = 0;
        while ($s < $this->_nsensors) {
            $currnexttim = $this->_nexttim[$s];
            if ($currnexttim == 0) {
                $idx = $this->_nextidx[$s];
                $measures = $this->_datasets[$s]->get_measures();
                $currprogress = $this->_progresss[$s];
                while (($idx >= sizeof($measures)) && ($currprogress < 100)) {
                    $currprogress = $this->_datasets[$s]->loadMore();
                    if ($currprogress < 0) {
                        $currprogress = 100;
                    }
                    $this->_progresss[$s] = $currprogress;
                    $measures = $this->_datasets[$s]->get_measures();
                }
                if ($idx < sizeof($measures)) {
                    $currnexttim = $measures[$idx]->get_endTimeUTC();
                    $this->_nexttim[$s] = $currnexttim;
                }
            }
            if ($currnexttim > 0) {
                if (($nexttime == 0) || ($nexttime > $currnexttim)) {
                    $nexttime = $currnexttim;
                }
            }
            $s = $s + 1;
        }
        if ($nexttime == 0) {
            return 100;
        }
        //
        // Extract data for $this timestamp
        //
        while (sizeof($datarec) > 0) {
            array_pop($datarec);
        };
        $datarec[] = $nexttime;
        $globprogress = 0;
        $s = 0;
        while ($s < $this->_nsensors) {
            if ($this->_nexttim[$s] == $nexttime) {
                $idx = $this->_nextidx[$s];
                $measures = $this->_datasets[$s]->get_measures();
                $newvalue = $measures[$idx]->get_averageValue();
                $datarec[] = $newvalue;
                $this->_nexttim[$s] = 0.0;
                $this->_nextidx[$s] = $idx+1;
            } else {
                $datarec[] = NAN;
            }
            $currprogress = $this->_progresss[$s];
            $globprogress = $globprogress + $currprogress;
            $s = $s + 1;
        }
        if ($globprogress > 0) {
            $globprogress = intVal(($globprogress) / ($this->_nsensors));
            if ($globprogress > 99) {
                $globprogress = 99;
            }
        }
        return $globprogress;
    }

    //--- (end of generated code: YConsolidatedDataSet implementation)
}

