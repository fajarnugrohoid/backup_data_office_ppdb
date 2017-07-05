<?php
require __DIR__ . '/Database.php';
ini_set('max_execution_time', -1);
ini_set("memory_limit", "-1");
// extends the base class
class InitializationData extends Database
{

    public $classConnection;
    public $conn;
    public $listschool = array();
    public $historylist = array();
    private $history_idx = 0;

    public function __construct()
    {
        $this->classConnection = new Database;

    }

    public function resetQuota(){
        $query_sch = "SELECT a.id as id,a.type,a.quota,a.old_quota,a.old_quota_dw,a.old_quota_gw,a.old_quota_lk, a.quota_lk,b.name,b.is_border,substring(b.code,1,1) as code, a.quota_dw,a.quota_gw, b.foreigner_percentage
              FROM ppdb_option a
              inner join ppdb_school b on (a.school = b.id)
              where (substring(b.code,1,1)=3 ) and a.type='academic'
              ORDER BY b.code, a.id";

        $results_school = $this->conn->query($query_sch) or die(mysqli_error($this->conn));
        while ($row = mysqli_fetch_array($results_school)) {

            $inisialisasi_quota_awal="
                    UPDATE `ppdb_option` SET `quota` = `old_quota` , 
                    `quota_dw` =  `old_quota_dw` ,
                    `quota_gw` =  `old_quota_gw` ,
                    `quota_lk` = `old_quota_lk`
                    WHERE `ppdb_option`.`id` = '" . $row['id'] . "'";
                    //echo 'query_inisialisasi:' . $inisialisasi_quota_awal . '<br/>';
                $result_inisialisasi_quota = $this->conn->query($inisialisasi_quota_awal);
                @mysqli_free_result($result_inisialisasi_quota);
        }
        

    }

