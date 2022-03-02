<?php
	include 'dbh.p.php';
	
	$sql = "UPDATE `issue` SET `issue_status` = '0' WHERE `issue`.`issue_id` = ".$_GET['id']."";
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo 'error';
	}else{
		mysqli_query($conn, $sql);
		
		header('Location: ../issue_report.php?i_id='.$_GET['id'].'&redo=success');
		exit();
	}
?>