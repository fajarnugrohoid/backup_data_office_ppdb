<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kepegawaian extends CI_Model {
	function __construct(){
		parent:: __construct();
	}
	
	function pilih_data_kepegawaian($limit=array()){
		$this->db->select('*')
				 ->from('kepegawaian, jabatan')
				 ->where('kepegawaian.id_jabatan = jabatan.id_jabatan')
				 ->order_by('jabatan.urut, kepegawaian.nama', "asc");
		
		if($limit!=NULL){
			$this->db->limit($limit['perpage'],$limit['offset']);
		}
		return $this->db->get();
	}
	
	function pilih_user_kepegawaian($username){
		$this->db->select('*')
				 ->from('kepegawaian')
				 ->where('username', $username);
		return $this->db->get();
	}
	
	function masuk_data_kepegawaian($data){
		$this->db->insert('kepegawaian', $data);
	}
	
	function get_kepsek(){
		$this->db->select('kepegawaian.foto')
				 ->from('kepegawaian, jabatan')
				 ->where('kepegawaian.id_jabatan = jabatan.id_jabatan')
				 ->where('jabatan.jabatan = "Kepala Sekolah"');
		return $this->db->get();
	}
	
	function pilih_id_kepegawaian($id_kepegawaian){
		$this->db->select('*');
		$this->db->from('kepegawaian');
		$this->db->where('id_pegawai', $id_kepegawaian);
		return $this->db->get();
	}
	
	function update_data($id,$data){
		$this->db->where('id_pegawai', $id);
		$this->db->update('kepegawaian', $data);
	}
	
	function hapus($id_kepegawaian){
		$this->db->where('id_pegawai', $id_kepegawaian);
		$this->db->delete('kepegawaian');
	}
	
	function pilih_kepegawaian(){
		$this->db->select('*');
		$this->db->from('kepegawaian');
		return $this->db->get();
	}
	
	function pilih_kepegawaian_jurusan(){
		$this->db->select('*');
		$this->db->from('kepegawaian, jabatan');
		$this->db->where('kepegawaian.id_jabatan = jabatan.id_jabatan');
		$this->db->where('jabatan.urut = "3"');
		return $this->db->get();
	}
	
	public function get_all_search(){
		$this->db->from("kepegawaian, jabatan");
		$this->db->select("*");
		$this->db->where("kepegawaian.id_jabatan=jabatan.id_jabatan");
		$this->db->order_by("jabatan.urut","asc");
		$this->db->order_by("jabatan.jabatan", "asc");
		$this->db->order_by("kepegawaian.nama","asc");
		$this->db->order_by("jenis_kelamin","asc");

		$hasil = $this->db->get();
		return $hasil;
	}
	
	public function get_all_like($Spec=""){
		if($Spec==""){
			return $this->get_all_search();
		}else{
			$this->db->from("kepegawaian, jabatan");
			$this->db->select("*");
			$this->db->where("kepegawaian.id_jabatan=jabatan.id_jabatan");
			$this->db->like("nip", $Spec);
			$this->db->or_like("nama", $Spec);
			$this->db->order_by("jabatan.urut","asc");
			$this->db->order_by("jabatan.jabatan", "asc");
			$this->db->order_by("kepegawaian.nama","asc");
			$this->db->order_by("jenis_kelamin","asc");

			$hasil = $this->db->get();
			return $hasil;
		}
	}
	
	function select_all_paging_peg($limit=array()){
		$sql = "select * from kepegawaian, jabatan where kepegawaian.id_jabatan = jabatan.id_jabatan order by jabatan.urut asc";
		if ($limit != NULL){
			$sql .= " limit ".$limit['offset'].",".$limit['perpage'];
		}
		return $this->db->query($sql);		
	}
	
	public function get_all_with_limit($Limit=0,$Offset=0){
		if($Limit==0 && $Offset==0){
			return $this->get_all_search();
		}else{
			$sql = "select * from kepegawaian, jabatan where kepegawaian.id_jabatan = jabatan.id_jabatan order by jabatan.urut, kepegawaian.nama asc";

			if($Limit!=0 && $Offset==0){
				$this->db->limit($Limit,0);
			}else{
				$this->db->limit($Limit,$Offset);
			}

			$hasil = $this->db->get();
			return $hasil;
		}
	}
	
	function cek_id_kepegawaian(){
		$this->db->select("*")
				 ->from("kepegawaian")
				 ->order_by('id_pegawai',"desc");
		return $this->db->get();
	}
}