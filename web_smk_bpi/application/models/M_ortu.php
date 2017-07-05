<?php
	class M_ortu extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		
		function proses_login($username, $password){
			$this->db->select('*');
			$this->db->from('siswa');
			$this->db->where('username', $username);
			$this->db->where('password', $password);
			
			return $this->db->get();
		}
		
		function rekap_absen($nis){
			$query = $this->db->query("select s.nis, s.nama, s.jenis_kelamin,ke.kelas , k.keterangan, date_format(a.tanggal, '%m-%b-%Y') as tanggal, TIME(a.tanggal) as jam, a.detail from kelas ke, siswa s, keterangan_absen k, absensi a where a.nis = s.nis and ke.id_kelas = s.id_kelas and k.id_keterangan = a.id_keterangan_absensi and s.nis = '$nis' and DATE(a.tanggal) = CURRENT_DATE");
			
			return $query;
		}
		
		function rekap_absen2($nis, $bulan, $tahun){
			$query = $this->db->query("select a.id_absensi, s.nis as a, s.nama, s.jenis_kelamin, ke.kelas, (select count(id_keterangan_absensi) from siswa s, absensi a where id_keterangan_absensi = 1 and a.nis = s.nis and s.nis = a and Month(a.tanggal) = $bulan and year(a.tanggal) = $tahun) as sakit, (select count(id_keterangan_absensi) from siswa s, absensi a where id_keterangan_absensi = 2 and a.nis = s.nis and s.nis = a and Month(a.tanggal) = $bulan and year(a.tanggal) = $tahun) as ijin, (select count(id_keterangan_absensi) from siswa s, absensi a where id_keterangan_absensi = 3 and a.nis = s.nis and s.nis = a and Month(a.tanggal) = $bulan and year(a.tanggal) = $tahun) as alpha, (select count(id_keterangan_absensi) from siswa s, absensi a where id_keterangan_absensi = 4 and a.nis = s.nis and s.nis = a and Month(a.tanggal) = $bulan and year(a.tanggal) = $tahun) as terlambat from kelas ke, siswa s, absensi a where s.nis = a.nis and s.nis = $nis and Month(a.tanggal) = $bulan and year(a.tanggal) = $tahun group by a order by a");
			
			return $query;
		}
		
		function detail($nis, $bulan, $tahun){
			$query = $this->db->query("SELECT k.keterangan, date_format(a.tanggal, '%m-%b-%Y') as tanggal FROM keterangan_absen k, absensi a WHERE nis = '$nis' and a.id_keterangan_absensi = k.id_keterangan and month(a.tanggal)='$bulan' and year(a.tanggal)='$tahun' order by a.tanggal");
			
			return $query;
		}
		
		function auth($username, $password){
			$this->db->select('*');
			$this->db->from('siswa');
			$this->db->where('username', $username);
			$this->db->where('password', $password);
			return $this->db->get();
		}
		
		function reset($username, $pass){
			$this->db->where('username', $username);
			$this->db->update('siswa', $pass);
		}
	}
?>