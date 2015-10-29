<?php
include("config.php");
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
		$query = "SELECT userid FROM users WHERE userid='$userID'";
		$result=pg_query($db, $query);
		$row=pg_fetch_row($result);
		$count=pg_num_rows($result);
		if($count==1)
		{
			echo '<script type="text/javascript">alert("Sorry the userID has already been taken, please select a different one");</script>';
		}
		else 
		{
			
			$result = pg_prepare($db, "add_user", 'insert into users values($1, $2, $3, $4, $5, $6)');
			$result = pg_execute($db, "add_user", array($userID, $username, $department, $password, $email, $year));
			if($result != false){
				$_SESSION['login_user']=$userID;
				header("location: welcome.php");
			}
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
<body>

<div class="jumbotron">
	  	<h1	>Welcome to Survey Portal</h1>
	</div>
	<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Please enter your details to Register</h3>
  </div>
  <div class="panel-body">
	<form action="register.php" method="post">
	<label>UserID :</label>
	<input type="text" class="form-control" name="userID"/><br />
	<label>User Name :</label>
	<input type="text" class="form-control" name="username"/><br />
	<label>Password :</label>
	<input type="password" class="form-control" name="password"/><br/>
	<label>Department :</label>
	<input type="text" class="form-control" name="department"/><br />
	<label>Year :</label>
	<input type="text" class="form-control" name="year"/><br />
	<label>Email :</label>
	<input type="text" class="form-control" name="email"/><br />
	<input type="submit" class="btn btn-primary btn-lg" value=" Submit "/><br />
	</form>
  </div>
</div>
</body>
</html>