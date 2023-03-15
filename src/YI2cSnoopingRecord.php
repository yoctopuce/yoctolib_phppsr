<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YI2cSnoopingRecord Class: Intercepted I2C message description, returned by i2cPort.snoopMessages method
 *
 *
 */
class YI2cSnoopingRecord
{
    //--- (end of generated code: YI2cSnoopingRecord declaration)

    //--- (generated code: YI2cSnoopingRecord attributes)
    protected int $_tim = 0;                            // int
    protected int $_dir = 0;                            // int
    protected string $_msg = "";                           // str

    //--- (end of generated code: YI2cSnoopingRecord attributes)

    function __construct(string $str_json)
    {
        //--- (generated code: YI2cSnoopingRecord constructor)
        //--- (end of generated code: YI2cSnoopingRecord constructor)

        $loadval = json_decode($str_json, true);
        $this->_tim = $loadval['t'];
        $this->_dir = $loadval['m'][0] == '<' ? 1 : 0;
        $this->_msg = substr($loadval['m'], 1);
    }

    //--- (generated code: YI2cSnoopingRecord implementation)

    /**
     * Returns the elapsed time, in ms, since the beginning of the preceding message.
     *
     * @return int  the elapsed time, in ms, since the beginning of the preceding message.
     */
    public function get_time(): int
    {
        return $this->_tim;
    }

    /**
     * Returns the message direction (RX=0, TX=1).
     *
     * @return int  the message direction (RX=0, TX=1).
     */
    public function get_direction(): int
    {
        return $this->_dir;
    }

    /**
     * Returns the message content.
     *
     * @return string  the message content.
     */
    public function get_message(): string
    {
        return $this->_msg;
    }

    //--- (end of generated code: YI2cSnoopingRecord implementation)
}

