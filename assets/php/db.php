<?php

function openDB()
{
    $conn = mysqli_connect("localhost", "root", "", "praktikum") or die("Connection failed!");
    return $conn;
}

function insertDB($conn, $query)
{
    $conn->query($query) == TRUE or die("Failed to insert!");
}

function closeDB($conn)
{
    $conn->close();
}