<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YGps Class: Geolocalization control interface (GPS, GNSS, ...), available for instance in the Yocto-GPS-V2
 *
 * The YGps class allows you to retrieve positioning
 * data from a GPS/GNSS sensor. This class can provides
 * complete positioning information. However, if you
 * wish to define callbacks on position changes or record
 * the position in the datalogger, you
 * should use the YLatitude et YLongitude classes.
 */
class YGps extends YFunction
{
    const ISFIXED_FALSE = 0;
    const ISFIXED_TRUE = 1;
    const ISFIXED_INVALID = -1;
    const SATCOUNT_INVALID = YAPI::INVALID_LONG;
    const SATPERCONST_INVALID = YAPI::INVALID_LONG;
    const GPSREFRESHRATE_INVALID = YAPI::INVALID_DOUBLE;
    const COORDSYSTEM_GPS_DMS = 0;
    const COORDSYSTEM_GPS_DM = 1;
    const COORDSYSTEM_GPS_D = 2;
    const COORDSYSTEM_INVALID = -1;
    const CONSTELLATION_GNSS = 0;
    const CONSTELLATION_GPS = 1;
    const CONSTELLATION_GLONASS = 2;
    const CONSTELLATION_GALILEO = 3;
    const CONSTELLATION_GPS_GLONASS = 4;
    const CONSTELLATION_GPS_GALILEO = 5;
    const CONSTELLATION_GLONASS_GALILEO = 6;
    const CONSTELLATION_INVALID = -1;
    const LATITUDE_INVALID = YAPI::INVALID_STRING;
    const LONGITUDE_INVALID = YAPI::INVALID_STRING;
    const DILUTION_INVALID = YAPI::INVALID_DOUBLE;
    const ALTITUDE_INVALID = YAPI::INVALID_DOUBLE;
    const GROUNDSPEED_INVALID = YAPI::INVALID_DOUBLE;
    const DIRECTION_INVALID = YAPI::INVALID_DOUBLE;
    const UNIXTIME_INVALID = YAPI::INVALID_LONG;
    const DATETIME_INVALID = YAPI::INVALID_STRING;
    const UTCOFFSET_INVALID = YAPI::INVALID_INT;
    const COMMAND_INVALID = YAPI::INVALID_STRING;
    //--- (end of YGps declaration)

    //--- (YGps attributes)
    protected int $_isFixed = self::ISFIXED_INVALID;        // Bool
    protected float $_satCount = self::SATCOUNT_INVALID;       // UInt
    protected float $_satPerConst = self::SATPERCONST_INVALID;    // UInt
    protected float $_gpsRefreshRate = self::GPSREFRESHRATE_INVALID; // MeasureVal
    protected int $_coordSystem = self::COORDSYSTEM_INVALID;    // GPSCoordinateSystem
    protected int $_constellation = self::CONSTELLATION_INVALID;  // GPSConstellation
    protected string $_latitude = self::LATITUDE_INVALID;       // Text
    protected string $_longitude = self::LONGITUDE_INVALID;      // Text
    protected float $_dilution = self::DILUTION_INVALID;       // MeasureVal
    protected float $_altitude = self::ALTITUDE_INVALID;       // MeasureVal
    protected float $_groundSpeed = self::GROUNDSPEED_INVALID;    // MeasureVal
    protected float $_direction = self::DIRECTION_INVALID;      // MeasureVal
    protected float $_unixTime = self::UNIXTIME_INVALID;       // UTCTime
    protected string $_dateTime = self::DATETIME_INVALID;       // Text
    protected int $_utcOffset = self::UTCOFFSET_INVALID;      // Int
    protected string $_command = self::COMMAND_INVALID;        // Text

    //--- (end of YGps attributes)

    function __construct(string $str_func)
    {
        //--- (YGps constructor)
        parent::__construct($str_func);
        $this->_className = 'Gps';

        //--- (end of YGps constructor)
    }

    //--- (YGps implementation)

