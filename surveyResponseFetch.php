<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
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
			$options = array();
			$type = array();
			while ($row = pg_fetch_row($questions)){	//loop thru questions
				array_push($type, $row[2]);
				if($row[2] != 4){
					$temp = explode("\",\"", substr($row[6],1,-1));
					array_push($options,$temp);	//$options[i] = array of all mcq options
				}
				else{
					array_push($options,-1);
				}
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
	   			if($type[0] == 1 || $type[0] == 2 || $type[0] == 5){
		   			$row_int = (int)$row[3];
		   			$temp = $options[0];
		   			echo "<td> $temp[$row_int]";
		   		}
		   		else if ($type[0] == 4){
		   			echo "<td> $row[3]";
		   		}
		   		else if ($type[0] == 3 || $type[0] == 6){
		   			$choices = explode(",", $row[3]);
		   			$output="";
		   			if(sizeof($choices) != 0){
		   				$row_int = (int)$choices[0];
		   				$temp = $options[0];
		   				$output .= $temp[$row_int];

		   				for($k=1; $k<sizeof($choices);$k++){
			   				$row_int = (int)$choices[$k];
			   				$temp = $options[0];
			   				$output .= ", ".$temp[$row_int];
		   				}
		   			echo "<td> $output";
	   				}
	   			
	   			}
	   			for($i=1;$i<$num_questions;$i++){
	   				$row = pg_fetch_row($result);
	   				if($type[$i] == 1 || $type[$i] == 2 || $type[$i] == 5){
			   			$row_int = (int)$row[3];
			   			$temp = $options[$i];
			   			echo "<td> $temp[$row_int]";
			   		}
			   		else if ($type[$i] == 4){
			   			echo "<td> $row[3]";
			   		}
			   		else if ($type[$i] == 3 || $type[$i] == 6){
			   			$choices = explode(",", $row[3]);
			   			$output="";
			   			if(sizeof($choices) != 0){
			   				$row_int = (int)$choices[0];
			   				$temp = $options[$i];
			   				$output .= $temp[$row_int];

			   				for($k=1; $k<sizeof($choices);$k++){
				   				$row_int = (int)$choices[$k];
				   				$temp = $options[$i];
				   				$output .= ", ".$temp[$row_int];
			   				}
			   			echo "<td> $output";
		   				}
		   			
		   			}
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
	   	$query = pg_prepare($this->db, "aggregation", 'select count(*) as freq from survey_responses where form_id = $1 and question_id = $2 and response = $3');
	   	$query = pg_prepare($this->db, "response", 'select * from survey_responses where form_id = $1 and question_id = $2');
	   	$query = pg_prepare($this->db, "num_response", 'Select * from survey_responses where form_id = $1');
	   	$num_response = pg_execute($this->db, "num_response", array($form_id));
	   	$num_response = pg_num_rows($num_response);

	   	if($num_response == 0){
	   		echo "no response statistics to display."
	   	}
	   	else{
	   		while($row = pg_fetch_row($questions)){
	   			if($row[2] == '1' || $row[2] == '2' || $row[2] == '5'){
	   				$num = pg_execute($this->db, "response", array($form_id,$row[1]));
	   				$num_responses = pg_num_rows($num);
	   				echo "$row[1] : $row[5]<br>";
	   				//extract each response possible from row[6]
	   				$options = explode("\",\"", substr($row[6],1,-1));
	   				echo "<table class=\"table\">";
	   				echo "<tr> <th> Response <th> Frequency <th> Percentage";
	   				for($i = 0;$i < sizeof($options);$i++){
	   					$result = pg_execute($this->db, "aggregation", array($form_id,$row[1],$i));
	   					$freq_row = pg_fetch_row($result);
	   					$percentage = $freq_row[0]*100/$num_responses;
	   					echo "<tr> <td> $options[$i] <td> $freq_row[0] <td> $percentage </tr>";
	   				}
	   				echo "</table>";
		   		}
		   		else if($row[2] == '3' || $row[2] == '6'){
		   			echo "$row[1] : $row[5]<br>";
	   				//extract each response possible from row[6]
	   				$options = explode("\",\"", substr($row[6],1,-1));
	   				$mcq = pg_execute($this->db, "response", array($form_id,$row[1]));
	   				$num_responses = pg_num_rows($mcq);
	   				$freq = array();
	   				for($i = 0; $i < sizeof($options); $i++){
	   					$freq[$i] = 0;
	   				}
	   				while($mcq_row = pg_fetch_row($mcq)){
	   					$mcq_response = explode(",",$mcq_row[3]);
	   					for($k = 0; $k<sizeof($mcq_response); $k++){
	   						$row_int = (int)$mcq_response[$k];
	   						$freq[$row_int]++;
	   					}
	   				}
	   				echo "<table class=\"table\">";
	   				echo "<tr> <th> Response <th> Frequency <th> Percentage";
	   				for($i = 0;$i < sizeof($options);$i++){
	   					$percentage = $freq[$i]*100/$num_responses;
	   					echo "<tr> <td> $options[$i] <td> $freq[$i] <td> $percentage </tr>";
	   				}
	   				echo "</table>";
		   		}
	   		}//end of while
	   	}
   	}//end of function

   }	//end of class

 $form_id = $_GET['form_id'];
 echo "$form_id heelo";
 $response = new SurveyResponse();
 $response->fetchResponse($form_id);
 $response->form_statistics($form_id);

?>
