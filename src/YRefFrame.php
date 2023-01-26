<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YRefFrame Class: 3D reference frame configuration interface, available for instance in the
 * Yocto-3D-V2 or the Yocto-Inclinometer
 *
 * The YRefFrame class is used to setup the base orientation of the Yoctopuce inertial
 * sensors. Thanks to this, orientation functions relative to the earth surface plane
 * can use the proper reference frame. For some devices, the class also implements a
 * tridimensional sensor calibration process, which can compensate for local variations
 * of standard gravity and improve the precision of the tilt sensors.
 */
class YRefFrame extends YFunction
{
    const MOUNTPOS_INVALID = YAPI::INVALID_UINT;
    const BEARING_INVALID = YAPI::INVALID_DOUBLE;
    const CALIBRATIONPARAM_INVALID = YAPI::INVALID_STRING;
    const FUSIONMODE_NDOF = 0;
    const FUSIONMODE_NDOF_FMC_OFF = 1;
    const FUSIONMODE_M4G = 2;
    const FUSIONMODE_COMPASS = 3;
    const FUSIONMODE_IMU = 4;
    const FUSIONMODE_INCLIN_90DEG_1G8 = 5;
    const FUSIONMODE_INCLIN_90DEG_3G6 = 6;
    const FUSIONMODE_INCLIN_10DEG = 7;
    const FUSIONMODE_INVALID = -1;
    const MOUNTPOSITION_BOTTOM           = 0;
    const MOUNTPOSITION_TOP              = 1;
    const MOUNTPOSITION_FRONT            = 2;
    const MOUNTPOSITION_REAR             = 3;
    const MOUNTPOSITION_RIGHT            = 4;
    const MOUNTPOSITION_LEFT             = 5;
    const MOUNTPOSITION_INVALID          = 6;
    const MOUNTORIENTATION_TWELVE        = 0;
    const MOUNTORIENTATION_THREE         = 1;
    const MOUNTORIENTATION_SIX           = 2;
    const MOUNTORIENTATION_NINE          = 3;
    const MOUNTORIENTATION_INVALID       = 4;
    //--- (end of YRefFrame declaration)

    //--- (YRefFrame attributes)
    protected int $_mountPos = self::MOUNTPOS_INVALID;       // UInt31
    protected float $_bearing = self::BEARING_INVALID;        // MeasureVal
    protected string $_calibrationParam = self::CALIBRATIONPARAM_INVALID; // CalibParams
    protected int $_fusionMode = self::FUSIONMODE_INVALID;     // FusionModeTypeAll
    protected bool $_calibV2 = false;                        // bool
    protected int $_calibStage = 0;                            // int
    protected string $_calibStageHint = "";                           // str
    protected int $_calibStageProgress = 0;                            // int
    protected int $_calibProgress = 0;                            // int
    protected string $_calibLogMsg = "";                           // str
    protected string $_calibSavedParams = "";                           // str
    protected int $_calibCount = 0;                            // int
    protected int $_calibInternalPos = 0;                            // int
    protected int $_calibPrevTick = 0;                            // int
    protected array $_calibOrient = [];                           // intArr
    protected array $_calibDataAccX = [];                           // floatArr
    protected array $_calibDataAccY = [];                           // floatArr
    protected array $_calibDataAccZ = [];                           // floatArr
    protected array $_calibDataAcc = [];                           // floatArr
    protected float $_calibAccXOfs = 0;                            // float
    protected float $_calibAccYOfs = 0;                            // float
    protected float $_calibAccZOfs = 0;                            // float
    protected float $_calibAccXScale = 0;                            // float
    protected float $_calibAccYScale = 0;                            // float
    protected float $_calibAccZScale = 0;                            // float

    //--- (end of YRefFrame attributes)

    function __construct($str_func)
    {
        //--- (YRefFrame constructor)
        parent::__construct($str_func);
        $this->_className = 'RefFrame';

        //--- (end of YRefFrame constructor)
    }

    //--- (YRefFrame implementation)

    function _parseAttr($name, $val): int
    {
        switch ($name) {
        case 'mountPos':
            $this->_mountPos = intval($val);
            return 1;
        case 'bearing':
            $this->_bearing = round($val / 65.536) / 1000.0;
            return 1;
        case 'calibrationParam':
            $this->_calibrationParam = $val;
            return 1;
        case 'fusionMode':
            $this->_fusionMode = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    public function get_mountPos(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::MOUNTPOS_INVALID;
            }
        }
        $res = $this->_mountPos;
        return $res;
    }

    public function set_mountPos(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("mountPos", $rest_val);
    }

