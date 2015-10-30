<?php
include("user.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	// username and password sent from Form
	$user_id=pg_escape_string($_POST['username']); 
	$password=pg_escape_string($_POST['password']); 

	$user = new User();
	$loginSuccess = $user->validateUser($user_id, $password); 
	if($loginSuccess == 1){
		$_SESSION['login_user']=$user_id;
		header("location: welcome.php");	
	}
	else{
		echo '<script type="text/javascript">alert("Your Login Name or Password is invalid");</script>';
	}
}
?>


<html>
<head>
	<title>
		Login Page
	</title>
	<style type="text/css">
	form{
		margin-left: 35%;
		margin-right: 35%;
		text-align: center;
	}

	div{
		text-align: center;
		border: 10%;
	}

	</style>
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
</head>
<body>

<div class="jumbotron">
	  	<h1	>Welcome to Survey Portal</h1>
	</div>
	<div>
  	<div class="panel-heading">
    	<h3 class="panel-title">Please enter your details to login</h3>
  	</div>
  	<div class="panel-body">
		<form action="login.php" method="post" class = "form-inline">
		<label>UserID :</label>
		<input type="text" class="form-control" name="username"/><br><br>
		<label>Password :</label>
		<input type="password" class="form-control" name="password"/><br/>
		<h6><a href="register.php">New User? Register Now!!</a></h6>
		<input type="submit" class="btn btn-primary btn-lg" value=" Submit "/><br />
		</form>
  	</div>
	</div>
</body>
</html>
