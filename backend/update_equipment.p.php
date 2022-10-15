<?php
include 'dbh.p.php';

$id = $_GET['id'];
$brand = $_POST['brand'];
$machine_description = $_POST['machine_description'];
$model_no = $_POST['model_no'];
$serial_no = $_POST['serial_no'];
$date_of_purchase = $_POST['date_of_purchase'];
$floor = $_POST['floor'];
$room_number = $_POST['room_number'];
$room_classification = $_POST['room_classification'];


$sql_equipment = "UPDATE `equipment` SET `brand` = '".$brand."', `machine_description` = '".$machine_description."', `model_no` = '".$model_no."', `serial_no` = '".$serial_no."', `date_of_purchase` = '".$date_of_purchase."' WHERE equipment_id = ".$id."";
$sql_location = "UPDATE `location` SET `floor` = '".$floor."', `room_number` = '".$room_number."', `room_classification` = '".$room_classification."' WHERE location_id = ".$id."";
$stmt = mysqli_stmt_init($conn);


if(!mysqli_stmt_prepare($stmt, $sql_equipment)){
    echo 'error connecting to database';
    echo $sql_equipment;
}else if(!mysqli_stmt_prepare($stmt, $sql_location)){
        echo 'error connecting to database';
        echo $sql_location;
}else{
    $result = mysqli_query($conn,$sql_equipment);
    $result = mysqli_query($conn,$sql_location);

    header('Location:../equipment.php?site=Equipment&update=success&id='.$id.'');
    exit();
}
    