    function _parseAttr(string $name, mixed $val): int
    {
        switch ($name) {
        case 'isFixed':
            $this->_isFixed = intval($val);
            return 1;
        case 'satCount':
            $this->_satCount = intval($val);
            return 1;
        case 'satPerConst':
            $this->_satPerConst = intval($val);
            return 1;
        case 'gpsRefreshRate':
            $this->_gpsRefreshRate = round($val / 65.536) / 1000.0;
            return 1;
        case 'coordSystem':
            $this->_coordSystem = intval($val);
            return 1;
        case 'constellation':
            $this->_constellation = intval($val);
            return 1;
        case 'latitude':
            $this->_latitude = $val;
            return 1;
        case 'longitude':
            $this->_longitude = $val;
            return 1;
        case 'dilution':
            $this->_dilution = round($val / 65.536) / 1000.0;
            return 1;
        case 'altitude':
            $this->_altitude = round($val / 65.536) / 1000.0;
            return 1;
        case 'groundSpeed':
            $this->_groundSpeed = round($val / 65.536) / 1000.0;
            return 1;
        case 'direction':
            $this->_direction = round($val / 65.536) / 1000.0;
            return 1;
        case 'unixTime':
            $this->_unixTime = intval($val);
            return 1;
        case 'dateTime':
            $this->_dateTime = $val;
            return 1;
        case 'utcOffset':
            $this->_utcOffset = intval($val);
            return 1;
        case 'command':
            $this->_command = $val;
            return 1;
        }
        return parent::_parseAttr($name, $val);
    }

