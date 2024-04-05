<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YRfidOptions Class: Additional parameters for operations on RFID tags.
 *
 * The YRfidOptions objects are used to specify additional
 * optional parameters to RFID commands that interact with tags,
 * including security keys. When instantiated,the parameters of
 * this object are pre-initialized to a value  which corresponds
 * to the most common usage.
 */
class YRfidOptions
{
    const NO_RFID_KEY                    = 0;
    const MIFARE_KEY_A                   = 1;
    const MIFARE_KEY_B                   = 2;
    //--- (end of generated code: YRfidOptions declaration)

    //--- (generated code: YRfidOptions attributes)

    /**
     * Type of security key to be used to access the RFID tag.
     * For MIFARE Classic tags, allowed values are
     * Y_MIFARE_KEY_A or Y_MIFARE_KEY_B.
     * The default value is Y_NO_RFID_KEY, in that case
     * the reader will use the most common default key for the
     * tag type.
     * When a security key is required, it must be provided
     * using property HexKey.
     */
    public int $KeyType = 0;

    /**
     * Security key to be used to access the RFID tag, as an
     * hexadecimal string. The key will only be used if you
     * also specify which type of key it is, using property
     * KeyType.
     */
    public string $HexKey = "";

    /**
     * Force the use of single-block commands to access RFID tag memory blocks.
     * By default, the Yoctopuce library uses the most efficient access strategy
     * generally available for each tag type, but you can force the use of
     * single-block commands if the RFID tags you are using do not support
     * multi-block commands. If opération speed is not a priority, choose
     * single-block mode as it will work with any mode.
     */
    public bool $ForceSingleBlockAccess = false;

    /**
     * Force the use of multi-block commands to access RFID tag memory blocks.
     * By default, the Yoctopuce library uses the most efficient access strategy
     * generally available for each tag type, but you can force the use of
     * multi-block commands if you know for sure that the RFID tags you are using
     * do support multi-block commands. Be  aware that even if a tag allows multi-block
     * operations, the maximum number of blocks that can be written or read at the same
     * time can be (very) limited. If the tag does not support multi-block mode
     * for the wanted opération, the option will be ignored.
     */
    public bool $ForceMultiBlockAccess = false;

    /**
     * Enable direct access to RFID tag control blocks.
     * By default, Yoctopuce library read and write functions only work
     * on data blocks and automatically skip special blocks, as specific functions are provided
     * to configure security parameters found in control blocks.
     * If you need to access control blocks in your own way using
     * read/write functions, enable this option.  Use this option wisely,
     * as overwriting a special block migth very well irreversibly alter your
     * tag behavior.
     */
    public bool $EnableRawAccess = false;

    /**
     * Disables the tag memory overflow test. By default, the Yoctopuce
     * library's read/write functions detect overruns and do not run
     * commands that are likely to fail. If you nevertheless wish to
     * try to access more memory than the tag announces, you can try to use
     * this option.
     */
    public bool $DisableBoundaryChecks = false;

    /**
     * Enable simulation mode to check the affected block range as well
     * as access rights. When this option is active, the operation is
     * not fully applied to the RFID tag but the affected block range
     * is determined and the optional access key is tested on these blocks.
     * The access key rights are not tested though. This option applies to
     * write / configure operations only, it is ignored for read operations.
     */
    public bool $EnableDryRun = false;

    //--- (end of generated code: YRfidOptions attributes)

    function __construct()
    {
        //--- (generated code: YRfidOptions constructor)
        //--- (end of generated code: YRfidOptions constructor)
    }

    //--- (generated code: YRfidOptions implementation)

    /**
     * @throws YAPI_Exception on error
     */
    public function imm_getParams(): string
    {
        // $opt                    is a int;
        // $res                    is a str;
        if ($this->ForceSingleBlockAccess) {
            $opt = 1;
        } else {
            $opt = 0;
        }
        if ($this->ForceMultiBlockAccess) {
            $opt = (($opt) | (2));
        }
        if ($this->EnableRawAccess) {
            $opt = (($opt) | (4));
        }
        if ($this->DisableBoundaryChecks) {
            $opt = (($opt) | (8));
        }
        if ($this->EnableDryRun) {
            $opt = (($opt) | (16));
        }
        $res = sprintf('&o=%d', $opt);
        if ($this->KeyType != 0) {
            $res = sprintf('%s&k=%02x:%s', $res, $this->KeyType, $this->HexKey);
        }
        return $res;
    }

    //--- (end of generated code: YRfidOptions implementation)

}
