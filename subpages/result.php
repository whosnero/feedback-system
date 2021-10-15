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

/* table inputs */
$query = $conn->prepare("SELECT questionid, valuation, created_at FROM responses WHERE code = ?"); // prepare db (against injection)
$query->bind_param("i", $code); // replace integer (code) to var ($code)
$query->execute();
$query->store_result(); // returns a buffered result object from query

/* checks the code and creates variables from result */
if ($query->num_rows() > 0) {
    $query->bind_result($questionid, $valuation, $created_at);
    while ($query->fetch()) { // page can use the variables
        /* TODO: echo html code */
        echo "code:" . $code . "<br> questionID: " . $questionid . "<br> valuation: " . $valuation . "<br> created_at: " . $created_at . "<br> <br>"; // debug
    }
} else {
    /* couldn´t find the code */
    header('Location: ../index.php');
}

$query->close();

closeDB($conn);
