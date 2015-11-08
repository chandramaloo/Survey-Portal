<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="text/javascript" src="Chart.js"></script>
	<script type="text/javascript" src="jquery.js"></script>
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
	<style>
	td .response {
		width:100px;
	}

	</style>
</head>
<body>
<head>
</head>

<body>
<div class = "panel panel-primary">
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('formClass.php');

$form_id = $_GET['form_id'];
$form = new Form();
$chk = $form->checkNoForm($form_id);
if($chk == 1){
	header("Location: welcome.php");
}

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
   		//check user credentials
   		//fetch response corresponding to a form
   		$query = pg_prepare($this->db, "form_response", 'Select * from survey_responses where form_id = $1 order by (user_id,question_id)');
   		$result = pg_execute($this->db, "form_response", array($form_id));
   		$num_responses = pg_num_rows($result);

   		//fetch number of form questions
   		$query = pg_prepare($this->db, "questions", 'select * from survey_questions where form_id=$1');
   		$questions = pg_execute($this->db, "questions", array($form_id));
   		$num_questions = pg_num_rows($questions);

   		$query = pg_prepare($this->db, "anonymity", 'select anonymity, form_name from form where form_id=$1');
   		$anonymity_res = pg_execute($this->db, "anonymity", array($form_id));
   		$row = pg_fetch_row($anonymity_res);
   		$anonymity = $row[0];
   		$form_name = $row[1];
?>
	<div class="panel-heading"> <h3> <?php echo $form_name ?> </h3> </div>
