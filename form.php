<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript" src="jquery.js"></script>
	<script type="text/javascript" src="index.js"></script>
	<link rel="stylesheet" type="text/css" href="bootstrap.min.css">
	<title>Create Survey</title>
</head>
<body style="margin:20px;">
	<div id="ques-done">
		Submitted Questions<br>
	</div>
	<div id="ques-active">
		<div id="ques-type">
			
		</div>
		<div id="ques-text">
			
		</div>
		<div id="ques-opt">
			<div id="ques-opt-done">
				
			</div>
			<div id="ques-opt-active">
				
			</div>
			<div id="ques-opt-foot">
				
			</div>
		</div>
		<div id="ques-foot">
			
		</div>
	</div>
	<input id='add-ques-btn' type="button" class='btn btn-success' onclick="addQuestion()" value="Add Question"/>
	<input id='done-btn' type="button" class='btn btn-success' onclick="submitForm()" value="Done"/>
</body>
</html>