<?php 

$host = "localhost"; 
$user = "admin"; 
$pass = "db"; 
$db = "dbAppln"; 

$con = pg_connect("host=$host dbname=$db user=$user password=$pass")
    or die ("Could not connect to server\n");

$query = "SELECT data FROM images WHERE id='5'";
$res = pg_query($con, $query) or die (pg_last_error($con)); 

$data = pg_fetch_result($res, 'data');
$unes_image = pg_unescape_bytea($data);

$file_name = "woman2.jpg";
$img = fopen($file_name, 'w') or die("cannot open image\n");
fwrite($img, $unes_image) or die("cannot write image data\n");
fclose($img);

pg_close($con); 

?>