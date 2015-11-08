<?php
include("user.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);    
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	// username and password sent from Form
	$userID=pg_escape_string($_POST['userID']); 
	$username=pg_escape_string($_POST['username']); 
	$password=pg_escape_string($_POST['password']); 
	$department=pg_escape_string($_POST['department']); 
	$year=pg_escape_string($_POST['year']); 
	$email=pg_escape_string($_POST['email']); 


	if(empty($userID)){
		echo '<script type="text/javascript">alert("Please select an user id");</script>';
	}
	else if(empty($username)){
		echo '<script type="text/javascript">alert("Please select an user name");</script>';
	}
	else if(empty($password)){
		echo '<script type="text/javascript">alert("Please select a password");</script>';
	}
	else if(empty($department)){
		echo '<script type="text/javascript">alert("Please select a department");</script>';
	}
	else if(empty($email)){
		echo '<script type="text/javascript">alert("Please select an email");</script>';
	}
	else{
		$user = new User();
		$checkUID = $user->checkUID($userID);
		if($checkUID==1)
		{
			$addUser = $user->addUser($userID, $password, $username, $department, $year, $email);
			if($addUser == 1){
				$_SESSION['login_user']=$userID;
				header("location: welcome.php");
			}
			else{
				echo '<script type="text/javascript">alert("An error occured during registration please try again");</script>';		
			}
		}
		else 
		{
			echo '<script type="text/javascript">alert("Sorry the userID has already been taken, please select a different one");</script>';
		}
	}
}
?>


<html>
<head>
	<title>
		Register
	</title>
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
</head>
<style type="text/css">
	.panel-title, .jumbotron {
		text-align: center;
	}
	.panel-body {
		padding: 30px;
	}
</style>
<body>

<div class="jumbotron">
	  	<h1	>Welcome to Survey Portal</h1>
	</div>
	<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Please enter your details to Register</h3>
  </div>
  <div class="panel-body">
	<form action="register.php" method="post" class = "form-horizontal">
	<div class="form-group">	
		<label>UserID* :</label>
		<input type="text" class="form-control" name="userID"/><br />
		<label>User Name* :</label>
		<input type="text" class="form-control" name="username"/><br />
		<label>Password* :</label>
		<input type="password" class="form-control" name="password"/><br/>
		<label>Department* :</label>
		<input type="text" class="form-control" name="department"/><br />
		<label>Year* :</label>
		<input type="text" class="form-control" name="year"/><br />
		<label>Email* :</label>
		<input type="text" class="form-control" name="email"/><br />
		<input type="submit" class="btn btn-primary btn-lg" value=" Submit "/><br />
	</div>
	</form>
  </div>
</div>
</body>
</html>