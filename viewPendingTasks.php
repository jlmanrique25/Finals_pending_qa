<?php

session_start();
include 'backend/dbh.p.php';
include 'header.php';

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

//getting the location of specific equipment
$sql_location = "SELECT * FROM `location` WHERE location_id = ".$row_equipment['location_id']."";
	
if(!mysqli_stmt_prepare($stmt, $sql_location)){
	echo 'error connecting to database location';
}else{	
	$result_loc = mysqli_query($conn, $sql_location);
	$row_loc = mysqli_fetch_assoc($result_loc);
}

//getting the username of specific record
$sql_user = "SELECT * FROM `users` WHERE users_id = ".$row_report['assigned_user']."";
	
if(!mysqli_stmt_prepare($stmt, $sql_user)){
	echo 'error connecting to database users';
}else{	
	$result_user = mysqli_query($conn, $sql_user);
	$row_user = mysqli_fetch_assoc($result_user);
}

if($_GET['site'] == "Pending Task"){
?>

<head>
	<style>
		#main_content{
			padding: 7%;
		}
	</style>
	<title>Pending Status Report</title>
</head>

<div class="container-fluid py-4" id="main_content">

		<!-- assigned task info -->
		<h2><?php echo $row_report['task']; ?> : equipment <?php echo $row_equipment['equipment_name']; ?></h2>
		<hr class="rounded" />
		<div class="row mb-4">
			<div class="col-8">
				<h5>Due date: <?php echo $row_report['task_due']; ?></h5>
				<h5>Assigned to: <?php echo $row_user['username']; ?></h5>
			</div>
			<div class="col-4">
				<h5 class="mb-5">Date created: <?php echo $row_report['date_created'];?></h5>
			</div>
		</div>
		
		<!-- form submission based on asset -->
		<?php
		if('HVAC' == $row_equipment['asset']) { ?>
			<form action="u_tasks.php?site=Pending%20Tasks&page=1" method="post">
				<div class="row mb-4">
	              <div class="col-4">
	                <label for="volt">Voltage</label>
	                <input type="number" class="form-control w-100" name="volt" id="volt" disabled>
	              </div>
				  <div class="col-4">
	                <label for="pressure">Pressure</label>
	                <input type="number" class="form-control w-100" name="pressure" id="pressure" disabled>
	              </div>
				  <div class="col-4">
	                <label for="temp">Temperature</label>
	                <input type="number" class="form-control w-100" name="temp" id="temp" disabled>
	              </div>
	            </div> 
		<?php }else { ?>
			<form action="u_tasks.php?site=Pending%20Tasks&page=1" method="post">
			<div class="row mb-4">
				  <label for="Voltage">Voltage</label>
	              <div class="col-4">
	                <input type="number" class="form-control w-100" name="v1" id="voltage_line_1" placeholder="Line 1" disabled>
	              </div>
				  <div class="col-4">
				  <input type="number" class="form-control w-100" name="v2" id="voltage_line_2" placeholder="Line 2" disabled>
	              </div>
				  <div class="col-4">
				  <input type="number" class="form-control w-100" name="v3" id="voltage_line_3" placeholder="Line 3" disabled>
	              </div>
	            </div>
				<br>
				<div class="row mb-4">
				  <label for="Current">Current</label>
	              <div class="col-4">
	                <input type="number" class="form-control w-100" name="c1" id="current_line_1" placeholder="Line 1" disabled>
	              </div>
				  <div class="col-4">
				  <input type="number" class="form-control w-100" name="c2" id="current_line_2" placeholder="Line 2" disabled>
	              </div>
				  <div class="col-4">
				  <input type="number" class="form-control w-100" name="c3" id="current_line_3" placeholder="Line 3" disabled>
	              </div>
	            </div>
				<br>
				<div class="row mb-4">
	              <div class="col-4">
				    <label for="frequency">Frequency</label>
	                <input type="number" class="form-control w-100" name="frequency" id="frequency" placeholder="hz" disabled>
	              </div>
				  <div class="col-4">
				    <label for="battery_voltage">Battery Voltage</label>
	                <input type="number" class="form-control w-100" name="battery_voltage" id="battery_voltage" placeholder="V" disabled>
	              </div>
				  <div class="col-4">
				  <label for="running_hours">Running Hours</label>
				  <input type="number" class="form-control w-100" name="running_hours" id="running_hours" placeholder="h" disabled>
	              </div>
	            </div>
				<br>
				<div class="row mb-4">
	              <div class="col-6">
				    <label for="oil_pressure">Oil Pressure</label>
	                <input type="number" class="form-control w-100" name="oil_pressure" id="oil_pressure" placeholder="psi" disabled>
	              </div>
				  <div class="col-6">
				  <label for="oil_temperature">Oil Temperature</label>
				  <input type="number" class="form-control w-100" name="oil_temperature" id="oil_temperature" placeholder="F" disabled>
	              </div>
	            </div>
				<br>
				<div class="row mb-4">
				  <div class="col-6">
				    <label for="rotation">Frequency of Rotation</label>
	                <input type="number" class="form-control w-100" name="rotation" id="rotation" placeholder="rpm" disabled>
	              </div>
	              <div class="col-6">
				    <label for="fuel_level">Fuel Level</label>
	                <input type="number" class="form-control w-100" name="fuel_level" id="fuel_level" placeholder="L" disabled>
	              </div>
	            </div>
				<br>
				<div class="row mb-4">
					<div class="col-12">
				  	<input type="checkbox" name="abnormal_sound" id="abnormal_sound" value=1 disabled/>
					<label>Any abnormal sounds?</label>
					</div>
				</div>
				<div class="row mb-4">
					<div class="col-12">
				  	<input type="checkbox" name="gas_leak" id="gas_leak" value=1 disabled/>
					<label>Gas leak?</label>
					</div>
				</div>
		<?php } ?>
		<br>
		
		<!-- additional report remarks -->
			<div class="form-group">
				<input type="checkbox" id="for_repair" name="for_repair" value=1 disabled>
				<label for="temp">Issue/For repair</label><br>
				<textarea class="form-control" id="repair_remarks" name="repair_remarks" rows="3" disabled></textarea>
			</div>
            <div class="form-group">
              	<label for="comments">Other remarks</label>
              	<textarea class="form-control" id="comments" name="other_remarks" rows="3" disabled></textarea>
            </div>
		
		<!-- <button class="btn btn-primary mb-2" type="submit" name="submit">Back to Pending Tasks</button> -->
		</form>
		
	</div>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script type="text/javascript">
		function issueFunction(){
			var field1 = document.getElementById("repair_remarks");
			if (document.getElementById("for_repair").checked) {
				field1.style.display = "table-row";
			}else{
				field1.style.display = "none";
			}
		}	
	</script>
</div>

<?php } ?>