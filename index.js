var count = 0;

var $quesNew = 	"Active Question:<br><br>" +
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

function submitForm(){
	// extract all questions
	// redirect to user home
};

function addOption(type){
	$("#add-opt-btn").attr("disabled", true);
	switch(type){
		case 1:
		case 2:
		case 3:
			$("#ques-opt-active").html("<input id='opt-text' type='text' class='form-control'/><br>");
			break;
		case 5:
		case 6:
			$("#ques-opt-active").html("<input id='opt-text' type='text' class='form-control'/><input type='file' accept='image/png, image/jpeg'>");
			break;
		default:
			break;
	}
	$("#ques-opt-foot").html("<input type='button' class='btn btn-primary' onclick='freezeOption("+ type 
		+")' value='Freeze this Option'><br><br>");
};

function freezeOption(type){
	$("#add-opt-btn").removeAttr("disabled");
	$("#ques-opt-foot").html("");
	$("#ques-opt-active").html("");
	switch(type){
		case 1:
		case 2:
		case 3:
			$("#ques-opt-done").html($("#ques-opt-done").html() + $("#opt-text").val());
			break;
		case 5:
		case 6:
			$("#ques-opt-done").html($("#ques-opt-done").html() + $("#opt-text").val() + $("#opt-img").val());
			break;
		default:
			break;
	}
}

function addQuestion(){
	count++;

	$("#ques-type").html($quesNew);
	$("body").on("change","#ques-selector",function(){
  	 	setQuestionType($("#ques-selector").val());
	});
	$("#add-ques-btn").attr("disabled", true);
};

function clearOptions(){
	$("#ques-opt-active").html("");
	$("#ques-opt-done").html("");
	$("#ques-opt-foot").html("");
}

function clearQuestions(){
	$("#ques-type").html("");
	$("#ques-text").html("");
	$("#ques-foot").html("");
};


function setQuestionType(type){
	$("#ques-foot").html("<input type='button' class='btn btn-primary' onclick='freezeQuestion("+ type 
		+")' value='Freeze this Question'><br><br>");
	$("#ques-selector").val(type);
	clearOptions();
	switch(type){
		case '0': 
			$("#ques-text").html("");
			$("#ques-foot").html("");
			break;
		case '1':
		case '2':
		case '3':
		case '5':
		case '6':
			$("#ques-text").html("Question Text <input id='ques-text' type='text' class='form-control'/><br>");
			$("#ques-foot").html("<input id='add-opt-btn' type='button' class='btn btn-success' onclick='addOption(" + type + ")'' value='Add Option'/><br>"+ $("#ques-foot").html());
			break;
		case '4':
			$("#ques-text").html("Question Text <input id='ques-text' type='text' class='form-control'/><br>");
			break;
		default:
			break;
	}
};

function freezeQuestion(type){
	switch(type){
		case 1:
		case 2:
		case 3:
			$("#ques-done").html($("#ques-done").html() + "Question " + count + ": " + document.getElementById("ques-text").value +
			"<br> Options: " + document.getElementById("ques-opt").value + "<br><br>");
			break;
		case 4:
			$("#ques-done").html($("#ques-done").html() + "Question " + count + ": " + document.getElementById("ques-text").value +
			"<br><br>");
			break;
		case 5:
		case 6:
			break;
		default:
			break;
	}
	clearOptions();
	clearQuestions();
	$("#add-ques-btn").removeAttr("disabled");
};
