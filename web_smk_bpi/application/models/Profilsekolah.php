<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profilsekolah extends CI_Model {
	function __construct(){
		parent:: __construct();
	}

	function update_data($id, $data){
		$this->db->where('id_sekolah', $id);
		$this->db->update('profil_sekolah', $data);
	}
	
	function pilih_profilsekolah(){
		$this->db->select('*');
		$this->db->from('profil_sekolah');
		return $this->db->get();
	}
}