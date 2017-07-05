<?php
require 'InitializationData.php';
// base class with member properties and methods
class ProcessSelection extends InitializationData
{

    public $initializationData;
    private $arrResultFunc=[];
    public $classConnection;
    public $conn;
    //var $listsekolah = [];

    public function __construct()
    {
        $this->initializationData = new InitializationData;
        $this->classConnection  = new Database;
        $this->conn             = $this->classConnection->connect();
    }

    public function sorting(&$arr, $col_total, $col_total2, $col_n1, $col_n2, $col_n3, $col_n4, $col_skorjarak, $col_range)
    {
        $sort_col_total     = array();
        $sort_col_total2    = array();
        $sort_col_n1        = array();
        $sort_col_n2        = array();
        $sort_col_n3        = array();
        $sort_col_n4        = array();
        $sort_col_skorjarak = array();
        $sort_col_range = array();

        foreach ($arr as $key => $row) {
            $sort_col_total[$key]     = $row[$col_total];
            $sort_col_total2[$key]    = $row[$col_total2];
            $sort_col_n1[$key]        = $row[$col_n1];
            $sort_col_n2[$key]        = $row[$col_n2];
            $sort_col_n3[$key]        = $row[$col_n3];
            $sort_col_n4[$key]        = $row[$col_n4];
            $sort_col_skorjarak[$key] = $row[$col_skorjarak];
            $sort_col_range[$key] = $row[$col_range];
        }
        array_multisort($sort_col_total, SORT_DESC, $sort_col_total2, SORT_DESC, $sort_col_n1, SORT_DESC, $sort_col_n2, SORT_DESC, $sort_col_n3, SORT_DESC, $sort_col_n4, SORT_DESC, $sort_col_skorjarak, SORT_DESC, $sort_col_range, SORT_ASC,$arr);
    }

    public function simple_sorting(&$arr, $col_total)
    {
        $sort_col_total = array();
        foreach ($arr as $key => $row) {
            $sort_col_total[$key] = $row[$col_total];
        }
        array_multisort($sort_col_total, SORT_DESC, $arr);
    }

    public function processDataBandungRaya($listsekolah, $first)
    {
        #------- Proses Bandung Raya

        $passgrad = true;
        while ($passgrad != false) {
            // selama masih ada sekolah yg harus di sorting
            $passgrad = false;

            foreach ($listsekolah as $sekolah) {
                // sort tiap sekolah
                if ($sekolah['bandungraya']['id'] == '9999') {continue;}
                
                    # init
                    $id = $sekolah['id'];

                    # sort
                    $this->sorting($listsekolah[$id]['bandungraya']['data'], 'total', 'total2', 'score_bahasa', 'score_english', 'score_math', 'score_physics', 'score_range', 'range');


                    
                    if ($first==0){
                        $quota_luar_kota = floor(($listsekolah[$id]['old_quota'] * 0.1));
                        $listsekolah[$id]['old_quota_luarkota'] = $quota_luar_kota;
                        $listsekolah[$id]['quota_luarkota'] = $quota_luar_kota;
                        
                        //    echo 'arr_quota_oldluarkota_first_0-' . $id . ':' . $listsekolah[$id]['old_quota_luarkota'] . '<br/>';
                        //    echo 'arr_quota_luarkota_first_0-' . $id . ':' . $listsekolah[$id]['quota_luarkota'] . '<br/>';
                        
                    }else{
                        
                        //echo 'arr_quota_luarkota_first_1-'  . $id  . ':' . $listsekolah[$id]['quota_luarkota'] . '<br/>';
                        
                        $quota_luar_kota = $listsekolah[$id]['quota_luarkota'];
                    }

                    $jml_pend        = count($listsekolah[$id]['bandungraya']['data']);

                    if ($jml_pend > $quota_luar_kota) {
                        /* potong berdasarkan quota */

                        // # lemparkan
                        for ($i = $jml_pend - 1; $i > $quota_luar_kota - 1; $i--) {

                            if ($listsekolah[$id]['bandungraya']['data'][$i]['second_choice'] != $sekolah['id']) {
                                /* lempar ke pilihan 2 */
                                if ($listsekolah[$id]['bandungraya']['data'][$i]['second_choice'] == '9999') {
                                    $listsekolah[$id]['bandungraya']['data'][$i]['accepted_status'] = 3;
                                    $listsekolah[$id]['bandungraya']['data'][$i]['accepted_school'] = 9999;
                                    array_push($listsekolah['9999']['bandungraya']['data'], $listsekolah[$id]['bandungraya']['data'][$i]);
                                    array_splice($listsekolah[$id]['bandungraya']['data'], $i, 1);
                                } else {
                                    $xid = $listsekolah[$id]['bandungraya']['data'][$i]['second_choice'];  //cek id sekolah
                                    if (!isset( $listsekolah[$xid])){
                                        $listsekolah[$id]['bandungraya']['data'][$i]['accepted_status'] = 3;
                                        $listsekolah[$id]['bandungraya']['data'][$i]['accepted_school'] = 9999;
                                        array_push($listsekolah['9999']['bandungraya']['data'], $listsekolah[$id]['bandungraya']['data'][$i]);
                                        array_splice($listsekolah[$id]['bandungraya']['data'], $i, 1);
                                    }else{
                                        //lempar ke pilihan 2
                                        $listsekolah[$id]['bandungraya']['data'][$i]['accepted_status'] = 2;
                                        $listsekolah[$id]['bandungraya']['data'][$i]['accepted_school'] = $listsekolah[$id]['bandungraya']['data'][$i]['second_choice'];

                                        $listsekolah[$listsekolah[$id]['bandungraya']['data'][$i]['second_choice']]['bandungraya']['status'] = 0;

                                        array_push($listsekolah[$listsekolah[$id]['bandungraya']['data'][$i]['second_choice']]['bandungraya']['data'], $listsekolah[$id]['bandungraya']['data'][$i]);
                                        array_splice($listsekolah[$id]['bandungraya']['data'], $i, 1);
                                    }
                                    
                                }
                            } else {
                                // tidak diterima dimana2
                                $listsekolah[$id]['bandungraya']['data'][$i]['accepted_status'] = 3;
                                $listsekolah[$id]['bandungraya']['data'][$i]['accepted_school'] = 9999;
                                array_push($listsekolah['9999']['bandungraya']['data'], $listsekolah[$id]['bandungraya']['data'][$i]);
                                array_splice($listsekolah[$id]['bandungraya']['data'], $i, 1);
                            }
                        }
                    }//end check quota luar kota > jml

                    $listsekolah[$id]['bandungraya']['status'] = 1;
                
            }

            # cek sekolah, bisi aya nu can di sorting
            foreach ($listsekolah as $sekolah) {
                if ($sekolah['bandungraya']['status'] == 0) {
                    $passgrad = true;
                    break;
                }
            }
        }

        return $listsekolah;

    } //end of process Datas

