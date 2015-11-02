<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);    
include('lock.php');

$curr_user = $_SESSION['login_user']; 
$host = "host=localhost";
$dbname = "dbname=dbAppln";
$credentials = "user=admin password=db";
$db = pg_connect("$host $dbname $credentials");
echo "<h1>Welcome $curr_user</h1>";

$curr_date = new DateTime('Now');

echo "CURRENT RUNNING FORMS <br>";

echo "<br>";
echo "CHECK YOUR FORMS: <br>";
$query = pg_prepare($db, "my_forms", 'SELECT form_id from role where user_id = $1 and privilege = \'1\'');
$result = pg_execute($db, "my_forms", array($curr_user));
while($row = pg_fetch_row($result)){
	$query = pg_prepare($db, "getForm$row[0]", 'SELECT * from form where form_id = $1');
	$result1 = pg_execute($db, "getForm$row[0]", array($row[0]));
	$row = pg_fetch_row($result1);
	$form_start = $row[1];
	$form_end = $row[2];
	$startDate = new DateTime($form_start);
	$endDate = new DateTime($form_end);
 	if($startDate < $curr_date && $endDate > $curr_date){
		echo $row[4];
		echo " SEE SUBMITTED RESPONSES<br>";
	}
}

echo "<br>";
echo "FORMS FOR YOU TO FILL: <br>";

$query = pg_prepare($db, "awaiting_forms", 'SELECT form_id from role where user_id = $1 and privilege = \'0\' and status = \'0\'');
$result = pg_execute($db, "awaiting_forms", array($curr_user));
while($row = pg_fetch_row($result)){
	$query = pg_prepare($db, "getForm$row[0]", 'SELECT * from form where form_id = $1');
	$result1 = pg_execute($db, "getForm$row[0]", array($row[0]));
	$row = pg_fetch_row($result1);
	$form_start = $row[1];
	$form_end = $row[2];
	$startDate = new DateTime($form_start);
	$endDate = new DateTime($form_end);
	if($startDate < $curr_date && $endDate > $curr_date){
		echo $row[4];
		echo " FILL NOW<br>";
	}
}

$query = pg_prepare($db, "filled_forms", 'SELECT form_id from role where user_id = $1 and privilege = \'0\' and status = \'1\'');
$result = pg_execute($db, "filled_forms", array($curr_user));
while($row = pg_fetch_row($result)){
	$query = pg_prepare($db, "getForm$row[0]", 'SELECT * from form where form_id = $1');
	$result1 = pg_execute($db, "getForm$row[0]", array($row[0]));
	$row = pg_fetch_row($result1);
	$form_start = $row[1];
	$form_end = $row[2];
	$startDate = new DateTime($form_start);
	$endDate = new DateTime($form_end);
	if($startDate < $curr_date && $endDate > $curr_date){
		echo $row[4];
		echo " Thanks for Submitting your Response<br>";
	}
}

?>
<body>
<a href='addForm.php'>Add Form</a>
<form action="logout.php" method="post">
	<input type="submit" value="Logout"/><br />
</form>
</body>