<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript" src="jquery.js"></script>
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
	<title>Create Survey</title>
	<style type="text/css">
	h1{
		text-align: center;
	}

	</style>
</head>
<body style="margin:20px;">
	<div id="main-cont" class="panel panel-info">
	<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	include('lock.php');
	include('role.php');
	include('formClass.php');
	error_reporting(E_ALL); 

	$host = "host=localhost";
	$dbname = "dbname=dbAppln";
	$credentials = "user=admin password=db";
	$db = pg_connect("$host $dbname $credentials");

	$user_id=$_SESSION['login_user'];
	$form_id = $_GET['form_id'];	

	$form = new Form();
	if($form->checkNoForm($form_id) == 1){
		header("Location: welcome.php");
	}
	
	$_SESSION['submitted_form']=$form_id;

	$anonymity = $row[0];
	$formName = $row[1];

	$role = new Role();
	$validate = $role->validateUser($user_id, $form_id);
	if($validate == 0){
		header("Location: welcome.php");
	}
	
	$result = pg_prepare($db, "render", 'SELECT type, is_compulsory, content, extra_content, question_id FROM survey_questions WHERE form_id=$1');
	$result = pg_execute($db, "render", array($form_id));
	
	$quesArr = [];
	$compArr = [];
	$typeArr = [];
	$optArr = [];
	$quesID = [];

	while($row = pg_fetch_row($result)){
		array_push($typeArr, $row[0]);
		array_push($compArr, $row[1]);
		array_push($quesArr, $row[2]);
		$options = explode("\",\"", substr($row[3],1,-1));
		array_push($optArr, $options);
		array_push($quesID, $row[4]);
	}
	

	$str = "<div class =\"panel-heading\" style=\"padding-top=0px;\"><h1>".$formName."</h1></div>";
	$str = $str."<div class = \"panel-body\">";
	if($anonymity=="0") $str = $str."<h6>Your responses will NOT BE anonymous<h4>";
	else $str = $str."<h6>Your responses will be Anonymous<h4>";
	$str = $str."<form id='main-form' action='submit.php' method=\"POST\">";
	for($i = 0; $i < sizeof($quesArr); $i++){
		$tmp = "";
		$star = "";
		if($compArr[$i]=='1'){
			$tmp = " required";
			$star = "<span style='color:#800000'>*</span>";
		}
  		$str = $str."Question ".($i+1).$star.": ".$quesArr[$i];
		switch($typeArr[$i]){
			case '1': $str = $str."<br><ul style=\"list-style-type: none;\">";
				for($j=0; $j<sizeof($optArr[$i]); $j++){
  					$str = $str."<li><input type='radio' name='inp-".($i+1)."' value='".$j."'".$tmp.">".$optArr[$i][$j]."</li>";
  				}
  				$str = $str."</ul>";
				break;
			case '2': $str = $str."&nbsp;&nbsp;<select name='inp-".($i+1)."'".$tmp.">";
  					$str = $str."<option  value=''>--select one--</option>";
  				for($j=0; $j<sizeof($optArr[$i]); $j++){
  					$str = $str."<option value='".$j."'>".$optArr[$i][$j]."</option>";
  				}
  				$str = $str."</select>";
				break;
			case '3': $str = $str."<br><ul style=\"list-style-type: none;\">";
  				for($j=0; $j<sizeof($optArr[$i]); $j++){
  					$str = $str."<li><input type='checkbox' name='inp-".($i+1)."[]' value='".$j."'".$tmp.">".$optArr[$i][$j]."</li>";
  				}
  				$str = $str."</ul>";
  				if($compArr[$i]=='1')
					$str = $str."
  						<script type='text/javascript'>
					    	var requiredCheckboxes = $(\"[name='inp-".($i+1)."[]']\");
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
  					$str = $str."<br><input type='text' name='inp-".($i+1)."' class='form-control'".$tmp.">";
				break;
	/* 	
			case '5': $str = $str."<br><ul style=\"list-style-type: none;\">";
				for($j=0; $j<sizeof($optArr[$i]); $j++){
  					$str = $str."<li><input type='radio' name='inp-".($i+1)."' value='".$j."'".$tmp.">".$optArr[$i][$j]."</li>";

  					$res = pg_query("SELECT encode(data, 'base64') AS data FROM images WHERE id='".$form_id.$i.$j."'"); 
					$raw = pg_fetch_result($res, 'data');
				// 	header('Content-type: image/jpeg');
				//	$str = $str.base64_decode($raw);
  				}
  				$str = $str."</ul>";
				break;
			case '6': $str = $str."<br><ul style=\"list-style-type: none;\">";
  				for($j=0; $j<sizeof($optArr[$i]); $j++){
  					$str = $str."<li><input type='checkbox' name='inp-".($i+1)."[]' value='".$j."'".$tmp.">".$optArr[$i][$j]."</li>";

  					$res = pg_query("SELECT encode(data, 'base64') AS data FROM images WHERE id='".$form_id.$i.$j."'"); 
					$raw = pg_fetch_result($res, 'data');
				 //	header('Content-type: image/jpeg');
				//	$str = $str.base64_decode($raw);
  				}
  				$str = $str."</ul>";
				$str = $str."
  					<script type='text/javascript'>
					    var requiredCheckboxes = $(\"[name='inp-".($i+1)."[]']\");
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
			default:
				break;
				*/
		}
		$str = $str."<br><br>";
	}
	$str= $str."<input type='submit' class='btn btn-success' value='Complete Survey'>";
	echo $str;
	
	?>		
</div>
		</form>
	</div>

</body>
</html>