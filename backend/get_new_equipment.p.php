<?php
session_start();
include 'dbh.p.php';

if(isset($_POST['submit']))
{
	$equipment_name= $_POST['equipment_name'];
	$asset= $_POST['asset'];
	$brand= $_POST['brand'];
	$machine_description= $_POST['machine_description'];
	$model_no= $_POST['model_no'];
	$serial_no= $_POST['serial_no'];
	$date_of_purchase= $_POST['date_of_purchase'];
	$floor= $_POST['floor'];
	$room_number= $_POST['room_number'];
	$room_classification= $_POST['room_classification'];
	$stmt = mysqli_stmt_init($conn);
	$n_issue = "no issues";
	$o = 1;
	
	
	/* echo $equipment_name, $asset, $brand, $machine_description, $model_no, $serial_no, $date_of_purchase, $date_last_used, $floor, $room_number, $room_classification, $_SESSION['userId']; */

	$location_id = "SELECT location_id as last FROM location ORDER BY location_id DESC LIMIT 1";

	

	if(!mysqli_stmt_prepare($stmt,$location_id)){
		header("Location: ../add_new_equipment.php?site=Add%20new%20equipment&error=getting%20%20last");
		exit();
	}else{
		$result_last = mysqli_query($conn, $location_id);
		$row_last = mysqli_fetch_assoc($result_last);
		$location_id = $row_last['last'] + 1;
		
		$d_created = "INSERT INTO `location`( `floor`, `room_number`, `room_classification`) VALUES (?,?,?)";
		
		if(!mysqli_stmt_prepare($stmt,$d_created)){
			header("Location: ../add_new_equipment.php?site=Add%20new%20equipment&error=d%20created&row=".$row_last['last']."");
			exit();
		}else{
			mysqli_stmt_bind_param($stmt, "sis", $floor, $room_number, $room_classification);
			mysqli_stmt_execute($stmt);
			
			$d_due = "INSERT INTO `equipment`( `equipment_name`, `asset`, `brand`, `machine_description`, `location_id`, `model_no`, `serial_no`, `date_of_purchase`, `condition`, `operating`) VALUES (?,?,?,?,?,?,?,?,?,?)";
			
			if(!mysqli_stmt_prepare($stmt, $d_due)){
				header("Location: ../add_new_equipment.php?site=Add%20new%20equipment&error=d%20due");
				exit();
			}else{
				mysqli_stmt_bind_param($stmt, "ssssisissi", $equipment_name, $asset, $brand, $machine_description, $location_id, $model_no, $serial_no, $date_of_purchase, $n_issue, $o);
				mysqli_stmt_execute($stmt);
				
					
					header("Location: ../add_new_equipment.php?site=Add%20new%20equipment&status=submitted");
					exit();
				}
			}
		}
	}
	
?> 