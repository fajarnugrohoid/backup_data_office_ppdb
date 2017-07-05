<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function pdf_create($html, $filename, $stream=TRUE) {
    $base = '';
    require_once("dompdf/dompdf_config.inc.php");
    spl_autoload_register('DOMPDF_autoload');

    $dompdf = new DOMPDF();
    //$dompdf->set_paper("a4", "portrait");
    $dompdf->load_html($html);
    $dompdf->render();

    if ($stream) {
        $dompdf->stream($filename . ".pdf");
    } else {
        $ci = & get_instance();
        $ci->load->helper('file');
        if (!is_dir("file")):
            $cd = mkdir("file", 0777, TRUE);
            
        endif;

        write_file('file/' . $filename . '.pdf', $dompdf->output());
    }
}

