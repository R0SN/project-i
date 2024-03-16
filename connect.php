<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "home_service";

$con = mysqli_connect($server, $username, $password, $database);

if (!$con) {
  die("Connection to database failed: ");
}
?>