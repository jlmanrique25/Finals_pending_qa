<?php
	include 'dbh.p.php';
	
	$sql = "SELECT count(*) as total FROM `issue` WHERE assigned_to is null or day(date_created) = day(now())";
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo 'error connecting to the database';
	}else{
		$result = mysqli_query($conn, $sql);
		$total = mysqli_fetch_array($result);
		
		echo $total['total'];
	}
?>