<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);    
include('lock.php');
$selected_users = count($_POST['select']);
echo $selected_users;

$query = pg_prepare($db, "display_user", 'SELECT * FROM users WHERE user_id = $1') ;

$selected_users = count($_POST['select']);

echo "<table>";
for($i = 0; $i < $selected_users; $i++) {
  $userid = pg_escape_string($_POST['select'][$i]); // Secures It
  //$userid = $_POST['select'][$i];
  $result = pg_execute($db, "display_user", array($userid));
	while ($row = pg_fetch_row($result)) {
	    print 
	    "<tr>
	    <td>{$row[0]}</td>
	    <td>{$row[2]}</td>
	    <td>{$row[3]}</td>
	    </tr>";
	}
}

echo "</table>";
?>
