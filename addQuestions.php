<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);    
include('lock.php');
include('user.php');
session_start();
$selected_users = count($_POST['select']);
echo $selected_users;

$selected_users = count($_POST['select']);
$user = new User();

echo "<table>";
for($i = 0; $i < $selected_users; $i++) {
  	$userid = pg_escape_string($_POST['select'][$i]); // Secures It
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
?>
<form action="login.php" method="post" class = "form-inline">
