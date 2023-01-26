<?php
namespace Yoctopuce\YoctoAPI;
//
// YFunctionType Class (used internally)
//
// Instances of this class stores everything we know about a given type of function:
// Mapping between function logical names and Hardware ID as discovered on hubs,
// and existing instances of YFunction (either already connected or simply requested).
// To keep it simple, this implementation separates completely the name resolution
// mechanism, implemented using the yellow pages, and the storage and retrieval of
// existing YFunction instances.
//

class YFunctionType
{
    // private attributes, to be used within yocto_api only
    protected string $_className;
    protected array $_connectedFns;           // functions requested and available, by Hardware Id
    protected array $_requestedFns;           // functions requested but not yet known, by any type of name
    protected array $_hwIdByName;             // hash table of function Hardware Id by logical name
    protected array $_nameByHwId;             // hash table of function logical name by Hardware Id
    protected array $_valueByHwId;            // hash table of function advertised value by logical name
    protected int $_baseType;               // default to no abstract base type (generic YFunction)

    /**
     * YFunctionType constructor.
     * @param string $str_classname
     * @throws YAPI_Exception
     */
    function __construct(string $str_classname)
    {
        if (ord($str_classname[strlen($str_classname) - 1]) <= 57) {
            throw new YAPI_Exception("Invalid function type", -1);
        }
        $this->_className = $str_classname;
        $this->_connectedFns = array();
        $this->_requestedFns = array();
        $this->_hwIdByName = array();
        $this->_nameByHwId = array();
        $this->_valueByHwId = array();
        $this->_baseType = 0;
    }


    // Index a single function given by HardwareId and logical name; store any advertised value
    // Return true iff there was a logical name discrepency
    public function reindexFunction(string $str_hwid, string $str_name, ?string $str_val, ?int $int_basetype): bool
    {
        $currname = '';
        $res = false;
        if (isset($this->_nameByHwId[$str_hwid])) {
            $currname = $this->_nameByHwId[$str_hwid];
        }
        if ($currname == '') {
            if ($str_name != '') {
                $this->_nameByHwId[$str_hwid] = $str_name;
                $res = true;
            }
        } elseif ($currname != $str_name) {
            if ($this->_hwIdByName[$currname] == $str_hwid) {
                unset($this->_hwIdByName[$currname]);
            }
            if ($str_name != '') {
                $this->_nameByHwId[$str_hwid] = $str_name;
            } else {
                unset($this->_nameByHwId[$str_hwid]);
            }
            $res = true;
        }
        if ($str_name != '') {
            $this->_hwIdByName[$str_name] = $str_hwid;
        }
        if (!is_null($str_val)) {
            $this->_valueByHwId[$str_hwid] = $str_val;
        } else {
            if (!isset($this->_valueByHwId[$str_hwid])) {
                $this->_valueByHwId[$str_hwid] = '';
            }
        }
        if (!is_null($int_basetype)) {
            if ($this->_baseType == 0) {
                $this->_baseType = $int_basetype;
            }
        }
        return $res;
    }

    // Forget a disconnected function given by HardwareId
    public function forgetFunction(string $str_hwid): void
    {
        if (isset($this->_nameByHwId[$str_hwid])) {
            $currname = $this->_nameByHwId[$str_hwid];
            if ($currname != '' && $this->_hwIdByName[$currname] == $str_hwid) {
                unset($this->_hwIdByName[$currname]);
            }
            unset($this->_nameByHwId[$str_hwid]);
        }
        if (isset($this->_valueByHwId[$str_hwid])) {
            unset($this->_valueByHwId[$str_hwid]);
        }
    }

    // Find the exact Hardware Id of the specified function, if currently connected
    // If device is not known as connected, return a clean error
    // This function will not cause any network access
    public function resolve(string $str_func): YAPI_YReq
    {
        // Try to resolve str_func to a known Function instance, if possible, without any device access
        $dotpos = strpos($str_func, '.');
        if ($dotpos === false) {
            // First case: str_func is the logicalname of a function
            if (isset($this->_hwIdByName[$str_func])) {
                return new YAPI_YReq($this->_hwIdByName[$str_func],
                    YAPI::SUCCESS,
                    'no error',
                    $this->_hwIdByName[$str_func]);
            }

            // fallback to assuming that str_func is a logicalname or serial number of a module
            // with an implicit function name (like serial.module for instance)
            $dotpos = strlen($str_func);
            $str_func .= '.' . strtolower($this->_className[0]) . substr($this->_className, 1);
        }

        // Second case: str_func is in the form: device_id.function_id

        // quick lookup for a known pure hardware id
        if (isset($this->_valueByHwId[$str_func])) {
            return new YAPI_YReq($this->_valueByHwId[$str_func],
                YAPI::SUCCESS,
                'no error',
                $str_func);
        }
        if ($dotpos > 0) {
            // either the device id is a logical name, or the function is unknown
            $devid = substr($str_func, 0, $dotpos);
            $funcid = substr($str_func, $dotpos + 1);
            $dev = YAPI::getDevice($devid);
            if (!$dev) {
                return new YAPI_YReq($str_func,
                    YAPI::DEVICE_NOT_FOUND,
                    "Device [$devid] not online",
                    null);
            }
            $serial = $dev->getSerialNumber();
            $res = "$serial.$funcid";
            if (isset($this->_valueByHwId[$res])) {
                return new YAPI_YReq($res,
                    YAPI::SUCCESS,
                    'no error',
                    $res);
            }

            // not found neither, may be funcid is a function logicalname
            $nfun = $dev->functionCount();
            for ($i = 0; $i < $nfun; $i++) {
                $res = "$serial." . $dev->functionId($i);
                if (isset($this->_nameByHwId[$res])) {
                    $name = $this->_nameByHwId[$res];
                    if ($name == $funcid) {
                        return new YAPI_YReq($res,
                            YAPI::SUCCESS,
                            'no error',
                            $res);
                    }
                }
            }
        } else {
            $serial = '';
            $funcid = substr($str_func, 1);
            // only functionId  (ie ".temperature")
            foreach (array_keys($this->_connectedFns) as $hwid_str) {
                $pos = strpos($hwid_str, '.');
                $function = substr($hwid_str, $pos + 1);
                //print("search for $funcid in {$this->_className} $function\n");
                if ($function == $funcid) {
                    return new YAPI_YReq($hwid_str,
                        YAPI::SUCCESS,
                        'no error',
                        $hwid_str);
                }
            }
        }

        return new YAPI_YReq("$serial.$funcid",
            YAPI::DEVICE_NOT_FOUND,
            "No function [$funcid] found on device [$serial]",
            null);
    }

