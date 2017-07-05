<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Infoppdb extends CI_Model {
	function __construct(){
		parent:: __construct();
	}
	
	function pilih_data_infoppdb(){
		$this->db->select('*')
				 ->from('info_ppdb, user')
				 ->where('info_ppdb.id_user = user.id_user')
				 ->order_by('info_ppdb.tgl_posting', "desc");
		return $this->db->get();
	}
	
	function pilih_infoppdb(){
		$this->db->select('*');
		$this->db->from('info_ppdb')
				 ->order_by('tgl_posting', "desc");
		return $this->db->get();
	}
	
	function cek_id_infoppdb(){
		$query=$this -> db -> query("select * from info_ppdb order by id_info_ppdb desc limit 1");
		return $query;
	}
	
	function masuk_data_infoppdb($data){
		$this->db->insert('info_ppdb', $data);
	}
	
	function pilih_id_infoppdb($id_infoppdb){
		$this->db->select('*');
		$this->db->from('info_ppdb');
		$this->db->where('id_info_ppdb', $id_infoppdb);
		return $this->db->get();
	}
	
	function update_data($id,$data){
		$this->db->where('id_info_ppdb', $id);
		$this->db->update('info_ppdb', $data);
	}
	
	function hapus($id_infoppdb){
		$this->db->where('id_info_ppdb', $id_infoppdb);
		$this->db->delete('info_ppdb');
	}
	
	function slide_infoppdb(){
		$query=$this -> db -> query("select * from info_ppdb order by tgl_posting desc limit 1");
		return $query;
	}
}