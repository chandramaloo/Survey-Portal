<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);    
include('lock.php');
?>
<body>
<h1>Welcome <?php echo $_SESSION['login_user']; ?></h1>
<form action="logout.php" method="post">
	<input type="submit" value=" Logout "/><br />
</form>
</body>