<?php
	include 'dbh.p.php';
	
	$sql = "UPDATE `issue` SET `assigned_to`= NULL,`date_due`= NULL  WHERE issue_id = ".$_GET['i']."";
	$stmt = mysqli_stmt_init($conn);
	
	mysqli_query($conn, $sql);
	
	$sql = "DELETE FROM `dates` WHERE date_identity = 'issue' AND report_issue_id = ".$_GET['i']."";
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo 'error connecting to the database';
	}else{
		mysqli_query($conn, $sql);
		
		header("Location:../assign_issue_reports.php?site=Unassigned%20Reports&update=undo");
		exit();
	}
?>