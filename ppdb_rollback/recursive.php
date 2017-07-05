<?php

$array = array( [325] => Array ( [id] => 325 [name] => SMP Negeri 1 [quota] => 382 [old_quota] => 396 [quota_luarkota] => 25 [old_quota_luarkota] => 39 [foreigner_percentage] => 10 [low_passing_grage] => 0 [dalam] => Array ( [id] => 325 [quota] => 193 [old_quota_dw] => 193 [passing_grade] => 0 [remaining_quota] => 0 [data] =>'')));

function factorial($number) { 

    if ($number < 2) { 
        return 1; 
    } else { 
        return ($number * factorial($number-1)); 
    } 
}


echo factorial(3);
?>