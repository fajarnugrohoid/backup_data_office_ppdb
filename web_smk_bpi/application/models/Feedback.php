<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback extends CI_Model {
	function __construct(){
		parent:: __construct();
	}
	
	// untuk file lihat feedback
	function pilih_data_feedback($limit=array()){
		$this->db->select('*')
				 ->from('feedback')
				 ->order_by('tgl_posting',"desc");
				 
		if($limit!=NULL){
			$this->db->limit($limit['perpage'],$limit['offset']);
		}
		
		return $this->db->get();
	}
	
	function lihat_detail_feedback($id){
		$this->db->select('*')
				 ->from('feedback')
				 ->where('id_feedback',$id);
		return $this->db->get();
	}
	
	function update_status_feedback($id, $status){
		$this->db->where('id_feedback', $id);
		$this->db->update('feedback', $status);
	}
	
	// untuk file data feedback
	function masuk_data_feedback($data){
		$this->db->insert('feedback', $data);
	}
	
}