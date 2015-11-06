<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class SurveyResponse{
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

   	public function fetchResponse($form_id){
   		//fetch response corresponding to a form
   		$query = pg_prepare($this->db, "form_response", 'Select * from survey_responses where form_id = $1 order by (user_id,question_id)');
   		$result = pg_execute($this->db, "form_response", array($form_id));
   		$num_responses = pg_num_rows($result);

   		//fetch number of form questions
   		$query = pg_prepare($this->db, "questions", 'select * from survey_questions where form_id=$1');
   		$questions = pg_execute($this->db, "questions", array($form_id));
   		$num_questions = pg_num_rows($questions);

   		$query = pg_prepare($this->db, "anonymity", 'select anonymity from form where form_id=$1');
   		$anonymity_res = pg_execute($this->db, "anonymity", array($form_id));
   		$row = pg_fetch_row($anonymity_res);
   		$anonymity = $row[0];

   		// //printing table
   		if($num_responses==0){
   			echo "You have no responses yet.";
   		}
   		else{
			echo "<table class=\"table\">";
			echo "<tr> <th> Response number";
			if($anonymity=='0') {
				echo "<th> User ID";
			}
			while ($row = pg_fetch_row($questions)){
				echo "<th> $row[1]";
			}
			echo "</tr>";
			$count=1;
	   		while($row = pg_fetch_row($result)){
	   			echo "<tr>";
	   			echo "<td>$count";
	   			if($anonymity=='0'){
	   				echo "<td> $row[2]";
	   			}
	   			echo "<td> $row[3]";
	   			for($i=1;$i<$num_questions;$i++){
	   				$row = pg_fetch_row($result);
	   				echo "<td> $row[3]";
	   			}
	   			echo "</tr>";
	   			$count++;
	   		}
	   		echo "</table>";
	   	}

   	}

   	public function form_statistics($form_id){
   		$query = pg_prepare($this->db, "questions1", 'select * from survey_questions where form_id=$1');
   		$questions = pg_execute($this->db, "questions1", array($form_id));
	   	$query1 = pg_prepare($this->db, "aggregation", 'select response, count(response) as freq from survey_responses where form_id = $1 and question_id = $2 group by response');

   		while($row = pg_fetch_row($questions)){
   			if($row[2] == '1' || $row[2] == '2'){
	   			$result = pg_execute($this->db, "aggregation", array($form_id,$row[1]));
	   			echo "$row[1] <br>";
	   			//print table
	   			echo "<table class=\"table\">";
	   			echo "<tr> <th> Response <th> Frequency";
	   			while($stat_row = pg_fetch_row($result)){
	   				echo "<tr> <td> $stat_row[0] <td> $stat_row[1] </tr>";
	   			}
	   			echo "</table>";
	   		}
   		}
   	}

   }

 $response = new SurveyResponse();
 $response->fetchResponse('1234567890');
 $response->form_statistics('1234567890');

?>
