<?php
require 'InitializationData.php';
// base class with member properties and methods
class ProcessSelection extends InitializationData
{

    public $initializationData;
    //var $listsekolah = [];

    public function __construct()
    {
        $this->initializationData = new InitializationData;
    }

    public function sorting(&$arr, $col_total, $col_total2, $col_n1, $col_n2, $col_n3, $col_n4, $col_skorjarak)
    {
        $sort_col_total     = array();
        $sort_col_total2    = array();
        $sort_col_n1        = array();
        $sort_col_n2        = array();
        $sort_col_n3        = array();
        $sort_col_n4        = array();
        $sort_col_skorjarak = array();

        foreach ($arr as $key => $row) {
            $sort_col_total[$key]     = $row[$col_total];
            $sort_col_total2[$key]    = $row[$col_total2];
            $sort_col_n1[$key]        = $row[$col_n1];
            $sort_col_n2[$key]        = $row[$col_n2];
            $sort_col_n3[$key]        = $row[$col_n3];
            $sort_col_n4[$key]        = $row[$col_n4];
            $sort_col_skorjarak[$key] = $row[$col_skorjarak];
        }
        array_multisort($sort_col_total, SORT_DESC, $sort_col_total2, SORT_DESC, $sort_col_n1, SORT_DESC, $sort_col_n2, SORT_DESC, $sort_col_n3, SORT_DESC, $sort_col_n4, SORT_DESC, $sort_col_skorjarak, SORT_DESC, $arr);
    }

    public function simple_sorting(&$arr, $col_total)
    {
        $sort_col_total = array();
        foreach ($arr as $key => $row) {
            $sort_col_total[$key] = $row[$col_total];
        }
        array_multisort($sort_col_total, SORT_DESC, $arr);
    }

    public function processDataLuarKota($listsekolah)
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
                    $this->sorting($listsekolah[$id]['luar']['data'], 'total','total2','score_bahasa','score_english','score_math','score_physics','score_range1');

                    $quota_luar_kota = ($listsekolah[$id]['luar']['quota'] * 0.1);
                    $jml_pend        = count($listsekolah[$id]['luar']['data']);

