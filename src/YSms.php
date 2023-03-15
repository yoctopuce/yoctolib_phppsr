<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YSms Class: SMS message sent or received, returned by messageBox.get_messages or messageBox.newMessage
 *
 * YSms objects are used to describe an SMS message, received or to be sent.
 * These objects are used in particular in conjunction with the YMessageBox class.
 */
class YSms
{
    //--- (end of generated code: YSms declaration)

    //--- (generated code: YSms attributes)
    protected ?YMessageBox $_mbox = null;                         // YMessageBox
    protected int $_slot = 0;                            // int
    protected bool $_deliv = false;                        // bool
    protected string $_smsc = '';                           // str
    protected int $_mref = 0;                            // int
    protected string $_orig = '';                           // str
    protected string $_dest = '';                           // str
    protected int $_pid = 0;                            // int
    protected int $_alphab = 0;                            // int
    protected int $_mclass = 0;                            // int
    protected string $_stamp = '';                           // str
    protected string $_udh = "";                           // bin
    protected string $_udata = "";                           // bin
    protected int $_npdu = 0;                            // int
    protected string $_pdu = "";                           // bin
    protected array $_parts = [];                           // YSmsArr
    protected string $_aggSig = '';                           // str
    protected int $_aggIdx = 0;                            // int
    protected int $_aggCnt = 0;                            // int

    //--- (end of generated code: YSms attributes)

    function __construct(YMessageBox $obj_mbox)
    {
        //--- (generated code: YSms constructor)
        //--- (end of generated code: YSms constructor)
        $this->_mbox = $obj_mbox;
    }

    //--- (generated code: YSms implementation)

