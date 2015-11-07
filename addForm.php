<head>
  <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
  <script type="text/javascript" src="jquery.js"></script>
  <script type="text/javascript" src="index.js"></script>
  
</head>
<body>
<div class="panel panel-primary" style="border-radius: 15px">
  <div class = "panel-heading" style = "padding-left:5px;margin-top:-20px;text-align:center;">
      <h3 style = "margin-bottom:5px;">Form Details</h3>
  </div>
<div class="panel-body">
<form name = "form" action="FormAdd.php" method="post" enctype="multipart/form-data" class="form-group" onsubmit="return validateForm()">
Form Name: &nbsp; &nbsp;<input type="text" class = "form-control" name="form_name" id = "form_name" placeholder = "Enter your form name">
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
$time = time();
?>

Anonymity: 
<input type="radio" name="anonymity" value='1' checked="true">Yes
<input type="radio" name="anonymity" value='0'>No	

<br><br>

Start Date: &nbsp; &nbsp;<input type="text" name="start_date" id = "start_date" value="<?php echo date('Y-m-d H:m:s'); ?>" />&nbsp; &nbsp; &nbsp; &nbsp; End Date: &nbsp; &nbsp;<input type="text" name="end_date" id = "end_date" value="<?php echo date('Y-m-d H:m:s'); ?>" />

<br><br>

</div>
</div>

<div class = "panel panel-primary">
<div class = "panel-heading" style = "padding-top:5px;text-align:center;">
    <h3 style = "margin-top:0px;margin-bottom:5px;">Survey Questions</h3>
</div>
<div class = "panel-body">
<div id="ques-done">
</div>
  <div id="ques-active">
    <div id="ques-type">
      <b>Active Question:</b><br>
      Question Type: <select id='ques-selector'>
      <option value='0'>--select--</option>
      <option value='1'>MCQ-Radio</option>
      <option value='2'>MCQ-Select</option>
      <option value='3'>MCQ-Checkbox</option>
      <option value='4'>Text</option>
      <option value='5'>MCQ-Radio-Image</option>
      <option value='6'>MCQ-Checkbox-Image</option>
      </select>
      &nbsp; &nbsp;
      <span id='ques-comp'><input id='ques-comp-inp' type='checkbox'/>&nbsp; Make it compulsory<br></span>
      <br>
    </div>
    <div id="ques-text-cont">
      <input id='ques-text' type='text' class='form-control' placeholder='Question Text'/><br>
    </div>
    <div id="ques-opt">
      <div id="ques-opt-done">
      </div>
      <div id="ques-opt-active">
        <input type='text' id='opt-text' class='form-control' placeholder='Option Text'/><br>
        <input type='file' id='opt-img' name='opt-image' accept='image/png, image/jpeg'/>
        <input type='button' id="opt-freeze" class='btn btn-primary' onclick='freezeOption()' value='Freeze this Option'><br><br>
      </div>
    </div>
    <div id="ques-foot">
      <input type='button' id='opt-add' class='btn btn-success' onclick='addOption()' value='Add Option'/>
      <input type='button' class='btn btn-primary' onclick='freezeQuestion()' value='Freeze this Question'><br><br>
    </div>
  </div>
  <input id='add-ques-btn' type="button" class='btn btn-success' onclick="addQuestion()" value="Add Question"/>
  <input type = "hidden" name = "time" id = "time" value=<?php echo '"'.$time.'"'?>/> 
  <input type = "hidden" name = "img-id" id = "img-id"/> 
  <input type = "hidden" name = "questions" id = "questions"/> 
  <input type = "hidden" name = "optionArray" id = "optionArray"/> 
  <input type = "hidden" name = "question_types" id = "question_types"/> 
  <input type = "hidden" name = "compulsory" id = "compulsory"/> 
<script type="text/javascript">
  clearOptions();
  clearQuestions();
</script>
</div>
</div>
 &nbsp; <input type="submit" class="btn btn-success" id = "submit" value = "Submit Form" style="text-align:center;"/>
</form> 
<br>
<br>
</body>