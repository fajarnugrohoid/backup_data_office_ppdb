<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Model {
	function __construct(){
		parent:: __construct();
	}
	
	function auth($username, $password){
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('username', $username);
		$this->db->where('password', $password);
		return $this->db->get();
	}
}