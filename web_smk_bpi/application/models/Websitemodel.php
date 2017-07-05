<?php
	class Websitemodel extends CI_Model{
		function __construct(){
			parent::__construct();
			$this -> load -> database();
		}
		
		function select_berita_terbaru(){
			$query = $this -> db -> query('select * from berita where id_berita=(select max(id_berita) from berita)');
			
			return $query;
		}
		
		function select_sekilas_berita(){
			$query = $this -> db -> query('select * from berita limit 7');
			
			return $query;
		}
		
		function select_all_berita(){
			$this -> db -> select('*');
			$this -> db -> from('berita');
			
			return $this -> db -> get();
		}
		
		function select_all_paging_berita($limit=array()){
			$this -> db -> select('*');
			$this -> db -> from('berita');
			$this -> db -> order_by('tanggal','desc');
			
			if($limit!=NULL){
				$this -> db -> limit($limit['perpage'],$limit['offset']);
			}
			
			return $this -> db -> get();
		}
		
		function select_detail_berita($id){
			$this -> db -> select('*');
			$this -> db -> from('berita');
			$this -> db -> where('id_berita',$id);
			
			return $this -> db -> get();
		}
		
		function select_all_foto(){
			$this -> db -> select('*');
			$this -> db -> from('galeri');
			
			return $this -> db -> get();
		}
	}
?>