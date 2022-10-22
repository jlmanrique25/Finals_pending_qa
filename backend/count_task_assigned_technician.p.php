<?php
	include 'dbh.p.php';
	
	$sql = "SELECT COUNT(assigned_user) as total FROM `reports` WHERE assigned_user = ".$_SESSION['userId']."";
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