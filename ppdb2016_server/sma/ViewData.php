<?php
require 'ProcessSelection.php';
// base class with member properties and methods
class ViewData extends ProcessSelection
{

    public $classConnection;
    public $conn;
    public $processSelection;
    public $listsekolah = [];

    public function __construct()
    {
        $this->classConnection  = new Database;
        $this->conn             = $this->classConnection->connect();
        $this->processSelection = new ProcessSelection;
    }

    public function insertToDb()
    {
        //$this->listsekolah = $this->processSelection->setProcessData();
        $this->listsekolah = $this->processSelection->setProcessData();
        $sql_del           = "DELETE
		from ppdb_filtered_academic
		where `option` in (
			SELECT a.id FROM ppdb_option a
		inner join ppdb_school b on (a.school = b.id)
		where (substring(b.code,1,1)=3 ) and (a.type='academic'))
		";
        $result = $this->conn->query($sql_del) or die(mysqli_error($this->conn));

        $parts    = [];
        /*$qpilihan = "SELECT a.id, a.quota,b.name FROM ppdb_option a
        inner join ppdb_school b on (a.school = b.id)
        where (substring(b.code,1,1)=2 or substring(b.code,1,1)=3) and (a.type='academic')
        and a.id in ('325','331','337','355')
        ";*/
        $qpilihan = "SELECT a.id, a.quota,b.name FROM ppdb_option a
		inner join ppdb_school b on (a.school = b.id)
		where (substring(b.code,1,1)=3) and (a.type='academic')
		";
        $rpilihan  = $this->conn->query($qpilihan) or die(mysqli_error($this->conn));
        $j         = 1;
        $qfiltered = '';
        while ($row = mysqli_fetch_array($rpilihan)) {
            $passinggrade                  = 0.00;
            $passinggrade_dalam_wilayah    = 0.00;
            $passinggrade_gabungan_wilayah = 0.00;
            $passinggrade_luar             = 0.00;
            $passinggrade_luar_kota        = 0.00;
            $passinggrade_bandungraya        = 0.00;
            $filtered_total = 0;
            $siswa_luar_wilayah            = 0;
            $i                             = 0;
            $j                             = 0;
            $y                             = 0;

            foreach ($this->listsekolah[$row['id']]['dalam']['data'] as $r) {
                //    echo $r['id'] . '-' . $r['accepted_school'];
                $parts[]                    = "('" . $r['id'] . "', '" . $r['accepted_school'] . "', '0')";
                $passinggrade_dalam_wilayah = $r['total'];
            }

            foreach ($this->listsekolah[$row['id']]['gabungan']['data'] as $r) {
                $parts[] .= "('" . $r['id'] . "', '" . $r['accepted_school'] . "', '1')";
                $passinggrade_gabungan_wilayah = $r['total'];
            }
            $y = 0;
            foreach ($this->listsekolah[$row['id']]['bandungraya']['data'] as $r) {
                $parts[] .= "('" . $r['id'] . "', '" . $r['accepted_school'] . "', '2')";
                $passinggrade_bandungraya = $r['total'];
                $y++;
            }
            foreach ($this->listsekolah[$row['id']]['luar']['data'] as $r) {
                $parts[] .= "('" . $r['id'] . "', '" . $r['accepted_school'] . "', '3')";
                $passinggrade_luar_kota = $r['total'];
                $y++;
            }

            if ($passinggrade_gabungan_wilayah < $passinggrade_dalam_wilayah) {
                $passinggrade = $passinggrade_gabungan_wilayah;
            } else {
                $passinggrade = $passinggrade_dalam_wilayah;
            }

            if ($passinggrade_bandungraya < $passinggrade_luar_kota) {
                $passinggrade_luar = $passinggrade_bandungraya;
            } else {
                $passinggrade_luar = $passinggrade_luar_kota;
            }

            $filtered_total = count($this->listsekolah[$row['id']]['dalam']['data']) + count($this->listsekolah[$row['id']]['gabungan']['data']) + count($this->listsekolah[$row['id']]['bandungraya']['data']) + count($this->listsekolah[$row['id']]['luar']['data']);
            


            $update_passing="
            	UPDATE `ppdb_statistic` SET `filtered_total` = '" .$filtered_total. "', 
            	`filtered_foreigner` = '". $y ."', 
            	`passing_grade` = '" . $passinggrade_dalam_wilayah . "', 
            	`passing_grade_gabungan` = '" . $passinggrade_gabungan_wilayah . "', 
            	`passing_grade_foreigner` = '" . $passinggrade_luar . "' 
            	WHERE `ppdb_statistic`.`option` = '" . $row['id'] . "'";
        	
            $result_update_tot_pendaftar = $this->conn->query($update_passing);
            
            @mysqli_free_result($result_update_tot_pendaftar);

        }

        mysqli_free_result($rpilihan);
        if ($parts != "") {
            $qfiltered = "INSERT INTO ppdb_filtered_academic (`registration`, `option`, `is_foreigner`) VALUES " . implode(', ', $parts);
            $result    = $this->conn->query($qfiltered) or die(mysqli_error($this->conn));
        }
        unset($parts);
        return $this->listsekolah;
        $this->classConnection->close();
    }

