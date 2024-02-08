<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YSnoopingRecord Class: Intercepted serial message description, returned by serialPort.snoopMessages method
 *
 *
 */
class YSnoopingRecord
{
    //--- (end of generated code: YSnoopingRecord declaration)

    //--- (generated code: YSnoopingRecord attributes)
    protected int $_tim = 0;                            // int
    protected int $_pos = 0;                            // int
    protected int $_dir = 0;                            // int
    protected string $_msg = "";                           // str

    //--- (end of generated code: YSnoopingRecord attributes)

    function __construct(string $str_json)
    {
        //--- (generated code: YSnoopingRecord constructor)
        //--- (end of generated code: YSnoopingRecord constructor)
        $loadval = json_decode($str_json, true);
        if (array_key_exists('t', $loadval)) {
            $this->_tim = $loadval['t'];
        }
        if (array_key_exists('p', $loadval)) {
            $this->_pos = $loadval['p'];
        }
        if (array_key_exists('m', $loadval)) {
            $this->_dir = $loadval['m'][0] == '<' ? 1 : 0;
            $this->_msg = substr($loadval['m'], 1);
        }
    }

    //--- (generated code: YSnoopingRecord implementation)

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
     * Returns the absolute position of the message end.
     *
     * @return int  the absolute position of the message end.
     */
    public function get_pos(): int
    {
        return $this->_pos;
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

    //--- (end of generated code: YSnoopingRecord implementation)
}

