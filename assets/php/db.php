<?php

function openDB()
{
    $conn = mysqli_connect("localhost", "root", "", "feedo") or die("Connection failed!");
    return $conn;
}

function closeDB($conn)
{
    $conn->close();
}
