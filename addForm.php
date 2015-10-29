<head>
<link rel="stylesheet" type="text/css" href="bootstrap.min.css">

</head>
<body>
<form action="addQuestions.php" method="post" class="form-horizontal">
Form Name: &nbsp; &nbsp;<input type="text" name="form_name">
<br>
<br>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);    
include('lock.php');
$user_id = $_SESSION['login_user'];
$result = pg_query($db, "SELECT user_id, name, department from users order by department, user_id");
echo "<table class=\"table table-hover\">";
echo "<tr><th>User ID<th>User Name<th>Department<th>";
while($row = pg_fetch_row($result)){
	echo "<tr>";
	echo "<td> $row[0] </ td>"; 
	echo "<td> $row[1] </ td>";
	echo "<td> $row[2] </ td>";
	echo "<td> <input type='checkbox' name='select[]' value='{$row[0]}' /> </ td>";
	echo "</tr>"; 
}
echo "</table>";

?>
<br>
Anonymity: <input type="radio" name="anonymity" value="yes">Yes
<input type="radio" name="anonymity" value="no">No	
<br>
<br>
<input type="submit" value="Confirm Selection"/><br />
</form>
</body>