<?php
	session_start();
	include 'header.php';
?>

<head>
	<style>
		#main_content {
			padding: 7%;
		}
	</style>
	<title>Assign new task</title>

</head>
<?php 
    if(isset($_GET['status']) && $_GET['status'] == 'submitted')
    {
    	?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Hey!</strong> Task assigned succesfully
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
    <?php
	}
?>
	<div class="container-fluid py-4" id="main_content">
        <div class="info">
        	<input type="button" class="btn btn-secondary" onclick="history.back()" value="<< Back">
        	<br><br>
					<form class="needs-validation" action="backend/create_task.p.php" method="post" novalidate>
						<?php
						
							if(isset($_GET['asset']) && isset($_GET['machine']) && isset($_GET['e_id']) && isset($_GET['room'])){
								?>
									<div class="form-group">
									<h2>Machine Details</h2>
									<hr class="rounded">
									<label>Type of Machine</label>
									<select class="form-control" name="typeOfMachine" id="typeOfMachine" readonly>
										<option value="<?php echo $_GET['asset'];?>" selected><?php echo $_GET['asset'];?></option>
									</select>
									</div>

									<div class="form-group">
										<label for="formGroupExampleInput2">Machine</label>
										<input type="text" class="form-control" id="machine" name="machine"placeholder="Select Machine" disabled>
										<select class="form-control" name="airconForm" id="HVAC" readonly>
											<option value="<?php echo $_GET['e_id'];?>" selected><?php echo $_GET['machine'], " ", $_GET['room'];?></option>
										</select>
										<select class="form-control" name="gensetForm" id="Genset" readonly>
											<option value="<?php echo $_GET['e_id'];?>" selected><?php echo $_GET['machine'], " ", $_GET['room'];?></option>
										</select>
									</div>
								<?php
							}else{
								?>
								<div class="form-group">
								<h2>Machine Details</h2>
								<hr class="rounded">
								<label>Choose the type of Machine</label><text style="color:red;"> *</text>
								<select class="form-control" name="typeOfMachine" id="typeOfMachine" required>
									<option value="">--</option>
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
									<select class="form-control" name="airconForm" id="HVAC">
									  <option value="">--</option>
										<?php
											include 'backend/get_hvac.p.php';
										?>
									</select>
									<select class="form-control" name="gensetForm" id="Genset">
										<option value="">--</option>
										<?php
											include 'backend/get_genset.p.php';
										?>
									</select>
								</div>
								<?php
							}
						?>
						<br>
						<h2>Task Details </h2>
						<hr class="rounded">
						<div class="form-group">
							<label for="formGroupExampleInput2">What is the task? <text style="color:red;"> *</text></label>
							<input type="text" class="form-control" name="task" placeholder="E.g. Check capacitor" required>
							<div class="invalid-feedback">
								Please fill in this field
							</div>
						</div>
						<div class="form-group">
							<label for="formGroupExampleInput2">Task Description (optional)</label>
							<input type="text" class="form-control" name="taskDesc" placeholder="Describe what the task is all about">
						</div>
						<div class="form-group">
							<label for="typeOfForm">Assign the task to <text style="color:red;"> *</text></label>
							<?php
								if(isset($_GET['u_id']) && isset($_GET['username'])){
									?>
									<select class="form-control" name="assignedTo" readonly>
										  <option value="<?php echo $_GET['u_id'];?>" selected><?php echo $_GET['username'];?></option>
								    </select>
									<?php
								}else{
							?>
							  <select class="form-control" name="assignedTo" required>
								  <option value="">--</option>
									<?php
									include 'backend/get_technicians.p.php';
									?>
							  </select>
							  <div class="invalid-feedback">
								Please choose from the list
							 </div>
							<?php
								}
                            ?>
						</div>
						<div class="form-group">
							<label for="formGroupExampleInput2">Due date <text style="color:red;"> *</text></label>
							<input type="date" class="form-control" min="<?php echo date('Y-m-d')?>" name="dueDate" required>
							<div class="invalid-feedback">
								Please fill in this field
							 </div>
						</div> 
						<button class="btn btn-primary mb-2" type="submit" name="submit" onclick="alert('Are you sure you want to submit?')">Submit</button>
						<button type="reset" class="btn btn-danger mb-2" onclick="alert('Are you sure you want to reset?')">Reset</button>
					</form>
				</div>
    
	</div>
	
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