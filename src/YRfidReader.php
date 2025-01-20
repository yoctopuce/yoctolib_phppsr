<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YRfidReader Class: RfidReader function interface
 *
 * The YRfidReader class allows you to detect RFID tags, as well as
 * read and write on these tags if the security settings allow it.
 *
 * Short reminder:
 *
 * - A tag's memory is generally organized in fixed-size blocks.
 * - At tag level, each block must be read and written in its entirety.
 * - Some blocks are special configuration blocks, and may alter the tag's behavior
 * if they are rewritten with arbitrary data.
 * - Data blocks can be set to read-only mode, but on many tags, this operation is irreversible.
 *
 *
 * By default, the RfidReader class automatically manages these blocks so that
 * arbitrary size data  can be manipulated of  without risk and without knowledge of
 * tag architecture.
 */
class YRfidReader extends YFunction
{
    const NTAGS_INVALID = YAPI::INVALID_UINT;
    const REFRESHRATE_INVALID = YAPI::INVALID_UINT;
    //--- (end of generated code: YRfidReader declaration)

    //--- (generated code: YRfidReader attributes)
    protected int $_nTags = self::NTAGS_INVALID;          // UInt31
    protected int $_refreshRate = self::REFRESHRATE_INVALID;    // UInt31
    protected mixed $_eventCallback = null;                         // YEventCallback
    protected bool $_isFirstCb = false;                        // bool
    protected int $_prevCbPos = 0;                            // int
    protected int $_eventPos = 0;                            // int
    protected int $_eventStamp = 0;                            // int

    //--- (end of generated code: YRfidReader attributes)

    function __construct(string $str_func)
    {
        //--- (generated code: YRfidReader constructor)
        parent::__construct($str_func);
        $this->_className = 'RfidReader';

        //--- (end of generated code: YRfidReader constructor)
    }

