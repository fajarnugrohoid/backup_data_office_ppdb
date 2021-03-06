<?php
require 'InitializationData.php';
// base class with member properties and methods
class ProcessSelection extends InitializationData
{

    public $initializationData;
    private $arrResultFunc=[];
    public $classConnection;
    public $conn;
    //var $listsekolah = [];

    public function __construct()
    {
        $this->initializationData = new InitializationData;
        $this->classConnection  = new Database;
        $this->conn             = $this->classConnection->connect();
    }

    public function sorting(&$arr, $col_total, $col_total2, $col_n1, $col_n2, $col_n3, $col_n4, $col_skorjarak, $col_range)
    {
        $sort_col_total     = array();
        $sort_col_total2    = array();
        $sort_col_n1        = array();
        $sort_col_n2        = array();
        $sort_col_n3        = array();
        $sort_col_n4        = array();
        $sort_col_skorjarak = array();
        $sort_col_range = array();

        foreach ($arr as $key => $row) {
            $sort_col_total[$key]     = $row[$col_total];
            $sort_col_total2[$key]    = $row[$col_total2];
            $sort_col_n1[$key]        = $row[$col_n1];
            $sort_col_n2[$key]        = $row[$col_n2];
            $sort_col_n3[$key]        = $row[$col_n3];
            $sort_col_n4[$key]        = $row[$col_n4];
            $sort_col_skorjarak[$key] = $row[$col_skorjarak];
            $sort_col_range[$key] = $row[$col_range];
        }
        array_multisort($sort_col_total, SORT_DESC, $sort_col_total2, SORT_DESC, $sort_col_n1, SORT_DESC, $sort_col_n2, SORT_DESC, $sort_col_n3, SORT_DESC, $sort_col_n4, SORT_DESC, $sort_col_skorjarak, SORT_DESC, $sort_col_range, SORT_ASC,$arr);
    }

    public function simple_sorting(&$arr, $col_total)
    {
        $sort_col_total = array();
        foreach ($arr as $key => $row) {
            $sort_col_total[$key] = $row[$col_total];
        }
        array_multisort($sort_col_total, SORT_DESC, $arr);
    }

    

    public function resultSelection(){
        $listsekolah = [];
        $listsekolah = $this->reSelection();
        return $listsekolah;
    }

} // end of class Vegetable
