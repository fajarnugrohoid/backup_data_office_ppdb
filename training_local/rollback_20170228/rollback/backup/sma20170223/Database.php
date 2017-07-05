<?php
/*
* Mysql database class - only one connection alowed
*/
class Database {
	var $host = 'localhost';
    var $user = 'root';
    var $pass = '';
    //var $db = 'ppdb2017-demo';
    var $db = 'ppdb2017-demosumut';
    var $dbconn;
	
	function connect() {
        $con = mysqli_connect($this->host, $this->user, $this->pass, $this->db);
        if (!$con) {
            die('Could not connect to database!');
        } else {
            echo 'dbconn';
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