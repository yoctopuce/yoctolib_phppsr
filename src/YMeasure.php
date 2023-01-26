<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YMeasure Class: Measured value, returned in particular by the methods of the YDataSet class.
 *
 * YMeasure objects are used within the API to represent
 * a value measured at a specified time. These objects are
 * used in particular in conjunction with the YDataSet class,
 * but also for sensors periodic timed reports
 * (see sensor.registerTimedReportCallback).
 */
class YMeasure
{
    //--- (end of generated code: YMeasure declaration)
    const DATA_INVALID = YAPI::INVALID_DOUBLE;

    //--- (generated code: YMeasure attributes)
    protected float $_start = 0;                            // float
    protected float $_end = 0;                            // float
    protected float $_minVal = 0;                            // float
    protected float $_avgVal = 0;                            // float
    protected float $_maxVal = 0;                            // float

    //--- (end of generated code: YMeasure attributes)

    public function __construct($float_start, $float_end, $float_minVal, $float_avgVal, $float_maxVal)
    {
        //--- (generated code: YMeasure constructor)
        //--- (end of generated code: YMeasure constructor)

        $this->_start = $float_start;
        $this->_end = $float_end;
        $this->_minVal = $float_minVal;
        $this->_avgVal = $float_avgVal;
        $this->_maxVal = $float_maxVal;
    }

    //--- (generated code: YMeasure implementation)

    /**
     * Returns the start time of the measure, relative to the Jan 1, 1970 UTC
     * (Unix timestamp). When the recording rate is higher then 1 sample
     * per second, the timestamp may have a fractional part.
     *
     * @return float  a floating point number corresponding to the number of seconds
     *         between the Jan 1, 1970 UTC and the beginning of this measure.
     */
    public function get_startTimeUTC(): float
    {
        return $this->_start;
    }

    /**
     * Returns the end time of the measure, relative to the Jan 1, 1970 UTC
     * (Unix timestamp). When the recording rate is higher than 1 sample
     * per second, the timestamp may have a fractional part.
     *
     * @return float  a floating point number corresponding to the number of seconds
     *         between the Jan 1, 1970 UTC and the end of this measure.
     */
    public function get_endTimeUTC(): float
    {
        return $this->_end;
    }

    /**
     * Returns the smallest value observed during the time interval
     * covered by this measure.
     *
     * @return float  a floating-point number corresponding to the smallest value observed.
     */
    public function get_minValue(): float
    {
        return $this->_minVal;
    }

    /**
     * Returns the average value observed during the time interval
     * covered by this measure.
     *
     * @return float  a floating-point number corresponding to the average value observed.
     */
    public function get_averageValue(): float
    {
        return $this->_avgVal;
    }

    /**
     * Returns the largest value observed during the time interval
     * covered by this measure.
     *
     * @return float  a floating-point number corresponding to the largest value observed.
     */
    public function get_maxValue(): float
    {
        return $this->_maxVal;
    }

    //--- (end of generated code: YMeasure implementation)
}

