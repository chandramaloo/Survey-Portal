var count = 0;
var type;
var quesArr = [];
var typeArr = [];
var optArr = [];
var tempOptArr = [];

function submitForm(){
	
};

function addOption(){
	$("#opt-freeze").show();
	$("#opt-add").attr("disabled", true);
	$("#opt-text").show();
	if(type=="6") $("#opt-img").show();
};

function freezeOption(){
	tempOptArr.push($("#opt-text").val());
	$("#opt-add").removeAttr("disabled");
	var str = "";
	if(tempOptArr.length != 0){
		str += "Options:<br><ul>";
		for(var opt in tempOptArr){
			str += "<li>" + tempOptArr[opt] + "</li>";
		}
		str += "</ul><br>";
	}
	$("#ques-opt-done").html(str);
	$("#opt-text").val("");
	$("#opt-img").val("");
	$("#opt-text").hide();
	$("#opt-img").hide();
	$("#opt-freeze").hide();
}

function addQuestion(){
	count++;
	$("#ques-type").show();
	$("body").on("change","#ques-selector",function(){
		type=$("#ques-selector").val();
  	 	setQuestionType();
	});
	$("#add-ques-btn").attr("disabled", true);
};

function clearOptions(){
	tempOptArr = [];
	$("#ques-opt-done").html("");
	$("#opt-text").val("");
	$("#opt-img").val("");
	$("#opt-text").hide();
	$("#opt-img").hide();
	$("#opt-freeze").hide();
	$("#opt-add").hide();
}

function clearQuestions(){
	$("#ques-type").hide();
	$("#ques-text").val("");
	$("#ques-text").hide();
	$("#ques-foot").hide();
};


function setQuestionType(){
	$("#ques-foot").show();
	clearOptions();
	$("#ques-text").show();
	$("#opt-add").show();
	if(type=='4') $("#opt-add").hide();
	if(type=='0'){
		$("#ques-text").val("");
		$("#ques-text").hide();
		$("#ques-foot").hide();		
	}			
};

function freezeQuestion(){
	quesArr.push($("#ques-text").val());
	typeArr.push(type);
	optArr.push(tempOptArr);
	var str = "Submitted Questions<br>";
	for(var i = 0; i < quesArr.length; i++){
		str += "Question " + (i+1) + ": " + quesArr[i] + "<br>";
		if(optArr[i].length != 0){
			str += "Options:<br><ul>";
			for(var opt in optArr[i]){
				str += "<li>" + optArr[i][opt] + "</li>";
			}
			str += "</ul>";
		}
		str += "<br>";
	}
	$("#ques-done").html(str);
	clearOptions();
	clearQuestions();
	$("#add-ques-btn").removeAttr("disabled");
};