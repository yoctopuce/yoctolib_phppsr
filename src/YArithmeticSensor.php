<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YArithmeticSensor Class: arithmetic sensor control interface, available for instance in the
 * Yocto-MaxiMicroVolt-Rx
 *
 * The YArithmeticSensor class allows some Yoctopuce devices to compute in real-time
 * values based on an arithmetic formula involving one or more measured signals as
 * well as the temperature. As for any physical sensor, the computed values can be
 * read by callback and stored in the built-in datalogger.
 */
class YArithmeticSensor extends YSensor
{
    const DESCRIPTION_INVALID = YAPI::INVALID_STRING;
    const COMMAND_INVALID = YAPI::INVALID_STRING;
    //--- (end of YArithmeticSensor declaration)

    //--- (YArithmeticSensor attributes)
    protected string $_description = self::DESCRIPTION_INVALID;    // Text
    protected string $_command = self::COMMAND_INVALID;        // Text

    //--- (end of YArithmeticSensor attributes)

    function __construct(string $str_func)
    {
        //--- (YArithmeticSensor constructor)
        parent::__construct($str_func);
        $this->_className = 'ArithmeticSensor';

        //--- (end of YArithmeticSensor constructor)
    }

    //--- (YArithmeticSensor implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'description':
            $this->_description = $val;
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Changes the measuring unit for the arithmetic sensor.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param string $newval : a string corresponding to the measuring unit for the arithmetic sensor
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_unit(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("unit", $rest_val);
    }

    /**
     * Returns a short informative description of the formula.
     *
     * @return string  a string corresponding to a short informative description of the formula
     *
     * On failure, throws an exception or returns YArithmeticSensor::DESCRIPTION_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_description(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DESCRIPTION_INVALID;
            }
        }
        $res = $this->_description;
        return $res;
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
     * Retrieves an arithmetic sensor for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the arithmetic sensor is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the arithmetic sensor is
     * indeed online at a given time. In case of ambiguity when looking for
     * an arithmetic sensor by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the arithmetic sensor, for instance
     *         RXUVOLT1.arithmeticSensor1.
     *
     * @return YArithmeticSensor  a YArithmeticSensor object allowing you to drive the arithmetic sensor.
     */
    public static function FindArithmeticSensor(string $func): YArithmeticSensor
    {
        // $obj                    is a YArithmeticSensor;
        $obj = YFunction::_FindFromCache('ArithmeticSensor', $func);
        if ($obj == null) {
            $obj = new YArithmeticSensor($func);
            YFunction::_AddToCache('ArithmeticSensor', $func, $obj);
        }
        return $obj;
    }

    /**
     * Defines the arithmetic function by means of an algebraic expression. The expression
     * may include references to device sensors, by their physical or logical name, to
     * usual math functions and to auxiliary functions defined separately.
     *
     * @param string $expr : the algebraic expression defining the function.
     * @param string $descr : short informative description of the expression.
     *
     * @return float  the current expression value if the call succeeds.
     *
     * On failure, throws an exception or returns YAPI::INVALID_DOUBLE.
     * @throws YAPI_Exception on error
     */
    public function defineExpression(string $expr, string $descr): float
    {
        // $id                     is a str;
        // $fname                  is a str;
        // $content                is a str;
        // $data                   is a bin;
        // $diags                  is a str;
        // $resval                 is a float;
        $id = $this->get_functionId();
        $id = substr($id,  16, strlen($id) - 16);
        $fname = sprintf('arithmExpr%s.txt', $id);

        $content = sprintf('// %s'."\n".'%s', $descr, $expr);
        $data = $this->_uploadEx($fname, $content);
        $diags = $data;
        if (!(substr($diags, 0, 8) == 'Result: ')) return $this->_throw( YAPI::INVALID_ARGUMENT, $diags,YAPI::INVALID_DOUBLE);
        $resval = floatval(substr($diags,  8, strlen($diags)-8));
        return $resval;
    }

