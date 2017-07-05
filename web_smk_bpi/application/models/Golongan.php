<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Golongan extends CI_Model {
	function __construct(){
		parent:: __construct();
	}
	
	function pilih_data_golongan(){
		$this->db->select('*')
				 ->from('golongan');
		return $this->db->get();
	}
	
	function pilih_golongan(){
		$this->db->select('*');
		$this->db->from('golongan');
		return $this->db->get();
	}
	
	function masuk_data_golongan($data){
		$this->db->insert('golongan', $data);
	}
	
	function pilih_id_golongan($id_golongan){
		$this->db->select('*');
		$this->db->from('golongan');
		$this->db->where('id_golongan', $id_golongan);
		return $this->db->get();
	}
	
	function update_data($id,$data){
		$this->db->where('id_golongan', $id);
		$this->db->update('golongan', $data);
	}
	
	function hapus($id_golongan){
		$this->db->where('id_golongan', $id_golongan);
		$this->db->delete('golongan');
	}
}
