<?php

error_reporting(0); // disable warnings
$code = $_POST["code"];

/* checks post got an code */
if (!isset($code) || $code == null) {
  header('Location: ../index.php');
}

/* connection to db */
require_once '../assets/php/db.php';
$conn = openDB();

/* table inputs (surveys) */
$surveyquery = $conn->prepare("SELECT code, question, questionid, created_at FROM surveys WHERE code = ?"); // prepare db (against injection)
$surveyquery->bind_param("i", $code); // replace integer (code) to var ($code)
$surveyquery->execute();
$surveyquery->store_result(); // returns a buffered result object from surveyquery

/* checks the code and creates variables from result */
if ($surveyquery->num_rows() > 0) { // amount
  $surveyquery->bind_result($code_survey, $question_survey, $questionid_survey, $created_at_survey);
  while ($surveyquery->fetch()) { // while page can use this variables
    if ($code_survey = $code) { // code (form) = code (db)
       /* TODO: echo html code */
      echo  "questionID: " . $questionid_survey . "<br> question: " . $question_survey . "<br> created_at: " . $created_at_survey . "<br> <br>"; // debug
    }
  }
} else {
  /* couldn´t find the code */
  header('Location: ../index.php');
}


#TODO: Insert methode erstellen

$surveyquery->close();








closeDB($conn);
