<?php

# currently working on

error_reporting(0); // disable warnings
$code = $_POST["code"];

/* checks post got an code */
if (!isset($code) || $code == null) {
  header('Location: ../index.php');
}

/* connection to db */
require_once '../assets/php/db.php';
$conn = openDB();

/* table inputs (sample_questions) */
$samplequery = $conn->prepare("SELECT id, question FROM sample_questions"); // prepare db (against injection)
$samplequery->execute();
$samplequery->store_result(); // returns a buffered result object from samplequery

/* checks result and creates variables from result */
if ($samplequery->num_rows() > 0) { // amount
  $samplequery->bind_result($questionid_sample, $question_sample);
  while ($samplequery->fetch()) { // while page can use this variables
    /* TODO: echo html code */
    echo "questionid:" . $questionid_sample . "<br> question: " . $question_sample . "<br> <br>"; // debug
  }
} else {
  /* no result (db=sample_question) */
  header('Location: ../index.php');
}

$samplequery->close();


closeDB($conn);