    public function getSchool()
    {
        $this->conn = $this->classConnection->connect();

        $sql_statistik = "DELETE
          from ppdb_statistic
          where `option` in(
            SELECT a.id FROM ppdb_option a
          inner join ppdb_school b on (a.school = b.id)
          where (substring(b.code,1,1)=3 ) and a.type='academic')
            ";

        $truncate_statistic = $this->conn->query($sql_statistik) or die(mysqli_error($this->conn));

        // if ($first==0){
        //     $this->resetQuota();
        // }

        /*$query_sch = "SELECT a.id as id,a.type,a.quota,b.name,b.is_border,substring(b.code,1,1) as code, a.quota_dw,a.quota_gw, b.foreigner_percentage
        FROM ppdb_option a
        inner join ppdb_school b on (a.school = b.id)
        where (substring(b.code,1,1)=2 or substring(b.code,1,1)=3 ) and a.type='academic'
        and a.id in ('325','331','337','355')
        ORDER BY b.code, a.id"; */
        $query_sch = "SELECT a.id as id,a.type,a.quota,a.old_quota,a.old_quota_dw,a.old_quota_gw,a.old_quota_lk, a.quota_lk,b.name,b.is_border,substring(b.code,1,1) as code, a.quota_dw,a.quota_gw, a.quota_br, b.foreigner_percentage
              FROM ppdb_option a
              inner join ppdb_school b on (a.school = b.id)
              where (substring(b.code,1,1)=3 ) and a.type='academic'
              and a.id in ('655','661','667','673','679')
              ORDER BY b.code, a.id";

        $results_school = $this->conn->query($query_sch) or die(mysqli_error($this->conn));
        $school_idx=0;
        while ($row = mysqli_fetch_array($results_school)) {
            $temp_total_pendaftar = 0;
            $temp_total_luar_kota = 0;

            /*start push siswa dalam wilayah*/
            /*$query = "SELECT * FROM ppdb_registration_academic
            where (type='academic')  and first_choice = '" . $row['id'] . " '
            and `status`='approved'
            and (( is_foreigner!='0' and (is_insentif1='1' and is_insentif2='1' )) or ( (is_foreigner='0') and (is_insentif1='1') ))
            "; */
            
            $query = "SELECT * FROM ppdb_registration_academic
                          where (type='academic')  and first_choice = '" . $row['id'] . " '
                          and `status`='approved' and is_insentif1='1'
                          ";
            /*$query = "SELECT * FROM ppdb_registration_academic
            where (type='academic')  and first_choice = '" . $row['id'] . " '
            and `status`='approved'
            and (
            ( is_foreigner!='0' and (is_insentif1='1' and is_insentif2='1' ))
            or ( (is_foreigner='0') and (is_insentif1='1') )
            or ( (is_foreigner='1') and (is_insentif1='1') )
            or ( (is_foreigner='2') and (is_insentif1='1') )
            )
            "; */

            $result_reg_dw = $this->conn->query($query) or die(mysqli_error($this->conn));
            $siswa_dw      = array();
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

                $siswa_dw[$x]['range']  = $r['range1'];
                $siswa_dw[$x]['range1'] = $r['range1'];
                $siswa_dw[$x]['range2'] = $r['range2'];

                $siswa_dw[$x]['accepted_status']       = '1';
                $siswa_dw[$x]['filtered_is_foreigner'] = '0';
                $siswa_dw[$x]['status']                = $siswa_dw[$x]['accepted_status'];
                $x++;
            }
            $temp_total_pendaftar = $temp_total_pendaftar + $x;
            @mysqli_free_result($result_reg_dw);
            $this->listschool[$school_idx]['id']                   = $row['id'];
            $this->listschool[$school_idx]['name']                 = $row['name'];
            $this->listschool[$school_idx]['quota']                = $row['quota'];
            $this->listschool[$school_idx]['old_quota']            = $row['old_quota'];
            $this->listschool[$school_idx]['foreigner_percentage'] = $row['foreigner_percentage'];
            $this->listschool[$school_idx]['low_passing_grage']    = 0;

            $this->listschool[$school_idx]['dw']['id']                   = $row['id'];
            $this->listschool[$school_idx]['dw']['quota']                = $row['quota_dw'];
            $this->listschool[$school_idx]['dw']['old_quota_dw']         = $row['old_quota_dw'];
            $this->listschool[$school_idx]['dw']['filtered']             = 0;
            $this->listschool[$school_idx]['dw']['foreigner_percentage'] = $row['foreigner_percentage'];
            $this->listschool[$school_idx]['dw']['passing_grade']        = 0;
            $this->listschool[$school_idx]['dw']['remaining_quota']      = 0;

            if (isset($siswa_dw)) {
                $this->listschool[$school_idx]['dw']['data'] = $siswa_dw;
            } else {
                $this->listschool[$school_idx]['dw']['data'] = array();
            }
            $this->listschool[$school_idx]['dw']['status'] = 0;
            unset($siswa_dw);
            /*end push siswa dalam wilayah*/

            //history
            $this->historylist[$this->history_idx][$school_idx]['dw']['id'] = $this->listschool[$school_idx]['dw']['id'];
            $this->historylist[$this->history_idx][$school_idx]['dw']['data'] = $this->listschool[$school_idx]['dw']['data'];

            /*start push siswa gabungan wilayah*/
            $query = "SELECT * FROM ppdb_registration_academic
                          where (type='academic')  and first_choice = '" . $row['id'] . " '
                          and status='approved' and is_insentif1='0' and is_foreigner='0' ";

            $temp_passing_grade = 0;
            $result_gw          = $this->conn->query($query) or die(mysqli_error($this->conn));

            $siswa_gw = array();
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

                $siswa_gw[$x]['range']  = $r['range1'];
                $siswa_gw[$x]['range1'] = $r['range1'];
                $siswa_gw[$x]['range2'] = $r['range2'];

                $siswa_gw[$x]['accepted_status']       = '1';
                $siswa_gw[$x]['filtered_is_foreigner'] = '1';
                $siswa_gw[$x]['status']                = $siswa_gw[$x]['accepted_status'];
                $x++;
            }

            $temp_total_pendaftar = $temp_total_pendaftar + $x;
            @mysqli_free_result($result_gw);

            $this->listschool[$school_idx]['gw']['id']                   = $row['id'];
            $this->listschool[$school_idx]['gw']['quota']                = $row['quota_gw'];
            $this->listschool[$school_idx]['gw']['old_quota_gw']         = $row['old_quota_gw'];
            $this->listschool[$school_idx]['gw']['filtered']             = 0;
            $this->listschool[$school_idx]['gw']['foreigner_percentage'] = $row['foreigner_percentage'];
            $this->listschool[$school_idx]['gw']['passing_grade']        = 0;
            $this->listschool[$school_idx]['gw']['remaining_quota']      = 0;

            if (isset($siswa_gw)) {
                $this->listschool[$school_idx]['gw']['data'] = $siswa_gw;
            } else {
                $this->listschool[$school_idx]['gw']['data'] = array();
            }
            $this->listschool[$school_idx]['gw']['status'] = 0;

            unset($siswa_gw);
            /*end push siswa gabungan kota*/

            //history
            $this->historylist[$this->history_idx][$school_idx]['gw']['id'] = $this->listschool[$school_idx]['gw']['id'];
            $this->historylist[$this->history_idx][$school_idx]['gw']['data'] = $this->listschool[$school_idx]['gw']['data'];


            /*start push siswa bandung raya*/
            $query = "SELECT * FROM ppdb_registration_academic
                          where (type='academic')  and first_choice = '" . $row['id'] . " '
                          and status='approved'
                          and is_foreigner='1' and (is_insentif1!='1' and is_insentif2!='1') ";

