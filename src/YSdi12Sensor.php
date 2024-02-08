<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YSdi12Sensor Class: Description of a discovered SDI12 sensor, returned by
 * sdi12Port.discoverSingleSensor and sdi12Port.discoverAllSensors methods
 *
 *
 */
class YSdi12Sensor
{
    //--- (end of generated code: YSdi12Sensor declaration)

    //--- (generated code: YSdi12Sensor attributes)
    protected ?YSdi12Port $_sdi12Port = null;                         // YSdi12Port
    protected string $_addr = "";                           // str
    protected string $_proto = "";                           // str
    protected string $_mfg = "";                           // str
    protected string $_model = "";                           // str
    protected string $_ver = "";                           // str
    protected string $_sn = "";                           // str
    protected array $_valuesDesc = [];                           // strArrArr

    //--- (end of generated code: YSdi12Sensor attributes)

    function __construct(string $str_func)
    {
        //--- (generated code: YSdi12Sensor constructor)
        //--- (end of generated code: YSdi12Sensor constructor)
    }

    //--- (generated code: YSdi12Sensor implementation)

    /**
     * Returns the sensor address.
     *
     * @return string  the sensor address.
     */
    public function get_sensorAddress(): string
    {
        return $this->_addr;
    }

    /**
     * Returns the compatible SDI-12 version of the sensor.
     *
     * @return string  the compatible SDI-12 version of the sensor.
     */
    public function get_sensorProtocol(): string
    {
        return $this->_proto;
    }

    /**
     * Returns the sensor vendor identification.
     *
     * @return string  the sensor vendor identification.
     */
    public function get_sensorVendor(): string
    {
        return $this->_mfg;
    }

    /**
     * Returns the sensor model number.
     *
     * @return string  the sensor model number.
     */
    public function get_sensorModel(): string
    {
        return $this->_model;
    }

    /**
     * Returns the sensor version.
     *
     * @return string  the sensor version.
     */
    public function get_sensorVersion(): string
    {
        return $this->_ver;
    }

    /**
     * Returns the sensor serial number.
     *
     * @return string  the sensor serial number.
     */
    public function get_sensorSerial(): string
    {
        return $this->_sn;
    }

    /**
     * Returns the number of sensor measurements.
     *
     * @return int  the number of sensor measurements.
     */
    public function get_measureCount(): int
    {
        return sizeof($this->_valuesDesc);
    }

    /**
     * Returns the sensor measurement command.
     *
     * @param int $measureIndex : measurement index
     *
     * @return string  the sensor measurement command.
     */
    public function get_measureCommand(int $measureIndex): string
    {
        return $this->_valuesDesc[$measureIndex][0];
    }

    /**
     * Returns sensor measurement position.
     *
     * @param int $measureIndex : measurement index
     *
     * @return int  the sensor measurement command.
     */
    public function get_measurePosition(int $measureIndex): int
    {
        return intVal($this->_valuesDesc[$measureIndex][2]);
    }

    /**
     * Returns the measured value symbol.
     *
     * @param int $measureIndex : measurement index
     *
     * @return string  the sensor measurement command.
     */
    public function get_measureSymbol(int $measureIndex): string
    {
        return $this->_valuesDesc[$measureIndex][3];
    }

    /**
     * Returns the unit of the measured value.
     *
     * @param int $measureIndex : measurement index
     *
     * @return string  the sensor measurement command.
     */
    public function get_measureUnit(int $measureIndex): string
    {
        return $this->_valuesDesc[$measureIndex][4];
    }

