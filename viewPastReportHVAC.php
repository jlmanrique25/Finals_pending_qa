<?php
include 'backend/dbh.p.php';

//getting specific reports record
$sql_report = "SELECT * FROM `reports` WHERE report_id = ".$_GET['r']."";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql_report)){
	echo 'error connecting to the database report';
}else{
	$result_report = mysqli_query($conn, $sql_report);
	$row_report = mysqli_fetch_assoc($result_report);
}

//getting specific equipment record
$sql_equipment = "SELECT * FROM `equipment` WHERE equipment_id = ".$_GET['e']."";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql_equipment)){
	echo 'error connecting to the database equipment';
}else{
	$result_equipment = mysqli_query($conn, $sql_equipment);
	$row_equipment = mysqli_fetch_assoc($result_equipment);
}

//getting the readings of specific record
$sql_readings = "SELECT * FROM `equipment_readings_aircon` WHERE date_created = '".$row_report['date_submitted']."'";
	
if(!mysqli_stmt_prepare($stmt, $sql_readings)){
	echo 'error connecting to database equipment_readings_aircon';
}else{	
	$result_read = mysqli_query($conn, $sql_readings);
	$row_hvac = mysqli_fetch_assoc($result_read);
}

//getting the username of specific record
$sql_user = "SELECT * FROM `users` WHERE users_id = ".$row_report['assigned_user']."";
	
if(!mysqli_stmt_prepare($stmt, $sql_user)){
	echo 'error connecting to database users';
}else{	
	$result_user = mysqli_query($conn, $sql_user);
	$row_user = mysqli_fetch_assoc($result_user);
}

//set checkbox values
$for_repair = $row_hvac['for_repair'];
?>

<head>
	<style>
		input[type="number"]:disabled, input[type="text"]:disabled, textarea:disabled {
  			background: #e5e5e5;
			border: none;
			color: #000;
		}
	</style>
	<title>View Status Report</title>
</head>

<div class="container-fluid py-4">

		<!-- assigned task info -->
		<h2><?php echo $row_report['task']; ?> : equipment <?php echo $row_equipment['equipment_name']; ?></h2>
		<hr class="rounded" />
		<div class="row mb-4">
			<div class="col-6">
				<h5>Due Date: <?php echo $row_report['task_due']; ?></h5>
				<h5>Date Submitted: <?php echo $row_report['date_submitted']; ?></h5>
				<h5>Submitted by: <?php echo $row_user['username'];?></h5>
			</div>
			<div class="col-6">
				<h5 class="mb-5">Date created: <?php echo $row_report['date_created'];?></h5>
			</div>
		</div>
		
		<!-- equipment readings -->
		<form>
		<div class="row mb-4">
	        <div class="col-4">
	        	<label for="volt">Voltage</label>
	        	<input type="number" class="form-control w-100" name="volt" id="volt" placeholder="<?php echo $row_hvac['volt'] ?> V" disabled>
	        </div>
			<div class="col-4">
	            <label for="pressure">Pressure</label>
	            <input type="number" class="form-control w-100" name="pressure" id="pressure" placeholder="<?php echo $row_hvac['pressure'] ?> psi" disabled>
	        </div>
			<div class="col-4">
	            <label for="temp">Temperature</label>
	            <input type="number" class="form-control w-100" name="temp" id="temp" placeholder="<?php echo $row_hvac['temp'] ?> F" disabled>
	        </div>
	    </div>

		<!-- additional report remarks -->
		<div class="form-group">
			<input type="checkbox" id="for_repair" name="for_repair" 
			<?php if ($for_repair == 1) { ?>
        		checked
    		<?php }?> disabled/>
			<label for="temp">Issue/For repair</label><br>
			<textarea class="form-control" id="repair_remarks" name="repair_remarks" rows="3" placeholder="<?php echo $row_hvac['repair_remarks'] ?>" disabled></textarea>
		</div>
        <div class="form-group">
            <label for="comments">Other remarks</label>
            <textarea class="form-control" id="comments" name="other_remarks" rows="3" placeholder="<?php echo $row_hvac['other_remarks'] ?>" disabled></textarea>
        </div>
</div>