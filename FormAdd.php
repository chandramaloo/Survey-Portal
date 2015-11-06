<head>
<link rel="stylesheet" type="text/css" href="bootstrap.min.css">

</head>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);    
include('lock.php');

$user_id = $_SESSION['login_user'];
$form_id = $user_id.time();
$form_name = $_POST['form_name'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$anonymity = $_POST['anonymity'];
echo $anonymity;

$selected_users = count($_POST['select']);

$host = "host=localhost";
$dbname = "dbname=dbAppln";
$credentials = "user=admin password=db";
$db = pg_connect("$host $dbname $credentials");
$result = pg_prepare($db, "add$form_id", "INSERT into form values($1, $2, $3, $4, $5)");
$result = pg_execute($db, "add$form_id", array($form_id, $start_date, $end_date, $anonymity, $form_name));
$result = pg_prepare($db, "add$user_id", "INSERT into role values($1, $2, $3, $4)");
$result = pg_execute($db, "add$user_id", array($form_id, $user_id, '1', '1'));


for($i = 0; $i < $selected_users; $i++) {
  	$userid = pg_escape_string($_POST['select'][$i]);
  	$result = pg_prepare($db, "add$userid", "INSERT into role values($1, $2, $3, $4)");
  	$result = pg_execute($db, "add$userid", array($form_id, $userid, '0', '0'));
}

$questions = $_POST['questions'];
$questions = substr($questions, 1, strlen($questions)-2);
$questions = explode(",", $questions);
$num_questions = count($questions);
echo $num_questions;
$types = $_POST['question_types'];
$types = substr($types, 1, strlen($types)-2);
$types = explode(",", $types);

$options = $_POST['optionArray'];
$options = explode("]", $options);
for ($i=0; $i < $num_questions; $i++) { 
	$question_id = $i;
	$ques_content = $questions[$i];
	$ques_content = substr($ques_content, 1, strlen($ques_content)-2);
	$ques_type = $types[$i];
	$ques_type = substr($ques_type, 1, strlen($ques_type)-2);	
	$ques_options = substr($options[$i], 2);
	$compulsory = '0';
  	$result = pg_prepare($db, "add$question_id", "INSERT into survey_questions values($1, $2, $3, $4, $5, $6, $7)");
  	$result = pg_execute($db, "add$question_id", array($form_id, $question_id, $ques_type, NULL, $compulsory, $ques_content, $ques_options));
}

?>
<form action="addQuestions.php" method="post" class = "form-inline">
<input type = "submit" value = "Proceed to Add Questions" name = "submit">
</form> 