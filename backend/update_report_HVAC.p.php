<?php

session_start();
include 'dbh.p.php';

if(isset($_POST['submit']))
{
    $r_id = $_GET['r_id'];
    $e_id = $_GET['e_id'];
	$volt = $_POST['volt'];
	$pressure = $_POST['pressure'];
	$temp = $_POST['temp'];
    if($_POST['repair_remarks'] == ''){
        $repair_remarks = 'N/A';
    }else{
        $repair_remarks = $_POST['repair_remarks'];
    }

    $other_remarks = $_POST['other_remarks'];
    $report_status = "done";
    if($_POST['for_repair'] != NULL){
        $for_repair = $_POST['for_repair'];
    }else{
        $for_repair = 0;
    }
    $zero = 0;

    date_default_timezone_set('Asia/Hong_Kong');
    $time_submitted = date('Y-m-d h:i:s a', time());

    $stmt = mysqli_stmt_init($conn);

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

        $sql = "UPDATE `equipment_readings_aircon`
                SET
                    `volt` = '".$volt."',
                    `pressure` = '".$pressure."',
                    `temp` = '".$temp."',
                    `for_repair` = '".$for_repair."',
                    `repair_remarks` = '".$repair_remarks."',
                    `other_remarks` = '".$other_remarks."'
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