    /**
     * Returns TRUE if the receiver has found enough satellites to work.
     *
     * @return int  either YGps::ISFIXED_FALSE or YGps::ISFIXED_TRUE, according to TRUE if the receiver has
     * found enough satellites to work
     *
     * On failure, throws an exception or returns YGps::ISFIXED_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_isFixed(): int
    {
        // $res                    is a enumBOOL;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::ISFIXED_INVALID;
            }
        }
        $res = $this->_isFixed;
        return $res;
    }

    /**
     * Returns the total count of satellites used to compute GPS position.
     *
     * @return float  an integer corresponding to the total count of satellites used to compute GPS position
     *
     * On failure, throws an exception or returns YGps::SATCOUNT_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_satCount(): float
    {
        // $res                    is a long;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SATCOUNT_INVALID;
            }
        }
        $res = $this->_satCount;
        return $res;
    }

    /**
     * Returns the count of visible satellites per constellation encoded
     * on a 32 bit integer: bits 0..5: GPS satellites count,  bits 6..11 : Glonass, bits 12..17 : Galileo.
     * this value is refreshed every 5 seconds only.
     *
     * @return float  an integer corresponding to the count of visible satellites per constellation encoded
     *         on a 32 bit integer: bits 0.
     *
     * On failure, throws an exception or returns YGps::SATPERCONST_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_satPerConst(): float
    {
        // $res                    is a long;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::SATPERCONST_INVALID;
            }
        }
        $res = $this->_satPerConst;
        return $res;
    }

    /**
     * Returns effective GPS data refresh frequency.
     * this value is refreshed every 5 seconds only.
     *
     * @return float  a floating point number corresponding to effective GPS data refresh frequency
     *
     * On failure, throws an exception or returns YGps::GPSREFRESHRATE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_gpsRefreshRate(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::GPSREFRESHRATE_INVALID;
            }
        }
        $res = $this->_gpsRefreshRate;
        return $res;
    }

    /**
     * Returns the representation system used for positioning data.
     *
     * @return int  a value among YGps::COORDSYSTEM_GPS_DMS, YGps::COORDSYSTEM_GPS_DM and
     * YGps::COORDSYSTEM_GPS_D corresponding to the representation system used for positioning data
     *
     * On failure, throws an exception or returns YGps::COORDSYSTEM_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_coordSystem(): int
    {
        // $res                    is a enumGPSCOORDINATESYSTEM;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::COORDSYSTEM_INVALID;
            }
        }
        $res = $this->_coordSystem;
        return $res;
    }

    /**
     * Changes the representation system used for positioning data.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param int $newval : a value among YGps::COORDSYSTEM_GPS_DMS, YGps::COORDSYSTEM_GPS_DM and
     * YGps::COORDSYSTEM_GPS_D corresponding to the representation system used for positioning data
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_coordSystem(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("coordSystem", $rest_val);
    }

    /**
     * Returns the the satellites constellation used to compute
     * positioning data.
     *
     * @return int  a value among YGps::CONSTELLATION_GNSS, YGps::CONSTELLATION_GPS,
     * YGps::CONSTELLATION_GLONASS, YGps::CONSTELLATION_GALILEO, YGps::CONSTELLATION_GPS_GLONASS,
     * YGps::CONSTELLATION_GPS_GALILEO and YGps::CONSTELLATION_GLONASS_GALILEO corresponding to the the
     * satellites constellation used to compute
     *         positioning data
     *
     * On failure, throws an exception or returns YGps::CONSTELLATION_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_constellation(): int
    {
        // $res                    is a enumGPSCONSTELLATION;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::CONSTELLATION_INVALID;
            }
        }
        $res = $this->_constellation;
        return $res;
    }

    /**
     * Changes the satellites constellation used to compute
     * positioning data. Possible  constellations are GNSS ( = all supported constellations),
     * GPS, Glonass, Galileo , and the 3 possible pairs. This setting has  no effect on Yocto-GPS (V1).
     *
     * @param int $newval : a value among YGps::CONSTELLATION_GNSS, YGps::CONSTELLATION_GPS,
     * YGps::CONSTELLATION_GLONASS, YGps::CONSTELLATION_GALILEO, YGps::CONSTELLATION_GPS_GLONASS,
     * YGps::CONSTELLATION_GPS_GALILEO and YGps::CONSTELLATION_GLONASS_GALILEO corresponding to the
     * satellites constellation used to compute
     *         positioning data
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_constellation(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("constellation", $rest_val);
    }

    /**
     * Returns the current latitude.
     *
     * @return string  a string corresponding to the current latitude
     *
     * On failure, throws an exception or returns YGps::LATITUDE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_latitude(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LATITUDE_INVALID;
            }
        }
        $res = $this->_latitude;
        return $res;
    }

    /**
     * Returns the current longitude.
     *
     * @return string  a string corresponding to the current longitude
     *
     * On failure, throws an exception or returns YGps::LONGITUDE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_longitude(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::LONGITUDE_INVALID;
            }
        }
        $res = $this->_longitude;
        return $res;
    }

    /**
     * Returns the current horizontal dilution of precision,
     * the smaller that number is, the better .
     *
     * @return float  a floating point number corresponding to the current horizontal dilution of precision,
     *         the smaller that number is, the better
     *
     * On failure, throws an exception or returns YGps::DILUTION_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_dilution(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DILUTION_INVALID;
            }
        }
        $res = $this->_dilution;
        return $res;
    }

    /**
     * Returns the current altitude. Beware:  GPS technology
     * is very inaccurate regarding altitude.
     *
     * @return float  a floating point number corresponding to the current altitude
     *
     * On failure, throws an exception or returns YGps::ALTITUDE_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_altitude(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::ALTITUDE_INVALID;
            }
        }
        $res = $this->_altitude;
        return $res;
    }

    /**
     * Returns the current ground speed in Km/h.
     *
     * @return float  a floating point number corresponding to the current ground speed in Km/h
     *
     * On failure, throws an exception or returns YGps::GROUNDSPEED_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_groundSpeed(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::GROUNDSPEED_INVALID;
            }
        }
        $res = $this->_groundSpeed;
        return $res;
    }

    /**
     * Returns the current move bearing in degrees, zero
     * is the true (geographic) north.
     *
     * @return float  a floating point number corresponding to the current move bearing in degrees, zero
     *         is the true (geographic) north
     *
     * On failure, throws an exception or returns YGps::DIRECTION_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_direction(): float
    {
        // $res                    is a double;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DIRECTION_INVALID;
            }
        }
        $res = $this->_direction;
        return $res;
    }

    /**
     * Returns the current time in Unix format (number of
     * seconds elapsed since Jan 1st, 1970).
     *
     * @return float  an integer corresponding to the current time in Unix format (number of
     *         seconds elapsed since Jan 1st, 1970)
     *
     * On failure, throws an exception or returns YGps::UNIXTIME_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_unixTime(): float
    {
        // $res                    is a long;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::UNIXTIME_INVALID;
            }
        }
        $res = $this->_unixTime;
        return $res;
    }

    /**
     * Returns the current time in the form "YYYY/MM/DD hh:mm:ss".
     *
     * @return string  a string corresponding to the current time in the form "YYYY/MM/DD hh:mm:ss"
     *
     * On failure, throws an exception or returns YGps::DATETIME_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_dateTime(): string
    {
        // $res                    is a string;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::DATETIME_INVALID;
            }
        }
        $res = $this->_dateTime;
        return $res;
    }

    /**
     * Returns the number of seconds between current time and UTC time (time zone).
     *
     * @return int  an integer corresponding to the number of seconds between current time and UTC time (time zone)
     *
     * On failure, throws an exception or returns YGps::UTCOFFSET_INVALID.
     * @throws YAPI_Exception on error
     */
    public function get_utcOffset(): int
    {
        // $res                    is a int;
        if ($this->_cacheExpiration <= YAPI::GetTickCount()) {
            if ($this->load(YAPI::$_yapiContext->GetCacheValidity()) != YAPI::SUCCESS) {
                return self::UTCOFFSET_INVALID;
            }
        }
        $res = $this->_utcOffset;
        return $res;
    }