    public function processDataLuarKota($listsekolah, $first)
    {
        // $this->listsekolah=$this->initializationData->getSchool();
        #------- Proses luar kota

        $passgrad = true;
        while ($passgrad != false) {
            // selama masih ada sekolah yg harus di sorting
            $passgrad = false;

            foreach ($listsekolah as $sekolah) {
                // sort tiap sekolah
                if ($sekolah['luar']['id'] == '9999') {continue;}
                if ($sekolah['luar']['status'] == 0) {
                    # init
                    $id = $sekolah['id'];

                    # sort
                    $this->sorting($listsekolah[$id]['luar']['data'], 'total', 'total2', 'score_bahasa', 'score_english', 'score_math', 'score_physics', 'score_range', 'range');

                    // if ($first){
                    //     $quota_luar_kota = floor(($listsekolah[$id]['old_quota'] * 0.1));    
                    // }else{
                    //     $quota_luar_kota = floor(($listsekolah[$id]['quota'] * 0.1));
                    // }

                    //  if ($first==0){
                    //     $quota_luar_kota = floor(($listsekolah[$id]['old_quota'] * 0.1));
                    //     $listsekolah[$id]['old_quota_luarkota'] = $quota_luar_kota;
                    //     $listsekolah[$id]['quota_luarkota'] = $quota_luar_kota;
                    // }else{
                    //     $quota_luar_kota = $listsekolah[$id]['quota_luarkota'];
                    // }
                    $quota_luar_kota = $listsekolah[$id]['quota_luarkota'];
                    //echo 'filter_luarkota_quota_luar_kota-' . $id . ':' . $listsekolah[$id]['quota_luarkota'] . '<br/>';
                    
                    $jml_pend        = count($listsekolah[$id]['luar']['data']);
                    $jml_pend_bandungraya        = count($listsekolah[$id]['bandungraya']['data']);
                    //$quota_luar_kota = floor(($listsekolah[$id]['quota'] * 0.1));
                    $sisa_quota_bandungraya = $quota_luar_kota - $jml_pend_bandungraya;
                    //echo $id . '-sisa_quota_bandungraya:' . $sisa_quota_bandungraya . '<br/>';
                    if ($sisa_quota_bandungraya > 0){

                        if ($jml_pend > $sisa_quota_bandungraya) {
                            /* potong berdasarkan quota */

                            // # lemparkan
                            for ($i = $jml_pend - 1; $i > $sisa_quota_bandungraya - 1; $i--) {

                                if ($listsekolah[$id]['luar']['data'][$i]['second_choice'] != $sekolah['id']) {
                                    /* lempar ke pilihan 2 */
                                    if ($listsekolah[$id]['luar']['data'][$i]['second_choice'] == '9999') {
                                        $listsekolah[$id]['luar']['data'][$i]['accepted_status'] = 3;
                                        $listsekolah[$id]['luar']['data'][$i]['accepted_school'] = 9999;
                                        array_push($listsekolah['9999']['luar']['data'], $listsekolah[$id]['luar']['data'][$i]);
                                        array_splice($listsekolah[$id]['luar']['data'], $i, 1);
                                    } else {
                                        $xid = $listsekolah[$id]['luar']['data'][$i]['second_choice'];  //cek id sekolah
                                        if (!isset( $listsekolah[$xid])){
                                            $listsekolah[$id]['luar']['data'][$i]['accepted_status'] = 3;
                                            $listsekolah[$id]['luar']['data'][$i]['accepted_school'] = 9999;
                                            array_push($listsekolah['9999']['luar']['data'], $listsekolah[$id]['luar']['data'][$i]);
                                            array_splice($listsekolah[$id]['luar']['data'], $i, 1);
                                        }else{
                                            //lempar ke pilihan 2
                                            $listsekolah[$id]['luar']['data'][$i]['accepted_status'] = 2;
                                            $listsekolah[$id]['luar']['data'][$i]['accepted_school'] = $listsekolah[$id]['luar']['data'][$i]['second_choice'];

                                            $listsekolah[$listsekolah[$id]['luar']['data'][$i]['second_choice']]['luar']['status'] = 0;
                                            array_push($listsekolah[$listsekolah[$id]['luar']['data'][$i]['second_choice']]['luar']['data'], $listsekolah[$id]['luar']['data'][$i]);
                                            array_splice($listsekolah[$id]['luar']['data'], $i, 1);
                                        }
                                        
                                    }
                                } else {
                                    // tidak diterima dimana2
                                    $listsekolah[$id]['luar']['data'][$i]['accepted_status'] = 3;
                                    $listsekolah[$id]['luar']['data'][$i]['accepted_school'] = 9999;
                                    array_push($listsekolah['9999']['luar']['data'], $listsekolah[$id]['luar']['data'][$i]);
                                    array_splice($listsekolah[$id]['luar']['data'], $i, 1);
                                }
                            }
                        }
                        

                    }else{
                        //echo 'masukan ke 9999 semua<br/>';
                        //echo $jml_pend . '<br/><br/>';
                        for ($i = $jml_pend - 1; $i>=0 ; $i--) {
                           // echo 'nama yg dilempar 9999:'. $listsekolah[$id]['luar']['data'][$i]['name'] . '<br/>';
                            $listsekolah[$id]['luar']['data'][$i]['accepted_status'] = 3;
                            $listsekolah[$id]['luar']['data'][$i]['accepted_school'] = 9999;
                            array_push($listsekolah['9999']['luar']['data'], $listsekolah[$id]['luar']['data'][$i]);
                            array_splice($listsekolah[$id]['luar']['data'], $i, 1);
                        }
                    }
                    $listsekolah[$id]['luar']['status'] = 1;
                    

                    
                }
            }

            # cek sekolah, bisi aya nu can di sorting
            foreach ($listsekolah as $sekolah) {
                if ($sekolah['luar']['status'] == 0) {
                    $passgrad = true;
                    break;
                }
            }
        }

        return $listsekolah;

    } //end of process Datas

