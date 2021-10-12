<?php

error_reporting(0);
$code = $_POST["code"];
echo "Code: $code";

  include '../assets/php/db.php';
  $connection = open();

  echo "Connected Successfully";



  close($connection);


?>

<!-- currently working on 

<head>
  <meta http-equiv='refresh' content='0; URL=index.html'>
</head>
-->