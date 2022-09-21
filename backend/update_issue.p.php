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



$sql = "UPDATE `issue` SET issue = '".$task."', `issue description` = '".$td."', date_due = '".$duedate."', assigned_to = ".$assign.", machine_id = ".$machine." WHERE issue_id = ".$id."";
$stmt = mysqli_stmt_init($conn);


if(!mysqli_stmt_prepare($stmt, $sql)){
    echo 'error connecting to database';
    echo $sql;
}else{
    $result = mysqli_query($conn,$sql);


    header('Location:../issues.php?site=Issues&update=success&id='.$id.'');
    exit();
}