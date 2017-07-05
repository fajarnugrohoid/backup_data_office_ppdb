<?php
	class Adminmodel extends CI_Model{
		function __construct(){
			parent::__construct();
			$this -> load -> database();
		}
		
		function check_user_account($username, $password){
			$this -> db -> select('*');
			$this -> db -> from('pengguna');
			$this -> db -> where('username', $username);
			$this -> db -> where('password', $password);
			
			return $this -> db -> get();
		}
	
		function cek_id_berita(){
			$this->db->select('*')
				 ->from('berita')
				 ->order_by('id_berita',"desc");
		return $this->db->get();
		}
		
		function cek_id_artikel(){
			$this->db->select('*')
				 ->from('artikel')
				 ->order_by('id_artikel',"desc");
		return $this->db->get();
		}
		
		function cek_id_bursa_kerja(){
			$this->db->select('*')
				 ->from('bursa_kerja')
				 ->order_by('id_bursa_kerja',"desc");
		return $this->db->get();
		}
		
		function select_all_berita($limit=array()){
			$this -> db -> select('*');
			$this -> db -> from('berita, user');
			$this -> db -> where('berita.id_user = user.id_user')
						-> order_by('berita.tgl_posting', "desc");
						
			if($limit!=NULL){
				$this->db->limit($limit['perpage'],$limit['offset']);
			}
			return $this -> db -> get();
		}
		
		function insert_berita($data){
			$this -> db -> insert('berita',$data);
		}
		
		function select_detail_berita($id_berita){
			$this -> db -> select('*');
			$this -> db -> from('berita,user');
			$this -> db -> where('id_berita', $id_berita);
			$this -> db -> where('berita.id_user = user.id_user');
			
			return $this -> db -> get();
		}
		
		function delete_berita($id_berita){
			$this -> db -> where('id_berita',$id_berita);
			$this -> db -> delete('berita');
		}
		
		function update_berita($id_berita,$data){
			$this -> db -> where('id_berita',$id_berita);
			$this -> db -> update('berita',$data);
		}
		
		function select_all_artikel($limit=array()){
			$this -> db -> select('*');
			$this -> db -> from('artikel, user');
			$this -> db -> where('artikel.id_user = user.id_user')
						-> order_by('artikel.tgl_posting', "desc");
			if($limit!=NULL){
				$this->db->limit($limit['perpage'],$limit['offset']);
			}
			return $this -> db -> get();
		}
		
		function insert_artikel($data){
			$this -> db -> insert('artikel',$data);
		}
		
		function select_detail_artikel($id_artikel){
			$this -> db -> select('*');
			$this -> db -> from('artikel,user,kategori_artikel');
			$this -> db -> where('id_artikel', $id_artikel);
			$this -> db -> where('artikel.id_user = user.id_user');
			$this -> db -> where('artikel.id_kategori = kategori_artikel.id_kategori_artikel');
			
			return $this -> db -> get();
		}
		
		function delete_artikel($id_artikel){
			$this -> db -> where('id_artikel',$id_artikel);
			$this -> db -> delete('artikel');
		}
		
		function update_artikel($id_artikel,$data){
			$this -> db -> where('id_artikel',$id_artikel);
			$this -> db -> update('artikel',$data);
		}
		
		function select_all_bursa_kerja($limit=array()){
			$this -> db -> select('*');
			$this -> db -> from('bursa_kerja');
			$this -> db -> order_by('bursa_kerja.tgl_posting', "desc");
			if($limit!=NULL){
				$this->db->limit($limit['perpage'],$limit['offset']);
			}
			return $this -> db -> get();
		}
		
		function insert_bursa_kerja($data){
			$this -> db -> insert('bursa_kerja',$data);
		}
		
		function select_detail_bursa_kerja($id_bursa_kerja){
			$this -> db -> select('*');
			$this -> db -> from('bursa_kerja');
			$this -> db -> where('id_bursa_kerja', $id_bursa_kerja);
			
			return $this -> db -> get();
		}
		
		function delete_bursa_kerja($id_bursa_kerja){
			$this -> db -> where('id_bursa_kerja',$id_bursa_kerja);
			$this -> db -> delete('bursa_kerja');
		}
		
		function update_bursa_kerja($id_bursa_kerja,$data){
			$this -> db -> where('id_bursa_kerja',$id_bursa_kerja);
			$this -> db -> update('bursa_kerja',$data);
		}
}
?>