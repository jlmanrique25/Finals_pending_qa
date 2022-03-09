<?php
include 'dbh.p.php';

if(isset($_POST['submit']))
{
    $r_id = $_GET['r_id'];
    $e_id = $_GET['e_id'];
	$volt = $_POST['volt'];
	$pressure = $_POST['pressure'];
	$temp = $_POST['temp'];
    $repair_remarks = $_POST['repair_remarks'];
    $other_remarks = $_POST['other_remarks'];
    $report_status = "done";

    date_default_timezone_set('Asia/Hong_Kong');
    $time_submitted = date('Y-m-d h:i:s a', time());
    
    //initialize connection
    $stmt = mysqli_stmt_init($conn);

    $check = isset($_POST['for_repair']) ? "checked" : "unchecked";
    if ($check == "unchecked") {
        $for_repair = 0;
    } else {
        $for_repair = $_POST['for_repair'];
    }
    
    $airconReadings = "INSERT into `equipment_readings_aircon` (`equipment_id`,`report_id`, `volt`, `pressure`, `temp`, `for_repair`, `repair_remarks`, `other_remarks`, `date_created`, `assigned_to`) VALUES (?,?,?,?,?,?,?,?,?,?)";
        
    if(!mysqli_stmt_prepare($stmt, $airconReadings)){
        header("Location: ../createStatusReport.php?&error=insert%20hvac%20readings");
        exit();
    }else{
        mysqli_stmt_bind_param($stmt, "iiiidsssss", $e_id, $r_id, $volt, $pressure, $temp, $for_repair, $repair_remarks, $other_remarks, $time_submitted, $_SESSION['userId']);
        mysqli_stmt_execute($stmt);
    }

    // update report status to done
    $sql = "UPDATE `reports` SET `date_submitted` = '".$time_submitted."',`report_status` = '".$report_status."', `for_repair` = ".$for_repair."  WHERE `report_id` = ".$r_id."";
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo 'error updating reports database';
	}else{
		mysqli_query($conn, $sql);
        //echo 'reports date submitted set';
    }
	
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		//header('Location:../users.php?updatenotsuccessful&page=1&site=Users');
		exit();
	}else{
		$result = mysqli_query($conn,$sql);
    }
}
?>