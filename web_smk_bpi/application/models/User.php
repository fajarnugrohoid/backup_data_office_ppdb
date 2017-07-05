<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model {
	function __construct(){
		parent:: __construct();
	}
	
	function pilih_data_user($limit=array()){
		$this->db->select('*')
				 ->from('user')
				 ->order_by('level_user',"asc");
				 
		if($limit!=NULL){
			$this->db->limit($limit['perpage'],$limit['offset']);
		}
		
		return $this->db->get();
	}
	
	function pilih_user_user($username){
		$this->db->select('*')
				 ->from('user')
				 ->where('username', $username);
		return $this->db->get();
	}
	
	function masuk_data_user($data){
		$this->db->insert('user', $data);
	}
	
	function pilih_id_user($id_user){
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('id_user', $id_user);
		return $this->db->get();
	}
	
	function update_data($id,$data){
		$this->db->where('id_user', $id);
		$this->db->update('user', $data);
	}
	
	function hapus($id_user){
		$this->db->where('id_user', $id_user);
		$this->db->delete('user');
	}
	
	function pilih_user(){
		$this->db->select('*');
		$this->db->from('user');
		return $this->db->get();
	}
	function pilih_username($user){
		$this->db->select('*');
		$this->db->from('user')
				 ->where('username',$user);
		return $this->db->get();
	}
	
	function reset($username, $pass){
		$this->db->where('username', $username);
		$this->db->update('user', $pass);
	}
}