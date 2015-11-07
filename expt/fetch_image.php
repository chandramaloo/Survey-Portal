<?php

header("content-type:image/jpeg");

$host = "localhost"; 
$user = "admin"; 
$pass = "db"; 
$db = "dbAppln"; 

ini_set('display_errors', 1); 
error_reporting(E_ALL);

$con = pg_connect("host=$host dbname=$db user=$user password=$pass")
    or die ("Could not connect to server\n");

	// $id = $_POST['img-id'];
	// $data=file_get_contents($_FILES['opt-image']['tmp_name']);
	// echo "Success";
	// $es_data = bin2hex($data);
	$name=$_GET['name'];
//	echo $name;
	$result = pg_prepare($con, "renderSachin", 'SELECT * FROM image_table WHERE imagename=$1');
	$result = pg_execute($con, "renderSachin", array($name));
	
	

	if($row = pg_fetch_row($result)){
		$image_name = $row[0];
		$image_content = base64_decode($row[1]);
	}

	echo $image_content;

?>