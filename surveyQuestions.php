<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class surveyQuestions{
	private $db;
	
	function __construct() {
		$host = "host=localhost";
		$dbname = "dbname=dbAppln";
		$credentials = "user=admin password=db";
		$this->db = pg_connect("$host $dbname $credentials");
	}

   	public function insertSurveyQuestion($form_id, $question_id, $ques_type, $ques_compulsory, $ques_content, $ques_options){
   		$result = pg_prepare($this->db, "add$question_id", "INSERT into survey_questions values($1, $2, $3, $4, $5, $6, $7)");
  		$result = pg_execute($this->db, "add$question_id", array($form_id, $question_id, $ques_type, NULL, $ques_compulsory, $ques_content, $ques_options));
   	}
}
?>
