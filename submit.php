<head>
<link rel="stylesheet" type="text/css" href="bootstrap.min.css">

</head>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);    
include('lock.php');

$user_id=$_SESSION['login_user'];
$form_id=$_SESSION['submitted_forms'];


//check that the user was privelege = 0 and status = 0 on that form_id also implement that the time should be in the limits, FUNCTION in ROLE




?>