    public function processDataDwGw($listsekolah, $first)
    {

        #process inner & combine_area wilayah
        $passgrad = true;
        while ($passgrad != false) {
            // selama masih ada sekolah yg harus di sorting
            $passgrad = false;

            foreach ($listsekolah as $sekolah) {
                // sort tiap sekolah
                if ($sekolah['inner']['id'] == '9999') {continue;}

                # init
                $id = $sekolah['id'];

                # sort
                $this->sorting($listsekolah[$id]['inner']['data'], 'total', 'total2', 'score_bahasa', 'score_english', 'score_math', 'score_physics', 'score_range','range');
                $this->sorting($listsekolah[$id]['combine_area']['data'], 'total', 'total2', 'score_bahasa', 'score_english', 'score_math', 'score_physics', 'score_range', 'range');

                // print_r($listsekolah[$id]['data']);
                // echo '<br>';
                
                $jml_pend_luar = count($listsekolah[$id]['luar']['data']);
                $jml_pend_inner = count($listsekolah[$id]['inner']['data']);
                
         
                
                
                if ($first==0){
                    $quota_inner = (int)$listsekolah[$id]['inner']['old_quota_dw'];    
                    //echo 'arr_quota_innerwilayah_first_0-' . $id . ':' . $listsekolah[$id]['inner']['old_quota_dw'] . '<br/>';
                }else{
                    $quota_inner = (int)$listsekolah[$id]['inner']['quota'];    
                    //echo 'arr_quota_innerwilayah_first_1-' . $id . ':' . $listsekolah[$id]['inner']['old_quota_dw'] . '<br/>';
                }
                

                //echo 'Sekolah:' .  $id . '-' . $jml_pend_inner . '-' . $listsekolah[$id]['inner']['quota'] . '-'  . ' QuotaDalam:' . $quota_inner . '<br/>';
                //start inner wilayah
                if ($jml_pend_inner > $quota_inner) {
                    /* potong berdasarkan kuota */
                    // # lemparkan
                    for ($i = $jml_pend_inner - 1; $i > $quota_inner - 1; $i--) {
                        //echo 'test_inner:' . $listsekolah[$id]['inner']['data'][$i]['name'] . '-' . $listsekolah[$id]['inner']['data'][$i]['second_choice'] . '-' . $listsekolah[$id]['inner']['data'][$i]['is_insentif2'] . ' - Sekolah :' . $sekolah['inner']['id'] . '<br/>';

                        $listsekolah[$id]['inner']['data'][$i]['accepted_status'] = 1;
                        $listsekolah[$id]['inner']['data'][$i]['accepted_school'] = $id;

                        array_push($listsekolah[$id]['combine_area']['data'], $listsekolah[$id]['inner']['data'][$i]);
                        array_splice($listsekolah[$id]['inner']['data'], $i, 1);
                    }
                }

                $this->sorting($listsekolah[$id]['inner']['data'], 'total', 'total2', 'score_bahasa', 'score_english', 'score_math', 'score_physics', 'score_range', 'range');
                $this->sorting($listsekolah[$id]['combine_area']['data'], 'total', 'total2', 'score_bahasa', 'score_english', 'score_math', 'score_physics', 'score_range', 'range');

                $jml_pend_combine_area = count($listsekolah[$id]['combine_area']['data']);

                if ($first==0){
                    $quota_combine_area = $listsekolah[$id]['combine_area']['old_quota_gw'];
                    if ($id='817'){
                        echo 'arr_quota_oldquota_gw_first_0-' . $id . ':' . $listsekolah[$id]['combine_area']['old_quota_gw'] . '<br/>';
                    }
                }else{
                    $quota_combine_area = $listsekolah[$id]['combine_area']['quota'];
                    if ($id='817'){
                        echo 'arr_quota_oldquota_gw_first_1-' . $id . ':' . $listsekolah[$id]['combine_area']['quota'] . '<br/>';
                    }
                }

                if ($jml_pend_combine_area > $quota_combine_area) {
                    /* potong berdasarkan kuota */
                    // # lemparkan
                    for ($i = $jml_pend_combine_area - 1; $i > $quota_combine_area - 1; $i--) {
                        if ($id='817'){
                            echo 'test_combine_area:' . $listsekolah[$id]['combine_area']['data'][$i]['name'] . '-' . $listsekolah[$id]['combine_area']['data'][$i]['second_choice'] . '-' . $listsekolah[$id]['combine_area']['data'][$i]['is_insentif2'] . ' - Sekolah :' . $sekolah['combine_area']['id'] . '<br/>';
                        }

                        if ($listsekolah[$id]['combine_area']['data'][$i]['second_choice'] != $sekolah['combine_area']['id']) {
                            //lempar ke pilihan 2
                            if ($listsekolah[$id]['combine_area']['data'][$i]['second_choice'] == '9999') {

                                $listsekolah[$id]['combine_area']['data'][$i]['accepted_status'] = 3;
                                $listsekolah[$id]['combine_area']['data'][$i]['accepted_school'] = '9999';
                                array_push($listsekolah['9999']['combine_area']['data'], $listsekolah[$id]['combine_area']['data'][$i]);
                                array_splice($listsekolah[$id]['combine_area']['data'], $i, 1);
                            } else {

                                $xid = $listsekolah[$id]['combine_area']['data'][$i]['second_choice']; //cek id sekolah
                                if (!isset($listsekolah[$xid])) {
                                    $listsekolah[$id]['combine_area']['data'][$i]['accepted_status'] = 3;
                                    $listsekolah[$id]['combine_area']['data'][$i]['accepted_school'] = '9999';
                                    array_push($listsekolah['9999']['combine_area']['data'], $listsekolah[$id]['combine_area']['data'][$i]);
                                    array_splice($listsekolah[$id]['combine_area']['data'], $i, 1);
                                } else {
                                    if ($listsekolah[$id]['combine_area']['data'][$i]['is_insentif2'] == '1') {
                                        $listsekolah[$id]['combine_area']['data'][$i]['accepted_status'] = 2;
                                        $listsekolah[$id]['combine_area']['data'][$i]['range'] = $listsekolah[$id]['combine_area']['data'][$i]['range2'];
                                        $listsekolah[$id]['combine_area']['data'][$i]['score_range'] = $listsekolah[$id]['combine_area']['data'][$i]['score_range2'];
                                        $listsekolah[$id]['combine_area']['data'][$i]['accepted_school'] = $listsekolah[$id]['combine_area']['data'][$i]['second_choice'];

                                        $listsekolah[$listsekolah[$id]['combine_area']['data'][$i]['second_choice']]['inner']['status'] = 0;
                                        array_push($listsekolah[$listsekolah[$id]['combine_area']['data'][$i]['second_choice']]['inner']['data'], $listsekolah[$id]['combine_area']['data'][$i]);

                                    } else {

                                        $listsekolah[$id]['combine_area']['data'][$i]['accepted_status'] = 2;
                                        $listsekolah[$id]['combine_area']['data'][$i]['accepted_school'] = $listsekolah[$id]['combine_area']['data'][$i]['second_choice'];

                                        $listsekolah[$listsekolah[$id]['combine_area']['data'][$i]['second_choice']]['combine_area']['status'] = 0;
                                        array_push($listsekolah[$listsekolah[$id]['combine_area']['data'][$i]['second_choice']]['combine_area']['data'], $listsekolah[$id]['combine_area']['data'][$i]);
                                    }
                                    array_splice($listsekolah[$id]['combine_area']['data'], $i, 1);
                                }

                            }
                        } else {
                            $listsekolah[$id]['combine_area']['data'][$i]['accepted_status'] = 3;
                            $listsekolah[$id]['combine_area']['data'][$i]['accepted_school'] = 9999;

                            array_push($listsekolah['9999']['combine_area']['data'], $listsekolah[$id]['combine_area']['data'][$i]);
                            array_splice($listsekolah[$id]['combine_area']['data'], $i, 1);
                        }
                    }
                }

                $listsekolah[$id]['inner']['status']    = 1;
                $listsekolah[$id]['combine_area']['status'] = 1;

            } //end of foreach

            # cek sekolah, bisi aya nu can di sorting
            foreach ($listsekolah as $sekolah) {
                if ($sekolah['inner']['status'] == 0) {
                    $passgrad = true;
                    break;
                }
            }

            foreach ($listsekolah as $sekolah) {
                if ($sekolah['combine_area']['status'] == 0) {
                    $passgrad = true;
                    break;
                }
            }

        } //end of while

        return $listsekolah;

    } //endfunction processDataGW

