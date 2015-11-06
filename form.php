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




	$formName = "Sample Form";
	$quesArr = ['q1','Q2','Q3','q4'];
	$compArr = ['1','1','1','1'];
	$typeArr = ['1','2','3','4'];
	$optArr = [['O11','O12','O13'],['O21','O22','O23'],['o31','o32'],[]];

	$str = "<h1>".$formName."</h1>";
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