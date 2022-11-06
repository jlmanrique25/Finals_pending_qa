<?php
	session_start();
	if(!isset($_SESSION['role'])){
		header("Location: login.php");
		exit();
	}else if ($_SESSION['role'] == "Head"){
		include 'dashboard.php';
	}else if($_SESSION['role'] == "Admin"){
		include 'dashboard.php';
	}else if($_SESSION['role'] == "Technician"){
		include 'tech_tasks_table.php';
	}
?>