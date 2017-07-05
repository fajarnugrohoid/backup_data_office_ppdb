<?php
$data = 'some data'.PHP_EOL;
$fp = fopen('log_aing.txt', 'a');
fwrite($fp, $data);
fclose($fp);


/*	$fp = fopen('C:\\mitla\\Apache2\\htdocs\\hbp_study\\' . 'log_aing.html', 'a');
		$data = 'chart_id:' . $chartId.PHP_EOL;
		$data .= 'chartinfo:' . json_encode($chartinfo).PHP_EOL;
		fwrite($fp, $data);
		fclose($fp);*/

?>