    //--- (generated code: YRfidReader implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'nTags':
            $this->_nTags = intval($val);
            return 1;
        case 'refreshRate':
            $this->_refreshRate = intval($val);
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the number of RFID tags currently detected.
     *
     * @return int  an integer corresponding to the number of RFID tags currently detected
     *
     * On failure, throws an exception or returns YRfidReader::NTAGS_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_nTags(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::NTAGS_INVALID;
            }
        }
        $res = $this->_nTags;
        return $res;
    }

    /**
     * Returns the tag list refresh rate, measured in Hz.
     *
     * @return int  an integer corresponding to the tag list refresh rate, measured in Hz
     *
     * On failure, throws an exception or returns YRfidReader::REFRESHRATE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_refreshRate(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::REFRESHRATE_INVALID;
            }
        }
        $res = $this->_refreshRate;
        return $res;
    }

    /**
     * Changes the present tag list refresh rate, measured in Hz. The reader will do
     * its best to respect it. Note that the reader cannot detect tag arrival or removal
     * while it is  communicating with a tag.  Maximum frequency is limited to 100Hz,
     * but in real life it will be difficult to do better than 50Hz.  A zero value
     * will power off the device radio.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param int $newval : an integer corresponding to the present tag list refresh rate, measured in Hz
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_refreshRate(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("refreshRate", $rest_val);
    }

    /**
     * Retrieves a RFID reader for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the RFID reader is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the RFID reader is
     * indeed online at a given time. In case of ambiguity when looking for
     * a RFID reader by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the RFID reader, for instance
     *         MyDevice.rfidReader.
     *
     * @return YRfidReader  a YRfidReader object allowing you to drive the RFID reader.
     */
    public static function FindRfidReader(string $func): YRfidReader
    {
        // $obj                    is a YRfidReader;
        $obj = YFunction::_FindFromCache('RfidReader', $func);
        if ($obj == null) {
            $obj = new YRfidReader($func);
            YFunction::_AddToCache('RfidReader', $func, $obj);
        }
        return $obj;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _chkerror(string $tagId, string $json, YRfidStatus &$status): int
    {
        // $jsonStr                is a str;
        // $errCode                is a int;
        // $errBlk                 is a int;
        // $fab                    is a int;
        // $lab                    is a int;
        // $retcode                is a int;

        if (strlen($json) == 0) {
            $errCode = $this->get_errorType();
            $errBlk = -1;
            $fab = -1;
            $lab = -1;
        } else {
            $jsonStr = YAPI::Ybin2str($json);
            $errCode = intVal($this->_json_get_key($json, 'err'));
            $errBlk = intVal($this->_json_get_key($json, 'errBlk'))-1;
            if (YAPI::Ystrpos($jsonStr,'"fab":') >= 0) {
                $fab = intVal($this->_json_get_key($json, 'fab'))-1;
                $lab = intVal($this->_json_get_key($json, 'lab'))-1;
            } else {
                $fab = -1;
                $lab = -1;
            }
        }
        $status->imm_init($tagId, $errCode, $errBlk, $fab, $lab);
        $retcode = $status->get_yapiError();
        if (!($retcode == YAPI::SUCCESS)) return $this->_throw($retcode,$status->get_errorMessage(),$retcode);
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function reset(): int
    {
        // $json                   is a bin;
        // $status                 is a YRfidStatus;
        $status = new YRfidStatus();

        $json = $this->_download('rfid.json?a=reset');
        return $this->_chkerror('', $json, $status);
    }

    /**
     * Returns the list of RFID tags currently detected by the reader.
     *
     * @return string[]  a list of strings, corresponding to each tag identifier (UID).
     *
     * On failure, throws an exception or returns an empty list.
     * @throws YAPI_Exception on error
     */
    public function get_tagIdList(): array
    {
        // $json                   is a bin;
        $jsonList = [];         // binArr;
        $taglist = [];          // strArr;

        $json = $this->_download('rfid.json?a=list');
        while (sizeof($taglist) > 0) {
            array_pop($taglist);
        };
        if (strlen($json) > 3) {
            $jsonList = $this->_json_get_array($json);
            foreach ($jsonList as $each) {
                $taglist[] = $this->_json_get_string($each);
            }
        }
        return $taglist;
    }

    /**
     * Returns a description of the properties of an existing RFID tag.
     * This function can cause communications with the tag.
     *
     * @param string $tagId : identifier of the tag to check
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return ?YRfidTagInfo  a YRfidTagInfo object.
     *
     * On failure, throws an exception or returns an empty YRfidTagInfo objact.
     * When it happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function get_tagInfo(string $tagId, YRfidStatus &$status): ?YRfidTagInfo
    {
        // $url                    is a str;
        // $json                   is a bin;
        // $tagType                is a int;
        // $size                   is a int;
        // $usable                 is a int;
        // $blksize                is a int;
        // $fblk                   is a int;
        // $lblk                   is a int;
        // $res                    is a YRfidTagInfo;
        $url = sprintf('rfid.json?a=info&t=%s',$tagId);

        $json = $this->_download($url);
        $this->_chkerror($tagId, $json, $status);
        $tagType = intVal($this->_json_get_key($json, 'type'));
        $size = intVal($this->_json_get_key($json, 'size'));
        $usable = intVal($this->_json_get_key($json, 'usable'));
        $blksize = intVal($this->_json_get_key($json, 'blksize'));
        $fblk = intVal($this->_json_get_key($json, 'fblk'));
        $lblk = intVal($this->_json_get_key($json, 'lblk'));
        $res = new YRfidTagInfo();
        $res->imm_init($tagId, $tagType, $size, $usable, $blksize, $fblk, $lblk);
        return $res;
    }

    /**
     * Changes an RFID tag configuration to prevents any further write to
     * the selected blocks. This operation is definitive and irreversible.
     * Depending on the tag type and block index, adjascent blocks may become
     * read-only as well, based on the locking granularity.
     *
     * @param string $tagId : identifier of the tag to use
     * @param int $firstBlock : first block to lock
     * @param int $nBlocks : number of blocks to lock
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function tagLockBlocks(string $tagId, int $firstBlock, int $nBlocks, YRfidOptions $options, YRfidStatus &$status): int
    {
        // $optstr                 is a str;
        // $url                    is a str;
        // $json                   is a bin;
        $optstr = $options->imm_getParams();
        $url = sprintf('rfid.json?a=lock&t=%s&b=%d&n=%d%s',$tagId,$firstBlock,$nBlocks,$optstr);

        $json = $this->_download($url);
        return $this->_chkerror($tagId, $json, $status);
    }

    /**
     * Reads the locked state for RFID tag memory data blocks.
     * FirstBlock cannot be a special block, and any special
     * block encountered in the middle of the read operation will be
     * skipped automatically.
     *
     * @param string $tagId : identifier of the tag to use
     * @param int $firstBlock : number of the first block to check
     * @param int $nBlocks : number of blocks to check
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return Boolean[]  a list of booleans with the lock state of selected blocks
     *
     * On failure, throws an exception or returns an empty list. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function get_tagLockState(string $tagId, int $firstBlock, int $nBlocks, YRfidOptions $options, YRfidStatus &$status): array
    {
        // $optstr                 is a str;
        // $url                    is a str;
        // $json                   is a bin;
        // $binRes                 is a bin;
        $res = [];              // boolArr;
        // $idx                    is a int;
        // $val                    is a int;
        // $isLocked               is a bool;
        $optstr = $options->imm_getParams();
        $url = sprintf('rfid.json?a=chkl&t=%s&b=%d&n=%d%s',$tagId,$firstBlock,$nBlocks,$optstr);

        $json = $this->_download($url);
        $this->_chkerror($tagId, $json, $status);
        if ($status->get_yapiError() != YAPI::SUCCESS) {
            return $res;
        }
        $binRes = YAPI::_hexStrToBin($this->_json_get_key($json, 'bitmap'));
        $idx = 0;
        while ($idx < $nBlocks) {
            $val = ord($binRes[(($idx) >> 3)]);
            $isLocked = ((($val) & (1 << (($idx) & 7))) != 0);
            $res[] = $isLocked;
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * Tells which block of a RFID tag memory are special and cannot be used
     * to store user data. Mistakely writing a special block can lead to
     * an irreversible alteration of the tag.
     *
     * @param string $tagId : identifier of the tag to use
     * @param int $firstBlock : number of the first block to check
     * @param int $nBlocks : number of blocks to check
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return Boolean[]  a list of booleans with the lock state of selected blocks
     *
     * On failure, throws an exception or returns an empty list. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function get_tagSpecialBlocks(string $tagId, int $firstBlock, int $nBlocks, YRfidOptions $options, YRfidStatus &$status): array
    {
        // $optstr                 is a str;
        // $url                    is a str;
        // $json                   is a bin;
        // $binRes                 is a bin;
        $res = [];              // boolArr;
        // $idx                    is a int;
        // $val                    is a int;
        // $isLocked               is a bool;
        $optstr = $options->imm_getParams();
        $url = sprintf('rfid.json?a=chks&t=%s&b=%d&n=%d%s',$tagId,$firstBlock,$nBlocks,$optstr);

        $json = $this->_download($url);
        $this->_chkerror($tagId, $json, $status);
        if ($status->get_yapiError() != YAPI::SUCCESS) {
            return $res;
        }
        $binRes = YAPI::_hexStrToBin($this->_json_get_key($json, 'bitmap'));
        $idx = 0;
        while ($idx < $nBlocks) {
            $val = ord($binRes[(($idx) >> 3)]);
            $isLocked = ((($val) & (1 << (($idx) & 7))) != 0);
            $res[] = $isLocked;
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * Reads data from an RFID tag memory, as an hexadecimal string.
     * The read operation may span accross multiple blocks if the requested
     * number of bytes is larger than the RFID tag block size. By default
     * firstBlock cannot be a special block, and any special block encountered
     * in the middle of the read operation will be skipped automatically.
     * If you rather want to read special blocks, use the EnableRawAccess
     * field from the options parameter.
     *
     * @param string $tagId : identifier of the tag to use
     * @param int $firstBlock : block number where read should start
     * @param int $nBytes : total number of bytes to read
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return string  an hexadecimal string if the call succeeds.
     *
     * On failure, throws an exception or returns an empty binary buffer. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function tagReadHex(string $tagId, int $firstBlock, int $nBytes, YRfidOptions $options, YRfidStatus &$status): string
    {
        // $optstr                 is a str;
        // $url                    is a str;
        // $json                   is a bin;
        // $hexbuf                 is a str;
        $optstr = $options->imm_getParams();
        $url = sprintf('rfid.json?a=read&t=%s&b=%d&n=%d%s',$tagId,$firstBlock,$nBytes,$optstr);

        $json = $this->_download($url);
        $this->_chkerror($tagId, $json, $status);
        if ($status->get_yapiError() == YAPI::SUCCESS) {
            $hexbuf = $this->_json_get_key($json, 'res');
        } else {
            $hexbuf = '';
        }
        return $hexbuf;
    }

    /**
     * Reads data from an RFID tag memory, as a binary buffer. The read operation
     * may span accross multiple blocks if the requested number of bytes
     * is larger than the RFID tag block size.  By default
     * firstBlock cannot be a special block, and any special block encountered
     * in the middle of the read operation will be skipped automatically.
     * If you rather want to read special blocks, use the EnableRawAccess
     * field frrm the options parameter.
     *
     * @param string $tagId : identifier of the tag to use
     * @param int $firstBlock : block number where read should start
     * @param int $nBytes : total number of bytes to read
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return string  a binary object with the data read if the call succeeds.
     *
     * On failure, throws an exception or returns an empty binary buffer. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function tagReadBin(string $tagId, int $firstBlock, int $nBytes, YRfidOptions $options, YRfidStatus &$status): string
    {
        return YAPI::_hexStrToBin($this->tagReadHex($tagId, $firstBlock, $nBytes, $options, $status));
    }

    /**
     * Reads data from an RFID tag memory, as a byte list. The read operation
     * may span accross multiple blocks if the requested number of bytes
     * is larger than the RFID tag block size.  By default
     * firstBlock cannot be a special block, and any special block encountered
     * in the middle of the read operation will be skipped automatically.
     * If you rather want to read special blocks, use the EnableRawAccess
     * field from the options parameter.
     *
     * @param string $tagId : identifier of the tag to use
     * @param int $firstBlock : block number where read should start
     * @param int $nBytes : total number of bytes to read
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return Integer[]  a byte list with the data read if the call succeeds.
     *
     * On failure, throws an exception or returns an empty list. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function tagReadArray(string $tagId, int $firstBlock, int $nBytes, YRfidOptions $options, YRfidStatus &$status): array
    {
        // $blk                    is a bin;
        // $idx                    is a int;
        // $endidx                 is a int;
        $res = [];              // intArr;
        $blk = $this->tagReadBin($tagId, $firstBlock, $nBytes, $options, $status);
        $endidx = strlen($blk);
        $idx = 0;
        while ($idx < $endidx) {
            $res[] = ord($blk[$idx]);
            $idx = $idx + 1;
        }
        return $res;
    }

    /**
     * Reads data from an RFID tag memory, as a text string. The read operation
     * may span accross multiple blocks if the requested number of bytes
     * is larger than the RFID tag block size.  By default
     * firstBlock cannot be a special block, and any special block encountered
     * in the middle of the read operation will be skipped automatically.
     * If you rather want to read special blocks, use the EnableRawAccess
     * field from the options parameter.
     *
     * @param string $tagId : identifier of the tag to use
     * @param int $firstBlock : block number where read should start
     * @param int $nChars : total number of characters to read
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return string  a text string with the data read if the call succeeds.
     *
     * On failure, throws an exception or returns an empty string. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function tagReadStr(string $tagId, int $firstBlock, int $nChars, YRfidOptions $options, YRfidStatus &$status): string
    {
        return YAPI::Ybin2str($this->tagReadBin($tagId, $firstBlock, $nChars, $options, $status));
    }

    /**
     * Writes data provided as a binary buffer to an RFID tag memory.
     * The write operation may span accross multiple blocks if the
     * number of bytes to write is larger than the RFID tag block size.
     * By default firstBlock cannot be a special block, and any special block
     * encountered in the middle of the write operation will be skipped
     * automatically. The last data block affected by the operation will
     * be automatically padded with zeros if neccessary.  If you rather want
     * to rewrite special blocks as well,
     * use the EnableRawAccess field from the options parameter.
     *
     * @param string $tagId : identifier of the tag to use
     * @param int $firstBlock : block number where write should start
     * @param string $buff : the binary buffer to write
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function tagWriteBin(string $tagId, int $firstBlock, string $buff, YRfidOptions $options, YRfidStatus &$status): int
    {
        // $optstr                 is a str;
        // $hexstr                 is a str;
        // $buflen                 is a int;
        // $fname                  is a str;
        // $json                   is a bin;
        $buflen = strlen($buff);
        if ($buflen <= 16) {
            // short data, use an URL-based command
            $hexstr = YAPI::_bytesToHexStr($buff);
            return $this->tagWriteHex($tagId, $firstBlock, $hexstr, $options, $status);
        } else {
            // long data, use an upload command
            $optstr = $options->imm_getParams();
            $fname = sprintf('Rfid:t=%s&b=%d&n=%d%s',$tagId,$firstBlock,$buflen,$optstr);
            $json = $this->_uploadEx($fname, $buff);
            return $this->_chkerror($tagId, $json, $status);
        }
    }

    /**
     * Writes data provided as a list of bytes to an RFID tag memory.
     * The write operation may span accross multiple blocks if the
     * number of bytes to write is larger than the RFID tag block size.
     * By default firstBlock cannot be a special block, and any special block
     * encountered in the middle of the write operation will be skipped
     * automatically. The last data block affected by the operation will
     * be automatically padded with zeros if neccessary.
     * If you rather want to rewrite special blocks as well,
     * use the EnableRawAccess field from the options parameter.
     *
     * @param string $tagId : identifier of the tag to use
     * @param int $firstBlock : block number where write should start
     * @param Integer[] $byteList : a list of byte to write
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function tagWriteArray(string $tagId, int $firstBlock, array $byteList, YRfidOptions $options, YRfidStatus &$status): int
    {
        // $bufflen                is a int;
        // $buff                   is a bin;
        // $idx                    is a int;
        // $hexb                   is a int;
        $bufflen = sizeof($byteList);
        $buff = ($bufflen > 0 ? pack('C',array_fill(0, $bufflen, 0)) : '');
        $idx = 0;
        while ($idx < $bufflen) {
            $hexb = $byteList[$idx];
            $buff[$idx] = pack('C', $hexb);
            $idx = $idx + 1;
        }

        return $this->tagWriteBin($tagId, $firstBlock, $buff, $options, $status);
    }

    /**
     * Writes data provided as an hexadecimal string to an RFID tag memory.
     * The write operation may span accross multiple blocks if the
     * number of bytes to write is larger than the RFID tag block size.
     * By default firstBlock cannot be a special block, and any special block
     * encountered in the middle of the write operation will be skipped
     * automatically. The last data block affected by the operation will
     * be automatically padded with zeros if neccessary.
     * If you rather want to rewrite special blocks as well,
     * use the EnableRawAccess field from the options parameter.
     *
     * @param string $tagId : identifier of the tag to use
     * @param int $firstBlock : block number where write should start
     * @param string $hexString : a string of hexadecimal byte codes to write
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function tagWriteHex(string $tagId, int $firstBlock, string $hexString, YRfidOptions $options, YRfidStatus &$status): int
    {
        // $bufflen                is a int;
        // $optstr                 is a str;
        // $url                    is a str;
        // $json                   is a bin;
        // $buff                   is a bin;
        // $idx                    is a int;
        // $hexb                   is a int;
        $bufflen = mb_strlen($hexString);
        $bufflen = (($bufflen) >> 1);
        if ($bufflen <= 16) {
            // short data, use an URL-based command
            $optstr = $options->imm_getParams();
            $url = sprintf('rfid.json?a=writ&t=%s&b=%d&w=%s%s',$tagId,$firstBlock,$hexString,$optstr);
            $json = $this->_download($url);
            return $this->_chkerror($tagId, $json, $status);
        } else {
            // long data, use an upload command
            $buff = ($bufflen > 0 ? pack('C',array_fill(0, $bufflen, 0)) : '');
            $idx = 0;
            while ($idx < $bufflen) {
                $hexb = hexdec(substr($hexString, 2 * $idx, 2));
                $buff[$idx] = pack('C', $hexb);
                $idx = $idx + 1;
            }
            return $this->tagWriteBin($tagId, $firstBlock, $buff, $options, $status);
        }
    }

    /**
     * Writes data provided as an ASCII string to an RFID tag memory.
     * The write operation may span accross multiple blocks if the
     * number of bytes to write is larger than the RFID tag block size.
     * Note that only the characters present in the provided string
     * will be written, there is no notion of string length. If your
     * string data have variable length, you'll have to encode the
     * string length yourself, with a terminal zero for instannce.
     *
     * This function only works with ISO-latin characters, if you wish to
     * write strings encoded with alternate character sets, you'll have to
     * use tagWriteBin() function.
     *
     * By default firstBlock cannot be a special block, and any special block
     * encountered in the middle of the write operation will be skipped
     * automatically. The last data block affected by the operation will
     * be automatically padded with zeros if neccessary.
     * If you rather want to rewrite special blocks as well,
     * use the EnableRawAccess field from the options parameter
     * (definitely not recommanded).
     *
     * @param string $tagId : identifier of the tag to use
     * @param int $firstBlock : block number where write should start
     * @param string $text : the text string to write
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function tagWriteStr(string $tagId, int $firstBlock, string $text, YRfidOptions $options, YRfidStatus &$status): int
    {
        // $buff                   is a bin;
        $buff = YAPI::Ystr2bin($text);

        return $this->tagWriteBin($tagId, $firstBlock, $buff, $options, $status);
    }

    /**
     * Reads an RFID tag AFI byte (ISO 15693 only).
     *
     * @param string $tagId : identifier of the tag to use
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return int  the AFI value (0...255)
     *
     * On failure, throws an exception or returns a negative error code. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function tagGetAFI(string $tagId, YRfidOptions $options, YRfidStatus &$status): int
    {
        // $optstr                 is a str;
        // $url                    is a str;
        // $json                   is a bin;
        // $res                    is a int;
        $optstr = $options->imm_getParams();
        $url = sprintf('rfid.json?a=rdsf&t=%s&b=0%s',$tagId,$optstr);

        $json = $this->_download($url);
        $this->_chkerror($tagId, $json, $status);
        if ($status->get_yapiError() == YAPI::SUCCESS) {
            $res = intVal($this->_json_get_key($json, 'res'));
        } else {
            $res = $status->get_yapiError();
        }
        return $res;
    }

    /**
     * Changes an RFID tag AFI byte (ISO 15693 only).
     *
     * @param string $tagId : identifier of the tag to use
     * @param int $afi : the AFI value to write (0...255)
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function tagSetAFI(string $tagId, int $afi, YRfidOptions $options, YRfidStatus &$status): int
    {
        // $optstr                 is a str;
        // $url                    is a str;
        // $json                   is a bin;
        $optstr = $options->imm_getParams();
        $url = sprintf('rfid.json?a=wrsf&t=%s&b=0&v=%d%s',$tagId,$afi,$optstr);

        $json = $this->_download($url);
        return $this->_chkerror($tagId, $json, $status);
    }

    /**
     * Locks the RFID tag AFI byte (ISO 15693 only).
     * This operation is definitive and irreversible.
     *
     * @param string $tagId : identifier of the tag to use
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function tagLockAFI(string $tagId, YRfidOptions $options, YRfidStatus &$status): int
    {
        // $optstr                 is a str;
        // $url                    is a str;
        // $json                   is a bin;
        $optstr = $options->imm_getParams();
        $url = sprintf('rfid.json?a=lksf&t=%s&b=0%s',$tagId,$optstr);

        $json = $this->_download($url);
        return $this->_chkerror($tagId, $json, $status);
    }

    /**
     * Reads an RFID tag DSFID byte (ISO 15693 only).
     *
     * @param string $tagId : identifier of the tag to use
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return int  the DSFID value (0...255)
     *
     * On failure, throws an exception or returns a negative error code. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function tagGetDSFID(string $tagId, YRfidOptions $options, YRfidStatus &$status): int
    {
        // $optstr                 is a str;
        // $url                    is a str;
        // $json                   is a bin;
        // $res                    is a int;
        $optstr = $options->imm_getParams();
        $url = sprintf('rfid.json?a=rdsf&t=%s&b=1%s',$tagId,$optstr);

        $json = $this->_download($url);
        $this->_chkerror($tagId, $json, $status);
        if ($status->get_yapiError() == YAPI::SUCCESS) {
            $res = intVal($this->_json_get_key($json, 'res'));
        } else {
            $res = $status->get_yapiError();
        }
        return $res;
    }

    /**
     * Changes an RFID tag DSFID byte (ISO 15693 only).
     *
     * @param string $tagId : identifier of the tag to use
     * @param int $dsfid : the DSFID value to write (0...255)
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function tagSetDSFID(string $tagId, int $dsfid, YRfidOptions $options, YRfidStatus &$status): int
    {
        // $optstr                 is a str;
        // $url                    is a str;
        // $json                   is a bin;
        $optstr = $options->imm_getParams();
        $url = sprintf('rfid.json?a=wrsf&t=%s&b=1&v=%d%s',$tagId,$dsfid,$optstr);

        $json = $this->_download($url);
        return $this->_chkerror($tagId, $json, $status);
    }

    /**
     * Locks the RFID tag DSFID byte (ISO 15693 only).
     * This operation is definitive and irreversible.
     *
     * @param string $tagId : identifier of the tag to use
     * @param YRfidOptions $options : an YRfidOptions object with the optional
     *         command execution parameters, such as security key
     *         if required
     * @param YRfidStatus $status : an RfidStatus object that will contain
     *         the detailled status of the operation
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code. When it
     * happens, you can get more information from the status object.
     * @throws YAPI_Exception on error
     */
    public function tagLockDSFID(string $tagId, YRfidOptions $options, YRfidStatus &$status): int
    {
        // $optstr                 is a str;
        // $url                    is a str;
        // $json                   is a bin;
        $optstr = $options->imm_getParams();
        $url = sprintf('rfid.json?a=lksf&t=%s&b=1%s',$tagId,$optstr);

        $json = $this->_download($url);
        return $this->_chkerror($tagId, $json, $status);
    }

    /**
     * Returns a string with last tag arrival/removal events observed.
     * This method return only events that are still buffered in the device memory.
     *
     * @return string  a string with last events observed (one per line).
     *
     * On failure, throws an exception or returns  YAPI::INVALID_STRING.
     * @throws YAPI_Exception on error
     */
    public function get_lastEvents(): string
    {
        // $content                is a bin;

        $content = $this->_download('events.txt?pos=0');
        return YAPI::Ybin2str($content);
    }

    /**
     * Registers a callback function to be called each time that an RFID tag appears or
     * disappears. The callback is invoked only during the execution of
     * ySleep or yHandleEvents. This provides control over the time when
     * the callback is triggered. For good responsiveness, remember to call one of these
     * two functions periodically. To unregister a callback, pass a null pointer as argument.
     *
     * @param callable $callback : the callback function to call, or a null pointer.
     *         The callback function should take four arguments:
     *         the YRfidReader object that emitted the event, the
     *         UTC timestamp of the event, a character string describing
     *         the type of event ("+" or "-") and a character string with the
     *         RFID tag identifier.
     *         On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function registerEventCallback(mixed $callback): int
    {
        $this->_eventCallback = $callback;
        $this->_isFirstCb = true;
        if (!is_null($callback)) {
            $this->registerValueCallback('yInternalEventCallback');
        } else {
            $this->registerValueCallback(null);
        }
        return 0;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _internalEventHandler(string $cbVal): int
    {
        // $cbPos                  is a int;
        // $cbDPos                 is a int;
        // $url                    is a str;
        // $content                is a bin;
        // $contentStr             is a str;
        $eventArr = [];         // strArr;
        // $arrLen                 is a int;
        // $lenStr                 is a str;
        // $arrPos                 is a int;
        // $eventStr               is a str;
        // $eventLen               is a int;
        // $hexStamp               is a str;
        // $typePos                is a int;
        // $dataPos                is a int;
        // $intStamp               is a int;
        // $binMStamp              is a bin;
        // $msStamp                is a int;
        // $evtStamp               is a float;
        // $evtType                is a str;
        // $evtData                is a str;
        // detect possible power cycle of the reader to clear event pointer
        $cbPos = intVal($cbVal);
        $cbPos = intVal(($cbPos) / (1000));
        $cbDPos = (($cbPos - $this->_prevCbPos) & 0x7ffff);
        $this->_prevCbPos = $cbPos;
        if ($cbDPos > 16384) {
            $this->_eventPos = 0;
        }
        if (!(!is_null($this->_eventCallback))) {
            return YAPI::SUCCESS;
        }
        if ($this->_isFirstCb) {
            // first emulated value callback caused by registerValueCallback:
            // retrieve arrivals of all tags currently present to emulate arrival
            $this->_isFirstCb = false;
            $this->_eventStamp = 0;
            $content = $this->_download('events.txt');
            $contentStr = YAPI::Ybin2str($content);
            $eventArr = explode(''."\n".'', $contentStr);
            $arrLen = sizeof($eventArr);
            if (!($arrLen > 0)) return $this->_throw(YAPI::IO_ERROR,'fail to download events',YAPI::IO_ERROR);
            // first element of array is the new position preceeded by '@'
            $arrPos = 1;
            $lenStr = $eventArr[0];
            $lenStr = substr($lenStr, 1, mb_strlen($lenStr)-1);
            // update processed event position pointer
            $this->_eventPos = intVal($lenStr);
        } else {
            // load all events since previous call
            $url = sprintf('events.txt?pos=%d', $this->_eventPos);
            $content = $this->_download($url);
            $contentStr = YAPI::Ybin2str($content);
            $eventArr = explode(''."\n".'', $contentStr);
            $arrLen = sizeof($eventArr);
            if (!($arrLen > 0)) return $this->_throw(YAPI::IO_ERROR,'fail to download events',YAPI::IO_ERROR);
            // last element of array is the new position preceeded by '@'
            $arrPos = 0;
            $arrLen = $arrLen - 1;
            $lenStr = $eventArr[$arrLen];
            $lenStr = substr($lenStr, 1, mb_strlen($lenStr)-1);
            // update processed event position pointer
            $this->_eventPos = intVal($lenStr);
        }
        // now generate callbacks for each real event
        while ($arrPos < $arrLen) {
            $eventStr = $eventArr[$arrPos];
            $eventLen = mb_strlen($eventStr);
            $typePos = YAPI::Ystrpos($eventStr,':')+1;
            if (($eventLen >= 14) && ($typePos > 10)) {
                $hexStamp = substr($eventStr, 0, 8);
                $intStamp = hexdec($hexStamp);
                if ($intStamp >= $this->_eventStamp) {
                    $this->_eventStamp = $intStamp;
                    $binMStamp = YAPI::Ystr2bin(substr($eventStr, 8, 2));
                    $msStamp = (ord($binMStamp[0])-64) * 32 + ord($binMStamp[1]);
                    $evtStamp = $intStamp + (0.001 * $msStamp);
                    $dataPos = YAPI::Ystrpos($eventStr,'=')+1;
                    $evtType = substr($eventStr, $typePos, 1);
                    $evtData = '';
                    if ($dataPos > 10) {
                        $evtData = substr($eventStr, $dataPos, $eventLen-$dataPos);
                    }
                    if (!is_null($this->_eventCallback)) {
                        call_user_func($this->_eventCallback, $this, $evtStamp, $evtType, $evtData);
                    }
                }
            }
            $arrPos = $arrPos + 1;
        }
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception
     */
    public function nTags(): int
{
    return $this->get_nTags();
}

    /**
     * @throws YAPI_Exception
     */
    public function refreshRate(): int
{
    return $this->get_refreshRate();
}

    /**
     * @throws YAPI_Exception
     */
    public function setRefreshRate(int $newval): int
{
    return $this->set_refreshRate($newval);
}

    /**
     * Continues the enumeration of RFID readers started using yFirstRfidReader().
     * Caution: You can't make any assumption about the returned RFID readers order.
     * If you want to find a specific a RFID reader, use RfidReader.findRfidReader()
     * and a hardwareID or a logical name.
     *
     * @return ?YRfidReader  a pointer to a YRfidReader object, corresponding to
     *         a RFID reader currently online, or a null pointer
     *         if there are no more RFID readers to enumerate.
     */
    public function nextRfidReader(): ?YRfidReader
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindRfidReader($next_hwid);
    }

    /**
     * Starts the enumeration of RFID readers currently accessible.
     * Use the method YRfidReader::nextRfidReader() to iterate on
     * next RFID readers.
     *
     * @return ?YRfidReader  a pointer to a YRfidReader object, corresponding to
     *         the first RFID reader currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstRfidReader(): ?YRfidReader
    {
        $next_hwid = YAPI::getFirstHardwareId('RfidReader');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindRfidReader($next_hwid);
    }

    //--- (end of generated code: YRfidReader implementation)

}
