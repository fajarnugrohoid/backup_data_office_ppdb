<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Galeri extends CI_Model {
	function __construct(){
		parent:: __construct();
		$this -> load -> database();
	}
	
	function pilih_data_galeri(){
		$this->db->select('*')
				 ->from('galeri, kategori_artikel')
				 ->where('galeri.id_kategori = kategori_artikel.id_kategori_artikel')
				 ->order_by('tgl_posting',"desc");
		return $this->db->get();
	}
	
	function pilih_user_galeri($username){
		$this->db->select('*')
				 ->from('galeri')
				 ->where('username', $username);
		return $this->db->get();
	}
	
	function masuk_data_galeri($data){
		$this->db->insert('galeri', $data);
	}
	
	function pilih_id_galeri($id_galeri){
		$this->db->select('*');
		$this->db->from('galeri');
		$this->db->where('id_galeri', $id_galeri);
		return $this->db->get();
	}
	
	function update_data($id,$data){
		$this->db->where('id_galeri', $id);
		$this->db->update('galeri', $data);
	}
	
	function hapus($id_galeri){
		$this->db->where('id_galeri', $id_galeri);
		$this->db->delete('galeri');
	}
	
	function pilih_galeri(){
		$this->db->select('*');
		$this->db->from('galeri');
		return $this->db->get();
	}
	
	function cek_id_galeri(){
		$this->db->select('*')
				 ->from('galeri')
				 ->order_by('id_galeri',"desc");
		return $this->db->get();
	}
	
	function select_all_paging_galeri($limit=array()){
		$this->db->select('*')
				 ->from('galeri, kategori_artikel')
				 ->where('galeri.id_kategori = kategori_artikel.id_kategori_artikel');
		$this->db->order_by('galeri.tgl_posting','desc');
		
		if($limit!=NULL){
			$this -> db -> limit($limit['perpage'],$limit['offset']);
		}
		
		return $this -> db -> get();
	}
}