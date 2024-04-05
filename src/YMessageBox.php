<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YMessageBox Class: SMS message box interface control interface, available for instance in the
 * YoctoHub-GSM-2G, the YoctoHub-GSM-3G-EU, the YoctoHub-GSM-3G-NA or the YoctoHub-GSM-4G
 *
 * The YMessageBox class provides SMS sending and receiving capability for
 * GSM-enabled Yoctopuce devices.
 */
class YMessageBox extends YFunction
{
    const SLOTSINUSE_INVALID = YAPI::INVALID_UINT;
    const SLOTSCOUNT_INVALID = YAPI::INVALID_UINT;
    const SLOTSBITMAP_INVALID = YAPI::INVALID_STRING;
    const PDUSENT_INVALID = YAPI::INVALID_UINT;
    const PDURECEIVED_INVALID = YAPI::INVALID_UINT;
    const OBEY_INVALID = YAPI::INVALID_STRING;
    const COMMAND_INVALID = YAPI::INVALID_STRING;
    //--- (end of generated code: YMessageBox declaration)

    //--- (generated code: YMessageBox attributes)
    protected int $_slotsInUse = self::SLOTSINUSE_INVALID;     // UInt31
    protected int $_slotsCount = self::SLOTSCOUNT_INVALID;     // UInt31
    protected string $_slotsBitmap = self::SLOTSBITMAP_INVALID;    // BinaryBuffer
    protected int $_pduSent = self::PDUSENT_INVALID;        // UInt31
    protected int $_pduReceived = self::PDURECEIVED_INVALID;    // UInt31
    protected string $_obey = self::OBEY_INVALID;           // Text
    protected string $_command = self::COMMAND_INVALID;        // Text
    protected int $_nextMsgRef = 0;                            // int
    protected string $_prevBitmapStr = '';                           // str
    protected array $_pdus = [];                           // YSmsArr
    protected array $_messages = [];                           // YSmsArr
    protected bool $_gsm2unicodeReady = false;                        // bool
    protected array $_gsm2unicode = [];                           // intArr
    protected string $_iso2gsm = "";                           // bin

    //--- (end of generated code: YMessageBox attributes)

    function __construct(string $str_func)
    {
        //--- (generated code: YMessageBox constructor)
        parent::__construct($str_func);
        $this->_className = 'MessageBox';

        //--- (end of generated code: YMessageBox constructor)
    }

