<?php
	include 'dbh.p.php';

	$sql = "SELECT count(*) as total FROM `issue` WHERE (day(date_created) = day(now()) AND month(date_created) = month(now()) AND YEAR(date_created) = YEAR(now())) or assigned_to is null";
	$stmt = mysqli_stmt_init($conn);

	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo 'error connecting to the database';
	}else{
		$result = mysqli_query($conn, $sql);
		$total = mysqli_fetch_array($result);

		echo $total['total'];
	}
?>