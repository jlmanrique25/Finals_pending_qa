<?php
	include 'dbh.p.php';
	
	$sql = "UPDATE `issue` SET `issue_status`= 1 WHERE issue_id = ".$_GET['i']."";
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo 'error connecting to the database';
	}else{
		mysqli_query($conn, $sql);
		
		header("Location:../issue_report.php?i_id=".$_GET['i']."&Generator%20set%20II&update=undo");
		exit();
	}
?>