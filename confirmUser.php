<head>
<link rel="stylesheet" type="text/css" href="bootstrap.min.css">

</head>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);    
include('lock.php');
include('user.php');
$selected_users = count($_POST['select']);
echo $selected_users;

$selected_users = count($_POST['select']);
$user = new User();

echo "<table class=\"table table-hover\">";
for($i = 0; $i < $selected_users; $i++) {
  	$userid = pg_escape_string($_POST['select'][$i]);
  	//$userid = $_POST['select'][$i];
    $row = $user->getUser($userid);
    
    print 
    "<tr>
    <td>$row[0]</td>
    <td>$row[1]</td>
    <td>$row[2]</td>
    </tr>";

}
echo "</table>";
echo $_POST['questions'];
echo "<br>";
echo $_POST['question_types'];
echo "<br>";
$options = $_POST['optionArray'];
//var_dump($options);
echo "<br>";
echo $options;
//$options = trim($options, '""');
//echo "<br>";
//echo $options;
$options = explode("]", $options);
echo "<br>";
echo substr($options[0], 2);
echo "<br>";
echo substr($options[1], 2);
$user_id = $_SESSION['login_user'];
echo $user_id.time();

?>
<form action="addQuestions.php" method="post" class = "form-inline">
<input type = "submit" value = "Proceed to Add Questions" name = "submit">
</form> 