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
					<form action="backend/create_task.p.php" method="post">
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
								<label>Type of Machine</label>
								<select class="form-control" name="typeOfMachine" id="typeOfMachine">
									<option value="none">--</option>
									<?php
										include 'backend/get_asset.p.php';
									?>
								</select>
								</div>

								<div class="form-group">
									<label for="formGroupExampleInput2">Machine</label>
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
						<h2>Task Details</h2>
						<hr class="rounded">
						<div class="form-group">
							<label for="formGroupExampleInput2">Task</label>
							<input type="text" class="form-control" name="task" placeholder="Task">
						</div>
						<div class="form-group">
							<label for="formGroupExampleInput2">Task Description</label>
							<input type="text" class="form-control" name="taskDesc" placeholder="Task Description">
						</div>
						<div class="form-group">
							<label for="typeOfForm">Assign To</label>
							<?php
								if(isset($_GET['u_id']) && isset($_GET['username'])){
									?>
									<select class="form-control" name="assignedTo" readonly>
										  <option value="<?php echo $_GET['u_id'];?>" selected><?php echo $_GET['username'];?></option>
								    </select>
									<?php
								}else{
							?>
							  <select class="form-control" name="assignedTo">
								  <option value="">--</option>
									<?php
									include 'backend/get_technicians.p.php';
									?>
							  </select>
							<?php
								}
							?>
						</div>
						<div class="form-group">
							<label for="formGroupExampleInput2">Due date & time</label>
							<input type="datetime-local" class="form-control" name="dueDate">
						</div> 
						<button class="btn btn-primary mb-2" type="submit" name="submit">Submit</button>
					</form>
				</div>
    
	</div>
	
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	
	<script type="text/javascript">		
	
	$("#typeOfMachine").change(function() {
			if ($(this).val() == "Genset") {
				$('#machine').hide();
				$('#Genset').show();
				$('#HVAC').hide();
			}else if ($(this).val() == "HVAC") {
				$('#machine').hide();
				$('#Genset').hide();
				$('#HVAC').show();
			}else {
				$('#machine').show();
				$('#Genset').hide();
				$('#HVAC').hide();
			}
		});
		$("#typeOfMachine").trigger("change");
	</script>
	</div> 