<?php
	class Ortu extends CI_Controller{
		function __construct(){
			parent::__construct();
			$this->load->model('profilsekolah');
		}
			
		function index(){
			$data = $this->session->userdata();
			if($data['login']==false){
				//$this->load->view('ortu/login');
				redirect(base_url('ortu/ortu/auth'));
			}
			else{
					print_r($this->session->userdata());
					redirect('ortu/ortu/rekap_absen');
			}
		}
		
		function auth(){
			if($this->session->userdata('login')){
				redirect(base_url('ortu/ortu'));
			} else {
				$data['title']="Login";
				//$this->load->view('admin/auth_page', $data);
				$data['profilsekolah_pil']=$this->profilsekolah->pilih_profilsekolah()->result();				
				$this->load->view('ortu/login', $data);			
			}
		}
		
		function proses_login(){
			if(isset($_POST['login'])){
				$username = $this->input->post('username');
				$password = md5($this->input->post('password'));
				$data = $this->M_ortu->proses_login($username, $password)->row();
				$counter = count($data);
				
				if($counter == 1){
					$data2 = array(
							'nis' => $data->nis,
							'nama' => $data->nama,
							'username' => $data->username,
							'password' => $data->password,
							'login' => true
						);
					$this->session->set_userdata($data2);
					redirect('ortu/ortu');
				}
				else{
					$this->session->set_flashdata('notification', '
					<div class="ui red message">
						<strong>Peringatan</strong>: Username dan/atau Password salah!!!
					</div>');
					redirect('ortu/ortu/auth');
				}
			}else{
				redirect('ortu/ortu/auth');
			}
		}
		
		function logout(){
			$data2 = array(
						'nis' => "",
						'nama' => "",
						'username' => "",
						'password' => "",
						'login' => false
					);
			$this->session->set_userdata($data2);
			redirect('ortu/ortu');
		}
		
		function rekap_absensi(){
			if($this->session->userdata('login')){
				$datas = $this->session->userdata();
				$data['nama'] = $datas['nama'];
				$data['kelas'] = $this->M_absensi->ambil_kelas()->result();
				$data['level_user']=$this->session->userdata('level_user');
				$data['title']="Rekap Absen Siswa";
				$data['nama_log']=$this->session->userdata('admin_name');
				$data['profilsekolah_pil']=$this->profilsekolah->pilih_profilsekolah()->result();
				$this->load->view('ortu/rekap_absensi', $data);
			}else{
				redirect(base_url('ortu/ortu'));
			}
		}
		
		function rekap_absen(){
			$datas = $this->session->userdata();
			$data['nama'] = $datas['nama'];
			if($datas['login'] == true){
				$data['siswa'] = $this->M_ortu->rekap_absen($datas['nis'])->result();
				$hit = count($this->M_ortu->rekap_absen($datas['nis'])->row());
				if ($hit != 0){
					$data['jumlah'] = $hit;
				}
				else{
					$data['jumlah'] = 0;
				}
				$data['profilsekolah_pil']=$this->profilsekolah->pilih_profilsekolah()->result();
				$this->load->view('ortu/rekap_absen', $data);
			}else{
				redirect('ortu/ortu');
			}
		}
		
		function rekap_absen2(){
			if($this->session->userdata('login')){
				$datas = $this->session->userdata();
				$data['nama'] = $datas['nama'];
					
				$bulan = $this->input->post('bulan');
				$tahun = $this->input->post('tahun');
				$data['siswa'] = $this->M_ortu->rekap_absen2($datas['nis'], $bulan, $tahun)->result();
				
				$data['detail'] = $this->M_ortu->detail($datas['nis'], $bulan, $tahun)->result();
				$data['jumlah'] = count($this->M_ortu->rekap_absen2($datas['nis'], $bulan, $tahun)->row());
				$data['profilsekolah_pil']=$this->profilsekolah->pilih_profilsekolah()->result();
				$this->load->view('ortu/rekap_absen2', $data);
			}else{
				redirect('ortu/ortu');
			}
		}
		
		//Ganti Password
	public function ganti_password(){
		if(($this->session->userdata('login'))){
			$data['title']="Ganti Password";
			$datas = $this->session->userdata();
			$data['nama'] = $datas['nama'];
			$data['nama_log']=$this->session->userdata('username');
			$data['pass_log']=$this->session->userdata('password');
			$data['profilsekolah_pil']=$this->profilsekolah->pilih_profilsekolah()->result();
			$this->load->view('ortu/ganti_password', $data);
		}else {
			redirect(base_url('ortu/ortu'));
		}
	}
	
	function pass_action(){
		$datas = $this->session->userdata();
			
		if($this->session->userdata('login', true)){
			$username = $this->session->userdata('username', true);
			$password = md5($this->input->post('password_lama', 'true'));
			$temp_account = $this->M_ortu->auth($username, $password)->row();
			
			// check account
			$num_account = count($temp_account);
			
			if (($this->input->post('konfirmasi_password_baru', 'true'))== ($this->input->post('password_baru', 'true'))){
				$pass['password'] = md5($this->input->post('konfirmasi_password_baru', 'true'));
				$num_account;
				if ($num_account==1){
					$this->M_ortu->reset($username,$pass);
					$this->session->set_flashdata('notif','<div class="ui blue message">Peringatan : Password berhasil diganti!</div>');
					redirect(base_url('ortu/ortu/ganti_password'));
				}
				else {
					// kalau ga ada diredirect lagi ke halaman login
					$this->session->set_flashdata('notif','<div class="ui red message">Peringatan : Password Lama tidak cocok</div>');
					redirect(base_url('ortu/ortu/ganti_password'));
				}
			}else{
				$this->session->set_flashdata('notif','<div class="ui red message">Peringatan : Konfirmasi password baru tidak cocok</div>');
				redirect(base_url('ortu/ortu/ganti_password'));
			}
		}else{
			redirect(base_url('ortu/ortu'));
		}
	}
	
	
		
	}
?>