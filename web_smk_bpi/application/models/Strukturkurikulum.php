<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Strukturkurikulum extends CI_Model {
	function __construct(){
		parent:: __construct();
	}
	
	function pilih_data_strukturkurikulum($limit=array()){
		$this->db->select('*')
				 ->from('struktur_kurikulum, profil_jurusan')
				 ->where('struktur_kurikulum.id_jurusan = profil_jurusan.id_jurusan')
				 ->order_by('tgl_posting',"desc");
		if($limit!=NULL){
			$this->db->limit($limit['perpage'],$limit['offset']);
		}
		return $this->db->get();
	}
	
	function masuk_data_strukturkurikulum($data){
		$this->db->insert('struktur_kurikulum', $data);
	}
	
	function pilih_id_strukturkurikulum($id_strukturkurikulum){
		$this->db->select('*');
		$this->db->from('struktur_kurikulum');
		$this->db->where('id_struktur_kurikulum', $id_strukturkurikulum);
		return $this->db->get();
	}
	
	function update_data($id, $data){
		$this->db->where('id_struktur_kurikulum', $id);
		$this->db->update('struktur_kurikulum', $data);
	}
	
	function hapus($id_strukturkurikulum){
		$this->db->where('id_struktur_kurikulum', $id_strukturkurikulum);
		$this->db->delete('struktur_kurikulum');
	}
	
	function cek_id_kurikulum(){
		$this->db->select('*')
				 ->from('struktur_kurikulum')
				 ->order_by('id_struktur_kurikulum',"desc");
		return $this->db->get();
	}
	
	function pilih_strukturkurikulum(){
		$this->db->select('*');
		$this->db->from('struktur_kurikulum');
		return $this->db->get();
	}
}