<?php
$hostName = "localhost";
$dbUser = "cs2team17";
$dbPassword = "C2VPKBl3NviP8GDYXNeQBypgm";
$dbName = "cs2team17_db";

$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>