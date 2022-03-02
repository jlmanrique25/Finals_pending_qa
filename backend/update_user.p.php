<?php
	include 'dbh.p.php';
	
	if($_GET['role'] == "Technician"){
		$sql = "UPDATE `users` SET `role`= 'Admin' WHERE users_id =".$_GET['userid']."";
	}else{
		$sql = "UPDATE `users` SET `role`= 'Technician' WHERE users_id =".$_GET['userid']."";
	}
	
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		header('Location:../users.php?updatenotsuccessful&page=1&site=Users');
		exit();
	}else{
		$result = mysqli_query($conn,$sql);
		
		header('Location:../users.php?userrolechanged&page=1&site=Users');
		exit();
	}
	
?>