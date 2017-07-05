<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profiljurusan extends CI_Model {
	function __construct(){
		parent:: __construct();
	}
	
	function pilih_data_profiljurusan($limit=array()){
		$this->db->select('*')
				 ->from('profil_jurusan, kepegawaian, jabatan')
				 ->where('profil_jurusan.ketua_jurusan=kepegawaian.id_pegawai')
				 ->where('kepegawaian.id_jabatan=jabatan.id_jabatan')
				 ->order_by('jabatan.status', "desc");
				 
		if($limit!=NULL){
			$this->db->limit($limit['perpage'],$limit['offset']);
		}
		
		return $this->db->get();
	}
	
	function pilih_profiljurusan(){
		$this->db->select('*');
		$this->db->from('profil_jurusan');
		return $this->db->get();
	}
	
	function masuk_data_profiljurusan($data){
		$this->db->insert('profil_jurusan', $data);
	}
	
	function pilih_id_profiljurusan($id_profiljurusan){
		$this->db->select('*')
				 ->from('profil_jurusan, kepegawaian')
				 ->where('profil_jurusan.ketua_jurusan=kepegawaian.id_pegawai');
		$this->db->where('id_jurusan', $id_profiljurusan);
		return $this->db->get();
	}
	
	function update_data($id,$data){
		$this->db->where('id_jurusan', $id);
		$this->db->update('profil_jurusan', $data);
	}
	
	function hapus($id_profiljurusan){
		$this->db->where('id_jurusan', $id_profiljurusan);
		$this->db->delete('profil_jurusan');
	}
	
	function cek_id_profiljurusan(){
		$this->db->select("*")
				 ->from("profil_jurusan")
				 ->order_by('id_jurusan',"desc");
		return $this->db->get();
	}
}
