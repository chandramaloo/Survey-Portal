var count = 0;
var type;
var quesArr = [];
var typeArr = [];
var optArr = [];
var tempOptArr = [];

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

  var startDate = document.forms["form"]["Start Date"].value;
  var date_pattern = /....-..-.. ..:..:../g;
  var result = date_pattern.test(startDate);
  if (result == false){
    alert("Enter the Start Date in YYYY-MM-DD HH:mm:ss format");
    return false;
  }

  var endDate = document.forms["form"]["End Date"].value;
  var date_pattern = /....-..-.. ..:..:../g;
  var result = date_pattern.test(endDate);
  if (result == false){
    alert("Enter the End Date in YYYY-MM-DD HH:mm:ss format" + endDate);
    return false;
  }
  
  var today = new Date();
  
  var stTimestamp = Date.parse(startDate);
  if (isNaN(stTimestamp)==false)
  {
    var start = new Date(startDate);
    if(start <= today){
      alert("The survey start date should be after the current time");
      return false;
    }
    var endTimestamp = Date.parse(endDate);
    if (isNaN(endTimestamp)==false)
    {
      var end = new Date(endDate);
      if(start >= end){
        alert("The survey end date should be after the start date");
        return false;
      }
    }
    else{
      alert ("The end date is invalid.")
      return false;
    }
  }
  else{
    alert ("The start date is invalid.")
    return false;
  }
  $("#questions").val(quesArr);
  $("#optionArray").val(optArr);
  $("#question_types	").val(typeArr);

};

function submitForm(){
	window.location.href= "addForm.php?questions="+quesArr+"&type="+typeArr+"&optArr="+optArr;
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
	$("#ques-selector").val("0");
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