    public function processDataGetLowValueBandungRaya($listsekolah, $first)
    {

        $passgrad = true;
        while ($passgrad != false) {
            $passgrad = false;

                //get pg terendah antara inner & combine_area, kemudian check siswa & bandung raya,seleksi jika ada yg nilainya kurang dari pg
                foreach ($listsekolah as $sekolah) {
                    $id                = $sekolah['id'];

                    if ($sekolah['bandungraya']['id'] == '9999') {continue;}

                    $low_passing_grage = 0;
                    $passing_grage_dw  = 0;
                    $passing_grage_gw  = 0;
                    foreach ($sekolah['inner']['data'] as $siswa) {
                        $passing_grage_dw = $siswa['total'];
                    }
                    foreach ($sekolah['combine_area']['data'] as $siswa) {
                        $passing_grage_gw = $siswa['total'];
                    }
                    /*if ($passing_grage_dw <= $passing_grage_gw) {
                        $low_passing_grage = $passing_grage_dw;
                    } else {
                        $low_passing_grage = $passing_grage_gw;
                    }*/
                    $low_passing_grage = $passing_grage_gw;

                    $listsekolah[$id]['inner']['passing_grade']    = $passing_grage_dw;
                    $listsekolah[$id]['combine_area']['passing_grade'] = $passing_grage_gw;
                    $listsekolah[$id]['low_passing_grage'] = $low_passing_grage;

                    if ($id='817'){
                        echo 'Sekolah ID:' . $id . ' Dalam-' . $passing_grage_dw;
                        echo '---- Gabungan-' . $passing_grage_gw;
                        echo '---- Lowest-' . $low_passing_grage;
                        echo '<br/>';
                        echo '<br/>';
                    }

                    $this->sorting($listsekolah[$id]['bandungraya']['data'], 'total', 'total2', 'score_bahasa', 'score_english', 'score_math', 'score_physics', 'score_range', 'range');

                    $jml_pend = count($listsekolah[$id]['bandungraya']['data']);
                    for ($i = $jml_pend - 1; $i >= 0; $i--) {
                        if ($id='817'){
                            echo 'first bandungraya kota : ' . $listsekolah[$id]['bandungraya']['data'][$i]['name'] . '-' . $listsekolah[$id]['bandungraya']['data'][$i]['total'] . '<br/>';
                        }
                        if ($listsekolah[$id]['bandungraya']['data'][$i]['total'] < $low_passing_grage) {
                            if ($id='817'){
                                echo 'inner bandungraya kota : ' . $listsekolah[$id]['bandungraya']['data'][$i]['name'] . '-' . $listsekolah[$id]['bandungraya']['data'][$i]['second_choice'] . '<br/>';
                            }
                            if ($listsekolah[$id]['bandungraya']['data'][$i]['second_choice'] != $sekolah['id']) {
                                /* lempar ke pilihan 2 */
                                if ($listsekolah[$id]['bandungraya']['data'][$i]['second_choice'] == '9999') {
                                    $listsekolah[$id]['bandungraya']['data'][$i]['accepted_status'] = 3;
                                    $listsekolah[$id]['bandungraya']['data'][$i]['accepted_school'] = 9999;
                                    array_push($listsekolah['9999']['bandungraya']['data'], $listsekolah[$id]['bandungraya']['data'][$i]);
                                    array_splice($listsekolah[$id]['bandungraya']['data'], $i, 1);
                                } else {
                                    $xid = $listsekolah[$id]['bandungraya']['data'][$i]['second_choice'];  //cek id sekolah
                                    if (!isset( $listsekolah[$xid])){
                                        $listsekolah[$id]['bandungraya']['data'][$i]['accepted_status'] = 3;
                                        $listsekolah[$id]['bandungraya']['data'][$i]['accepted_school'] = 9999;
                                        array_push($listsekolah['9999']['bandungraya']['data'], $listsekolah[$id]['bandungraya']['data'][$i]);
                                        array_splice($listsekolah[$id]['bandungraya']['data'], $i, 1);
                                    }else{
                                        //lempar ke pilihan 2
                                        $listsekolah[$id]['bandungraya']['data'][$i]['accepted_status'] = 2;
                                        $listsekolah[$id]['bandungraya']['data'][$i]['range'] = $listsekolah[$id]['bandungraya']['data'][$i]['range2'];
                                        $listsekolah[$id]['bandungraya']['data'][$i]['score_range'] = $listsekolah[$id]['bandungraya']['data'][$i]['score_range2'];

                                        $listsekolah[$id]['bandungraya']['data'][$i]['accepted_school'] = $listsekolah[$id]['bandungraya']['data'][$i]['second_choice'];

                                        $listsekolah[$listsekolah[$id]['bandungraya']['data'][$i]['second_choice']]['bandungraya']['status'] = 0;
                                        array_push($listsekolah[$listsekolah[$id]['bandungraya']['data'][$i]['second_choice']]['bandungraya']['data'], $listsekolah[$id]['bandungraya']['data'][$i]);
                                        array_splice($listsekolah[$id]['bandungraya']['data'], $i, 1);
                                    }
                                    
                                }
                            } else {
                                // tidak diterima dimana2
                                $listsekolah[$id]['bandungraya']['data'][$i]['accepted_status'] = 3;
                                $listsekolah[$id]['bandungraya']['data'][$i]['accepted_school'] = 9999;
                                array_push($listsekolah['9999']['bandungraya']['data'], $listsekolah[$id]['bandungraya']['data'][$i]);
                                array_splice($listsekolah[$id]['bandungraya']['data'], $i, 1);
                            }

                        } //end if
                    } //end for


                    
                
                    # init
                    $id = $sekolah['id'];

                    # sort
                    $this->sorting($listsekolah[$id]['bandungraya']['data'], 'total', 'total2', 'score_bahasa', 'score_english', 'score_math', 'score_physics', 'score_range', 'range');


                    
                    if ($first==0){
                        $quota_luar_kota = floor(($listsekolah[$id]['old_quota'] * 0.1));
                        $listsekolah[$id]['old_quota_luarkota'] = $quota_luar_kota;
                        $listsekolah[$id]['quota_luarkota'] = $quota_luar_kota;
                        
                        //    echo 'arr_quota_oldluarkota_first_0-' . $id . ':' . $listsekolah[$id]['old_quota_luarkota'] . '<br/>';
                        //    echo 'arr_quota_luarkota_first_0-' . $id . ':' . $listsekolah[$id]['quota_luarkota'] . '<br/>';
                        
                    }else{
                        
                        //    echo 'arr_quota_luarkota_first_1-'  . $id  . ':' . $listsekolah[$id]['quota_luarkota'] . '<br/>';
                        
                        $quota_luar_kota = $listsekolah[$id]['quota_luarkota'];
                    }

                    $jml_pend        = count($listsekolah[$id]['bandungraya']['data']);

                    if ($jml_pend > $quota_luar_kota) {
                        /* potong berdasarkan quota */

                        // # lemparkan
                        for ($i = $jml_pend - 1; $i > $quota_luar_kota - 1; $i--) {

                            if ($listsekolah[$id]['bandungraya']['data'][$i]['second_choice'] != $sekolah['id']) {
                                /* lempar ke pilihan 2 */
                                if ($listsekolah[$id]['bandungraya']['data'][$i]['second_choice'] == '9999') {
                                    $listsekolah[$id]['bandungraya']['data'][$i]['accepted_status'] = 3;
                                    $listsekolah[$id]['bandungraya']['data'][$i]['accepted_school'] = 9999;
                                    array_push($listsekolah['9999']['bandungraya']['data'], $listsekolah[$id]['bandungraya']['data'][$i]);
                                    array_splice($listsekolah[$id]['bandungraya']['data'], $i, 1);
                                } else {
                                    $xid = $listsekolah[$id]['bandungraya']['data'][$i]['second_choice'];  //cek id sekolah
                                    if (!isset( $listsekolah[$xid])){
                                        $listsekolah[$id]['bandungraya']['data'][$i]['accepted_status'] = 3;
                                        $listsekolah[$id]['bandungraya']['data'][$i]['accepted_school'] = 9999;
                                        array_push($listsekolah['9999']['bandungraya']['data'], $listsekolah[$id]['bandungraya']['data'][$i]);
                                        array_splice($listsekolah[$id]['bandungraya']['data'], $i, 1);
                                    }else{
                                        //lempar ke pilihan 2
                                        $listsekolah[$id]['bandungraya']['data'][$i]['accepted_status'] = 2;
                                        $listsekolah[$id]['bandungraya']['data'][$i]['accepted_school'] = $listsekolah[$id]['bandungraya']['data'][$i]['second_choice'];

                                        $listsekolah[$listsekolah[$id]['bandungraya']['data'][$i]['second_choice']]['bandungraya']['status'] = 0;

                                        array_push($listsekolah[$listsekolah[$id]['bandungraya']['data'][$i]['second_choice']]['bandungraya']['data'], $listsekolah[$id]['bandungraya']['data'][$i]);
                                        array_splice($listsekolah[$id]['bandungraya']['data'], $i, 1);
                                    }
                                    
                                }
                            } else {
                                // tidak diterima dimana2
                                $listsekolah[$id]['bandungraya']['data'][$i]['accepted_status'] = 3;
                                $listsekolah[$id]['bandungraya']['data'][$i]['accepted_school'] = 9999;
                                array_push($listsekolah['9999']['bandungraya']['data'], $listsekolah[$id]['bandungraya']['data'][$i]);
                                array_splice($listsekolah[$id]['bandungraya']['data'], $i, 1);
                            }
                        }
                    } //potong bandung raya

                    $listsekolah[$id]['bandungraya']['status']    = 1;
                }

                foreach ($listsekolah as $sekolah) {
                    if ($sekolah['bandungraya']['status'] == 0) {
                        $passgrad = true;
                        break;
                    }
                }    
        }    

        return $listsekolah;

    } //end of function processDataGetValue

