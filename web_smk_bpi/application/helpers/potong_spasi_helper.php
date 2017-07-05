<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('potong_spasi')){
	function potong_spasi($teks){
		$teks = trim($teks);
		 while (strpos($teks, ' ')) {//PERULANGAN SPASI (perulangan tidak dibatasi)
			$teks = str_replace(' ', '', $teks);//str_replace (fungsi mengganti string)
		}
	return $teks;
	}
}