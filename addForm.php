<head>
<link rel="stylesheet" type="text/css" href="bootstrap.min.css">

</head>
<body>
<form name = "form" action="confirmUser.php" method="post" class="form-horizontal" onsubmit="return validateForm()">
Form Name: &nbsp; &nbsp;<input type="text" name="form_name" id = 'form_name'>
<br><br>

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
Anonymity: 
<input type="radio" name="anonymity" value="yes" checked="true">Yes
<input type="radio" name="anonymity" value="no">No	

<br><br>

Start Date: &nbsp; &nbsp;<input type="text" name="Start Date" value="<?php echo date('Y-m-d'); ?>" /><br><br>
Start Date: &nbsp; &nbsp;<input type="text" name="End Date" value="<?php echo date('Y-m-d'); ?>" />

<br><br>

<input type="submit" id = "submit" value = "Confirm Selection"/><br />
</form>
<script type="text/javascript">
	function validateForm() {
    var x = document.forms["form"]["form_name"].value;
    if (x == null || x == "") {
        alert("Name must be filled out");
        return false;
    }

	var eligible_count = document.querySelectorAll('input[type="checkbox"]:checked').length;
   	if(eligible_count == 0) {
   		alert("Please select atleast one user to participate in the form");
   		return false;
   	}


   	/*var selected_users = count($_POST['select']);
    if(selected_users == 0){
    	return false;
    }*/
}
</script>
</body>