<?php
class Database extends PDO {
	
	function __construct(){

		$dsn = "mysql:dbname=test";
		$username = "root";
		$password = "";

		try {  
			parent::__construct( $dsn, $username, $password );  
			$this->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  
	
		}
		catch(PDOException $e) {  
		    echo 'ERROR: ' . $e->getMessage();
		}   

	}
}