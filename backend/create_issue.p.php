<?php
session_start();
include 'dbh.p.php';

if(isset($_POST['submit']))
{
	date_default_timezone_set('Asia/Hong_Kong');
	$date_created = date('Y-m-d h:i:s a', time());
	$typeOfMachine = $_POST['typeOfMachine'];
	$issue_desc = $_POST['issue_desc'];
	$issue = $_POST['issue'];
	if(isset($_POST['assignedTo'])){
		$assignedTo = $_POST['assignedTo'];
		$dueDate = $_POST['dueDate'];
	}
	
	$created = "created";
	$type = "issue";
	$due_date = "due date";
	$stmt = mysqli_stmt_init($conn);
	$unresolved = 0;
	
	
	
	if($typeOfMachine == 'Genset'){
		$e_id = $_POST['gensetForm'];
	}else if($typeOfMachine == 'HVAC'){
		$e_id = $_POST['airconForm'];
	}
	

	$report_id = "SELECT issue_id as last FROM issue ORDER BY issue_id DESC LIMIT 1";

	if(!mysqli_stmt_prepare($stmt, $report_id)){
		header("Location: ../assign_issue.php?site=Report%20Issue&error=getting%20%20last");
		exit();
	}else{
		$result_last = mysqli_query($conn, $report_id);
		$row_last = mysqli_fetch_assoc($result_last);
		
		$report_id = $row_last['last'] + 1;
		
		$d_created = "INSERT INTO `dates`( `date_time`, `date_type`, `date_identity`, `report_issue_id`) VALUES (?,?,?,?)";
		
		if(!mysqli_stmt_prepare($stmt, $d_created)){
			header("Location: ../assign_issue.php?site=Report%20Issue&error=dcreated");
			exit();
		}else{
			mysqli_stmt_bind_param($stmt, "sssi",$date_created, $created, $type, $report_id);
			mysqli_stmt_execute($stmt);
			
			if(isset($_POST['assignedTo'])){
				$d_due = "INSERT INTO `dates`( `date_time`, `date_type`, `date_identity`, `report_issue_id`) VALUES (?,?,?,?)";
				
				if(!mysqli_stmt_prepare($stmt, $d_due)){
					header("Location: ../assign_issue.php?site=Report%20Issue&error=ddue");
					exit();
				}else{
					mysqli_stmt_bind_param($stmt, "sssi", $dueDate, $due_date, $type, $report_id);
					mysqli_stmt_execute($stmt);
					
					if(is_null($issue_desc) || $issue_desc == ""){
						$query = "INSERT INTO `issue`(`machine_id`, `issue`, `submitted_by`,`issue_status`, `assigned_to`, `date_created`, `date_due`) VALUES (?,?,?,?,?,?,?)";
					}else{
						$query = "INSERT INTO `issue`(`machine_id`, `issue`, `submitted_by`,`issue description`, `issue_status`, `assigned_to`, `date_created`, `date_due`) VALUES (?,?,?,?,?,?,?,?)";
					}
					
					if(!mysqli_stmt_prepare($stmt, $query)){
						header("Location: ../assign_issue.php?site=Report%20Issue&error=issue");
						exit();
					}else{
						if(is_null($issue_desc) || $issue_desc == ""){
							mysqli_stmt_bind_param($stmt, "isiiiss", $e_id, $issue, $_SESSION['userId'], $unresolved, $assignedTo, $date_created, $dueDate);
						}else{
							mysqli_stmt_bind_param($stmt, "isisiiss", $e_id, $issue, $_SESSION['userId'], $issue_desc,$unresolved, $assignedTo, $date_created, $dueDate);
						}
						
						mysqli_stmt_execute($stmt);
						
						$equip = "UPDATE `equipment` SET `condition`= 'with issues/abnormal reading' WHERE equipment_id = ".$e_id."";
					
	
						if(!mysqli_stmt_prepare($stmt, $equip)){
							header('Location:../users.php?updatenotsuccessful&page=1&site=Users');
							exit();
						}else{
							$result = mysqli_query($conn,$equip);
							
							
							header("Location: ../assign_issue.php?site=Submit%20issue&status=submitted&id=".$report_id."");
							exit();
						}
					}
				}
			}else{
				if(is_null($issue_desc) || $issue_desc == ""){
					$query = "INSERT INTO `issue`(`machine_id`, `issue`, `submitted_by`, `issue_status`, `date_created`) VALUES (?,?,?,?,?)";

				}else{
					$query = "INSERT INTO `issue`(`machine_id`, `issue`, `submitted_by`, `issue description`, `issue_status`, `date_created`) VALUES (?,?,?,?,?,?)";

				}

				if(!mysqli_stmt_prepare($stmt, $query)){
					header("Location: ../assign_issue.php?site=Submit%20Issue&error=reports");
					exit();
						
				}else{
					if(is_null($issue_desc) || $issue_desc == ""){
						mysqli_stmt_bind_param($stmt, "isiis", $e_id, $issue, $_SESSION['userId'],$unresolved, $date_created);
					}else{
						mysqli_stmt_bind_param($stmt, "isisis", $e_id, $issue, $_SESSION['userId'],$issue_desc, $unresolved, $date_created);

					}
					
					mysqli_stmt_execute($stmt);
					
					$equip = "UPDATE `equipment` SET `condition`= 'with issues/abnormal reading' WHERE equipment_id = ".$e_id."";
					
	
					if(!mysqli_stmt_prepare($stmt, $equip)){
						header('Location:../users.php?updatenotsuccessful&page=1&site=Users');
						exit();
					}else{
						$result = mysqli_query($conn,$equip);
						
						echo $result;
						
						header("Location: ../assign_issue.php?site=Submit%20issue&status=submitted&id=".$report_id."");
						exit();
					}
	
					
				}
			}
		}
	}
	
	/**
	if(!mysqli_stmt_prepare($stmt,$report_id)){
		header("Location: ../assign_issue.php?site=Report%20Issue&error=getting%20%20last");
		exit();
	}else{
		$result_last = mysqli_query($conn, $report_id);
		$row_last = mysqli_fetch_assoc($result_last);
		$report_id = $row_last['last'] + 1;
		
		$d_created = "INSERT INTO `dates`( `date_time`, `date_type`, `date_identity`, `report_issue_id`) VALUES (?,?,?,?)";
		
		if(!mysqli_stmt_prepare($stmt,$d_created)){
			header("Location: ../assign_issue.php?site=Report%20issue&error=d%20created&row=".$row_last['last']."");
			exit();
		}else{
			mysqli_stmt_bind_param($stmt, "sssi", $date_created, $created, $type, $report_id);
			mysqli_stmt_execute($stmt);
			
			if(isset($_POST['assignedTo']) && isset($_POST['dueDate'])){
				$d_due = "INSERT INTO `dates`( `date_time`, `date_type`, `date_identity`, `report_issue_id`) VALUES (?,?,?,?)";
			
				if(!mysqli_stmt_prepare($stmt, $d_due)){
					header("Location: ../assign_issue.php?site=Report%20issuek&error=d%20due");
					exit();
				}else{
					mysqli_stmt_bind_param($stmt, "sssi", $date_created, $due_date, $type, $report_id);
					mysqli_stmt_execute($stmt);
					
					if(is_null($issue_desc) || $issue_desc =""){
						$query = "INSERT INTO `issue`(`machine_id`, `issue`, `issue_status`, `assigned_to`, `date_created`, `date_due`) VALUES (?,?,?,?,?,?)";
					}else{
						$query = "INSERT INTO `issue`(`machine_id`, `issue`, `issue description`, `issue_status`, `assigned_to`, `date_created`, `date_due`) VALUES (?,?,?,?,?,?,?)";
					}
					
					
					if(!mysqli_stmt_prepare($stmt, $query)){
						header("Location: ../assign_new_task.php?site=Submit%20issue&error=reports");
						exit();
					}else{
						if(is_null($issue_desc) || $issue_desc == ""){
							mysqli_stmt_bind_param($stmt, "isiiss", $e_id, $issue, $unresolved, $assignedTo, $date_created, $dueDate);
						}else{
							mysqli_stmt_bind_param($stmt, "issiiss", $e_id, $issue, $issue_desc, $unresolved, $assignedTo, $date_created, $dueDate);

						}
						
						mysqli_stmt_execute($stmt);
						
						header("Location: ../assign_issue.php?site=Report%20issue&status=submitted");
						exit();
					}
				}
			}else{
				if(is_null($issue_desc) || $issue_desc =""){
					$query = "INSERT INTO `issue`(`machine_id`, `issue`, `issue_status`, `date_created`) VALUES (?,?,?,?)";
				}else{
					$query = "INSERT INTO `issue`(`machine_id`, `issue`, `issue description`, `issue_status`, `date_created`) VALUES (?,?,?,?,?,)";
				}
				
				
				if(!mysqli_stmt_prepare($stmt, $query)){
					header("Location: ../assign_issue.php?site=Submit%20Issue&error=reports");
					exit();
				}else{
					if(is_null($issue_desc) || $issue_desc == ""){
						mysqli_stmt_bind_param($stmt, "isis", $e_id, $issue, $unresolved, $date_created);
					}else{
						mysqli_stmt_bind_param($stmt, "issis", $e_id, $issue, $issue_desc, $unresolved, $date_created);

					}
					
					mysqli_stmt_execute($stmt);
					
					header("Location: ../assign_issue.php?site=Submit%20issue&status=submitted");
					exit();
				}
			}
			
		}
	}**/

}else{
	header("Location:../assign_issue.php?site=Report%20Issue");
	exit();
}
?> 