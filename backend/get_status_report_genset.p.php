<?php
include 'dbh.p.php';

if(isset($_POST['submit']))
{
    $r_id = $_GET['r_id'];
    $e_id = $_GET['e_id'];
	$v1 = $_POST['v1'];
    $v2 = $_POST['v2'];
    $v3 = $_POST['v3'];
	$c1 = $_POST['c1'];
    $c2 = $_POST['c2'];
    $c3 = $_POST['c3'];
    $frequency = $_POST['frequency'];
    $battery_voltage = $_POST['battery_voltage'];
    $running_hours = $_POST['running_hours'];
    $oil_pressure = $_POST['oil_pressure'];
    $oil_temperature = $_POST['oil_temperature'];
    $oil_rotation = $_POST['rotation'];
    $fuel_level = $_POST['fuel_level'];
    $repair_remarks = $_POST['repair_remarks'];
    $other_remarks = $_POST['other_remarks'];
    $report_status = "done";

    date_default_timezone_set('Asia/Hong_Kong');
    $time_submitted = date('Y-m-d h:i:s a', time());
    
    //initialize connection
    $stmt = mysqli_stmt_init($conn);

    $check1 = isset($_POST['for_repair']) ? "checked" : "unchecked";
    if ($check1 == "unchecked") {
        $for_repair = 0;
    } else {
        $for_repair = $_POST['for_repair'];
    }

    $check2 = isset($_POST['abnormal_sound']) ? "checked" : "unchecked";
    if ($check2 == "unchecked") {
        $abnormal_sound = 0;
    } else {
        $abnormal_sound = $_POST['abnormal_sound'];
    }

    $check3 = isset($_POST['gas_leak']) ? "checked" : "unchecked";
    if ($check3 == "unchecked") {
        $gas_leak = 0;
    } else {
        $gas_leak = $_POST['gas_leak'];
    }

	$gensetReadings = "INSERT into `equipment_readings_genset` (`equipment_id`,`report_id`, `voltage_line_1`, `voltage_line_2`, `voltage_line_3`, `current_line_1`, `current_line_2`, `current_line_3`, `frequency`, `battery_voltage`, `running_hours`, `oil_pressure`, `oil_temperature`, `rotation`, `fuel_level`, `abnormal_sound`, `gas_leak`, `for_repair`, `repair_remarks`, `other_remarks`, `date_created`, `assigned_to`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

	if(!mysqli_stmt_prepare($stmt, $gensetReadings)){
		header("Location: ../createStatusReport.php?&error=insert%20genset%20readings");
		exit();
	}else{
		mysqli_stmt_bind_param($stmt, "iidddddddddidiisssssss", $e_id, $r_id, $v1, $v2, $v3, $c1, $c2, $c3, $frequency, $battery_voltage, $running_hours, $oil_pressure, $oil_temperature, $rotation, $fuel_level, $abnormal_sound, $gas_leak, $for_repair, $repair_remarks, $other_remarks, $time_submitted, $_SESSION['userId']);
		mysqli_stmt_execute($stmt);
		}

    // update report status to done
    $sql = "UPDATE `reports` SET `date_submitted` = '".$time_submitted."',`report_status` = '".$report_status."'  WHERE `report_id` = ".$r_id."";
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