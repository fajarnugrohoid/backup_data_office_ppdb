<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unitkerja extends CI_Model {
	function __construct(){
		parent:: __construct();
	}
	
	function pilih_data_unitkerja($limit=array()){
		$this->db->select('*')
				 ->from('profil_unit_kerja')
				 ->order_by('unit_kerja',"asc");
				 
		if($limit!=NULL){
			$this->db->limit($limit['perpage'],$limit['offset']);
		}
		
		return $this->db->get();
	}
	
	function pilih_unitkerja(){
		$this->db->select('*');
		$this->db->from('profil_unit_kerja');
		return $this->db->get();
	}
	
	function masuk_data_unitkerja($data){
		$this->db->insert('profil_unit_kerja', $data);
	}
	
	function pilih_id_unitkerja($id_unitkerja){
		$this->db->select('*');
		$this->db->from('profil_unit_kerja');
		$this->db->where('id_unit_kerja', $id_unitkerja);
		return $this->db->get();
	}
	
	function update_data($id,$data){
		$this->db->where('id_unit_kerja', $id);
		$this->db->update('profil_unit_kerja', $data);
	}
	
	function hapus($id_unitkerja){
		$this->db->where('id_unit_kerja', $id_unitkerja);
		$this->db->delete('profil_unit_kerja');
	}
}