                    if ($jml_pend > $quota_luar_kota) {
                        /* potong berdasarkan quota */

                        // # lemparkan
                        for ($i = $jml_pend - 1; $i > $quota_luar_kota - 1; $i--) {

                            if ($listsekolah[$id]['luar']['data'][$i]['second_choice'] != $sekolah['id']) {
                                /* lempar ke pilihan 2 */

                                if ($listsekolah[$id]['luar']['data'][$i]['is_insentif2'] == '1') {
                                    if ($listsekolah[$id]['luar']['data'][$i]['second_choice'] != '9999') {
                                        //lempar ke pilihan 2
                                        $listsekolah[$id]['luar']['data'][$i]['accepted_status'] = 2;
                                        $listsekolah[$id]['luar']['data'][$i]['accepted_school'] = $listsekolah[$id]['luar']['data'][$i]['second_choice'];

                                        $listsekolah[$listsekolah[$id]['luar']['data'][$i]['second_choice']]['luar']['status'] = 0;
                                        array_push($listsekolah[$listsekolah[$id]['luar']['data'][$i]['second_choice']]['dalam']['data'], $listsekolah[$id]['luar']['data'][$i]);
                                        array_splice($listsekolah[$id]['luar']['data'], $i, 1);

                                    } else {
                                        $listsekolah[$id]['luar']['data'][$i]['accepted_status'] = 3;
                                        $listsekolah[$id]['luar']['data'][$i]['accepted_school'] = 9999;
                                        array_push($listsekolah['9999']['luar']['data'], $listsekolah[$id]['luar']['data'][$i]);
                                        array_splice($listsekolah[$id]['luar']['data'], $i, 1);
                                    }
                                } else {
                                    $listsekolah[$id]['luar']['data'][$i]['accepted_status'] = 3;
                                    $listsekolah[$id]['luar']['data'][$i]['accepted_school'] = 9999;
                                    array_push($listsekolah['9999']['luar']['data'], $listsekolah[$id]['luar']['data'][$i]);
                                    array_splice($listsekolah[$id]['luar']['data'], $i, 1);
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

    public function processDataDwGw($listsekolah)
    {

        #process dalam & gabungan wilayah
        $passgrad = true;
        while ($passgrad != false) {
            // selama masih ada sekolah yg harus di sorting
            $passgrad = false;

            foreach ($listsekolah as $sekolah) {
                // sort tiap sekolah
                if ($sekolah['dalam']['id'] == '9999') {continue;}

                # init
                $id = $sekolah['id'];

                # sort
                $this->sorting($listsekolah[$id]['dalam']['data'], 'total','total2','score_bahasa','score_english','score_math','score_physics','score_range1');
                $this->sorting($listsekolah[$id]['gabungan']['data'], 'total','total2','score_bahasa','score_english','score_math','score_physics','score_range1');

                // print_r($listsekolah[$id]['data']);
                // echo '<br>';
                $jml_pend_dalam = count($listsekolah[$id]['dalam']['data']);
                echo $id . '-' . $jml_pend_dalam . '-' . $listsekolah[$id]['dalam']['quota'] . '<br/>';
                //start dalam wilayah
                if ($jml_pend_dalam > $listsekolah[$id]['dalam']['quota']) {
                    /* potong berdasarkan kuota */
                    // # lemparkan
                    for ($i = $jml_pend_dalam - 1; $i > $listsekolah[$id]['dalam']['quota'] - 1; $i--) {
                        echo 'test_dalam:' . $listsekolah[$id]['dalam']['data'][$i]['name'] . '-' . $listsekolah[$id]['dalam']['data'][$i]['second_choice'] . '-' . $listsekolah[$id]['dalam']['data'][$i]['is_insentif2'] . ' - Sekolah :' . $sekolah['dalam']['id'] . '<br/>';

                        $listsekolah[$id]['dalam']['data'][$i]['accepted_status'] = 1;
                        $listsekolah[$id]['dalam']['data'][$i]['accepted_school'] = $id;

                        array_push($listsekolah[$id]['gabungan']['data'], $listsekolah[$id]['dalam']['data'][$i]);
                        array_splice($listsekolah[$id]['dalam']['data'], $i, 1);
                    }
                }

                $this->sorting($listsekolah[$id]['dalam']['data'], 'total','total2','score_bahasa','score_english','score_math','score_physics','score_range1');
                $this->sorting($listsekolah[$id]['gabungan']['data'], 'total','total2','score_bahasa','score_english','score_math','score_physics','score_range1');

                $jml_pend_gabungan = count($listsekolah[$id]['gabungan']['data']);
                if ($jml_pend_gabungan > $listsekolah[$id]['gabungan']['quota']) {
                    /* potong berdasarkan kuota */
                    // # lemparkan
                    for ($i = $jml_pend_gabungan - 1; $i > $listsekolah[$id]['gabungan']['quota'] - 1; $i--) {
                        echo 'test_gabungan:' . $listsekolah[$id]['gabungan']['data'][$i]['name'] . '-' . $listsekolah[$id]['gabungan']['data'][$i]['second_choice'] . '-' . $listsekolah[$id]['gabungan']['data'][$i]['is_insentif2'] . ' - Sekolah :' . $sekolah['gabungan']['id'] . '<br/>';

                        if ($listsekolah[$id]['gabungan']['data'][$i]['second_choice'] != $sekolah['gabungan']['id']) {
                            //lempar ke pilihan 2
                            if ($listsekolah[$id]['gabungan']['data'][$i]['is_insentif2'] == '1') {

                                $listsekolah[$id]['gabungan']['data'][$i]['accepted_status'] = 2;
                                $listsekolah[$id]['gabungan']['data'][$i]['accepted_school'] = $listsekolah[$id]['gabungan']['data'][$i]['second_choice'];

                                $listsekolah[$listsekolah[$id]['gabungan']['data'][$i]['second_choice']]['dalam']['status'] = 0;
                                array_push($listsekolah[$listsekolah[$id]['gabungan']['data'][$i]['second_choice']]['dalam']['data'], $listsekolah[$id]['gabungan']['data'][$i]);

                            } else {

                                $listsekolah[$id]['gabungan']['data'][$i]['accepted_status'] = 2;
                                $listsekolah[$id]['gabungan']['data'][$i]['accepted_school'] = $listsekolah[$id]['gabungan']['data'][$i]['second_choice'];

                                $listsekolah[$listsekolah[$id]['gabungan']['data'][$i]['second_choice']]['gabungan']['status'] = 0;
                                array_push($listsekolah[$listsekolah[$id]['gabungan']['data'][$i]['second_choice']]['gabungan']['data'], $listsekolah[$id]['gabungan']['data'][$i]);
                            }
                            array_splice($listsekolah[$id]['gabungan']['data'], $i, 1);
                        } else {
                            $listsekolah[$id]['gabungan']['data'][$i]['accepted_status'] = 3;
                            $listsekolah[$id]['gabungan']['data'][$i]['accepted_school'] = 9999;

                            array_push($listsekolah['9999']['gabungan']['data'], $listsekolah[$id]['gabungan']['data'][$i]);
                            array_splice($listsekolah[$id]['gabungan']['data'], $i, 1);
                        }
                    }
                }

                $listsekolah[$id]['dalam']['status']    = 1;
                $listsekolah[$id]['gabungan']['status'] = 1;

            } //end of foreach

            # cek sekolah, bisi aya nu can di sorting
            foreach ($listsekolah as $sekolah) {
                if ($sekolah['dalam']['status'] == 0) {
                    $passgrad = true;
                    break;
                }
            }

            foreach ($listsekolah as $sekolah) {
                if ($sekolah['gabungan']['status'] == 0) {
                    $passgrad = true;
                    break;
                }
            }

        } //end of while

        return $listsekolah;

    } //endfunction processDataGW

    public function processDataGetLowValue($listsekolah)
    {

        //get pg terendah antara dalam & gabungan, kemudian check siswa luar kota,seleksi jika ada yg nilainya kurang dari pg
        foreach ($listsekolah as $sekolah) {
            $id                = $sekolah['id'];
            $low_passing_grage = 0;
            $passing_grage_dw  = 0;
            $passing_grage_gw  = 0;
            foreach ($sekolah['dalam']['data'] as $siswa) {
                $passing_grage_dw = $siswa['total'];
            }
            foreach ($sekolah['gabungan']['data'] as $siswa) {
                $passing_grage_gw = $siswa['total'];
            }
            if ($passing_grage_dw <= $passing_grage_gw) {
                $low_passing_grage = $passing_grage_dw;
            } else {
                $low_passing_grage = $passing_grage_gw;
            }

            $listsekolah[$id]['dalam']['passing_grade']    = $passing_grage_dw;
            $listsekolah[$id]['gabungan']['passing_grade'] = $passing_grage_gw;

            echo 'Sekolah ID:' . $id . ' Dalam-' . $passing_grage_dw;
            echo '---- Gabungan-' . $passing_grage_gw;
            echo '---- Lowest-' . $low_passing_grage;
            echo '<br/>';
            echo '<br/>';

            $jml_pend = count($listsekolah[$id]['luar']['data']);
            for ($i = $jml_pend - 1; $i >= 0; $i--) {
                echo 'first luar kota : ' . $listsekolah[$id]['luar']['data'][$i]['name'] . '-' . $listsekolah[$id]['luar']['data'][$i]['total'] . '<br/>';
                if ($listsekolah[$id]['luar']['data'][$i]['total'] < $low_passing_grage) {
                    echo 'inner luar kota : ' . $listsekolah[$id]['luar']['data'][$i]['name'] . '-' . $listsekolah[$id]['luar']['data'][$i]['second_choice'] . '<br/>';
                    if ($listsekolah[$id]['luar']['data'][$i]['is_insentif2'] == '1') {
                        if ($listsekolah[$id]['luar']['data'][$i]['second_choice'] != '9999') {
                            //lempar ke pilihan 2

                            //$listsekolah[$id]['luar']['data'][$i]['filtered_is_foreigner'] = 0;
                            $listsekolah[$id]['luar']['data'][$i]['accepted_status'] = 2;
                            $listsekolah[$id]['luar']['data'][$i]['accepted_school'] = $listsekolah[$id]['luar']['data'][$i]['second_choice'];

                            $listsekolah[$listsekolah[$id]['luar']['data'][$i]['second_choice']]['dalam']['status'] = 0;
                            array_push($listsekolah[$listsekolah[$id]['luar']['data'][$i]['second_choice']]['dalam']['data'], $listsekolah[$id]['luar']['data'][$i]);
                            array_splice($listsekolah[$id]['luar']['data'], $i, 1);
                        } else {

                            $listsekolah[$id]['luar']['data'][$i]['accepted_status'] = 3;
                            $listsekolah[$id]['luar']['data'][$i]['accepted_school'] = 9999;

                            array_push($listsekolah['9999']['luar']['data'], $listsekolah[$id]['luar']['data'][$i]);
                            array_splice($listsekolah[$id]['luar']['data'], $i, 1);
                        }
                    } else {
                        $listsekolah[$id]['luar']['data'][$i]['accepted_status'] = 3;
                        $listsekolah[$id]['luar']['data'][$i]['accepted_school'] = 9999;

                        array_push($listsekolah['9999']['luar']['data'], $listsekolah[$id]['luar']['data'][$i]);
                        array_splice($listsekolah[$id]['luar']['data'], $i, 1);
                    }

                } //end if
            } //end for

        }
        return $listsekolah;

    } //end of function processDataGetValue

    public function setProcessData()
    {
        $listsekolah = [];
        $listsekolah = $this->initializationData->getSchool();
        $listsekolah = $this->processDataLuarKota($listsekolah);
        $listsekolah = $this->processDataDwGw($listsekolah);
        $listsekolah = $this->processDataGetLowValue($listsekolah);
        $listsekolah = $this->processDataLuarKota($listsekolah);

        return $listsekolah;
    }

} // end of class Vegetable

/*
$processSelection = new ProcessSelection;
print_r($processSelection->processData()); */
