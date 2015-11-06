<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class User{
	private $db;
	
	function __construct() {
		$host = "host=localhost";
		$dbname = "dbname=dbAppln";
		$credentials = "user=admin password=db";
		$this->db = pg_connect("$host $dbname $credentials");
	}
	
	function __destruct() {
    	pg_close($this->db);
   }

	public function validateUser($user, $passwd){
		$result = pg_prepare($this->db, "login", 'SELECT user_id FROM users WHERE user_id=$1 and password=$2');
		$result = pg_execute($this->db, "login", array($user, $passwd));
		$row = pg_fetch_row($result);
		$count = pg_num_rows($result);

		if($count==1)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}

	public function checkUID($userID){
		$result = pg_prepare($this->db, "login", 'SELECT user_id FROM users WHERE user_id=$1');
		$result = pg_execute($this->db, "login", array($userID));
		$row = pg_fetch_row($result);
		$count = pg_num_rows($result);

		if($count==0)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}

	public function addUser($userID, $password, $username, $department, $year, $email){
		$result = pg_prepare($this->db, "add_user", 'INSERT into users values($1, $2, $3, $4, $5, $6)');
		$result = pg_execute($this->db, "add_user", array($userID, $password, $username, $department, $year, $email));
		if($result != false){
			return 1;
		}
		else{
			return 0;
		}
	}

	public function tabulateAllUsers(){
		$result = pg_query($this->db, "SELECT user_id, name, department from users order by department, user_id");
		echo "<table class=\"table table-hover\">";
		echo "<tr><th>User ID<th>User Name<th>Department<th>";
		while($row = pg_fetch_row($result)){
			echo "<tr>";
			echo "<td> $row[0] </ td>"; 
			echo "<td> $row[1] </ td>";
			echo "<td> $row[2] </ td>";
			echo "<td> <input type='checkbox' name='select[]' value='{$row[0]}' /> </ td>";
			echo "</tr>"; 
		}
		echo "</table>";
	}

	public function getUser($userID){
		$query = pg_prepare($this->db, "display_user$userID", 'SELECT * FROM users WHERE user_id = $1') ;
		$result = pg_execute($this->db, "display_user$userID", array($userID));
		$row = pg_fetch_row($result);
		return array($row[0], $row[2], $row[3]);
	}


}
?>