<?php
   		// //printing table
   		if($num_responses==0){
   			echo "You have no responses yet. <br>";
   		}
   		else{
			echo "<table class=\"table table-hover\">";
			echo "<tr> <th class = \"response\"> Response number";
			if($anonymity=='0') {
				echo "<th class = \"response\"> User ID";
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
				echo "<th class = \"response\"> $row[1]";
			}
			echo "</tr>";
			$count=1;
	   		while($row = pg_fetch_row($result)){
		   		echo "<tr>";
		   		echo "<td class = \"response\">$count";
	   			if($anonymity=='0'){
	   				echo "<td class = \"response\"> $row[2]";
	   			}
	   			if($type[0] == '1' || $type[0] == '2' || $type[0] == '5'){
	   				if($row[3] != ""){
			   			$row_int = (int)$row[3];
			   			$temp = $options[0];
			   			echo "<td class = \"response\"> $temp[$row_int]";
			   		}
			   		else {
			   			echo "<td class = \"response\"> ";
			   		}
		   		}
		   		else if ($type[0] == '4'){
		   			echo "<td class = \"response\"> $row[3]";
		   		}
		   		else if ($type[0] == '3' || $type[0] == '6'){
		   			if($row[3] != ""){
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
			   			echo "<td class = \"response\"> $output";
		   				}
		   			}
		   			else {
		   				echo "<td class = \"response\"> ";
		   			}
	   			
	   			}
	   			for($i=1;$i<$num_questions;$i++){
	   				$row = pg_fetch_row($result);
	   				if($type[$i] == 1 || $type[$i] == 2 || $type[$i] == 5){
	   					if($row[3] != ""){
				   			$row_int = (int)$row[3];
				   			$temp = $options[$i];
				   			echo "<td class = \"response\"> $temp[$row_int]";
				   		}
				   		else{
				   			echo "<td class = \"response\">";
				   		}
			   		}
			   		else if ($type[$i] == 4){
			   			echo "<td class = \"response\"> $row[3]";
			   		}
			   		else if ($type[$i] == 3 || $type[$i] == 6){
			   			if($row[3] != ""){
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
				   			echo "<td class = \"response\" $output";
			   				}
			   			}
			   			else {
			   				echo "<td class = \"response\"> ";
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
	   	$num = pg_num_rows($num_response);

	   	if($num == 0){
	   		echo "We have no response statistics to display. <br>";
	   	}
	   	else{
	   		echo '<div id="bars"></div>';
	   		while($row = pg_fetch_row($questions)){
	   			if($row[2] == '1' || $row[2] == '2' || $row[2] == '5'){
	   				echo '<script type="text/javascript">{
						$("#bars").append("<h3>Question '.($row[1]+1).': '.$row[5].'</h3><canvas id=\'myChart-'.$row[1].'\' width=\'200\' height=\'200\'></canvas><br>");
						var ctx = document.getElementById("myChart-'.$row[1].'").getContext("2d");
						var opt = []; var perc = [];';
		   			$num = pg_execute($this->db, "response", array($form_id,$row[1]));
		   			$num_responses = pg_num_rows($num);
		   			//extract each response possible from row[6]
		   			$options = explode("\",\"", substr($row[6],1,-1));
		   			for($i = 0;$i < sizeof($options);$i++){
	   					$result = pg_execute($this->db, "aggregation", array($form_id,$row[1],$i));
	   					$freq_row = pg_fetch_row($result);
	   					$percentage = $freq_row[0]*100/$num_responses;
	   					echo "opt.push('".$options[$i]."'); perc.push('".$percentage."');";
	   				}
	   				
		   			echo '
					var data = {
			    	labels: opt,
					    datasets: [
					        {
					            label: "Percentage",
					            fillColor: "rgba(0,220,0,0.5)",
					            strokeColor: "rgba(0,204,220,0.8)",
					            highlightFill: "rgba(0,255,0,0.75)",
					            highlightStroke: "rgba(220,220,220,1)",
					            data: perc
					        }	
					    ]
					};
					var myBarChart = new Chart(ctx).Bar(data);}</script>';
	   			} else if($row[2] == '3' || $row[2] == '6'){
	   				echo '<script type="text/javascript">{
						$("#bars").append("<h3>Question '.($row[1]+1).': '.$row[5].'</h3><canvas id=\'myChart-'.$row[1].'\' width=\'200\' height=\'200\'></canvas><br>");
						var ctx = document.getElementById("myChart-'.$row[1].'").getContext("2d");
						var opt = []; var perc = [];';
		   			

	   				$options = explode("\",\"", substr($row[6],1,-1));
	   				$mcq = pg_execute($this->db, "response", array($form_id,$row[1]));
	   				$num_responses = pg_num_rows($mcq);
	   				$freq = array();
	   				for($i = 0; $i < sizeof($options); $i++){
	   					$freq[$i] = 0;
	   				}
	   				while($mcq_row = pg_fetch_row($mcq)){
	   					if($mcq_row[3] != ""){
		   					$mcq_response = explode(",",$mcq_row[3]);
		   					for($k = 0; $k<sizeof($mcq_response); $k++){
		   						$row_int = (int)$mcq_response[$k];
		   						$freq[$row_int]++;
		   					}
		   				}
	   				}
	   				for($i = 0;$i < sizeof($options);$i++){
	   					$percentage = $freq[$i]*100/$num_responses;
	   					echo "opt.push('".$options[$i]."'); perc.push('".$percentage."');";
	   				}
	   				
		   			echo '
					var data = {
			    	labels: opt,
					    datasets: [
					        {
					            label: "Percentage",
					            fillColor: "rgba(0,0,220,0.7)",
					            strokeColor: "rgba(153,220,220,0.8)",
					            highlightFill: "rgba(220,220,220,0.75)",
					            highlightStroke: "rgba(220,220,220,1)",
					            data: perc
					        }	
					    ]
					};
					var myBarChart = new Chart(ctx).Bar(data);}</script>';
	   			}
	   			
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
	   					if($mcq_row[3] != ""){
		   					$mcq_response = explode(",",$mcq_row[3]);
		   					for($k = 0; $k<sizeof($mcq_response); $k++){
		   						$row_int = (int)$mcq_response[$k];
		   						$freq[$row_int]++;
		   					}
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

 // echo "$form_id heelo";
 $response = new SurveyResponse();
 $response->fetchResponse($form_id);
 $response->form_statistics($form_id);

?>
</div>
</body>
</html>