    public function processDataGetLowValueLuarKota($listsekolah,$first)
    {

        $passgrad = true;
        while ($passgrad != false) {
            $passgrad = false;

            //get pg terendah antara inner & combine_area, kemudian check siswa & luar kota,seleksi jika ada yg nilainya kurang dari pg
            foreach ($listsekolah as $sekolah) {
                $id                = $sekolah['id'];
                if ($sekolah['luar']['id'] == '9999') {continue;}
                $this->sorting($listsekolah[$id]['luar']['data'], 'total', 'total2', 'score_bahasa', 'score_english', 'score_math', 'score_physics', 'score_range', 'range');

                $jml_pend = count($listsekolah[$id]['luar']['data']);
                for ($i = $jml_pend - 1; $i >= 0; $i--) {
                   // echo 'first luar kota : ' . $listsekolah[$id]['luar']['data'][$i]['name'] . '-' . $listsekolah[$id]['luar']['data'][$i]['total'] . '<br/>';
                    if ($listsekolah[$id]['luar']['data'][$i]['total'] < $listsekolah[$id]['low_passing_grage']) {
                      //  echo 'inner luar kota : ' . $listsekolah[$id]['luar']['data'][$i]['name'] . '-' . $listsekolah[$id]['luar']['data'][$i]['second_choice'] . '<br/>';
                        if ($listsekolah[$id]['luar']['data'][$i]['second_choice'] != $sekolah['id']) {
                            /* lempar ke pilihan 2 */
                            if ($listsekolah[$id]['luar']['data'][$i]['second_choice'] == '9999') {
                                $listsekolah[$id]['luar']['data'][$i]['accepted_status'] = 3;
                                $listsekolah[$id]['luar']['data'][$i]['accepted_school'] = 9999;
                                array_push($listsekolah['9999']['luar']['data'], $listsekolah[$id]['luar']['data'][$i]);
                                array_splice($listsekolah[$id]['luar']['data'], $i, 1);
                            } else {
                                $xid = $listsekolah[$id]['luar']['data'][$i]['second_choice'];  //cek id sekolah
                                if (!isset( $listsekolah[$xid])){
                                    $listsekolah[$id]['luar']['data'][$i]['accepted_status'] = 3;
                                    $listsekolah[$id]['luar']['data'][$i]['accepted_school'] = 9999;
                                    array_push($listsekolah['9999']['luar']['data'], $listsekolah[$id]['luar']['data'][$i]);
                                    array_splice($listsekolah[$id]['luar']['data'], $i, 1);
                                }else{
                                    //lempar ke pilihan 2
                                    
                                    //cek quota bandung raya
                                    $jml_pend_bandungraya        = count($listsekolah[$listsekolah[$id]['luar']['data'][$i]['second_choice']]['bandungraya']['data']);
                                    
                                    //$quota_luar_kota = floor(($listsekolah[$id]['quota'] * 0.1));

                                    // if ($first==0){
                                    //     $quota_luar_kota = floor(($listsekolah[$id]['old_quota'] * 0.1));
                                    // }else{
                                    //     $quota_luar_kota = floor(($listsekolah[$id]['quota'] * 0.1));
                                    // }

                                    // if ($first==0){
                                    //     $quota_luar_kota = floor(($listsekolah[$id]['old_quota'] * 0.1));
                                    //     $listsekolah[$id]['old_quota_luarkota'] = $quota_luar_kota;
                                    //     $listsekolah[$id]['quota_luarkota'] = $quota_luar_kota;
                                    // }else{
                                    //     $quota_luar_kota = $listsekolah[$id]['quota_luarkota'];
                                    // }

                                    $quota_luar_kota = $listsekolah[$id]['quota_luarkota'];
                                   // echo 'splice_pg_quota_luar_kota-' . $id . ':' . $listsekolah[$id]['quota_luarkota'] . '<br/>'; 
                                    $sisa_quota_bandungraya = $quota_luar_kota - $jml_pend_bandungraya;

                                    if ($sisa_quota_bandungraya>0){
                                        $listsekolah[$id]['luar']['data'][$i]['accepted_status'] = 2;
                                        $listsekolah[$id]['luar']['data'][$i]['range'] = $listsekolah[$id]['luar']['data'][$i]['range2'];
                                        $listsekolah[$id]['luar']['data'][$i]['score_range'] = $listsekolah[$id]['luar']['data'][$i]['score_range2'];

                                        $listsekolah[$id]['luar']['data'][$i]['accepted_school'] = $listsekolah[$id]['luar']['data'][$i]['second_choice'];    
                                        $listsekolah[$listsekolah[$id]['luar']['data'][$i]['second_choice']]['luar']['status'] = 0;
                                        array_push($listsekolah[$listsekolah[$id]['luar']['data'][$i]['second_choice']]['luar']['data'], $listsekolah[$id]['luar']['data'][$i]);
                                        array_splice($listsekolah[$id]['luar']['data'], $i, 1);

                                    }else{
                                        $listsekolah[$id]['luar']['data'][$i]['accepted_status'] = 3;
                                        $listsekolah[$id]['luar']['data'][$i]['accepted_school'] = 9999;
                                        array_push($listsekolah['9999']['luar']['data'], $listsekolah[$id]['luar']['data'][$i]);
                                        array_splice($listsekolah[$id]['luar']['data'], $i, 1);
                                    }

                                }
                                
                            }
                        } else {
                            // tidak diterima dimana2
                            $listsekolah[$id]['luar']['data'][$i]['accepted_status'] = 3;
                            $listsekolah[$id]['luar']['data'][$i]['accepted_school'] = 9999;
                            array_push($listsekolah['9999']['luar']['data'], $listsekolah[$id]['luar']['data'][$i]);
                            array_splice($listsekolah[$id]['luar']['data'], $i, 1);
                        }

                    } //end if
                } //end for


                //start potong quota
                
                if ($sekolah['luar']['status'] == 0) {
                    # init
                    $id = $sekolah['id'];

                    # sort
                    $this->sorting($listsekolah[$id]['luar']['data'], 'total', 'total2', 'score_bahasa', 'score_english', 'score_math', 'score_physics', 'score_range', 'range');

                    // if ($first){
                    //     $quota_luar_kota = floor(($listsekolah[$id]['old_quota'] * 0.1));    
                    // }else{
                    //     $quota_luar_kota = floor(($listsekolah[$id]['quota'] * 0.1));
                    // }

                    //  if ($first==0){
                    //     $quota_luar_kota = floor(($listsekolah[$id]['old_quota'] * 0.1));
                    //     $listsekolah[$id]['old_quota_luarkota'] = $quota_luar_kota;
                    //     $listsekolah[$id]['quota_luarkota'] = $quota_luar_kota;
                    // }else{
                    //     $quota_luar_kota = $listsekolah[$id]['quota_luarkota'];
                    // }
                    $quota_luar_kota = $listsekolah[$id]['quota_luarkota'];
                    //echo 'filter_luarkota_quota_luar_kota-' . $id . ':' . $listsekolah[$id]['quota_luarkota'] . '<br/>';
                    
                    $jml_pend        = count($listsekolah[$id]['luar']['data']);
                    $jml_pend_bandungraya        = count($listsekolah[$id]['bandungraya']['data']);
                    //$quota_luar_kota = floor(($listsekolah[$id]['quota'] * 0.1));
                    $sisa_quota_bandungraya = $quota_luar_kota - $jml_pend_bandungraya;
                    //echo $id . '-sisa_quota_bandungraya:' . $sisa_quota_bandungraya . '<br/>';
                    if ($sisa_quota_bandungraya > 0){

                        if ($jml_pend > $sisa_quota_bandungraya) {
                            /* potong berdasarkan quota */

                            // # lemparkan
                            for ($i = $jml_pend - 1; $i > $sisa_quota_bandungraya - 1; $i--) {

                                if ($listsekolah[$id]['luar']['data'][$i]['second_choice'] != $sekolah['id']) {
                                    /* lempar ke pilihan 2 */
                                    if ($listsekolah[$id]['luar']['data'][$i]['second_choice'] == '9999') {
                                        $listsekolah[$id]['luar']['data'][$i]['accepted_status'] = 3;
                                        $listsekolah[$id]['luar']['data'][$i]['accepted_school'] = 9999;
                                        array_push($listsekolah['9999']['luar']['data'], $listsekolah[$id]['luar']['data'][$i]);
                                        array_splice($listsekolah[$id]['luar']['data'], $i, 1);
                                    } else {
                                        $xid = $listsekolah[$id]['luar']['data'][$i]['second_choice'];  //cek id sekolah
                                        if (!isset( $listsekolah[$xid])){
                                            $listsekolah[$id]['luar']['data'][$i]['accepted_status'] = 3;
                                            $listsekolah[$id]['luar']['data'][$i]['accepted_school'] = 9999;
                                            array_push($listsekolah['9999']['luar']['data'], $listsekolah[$id]['luar']['data'][$i]);
                                            array_splice($listsekolah[$id]['luar']['data'], $i, 1);
                                        }else{
                                            //lempar ke pilihan 2
                                            $listsekolah[$id]['luar']['data'][$i]['accepted_status'] = 2;
                                            $listsekolah[$id]['luar']['data'][$i]['accepted_school'] = $listsekolah[$id]['luar']['data'][$i]['second_choice'];

                                            $listsekolah[$listsekolah[$id]['luar']['data'][$i]['second_choice']]['luar']['status'] = 0;
                                            array_push($listsekolah[$listsekolah[$id]['luar']['data'][$i]['second_choice']]['luar']['data'], $listsekolah[$id]['luar']['data'][$i]);
                                            array_splice($listsekolah[$id]['luar']['data'], $i, 1);
                                        }
                                        
                                    }
                                } else {
                                    // tidak diterima dimana2
                                    $listsekolah[$id]['luar']['data'][$i]['accepted_status'] = 3;
                                    $listsekolah[$id]['luar']['data'][$i]['accepted_school'] = 9999;
                                    array_push($listsekolah['9999']['luar']['data'], $listsekolah[$id]['luar']['data'][$i]);
                                    array_splice($listsekolah[$id]['luar']['data'], $i, 1);
                                }
                            }
                        }
                        

                    }else{
                        //echo 'masukan ke 9999 semua<br/>';
                        //echo $jml_pend . '<br/><br/>';
                        for ($i = $jml_pend - 1; $i>=0 ; $i--) {
                           // echo 'nama yg dilempar 9999:'. $listsekolah[$id]['luar']['data'][$i]['name'] . '<br/>';
                            $listsekolah[$id]['luar']['data'][$i]['accepted_status'] = 3;
                            $listsekolah[$id]['luar']['data'][$i]['accepted_school'] = 9999;
                            array_push($listsekolah['9999']['luar']['data'], $listsekolah[$id]['luar']['data'][$i]);
                            array_splice($listsekolah[$id]['luar']['data'], $i, 1);
                        }
                    }
                }//end potong quota


                $listsekolah[$id]['luar']['status']    = 1;
            }//end foreach

            foreach ($listsekolah as $sekolah) {
                if ($sekolah['luar']['status'] == 0) {
                    $passgrad = true;
                    break;
                }
            }

        }//end of while

        return $listsekolah;

    } //end of function processDataGetValue

