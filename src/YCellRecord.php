<?php
namespace Yoctopuce\YoctoAPI;

/**
 * YCellRecord Class: Cellular antenna description, returned by cellular.quickCellSurvey method
 *
 * YCellRecord objects are used to describe a wireless network.
 * These objects are used in particular in conjunction with the
 * YCellular class.
 */
class YCellRecord
{
    //--- (end of generated code: YCellRecord declaration)

    //--- (generated code: YCellRecord attributes)
    protected string $_oper = "";                           // str
    protected int $_mcc = 0;                            // int
    protected int $_mnc = 0;                            // int
    protected int $_lac = 0;                            // int
    protected int $_cid = 0;                            // int
    protected int $_dbm = 0;                            // int
    protected int $_tad = 0;                            // int

    //--- (end of generated code: YCellRecord attributes)

    function __construct($int_mcc, $int_mnc, $int_lac, $int_cellId, $int_dbm, $int_tad, $str_oper)
    {
        //--- (generated code: YCellRecord constructor)
        //--- (end of generated code: YCellRecord constructor)
        $this->_oper = $str_oper;
        $this->_mcc = $int_mcc;
        $this->_mnc = $int_mnc;
        $this->_lac = $int_lac;
        $this->_cid = $int_cellId;
        $this->_dbm = $int_dbm;
        $this->_tad = $int_tad;
    }

    //--- (generated code: YCellRecord implementation)

    /**
     * Returns the name of the the cell operator, as received from the network.
     *
     * @return string  a string with the name of the the cell operator.
     */
    public function get_cellOperator(): string
    {
        return $this->_oper;
    }

    /**
     * Returns the Mobile Country Code (MCC). The MCC is a unique identifier for each country.
     *
     * @return int  an integer corresponding to the Mobile Country Code (MCC).
     */
    public function get_mobileCountryCode(): int
    {
        return $this->_mcc;
    }

    /**
     * Returns the Mobile Network Code (MNC). The MNC is a unique identifier for each phone
     * operator within a country.
     *
     * @return int  an integer corresponding to the Mobile Network Code (MNC).
     */
    public function get_mobileNetworkCode(): int
    {
        return $this->_mnc;
    }

    /**
     * Returns the Location Area Code (LAC). The LAC is a unique identifier for each
     * place within a country.
     *
     * @return int  an integer corresponding to the Location Area Code (LAC).
     */
    public function get_locationAreaCode(): int
    {
        return $this->_lac;
    }

    /**
     * Returns the Cell ID. The Cell ID is a unique identifier for each
     * base transmission station within a LAC.
     *
     * @return int  an integer corresponding to the Cell Id.
     */
    public function get_cellId(): int
    {
        return $this->_cid;
    }

    /**
     * Returns the signal strength, measured in dBm.
     *
     * @return int  an integer corresponding to the signal strength.
     */
    public function get_signalStrength(): int
    {
        return $this->_dbm;
    }

    /**
     * Returns the Timing Advance (TA). The TA corresponds to the time necessary
     * for the signal to reach the base station from the device.
     * Each increment corresponds about to 550m of distance.
     *
     * @return int  an integer corresponding to the Timing Advance (TA).
     */
    public function get_timingAdvance(): int
    {
        return $this->_tad;
    }

    //--- (end of generated code: YCellRecord implementation)

};
