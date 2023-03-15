<?php
namespace Yoctopuce\YoctoAPI;

/**
 * Structure used internally to report results of a query. It only uses public attributes.
 * Do not instantiate directly
 */
class YAPI_YReq
{
    public string $hwid = "";
    public string $deviceid = "";
    public string $functionid = "";
    public int $errorType;
    public string $errorMsg;
    public mixed $result;
    public mixed $obj_result = null;

    function __construct(string $str_hwid, int $int_errType, string $str_errMsg, mixed $bin_result, mixed $obj_result = null)
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

