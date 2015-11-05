<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript" src="jquery.js"></script>
	<script type="text/javascript" src="render.js"></script>
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
	<title>Create Survey</title>
</head>
<body style="margin:20px;">
	<div id="main-cont">
		<form id='main-form' action='submit.php' method="POST">
			
		</form>
	</div>

<!-- <div id="ques-done">
  </div>
  <div id="ques-active">
    <div id="ques-type">
      Active Question:<br><br>
      Question Type: <select id='ques-selector'>
      <option value='0'>select</option>
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
-->
<script type="text/javascript">
  renderForm();
</script>
</body>
</html>