<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Role{
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

   	public function validateUser($user, $form){
		$flag = '0';
   		$result = pg_prepare($this->db, "get_user", 'SELECT * FROM role WHERE form_id=$1 and user_id=$2 and privilege=$3 and status=$4');
   		$result = pg_execute($this->db, "get_user", array($form, $user, $flag, $flag));
   		$row = pg_fetch_row($result);
   		$count = pg_num_rows($result);
   		if($count == 1){
   				return 1;
   		}
   		return 0;
   	}

   	public function updateStatus($user, $form){
		$flag = '0';
   		$result = pg_prepare($this->db, "update_user_status", 'UPDATE role SET status = \'1\' where user_id = $1 and form_id = $2 and privilege = \'0\'');
   		$result = pg_execute($this->db, "update_user_status", array($user, $form));
   	}


   	public function adminForms($user){
   		$query = pg_prepare($this->db, "my_forms", 'SELECT form_id from role where user_id = $1 and privilege = \'1\'');
		$result = pg_execute($this->db, "my_forms", array($user));
		$first = 0;
		while($row = pg_fetch_row($result)){
			$query = pg_prepare($this->db, "get_my_Form$row[0]", 'SELECT * from form where form_id = $1');
			$result1 = pg_execute($this->db, "get_my_Form$row[0]", array($row[0]));
			$row = pg_fetch_row($result1);
			$form_start = $row[1];
			$form_end = $row[2];
			$startDate = new DateTime($form_start);
			$endDate = new DateTime($form_end);
			$curr_date = new DateTime('Now');
		 	if($startDate < $curr_date && $endDate > $curr_date){
				if($first == 0){
					echo "<table class=\"table\">";
					echo "<tr><th>Form Name <th> Start Time <th> End Time <th>Anonymity <th></tr>";
					$first++;
				}
				$anonymity = "No";
				if($row[3] == 1){
					$anonymity = "Yes";
				}
				echo "<tr> <td>$row[4] <td> $row[1] <td> $row[2] <td> $anonymity <td><a href=\"surveyResponseFetch.php?form_id=$row[0]\"> Check your responses now </a> </tr>";
			}
		}
		if($first != 0){
			echo "</table>";
		}
		else{
			echo "There arent any surveys ran by you at the moment";
		}
   	}

   	public function currentForms($user){
   		$query = pg_prepare($this->db, "awaiting_forms", 'SELECT form_id from role where user_id = $1 and privilege = \'0\' and status = \'0\'');
		$result = pg_execute($this->db, "awaiting_forms", array($user));
		$count = 0;
		$first = 0;
		$curr_date = new DateTime('Now');
		while($row = pg_fetch_row($result)){
			$query = pg_prepare($this->db, "getForm$row[0]", 'SELECT * from form where form_id = $1');
			$result1 = pg_execute($this->db, "getForm$row[0]", array($row[0]));
			$row = pg_fetch_row($result1);
			$form_start = $row[1];
			$form_end = $row[2];
			$startDate = new DateTime($form_start);
			$endDate = new DateTime($form_end);
			if($startDate < $curr_date && $endDate > $curr_date){
				if($first == 0){
					echo "<table class=\"table\">";
					echo "<tr><th>Form Name <th> Start Time <th> End Time <th> Anonymity <th></tr>";
					$first++;
				}
				$count++;
				$anonymity = "No";
				if($row[3] == 1){
					$anonymity = "Yes";
				}
				echo "<tr> <td>$row[4] <td> $row[1] <td> $row[2] <td> $anonymity <td> <a href=\"form.php?form_id=$row[0]\"> Fill your responses now </a> </tr>";
			}
		}

		$query = pg_prepare($this->db, "filled_forms", 'SELECT form_id from role where user_id = $1 and privilege = \'0\' and status = \'1\'');
		$result = pg_execute($this->db, "filled_forms", array($user));
		while($row = pg_fetch_row($result)){
			$query = pg_prepare($this->db, "getForm$row[0]", 'SELECT * from form where form_id = $1');
			$result1 = pg_execute($this->db, "getForm$row[0]", array($row[0]));
			$row = pg_fetch_row($result1);
			$form_start = $row[1];
			$form_end = $row[2];
			$startDate = new DateTime($form_start);
			$endDate = new DateTime($form_end);
			if($startDate < $curr_date && $endDate > $curr_date){
				if($count == 0){
					echo "<table class=\"table\">";
					echo "<tr><th>Form Name <th> Start Time <th> End Time <th> Anonymity <th></tr>";
					$first++;
				}
				$count++;
				$anonymity = "No";
				if($row[3] == 1){
					$anonymity = "Yes";
				}
				echo "<tr> <td>$row[4] <td> $row[1] <td> $row[2] <td> $anonymity <td> Your response has been recorded. Thanks for participating </tr>";
			}
		}
		if($count == 0){
			echo "There are no ongoing surveys at the moment.";
		}
		else{
			echo "</table>";
		}
   	}
}
?>
