<?php 

$host = "localhost"; 
$user = "admin"; 
$pass = "db"; 
$db = "dbAppln"; 

$con = pg_connect("host=$host dbname=$db user=$user password=$pass")
    or die ("Could not connect to server\n");

//$file_name = "twitter-logo-small.jpg";

// $img = fopen($file_name, 'r') or die("cannot read image\n");
// $data = fread($img, filesize($file_name));

// $es_data = pg_escape_bytea($data);
// fclose($img);

if($_SERVER["REQUEST_METHOD"] == "POST"){
// 	echo "here";
// if ($_FILES['pic']['error'] == UPLOAD_ERR_OK               //checks for errors
//       && is_uploaded_file($_FILES['pic']['tmp_name'])) { //checks that file is uploaded
// 	echo "here1";
//   echo file_get_contents($_FILES['pic']['tmp_name']); 
// }

$data=file_get_contents($_FILES['pic']['tmp_name']);

$es_data = bin2hex($data);

$query = "INSERT INTO images(id, data) Values('6', decode('{$es_data}' , 'hex'))";
pg_query($con, $query); 

$res = pg_query("SELECT encode(data, 'base64') AS data FROM images WHERE id='6'"); 
  $raw = pg_fetch_result($res, 'data');
 
  // Convert to binary and send to the browser
  header('Content-type: image/jpeg');
  echo base64_decode($raw);
}

pg_close($con); 

?>


<html>
<head>
	<title>image page</title>
</head>
<body>
	<form action="insert_image.php" method="post" enctype="multipart/form-data">
	  <input type="file" name="pic" accept="image/*">
	  <input type="submit">
</form>
</body>
</html>
