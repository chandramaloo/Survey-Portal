<head>
<link rel="stylesheet" type="text/css" href="bootstrap.min.css">

</head>
<body>
<form action="addQuestions.php" method="post" class="form-horizontal">
Form Name: &nbsp; &nbsp;<input type="text" name="form_name">
<br>
<br>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);    
include('lock.php');
include('user.php');
$user_id = $_SESSION['login_user'];
$user = new User();
$user->tabulateAllUsers();
?>
<br>
Anonymity: <input type="radio" name="anonymity" value="yes">Yes
<input type="radio" name="anonymity" value="no">No	
<br>
<br>
<input type="submit" value="Confirm Selection"/><br />
</form>
</body>