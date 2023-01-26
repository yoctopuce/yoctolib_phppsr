<?php
namespace Yoctopuce\YoctoAPI;
//
// Structure used internally to report results of a query. It only uses public attributes.
// Do not instantiate directly
//
class YAPI_YReq
{
    public $hwid = "";
    public $deviceid = "";
    public $functionid = "";
    public $errorType;
    public $errorMsg;
    public $result;
    public $obj_result = null;

    function __construct($str_hwid, $int_errType, $str_errMsg, $bin_result, $obj_result = null)
    {
        $sep = strpos($str_hwid, ".");
        if ($sep !== false) {
            $this->hwid = $str_hwid;
            $this->deviceid = substr($str_hwid, 0, $sep);
            $this->functionid = substr($str_hwid, $sep + 1);
        }
        $this->errorType = $int_errType;
        $this->errorMsg = $str_errMsg;
        $this->result = $bin_result;
        $this->obj_result = $obj_result;
    }
}

