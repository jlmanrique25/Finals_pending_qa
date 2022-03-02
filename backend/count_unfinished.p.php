<?php
	include 'dbh.p.php';
	
	$sql = "SELECT COUNT(report_status) as total FROM `reports` WHERE report_status = 'unresolved'";
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo 'error connecting to server';
	}else{
		$result = mysqli_query($conn, $sql);
		
		$total = mysqli_fetch_assoc($result);
		echo $total['total'];
	}
?>