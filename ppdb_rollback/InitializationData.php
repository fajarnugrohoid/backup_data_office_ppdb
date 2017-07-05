<?php
require __DIR__ . '/Database.php';
ini_set('max_execution_time', -1);
ini_set("memory_limit", "-1");
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

    
    public function getSchool($first)
    {
        $this->conn = $this->classConnection->connect();


        /*$query_sch = "SELECT a.id as id,a.type,a.quota,b.name,b.is_border,substring(b.code,1,1) as code, a.quota_dw,a.quota_gw, b.foreigner_percentage
        FROM ppdb_option a
        inner join ppdb_school b on (a.school = b.id)
        where (substring(b.code,1,1)=2 or substring(b.code,1,1)=3 ) and a.type='academic'
        and a.id in ('325','331','337','355')
        ORDER BY b.code, a.id"; */
        $query_sch = "SELECT a.id as id,a.type,a.quota,a.old_quota,a.old_quota_dw,a.old_quota_gw,a.old_quota_luarkota, a.quota_luarkota,b.name,b.is_border,substring(b.code,1,1) as code, a.quota_dw,a.quota_gw, b.foreigner_percentage
              FROM ppdb_option a
              inner join ppdb_school b on (a.school = b.id)
              where (substring(b.code,1,1)=2) and a.type='academic'
              and a.id in ('325','331','337')
              ORDER BY b.code, a.id";

        $results_school = $this->conn->query($query_sch) or die(mysqli_error($this->conn));
        while ($row = mysqli_fetch_array($results_school)) {
            $temp_total_pendaftar = 0;
            $temp_total_luar_kota = 0;

            $query = "SELECT * FROM ppdb_registration_academic
                          where (type='academic')  and first_choice = '" . $row['id'] . " '
                          and `status`='approved' and is_insentif1='1'
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
            $this->listsekolah[$row['id']]['old_quota']            = $row['old_quota'];
            $this->listsekolah[$row['id']]['quota_luarkota']       = $row['quota_luarkota'];
            $this->listsekolah[$row['id']]['old_quota_luarkota']   = $row['old_quota_luarkota'];
            $this->listsekolah[$row['id']]['foreigner_percentage'] = $row['foreigner_percentage'];
            $this->listsekolah[$row['id']]['low_passing_grage']    = 0;

            $this->listsekolah[$row['id']]['dalam']['id']                   = $row['id'];
            $this->listsekolah[$row['id']]['dalam']['quota']                = $row['quota_dw'];
            $this->listsekolah[$row['id']]['dalam']['old_quota_dw']         = $row['old_quota_dw'];
            $this->listsekolah[$row['id']]['dalam']['foreigner_percentage'] = $row['foreigner_percentage'];
            $this->listsekolah[$row['id']]['dalam']['passing_grade']        = 0;
            $this->listsekolah[$row['id']]['dalam']['remaining_quota']      = 0;

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
                          and status='approved' and is_insentif1='0' and is_foreigner='0' ";

            $temp_passing_grade = 0;
            $result_gw          = $this->conn->query($query) or die(mysqli_error($this->conn));

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
                
                $siswa_gw[$x]['accepted_status']       = '1';
                $siswa_gw[$x]['filtered_is_foreigner'] = '1';
                $siswa_gw[$x]['status']                = $siswa_gw[$x]['accepted_status'];
                $x++;
            }

            $temp_total_pendaftar = $temp_total_pendaftar + $x;
            @mysqli_free_result($result_gw);

            $this->listsekolah[$row['id']]['gabungan']['id']                   = $row['id'];
            $this->listsekolah[$row['id']]['gabungan']['quota']                = $row['quota_gw'];
            $this->listsekolah[$row['id']]['gabungan']['old_quota_gw']         = $row['old_quota_gw'];
            $this->listsekolah[$row['id']]['gabungan']['foreigner_percentage'] = $row['foreigner_percentage'];
            $this->listsekolah[$row['id']]['gabungan']['passing_grade']        = 0;
            $this->listsekolah[$row['id']]['gabungan']['remaining_quota']      = 0;

            if (isset($siswa_gw)) {
                $this->listsekolah[$row['id']]['gabungan']['data'] = $siswa_gw;
            } else {
                $this->listsekolah[$row['id']]['gabungan']['data'] = array();
            }
            $this->listsekolah[$row['id']]['gabungan']['status'] = 0;

            unset($siswa_gw);
            /*end push siswa gabungan kota*/

            /*start push siswa bandung raya*/
            $query = "SELECT * FROM ppdb_registration_academic
                          where (type='academic')  and first_choice = '" . $row['id'] . " '
                          and status='approved'
                          and is_foreigner='1' and (is_insentif1!='1' and is_insentif2!='1') ";

            $temp_passing_grade = 0;
            $result_gw          = $this->conn->query($query) or die(mysqli_error($this->conn));

            $siswa_br = [];
            $x        = 0;
            while ($r = mysqli_fetch_array($result_gw)) {
                $siswa_br[$x]['id']              = $r['id'];
                $siswa_br[$x]['type']            = $r['type'];
                $siswa_br[$x]['name']            = $r['name'];
                $siswa_br[$x]['first_choice']    = $r['first_choice'];
                $siswa_br[$x]['second_choice']   = $r['second_choice'];
                $siswa_br[$x]['is_foreigner']    = $r['is_foreigner'];
                $siswa_br[$x]['is_insentif1']    = $r['is_insentif1'];
                $siswa_br[$x]['is_insentif2']    = $r['is_insentif2'];
                $siswa_br[$x]['accepted_school'] = $r['first_choice'];

                $siswa_br[$x]['total']         = $r['score_total1'];
                
                $siswa_br[$x]['accepted_status'] = '1';
                $siswa_br[$x]['filtered_is_foreigner'] = '1';
                $siswa_br[$x]['status']                = $siswa_br[$x]['accepted_status'];
                $x++;
            }

            $temp_total_pendaftar = $temp_total_pendaftar + $x;
            $temp_total_luar_kota        = $temp_total_luar_kota + $x;
            @mysqli_free_result($result_gw);

            $this->listsekolah[$row['id']]['bandungraya']['id']                   = $row['id'];
            $this->listsekolah[$row['id']]['bandungraya']['quota']                = $row['quota'];
            $this->listsekolah[$row['id']]['bandungraya']['quota_luarkota']       = $row['quota_luarkota'];
            $this->listsekolah[$row['id']]['bandungraya']['foreigner_percentage'] = $row['foreigner_percentage'];
            $this->listsekolah[$row['id']]['bandungraya']['passing_grade']        = 0;
            $this->listsekolah[$row['id']]['bandungraya']['remaining_quota']      = 0;

            if (isset($siswa_br)) {
                $this->listsekolah[$row['id']]['bandungraya']['data'] = $siswa_br;
            } else {
                $this->listsekolah[$row['id']]['bandungraya']['data'] = array();
            }
            $this->listsekolah[$row['id']]['bandungraya']['status'] = 0;

            unset($siswa_br);
            /*end push siswa bandung raya*/

            /*start push siswa luar kota*/
            $query = "SELECT * FROM ppdb_registration_academic
                          where (type='academic')  and first_choice = '" . $row['id'] . " '
                          and status='approved'
                          and is_foreigner='2' and (is_insentif1!='1' and is_insentif2!='1')";

            $temp_passing_grade = 0;
            $result_luar        = $this->conn->query($query) or die(mysqli_error($this->conn));
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

                $siswa_luar[$x]['accepted_status']       = '1';
                $siswa_luar[$x]['filtered_is_foreigner'] = '2';
                $siswa_luar[$x]['status']                = $siswa_luar[$x]['accepted_status'];
                $x++;
            }
            @mysqli_free_result($result_luar);
            $this->listsekolah[$row['id']]['luar']['id']                   = $row['id'];
            $this->listsekolah[$row['id']]['luar']['quota']                = $row['quota'];
            $this->listsekolah[$row['id']]['luar']['quota_luarkota']       = $row['quota_luarkota'];
            $this->listsekolah[$row['id']]['luar']['foreigner_percentage'] = $row['foreigner_percentage'];
            $this->listsekolah[$row['id']]['luar']['passing_grade']        = 0;
            $this->listsekolah[$row['id']]['luar']['remaining_quota']      = 0;

            if (isset($siswa_luar)) {
                $this->listsekolah[$row['id']]['luar']['data'] = $siswa_luar;
            } else {
                $this->listsekolah[$row['id']]['luar']['data'] = array();
            }
            $this->listsekolah[$row['id']]['luar']['status'] = 0;
            unset($siswa_luar);
            /*end push siswa luar kota*/

            $temp_total_pendaftar        = $temp_total_pendaftar + $x;
            $temp_total_luar_kota        = $temp_total_luar_kota + $x;
            $update_tot_pendaftar        = "insert into ppdb_statistic (`id`, `option`, `registered_total`,`registered_foreigner`) values ('', '" . $row['id'] . "','" . $temp_total_pendaftar . "','" . $temp_total_luar_kota . "')";
            $result_update_tot_pendaftar = $this->conn->query($update_tot_pendaftar);
            @mysqli_free_result($result_update_tot_pendaftar);

        } //end while

        $this->listsekolah['9999']['id']                   = '9999';
        $this->listsekolah['9999']['name']                 = 'Sekolah Buangan';
        $this->listsekolah['9999']['quota']                = 0;
        $this->listsekolah['9999']['quota']                = 0;
        $this->listsekolah['9999']['foreigner_percentage'] = 0;

        $this->listsekolah['9999']['old_quota']          = 0;
        $this->listsekolah['9999']['quota_luarkota']     = 0;
        $this->listsekolah['9999']['old_quota_luarkota'] = 0;

        $this->listsekolah['9999']['remaining_quota'] = 0;

        $this->listsekolah['9999']['dalam']['id']              = '9999';
        $this->listsekolah['9999']['dalam']['name']            = 'Buangan';
        $this->listsekolah['9999']['dalam']['quota']           = 0;
        $this->listsekolah['9999']['dalam']['data']            = array();
        $this->listsekolah['9999']['dalam']['status']          = 1;
        $this->listsekolah['9999']['dalam']['remaining_quota'] = 0;

        $this->listsekolah['9999']['gabungan']['id']              = '9999';
        $this->listsekolah['9999']['gabungan']['name']            = 'Buangan';
        $this->listsekolah['9999']['gabungan']['quota']           = 0;
        $this->listsekolah['9999']['gabungan']['data']            = array();
        $this->listsekolah['9999']['gabungan']['status']          = 1;
        $this->listsekolah['9999']['gabungan']['remaining_quota'] = 0;

        $this->listsekolah['9999']['bandungraya']['id']              = '9999';
        $this->listsekolah['9999']['bandungraya']['name']            = 'Buangan';
        $this->listsekolah['9999']['bandungraya']['quota']           = 0;
        $this->listsekolah['9999']['bandungraya']['data']            = array();
        $this->listsekolah['9999']['bandungraya']['status']          = 1;
        $this->listsekolah['9999']['bandungraya']['remaining_quota'] = 0;

        $this->listsekolah['9999']['luar']['id']              = '9999';
        $this->listsekolah['9999']['luar']['name']            = 'Buangan';
        $this->listsekolah['9999']['luar']['quota']           = 0;
        $this->listsekolah['9999']['luar']['data']            = array();
        $this->listsekolah['9999']['luar']['status']          = 1;
        $this->listsekolah['9999']['luar']['remaining_quota'] = 0;

        $this->classConnection->close();


        return $this->listsekolah;
    }

    public function test()
    {
        echo json_encode($this->getSchool(0));
    }

} // end of class Spinach


$initial = new InitializationData;

$initial->test();