    /**
     * Returns the description of the measured value.
     *
     * @param int $measureIndex : measurement index
     *
     * @return string  the sensor measurement command.
     */
    public function get_measureDescription(int $measureIndex): string
    {
        return $this->_valuesDesc[$measureIndex][5];
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_typeMeasure(): array
    {
        return $this->_valuesDesc;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _parseInfoStr(string $infoStr): void
    {
        // $errmsg                 is a str;

        if (strlen($infoStr) > 1) {
            if (substr($infoStr,  0, 2) == 'ER') {
                $errmsg = substr($infoStr,  2, strlen($infoStr)-2);
                $this->_addr = $errmsg;
                $this->_proto = $errmsg;
                $this->_mfg = $errmsg;
                $this->_model = $errmsg;
                $this->_ver = $errmsg;
                $this->_sn = $errmsg;
            } else {
                $this->_addr = substr($infoStr,  0, 1);
                $this->_proto = substr($infoStr,  1, 2);
                $this->_mfg = substr($infoStr,  3, 8);
                $this->_model = substr($infoStr,  11, 6);
                $this->_ver = substr($infoStr,  17, 3);
                $this->_sn = substr($infoStr,  20, strlen($infoStr)-20);
            }
        }
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _queryValueInfo(): void
    {
        $val = [];              // strArrArr;
        $data = [];             // strArr;
        // $infoNbVal              is a str;
        // $cmd                    is a str;
        // $infoVal                is a str;
        // $value                  is a str;
        // $nbVal                  is a int;
        // $k                      is a int;
        // $i                      is a int;
        // $j                      is a int;
        $listVal = [];          // strArr;
        // $size                   is a int;

        $k = 0;
        $size = 4;
        while ($k < 10) {
            $infoNbVal = $this->_sdi12Port->querySdi12($this->_addr, sprintf('IM%d', $k), 5000);
            if (strlen($infoNbVal) > 1) {
                $value = substr($infoNbVal,  4, strlen($infoNbVal)-4);
                $nbVal = intVal($value);
                if ($nbVal != 0) {
                    while (sizeof($val) > 0) {
                        array_pop($val);
                    };
                    $i = 0;
                    while ($i < $nbVal) {
                        $cmd = sprintf('IM%d_00%d', $k, $i+1);
                        $infoVal = $this->_sdi12Port->querySdi12($this->_addr, $cmd, 5000);
                        $data = explode(';', $infoVal);
                        $data = explode(',', $data[0]);
                        while (sizeof($listVal) > 0) {
                            array_pop($listVal);
                        };
                        $listVal[] = sprintf('M%d', $k);
                        $listVal[] = $i+1;
                        $j = 0;
                        while (sizeof($data) < $size) {
                            $data[] = '';
                        }
                        while ($j < sizeof($data)) {
                            $listVal[] = $data[$j];
                            $j = $j + 1;
                        }
                        $val[] = $listVal;
                        $i = $i + 1;
                    }
                }
            }
            $k = $k + 1;
        }
        $this->_valuesDesc = $val;
    }

    //--- (end of generated code: YSdi12Sensor implementation)

//--- (generated code: YSdi12Port return codes)
//--- (end of generated code: YSdi12Port return codes)
//--- (generated code: YSdi12Port definitions)
if (!defined('Y_VOLTAGELEVEL_OFF')) {
    define('Y_VOLTAGELEVEL_OFF', 0);
}
if (!defined('Y_VOLTAGELEVEL_TTL3V')) {
    define('Y_VOLTAGELEVEL_TTL3V', 1);
}
if (!defined('Y_VOLTAGELEVEL_TTL3VR')) {
    define('Y_VOLTAGELEVEL_TTL3VR', 2);
}
if (!defined('Y_VOLTAGELEVEL_TTL5V')) {
    define('Y_VOLTAGELEVEL_TTL5V', 3);
}
if (!defined('Y_VOLTAGELEVEL_TTL5VR')) {
    define('Y_VOLTAGELEVEL_TTL5VR', 4);
}
if (!defined('Y_VOLTAGELEVEL_RS232')) {
    define('Y_VOLTAGELEVEL_RS232', 5);
}
if (!defined('Y_VOLTAGELEVEL_RS485')) {
    define('Y_VOLTAGELEVEL_RS485', 6);
}
if (!defined('Y_VOLTAGELEVEL_TTL1V8')) {
    define('Y_VOLTAGELEVEL_TTL1V8', 7);
}
if (!defined('Y_VOLTAGELEVEL_SDI12')) {
    define('Y_VOLTAGELEVEL_SDI12', 8);
}
if (!defined('Y_VOLTAGELEVEL_INVALID')) {
    define('Y_VOLTAGELEVEL_INVALID', -1);
}
if (!defined('Y_RXCOUNT_INVALID')) {
    define('Y_RXCOUNT_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_TXCOUNT_INVALID')) {
    define('Y_TXCOUNT_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_ERRCOUNT_INVALID')) {
    define('Y_ERRCOUNT_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_RXMSGCOUNT_INVALID')) {
    define('Y_RXMSGCOUNT_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_TXMSGCOUNT_INVALID')) {
    define('Y_TXMSGCOUNT_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_LASTMSG_INVALID')) {
    define('Y_LASTMSG_INVALID', YAPI_INVALID_STRING);
}
if (!defined('Y_CURRENTJOB_INVALID')) {
    define('Y_CURRENTJOB_INVALID', YAPI_INVALID_STRING);
}
if (!defined('Y_STARTUPJOB_INVALID')) {
    define('Y_STARTUPJOB_INVALID', YAPI_INVALID_STRING);
}
if (!defined('Y_JOBMAXTASK_INVALID')) {
    define('Y_JOBMAXTASK_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_JOBMAXSIZE_INVALID')) {
    define('Y_JOBMAXSIZE_INVALID', YAPI_INVALID_UINT);
}
if (!defined('Y_COMMAND_INVALID')) {
    define('Y_COMMAND_INVALID', YAPI_INVALID_STRING);
}
if (!defined('Y_PROTOCOL_INVALID')) {
    define('Y_PROTOCOL_INVALID', YAPI_INVALID_STRING);
}
if (!defined('Y_SERIALMODE_INVALID')) {
    define('Y_SERIALMODE_INVALID', YAPI_INVALID_STRING);
}
//--- (end of generated code: YSdi12Port definitions)
    #--- (generated code: YSdi12Port yapiwrapper)

   #--- (end of generated code: YSdi12Port yapiwrapper)

//--- (generated code: YSdi12Port declaration)
