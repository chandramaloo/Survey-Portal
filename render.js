var formName = "Sample Form";
var quesArr = ['q1','Q2','Q3','q4'];
var typeArr = ['1','2','3','4'];
var optArr = [['O11','O12','O13'],['O21','O22','O23'],['o31','o32'],[]];

function renderForm(){
	var str = "<h1>" + formName + "</h1>";
	for(var i = 0; i<quesArr.length; i++){
		str += "Question " + (i+1) + ":<br>" + quesArr[i] + "<br>";
		switch(typeArr[i]){
			case '1':str += "Options:<ul>"
  				for(var j=0; j<optArr[i].length; j++){
  					str += "<li><input type='radio' name='inp-" + (i+1) +"' value='" + j + "'>" + optArr[i][j] +"</li>";
  				}
  				str += "</ul>";
				break;
			case '2':str += "Options:<select>"
  				for(var j=0; j<optArr[i].length; j++){
  					str += "<option name='inp-" + (i+1) +"' value='" + j + "'>" + optArr[i][j] +"</option>";
  				}
  				str += "</select>";
				break;
			case '3':
				str += "Options:<ul>"
  				for(var j=0; j<optArr[i].length; j++){
  					str += "<li><input type='checkbox' name='inp-" + (i+1) +"' value='" + j + "'>" + optArr[i][j] +"</li>";
  				}
  				str += "</ul>";
				break;
			case '4':
				str += "<input type='text' id='inp-" + (i+1) +"' class='form-control'>"
				break;
			case '5':
				break;
			case '6':
				break;
			default:
				break;
		}
		str += "<br><br>";
	}
	str += "<input type='submit' class='btn btn-success' value='Complete Survey'>";
	$("#main-form").html(str);
};
