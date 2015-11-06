<head>
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
	<style type="text/css">

	</style>
</head>
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
$curr_date = new DateTime('Now');
?>

<body>
<div class = "panel panel-primary">
	<div class = "panel-heading">
		<h2 style ="margin-top: -5px;" >Welcome 
			<?php echo $_SESSION['login_user'];?></h2>
	</div>
	<br>
	<div class = "panel panel-default">
		<div class = "panel-heading" style="margin-top:-20px;"> <H3 style="padding-top:15px;margin-top:-15px; margin-bottom:0px; margin-left:-7px;">CURRENT RUNNING FORMS </H3></div>
		<div class = "panel panel-success">
			<div class = "panel-heading"><h4 style="margin-top:1px; margin-left:-7px;margin-bottom:5px"> Your Current Running Forms </h4></div>

<?php
$query = pg_prepare($db, "my_forms", 'SELECT form_id from role where user_id = $1 and privilege = \'1\'');
$result = pg_execute($db, "my_forms", array($curr_user));
$first = 0;
while($row = pg_fetch_row($result)){
	$query = pg_prepare($db, "get_my_Form$row[0]", 'SELECT * from form where form_id = $1');
	$result1 = pg_execute($db, "get_my_Form$row[0]", array($row[0]));
	$row = pg_fetch_row($result1);
	$form_start = $row[1];
	$form_end = $row[2];
	$startDate = new DateTime($form_start);
	$endDate = new DateTime($form_end);
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
		echo "<tr> <td>$row[4] <td> $row[1] <td> $row[2] <td> $anonymity <td> Check Survey Responses </tr>";
	}
}
if($first != 0){
	echo "</table>";
}
else{
	echo "There arent any surveys ran by you at the moment";
}
?>
		</div>

		<div class = "panel panel-success">
			<div class = "panel-heading"> <h4 style="margin-top:1px; margin-left:-5px;margin-bottom:5px"> Forms For You To Fill: </h4></div>

<?php
$query = pg_prepare($db, "awaiting_forms", 'SELECT form_id from role where user_id = $1 and privilege = \'0\' and status = \'0\'');
$result = pg_execute($db, "awaiting_forms", array($curr_user));
$count = 0;
$first = 0;
while($row = pg_fetch_row($result)){
	$query = pg_prepare($db, "getForm$row[0]", 'SELECT * from form where form_id = $1');
	$result1 = pg_execute($db, "getForm$row[0]", array($row[0]));
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
		echo "<tr> <td>$row[4] <td> $row[1] <td> $row[2] <td> $anonymity <td> Fill your responses now </tr>";
	}
}

$query = pg_prepare($db, "filled_forms", 'SELECT form_id from role where user_id = $1 and privilege = \'0\' and status = \'1\'');
$result = pg_execute($db, "filled_forms", array($curr_user));
$count = $count + pg_num_rows($result);
while($row = pg_fetch_row($result)){
	$query = pg_prepare($db, "getForm$row[0]", 'SELECT * from form where form_id = $1');
	$result1 = pg_execute($db, "getForm$row[0]", array($row[0]));
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
		echo "<tr> <td>$row[4] <td> $row[1] <td> $row[2] <td> $anonymity <td> Your response has been recordes. Thanks for participating </tr>";
	}
}
if($count == 0){
	echo "There are no ongoing surveys at the moment.";
}
else{
	echo "</table>";
}
pg_close($db);

?>
	</div>

	</div>
<button type="button" class="btn btn-info" onclick="location.href = 'addForm.php';" >Host a New Survey</button> 
<button type="button" class="btn btn-danger" onclick="location.href = 'logout.php';" >LOGOUT</button> <br><br>
</div>
</body>