    public function getFriendlyName(string $str_func): YAPI_YReq
    {
        $resolved = $this->resolve($str_func);
        if ($resolved->errorType != YAPI::SUCCESS) {
            return $resolved;
        }

        if ($this->_className == "Module") {
            $friend = $resolved->result;
            if (isset($this->_nameByHwId[$resolved->result])) {
                $friend = $this->_nameByHwId[$resolved->result];
            }
            return new YAPI_YReq($resolved->result,
                YAPI::SUCCESS,
                'no error',
                $friend);
        } else {
            $pos = strpos($resolved->result, '.');
            $serial_mod = substr($resolved->result, 0, $pos);
            $friend_mod_full = YAPI::getFriendlyNameFunction("Module", $serial_mod)->result;
            $friend_mod_dot = strpos($friend_mod_full, '.');
            $friend_mod = ($friend_mod_dot ? substr($friend_mod_full, 0, $friend_mod_dot) : $friend_mod_full);
            $friend_func = substr($resolved->result, $pos + 1);
            if (isset($this->_nameByHwId[$resolved->result]) && $this->_nameByHwId[$resolved->result] != '') {
                $friend_func = $this->_nameByHwId[$resolved->result];
            }
            return new YAPI_YReq($resolved->result,
                YAPI::SUCCESS,
                'no error',
                $friend_mod . '.' . $friend_func);
        }
    }

    // Retrieve a function object by hardware id, updating the indexes on the fly if needed
    public function setFunction(string $str_func, YFunction $obj_func): void
    {
        $funres = $this->resolve($str_func);
        if ($funres->errorType == YAPI::SUCCESS) {
            // the function has been located on a device
            $this->_connectedFns[$funres->result] = $obj_func;
        } else {
            // the function is still abstract
            $this->_requestedFns[$str_func] = $obj_func;
        }
    }

    // Retrieve a function object by hardware id, updating the indexes on the fly if needed
    public function getFunction(string $str_func): ?YFunction
    {
        $funres = $this->resolve($str_func);
        if ($funres->errorType == YAPI::SUCCESS) {
            // the function has been located on a device
            if (isset($this->_connectedFns[$funres->result])) {
                return $this->_connectedFns[$funres->result];
            }

            if (isset($this->_requestedFns[$str_func])) {
                $req_fn = $this->_requestedFns[$str_func];
                $this->_connectedFns[$funres->result] = $req_fn;
                unset($this->_requestedFns[$str_func]);
                return $req_fn;
            }
        } else {
            // the function is still abstract
            if (isset($this->_requestedFns[$str_func])) {
                return $this->_requestedFns[$str_func];
            }
        }
        return null;
    }

    // Stores a function advertised value by hardware id, queue an event if needed
    public function setFunctionValue(string $str_hwid, string $str_pubval): void
    {
        if (isset($this->_valueByHwId[$str_hwid]) &&
            $this->_valueByHwId[$str_hwid] == $str_pubval) {
            return;
        }
        $this->_valueByHwId[$str_hwid] = $str_pubval;
        foreach (YFunction::$_ValueCallbackList as $fun) {
            $hwId = $fun->_getHwId();
            if (!$hwId) {
                continue;
            }
            if ($hwId == $str_hwid) {
                YAPI::addValueEvent($fun, $str_pubval);
            }
        }
    }

    // Retrieve a function advertised value by hardware id
    public function getFunctionValue(string $str_hwid): string
    {
        return $this->_valueByHwId[$str_hwid];
    }

    // Stores a function advertised value by hardware id, queue an event if needed
    public function setTimedReport(string $str_hwid, float $float_timestamp, float $float_duration, array $arr_report): void
    {
        foreach (YFunction::$_TimedReportCallbackList as $fun) {
            $hwId = $fun->_getHwId();
            if (!$hwId) {
                continue;
            }
            if ($hwId == $str_hwid) {
                YAPI::addTimedReportEvent($fun, $float_timestamp, $float_duration, $arr_report);
            }
        }
    }

    // Return the basetype of this function class
    public function getBaseType(): int
    {
        return $this->_baseType;
    }

    public function matchBaseType(int $baseType): bool
    {
        if ($baseType == 0) {
            return true;
        }
        return $this->_baseType == $baseType;
    }

    // Find the hardwareId of the first instance of a given function class
    public function getFirstHardwareId(): ?string
    {
        foreach (array_keys($this->_valueByHwId) as $res) {
            return $res;
        }
        return null;
    }

    // Find the hardwareId for the next instance of a given function class
    public function getNextHardwareId(string $str_hwid): ?string
    {
        foreach (array_keys($this->_valueByHwId) as $iter_hwid) {
            if ($str_hwid == "!") {
                return $iter_hwid;
            }
            if ($str_hwid == $iter_hwid) {
                $str_hwid = "!";
            }
        }
        return null; // no more instance found
    }
}

