<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YRfidStatus Class: Detailled information about the result of RFID tag operations
 *
 * YRfidStatus objects provide additional information about
 * operations on RFID tags, including the range of blocks affected
 * by read/write operations and possible errors when communicating
 * with RFID tags.
 * This makes it possible, for example, to distinguish communication
 * errors that can be recovered by an additional attempt, from
 * security or other errors on the tag.
 */
class YRfidStatus
{
    const SUCCESS                        = 0;
    const COMMAND_NOT_SUPPORTED          = 1;
    const COMMAND_NOT_RECOGNIZED         = 2;
    const COMMAND_OPTION_NOT_RECOGNIZED  = 3;
    const COMMAND_CANNOT_BE_PROCESSED_IN_TIME = 4;
    const UNDOCUMENTED_ERROR             = 15;
    const BLOCK_NOT_AVAILABLE            = 16;
    const BLOCK_ALREADY_LOCKED           = 17;
    const BLOCK_LOCKED                   = 18;
    const BLOCK_NOT_SUCESSFULLY_PROGRAMMED = 19;
    const BLOCK_NOT_SUCESSFULLY_LOCKED   = 20;
    const BLOCK_IS_PROTECTED             = 21;
    const CRYPTOGRAPHIC_ERROR            = 64;
    const READER_BUSY                    = 1000;
    const TAG_NOTFOUND                   = 1001;
    const TAG_LEFT                       = 1002;
    const TAG_JUSTLEFT                   = 1003;
    const TAG_COMMUNICATION_ERROR        = 1004;
    const TAG_NOT_RESPONDING             = 1005;
    const TIMEOUT_ERROR                  = 1006;
    const COLLISION_DETECTED             = 1007;
    const INVALID_CMD_ARGUMENTS          = -66;
    const UNKNOWN_CAPABILITIES           = -67;
    const MEMORY_NOT_SUPPORTED           = -68;
    const INVALID_BLOCK_INDEX            = -69;
    const MEM_SPACE_UNVERRUN_ATTEMPT     = -70;
    const BROWNOUT_DETECTED              = -71     ;
    const BUFFER_OVERFLOW                = -72;
    const CRC_ERROR                      = -73;
    const COMMAND_RECEIVE_TIMEOUT        = -75;
    const DID_NOT_SLEEP                  = -76;
    const ERROR_DECIMAL_EXPECTED         = -77;
    const HARDWARE_FAILURE               = -78;
    const ERROR_HEX_EXPECTED             = -79;
    const FIFO_LENGTH_ERROR              = -80;
    const FRAMING_ERROR                  = -81;
    const NOT_IN_CNR_MODE                = -82;
    const NUMBER_OU_OF_RANGE             = -83;
    const NOT_SUPPORTED                  = -84;
    const NO_RF_FIELD_ACTIVE             = -85;
    const READ_DATA_LENGTH_ERROR         = -86;
    const WATCHDOG_RESET                 = -87;
    const UNKNOW_COMMAND                 = -91;
    const UNKNOW_ERROR                   = -92;
    const UNKNOW_PARAMETER               = -93;
    const UART_RECEIVE_ERROR             = -94;
    const WRONG_DATA_LENGTH              = -95;
    const WRONG_MODE                     = -96;
    const UNKNOWN_DWARFxx_ERROR_CODE     = -97;
    const RESPONSE_SHORT                 = -98;
    const UNEXPECTED_TAG_ID_IN_RESPONSE  = -99;
    const UNEXPECTED_TAG_INDEX           = -100;
    const READ_EOF                       = -101;
    const READ_OK_SOFAR                  = -102;
    const WRITE_DATA_MISSING             = -103;
    const WRITE_TOO_MUCH_DATA            = -104;
    const TRANSFER_CLOSED                = -105;
    const COULD_NOT_BUILD_REQUEST        = -106;
    const INVALID_OPTIONS                = -107;
    const UNEXPECTED_RESPONSE            = -108;
    const AFI_NOT_AVAILABLE              = -109;
    const DSFID_NOT_AVAILABLE            = -110;
    const TAG_RESPONSE_TOO_SHORT         = -111;
    const DEC_EXPECTED                   = -112 ;
    const HEX_EXPECTED                   = -113;
    const NOT_SAME_SECOR                 = -114;
    const MIFARE_AUTHENTICATED           = -115;
    const NO_DATABLOCK                   = -116;
    const KEYB_IS_READABLE               = -117;
    const OPERATION_NOT_EXECUTED         = -118;
    const BLOK_MODE_ERROR                = -119;
    const BLOCK_NOT_WRITABLE             = -120;
    const BLOCK_ACCESS_ERROR             = -121;
    const BLOCK_NOT_AUTHENTICATED        = -122;
    const ACCESS_KEY_BIT_NOT_WRITABLE    = -123;
    const USE_KEYA_FOR_AUTH              = -124;
    const USE_KEYB_FOR_AUTH              = -125;
    const KEY_NOT_CHANGEABLE             = -126;
    const BLOCK_TOO_HIGH                 = -127;
    const AUTH_ERR                       = -128;
    const NOKEY_SELECT                   = -129;
    const CARD_NOT_SELECTED              = -130;
    const BLOCK_TO_READ_NONE             = -131;
    const NO_TAG                         = -132;
    const TOO_MUCH_DATA                  = -133;
    const CON_NOT_SATISFIED              = -134;
    const BLOCK_IS_SPECIAL               = -135;
    const READ_BEYOND_ANNOUNCED_SIZE     = -136;
    const BLOCK_ZERO_IS_RESERVED         = -137;
    const VALUE_BLOCK_BAD_FORMAT         = -138;
    const ISO15693_ONLY_FEATURE          = -139;
    const ISO14443_ONLY_FEATURE          = -140;
    const MIFARE_CLASSIC_ONLY_FEATURE    = -141;
    const BLOCK_MIGHT_BE_PROTECTED       = -142;
    const NO_SUCH_BLOCK                  = -143;
    const COUNT_TOO_BIG                  = -144;
    const UNKNOWN_MEM_SIZE               = -145;
    const MORE_THAN_2BLOCKS_MIGHT_NOT_WORK = -146;
    const READWRITE_NOT_SUPPORTED        = -147;
    const UNEXPECTED_VICC_ID_IN_RESPONSE = -148;
    const LOCKBLOCK_NOT_SUPPORTED        = -150;
    const INTERNAL_ERROR_SHOULD_NEVER_HAPPEN = -151;
    const INVLD_BLOCK_MODE_COMBINATION   = -152;
    const INVLD_ACCESS_MODE_COMBINATION  = -153;
    const INVALID_SIZE                   = -154;
    const BAD_PASSWORD_FORMAT            = -155;
    //--- (end of generated code: YRfidStatus declaration)

