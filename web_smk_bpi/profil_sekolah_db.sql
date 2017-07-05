-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 15, 2016 at 10:13 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `profil_sekolah`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE IF NOT EXISTS `absensi` (
  `id_absensi` int(11) NOT NULL AUTO_INCREMENT,
  `id_keterangan_absensi` int(11) DEFAULT NULL,
  `nis` varchar(10) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `detail` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_absensi`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=103 ;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id_absensi`, `id_keterangan_absensi`, `nis`, `tanggal`, `detail`) VALUES
(80, 1, '151610071', '2016-03-02 00:00:00', NULL),
(82, 1, '151610077', '2016-03-03 00:00:00', NULL),
(83, 4, '151610081', '2016-03-03 00:00:00', NULL),
(84, 3, '1516.10031', '2016-03-03 00:00:00', NULL),
(85, 2, '1205799', '2016-03-03 00:00:00', NULL),
(86, 3, '151610078', '2016-03-03 00:00:00', NULL),
(87, 1, '30316', '2016-03-03 00:00:00', NULL),
(88, 1, '30316', '2016-03-03 00:00:00', NULL),
(89, 3, '30316', '2016-03-03 00:00:00', NULL),
(90, 1, '151610074', '2016-03-03 00:00:00', NULL),
(91, 2, '30316', '2016-03-03 00:00:00', NULL),
(92, 1, '30316', '2016-03-03 00:00:00', NULL),
(93, 1, '151610073', '2016-03-03 00:00:00', NULL),
(94, 4, '12345', '2016-03-03 00:00:00', NULL),
(95, 1, '04032016', '2016-03-04 00:00:00', NULL),
(96, 2, '151610071', '2016-02-09 00:00:00', NULL),
(97, 1, '151610071', '2016-03-08 00:00:00', NULL),
(98, 2, '151610073', '2016-03-08 17:53:06', NULL),
(99, 1, '151610071', '2016-03-09 10:16:11', 'sfhbahf'),
(102, 2, '151610073', '2016-03-09 10:19:36', 'pulang ke rumah, males sekolah');

-- --------------------------------------------------------

--
-- Table structure for table `agenda`
--

