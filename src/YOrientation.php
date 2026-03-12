<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YOrientation Class: orientation sensor control interface
 *
 * The YOrientation class allows you to read and configure Yoctopuce orientation sensors.
 * It inherits from YSensor class the core functions to read measurements,
 * to register callback functions, and to access the autonomous datalogger.
 */
class YOrientation extends YSensor
{
    const COMMAND_INVALID = YAPI::INVALID_STRING;
    const ZEROOFFSET_INVALID = YAPI::INVALID_DOUBLE;
    //--- (end of YOrientation declaration)

    //--- (YOrientation attributes)
    protected string $_command = self::COMMAND_INVALID;        // Text
    protected float $_zeroOffset = self::ZEROOFFSET_INVALID;     // MeasureVal

    //--- (end of YOrientation attributes)

    function __construct(string $str_func)
    {
        //--- (YOrientation constructor)
        parent::__construct($str_func);
        $this->_className = 'Orientation';

        //--- (end of YOrientation constructor)
    }

    //--- (YOrientation implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'command':
            $this->_command = $val;
            return 1;
        case 'zeroOffset':
            $this->_zeroOffset = round($val / 65.536) / 1000.0;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_command(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::COMMAND_INVALID;
            }
        }
        $res = $this->_command;
        return $res;
    }

    /**
     * @throws YAPI_Exception
     */
    public function set_command(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("command", $rest_val);
    }

    /**
     * Sets an offset between the orientation reported by the sensor and the actual orientation. This
     * can typically be used  to compensate for mechanical offset. This offset can also be set
     * automatically using the zero() method.
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     * On failure, throws an exception or returns a negative error code.
     *
     * @param float $newval : a floating point number
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_zeroOffset(float $newval): int
    {
        $rest_val = strval(round($newval * 65536.0));
        return $this->_setAttr("zeroOffset", $rest_val);
    }

    /**
     * Returns the Offset between the orientation reported by the sensor and the actual orientation.
     *
     * @return float  a floating point number corresponding to the Offset between the orientation reported
     * by the sensor and the actual orientation
     *
     * On failure, throws an exception or returns YOrientation::ZEROOFFSET_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_zeroOffset(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::ZEROOFFSET_INVALID;
            }
        }
        $res = $this->_zeroOffset;
        return $res;
    }

    /**
     * Retrieves an orientation sensor for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the orientation sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the orientation sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * an orientation sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the orientation sensor, for instance
     *         MyDevice.orientation.
     *
     * @return YOrientation  a YOrientation object allowing you to drive the orientation sensor.
     */
    public static function FindOrientation(string $func): YOrientation
    {
        // $obj                    is a YOrientation;
        $obj = YFunction::_FindFromCache('Orientation', $func);
        if ($obj == null) {
            $obj = new YOrientation($func);
            YFunction::_AddToCache('Orientation', $func, $obj);
        }
        return $obj;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function sendCommand(string $command): int
    {
        return $this->set_command($command);
    }

    /**
     * Reset the sensor's zero to current position by automatically setting a new offset.
     * Remember to call the saveToFlash() method of the module if the modification must be kept.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function zero(): int
    {
        return $this->sendCommand('Z');
    }

    /**
     * Modifies the calibration of the MA600A sensor using an array of 32
     * values representing the offset in degrees between the true values and
     * those measured regularly every 11.25 degrees starting from zero. The calibration
     * is applied immediately and is stored permanently in the MA600A sensor.
     * Before calculating the offset values, remember to clear any previous
     * calibration using the clearCalibration function and set
     * the zero offset  to 0. After a calibration change, the sensor will stop
     * measurements for about one second.
     * Do not confuse this function with the generic calibrateFromPoints function,
     * which works at the YSensor level and is not necessarily well suited to
     * a sensor returning circular values.
     *
     * @param float[] $offsetValues : array of 32 floating point values in the [-11.25..+11.25] range
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_calibration(array &$offsetValues): int
    {
        // $res                    is a str;
        // $npt                    is a int;
        // $idx                    is a int;
        // $corr                   is a int;
        $npt = sizeof($offsetValues);
        if ($npt != 32) {
            $this->_throw(YAPI::INVALID_ARGUMENT, 'Invalid calibration parameters (32 expected)');
            return YAPI::INVALID_ARGUMENT;
        }
        $res = 'C';
        $idx = 0;
        while ($idx < $npt) {
            $corr = intval(round($offsetValues[$idx] * 128 / 11.25));
            if (($corr < -128) || ($corr > 127)) {
                $this->_throw(YAPI::INVALID_ARGUMENT, 'Calibration parameter exceeds permitted range (+/-11.25)');
                return YAPI::INVALID_ARGUMENT;
            }
            if ($corr < 0) {
                $corr = $corr + 256;
            }
            $res = sprintf('%s%02x', $res, $corr);
            $idx = $idx + 1;
        }
        return $this->sendCommand($res);
    }

    /**
     * Retrieves offset correction data points previously entered using the method
     * set_calibration.
     *
     * @param offsetValues : array of 32 floating point numbers, that will be filled by the
     *         function with the offset values for the correction points.
     *
     * @return YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function get_Calibration(array &$offsetValues): int
    {
        return 0;
    }

    /**
     * Cancels any calibration set with set_calibration. This function
     * is equivalent to calling set_calibration with only zeros.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function clearCalibration(): int
    {
        return $this->sendCommand('-');
    }

    /**
     * @throws YAPI_Exception
     */
    public function command(): string
{
    return $this->get_command();
}

    /**
     * @throws YAPI_Exception
     */
    public function setCommand(string $newval): int
{
    return $this->set_command($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function setZeroOffset(float $newval): int
{
    return $this->set_zeroOffset($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function zeroOffset(): float
{
    return $this->get_zeroOffset();
}

    /**
     * Continues the enumeration of orientation sensors started using yFirstOrientation().
     * Caution: You can't make any assumption about the returned orientation sensors order.
     * If you want to find a specific an orientation sensor, use Orientation.findOrientation()
     * and a hardwareID or a logical name.
     *
     * @return ?YOrientation  a pointer to a YOrientation object, corresponding to
     *         an orientation sensor currently online, or a null pointer
     *         if there are no more orientation sensors to enumerate.
     */
    public function nextOrientation(): ?YOrientation
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindOrientation($next_hwid);
    }

    /**
     * Starts the enumeration of orientation sensors currently accessible.
     * Use the method YOrientation::nextOrientation() to iterate on
     * next orientation sensors.
     *
     * @return ?YOrientation  a pointer to a YOrientation object, corresponding to
     *         the first orientation sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstOrientation(): ?YOrientation
    {
        $next_hwid = YAPI::getFirstHardwareId('Orientation');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindOrientation($next_hwid);
    }

    //--- (end of YOrientation implementation)

}
