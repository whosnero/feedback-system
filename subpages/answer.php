<?php

error_reporting(0); // disable warnings
$code = $_POST["code"];

/* checks if post got an code */
if (!isset($code) || $code == null) {
  header('Location: ../index.php');
}

/* connection to db */
require_once '../assets/php/db.php';
$conn = openDB();

$query = "SELECT * FROM survey";

// content foreach
foreach ($conn->query($query) as $row) {
  echo "";
}

closeDB($conn);