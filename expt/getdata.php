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
	// $id = $_POST['img-id'];
	// $data=file_get_contents($_FILES['opt-image']['tmp_name']);
	// echo "Success";
	// $es_data = bin2hex($data);
	 $imagename=$_FILES["myimage"]["name"]; 

//Get the content of the image and then add slashes to it 
	$imagetmp=addslashes(file_get_contents($_FILES['myimage']['tmp_name']));
	$imagetmp = base64_encode($imagetmp);
	echo $imagetmp;
	echo $imagename;
	$result = pg_query($con ,"INSERT into image_table values('".$imagename."','".$imagetmp."')");
}

//Insert the image name and image content in image_table
//$insert_image="INSERT INTO image_table VALUES('$imagetmp','$imagename')";

//mysql_query($insert_image);
?>