            $temp_passing_grade = 0;
            $result_gw          = $this->conn->query($query) or die(mysqli_error($this->conn));

            $siswa_br = array();
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
                $siswa_br[$x]['total1']        = $r['score_total1'];
                $siswa_br[$x]['total2']        = $r['score_total2'];
                $siswa_br[$x]['score_bahasa']  = $r['score_bahasa'];
                $siswa_br[$x]['score_english'] = $r['score_english'];
                $siswa_br[$x]['score_math']    = $r['score_math'];
                $siswa_br[$x]['score_physics'] = $r['score_physics'];
                $siswa_br[$x]['score_range']   = $r['score_range1'];
                $siswa_br[$x]['score_range1']  = $r['score_range1'];
                $siswa_br[$x]['score_range2']  = $r['score_range2'];

                $siswa_br[$x]['range']  = $r['range1'];
                $siswa_br[$x]['range1'] = $r['range1'];
                $siswa_br[$x]['range2'] = $r['range2'];

                $siswa_br[$x]['accepted_status']       = '1';
                $siswa_br[$x]['filtered_is_foreigner'] = '1';
                $siswa_br[$x]['status']                = $siswa_br[$x]['accepted_status'];
                $x++;
            }

            $temp_total_pendaftar = $temp_total_pendaftar + $x;
            $temp_total_luar_kota        = $temp_total_luar_kota + $x;
            @mysqli_free_result($result_gw);

            $this->listschool[$school_idx]['br']['id']                   = $row['id'];
            $this->listschool[$school_idx]['br']['quota']                = floor($this->listschool[$school_idx]['quota'] * 0.1);
            $this->listschool[$school_idx]['br']['filtered']             = 0;
            $this->listschool[$school_idx]['br']['foreigner_percentage'] = $row['foreigner_percentage'];
            $this->listschool[$school_idx]['br']['passing_grade']        = 0;
            $this->listschool[$school_idx]['br']['remaining_quota']      = 0;
            if (isset($siswa_br)) {
                $this->listschool[$school_idx]['br']['data'] = $siswa_br;
            } else {
                $this->listschool[$school_idx]['br']['data'] = array();
            }
            $this->listschool[$school_idx]['br']['status'] = 0;
            unset($siswa_br);
            /*end push siswa bandung raya*/

            //history
            $this->historylist[$this->history_idx][$school_idx]['br']['id'] = $this->listschool[$school_idx]['br']['id'];
            $this->historylist[$this->history_idx][$school_idx]['br']['data'] = $this->listschool[$school_idx]['br']['data'];


            /*start push siswa luar kota*/
            $query = "SELECT * FROM ppdb_registration_academic
                          where (type='academic')  and first_choice = '" . $row['id'] . " '
                          and status='approved'
                          and is_foreigner='2' and (is_insentif1!='1' and is_insentif2!='1')";

            $temp_passing_grade = 0;
            $result_luar        = $this->conn->query($query) or die(mysqli_error($this->conn));
            $siswa_lk         = array();
            $x                  = 0;
            while ($r = mysqli_fetch_array($result_luar)) {
                $siswa_lk[$x]['id']              = $r['id'];
                $siswa_lk[$x]['type']            = $r['type'];
                $siswa_lk[$x]['name']            = $r['name'];
                $siswa_lk[$x]['first_choice']    = $r['first_choice'];
                $siswa_lk[$x]['second_choice']   = $r['second_choice'];
                $siswa_lk[$x]['is_foreigner']    = $r['is_foreigner'];
                $siswa_lk[$x]['is_insentif1']    = $r['is_insentif1'];
                $siswa_lk[$x]['is_insentif2']    = $r['is_insentif2'];
                $siswa_lk[$x]['accepted_school'] = $r['first_choice'];

                $siswa_lk[$x]['total']         = $r['score_total1'];
                $siswa_lk[$x]['total1']        = $r['score_total1'];
                $siswa_lk[$x]['total2']        = $r['score_total2'];
                $siswa_lk[$x]['score_bahasa']  = $r['score_bahasa'];
                $siswa_lk[$x]['score_english'] = $r['score_english'];
                $siswa_lk[$x]['score_math']    = $r['score_math'];
                $siswa_lk[$x]['score_physics'] = $r['score_physics'];
                $siswa_lk[$x]['score_range']   = $r['score_range1'];
                $siswa_lk[$x]['score_range1']  = $r['score_range1'];
                $siswa_lk[$x]['score_range2']  = $r['score_range2'];

                $siswa_lk[$x]['range']  = $r['range1'];
                $siswa_lk[$x]['range1'] = $r['range1'];
                $siswa_lk[$x]['range2'] = $r['range2'];

                $siswa_lk[$x]['accepted_status']       = '1';
                $siswa_lk[$x]['filtered_is_foreigner'] = '2';
                $siswa_lk[$x]['status']                = $siswa_lk[$x]['accepted_status'];
                $x++;
            }
            @mysqli_free_result($result_luar);
            $this->listschool[$school_idx]['lk']['id']                   = $row['id'];
            $this->listschool[$school_idx]['lk']['quota']                = floor($this->listschool[$school_idx]['quota'] * 0.1);
            $this->listschool[$school_idx]['lk']['filtered']             = 0;
            $this->listschool[$school_idx]['lk']['foreigner_percentage'] = $row['foreigner_percentage'];
            $this->listschool[$school_idx]['lk']['passing_grade']        = 0;
            $this->listschool[$school_idx]['lk']['remaining_quota']      = 0;
            

            if (isset($siswa_lk)) {
                $this->listschool[$school_idx]['lk']['data'] = $siswa_lk;
            } else {
                $this->listschool[$school_idx]['lk']['data'] = array();
            }
            $this->listschool[$school_idx]['lk']['status'] = 0;
            unset($siswa_lk);
            /*end push siswa luar kota*/

            //history
            $this->historylist[$this->history_idx][$school_idx]['lk']['id'] = $this->listschool[$school_idx]['lk']['id'];
            $this->historylist[$this->history_idx][$school_idx]['lk']['data'] = $this->listschool[$school_idx]['lk']['data'];


            $temp_total_pendaftar        = $temp_total_pendaftar + $x;
            $temp_total_luar_kota        = $temp_total_luar_kota + $x;
            $update_tot_pendaftar        = "insert into ppdb_statistic (`id`, `option`, `registered_total`,`registered_foreigner`) values ('', '" . $row['id'] . "','" . $temp_total_pendaftar . "','" . $temp_total_luar_kota . "')";
            $result_update_tot_pendaftar = $this->conn->query($update_tot_pendaftar);
            @mysqli_free_result($result_update_tot_pendaftar);

            echo '<br/>' . '0-' . $this->listschool[$school_idx]['gw']['id'];
            dump_r($this->historylist[$this->history_idx][$school_idx], false, true, 4, 1);

            $school_idx++;
        } //end while

        $this->listschool[$school_idx]['id']                   = '9999';
        $this->listschool[$school_idx]['name']                 = 'Sekolah Buangan';
        $this->listschool[$school_idx]['quota']                = 0;
        $this->listschool[$school_idx]['filtered']              = 1;
        $this->listschool[$school_idx]['foreigner_percentage'] = 0;

        $this->listschool[$school_idx]['old_quota']          = 0;
        $this->listschool[$school_idx]['quota_lk']     = 0;
        $this->listschool[$school_idx]['old_quota_lk'] = 0;

        $this->listschool[$school_idx]['remaining_quota'] = 0;

        $this->listschool[$school_idx]['dw']['id']              = '9999';
        $this->listschool[$school_idx]['dw']['name']            = 'Buangan';
        $this->listschool[$school_idx]['dw']['quota']           = 0;
        $this->listschool[$school_idx]['dw']['data']            = array();
        $this->listschool[$school_idx]['dw']['status']          = 1;
        $this->listschool[$school_idx]['dw']['filtered']        = 1;
        $this->listschool[$school_idx]['dw']['remaining_quota'] = 0;

        $this->listschool[$school_idx]['gw']['id']              = '9999';
        $this->listschool[$school_idx]['gw']['name']            = 'Buangan';
        $this->listschool[$school_idx]['gw']['quota']           = 0;
        $this->listschool[$school_idx]['gw']['data']            = array();
        $this->listschool[$school_idx]['gw']['status']          = 1;
        $this->listschool[$school_idx]['gw']['filtered']        = 1;
        $this->listschool[$school_idx]['gw']['remaining_quota'] = 0;

        $this->listschool[$school_idx]['br']['id']              = '9999';
        $this->listschool[$school_idx]['br']['name']            = 'Buangan';
        $this->listschool[$school_idx]['br']['quota']           = 0;
        $this->listschool[$school_idx]['br']['data']            = array();
        $this->listschool[$school_idx]['br']['status']          = 1;
        $this->listschool[$school_idx]['br']['filtered']        = 1;
        $this->listschool[$school_idx]['br']['remaining_quota'] = 0;

        $this->listschool[$school_idx]['lk']['id']              = '9999';
        $this->listschool[$school_idx]['lk']['name']            = 'Buangan';
        $this->listschool[$school_idx]['lk']['quota']           = 0;
        $this->listschool[$school_idx]['lk']['data']            = array();
        $this->listschool[$school_idx]['lk']['status']          = 1;
        $this->listschool[$school_idx]['lk']['filtered']        = 1;
        $this->listschool[$school_idx]['lk']['remaining_quota'] = 0;


        $this->classConnection->close();

        return $this->listschool;
    }

    public function history()
    {
       
        return $this->historylist;
    }

} // end of class InitilizationData
