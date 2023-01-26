<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YFileRecord Class: Description of a file on the device filesystem, returned by files.get_list
 *
 * YFileRecord objects are used to describe a file that is stored on a Yoctopuce device.
 * These objects are used in particular in conjunction with the YFiles class.
 */
class YFileRecord
{
    //--- (end of generated code: YFileRecord declaration)

    //--- (generated code: YFileRecord attributes)
    protected string $_name = "";                           // str
    protected int $_size = 0;                            // int
    protected int $_crc = 0;                            // int

    //--- (end of generated code: YFileRecord attributes)

    function __construct($str_json)
    {
        //--- (generated code: YFileRecord constructor)
        //--- (end of generated code: YFileRecord constructor)

        $loadval = json_decode($str_json, TRUE);
        $this->_name = $loadval['name'];
        $this->_size = $loadval['size'];
        $this->_crc  = $loadval['crc'];
    }

    //--- (generated code: YFileRecord implementation)

    /**
     * Returns the name of the file.
     *
     * @return string  a string with the name of the file.
     */
    public function get_name(): string
    {
        return $this->_name;
    }

    /**
     * Returns the size of the file in bytes.
     *
     * @return int  the size of the file.
     */
    public function get_size(): int
    {
        return $this->_size;
    }

    /**
     * Returns the 32-bit CRC of the file content.
     *
     * @return int  the 32-bit CRC of the file content.
     */
    public function get_crc(): int
    {
        return $this->_crc;
    }

    //--- (end of generated code: YFileRecord implementation)

    function contentEquals($bin_content)
    {
        return ($this->_size == strlen($bin_content) &&
                $this->_crc == crc32($bin_content));
    }
}
