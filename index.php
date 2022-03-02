<?php
	session_start();
	if(!isset($_SESSION['role'])){
		header("Location: login.php");
		exit();
	}else if ($_SESSION['role'] == "Head"){
		include 'header.php';
		include 'dashboard.php';
	}else if($_SESSION['role'] == "Admin"){
		include 'header.php';
		include 'dashboard.php';
	}else if($_SESSION['role'] == "Technician"){
		include 'tasks.php';
	}
?>