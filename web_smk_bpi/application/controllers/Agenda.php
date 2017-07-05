<?php
	class Agenda extends CI_Controller{
		function __construct(){
			parent::__construct();
			$this->load->model('profilsekolah');
		}
		
		public function beranda(){
			$data['title'] = "AGENDA";
			$data['profilsekolah_pil']=$this->profilsekolah->pilih_profilsekolah()->result();
			$this->load->view('agenda', $data);
		}
		
		public function addEvent(){
			$title = $this->input->post('title');
			$start = $this->input->post('start');
			$end = $this->input->post('end');
			$description = $this->input->post('description');
			$color = $this->input->post('color');
			
			$this->M_agenda->addEvent($title, $start, $end, $description, $color);
		}
		
		public function deleteEvent($id){
			$this->M_agenda->deleteEvent($id);
		}
		
		public function getEvent($id){
			$kueri = $this->M_agenda->getEvent($id);
			
			while(($resultArray[] = mysql_fetch_assoc($kueri)) || array_pop($resultArray));
			echo json_encode($resultArray);
		}
		
		public function getEvents(){
			$kueri = $this->M_agenda->getEvents();
			echo json_encode($kueri->result_array());
		}
		
		public function updateEvent(){
			$id = $this->input->post('id');
			$title = $this->input->post('title');
			$start = $this->input->post('start');
			$end = $this->input->post('end');
			$description = $this->input->post('description');
			
			$this->M_agenda->updateEvent($id, $title, $start, $end, $description);
		}
	}
?>