    public function showData()
    {
        echo '<html>';
        echo '<head>';
        echo '</head>';

        echo '<body>';
        $this->listsekolah = [];
        $this->listsekolah=$this->insertToDb();

        //$this->listsekolah = $this->processSelection->setProcessData();
        foreach ($this->listsekolah as $sekolah) {
            echo 'id-' . $sekolah['id'] . '-' . $sekolah['name'];
            echo '<table border="1">'
                . '<thead>'
                . '<tr bgcolor="#00ff00">'
                . '<td>No</td>'
                . '<td>Nama</td>'
                . '<td>Pilihan 1</td>'
                . '<td>Pilihan 2</td>'
                . '<td>Nilai1</td>'
                . '<td>Nilai2</td>'
                . '<td>Bahasa</td>'
                . '<td>English</td>'
                . '<td>Math</td>'
                . '<td>Physics</td>'
                . '<td>Range1</td>'
                . '<td>Range2</td>'
                . '<td>Asal Pendaftar</td>'
                . '<td>IsIntensif1</td>'
                . '<td>IsIntensif2</td>'
                . '<td>Terima Di Wilayah (Is Foreigner)</td>'
                . '<td>Diterima Sekolah</td>'
                . '<td>Status Diterima</td>'
                . '</tr>'
                . '</thead>';
            echo '<tbody>';

            echo '<tr><td colspan="5">Bandung Raya</td><td>Quota 10% :' . $sekolah['old_quota'] . '</td></tr>';
            $i = 0;
            foreach ($sekolah['bandungraya']['data'] as $siswa) {
                $i++;
                echo '<tr>'
                    . '<td>' . $i . '</td>'
                    . '<td>' . $siswa['name'] . '</td>'
                    . '<td>' . $siswa['first_choice'] . '</td>'
                    . '<td>' . $siswa['second_choice'] . '</td>'
                    . '<td>' . $siswa['total1'] . '</td>'
                    . '<td>' . $siswa['total2'] . '</td>'
                    . '<td>' . $siswa['score_bahasa'] . '</td>'
                    . '<td>' . $siswa['score_english'] . '</td>'
                    . '<td>' . $siswa['score_math'] . '</td>'
                    . '<td>' . $siswa['score_physics'] . '</td>'
                    . '<td>' . $siswa['score_range1'] . '</td>'
                    . '<td>' . $siswa['score_range2'] . '</td>'
                    . '<td>' . $siswa['is_foreigner'] . '</td>'
                    . '<td>' . $siswa['is_insentif1'] . '</td>'
                    . '<td>' . $siswa['is_insentif2'] . '</td>'
                    . '<td>' . $siswa['filtered_is_foreigner'] . '</td>'
                    . '<td>' . $siswa['accepted_school'] . '</td>'
                    . '<td>' . $siswa['accepted_status'] . '</td>'
                    . '</tr>';
            }
            echo '<tr><td colspan="5">Luar Bandung Raya</td><td>Quota 10% :' . $sekolah['old_quota'] . '</td></tr>';
            $i = 0;
            foreach ($sekolah['luar']['data'] as $siswa) {
                $i++;
                echo '<tr>'
                    . '<td>' . $i . '</td>'
                    . '<td>' . $siswa['name'] . '</td>'
                    . '<td>' . $siswa['first_choice'] . '</td>'
                    . '<td>' . $siswa['second_choice'] . '</td>'
                    . '<td>' . $siswa['total1'] . '</td>'
                    . '<td>' . $siswa['total2'] . '</td>'
                    . '<td>' . $siswa['score_bahasa'] . '</td>'
                    . '<td>' . $siswa['score_english'] . '</td>'
                    . '<td>' . $siswa['score_math'] . '</td>'
                    . '<td>' . $siswa['score_physics'] . '</td>'
                    . '<td>' . $siswa['score_range1'] . '</td>'
                    . '<td>' . $siswa['score_range2'] . '</td>'
                    . '<td>' . $siswa['is_foreigner'] . '</td>'
                    . '<td>' . $siswa['is_insentif1'] . '</td>'
                    . '<td>' . $siswa['is_insentif2'] . '</td>'
                    . '<td>' . $siswa['filtered_is_foreigner'] . '</td>'
                    . '<td>' . $siswa['accepted_school'] . '</td>'
                    . '<td>' . $siswa['accepted_status'] . '</td>'
                    . '</tr>';
            }


            echo '<tr><td colspan="5">Dalam Wilayah</td><td>Quota : ' . $sekolah['dalam']['old_quota_dw'] . ' + ' . $sekolah['luar']['remaining_quota'] . '</td></tr>';
            $j = 0;
            foreach ($sekolah['dalam']['data'] as $siswa) {
                $j++;
                echo '<tr>'
                    . '<td>' . $j . '</td>'
                    . '<td>' . $siswa['name'] . '</td>'
                    . '<td>' . $siswa['first_choice'] . '</td>'
                    . '<td>' . $siswa['second_choice'] . '</td>'
                    . '<td>' . $siswa['total1'] . '</td>'
                    . '<td>' . $siswa['total2'] . '</td>'
                    . '<td>' . $siswa['score_bahasa'] . '</td>'
                    . '<td>' . $siswa['score_english'] . '</td>'
                    . '<td>' . $siswa['score_math'] . '</td>'
                    . '<td>' . $siswa['score_physics'] . '</td>'
                    . '<td>' . $siswa['score_range1'] . '</td>'
                    . '<td>' . $siswa['score_range2'] . '</td>'
                    . '<td>' . $siswa['is_foreigner'] . '</td>'
                    . '<td>' . $siswa['is_insentif1'] . '</td>'
                    . '<td>' . $siswa['is_insentif2'] . '</td>'
                    . '<td>' . $siswa['filtered_is_foreigner'] . '</td>'
                    . '<td>' . $siswa['accepted_school'] . '</td>'
                    . '<td>' . $siswa['accepted_status'] . '</td>'
                    . '</tr>';
            }

            echo '<tr><td colspan="5">Gabungan Wilayah</td><td>Quota : ' . $sekolah['gabungan']['old_quota_gw'] . '</td></tr>';
            $k = 0;
            foreach ($sekolah['gabungan']['data'] as $siswa) {
                $k++;
                echo '<tr>'
                    . '<td>' . $k . '</td>'
                    . '<td>' . $siswa['name'] . '</td>'
                    . '<td>' . $siswa['first_choice'] . '</td>'
                    . '<td>' . $siswa['second_choice'] . '</td>'
                    . '<td>' . $siswa['total1'] . '</td>'
                    . '<td>' . $siswa['total2'] . '</td>'
                    . '<td>' . $siswa['score_bahasa'] . '</td>'
                    . '<td>' . $siswa['score_english'] . '</td>'
                    . '<td>' . $siswa['score_math'] . '</td>'
                    . '<td>' . $siswa['score_physics'] . '</td>'
                    . '<td>' . $siswa['score_range1'] . '</td>'
                    . '<td>' . $siswa['score_range2'] . '</td>'
                    . '<td>' . $siswa['is_foreigner'] . '</td>'
                    . '<td>' . $siswa['is_insentif1'] . '</td>'
                    . '<td>' . $siswa['is_insentif2'] . '</td>'
                    . '<td>' . $siswa['filtered_is_foreigner'] . '</td>'
                    . '<td>' . $siswa['accepted_school'] . '</td>'
                    . '<td>' . $siswa['accepted_status'] . '</td>'
                    . '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            echo '<br/><br/>';
        }
        echo '</body>';
        echo '</html>';

        //return $this->listsekolah;
    }

} // end of class

