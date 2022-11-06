<?php
session_start();
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
    if($_POST['repair_remarks'] == ''){
        $repair_remarks = 'N/A';
    }else{
        $repair_remarks = $_POST['repair_remarks'];
    }
    $other_remarks = $_POST['other_remarks'];
    $report_status = "done";
    $zero = 0;

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

    $sql = "UPDATE `reports`
                SET
                    `date_submitted` = '".$time_submitted."',
                    `report_status` = 'done'
            WHERE `report_id` = ".$r_id."";
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo 'error connecting to database';
        echo $sql;
    }else{
        $result = mysqli_query($conn,$sql);

        $sql = "UPDATE `equipment_readings_genset`
                SET
                    `voltage_line_1` = '".$v1."',
                    `voltage_line_2` = '".$v2."',
                    `voltage_line_3` = '".$v3."',
                    `current_line_1` = '".$c1."',
                    `current_line_2` = '".$c2."',
                    `current_line_3` = '".$c3."',
                    `frequency` = '".$frequency."',
                    `battery_voltage` = '".$battery_voltage."',
                    `running_hours` = '".$running_hours."',
                    `oil_pressure` = '".$oil_pressure."',
                    `oil_temperature` = '".$oil_temperature."',
                    `rotation` = '".$oil_rotation."',
                    `fuel_level` = '".$fuel_level."',
                    `fuel_level` = '".$fuel_level."',
                    `abnormal_sound` = '".$abnormal_sound."',
                    `gas_leak` = '".$gas_leak."',
                    `for_repair` = '".$for_repair."',
                    `for_repair` = '".$for_repair."',
                    `repair_remarks` = '".$repair_remarks."',
                    `other_remarks` = '".$other_remarks."',
                    `time_submitted` = '".$time_submitted."'
            WHERE `report_id` = ".$r_id."";

        if(!mysqli_stmt_prepare($stmt, $sql)){
            echo 'error connecting to database';
            echo $sql;
        }else{
            $result = mysqli_query($conn,$sql);

            if($_SESSION['role'] == 'Admin'){
                header('Location:../admin_tasks_table.php?site=Resolved%20Tasks&table=resolved');
                exit();
            }else{
                header('Location:../technician_reports.php?site=My%20Reports&page=1');
                exit();
            }

        }


    }

    }



