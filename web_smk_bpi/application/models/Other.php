<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Other extends CI_Model {
	function __construct(){
		parent:: __construct();
	}
	
	function pilih_data_other($limit=array()){
		$this->db->select('*')
				 ->from('other')
				 ->order_by('tgl_posting',"desc");
		if($limit!=NULL){
			$this->db->limit($limit['perpage'],$limit['offset']);
		}
		return $this->db->get();
	}
	
	function masuk_data_other($data){
		$this->db->insert('other', $data);
	}
	
	function pilih_id_other($id_other){
		$this->db->select('*');
		$this->db->from('other');
		$this->db->where('id_other', $id_other);
		return $this->db->get();
	}
	
	function update_data($id,$data){
		$this->db->where('id_other', $id);
		$this->db->update('other', $data);
	}
	
	function hapus($id_other){
		$this->db->where('id_other', $id_other);
		$this->db->delete('other');
	}
	
	function pilih_other(){
		$this->db->select('*');
		$this->db->from('other');
		return $this->db->get();
	}
	
	function cek_id_other(){
		$this->db->select('*')
				 ->from('other')
				 ->order_by('id_other',"desc");
		return $this->db->get();
	}
	
	function other_beranda(){
		$query=$this -> db -> query("select * from other order by tgl_posting desc limit 5");
		return $query;
	}
}