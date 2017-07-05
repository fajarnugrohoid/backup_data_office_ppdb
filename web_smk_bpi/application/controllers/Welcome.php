<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('potong_spasi');
		$this->load->helper(array('url','download'));
		$this->load->helper('date');
		$this->load->helper('text');
		$this->load->helper('form');
		$this->load->helper('potong_spasi');
		$this->load->model('kepegawaian');
		$this->load->model('jabatan');
		$this->load->model('golongan');
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
		$this->load->model('galeri');
		$this->load->model('feedback');
		$this->load->model('infoppdb');
		$this->load->model('M_agenda');
		$this->load->model('M_absensi');
		$this->load->model('M_ortu');
		$this->load->library('form_validation');
		$this->load->library('table');
		$this->load->library('cart');
		$this->load->library('pagination');
	}
	
	public function index(){
		//$this->load->view('welcome_message');
		$data['data']=$this->kategoriartikel->show_artikel()->result();
		$data['berita']=$this->kategoriartikel->show_berita()->result();
		$data['bursa']=$this->kategoriartikel->show_bursa_kerja()->result();
		$data['info'] = $this->infoppdb->pilih_infoppdb()->result();
		$data['profilsekolah_pil']=$this->profilsekolah->pilih_profilsekolah()->result();
		$data['visimisi_pil']=$this->visimisi->pilih_visimisi()->result();
		$data['slide_artikel']=$this->kategoriartikel->slide_artikel()->result();
		$data['slide_berita']=$this->kategoriartikel->slide_berita()->result();
		$data['slide_infoppdb']=$this->infoppdb->slide_infoppdb()->result();
		$data['down']=$this->other->other_beranda()->result();
		$this->load->view('index', $data);
	}
	
	//profil
	
	public function lihat_profil($offset = 0){
		$data['title']="Profil Sekolah";
		
		$this->load->library("pagination");
			
		//tentukan jumlah data perhalaman
		$perpage = 8;
		
		//load library pagination
		$this->load->library('pagination');
		
		//konfigurasi tampilan paging
		$config = array(
			'base_url' => base_url('welcome/lihat_profil'),
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
		$data['profilsekolah_pil']=$this->profilsekolah->pilih_profilsekolah()->result();
		$data['kepsek']=$this->kepegawaian->get_kepsek()->row();
		$data['visimisi_pil']=$this->visimisi->pilih_visimisi()->result();
		$data['profiljurusan_pil']=$this->profiljurusan->pilih_data_profiljurusan($limit)->result();
		//print_r($data['profiljurusan_pil']);
		$this->load->view('profil', $data);
	}
	
	public function lihat_profiljurusan($offset = 0){
		$data['title']="Profil Jurusan";
		
		$this->load->library("pagination");
			
		//tentukan jumlah data perhalaman
		$perpage = 8;
		
		//load library pagination
		$this->load->library('pagination');
		
		//konfigurasi tampilan paging
		$config = array(
			'base_url' => base_url('welcome/lihat_profil'),
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
		$data['profilsekolah_pil']=$this->profilsekolah->pilih_profilsekolah()->result();
		$data['visimisi_pil']=$this->visimisi->pilih_visimisi()->result();
		$data['profiljurusan_pil']=$this->profiljurusan->pilih_data_profiljurusan($limit)->result();
		//print_r($data['profiljurusan_pil']);
		$this->load->view('profil_profiljurusan', $data);
	}
	
	public function lihat_profil_jurusan(){
		$data['title']="Detail Profil Jurusan";
		$data['profilsekolah_pil']=$this->profilsekolah->pilih_profilsekolah()->result();
		$data['profiljurusan_pil']=$this->profiljurusan->pilih_id_profiljurusan($this->uri->segment(3))->result();
		$this->load->view('profil_jurusan', $data);
	}
	
	//kepegawaian
	
	public function lihat_pegawai($offset = 0){
		$data['title']="Kepegawaian";
		$data['list_kepegawaian']=$this->kepegawaian->pilih_data_kepegawaian()->result();
		$data['jabatan_pil']=$this->jabatan->pilih_jabatan($this->uri->segment(3))->result();
		$data['profilsekolah_pil']=$this->profilsekolah->pilih_profilsekolah()->result();
	
		$this->load->library("table");
		$this->load->library("pagination");
		
		//tentukan jumlah data perhalaman
		$perpage = 20;
		
		//load library pagination
		$this->load->library('pagination');
		
		//konfigurasi tampilan paging
		$config = array(
			'base_url' => base_url('welcome/lihat_pegawai'),
			'total_rows' => count($this->kepegawaian->select_all_paging_peg()->result()),
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
		$data['i']=($this->uri->segment(3)+1);
		$data['paginator']=$this->pagination->create_links();
		$data['listData'] = $this->kepegawaian->pilih_data_kepegawaian($limit)->result();
		$data['cari']= "";
		$data['data_search'] = $this->kepegawaian->get_all_search();
		$data['hasil_search']=$data['data_search']->num_rows();
		$this->load->view("pegawai", $data);
		
	}
	
	public function lihat_galeri($offset=0){
		$data['title']="Galeri";
		$data['profilsekolah_pil']=$this->profilsekolah->pilih_profilsekolah()->result();
		
		//tentukan jumlah data perhalaman
		$perpage = 12;
		
		//load library pagination
		$this->load->library('pagination');
		
		//konfigurasi tampilan paging
		$config = array(
			'base_url' => base_url('welcome/lihat_galeri'),
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
		
		$data['list_galeri']=$this->galeri->select_all_paging_galeri($limit)->result();
		$data['paginator']=$this->pagination->create_links();
		$this->load->view('galeri',$data);
	}
	
	public function lihat_ekstrakulikuler($offset=0){
		$data['title']="Ekstrakulikuler";
		
		//tentukan jumlah data perhalaman
		$perpage = 10;
		
		//load library pagination
		$this->load->library('pagination');
		
		//konfigurasi tampilan paging
		$config = array(
			'base_url' => base_url('welcome/lihat_ekstrakulikuler'),
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
		$data['i']=($this->uri->segment(3)+1);
		
		$data['list_ekskul']=$this->ekstrakulikuler->pilih_data_ekstrakulikuler_list($limit)->result();
		$data['profilsekolah_pil']=$this->profilsekolah->pilih_profilsekolah()->result();
		$this->load->view('ekstrakulikuler', $data);
	}
	
	public function lihat_kurikulum(){
		$data['title']="Kurikulum";
		//tentukan jumlah data perhalaman
		$perpage = 10;
		
		//load library pagination
		$this->load->library('pagination');
		
		//konfigurasi tampilan paging
		$config = array(
			'base_url' => base_url('welcome/lihat_kurikulum'),
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
		$limit['offset'] = $this->uri->segment(3);
		
		$data['paginator']=$this->pagination->create_links();
		$data['j']=($this->uri->segment(3)+1);
		$data['list_strukturkurikulum']=$this->strukturkurikulum->pilih_data_strukturkurikulum($limit)->result();
		$data['list_silabus']=$this->silabus->pilih_data_silabus()->result();
		$data['list_other']=$this->other->pilih_data_other()->result();
		$data['profilsekolah_pil']=$this->profilsekolah->pilih_profilsekolah()->result();
		$this->load->view('kurikulum', $data);
	}
	
	public function lihat_silabus(){
		$data['title']="Silabus";
		//tentukan jumlah data perhalaman
		$perpage = 10;
		
		//load library pagination
		$this->load->library('pagination');
		
		//konfigurasi tampilan paging
		$config = array(
			'base_url' => base_url('welcome/lihat_silabus'),
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
		$limit['offset'] = $this->uri->segment(3);
		
		$data['paginator']=$this->pagination->create_links();
		$data['j']=($this->uri->segment(3)+1);
		$data['list_strukturkurikulum']=$this->strukturkurikulum->pilih_data_strukturkurikulum()->result();
		$data['list_silabus']=$this->silabus->pilih_data_silabus($limit)->result();
		$data['list_other']=$this->other->pilih_data_other()->result();
		$data['profilsekolah_pil']=$this->profilsekolah->pilih_profilsekolah()->result();
		$this->load->view('silabus', $data);
	}
	
	public function lihat_download(){
		$data['title']="Download Lainnya";
		//tentukan jumlah data perhalaman
		$perpage = 15;
		
		//load library pagination
		$this->load->library('pagination');
		
		//konfigurasi tampilan paging
		$config = array(
			'base_url' => base_url('welcome/lihat_download'),
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
		$limit['offset'] = $this->uri->segment(3);
		
		$data['paginator']=$this->pagination->create_links();
		$data['j']=($this->uri->segment(3)+1);
		$data['list_other']=$this->other->pilih_data_other($limit)->result();
		$data['profilsekolah_pil']=$this->profilsekolah->pilih_profilsekolah()->result();
		$this->load->view('other', $data);
	}
	
	function download(){
		$isi = file_get_contents(base_url()."asset/file/".$this->uri->segment(3));
		//$potong_nama = potong_spasi($this->uri->segment(4));
		//$nama_file_download = "silabus_".$potong_nama;
		force_download($this->uri->segment(3),$isi);
	}
	
	public function lihat_unitkerja($offset=0){
		$data['title']="Unit Kerja";
		
		//tentukan jumlah data perhalaman
		$perpage = 5;
		
		//load library pagination
		$this->load->library('pagination');
		
		//konfigurasi tampilan paging
		$config = array(
			'base_url' => base_url('welcome/lihat_unitkerja'),
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
		;
		$data['paginator']=$this->pagination->create_links();
		
		$data['list_unitkerja']=$this->unitkerja->pilih_data_unitkerja($limit)->result();
		$data['profilsekolah_pil']=$this->profilsekolah->pilih_profilsekolah()->result();
		$this->load->view('unitkerja', $data);
	}
		
	//FeedBack
	public function input_feedback(){
		$data['title']="Kontak";
		
		$this->load->library('googlemaps');
     
		$config['center'] = '-6.924092, 107.619105';//Coordinate tengah peta
		$config['zoom'] = 'auto';
		$this->googlemaps->initialize($config);
		 
		$marker = array();
		$marker['position'] = '-6.924092, 107.619105';//Posisi marker (itu tuh yang merah2 lancip itu loh :-p)
		$this->googlemaps->add_marker($marker);
		 
		$data['map'] = $this->googlemaps->create_map();
			
		$data['profilsekolah_pil']=$this->profilsekolah->pilih_profilsekolah($this->uri->segment(3))->result();
		$data['nama_log']=$this->session->userdata('admin_name');
		$this->load->view('data_feedback', $data);
	}
	
	public function proses_input_feedback(){
		$nama = $this->input->post('nama');
		$instansi = $this->input->post('instansi');
		$kontak = $this->input->post('kontak');
		$email = $this->input->post('email');
		$komentar = $this->input->post('komentar');
		
		$data=array(
			'nama' => $nama,
			'kontak' => $kontak,
			'email' => $email,
			'instansi' => $instansi,
			'isi_feedback' => $komentar
		);
		
		$this->session->set_flashdata('feedback','<div class="ui blue message">Komentar/Feedback telah disimpan, Terima Kasih telah menghubungi kami.</div>');
		$this->feedback->masuk_data_feedback($data);
		redirect(base_url('welcome/input_feedback'));
	}
	

	function artikel($id){
		$data['title'] = "ARTIKEL";
		$data['artikel'] = $this->kategoriartikel->artikel_full($id)->result();
		$data['profilsekolah_pil']=$this->profilsekolah->pilih_profilsekolah()->result();
		$this->load->view('artikel_view', $data);
	}
	
	function list_artikel($offset=0){
		$data['title'] = "ARTIKEL";
		
		//tentukan jumlah data perhalaman
		$perpage = 5;
		
		//konfigurasi tampilan paging
		$config = array(
			'base_url' => base_url('welcome/list_artikel'),
			'total_rows' => count( $this->kategoriartikel->list_artikel()->result()),
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
		$data['i']=($this->uri->segment(3)+1);

		$data['list_artikel'] = $this->kategoriartikel->paging_list_artikel($limit)->result();
		$data['profilsekolah_pil']=$this->profilsekolah->pilih_profilsekolah()->result();
		$this->load->view('list_artikel', $data);
	}

	
	function list_berita($offset=0){
		$data['title'] = "BERITA";
		
		//tentukan jumlah data perhalaman
		$perpage = 5;
				
		//konfigurasi tampilan paging
		$config = array(
			'base_url' => base_url('welcome/list_berita'),
			'total_rows' => count( $this->kategoriartikel->list_berita()->result()),
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
		$data['i']=($this->uri->segment(3)+1);
		
		$data['list_berita'] = $this->kategoriartikel->paging_list_berita($limit)->result();
		$data['profilsekolah_pil']=$this->profilsekolah->pilih_profilsekolah()->result();
		$this->load->view('list_berita', $data);
	}
	
	function berita($id){
		$data['title'] = "BERITA";
		$data['berita'] = $this->kategoriartikel->berita_full($id)->result();
		$data['profilsekolah_pil']=$this->profilsekolah->pilih_profilsekolah()->result();
		$this->load->view('berita_view', $data);
	}
	
	function lihat_bursakerja($offset=0){
		$data['title'] = "BURSA KERJA";
		
		//tentukan jumlah data perhalaman
		$perpage = 5;
				
		//konfigurasi tampilan paging
		$config = array(
			'base_url' => base_url('welcome/list_bursa_kerja'),
			'total_rows' => count( $this->kategoriartikel->list_bursa_kerja()->result()),
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
		$data['i']=($this->uri->segment(3)+1);
		
		$data['list_bursa_kerja'] = $this->kategoriartikel->paging_list_bursa_kerja($limit)->result();
		$data['profilsekolah_pil']=$this->profilsekolah->pilih_profilsekolah()->result();
		$this->load->view('list_bursa_kerja', $data);
	}
	
	function bursa_kerja($id){
		$data['title'] = "Bursa Kerja";
		$data['bursa_kerja'] = $this->kategoriartikel->bursa_kerja_full($id)->result();
		$data['profilsekolah_pil']=$this->profilsekolah->pilih_profilsekolah()->result();
		$this->load->view('bursa_kerja_view', $data);
	}
	
	function list_infoppdb($offset=0){
		$data['title'] = "Info PPDB";
		
		//tentukan jumlah data perhalaman
		$perpage = 10;
				
		//konfigurasi tampilan paging
		$config = array(
			'base_url' => base_url('welcome/list_infoppdb'),
			'total_rows' => count( $this->kategoriartikel->list_infoppdb()->result()),
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
		$data['i']=($this->uri->segment(3)+1);
		$data['info'] = $this->infoppdb->pilih_data_infoppdb()->result();
		$data['list_infoppdb'] = $this->kategoriartikel->paging_list_infoppdb($limit)->result();
		$data['profilsekolah_pil']=$this->profilsekolah->pilih_profilsekolah()->result();
		$this->load->view('list_infoppdb', $data);
	}

}

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