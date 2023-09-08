<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YInputCaptureData Class: Sampled data from a Yoctopuce electrical sensor
 *
 * InputCaptureData objects represent raw data
 * sampled by the analog/digital converter present in
 * a Yoctopuce electrical sensor. When several inputs
 * are samples simultaneously, their data are provided
 * as distinct series.
 */
class YInputCaptureData
{
    //--- (end of generated code: YInputCaptureData declaration)

    //--- (generated code: YInputCaptureData attributes)
    protected int $_fmt = 0;                            // int
    protected int $_var1size = 0;                            // int
    protected int $_var2size = 0;                            // int
    protected int $_var3size = 0;                            // int
    protected int $_nVars = 0;                            // int
    protected int $_recOfs = 0;                            // int
    protected int $_nRecs = 0;                            // int
    protected int $_samplesPerSec = 0;                            // int
    protected int $_trigType = 0;                            // int
    protected float $_trigVal = 0;                            // float
    protected int $_trigPos = 0;                            // int
    protected float $_trigUTC = 0;                            // float
    protected string $_var1unit = "";                           // string
    protected string $_var2unit = "";                           // string
    protected string $_var3unit = "";                           // string
    protected array $_var1samples = [];                           // floatArr
    protected array $_var2samples = [];                           // floatArr
    protected array $_var3samples = [];                           // floatArr

    //--- (end of generated code: YInputCaptureData attributes)

    function __construct(YFunction $yfun, string $sdata)
    {
        //--- (generated code: YInputCaptureData constructor)
        //--- (end of generated code: YInputCaptureData constructor)
        $this->_decodeSnapBin($sdata);
    }

    /**
     * @param int $int_errType
     * @param string $str_errMsg
     * @param mixed $obj_retVal
     * @return mixed
     * @throws YAPI_Exception
     */
    protected function _throw(int $int_errType, string $str_errMsg, mixed $obj_retVal): mixed
    {
        if (YAPI::$exceptionsDisabled) {
            return $obj_retVal;
        }
        // throw an exception
        throw new YAPI_Exception($str_errMsg, $int_errType);
    }

    //--- (generated code: YInputCaptureData implementation)

