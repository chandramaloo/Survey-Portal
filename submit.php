<head>
<link rel="stylesheet" type="text/css" href="bootstrap.min.css">

</head>

<?php
include('lock.php');
include('role.php');

$user_id=$_SESSION['login_user'];
$form_id=$_SESSION['submitted_form'];


//check that the user was privelege = 0 and status = 0 on that form_id also implement that the time should be in the limits, FUNCTION in ROLE
$role = new Role();
$validate = $role->validateUser($user_id, $form_id);
if($validate == 0){
	header("Location: welcome.php");
}

$role->updateStatus($user_id, $form_id);

$result = pg_prepare($db, "render", 'SELECT type FROM survey_questions WHERE form_id=$1');
$result = pg_execute($db, "render", array($form_id));
$typeArr = [];

while($row = pg_fetch_row($result)){
	array_push($typeArr, $row[0]);
}

$numQuestions = sizeof($typeArr);

$result = pg_prepare($db, "insert_response", "INSERT into survey_responses values($1, $2, $3, $4)");
for($i = 0; $i < $numQuestions; $i++){
	$temp = $i+1;
	switch ($typeArr[$i]) {
		case '1':
			$survey_response = '';
			if(count($_POST['inp-'.$temp] > 0)){
				$survey_response = $_POST['inp-'.$temp];
			}
			$result = pg_execute($db, "insert_response", array($form_id, $i, $user_id, $survey_response));
			break;
		case '2':
			$survey_response = $_POST['inp-'.$temp];
			$result = pg_execute($db, "insert_response", array($form_id, $i, $user_id, $survey_response));
			break;
		case '3':
			$survey_response = '';
			if(count($_POST['inp-'.$temp] > 0)){
				for($j = 0; $j < count($_POST['inp-'.$temp]); $j++){
					if($j != 0)
						$survey_response = $survey_response.',';
					$survey_response = $survey_response.$_POST['inp-'.$temp][$j];
				}
			}
			$result = pg_execute($db, "insert_response", array($form_id, $i, $user_id, $survey_response));
			break;	
		case '4':
			$survey_response = $_POST['inp-'.$temp];
			$result = pg_execute($db, "insert_response", array($form_id, $i, $user_id, $survey_response));
			break;
	}
}
pg_close($db);
header("Location: welcome.php");

?>
