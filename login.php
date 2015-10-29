<?php
include("config.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);    
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	// username and password sent from Form
	$myusername=pg_escape_string($_POST['username']); 
	$mypassword=pg_escape_string($_POST['password']); 

	$query = "SELECT userid FROM users WHERE userid='$myusername' and password ='$mypassword'";
	$result=pg_query($db, $query);
	$row=pg_fetch_row($result);
	$active=$row[0];
	$count=pg_num_rows($result);


	// If result matched $myusername and $mypassword, table row must be 1 row
	if($count==1)
	{
		//session_register("myusername");
		$_SESSION['login_user']=$myusername;
		header("location: welcome.php");
	}
	else 
	{
		$error="Your Login Name or Password is invalid";
	}
}
?>


<html>
<head>
	<title>
		Login Page
	</title>
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
</head>
<body>

<div class="jumbotron">
	  	<h1	>Welcome to Survey Portal</h1>
	</div>
	<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Please enter your details to login</h3>
  </div>
  <div class="panel-body">
	<form action="login.php" method="post">
	<label>UserID :</label>
	<input type="text" class="form-control" name="username"/><br />
	<label>Password :</label>
	<input type="password" class="form-control" name="password"/><br/>
	<h6><a href="register.php">New User? Register Now!!</a></h6>
	<input type="submit" class="btn btn-primary btn-lg" value=" Submit "/><br />
	</form>
  </div>
</div>
</body>
</html>