<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Silabus extends CI_Model {
	function __construct(){
		parent:: __construct();
	}
	
	function pilih_data_silabus($limit=array()){
		$this->db->select('*')
				 ->from('silabus')
				 ->order_by('tgl_posting',"desc")
				 ->order_by('tahun_berlaku',"asc");
		if($limit!=NULL){
			$this->db->limit($limit['perpage'],$limit['offset']);
		}
		return $this->db->get();
	}
	
	function masuk_data_silabus($data){
		$this->db->insert('silabus', $data);
	}
	
	function pilih_id_silabus($id_silabus){
		$this->db->select('*');
		$this->db->from('silabus');
		$this->db->where('id_silabus', $id_silabus);
		return $this->db->get();
	}
	
	function update_data($id,$data){
		$this->db->where('id_silabus', $id);
		$this->db->update('silabus', $data);
	}
	
	function hapus($id_silabus){
		$this->db->where('id_silabus', $id_silabus);
		$this->db->delete('silabus');
	}
	
	function cek_id_silabus(){
		$this->db->select('*')
				 ->from('silabus')
				 ->order_by('id_silabus',"desc");
		return $this->db->get();
	}
	
	function pilih_silabus(){
		$this->db->select('*');
		$this->db->from('silabus');
		return $this->db->get();
	}
}