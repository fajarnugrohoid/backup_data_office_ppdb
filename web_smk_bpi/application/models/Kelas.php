<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas extends CI_Model {
	function __construct(){
		parent:: __construct();
	}
	
	function pilih_data_kelas(){
		$this->db->select('kelas.id_kelas, kelas.kelas, guru.nama_guru, jurusan.jurusan')
				 ->from('kelas, guru, jurusan')
				 ->where('kelas.id_jurusan = jurusan.id_jurusan')
				 ->where('kelas.id_wali_kelas = guru.id_guru');
		return $this->db->get();
	}
	
	function pilih_kelas(){
		$this->db->select('*');
		$this->db->from('kelas');
		return $this->db->get();
	}
	
	function masuk_data_kelas($data){
		$this->db->insert('kelas', $data);
	}
	
	function pilih_id_kelas($id_kelas){
		$this->db->select('*');
		$this->db->from('kelas');
		$this->db->where('id_kelas', $id_kelas);
		return $this->db->get();
	}
	
	function update_data($id,$data){
		$this->db->where('id_kelas', $id);
		$this->db->update('kelas', $data);
	}
	
	function hapus($id_kelas){
		$this->db->where('id_kelas', $id_kelas);
		$this->db->delete('kelas');
	}
}
