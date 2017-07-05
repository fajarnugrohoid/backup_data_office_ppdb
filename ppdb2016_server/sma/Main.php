<?php
$time_start = microtime(true);
require 'ViewData.php';

$viewData = new ViewData;
$viewData->showData();

$time_end = microtime(true);
$time = $time_end - $time_start;
echo 'Filtered : '.$time . ' on ' . $datetime_now;
echo '<br/>'.memory_get_usage();
?>