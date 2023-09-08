<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YSdi12SnoopingRecord Class: Intercepted SDI12 message description, returned by sdi12Port.snoopMessages method
 *
 *
 */
class YSdi12SnoopingRecord
{
    //--- (end of generated code: YSdi12SnoopingRecord declaration)

    //--- (generated code: YSdi12SnoopingRecord attributes)
    protected int $_tim = 0;                            // int
    protected int $_dir = 0;                            // int
    protected string $_msg = "";                           // str

    //--- (end of generated code: YSdi12SnoopingRecord attributes)

    function __construct(string $str_func)
    {
        //--- (generated code: YSdi12SnoopingRecord constructor)
        //--- (end of generated code: YSdi12SnoopingRecord constructor)
    }

    //--- (generated code: YSdi12SnoopingRecord implementation)

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

    //--- (end of generated code: YSdi12SnoopingRecord implementation)

//--- (generated code: YSdi12Sensor definitions)
//--- (end of generated code: YSdi12Sensor definitions)
    #--- (generated code: YSdi12Sensor yapiwrapper)

   #--- (end of generated code: YSdi12Sensor yapiwrapper)

//--- (generated code: YSdi12Sensor declaration)