    //--- (generated code: YMessageBox implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'slotsInUse':
            $this->_slotsInUse = intval($val);
            return 1;
        case 'slotsCount':
            $this->_slotsCount = intval($val);
            return 1;
        case 'slotsBitmap':
            $this->_slotsBitmap = $val;
            return 1;
        case 'pduSent':
            $this->_pduSent = intval($val);
            return 1;
        case 'pduReceived':
            $this->_pduReceived = intval($val);
            return 1;
        case 'obey':
            $this->_obey = $val;
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns the number of message storage slots currently in use.
     *
     * @return int  an integer corresponding to the number of message storage slots currently in use
     *
     * On failure, throws an exception or returns YMessageBox::SLOTSINUSE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_slotsInUse(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SLOTSINUSE_INVALID;
            }
        }
        $res = $this->_slotsInUse;
        return $res;
    }

    /**
     * Returns the total number of message storage slots on the SIM card.
     *
     * @return int  an integer corresponding to the total number of message storage slots on the SIM card
     *
     * On failure, throws an exception or returns YMessageBox::SLOTSCOUNT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_slotsCount(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SLOTSCOUNT_INVALID;
            }
        }
        $res = $this->_slotsCount;
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_slotsBitmap(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SLOTSBITMAP_INVALID;
            }
        }
        $res = $this->_slotsBitmap;
        return $res;
    }

    /**
     * Returns the number of SMS units sent so far.
     *
     * @return int  an integer corresponding to the number of SMS units sent so far
     *
     * On failure, throws an exception or returns YMessageBox::PDUSENT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_pduSent(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PDUSENT_INVALID;
            }
        }
        $res = $this->_pduSent;
        return $res;
    }

    /**
     * Changes the value of the outgoing SMS units counter.
     *
     * @param int $newval : an integer corresponding to the value of the outgoing SMS units counter
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_pduSent(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("pduSent", $rest_val);
    }

    /**
     * Returns the number of SMS units received so far.
     *
     * @return int  an integer corresponding to the number of SMS units received so far
     *
     * On failure, throws an exception or returns YMessageBox::PDURECEIVED_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_pduReceived(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::PDURECEIVED_INVALID;
            }
        }
        $res = $this->_pduReceived;
        return $res;
    }

    /**
     * Changes the value of the incoming SMS units counter.
     *
     * @param int $newval : an integer corresponding to the value of the incoming SMS units counter
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_pduReceived(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("pduReceived", $rest_val);
    }

    /**
     * Returns the phone number authorized to send remote management commands.
     * When a phone number is specified, the hub will take contre of all incoming
     * SMS messages: it will execute commands coming from the authorized number,
     * and delete all messages once received (whether authorized or not).
     * If you need to receive SMS messages using your own software, leave this
     * attribute empty.
     *
     * @return string  a string corresponding to the phone number authorized to send remote management commands
     *
     * On failure, throws an exception or returns YMessageBox::OBEY_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_obey(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::OBEY_INVALID;
            }
        }
        $res = $this->_obey;
        return $res;
    }

    /**
     * Changes the phone number authorized to send remote management commands.
     * The phone number usually starts with a '+' and does not include spacers.
     * When a phone number is specified, the hub will take contre of all incoming
     * SMS messages: it will execute commands coming from the authorized number,
     * and delete all messages once received (whether authorized or not).
     * If you need to receive SMS messages using your own software, leave this
     * attribute empty. Remember to call the saveToFlash() method of the
     * module if the modification must be kept.
     *
     * This feature is only available since YoctoHub-GSM-4G.
     *
     * @param string $newval : a string corresponding to the phone number authorized to send remote management commands
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_obey(string $newval): int
    {
        $rest_val = $newval;
        return $this->_setAttr("obey", $rest_val);
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
     * Retrieves a SMS message box interface for a given identifier.
     * The identifier can be specified using several formats:
     *
     * - FunctionLogicalName
     * - ModuleSerialNumber.FunctionIdentifier
     * - ModuleSerialNumber.FunctionLogicalName
     * - ModuleLogicalName.FunctionIdentifier
     * - ModuleLogicalName.FunctionLogicalName
     *
     *
     * This function does not require that the SMS message box interface is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the SMS message box interface is
     * indeed online at a given time. In case of ambiguity when looking for
     * a SMS message box interface by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the SMS message box interface, for instance
     *         YHUBGSM1.messageBox.
     *
     * @return YMessageBox  a YMessageBox object allowing you to drive the SMS message box interface.
     */
    public static function FindMessageBox(string $func): YMessageBox
    {
        // $obj                    is a YMessageBox;
        $obj = YFunction::_FindFromCache('MessageBox', $func);
        if ($obj == null) {
            $obj = new YMessageBox($func);
            YFunction::_AddToCache('MessageBox', $func, $obj);
        }
        return $obj;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function nextMsgRef(): int
    {
        $this->_nextMsgRef = $this->_nextMsgRef + 1;
        return $this->_nextMsgRef;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function clearSIMSlot(int $slot): int
    {
        // $retry                  is a int;
        // $idx                    is a int;
        // $res                    is a str;
        // $bitmapStr              is a str;
        // $int_res                is a int;
        // $newBitmap              is a bin;
        // $bitVal                 is a int;

        $retry = 5;
        while ($retry > 0) {
            $this->clearCache();
            $bitmapStr = $this->get_slotsBitmap();
            $newBitmap = YAPI::_hexStrToBin($bitmapStr);
            $idx = (($slot) >> (3));
            if ($idx < strlen($newBitmap)) {
                $bitVal = ((1) << (((($slot) & (7)))));
                if ((((ord($newBitmap[$idx])) & ($bitVal))) != 0) {
                    $this->_prevBitmapStr = '';
                    $int_res = $this->set_command(sprintf('DS%d',$slot));
                    if ($int_res < 0) {
                        return $int_res;
                    }
                } else {
                    return YAPI::SUCCESS;
                }
            } else {
                return YAPI::INVALID_ARGUMENT;
            }
            $res = $this->_AT('');
            $retry = $retry - 1;
        }
        return YAPI::IO_ERROR;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function _AT(string $cmd): string
    {
        // $chrPos                 is a int;
        // $cmdLen                 is a int;
        // $waitMore               is a int;
        // $res                    is a str;
        // $buff                   is a bin;
        // $bufflen                is a int;
        // $buffstr                is a str;
        // $buffstrlen             is a int;
        // $idx                    is a int;
        // $suffixlen              is a int;
        // copied form the YCellular class
        // quote dangerous characters used in AT commands
        $cmdLen = strlen($cmd);
        $chrPos = YAPI::Ystrpos($cmd,'#');
        while ($chrPos >= 0) {
            $cmd = sprintf('%s%c23%s', substr($cmd,  0, $chrPos), 37,
            substr($cmd,  $chrPos+1, $cmdLen-$chrPos-1));
            $cmdLen = $cmdLen + 2;
            $chrPos = YAPI::Ystrpos($cmd,'#');
        }
        $chrPos = YAPI::Ystrpos($cmd,'+');
        while ($chrPos >= 0) {
            $cmd = sprintf('%s%c2B%s', substr($cmd,  0, $chrPos), 37,
            substr($cmd,  $chrPos+1, $cmdLen-$chrPos-1));
            $cmdLen = $cmdLen + 2;
            $chrPos = YAPI::Ystrpos($cmd,'+');
        }
        $chrPos = YAPI::Ystrpos($cmd,'=');
        while ($chrPos >= 0) {
            $cmd = sprintf('%s%c3D%s', substr($cmd,  0, $chrPos), 37,
            substr($cmd,  $chrPos+1, $cmdLen-$chrPos-1));
            $cmdLen = $cmdLen + 2;
            $chrPos = YAPI::Ystrpos($cmd,'=');
        }
        $cmd = sprintf('at.txt?cmd=%s',$cmd);
        $res = sprintf('');
        // max 2 minutes (each iteration may take up to 5 seconds if waiting)
        $waitMore = 24;
        while ($waitMore > 0) {
            $buff = $this->_download($cmd);
            $bufflen = strlen($buff);
            $buffstr = $buff;
            $buffstrlen = strlen($buffstr);
            $idx = $bufflen - 1;
            while (($idx > 0) && (ord($buff[$idx]) != 64) && (ord($buff[$idx]) != 10) && (ord($buff[$idx]) != 13)) {
                $idx = $idx - 1;
            }
            if (ord($buff[$idx]) == 64) {
                // continuation detected
                $suffixlen = $bufflen - $idx;
                $cmd = sprintf('at.txt?cmd=%s', substr($buffstr,  $buffstrlen - $suffixlen, $suffixlen));
                $buffstr = substr($buffstr,  0, $buffstrlen - $suffixlen);
                $waitMore = $waitMore - 1;
            } else {
                // request complete
                $waitMore = 0;
            }
            $res = sprintf('%s%s', $res, $buffstr);
        }
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function fetchPdu(int $slot): ?YSms
    {
        // $binPdu                 is a bin;
        $arrPdu = [];           // strArr;
        // $hexPdu                 is a str;
        // $sms                    is a YSms;

        $binPdu = $this->_download(sprintf('sms.json?pos=%d&len=1', $slot));
        $arrPdu = $this->_json_get_array($binPdu);
        $hexPdu = $this->_decode_json_string($arrPdu[0]);
        $sms = new YSms($this);
        $sms->set_slot($slot);
        $sms->parsePdu(YAPI::_hexStrToBin($hexPdu));
        return $sms;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function initGsm2Unicode(): int
    {
        // $i                      is a int;
        // $uni                    is a int;
        while (sizeof($this->_gsm2unicode) > 0) {
            array_pop($this->_gsm2unicode);
        };
        // 00-07
        $this->_gsm2unicode[] = 64;
        $this->_gsm2unicode[] = 163;
        $this->_gsm2unicode[] = 36;
        $this->_gsm2unicode[] = 165;
        $this->_gsm2unicode[] = 232;
        $this->_gsm2unicode[] = 233;
        $this->_gsm2unicode[] = 249;
        $this->_gsm2unicode[] = 236;
        // 08-0F
        $this->_gsm2unicode[] = 242;
        $this->_gsm2unicode[] = 199;
        $this->_gsm2unicode[] = 10;
        $this->_gsm2unicode[] = 216;
        $this->_gsm2unicode[] = 248;
        $this->_gsm2unicode[] = 13;
        $this->_gsm2unicode[] = 197;
        $this->_gsm2unicode[] = 229;
        // 10-17
        $this->_gsm2unicode[] = 916;
        $this->_gsm2unicode[] = 95;
        $this->_gsm2unicode[] = 934;
        $this->_gsm2unicode[] = 915;
        $this->_gsm2unicode[] = 923;
        $this->_gsm2unicode[] = 937;
        $this->_gsm2unicode[] = 928;
        $this->_gsm2unicode[] = 936;
        // 18-1F
        $this->_gsm2unicode[] = 931;
        $this->_gsm2unicode[] = 920;
        $this->_gsm2unicode[] = 926;
        $this->_gsm2unicode[] = 27;
        $this->_gsm2unicode[] = 198;
        $this->_gsm2unicode[] = 230;
        $this->_gsm2unicode[] = 223;
        $this->_gsm2unicode[] = 201;
        // 20-7A
        $i = 32;
        while ($i <= 122) {
            $this->_gsm2unicode[] = $i;
            $i = $i + 1;
        }
        // exceptions in range 20-7A
        $this->_gsm2unicode[36] = 164;
        $this->_gsm2unicode[64] = 161;
        $this->_gsm2unicode[91] = 196;
        $this->_gsm2unicode[92] = 214;
        $this->_gsm2unicode[93] = 209;
        $this->_gsm2unicode[94] = 220;
        $this->_gsm2unicode[95] = 167;
        $this->_gsm2unicode[96] = 191;
        // 7B-7F
        $this->_gsm2unicode[] = 228;
        $this->_gsm2unicode[] = 246;
        $this->_gsm2unicode[] = 241;
        $this->_gsm2unicode[] = 252;
        $this->_gsm2unicode[] = 224;
        // Invert table as well wherever possible
        $this->_iso2gsm = (256 > 0 ? pack('C',array_fill(0, 256, 0)) : '');
        $i = 0;
        while ($i <= 127) {
            $uni = $this->_gsm2unicode[$i];
            if ($uni <= 255) {
                $this->_iso2gsm[$uni] = pack('C', $i);
            }
            $i = $i + 1;
        }
        $i = 0;
        while ($i < 4) {
            // mark escape sequences
            $this->_iso2gsm[91+$i] = pack('C', 27);
            $this->_iso2gsm[123+$i] = pack('C', 27);
            $i = $i + 1;
        }
        // Done
        $this->_gsm2unicodeReady = true;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function gsm2unicode(string $gsm): array
    {
        // $i                      is a int;
        // $gsmlen                 is a int;
        // $reslen                 is a int;
        $res = [];              // intArr;
        // $uni                    is a int;
        if (!($this->_gsm2unicodeReady)) {
            $this->initGsm2Unicode();
        }
        $gsmlen = strlen($gsm);
        $reslen = $gsmlen;
        $i = 0;
        while ($i < $gsmlen) {
            if (ord($gsm[$i]) == 27) {
                $reslen = $reslen - 1;
            }
            $i = $i + 1;
        }
        while (sizeof($res) > 0) {
            array_pop($res);
        };
        $i = 0;
        while ($i < $gsmlen) {
            $uni = $this->_gsm2unicode[ord($gsm[$i])];
            if (($uni == 27) && ($i+1 < $gsmlen)) {
                $i = $i + 1;
                $uni = ord($gsm[$i]);
                if ($uni < 60) {
                    if ($uni < 41) {
                        if ($uni==20) {
                            $uni=94;
                        } else {
                            if ($uni==40) {
                                $uni=123;
                            } else {
                                $uni=0;
                            }
                        }
                    } else {
                        if ($uni==41) {
                            $uni=125;
                        } else {
                            if ($uni==47) {
                                $uni=92;
                            } else {
                                $uni=0;
                            }
                        }
                    }
                } else {
                    if ($uni < 62) {
                        if ($uni==60) {
                            $uni=91;
                        } else {
                            if ($uni==61) {
                                $uni=126;
                            } else {
                                $uni=0;
                            }
                        }
                    } else {
                        if ($uni==62) {
                            $uni=93;
                        } else {
                            if ($uni==64) {
                                $uni=124;
                            } else {
                                if ($uni==101) {
                                    $uni=164;
                                } else {
                                    $uni=0;
                                }
                            }
                        }
                    }
                }
            }
            if ($uni > 0) {
                $res[] = $uni;
            }
            $i = $i + 1;
        }
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function gsm2str(string $gsm): string
    {
        // $i                      is a int;
        // $gsmlen                 is a int;
        // $reslen                 is a int;
        // $resbin                 is a bin;
        // $resstr                 is a str;
        // $uni                    is a int;
        if (!($this->_gsm2unicodeReady)) {
            $this->initGsm2Unicode();
        }
        $gsmlen = strlen($gsm);
        $reslen = $gsmlen;
        $i = 0;
        while ($i < $gsmlen) {
            if (ord($gsm[$i]) == 27) {
                $reslen = $reslen - 1;
            }
            $i = $i + 1;
        }
        $resbin = ($reslen > 0 ? pack('C',array_fill(0, $reslen, 0)) : '');
        $i = 0;
        $reslen = 0;
        while ($i < $gsmlen) {
            $uni = $this->_gsm2unicode[ord($gsm[$i])];
            if (($uni == 27) && ($i+1 < $gsmlen)) {
                $i = $i + 1;
                $uni = ord($gsm[$i]);
                if ($uni < 60) {
                    if ($uni < 41) {
                        if ($uni==20) {
                            $uni=94;
                        } else {
                            if ($uni==40) {
                                $uni=123;
                            } else {
                                $uni=0;
                            }
                        }
                    } else {
                        if ($uni==41) {
                            $uni=125;
                        } else {
                            if ($uni==47) {
                                $uni=92;
                            } else {
                                $uni=0;
                            }
                        }
                    }
                } else {
                    if ($uni < 62) {
                        if ($uni==60) {
                            $uni=91;
                        } else {
                            if ($uni==61) {
                                $uni=126;
                            } else {
                                $uni=0;
                            }
                        }
                    } else {
                        if ($uni==62) {
                            $uni=93;
                        } else {
                            if ($uni==64) {
                                $uni=124;
                            } else {
                                if ($uni==101) {
                                    $uni=164;
                                } else {
                                    $uni=0;
                                }
                            }
                        }
                    }
                }
            }
            if (($uni > 0) && ($uni < 256)) {
                $resbin[$reslen] = pack('C', $uni);
                $reslen = $reslen + 1;
            }
            $i = $i + 1;
        }
        $resstr = $resbin;
        if (strlen($resstr) > $reslen) {
            $resstr = substr($resstr, 0, $reslen);
        }
        return $resstr;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function str2gsm(string $msg): string
    {
        // $asc                    is a bin;
        // $asclen                 is a int;
        // $i                      is a int;
        // $ch                     is a int;
        // $gsm7                   is a int;
        // $extra                  is a int;
        // $res                    is a bin;
        // $wpos                   is a int;
        if (!($this->_gsm2unicodeReady)) {
            $this->initGsm2Unicode();
        }
        $asc = $msg;
        $asclen = strlen($asc);
        $extra = 0;
        $i = 0;
        while ($i < $asclen) {
            $ch = ord($asc[$i]);
            $gsm7 = ord($this->_iso2gsm[$ch]);
            if ($gsm7 == 27) {
                $extra = $extra + 1;
            }
            if ($gsm7 == 0) {
                // cannot use standard GSM encoding
                $res = '';
                return $res;
            }
            $i = $i + 1;
        }
        $res = ($asclen+$extra > 0 ? pack('C',array_fill(0, $asclen+$extra, 0)) : '');
        $wpos = 0;
        $i = 0;
        while ($i < $asclen) {
            $ch = ord($asc[$i]);
            $gsm7 = ord($this->_iso2gsm[$ch]);
            $res[$wpos] = pack('C', $gsm7);
            $wpos = $wpos + 1;
            if ($gsm7 == 27) {
                if ($ch < 100) {
                    if ($ch<93) {
                        if ($ch<92) {
                            $gsm7=60;
                        } else {
                            $gsm7=47;
                        }
                    } else {
                        if ($ch<94) {
                            $gsm7=62;
                        } else {
                            $gsm7=20;
                        }
                    }
                } else {
                    if ($ch<125) {
                        if ($ch<124) {
                            $gsm7=40;
                        } else {
                            $gsm7=64;
                        }
                    } else {
                        if ($ch<126) {
                            $gsm7=41;
                        } else {
                            $gsm7=61;
                        }
                    }
                }
                $res[$wpos] = pack('C', $gsm7);
                $wpos = $wpos + 1;
            }
            $i = $i + 1;
        }
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function checkNewMessages(): int
    {
        // $bitmapStr              is a str;
        // $prevBitmap             is a bin;
        // $newBitmap              is a bin;
        // $slot                   is a int;
        // $nslots                 is a int;
        // $pduIdx                 is a int;
        // $idx                    is a int;
        // $bitVal                 is a int;
        // $prevBit                is a int;
        // $i                      is a int;
        // $nsig                   is a int;
        // $cnt                    is a int;
        // $sig                    is a str;
        $newArr = [];           // YSmsArr;
        $newMsg = [];           // YSmsArr;
        $newAgg = [];           // YSmsArr;
        $signatures = [];       // strArr;
        // $sms                    is a YSms;

        $bitmapStr = $this->get_slotsBitmap();
        if ($bitmapStr == $this->_prevBitmapStr) {
            return YAPI::SUCCESS;
        }
        $prevBitmap = YAPI::_hexStrToBin($this->_prevBitmapStr);
        $newBitmap = YAPI::_hexStrToBin($bitmapStr);
        $this->_prevBitmapStr = $bitmapStr;
        $nslots = 8*strlen($newBitmap);
        while (sizeof($newArr) > 0) {
            array_pop($newArr);
        };
        while (sizeof($newMsg) > 0) {
            array_pop($newMsg);
        };
        while (sizeof($signatures) > 0) {
            array_pop($signatures);
        };
        $nsig = 0;
        // copy known messages
        $pduIdx = 0;
        while ($pduIdx < sizeof($this->_pdus)) {
            $sms = $this->_pdus[$pduIdx];
            $slot = $sms->get_slot();
            $idx = (($slot) >> (3));
            if ($idx < strlen($newBitmap)) {
                $bitVal = ((1) << (((($slot) & (7)))));
                if ((((ord($newBitmap[$idx])) & ($bitVal))) != 0) {
                    $newArr[] = $sms;
                    if ($sms->get_concatCount() == 0) {
                        $newMsg[] = $sms;
                    } else {
                        $sig = $sms->get_concatSignature();
                        $i = 0;
                        while (($i < $nsig) && (strlen($sig) > 0)) {
                            if ($signatures[$i] == $sig) {
                                $sig = '';
                            }
                            $i = $i + 1;
                        }
                        if (strlen($sig) > 0) {
                            $signatures[] = $sig;
                            $nsig = $nsig + 1;
                        }
                    }
                }
            }
            $pduIdx = $pduIdx + 1;
        }
        // receive new messages
        $slot = 0;
        while ($slot < $nslots) {
            $idx = (($slot) >> (3));
            $bitVal = ((1) << (((($slot) & (7)))));
            $prevBit = 0;
            if ($idx < strlen($prevBitmap)) {
                $prevBit = ((ord($prevBitmap[$idx])) & ($bitVal));
            }
            if ((((ord($newBitmap[$idx])) & ($bitVal))) != 0) {
                if ($prevBit == 0) {
                    $sms = $this->fetchPdu($slot);
                    $newArr[] = $sms;
                    if ($sms->get_concatCount() == 0) {
                        $newMsg[] = $sms;
                    } else {
                        $sig = $sms->get_concatSignature();
                        $i = 0;
                        while (($i < $nsig) && (strlen($sig) > 0)) {
                            if ($signatures[$i] == $sig) {
                                $sig = '';
                            }
                            $i = $i + 1;
                        }
                        if (strlen($sig) > 0) {
                            $signatures[] = $sig;
                            $nsig = $nsig + 1;
                        }
                    }
                }
            }
            $slot = $slot + 1;
        }
        $this->_pdus = $newArr;
        // append complete concatenated messages
        $i = 0;
        while ($i < $nsig) {
            $sig = $signatures[$i];
            $cnt = 0;
            $pduIdx = 0;
            while ($pduIdx < sizeof($this->_pdus)) {
                $sms = $this->_pdus[$pduIdx];
                if ($sms->get_concatCount() > 0) {
                    if ($sms->get_concatSignature() == $sig) {
                        if ($cnt == 0) {
                            $cnt = $sms->get_concatCount();
                            while (sizeof($newAgg) > 0) {
                                array_pop($newAgg);
                            };
                        }
                        $newAgg[] = $sms;
                    }
                }
                $pduIdx = $pduIdx + 1;
            }
            if (($cnt > 0) && (sizeof($newAgg) == $cnt)) {
                $sms = new YSms($this);
                $sms->set_parts($newAgg);
                $newMsg[] = $sms;
            }
            $i = $i + 1;
        }
        $this->_messages = $newMsg;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_pdus(): array
    {
        $this->checkNewMessages();
        return $this->_pdus;
    }

    /**
     * Clear the SMS units counters.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function clearPduCounters(): int
    {
        // $retcode                is a int;

        $retcode = $this->set_pduReceived(0);
        if ($retcode != YAPI::SUCCESS) {
            return $retcode;
        }
        $retcode = $this->set_pduSent(0);
        return $retcode;
    }

    /**
     * Sends a regular text SMS, with standard parameters. This function can send messages
     * of more than 160 characters, using SMS concatenation. ISO-latin accented characters
     * are supported. For sending messages with special unicode characters such as asian
     * characters and emoticons, use newMessage to create a new message and define
     * the content of using methods addText and addUnicodeData.
     *
     * @param string $recipient : a text string with the recipient phone number, either as a
     *         national number, or in international format starting with a plus sign
     * @param string $message : the text to be sent in the message
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function sendTextMessage(string $recipient, string $message): int
    {
        // $sms                    is a YSms;

        $sms = new YSms($this);
        $sms->set_recipient($recipient);
        $sms->addText($message);
        return $sms->send();
    }

    /**
     * Sends a Flash SMS (class 0 message). Flash messages are displayed on the handset
     * immediately and are usually not saved on the SIM card. This function can send messages
     * of more than 160 characters, using SMS concatenation. ISO-latin accented characters
     * are supported. For sending messages with special unicode characters such as asian
     * characters and emoticons, use newMessage to create a new message and define
     * the content of using methods addText et addUnicodeData.
     *
     * @param string $recipient : a text string with the recipient phone number, either as a
     *         national number, or in international format starting with a plus sign
     * @param string $message : the text to be sent in the message
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function sendFlashMessage(string $recipient, string $message): int
    {
        // $sms                    is a YSms;

        $sms = new YSms($this);
        $sms->set_recipient($recipient);
        $sms->set_msgClass(0);
        $sms->addText($message);
        return $sms->send();
    }

    /**
     * Creates a new empty SMS message, to be configured and sent later on.
     *
     * @param string $recipient : a text string with the recipient phone number, either as a
     *         national number, or in international format starting with a plus sign
     *
     * @return ?YSms  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function newMessage(string $recipient): ?YSms
    {
        // $sms                    is a YSms;
        $sms = new YSms($this);
        $sms->set_recipient($recipient);
        return $sms;
    }

    /**
     * Returns the list of messages received and not deleted. This function
     * will automatically decode concatenated SMS.
     *
     * @return YSms[]  an YSms object list.
     *
     * On failure, throws an exception or returns an empty list.
     * @throws YAPI_Exception on error
     */
    public function get_messages(): array
    {
        $this->checkNewMessages();
        return $this->_messages;
    }

    /**
     * @throws YAPI_Exception
     */
    public function slotsInUse(): int
{
    return $this->get_slotsInUse();
}

    /**
     * @throws YAPI_Exception
     */
    public function slotsCount(): int
{
    return $this->get_slotsCount();
}

    /**
     * @throws YAPI_Exception
     */
    public function slotsBitmap(): string
{
    return $this->get_slotsBitmap();
}

    /**
     * @throws YAPI_Exception
     */
    public function pduSent(): int
{
    return $this->get_pduSent();
}

    /**
     * @throws YAPI_Exception
     */
    public function setPduSent(int $newval): int
{
    return $this->set_pduSent($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function pduReceived(): int
{
    return $this->get_pduReceived();
}

    /**
     * @throws YAPI_Exception
     */
    public function setPduReceived(int $newval): int
{
    return $this->set_pduReceived($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function obey(): string
{
    return $this->get_obey();
}

    /**
     * @throws YAPI_Exception
     */
    public function setObey(string $newval): int
{
    return $this->set_obey($newval);
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
     * Continues the enumeration of SMS message box interfaces started using yFirstMessageBox().
     * Caution: You can't make any assumption about the returned SMS message box interfaces order.
     * If you want to find a specific a SMS message box interface, use MessageBox.findMessageBox()
     * and a hardwareID or a logical name.
     *
     * @return ?YMessageBox  a pointer to a YMessageBox object, corresponding to
     *         a SMS message box interface currently online, or a null pointer
     *         if there are no more SMS message box interfaces to enumerate.
     */
    public function nextMessageBox(): ?YMessageBox
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindMessageBox($next_hwid);
    }

    /**
     * Starts the enumeration of SMS message box interfaces currently accessible.
     * Use the method YMessageBox::nextMessageBox() to iterate on
     * next SMS message box interfaces.
     *
     * @return ?YMessageBox  a pointer to a YMessageBox object, corresponding to
     *         the first SMS message box interface currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstMessageBox(): ?YMessageBox
    {
        $next_hwid = YAPI::getFirstHardwareId('MessageBox');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindMessageBox($next_hwid);
    }

    //--- (end of generated code: YMessageBox implementation)

}