CREATE TABLE IF NOT EXISTS `agenda` (
  `id_agenda` int(11) NOT NULL AUTO_INCREMENT,
  `judul_agenda` varchar(150) DEFAULT NULL,
  `agenda` text,
  `tgl_mulai` date DEFAULT NULL,
  `tgl_akhir` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_agenda`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `artikel`
--

CREATE TABLE IF NOT EXISTS `artikel` (
  `id_artikel` int(11) NOT NULL AUTO_INCREMENT,
  `judul_artikel` varchar(150) DEFAULT NULL,
  `gambar_utama` varchar(150) NOT NULL,
  `artikel` text,
  `id_kategori` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `tgl_posting` datetime DEFAULT NULL,
  PRIMARY KEY (`id_artikel`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `artikel`
--

INSERT INTO `artikel` (`id_artikel`, `judul_artikel`, `gambar_utama`, `artikel`, `id_kategori`, `id_user`, `tgl_posting`) VALUES
(2, 'Var IT', 'Artikel_VarIT.png', '<p>VAR IT adalah sebuah perusahaan yang termuka</p>', 2, 1, '2016-01-29 12:54:17');

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE IF NOT EXISTS `berita` (
  `id_berita` int(11) NOT NULL AUTO_INCREMENT,
  `judul_berita` varchar(150) DEFAULT NULL,
  `gambar_utama` varchar(150) NOT NULL,
  `berita` text,
  `tgl_posting` datetime DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_berita`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id_berita`, `judul_berita`, `gambar_utama`, `berita`, `tgl_posting`, `id_user`) VALUES
(6, 'Tes 1', 'Berita_Tes1.jpg', '<p>merupakan <strong>hal&nbsp;</strong>yang</p>', '2016-01-28 08:05:26', 1),
(7, 'Tes 2', 'Berita_Tes2.jpg', '<p>merupakan <strong>hal&nbsp;</strong>yang</p>', '2016-01-28 07:17:58', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bursa_kerja`
--

CREATE TABLE IF NOT EXISTS `bursa_kerja` (
  `id_bursa_kerja` int(11) NOT NULL,
  `judul_bursa_kerja` varchar(150) NOT NULL,
  `gambar_utama` varchar(150) DEFAULT NULL,
  `bursa_kerja` text NOT NULL,
  `tgl_posting` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ekstrakulikuler`
--

CREATE TABLE IF NOT EXISTS `ekstrakulikuler` (
  `id_ekstrakulikuler` int(11) NOT NULL AUTO_INCREMENT,
  `nama_ekstrakulikuler` varchar(150) DEFAULT NULL,
  `deskripsi` text,
  `id_pegawai` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_ekstrakulikuler`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ekstrakulikuler`
--

INSERT INTO `ekstrakulikuler` (`id_ekstrakulikuler`, `nama_ekstrakulikuler`, `deskripsi`, `id_pegawai`) VALUES
(2, 'bla bla', 'hohoho', 6),
(3, 'Balap Karung', 'ini adalah', 6);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `id_feedback` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) DEFAULT NULL,
  `kontak` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `instansi` varchar(100) DEFAULT NULL,
  `isi_feedback` text,
  `tgl_posting` datetime DEFAULT NULL,
  PRIMARY KEY (`id_feedback`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id_feedback`, `nama`, `kontak`, `email`, `instansi`, `isi_feedback`, `tgl_posting`) VALUES
(1, 'Izzah Cantik', '123456', 'jajhja@djs.sdjs', 'UPI', 'ini loh', '0000-00-00 00:00:00'),
(2, 'Izzah Cantik', '123456', 'jajhja@djs.sdjs', 'UPI', 'ini loh', '0000-00-00 00:00:00'),
(3, 'Izzah Cantik', '123456', 'jajhja@djs.sdjs', 'UPI', 'mengapa mengapa mengapa?', '0000-00-00 00:00:00'),
(4, 'Izzah Cantik', '123456', 'smkbpi@sch.co.id', 'UPI', 'terima kasih', '2016-01-28 11:11:41');

-- --------------------------------------------------------

--
-- Table structure for table `galeri`
--

CREATE TABLE IF NOT EXISTS `galeri` (
  `id_galeri` int(11) NOT NULL AUTO_INCREMENT,
  `judul_galeri` varchar(50) DEFAULT NULL,
  `foto` varchar(150) DEFAULT NULL,
  `deskripsi` varchar(200) DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `tgl_posting` datetime DEFAULT NULL,
  PRIMARY KEY (`id_galeri`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `galeri`
--

INSERT INTO `galeri` (`id_galeri`, `judul_galeri`, `foto`, `deskripsi`, `id_kategori`, `tgl_posting`) VALUES
(12, 'Logo VAR IT', '2_LogoVARIT.png', 'VAR IT Solution', 2, '2016-01-28 11:08:48'),
(13, 'Izzah Muslimah', '2_IzzahMuslimah.jpg', 'adalah sesuatu yang diawali dengan bismillah', 2, '2016-01-28 08:30:25');

-- --------------------------------------------------------

--
-- Table structure for table `guru_piket`
--

CREATE TABLE IF NOT EXISTS `guru_piket` (
  `id_guru_piket` int(11) NOT NULL AUTO_INCREMENT,
  `id_pegawai` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_guru_piket`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `histori_kelas`
--

CREATE TABLE IF NOT EXISTS `histori_kelas` (
  `id_histori_kelas` int(11) NOT NULL AUTO_INCREMENT,
  `id_kelas` int(11) DEFAULT NULL,
  `nis` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_histori_kelas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `info_ppdb`
--

CREATE TABLE IF NOT EXISTS `info_ppdb` (
  `id_info_ppdb` int(11) NOT NULL AUTO_INCREMENT,
  `judul_info_ppdb` varchar(150) DEFAULT NULL,
  `info_ppdb` text,
  `tgl_posting` datetime DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_info_ppdb`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `info_ppdb`
--

INSERT INTO `info_ppdb` (`id_info_ppdb`, `judul_info_ppdb`, `info_ppdb`, `tgl_posting`, `id_user`) VALUES
(6, 'pendaftaran', 'pembukaan akan', '2016-01-26 04:42:27', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE IF NOT EXISTS `jabatan` (
  `id_jabatan` int(11) NOT NULL AUTO_INCREMENT,
  `jabatan` varchar(100) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `urut` int(11) NOT NULL,
  PRIMARY KEY (`id_jabatan`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id_jabatan`, `jabatan`, `status`, `urut`) VALUES
(20, 'Kepala Sekolah', 1, 1),
(21, 'Wakasek Kurikulum', 1, 2),
(22, 'Wakasek Kesiswaan', 1, 2),
(23, 'Guru', 0, 4),
(24, 'Bimbingan Konseling', 0, 3),
(25, 'Staf TU', 0, 5),
(26, 'Wakasek Bidang BKK', 1, 2),
(27, 'Wakasek Bidang Hubin', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_artikel`
--

CREATE TABLE IF NOT EXISTS `kategori_artikel` (
  `id_kategori_artikel` int(11) NOT NULL AUTO_INCREMENT,
  `kategori_artikel` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_kategori_artikel`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `kategori_artikel`
--

INSERT INTO `kategori_artikel` (`id_kategori_artikel`, `kategori_artikel`) VALUES
(2, 'Teknik Komputer dan Jaringan');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE IF NOT EXISTS `kelas` (
  `id_kelas` int(11) NOT NULL AUTO_INCREMENT,
  `kelas` varchar(12) NOT NULL,
  PRIMARY KEY (`id_kelas`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `kelas`) VALUES
(1, 'X-AP'),
(2, 'X-TI1'),
(3, 'X-TI2'),
(4, 'XI-TKJ'),
(5, 'XI-RPL'),
(6, 'XI-AP'),
(7, 'XII-TK'),
(8, 'XII-RPL'),
(9, 'XII-AP');

-- --------------------------------------------------------

--
-- Table structure for table `kepegawaian`
--

CREATE TABLE IF NOT EXISTS `kepegawaian` (
  `id_pegawai` int(11) NOT NULL AUTO_INCREMENT,
  `nip` varchar(20) DEFAULT NULL,
  `id_jabatan` int(11) DEFAULT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `jenis_kelamin` varchar(15) DEFAULT NULL,
  `alamat` varchar(250) DEFAULT NULL,
  `no_kontak` varchar(15) DEFAULT NULL,
  `sosmed` varchar(150) DEFAULT NULL,
  `mata_pelajaran` varchar(150) NOT NULL,
  `foto` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_pegawai`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `kepegawaian`
--

INSERT INTO `kepegawaian` (`id_pegawai`, `nip`, `id_jabatan`, `nama`, `jenis_kelamin`, `alamat`, `no_kontak`, `sosmed`, `mata_pelajaran`, `foto`) VALUES
(41, 'N/A', 20, 'Drs. Akhmad Budi Utomo, M.Pd.', 'L', 'Bandung', '0812345678', '', '-', 'pegawai_1.jpg'),
(43, 'N/A', 22, 'Agus Nugroho, S.Pd', 'L', 'Bandung', '081xxxx', '', 'IPS', 'pegawai_42.jpg'),
(44, 'N/A', 26, 'Agus Salim, S.Pdi', 'L', 'Bandung', '08xxx', '', 'PAI', 'pegawai_44.jpg'),
(45, 'N/A', 27, 'Dra. Hj Anggani', 'P', 'Bandung', '08xx', '', 'PAI', 'pegawai_45.jpg'),
(46, 'N/A', 21, 'Tatang M.Pd', 'L', 'Bandung', '08xx', '', '-', 'pegawai_46.jpg'),
(47, 'N/A', 23, 'Ade Aso, S.Pd', 'L', 'Bandung', '08xx', '', 'Produktif TKJ', 'pegawai_47.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `keterangan_absen`
--

CREATE TABLE IF NOT EXISTS `keterangan_absen` (
  `id_keterangan` int(11) NOT NULL AUTO_INCREMENT,
  `keterangan` varchar(25) NOT NULL,
  PRIMARY KEY (`id_keterangan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `keterangan_absen`
--

INSERT INTO `keterangan_absen` (`id_keterangan`, `keterangan`) VALUES
(1, 'sakit'),
(2, 'izin'),
(3, 'alpha'),
(4, 'terlambat');

-- --------------------------------------------------------

--
-- Table structure for table `other`
--

CREATE TABLE IF NOT EXISTS `other` (
  `id_other` int(11) NOT NULL AUTO_INCREMENT,
  `judul_upload` varchar(150) DEFAULT NULL,
  `file_upload` varchar(150) DEFAULT NULL,
  `tgl_posting` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_other`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `profil_jurusan`
--

CREATE TABLE IF NOT EXISTS `profil_jurusan` (
  `id_jurusan` int(11) NOT NULL AUTO_INCREMENT,
  `ketua_jurusan` varchar(15) NOT NULL,
  `nama_jurusan` varchar(200) NOT NULL,
  `deskripsi` text,
  PRIMARY KEY (`id_jurusan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `profil_jurusan`
--

INSERT INTO `profil_jurusan` (`id_jurusan`, `ketua_jurusan`, `nama_jurusan`, `deskripsi`) VALUES
(4, 'tukijan', 'Rekayasa Perangkat Lunak', 'RPL merupakan jurusan yang');

-- --------------------------------------------------------

--
-- Table structure for table `profil_sekolah`
--

CREATE TABLE IF NOT EXISTS `profil_sekolah` (
  `id_sekolah` int(11) NOT NULL AUTO_INCREMENT,
  `nama_sekolah` varchar(150) NOT NULL,
  `logo` varchar(150) DEFAULT NULL,
  `foto_profil` varchar(100) NOT NULL,
  `alamat` varchar(250) DEFAULT NULL,
  `no_kontak` varchar(15) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `sambutan_kepsek` text NOT NULL,
  `deskripsi` text,
  PRIMARY KEY (`id_sekolah`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `profil_sekolah`
--

INSERT INTO `profil_sekolah` (`id_sekolah`, `nama_sekolah`, `logo`, `foto_profil`, `alamat`, `no_kontak`, `email`, `sambutan_kepsek`, `deskripsi`) VALUES
(1, 'SMK BPI Bandung', 'logo_SMKBPIBandung.png', 'fotoprofil_SMKBPIBandung.gif', 'Jl. Burangrang No. 08', '022 - 7305735', 'smkbpi@sch.co.id', '<p><img class="example1" style="margin: 10px; float: left;" src="../asset/img/pegawai_1.jpg" alt="" width="116" height="144" />Ini merupakan sambutan kepala sekolah menengah kejuruan bpi bandung.&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>Assalamu''alaikum wr. wb.</p>\r\n<p>Alhamdulillahi robbil alamin saya ucapkan&amp;nbsp;kehadlirat Allah SWT, bahwasannya dengan rahmat dan karunia-Nya lah akhirnya Website sekolah ini dapat kami perbaharui. Kami mengucapkan selamat datang di Website kami Sekolah Menengah Kejuruan BPI Bandung&amp;nbsp;yang saya tujukan untuk seluruh unsur pimpinan, guru, karyawan dan siswa serta khalayak umum guna dapat mengakses seluruh informasi tentang segala profil, aktifitas/kegiatan serta fasilitas sekolah kami.</p>\r\n<p>Kami selaku pimpinan sekolah mengucapkan terima kasih kepada tim pembuat Website ini yang telah berusaha untuk dapat lebih memperkenalkan segala perihal yang dimiliki oleh sekolah. Dan tentunya Website sekolah kami masih terdapat banyak kekurangan, oleh karena itu kepada seluruh civitas akademika dan masyarakat umum dapat memberikan saran dan kritik yang membangun demi kemajuan Website ini lebih lanjut.</p>\r\n<p>Saya berharap Website ini dapat dijadikan wahana interaksi yang positif baik antar civitas akademika maupun masyarakat pada umumnya sehingga dapat menjalin silaturahmi yang erat disegala unsur. Mari kita bekerja dan berkarya dengan mengharap ridho sang Kuasa dan keikhlasan yang tulus dijiwa demi anak bangsa.</p>\r\n<p>&nbsp;</p>', '<p>Diawali pada tahun pelajaran baru tahun 2008, &nbsp;keputusan Pengurus yayasan BPI Bandung untuk mendirikan SMK BPI&nbsp; yang memungkinkan untuk memanfaatkan seluruh sarana dan prasarana yang mungkin untuk memberikan pelayanan pendidikan yang dibutuhkan oleh masyarakat. Diperkuat oleh izin operasional SMK BPI oleh DISDIK Kota Bandung No. 421.5/580/PSMAK/2008.</p>\r\n<p>&nbsp;</p>\r\n<p>Bermodalkan sarana dan prasarana, serta SDM yang ada di lingkungan Yayasan BPI, maka pada saat akhir penutupan Penerimaan Siswa Baru (PSB) ada 9 (sembilan) siswa yang tertarik dan memilih Jurusan Rekayasa Perangkat Lunak (RPL).&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>Kepala Sekolah, atau Pejabat Kepala&nbsp; SMK BPI pertama adalah : SURYADI SURYANINGRAT, M.M hingga tahun 2010.</p>\r\n<p>&nbsp;</p>\r\n<p>SMK BPI Bandung &nbsp;menjalin kerja sama dengan Dunia Usaha/Dunia Industri sebagai institusi pasangan. Berikut daftar institusi pasangan SMK BPI:</p>\r\n<ol>\r\n<li>Amisya Tours</li>\r\n<li>Dinas Kebudayaan dan Pariwisata Kota Bandung Prov. Jawa Barat</li>\r\n<li>IT ISTA</li>\r\n<li>Rumah Sakit Pendidikan UNPAD</li>\r\n<li>com</li>\r\n<li>Bita Enarcon</li>\r\n<li>Balai Bahasa Provinsi Jawa Barat</li>\r\n<li>Industri Susu Alam Murni</li>\r\n<li>Cimahi Creative Association</li>\r\n<li>Dinas Kebudayaan dN Pariwisata Kota Bandung</li>\r\n<li>Axioo Mitra Abadi</li>\r\n<li>Simaya Jejaring Mandiri</li>\r\n<li>Dinas Perhubungan Kota Bandung</li>\r\n<li>Bank Jabar Banten</li>\r\n<li>Trans Studio Mall</li>\r\n<li>Pindad Persero</li>\r\n<li>Global Media Nusantara</li>\r\n<li>Mandiri, Tbk</li>\r\n<li>Kantor Imigrasi Kelas I, Bandung</li>\r\n<li>Koperasi Pegawai Pemerintah Kota Bandung</li>\r\n<li>Gedung Keuangan Negara</li>\r\n<li>Bank Bukopin</li>\r\n<li>Premier Equity Futures</li>\r\n<li>Gapura Angkasa</li>\r\n<li>Yayasan BPI</li>\r\n</ol>\r\n<p>&nbsp;</p>\r\n<p>Selain kerja sama dengan DU/DI, SMK BPI Bandung bekerja sama dengan beberapa Perguruan Tinggi Negeri maupun Swasta dan beberapa SMK&nbsp; antara lain :</p>\r\n<ol>\r\n<li>STMIK &nbsp;AMIKOM Yogyakarta</li>\r\n<li>SMK Walisongo, Jakarta</li>\r\n<li>SMK Daarut Tauhid Bandung</li>\r\n<li>SMK Cybermedia, Jakarta</li>\r\n<li>SMK Timika, Papua</li>\r\n<li>Universitas Pendidikan Indonesia</li>\r\n<li>Sekolah Farmasi ITB</li>\r\n</ol>\r\n<p>&nbsp;</p>\r\n<p><strong>PROGRAM UNGGULAN</strong></p>\r\n<p>1. Program Awal Tahun</p>\r\n<ul>\r\n<li>Penerimaan Peserta Didik Baru</li>\r\n<li>Masa Pengenalan Lingkungan Sekolah</li>\r\n<li>In House Training Guru dan Karyawan SMK BPI</li>\r\n<li>Pelantikan Pengurus OSIS</li>\r\n</ul>\r\n<p>2. Program Pertengahan Tahun</p>\r\n<ul>\r\n<li>Audit Internal Manajemen Mutu SMK BPI</li>\r\n<li>Ujian Tengah Semester dan Ujian Akhir Semester Ganjil</li>\r\n<li>Pembagian Raport Semester 1</li>\r\n<li>Kunjungan Industri</li>\r\n<li>Praktik Kerja Industri</li>\r\n<li>Fiesta SMK BPI : Culinary &amp; Acoustic Festival</li>\r\n</ul>\r\n<p>3. Program Akhir Tahun</p>\r\n<ul>\r\n<li>Promosi SMK BPI</li>\r\n<li>Rangkaian Ujian : Uji Kompetensi, Ujian Sekolah, dan Ujian Nasional, UKK.</li>\r\n<li>Rapat Tinjauan Manajemen</li>\r\n<li>Surveillance Audit Manajemen Mutu</li>\r\n<li>Pembagian Raport Semester 2</li>\r\n<li>Survey Kepuasan Pelanggan</li>\r\n</ul>\r\n<p>&nbsp;</p>');

-- --------------------------------------------------------

--
-- Table structure for table `profil_unit_kerja`
--

CREATE TABLE IF NOT EXISTS `profil_unit_kerja` (
  `id_unit_kerja` int(11) NOT NULL AUTO_INCREMENT,
  `unit_kerja` varchar(150) DEFAULT NULL,
  `deskripsi` text,
  PRIMARY KEY (`id_unit_kerja`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `profil_unit_kerja`
--

INSERT INTO `profil_unit_kerja` (`id_unit_kerja`, `unit_kerja`, `deskripsi`) VALUES
(4, 'Humas', '<p>Humas</p>'),
(5, 'Kesiswaan', '<p>Kesiswaan</p>'),
(6, 'Kurikulum', '<p>Kurikulum</p>'),
(7, 'BKK', '<p>BKK</p>');

-- --------------------------------------------------------

--
-- Table structure for table `silabus`
--

CREATE TABLE IF NOT EXISTS `silabus` (
  `id_silabus` int(11) NOT NULL AUTO_INCREMENT,
  `silabus` varchar(150) NOT NULL,
  `mata_pelajaran` varchar(100) NOT NULL,
  `tahun_berlaku` int(11) NOT NULL,
  `tgl_posting` datetime DEFAULT NULL,
  PRIMARY KEY (`id_silabus`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `silabus`
--

INSERT INTO `silabus` (`id_silabus`, `silabus`, `mata_pelajaran`, `tahun_berlaku`, `tgl_posting`) VALUES
(6, 'Silabus_2015_BahasaInggris.pdf', 'Bahasa Inggris', 2015, '2016-01-28 10:57:28');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE IF NOT EXISTS `siswa` (
  `id_siswa` int(11) NOT NULL AUTO_INCREMENT,
  `nis` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` varchar(2) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `foto` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_siswa`),
  UNIQUE KEY `nis` (`nis`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=96 ;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nis`, `nama`, `jenis_kelamin`, `username`, `password`, `id_kelas`, `foto`) VALUES
(8, '151610071', 'CINDY HELMALIA ANJANI', 'P', 'cindyhelmaliaanjani', 'b10d78dcf341ecb0270031920f9780e0', 1, NULL),
(10, '151610073', 'FIRDA BUDI', 'P', 'firdamaryana', 'firdamaryana', 1, NULL),
(11, '151610074', 'FITRIA MELINDA', 'L', 'fitriamelindasanyang', 'fitriamelindasanyang', 2, NULL),
(12, '151610075', 'HAVISHA SALSABILLA  R', 'P', 'havishasalsabillar', 'havishasalsabillar', 1, NULL),
(14, '151610077', 'INTAN ANANDA', 'P', 'intanananda', 'intanananda', 1, NULL),
(15, '151610078', 'JENI RAHAYU', 'P', 'jenirahayu', 'jenirahayu', 1, NULL),
(16, '151610079', 'LUTHFIYANTI NOERFI  KH', 'P', 'luthfiyantinoerfikh', 'luthfiyantinoerfikh', 1, NULL),
(17, '151610080', 'NADYA SAVITRI APRILIANI', 'P', 'nadyasavitriapriliani', 'nadyasavitriapriliani', 1, NULL),
(18, '151610081', 'NARENZA FAJRIAH RIZALDI', 'P', 'narenzafajriahrizaldi', 'narenzafajriahrizaldi', 9, NULL),
(19, '151610082', 'NITA YULIA', 'P', 'nitayulia', 'nitayulia', 1, NULL),
(20, '151610083', 'NOVIYANTI RATNASARI', 'P', 'noviyantiratnasari', 'noviyantiratnasari', 1, NULL),
(21, '151610084', 'REFFY WULANDARI', 'P', 'reffywulandari', 'reffywulandari', 1, NULL),
(22, '151610085', 'RIMA ANGGRAENI', 'P', 'rimaanggraeni', 'rimaanggraeni', 1, NULL),
(23, '151610086', 'RISKA JANUAR  P.', 'P', 'riskajanuarp.', 'riskajanuarp.', 1, NULL),
(24, '151610087', 'RODIANA SUPRIATIN', 'P', 'rodianasupriatin', 'rodianasupriatin', 1, NULL),
(25, '151610088', 'SALSA AULIA AZZAHRA', 'P', 'salsaauliaazzahra', 'salsaauliaazzahra', 1, NULL),
(26, '151610089', 'SITI MARYANI', 'P', 'sitimaryani', 'sitimaryani', 1, NULL),
(27, '151610090', 'SOFYAH RIZQI AZHARI', 'P', 'sofyahrizqiazhari', 'sofyahrizqiazhari', 1, NULL),
(28, '151610091', 'SRI HAYATI', 'P', 'srihayati', 'srihayati', 1, NULL),
(29, '151610092', 'SYAFIRA AYUDHIA  H.', 'P', 'syafiraayudhiah.', 'syafiraayudhiah.', 1, NULL),
(30, '151610093', 'VINI NOVIYANTI', 'P', 'vininoviyanti', 'vininoviyanti', 1, NULL),
(31, '151610094', 'VINNA NUR SYALSABILLA', 'P', 'vinnanursyalsabilla', 'vinnanursyalsabilla', 1, NULL),
(32, '151610095', 'YASELIA SAFITRI', 'P', 'yaseliasafitri', 'yaseliasafitri', 1, NULL),
(33, '151610096', 'YASINTA NAFI', 'P', 'yasintanafi', 'yasintanafi', 1, NULL),
(34, '151610097', 'YASMIN FAADILLAH', 'P', 'yasminfaadillah', 'yasminfaadillah', 1, NULL),
(35, '151610098', 'ZIDNA RIFA RIKZATILLAH  A', 'P', 'zidnarifarikzatillaha', 'zidnarifarikzatillaha', 1, NULL),
(36, '1516.10031', 'ADITYA PUTRA SUHENDRA', 'L', 'adityaputrasuhendra', 'adityaputrasuhendra', 3, NULL),
(37, '1516.10032', 'ALIF ZAKYA RAFIQ', 'L', 'alifzakyarafiq', 'alifzakyarafiq', 3, NULL),
(38, '1516.10033', 'ANASTASYA RESKIANISSA', 'P', 'anastasyareskianissa', 'anastasyareskianissa', 3, NULL),
(40, '1516.10035', 'ARIQ FADIL LESMANA', 'L', 'ariqfadillesmana', 'ariqfadillesmana', 3, NULL),
(92, '1205799', 'Anita', 'P', '1205799', '83349cbdac695f3943635a4fd1aaa7d0', 5, 'pegawai_female_default.jpg'),
(93, '030316', 'Putri', 'P', '030316', '1471cea57bd0c388d50074907b9a8b98', 2, 'pegawai_female_default.jpg'),
(94, '12345', 'Andara Putri', 'P', '12345', '827ccb0eea8a706c4c34a16891f84e7b', 9, 'pegawai_female_default.jpg'),
(95, '04032016', 'Azep', 'L', '04032016', '8756e029614d4baf3e2f0667a98d622e', 7, 'pegawai_male_default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `struktur_kurikulum`
--

CREATE TABLE IF NOT EXISTS `struktur_kurikulum` (
  `id_struktur_kurikulum` int(11) NOT NULL AUTO_INCREMENT,
  `struktur_kurikulum` varchar(150) NOT NULL,
  `id_jurusan` int(11) NOT NULL,
  `tahun_berlaku` int(11) NOT NULL,
  `tgl_posting` datetime DEFAULT NULL,
  PRIMARY KEY (`id_struktur_kurikulum`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `struktur_kurikulum`
--

INSERT INTO `struktur_kurikulum` (`id_struktur_kurikulum`, `struktur_kurikulum`, `id_jurusan`, `tahun_berlaku`, `tgl_posting`) VALUES
(7, 'StrukturKurikulum_2015_RekayasaPerangkatLunak.pdf', 4, 2015, '2016-01-28 11:02:01');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nama_user` varchar(150) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `level_user` int(11) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama_user`, `username`, `password`, `level_user`) VALUES
(1, 'Admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 1),
(2, 'bla bla', 'izzah', '39a4daec4efa9cd25a9915331e3f7b00', 3),
(4, 'Petugas Piket', 'piket', 'd4b78ebe5d394063636ef18923d5b905', 4);

-- --------------------------------------------------------

--
-- Table structure for table `visi_misi`
--

CREATE TABLE IF NOT EXISTS `visi_misi` (
  `id_visi_misi` int(11) NOT NULL AUTO_INCREMENT,
  `visi` varchar(150) DEFAULT NULL,
  `misi` text,
  PRIMARY KEY (`id_visi_misi`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `visi_misi`
--

INSERT INTO `visi_misi` (`id_visi_misi`, `visi`, `misi`) VALUES
(1, '<p><em>Penyelenggaran Pendidikan Kejuruan Berkualitas dan Terpercaya Kota Bandung Tahun 2018.</em></p>\r\n<p>&nbsp;</p>\r\n<p>SMK BPI Bandung bertekad unt', '<ol>\r\n<li>Mewujudkan tata kelola, sistem pengendalian manajemen, dan sistem pengawasan internal yang modern, efektif, dan efisien.</li>\r\n<li>Mewujudkan budaya religi, jujur, disiplin, beretika, berestetika, pekerja keras, kreatif, inovatif, kompetitif, dan berkwalitas.</li>\r\n<li>Mewujudkan dinamisasi peningkatan kualitas pendidikan berkarakter yang berkesinambungan dan berkelanjutan.</li>\r\n<li>Mewujudkan Produk kompetensi keahlian Bernilai Jual Pasar Global.</li>\r\n<li>Memperluas akses kemitraan dunia kerja yang menjamin lapangan kerja dan prakerin bagi peserta didik dan lulusan SMK BPI.</li>\r\n<li>Mewujudkan lulusan yang handal di bidangnya dan fasih berbahasa Inggris sehingga dipercaya oleh segenap dunia kerja pemerintah&nbsp; maupun swasta.</li>\r\n<li>Mewujudkan jiwa <em>entrepreneurship</em> kuat yang mampu meningkatkan kwalitas hidup civitas akademika SMK BPI.</li>\r\n</ol>');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
