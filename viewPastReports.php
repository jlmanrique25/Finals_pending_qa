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

if($_GET['site'] == "My Past Reports"){
?>

<head>
	<style>
		#main_content{
			padding: 7%;
		}
	</style>
	<title>Create Status Report</title>
</head>

<div class="container-fluid py-4" id="main_content">
		<input type="button" class="btn btn-secondary" onclick="history.back()" value="<< Back">
		<br /><br />
		<!-- assigned task info -->
		<h2><?php echo  '#R-'.$row_report['report_id'].' '.$row_report['task']; ?> : equipment <?php echo $row_equipment['equipment_name']; ?></h2>
		<hr class="rounded" />
		<div class="row mb-4">
			<div class="col-8">
				<h5>Due Date: <?php echo $row_report['task_due']; ?></h5>
			</div>
			<div class="col-4">
				<h5 class="mb-5">Date created: <?php echo $row_report['date_created'];?></h5>
			</div>
		</div>
		
		<!-- form submission based on asset -->
		<?php
		if('HVAC' == $row_equipment['asset']) { 
			
			
			/**
             * 
             * IF FORM IS ALREADY COMPLETED VIEW
             * 
             * **/
			if($row_report['report_status'] != 'unresolved')
            {

				$sql_readings = "SELECT * FROM `equipment_readings_aircon` WHERE report_id = '".$row_report['report_id']."'";
				
                
                if(!mysqli_stmt_prepare($stmt, $sql_readings)){
                    echo 'error connecting to database equipment_readings_aircon';
                }else{	
                    $result_read = mysqli_query($conn, $sql_readings);
                    $row_equipment = mysqli_fetch_assoc($result_read);
                }


                ?>
				<form class="needs-validation"  method="post" action="backend/redo_report.p.php?r_id=<?php echo $row_report['report_id'];?>&e_id=<?php echo $row_report['machine_id'];?>&site=Report%20Submitted" novalidate>
				<div class="row mb-4">
	              <div class="col-4">
	                <label for="volt">Voltage<text style="color:red;"> *</text></label>
	                <input type="text" class="form-control w-100" name="volt" id="volt" value="<?php echo $row_equipment['volt']; ?> V" disabled>
	                	<div class="invalid-feedback">
							Please fill in this field
						</div>
	              </div>

				  <div class="col-4">
	                <label for="pressure">Pressure<text style="color:red;"> *</text></label>
	                <input type="text" class="form-control w-100" name="pressure" id="pressure" value="<?php echo $row_equipment['pressure'] ?> psi" disabled>
	                	<div class="invalid-feedback">
							Please fill in this field
						</div>
	              </div>

				  <div class="col-4">
	                <label for="temp">Temperature<text style="color:red;"> *</text></label>
	                <input type="text" class="form-control w-100" name="temp" id="temp" value="<?php echo $row_equipment['temp'] ?> F" disabled>
	                	<div class="invalid-feedback">
							Please fill in this field
						</div>
	              </div>
	            </div> 
				<?php
            }

			/***
             * 
             * IF REPORT IS RE OPENED
             * 
             * ***/

			else if($row_report['date_submitted']){

				$sql_readings = "SELECT * FROM `equipment_readings_aircon` WHERE report_id = '".$row_report['report_id']."'";
				
                
                if(!mysqli_stmt_prepare($stmt, $sql_readings)){
                    echo 'error connecting to database equipment_readings_aircon';
                }else{	
                    $result_read = mysqli_query($conn, $sql_readings);
                    $row_equipment = mysqli_fetch_assoc($result_read);
                }
                ?>
				<form class="needs-validation"  method="post" action="backend/update_report_HVAC.p.php?r_id=<?php echo $row_report['report_id'];?>&e_id=<?php echo $row_report['machine_id'];?>&site=Report%20Submitted" novalidate>
				<div class="row mb-4">
	              <div class="col-4">
	                <label for="volt">Voltage<text style="color:red;"> *</text></label>
	                <input type="number" class="form-control w-100" name="volt" id="volt" value="<?php echo $row_equipment['volt']; ?>" >
	                	<div class="invalid-feedback">
							Please fill in this field
						</div>
	              </div>

				  <div class="col-4">
	                <label for="pressure">Pressure<text style="color:red;"> *</text></label>
	                <input type="number" class="form-control w-100" name="pressure" id="pressure" value="<?php echo $row_equipment['pressure'] ?>" >
	                	<div class="invalid-feedback">
							Please fill in this field
						</div>
	              </div>

				  <div class="col-4">
	                <label for="temp">Temperature<text style="color:red;"> *</text></label>
	                <input type="number" class="form-control w-100" name="temp" id="temp" value="<?php echo $row_equipment['temp'] ?>" >
	                	<div class="invalid-feedback">
							Please fill in this field
						</div>
	              </div>
	            </div> 
				<?php
            }
			
			/*
             * 
             * IF FORM IS NOT YET COMPLETED VIEW
             * 
             * **/
			
			
			else
            {
               
				?>

				<form class="needs-validation" action="backend/submit_report_HVAC.p.php?r_id=<?php echo $row_report['report_id'];?>&e_id=<?php echo $row_report['machine_id'];?>" method="post" novalidate>
				<div class="row mb-4">
	              <div class="col-4">
	                <label for="volt">Voltage<text style="color:red;"> *</text></label>
	                <input type="number" class="form-control w-100" name="volt" id="volt" required>
	                	<div class="invalid-feedback">
							Please fill in this field
						</div>
	              </div>

				  <div class="col-4">
	                <label for="pressure">Pressure<text style="color:red;"> *</text></label>
	                <input type="number" class="form-control w-100" name="pressure" id="pressure" required>
	                	<div class="invalid-feedback">
							Please fill in this field
						</div>
	              </div>

				  <div class="col-4">
	                <label for="temp">Temperature<text style="color:red;"> *</text></label>
	                <input type="number" class="form-control w-100" name="temp" id="temp"required>
	                	<div class="invalid-feedback">
							Please fill in this field
						</div>
	              </div>
	            </div> 
				
				<?php
			
            }

			?>
			
		<?php }else { 

			//IF REPORT IS FOR VIEWING ONLY
			if($row_report['report_status'] != 'unresolved')
            {
				//getting the readings of specific record
				$sql_readings = "SELECT * FROM `equipment_readings_genset` WHERE report_id = '".$row_report['report_id']."'";
	
				if(!mysqli_stmt_prepare($stmt, $sql_readings)){
					echo 'error connecting to database equipment_readings_genset';
				}else{	
					$result_genset = mysqli_query($conn, $sql_readings);
					$row_equipment = mysqli_fetch_assoc($result_genset);
				}
                ?>
				<form class="needs-validation" action="backend/redo_report.p.php?r_id=<?php echo $row_report['report_id'];?>&e_id=<?php echo $row_report['machine_id'];?>&site=Report%20Submitted" method="post" novalidate>
				<div class="row mb-4">
				  <label for="Voltage">Voltage</label>
	              <div class="col-4">
	                <input type="number" class="form-control w-100" name="v1" id="voltage_line_1" placeholder="Line 1: <?php echo $row_equipment['voltage_line_1'] ?> V" disabled>
	              </div>
				  <div class="col-4">
				  <input type="number" class="form-control w-100" name="v2" id="voltage_line_2" placeholder="Line 2: <?php echo $row_equipment['voltage_line_2'] ?> V" disabled>
	              </div>
				  <div class="col-4">
				  <input type="number" class="form-control w-100" name="v3" id="voltage_line_3" placeholder="Line 3: <?php echo $row_equipment['voltage_line_3'] ?> V" disabled>
	              </div>
	            </div>
				<br>
				<div class="row mb-4">
				  <label for="Current">Current</label>
	              <div class="col-4">
	                <input type="number" class="form-control w-100" name="c1" id="current_line_1" placeholder="Line 1: <?php echo $row_equipment['current_line_1'] ?> A" disabled>
	              </div>
				  <div class="col-4">
				  <input type="number" class="form-control w-100" name="c2" id="current_line_2" placeholder="Line 2: <?php echo $row_equipment['current_line_2'] ?> A" disabled>
	              </div>
				  <div class="col-4">
				  <input type="number" class="form-control w-100" name="c3" id="current_line_3" placeholder="Line 3: <?php echo $row_equipment['current_line_3'] ?> A" disabled>
	              </div>
	            </div>
				<br>
				<div class="row mb-4">
	              <div class="col-4">
				    <label for="frequency">Frequency</label>
	                <input type="number" class="form-control w-100" name="frequency" id="frequency" placeholder="<?php echo $row_equipment['frequency'] ?> hz" disabled>
	              </div>
				  <div class="col-4">
				    <label for="battery_voltage">Battery Voltage</label>
	                <input type="number" class="form-control w-100" name="battery_voltage" id="battery_voltage" placeholder="<?php echo $row_equipment['battery_voltage'] ?> V" disabled>
	              </div>
				  <div class="col-4">
				  <label for="running_hours">Running Hours</label>
				  <input type="number" class="form-control w-100" name="running_hours" id="running_hours" placeholder=" <?php echo $row_equipment['running_hours'] ?> h" disabled>
	              </div>
	            </div>
				<br>
				<div class="row mb-4">
	              <div class="col-6">
				    <label for="oil_pressure">Oil Pressure</label>
	                <input type="number" class="form-control w-100" name="oil_pressure" id="oil_pressure" placeholder="<?php echo $row_equipment['oil_pressure'] ?> psi" disabled>
	              </div>
				  <div class="col-6">
				  <label for="oil_temperature">Oil Temperature</label>
				  <input type="number" class="form-control w-100" name="oil_temperature" id="oil_temperature" placeholder="<?php echo $row_equipment['oil_temperature'] ?> F" disabled>
	              </div>
	            </div>
				<br>
				<div class="row mb-4">
				  <div class="col-6">
				    <label for="rotation">Frequency of Rotation</label>
	                <input type="number" class="form-control w-100" name="rotation" id="rotation" placeholder="<?php echo $row_equipment['rotation'] ?> rpm" disabled>
	              </div>
	              <div class="col-6">
				    <label for="fuel_level">Fuel Level</label>
	                <input type="number" class="form-control w-100" name="fuel_level" id="fuel_level" placeholder="<?php echo $row_equipment['fuel_level'] ?> L" disabled>
	              </div>
	            </div>
				<br>
				<div class="row mb-4">
					<div class="col-12">
				  	<input type="checkbox" name="abnormal_sound" id="abnormal_sound"
					<?php if ($row_equipment['abnormal_sound'] == 1) { ?>
        			checked
    				<?php }?> disabled/>
					<label>Any abnormal sounds?</label>
					</div>
				</div>
				<div class="row mb-4">
					<div class="col-12">
				  	<input type="checkbox" name="gas_leak" id="gas_leak"
					<?php if ($row_equipment['gas_leak'] == 1) { ?>
        			checked
    				<?php }?> disabled/>
					<label>Gas leak?</label>
					</div>
				</div>
				<br>


				<?php
				
            }

			/**
             * 
             * IF report is re opened
             * 
             * **/

			else if($row_report['date_submitted']){
                
				//getting the readings of specific record
				$sql_readings = "SELECT * FROM `equipment_readings_genset` WHERE report_id = '".$row_report['report_id']."'";
	
				if(!mysqli_stmt_prepare($stmt, $sql_readings)){
					echo 'error connecting to database equipment_readings_genset';
				}else{	
					$result_genset = mysqli_query($conn, $sql_readings);
					$row_equipment = mysqli_fetch_assoc($result_genset);
				}
                ?>
				<form class="needs-validation" action="backend/update_report_genset.p.php?r_id=<?php echo $row_report['report_id'];?>&e_id=<?php echo $row_report['machine_id'];?>&site=Report%20Submitted" method="post" novalidate>
				<div class="row mb-4">
				  <label for="Voltage">Voltage</label>
	              <div class="col-4">
	                <input type="number" class="form-control w-100" name="v1" id="voltage_line_1" placeholder="Line 1:" value = "<?php echo $row_equipment['voltage_line_1'] ?>" >
	              </div>
				  <div class="col-4">
				  <input type="number" class="form-control w-100" name="v2" id="voltage_line_2" placeholder="Line 2" value="<?php echo $row_equipment['voltage_line_2'] ?>" >
	              </div>
				  <div class="col-4">
				  <input type="number" class="form-control w-100" name="v3" id="voltage_line_3" placeholder="Line 3" value="<?php echo $row_equipment['voltage_line_3'] ?>" >
	              </div>
	            </div>
				<br>
				<div class="row mb-4">
				  <label for="Current">Current</label>
	              <div class="col-4">
	                <input type="number" class="form-control w-100" name="c1" id="current_line_1" placeholder="Line 1" value="<?php echo $row_equipment['current_line_1']?>" >
	              </div>
				  <div class="col-4">
				  <input type="number" class="form-control w-100" name="c2" id="current_line_2" placeholder="Line 2" value="<?php echo $row_equipment['current_line_2'] ?>" >
	              </div>
				  <div class="col-4">
				  <input type="number" class="form-control w-100" name="c3" id="current_line_3" placeholder="Line 3" value="<?php echo $row_equipment['current_line_3'] ?>" >
	              </div>
	            </div>
				<br>
				<div class="row mb-4">
	              <div class="col-4">
				    <label for="frequency">Frequency</label>
	                <input type="number" class="form-control w-100" name="frequency" id="frequency" placeholder="Z" value="<?php echo $row_equipment['frequency'] ?>">
	              </div>
				  <div class="col-4">
				    <label for="battery_voltage">Battery Voltage</label>
	                <input type="number" class="form-control w-100" name="battery_voltage" id="battery_voltage" placeholder="V" value="<?php echo $row_equipment['battery_voltage'] ?>">
	              </div>
				  <div class="col-4">
				  <label for="running_hours">Running Hours</label>
				  <input type="number" class="form-control w-100" name="running_hours" id="running_hours" placeholder="H" value=" <?php echo $row_equipment['running_hours'] ?>">
	              </div>
	            </div>
				<br>
				<div class="row mb-4">
	              <div class="col-6">
				    <label for="oil_pressure">Oil Pressure</label>
	                <input type="number" class="form-control w-100" name="oil_pressure" id="oil_pressure" placeholder="psi" value="<?php echo $row_equipment['oil_pressure'] ?>">
	              </div>
				  <div class="col-6">
				  <label for="oil_temperature">Oil Temperature</label>
				  <input type="number" class="form-control w-100" name="oil_temperature" id="oil_temperature" placeholder="temp" value="<?php echo $row_equipment['oil_temperature'] ?>">
	              </div>
	            </div>
				<br>
				<div class="row mb-4">
				  <div class="col-6">
				    <label for="rotation">Frequency of Rotation</label>
	                <input type="number" class="form-control w-100" name="rotation" id="rotation" placeholder="rpm" value="<?php echo $row_equipment['rotation'] ?>">
	              </div>
	              <div class="col-6">
				    <label for="fuel_level">Fuel Level</label>
	                <input type="number" class="form-control w-100" name="fuel_level" id="fuel_level" placeholder="L" value="<?php echo $row_equipment['fuel_level'] ?>">
	              </div>
	            </div>
				<br>
				<div class="row mb-4">
					<div class="col-12">
				  	<input type="checkbox" name="abnormal_sound" id="abnormal_sound"
					<?php if ($row_equipment['abnormal_sound'] == 1) { ?>
        			checked
    				<?php }?> />
					<label>Any abnormal sounds?</label>
					</div>
				</div>
				<div class="row mb-4">
					<div class="col-12">
				  	<input type="checkbox" name="gas_leak" id="gas_leak"
					<?php if ($row_equipment['gas_leak'] == 1) { ?>
        			checked
    				<?php }?> />
					<label>Gas leak?</label>
					</div>
				</div>
				<br>

				<?php

            }


			//IF REPORT IS NOT YET ACCOMPLISHED
			else
            {
                ?>
				<form class="needs-validation" action="backend/submit_report_Genset.p.php?r_id=<?php echo $row_report['report_id'];?>&e_id=<?php echo $row_report['machine_id'];?>&site=Report%20Submitted" method="post" novalidate>
			<div class="row mb-4">
				  <label for="Voltage">Voltage<text style="color:red;"> *</text></label>
	              <div class="col-4">
	                <input type="number" class="form-control w-100" name="v1" id="voltage_line_1" placeholder="Line 1" required>
	                	<div class="invalid-feedback">
							Please fill in this field
						</div>
	              </div>

				  <div class="col-4">
				  <input type="number" class="form-control w-100" name="v2" id="voltage_line_2" placeholder="Line 2" required>
				  		<div class="invalid-feedback">
							Please fill in this field
						</div>
	              </div>

				  <div class="col-4">
				  <input type="number" class="form-control w-100" name="v3" id="voltage_line_3" placeholder="Line 3" required>
				  		<div class="invalid-feedback">
							Please fill in this field
						</div>
	              </div>

	            </div>
				<br>
				<div class="row mb-4">
				  <label for="Current">Current<text style="color:red;"> *</text></label>
	              <div class="col-4">
	                <input type="number" class="form-control w-100" name="c1" id="current_line_1" placeholder="Line 1" required>
	                	<div class="invalid-feedback">
							Please fill in this field
						</div>
	              </div>

				  <div class="col-4">
				  <input type="number" class="form-control w-100" name="c2" id="current_line_2" placeholder="Line 2" required>
				  	<div class="invalid-feedback">
							Please fill in this field
						</div>
	              </div>

				  <div class="col-4">
				  <input type="number" class="form-control w-100" name="c3" id="current_line_3" placeholder="Line 3" required>
				  		<div class="invalid-feedback">
							Please fill in this field
						</div>
	              </div>
	            </div>
				<br>
				<div class="row mb-4">
	              <div class="col-4">
				    <label for="frequency">Frequency<text style="color:red;"> *</text></label>
	                <input type="number" class="form-control w-100" name="frequency" id="frequency" placeholder="hz" required>
	                	<div class="invalid-feedback">
							Please fill in this field
						</div>
	              </div>

				  <div class="col-4">
				    <label for="battery_voltage">Battery Voltage<text style="color:red;"> *</text></label>
	                <input type="number" class="form-control w-100" name="battery_voltage" id="battery_voltage" placeholder="V" required>
	                	<div class="invalid-feedback">
							Please fill in this field
						</div>
	              </div>

				  <div class="col-4">
				  <label for="running_hours">Running Hours<text style="color:red;"> *</text></label>
				  <input type="number" class="form-control w-100" name="running_hours" id="running_hours" placeholder="h" required>
				  		<div class="invalid-feedback">
							Please fill in this field
						</div>
	              </div>

	            </div>
				<br>
				<div class="row mb-4">
	              <div class="col-6">
				    <label for="oil_pressure">Oil Pressure<text style="color:red;"> *</text></label>
	                <input type="number" class="form-control w-100" name="oil_pressure" id="oil_pressure" placeholder="psi"required>
	                <div class="invalid-feedback">
						Please fill in this field
					</div>
	              </div>
				  <div class="col-6">
				  <label for="oil_temperature">Oil Temperature<text style="color:red;"> *</text></label>
				  <input type="number" class="form-control w-100" name="oil_temperature" id="oil_temperature" placeholder="F" required>
				  	<div class="invalid-feedback">
						Please fill in this field
					</div>
	              </div>
	            </div>
				<br>
				<div class="row mb-4">
				  <div class="col-6">
				    <label for="rotation">Frequency of Rotation<text style="color:red;"> *</text></label>
	                <input type="number" class="form-control w-100" name="rotation" id="rotation" placeholder="rpm" required>
	                <div class="invalid-feedback">
						Please fill in this field
					</div>
	              </div>
	              <div class="col-6">
				    <label for="fuel_level">Fuel Level<text style="color:red;"> *</text></label>
	                <input type="number" class="form-control w-100" name="fuel_level" id="fuel_level" placeholder="L" required>
	                <div class="invalid-feedback">
						Please fill in this field
					 </div>
	              </div>
	            </div>
				<br>
				<div class="row mb-4">
					<div class="col-12">
				  	<input type="checkbox" name="abnormal_sound" id="abnormal_sound" value=1/>
					<label>Any abnormal sounds?</label>
					</div>
				</div>
				<div class="row mb-4">
					<div class="col-12">
				  	<input type="checkbox" name="gas_leak" id="gas_leak" value=1/>
					<label>Gas leak?</label>
					</div>
				</div>


				<?php
				
            }
			
			?>
			
		<?php } ?>
		<br>
		
		<!-- additional report remarks -->
			<div class="form-group">
				<input type="checkbox" id="for_repair" name="for_repair" value="1" 
				<?php
					if($row_report['report_status'] != 'unresolved')
                    {
                        if($row_equipment['for_repair']){
                            echo 'checked ';
                        }
						echo 'disabled';
                    }
					elseif($row_report['date_submitted']){
                        if($row_equipment['for_repair']){
                            echo 'checked ';
                        }
                    }
                ?>
					   >

				<label for="temp">Issue/For repair</label><br>
				<textarea class="form-control" id="repair_remarks" name="repair_remarks" rows="3" placeholder="Describe the issue here"
				
				<?php
					if($row_report['report_status'] != 'unresolved')
					{
						echo 'disabled';
					}
                ?>
					  
						  ><?php
				if($row_report['report_status'] != 'unresolved')
					{
						if($row_equipment['for_repair']){
							echo $row_equipment['repair_remarks'];
						}
						
				}?><?php if($row_report['date_submitted']){echo $row_equipment['repair_remarks'];} ?></textarea>
			</div>
            <div class="form-group">
              	<label for="comments">Other remarks</label>
              	<textarea class="form-control" id="comments" name="other_remarks" rows="3" placeholder="Add some additional information here"
						  
				<?php
					if($row_report['report_status'] != 'unresolved')
					{
						echo 'disabled';
					}
                ?>><?php
    if($row_report['report_status'] != 'unresolved')
    {
        
            echo $row_equipment['other_remarks'];
        
        
    }?><?php if($row_report['date_submitted']){echo $row_equipment['other_remarks'];} ?></textarea>
            </div>
		
		<?php
			if($row_report['report_status'] == 'unresolved')
			{
			?>
			<button class="btn btn-primary mb-2" type="submit" name="submit">Submit</button>
			<button type="reset" class="btn btn-danger mb-2" onclick="alert('Are you sure you want to reset?')">Reset</button>
				<?php
			}else{
                ?>
				<button class="btn btn-success mb-2 btn-lg" type="submit" name="submit"><i class="fas fa-clipboard-check"></i> Re-Open Issue</button>
				<?php
            }
        ?>
		
		</form>

		
	</div>
	<<!--script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>-->
	
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


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

	<!-- script for field validations -->
	<script type="text/javascript">
		// Example starter JavaScript for disabling form submissions if there are invalid fields
		(function () {
		  'use strict'

		  // Fetch all the forms we want to apply custom Bootstrap validation styles to
		  var forms = document.querySelectorAll('.needs-validation')

		  // Loop over them and prevent submission
		  Array.prototype.slice.call(forms)
		    .forEach(function (form) {
		      form.addEventListener('submit', function (event) {
		        if (!form.checkValidity()) {
		          event.preventDefault()
		          event.stopPropagation()
		        }

		        form.classList.add('was-validated')
		      }, false)
		    })
		})()
	</script>


</div>

<?php } ?>