    //--- (generated code: YRfidStatus attributes)
    protected string $_tagId = "";                           // str
    protected int $_errCode = 0;                            // int
    protected int $_errBlk = 0;                            // int
    protected string $_errMsg = "";                           // str
    protected int $_yapierr = 0;                            // int
    protected int $_fab = 0;                            // int
    protected int $_lab = 0;                            // int

    //--- (end of generated code: YRfidStatus attributes)

    function __construct()
    {
        //--- (generated code: YRfidStatus constructor)
        //--- (end of generated code: YRfidStatus constructor)
    }

    //--- (generated code: YRfidStatus implementation)

    /**
     * Returns RFID tag identifier related to the status.
     *
     * @return string  a string with the RFID tag identifier.
     */
    public function get_tagId(): string
    {
        return $this->_tagId;
    }

    /**
     * Returns the detailled error code, or 0 if no error happened.
     *
     * @return int  a numeric error code
     */
    public function get_errorCode(): int
    {
        return $this->_errCode;
    }

    /**
     * Returns the RFID tag memory block number where the error was encountered, or -1 if the
     * error is not specific to a memory block.
     *
     * @return int  an RFID tag block number
     */
    public function get_errorBlock(): int
    {
        return $this->_errBlk;
    }

    /**
     * Returns a string describing precisely the RFID commande result.
     *
     * @return string  an error message string
     */
    public function get_errorMessage(): string
    {
        return $this->_errMsg;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_yapiError(): int
    {
        return $this->_yapierr;
    }

    /**
     * Returns the block number of the first RFID tag memory block affected
     * by the operation. Depending on the type of operation and on the tag
     * memory granularity, this number may be smaller than the requested
     * memory block index.
     *
     * @return int  an RFID tag block number
     */
    public function get_firstAffectedBlock(): int
    {
        return $this->_fab;
    }

    /**
     * Returns the block number of the last RFID tag memory block affected
     * by the operation. Depending on the type of operation and on the tag
     * memory granularity, this number may be bigger than the requested
     * memory block index.
     *
     * @return int  an RFID tag block number
     */
    public function get_lastAffectedBlock(): int
    {
        return $this->_lab;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function imm_init(string $tagId, int $errCode, int $errBlk, int $fab, int $lab): void
    {
        // $errMsg                 is a str;
        if ($errCode == 0) {
            $this->_yapierr = YAPI::SUCCESS;
            $errMsg = 'Success (no error)';
        } else {
            if ($errCode < 0) {
                if ($errCode > -50) {
                    $this->_yapierr = $errCode;
                    $errMsg = sprintf('YoctoLib error %d', $errCode);
                } else {
                    $this->_yapierr = YAPI::RFID_HARD_ERROR;
                    $errMsg = sprintf('Non-recoverable RFID error %d', $errCode);
                }
            } else {
                if ($errCode > 1000) {
                    $this->_yapierr = YAPI::RFID_SOFT_ERROR;
                    $errMsg = sprintf('Recoverable RFID error %d', $errCode);
                } else {
                    $this->_yapierr = YAPI::RFID_HARD_ERROR;
                    $errMsg = sprintf('Non-recoverable RFID error %d', $errCode);
                }
            }
            if ($errCode == self::TAG_NOTFOUND) {
                $errMsg = 'Tag not found';
            }
            if ($errCode == self::TAG_JUSTLEFT) {
                $errMsg = 'Tag left during operation';
            }
            if ($errCode == self::TAG_LEFT) {
                $errMsg = 'Tag not here anymore';
            }
            if ($errCode == self::READER_BUSY) {
                $errMsg = 'Reader is busy';
            }
            if ($errCode == self::INVALID_CMD_ARGUMENTS) {
                $errMsg = 'Invalid command arguments';
            }
            if ($errCode == self::UNKNOWN_CAPABILITIES) {
                $errMsg = 'Unknown capabilities';
            }
            if ($errCode == self::MEMORY_NOT_SUPPORTED) {
                $errMsg = 'Memory no present';
            }
            if ($errCode == self::INVALID_BLOCK_INDEX) {
                $errMsg = 'Invalid block index';
            }
            if ($errCode == self::MEM_SPACE_UNVERRUN_ATTEMPT) {
                $errMsg = 'Tag memory space overrun attempt';
            }
            if ($errCode == self::COMMAND_NOT_SUPPORTED) {
                $errMsg = 'The command is not supported';
            }
            if ($errCode == self::COMMAND_NOT_RECOGNIZED) {
                $errMsg = 'The command is not recognized';
            }
            if ($errCode == self::COMMAND_OPTION_NOT_RECOGNIZED) {
                $errMsg = 'The command option is not supported.';
            }
            if ($errCode == self::COMMAND_CANNOT_BE_PROCESSED_IN_TIME) {
                $errMsg = 'The command cannot be processed in time';
            }
            if ($errCode == self::UNDOCUMENTED_ERROR) {
                $errMsg = 'Error with no information given';
            }
            if ($errCode == self::BLOCK_NOT_AVAILABLE) {
                $errMsg = 'Block is not available';
            }
            if ($errCode == self::BLOCK_ALREADY_LOCKED) {
                $errMsg = 'Block is already locked and thus cannot be locked again.';
            }
            if ($errCode == self::BLOCK_LOCKED) {
                $errMsg = 'Block is locked and its content cannot be changed';
            }
            if ($errCode == self::BLOCK_NOT_SUCESSFULLY_PROGRAMMED) {
                $errMsg = 'Block was not successfully programmed';
            }
            if ($errCode == self::BLOCK_NOT_SUCESSFULLY_LOCKED) {
                $errMsg = 'Block was not successfully locked';
            }
            if ($errCode == self::BLOCK_IS_PROTECTED) {
                $errMsg = 'Block is protected';
            }
            if ($errCode == self::CRYPTOGRAPHIC_ERROR) {
                $errMsg = 'Generic cryptographic error';
            }
            if ($errCode == self::BROWNOUT_DETECTED) {
                $errMsg = 'BrownOut detected (BOD)';
            }
            if ($errCode == self::BUFFER_OVERFLOW) {
                $errMsg = 'Buffer Overflow (BOF)';
            }
            if ($errCode == self::CRC_ERROR) {
                $errMsg = 'Communication CRC Error (CCE)';
            }
            if ($errCode == self::COLLISION_DETECTED) {
                $errMsg = 'Collision Detected (CLD/CDT)';
            }
            if ($errCode == self::COMMAND_RECEIVE_TIMEOUT) {
                $errMsg = 'Command Receive Timeout (CRT)';
            }
            if ($errCode == self::DID_NOT_SLEEP) {
                $errMsg = 'Did Not Sleep (DNS)';
            }
            if ($errCode == self::ERROR_DECIMAL_EXPECTED) {
                $errMsg = 'Error Decimal Expected (EDX)';
            }
            if ($errCode == self::HARDWARE_FAILURE) {
                $errMsg = 'Error Hardware Failure (EHF)';
            }
            if ($errCode == self::ERROR_HEX_EXPECTED) {
                $errMsg = 'Error Hex Expected (EHX)';
            }
            if ($errCode == self::FIFO_LENGTH_ERROR) {
                $errMsg = 'FIFO length error (FLE)';
            }
            if ($errCode == self::FRAMING_ERROR) {
                $errMsg = 'Framing error (FER)';
            }
            if ($errCode == self::NOT_IN_CNR_MODE) {
                $errMsg = 'Not in CNR Mode (NCM)';
            }
            if ($errCode == self::NUMBER_OU_OF_RANGE) {
                $errMsg = 'Number Out of Range (NOR)';
            }
            if ($errCode == self::NOT_SUPPORTED) {
                $errMsg = 'Not Supported (NOS)';
            }
            if ($errCode == self::NO_RF_FIELD_ACTIVE) {
                $errMsg = 'No RF field active (NRF)';
            }
            if ($errCode == self::READ_DATA_LENGTH_ERROR) {
                $errMsg = 'Read data length error (RDL)';
            }
            if ($errCode == self::WATCHDOG_RESET) {
                $errMsg = 'Watchdog reset (SRT)';
            }
            if ($errCode == self::TAG_COMMUNICATION_ERROR) {
                $errMsg = 'Tag Communication Error (TCE)';
            }
            if ($errCode == self::TAG_NOT_RESPONDING) {
                $errMsg = 'Tag Not Responding (TNR)';
            }
            if ($errCode == self::TIMEOUT_ERROR) {
                $errMsg = 'TimeOut Error (TOE)';
            }
            if ($errCode == self::UNKNOW_COMMAND) {
                $errMsg = 'Unknown Command (UCO)';
            }
            if ($errCode == self::UNKNOW_ERROR) {
                $errMsg = 'Unknown error (UER)';
            }
            if ($errCode == self::UNKNOW_PARAMETER) {
                $errMsg = 'Unknown Parameter (UPA)';
            }
            if ($errCode == self::UART_RECEIVE_ERROR) {
                $errMsg = 'UART Receive Error (URE)';
            }
            if ($errCode == self::WRONG_DATA_LENGTH) {
                $errMsg = 'Wrong Data Length (WDL)';
            }
            if ($errCode == self::WRONG_MODE) {
                $errMsg = 'Wrong Mode (WMO)';
            }
            if ($errCode == self::UNKNOWN_DWARFxx_ERROR_CODE) {
                $errMsg = 'Unknown DWARF15 error code';
            }
            if ($errCode == self::UNEXPECTED_TAG_ID_IN_RESPONSE) {
                $errMsg = 'Unexpected Tag id in response';
            }
            if ($errCode == self::UNEXPECTED_TAG_INDEX) {
                $errMsg = 'internal error : unexpected TAG index';
            }
            if ($errCode == self::TRANSFER_CLOSED) {
                $errMsg = 'transfer closed';
            }
            if ($errCode == self::WRITE_DATA_MISSING) {
                $errMsg = 'Missing write data';
            }
            if ($errCode == self::WRITE_TOO_MUCH_DATA) {
                $errMsg = 'Attempt to write too much data';
            }
            if ($errCode == self::COULD_NOT_BUILD_REQUEST) {
                $errMsg = 'Could not not request';
            }
            if ($errCode == self::INVALID_OPTIONS) {
                $errMsg = 'Invalid transfer options';
            }
            if ($errCode == self::UNEXPECTED_RESPONSE) {
                $errMsg = 'Unexpected Tag response';
            }
            if ($errCode == self::AFI_NOT_AVAILABLE) {
                $errMsg = 'AFI not available';
            }
            if ($errCode == self::DSFID_NOT_AVAILABLE) {
                $errMsg = 'DSFID not available';
            }
            if ($errCode == self::TAG_RESPONSE_TOO_SHORT) {
                $errMsg = 'Tag\'s response too short';
            }
            if ($errCode == self::DEC_EXPECTED) {
                $errMsg = 'Error Decimal value Expected, or is missing';
            }
            if ($errCode == self::HEX_EXPECTED) {
                $errMsg = 'Error Hexadecimal value Expected, or is missing';
            }
            if ($errCode == self::NOT_SAME_SECOR) {
                $errMsg = 'Input and Output block are not in the same Sector';
            }
            if ($errCode == self::MIFARE_AUTHENTICATED) {
                $errMsg = 'No chip with MIFARE Classic technology Authenticated';
            }
            if ($errCode == self::NO_DATABLOCK) {
                $errMsg = 'No Data Block';
            }
            if ($errCode == self::KEYB_IS_READABLE) {
                $errMsg = 'Key B is Readable';
            }
            if ($errCode == self::OPERATION_NOT_EXECUTED) {
                $errMsg = 'Operation Not Executed, would have caused an overflow';
            }
            if ($errCode == self::BLOK_MODE_ERROR) {
                $errMsg = 'Block has not been initialized as a \'value block\'';
            }
            if ($errCode == self::BLOCK_NOT_WRITABLE) {
                $errMsg = 'Block Not Writable';
            }
            if ($errCode == self::BLOCK_ACCESS_ERROR) {
                $errMsg = 'Block Access Error';
            }
            if ($errCode == self::BLOCK_NOT_AUTHENTICATED) {
                $errMsg = 'Block Not Authenticated';
            }
            if ($errCode == self::ACCESS_KEY_BIT_NOT_WRITABLE) {
                $errMsg = 'Access bits or Keys not Writable';
            }
            if ($errCode == self::USE_KEYA_FOR_AUTH) {
                $errMsg = 'Use Key B for authentication';
            }
            if ($errCode == self::USE_KEYB_FOR_AUTH) {
                $errMsg = 'Use Key A for authentication';
            }
            if ($errCode == self::KEY_NOT_CHANGEABLE) {
                $errMsg = 'Key(s) not changeable';
            }
            if ($errCode == self::BLOCK_TOO_HIGH) {
                $errMsg = 'Block index is too high';
            }
            if ($errCode == self::AUTH_ERR) {
                $errMsg = 'Authentication Error (i.e. wrong key)';
            }
            if ($errCode == self::NOKEY_SELECT) {
                $errMsg = 'No Key Select, select a temporary or a static key';
            }
            if ($errCode == self::CARD_NOT_SELECTED) {
                $errMsg = ' Card is Not Selected';
            }
            if ($errCode == self::BLOCK_TO_READ_NONE) {
                $errMsg = 'Number of Blocks to Read is 0';
            }
            if ($errCode == self::NO_TAG) {
                $errMsg = 'No Tag detected';
            }
            if ($errCode == self::TOO_MUCH_DATA) {
                $errMsg = 'Too Much Data (i.e. Uart input buffer overflow)';
            }
            if ($errCode == self::CON_NOT_SATISFIED) {
                $errMsg = 'Conditions Not Satisfied';
            }
            if ($errCode == self::BLOCK_IS_SPECIAL) {
                $errMsg = 'Bad parameter: block is a special block';
            }
            if ($errCode == self::READ_BEYOND_ANNOUNCED_SIZE) {
                $errMsg = 'Attempt to read more than announced size.';
            }
            if ($errCode == self::BLOCK_ZERO_IS_RESERVED) {
                $errMsg = 'Block 0 is reserved and cannot be used';
            }
            if ($errCode == self::VALUE_BLOCK_BAD_FORMAT) {
                $errMsg = 'One value block is not properly initialized';
            }
            if ($errCode == self::ISO15693_ONLY_FEATURE) {
                $errMsg = 'Feature available on ISO 15693 only';
            }
            if ($errCode == self::ISO14443_ONLY_FEATURE) {
                $errMsg = 'Feature available on ISO 14443 only';
            }
            if ($errCode == self::MIFARE_CLASSIC_ONLY_FEATURE) {
                $errMsg = 'Feature available on ISO 14443 MIFARE Classic only';
            }
            if ($errCode == self::BLOCK_MIGHT_BE_PROTECTED) {
                $errMsg = 'Block might be protected';
            }
            if ($errCode == self::NO_SUCH_BLOCK) {
                $errMsg = 'No such block';
            }
            if ($errCode == self::COUNT_TOO_BIG) {
                $errMsg = 'Count parameter is too large';
            }
            if ($errCode == self::UNKNOWN_MEM_SIZE) {
                $errMsg = 'Tag memory size is unknown';
            }
            if ($errCode == self::MORE_THAN_2BLOCKS_MIGHT_NOT_WORK) {
                $errMsg = 'Writing more than two blocks at once might not be supported by $this tag';
            }
            if ($errCode == self::READWRITE_NOT_SUPPORTED) {
                $errMsg = 'Read/write operation not supported for $this tag';
            }
            if ($errCode == self::UNEXPECTED_VICC_ID_IN_RESPONSE) {
                $errMsg = 'Unexpected VICC ID in response';
            }
            if ($errCode == self::LOCKBLOCK_NOT_SUPPORTED) {
                $errMsg = 'This tag does not support the Lock block function';
            }
            if ($errCode == self::INTERNAL_ERROR_SHOULD_NEVER_HAPPEN) {
                $errMsg = 'Yoctopuce RFID code ran into an unexpected state, please contact support';
            }
            if ($errCode == self::INVLD_BLOCK_MODE_COMBINATION) {
                $errMsg = 'Invalid combination of block mode options';
            }
            if ($errCode == self::INVLD_ACCESS_MODE_COMBINATION) {
                $errMsg = 'Invalid combination of access mode options';
            }
            if ($errCode == self::INVALID_SIZE) {
                $errMsg = 'Invalid data size parameter';
            }
            if ($errCode == self::BAD_PASSWORD_FORMAT) {
                $errMsg = 'Bad password format or type';
            }
            if ($errBlk >= 0) {
                $errMsg = sprintf('%s (block %d)', $errMsg, $errBlk);
            }
        }
        $this->_tagId = $tagId;
        $this->_errCode = $errCode;
        $this->_errBlk = $errBlk;
        $this->_errMsg = $errMsg;
        $this->_fab = $fab;
        $this->_lab = $lab;
    }

    //--- (end of generated code: YRfidStatus implementation)

}
