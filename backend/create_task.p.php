<?php
session_start();
include 'dbh.p.php';

if(isset($_POST['submit']))
{
	date_default_timezone_set('Asia/Hong_Kong');
	$date_created = date('Y-m-d h:i:s a', time());
	$typeOfMachine = $_POST['typeOfMachine'];
	$taskDesc = $_POST['taskDesc'];
	$task = $_POST['task'];
	$assignedTo = $_POST['assignedTo'];
	$dueDate = $_POST['dueDate'];
	$created = "created";
	$report = "report";
	$due_date = "due date";
	$unresolved = "unresolved";
	$stmt = mysqli_stmt_init($conn);
	
	
	
	if($typeOfMachine == 'Genset'){
		$e_id = $_POST['gensetForm'];
	}else if($typeOfMachine == 'HVAC'){
		$e_id = $_POST['airconForm'];
	}
		
	
	$report_id = "SELECT report_id as last FROM reports ORDER BY report_id DESC LIMIT 1";

	

	if(!mysqli_stmt_prepare($stmt,$report_id)){
		header("Location: ../assign_new_task.php?site=Assign%20new%20task&error=getting%20%20last");
		exit();
	}else{
		$result_last = mysqli_query($conn, $report_id);
		$row_last = mysqli_fetch_assoc($result_last);
		$report_id = $row_last['last'] + 1;
		
		$d_created = "INSERT INTO `dates`( `date_time`, `date_type`, `date_identity`, `report_issue_id`) VALUES (?,?,?,?)";
		
		if(!mysqli_stmt_prepare($stmt,$d_created)){
			header("Location: ../assign_new_task.php?site=Assign%20new%20task&error=d%20created&row=".$row_last['last']."");
			exit();
		}else{
			mysqli_stmt_bind_param($stmt, "sssi", $date_created, $created, $report, $report_id);
			mysqli_stmt_execute($stmt);
			
			$d_due = "INSERT INTO `dates`( `date_time`, `date_type`, `date_identity`, `report_issue_id`) VALUES (?,?,?,?)";
			
			if(!mysqli_stmt_prepare($stmt, $d_due)){
				header("Location: ../assign_new_task.php?site=Assign%20new%20task&error=d%20due");
				exit();
			}else{
				mysqli_stmt_bind_param($stmt, "sssi", $date_created, $due_date, $report, $report_id);
				mysqli_stmt_execute($stmt);
				
				if(is_null($taskDesc) || $taskDesc ==""){
					$query = "INSERT INTO `reports`(`machine_id`, `task`, `task_due`, `date_created`, `report_status`, `assigned_user`, `assigned_by`) VALUES (?,?,?,?,?,?,?)";
				}else{
					$query = "INSERT INTO `reports`(`machine_id`, `task`, `task_desc`, `task_due`, `date_created`, `report_status`, `assigned_user`, `assigned_by`) VALUES (?,?,?,?,?,?,?,?)";
				}
				
				
				if(!mysqli_stmt_prepare($stmt, $query)){
					header("Location: ../assign_new_task.php?site=Assign%20new%20task&error=reports");
					exit();
				}else{
					if(is_null($taskDesc) || $taskDesc == ""){
						mysqli_stmt_bind_param($stmt, "issssis", $e_id, $task, $dueDate, $date_created, $unresolved, $assignedTo, $_SESSION['userId']);
					}else{
						mysqli_stmt_bind_param($stmt, "isssssis", $e_id, $task, $taskDesc, $dueDate, $date_created, $unresolved, $assignedTo, $_SESSION['userId']);

					}
					
					mysqli_stmt_execute($stmt);
					
					header("Location: ../assign_new_task.php?site=Assign%20new%20task&status=submitted");
					exit();
				}
			}
		}
	}
	
}else{
	header("Location:../assign_new_task.php?site=Assign%20new%20task");
	exit();
}
?> 