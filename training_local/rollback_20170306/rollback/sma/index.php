<?php
// function jumlah(&$nilai) {
// 	$nilai++;
// }

// $input=5;

// jumlah($input);

// echo $input;

// echo '<br/>';



$list = array(
			array(
				'id'=>0,
				'status'=>0,
				'nilai'=>4
			),
			array(
				'id'=>1,
				'status'=>0,
				'nilai'=>7
			),
			array(
				'id'=>2,
				'status'=>0,
				'nilai'=>5
			)
	);

var_dump($list);

echo '<br/>';
echo '<br/>';

// function recursive(&$list, $i){

// 	if ($i<count($list)){
		
// 		if ($list[$i]['status']==0){
// 			$list[$i]['status']=1;
// 		}

// 		$i++;
// 		recursive($list, $i);	
// 	}
	
// }

function func(&$list){
	$status = true;
	for($i=0;$i<count($list);$i++){
		if ($list[$i]['status']==0) {
			$list[$i]['status']=1;
			$status = false;
		}
	}
	if ($status==false){
		func($list);
	}
}



func($list);

// recursive($list,0);
//var_dump($list);
// $res=recursive($list,0);
// $res=recursive($list,1);
// $res=recursive($list,2);

// for($i=0;$i<count($list);$i++){
// 	recursive($list, $i);
// }

//var_dump($res);
// echo '<br/>';
var_dump($list);
//var_dump($list);
?>