<?php

function open() {
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "feedo";


    $connection = new mysqli($host, $user, $pass, $db) or die("Connect failed: %s\n" . $connection->error);

    return $connection;
}



function close($connection) {
    $connection->close();
}
