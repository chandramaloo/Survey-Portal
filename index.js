var count = 0;
var type;
var quesArr = [];
var compArr = [];
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

  var startDate = document.forms["form"]["start_date"].value;
  var date_pattern = /....-..-.. ..:..:../g;
  var result = date_pattern.test(startDate);
  if (result == false){
    alert("Enter the Start Date in YYYY-MM-DD HH:mm:ss format");
    return false;
  }

  var endDate = document.forms["form"]["end_date"].value;
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
  console.log(optArr);
 
  $("#questions").val(window.JSON.stringify(quesArr));
  $("#optionArray").val(window.JSON.stringify(optArr));
  $("#question_types").val(window.JSON.stringify(typeArr));
  $("#compulsory").val(window.JSON.stringify(compArr));

};

function submitForm(){
};

function addOption(){
	$("#opt-freeze").show();
	$("#opt-add").attr("disabled", true);
	$("#opt-text").show();
	if(type=="6" || type=="5"){
		$("#opt-img").show();	
	}
};

function freezeOption(){
	if($("#opt-text").val()==""){
		alert("Option Text cannot be empty");
		return;
	}
	if(type=="5" || type=="6"){
		$("#img-id").val($("#time").val() + quesArr.length + tempOptArr.length);
		$.ajax({
		    type: "POST",
		    url: "insert_image.php",
		    data: new FormData($('[name="form"]')[0]),
		    processData: false,
		    contentType: false,
		    success: function (data) {
		        alert(data);
		    }
		});	
	}
	tempOptArr.push($("#opt-text").val());
	$("#opt-add").removeAttr("disabled");
	var str = "";
	if(tempOptArr.length != 0){
		str += "Options:<ul>";
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
	$("#opt-add").removeAttr("disabled");
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
	$("#ques-comp-inp").attr('checked', false);
	$("#ques-selector").val("0");
	$("#ques-text").hide();
	$("#ques-comp").hide();
	$("#ques-foot").hide();
};


function setQuestionType(){
	$("#ques-foot").show();
	clearOptions();
	$("#ques-text").show();
	$("#ques-comp").show();
	$("#opt-add").show();
	if(type=='4'){
		$("#opt-add").hide();
	}
	if(type=='0'){
		$("#ques-text").val("");
		$("#ques-comp-inp").attr('checked', false);
		$("#ques-text").hide();
		$("#ques-comp").hide();
		$("#ques-foot").hide();		
	}			
};

function freezeQuestion(){
	if($("#ques-text").val()==""){
		alert("Question Text cannot be empty");
		return;
	}
	if(type!='4' && tempOptArr.length==0){
		alert("At least one option should be there");
		return;
	}
	quesArr.push($("#ques-text").val());
	if($("#ques-comp-inp").is(":checked"))
		compArr.push('1');
	else compArr.push('0');
	typeArr.push(type);
	optArr.push(tempOptArr);
	var str = "<b>Submitted Questions:</b><br>";
	for(var i = 0; i < quesArr.length; i++){
		str += "Question " + (i+1) + ": " + quesArr[i] + "<br>";
		if(compArr[i] == '1') str += "*required<br>";
		if(optArr[i].length != 0){
			str += "Options:<ul>";
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