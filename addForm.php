<head>
  <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
  <script type="text/javascript" src="jquery.js"></script>
  <script type="text/javascript" src="index.js"></script>
  
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

<div id="ques-done">
  </div>
  <div id="ques-active">
    <div id="ques-type">
      Active Question:<br><br>
      Question Type: <select id='ques-selector'>
      <option value='0'>--select--</option>
      <option value='1'>MCQ-Radio</option>
      <option value='2'>MCQ-Select</option>
      <option value='3'>MCQ-Checkbox</option>
      <option value='4'>Text</option>
      <option value='5'>MCQ-Radio-Image</option>
      <option value='6'>MCQ-Checkbox-Image</option>
      </select>
      <br><br>
    </div>
    <div id="ques-text-cont">
      <input id='ques-text' type='text' class='form-control' placeholder='Question Text'/><br>
    </div>
    <div id="ques-opt">
      <div id="ques-opt-done">
        
      </div>
      <div id="ques-opt-active">
        <input type='text' id='opt-text' class='form-control'/><br>
        <input type='file' id='opt-img' accept='image/png, image/jpeg'>
        <input type='button' id="opt-freeze" class='btn btn-primary' onclick='freezeOption()' value='Freeze this Option'><br><br>
        <input type='button' id='opt-add' class='btn btn-success' onclick='addOption()' value='Add Option'/><br>
      </div>
    </div>
    <div id="ques-foot">
      <input type='button' class='btn btn-primary' onclick='freezeQuestion()' value='Freeze this Question'><br><br>
    </div>
  </div>
  <input id='add-ques-btn' type="button" class='btn btn-success' onclick="addQuestion()" value="Add Question"/>
  <input id='done-btn' type="button" class='btn btn-success' onclick="submitForm()" value="Done"/>
<script type="text/javascript">
  clearOptions();
  clearQuestions();
</script>

</body>