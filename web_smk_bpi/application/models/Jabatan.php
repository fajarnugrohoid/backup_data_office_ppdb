<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan extends CI_Model {
	function __construct(){
		parent:: __construct();
	}
	
	function pilih_data_jabatan($limit=array()){
		$this->db->select('*')
				 ->from('jabatan')
				 ->order_by('urut', "asc");
		if($limit!=NULL){
			$this->db->limit($limit['perpage'],$limit['offset']);
		}
		return $this->db->get();
	}
	
	function cek_id(){
		$this->db->select('*')
				 ->from('jabatan')
				 ->order_by('id_jabatan', "desc")
				 ->limit(1);
		return $this->db->get();
	}
	
	function cek_id_guru(){
		$this->db->select('*')
				 ->from('jabatan')
				 ->where('jabatan = "Guru"');
		return $this->db->get();
	}
	
	function pilih_jabatan(){
		$this->db->select('*');
		$this->db->from('jabatan')
				 ->order_by('urut', "asc")
				 ->order_by('status', "desc");
		return $this->db->get();
	}
	
	function pilih_jabatan_pegawai(){
		$this->db->select('jabatan.jabatan')
				 ->from('kepegawaian,jabatan')
				 ->where('kepegawaian.id_jabatan=jabatan.id_jabatan')
				 ->where('jabatan.status=1')
				 ->order_by('jabatan.urut', "asc");
		return $this->db->get();
	}
	
	function masuk_data_jabatan($data){
		$this->db->insert('jabatan', $data);
	}
	
	function pilih_id_jabatan($id_jabatan){
		$this->db->select('*');
		$this->db->from('jabatan');
		$this->db->where('id_jabatan', $id_jabatan);
		return $this->db->get();
	}
	
	function update_data($id,$data){
		$this->db->where('id_jabatan', $id);
		$this->db->update('jabatan', $data);
	}
	
	function hapus($id_jabatan){
		$this->db->where('id_jabatan', $id_jabatan);
		$this->db->delete('jabatan');
	}
}
