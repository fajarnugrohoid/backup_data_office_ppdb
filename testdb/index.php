<?php
$db = @mysql_connect('192.168.101.4', 'mitla', 'password');

if ($db){
	echo 'connected';
}else{
	echo 'not connect';
}

?>