<?php 

//$file_name = "twitter-logo-small.jpg";

// $img = fopen($file_name, 'r') or die("cannot read image\n");
// $data = fread($img, filesize($file_name));

// $es_data = pg_escape_bytea($data);
// fclose($img);

// 	echo "here";
// if ($_FILES['pic']['error'] == UPLOAD_ERR_OK               //checks for errors
//       && is_uploaded_file($_FILES['pic']['tmp_name'])) { //checks that file is uploaded
// 	echo "here1";
//   echo file_get_contents($_FILES['pic']['tmp_name']); 
// }

// $data=file_get_contents($_FILES['pic']['tmp_name']);

// $es_data = bin2hex($data);

// $query = "INSERT INTO images(id, data) Values('6', decode('{$es_data}' , 'hex'))";
// pg_query($con, $query); 

   $aExtraInfo = getimagesize($_FILES['image']['tmp_name']);  
    $sImage = "data:" . $aExtraInfo["mime"] . ";base64," . base64_encode(file_get_contents($_FILES['image']['tmp_name']));
    echo '<p>The image has been uploaded successfully</p><p>Preview:</p><img src="' . $sImage . '" alt="Your Image" />';
  // Convert to binary and send to the browser
  include('a.php');
  header("Content-type: text/html");
  

?>


<html>
<head>
	<title>image page</title>
</head>
<body>
  <img src=""/>
	<form action="insert_image.php" method="post" enctype="multipart/form-data">
	  <input type="file" name="pic" accept="image/*">
	  <input type="submit">
</form>
</body>
</html>
