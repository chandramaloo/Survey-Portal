var count = 0;

function addQuestion(){
	count++;
	$ques = $("#ques-active-cont");
	var $quesNew = 	"Active Question<br><br>Question " + count + ":<br>" +
		"Question Type: <select id='ques-selector'>" +
  "<option value='0'>--select--</option>" + 
  "<option value='1'>MCQ-Radio</option>" + 
  "<option value='2'>MCQ-Select</option>" + 
  "<option value='3'>MCQ-Checkbox</option>" + 
  "<option value='4'>Text</option>" + 
  "<option value='5'>MCQ-Radio-Image</option>" + 
  "<option value='6'>MCQ-Checkbox-Image</option>" + 
  "</select>" +
  "<br><br>";
	$ques.html($quesNew);
	$("body").on("change","#ques-selector",function(){
  	 	setQuestionType($("#ques-selector").val());
	});
	$("#add-ques-btn").attr("disabled", true);
};

function setQuestionType(type){
	$ques = $("#ques-active-cont");
	switch(type){
		case '0': 
			$ques.html($ques.html() + "");
			break;
		case '1':
		case '2':
		case '3':
			$ques.html($ques.html() + "Question Text <input id='ques-text' type='text' class='form-control'/><br>"+
			"Semicolon separated Options <input id='ques-options' type='text' class='form-control'><br>" +
			"<input type='button' class='btn btn-primary' onclick='freezeQuestion("+ type +")' value='Freeze this Question'><br><br>");
			break;
		case '4':
			$ques.html($ques.html() + "Question Text <input id='ques-text' type='text' class='form-control'/><br>"+
			"<input type='button' class='btn btn-primary' onclick='freezeQuestion("+ type +")' value='Freeze this Question'><br><br>");
			break;
		case '5':

			break;
		default:
			break;
	}
};

function freezeQuestion(type){
	$ques = $("#ques-done-cont");
	var $quesNew = "";
	switch(type){
		case 1:
		case 2:
		case 3:
			$quesNew = "Question " + count + ": " + document.getElementById("ques-text").value +
			"<br> Options: " + document.getElementById("ques-options").value + "<br><br>";
			break;
		case 4:
			$quesNew = "Question " + count + ": " + document.getElementById("ques-text").value +
			"<br><br>";
			break;
		default:
			break;
	}
	$("#ques-active-cont").html("");
	$ques.html($ques.html() + $quesNew);	
	$("#add-ques-btn").removeAttr("disabled");
};