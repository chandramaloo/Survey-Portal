<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Form{
	private $db;
	
	function __construct() {
		$host = "host=localhost";
		$dbname = "dbname=dbAppln";
		$credentials = "user=admin password=db";
		$this->db = pg_connect("$host $dbname $credentials");
	}

   	public function checkNoForm($form_id){
   		$result = pg_prepare($this->db, "form_data", 'SELECT anonymity, form_name FROM form WHERE form_id=$1');
		$result = pg_execute($this->db, "form_data", array($form_id));
		$row = pg_fetch_row($result);
		$count = pg_num_rows($result);
		if($count!=1){
			return 1;
		}
		else return 0;
   	}

   	public function insertForm($form_id, $start_date, $end_date, $anonymity, $form_name){
   		$result = pg_prepare($this->db, "add$form_id", "INSERT into form values($1, $2, $3, $4, $5)");
		$result = pg_execute($this->db, "add$form_id", array($form_id, $start_date, $end_date, $anonymity, $form_name));
   	}
}
?>
