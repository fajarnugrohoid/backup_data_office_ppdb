<?php
	class M_absensi extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function lihat_siswa($kelas){
			$query = $this->db->query("select s.nis, s.nama, s.jenis_kelamin, k.kelas, k.id_kelas, s.foto from siswa s, kelas k where k.id_kelas = s.id_kelas and s.id_kelas = '$kelas' order by s.nis");
			
			return $query;
		}
		
		function hitung_siswa($kelas){
			$this->db->where('id_kelas', $kelas);
			$this->db->select('*');
			$this->db->from('siswa');
			$query = $this->db->get()->num_rows();
			
			return $query;
		}
		
		function ambil_kelas(){
			$this->db->select('*');
			$this->db->from('kelas');
			
			return $this->db->get();
		}
		
		function proses_input_siswa($data_siswa){
			//$this->db->query("insert into siswa(nis, nama, jenis_kelamin, id_kelas, username, password) values ('$nis', '$nama', '$jk', '$kelas', '$username', '$password')");
			$this->db->insert('siswa', $data_siswa);
		}
		
		function ambil_edit_siswa($nis){
			$query = $this->db->query("select s.nis, s.nama, s.jenis_kelamin, k.kelas, k.id_kelas from siswa s, kelas k where k.id_kelas = s.id_kelas and s.nis = '$nis' order by k.kelas, s.nis");
			
			return $query;
		}
		
		function proses_edit_siswa($data_siswa){
			//$this->db->query("update siswa set nama = '$nama', jenis_kelamin = '$jk', id_kelas = '$kelas' where nis = $nis");
			$this->db->where('nis', $nis);
			$this->db->update('siswa', $data_siswa);
		}
		
		function delete_siswa($nis){
			$this->db->where('nis', $nis);
			$this->db->delete('siswa');
		}
		
		function hitung_siswa_absen($nis){
			$this->db->where('nis', $nis);
			$this->db->select('*');
			$this->db->from('siswa');
			$query = $this->db->get()->num_rows();
			
			return $query;
		}
		
		function lihat_siswa_absen($id_kelas){
			$query = $this->db->query("select s.nis, s.nama, s.jenis_kelamin, k.kelas, k.id_kelas from siswa s, kelas k where s.id_kelas = k.id_kelas and s.id_kelas = '$id_kelas' and s.nis not in (SELECT nis FROM absensi WHERE DATE(tanggal) = CURRENT_DATE order by k.kelas, s.nis)");
			
			return $query;
		}
		
		function lihat_siswa_absen2($id_kelas, $cari){
			$query = $this->db->query("select s.nis, s.nama, s.jenis_kelamin, k.kelas, k.id_kelas from siswa s, kelas k where s.id_kelas = k.id_kelas and s.id_kelas = '$id_kelas' and s.nama like '%$cari%' and s.nis not in (SELECT nis FROM absensi WHERE DATE(tanggal) = CURRENT_DATE order by k.kelas, s.nis)");
			
			return $query;
		}
		
		function input_absen($nis, $ket){
			$this->db->query("insert into absensi(nis, id_keterangan_absensi, tanggal) values('$nis', $ket, CURRENT_TIMESTAMP)");
		}
		
		function input_absen2($nis, $ket, $det){
			$this->db->query("insert into absensi(nis, id_keterangan_absensi, tanggal, detail) values('$nis', $ket, CURRENT_TIMESTAMP, '$det')");
		}
		
		function rekap_absen(){
			$query = $this->db->query("select a.id_absensi, s.nis, s.nama, s.jenis_kelamin,ke.kelas , k.keterangan, date_format(a.tanggal, '%m-%b-%Y') as tanggal, TIME(a.tanggal) as jam, a.detail from kelas ke, siswa s, keterangan_absen k, absensi a where a.nis = s.nis and ke.id_kelas = s.id_kelas and k.id_keterangan = a.id_keterangan_absensi and DATE(a.tanggal) = CURRENT_DATE order by ke.kelas, s.nis");
			
			return $query;
		}
		
		function rekap_absen2($bulan, $tahun, $kelas){
			$query = $this->db->query("select s.nis as a, s.nama, s.jenis_kelamin, ke.kelas, (select count(id_keterangan_absensi) from siswa s, absensi a where id_keterangan_absensi = 1 and a.nis = s.nis and s.nis = a and Month(a.tanggal) = $bulan and year(a.tanggal) = $tahun) as sakit, (select count(id_keterangan_absensi) from siswa s, absensi a where id_keterangan_absensi = 2 and a.nis = s.nis and s.nis = a and Month(a.tanggal) = $bulan and year(a.tanggal) = $tahun) as ijin, (select count(id_keterangan_absensi) from siswa s, absensi a where id_keterangan_absensi = 3 and a.nis = s.nis and s.nis = a and Month(a.tanggal) = $bulan and year(a.tanggal) = $tahun) as alpha, (select count(id_keterangan_absensi) from siswa s, absensi a where id_keterangan_absensi = 4 and a.nis = s.nis and s.nis = a and Month(a.tanggal) = $bulan and year(a.tanggal) = $tahun) as terlambat from kelas ke, siswa s, absensi a where s.nis = a.nis and Month(a.tanggal) = $bulan and year(a.tanggal) = $tahun and s.id_kelas = $kelas group by a order by a");
			
			return $query;
		}
		
		function delete_rekap_absen($id_absensi){
			$this->db->where('id_absensi', $id_absensi);
			$this->db->delete('absensi');
		}
		
		//kelas
		function pilih_data_kelas(){
			$this->db->select('*')
					 ->from('kelas');
			return $this->db->get();
		}
		
		function pilih_kelas(){
			$this->db->select('*');
			$this->db->from('kelas');
			return $this->db->get();
		}
		
		function cari_kelas($kelas){
			$this->db->select('*');
			$this->db->from('kelas')
					 ->where('kelas',$kelas);
			return $this->db->get();
		}
		
		function masuk_data_kelas($data){
			$this->db->insert('kelas', $data);
		}
		
		function pilih_id_kelas($id_kelas){
			$this->db->select('*');
			$this->db->from('kelas');
			$this->db->where('id_kelas', $id_kelas);
			return $this->db->get();
		}
		
		function update_data($id,$data){
			$this->db->where('id_kelas', $id);
			$this->db->update('kelas', $data);
		}
		
		function hapus_kelas($id_kelas){
			$this->db->where('id_kelas', $id_kelas);
			$this->db->delete('kelas');
		}
		
		function detail($bulan, $tahun){
			$query = $this->db->query("SELECT a.nis, k.keterangan, date_format(a.tanggal, '%m-%b-%Y') as tanggal FROM keterangan_absen k, absensi a WHERE a.id_keterangan_absensi = k.id_keterangan and month(a.tanggal)='$bulan' and year(a.tanggal)='$tahun' order by a.tanggal");
			
			return $query;
		}
		
		function detail_absen($nis, $bulan, $tahun){
			$query = $this->db->query("SELECT a.nis, k.keterangan, date_format(a.tanggal, '%m-%b-%Y') as tanggal FROM keterangan_absen k, absensi a WHERE a.nis = '$nis' and a.id_keterangan_absensi = k.id_keterangan and month(a.tanggal)='$bulan' and year(a.tanggal)='$tahun' order by a.tanggal");
			
			return $query;
		}
		
		function cek_nis($nis){
			$this->db->select('nis');
			$this->db->from('siswa');
			$this->db->where('nis', $nis);
			
			return $this->db->get();
		}
		
		function cek_id_siswa(){
			$this->db->select("*")
					 ->from("siswa")
					 ->order_by('id_siswa',"desc");
			return $this->db->get();
		}
	}
?>