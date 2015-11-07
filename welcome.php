<head>
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
	<style type="text/css">

	</style>
</head>
<?php
 ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);    
include('lock.php');
include('role.php');
$curr_user = $_SESSION['login_user'];
?>

<body style="margin:0px">
<div class = "panel panel-primary">
	<div class = "panel-heading">
		<h2 style ="margin-top: -5px;" >Welcome 
			<?php echo $_SESSION['login_user'];?></h2>
	</div>
	<br>
	<div class = "panel panel-default">
		<div class = "panel-heading" style="margin-top:-20px;"> <H3 style="padding-top:15px;margin-top:-15px; margin-bottom:0px; margin-left:-7px;">CURRENT RUNNING FORMS </H3></div>
		<div class = "panel panel-success">
			<div class = "panel-heading"><h4 style="margin-top:1px; margin-left:-7px;margin-bottom:5px"> Your Current Running Forms </h4></div>
			<?php
			$role = new Role();
			$role->adminForms($curr_user);
			?>
		</div>

		<div class = "panel panel-success">
			<div class = "panel-heading"> <h4 style="margin-top:1px; margin-left:-5px;margin-bottom:5px"> Forms For You To Fill: </h4></div>

			<?php
				$role->currentForms($curr_user);
			?>
		</div>

	</div>
	<div class = "panel-body">
		<button type="button" class="btn btn-info" onclick="location.href = 'addForm.php';" >Host a New Survey</button> 
		<button type="button" class="btn btn-danger" onclick="location.href = 'logout.php';" >LOGOUT</button> <br><br>
	</div>
</div>
</body>