    /**
     * Retrieves the algebraic expression defining the arithmetic function, as previously
     * configured using the defineExpression function.
     *
     * @return string  a string containing the mathematical expression.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function loadExpression(): string
    {
        // $id                     is a str;
        // $fname                  is a str;
        // $content                is a str;
        // $idx                    is a int;
        $id = $this->get_functionId();
        $id = substr($id,  16, strlen($id) - 16);
        $fname = sprintf('arithmExpr%s.txt', $id);

        $content = $this->_download($fname);
        $idx = YAPI::Ystrpos($content,''."\n".'');
        if ($idx > 0) {
            $content = substr($content,  $idx+1, strlen($content)-($idx+1));
        }
        return $content;
    }

    /**
     * Defines a auxiliary function by means of a table of reference points. Intermediate values
     * will be interpolated between specified reference points. The reference points are given
     * as pairs of floating point numbers.
     * The auxiliary function will be available for use by all ArithmeticSensor objects of the
     * device. Up to nine auxiliary function can be defined in a device, each containing up to
     * 96 reference points.
     *
     * @param string $name : auxiliary function name, up to 16 characters.
     * @param float[] $inputValues : array of floating point numbers, corresponding to the function input value.
     * @param float[] $outputValues : array of floating point numbers, corresponding to the output value
     *         desired for each of the input value, index by index.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function defineAuxiliaryFunction(string $name, array $inputValues, array $outputValues): int
    {
        // $siz                    is a int;
        // $defstr                 is a str;
        // $idx                    is a int;
        // $inputVal               is a float;
        // $outputVal              is a float;
        // $fname                  is a str;
        $siz = sizeof($inputValues);
        if (!($siz > 1)) return $this->_throw( YAPI::INVALID_ARGUMENT, 'auxiliary function must be defined by at least two points',YAPI::INVALID_ARGUMENT);
        if (!($siz == sizeof($outputValues))) return $this->_throw( YAPI::INVALID_ARGUMENT, 'table sizes mismatch',YAPI::INVALID_ARGUMENT);
        $defstr = '';
        $idx = 0;
        while ($idx < $siz) {
            $inputVal = $inputValues[$idx];
            $outputVal = $outputValues[$idx];
            $defstr = sprintf('%s%F:%F'."\n".'', $defstr, $inputVal, $outputVal);
            $idx = $idx + 1;
        }
        $fname = sprintf('userMap%s.txt', $name);

        return $this->_upload($fname, $defstr);
    }

    /**
     * Retrieves the reference points table defining an auxiliary function previously
     * configured using the defineAuxiliaryFunction function.
     *
     * @param string $name : auxiliary function name, up to 16 characters.
     * @param float[] $inputValues : array of floating point numbers, that is filled by the function
     *         with all the function reference input value.
     * @param float[] $outputValues : array of floating point numbers, that is filled by the function
     *         output value for each of the input value, index by index.
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function loadAuxiliaryFunction(string $name, array &$inputValues, array &$outputValues): int
    {
        // $fname                  is a str;
        // $defbin                 is a bin;
        // $siz                    is a int;

        $fname = sprintf('userMap%s.txt', $name);
        $defbin = $this->_download($fname);
        $siz = strlen($defbin);
        if (!($siz > 0)) return $this->_throw( YAPI::INVALID_ARGUMENT, 'auxiliary function does not exist',YAPI::INVALID_ARGUMENT);
        while (sizeof($inputValues) > 0) {
            array_pop($inputValues);
        };
        while (sizeof($outputValues) > 0) {
            array_pop($outputValues);
        };
        // FIXME: decode line by line
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception
     */
    public function setUnit(string $newval): int
{
    return $this->set_unit($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function description(): string
{
    return $this->get_description();
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
     * Continues the enumeration of arithmetic sensors started using yFirstArithmeticSensor().
     * Caution: You can't make any assumption about the returned arithmetic sensors order.
     * If you want to find a specific an arithmetic sensor, use ArithmeticSensor.findArithmeticSensor()
     * and a hardwareID or a logical name.
     *
     * @return ?YArithmeticSensor  a pointer to a YArithmeticSensor object, corresponding to
     *         an arithmetic sensor currently online, or a null pointer
     *         if there are no more arithmetic sensors to enumerate.
     */
    public function nextArithmeticSensor(): ?YArithmeticSensor
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindArithmeticSensor($next_hwid);
    }

    /**
     * Starts the enumeration of arithmetic sensors currently accessible.
     * Use the method YArithmeticSensor::nextArithmeticSensor() to iterate on
     * next arithmetic sensors.
     *
     * @return ?YArithmeticSensor  a pointer to a YArithmeticSensor object, corresponding to
     *         the first arithmetic sensor currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstArithmeticSensor(): ?YArithmeticSensor
    {
        $next_hwid = YAPI::getFirstHardwareId('ArithmeticSensor');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindArithmeticSensor($next_hwid);
    }

    //--- (end of YArithmeticSensor implementation)

}
