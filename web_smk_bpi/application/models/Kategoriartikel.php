<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategoriartikel extends CI_Model {
	function __construct(){
		parent:: __construct();
	}
	
	function pilih_data_kategoriartikel(){
		$this->db->select('*')
				 ->from('kategori_artikel');
		return $this->db->get();
	}
	
	function pilih_kategoriartikel(){
		$this->db->select('*');
		$this->db->from('kategori_artikel');
		return $this->db->get();
	}
	
	function cari_kategoriartikel($kategori){
		$this->db->select('*');
		$this->db->from('kategori_artikel')
				 ->where('kategori_artikel',$kategori);
		return $this->db->get();
	}
	
	function masuk_data_kategoriartikel($data){
		$this->db->insert('kategori_artikel', $data);
	}
	
	function pilih_id_kategoriartikel($id_kategoriartikel){
		$this->db->select('*');
		$this->db->from('kategori_artikel');
		$this->db->where('id_kategori_artikel', $id_kategoriartikel);
		return $this->db->get();
	}
	
	function update_data($id,$data){
		$this->db->where('id_kategori_artikel', $id);
		$this->db->update('kategori_artikel', $data);
	}
	
	function hapus($id_kategoriartikel){
		$this->db->where('id_kategori_artikel', $id_kategoriartikel);
		$this->db->delete('kategori_artikel');
	}
	
	function show_artikel(){
		$query=$this -> db -> query("select * from artikel order by tgl_posting desc limit 3");
		return $query;
	}
	
	function artikel_full($id){
		$this->db->select('*');
		$this->db->from('artikel, user');
		$this->db->where('artikel.id_user=user.id_user');
		$this->db->where('id_artikel', $id);
		return $this->db->get();
	}
	
	function list_artikel(){
		$query=$this -> db -> query("select * from artikel order by tgl_posting");
		return $query;
	}
	
	function show_berita(){
		$query=$this -> db -> query("select * from berita order by tgl_posting desc limit 3");
		return $query;
	}
	
	function show_bursa_kerja(){
		$query=$this -> db -> query("select * from bursa_kerja order by tgl_posting desc limit 5");
		return $query;
	}
	
	function list_berita(){
		$query=$this -> db -> query("select * from berita order by tgl_posting");
		return $query;
	}
	
	function list_bursa_kerja(){
		$query=$this -> db -> query("select * from bursa_kerja order by tgl_posting");
		return $query;
	}
	
	function berita_full($id){
		$this->db->select('*');
		$this->db->from('berita, user');
		$this->db->where('berita.id_user=user.id_user');
		$this->db->where('id_berita', $id);
		return $this->db->get();
	}
	
	function bursa_kerja_full($id){
		$this->db->select('*');
		$this->db->from('bursa_kerja');
		$this->db->where('id_bursa_kerja', $id);
		return $this->db->get();
	}
	
	function paging_list_berita($limit=array()){
		$this->db->select('*');
		$this->db->from('berita');
		$this->db->order_by('tgl_posting','desc');
		
		if($limit!=NULL){
			$this -> db -> limit($limit['perpage'],$limit['offset']);
		}
		
		return $this -> db -> get();
	}
	
	function paging_list_artikel($limit=array()){
		$this->db->select('*');
		$this->db->from('artikel');
		$this->db->order_by('tgl_posting','desc');
		
		if($limit!=NULL){
			$this -> db -> limit($limit['perpage'],$limit['offset']);
		}
		
		return $this -> db -> get();
	}
	
	function paging_list_bursa_kerja($limit=array()){
		$this->db->select('*');
		$this->db->from('bursa_kerja');
		$this->db->order_by('tgl_posting','desc');
		
		if($limit!=NULL){
			$this -> db -> limit($limit['perpage'],$limit['offset']);
		}
		
		return $this -> db -> get();
	}
	
	function slide_artikel(){
		$query=$this -> db -> query("select * from artikel order by tgl_posting desc limit 1");
		return $query;
	}
	
	function slide_berita(){
		$query=$this -> db -> query("select * from berita order by tgl_posting desc limit 1");
		return $query;
	}
	
	function list_infoppdb(){
		$query=$this -> db -> query("select * from info_ppdb order by tgl_posting");
		return $query;
	}
	
	function paging_list_infoppdb($limit=array()){
		$this->db->select('*');
		$this->db->from('info_ppdb');
		$this->db->order_by('tgl_posting','desc');
		
		if($limit!=NULL){
			$this -> db -> limit($limit['perpage'],$limit['offset']);
		}
		
		return $this -> db -> get();
	}
	
}