    /**
     * @throws YAPI_Exception on error
     */
    public function get_slot(): int
    {
        return $this->_slot;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_smsc(): string
    {
        return $this->_smsc;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_msgRef(): int
    {
        return $this->_mref;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_sender(): string
    {
        return $this->_orig;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_recipient(): string
    {
        return $this->_dest;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_protocolId(): int
    {
        return $this->_pid;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function isReceived(): bool
    {
        return $this->_deliv;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_alphabet(): int
    {
        return $this->_alphab;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_msgClass(): int
    {
        if ((($this->_mclass) & (16)) == 0) {
            return -1;
        }
        return (($this->_mclass) & (3));
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_dcs(): int
    {
        return (($this->_mclass) | (((($this->_alphab) << (2)))));
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_timestamp(): string
    {
        return $this->_stamp;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_userDataHeader(): string
    {
        return $this->_udh;
    }

    /**
     * Returns the value of the userData attribute, as previously stored using method
     * set_userData.
     * This attribute is never touched directly by the API, and is at disposal of the caller to
     * store a context.
     *
     * @return the object stored previously by the caller.
     */
    public function get_userData(): string
    {
        return $this->_udata;
    }

    /**
     * Returns the content of the message.
     *
     * @return string   a string with the content of the message.
     */
    public function get_textData(): string
    {
        // $isolatin               is a bin;
        // $isosize                is a int;
        // $i                      is a int;
        if ($this->_alphab == 0) {
            // using GSM standard 7-bit alphabet
            return $this->_mbox->gsm2str($this->_udata);
        }
        if ($this->_alphab == 2) {
            // using UCS-2 alphabet
            $isosize = ((strlen($this->_udata)) >> (1));
            $isolatin = ($isosize > 0 ? pack('C',array_fill(0, $isosize, 0)) : '');
            $i = 0;
            while ($i < $isosize) {
                $isolatin[$i] = pack('C', ord($this->_udata[2*$i+1]));
                $i = $i + 1;
            }
            return $isolatin;
        }
        // default: convert 8 bit to string as-is
        return $this->_udata;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_unicodeData(): array
    {
        $res = [];              // intArr;
        // $unisize                is a int;
        // $unival                 is a int;
        // $i                      is a int;
        if ($this->_alphab == 0) {
            // using GSM standard 7-bit alphabet
            return $this->_mbox->gsm2unicode($this->_udata);
        }
        if ($this->_alphab == 2) {
            // using UCS-2 alphabet
            $unisize = ((strlen($this->_udata)) >> (1));
            while (sizeof($res) > 0) {
                array_pop($res);
            };
            $i = 0;
            while ($i < $unisize) {
                $unival = 256*ord($this->_udata[2*$i])+ord($this->_udata[2*$i+1]);
                $res[] = $unival;
                $i = $i + 1;
            }
        } else {
            // return straight 8-bit values
            $unisize = strlen($this->_udata);
            while (sizeof($res) > 0) {
                array_pop($res);
            };
            $i = 0;
            while ($i < $unisize) {
                $res[] = ord($this->_udata[$i])+0;
                $i = $i + 1;
            }
        }
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_partCount(): int
    {
        if ($this->_npdu == 0) {
            $this->generatePdu();
        }
        return $this->_npdu;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_pdu(): string
    {
        if ($this->_npdu == 0) {
            $this->generatePdu();
        }
        return $this->_pdu;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_parts(): array
    {
        if ($this->_npdu == 0) {
            $this->generatePdu();
        }
        return $this->_parts;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_concatSignature(): string
    {
        if ($this->_npdu == 0) {
            $this->generatePdu();
        }
        return $this->_aggSig;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_concatIndex(): int
    {
        if ($this->_npdu == 0) {
            $this->generatePdu();
        }
        return $this->_aggIdx;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function get_concatCount(): int
    {
        if ($this->_npdu == 0) {
            $this->generatePdu();
        }
        return $this->_aggCnt;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function set_slot(int $val): int
    {
        $this->_slot = $val;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function set_received(bool $val): int
    {
        $this->_deliv = $val;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function set_smsc(string $val): int
    {
        $this->_smsc = $val;
        $this->_npdu = 0;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function set_msgRef(int $val): int
    {
        $this->_mref = $val;
        $this->_npdu = 0;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function set_sender(string $val): int
    {
        $this->_orig = $val;
        $this->_npdu = 0;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function set_recipient(string $val): int
    {
        $this->_dest = $val;
        $this->_npdu = 0;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function set_protocolId(int $val): int
    {
        $this->_pid = $val;
        $this->_npdu = 0;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function set_alphabet(int $val): int
    {
        $this->_alphab = $val;
        $this->_npdu = 0;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function set_msgClass(int $val): int
    {
        if ($val == -1) {
            $this->_mclass = 0;
        } else {
            $this->_mclass = 16+$val;
        }
        $this->_npdu = 0;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function set_dcs(int $val): int
    {
        $this->_alphab = ((((($val) >> (2)))) & (3));
        $this->_mclass = (($val) & (16+3));
        $this->_npdu = 0;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function set_timestamp(string $val): int
    {
        $this->_stamp = $val;
        $this->_npdu = 0;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function set_userDataHeader(string $val): int
    {
        $this->_udh = $val;
        $this->_npdu = 0;
        $this->parseUserDataHeader();
        return YAPI::SUCCESS;
    }

    /**
     * Stores a user context provided as argument in the userData attribute of the function.
     * This attribute is never touched by the API, and is at disposal of the caller to store a context.
     *
     * @param data : any kind of object to be stored
     * @noreturn
     */
    public function set_userData(string $val): int
    {
        $this->_udata = $val;
        $this->_npdu = 0;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function convertToUnicode(): int
    {
        $ucs2 = [];             // intArr;
        // $udatalen               is a int;
        // $i                      is a int;
        // $uni                    is a int;
        if ($this->_alphab == 2) {
            return YAPI::SUCCESS;
        }
        if ($this->_alphab == 0) {
            $ucs2 = $this->_mbox->gsm2unicode($this->_udata);
        } else {
            $udatalen = strlen($this->_udata);
            while (sizeof($ucs2) > 0) {
                array_pop($ucs2);
            };
            $i = 0;
            while ($i < $udatalen) {
                $uni = ord($this->_udata[$i]);
                $ucs2[] = $uni;
                $i = $i + 1;
            }
        }
        $this->_alphab = 2;
        $this->_udata = '';
        $this->addUnicodeData($ucs2);
        return YAPI::SUCCESS;
    }

    /**
     * Add a regular text to the SMS. This function support messages
     * of more than 160 characters. ISO-latin accented characters
     * are supported. For messages with special unicode characters such as asian
     * characters and emoticons, use the  addUnicodeData method.
     *
     * @param string $val : the text to be sent in the message
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     */
    public function addText(string $val): int
    {
        // $udata                  is a bin;
        // $udatalen               is a int;
        // $newdata                is a bin;
        // $newdatalen             is a int;
        // $i                      is a int;
        if (strlen($val) == 0) {
            return YAPI::SUCCESS;
        }
        if ($this->_alphab == 0) {
            // Try to append using GSM 7-bit alphabet
            $newdata = $this->_mbox->str2gsm($val);
            $newdatalen = strlen($newdata);
            if ($newdatalen == 0) {
                // 7-bit not possible, switch to unicode
                $this->convertToUnicode();
                $newdata = $val;
                $newdatalen = strlen($newdata);
            }
        } else {
            $newdata = $val;
            $newdatalen = strlen($newdata);
        }
        $udatalen = strlen($this->_udata);
        if ($this->_alphab == 2) {
            // Append in unicode directly
            $udata = ($udatalen + 2*$newdatalen > 0 ? pack('C',array_fill(0, $udatalen + 2*$newdatalen, 0)) : '');
            $i = 0;
            while ($i < $udatalen) {
                $udata[$i] = pack('C', ord($this->_udata[$i]));
                $i = $i + 1;
            }
            $i = 0;
            while ($i < $newdatalen) {
                $udata[$udatalen+1] = pack('C', ord($newdata[$i]));
                $udatalen = $udatalen + 2;
                $i = $i + 1;
            }
        } else {
            // Append binary buffers
            $udata = ($udatalen+$newdatalen > 0 ? pack('C',array_fill(0, $udatalen+$newdatalen, 0)) : '');
            $i = 0;
            while ($i < $udatalen) {
                $udata[$i] = pack('C', ord($this->_udata[$i]));
                $i = $i + 1;
            }
            $i = 0;
            while ($i < $newdatalen) {
                $udata[$udatalen] = pack('C', ord($newdata[$i]));
                $udatalen = $udatalen + 1;
                $i = $i + 1;
            }
        }
        return $this->set_userData($udata);
    }

    /**
     * Add a unicode text to the SMS. This function support messages
     * of more than 160 characters, using SMS concatenation.
     *
     * @param Integer[] $val : an array of special unicode characters
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     */
    public function addUnicodeData(array $val): int
    {
        // $arrlen                 is a int;
        // $newdatalen             is a int;
        // $i                      is a int;
        // $uni                    is a int;
        // $udata                  is a bin;
        // $udatalen               is a int;
        // $surrogate              is a int;
        if ($this->_alphab != 2) {
            $this->convertToUnicode();
        }
        // compute number of 16-bit code units
        $arrlen = sizeof($val);
        $newdatalen = $arrlen;
        $i = 0;
        while ($i < $arrlen) {
            $uni = $val[$i];
            if ($uni > 65535) {
                $newdatalen = $newdatalen + 1;
            }
            $i = $i + 1;
        }
        // now build utf-16 buffer
        $udatalen = strlen($this->_udata);
        $udata = ($udatalen+2*$newdatalen > 0 ? pack('C',array_fill(0, $udatalen+2*$newdatalen, 0)) : '');
        $i = 0;
        while ($i < $udatalen) {
            $udata[$i] = pack('C', ord($this->_udata[$i]));
            $i = $i + 1;
        }
        $i = 0;
        while ($i < $arrlen) {
            $uni = $val[$i];
            if ($uni >= 65536) {
                $surrogate = $uni - 65536;
                $uni = ((((($surrogate) >> (10))) & (1023))) + 55296;
                $udata[$udatalen] = pack('C', (($uni) >> (8)));
                $udata[$udatalen+1] = pack('C', (($uni) & (255)));
                $udatalen = $udatalen + 2;
                $uni = ((($surrogate) & (1023))) + 56320;
            }
            $udata[$udatalen] = pack('C', (($uni) >> (8)));
            $udata[$udatalen+1] = pack('C', (($uni) & (255)));
            $udatalen = $udatalen + 2;
            $i = $i + 1;
        }
        return $this->set_userData($udata);
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function set_pdu(string $pdu): int
    {
        $this->_pdu = $pdu;
        $this->_npdu = 1;
        return $this->parsePdu($pdu);
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function set_parts(array $parts): int
    {
        $sorted = [];           // YSmsArr;
        // $partno                 is a int;
        // $initpartno             is a int;
        // $i                      is a int;
        // $retcode                is a int;
        // $totsize                is a int;
        // $subsms                 is a YSms;
        // $subdata                is a bin;
        // $res                    is a bin;
        $this->_npdu = sizeof($parts);
        if ($this->_npdu == 0) {
            return YAPI::INVALID_ARGUMENT;
        }
        while (sizeof($sorted) > 0) {
            array_pop($sorted);
        };
        $partno = 0;
        while ($partno < $this->_npdu) {
            $initpartno = $partno;
            $i = 0;
            while ($i < $this->_npdu) {
                $subsms = $parts[$i];
                if ($subsms->get_concatIndex() == $partno) {
                    $sorted[] = $subsms;
                    $partno = $partno + 1;
                }
                $i = $i + 1;
            }
            if ($initpartno == $partno) {
                $partno = $partno + 1;
            }
        }
        $this->_parts = $sorted;
        // inherit header fields from first part
        $subsms = $this->_parts[0];
        $retcode = $this->parsePdu($subsms->get_pdu());
        if ($retcode != YAPI::SUCCESS) {
            return $retcode;
        }
        $this->_npdu = sizeof($sorted);
        // concatenate user data from all parts
        $totsize = 0;
        $partno = 0;
        while ($partno < sizeof($this->_parts)) {
            $subsms = $this->_parts[$partno];
            $subdata = $subsms->get_userData();
            $totsize = $totsize + strlen($subdata);
            $partno = $partno + 1;
        }
        $res = ($totsize > 0 ? pack('C',array_fill(0, $totsize, 0)) : '');
        $totsize = 0;
        $partno = 0;
        while ($partno < sizeof($this->_parts)) {
            $subsms = $this->_parts[$partno];
            $subdata = $subsms->get_userData();
            $i = 0;
            while ($i < strlen($subdata)) {
                $res[$totsize] = pack('C', ord($subdata[$i]));
                $totsize = $totsize + 1;
                $i = $i + 1;
            }
            $partno = $partno + 1;
        }
        $this->_udata = $res;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function encodeAddress(string $addr): string
    {
        // $bytes                  is a bin;
        // $srclen                 is a int;
        // $numlen                 is a int;
        // $i                      is a int;
        // $val                    is a int;
        // $digit                  is a int;
        // $res                    is a bin;
        $bytes = $addr;
        $srclen = strlen($bytes);
        $numlen = 0;
        $i = 0;
        while ($i < $srclen) {
            $val = ord($bytes[$i]);
            if (($val >= 48) && ($val < 58)) {
                $numlen = $numlen + 1;
            }
            $i = $i + 1;
        }
        if ($numlen == 0) {
            $res = (1 > 0 ? pack('C',array_fill(0, 1, 0)) : '');
            $res[0] = pack('C', 0);
            return $res;
        }
        $res = (2+(($numlen+1) >> (1)) > 0 ? pack('C',array_fill(0, 2+(($numlen+1) >> (1)), 0)) : '');
        $res[0] = pack('C', $numlen);
        if (ord($bytes[0]) == 43) {
            $res[1] = pack('C', 145);
        } else {
            $res[1] = pack('C', 129);
        }
        $numlen = 4;
        $digit = 0;
        $i = 0;
        while ($i < $srclen) {
            $val = ord($bytes[$i]);
            if (($val >= 48) && ($val < 58)) {
                if ((($numlen) & (1)) == 0) {
                    $digit = $val - 48;
                } else {
                    $res[(($numlen) >> (1))] = pack('C', $digit + 16*($val-48));
                }
                $numlen = $numlen + 1;
            }
            $i = $i + 1;
        }
        // pad with F if needed
        if ((($numlen) & (1)) != 0) {
            $res[(($numlen) >> (1))] = pack('C', $digit + 240);
        }
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function decodeAddress(string $addr, int $ofs, int $siz): string
    {
        // $addrType               is a int;
        // $gsm7                   is a bin;
        // $res                    is a str;
        // $i                      is a int;
        // $rpos                   is a int;
        // $carry                  is a int;
        // $nbits                  is a int;
        // $byt                    is a int;
        if ($siz == 0) {
            return '';
        }
        $res = '';
        $addrType = ((ord($addr[$ofs])) & (112));
        if ($addrType == 80) {
            // alphanumeric number
            $siz = intVal((4*$siz) / (7));
            $gsm7 = ($siz > 0 ? pack('C',array_fill(0, $siz, 0)) : '');
            $rpos = 1;
            $carry = 0;
            $nbits = 0;
            $i = 0;
            while ($i < $siz) {
                if ($nbits == 7) {
                    $gsm7[$i] = pack('C', $carry);
                    $carry = 0;
                    $nbits = 0;
                } else {
                    $byt = ord($addr[$ofs+$rpos]);
                    $rpos = $rpos + 1;
                    $gsm7[$i] = pack('C', (($carry) | (((((($byt) << ($nbits)))) & (127)))));
                    $carry = (($byt) >> ((7 - $nbits)));
                    $nbits = $nbits + 1;
                }
                $i = $i + 1;
            }
            return $this->_mbox->gsm2str($gsm7);
        } else {
            // standard phone number
            if ($addrType == 16) {
                $res = '+';
            }
            $siz = ((($siz+1)) >> (1));
            $i = 0;
            while ($i < $siz) {
                $byt = ord($addr[$ofs+$i+1]);
                $res = sprintf('%s%x%x', $res, (($byt) & (15)), (($byt) >> (4)));
                $i = $i + 1;
            }
            // remove padding digit if needed
            if (((ord($addr[$ofs+$siz])) >> (4)) == 15) {
                $res = substr($res,  0, strlen($res)-1);
            }
            return $res;
        }
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function encodeTimeStamp(string $exp): string
    {
        // $explen                 is a int;
        // $i                      is a int;
        // $res                    is a bin;
        // $n                      is a int;
        // $expasc                 is a bin;
        // $v1                     is a int;
        // $v2                     is a int;
        $explen = strlen($exp);
        if ($explen == 0) {
            $res = '';
            return $res;
        }
        if (substr($exp, 0, 1) == '+') {
            $n = intVal(substr($exp, 1, $explen-1));
            $res = (1 > 0 ? pack('C',array_fill(0, 1, 0)) : '');
            if ($n > 30*86400) {
                $n = 192+intVal((($n+6*86400)) / ((7*86400)));
            } else {
                if ($n > 86400) {
                    $n = 166+intVal((($n+86399)) / (86400));
                } else {
                    if ($n > 43200) {
                        $n = 143+intVal((($n-43200+1799)) / (1800));
                    } else {
                        $n = -1+intVal((($n+299)) / (300));
                    }
                }
            }
            if ($n < 0) {
                $n = 0;
            }
            $res[0] = pack('C', $n);
            return $res;
        }
        if (substr($exp, 4, 1) == '-' || substr($exp, 4, 1) == '/') {
            // ignore century
            $exp = substr($exp,  2, $explen-2);
            $explen = strlen($exp);
        }
        $expasc = $exp;
        $res = (7 > 0 ? pack('C',array_fill(0, 7, 0)) : '');
        $n = 0;
        $i = 0;
        while (($i+1 < $explen) && ($n < 7)) {
            $v1 = ord($expasc[$i]);
            if (($v1 >= 48) && ($v1 < 58)) {
                $v2 = ord($expasc[$i+1]);
                if (($v2 >= 48) && ($v2 < 58)) {
                    $v1 = $v1 - 48;
                    $v2 = $v2 - 48;
                    $res[$n] = pack('C', ((($v2) << (4))) + $v1);
                    $n = $n + 1;
                    $i = $i + 1;
                }
            }
            $i = $i + 1;
        }
        while ($n < 7) {
            $res[$n] = pack('C', 0);
            $n = $n + 1;
        }
        if ($i+2 < $explen) {
            // convert for timezone in cleartext ISO format +/-nn:nn
            $v1 = ord($expasc[$i-3]);
            $v2 = ord($expasc[$i]);
            if ((($v1 == 43) || ($v1 == 45)) && ($v2 == 58)) {
                $v1 = ord($expasc[$i+1]);
                $v2 = ord($expasc[$i+2]);
                if (($v1 >= 48) && ($v1 < 58) && ($v1 >= 48) && ($v1 < 58)) {
                    $v1 = intVal(((10*($v1 - 48)+($v2 - 48))) / (15));
                    $n = $n - 1;
                    $v2 = 4 * ord($res[$n]) + $v1;
                    if (ord($expasc[$i-3]) == 45) {
                        $v2 = $v2 + 128;
                    }
                    $res[$n] = pack('C', $v2);
                }
            }
        }
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function decodeTimeStamp(string $exp, int $ofs, int $siz): string
    {
        // $n                      is a int;
        // $res                    is a str;
        // $i                      is a int;
        // $byt                    is a int;
        // $sign                   is a str;
        // $hh                     is a str;
        // $ss                     is a str;
        if ($siz < 1) {
            return '';
        }
        if ($siz == 1) {
            $n = ord($exp[$ofs]);
            if ($n < 144) {
                $n = $n * 300;
            } else {
                if ($n < 168) {
                    $n = ($n-143) * 1800;
                } else {
                    if ($n < 197) {
                        $n = ($n-166) * 86400;
                    } else {
                        $n = ($n-192) * 7 * 86400;
                    }
                }
            }
            return sprintf('+%d',$n);
        }
        $res = '20';
        $i = 0;
        while (($i < $siz) && ($i < 6)) {
            $byt = ord($exp[$ofs+$i]);
            $res = sprintf('%s%x%x', $res, (($byt) & (15)), (($byt) >> (4)));
            if ($i < 3) {
                if ($i < 2) {
                    $res = sprintf('%s-', $res);
                } else {
                    $res = sprintf('%s ', $res);
                }
            } else {
                if ($i < 5) {
                    $res = sprintf('%s:', $res);
                }
            }
            $i = $i + 1;
        }
        if ($siz == 7) {
            $byt = ord($exp[$ofs+$i]);
            $sign = '+';
            if ((($byt) & (8)) != 0) {
                $byt = $byt - 8;
                $sign = '-';
            }
            $byt = (10*((($byt) & (15)))) + ((($byt) >> (4)));
            $hh = sprintf('%d', (($byt) >> (2)));
            $ss = sprintf('%d', 15*((($byt) & (3))));
            if (strlen($hh)<2) {
                $hh = sprintf('0%s', $hh);
            }
            if (strlen($ss)<2) {
                $ss = sprintf('0%s', $ss);
            }
            $res = sprintf('%s%s%s:%s', $res, $sign, $hh, $ss);
        }
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function udataSize(): int
    {
        // $res                    is a int;
        // $udhsize                is a int;
        $udhsize = strlen($this->_udh);
        $res = strlen($this->_udata);
        if ($this->_alphab == 0) {
            if ($udhsize > 0) {
                $res = $res + intVal(((8 + 8*$udhsize + 6)) / (7));
            }
            $res = intVal((($res * 7 + 7)) / (8));
        } else {
            if ($udhsize > 0) {
                $res = $res + 1 + $udhsize;
            }
        }
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function encodeUserData(): string
    {
        // $udsize                 is a int;
        // $udlen                  is a int;
        // $udhsize                is a int;
        // $udhlen                 is a int;
        // $res                    is a bin;
        // $i                      is a int;
        // $wpos                   is a int;
        // $carry                  is a int;
        // $nbits                  is a int;
        // $thi_b                  is a int;
        // nbits = number of bits in carry
        $udsize = $this->udataSize();
        $udhsize = strlen($this->_udh);
        $udlen = strlen($this->_udata);
        $res = (1+$udsize > 0 ? pack('C',array_fill(0, 1+$udsize, 0)) : '');
        $udhlen = 0;
        $nbits = 0;
        $carry = 0;
        // 1. Encode UDL
        if ($this->_alphab == 0) {
            // 7-bit encoding
            if ($udhsize > 0) {
                $udhlen = intVal(((8 + 8*$udhsize + 6)) / (7));
                $nbits = 7*$udhlen - 8 - 8*$udhsize;
            }
            $res[0] = pack('C', $udhlen+$udlen);
        } else {
            // 8-bit encoding
            $res[0] = pack('C', $udsize);
        }
        // 2. Encode UDHL and UDL
        $wpos = 1;
        if ($udhsize > 0) {
            $res[$wpos] = pack('C', $udhsize);
            $wpos = $wpos + 1;
            $i = 0;
            while ($i < $udhsize) {
                $res[$wpos] = pack('C', ord($this->_udh[$i]));
                $wpos = $wpos + 1;
                $i = $i + 1;
            }
        }
        // 3. Encode UD
        if ($this->_alphab == 0) {
            // 7-bit encoding
            $i = 0;
            while ($i < $udlen) {
                if ($nbits == 0) {
                    $carry = ord($this->_udata[$i]);
                    $nbits = 7;
                } else {
                    $thi_b = ord($this->_udata[$i]);
                    $res[$wpos] = pack('C', (($carry) | (((((($thi_b) << ($nbits)))) & (255)))));
                    $wpos = $wpos + 1;
                    $nbits = $nbits - 1;
                    $carry = (($thi_b) >> ((7 - $nbits)));
                }
                $i = $i + 1;
            }
            if ($nbits > 0) {
                $res[$wpos] = pack('C', $carry);
            }
        } else {
            // 8-bit encoding
            $i = 0;
            while ($i < $udlen) {
                $res[$wpos] = pack('C', ord($this->_udata[$i]));
                $wpos = $wpos + 1;
                $i = $i + 1;
            }
        }
        return $res;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function generateParts(): int
    {
        // $udhsize                is a int;
        // $udlen                  is a int;
        // $mss                    is a int;
        // $partno                 is a int;
        // $partlen                is a int;
        // $newud                  is a bin;
        // $newudh                 is a bin;
        // $newpdu                 is a YSms;
        // $i                      is a int;
        // $wpos                   is a int;
        $udhsize = strlen($this->_udh);
        $udlen = strlen($this->_udata);
        $mss = 140 - 1 - 5 - $udhsize;
        if ($this->_alphab == 0) {
            $mss = intVal((($mss * 8 - 6)) / (7));
        }
        $this->_npdu = intVal((($udlen+$mss-1)) / ($mss));
        while (sizeof($this->_parts) > 0) {
            array_pop($this->_parts);
        };
        $partno = 0;
        $wpos = 0;
        while ($wpos < $udlen) {
            $partno = $partno + 1;
            $newudh = (5+$udhsize > 0 ? pack('C',array_fill(0, 5+$udhsize, 0)) : '');
            $newudh[0] = pack('C', 0);           // IEI: concatenated message
            $newudh[1] = pack('C', 3);           // IEDL: 3 bytes
            $newudh[2] = pack('C', $this->_mref);
            $newudh[3] = pack('C', $this->_npdu);
            $newudh[4] = pack('C', $partno);
            $i = 0;
            while ($i < $udhsize) {
                $newudh[5+$i] = pack('C', ord($this->_udh[$i]));
                $i = $i + 1;
            }
            if ($wpos+$mss < $udlen) {
                $partlen = $mss;
            } else {
                $partlen = $udlen-$wpos;
            }
            $newud = ($partlen > 0 ? pack('C',array_fill(0, $partlen, 0)) : '');
            $i = 0;
            while ($i < $partlen) {
                $newud[$i] = pack('C', ord($this->_udata[$wpos]));
                $wpos = $wpos + 1;
                $i = $i + 1;
            }
            $newpdu = new YSms($this->_mbox);
            $newpdu->set_received($this->isReceived());
            $newpdu->set_smsc($this->get_smsc());
            $newpdu->set_msgRef($this->get_msgRef());
            $newpdu->set_sender($this->get_sender());
            $newpdu->set_recipient($this->get_recipient());
            $newpdu->set_protocolId($this->get_protocolId());
            $newpdu->set_dcs($this->get_dcs());
            $newpdu->set_timestamp($this->get_timestamp());
            $newpdu->set_userDataHeader($newudh);
            $newpdu->set_userData($newud);
            $this->_parts[] = $newpdu;
        }
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function generatePdu(): int
    {
        // $sca                    is a bin;
        // $hdr                    is a bin;
        // $addr                   is a bin;
        // $stamp                  is a bin;
        // $udata                  is a bin;
        // $pdutyp                 is a int;
        // $pdulen                 is a int;
        // $i                      is a int;
        // Determine if the message can fit within a single PDU
        while (sizeof($this->_parts) > 0) {
            array_pop($this->_parts);
        };
        if ($this->udataSize() > 140) {
            // multiple PDU are needed
            $this->_pdu = '';
            return $this->generateParts();
        }
        $sca = $this->encodeAddress($this->_smsc);
        if (strlen($sca) > 0) {
            $sca[0] = pack('C', strlen($sca)-1);
        }
        $stamp = $this->encodeTimeStamp($this->_stamp);
        $udata = $this->encodeUserData();
        if ($this->_deliv) {
            $addr = $this->encodeAddress($this->_orig);
            $hdr = (1 > 0 ? pack('C',array_fill(0, 1, 0)) : '');
            $pdutyp = 0;
        } else {
            $addr = $this->encodeAddress($this->_dest);
            $this->_mref = $this->_mbox->nextMsgRef();
            $hdr = (2 > 0 ? pack('C',array_fill(0, 2, 0)) : '');
            $hdr[1] = pack('C', $this->_mref);
            $pdutyp = 1;
            if (strlen($stamp) > 0) {
                $pdutyp = $pdutyp + 16;
            }
            if (strlen($stamp) == 7) {
                $pdutyp = $pdutyp + 8;
            }
        }
        if (strlen($this->_udh) > 0) {
            $pdutyp = $pdutyp + 64;
        }
        $hdr[0] = pack('C', $pdutyp);
        $pdulen = strlen($sca)+strlen($hdr)+strlen($addr)+2+strlen($stamp)+strlen($udata);
        $this->_pdu = ($pdulen > 0 ? pack('C',array_fill(0, $pdulen, 0)) : '');
        $pdulen = 0;
        $i = 0;
        while ($i < strlen($sca)) {
            $this->_pdu[$pdulen] = pack('C', ord($sca[$i]));
            $pdulen = $pdulen + 1;
            $i = $i + 1;
        }
        $i = 0;
        while ($i < strlen($hdr)) {
            $this->_pdu[$pdulen] = pack('C', ord($hdr[$i]));
            $pdulen = $pdulen + 1;
            $i = $i + 1;
        }
        $i = 0;
        while ($i < strlen($addr)) {
            $this->_pdu[$pdulen] = pack('C', ord($addr[$i]));
            $pdulen = $pdulen + 1;
            $i = $i + 1;
        }
        $this->_pdu[$pdulen] = pack('C', $this->_pid);
        $pdulen = $pdulen + 1;
        $this->_pdu[$pdulen] = pack('C', $this->get_dcs());
        $pdulen = $pdulen + 1;
        $i = 0;
        while ($i < strlen($stamp)) {
            $this->_pdu[$pdulen] = pack('C', ord($stamp[$i]));
            $pdulen = $pdulen + 1;
            $i = $i + 1;
        }
        $i = 0;
        while ($i < strlen($udata)) {
            $this->_pdu[$pdulen] = pack('C', ord($udata[$i]));
            $pdulen = $pdulen + 1;
            $i = $i + 1;
        }
        $this->_npdu = 1;
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function parseUserDataHeader(): int
    {
        // $udhlen                 is a int;
        // $i                      is a int;
        // $iei                    is a int;
        // $ielen                  is a int;
        // $sig                    is a str;
        $this->_aggSig = '';
        $this->_aggIdx = 0;
        $this->_aggCnt = 0;
        $udhlen = strlen($this->_udh);
        $i = 0;
        while ($i+1 < $udhlen) {
            $iei = ord($this->_udh[$i]);
            $ielen = ord($this->_udh[$i+1]);
            $i = $i + 2;
            if ($i + $ielen <= $udhlen) {
                if (($iei == 0) && ($ielen == 3)) {
                    // concatenated SMS, 8-bit ref
                    $sig = sprintf('%s-%s-%02x-%02x', $this->_orig, $this->_dest,
                    $this->_mref, ord($this->_udh[$i]));
                    $this->_aggSig = $sig;
                    $this->_aggCnt = ord($this->_udh[$i+1]);
                    $this->_aggIdx = ord($this->_udh[$i+2]);
                }
                if (($iei == 8) && ($ielen == 4)) {
                    // concatenated SMS, 16-bit ref
                    $sig = sprintf('%s-%s-%02x-%02x%02x', $this->_orig, $this->_dest,
                    $this->_mref, ord($this->_udh[$i]), ord($this->_udh[$i+1]));
                    $this->_aggSig = $sig;
                    $this->_aggCnt = ord($this->_udh[$i+2]);
                    $this->_aggIdx = ord($this->_udh[$i+3]);
                }
            }
            $i = $i + $ielen;
        }
        return YAPI::SUCCESS;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function parsePdu(string $pdu): int
    {
        // $rpos                   is a int;
        // $addrlen                is a int;
        // $pdutyp                 is a int;
        // $tslen                  is a int;
        // $dcs                    is a int;
        // $udlen                  is a int;
        // $udhsize                is a int;
        // $udhlen                 is a int;
        // $i                      is a int;
        // $carry                  is a int;
        // $nbits                  is a int;
        // $thi_b                  is a int;
        $this->_pdu = $pdu;
        $this->_npdu = 1;
        // parse meta-data
        $this->_smsc = $this->decodeAddress($pdu, 1, 2*(ord($pdu[0])-1));
        $rpos = 1+ord($pdu[0]);
        $pdutyp = ord($pdu[$rpos]);
        $rpos = $rpos + 1;
        $this->_deliv = ((($pdutyp) & (3)) == 0);
        if ($this->_deliv) {
            $addrlen = ord($pdu[$rpos]);
            $rpos = $rpos + 1;
            $this->_orig = $this->decodeAddress($pdu, $rpos, $addrlen);
            $this->_dest = '';
            $tslen = 7;
        } else {
            $this->_mref = ord($pdu[$rpos]);
            $rpos = $rpos + 1;
            $addrlen = ord($pdu[$rpos]);
            $rpos = $rpos + 1;
            $this->_dest = $this->decodeAddress($pdu, $rpos, $addrlen);
            $this->_orig = '';
            if (((($pdutyp) & (16))) != 0) {
                if (((($pdutyp) & (8))) != 0) {
                    $tslen = 7;
                } else {
                    $tslen= 1;
                }
            } else {
                $tslen = 0;
            }
        }
        $rpos = $rpos + (((($addrlen+3)) >> (1)));
        $this->_pid = ord($pdu[$rpos]);
        $rpos = $rpos + 1;
        $dcs = ord($pdu[$rpos]);
        $rpos = $rpos + 1;
        $this->_alphab = ((((($dcs) >> (2)))) & (3));
        $this->_mclass = (($dcs) & (16+3));
        $this->_stamp = $this->decodeTimeStamp($pdu, $rpos, $tslen);
        $rpos = $rpos + $tslen;
        // parse user data (including udh)
        $nbits = 0;
        $carry = 0;
        $udlen = ord($pdu[$rpos]);
        $rpos = $rpos + 1;
        if ((($pdutyp) & (64)) != 0) {
            $udhsize = ord($pdu[$rpos]);
            $rpos = $rpos + 1;
            $this->_udh = ($udhsize > 0 ? pack('C',array_fill(0, $udhsize, 0)) : '');
            $i = 0;
            while ($i < $udhsize) {
                $this->_udh[$i] = pack('C', ord($pdu[$rpos]));
                $rpos = $rpos + 1;
                $i = $i + 1;
            }
            if ($this->_alphab == 0) {
                // 7-bit encoding
                $udhlen = intVal(((8 + 8*$udhsize + 6)) / (7));
                $nbits = 7*$udhlen - 8 - 8*$udhsize;
                if ($nbits > 0) {
                    $thi_b = ord($pdu[$rpos]);
                    $rpos = $rpos + 1;
                    $carry = (($thi_b) >> ($nbits));
                    $nbits = 8 - $nbits;
                }
            } else {
                // byte encoding
                $udhlen = 1+$udhsize;
            }
            $udlen = $udlen - $udhlen;
        } else {
            $udhsize = 0;
            $this->_udh = '';
        }
        $this->_udata = ($udlen > 0 ? pack('C',array_fill(0, $udlen, 0)) : '');
        if ($this->_alphab == 0) {
            // 7-bit encoding
            $i = 0;
            while ($i < $udlen) {
                if ($nbits == 7) {
                    $this->_udata[$i] = pack('C', $carry);
                    $carry = 0;
                    $nbits = 0;
                } else {
                    $thi_b = ord($pdu[$rpos]);
                    $rpos = $rpos + 1;
                    $this->_udata[$i] = pack('C', (($carry) | (((((($thi_b) << ($nbits)))) & (127)))));
                    $carry = (($thi_b) >> ((7 - $nbits)));
                    $nbits = $nbits + 1;
                }
                $i = $i + 1;
            }
        } else {
            // 8-bit encoding
            $i = 0;
            while ($i < $udlen) {
                $this->_udata[$i] = pack('C', ord($pdu[$rpos]));
                $rpos = $rpos + 1;
                $i = $i + 1;
            }
        }
        $this->parseUserDataHeader();
        return YAPI::SUCCESS;
    }

    /**
     * Sends the SMS to the recipient. Messages of more than 160 characters are supported
     * using SMS concatenation.
     *
     * @return int  YAPI::SUCCESS when the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function send(): int
    {
        // $i                      is a int;
        // $retcode                is a int;
        // $pdu                    is a YSms;

        if ($this->_npdu == 0) {
            $this->generatePdu();
        }
        if ($this->_npdu == 1) {
            return $this->_mbox->_upload('sendSMS', $this->_pdu);
        }
        $retcode = YAPI::SUCCESS;
        $i = 0;
        while (($i < $this->_npdu) && ($retcode == YAPI::SUCCESS)) {
            $pdu = $this->_parts[$i];
            $retcode= $pdu->send();
            $i = $i + 1;
        }
        return $retcode;
    }

    /**
     * @throws YAPI_Exception on error
     */
    public function deleteFromSIM(): int
    {
        // $i                      is a int;
        // $retcode                is a int;
        // $pdu                    is a YSms;

        if ($this->_npdu < 2) {
            return $this->_mbox->clearSIMSlot($this->_slot);
        }
        $retcode = YAPI::SUCCESS;
        $i = 0;
        while (($i < $this->_npdu) && ($retcode == YAPI::SUCCESS)) {
            $pdu = $this->_parts[$i];
            $retcode= $pdu->deleteFromSIM();
            $i = $i + 1;
        }
        return $retcode;
    }

    //--- (end of generated code: YSms implementation)

}

