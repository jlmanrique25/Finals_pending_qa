<?php
//setting database connections
$servername = "localhost";
$username = "root";
$password = "";
$db = "pending_project";

//establishing a database connection
$conn = new mysqli($servername, $username, $password, $db);

//checking connection
if($conn->connect_error){
	die("Connection Failed ".$conn->connect_error);
}

?>