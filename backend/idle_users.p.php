<?php
	include 'dbh.p.php';
	
	//SELECT * FROM `users` WHERE users.users_id NOT IN (SELECT assigned_user FROM `reports`) AND role != 'head'AND role != 'admin' code for selecting all the data of the users`
	
	$sql = "SELECT count(users_id) as total FROM `users` WHERE users.users_id NOT IN (SELECT assigned_user FROM `reports`) AND role != 'head'AND role != 'admin'";
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo 'error connecting to server';
	}else{
		$result = mysqli_query($conn, $sql);
		
		$total = mysqli_fetch_assoc($result);
		
		echo $total['total'];
	}
	
?>