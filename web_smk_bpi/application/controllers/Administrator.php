<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('date');
		$this->load->helper('text');
		$this->load->helper('form');
		$this->load->helper('potong_spasi');
		$this->load->model('auth');
		$this->load->model('kepegawaian');
		$this->load->model('jabatan');
		$this->load->model('kategoriartikel');
		$this->load->model('ekstrakulikuler');
		$this->load->model('profiljurusan');
		$this->load->model('unitkerja');
		$this->load->model('user');
		$this->load->model('profilsekolah');
		$this->load->model('silabus');
		$this->load->model('other');
		$this->load->model('strukturkurikulum');
		$this->load->model('visimisi');
		$this->load->model('m_agenda');
		$this->load->model('galeri');
		$this->load->model('feedback');
		$this->load->model('infoppdb');
		$this->load->model('adminmodel');
		$this->load->library('form_validation');
		$this->load->library('cart');
	}
	
	public function index()
	{
		/*
		Jika belum melakukan login, akan redirect ke form login.
		*/
		if($this->session->userdata('logged_in')){
			$data['nama_log']=$this->session->userdata('admin_name');
			$data['id_login']=$this->session->userdata('id_login');
			$data['level_user']=$this->session->userdata('level_user');
			$data['title']="Administrasi Web SMK BPI";
			
			if ($data['level_user']==4){
				redirect(base_url('administrator/daftar_absen'));
			}else{
				$this->load->view('admin/landing', $data);
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function auth(){
		if($this->session->userdata('logged_in')){
			redirect(base_url('administrator'));
		} else {
			$data['title']="Login";
			//$this->load->view('admin/auth_page', $data);			
			$this->load->view('admin/login', $data);			
		}
	}
	
	public function proses_auth(){
		if(isset($_POST['login'])){
			$username=$this->input->post('username', true);
			$password=md5($this->input->post('password', true));
			//$password=$this->input->post('password');
			$cek_akun=$this->auth->auth($username, $password)->row();
			
			/*
			Jika informasi login betul maka redirect ke halaman utama administrasi
			*/
			if(count($cek_akun)==1){
				$data=array(
					'id_login' => $cek_akun->id_user,
					'logged_in' => true,
					'admin_name' => $cek_akun->nama_user,
					'level_user' => $cek_akun->level_user,
					'username_login' => $cek_akun->username
				);
				$this->session->set_userdata($data);
				//print_r($data);
				redirect(base_url('administrator'));
			}
			/*
			Jika informasi login tidak betul redirect ke halaman login dan menampilkan pesan kesalahan
			*/
			else{
				$this->session->set_flashdata('notification', '
					<div class="ui red message">
						<strong>Peringatan</strong>: Username dan/atau Password salah!!!
					</div>
				');
				redirect(base_url('administrator/auth'));
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function keluar(){
		$this->session->sess_destroy();
		redirect(base_url());
	}
	
	//Kepegawaian
	public function input_kepegawaian($offset = 0){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$data['title']="Data Kepegawaian";
				
				//tentukan jumlah data perhalaman
				$perpage = 20;
				
				//load library pagination
				$this->load->library('pagination');
				
				//konfigurasi tampilan paging
				$config = array(
					'base_url' => base_url('administrator/input_kepegawaian'),
					'total_rows' => count($this->kepegawaian->pilih_data_kepegawaian()->result()),
					'per_page' => $perpage,
					
					'first_link' => '&lt;&lt;',
					'first_tag_open' => '<li>',
					'first_tag_close' => '</li>',

					'last_link' => '&gt;&gt;',
					'last_tag_open' => '<li>',
					'last_tag_close' => '</li>',

					'prev_link'  => '&lt;',
					'prev_tag_open' => '<li>',
					'prev_tag_close' => '</li>',

					'next_link' => '&gt;',
					'next_tag_open' => '<li>',
					'next_tag_close' => '</li>',
					
					'cur_tag_open' => '<li class="active"><a href="#">',
					'cur_tag_close' => '</a></li>',
					
					'num_tag_open' => '<li>',
					'num_tag_close' => '</li>'
				);
				
				//inisialisisasi pagination dan config
				$this->pagination->initialize($config);
				$limit['perpage'] = $perpage;
				$limit['offset'] = $offset;
				
				$data['paginator']=$this->pagination->create_links();
				$data['list_kepegawaian']=$this->kepegawaian->pilih_data_kepegawaian($limit)->result();
				$jabatan=$this->jabatan->pilih_jabatan_pegawai()->result();

				if(count($jabatan)==0){
					$data['jabatan_peg']="0";
				}else{
					$data['jabatan_peg']=$this->jabatan->pilih_jabatan_pegawai()->result();
				}
				
				$data['jabatan_pil']=$this->jabatan->pilih_jabatan()->result();
				$data['nama_log']=$this->session->userdata('admin_name');
				$data['j']=($this->uri->segment(3)+1);
				$data['level_user']=$this->session->userdata('level_user');
				$this->load->view('admin/data_kepegawaian', $data);
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function proses_input_kepegawaian(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$nips = $this->input->post('nip');
				if(strcmp($nips,"")==0){
					$nip="N/A";
				}else{
					$nip=$this->input->post('nip');
				}
				$nama = $this->input->post('nama');
				$jenis_kelamin = $this->input->post('jenis_kelamin');
				$alamat = $this->input->post('alamat');
				$jabatan = $this->input->post('jabatan');
				$no_kontak = $this->input->post('no_kontak');
				$sosmed = $this->input->post('sosmed');
				$mapel = $this->input->post('mapel');
				
				$data_other['other']=$this->kepegawaian->cek_id_kepegawaian()->result();
				if(count($data_other['other'])==0){
					$id=1;
				}else{
					$id=($data_other['other'][0]->id_pegawai)+1;
				}
				
				$potong_nama=potong_spasi($nama);
				$nama_file="pegawai_".$id;
				
				$nama_asli = $_FILES['foto']['name'];
				$pisah_nama_asli = explode(".", $nama_asli);
				$pisah = count($pisah_nama_asli);
				$ekstensi = strtolower($pisah_nama_asli[$pisah-1]);
				$ekstensi_asli = ($pisah_nama_asli[$pisah-1]);
				
				$config['upload_path']='./asset/img';
				$config['allowed_types']='png|jpg';
				$config['max_size']='134217728';
				$config['overwrite']=TRUE;
				$config['file_name']=$nama_file;
				$this->load->library('upload', $config);
				
				$upload_data=$this->upload->data();
				$foto=$upload_data['file_name'];
				
				
				if($ekstensi==NULL){
					if(strcmp($jenis_kelamin,"P")==0){
						$data_pegawai=array(
							'nip' => $nip,
							'foto' => "pegawai_female_default.jpg",
							'nama' => $nama,
							'jenis_kelamin' => $jenis_kelamin,
							'alamat' => $alamat,
							'id_jabatan' => $jabatan,
							'no_kontak' => $no_kontak,
							'sosmed' => $sosmed,
							'mata_pelajaran' => $mapel
						);
					}else{
						$data_pegawai=array(
							'nip' => $nip,
							'foto' => "pegawai_male_default.jpg",
							'nama' => $nama,
							'jenis_kelamin' => $jenis_kelamin,
							'alamat' => $alamat,
							'id_jabatan' => $jabatan,
							'no_kontak' => $no_kontak,
							'sosmed' => $sosmed,
							'mata_pelajaran' => $mapel
						);
					}
					$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Data Pegawai berhasil ditambah dengan foto default, silakan update data untuk menambahkan foto.</div>');
				}elseif($ekstensi!=NULL){
					if((strcmp($ekstensi,"jpeg")==0) OR (strcmp($ekstensi,"jpg")==0) OR (strcmp($ekstensi,"png")==0) OR (strcmp($ekstensi,"gif")==0)){
						$this->upload->do_upload('foto');
						$data_pegawai=array(
							'foto' => $foto.".".$ekstensi_asli,
							'nip' => $nip,
							'nama' => $nama,
							'jenis_kelamin' => $jenis_kelamin,
							'alamat' => $alamat,
							'id_jabatan' => $jabatan,
							'no_kontak' => $no_kontak,
							'sosmed' => $sosmed,
							'mata_pelajaran' => $mapel
						);
						
						$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Data Pegawai berhasil ditambah.</div>');
					}else{
						if(strcmp($jenis_kelamin,"P")==0){
							$data_pegawai['foto']="pegawai_female_default.jpg";
						}else{
							$data_pegawai['foto']="pegawai_male_default.jpg";
						}
						$data_pegawai=array(
							'nip' => $nip,
							'nama' => $nama,
							'jenis_kelamin' => $jenis_kelamin,
							'alamat' => $alamat,
							'id_jabatan' => $jabatan,
							'no_kontak' => $no_kontak,
							'sosmed' => $sosmed,
							'mata_pelajaran' => $mapel
						);
						
						$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Data Pegawai berhasil ditambah dengan foto default <stong>(karena format salah)</strong>, silakan update data untuk menambahkan foto.</div>');
					}
				}
				
				$this->kepegawaian->masuk_data_kepegawaian($data_pegawai);
				redirect(base_url('administrator/input_kepegawaian'));
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function edit_kepegawaian(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$data['title']="Edit Data Kepegawaian";
				$data['kepegawaian_ed']=$this->kepegawaian->pilih_id_kepegawaian($this->uri->segment(3))->result();
				$data['jabatan_pil']=$this->jabatan->pilih_jabatan()->result();
				$jabatan=$this->jabatan->pilih_jabatan_pegawai()->result();
				if(count($jabatan)==0){
					$data['jabatan_peg']="0";
				}else{
					$data['jabatan_peg']=$this->jabatan->pilih_jabatan_pegawai()->result();
				}
				//print_r($data['jabatan_peg']);
				$data['list_kepegawaian']=$this->kepegawaian->pilih_kepegawaian()->result();
				$data['nama_log']=$this->session->userdata('admin_name');
				$data['level_user']=$this->session->userdata('level_user');
				$this->load->view('admin/edit_kepegawaian', $data);
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function proses_edit_kepegawaian(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$id = $this->input->post('id_kepegawaian');
				$nips = $this->input->post('nip');
				if(strcmp($nips,"")==0){
					$nip="N/A";
				}else{
					$nip=$this->input->post('nip');
				}
				
				$nama = $this->input->post('nama');
				$jenis_kelamin = $this->input->post('jenis_kelamin');
				$alamat = $this->input->post('alamat');
				$jabatan = $this->input->post('jabatan');
				$no_kontak = $this->input->post('no_kontak');
				$sosmed = $this->input->post('sosmed');
				$mapel = $this->input->post('mapel');
				
				$potong_nama=potong_spasi($nama);
				$nama_file="pegawai_".$id;
				
				$nama_asli = $_FILES['foto']['name'];
				$pisah_nama_asli = explode(".", $nama_asli);
				$pisah = count($pisah_nama_asli);
				$ekstensi = strtolower($pisah_nama_asli[$pisah-1]);
				$ekstensi_asli = ($pisah_nama_asli[$pisah-1]);
				
				$config['upload_path']='./asset/img';
				$config['allowed_types']='png|jpg';
				$config['max_size']='134217728';
				$config['overwrite']=TRUE;
				$config['file_name']=$nama_file;
				$this->load->library('upload', $config);
				
				$upload_data=$this->upload->data();
				$foto=$upload_data['file_name'];
				$this->upload->do_upload('foto');

				if($ekstensi==NULL){
					$data_pegawai=array(
						'nip' => $nip,
						'nama' => $nama,
						'jenis_kelamin' => $jenis_kelamin,
						'alamat' => $alamat,
						'id_jabatan' => $jabatan,
						'no_kontak' => $no_kontak,
						'sosmed' => $sosmed,
						'mata_pelajaran' => $mapel
					);
					
					$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Data Pegawai berhasil diperbaharui tanpa mengganti foto.</div>');
				}elseif($ekstensi!=NULL){
					if((strcmp($ekstensi,"jpeg")==0) or (strcmp($ekstensi,"jpg")==0) or (strcmp($ekstensi,"png")==0) or (strcmp($ekstensi,"gif")==0)){
						
						$data_pegawai=array(
							'foto' => $foto.".".$ekstensi_asli,
							'nip' => $nip,
							'nama' => $nama,
							'jenis_kelamin' => $jenis_kelamin,
							'alamat' => $alamat,
							'id_jabatan' => $jabatan,
							'no_kontak' => $no_kontak,
							'sosmed' => $sosmed,
							'mata_pelajaran' => $mapel
						);
					
						$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Data Pegawai berhasil perbaharui.</div>');
					}else{
						$data_pegawai=array(
							'nip' => $nip,
							'nama' => $nama,
							'jenis_kelamin' => $jenis_kelamin,
							'alamat' => $alamat,
							'id_jabatan' => $jabatan,
							'no_kontak' => $no_kontak,
							'sosmed' => $sosmed,
							'mata_pelajaran' => $mapel
						);
						
						$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Data Pegawai berhasil diperbaharui tanpa mengganti foto <stong>(karena format salah)</strong>, silakan update foto baru dengan format yang benar.</div>');
					}
				}
				
				$this->kepegawaian->update_data($id, $data_pegawai);
				redirect(base_url('administrator/input_kepegawaian'));
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function hapus_kepegawaian($id_kepegawaian){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$this->kepegawaian->hapus($id_kepegawaian);
				$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Data Pegawai berhasil dihapus.</div>');
				redirect(base_url('administrator/input_kepegawaian'));
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	//Jabatan
	public function input_jabatan($offset=0){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$data['title']="Data Jabatan";
				
				//tentukan jumlah data perhalaman
				$perpage = 10;
				
				//load library pagination
				$this->load->library('pagination');
				
				//konfigurasi tampilan paging
				$config = array(
					'base_url' => base_url('administrator/input_jabatan'),
					'total_rows' => count($this->jabatan->pilih_data_jabatan()->result()),
					'per_page' => $perpage,
					
					'first_link' => '&lt;&lt;',
					'first_tag_open' => '<li>',
					'first_tag_close' => '</li>',

					'last_link' => '&gt;&gt;',
					'last_tag_open' => '<li>',
					'last_tag_close' => '</li>',

					'prev_link'  => '&lt;',
					'prev_tag_open' => '<li>',
					'prev_tag_close' => '</li>',

					'next_link' => '&gt;',
					'next_tag_open' => '<li>',
					'next_tag_close' => '</li>',
					
					'cur_tag_open' => '<li class="active"><a href="#">',
					'cur_tag_close' => '</a></li>',
					
					'num_tag_open' => '<li>',
					'num_tag_close' => '</li>'
				);
				
				//inisialisisasi pagination dan config
				$this->pagination->initialize($config);
				$limit['perpage'] = $perpage;
				$limit['offset'] = $offset;
				
				$data['paginator']=$this->pagination->create_links();
				$data['list_jabatan']=$this->jabatan->pilih_data_jabatan($limit)->result();
				$data['j']=($this->uri->segment(3)+1);
				$data['nama_log']=$this->session->userdata('admin_name');
				$data['level_user']=$this->session->userdata('level_user');
				$this->load->view('admin/data_jabatan', $data);
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function proses_input_jabatan(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$jabatan = $this->input->post('jabatan');
				$status = $this->input->post('status');
				$urut = $this->input->post('jajaran');
				
				$data=array(
					'jabatan' => $jabatan,
					'status' => $status,
					'urut' => $urut
				);
				
				//print_r($data);
				
				$this->jabatan->masuk_data_jabatan($data);
				$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Data Jabatan berhasil ditambahkan.</div>');
				redirect(base_url('administrator/input_jabatan'));
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function edit_jabatan(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$data['title']="Edit Data Jabatan";
				$data['jabatan_ed']=$this->jabatan->pilih_id_jabatan($this->uri->segment(3))->result();
				$data['nama_log']=$this->session->userdata('admin_name');
				$data['level_user']=$this->session->userdata('level_user');
				$this->load->view('admin/edit_jabatan', $data);
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function proses_edit_jabatan(){
	if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$id = $this->input->post('id_jabatan');
				$jabatan = $this->input->post('jabatan');
				$status = $this->input->post('status');
				$urut = $this->input->post('jajaran');
				
				$data=array(
					'jabatan' => $jabatan,
					'status' => $status,
					'urut' => $urut
				);
				
				$this->jabatan->update_data($id, $data);
				$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Data Jabatan berhasil diperbaharui.</div>');
				redirect(base_url('administrator/input_jabatan'));
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function hapus_jabatan($id_jabatan){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$this->jabatan->hapus($id_jabatan);
				$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Data jabatan berhasil dihapus</div>');
				redirect(base_url('administrator/input_jabatan'));
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	//Ekstrakukuler
	public function input_ekstrakulikuler($offset=0){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$data['title']="Data Ekstrakulikuler";
				
				//tentukan jumlah data perhalaman
				$perpage = 10;
				
				//load library pagination
				$this->load->library('pagination');
				
				//konfigurasi tampilan paging
				$config = array(
					'base_url' => base_url('administrator/input_ekstrakulikuler'),
					'total_rows' => count($this->ekstrakulikuler->pilih_data_ekstrakulikuler()->result()),
					'per_page' => $perpage,
					
					'first_link' => '&lt;&lt;',
					'first_tag_open' => '<li>',
					'first_tag_close' => '</li>',

					'last_link' => '&gt;&gt;',
					'last_tag_open' => '<li>',
					'last_tag_close' => '</li>',

					'prev_link'  => '&lt;',
					'prev_tag_open' => '<li>',
					'prev_tag_close' => '</li>',

					'next_link' => '&gt;',
					'next_tag_open' => '<li>',
					'next_tag_close' => '</li>',
					
					'cur_tag_open' => '<li class="active"><a href="#">',
					'cur_tag_close' => '</a></li>',
					
					'num_tag_open' => '<li>',
					'num_tag_close' => '</li>'
				);
				
				//inisialisisasi pagination dan config
				$this->pagination->initialize($config);
				$limit['perpage'] = $perpage;
				$limit['offset'] = $offset;
				
				$data['paginator']=$this->pagination->create_links();
				$data['list_ekstrakulikuler']=$this->ekstrakulikuler->pilih_data_ekstrakulikuler($limit)->result();
				$data['kepegawaian_pil']=$this->kepegawaian->pilih_kepegawaian($this->uri->segment(3))->result();
				$data['nama_log']=$this->session->userdata('admin_name');
				$data['i']=($this->uri->segment(3)+1);
				$data['level_user']=$this->session->userdata('level_user');
				$this->load->view('admin/data_ekstrakulikuler', $data);
			}
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	public function proses_input_ekstrakulikuler(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$ekstrakulikuler = $this->input->post('ekstrakulikuler');
				$deskripsi = $this->input->post('deskripsi');
				$pembina = $this->input->post('pembina');
				
				$this->load->library('form_validation');
				$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
				if ($this->form_validation->run() == FALSE){
					$this->session->set_flashdata('notifikasi','<div class="ui red message">Peringatan: Silakan isi deskripsi agar dapat menambah data Ekstrakulikuler!</div>');
					$this->session->set_flashdata('ekstrakulikuler',$$ekstrakulikuler);
					$this->session->set_flashdata('pembina',$$pembina);
				}else{
					$data=array(
						'nama_ekstrakulikuler' => $ekstrakulikuler,
						'deskripsi' => $deskripsi,
						'id_pegawai' => $pembina
					);
					$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Data berhasil disimpan.</div>');
					$this->ekstrakulikuler->masuk_data_ekstrakulikuler($data);
				}
				redirect(base_url('administrator/input_ekstrakulikuler'));
			}
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	public function edit_ekstrakulikuler(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$data['title']="Edit Data Ekstrakulikuler";
				$data['ekstrakulikuler_ed']=$this->ekstrakulikuler->pilih_id_ekstrakulikuler($this->uri->segment(3))->result();
				$data['kepegawaian_pil']=$this->kepegawaian->pilih_kepegawaian($this->uri->segment(3))->result();
				$data['nama_log']=$this->session->userdata('admin_name');
				$data['level_user']=$this->session->userdata('level_user');
				$this->load->view('admin/edit_ekstrakulikuler', $data);
			}
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	public function proses_edit_ekstrakulikuler(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$id = $this->input->post('id_ekstrakulikuler');
				$ekstrakulikuler = $this->input->post('ekstrakulikuler');
				$deskripsi = $this->input->post('deskripsi');
				$pembina = $this->input->post('pembina');
				
				$this->load->library('form_validation');
				$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
				if ($this->form_validation->run() == FALSE){
					$this->session->set_flashdata('notifikasi','<div class="ui red message">Peringatan: Silakan isi deskripsi agar dapat memperbaharui data Ekstrakulikuler!</div>');
				}else{
					$data=array(
						'nama_ekstrakulikuler' => $ekstrakulikuler,
						'deskripsi' => $deskripsi,
						'id_pegawai' => $pembina
					);
					$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Data berhasil diubah.</div>');
					$this->ekstrakulikuler->update_data($id,$data);
				}
				redirect(base_url('administrator/input_ekstrakulikuler'));
			}
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	public function hapus_ekstrakulikuler($id_ekstrakulikuler){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$this->ekstrakulikuler->hapus($id_ekstrakulikuler);
				$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Data berhasil dihapus.</div>');
				redirect(base_url('administrator/input_ekstrakulikuler'));
			}
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	//User
	public function input_user($offset=0){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$data['title']="Data User";
				
				//tentukan jumlah data perhalaman
				$perpage = 15;
				
				//load library pagination
				$this->load->library('pagination');
				
				//konfigurasi tampilan paging
				$config = array(
					'base_url' => base_url('administrator/input_user'),
					'total_rows' => count($this->user->pilih_data_user()->result()),
					'per_page' => $perpage,
					
					'first_link' => '&lt;&lt;',
					'first_tag_open' => '<li>',
					'first_tag_close' => '</li>',

					'last_link' => '&gt;&gt;',
					'last_tag_open' => '<li>',
					'last_tag_close' => '</li>',

					'prev_link'  => '&lt;',
					'prev_tag_open' => '<li>',
					'prev_tag_close' => '</li>',

					'next_link' => '&gt;',
					'next_tag_open' => '<li>',
					'next_tag_close' => '</li>',
					
					'cur_tag_open' => '<li class="active"><a href="#">',
					'cur_tag_close' => '</a></li>',
					
					'num_tag_open' => '<li>',
					'num_tag_close' => '</li>'
				);
				
				//inisialisisasi pagination dan config
				$this->pagination->initialize($config);
				$limit['perpage'] = $perpage;
				$limit['offset'] = $offset;
				
				$data['paginator']=$this->pagination->create_links();
				$data['list_user']=$this->user->pilih_data_user($limit)->result();
				$data['nama_log']=$this->session->userdata('admin_name');
				$data['j']=($this->uri->segment(3)+1);
				$data['level_user']=$this->session->userdata('level_user');
				$this->load->view('admin/data_user', $data);
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function proses_input_user(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$nama = $this->input->post('nama_user');
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				$level = $this->input->post('level');
				
				$data=array(
					'nama_user' => $nama,
					'username' => $username,
					'password' => md5($password),
					'level_user' => $level
				);
				
				if(count($this->user->pilih_username($username)->row())==1){
					$this->session->set_flashdata('notification', '
						<div class="ui red message">
							<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<strong>Peringatan</strong>: Username sudah digunakan!!!
						</div>
					');
					$this->session->set_flashdata('namauser',$nama);
				} else {
					$this->session->set_flashdata('notification', '
						<div class="ui blue message">
							<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<strong>Sukses</strong>: Data sudah disimpan.
						</div>
					');
					$this->user->masuk_data_user($data);
				}
				
				redirect(base_url('administrator/input_user'));
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function edit_user(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$data['title']="Edit Data User";
				$data['user_ed']=$this->user->pilih_id_user($this->uri->segment(3))->result();
				$data['nama_log']=$this->session->userdata('admin_name');
				$data['level_user']=$this->session->userdata('level_user');
				$this->load->view('admin/edit_user', $data);
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function proses_edit_user(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$id = $this->input->post('id_user');
				$nama = $this->input->post('nama_user');
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				$level = $this->input->post('level');
				
				$data=array(
					'nama_user' => $nama,
					'username' => $username,
					'password' => md5($password),
					'level_user' => $level
				);
				
				$data1=array(
					'nama_user' => $nama,
					'username' => $username,
					'level_user' => $level
				);
				
				$data2=array(
					'nama_user' => $nama,
					'level_user' => $level
				);
				
				$data3=array(
					'nama_user' => $nama,
					'password' => md5($password),
					'level_user' => $level
				);

				if(count($this->user->pilih_username($username)->row())==1){
					$this->session->set_flashdata('notification', '
						<div class="ui red message">
						<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<strong>Peringatan</strong>: Username sudah digunakan!!!
						</div>
					');
					
					redirect(base_url('administrator/edit_user')."/".$id);
				} elseif ($password==NULL and $username==NULL){
					$this->user->update_data($id, $data2);
					$this->session->set_flashdata('notification', '
						<div class="ui blue message">
							<button type="button" class=" close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<strong>Sukses</strong>: Data sudah diperbaharui tanpa mengganti username dan password.
						</div>
					');
					redirect(base_url('administrator/input_user'));
				} elseif ($username==NULL){
					$this->user->update_data($id, $data3);
					$this->session->set_flashdata('notification', '
						<div class="ui blue message">
							<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<strong>Sukses</strong>: Data sudah diperbaharui tanpa mengganti username.
						</div>
					');
					redirect(base_url('administrator/input_user'));
				} elseif ($password==NULL) {
					$this->user->update_data($id, $data1);
					$this->session->set_flashdata('notification', '
						<div class="ui blue message">
							<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<strong>Sukses</strong>: Data sudah diperbaharui tanpa mengganti password.
						</div>
					');
					redirect(base_url('administrator/input_user'));
				} else {
					$this->user->update_data($id, $data);
					$this->session->set_flashdata('notification', '
						<div class="ui blue message">
							<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
							<strong>Sukses</strong>: Semua data sudah diperbaharui..
						</div>
					');
					redirect(base_url('administrator/input_user'));
				}
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function hapus_user($id_user){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$this->user->hapus($id_user);
				$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Data berhasil dihapus.</div>');
				redirect(base_url('administrator/input_user'));
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	//Profil Sekolah
	public function edit_profilsekolah(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$data['title']="Data Profil Sekolah";
				$data['profilsekolah_ed']=$this->profilsekolah->pilih_profilsekolah()->result();
				$data['nama_log']=$this->session->userdata('admin_name');
				$data['level_user']=$this->session->userdata('level_user');
				$this->load->view('admin/edit_profilsekolah', $data);
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function proses_edit_profilsekolah(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
				$this->form_validation->set_rules('sambutan', 'Sambutan', 'required');
				
				if ($this->form_validation->run() == FALSE){
					$this->session->set_flashdata('Gagal','<div class="ui red message">Peringatan: Deskripsi dan Sambutan tidak boleh kosong, agar dapat mengubah Profil Sekolah!</div>');
					redirect(base_url('administrator/edit_profilsekolah'));
				}else{
					$nama = $this->input->post('nama');
					$alamat = $this->input->post('alamat');
					$kontak = $this->input->post('kontak');
					$email = $this->input->post('email');
					$deskripsi = $this->input->post('deskripsi');
					$sambutan = $this->input->post('sambutan');
					
					$nama_asli = $_FILES['logo']['name'];
					$pisah_nama_asli = explode(".", $nama_asli);
					$pisah = count($pisah_nama_asli);
					$ekstensi_asli = $pisah_nama_asli[$pisah-1];
					$ekstensi = strtolower($pisah_nama_asli[$pisah-1]);
					
					$potong_nama=potong_spasi($nama);
					$nama_file='logo_'.$potong_nama;
					$config['upload_path']='./asset/img';
					$config['allowed_types']='png|jpg|jpeg|gif';
					$config['max_size']='134217728';
					$config['overwrite']=TRUE;
					$config['file_name']=$nama_file;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					$upload_data=$this->upload->data();
					$foto=$upload_data['file_name'];
					
					
					$nama_asli1 = $_FILES['foto_profil']['name'];
					$pisah_nama_asli1 = explode(".", $nama_asli1);
					$pisah1 = count($pisah_nama_asli1);
					$ekstensi_asli1 = $pisah_nama_asli1[$pisah1-1];
					$ekstensi1 = strtolower($pisah_nama_asli1[$pisah1-1]);
					
					$potong_nama1=potong_spasi($nama);
					$nama_file1='fotoprofil_'.$potong_nama1;
					$config1['upload_path']='./asset/img';
					$config1['allowed_types']='png|jpg|jpeg|gif';
					$config1['max_size']='134217728';
					$config1['overwrite']=TRUE;
					$config1['file_name']=$nama_file1;
					$this->load->library('upload', $config1);
					$this->upload->initialize($config1);
					$upload_data1=$this->upload->data();
					$foto1=$upload_data1['file_name'];
					
					
					if($ekstensi==NULL and $ekstensi1==NULL){
					
						$data=array(
							'nama_sekolah' => $nama,
							'alamat' => $alamat,
							'no_kontak' => $kontak,
							'email' => $email,
							'deskripsi' => $deskripsi,
							'sambutan_kepsek' => $sambutan
						);
						
						$this->session->set_flashdata('sukses','<div class="ui blue message">Pemberitahuan: Logo dan Foto Profil tidak diperbaharui, Profil Sekolah berhasil diperbaharui.</div>');
					}elseif($ekstensi==NULL){
					
						$data=array(
							'nama_sekolah' => $nama,
							'foto_profil' => $foto1.'.'.$ekstensi_asli1,
							'alamat' => $alamat,
							'no_kontak' => $kontak,
							'email' => $email,
							'deskripsi' => $deskripsi,
							'sambutan_kepsek' => $sambutan
						);
						
						$this->session->set_flashdata('sukses','<div class="ui blue message">Pemberitahuan: Logo tidak diperbaharui, Profil Sekolah berhasil diperbaharui.</div>');
						
					}elseif($ekstensi1==NULL){
					
						$data=array(
							'nama_sekolah' => $nama,
							'logo' => $foto.'.'.$ekstensi_asli,
							'alamat' => $alamat,
							'no_kontak' => $kontak,
							'email' => $email,
							'deskripsi' => $deskripsi,
							'sambutan_kepsek' => $sambutan
						);
						
						$this->session->set_flashdata('sukses','<div class="ui blue message">Pemberitahuan: Foto Profil tidak diperbaharui, Profil Sekolah berhasil diperbaharui.</div>');
					}else{
						if(((strcmp($ekstensi,"jpeg")==0) or (strcmp($ekstensi,"jpg")==0) or (strcmp($ekstensi,"png")==0) or (strcmp($ekstensi,"gif")==0)) and ((strcmp($ekstensi1,"jpeg")==0) or (strcmp($ekstensi1,"jpg")==0)or (strcmp($ekstensi1,"png")==0) or (strcmp($ekstensi1,"gif")==0))){
							$this->upload->do_upload('logo');
							$this->upload->do_upload('foto_profil');
							$data=array(
								'nama_sekolah' => $nama,
								'logo' => $foto.'.'.$ekstensi_asli,
								'foto_profil' => $foto1.'.'.$ekstensi_asli1,
								'alamat' => $alamat,
								'no_kontak' => $kontak,
								'email' => $email,
								'deskripsi' => $deskripsi,
								'sambutan_kepsek' => $sambutan
							);
							
							$this->session->set_flashdata('sukses','<div class="ui blue message">Pemberitahuan: Profil Sekolah berhasil diperbaharui.</div>');
						}elseif((strcmp($ekstensi,"jpeg")==0) or (strcmp($ekstensi,"jpg")==0) or (strcmp($ekstensi,"png")==0) or (strcmp($ekstensi,"gif")==0)){
								$this->upload->do_upload('logo');
								$data=array(
									'nama_sekolah' => $nama,
									'logo' => $foto.'.'.$ekstensi_asli,
									'alamat' => $alamat,
									'no_kontak' => $kontak,
									'email' => $email,
									'deskripsi' => $deskripsi,
									'sambutan_kepsek' => $sambutan
								);
							
								$this->session->set_flashdata('sukses','<div class="ui blue message">Pemberitahuan: Format Foto Frofil salah, logo tidak tersimpan. Profil Sekolah berhasil diperbaharui.</div>');
							
						}elseif((strcmp($ekstensi1,"jpeg")==0) or (strcmp($ekstensi1,"jpg")==0) or (strcmp($ekstensi1,"png")==0) or (strcmp($ekstensi1,"gif")==0)){
								$this->upload->do_upload('foto_profil');
								$data=array(
									'nama_sekolah' => $nama,
									'foto_profil' => $foto1.'.'.$ekstensi_asli1,
									'alamat' => $alamat,
									'no_kontak' => $kontak,
									'email' => $email,
									'deskripsi' => $deskripsi,
									'sambutan_kepsek' => $sambutan
								);
								
								$this->session->set_flashdata('sukses','<div class="ui blue message">Pemberitahuan: Format logo salah, logo tidak tersimpan. Profil Sekolah berhasil diperbaharui.</div>');
								
						}else{
							$data=array(
								'nama_sekolah' => $nama,
								'alamat' => $alamat,
								'no_kontak' => $kontak,
								'email' => $email,
								'deskripsi' => $deskripsi,
								'sambutan_kepsek' => $sambutan
							);
							
							$this->session->set_flashdata('sukses','<div class="ui blue message">Pemberitahuan: Format Logo dan Foto Profil salah, Logo dan Foto Profil tidak tersimpan. Profil Sekolah berhasil diperbaharui.</div>');
						}
					}
					//echo $ekstensi."<br/>";
					//echo $ekstensi1."<br/>";
					//echo $ekstensi_asli."<br/>";
					//echo $ekstensi_asli1."<br/>";
					//echo $nama."<br/>";
					//echo $potong_nama."<br/>";
					//echo $potong_nama1."<br/>";
					$this->profilsekolah->update_data(1, $data);
					redirect(base_url('administrator/edit_profilsekolah'));
				}
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	//Visi Misi
	public function edit_visimisi(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$data['title']="VISI dan MISI";
				$data['visimisi_ed']=$this->visimisi->pilih_visimisi()->result();
				$data['nama_log']=$this->session->userdata('admin_name');
				$data['level_user']=$this->session->userdata('level_user');
				$this->load->view('admin/edit_visimisi', $data);
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function proses_edit_visimisi(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('visi', 'Visi', 'required');
				$this->form_validation->set_rules('misi', 'Misi', 'required');
				
				if ($this->form_validation->run() == FALSE){
					$this->session->set_flashdata('notifikasi','<div class="ui red message">Peringatan: Ada form yang kosong, silakan lengkapi form untuk mengubah Profil Sekolah!</div>');
					redirect(base_url('administrator/edit_visimisi'));
				}else{
					$visi = $this->input->post('visi');
					$misi = $this->input->post('misi');
					
					$data=array(
						'visi' => $visi,
						'misi' => $misi
					);
					$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Data berhasil diperbaharui</div>');
					$this->visimisi->update_data(1, $data);
					redirect(base_url('administrator/edit_visimisi'));
				}
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	//Kategori Artikel
	public function input_kategoriartikel($offset=0){
		if($this->session->userdata('logged_in')){
			$data['title']="Data Kategori Artikel";
			
			//tentukan jumlah data perhalaman
			$perpage = 10;
			
			//load library pagination
			$this->load->library('pagination');
			
			//konfigurasi tampilan paging
			$config = array(
				'base_url' => base_url('administrator/input_kategoriartikel'),
				'total_rows' => count($this->kategoriartikel->pilih_data_kategoriartikel()->result()),
				'per_page' => $perpage,
				
				'first_link' => '&lt;&lt;',
				'first_tag_open' => '<li>',
				'first_tag_close' => '</li>',

				'last_link' => '&gt;&gt;',
				'last_tag_open' => '<li>',
				'last_tag_close' => '</li>',

				'prev_link'  => '&lt;',
				'prev_tag_open' => '<li>',
				'prev_tag_close' => '</li>',

				'next_link' => '&gt;',
				'next_tag_open' => '<li>',
				'next_tag_close' => '</li>',
				
				'cur_tag_open' => '<li class="active"><a href="#">',
				'cur_tag_close' => '</a></li>',
				
				'num_tag_open' => '<li>',
				'num_tag_close' => '</li>'
			);
			
			//inisialisisasi pagination dan config
			$this->pagination->initialize($config);
			$limit['perpage'] = $perpage;
			$limit['offset'] = $offset;
			
			$data['paginator']=$this->pagination->create_links();
			$data['list_kategoriartikel']=$this->kategoriartikel->pilih_data_kategoriartikel($limit)->result();
			$data['nama_log']=$this->session->userdata('admin_name');
			$data['j']=($this->uri->segment(3)+1);
			$data['level_user']=$this->session->userdata('level_user');
			$this->load->view('admin/data_kategoriartikel', $data);
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	public function proses_input_kategoriartikel(){
		if($this->session->userdata('logged_in')){
			$kategoriartikel = $this->input->post('kategoriartikel');
			if(count($this->kategoriartikel->cari_kategoriartikel($kategoriartikel)->result())==0){
				$data=array(
					'kategori_artikel' => $kategoriartikel
				);
				$this->kategoriartikel->masuk_data_kategoriartikel($data);
				
				$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Kategori artikel berhasil ditambahkan.</div>');
			}else{
				$this->session->set_flashdata('notifikasi','<div class="ui red message">Peringatan: Kategori artikel sudah ada!</div>');
			}
			
			redirect(base_url('administrator/input_kategoriartikel'));
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	public function edit_kategoriartikel(){
		if($this->session->userdata('logged_in')){
			$data['title']="Edit Data Kategori Artikel";
			$data['kategoriartikel_ed']=$this->kategoriartikel->pilih_id_kategoriartikel($this->uri->segment(3))->result();
			$data['nama_log']=$this->session->userdata('admin_name');
			$data['level_user']=$this->session->userdata('level_user');
			$this->load->view('admin/edit_kategoriartikel', $data);
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	public function proses_edit_kategoriartikel(){
		if($this->session->userdata('logged_in')){
			$id = $this->input->post('id_kategoriartikel');
			$kategoriartikel = $this->input->post('kategoriartikel');
			if(strcmp($kategoriartikel,"")==1){
				if(count($this->kategoriartikel->cari_kategoriartikel($kategoriartikel)->result())==0){
					$data=array(
						'kategori_artikel' => $kategoriartikel
					);
					$this->kategoriartikel->masuk_data_kategoriartikel($data);
					
					$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Kategori artikel berhasil ditambahkan.</div>');
				}else{
					$this->session->set_flashdata('notifikasi','<div class="ui red message">Peringatan: Kategori artikel sudah ada!</div>');
				}
			}else{
				$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Kategori artikel tidak ada perubahan.</div>');
			}
			
			redirect(base_url('administrator/input_kategoriartikel'));
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	public function hapus_kategoriartikel($id_kategoriartikel){
		if($this->session->userdata('logged_in')){
			$this->kategoriartikel->hapus($id_kategoriartikel);
			$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Data berhasil dihapus</div>');
			redirect(base_url('administrator/input_kategoriartikel'));
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	//Profil Juruasan
	public function input_profiljurusan($offset=0){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$data['title']="Data Profil Jurusan";
				
				//tentukan jumlah data perhalaman
				$perpage = 10;
				
				//load library pagination
				$this->load->library('pagination');
				
				//konfigurasi tampilan paging
				$config = array(
					'base_url' => base_url('administrator/input_profiljurusan'),
					'total_rows' => count($this->profiljurusan->pilih_data_profiljurusan()->result()),
					'per_page' => $perpage,
					
					'first_link' => '&lt;&lt;',
					'first_tag_open' => '<li>',
					'first_tag_close' => '</li>',

					'last_link' => '&gt;&gt;',
					'last_tag_open' => '<li>',
					'last_tag_close' => '</li>',

					'prev_link'  => '&lt;',
					'prev_tag_open' => '<li>',
					'prev_tag_close' => '</li>',

					'next_link' => '&gt;',
					'next_tag_open' => '<li>',
					'next_tag_close' => '</li>',
					
					'cur_tag_open' => '<li class="active"><a href="#">',
					'cur_tag_close' => '</a></li>',
					
					'num_tag_open' => '<li>',
					'num_tag_close' => '</li>'
				);
				
				//inisialisisasi pagination dan config
				$this->pagination->initialize($config);
				$limit['perpage'] = $perpage;
				$limit['offset'] = $offset;
				
				$data['paginator']=$this->pagination->create_links();
				$data['list_profiljurusan']=$this->profiljurusan->pilih_data_profiljurusan($limit)->result();
				$data['kepegawaian_pil']=$this->kepegawaian->pilih_kepegawaian_jurusan()->result();
				$data['i']=($this->uri->segment(3)+1);
				$data['jabatan']=$this->jabatan->pilih_jabatan()->result();
				$data['level_user']=$this->session->userdata('level_user');
				$data['nama_log']=$this->session->userdata('admin_name');
				$this->load->view('admin/data_profiljurusan', $data);
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function proses_input_profiljurusan(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
			
				$this->load->library('form_validation');
				$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
				
				if ($this->form_validation->run() == FALSE){
					$this->session->set_flashdata('notifikasi','<div class="ui red message">Peringatan: Deskripsi tidak boleh kosong, silakan lengkapi untuk menambahkan data jurusan!</div>');
				}else{
				
					$nama_jurusan = $this->input->post('nama_jurusan');
					$ketua_jurusan = $this->input->post('ketua_jurusan');
					$deskripsi = $this->input->post('deskripsi');
					
					$cek['cek']=$this->profiljurusan->cek_id_profiljurusan()->result();
					if(count($cek['cek'])==0){
						$id=1;
					}else{
						$id=($cek['cek'][0]->id_jurusan)+1;
					}
					
					$nama_asli = $_FILES['logo']['name'];
					$pisah_nama_asli = explode(".", $nama_asli);
					$pisah = count($pisah_nama_asli);
					$ekstensi = strtolower($pisah_nama_asli[$pisah-1]);
					$ekstensi_asli = ($pisah_nama_asli[$pisah-1]);
					
					$potong_nama=potong_spasi($nama_jurusan);
					$nama_file='logojurusan_'.$id;
					$config['upload_path']='./asset/img';
					$config['allowed_types']='png|jpg|jpeg|gif';
					$config['max_size']='134217728';
					$config['overwrite']=TRUE;
					$config['file_name']=$nama_file;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					$upload_data=$this->upload->data();
					$foto=$upload_data['file_name'];
					
					if($ekstensi==NULL){
						$data=array(
							'logo_jurusan' => "logojurusan_Default.jpg",
							'nama_jurusan' => $nama_jurusan,
							'ketua_jurusan' => $ketua_jurusan,
							'deskripsi' => $deskripsi
						);
						$this->profiljurusan->masuk_data_profiljurusan($data);
						$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Berhasil menambahkan data jurusan dengan menggunakan logo jurusan default sistem.</div>');
					}elseif($ekstensi!=NULL){
						if((strcmp($ekstensi,"jpeg")==0) or (strcmp($ekstensi,"jpg")==0) or (strcmp($ekstensi,"png")==0) or (strcmp($ekstensi,"gif")==0)){
							$this->upload->do_upload('logo');
							$data=array(
								'logo_jurusan' => $foto.".".$ekstensi_asli,
								'nama_jurusan' => $nama_jurusan,
								'ketua_jurusan' => $ketua_jurusan,
								'deskripsi' => $deskripsi
							);
							$this->profiljurusan->masuk_data_profiljurusan($data);
							$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Berhasil menambahkan data jurusan.</div>');
						}else{
							$data=array(
								'logo_jurusan' => "logojurusan_Default.jpg",
								'nama_jurusan' => $nama_jurusan,
								'ketua_jurusan' => $ketua_jurusan,
								'deskripsi' => $deskripsi
							);
							$this->profiljurusan->masuk_data_profiljurusan($data);
							$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Berhasil menambahkan data jurusan dengan menggunakan logo jurusan default sistem karena format gambar pada logo salah.</div>');
						}
					}
				}
				redirect(base_url('administrator/input_profiljurusan'));
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function edit_profiljurusan(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$data['title']="Edit Profil Jurusan";
				$data['profiljurusan_ed']=$this->profiljurusan->pilih_id_profiljurusan($this->uri->segment(3))->result();
				$data['kepegawaian_pil']=$this->kepegawaian->pilih_kepegawaian_jurusan()->result();
				$data['level_user']=$this->session->userdata('level_user');
				$data['nama_log']=$this->session->userdata('admin_name');
				$this->load->view('admin/edit_profiljurusan', $data);
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function proses_edit_profiljurusan(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
			
				$this->load->library('form_validation');
				$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
				
				if ($this->form_validation->run() == FALSE){
					$this->session->set_flashdata('notifikasi','<div class="ui red message">Peringatan: Deskripsi tidak boleh kosong, silakan lengkapi untuk mengubah data jurusan!</div>');
				}else{
					
					$id_jur = $this->input->post('id_profiljurusan');
					$nama_jurusan = $this->input->post('nama_jurusan');
					$ketua_jurusan = $this->input->post('ketua_jurusan');
					$deskripsi = $this->input->post('deskripsi');
				
					$nama_asli = $_FILES['logo']['name'];
					$pisah_nama_asli = explode(".", $nama_asli);
					$pisah = count($pisah_nama_asli);
					$ekstensi = strtolower($pisah_nama_asli[$pisah-1]);
					$ekstensi_asli = ($pisah_nama_asli[$pisah-1]);
					
					$potong_nama=potong_spasi($nama_jurusan);
					$nama_file='logojurusan_'.$id_jur;
					$config['upload_path']='./asset/img';
					$config['allowed_types']='png|jpg|jpeg|gif';
					$config['max_size']='134217728';
					$config['overwrite']=TRUE;
					$config['file_name']=$nama_file;
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					$upload_data=$this->upload->data();
					$foto=$upload_data['file_name'];
					
					$logo_jurusan=$foto.".".$ekstensi_asli;
					
					if($ekstensi==NULL){
						$data=array(
							'nama_jurusan' => $nama_jurusan,
							'ketua_jurusan' => $ketua_jurusan,
							'deskripsi' => $deskripsi
						);
						$this->profiljurusan->update_data($id_jur, $data);
						$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Tidak memperbaharui logo jurusan. Data jurusan lain diperbaharui.</div>');
					}elseif($ekstensi!=NULL){
						if((strcmp($ekstensi,"jpeg")==0) OR (strcmp($ekstensi,"jpg")==0) OR (strcmp($ekstensi,"png")==0) OR (strcmp($ekstensi,"gif")==0)){
							$this->upload->do_upload('logo');
							$data=array(
								'logo_jurusan' => $logo_jurusan,
								'nama_jurusan' => $nama_jurusan,
								'ketua_jurusan' => $ketua_jurusan,
								'deskripsi' => $deskripsi
							);
							$this->profiljurusan->update_data($id_jur, $data);
							$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Berhasil memperbaharui data jurusan.</div>');
					
						}else{							
							$data=array(
								'nama_jurusan' => $nama_jurusan,
								'ketua_jurusan' => $ketua_jurusan,
								'deskripsi' => $deskripsi
							);
							$this->profiljurusan->update_data($id_jur, $data);
							$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Format gambar logo tidak sesuai, logo tidak diperbaharui. Data jurusan lain diperbaharui.</div>');
						}
					}
					redirect(base_url('administrator/input_profiljurusan'));
				}
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function hapus_profiljurusan($id_profiljurusan){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
								$this->profiljurusan->hapus($id_profiljurusan);
				$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Data berhasil dihapus</div>');
				redirect(base_url('administrator/input_profiljurusan'));
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	//Galeri
	public function input_galeri($offset=0){
		if($this->session->userdata('logged_in')){
			$data['title']="Data Galeri";
			
			//tentukan jumlah data perhalaman
			$perpage = 20;
			
			//load library pagination
			$this->load->library('pagination');
			
			//konfigurasi tampilan paging
			$config = array(
				'base_url' => base_url('administrator/input_galeri'),
				'total_rows' => count($this->galeri->pilih_data_galeri()->result()),
				'per_page' => $perpage,
				
				'first_link' => '&lt;&lt;',
				'first_tag_open' => '<li>',
				'first_tag_close' => '</li>',

				'last_link' => '&gt;&gt;',
				'last_tag_open' => '<li>',
				'last_tag_close' => '</li>',

				'prev_link'  => '&lt;',
				'prev_tag_open' => '<li>',
				'prev_tag_close' => '</li>',

				'next_link' => '&gt;',
				'next_tag_open' => '<li>',
				'next_tag_close' => '</li>',
				
				'cur_tag_open' => '<li class="active"><a href="#">',
				'cur_tag_close' => '</a></li>',
				
				'num_tag_open' => '<li>',
				'num_tag_close' => '</li>'
			);
			
			//inisialisisasi pagination dan config
			$this->pagination->initialize($config);
			$limit['perpage'] = $perpage;
			$limit['offset'] = $offset;
			
			$data['paginator']=$this->pagination->create_links();
			$data['list_galeri']=$this->galeri->pilih_data_galeri($limit)->result();
			$data['kategori_pil']=$this->kategoriartikel->pilih_kategoriartikel()->result();
			$data['nama_log']=$this->session->userdata('admin_name');
			$data['level_user']=$this->session->userdata('level_user');
			$this->load->view('admin/data_galeri', $data);
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	public function proses_input_galeri(){
		if(($this->session->userdata('logged_in'))){
			$judul = $this->input->post('judul_galeri');
			$deskripsi = $this->input->post('deskripsi');
			$kategori = $this->input->post('kategori');
			
			$cari['galeri']=$this->galeri->cek_id_galeri()->result();
			if(count($cari['galeri'])==0){
				$id=1;
			}else{
				$id=($cari['galeri'][0]->id_galeri)+1;
			}

			$nama_asli = $_FILES['foto_upload']['name'];
			$pisah_nama_asli = explode(".", $nama_asli);
			$pisah = count($pisah_nama_asli);
			$ekstensi = strtolower($pisah_nama_asli[$pisah-1]);
			$ekstensi_asli = ($pisah_nama_asli[$pisah-1]);
			$potong_nama=potong_spasi($judul);
			$nama_file="galeri_".$kategori."_".$id;
			$config['upload_path']='./asset/img';
			$config['allowed_types']='png|jpeg|jpg|gif';
			$config['max_size']='134217728';
			$config['overwrite']=TRUE;
			$config['file_name']=$nama_file;
			$this->load->library('upload', $config);
			
			$upload_data=$this->upload->data();
			$foto=$upload_data['file_name'];
			
			
			if($ekstensi==NULL){
				$this->session->set_flashdata('deskripsi',$deskripsi);
				$this->session->set_flashdata('id_kategori',$kategori);
				$this->session->set_flashdata('judul',$judul);
				$this->session->set_flashdata('notifikasi','<div class="ui red message">Peringatan: Foto tidak diinputkan, foto tidak ditambahkan ke galeri.</div>');
			}else{
				if((strcmp($ekstensi,"jpeg")==0) or (strcmp($ekstensi,"jpg")==0) or (strcmp($ekstensi,"png")==0) or (strcmp($ekstensi,"gif")==0)){
					$this->upload->do_upload('foto_upload');
					$data=array(
						'foto' => $foto.'.'.$ekstensi_asli,
						'judul_galeri' => $judul,
						'deskripsi' => $deskripsi,
						'id_kategori' => $kategori
					);
					$this->galeri->masuk_data_galeri($data);
					$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Foto berhasil ditambahkan ke galeri. </div>');
				}else{
					$this->session->set_flashdata('deskripsi',$deskripsi);
					$this->session->set_flashdata('id_kategori',$kategori);
					$this->session->set_flashdata('judul',$judul);
					$this->session->set_flashdata('notifikasi','<div class="ui red message">Peringatan: Foto tidak ditambahkan ke galeri. Format foto salah.</div>');
				}
			}
			
			redirect(base_url('administrator/input_galeri'));
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	public function edit_galeri(){
		if(($this->session->userdata('logged_in'))){
			$data['title']="Edit Data Galeri";
			$tgl_asli = $this->uri->segment(4);
			$temparray=explode('%20',$tgl_asli);
			$temparray[1]="";
			$depan = implode($temparray);
			
			$tgl_asli1 = $this->uri->segment(4);
			$pisah_tgl_asli1 = explode("%20", $tgl_asli1);
			$pisahtgl1 = count($pisah_tgl_asli1);
			$belakang = strtolower($pisah_tgl_asli1[$pisahtgl1-1]);
			$data['tanggal_asle'] = $depan." ".$belakang;
			$data['galeri_ed']=$this->galeri->pilih_id_galeri($this->uri->segment(3))->result();
			$data['kategori_pil']=$this->kategoriartikel->pilih_kategoriartikel($this->uri->segment(3))->result();
			$data['nama_log']=$this->session->userdata('admin_name');
			$data['level_user']=$this->session->userdata('level_user');
			$this->load->view('admin/edit_galeri', $data);
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	public function proses_edit_galeri(){
		if(($this->session->userdata('logged_in'))){
			$id = $this->input->post('id_galeri');
			$judul = $this->input->post('judul_galeri');
			$deskripsi = $this->input->post('deskripsi');
			$kategori = $this->input->post('kategori');
			
			$nama_asli = $_FILES['foto_upload']['name'];
			$pisah_nama_asli = explode(".", $nama_asli);
			$pisah = count($pisah_nama_asli);
			$ekstensi = strtolower($pisah_nama_asli[$pisah-1]);
			$ekstensi_asli = ($pisah_nama_asli[$pisah-1]);
			
			$potong_nama=potong_spasi($judul);
			$nama_file="galeri_".$kategori."_".$id;
			$config['upload_path']='./asset/img';
			$config['allowed_types']='png|jpeg|jpg|gif';
			$config['max_size']='134217728';
			$config['overwrite']=TRUE;
			$config['file_name']=$nama_file;
			$this->load->library('upload', $config);
			
			$upload_data=$this->upload->data();
			$foto=$upload_data['file_name'];
			
			
			if($ekstensi==NULL){
				$check = $this->input->post('tanggal_baru');
				$tanggal_asle = $this->input->post('tanggal_asle');
				if(strcmp($check,"1")==0){
					$data=array(
						'judul_galeri' => $judul,
						'deskripsi' => $deskripsi,
						'id_kategori' => $kategori
					);
				}else{
					$data=array(
						'judul_galeri' => $judul,
						'deskripsi' => $deskripsi,
						'id_kategori' => $kategori,
						'tgl_posting' => $tanggal_asle
					);
				}
				$this->galeri->update_data($id,$data);
				$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Foto tidak diperbaharui. Deskripsi berhasil diperbaharui dari galeri. </div>');
			}else{
				if((strcmp($ekstensi,"jpeg")==0) or (strcmp($ekstensi,"jpg")==0) or (strcmp($ekstensi,"png")==0) or (strcmp($ekstensi,"gif")==0)){
					
					$this->upload->do_upload('foto_upload');
					$check = $this->input->post('tanggal_baru');
					$tanggal_asle = $this->input->post('tanggal_asle');
					if(strcmp($check,"1")==0){
						$data=array(
							'foto' => $foto.'.'.$ekstensi_asli,
							'judul_galeri' => $judul,
							'deskripsi' => $deskripsi,
							'id_kategori' => $kategori
						);
					}else{
						$data=array(
							'foto' => $foto.'.'.$ekstensi_asli,
							'judul_galeri' => $judul,
							'deskripsi' => $deskripsi,
							'id_kategori' => $kategori,
							'tgl_posting' => $tanggal_asle
						);
					}
					
					$this->galeri->update_data($id,$data);
					$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Foto berhasil diperbaharui ke galeri. </div>');
				}else{
					$check = $this->input->post('tanggal_baru');
					$tanggal_asle = $this->input->post('tanggal_asle');
					if(strcmp($check,"1")==0){
						$data=array(
							'judul_galeri' => $judul,
							'deskripsi' => $deskripsi,
							'id_kategori' => $kategori
						);
					}else{
						$data=array(
							'judul_galeri' => $judul,
							'deskripsi' => $deskripsi,
							'id_kategori' => $kategori,
							'tgl_posting' => $tanggal_asle
						);
					}
					$this->galeri->update_data($id,$data);
					$this->session->set_flashdata('notifikasi','<div class="ui red message">Peringatan: Foto tidak diperbaharui ke galeri. Format foto salah. Data lain telah diperbaharui.</div>');
				}
			}
			
			redirect(base_url('administrator/input_galeri'));
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	public function hapus_galeri($id_galeri){
		if(($this->session->userdata('logged_in'))){
			$this->galeri->hapus($id_galeri);
			$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Foto telah dihapus</div>');
			redirect(base_url('administrator/input_galeri'));
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	//Unit Kerja
	public function input_unitkerja($offset=0){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$data['title']="Data Unit Kerja";
				
				//tentukan jumlah data perhalaman
				$perpage = 10;
				
				//load library pagination
				$this->load->library('pagination');
				
				//konfigurasi tampilan paging
				$config = array(
					'base_url' => base_url('administrator/input_unitkerja'),
					'total_rows' => count($this->unitkerja->pilih_data_unitkerja()->result()),
					'per_page' => $perpage,
					
					'first_link' => '&lt;&lt;',
					'first_tag_open' => '<li>',
					'first_tag_close' => '</li>',

					'last_link' => '&gt;&gt;',
					'last_tag_open' => '<li>',
					'last_tag_close' => '</li>',

					'prev_link'  => '&lt;',
					'prev_tag_open' => '<li>',
					'prev_tag_close' => '</li>',

					'next_link' => '&gt;',
					'next_tag_open' => '<li>',
					'next_tag_close' => '</li>',
					
					'cur_tag_open' => '<li class="active"><a href="#">',
					'cur_tag_close' => '</a></li>',
					
					'num_tag_open' => '<li>',
					'num_tag_close' => '</li>'
				);
				
				//inisialisisasi pagination dan config
				$this->pagination->initialize($config);
				$limit['perpage'] = $perpage;
				$limit['offset'] = $offset;
				
				$data['paginator']=$this->pagination->create_links();
				
				$data['list_unitkerja']=$this->unitkerja->pilih_data_unitkerja($limit)->result();
				$data['kepegawaian_pil']=$this->kepegawaian->pilih_kepegawaian()->result();
				$data['i']=($this->uri->segment(3)+1);
				$data['nama_log']=$this->session->userdata('admin_name');
				$data['level_user']=$this->session->userdata('level_user');
				$this->load->view('admin/data_unitkerja', $data);
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function proses_input_unitkerja(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$unit_kerja = $this->input->post('unit_kerja');
				$this->load->library('form_validation');
				$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
				
				if ($this->form_validation->run() == FALSE){
					$this->session->set_flashdata('notifikasi','<div class="ui red message">Peringatan: Form deskripsi kosong, silakan lengkapi form untuk menambahkan data Unit Kerja!</div>');
					$this->session->set_flashdata('unitkerja', $unit_kerta);
				}else{
					$deskripsi = $this->input->post('deskripsi');
					
					$data=array(
						'unit_kerja' => $unit_kerja,
						'deskripsi' => $deskripsi
					);
					
					$this->unitkerja->masuk_data_unitkerja($data);
					
					$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Berhasil menambahkan data Unit Kerja.</div>');
				}
				redirect(base_url('administrator/input_unitkerja'));
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function edit_unitkerja(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$data['title']="Edit Unit Kerja";
				$data['unitkerja_ed']=$this->unitkerja->pilih_id_unitkerja($this->uri->segment(3))->result();
				$data['nama_log']=$this->session->userdata('admin_name');
				$data['level_user']=$this->session->userdata('level_user');
				$data['kepegawaian_pil']=$this->kepegawaian->pilih_kepegawaian($this->uri->segment(3))->result();
				$this->load->view('admin/edit_unitkerja', $data);
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function proses_edit_unitkerja(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required');
				
				if ($this->form_validation->run() == FALSE){
					$this->session->set_flashdata('notifikasi','<div class="ui red message">Peringatan: Form deskripsi kosong, silakan lengkapi form untuk memperbaharui data Unit Kerja!</div>');
				}else{
					$id = $this->input->post('id_unit_kerja');
					$unit_kerja = $this->input->post('unit_kerja');
					$deskripsi = $this->input->post('deskripsi');
					
					$data=array(
						'unit_kerja' => $unit_kerja,
						'deskripsi' => $deskripsi
					);
					
					$this->unitkerja->update_data($id, $data);
					
					$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Berhasil memperbaharui data Unit Kerja.</div>');
				}
				redirect(base_url('administrator/input_unitkerja'));
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function hapus_unitkerja($id_unitkerja){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$this->unitkerja->hapus($id_unitkerja);
				$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Data telah dihapus</div>');
				redirect(base_url('administrator/input_unitkerja'));
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	//Silabus
	public function input_silabus($offset=0){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$data['title']="Data Silabus";
				//tentukan jumlah data perhalaman
				$perpage = 15;
				
				//load library pagination
				$this->load->library('pagination');
				
				//konfigurasi tampilan paging
				$config = array(
					'base_url' => base_url('administrator/input_silabus'),
					'total_rows' => count($this->silabus->pilih_data_silabus()->result()),
					'per_page' => $perpage,
					
					'first_link' => '&lt;&lt;',
					'first_tag_open' => '<li>',
					'first_tag_close' => '</li>',

					'last_link' => '&gt;&gt;',
					'last_tag_open' => '<li>',
					'last_tag_close' => '</li>',

					'prev_link'  => '&lt;',
					'prev_tag_open' => '<li>',
					'prev_tag_close' => '</li>',

					'next_link' => '&gt;',
					'next_tag_open' => '<li>',
					'next_tag_close' => '</li>',
					
					'cur_tag_open' => '<li class="active"><a href="#">',
					'cur_tag_close' => '</a></li>',
					
					'num_tag_open' => '<li>',
					'num_tag_close' => '</li>'
				);
				
				//inisialisisasi pagination dan config
				$this->pagination->initialize($config);
				$limit['perpage'] = $perpage;
				$limit['offset'] = $offset;
				
				$data['paginator']=$this->pagination->create_links();
				$data['list_silabus']=$this->silabus->pilih_data_silabus($limit)->result();
				$data['nama_log']=$this->session->userdata('admin_name');
				$data['j']=($this->uri->segment(3)+1);
				$data['level_user']=$this->session->userdata('level_user');
				$this->load->view('admin/data_silabus', $data);
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function proses_input_silabus(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$mata_pelajaran = $this->input->post('mapel');
				$tahun_berlaku = $this->input->post('tahun');
				
				$cari['silabus']=$this->silabus->cek_id_silabus()->result();
				if(count($cari['silabus'])==0){
					$id=1;
				}else{
					$id=($cari['silabus'][0]->id_silabus)+1;
				}
				
				$nama_asli = $_FILES['file_silabus']['name'];
				$pisah_nama_asli = explode(".", $nama_asli);
				$pisah = count($pisah_nama_asli);
				$ekstensi = strtolower($pisah_nama_asli[$pisah-1]);
				$ekstensi_asli = ($pisah_nama_asli[$pisah-1]);
				
				$potong_nama=potong_spasi($mata_pelajaran);
				$nama_file="Silabus_".$tahun_berlaku."_".$id."_".$potong_nama;
				$config['upload_path']='./asset/file';
				$config['allowed_types']='pdf|doc|docx';
				$config['max_size']='134217728';
				$config['overwrite']=TRUE;
				$config['file_name']=$nama_file;
				$this->load->library('upload', $config);
				
				$upload_data=$this->upload->data();
				$file=$upload_data['file_name'];
				
				
				$data=array(
					'mata_pelajaran' => $mata_pelajaran,
					'tahun_berlaku' => $tahun_berlaku
				);
				
				if($ekstensi==NULL){
					$this->session->set_flashdata('notifikasi','<div class="ui red message">Peringatan: Silabus tidak dapat ditambahkan tanpa file.</div>');
					$this->session->set_flashdata('mata_pelajaran',$mata_pelajaran);
					$this->session->set_flashdata('tahun',$tahun_berlaku);
				}else{
					if((strcmp($ekstensi,"pdf")==0) or (strcmp($ekstensi,"docx")==0) or (strcmp($ekstensi,"doc")==0)){
						$this->upload->do_upload('file_silabus');
						$data['silabus']=$file.'.'.$ekstensi_asli;
						$this->silabus->masuk_data_silabus($data);
						$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Silabus berhasil ditambahkan dan dipublikasi.</div>');
					}else{
						$this->session->set_flashdata('mata_pelajaran',$mata_pelajaran);
						$this->session->set_flashdata('tahun',$tahun_berlaku);
						$this->session->set_flashdata('notifikasi','<div class="ui red message">Peringatan: Silabus tidak berhasil ditambahkan (format file salah!).</div>');
					}
				}
				
				redirect(base_url('administrator/input_silabus'));
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function edit_silabus(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$data['title']="Edit Data Silabus";
				$tgl_asli = $this->uri->segment(4);
				$temparray=explode('%20',$tgl_asli);
				$temparray[1]="";
				$depan = implode($temparray);
				
				$tgl_asli1 = $this->uri->segment(4);
				$pisah_tgl_asli1 = explode("%20", $tgl_asli1);
				$pisahtgl1 = count($pisah_tgl_asli1);
				$belakang = strtolower($pisah_tgl_asli1[$pisahtgl1-1]);
				$data['tanggal_asle'] = $depan." ".$belakang;
				
				$data['silabus_ed']=$this->silabus->pilih_id_silabus($this->uri->segment(3))->result();
				$data['nama_log']=$this->session->userdata('admin_name');
				$data['level_user']=$this->session->userdata('level_user');
				$this->load->view('admin/edit_silabus', $data);
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function proses_edit_silabus(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$id = $this->input->post('id_silabus');
				$mata_pelajaran = $this->input->post('mapel');
				$tahun_berlaku = $this->input->post('tahun');
				
				$nama_asli = $_FILES['file_silabus']['name'];
				$pisah_nama_asli = explode(".", $nama_asli);
				$pisah = count($pisah_nama_asli);
				$ekstensi = strtolower($pisah_nama_asli[$pisah-1]);
				$ekstensi_asli =($pisah_nama_asli[$pisah-1]);
				
				$potong_nama=potong_spasi($mata_pelajaran);
				$nama_file="Silabus_".$tahun_berlaku."_".$id."_".$potong_nama;
				$config['upload_path']='./asset/file';
				$config['allowed_types']='pdf|doc|docx';
				$config['max_size']='134217728';
				$config['overwrite']=TRUE;
				$config['file_name']=$nama_file;
				$this->load->library('upload', $config);
				
				$upload_data=$this->upload->data();
				$file=$upload_data['file_name'];
				
				
				$check = $this->input->post('tanggal_baru');
				$tanggal_asle = $this->input->post('tanggal_asle');
				if(strcmp($check,"1")==0){
					$data=array(
						'mata_pelajaran' => $mata_pelajaran,
						'tahun_berlaku' => $tahun_berlaku
					);
				}else{
					$data=array(
						'mata_pelajaran' => $mata_pelajaran,
						'tahun_berlaku' => $tahun_berlaku,
						'tgl_posting' => $tanggal_asle
					);
				}
				
				if($ekstensi==NULL){
					$this->silabus->update_data($id,$data);
					$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuab: Silabus telah diperbaharui tanpa mengganti file.</div>');
				}else{
					if((strcmp($ekstensi,"pdf")==0) or (strcmp($ekstensi,"docx")==0) or (strcmp($ekstensi,"doc")==0)){
						$this->upload->do_upload('file');
						$data['silabus']=$file.'.'.$ekstensi_asli;
						$this->silabus->update_data($id,$data);
						$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Silabus berhasil diperbaharui dan dipublikasi.</div>');
					}else{
						$this->session->set_flashdata('notifikasi','<div class="ui red message">Peringatan: Silabus tidak berhasil diperbaharui (format file salah!).</div>');
					}
				}
				
				redirect(base_url('administrator/input_silabus'));
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function hapus_silabus($id_silabus){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$this->silabus->hapus($id_silabus);
				$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Silabus berhasil dihapus.</div>');
				redirect(base_url('administrator/input_silabus'));
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	//Struktur Kurikulum
	public function input_strukturkurikulum($offset=0){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$data['title']="Data Struktur Kurikulum";
				//tentukan jumlah data perhalaman
				$perpage = 15;
				
				//load library pagination
				$this->load->library('pagination');
				
				//konfigurasi tampilan paging
				$config = array(
					'base_url' => base_url('administrator/input_strukturkurikulum'),
					'total_rows' => count($this->strukturkurikulum->pilih_data_strukturkurikulum()->result()),
					'per_page' => $perpage,
					
					'first_link' => '&lt;&lt;',
					'first_tag_open' => '<li>',
					'first_tag_close' => '</li>',

					'last_link' => '&gt;&gt;',
					'last_tag_open' => '<li>',
					'last_tag_close' => '</li>',

					'prev_link'  => '&lt;',
					'prev_tag_open' => '<li>',
					'prev_tag_close' => '</li>',

					'next_link' => '&gt;',
					'next_tag_open' => '<li>',
					'next_tag_close' => '</li>',
					
					'cur_tag_open' => '<li class="active"><a href="#">',
					'cur_tag_close' => '</a></li>',
					
					'num_tag_open' => '<li>',
					'num_tag_close' => '</li>'
				);
				
				//inisialisisasi pagination dan config
				$this->pagination->initialize($config);
				$limit['perpage'] = $perpage;
				$limit['offset'] = $offset;
				
				$data['paginator']=$this->pagination->create_links();
				
				$data['list_strukturkurikulum']=$this->strukturkurikulum->pilih_data_strukturkurikulum($limit)->result();
				$data['jurusan_pil']=$this->profiljurusan->pilih_profiljurusan()->result();
				$data['nama_log']=$this->session->userdata('admin_name');
				$data['j']=($this->uri->segment(3)+1);
				$data['level_user']=$this->session->userdata('level_user');
				$this->load->view('admin/data_strukturkurikulum', $data);
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function proses_input_strukturkurikulum(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$id_jurusan = $this->input->post('jurusan');
				$tahun_berlaku = $this->input->post('tahun');
				
				$cari['kurikulum']=$this->strukturkurikulum->cek_id_kurikulum()->result();
				if(count($cari['kurikulum'])==0){
					$id=1;
				}else{
					$id=($cari['kurikulum'][0]->id_struktur_kurikulum)+1;
				}
				
				$nama_asli = $_FILES['file_strukturkurikulum']['name'];
				$pisah_nama_asli = explode(".", $nama_asli);
				$pisah = count($pisah_nama_asli);
				$ekstensi = strtolower($pisah_nama_asli[$pisah-1]);
				$ekstensi_asli = ($pisah_nama_asli[$pisah-1]);
				
				$nama_file="StrukturKurikulum_".$tahun_berlaku."_".$id."_".$id_jurusan;
				$config['upload_path']='./asset/file';
				$config['allowed_types']='pdf|doc|docx';
				$config['max_size']='134217728';
				$config['overwrite']=TRUE;
				$config['file_name']=$nama_file;
				$this->load->library('upload', $config);
				
				$upload_data=$this->upload->data();
				$file=$upload_data['file_name'];
				
				
				$data=array(
					'id_jurusan' => $id_jurusan,
					'tahun_berlaku' => $tahun_berlaku
				);
				
				if($ekstensi==NULL){
					$this->session->set_flashdata('notifikasi','<div class="ui red message">Pemberitahuan: Struktur Kurikulum tidak berhasil ditambahkan tanpa file.</div>');
						$this->session->set_flashdata('id_jurusan',$id_jurusan);
						$this->session->set_flashdata('tahun',$tahun_berlaku);
				}else{
					if((strcmp($ekstensi,"docx")==0) or (strcmp($ekstensi,"doc")==0) or (strcmp($ekstensi,"pdf")==0)){
						$this->upload->do_upload('file_strukturkurikulum');
						$data['struktur_kurikulum'] = $file.'.'.$ekstensi_asli;
						$this->strukturkurikulum->masuk_data_strukturkurikulum($data);
						$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Struktur Kurikulum berhasil ditambahkan dan dipublikasi.</div>');
					}else{
						$this->session->set_flashdata('notifikasi','<div class="ui red message">Peringatan: Struktur Kurikulum tidak berhasil ditambahkan (format file salah!).</div>');
						$this->session->set_flashdata('id_jurusan',$id_jurusan);
						$this->session->set_flashdata('tahun',$tahun_berlaku);
					}
				}
				
				redirect(base_url('administrator/input_strukturkurikulum'));
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function edit_strukturkurikulum(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$data['title']="Edit Data Struktur Kurikulum";
				
				$tgl_asli = $this->uri->segment(4);
				$temparray=explode('%20',$tgl_asli);
				$temparray[1]="";
				$depan = implode($temparray);
				
				$tgl_asli1 = $this->uri->segment(4);
				$pisah_tgl_asli1 = explode("%20", $tgl_asli1);
				$pisahtgl1 = count($pisah_tgl_asli1);
				$belakang = strtolower($pisah_tgl_asli1[$pisahtgl1-1]);
				$data['tanggal_asle'] = $depan." ".$belakang;
				
				$data['strukturkurikulum_ed']=$this->strukturkurikulum->pilih_id_strukturkurikulum($this->uri->segment(3))->result();
				$data['jurusan_pil']=$this->profiljurusan->pilih_profiljurusan($this->uri->segment(3))->result();
				$data['nama_log']=$this->session->userdata('admin_name');
				$data['level_user']=$this->session->userdata('level_user');
				$this->load->view('admin/edit_strukturkurikulum', $data);
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function proses_edit_strukturkurikulum(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$id = $this->input->post('id_strukturkurikulum');
				$id_jurusan = $this->input->post('jurusan');
				$tahun_berlaku = $this->input->post('tahun');
				
				$nama_asli = $_FILES['file_strukturkurikulum']['name'];
				$pisah_nama_asli = explode(".", $nama_asli);
				$pisah = count($pisah_nama_asli);
				$ekstensi = strtolower($pisah_nama_asli[$pisah-1]);
				$ekstensi = ($pisah_nama_asli[$pisah-1]);
				
				$nama_file="StrukturKurikulum_".$tahun_berlaku."_".$id."_".$id_jurusan;
				$config['upload_path']='./asset/file';
				$config['allowed_types']='pdf|doc|docx';
				$config['max_size']='134217728';
				$config['overwrite']=TRUE;
				$config['file_name']=$nama_file;
				$this->load->library('upload', $config);
				
				$upload_data=$this->upload->data();
				$file=$upload_data['file_name'];
				
				
				$check = $this->input->post('tanggal_baru');
				$tanggal_asle = $this->input->post('tanggal_asle');
				if(strcmp($check,"1")==0){
					$data=array(
						'id_jurusan' => $id_jurusan,
						'tahun_berlaku' => $tahun_berlaku
					);
				}else{
					$data=array(
						'id_jurusan' => $id_jurusan,
						'tahun_berlaku' => $tahun_berlaku,
						'tgl_posting' => $tanggal_asle
					);
				}
				if($ekstensi==NULL){
					$this->strukturkurikulum->update_data($id,$data);
					$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Struktur Kurikulum berhasil diperbaharui tanpa mengganti file.</div>');
				}else{
					if((strcmp($ekstensi,"docx")==0) or (strcmp($ekstensi,"doc")==0) or (strcmp($ekstensi,"pdf")==0)){
						$this->upload->do_upload('file_strukturkurikulum');
						$data['struktur_kurikulum'] = $file.'.'.$ekstensi_asli;
						$this->strukturkurikulum->update_data($id,$data);
						$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Struktur Kurikulum berhasil diperbaharui dan dipublikasi.</div>');
					}else{
						$this->session->set_flashdata('notifikasi','<div class="ui red message">Peringatan: Struktur Kurikulum tidak berhasil diperbaharui (format file salah!).</div>');
					}
				}
				//print_r($data);
				//echo $tanggal_asle." - ".$check;
				redirect(base_url('administrator/input_strukturkurikulum'));
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function hapus_strukturkurikulum($id_strukturkurikulum){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$this->strukturkurikulum->hapus($id_strukturkurikulum);
				$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Struktur Kurikulum berhasil dihapus.</div>');
				redirect(base_url('administrator/input_strukturkurikulum'));
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	// - lihat feedback
	public function lihat_feedback($offset=0){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				$data['lever_user']=$this->session->userdata('level_user');
				redirect(base_url('administrator',$data));
			}else{
				$data['title']="Feedback";
				
				//tentukan jumlah data perhalaman
				$perpage = 15;
				
				//load library pagination
				$this->load->library('pagination');
				
				//konfigurasi tampilan paging
				$config = array(
					'base_url' => base_url('administrator/lihat_feedback'),
					'total_rows' => count($this->feedback->pilih_data_feedback()->result()),
					'per_page' => $perpage,
					
					'first_link' => '&lt;&lt;',
					'first_tag_open' => '<li>',
					'first_tag_close' => '</li>',

					'last_link' => '&gt;&gt;',
					'last_tag_open' => '<li>',
					'last_tag_close' => '</li>',

					'prev_link'  => '&lt;',
					'prev_tag_open' => '<li>',
					'prev_tag_close' => '</li>',

					'next_link' => '&gt;',
					'next_tag_open' => '<li>',
					'next_tag_close' => '</li>',
					
					'cur_tag_open' => '<li class="active"><a href="#">',
					'cur_tag_close' => '</a></li>',
					
					'num_tag_open' => '<li>',
					'num_tag_close' => '</li>'
				);
				
				//inisialisisasi pagination dan config
				$this->pagination->initialize($config);
				$limit['perpage'] = $perpage;
				$limit['offset'] = $offset;
				
				$data['list_feedback']=$this->feedback->pilih_data_feedback($limit)->result();
				$data['paginator']=$this->pagination->create_links();
				$data['i']=($this->uri->segment(3)+1);
				$data['nama_log']=$this->session->userdata('admin_name');
				$data['level_user']=$this->session->userdata('level_user');
				$this->load->view('admin/lihat_feedback', $data);
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function lihat_detail_feedback(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$data['title']="Detail Feedback";
				$data['list_feedback']=$this->feedback->lihat_detail_feedback($this->uri->segment(3))->result();
				$data['nama_log']=$this->session->userdata('admin_name');
				$baca['baca_feedback']="1";
				
				$nama_asli = $this->uri->segment(4);
				$temparray=explode('%20',$nama_asli);
				$temparray[1]="";
				$depan = implode($temparray);
				
				$nama_asli1 = $this->uri->segment(4);
				$pisah_nama_asli1 = explode("%20", $nama_asli1);
				$pisah1 = count($pisah_nama_asli1);
				$belakang = strtolower($pisah_nama_asli1[$pisah1-1]);
				$baca['tgl_posting']=$depan." ".$belakang;
				$data['level_user']=$this->session->userdata('level_user');
				$this->feedback->update_status_feedback($this->uri->segment(3), $baca);
				$this->load->view('admin/lihat_detail_feedback', $data);
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function sudah_tanggapi_feedback(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$balas['balas_feedback']="1";
				
				$nama_asli = $this->uri->segment(4);
				$temparray=explode('%20',$nama_asli);
				$temparray[1]="";
				$depan = implode($temparray);
				
				$nama_asli1 = $this->uri->segment(4);
				$pisah_nama_asli1 = explode("%20", $nama_asli1);
				$pisah1 = count($pisah_nama_asli1);
				$belakang = strtolower($pisah_nama_asli1[$pisah1-1]);
				$balas['tgl_posting']=$depan." ".$belakang;
				$this->feedback->update_status_feedback($this->uri->segment(3), $balas);
				$id = $this->uri->segment(3);
				$subid = $this->uri->segment(4);
				$data['level_user']=$this->session->userdata('level_user');
				redirect(base_url('administrator/lihat_detail_feedback/'.$id.'/'.$subid));
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	//Info PPDB
	public function input_infoppdb($offset=0){
		if(($this->session->userdata('logged_in'))){
			$data['title']="Data Info PPDB";
			
			//tentukan jumlah data perhalaman
			$perpage = 10;
			
			//load library pagination
			$this->load->library('pagination');
			
			//konfigurasi tampilan paging
			$config = array(
				'base_url' => base_url('administrator/input_user'),
				'total_rows' => count($this->infoppdb->pilih_data_infoppdb()->result()),
				'per_page' => $perpage,
				
				'first_link' => '&lt;&lt;',
				'first_tag_open' => '<li>',
				'first_tag_close' => '</li>',

				'last_link' => '&gt;&gt;',
				'last_tag_open' => '<li>',
				'last_tag_close' => '</li>',

				'prev_link'  => '&lt;',
				'prev_tag_open' => '<li>',
				'prev_tag_close' => '</li>',

				'next_link' => '&gt;',
				'next_tag_open' => '<li>',
				'next_tag_close' => '</li>',
				
				'cur_tag_open' => '<li class="active"><a href="#">',
				'cur_tag_close' => '</a></li>',
				
				'num_tag_open' => '<li>',
				'num_tag_close' => '</li>'
			);
			
			//inisialisisasi pagination dan config
			$this->pagination->initialize($config);
			$limit['perpage'] = $perpage;
			$limit['offset'] = $offset;
			
			$data['paginator']=$this->pagination->create_links();
			$data['list_infoppdb']=$this->infoppdb->pilih_data_infoppdb($limit)->result();
			$data['nama_log']=$this->session->userdata('admin_name');
			$data['j']=($this->uri->segment(3)+1);
			$data['level_user']=$this->session->userdata('level_user');
			$this->load->view('admin/data_infoppdb', $data);
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	public function proses_input_infoppdb(){
		if(($this->session->userdata('logged_in'))){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('info', 'Info', 'required');
			
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('notifikasi','<div class="ui red message">Peringatan: Gagal menyimpan data! Silakan isi Info PPDB agar dapat menambah data Info PPDB.</div>');
				
			}else{
				$judul = $this->input->post('judul');
				$info = $this->input->post('info');
				$user = $this->session->userdata('id_login');
				
				$data=array(
					'judul_info_ppdb' => $judul,
					'info_ppdb' => $info,
					'id_user' => $user
				);
			
				$this->infoppdb->masuk_data_infoppdb($data);
				
				$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Info PPDB berhasil disimpan dan diterbitkan.</div>');
			}
			
			redirect(base_url('administrator/input_infoppdb'));
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	public function edit_infoppdb(){
		if(($this->session->userdata('logged_in'))){
			$data['title']="Edit Data Info PPDB";
			$data['infoppdb_ed']=$this->infoppdb->pilih_id_infoppdb($this->uri->segment(3))->result();
			
			$tgl_asli = $this->uri->segment(4);
			$temparray=explode('%20',$tgl_asli);
			$temparray[1]="";
			$depan = implode($temparray);
			
			$tgl_asli1 = $this->uri->segment(4);
			$pisah_tgl_asli1 = explode("%20", $tgl_asli1);
			$pisahtgl1 = count($pisah_tgl_asli1);
			$belakang = strtolower($pisah_tgl_asli1[$pisahtgl1-1]);
			$data['tanggal_asle'] = $depan." ".$belakang;
			
			$data['nama_log']=$this->session->userdata('admin_name');
			$data['level_user']=$this->session->userdata('level_user');
			$this->load->view('admin/edit_infoppdb', $data);
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	public function proses_edit_infoppdb(){
		if(($this->session->userdata('logged_in'))){
			$id = $this->input->post('id_infoppdb');
			$this->load->library('form_validation');
			$this->form_validation->set_rules('info', 'Info', 'required');
			
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('notifikasi','<div class="ui red message">Peringatan: Gagal memperbaharui data! Silakan isi Info PPDB agar dapat memperbaharui data Info PPDB.</div>');
				
			}else{
				$id = $this->input->post['id_infoppdb'];
				$judul = $this->input->post('judul');
				$info = $this->input->post('info');
				$user = $this->session->userdata('id_login');
				
				$check = $this->input->post('tanggal_baru');
				$tanggal_asle = $this->input->post('tanggal_asle');
				if(strcmp($check,"1")==0){
					$data=array(
						'judul_info_ppdb' => $judul,
						'info_ppdb' => $info,
						'id_user' => $user
					);
				}else{
					$data=array(
						'judul_info_ppdb' => $judul,
						'info_ppdb' => $info,
						'id_user' => $user,
						'tgl_posting' => $tanggal_asle
					);
				}
				
				$this->infoppdb->update_data($id, $data);
				
				$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Info PPDB berhasil perbaharui dan diterbitkan kembali.</div>');
			}
			
			redirect(base_url('administrator/input_infoppdb'));
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	public function hapus_infoppdb($id_infoppdb){
		if(($this->session->userdata('logged_in'))){
			$this->infoppdb->hapus($id_infoppdb);
			$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Info PPDB berhasil dihapus.</div>');
			redirect(base_url('administrator/input_infoppdb'));
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	//Agenda
	public function input_agenda(){
		if(($this->session->userdata('logged_in'))){
			$data['title']="Kelola Agenda";
			$data['nama_log']=$this->session->userdata('admin_name');
			$data['level_user']=$this->session->userdata('level_user');
			$this->load->view('admin/data_agenda', $data);
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	public function addEvent(){
		if(($this->session->userdata('logged_in'))){
			$title = $this->input->post('title');
			$start = $this->input->post('start');
			$end = $this->input->post('end');
			$description = $this->input->post('description');
			$color = $this->input->post('color');
			
			$this->M_agenda->addEvent($title, $start, $end, $description, $color);
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	public function deleteEvent($id){
		if(($this->session->userdata('logged_in'))){
			$this->M_agenda->deleteEvent($id);
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	public function getEvent($id){
		if(($this->session->userdata('logged_in'))){
			$kueri = $this->M_agenda->getEvent($id);
			
			while(($resultArray[] = mysql_fetch_assoc($kueri)) || array_pop($resultArray));
			echo json_encode($resultArray);
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	public function getEvents(){
		if(($this->session->userdata('logged_in'))){
			$kueri = $this->M_agenda->getEvents();
			echo json_encode($kueri->result_array());
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	public function updateEvent(){
		if(($this->session->userdata('logged_in'))){
			$id = $this->input->post('id');
			$title = $this->input->post('title');
			$start = $this->input->post('start');
			$end = $this->input->post('end');
			$description = $this->input->post('description');
			
			$this->M_agenda->updateEvent($id, $title, $start, $end, $description);
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	//Ganti Password
	public function ganti_password(){
		if(($this->session->userdata('logged_in'))){
			$data['title']="Ganti Password";
			$data['nama_log']=$this->session->userdata('admin_name');
			$data['level_user']=$this->session->userdata('level_user');
			$data['nama_log']=$this->session->userdata('admin_name');
			$this->load->view('admin/ganti_password', $data);
		}else {
			redirect(base_url('administrator'));
		}
	}
	
	function pass_action(){
		if(($this->session->userdata('logged_in'))){
			$username = $this->session->userdata('username_login', true);
			$password = md5($this->input->post('password_lama', 'true'));
			$temp_account = $this->auth->auth($username, $password)->row();
			
			// check account
			$num_account = count($temp_account);
			
			if (($this->input->post('konfirmasi_password_baru', 'true'))== ($this->input->post('password_baru', 'true'))){
				$pass['password'] = md5($this->input->post('konfirmasi_password_baru', 'true'));
				if ($num_account){
					$this->user->reset($username,$pass);
					$this->session->set_flashdata('notif','<div class="ui blue message">Peringatan : Password berhasil diganti!</div>');
					redirect(base_url('administrator/ganti_password'));
				}
				else {
					// kalau ga ada diredirect lagi ke halaman login
					$this->session->set_flashdata('notif','<div class="ui red message">Peringatan : Password Lama tidak cocok</div>');
					redirect(base_url('administrator/ganti_password'));
				}
			}else{
				$this->session->set_flashdata('notif','<div class="ui red message">Peringatan : konfirmasi password baru tidak cocok</div>');
				redirect(base_url('administrator/ganti_password'));
			}
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	//DARI ASEP
	public function olah_berita($offset=0){
		$logged_in=$this->session->userdata('logged_in');
		if(!$logged_in){
			redirect(base_url('administrator'));
		}else{
			$data['title']="Berita";
			
			//tentukan jumlah data perhalaman
			$perpage = 10;
			
			//load library pagination
			$this->load->library('pagination');
			
			//konfigurasi tampilan paging
			$config = array(
				'base_url' => base_url('administrator/olah_berita'),
				'total_rows' => count($this->adminmodel->select_all_berita()->result()),
				'per_page' => $perpage,
				
				'first_link' => '&lt;&lt;',
				'first_tag_open' => '<li>',
				'first_tag_close' => '</li>',

				'last_link' => '&gt;&gt;',
				'last_tag_open' => '<li>',
				'last_tag_close' => '</li>',

				'prev_link'  => '&lt;',
				'prev_tag_open' => '<li>',
				'prev_tag_close' => '</li>',

				'next_link' => '&gt;',
				'next_tag_open' => '<li>',
				'next_tag_close' => '</li>',
				
				'cur_tag_open' => '<li class="active"><a href="#">',
				'cur_tag_close' => '</a></li>',
				
				'num_tag_open' => '<li>',
				'num_tag_close' => '</li>'
			);
			
			//inisialisisasi pagination dan config
			$this->pagination->initialize($config);
			$limit['perpage'] = $perpage;
			$limit['offset'] = $offset;
			
			$data['paginator']=$this->pagination->create_links();
			
			$data['berita']=$this->adminmodel->select_all_berita($limit)->result();
			$data['j']=($this->uri->segment(3)+1);
			$data['nama_log']=$this->session->userdata('admin_name');
			$data['level_user']=$this->session->userdata('level_user');
			$this->load->view('admin/olah_berita',$data);
		}
	}
	
	public function tambah_berita(){
		$logged_in = $this -> session -> userdata('logged_in');
		if(!$logged_in){
			redirect(base_url('administrator'));
		}else{
			$data['title']="Tambah Berita";
			$data['nama_log']=$this->session->userdata('admin_name');
			$data['level_user']=$this->session->userdata('level_user');
			$this->load->view('admin/tambah_berita', $data);
		}
	}
	
	public function proses_tambah_berita(){
		$logged_in = $this -> session -> userdata('logged_in');
		if(!$logged_in){
			redirect(base_url('administrator'));
		}else{
			$data['judul_berita']=$this->input->post('judul');
			$data['id_user']=$this->session->userdata('id_login');
			$data['berita']=$this->input->post('isi');
			
			$cari['berita']=$this->adminmodel->cek_id_berita()->result();
			if(count($cari['berita'])==0){
				$id=1;
			}else{
				$id=($cari['berita'][0]->id_berita)+1;
			}
			
			$nama_asli = $_FILES['gambar_utama']['name'];
			$pisah_nama_asli = explode(".", $nama_asli);
			$pisah = count($pisah_nama_asli);
			$ekstensi = strtolower($pisah_nama_asli[$pisah-1]);
			$ekstensi_asli = ($pisah_nama_asli[$pisah-1]);
			
			$potong_nama=potong_spasi($this->input->post('judul'));
			$nama_file="Berita_".$id."_".$potong_nama;
			$config['upload_path']='./asset/images';
			$config['allowed_types']='jpeg|jpg|png|gif';
			$config['max_size']='134217728';
			$config['overwrite']=TRUE;
			$config['file_name']=$nama_file;
			$this->load->library('upload', $config);
			
			$upload_data=$this->upload->data();
			$foto=$upload_data['file_name'];
			
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('isi', 'Izi', 'required');
			
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('notifikasi','<div class="ui red message">Peringatan: Form isi berita kosong, silakan lengkapi form untuk menambah berita!</div>');
			}else{
				
				if($ekstensi==NULL){
					$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Berita berhasil ditambahkan, tapi tanpa foto utama.</div>');
				}else{
					if((strcmp($ekstensi,"jpeg")==0) or (strcmp($ekstensi,"jpg")==0) or (strcmp($ekstensi,"png")==0) or (strcmp($ekstensi,"gif")==0)){
						$this->upload->do_upload('gambar_utama');
						$ambil = $this->upload->data();
						$data['gambar_utama']=$foto.".".$ekstensi_asli;
						$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Berita berhasil ditambahkan dan dipublikasi.</div>');
					}else{
						$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Berita berhasil ditambahkan, tapi tanpa foto utama (format foto utama salah).</div>');
					}
				}
				$this->adminmodel->insert_berita($data);
			}
			
			redirect(base_url('administrator/olah_berita'));
		}
	}
	
	public function lihat_berita_detail($id_berita){
		$logged_in = $this -> session -> userdata('logged_in');
		if(!$logged_in){
			redirect(base_url('administrator'));
		}else{
			$data['title']="Detail Berita";
			$data['nama_log']=$this->session->userdata('admin_name');
			$data['level_user']=$this->session->userdata('level_user');
			$data['berita']=$this->adminmodel->select_detail_berita($id_berita)->row();
			$this->load->view('admin/lihat_berita_detail',$data);
		}
	}
	
	public function hapus_berita($id_berita){
		$logged_in = $this -> session -> userdata('logged_in');
		if(!$logged_in){
			redirect(base_url('administrator'));
		}else{
			$this->adminmodel->delete_berita($id_berita);
			$this->session->set_flashdata('sukses','<div class="ui blue message">Berita berhasil dihapus!</div>');
			redirect(base_url('administrator/olah_berita'));
		}
	}
	
	public function edit_berita($id_berita){
		$logged_in = $this -> session -> userdata('logged_in');
		if(!$logged_in){
			redirect(base_url('administrator'));
		}else{
			$data['title']="Edit Berita";
			$data['nama_log']=$this->session->userdata('admin_name');
			$data['level_user']=$this->session->userdata('level_user');
			$data['berita']=$this->adminmodel->select_detail_berita($id_berita)->row();
			
			$tgl_asli = $this->uri->segment(4);
			$temparray=explode('%20',$tgl_asli);
			$temparray[1]="";
			$depan = implode($temparray);
			
			$tgl_asli1 = $this->uri->segment(4);
			$pisah_tgl_asli1 = explode("%20", $tgl_asli1);
			$pisahtgl1 = count($pisah_tgl_asli1);
			$belakang = strtolower($pisah_tgl_asli1[$pisahtgl1-1]);
			$data['tanggal_asle'] = $depan." ".$belakang;
			
			$this->load->view('admin/edit_berita',$data);
		}
	}
	
	public function proses_edit_berita(){
		$logged_in = $this -> session -> userdata('logged_in');
		if(!$logged_in){
			redirect(base_url('administrator'));
		}else{
			
			$id_berita=$this->input->post('id_berita');
			
			$nama_asli = $_FILES['gambar_utama']['name'];
			$pisah_nama_asli = explode(".", $nama_asli);
			$pisah = count($pisah_nama_asli);
			$ekstensi = strtolower($pisah_nama_asli[$pisah-1]);
			$ekstensi_asli = ($pisah_nama_asli[$pisah-1]);
			
			$potong_nama=potong_spasi($this->input->post('judul'));
			$nama_file="Berita_".$id_berita."_".$potong_nama;
			$config['upload_path']='./asset/images';
			$config['allowed_types']='jpeg|jpg|png|gif';
			$config['max_size']='134217728';
			$config['overwrite']=TRUE;
			$config['file_name']=$nama_file;
			$this->load->library('upload', $config);
			
			$upload_data=$this->upload->data();
			$foto=$upload_data['file_name'];
			
			
			$check = $this->input->post('tanggal_baru');
			$tanggal_asle = $this->input->post('tanggal_asle');
			if(strcmp($check,"1")==0){
				$data['judul_berita']=$this->input->post('judul');
				$data['id_user']=$this->session->userdata('id_login');
				$data['berita']=$this->input->post('isi');
			}else{
				$data['judul_berita']=$this->input->post('judul');
				$data['id_user']=$this->session->userdata('id_login');
				$data['berita']=$this->input->post('isi');
				$data['tgl_posting'] = $tanggal_asle;
			}
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('isi', 'Izi', 'required');
			
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('notifikasi','<div class="ui red message">Peringatan: Form isi berita kosong, silakan lengkapi form untuk mengubah berita!</div>');
			}else{
				
				if($ekstensi==NULL){
					$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Gambar utama tidak diperbaharui. Berita berhasil diperbaharui.</div>');
					
				}else{
					if((strcmp($ekstensi,"jpeg")==0)or (strcmp($ekstensi,"jpg")==0) or (strcmp($ekstensi,"png")==0) or (strcmp($ekstensi,"gif")==0)){
						$this->upload->do_upload('gambar_utama');
						$data['gambar_utama']=$foto.".".$ekstensi_asli;
						$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Berita berhasil diperbaharu.</div>');
					}else{
						$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Format gambar utama salah, data gambar utama tidak tersimpan. Berita berhasil diperbaharui.</div>');
					}
				}
				$this->adminmodel->update_berita($id_berita,$data);
			}
			
			redirect(base_url('administrator/olah_berita'));
		}
	}
	
	//Bursa Kerja
	public function olah_bursa_kerja($offset=0){
		$logged_in=$this->session->userdata('logged_in');
		if(!$logged_in){
			redirect(base_url('administrator'));
		}else{
			$data['title']="Bursa Kerja";
			
			//tentukan jumlah data perhalaman
			$perpage = 10;
			
			//load library pagination
			$this->load->library('pagination');
			
			//konfigurasi tampilan paging
			$config = array(
				'base_url' => base_url('administrator/olah_bursa_kerja'),
				'total_rows' => count($this->adminmodel->select_all_bursa_kerja()->result()),
				'per_page' => $perpage,
				
				'first_link' => '&lt;&lt;',
				'first_tag_open' => '<li>',
				'first_tag_close' => '</li>',

				'last_link' => '&gt;&gt;',
				'last_tag_open' => '<li>',
				'last_tag_close' => '</li>',

				'prev_link'  => '&lt;',
				'prev_tag_open' => '<li>',
				'prev_tag_close' => '</li>',

				'next_link' => '&gt;',
				'next_tag_open' => '<li>',
				'next_tag_close' => '</li>',
				
				'cur_tag_open' => '<li class="active"><a href="#">',
				'cur_tag_close' => '</a></li>',
				
				'num_tag_open' => '<li>',
				'num_tag_close' => '</li>'
			);
			
			//inisialisisasi pagination dan config
			$this->pagination->initialize($config);
			$limit['perpage'] = $perpage;
			$limit['offset'] = $offset;
			
			$data['paginator']=$this->pagination->create_links();
			
			$data['bursa_kerja']=$this->adminmodel->select_all_bursa_kerja($limit)->result();
			$data['j']=($this->uri->segment(3)+1);
			$data['nama_log']=$this->session->userdata('admin_name');
			$data['level_user']=$this->session->userdata('level_user');
			$this->load->view('admin/olah_bursa_kerja',$data);
		}
	}
	
	public function tambah_bursa_kerja(){
		$logged_in = $this -> session -> userdata('logged_in');
		if(!$logged_in){
			redirect(base_url('administrator'));
		}else{
			$data['title']="Tambah Bursa Kerja";
			$data['nama_log']=$this->session->userdata('admin_name');
			$data['level_user']=$this->session->userdata('level_user');
			$this->load->view('admin/tambah_bursa_kerja', $data);
		}
	}
	
	public function proses_tambah_bursa_kerja(){
		$logged_in = $this -> session -> userdata('logged_in');
		if(!$logged_in){
			redirect(base_url('administrator'));
		}else{
			$data['judul_bursa_kerja']=$this->input->post('judul');
			$data['bursa_kerja']=$this->input->post('isi');
			
			$cari['bursa']=$this->adminmodel->cek_id_bursa_kerja()->result();
			if(count($cari['bursa'])==0){
				$id=1;
			}else{
				$id=($cari['bursa'][0]->id_bursa_kerja)+1;
			}
			
			$nama_asli = $_FILES['gambar_utama']['name'];
			$pisah_nama_asli = explode(".", $nama_asli);
			$pisah = count($pisah_nama_asli);
			$ekstensi = strtolower($pisah_nama_asli[$pisah-1]);
			$ekstensi_asli = ($pisah_nama_asli[$pisah-1]);
			
			$potong_nama=potong_spasi($this->input->post('judul'));
			$nama_file="BursaKerja_".$id."_".$potong_nama;
			$config['upload_path']='./asset/images';
			$config['allowed_types']='jpeg|jpg|png|gif';
			$config['max_size']='134217728';
			$config['overwrite']=TRUE;
			$config['file_name']=$nama_file;
			$this->load->library('upload', $config);
			
			$upload_data=$this->upload->data();
			$foto=$upload_data['file_name'];
			
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('isi', 'Isi', 'required');
			
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('notifikasi','<div class="ui red message">Peringatan: Form isi bursa kerja kosong, silakan lengkapi form untuk menambah bursa kerja!</div>');
			}else{
				if($ekstensi==NULL){
					$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Bursa Kerja berhasil ditambahkan, tapi tanpa foto utama.</div>');
				}else{
					if((strcmp($ekstensi,"jpeg")==0) or (strcmp($ekstensi,"jpg")==0) or (strcmp($ekstensi,"png")==0) or (strcmp($ekstensi,"gif")==0)){
						$this->upload->do_upload('gambar_utama');
						$ambil = $this->upload->data();
						$data['gambar_utama']=$foto.".".$ekstensi_asli;
						$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Bursa Kerja berhasil ditambahkan dan dipublikasi.</div>');
					}else{
						$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Bursa Kerja berhasil ditambahkan, tapi tanpa foto utama (format foto utama salah).</div>');
					}
				}
				$this->adminmodel->insert_bursa_kerja($data);
			}
			
			redirect(base_url('administrator/olah_bursa_kerja'));
		}
	}
	
	public function lihat_bursa_kerja_detail($id_bursa_kerja){
		$logged_in = $this -> session -> userdata('logged_in');
		if(!$logged_in){
			redirect(base_url('administrator'));
		}else{
			$data['title']="Detail Bursa Kerja";
			$data['nama_log']=$this->session->userdata('admin_name');
			$data['level_user']=$this->session->userdata('level_user');
			$data['bursa_kerja']=$this->adminmodel->select_detail_bursa_kerja($id_bursa_kerja)->row();
			$this->load->view('admin/lihat_bursa_kerja_detail',$data);
		}
	}
	
	public function hapus_bursa_kerja($id_bursa_kerja){
		$logged_in = $this -> session -> userdata('logged_in');
		if(!$logged_in){
			redirect(base_url('administrator'));
		}else{
			$this->adminmodel->delete_bursa_kerja($id_bursa_kerja);
			$this->session->set_flashdata('sukses','<div class="ui blue message">Bursa Kerja berhasil dihapus!</div>');
			redirect(base_url('administrator/olah_bursa_kerja'));
		}
	}
	
	public function edit_bursa_kerja($id_bursa_kerja){
		$logged_in = $this -> session -> userdata('logged_in');
		if(!$logged_in){
			redirect(base_url('administrator'));
		}else{
			$data['title']="Edit Bursa Kerja";
			$data['nama_log']=$this->session->userdata('admin_name');
			$data['level_user']=$this->session->userdata('level_user');
			$data['bursa_kerja']=$this->adminmodel->select_detail_bursa_kerja($id_bursa_kerja)->row();
			
			$tgl_asli = $this->uri->segment(4);
			$temparray=explode('%20',$tgl_asli);
			$temparray[1]="";
			$depan = implode($temparray);
			
			$tgl_asli1 = $this->uri->segment(4);
			$pisah_tgl_asli1 = explode("%20", $tgl_asli1);
			$pisahtgl1 = count($pisah_tgl_asli1);
			$belakang = strtolower($pisah_tgl_asli1[$pisahtgl1-1]);
			$data['tanggal_asle'] = $depan." ".$belakang;
			
			$this->load->view('admin/edit_bursa_kerja',$data);
		}
	}
	
	public function proses_edit_bursa_kerja(){
		$logged_in = $this -> session -> userdata('logged_in');
		if(!$logged_in){
			redirect(base_url('administrator'));
		}else{
			
			$id_bursa_kerja=$this->input->post('id_bursa_kerja');
			
			$nama_asli = $_FILES['gambar_utama']['name'];
			$pisah_nama_asli = explode(".", $nama_asli);
			$pisah = count($pisah_nama_asli);
			$ekstensi = strtolower($pisah_nama_asli[$pisah-1]);
			$ekstensi_asli = ($pisah_nama_asli[$pisah-1]);
			
			$potong_nama=potong_spasi($this->input->post('judul'));
			$nama_file="BursaKerja_".$id_bursa_kerja."_".$potong_nama;
			$config['upload_path']='./asset/images';
			$config['allowed_types']='jpeg|jpg|png|gif';
			$config['max_size']='134217728';
			$config['overwrite']=TRUE;
			$config['file_name']=$nama_file;
			$this->load->library('upload', $config);
			
			$upload_data=$this->upload->data();
			$foto=$upload_data['file_name'];
			
			
			$check = $this->input->post('tanggal_baru');
			$tanggal_asle = $this->input->post('tanggal_asle');
			if(strcmp($check,"1")==0){
				$data['judul_bursa_kerja']=$this->input->post('judul');
				$data['bursa_kerja']=$this->input->post('isi');
			}else{
				$data['judul_bursa_kerja']=$this->input->post('judul');
				$data['bursa_kerja']=$this->input->post('isi');
				$data['tgl_posting'] = $tanggal_asle;
			}
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('isi', 'Isi', 'required');
			
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('notifikasi','<div class="ui red message">Peringatan: Form isi bursa kerja kosong, silakan lengkapi form untuk mengubah bursa kerja!</div>');
			}else{
				
				if($ekstensi==NULL){
					$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Gambar utama tidak diperbaharui. Bursa Kerja berhasil diperbaharui.</div>');
					
				}else{
					if((strcmp($ekstensi,"jpeg")==0)or (strcmp($ekstensi,"jpg")==0) or (strcmp($ekstensi,"png")==0) or (strcmp($ekstensi,"gif")==0)){
						$this->upload->do_upload('gambar_utama');
						$data['gambar_utama']=$foto.".".$ekstensi_asli;
						$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Bursa Kerja berhasil diperbaharu.</div>');
					}else{
						$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Format gambar utama salah, data gambar utama tidak tersimpan. Bursa Kerja berhasil diperbaharui.</div>');
					}
				}
				$this->adminmodel->update_bursa_kerja($id_bursa_kerja,$data);
			}
			
			redirect(base_url('administrator/olah_bursa_kerja'));
		}
	}
	
	// Artikel
	
	public function olah_artikel($offset=0){
		$logged_in = $this -> session -> userdata('logged_in');
		if(!$logged_in){
			redirect(base_url('administrator'));
		}else{
			$data['title']="Artikel";
			//tentukan jumlah data perhalaman
			$perpage = 10;
			
			//load library pagination
			$this->load->library('pagination');
			
			//konfigurasi tampilan paging
			$config = array(
				'base_url' => base_url('administrator/olah_artikel'),
				'total_rows' => count($this->adminmodel->select_all_artikel()->result()),
				'per_page' => $perpage,
				
				'first_link' => '&lt;&lt;',
				'first_tag_open' => '<li>',
				'first_tag_close' => '</li>',

				'last_link' => '&gt;&gt;',
				'last_tag_open' => '<li>',
				'last_tag_close' => '</li>',

				'prev_link'  => '&lt;',
				'prev_tag_open' => '<li>',
				'prev_tag_close' => '</li>',

				'next_link' => '&gt;',
				'next_tag_open' => '<li>',
				'next_tag_close' => '</li>',
				
				'cur_tag_open' => '<li class="active"><a href="#">',
				'cur_tag_close' => '</a></li>',
				
				'num_tag_open' => '<li>',
				'num_tag_close' => '</li>'
			);
			
			//inisialisisasi pagination dan config
			$this->pagination->initialize($config);
			$limit['perpage'] = $perpage;
			$limit['offset'] = $offset;
			
			$data['paginator']=$this->pagination->create_links();
			$data['j']=($this->uri->segment(3)+1);
			$data['artikel']=$this->adminmodel->select_all_artikel($limit)->result();
			$data['nama_log']=$this->session->userdata('admin_name');
			$data['level_user']=$this->session->userdata('level_user');
			$this->load->view('admin/olah_artikel',$data);
		}
	}
	
	public function tambah_artikel(){
		$logged_in = $this -> session -> userdata('logged_in');
		if(!$logged_in){
			redirect(base_url('administrator'));
		}else{
			$data['title']="Tambah Artikel";
			$data['nama_log']=$this->session->userdata('admin_name');
			$data['level_user']=$this->session->userdata('level_user');
			$data['kategori']=$this->kategoriartikel->pilih_data_kategoriartikel()->result();
			$this->load->view('admin/tambah_artikel', $data);
		}
	}
	
	public function proses_tambah_artikel(){
		$logged_in = $this -> session -> userdata('logged_in');
		if(!$logged_in){
			redirect(base_url('administrator'));
		}else{
			$data['judul_artikel']=$this->input->post('judul');
			$data['id_user']=$this->session->userdata('id_login');
			$data['artikel']=$this->input->post('isi');
			$data['id_kategori']=$this->input->post('kategori');
			
			$cari['artikel']=$this->adminmodel->cek_id_artikel()->result();
			if(count($cari['artikel'])==0){
				$id=1;
			}else{
				$id=($cari['artikel'][0]->id_artikel)+1;
			}
			
			$nama_asli = $_FILES['gambar_utama']['name'];
			$pisah_nama_asli = explode(".", $nama_asli);
			$pisah = count($pisah_nama_asli);
			$ekstensi = strtolower($pisah_nama_asli[$pisah-1]);
			$ekstensi_asli = ($pisah_nama_asli[$pisah-1]);
			
			$potong_nama=potong_spasi($this->input->post('judul'));
			$nama_file="Artikel_".$id."_".$potong_nama;
			$config['upload_path']='./asset/images';
			$config['allowed_types']='jpeg|jpg|png|gif';
			$config['max_size']='134217728';
			$config['overwrite']=TRUE;
			$config['file_name']=$nama_file;
			$this->load->library('upload', $config);
			
			$upload_data=$this->upload->data();
			$foto=$upload_data['file_name'];
			
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('isi', 'Izi', 'required');
			
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('notifikasi','<div class="ui red message">Peringatan: Form isi artikel kosong, silakan lengkapi form untuk menambah artikel!</div>');
			}else{
				
				if($ekstensi==NULL){
					$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Artikel berhasil ditambahkan, tapi tanpa foto utama.</div>');
				}else{
					if((strcmp($ekstensi,"jpeg")==0) or (strcmp($ekstensi,"jpg")==0) or (strcmp($ekstensi,"png")==0) or (strcmp($ekstensi,"gif")==0)){
						$this->upload->do_upload('gambar_utama');
						$data['gambar_utama']=$foto.".".$ekstensi_asli;
						$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Artikel berhasil ditambahkan dan dipublikasi.</div>');
					}else{
						$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Artikel berhasil ditambahkan, tapi tanpa foto utama (format foto utama salah).</div>');
					}
				}
				$this->adminmodel->insert_artikel($data);
			}
			
			redirect(base_url('administrator/olah_artikel'));
		}
	}
	
	public function lihat_artikel_detail($id_artikel){
		$logged_in = $this -> session -> userdata('logged_in');
		if(!$logged_in){
			redirect(base_url('administrator'));
		}else{
			$data['title']="Detail Artikel";
			$data['nama_log']=$this->session->userdata('admin_name');
			$data['level_user']=$this->session->userdata('level_user');
			$data['artikel']=$this->adminmodel->select_detail_artikel($id_artikel)->row();
			$this->load->view('admin/lihat_artikel_detail',$data);
		}
	}
	
	public function hapus_artikel($id_artikel){
		$logged_in = $this -> session -> userdata('logged_in');
		if(!$logged_in){
			redirect(base_url('administrator'));
		}else{
			$this->adminmodel->delete_artikel($id_artikel);
			$this->session->set_flashdata('sukses','<div class="ui blue message">Artikel berhasil dihapus!</div>');
			redirect(base_url('administrator/olah_artikel'));
		}
	}
	
	public function edit_artikel($id_artikel){
		$logged_in = $this -> session -> userdata('logged_in');
		if(!$logged_in){
			redirect(base_url('administrator'));
		}else{
			$data['title']="Edit Artikel";
			$data['nama_log']=$this->session->userdata('admin_name');
			$data['level_user']=$this->session->userdata('level_user');
			$data['artikel']=$this->adminmodel->select_detail_artikel($id_artikel)->row();
			$data['kategori']=$this->kategoriartikel->pilih_data_kategoriartikel()->result();
			
			$tgl_asli = $this->uri->segment(4);
			$temparray=explode('%20',$tgl_asli);
			$temparray[1]="";
			$depan = implode($temparray);
			
			$tgl_asli1 = $this->uri->segment(4);
			$pisah_tgl_asli1 = explode("%20", $tgl_asli1);
			$pisahtgl1 = count($pisah_tgl_asli1);
			$belakang = strtolower($pisah_tgl_asli1[$pisahtgl1-1]);
			$data['tanggal_asle'] = $depan." ".$belakang;
			
			$this->load->view('admin/edit_artikel',$data);
		}
	}
	
	public function proses_edit_artikel(){
		$logged_in = $this -> session -> userdata('logged_in');
		if(!$logged_in){
			redirect(base_url('administrator'));
		}else{
			$id_artikel=$this->input->post('id_artikel');
			
			$nama_asli = $_FILES['gambar_utama']['name'];
			$pisah_nama_asli = explode(".", $nama_asli);
			$pisah = count($pisah_nama_asli);
			$ekstensi = strtolower($pisah_nama_asli[$pisah-1]);
			$ekstensi_asli = ($pisah_nama_asli[$pisah-1]);
			
			$potong_nama=potong_spasi($this->input->post('judul'));
			$nama_file="Artikel_".$potong_nama;
			$config['upload_path']='./asset/images';
			$config['allowed_types']='jpeg|jpg|png|gif';
			$config['max_size']='134217728';
			$config['overwrite']=TRUE;
			$config['file_name']=$nama_file;
			$this->load->library('upload', $config);
			
			$upload_data=$this->upload->data();
			$foto=$upload_data['file_name'];
			
			
			$check = $this->input->post('tanggal_baru');
			$tanggal_asle = $this->input->post('tanggal_asle');
			if(strcmp($check,"1")==0){
				$data['judul_artikel']=$this->input->post('judul');
				$data['id_user']=$this->session->userdata('id_login');
				$data['artikel']=$this->input->post('isi');
				$data['id_kategori']=$this->input->post('kategori');
			}else{
				$data['judul_artikel']=$this->input->post('judul');
				$data['id_user']=$this->session->userdata('id_login');
				$data['artikel']=$this->input->post('isi');
				$data['id_kategori']=$this->input->post('kategori');
				$data['tgl_posting'] = $tanggal_asle;
			}
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('isi', 'Izi', 'required');
			
			if ($this->form_validation->run() == FALSE){
				$this->session->set_flashdata('notifikasi','<div class="ui red message">Peringatan: Form isi artikel kosong, silakan lengkapi form untuk mengubah artikel!</div>');
			}else{
				
				if($ekstensi==NULL){
					$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Artikel berhasil diperbaharui, tapi tanpa foto utama.</div>');
				}else{
					if((strcmp($ekstensi,"jpeg")==0) or (strcmp($ekstensi,"jpg")==0) or (strcmp($ekstensi,"png")==0) or (strcmp($ekstensi,"gif")==0)){
						$this->upload->do_upload('gambar_utama');
						$data['gambar_utama']=$foto.".".$ekstensi_asli;
						$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Artikel berhasil diperbahatui dan dipublikasi.</div>');
					}else{
						$this->adminmodel->insert_berita($data);
						$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Artikel berhasil diperbaharui, tapi tanpa foto utama (format foto utama salah).</div>');
					}
				}
				$this->adminmodel->update_artikel($id_artikel,$data);
			}
			
			redirect(base_url('administrator/olah_artikel'));
		}
	}
	
	//Other
	public function input_other($offset=0){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$data['title']="Data Other";
				//tentukan jumlah data perhalaman
				$perpage = 15;
				
				//load library pagination
				$this->load->library('pagination');
				
				//konfigurasi tampilan paging
				$config = array(
					'base_url' => base_url('administrator/input_other'),
					'total_rows' => count($this->other->pilih_data_other()->result()),
					'per_page' => $perpage,
					
					'first_link' => '&lt;&lt;',
					'first_tag_open' => '<li>',
					'first_tag_close' => '</li>',

					'last_link' => '&gt;&gt;',
					'last_tag_open' => '<li>',
					'last_tag_close' => '</li>',

					'prev_link'  => '&lt;',
					'prev_tag_open' => '<li>',
					'prev_tag_close' => '</li>',

					'next_link' => '&gt;',
					'next_tag_open' => '<li>',
					'next_tag_close' => '</li>',
					
					'cur_tag_open' => '<li class="active"><a href="#">',
					'cur_tag_close' => '</a></li>',
					
					'num_tag_open' => '<li>',
					'num_tag_close' => '</li>'
				);
				
				//inisialisisasi pagination dan config
				$this->pagination->initialize($config);
				$limit['perpage'] = $perpage;
				$limit['offset'] = $offset;
				
				$data['paginator']=$this->pagination->create_links();
				$data['list_other']=$this->other->pilih_data_other($limit)->result();
				$data['nama_log']=$this->session->userdata('admin_name');
				$data['level_user']=$this->session->userdata('level_user');
				$data['j']=($this->uri->segment(3)+1);
				$this->load->view('admin/data_other', $data);
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function proses_input_other(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$cari['other']=$this->other->cek_id_other()->result();
				if(count($cari['other'])==0){
					$id=1;
				}else{
					$id=($cari['other'][0]->id_other)+1;
				}
				//print_r($data_other['other'][0]->id_other); echo "<br/>";
				//print_r($data_other); echo "<br/>";
				//echo $data_other['other']->id_other."<br/>";
				//echo $data_other->id_other."<br/>";
				//echo $id."<br/>";
				$nama_asli = $_FILES['file_other']['name'];
				$pisah_nama_asli = explode(".", $nama_asli);
				$pisah = count($pisah_nama_asli);
				$ekstensi = strtolower($pisah_nama_asli[$pisah-1]);
				$ekstensi_asli = ($pisah_nama_asli[$pisah-1]);
				
				$potong_nama=potong_spasi($judul_upload);
				$nama_file="downloadother_".$id."_".$potong_nama;
				$config['upload_path']='./asset/file';
				$config['allowed_types']='pdf|doc|docx';
				$config['max_size']='134217728';
				$config['overwrite']=TRUE;
				$config['file_name']=$nama_file;
				$this->load->library('upload', $config);
				
				$upload_data=$this->upload->data();
				$file=$upload_data['file_name'];
				
				
				$data=array(
					'judul_upload' => $judul_upload
				);
				
				if($ekstensi==NULL){
					$this->session->set_flashdata('notifikasi','<div class="ui red message">Peringatan: Data tidak dapat ditambahkan tanpa file.</div>');
					$this->session->set_flashdata('judul',$judul_upload);
				}else{
					if((strcmp($ekstensi,"pdf")==0) or (strcmp($ekstensi,"docx")==0) or (strcmp($ekstensi,"doc")==0)){
						$this->upload->do_upload('file_other');
						$data['file_upload']=$file.'.'.$ekstensi_asli;
						$this->other->masuk_data_other($data);
						$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Data berhasil ditambahkan dan dipublikasi.</div>');
					}else{
						$this->session->set_flashdata('judul',$judul_upload);
						$this->session->set_flashdata('notifikasi','<div class="ui red message">Peringatan: Data tidak berhasil ditambahkan (format file salah!).</div>');
					}
				}
				
				redirect(base_url('administrator/input_other'));
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function edit_other(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$data['title']="Edit Data Other";
				$data['other_ed']=$this->other->pilih_id_other($this->uri->segment(3))->result();
				
				$tgl_asli = $this->uri->segment(4);
				$temparray=explode('%20',$tgl_asli);
				$temparray[1]="";
				$depan = implode($temparray);
				
				$tgl_asli1 = $this->uri->segment(4);
				$pisah_tgl_asli1 = explode("%20", $tgl_asli1);
				$pisahtgl1 = count($pisah_tgl_asli1);
				$belakang = strtolower($pisah_tgl_asli1[$pisahtgl1-1]);
				$data['tanggal_asle'] = $depan." ".$belakang;
				
				$data['nama_log']=$this->session->userdata('admin_name');
				$data['level_user']=$this->session->userdata('level_user');
				$this->load->view('admin/edit_other', $data);
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function proses_edit_other(){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$id = $this->input->post('id_other');
				$judul_upload = $this->input->post('judul');
				$nama_asli = $_FILES['file_other']['name'];
				$pisah_nama_asli = explode(".", $nama_asli);
				$pisah = count($pisah_nama_asli);
				$ekstensi = strtolower($pisah_nama_asli[$pisah-1]);
				$ekstensi_asli = ($pisah_nama_asli[$pisah-1]);
				
				$potong_nama=potong_spasi($judul_upload);
				$nama_file="downloadother_".$id."_".$potong_nama;
				$config['upload_path']='./asset/file';
				$config['allowed_types']='pdf|doc|docx';
				$config['max_size']='134217728';
				$config['overwrite']=TRUE;
				$config['file_name']=$nama_file;
				$this->load->library('upload', $config);
				
				$upload_data=$this->upload->data();
				$file=$upload_data['file_name'];
				
				
				$check = $this->input->post('tanggal_baru');
				$tanggal_asle = $this->input->post('tanggal_asle');
				if(strcmp($check,"1")==0){
					$data=array(
						'judul_upload' => $judul_upload
					);
				}else{
					$data=array(
						'judul_upload' => $judul_upload,
						'tgl_posting' => $tanggal_asle
					);
				}
				
				if($ekstensi==NULL){
					$this->other->update_data($id,$data);
					$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Data diperbaharui tanpa mengganti file.</div>');
				}else{
					if((strcmp($ekstensi,"pdf")==0) or (strcmp($ekstensi,"docx")==0) or (strcmp($ekstensi,"doc")==0)){
						$this->upload->do_upload('file_other');
						$data['file_upload']=$file.'.'.$ekstensi_asli;
						$this->other->update_data($id,$data);
						$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Data berhasil diperbaharui dan dipublikasi.</div>');
					}else{
						$this->session->set_flashdata('notifikasi','<div class="ui red message">Peringatan: Data tidak berhasil diperbaharui (format file salah!).</div>');
					}
				}
				
				redirect(base_url('administrator/input_other'));
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	public function hapus_other($id_other){
		if($this->session->userdata('logged_in')){
			if(($this->session->userdata('level_user'))==3){
				redirect(base_url('administrator'));
			}else{
				$this->other->hapus($id_other);
				$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Silabus berhasil dihapus.</div>');
				redirect(base_url('administrator/input_other'));
			}
		}else{
			redirect(base_url('administrator/auth'));
		}
	}
	
	//absensi
	function siswa(){
			$data['kelas'] = $this->M_absensi->ambil_kelas()->result();
			$data['level_user']=$this->session->userdata('level_user');
			$data['title']="Data Siswa";
			$data['nama_log']=$this->session->userdata('admin_name');
			
			$this->load->view('absen/siswa', $data);
		}
		function lihat_siswa(){
			$kelas = $this->input->post('id_kelas');
			$jumlah = $this->M_absensi->hitung_siswa($kelas);
			
			// $config['base_url'] = base_url().'index.php/absen/absensi/lihat_siswa/';
			// $config['total_rows'] = $jumlah;
			// $config['per_page'] = 10;
			// $config['uri_segment'] = 4;
			
			// $perpage = 10;
			
			// $config = array(
				// 'base_url' => base_url().'index.php/absen/absensi/lihat_siswa/',
				// 'total_rows' => $jumlah,
				// 'per_page' => $perpage,
			
				// 'first_link' => '&laquo;',
				// 'first_tag_open' => '<li>',
				// 'first_tag_close' => '</li>',

				// 'last_link' => '&raquo;',
				// 'last_tag_open' => '<li>',
				// 'last_tag_close' => '</li>',

				// 'prev_link'  => '&larr;',
				// 'prev_tag_open' => '<li>',
				// 'prev_tag_close' => '</li>',

				// 'next_link' => '&rarr;',
				// 'next_tag_open' => '<li>',
				// 'next_tag_close' => '</li>',
				
				// 'cur_tag_open' => '<li class="active"><a href="#">',
				// 'cur_tag_close' => '</a></li>',
				
				// 'num_tag_open' => '<li>',
				// 'num_tag_close' => '</li>'
			// );
			
			// $this->pagination->initialize($config);
			//echo $kelas;
			// $dari = $this->uri->segment(4, 0);
			$data['siswa'] = $this->M_absensi->lihat_siswa($kelas)->result();
			// $data['dari'] = $dari+1;
			$data['level_user']=$this->session->userdata('level_user');
			$data['title']="Data Siswa";
			$data['nama_log']=$this->session->userdata('admin_name');
			
			$this->load->view('absen/lihat_siswa', $data);
		}
		
		function form_input(){
			$data['kelas'] = $this->M_absensi->ambil_kelas()->result();
			$data['level_user']=$this->session->userdata('level_user');
			$data['title']="Input Data Siswa";
			$data['nama_log']=$this->session->userdata('admin_name');
			
			$this->load->view("absen/form_input_siswa", $data);
		}
		
		function proses_input(){
			if($this->session->userdata('logged_in')){
				$nis = $this->input->post('nis');
				$nama = $this->input->post('nama');
				$jenis_kelamin = $this->input->post('jk');
				$kelas = $this->input->post('kelas');
				$username = $nis;
				$password = md5($nis);
				$cek_nis = $this->M_absensi->cek_nis($nis)->row();
				
				if (count($cek_nis)==0){
					
					$data_other['other']=$this->M_absensi->cek_id_siswa()->result();
					if(count($data_other['other'])==0){
						$id=1;
					}else{
						$id=($data_other['other'][0]->id_siswa)+1;
					}
				
					$potong_nama=potong_spasi($nama);
					$nama_file="siswa_".$id;
					
					$nama_asli = $_FILES['foto']['name'];
					$pisah_nama_asli = explode(".", $nama_asli);
					$pisah = count($pisah_nama_asli);
					$ekstensi = strtolower($pisah_nama_asli[$pisah-1]);
					$ekstensi_asli = ($pisah_nama_asli[$pisah-1]);
					
					$config['upload_path']='./asset/img/siswa';
					$config['allowed_types']='png|jpg';
					$config['max_size']='134217728';
					$config['overwrite']=TRUE;
					$config['file_name']=$nama_file;
					$this->load->library('upload', $config);
					
					$upload_data=$this->upload->data();
					$foto=$upload_data['file_name'];
					
					if($ekstensi==NULL){
						if(strcmp($jenis_kelamin,"P")==0){
							$data_siswa=array(
								'nis' => $nis,
								'nama' => $nama,
								'jenis_kelamin' => $jenis_kelamin,
								'username' => $username,
								'password' => $password,
								'id_kelas' => $kelas,
								'foto' => "pegawai_female_default.jpg"
							);
						}else{
							$data_siswa=array(
								'nis' => $nis,
								'nama' => $nama,
								'jenis_kelamin' => $jenis_kelamin,
								'username' => $username,
								'password' => $password,
								'id_kelas' => $kelas,
								'foto' => "pegawai_male_default.jpg"
							);
						}
						$this->M_absensi->proses_input_siswa($data_siswa);
						$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Data Siswa berhasil ditambah dengan foto default, silakan update data untuk menambahkan foto.</div>');
						
						echo count($cek_nis);
						redirect('administrator/form_input');
						
					}elseif($ekstensi!=NULL){
						if((strcmp($ekstensi,"jpeg")==0) OR (strcmp($ekstensi,"jpg")==0) OR (strcmp($ekstensi,"png")==0) OR (strcmp($ekstensi,"gif")==0)){
							$this->upload->do_upload('foto');
							$data_siswa=array(
								'nis' => $nis,
								'nama' => $nama,
								'jenis_kelamin' => $jenis_kelamin,
								'username' => $username,
								'password' => $password,
								'id_kelas' => $kelas,
								'foto' => $foto.".".$ekstensi_asli
								
							);
							$this->M_absensi->proses_input_siswa($data_siswa);
							$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Data Siswa berhasil ditambah.</div>');

						}else{
							if(strcmp($jenis_kelamin,"P")==0){
								$data_siswa['foto']="pegawai_female_default.jpg";
							}else{
								$data_siswa['foto']="pegawai_male_default.jpg";
							}
							$data_siswa=array(
								'nis' => $nis,
								'nama' => $nama,
								'jenis_kelamin' => $jenis_kelamin,
								'username' => $username,
								'password' => $password,
								'id_kelas' => $kelas
							);
							$this->M_absensi->proses_input_siswa($data_siswa);
							$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Data Siswa berhasil ditambah dengan foto default <stong>(karena format salah)</strong>, silakan update data untuk menambahkan foto.</div>');
							redirect('administrator/form_input');
						}
					}
					
					//$this->M_absensi->proses_input_siswa($data_siswa);
					redirect('administrator/form_input');
				
				}else{
					
					$this->session->set_flashdata('notifikasi','<div class="ui red message">Pemberitahuan: NIS sudah digunakan .</div>');
					redirect('administrator/form_input');
				}
				
			}else{
			redirect(base_url('administrator/auth'));
			}
		}
		
		function edit_siswa($nis){
			if($this->session->userdata('logged_in')){
				$data['siswa'] = $this->M_absensi->ambil_edit_siswa($nis)->row();
				$data['kelas'] = $this->M_absensi->ambil_kelas()->result();
				$data['level_user']=$this->session->userdata('level_user');
				$data['title']="Edit Data Siswa";
				$data['nama_log']=$this->session->userdata('admin_name');
				
				$this->load->view('absen/form_edit_siswa', $data);
			}else{
				redirect(base_url('administrator/auth'));
			}
		}
		
		function proses_edit(){
			if($this->session->userdata('logged_in')){
				$nis = $this->input->post('nis');
				$nama = $this->input->post('nama');
				$jenis_kelamin = $this->input->post('jk');
				$kelas = $this->input->post('kelas');
				
				$potong_nama=potong_spasi($nama);
				$nama_file="pegawai_".$id;
				
				$nama_asli = $_FILES['foto']['name'];
				$pisah_nama_asli = explode(".", $nama_asli);
				$pisah = count($pisah_nama_asli);
				$ekstensi = strtolower($pisah_nama_asli[$pisah-1]);
				$ekstensi_asli = ($pisah_nama_asli[$pisah-1]);
				
				$config['upload_path']='./asset/img/siswa';
				$config['allowed_types']='png|jpg';
				$config['max_size']='134217728';
				$config['overwrite']=TRUE;
				$config['file_name']=$nama_file;
				$this->load->library('upload', $config);
				
				$upload_data=$this->upload->data();
				$foto=$upload_data['file_name'];
				$this->upload->do_upload('foto');
				
				if($ekstensi==NULL){
					$data_siswa=array(
						'nis' => $nis,
						'nama' => $nama,
						'jenis_kelamin' => $jenis_kelamin,
						'username' => $username,
						'password' => $password,
						'id_kelas' => $kelas,
						'foto' => $foto.".".$ekstensi_asli
					);
					
					$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Data Siswa berhasil diperbaharui tanpa mengganti foto.</div>');
				}elseif($ekstensi!=NULL){
					if((strcmp($ekstensi,"jpeg")==0) or (strcmp($ekstensi,"jpg")==0) or (strcmp($ekstensi,"png")==0) or (strcmp($ekstensi,"gif")==0)){
						
						$data_siswa=array(
							'nis' => $nis,
							'nama' => $nama,
							'jenis_kelamin' => $jenis_kelamin,
							'username' => $username,
							'password' => $password,
							'id_kelas' => $kelas,
							'foto' => $foto.".".$ekstensi_asli
						);
					
						$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Data Siswa berhasil perbaharui.</div>');
					}else{
						$data_siswa=array(
							'nis' => $nis,
							'nama' => $nama,
							'jenis_kelamin' => $jenis_kelamin,
							'username' => $username,
							'password' => $password,
							'id_kelas' => $kelas
						);
						
						$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Data Siswa berhasil diperbaharui tanpa mengganti foto <stong>(karena format salah)</strong>, silakan update foto baru dengan format yang benar.</div>');
					}
				}
				
				$this->M_absensi->proses_edit_siswa($data_siswa);
				redirect('administrator/siswa');
			}else{
				redirect(base_url('administrator/auth'));
			}
		}
		
		function delete_siswa($nis){
			$this->M_absensi->delete_siswa($nis);
			
			redirect('administrator/siswa');
		}
		
		function daftar_absen(){
			$data['kelas'] = $this->M_absensi->ambil_kelas()->result();
			$data['level_user']=$this->session->userdata('level_user');
			$data['title']="Daftar Absen Siswa";
			$data['nama_log']=$this->session->userdata('admin_name');
			//$data['siswa'] = $this->M_absensi->lihat_siswa($kelas)->result();
			
			$this->load->view('absen/daftar_absen', $data);
			//$this->load->view('absen/bebaslahapaaja', $data);
		}
		
		function load_absen(){
			$id_kelas = $this->input->post('id_kelas');
			$cari = $this->input->post('cari');
			if($id_kelas !== 0 && $cari !== 0){
				$id_kelas = $this->input->post('id_kelas');
				$cari = $this->input->post('cari');
				 $data['siswa'] = $this->M_absensi->lihat_siswa_absen2($id_kelas, $cari)->result();
				$this->load->view('absen/absen', $data);
			}
			else{
				$id_kelas = $this->input->post('id_kelas');
			
				$data['siswa'] = $this->M_absensi->lihat_siswa_absen($id_kelas)->result();
				$this->load->view('absen/absen', $data);
			 }
		}
		
		function input_absen($nis, $ket){
			$this->M_absensi->input_absen($nis, $ket);
			
			redirect('administrator/daftar_absen');
		}
		
		function input_absen2(){
			$nis = $this->input->post('nis');
			$absen = $this->input->post('izin');
			$keterangan = $this->input->post('keterangan');
			
			$this->M_absensi->input_absen2($nis, $absen, $keterangan);
			redirect('administrator/daftar_absen');
		}
		
		function rekap_absen(){
			$data['siswa'] = $this->M_absensi->rekap_absen()->result();
			$data['level_user']=$this->session->userdata('level_user');
			$data['title']="Rekap Absen Siswa";
			$data['nama_log']=$this->session->userdata('admin_name');
			
			$this->load->view('absen/rekap_absen', $data);
		}
		
		function rekap_absensi(){
			$data['kelas'] = $this->M_absensi->ambil_kelas()->result();
			$data['level_user']=$this->session->userdata('level_user');
			$data['title']="Rekap Absen Siswa";
			$data['nama_log']=$this->session->userdata('admin_name');
			
			$this->load->view('absen/rekap_absensi', $data);
		}
		
		function rekap_absen2(){
			$datas = $this->session->userdata();
			$bulan = $this->input->post('bulan');
			$tahun = $this->input->post('tahun');
			$kelas = $this->input->post('kelas');
			$data['siswa'] = $this->M_absensi->rekap_absen2($bulan, $tahun, $kelas)->result();
			$data['detail'] = $this->M_absensi->detail($bulan, $tahun)->result();
			$data['bulan'] = $bulan;
			$data['tahun'] = $tahun;
			$this->load->view('absen/rekap_absen2', $data);
		}
		
		function delete_rekap_absen($id_absensi){
			$this->M_absensi->delete_rekap_absen($id_absensi);
			
			redirect('administrator/daftar_absen');
		}
		
	//Kelas
	public function input_kelas($offset=0){
		if($this->session->userdata('logged_in')){
			$data['title']="Data Kelas";
			
			//tentukan jumlah data perhalaman
			$perpage = 10;
			
			//load library pagination
			$this->load->library('pagination');
			
			//konfigurasi tampilan paging
			$config = array(
				'base_url' => base_url('administrator/input_kelas'),
				'total_rows' => count($this->M_absensi->pilih_data_kelas()->result()),
				'per_page' => $perpage,
				
				'first_link' => '&lt;&lt;',
				'first_tag_open' => '<li>',
				'first_tag_close' => '</li>',

				'last_link' => '&gt;&gt;',
				'last_tag_open' => '<li>',
				'last_tag_close' => '</li>',

				'prev_link'  => '&lt;',
				'prev_tag_open' => '<li>',
				'prev_tag_close' => '</li>',

				'next_link' => '&gt;',
				'next_tag_open' => '<li>',
				'next_tag_close' => '</li>',
				
				'cur_tag_open' => '<li class="active"><a href="#">',
				'cur_tag_close' => '</a></li>',
				
				'num_tag_open' => '<li>',
				'num_tag_close' => '</li>'
			);
			
			//inisialisisasi pagination dan config
			$this->pagination->initialize($config);
			$limit['perpage'] = $perpage;
			$limit['offset'] = $offset;
			
			$data['paginator']=$this->pagination->create_links();
			$data['list_kelas']=$this->M_absensi->pilih_data_kelas($limit)->result();
			$data['nama_log']=$this->session->userdata('admin_name');
			$data['j']=($this->uri->segment(3)+1);
			$data['level_user']=$this->session->userdata('level_user');
			$this->load->view('absen/kelas', $data);
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	public function proses_input_kelas(){
		if($this->session->userdata('logged_in')){
			$kelas = $this->input->post('kelas');
			if(count($this->M_absensi->cari_kelas($kelas)->result())==0){
				$data=array(
					'kelas' => $kelas
				);
				$this->M_absensi->masuk_data_kelas($data);
				
				$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Kategori artikel berhasil ditambahkan.</div>');
			}else{
				$this->session->set_flashdata('notifikasi','<div class="ui red message">Peringatan: Kategori artikel sudah ada!</div>');
			}
			
			redirect(base_url('administrator/input_kelas'));
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	public function edit_kelas(){
		if($this->session->userdata('logged_in')){
			$data['title']="Edit Data Kelas";
			$data['kelas_ed']=$this->M_absensi->pilih_id_kelas($this->uri->segment(3))->result();
			$data['nama_log']=$this->session->userdata('admin_name');
			$data['level_user']=$this->session->userdata('level_user');
			$this->load->view('absen/edit_kelas', $data);
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	public function proses_edit_kelas(){
		if($this->session->userdata('logged_in')){
			$id = $this->input->post('id_kelas');
			$kelas = $this->input->post('kelas');
			if($kelas!=""){
				if(count($this->M_absensi->cari_kelas($kelas)->result())==0){
					$data=array(
						'kelas' => $kelas
					);
					$this->M_absensi->update_data($id, $data);
					
					$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Kategori artikel berhasil ditambahkan.</div>');
				}else{
					$this->session->set_flashdata('notifikasi','<div class="ui red message">Peringatan: Kategori artikel sudah ada!</div>');
				}
			}else{
				$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Kategori artikel tidak ada perubahan.</div>');
			}
			
			redirect(base_url('administrator/input_kelas'));
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	public function hapus_kelas($id_kelas){
		if($this->session->userdata('logged_in')){
			$this->M_absensi->hapus_kelas($id_kelas);
			$this->session->set_flashdata('notifikasi','<div class="ui blue message">Pemberitahuan: Data berhasil dihapus</div>');
			redirect(base_url('administrator/input_kelas'));
		}else{
			redirect(base_url('administrator'));
		}
	}
	
	function detail_absen($nis, $bulan, $tahun){
		if($this->session->userdata('logged_in')){
			$data['nama_log']=$this->session->userdata('admin_name');
			$data['detail'] = $this->M_absensi->detail_absen($nis, $bulan, $tahun)->result();
			$this->load->view('absen/detail_absen', $data);
		}
		else{
			redirect(base_url('administrator'));
		}
	}
}