    public function getSisaQuotaDalamWilayah($listsekolah, $id){
            //echo 'idsekolah:' . $id . '-<br/>';
            $siswa_inner_wilayah = count($listsekolah[$id]['inner']['data']);
            $quota_dw = $listsekolah[$id]['inner']['quota'];
            $quota_gw = $listsekolah[$id]['combine_area']['quota'];

            $sisa_quota_inner_wilayah    = $quota_dw - $siswa_inner_wilayah;
           // echo 'calculate sisa quota inner wilayah-'. $id . ':' .  $quota_dw . '-' . $siswa_inner_wilayah  . '=' . $sisa_quota_inner_wilayah . '<br/><br/>';


            $res_quota_dw = $quota_dw - 1;
            $res_quota_gw = $quota_gw + 1;

            if ($id!='9999'){
                if ($sisa_quota_inner_wilayah>0){
                    $update_quota="
                        UPDATE `ppdb_option` SET 
                        `quota_dw` = '". $res_quota_dw ."',
                        `quota_gw` = '". $res_quota_gw ."' 
                        WHERE `ppdb_option`.`id` = '" . $id . "'";
                   // echo 'query:' . $update_quota . '; sisa_quota_innerwilayah:' . $sisa_quota_inner_wilayah . '<br/>';
                    $result_update_quota = $this->conn->query($update_quota);
                    @mysqli_free_result($result_update_quota);
                }
            }

        return $sisa_quota_inner_wilayah;
    }