    /**
     * Changes the reference bearing used by the compass. The relative bearing
     * indicated by the compass is the difference between the measured magnetic
     * heading and the reference bearing indicated here.
     *
     * For instance, if you setup as reference bearing the value of the earth
     * magnetic declination, the compass will provide the orientation relative
     * to the geographic North.
     *
     * Similarly, when the sensor is not mounted along the standard directions
     * because it has an additional yaw angle, you can set this angle in the reference
     * bearing so that the compass provides the expected natural direction.
     *
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * @param float $newval : a floating point number corresponding to the reference bearing used by the compass
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_bearing(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("bearing", $rest_val);
    }

    /**
     * Returns the reference bearing used by the compass. The relative bearing
     * indicated by the compass is the difference between the measured magnetic
     * heading and the reference bearing indicated here.
     *
     * @return float  a floating point number corresponding to the reference bearing used by the compass
     *
     * On failure, throws an exception or returns YRefFrame::BEARING_INVALID.
     */
    public function get_bearing(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::BEARING_INVALID;
            }
        }
        $res = $this->_bearing;
        return $res;
    }

    public function get_calibrationParam(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CALIBRATIONPARAM_INVALID;
            }
        }
        $res = $this->_calibrationParam;
        return $res;
    }

    public function set_calibrationParam(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("calibrationParam", $rest_val);
    }

    /**
     * Returns the sensor fusion mode. Note that available sensor fusion modes depend on the sensor type.
     *
     * @return int  a value among YRefFrame::FUSIONMODE_NDOF, YRefFrame::FUSIONMODE_NDOF_FMC_OFF,
     * YRefFrame::FUSIONMODE_M4G, YRefFrame::FUSIONMODE_COMPASS, YRefFrame::FUSIONMODE_IMU,
     * YRefFrame::FUSIONMODE_INCLIN_90DEG_1G8, YRefFrame::FUSIONMODE_INCLIN_90DEG_3G6 and
     * YRefFrame::FUSIONMODE_INCLIN_10DEG corresponding to the sensor fusion mode
     *
     * On failure, throws an exception or returns YRefFrame::FUSIONMODE_INVALID.
     */
    public function get_fusionMode(): int
    {
        // $res                    is a enumFUSIONMODETYPEALL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::FUSIONMODE_INVALID;
            }
        }
        $res = $this->_fusionMode;
        return $res;
    }

    /**
     * Change the sensor fusion mode. Note that available sensor fusion modes depend on the sensor type.
     * Remember to call the matching module saveToFlash() method to save the setting permanently.
     *
     * @param int $newval : a value among YRefFrame::FUSIONMODE_NDOF, YRefFrame::FUSIONMODE_NDOF_FMC_OFF,
     * YRefFrame::FUSIONMODE_M4G, YRefFrame::FUSIONMODE_COMPASS, YRefFrame::FUSIONMODE_IMU,
     * YRefFrame::FUSIONMODE_INCLIN_90DEG_1G8, YRefFrame::FUSIONMODE_INCLIN_90DEG_3G6 and
     * YRefFrame::FUSIONMODE_INCLIN_10DEG
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_fusionMode(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("fusionMode", $rest_val);
    }

    /**
     * Retrieves a reference frame for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the reference frame is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the reference frame is
     * indeed online at a given time. In case of ambiguity when looking for
     * a reference frame by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the reference frame, for instance
     *         Y3DMK002.refFrame.
     *
     * @return YRefFrame  a YRefFrame object allowing you to drive the reference frame.
     */
    public static function FindRefFrame(string $func): ?YRefFrame
    {
        // $obj                    is a YRefFrame;
        $obj = YFunction::_FindFromCache('RefFrame', $func);
        if ($obj == null) {
            $obj = new YRefFrame($func);
            YFunction::_AddToCache('RefFrame', $func, $obj);
        }
        return $obj;
    }

    /**
     * Returns the installation position of the device, as configured
     * in order to define the reference frame for the compass and the
     * pitch/roll tilt sensors.
     *
     * @return MOUNTPOSITION  a value among the YRefFrame::MOUNTPOSITION enumeration
     *         (YRefFrame::MOUNTPOSITION_BOTTOM,  YRefFrame::MOUNTPOSITION_TOP,
     *         YRefFrame::MOUNTPOSITION_FRONT,    YRefFrame::MOUNTPOSITION_RIGHT,
     *         YRefFrame::MOUNTPOSITION_REAR,     YRefFrame::MOUNTPOSITION_LEFT),
     *         corresponding to the installation in a box, on one of the six faces.
     *
     * On failure, throws an exception or returns YRefFrame::MOUNTPOSITION_INVALID.
     */
    public function get_mountPosition(): int
    {
        // $position               is a int;
        $position = $this->get_mountPos();
        if ($position < 0) {
            return self::MOUNTPOSITION_INVALID;
        }
        return (($position) >> (2));
    }

    /**
     * Returns the installation orientation of the device, as configured
     * in order to define the reference frame for the compass and the
     * pitch/roll tilt sensors.
     *
     * @return MOUNTORIENTATION  a value among the enumeration YRefFrame::MOUNTORIENTATION
     *         (YRefFrame::MOUNTORIENTATION_TWELVE, YRefFrame::MOUNTORIENTATION_THREE,
     *         YRefFrame::MOUNTORIENTATION_SIX,     YRefFrame::MOUNTORIENTATION_NINE)
     *         corresponding to the orientation of the "X" arrow on the device,
     *         as on a clock dial seen from an observer in the center of the box.
     *         On the bottom face, the 12H orientation points to the front, while
     *         on the top face, the 12H orientation points to the rear.
     *
     * On failure, throws an exception or returns YRefFrame::MOUNTORIENTATION_INVALID.
     */
    public function get_mountOrientation(): int
    {
        // $position               is a int;
        $position = $this->get_mountPos();
        if ($position < 0) {
            return self::MOUNTORIENTATION_INVALID;
        }
        return (($position) & (3));
    }

    /**
     * Changes the compass and tilt sensor frame of reference. The magnetic compass
     * and the tilt sensors (pitch and roll) naturally work in the plane
     * parallel to the earth surface. In case the device is not installed upright
     * and horizontally, you must select its reference orientation (parallel to
     * the earth surface) so that the measures are made relative to this position.
     *
     * @param MOUNTPOSITION $position : a value among the YRefFrame::MOUNTPOSITION enumeration
     *         (YRefFrame::MOUNTPOSITION_BOTTOM,  YRefFrame::MOUNTPOSITION_TOP,
     *         YRefFrame::MOUNTPOSITION_FRONT,    YRefFrame::MOUNTPOSITION_RIGHT,
     *         YRefFrame::MOUNTPOSITION_REAR,     YRefFrame::MOUNTPOSITION_LEFT),
     *         corresponding to the installation in a box, on one of the six faces.
     * @param MOUNTORIENTATION $orientation : a value among the enumeration YRefFrame::MOUNTORIENTATION
     *         (YRefFrame::MOUNTORIENTATION_TWELVE, YRefFrame::MOUNTORIENTATION_THREE,
     *         YRefFrame::MOUNTORIENTATION_SIX,     YRefFrame::MOUNTORIENTATION_NINE)
     *         corresponding to the orientation of the "X" arrow on the device,
     *         as on a clock dial seen from an observer in the center of the box.
     *         On the bottom face, the 12H orientation points to the front, while
     *         on the top face, the 12H orientation points to the rear.
     *
     * Remember to call the saveToFlash()
     * method of the module if the modification must be kept.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function set_mountPosition(int $position, int $orientation): int
    {
        // $mixedPos               is a int;
        $mixedPos = (($position) << (2)) + $orientation;
        return $this->set_mountPos($mixedPos);
    }

    /**
     * Returns the 3D sensor calibration state (Yocto-3D-V2 only). This function returns
     * an integer representing the calibration state of the 3 inertial sensors of
     * the BNO055 chip, found in the Yocto-3D-V2. Hundredths show the calibration state
     * of the accelerometer, tenths show the calibration state of the magnetometer while
     * units show the calibration state of the gyroscope. For each sensor, the value 0
     * means no calibration and the value 3 means full calibration.
     *
     * @return int  an integer representing the calibration state of Yocto-3D-V2:
     *         333 when fully calibrated, 0 when not calibrated at all.
     *
     * On failure, throws an exception or returns a negative error code.
     * For the Yocto-3D (V1), this function always return -3 (unsupported function).
     */
    public function get_calibrationState(): int
    {
        // $calibParam             is a str;
        $iCalib = [];           // intArr;
        // $caltyp                 is a int;
        // $res                    is a int;

        $calibParam = $this->get_calibrationParam();
        $iCalib = YAPI::_decodeFloats($calibParam);
        $caltyp = intVal(($iCalib[0]) / (1000));
        if ($caltyp != 33) {
            return YAPI::NOT_SUPPORTED;
        }
        $res = intVal(($iCalib[1]) / (1000));
        return $res;
    }

    /**
     * Returns estimated quality of the orientation (Yocto-3D-V2 only). This function returns
     * an integer between 0 and 3 representing the degree of confidence of the position
     * estimate. When the value is 3, the estimation is reliable. Below 3, one should
     * expect sudden corrections, in particular for heading (compass function).
     * The most frequent causes for values below 3 are magnetic interferences, and
     * accelerations or rotations beyond the sensor range.
     *
     * @return int  an integer between 0 and 3 (3 when the measure is reliable)
     *
     * On failure, throws an exception or returns a negative error code.
     * For the Yocto-3D (V1), this function always return -3 (unsupported function).
     */
    public function get_measureQuality(): int
    {
        // $calibParam             is a str;
        $iCalib = [];           // intArr;
        // $caltyp                 is a int;
        // $res                    is a int;

        $calibParam = $this->get_calibrationParam();
        $iCalib = YAPI::_decodeFloats($calibParam);
        $caltyp = intVal(($iCalib[0]) / (1000));
        if ($caltyp != 33) {
            return YAPI::NOT_SUPPORTED;
        }
        $res = intVal(($iCalib[2]) / (1000));
        return $res;
    }

    public function _calibSort(int $start, int $stopidx): int
    {
        // $idx                    is a int;
        // $changed                is a int;
        // $a                      is a float;
        // $b                      is a float;
        // $xa                     is a float;
        // $xb                     is a float;
        // bubble sort is good since we will re-sort again after offset adjustment
        $changed = 1;
        while ($changed > 0) {
            $changed = 0;
            $a = $this->_calibDataAcc[$start];
            $idx = $start + 1;
            while ($idx < $stopidx) {
                $b = $this->_calibDataAcc[$idx];
                if ($a > $b) {
                    $this->_calibDataAcc[$idx-1] = $b;
                    $this->_calibDataAcc[$idx] = $a;
                    $xa = $this->_calibDataAccX[$idx-1];
                    $xb = $this->_calibDataAccX[$idx];
                    $this->_calibDataAccX[$idx-1] = $xb;
                    $this->_calibDataAccX[$idx] = $xa;
                    $xa = $this->_calibDataAccY[$idx-1];
                    $xb = $this->_calibDataAccY[$idx];
                    $this->_calibDataAccY[$idx-1] = $xb;
                    $this->_calibDataAccY[$idx] = $xa;
                    $xa = $this->_calibDataAccZ[$idx-1];
                    $xb = $this->_calibDataAccZ[$idx];
                    $this->_calibDataAccZ[$idx-1] = $xb;
                    $this->_calibDataAccZ[$idx] = $xa;
                    $changed = $changed + 1;
                } else {
                    $a = $b;
                }
                $idx = $idx + 1;
            }
        }
        return 0;
    }

    /**
     * Initiates the sensors tridimensional calibration process.
     * This calibration is used at low level for inertial position estimation
     * and to enhance the precision of the tilt sensors.
     *
     * After calling this method, the device should be moved according to the
     * instructions provided by method get_3DCalibrationHint,
     * and more3DCalibration should be invoked about 5 times per second.
     * The calibration procedure is completed when the method
     * get_3DCalibrationProgress returns 100. At this point,
     * the computed calibration parameters can be applied using method
     * save3DCalibration. The calibration process can be cancelled
     * at any time using method cancel3DCalibration.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function start3DCalibration(): int
    {
        if (!($this->isOnline())) {
            return YAPI::DEVICE_NOT_FOUND;
        }
        if ($this->_calibStage != 0) {
            $this->cancel3DCalibration();
        }
        $this->_calibSavedParams = $this->get_calibrationParam();
        $this->_calibV2 = (intVal($this->_calibSavedParams) == 33);
        $this->set_calibrationParam('0');
        $this->_calibCount = 50;
        $this->_calibStage = 1;
        $this->_calibStageHint = 'Set down the device on a steady horizontal surface';
        $this->_calibStageProgress = 0;
        $this->_calibProgress = 1;
        $this->_calibInternalPos = 0;
        $this->_calibPrevTick = ((YAPI::GetTickCount()) & (0x7FFFFFFF));
        while (sizeof($this->_calibOrient) > 0) {
            array_pop($this->_calibOrient);
        };
        while (sizeof($this->_calibDataAccX) > 0) {
            array_pop($this->_calibDataAccX);
        };
        while (sizeof($this->_calibDataAccY) > 0) {
            array_pop($this->_calibDataAccY);
        };
        while (sizeof($this->_calibDataAccZ) > 0) {
            array_pop($this->_calibDataAccZ);
        };
        while (sizeof($this->_calibDataAcc) > 0) {
            array_pop($this->_calibDataAcc);
        };
        return YAPI::SUCCESS;
    }

    /**
     * Continues the sensors tridimensional calibration process previously
     * initiated using method start3DCalibration.
     * This method should be called approximately 5 times per second, while
     * positioning the device according to the instructions provided by method
     * get_3DCalibrationHint. Note that the instructions change during
     * the calibration process.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function more3DCalibration(): int
    {
        if ($this->_calibV2) {
            return $this->more3DCalibrationV2();
        }
        return $this->more3DCalibrationV1();
    }

    public function more3DCalibrationV1(): int
    {
        // $currTick               is a int;
        // $jsonData               is a bin;
        // $xVal                   is a float;
        // $yVal                   is a float;
        // $zVal                   is a float;
        // $xSq                    is a float;
        // $ySq                    is a float;
        // $zSq                    is a float;
        // $norm                   is a float;
        // $orient                 is a int;
        // $idx                    is a int;
        // $intpos                 is a int;
        // $err                    is a int;
        // make sure calibration has been started
        if ($this->_calibStage == 0) {
            return YAPI::INVALID_ARGUMENT;
        }
        if ($this->_calibProgress == 100) {
            return YAPI::SUCCESS;
        }
        // make sure we leave at least 160 ms between samples
        $currTick =  ((YAPI::GetTickCount()) & (0x7FFFFFFF));
        if ((($currTick - $this->_calibPrevTick) & (0x7FFFFFFF)) < 160) {
            return YAPI::SUCCESS;
        }
        // load current accelerometer values, make sure we are on a straight angle
        // (default timeout to 0,5 sec without reading measure when out of range)
        $this->_calibStageHint = 'Set down the device on a steady horizontal surface';
        $this->_calibPrevTick = (($currTick + 500) & (0x7FFFFFFF));
        $jsonData = $this->_download('api/accelerometer.json');
        $xVal = intVal($this->_json_get_key($jsonData, 'xValue')) / 65536.0;
        $yVal = intVal($this->_json_get_key($jsonData, 'yValue')) / 65536.0;
        $zVal = intVal($this->_json_get_key($jsonData, 'zValue')) / 65536.0;
        $xSq = $xVal * $xVal;
        if ($xSq >= 0.04 && $xSq < 0.64) {
            return YAPI::SUCCESS;
        }
        if ($xSq >= 1.44) {
            return YAPI::SUCCESS;
        }
        $ySq = $yVal * $yVal;
        if ($ySq >= 0.04 && $ySq < 0.64) {
            return YAPI::SUCCESS;
        }
        if ($ySq >= 1.44) {
            return YAPI::SUCCESS;
        }
        $zSq = $zVal * $zVal;
        if ($zSq >= 0.04 && $zSq < 0.64) {
            return YAPI::SUCCESS;
        }
        if ($zSq >= 1.44) {
            return YAPI::SUCCESS;
        }
        $norm = sqrt($xSq + $ySq + $zSq);
        if ($norm < 0.8 || $norm > 1.2) {
            return YAPI::SUCCESS;
        }
        $this->_calibPrevTick = $currTick;
        // Determine the device orientation index
        $orient = 0;
        if ($zSq > 0.5) {
            if ($zVal > 0) {
                $orient = 0;
            } else {
                $orient = 1;
            }
        }
        if ($xSq > 0.5) {
            if ($xVal > 0) {
                $orient = 2;
            } else {
                $orient = 3;
            }
        }
        if ($ySq > 0.5) {
            if ($yVal > 0) {
                $orient = 4;
            } else {
                $orient = 5;
            }
        }
        // Discard measures that are not in the proper orientation
        if ($this->_calibStageProgress == 0) {
            // New stage, check that $this orientation is not yet done
            $idx = 0;
            $err = 0;
            while ($idx + 1 < $this->_calibStage) {
                if ($this->_calibOrient[$idx] == $orient) {
                    $err = 1;
                }
                $idx = $idx + 1;
            }
            if ($err != 0) {
                $this->_calibStageHint = 'Turn the device on another face';
                return YAPI::SUCCESS;
            }
            $this->_calibOrient[] = $orient;
        } else {
            // Make sure device is not turned before stage is completed
            if ($orient != $this->_calibOrient[$this->_calibStage-1]) {
                $this->_calibStageHint = 'Not yet done, please move back to the previous face';
                return YAPI::SUCCESS;
            }
        }
        // Save measure
        $this->_calibStageHint = 'calibrating->.';
        $this->_calibDataAccX[] = $xVal;
        $this->_calibDataAccY[] = $yVal;
        $this->_calibDataAccZ[] = $zVal;
        $this->_calibDataAcc[] = $norm;
        $this->_calibInternalPos = $this->_calibInternalPos + 1;
        $this->_calibProgress = 1 + 16 * ($this->_calibStage - 1) + intVal((16 * $this->_calibInternalPos) / ($this->_calibCount));
        if ($this->_calibInternalPos < $this->_calibCount) {
            $this->_calibStageProgress = 1 + intVal((99 * $this->_calibInternalPos) / ($this->_calibCount));
            return YAPI::SUCCESS;
        }
        // Stage done, compute preliminary result
        $intpos = ($this->_calibStage - 1) * $this->_calibCount;
        $this->_calibSort($intpos, $intpos + $this->_calibCount);
        $intpos = $intpos + intVal(($this->_calibCount) / (2));
        $this->_calibLogMsg = sprintf('Stage %d: median is %d,%d,%d', $this->_calibStage,
                                      round(1000*$this->_calibDataAccX[$intpos]),
                                      round(1000*$this->_calibDataAccY[$intpos]),
                                      round(1000*$this->_calibDataAccZ[$intpos]));
        // move to next stage
        $this->_calibStage = $this->_calibStage + 1;
        if ($this->_calibStage < 7) {
            $this->_calibStageHint = 'Turn the device on another face';
            $this->_calibPrevTick = (($currTick + 500) & (0x7FFFFFFF));
            $this->_calibStageProgress = 0;
            $this->_calibInternalPos = 0;
            return YAPI::SUCCESS;
        }
        // Data collection completed, compute accelerometer shift
        $xVal = 0;
        $yVal = 0;
        $zVal = 0;
        $idx = 0;
        while ($idx < 6) {
            $intpos = $idx * $this->_calibCount + intVal(($this->_calibCount) / (2));
            $orient = $this->_calibOrient[$idx];
            if ($orient == 0 || $orient == 1) {
                $zVal = $zVal + $this->_calibDataAccZ[$intpos];
            }
            if ($orient == 2 || $orient == 3) {
                $xVal = $xVal + $this->_calibDataAccX[$intpos];
            }
            if ($orient == 4 || $orient == 5) {
                $yVal = $yVal + $this->_calibDataAccY[$intpos];
            }
            $idx = $idx + 1;
        }
        $this->_calibAccXOfs = $xVal / 2.0;
        $this->_calibAccYOfs = $yVal / 2.0;
        $this->_calibAccZOfs = $zVal / 2.0;
        // Recompute all norms, taking into account the computed shift, and re-sort
        $intpos = 0;
        while ($intpos < sizeof($this->_calibDataAcc)) {
            $xVal = $this->_calibDataAccX[$intpos] - $this->_calibAccXOfs;
            $yVal = $this->_calibDataAccY[$intpos] - $this->_calibAccYOfs;
            $zVal = $this->_calibDataAccZ[$intpos] - $this->_calibAccZOfs;
            $norm = sqrt($xVal * $xVal + $yVal * $yVal + $zVal * $zVal);
            $this->_calibDataAcc[$intpos] = $norm;
            $intpos = $intpos + 1;
        }
        $idx = 0;
        while ($idx < 6) {
            $intpos = $idx * $this->_calibCount;
            $this->_calibSort($intpos, $intpos + $this->_calibCount);
            $idx = $idx + 1;
        }
        // Compute the scaling factor for each axis
        $xVal = 0;
        $yVal = 0;
        $zVal = 0;
        $idx = 0;
        while ($idx < 6) {
            $intpos = $idx * $this->_calibCount + intVal(($this->_calibCount) / (2));
            $orient = $this->_calibOrient[$idx];
            if ($orient == 0 || $orient == 1) {
                $zVal = $zVal + $this->_calibDataAcc[$intpos];
            }
            if ($orient == 2 || $orient == 3) {
                $xVal = $xVal + $this->_calibDataAcc[$intpos];
            }
            if ($orient == 4 || $orient == 5) {
                $yVal = $yVal + $this->_calibDataAcc[$intpos];
            }
            $idx = $idx + 1;
        }
        $this->_calibAccXScale = $xVal / 2.0;
        $this->_calibAccYScale = $yVal / 2.0;
        $this->_calibAccZScale = $zVal / 2.0;
        // Report completion
        $this->_calibProgress = 100;
        $this->_calibStageHint = 'Calibration data ready for saving';
        return YAPI::SUCCESS;
    }

    public function more3DCalibrationV2(): int
    {
        // $currTick               is a int;
        // $calibParam             is a bin;
        $iCalib = [];           // intArr;
        // $cal3                   is a int;
        // $calAcc                 is a int;
        // $calMag                 is a int;
        // $calGyr                 is a int;
        // make sure calibration has been started
        if ($this->_calibStage == 0) {
            return YAPI::INVALID_ARGUMENT;
        }
        if ($this->_calibProgress == 100) {
            return YAPI::SUCCESS;
        }
        // make sure we don't start before previous calibration is cleared
        if ($this->_calibStage == 1) {
            $currTick = ((YAPI::GetTickCount()) & (0x7FFFFFFF));
            $currTick = (($currTick - $this->_calibPrevTick) & (0x7FFFFFFF));
            if ($currTick < 1600) {
                $this->_calibStageHint = 'Set down the device on a steady horizontal surface';
                $this->_calibStageProgress = intVal(($currTick) / (40));
                $this->_calibProgress = 1;
                return YAPI::SUCCESS;
            }
        }

        $calibParam = $this->_download('api/refFrame/calibrationParam.txt');
        $iCalib = YAPI::_decodeFloats($calibParam);
        $cal3 = intVal(($iCalib[1]) / (1000));
        $calAcc = intVal(($cal3) / (100));
        $calMag = intVal(($cal3) / (10)) - 10*$calAcc;
        $calGyr = (($cal3) % (10));
        if ($calGyr < 3) {
            $this->_calibStageHint = 'Set down the device on a steady horizontal surface';
            $this->_calibStageProgress = 40 + $calGyr*20;
            $this->_calibProgress = 4 + $calGyr*2;
        } else {
            $this->_calibStage = 2;
            if ($calMag < 3) {
                $this->_calibStageHint = 'Slowly draw \'8\' shapes along the 3 axis';
                $this->_calibStageProgress = 1 + $calMag*33;
                $this->_calibProgress = 10 + $calMag*5;
            } else {
                $this->_calibStage = 3;
                if ($calAcc < 3) {
                    $this->_calibStageHint = 'Slowly turn the device, stopping at each 90 degrees';
                    $this->_calibStageProgress = 1 + $calAcc*33;
                    $this->_calibProgress = 25 + $calAcc*25;
                } else {
                    $this->_calibStageProgress = 99;
                    $this->_calibProgress = 100;
                }
            }
        }
        return YAPI::SUCCESS;
    }

    /**
     * Returns instructions to proceed to the tridimensional calibration initiated with
     * method start3DCalibration.
     *
     * @return string  a character string.
     */
    public function get_3DCalibrationHint(): string
    {
        return $this->_calibStageHint;
    }

    /**
     * Returns the global process indicator for the tridimensional calibration
     * initiated with method start3DCalibration.
     *
     * @return int  an integer between 0 (not started) and 100 (stage completed).
     */
    public function get_3DCalibrationProgress(): int
    {
        return $this->_calibProgress;
    }

    /**
     * Returns index of the current stage of the calibration
     * initiated with method start3DCalibration.
     *
     * @return int  an integer, growing each time a calibration stage is completed.
     */
    public function get_3DCalibrationStage(): int
    {
        return $this->_calibStage;
    }

    /**
     * Returns the process indicator for the current stage of the calibration
     * initiated with method start3DCalibration.
     *
     * @return int  an integer between 0 (not started) and 100 (stage completed).
     */
    public function get_3DCalibrationStageProgress(): int
    {
        return $this->_calibStageProgress;
    }

    /**
     * Returns the latest log message from the calibration process.
     * When no new message is available, returns an empty string.
     *
     * @return string  a character string.
     */
    public function get_3DCalibrationLogMsg(): string
    {
        // $msg                    is a str;
        $msg = $this->_calibLogMsg;
        $this->_calibLogMsg = '';
        return $msg;
    }

    /**
     * Applies the sensors tridimensional calibration parameters that have just been computed.
     * Remember to call the saveToFlash()  method of the module if the changes
     * must be kept when the device is restarted.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function save3DCalibration(): int
    {
        if ($this->_calibV2) {
            return $this->save3DCalibrationV2();
        }
        return $this->save3DCalibrationV1();
    }

    public function save3DCalibrationV1(): int
    {
        // $shiftX                 is a int;
        // $shiftY                 is a int;
        // $shiftZ                 is a int;
        // $scaleExp               is a int;
        // $scaleX                 is a int;
        // $scaleY                 is a int;
        // $scaleZ                 is a int;
        // $scaleLo                is a int;
        // $scaleHi                is a int;
        // $newcalib               is a str;
        if ($this->_calibProgress != 100) {
            return YAPI::INVALID_ARGUMENT;
        }
        // Compute integer values (correction unit is 732ug/count)
        $shiftX = -round($this->_calibAccXOfs / 0.000732);
        if ($shiftX < 0) {
            $shiftX = $shiftX + 65536;
        }
        $shiftY = -round($this->_calibAccYOfs / 0.000732);
        if ($shiftY < 0) {
            $shiftY = $shiftY + 65536;
        }
        $shiftZ = -round($this->_calibAccZOfs / 0.000732);
        if ($shiftZ < 0) {
            $shiftZ = $shiftZ + 65536;
        }
        $scaleX = round(2048.0 / $this->_calibAccXScale) - 2048;
        $scaleY = round(2048.0 / $this->_calibAccYScale) - 2048;
        $scaleZ = round(2048.0 / $this->_calibAccZScale) - 2048;
        if ($scaleX < -2048 || $scaleX >= 2048 || $scaleY < -2048 || $scaleY >= 2048 || $scaleZ < -2048 || $scaleZ >= 2048) {
            $scaleExp = 3;
        } else {
            if ($scaleX < -1024 || $scaleX >= 1024 || $scaleY < -1024 || $scaleY >= 1024 || $scaleZ < -1024 || $scaleZ >= 1024) {
                $scaleExp = 2;
            } else {
                if ($scaleX < -512 || $scaleX >= 512 || $scaleY < -512 || $scaleY >= 512 || $scaleZ < -512 || $scaleZ >= 512) {
                    $scaleExp = 1;
                } else {
                    $scaleExp = 0;
                }
            }
        }
        if ($scaleExp > 0) {
            $scaleX = (($scaleX) >> ($scaleExp));
            $scaleY = (($scaleY) >> ($scaleExp));
            $scaleZ = (($scaleZ) >> ($scaleExp));
        }
        if ($scaleX < 0) {
            $scaleX = $scaleX + 1024;
        }
        if ($scaleY < 0) {
            $scaleY = $scaleY + 1024;
        }
        if ($scaleZ < 0) {
            $scaleZ = $scaleZ + 1024;
        }
        $scaleLo = (((($scaleY) & (15))) << (12)) + (($scaleX) << (2)) + $scaleExp;
        $scaleHi = (($scaleZ) << (6)) + (($scaleY) >> (4));
        // Save calibration parameters
        $newcalib = sprintf('5,%d,%d,%d,%d,%d', $shiftX, $shiftY, $shiftZ, $scaleLo, $scaleHi);
        $this->_calibStage = 0;
        return $this->set_calibrationParam($newcalib);
    }

    public function save3DCalibrationV2(): int
    {
        return $this->set_calibrationParam('5,5,5,5,5,5');
    }

    /**
     * Aborts the sensors tridimensional calibration process et restores normal settings.
     *
     * On failure, throws an exception or returns a negative error code.
     */
    public function cancel3DCalibration(): int
    {
        if ($this->_calibStage == 0) {
            return YAPI::SUCCESS;
        }

        $this->_calibStage = 0;
        return $this->set_calibrationParam($this->_calibSavedParams);
    }

    public function mountPos(): int
{
    return $this->get_mountPos();
}

    public function setMountPos(int $newval)
{
    return $this->set_mountPos($newval);
}

    public function setBearing(float $newval)
{
    return $this->set_bearing($newval);
}

    public function bearing(): float
{
    return $this->get_bearing();
}

    public function calibrationParam(): string
{
    return $this->get_calibrationParam();
}

    public function setCalibrationParam(string $newval)
{
    return $this->set_calibrationParam($newval);
}

    public function fusionMode(): int
{
    return $this->get_fusionMode();
}

    public function setFusionMode(int $newval)
{
    return $this->set_fusionMode($newval);
}

    /**
     * Continues the enumeration of reference frames started using yFirstRefFrame().
     * Caution: You can't make any assumption about the returned reference frames order.
     * If you want to find a specific a reference frame, use RefFrame.findRefFrame()
     * and a hardwareID or a logical name.
     *
     * @return YRefFrame  a pointer to a YRefFrame object, corresponding to
     *         a reference frame currently online, or a null pointer
     *         if there are no more reference frames to enumerate.
     */
    public function nextRefFrame(): ?YRefFrame
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindRefFrame($next_hwid);
    }

    /**
     * Starts the enumeration of reference frames currently accessible.
     * Use the method YRefFrame::nextRefFrame() to iterate on
     * next reference frames.
     *
     * @return YRefFrame  a pointer to a YRefFrame object, corresponding to
     *         the first reference frame currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstRefFrame()
    {
        $next_hwid = YAPI::getFirstHardwareId('RefFrame');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindRefFrame($next_hwid);
    }

    //--- (end of YRefFrame implementation)

}
