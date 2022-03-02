<?php 
	include 'dbh.p.php';
	
	if(isset($_POST['submit'])){
		$issue_id = $_GET['id'];
		date_default_timezone_set('Asia/Hong_Kong');
		$date_submitted = date('Y-m-d h:i:s a', time());
		$reco = $_POST['recommendation'];
		$e_by = $_POST['endorser'];
		$d_repair = $_POST['date_repair'];
		$identity = "submitted";
		$type = "issue";
		$status = 1;
		
		
		
		if($_POST['contact_company'] != ""){
			$c_co = $_POST['contact_company'];
		}else{
			$c_co = NULL;
		}
		
		
		
		if($_POST['company'] != ""){
			$co_rep = $_POST['company'];
		}else{
			$co_rep = NULL;
		}
		
		
		
		
		if($_POST['receipt'] != ""){
			$receit = $_POST['receipt'];
		}else{
			$receit = NULL;
		}
		
		$check = "SELECT * FROM `dates` Where date_type = 'submitted' AND date_identity = 'issue' AND report_issue_id = ".$issue_id."";
		$stmt = mysqli_stmt_init($conn);
		
		if(mysqli_query($conn, $check)->num_rows > 0){
			$sql_d = "UPDATE `dates` SET `date_time`='".$date_submitted."' WHERE report_issue_id = ".$issue_id."";
			mysqli_query($conn, $sql_d);
			
			$sql_i = "UPDATE `issue` 
			SET `recommendation`='".$reco."',`endorsed_by`='".$e_by."',`date_endorsed_for_repair`='".$d_repair."',`date_reinstalled`='".$d_reinstalled."',`contracted_company`='".$c_co."',`company_representative`='".$co_rep."',`service_report_number`='".$receit."',`date_issue_resolved`='".$date_submitted."', `issue_status` = ".$status."
			WHERE issue_id = ".$issue_id."";
			
			if(!mysqli_stmt_prepare($stmt, $sql_i)){
				header("Location: ../issue_report.php?error=database_issue");
			exit();
			}else{
				$result = mysqli_query($conn,$sql_i);
		
				header('Location:..//tasks.php?site=Issues&page=1&redo=success&i='.$issue_id.'');
				exit();
			}
		}else{
			$d_reinstalled = $_POST['date_reinstalled'];
		
		$sql_d = "INSERT INTO `dates`(`date_time`, `date_type`, `date_identity`, `report_issue_id`) VALUES (?,?,?,?)";
		
		
		if(!mysqli_stmt_prepare($stmt, $sql_d)){
			header("Location: ../issue_report.php?error=database_dates");
			exit();
		}else{
			mysqli_stmt_bind_param($stmt, 'sssi', $date_submitted, $identity, $type, $issue_id);
			mysqli_stmt_execute($stmt);
			
			$sql_i = "UPDATE `issue` 
			SET `recommendation`='".$reco."',`endorsed_by`='".$e_by."',`date_endorsed_for_repair`='".$d_repair."',`date_reinstalled`='".$d_reinstalled."',`contracted_company`='".$c_co."',`company_representative`='".$co_rep."',`service_report_number`='".$receit."',`date_issue_resolved`='".$date_submitted."', `issue_status` = ".$status."
			WHERE issue_id = ".$issue_id."";
			
			if(!mysqli_stmt_prepare($stmt, $sql_i)){
				header("Location: ../issue_report.php?error=database_issue");
			exit();
			}else{
				$result = mysqli_query($conn,$sql_i);
		
				header('Location:..//tasks.php?site=Issues&page=1&submition=success&i='.$issue_id.'');
				exit();
			}
		}
		}

	}else{
		echo 'no report detected';
	}
?>