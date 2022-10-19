<?php
session_start();
include 'header.php';
include 'backend/view_issue.p.php';

$sql_m = "SELECT equipment_id, equipment_name, asset FROM equipment WHERE equipment_id = ".$row_i['machine_id']."";
$result_m = mysqli_query($conn, $sql_m);
$row_m = mysqli_fetch_assoc($result_m);


$sql_u = "SELECT users_id, username FROM users WHERE users_id = ".$row_i['assigned_to']."";
$result_u = mysqli_query($conn, $sql_u);
$row_u = mysqli_fetch_assoc($result_u);

?>

<div class="container-fluid py-4" id="main_content">
<input type="button" class="btn btn-secondary" onclick="history.back()" value="<< Back">
<br><br>
	<h1>Editing issue report</h1>
	<h2><?php echo $row_i['issue'], " : equipment ", $row_m['equipment_name'];?></h2>
	<hr class="rounded">
	<h5>Date issue created: <?php echo $row_i['date_created']?></h5>
	<h5 class="mb-5">Assigned to: <?php echo $row_u['username'];?></h5>

	<div class="form-group">
	<form method="post" action="backend/update_issue.p.php?id=<?php echo $_GET['id'];?>">
		<div class="form-group">
				<h2>Machine Details</h2>
				<hr class="rounded">
				<label>Choose the type of Machine</label><text style="color:red;"> *</text>
				<select class="form-control" name="typeOfMachine" id="typeOfMachine" required <?php if ($row_i['issue_status'] == 1){
                                                                                                        echo 'disabled';
                                                                                                    }?>>
					<option value="<?php echo $row_m['asset']?>" selected><?php echo $row_m['asset']?></option>
					<?php
                    include 'backend/get_asset.p.php';
                    ?>
				</select>
				<div class="invalid-feedback">
					Please choose from the list
				</div>
			</div>

			<div class="form-group">
				<label id="label">Name of the Machine<text style="color:red;"> *</text></label>
				<input type="text" class="form-control" id="machine" name="machine"placeholder="Select Machine" disabled>
				<select class="form-control" name="airconForm" id="HVAC" <?php if ($row_i['issue_status'] == 1){
                                                                                                        echo 'disabled';
                                                                                                    }?>>
					<option value="<?php echo $row_m['equipment_id']?>" selected><?php echo $row_m['equipment_name']?></option>
					<?php
                    include 'backend/get_hvac.p.php';
                    ?>
				</select>
				<select class="form-control" name="gensetForm" id="Genset" <?php if ($row_i['issue_status'] == 1){
                                                                                                        echo 'disabled';
                                                                                                    }?>>
					<option value="<?php echo $row_m['equipment_id']?>" selected><?php echo $row_m['equipment_name']?></option>
					<?php
                    include 'backend/get_genset.p.php';
                    ?>
				</select>
			</div>

			


			<br>
			<h2>Task Details </h2>
			<hr class="rounded">
			<div class="form-group">
				<label for="formGroupExampleInput2">What is the issue? <text style="color:red;"> *</text></label>
				<input type="text" class="form-control" name="task" placeholder="E.g. Check capacitor"  value="<?php echo $row_i['issue'];?>" required 
				<?php if ($row_i['issue_status'] == 1){
                                                                                                        echo 'disabled';
                                                                                                    }?>>
				<div class="invalid-feedback">
					Please fill in this field
				</div>
			</div>
			<div class="form-group">
				<label for="formGroupExampleInput2">Issue Description (optional)</label>
				<input type="text" class="form-control" name="taskDesc" placeholder="Describe what the task is all about" value="<?php echo $row_i['description'];?>" <?php if ($row_i['issue_status'] == 1){
                                                                                                        echo 'disabled';
                                                                                                    }?>>
			</div>
			<div class="form-group">
				<label for="typeOfForm">Assign the task to <text style="color:red;"> *</text></label>
					<?php
					
					?>
					<select class="form-control" name="assignedTo" required <?php if ($row_i['issue_status'] == 1){
                                                                                                        echo 'disabled';
                                                                                                    }?>>
						<option value="<?php echo $row_u['users_id'];?>" selected><?php echo $row_u['username'];?></option>
						<?php
                    include 'backend/get_technicians.p.php';
                        ?>
					</select>
					<div class="invalid-feedback">
					Please choose from the list
					</div>
				<?php
                
                ?>
			</div>
			<div class="form-group">
				<label for="formGroupExampleInput2">Due date <text style="color:red;"> *</text></label>
				<input type="date" class="form-control" name="dueDate" min="<?php echo date('Y-m-d')?>" value="<?php echo $row_i['date_due'];?>" required <?php if ($row_i['issue_status'] == 1){
                                                                                                        echo 'disabled';
                                                                                                    }?>>
				<div class="invalid-feedback">
					Please fill in this field
					</div>
			</div> 
			<?php 
			if ($row_i['issue_status'] != 1)
            {
				echo '<button class="btn btn-primary mb-2" type="submit" name="submit" onclick="alert("Are you sure you want to update the issue?")">
				Update
			</button>';
			}?>
			
			
		</form>
</div>
</div>

<!--
	SCRIPT FOR THE DROPDOWN
-->

<!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>-->

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

	
<script type="text/javascript">		
	
$("#typeOfMachine").change(function() {
		if ($(this).val() == "Genset") {
			$('#machine').hide();
			$('#Genset').show();
			$('#HVAC').hide();
			$('#label').show();
		}else if ($(this).val() == "HVAC") {
			$('#machine').hide();
			$('#Genset').hide();
			$('#HVAC').show();
			$('#label').show();
		}else {
			$('#machine').hide();
			$('#Genset').hide();
			$('#HVAC').hide();
			$('#label').hide();
		}
	});
	$("#typeOfMachine").trigger("change");
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

<!-- script for alerting unsaved changes when clicking back button -->
<!-- <script type="text/javascript">
	window.onbeforeunload = function() {
		return "Data will be lost if you leave the page, are you sure?";
	};
</script> -->
	
	</div> 