    /**
     * Changes the number of seconds between current time and UTC time (time zone).
     * The timezone is automatically rounded to the nearest multiple of 15 minutes.
     * If current UTC time is known, the current time is automatically be updated according to the selected time zone.
     * Remember to call the saveToFlash() method of the module if the
     * modification must be kept.
     *
     * @param int $newval : an integer corresponding to the number of seconds between current time and UTC
     * time (time zone)
     *
     * @return int  YAPI::SUCCESS if the call succeeds.
     *
     * On failure, throws an exception or returns a negative error code.
     * @throws YAPI_Exception on error
     */
    public function set_utcOffset(int $newval): int
    {
        $rest_val = strval($newval);
        return $this->_setAttr("utcOffset", $rest_val);
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
     * Retrieves a geolocalization module for a given identifier.
     * The identifier can be specified using several formats:
     * <ul>
     * <li>FunctionLogicalName</li>
     * <li>ModuleSerialNumber.FunctionIdentifier</li>
     * <li>ModuleSerialNumber.FunctionLogicalName</li>
     * <li>ModuleLogicalName.FunctionIdentifier</li>
     * <li>ModuleLogicalName.FunctionLogicalName</li>
     * </ul>
     *
     * This function does not require that the geolocalization module is online at the time
     * it is invoked. The returned object is nevertheless valid.
     * Use the method isOnline() to test if the geolocalization module is
     * indeed online at a given time. In case of ambiguity when looking for
     * a geolocalization module by logical name, no error is notified: the first instance
     * found is returned. The search is performed first by hardware name,
     * then by logical name.
     *
     * If a call to this object's is_online() method returns FALSE although
     * you are certain that the matching device is plugged, make sure that you did
     * call registerHub() at application initialization time.
     *
     * @param string $func : a string that uniquely characterizes the geolocalization module, for instance
     *         YGNSSMK2.gps.
     *
     * @return YGps  a YGps object allowing you to drive the geolocalization module.
     */
    public static function FindGps(string $func): YGps
    {
        // $obj                    is a YGps;
        $obj = YFunction::_FindFromCache('Gps', $func);
        if ($obj == null) {
            $obj = new YGps($func);
            YFunction::_AddToCache('Gps', $func, $obj);
        }
        return $obj;
    }

    /**
     * @throws YAPI_Exception
     */
    public function isFixed(): int
{
    return $this->get_isFixed();
}

    /**
     * @throws YAPI_Exception
     */
    public function satCount(): float
{
    return $this->get_satCount();
}

    /**
     * @throws YAPI_Exception
     */
    public function satPerConst(): float
{
    return $this->get_satPerConst();
}

    /**
     * @throws YAPI_Exception
     */
    public function gpsRefreshRate(): float
{
    return $this->get_gpsRefreshRate();
}

    /**
     * @throws YAPI_Exception
     */
    public function coordSystem(): int
{
    return $this->get_coordSystem();
}

    /**
     * @throws YAPI_Exception
     */
    public function setCoordSystem(int $newval): int
{
    return $this->set_coordSystem($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function constellation(): int
{
    return $this->get_constellation();
}

    /**
     * @throws YAPI_Exception
     */
    public function setConstellation(int $newval): int
{
    return $this->set_constellation($newval);
}

    /**
     * @throws YAPI_Exception
     */
    public function latitude(): string
{
    return $this->get_latitude();
}

    /**
     * @throws YAPI_Exception
     */
    public function longitude(): string
{
    return $this->get_longitude();
}

    /**
     * @throws YAPI_Exception
     */
    public function dilution(): float
{
    return $this->get_dilution();
}

    /**
     * @throws YAPI_Exception
     */
    public function altitude(): float
{
    return $this->get_altitude();
}

    /**
     * @throws YAPI_Exception
     */
    public function groundSpeed(): float
{
    return $this->get_groundSpeed();
}

    /**
     * @throws YAPI_Exception
     */
    public function direction(): float
{
    return $this->get_direction();
}

    /**
     * @throws YAPI_Exception
     */
    public function unixTime(): float
{
    return $this->get_unixTime();
}

    /**
     * @throws YAPI_Exception
     */
    public function dateTime(): string
{
    return $this->get_dateTime();
}

    /**
     * @throws YAPI_Exception
     */
    public function utcOffset(): int
{
    return $this->get_utcOffset();
}

    /**
     * @throws YAPI_Exception
     */
    public function setUtcOffset(int $newval): int
{
    return $this->set_utcOffset($newval);
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
     * Continues the enumeration of geolocalization modules started using yFirstGps().
     * Caution: You can't make any assumption about the returned geolocalization modules order.
     * If you want to find a specific a geolocalization module, use Gps.findGps()
     * and a hardwareID or a logical name.
     *
     * @return ?YGps  a pointer to a YGps object, corresponding to
     *         a geolocalization module currently online, or a null pointer
     *         if there are no more geolocalization modules to enumerate.
     */
    public function nextGps(): ?YGps
    {
        $resolve = YAPI::resolveFunction($this->_className, $this->_func);
        if ($resolve->errorType != YAPI::SUCCESS) {
            return null;
        }
        $next_hwid = YAPI::getNextHardwareId($this->_className, $resolve->result);
        if ($next_hwid == null) {
            return null;
        }
        return self::FindGps($next_hwid);
    }

    /**
     * Starts the enumeration of geolocalization modules currently accessible.
     * Use the method YGps::nextGps() to iterate on
     * next geolocalization modules.
     *
     * @return ?YGps  a pointer to a YGps object, corresponding to
     *         the first geolocalization module currently online, or a null pointer
     *         if there are none.
     */
    public static function FirstGps(): ?YGps
    {
        $next_hwid = YAPI::getFirstHardwareId('Gps');
        if ($next_hwid == null) {
            return null;
        }
        return self::FindGps($next_hwid);
    }

    //--- (end of YGps implementation)

}
