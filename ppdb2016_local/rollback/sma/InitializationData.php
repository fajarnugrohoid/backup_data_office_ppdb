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


    public function getSchool()
    {
        $this->conn = $this->classConnection->connect();
        /*
        $sql_statistik = "DELETE
          from ppdb_statistic
          where `option` in(
            SELECT a.id FROM ppdb_option a
          inner join ppdb_school b on (a.school = b.id)
          where (substring(b.code,1,1)=3 ) and a.type='academic')
            ";

        $truncate_statistic = $this->conn->query($sql_statistik) or die(mysqli_error($this->conn));

        if ($first==0){
            $this->resetQuota();
        }*/

        /*$query_sch = "SELECT a.id as id,a.type,a.quota,b.name,b.is_border,substring(b.code,1,1) as code, a.quota_dw,a.quota_gw, b.foreigner_percentage
        FROM ppdb_option a
        inner join ppdb_school b on (a.school = b.id)
        where (substring(b.code,1,1)=2 or substring(b.code,1,1)=3 ) and a.type='academic'
        and a.id in ('655','661')
        ORDER BY b.code, a.id"; */
        $query_sch = "SELECT a.id as id,a.type,a.quota,b.name,b.is_border,substring(b.code,1,1) as code, b.foreigner_percentage 
        FROM ppdb_option a 
        inner join ppdb_school b on (a.school = b.id) 
        where (substring(b.code,1,1)=3 ) and a.type='academic' and a.id in ('655','661','667') ORDER BY b.code, a.id";

        $results_school = $this->conn->query($query_sch) or die(mysqli_error($this->conn));
        $i=0;
        while ($row = mysqli_fetch_array($results_school)) {
            $temp_total_pendaftar = 0;
            $temp_total_luar_kota = 0;
            
            $query = "SELECT * FROM ppdb_registration_academic
                          where (type='academic')  and first_choice = '" . $row['id'] . " '
                          and `status`='approved'
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
                $siswa_dw[$x]['accepted_school'] = $r['first_choice'];

                $siswa_dw[$x]['total']         = $r['score_total1'];
                $siswa_dw[$x]['total1']        = $r['score_total1'];
                $siswa_dw[$x]['total2']        = $r['score_total2'];

                $siswa_dw[$x]['accepted_status']       = '1';
                $siswa_dw[$x]['filtered_is_foreigner'] = '0';
                $siswa_dw[$x]['status']                = $siswa_dw[$x]['accepted_status'];
                $siswa_dw[$x]['history'] = array("Volvo","BMW","Toyota");
                $x++;
            }
            $temp_total_pendaftar = $temp_total_pendaftar + $x;
            @mysqli_free_result($result_reg_dw);
            $this->listsekolah[$i]['id']                   = $row['id'];
            $this->listsekolah[$i]['name']                 = $row['name'];
            $this->listsekolah[$i]['quota']                = $row['quota'];
            $this->listsekolah[$i]['filtered']                = 0;
            $this->listsekolah[$i]['foreigner_percentage'] = $row['foreigner_percentage'];
            $this->listsekolah[$i]['low_passing_grage']    = 0;

            if (isset($siswa_dw)) {
                $this->listsekolah[$i]['data'] = $siswa_dw;
            } else {
                $this->listsekolah[$i]['data'] = array();
            }
            $this->listsekolah[$i]['status'] = 0;
            unset($siswa_dw);
            $i++;
        } //end while
        
        $this->listsekolah[$i]['id']                   = '9999';
        $this->listsekolah[$i]['name']                 = 'Sekolah Buangan';
        $this->listsekolah[$i]['quota']                = 0;
        $this->listsekolah[$i]['filtered']         = 1;
        $this->listsekolah[$i]['foreigner_percentage'] = 0;
        $this->listsekolah[$i]['data'] = array();

        $this->listsekolah[$i]['old_quota']          = 0;
        $this->listsekolah[$i]['quota_luarkota']     = 0;
        $this->listsekolah[$i]['old_quota_luarkota'] = 0;
        $this->listsekolah[$i]['remaining_quota'] = 0;

        $this->listsekolah[$i]['dalam']['id']              = '9999';
        $this->listsekolah[$i]['dalam']['name']            = 'Buangan';
        $this->listsekolah[$i]['dalam']['quota']           = 0;
        $this->listsekolah[$i]['dalam']['filtered']         = 1;
        $this->listsekolah[$i]['dalam']['data']            = array();
        $this->listsekolah[$i]['dalam']['status']          = 1;
        $this->listsekolah[$i]['dalam']['remaining_quota'] = 0;

        $this->listsekolah[$i]['gabungan']['id']              = '9999';
        $this->listsekolah[$i]['gabungan']['name']            = 'Buangan';
        $this->listsekolah[$i]['gabungan']['quota']           = 0;
        $this->listsekolah[$i]['gabungan']['filtered']         = 1;
        $this->listsekolah[$i]['gabungan']['data']            = array();
        $this->listsekolah[$i]['gabungan']['status']          = 1;
        $this->listsekolah[$i]['gabungan']['remaining_quota'] = 0;

        $this->listsekolah[$i]['bandungraya']['id']              = '9999';
        $this->listsekolah[$i]['bandungraya']['name']            = 'Buangan';
        $this->listsekolah[$i]['bandungraya']['quota']           = 0;
        $this->listsekolah[$i]['bandungraya']['filtered']         = 1;
        $this->listsekolah[$i]['bandungraya']['data']            = array();
        $this->listsekolah[$i]['bandungraya']['status']          = 1;
        $this->listsekolah[$i]['bandungraya']['remaining_quota'] = 0;

        $this->listsekolah[$i]['luar']['id']              = '9999';
        $this->listsekolah[$i]['luar']['name']            = 'Buangan';
        $this->listsekolah[$i]['luar']['quota']           = 0;
        $this->listsekolah[$i]['luar']['filtered']         = 1;
        $this->listsekolah[$i]['luar']['data']            = array();
        $this->listsekolah[$i]['luar']['status']          = 1;
        $this->listsekolah[$i]['luar']['remaining_quota'] = 0;

        $this->classConnection->close();

        return $this->listsekolah;
    }


} // end of class Spinach
