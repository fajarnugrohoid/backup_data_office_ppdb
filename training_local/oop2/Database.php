<?php
/*
* Mysql database class - only one connection alowed
*/
class Database {
	var $host = 'localhost';
    var $user = 'root';
    var $pass = '';
    var $db = 'ppdb2016_20160612';
    var $dbconn;
	
	function connect() {
        $con = mysqli_connect($this->host, $this->user, $this->pass, $this->db);
        if (!$con) {
            die('Could not connect to database!');
        } else {
            $this->dbconn = $con;
        }
        return $this->dbconn;
    }

    function close() {
        mysqli_close($this->dbconn);
        echo 'Connection closed!';
    }
}
?>