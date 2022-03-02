<?php
	include 'dbh.p.php';
	
	$sql = "SELECT COUNT(assigned_to) as total FROM `issue` WHERE assigned_to = ".$_SESSION['userId']." AND issue_status = 0";
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		if(isset($_SESSION['userId'])){
			echo 'session is live';
		}else{
			echo 'session is not live';
		}
	}else{
		$result = mysqli_query($conn, $sql);
		
		$total = mysqli_fetch_assoc($result);
		
		echo $total['total'];
	}
	
?>