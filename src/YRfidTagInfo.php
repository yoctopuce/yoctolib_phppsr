<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YRfidTagInfo Class: RFID tag description, used by class YRfidReader
 *
 * YRfidTagInfo objects are used to describe RFID tag attributes,
 * such as the tag type and its storage size. These objects are returned by
 * method get_tagInfo() of class YRfidReader.
 */
class YRfidTagInfo
{
    const IEC_15693                      = 1;
    const IEC_14443                      = 2;
    const IEC_14443_MIFARE_ULTRALIGHT    = 3;
    const IEC_14443_MIFARE_CLASSIC1K     = 4;
    const IEC_14443_MIFARE_CLASSIC4K     = 5;
    const IEC_14443_MIFARE_DESFIRE       = 6;
    const IEC_14443_NTAG_213             = 7;
    const IEC_14443_NTAG_215             = 8;
    const IEC_14443_NTAG_216             = 9;
    const IEC_14443_NTAG_424_DNA         = 10;
    //--- (end of generated code: YRfidTagInfo declaration)

    //--- (generated code: YRfidTagInfo attributes)
    protected string $_tagId = "";                           // str
    protected int $_tagType = 0;                            // int
    protected string $_typeStr = "";                           // str
    protected int $_size = 0;                            // int
    protected int $_usable = 0;                            // int
    protected int $_blksize = 0;                            // int
    protected int $_fblk = 0;                            // int
    protected int $_lblk = 0;                            // int

    //--- (end of generated code: YRfidTagInfo attributes)

    function __construct()
    {
        //--- (generated code: YRfidTagInfo constructor)
        //--- (end of generated code: YRfidTagInfo constructor)
    }

    //--- (generated code: YRfidTagInfo implementation)

    /**
     * Returns the RFID tag identifier.
     *
     * @return string  a string with the RFID tag identifier.
     */
    public function get_tagId(): string
    {
        return $this->_tagId;
    }

    /**
     * Returns the type of the RFID tag, as a numeric constant.
     * (IEC_14443_MIFARE_CLASSIC1K, ...).
     *
     * @return int  an integer corresponding to the RFID tag type
     */
    public function get_tagType(): int
    {
        return $this->_tagType;
    }

    /**
     * Returns the type of the RFID tag, as a string.
     *
     * @return string  a string corresponding to the RFID tag type
     */
    public function get_tagTypeStr(): string
    {
        return $this->_typeStr;
    }

    /**
     * Returns the total memory size of the RFID tag, in bytes.
     *
     * @return int  the total memory size of the RFID tag
     */
    public function get_tagMemorySize(): int
    {
        return $this->_size;
    }

    /**
     * Returns the usable storage size of the RFID tag, in bytes.
     *
     * @return int  the usable storage size of the RFID tag
     */
    public function get_tagUsableSize(): int
    {
        return $this->_usable;
    }

    /**
     * Returns the block size of the RFID tag, in bytes.
     *
     * @return int  the block size of the RFID tag
     */
    public function get_tagBlockSize(): int
    {
        return $this->_blksize;
    }

    /**
     * Returns the index of the first usable storage block on the RFID tag.
     *
     * @return int  the index of the first usable storage block on the RFID tag
     */
    public function get_tagFirstBlock(): int
    {
        return $this->_fblk;
    }

    /**
     * Returns the index of the last usable storage block on the RFID tag.
     *
     * @return int  the index of the last usable storage block on the RFID tag
     */
    public function get_tagLastBlock(): int
    {
        return $this->_lblk;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function imm_init(string $tagId, int $tagType, int $size, int $usable, int $blksize, int $fblk, int $lblk): void
    {
        // $typeStr                is a str;
        $typeStr = 'unknown';
        if ($tagType == self::IEC_15693) {
            $typeStr = 'IEC 15693';
        }
        if ($tagType == self::IEC_14443) {
            $typeStr = 'IEC 14443';
        }
        if ($tagType == self::IEC_14443_MIFARE_ULTRALIGHT) {
            $typeStr = 'MIFARE Ultralight';
        }
        if ($tagType == self::IEC_14443_MIFARE_CLASSIC1K) {
            $typeStr = 'MIFARE Classic 1K';
        }
        if ($tagType == self::IEC_14443_MIFARE_CLASSIC4K) {
            $typeStr = 'MIFARE Classic 4K';
        }
        if ($tagType == self::IEC_14443_MIFARE_DESFIRE) {
            $typeStr = 'MIFARE DESFire';
        }
        if ($tagType == self::IEC_14443_NTAG_213) {
            $typeStr = 'NTAG 213';
        }
        if ($tagType == self::IEC_14443_NTAG_215) {
            $typeStr = 'NTAG 215';
        }
        if ($tagType == self::IEC_14443_NTAG_216) {
            $typeStr = 'NTAG 216';
        }
        if ($tagType == self::IEC_14443_NTAG_424_DNA) {
            $typeStr = 'NTAG 424 DNA';
        }
        $this->_tagId = $tagId;
        $this->_tagType = $tagType;
        $this->_typeStr = $typeStr;
        $this->_size = $size;
        $this->_usable = $usable;
        $this->_blksize = $blksize;
        $this->_fblk = $fblk;
        $this->_lblk = $lblk;
    }

    //--- (end of generated code: YRfidTagInfo implementation)

}
