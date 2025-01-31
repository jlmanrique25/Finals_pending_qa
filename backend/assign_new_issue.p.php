<?php
	session_start();
	include 'dbh.p.php';

	if(isset($_POST['submit'])){
		date_default_timezone_set('Asia/Hong_Kong');
		$d_date = ($_POST['dueDate']);
		$i_id = ($_POST['i_id']);
		$u_id = ($_POST['assignedTo']);
		$i = "issue";
		$t = "created";
		$date = $time_submitted = date('Y-m-d h:i:s a', time());

		$sql_dates = "INSERT INTO `dates`(`date_time`, `date_type`, `date_identity`, `report_issue_id`) VALUES (?,?,?,?)";
		$stmt = mysqli_stmt_init($conn);

		if(!mysqli_stmt_prepare($stmt, $sql_dates)){
			echo 'error connecting to the database dates';
		}else{
			mysqli_stmt_bind_param($stmt, "sssi", $date, $t, $i, $i_id);
			mysqli_stmt_execute($stmt);

			$sql_issues = "UPDATE `issue` SET `assigned_to`= ".$u_id.",`date_due`= '".$d_date."' WHERE issue_id = ".$i_id."";
			$stmt = mysqli_stmt_init($conn);

			if(!mysqli_stmt_prepare($stmt, $sql_issues)){
				echo $u_id, $d_date, $i_id;
				echo $sql_issues;
				//header('Location:../assign_issue_reports.php?site=Unassigned%20Reports&notsuccessful');
				exit();
			}else{
				$result = mysqli_query($conn,$sql_issues);

				header('Location:../n_issues.php?site=Unassigned%20Reports&update=success&u_id='.$u_id.'&$d='.$d_date.'&i='.$i_id.'');
				exit();
			}
		}

	}else{
		header("Location: ../n_issues.php?site=Unassigned%20Reports&error=invalidentry");
		exit();
	}


?>