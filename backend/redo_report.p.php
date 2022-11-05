<?php
include 'dbh.p.php';

$sql = "UPDATE `reports` SET `report_status` = 'unresolved' WHERE `report_id` = ".$_GET['r_id']."";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)){
    echo 'error';
    echo $sql;
}else{
    mysqli_query($conn, $sql);

    header('Location: ../viewPastReports.php?r='.$_GET['r_id'].'&e='.$_GET['e_id'].'&site=My%20Past%20Reports');
    exit();
}
?>