    /**
     * @throws YAPI_Exception on error
     */
    public function _decodeU16(string $sdata, int $ofs): int
    {
        // $v                      is a int;
        $v = ord($sdata[$ofs]);
        $v = $v + 256 * ord($sdata[$ofs+1]);
        return $v;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _decodeU32(string $sdata, int $ofs): float
    {
        // $v                      is a float;
        $v = $this->_decodeU16($sdata, $ofs);
        $v = $v + 65536.0 * $this->_decodeU16($sdata, $ofs+2);
        return $v;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _decodeVal(string $sdata, int $ofs, int $len): float
    {
        // $v                      is a float;
        // $b                      is a float;
        $v = $this->_decodeU16($sdata, $ofs);
        $b = 65536.0;
        $ofs = $ofs + 2;
        $len = $len - 2;
        while ($len > 0) {
            $v = $v + $b * ord($sdata[$ofs]);
            $b = $b * 256;
            $ofs = $ofs + 1;
            $len = $len - 1;
        }
        if ($v > ($b/2)) {
            // negative number
            $v = $v - $b;
        }
        return $v;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _decodeSnapBin(string $sdata): int
    {
        // $buffSize               is a int;
        // $recOfs                 is a int;
        // $ms                     is a int;
        // $recSize                is a int;
        // $count                  is a int;
        // $mult1                  is a int;
        // $mult2                  is a int;
        // $mult3                  is a int;
        // $v                      is a float;

        $buffSize = strlen($sdata);
        if (!($buffSize >= 24)) return $this->_throw( YAPI::INVALID_ARGUMENT, 'Invalid snapshot data (too short)',YAPI::INVALID_ARGUMENT);
        $this->_fmt = ord($sdata[0]);
        $this->_var1size = ord($sdata[1]) - 48;
        $this->_var2size = ord($sdata[2]) - 48;
        $this->_var3size = ord($sdata[3]) - 48;
        if (!($this->_fmt == 83)) return $this->_throw( YAPI::INVALID_ARGUMENT, 'Unsupported snapshot format',YAPI::INVALID_ARGUMENT);
        if (!(($this->_var1size >= 2) && ($this->_var1size <= 4))) return $this->_throw( YAPI::INVALID_ARGUMENT, 'Invalid sample size',YAPI::INVALID_ARGUMENT);
        if (!(($this->_var2size >= 0) && ($this->_var1size <= 4))) return $this->_throw( YAPI::INVALID_ARGUMENT, 'Invalid sample size',YAPI::INVALID_ARGUMENT);
        if (!(($this->_var3size >= 0) && ($this->_var1size <= 4))) return $this->_throw( YAPI::INVALID_ARGUMENT, 'Invalid sample size',YAPI::INVALID_ARGUMENT);
        if ($this->_var2size == 0) {
            $this->_nVars = 1;
        } else {
            if ($this->_var3size == 0) {
                $this->_nVars = 2;
            } else {
                $this->_nVars = 3;
            }
        }
        $recSize = $this->_var1size + $this->_var2size + $this->_var3size;
        $this->_recOfs = $this->_decodeU16($sdata, 4);
        $this->_nRecs = $this->_decodeU16($sdata, 6);
        $this->_samplesPerSec = $this->_decodeU16($sdata, 8);
        $this->_trigType = $this->_decodeU16($sdata, 10);
        $this->_trigVal = $this->_decodeVal($sdata, 12, 4) / 1000;
        $this->_trigPos = $this->_decodeU16($sdata, 16);
        $ms = $this->_decodeU16($sdata, 18);
        $this->_trigUTC = $this->_decodeVal($sdata, 20, 4);
        $this->_trigUTC = $this->_trigUTC + ($ms / 1000.0);
        $recOfs = 24;
        while (ord($sdata[$recOfs]) >= 32) {
            $this->_var1unit = sprintf('%s%c', $this->_var1unit, ord($sdata[$recOfs]));
            $recOfs = $recOfs + 1;
        }
        if ($this->_var2size > 0) {
            $recOfs = $recOfs + 1;
            while (ord($sdata[$recOfs]) >= 32) {
                $this->_var2unit = sprintf('%s%c', $this->_var2unit, ord($sdata[$recOfs]));
                $recOfs = $recOfs + 1;
            }
        }
        if ($this->_var3size > 0) {
            $recOfs = $recOfs + 1;
            while (ord($sdata[$recOfs]) >= 32) {
                $this->_var3unit = sprintf('%s%c', $this->_var3unit, ord($sdata[$recOfs]));
                $recOfs = $recOfs + 1;
            }
        }
        if ((($recOfs) & (1)) == 1) {
            // align to next word
            $recOfs = $recOfs + 1;
        }
        $mult1 = 1;
        $mult2 = 1;
        $mult3 = 1;
        if ($recOfs < $this->_recOfs) {
            // load optional value multiplier
            $mult1 = $this->_decodeU16($sdata, $this->_recOfs);
            $recOfs = $recOfs + 2;
            if ($this->_var2size > 0) {
                $mult2 = $this->_decodeU16($sdata, $this->_recOfs);
                $recOfs = $recOfs + 2;
            }
            if ($this->_var3size > 0) {
                $mult3 = $this->_decodeU16($sdata, $this->_recOfs);
                $recOfs = $recOfs + 2;
            }
        }
        $recOfs = $this->_recOfs;
        $count = $this->_nRecs;
        while (($count > 0) && ($recOfs + $this->_var1size <= $buffSize)) {
            $v = $this->_decodeVal($sdata, $recOfs, $this->_var1size) / 1000.0;
            $this->_var1samples[] = $v*$mult1;
            $recOfs = $recOfs + $recSize;
        }
        if ($this->_var2size > 0) {
            $recOfs = $this->_recOfs + $this->_var1size;
            $count = $this->_nRecs;
            while (($count > 0) && ($recOfs + $this->_var2size <= $buffSize)) {
                $v = $this->_decodeVal($sdata, $recOfs, $this->_var2size) / 1000.0;
                $this->_var2samples[] = $v*$mult2;
                $recOfs = $recOfs + $recSize;
            }
        }
        if ($this->_var3size > 0) {
            $recOfs = $this->_recOfs + $this->_var1size + $this->_var2size;
            $count = $this->_nRecs;
            while (($count > 0) && ($recOfs + $this->_var3size <= $buffSize)) {
                $v = $this->_decodeVal($sdata, $recOfs, $this->_var3size) / 1000.0;
                $this->_var3samples[] = $v*$mult3;
                $recOfs = $recOfs + $recSize;
            }
        }
        return YAPI::SUCCESS;
    }

    /**
     * Returns the number of series available in the capture.
     *
     * @return int  an integer corresponding to the number of
     *         simultaneous data series available.
     */
    public function get_serieCount(): int
    {
        return $this->_nVars;
    }

    /**
     * Returns the number of records captured (in a serie).
     * In the exceptional case where it was not possible
     * to transfer all data in time, the number of records
     * actually present in the series might be lower than
     * the number of records captured
     *
     * @return int  an integer corresponding to the number of
     *         records expected in each serie.
     */
    public function get_recordCount(): int
    {
        return $this->_nRecs;
    }

    /**
     * Returns the effective sampling rate of the device.
     *
     * @return int  an integer corresponding to the number of
     *         samples taken each second.
     */
    public function get_samplingRate(): int
    {
        return $this->_samplesPerSec;
    }

    /**
     * Returns the type of automatic conditional capture
     * that triggered the capture of this data sequence.
     *
     * @return int  the type of conditional capture.
     */
    public function get_captureType(): int
    {
        return $this->_trigType;
    }

    /**
     * Returns the threshold value that triggered
     * this automatic conditional capture, if it was
     * not an instant captured triggered manually.
     *
     * @return float  the conditional threshold value
     *         at the time of capture.
     */
    public function get_triggerValue(): float
    {
        return $this->_trigVal;
    }

    /**
     * Returns the index in the series of the sample
     * corresponding to the exact time when the capture
     * was triggered. In case of trigger based on average
     * or RMS value, the trigger index corresponds to
     * the end of the averaging period.
     *
     * @return int  an integer corresponding to a position
     *         in the data serie.
     */
    public function get_triggerPosition(): int
    {
        return $this->_trigPos;
    }

    /**
     * Returns the absolute time when the capture was
     * triggered, as a Unix timestamp. Milliseconds are
     * included in this timestamp (floating-point number).
     *
     * @return float  a floating-point number corresponding to
     *         the number of seconds between the Jan 1,
     *         1970 and the moment where the capture
     *         was triggered.
     */
    public function get_triggerRealTimeUTC(): float
    {
        return $this->_trigUTC;
    }

    /**
     * Returns the unit of measurement for data points in
     * the first serie.
     *
     * @return string  a string containing to a physical unit of
     *         measurement.
     */
    public function get_serie1Unit(): string
    {
        return $this->_var1unit;
    }

    /**
     * Returns the unit of measurement for data points in
     * the second serie.
     *
     * @return string  a string containing to a physical unit of
     *         measurement.
     */
    public function get_serie2Unit(): string
    {
        if (!($this->_nVars >= 2)) return $this->_throw( YAPI::INVALID_ARGUMENT, 'There is no serie 2 in $this capture data','');
        return $this->_var2unit;
    }

    /**
     * Returns the unit of measurement for data points in
     * the third serie.
     *
     * @return string  a string containing to a physical unit of
     *         measurement.
     */
    public function get_serie3Unit(): string
    {
        if (!($this->_nVars >= 3)) return $this->_throw( YAPI::INVALID_ARGUMENT, 'There is no serie 3 in $this capture data','');
        return $this->_var3unit;
    }

    /**
     * Returns the sampled data corresponding to the first serie.
     * The corresponding physical unit can be obtained
     * using the method get_serie1Unit().
     *
     * @return float[]  a list of real numbers corresponding to all
     *         samples received for serie 1.
     *
     * On failure, throws an exception or returns an empty array.
     * @throws YAPI_Exception on error
     */
    public function get_serie1Values(): array
    {
        return $this->_var1samples;
    }

    /**
     * Returns the sampled data corresponding to the second serie.
     * The corresponding physical unit can be obtained
     * using the method get_serie2Unit().
     *
     * @return float[]  a list of real numbers corresponding to all
     *         samples received for serie 2.
     *
     * On failure, throws an exception or returns an empty array.
     * @throws YAPI_Exception on error
     */
    public function get_serie2Values(): array
    {
        if (!($this->_nVars >= 2)) return $this->_throw( YAPI::INVALID_ARGUMENT, 'There is no serie 2 in $this capture data',$this->_var2samples);
        return $this->_var2samples;
    }

    /**
     * Returns the sampled data corresponding to the third serie.
     * The corresponding physical unit can be obtained
     * using the method get_serie3Unit().
     *
     * @return float[]  a list of real numbers corresponding to all
     *         samples received for serie 3.
     *
     * On failure, throws an exception or returns an empty array.
     * @throws YAPI_Exception on error
     */
    public function get_serie3Values(): array
    {
        if (!($this->_nVars >= 3)) return $this->_throw( YAPI::INVALID_ARGUMENT, 'There is no serie 3 in $this capture data',$this->_var3samples);
        return $this->_var3samples;
    }

    //--- (end of generated code: YInputCaptureData implementation)
}

