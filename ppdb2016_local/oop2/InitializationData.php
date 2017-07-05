<?php
require 'Database.php';
ini_set('max_execution_time', -1);
ini_set("memory_limit","-1");
// extends the base class
class InitializationData extends Database
{

    public $classConnection;
    public $conn;
    public $listsekolah = [];

    public function __construct()
    {
        $this->classConnection = new Database;
        
    }

    public function getSchool()
    {
        $this->conn            = $this->classConnection->connect();
        $query_sch = "SELECT a.id as id,a.type,a.quota,b.name,b.is_border,substring(b.code,1,1) as code, a.quota_dw,a.quota_gw, b.foreigner_percentage
              FROM ppdb_option a
              inner join ppdb_school b on (a.school = b.id)
              where (substring(b.code,1,1)=2 or substring(b.code,1,1)=3 ) and a.type='academic'
              and a.id in ('325','331','337','355')
              ORDER BY b.code, a.id";

        $results_school = $this->conn->query($query_sch) or die(mysqli_error($this->conn));
        while ($row = mysqli_fetch_array($results_school)) {
            $temp_total_pendaftar = 0;
            $temp_total_luar_kota = 0;

            /*start push siswa dalam wilayah*/
            $query = "SELECT * FROM ppdb_registration_academic
                          where (type='academic')  and first_choice = '" . $row['id'] . " '
                          and status='approved'
                          and is_insentif1='1'
                          ";

            $result_reg_dw = $this->conn->query($query) or die(mysqli_error($this->conn));
            $siswa_dw      = [];
            $x             = 0;
            while ($r = mysqli_fetch_array($result_reg_dw)) {
                $siswa_dw[$x]['id']              = $r['id'];
                $siswa_dw[$x]['type']            = $r['type'];
                $siswa_dw[$x]['name']            = $r['name'];
                $siswa_dw[$x]['first_choice']    = $r['first_choice'];
                $siswa_dw[$x]['second_choice']   = $r['second_choice'];
                $siswa_dw[$x]['is_foreigner']    = $r['is_foreigner'];
                $siswa_dw[$x]['is_insentif1']    = $r['is_insentif1'];
                $siswa_dw[$x]['is_insentif2']    = $r['is_insentif2'];
                $siswa_dw[$x]['accepted_school'] = $r['first_choice'];

                $siswa_dw[$x]['total']         = $r['score_total1'];
                $siswa_dw[$x]['total1']        = $r['score_total1'];
                $siswa_dw[$x]['total2']        = $r['score_total2'];
                $siswa_dw[$x]['score_bahasa']  = $r['score_bahasa'];
                $siswa_dw[$x]['score_english'] = $r['score_english'];
                $siswa_dw[$x]['score_math']    = $r['score_math'];
                $siswa_dw[$x]['score_physics'] = $r['score_physics'];
                $siswa_dw[$x]['score_range']   = $r['score_range1'];
                $siswa_dw[$x]['score_range1']  = $r['score_range1'];
                $siswa_dw[$x]['score_range2']  = $r['score_range2'];

                $siswa_dw[$x]['accepted_status']       = '1';
                $siswa_dw[$x]['filtered_is_foreigner'] = '0';
                $siswa_dw[$x]['status']                = $siswa_dw[$x]['accepted_status'];
                $x++;
            }
            $temp_total_pendaftar = $temp_total_pendaftar + $x;
            @mysqli_free_result($result_reg_dw);
            $this->listsekolah[$row['id']]['id']                   = $row['id'];
            $this->listsekolah[$row['id']]['name']                 = $row['name'];
            $this->listsekolah[$row['id']]['quota']                = $row['quota'];
            $this->listsekolah[$row['id']]['foreigner_percentage'] = $row['foreigner_percentage'];

            $this->listsekolah[$row['id']]['dalam']['id']                   = $row['id'];
            $this->listsekolah[$row['id']]['dalam']['quota']                = $row['quota_dw'];
            $this->listsekolah[$row['id']]['dalam']['foreigner_percentage'] = $row['foreigner_percentage'];
            $this->listsekolah[$row['id']]['dalam']['passing_grade']        = 0;

            if (isset($siswa_dw)) {
                $this->listsekolah[$row['id']]['dalam']['data'] = $siswa_dw;
            } else {
                $this->listsekolah[$row['id']]['dalam']['data'] = array();
            }
            $this->listsekolah[$row['id']]['dalam']['status'] = 0;
            unset($siswa_dw);

            /*start push siswa gabungan wilayah*/
            $query = "SELECT * FROM ppdb_registration_academic
                          where (type='academic')  and first_choice = '" . $row['id'] . " '
                          and status='approved' and is_insentif1='0' and is_foreigner<>'2' ";

            $temp_passing_grade = 0;
            $result_gw          = $this->conn->query($query) or die(mysqli_error($mysqli));

            $siswa_gw = [];
            $x        = 0;
            while ($r = mysqli_fetch_array($result_gw)) {
                $siswa_gw[$x]['id']              = $r['id'];
                $siswa_gw[$x]['type']            = $r['type'];
                $siswa_gw[$x]['name']            = $r['name'];
                $siswa_gw[$x]['first_choice']    = $r['first_choice'];
                $siswa_gw[$x]['second_choice']   = $r['second_choice'];
                $siswa_gw[$x]['is_foreigner']    = $r['is_foreigner'];
                $siswa_gw[$x]['is_insentif1']    = $r['is_insentif1'];
                $siswa_gw[$x]['is_insentif2']    = $r['is_insentif2'];
                $siswa_gw[$x]['accepted_school'] = $r['first_choice'];

                $siswa_gw[$x]['total']         = $r['score_total1'];
                $siswa_gw[$x]['total1']        = $r['score_total1'];
                $siswa_gw[$x]['total2']        = $r['score_total2'];
                $siswa_gw[$x]['score_bahasa']  = $r['score_bahasa'];
                $siswa_gw[$x]['score_english'] = $r['score_english'];
                $siswa_gw[$x]['score_math']    = $r['score_math'];
                $siswa_gw[$x]['score_physics'] = $r['score_physics'];
                $siswa_gw[$x]['score_range']   = $r['score_range1'];
                $siswa_gw[$x]['score_range1']  = $r['score_range1'];
                $siswa_gw[$x]['score_range2']  = $r['score_range2'];

                $siswa_gw[$x]['accepted_status']       = '1';
                $siswa_gw[$x]['filtered_is_foreigner'] = '1';
                $siswa_gw[$x]['status']                = $siswa_gw[$x]['accepted_status'];
                $x++;
            }

            $temp_total_pendaftar = $temp_total_pendaftar + $x;
            @mysqli_free_result($result_gw);

            $this->listsekolah[$row['id']]['gabungan']['id']                   = $row['id'];
            $this->listsekolah[$row['id']]['gabungan']['quota']                = $row['quota_gw'];
            $this->listsekolah[$row['id']]['gabungan']['foreigner_percentage'] = $row['foreigner_percentage'];
            $this->listsekolah[$row['id']]['gabungan']['passing_grade']        = 0;

            if (isset($siswa_gw)) {
                $this->listsekolah[$row['id']]['gabungan']['data'] = $siswa_gw;
            } else {
                $this->listsekolah[$row['id']]['gabungan']['data'] = array();
            }
            $this->listsekolah[$row['id']]['gabungan']['status'] = 0;

            unset($siswa_gw);
            /*end push siswa gabungan kota*/
            $temp_total_pendaftar = $temp_total_pendaftar + $x;
            $temp_total_luar_kota = $x;

            /*start push siswa luar kota*/
            $query = "SELECT * FROM ppdb_registration_academic
                          where (type='academic')  and first_choice = '" . $row['id'] . " '
                          and status='approved' and is_insentif1='0' and is_foreigner='2'";

            $temp_passing_grade = 0;
            $result_luar        = $this->conn->query($query) or die(mysqli_error($mysqli));
            $siswa_luar         = [];
            $x                  = 0;
            while ($r = mysqli_fetch_array($result_luar)) {
                $siswa_luar[$x]['id']              = $r['id'];
                $siswa_luar[$x]['type']            = $r['type'];
                $siswa_luar[$x]['name']            = $r['name'];
                $siswa_luar[$x]['first_choice']    = $r['first_choice'];
                $siswa_luar[$x]['second_choice']   = $r['second_choice'];
                $siswa_luar[$x]['is_foreigner']    = $r['is_foreigner'];
                $siswa_luar[$x]['is_insentif1']    = $r['is_insentif1'];
                $siswa_luar[$x]['is_insentif2']    = $r['is_insentif2'];
                $siswa_luar[$x]['accepted_school'] = $r['first_choice'];

                $siswa_luar[$x]['total']         = $r['score_total1'];
                $siswa_luar[$x]['total1']        = $r['score_total1'];
                $siswa_luar[$x]['total2']        = $r['score_total2'];
                $siswa_luar[$x]['score_bahasa']  = $r['score_bahasa'];
                $siswa_luar[$x]['score_english'] = $r['score_english'];
                $siswa_luar[$x]['score_math']    = $r['score_math'];
                $siswa_luar[$x]['score_physics'] = $r['score_physics'];
                $siswa_luar[$x]['score_range']   = $r['score_range1'];
                $siswa_luar[$x]['score_range1']  = $r['score_range1'];
                $siswa_luar[$x]['score_range2']  = $r['score_range2'];

                $siswa_luar[$x]['accepted_status']       = '1';
                $siswa_luar[$x]['filtered_is_foreigner'] = '2';
                $siswa_luar[$x]['status']                = $siswa_luar[$x]['accepted_status'];
                $x++;
            }

            $temp_total_pendaftar = $temp_total_pendaftar + $x;
            @mysqli_free_result($result_luar);

            $this->listsekolah[$row['id']]['luar']['id']                   = $row['id'];
            $this->listsekolah[$row['id']]['luar']['quota']                = $row['quota'];
            $this->listsekolah[$row['id']]['luar']['foreigner_percentage'] = $row['foreigner_percentage'];
            $this->listsekolah[$row['id']]['luar']['passing_grade']        = 0;

            if (isset($siswa_luar)) {
                $this->listsekolah[$row['id']]['luar']['data'] = $siswa_luar;
            } else {
                $this->listsekolah[$row['id']]['luar']['data'] = array();
            }
            $this->listsekolah[$row['id']]['luar']['status'] = 0;
            unset($siswa_luar);
            /*end push siswa luar kota*/

            $temp_total_pendaftar = $temp_total_pendaftar + $x;
            $temp_total_luar_kota = $x;
        } //end while

        $this->listsekolah['9999']['id']                   = '9999';
        $this->listsekolah['9999']['quota']                = 0;
        $this->listsekolah['9999']['presentase_luar_kota'] = 0;
        $this->listsekolah['9999']['kuota_seluruh']        = 0;

        $this->listsekolah['9999']['dalam']['id']     = '9999';
        $this->listsekolah['9999']['dalam']['nama']   = 'Buangan';
        $this->listsekolah['9999']['dalam']['quota']  = 0;
        $this->listsekolah['9999']['dalam']['data']   = array();
        $this->listsekolah['9999']['dalam']['status'] = 1;

        $this->listsekolah['9999']['gabungan']['id']     = '9999';
        $this->listsekolah['9999']['gabungan']['nama']   = 'Buangan';
        $this->listsekolah['9999']['gabungan']['quota']  = 0;
        $this->listsekolah['9999']['gabungan']['data']   = array();
        $this->listsekolah['9999']['gabungan']['status'] = 1;

        $this->listsekolah['9999']['luar']['id']     = '9999';
        $this->listsekolah['9999']['luar']['nama']   = 'Buangan';
        $this->listsekolah['9999']['luar']['quota']  = 0;
        $this->listsekolah['9999']['luar']['data']   = array();
        $this->listsekolah['9999']['luar']['status'] = 1;

        $this->classConnection->close();

        return $this->listsekolah;
    }

    public function test()
    {
        return 'nilai';
    }

} // end of class Spinach
