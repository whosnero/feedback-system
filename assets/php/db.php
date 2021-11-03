<?php

function openDB()
{
    $conn = mysqli_connect("localhost", "root", "", "feedo") or die("Connection to database failed!");
    return $conn;
}

function closeDB($conn)
{
    $conn->close();
}

function generateCode($min, $max)
{
    $co = openDB();
    /* table inputs (surveys, responses) */
    $codequery = $co->prepare("SELECT surveys.code, responses.code FROM surveys, responses;"); // prepare db (against injection)
    $codequery->execute();
    $codequery->store_result(); // returns a buffered result object from codequery

    $gCode = random_int($min, $max);
    $data = array();

    /* checks the code and creates variables from result */
    $codequery->bind_result($dbcodes, $dbcodes2);
    while ($codequery->fetch()) { // while page can use this variables
        $data[] = $dbcodes; // adds the current codes to an array
        $data[] = $dbcodes2; // adds the current codes to an array
    }

    /* check db (array) if code already exist */
    while (in_array($gCode, $data)) {
        $gCode = random_int($min, $max);
    }

    $codequery->close();

    closeDB($co);

    return $gCode;
}