    public function getSisaQuotaLuarKota($listsekolah, $id){

        //foreach ($listsekolah as $sekolah) {
            //$id                = $sekolah['id'];
            //echo 'idsekolah:' . $id . '-<br/>';
            $quota_luarbandungraya = count($listsekolah[$id]['luar']['data']);
            $quota_innerbandungraya = count($listsekolah[$id]['bandungraya']['data']);
            $old_quota_luarkota = floor(($listsekolah[$id]['old_quota'] * 0.1));

            $quota_luarkota = $listsekolah[$id]['quota_luarkota'];

            $quota = $listsekolah[$id]['quota'];
            if ($id='817'){
                echo 'sisa luar kota quota:' . $quota . '<br/>';
            }
            $quota_dw = $listsekolah[$id]['inner']['quota'];
            $quota_gw = $listsekolah[$id]['combine_area']['quota'];
            $total_quota_luarkota  = $quota_luarbandungraya + $quota_innerbandungraya;
            $sisa_quota_luarkota    = $quota_luarkota - $total_quota_luarkota;
            if ($id='817'){
               echo 'quota total luar kota '. $id . ':' .  $quota_luarkota . '-' . $total_quota_luarkota  . '=' . $sisa_quota_luarkota . '<br/><br/>';
            }

            $res_quota = $quota - 1;
            $res_quota_luarkota = $quota_luarkota - 1;
            $res_quota_gw = $quota_gw + 1;
            if ($id!='9999'){
                if ($sisa_quota_luarkota>0){
                    $update_quota="
                        UPDATE `ppdb_option` SET `quota` = '" . $res_quota . "', 
                        `quota_gw` = '". $res_quota_gw ."',
                        `quota_luarkota` = '". $res_quota_luarkota ."',
                        `old_quota_luarkota` = '". $old_quota_luarkota ."'
                        WHERE `ppdb_option`.`id` = '" . $id . "'";
                        if ($id='817'){
                            echo 'query:' . $update_quota . '; sisa_quota_luarkota:' . $sisa_quota_luarkota . '<br/>';
                        }
                    $result_update_quota = $this->conn->query($update_quota);
                    @mysqli_free_result($result_update_quota);
                }
            }
            
        //}

        return $sisa_quota_luarkota;

        

    }


