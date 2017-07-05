<?php
	/*error_reporting(0);*/

	$mysqli = new mysqli("localhost", "root", "", "ppdb2016_20160612");
	if ($mysqli->connect_errno) {
	    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	/*mysql_connect('localhost','root','') or die("Koneksi gagal");
	mysql_select_db('ppdb2015-dev') or die("Database tidak bisa dibuka");*/

	/*@mysql_connect('localhost','root','') or die("Koneksi gagal");
	@mysql_select_db('ppdb2015') or die("Database tidak bisa dibuka");*/

?>