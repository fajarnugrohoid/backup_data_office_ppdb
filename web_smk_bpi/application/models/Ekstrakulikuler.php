<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ekstrakulikuler extends CI_Model {
	function __construct(){
		parent:: __construct();
	}
	
	function pilih_data_ekstrakulikuler(){
		$this->db->select('*')
				 ->from('ekstrakulikuler, kepegawaian')
				 ->where('ekstrakulikuler.id_pegawai = kepegawaian.id_pegawai');
		return $this->db->get();
	}
	
	function pilih_data_ekstrakulikuler_list($limit=array()){
		$this->db->select('*')
				->from('ekstrakulikuler, kepegawaian')
				 ->where('ekstrakulikuler.id_pegawai = kepegawaian.id_pegawai');
		
		if($limit!=NULL){
			$this -> db -> limit($limit['perpage'],$limit['offset']);
		}
		
		return $this -> db -> get();
	}
	
	function pilih_ekstrakulikuler(){
		$this->db->select('*');
		$this->db->from('ekstrakulikuler');
		return $this->db->get();
	}
	
	function masuk_data_ekstrakulikuler($data){
		$this->db->insert('ekstrakulikuler', $data);
	}
	
	function pilih_id_ekstrakulikuler($id_ekstrakulikuler){
		$this->db->select('*');
		$this->db->from('ekstrakulikuler');
		$this->db->where('id_ekstrakulikuler', $id_ekstrakulikuler);
		return $this->db->get();
	}
	
	function update_data($id,$data){
		$this->db->where('id_ekstrakulikuler', $id);
		$this->db->update('ekstrakulikuler', $data);
	}
	
	function hapus($id_ekstrakulikuler){
		$this->db->where('id_ekstrakulikuler', $id_ekstrakulikuler);
		$this->db->delete('ekstrakulikuler');
	}
}