    public function setProcessData($first)
    {
        $listsekolah = [];
        $sisa_quota_luarkota = 0;
        $listsekolah = $this->initializationData->getSchool($first);
            
        
        $listsekolah = $this->processDataBandungRaya($listsekolah, $first);
        
        $listsekolah = $this->processDataDwGw($listsekolah, $first);
        $listsekolah = $this->processDataGetLowValueBandungRaya($listsekolah, $first);
        $listsekolah = $this->processDataLuarKota($listsekolah, $first);
        $listsekolah = $this->processDataGetLowValueLuarKota($listsekolah, $first);


     //   echo '<br/><br/>';
        //$listsekolah = $this->processDataDwGw($listsekolah);

        return $listsekolah;
    }


    public function reSelection(){


        $listsekolah2 = [];
        $listsekolah = $this->setProcessData(0);
        //$sisa_quota_luarkota = $this->getSisaQuotaLuarKota($listsekolah);
        //echo 'reSelection sisa luar kota :' . $sisa_quota_luarkota . '<br/>';
        
        foreach ($listsekolah as $sekolah) {
            
            $sisa_quota_inner_wilayah = $this->getSisaQuotaDalamWilayah($listsekolah , $sekolah['id']);
            if ($sisa_quota_inner_wilayah > 0){
                while($sisa_quota_inner_wilayah > 0){
                    echo 'reSelectionDW-' . '-' . $sekolah['id'] . ':' . $sisa_quota_inner_wilayah . '<br/>';
                    $listsekolah = $this->setProcessData(1);
                    $sisa_quota_inner_wilayah = $this->getSisaQuotaDalamWilayah($listsekolah , $sekolah['id']);
                }
                
            }

            $sisa_quota_luarkota = $this->getSisaQuotaLuarKota($listsekolah , $sekolah['id']);
             if ($sisa_quota_luarkota > 0){
                while($sisa_quota_luarkota > 0){
                    echo 'reSelectionLK-' . '-' . $sekolah['id'] . ':' . $sisa_quota_luarkota . '<br/>';
                    $listsekolah = $this->setProcessData(1);
                    $sisa_quota_luarkota = $this->getSisaQuotaLuarKota($listsekolah , $sekolah['id']);
                }
                
            }
        } 

       
        

        return $listsekolah;
    }

    public function resultSelection(){
        $listsekolah = [];
        $listsekolah = $this->reSelection();
        return $listsekolah;
    }

} // end of class Vegetable
