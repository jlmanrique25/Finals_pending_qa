<?php
include 'dbh.p.php';

$id = $_GET['id'];
$tm = $_POST['typeOfMachine'];

if($tm == 'Genset'){
    $machine = $_POST['gensetForm'];
}else{
    $machine = $_POST['airconForm'];
}

$task = $_POST['task'];
$td = $_POST['taskDesc'];
$duedate = $_POST['dueDate'];
$assign = $_POST['assignedTo'];

//echo $id.$tm.$machine.$task.$td.$duedate.$assign;


$sql = "UPDATE `reports` SET task = '".$task."', task_desc = '".$td."', task_due = '".$duedate."', assigned_user = ".$assign.", machine_id = ".$machine." WHERE report_id = ".$id."";
$stmt = mysqli_stmt_init($conn);


if(!mysqli_stmt_prepare($stmt, $sql)){
    echo 'error connecting to database';
}else{
    $result = mysqli_query($conn,$sql);

    header('Location:../reports.php?site=Reports&update=success&id='.$id.'');
    exit();
}

//if($_GET['role'] == "Technician"){
//    $sql = "UPDATE `users` SET `role`= 'Admin' WHERE users_id =".$_GET['userid']."";
//}else{
//    $sql = "UPDATE `users` SET `role`= 'Technician' WHERE users_id =".$_GET['userid']."";
//}

//$stmt = mysqli_stmt_init($conn);



