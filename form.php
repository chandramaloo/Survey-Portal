<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript" src="jquery.js"></script>
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
	<title>Create Survey</title>
</head>
<body style="margin:20px;">
	<div id="main-cont">
		<form id='main-form' action='submit.php' method="POST">
	<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL); 
	session_start();

	$host = "host=localhost";
	$dbname = "dbname=dbAppln";
	$credentials = "user=admin password=db";
	$db = pg_connect("$host $dbname $credentials");

	$user_id=$_SESSION['login_user'];
	$form_id = $_GET['form_id'];	
	$flag = '0';

	$result = pg_prepare($db, "form_data", 'SELECT anonymity, form_name FROM form WHERE form_id=$1');
	$result = pg_execute($db, "form_data", array($form_id));
	$row = pg_fetch_row($result);
	$count = pg_num_rows($result);
	if($count!=1){
			header("Location: welcome.php");
	}

	$anonymity = $row[0];
	$formName = $row[1];

	$result = pg_prepare($db, "user_status", 'SELECT * FROM role WHERE form_id=$1 and user_id=$2 and privilege=$3 and status=$4');
	$result = pg_execute($db, "user_status", array($form_id, $user_id,$flag, $flag));
	$row = pg_fetch_row($result);
	$count = pg_num_rows($result);
	if($count!=1){
			header("Location: welcome.php");
	}
	
	$result = pg_prepare($db, "render", 'SELECT type, is_compulsory, content, extra_content FROM survey_questions WHERE form_id=$1');
	$result = pg_execute($db, "render", array($form_id));
	
	$quesArr = [];
	$compArr = [];
	$typeArr = [];
	$optArr = [];

	while($row = pg_fetch_row($result){
		array_push($typeArr, $row[0]);
		array_push($compArr, $row[1]);
		array_push($quesArr, $row[2]);
		$options = explode("\",\"", substr($row[3],1,-1));
		array_push($optArr, $options);
	}


	
	$str = "<h1>".$formName."</h1>";
	if($anonymity=="0") $str = $str."<h4>Your responses will NOT BE anonymous<h4>";
	else $str = $str."<h4>Your responses will be Anonymous<h4>";
	for($i = 0; $i < sizeof($quesArr); $i++){
		$str = $str."Question ".($i+1).":<br>".$quesArr[$i]."<br>";
		$tmp = "";
		if($compArr[$i]=='1') $tmp = " required";
  		switch($typeArr[$i]){
			case '1': $str = $str."Options:<ul>";
				for($j=0; $j<sizeof($optArr[$i]); $j++){
  					$str = $str."<li><input type='radio' name='inp-".($i+1)."' value='".$j."'".$tmp.">".$optArr[$i][$j]."</li>";
  				}
  				$str = $str."</ul>";
				break;
			case '2': $str = $str."Options: <select ".$tmp.">";
  					$str = $str."<option name='inp-".($i+1)."' value=''>--select one--</option>";
  				for($j=0; $j<sizeof($optArr[$i]); $j++){
  					$str = $str."<option name='inp-".($i+1)."' value='".$j."'>".$optArr[$i][$j]."</option>";
  				}
  				$str = $str."</select>";
				break;
			case '3': $str = $str."Options:<ul>";
  				for($j=0; $j<sizeof($optArr[$i]); $j++){
  					$str = $str."<li><input type='checkbox' name='inp-".($i+1)."' value='".$j."'".$tmp.">".$optArr[$i][$j]."</li>";
  				}
  				$str = $str."</ul>";
				$str = $str."
  					<script type='text/javascript'>
					    var requiredCheckboxes = $(\"[name='inp-".($i+1)."']\");
					    requiredCheckboxes.change(function(){
					        if(requiredCheckboxes.is(':checked')) {
					            requiredCheckboxes.removeAttr('required');
					        }
						    else {
				            	requiredCheckboxes.attr('required', 'required');
				        	}
				    	});
				    </script>";
  				break;
			case '4':
  					$str = $str."<input type='text' id='inp-".($i+1)."' class='form-control'".$tmp.">";
				break;
			case '5':
				break;
			case '6':
				break;
			default:
				break;
		}
		$str = $str."<br><br>";
	}
	$str= $str."<input type='submit' class='btn btn-success' value='Complete Survey'>";
	echo $str;
	?>		
		</form>
	</div>

</body>
</html>