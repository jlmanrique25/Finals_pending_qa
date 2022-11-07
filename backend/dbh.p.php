<?php
//setting database connections
$servername = "us-cdbr-east-06.cleardb.net";
$username = "ba8ea00b7249f4";
$password = "52934ed3";
$db = "heroku_67414314b729d48";

//establishing a database connection
$conn = new mysqli($servername, $username, $password, $db);

//checking connection
if($conn->connect_error){
	die("Connection Failed ".$conn->connect_error);
}

?>
