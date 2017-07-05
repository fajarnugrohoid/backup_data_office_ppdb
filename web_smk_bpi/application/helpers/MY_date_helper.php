<?php

	if(!defined('BASEPATH')) exit('No direct script access allowed');
	
	function namabulan($nobulan = " "){
		$bulan = array(
					"01" => "Januari",
					"02" => "Februari",
					"03" => "Maret",
					"04" => "April",
					"05" => "Mei",
					"06" => "Juni",
					"07" => "Juli",
					"08" => "Agustus",
					"09" => "September",
					"10" => "Oktober",
					"11" => "November",
					"12" => "Desember"
				);
		
		$anobulan = array_keys($bulan);
		$retval = (in_array($nobulan, $anobulan))?$bulan[$nobulan]:false;
		
		return $retval;
	}
	
	function namahari($nohari = -1){
		$hari = array(
					"Minggu",
					"Senin",
					"Selasa",
					"Rabu",
					"Kamis",
					"Jum'at",
					"Sabtu"
				);
				
		$retval = (($nohari > 0) && ($nohari<=6))?$hari[$nohari]:false;
		
		return $retval;
	}
	
	function f_selisih_tgl ($tgl1, $tgl2){
		$pecah1 = explode("-", $tgl1);
		$day1 = $pecah1[2];
		$month1 = $pecah1[1];
		$year1 = $pecah1[0];
		
		$pecah2 = explode("-", $tgl2);
		$day2 = $pecah2[2];
		$month2 = $pecah2[1];
		$year2 = $pecah2[0];
		
		$jd1 = GregorianToJD($month1, $day1, $year1);
		$jd2 = GregorianToJD($month2, $day2, $year2);
		
		return $jd2-$jd1;
	}
	
?>