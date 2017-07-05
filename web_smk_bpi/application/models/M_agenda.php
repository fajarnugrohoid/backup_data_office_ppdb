<?php
	class M_agenda extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		
		function addEvent($title, $start, $end, $description, $color){
			$q = $this->db->query("insert into events (title, events.start, events.end, description, color) values ('$title', '$start', '$end', '$description', '$color')");
		}
		
		function deleteEvent($id){
			$q = $this->db->query("delete from events where id = '$id'");
		}
		
		function getEvent($id){
			$q = $this->db->query("select * from events where id = '$id'");
			
			return $q;
		}
		
		function getEvents(){
			$q = $this->db->query("Select id, title, description, color, start, date_add(end, interval 1 day) as end from events");
			
			return $q;
		}
		
		function updateEvent($id, $title, $start, $end, $description){
			$q = $this->db->query("update events set title = '$title', events.start = '$start', events.end = '$end', description = '$description' where id = '$id'");
		}
	}
?>