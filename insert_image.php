<?php 

$host = "localhost"; 
$user = "admin"; 
$pass = "db"; 
$db = "dbAppln"; 

ini_set('display_errors', 1); 
error_reporting(E_ALL);

$con = pg_connect("host=$host dbname=$db user=$user password=$pass")
    or die ("Could not connect to server\n");

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$id = $_SESSSION['login_user'].$_POST['img-id'];
	$data=file_get_contents($_FILES['opt-image']['tmp_name']);
	echo "Success";
	$es_data = bin2hex($data);

	$result = pg_prepare($con, "add-image", "INSERT into images values($1, decode('{$es_data}' , 'hex'))");
	$result = pg_execute($con, "add-image", array($id));
} else{
	echo "Failure";
}
pg_close($con); 
?>