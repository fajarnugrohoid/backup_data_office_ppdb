<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Visimisi extends CI_Model {
	function __construct(){
		parent:: __construct();
	}

	function update_data($id, $data){
		$this->db->where('id_visi_misi', $id);
		$this->db->update('visi_misi', $data);
	}
	
	function pilih_visimisi(){
		$this->db->select('*');
		$this->db->from('visi_misi');
		return $this->db->get();
	}
}