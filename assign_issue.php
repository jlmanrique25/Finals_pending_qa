<?php
	session_start();
	include 'header.php';
	include 'backend/dbh.p.php';
?>

<head>
	<style>
		#main_content {
			padding: 7%;
		}
	</style>
	<title>Report Equipment Issue</title>
</head>

	<div class="container-fluid py-4" id="main_content">
		<i class="fa-solid fa-chevrons-left"></i><input type="button" class="btn btn-secondary" onClick="document.location.href='/Finals_pending/technician_reports.php?site=My%20Issues%20Reported&page=1'" value="<< Back">
	<br /><br />
        <div class="info"><?php
				if(!isset($_GET['edit'])){
					?>
					<form class="needs-validation" action="backend/create_issue.p.php" method="post" novalidate>
						<?php
						
							if(isset($_GET['asset']) && isset($_GET['machine']) && isset($_GET['e_id']) && isset($_GET['room'])){
								?>
									<div class="form-group">
									<h2>Machine Details</h2>
									<hr class="rounded">
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
								<label>Choose the type of Machine<text style="color:red;"> *</text></label>
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
						<h2>Issue Details</h2>
						<hr class="rounded">
					
						<div class="form-group">
							<label>What is the issue?<text style="color:red;"> *</text></label>
							<input type="text" class="form-control" name="issue" placeholder="E.g. Broken Capacitor" required>
						</div>

						<div class="form-group">
							<label>Issue Description (optional)</label>
							<textarea class="form-control" name="issue_desc" placeholder="Place remarks here"></textarea> 
						</div>
						
						<?php
							if($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Head'){
								?>
								<div class="form-group">
									<label for="typeOfForm">Assign it to<text style="color:red;"> *</text></label>
									  <select class="form-control" name="assignedTo" required>
										  <option value="">--</option>
											<?php
											include 'backend/get_admin.p.php';
											?>
									  </select>
								</div>
								<div class="form-group">
									<label for="formGroupExampleInput2">Due date of the Issue<text style="color:red;"> *</text></label>
									<input type="date" class="form-control" name="dueDate" required>
								</div> 
								<?php
							}
						?>
						
						
						<button class="btn btn-primary mb-2" type="submit" name="submit">Submit</button>
						<button type="reset" class="btn btn-danger mb-2" onclick="alert('Are you sure you want to reset?')">Reset</button>
					</form>
					
					<?php
				
		?>
					
					<?php
				}else if($_GET['edit'] = 'true' && isset($_GET['id'])){
					$sql = "select * from `issue`, equipment, `location`  where issue_id = ".$_GET['id']." AND equipment.equipment_id = issue.machine_id AND equipment.location_id = location.location_id";
					$stmt = mysqli_stmt_init($conn);
					
					$result = mysqli_query($conn, $sql);
					$row = mysqli_fetch_array($result);
					echo $sql;
							?>
							<form action="backend/create_issue.p.php" method="post">
							
							<div class="form-group">
									<h2>Machine Details</h2>
									<hr class="rounded">
									<label>Type of Machine</label>
									<select class="form-control" name="typeOfMachine" id="typeOfMachine">
										<option value="<?php echo $row['asset'];?>" selected><?php echo $row['asset'];?></option>
										<?php
										include 'backend/get_asset.p.php';
										?>
									</select>
									</div>

									<div class="form-group">
										<label for="formGroupExampleInput2">Machine</label>
										<input type="text" class="form-control" id="machine" name="machine"placeholder="Select Machine" disabled>
										<select class="form-control" name="airconForm" id="HVAC" readonly>
											<option value="<?php echo $_GET['id'];?>" selected><?php echo $row['equipment_name'], " ", $row['room'];?></option>
										</select>
										<select class="form-control" name="gensetForm" id="Genset" readonly>
											<option value="<?php echo $row['id'];?>" selected><?php 
											
											echo $row['equipment_name'], " ", $row['floor'];?></option>
										</select>
									</div>

						<div class="form-group">
						<br>
						<h2>Issue Details</h2>
						<hr class="rounded">
							<label>Issue</label>
							<input type="text" class="form-control" name="issue" placeholder="What is the issue?" value = "<?php
								echo $row['issue']
							?>"required>
						</div>

						<div class="form-group">
							<label>Issue Description</label>
							<textarea class="form-control" name="issue_desc" placeholder="Place remarks here"><?php
								echo $row['issue description']
							?></textarea> 
						</div>
						
						<?php
							if($_SESSION['role'] == 'Admin' || $_SESSION['role'] == 'Head'){
								?>
								<div class="form-group">
									<label for="typeOfForm">Assign To</label>
									  <select class="form-control" name="assignedTo" required>
										  <option value="">--</option>
											<?php
											include 'backend/get_admin.p.php';
											?>
									  </select>
								</div>
								<div class="form-group">
									<label for="formGroupExampleInput2">Due date & time</label>
									<input type="datetime-local" class="form-control" name="dueDate" required>
								</div> 
								<?php
							}
						?>
						
						
						<button class="btn btn-primary mb-2" type="submit" name="submit">Submit</button>
					</form>
							<?php
							
						}
					?>
				</div>
				<?php 
    if(isset($_GET['status']) && $_GET['status'] == 'submitted')
    {
                ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Issue Submitted Succesfully</h4>
				  <p>Wanna check out the issue? <a href="technician_reports.php?site=My%20Issues%20Reported&page=1">click here</a>.<br>
				  The issue you have submitted is the following:<?php
				  
					$sql = 'SELECT * FROM issue, equipment, location WHERE issue_id = '.$_GET['id'].' and machine_id = equipment_id AND location.location_id = equipment.location_id';
					
					$row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
					?>
					<ul class="list-group list-group-flush">
					  <li class="list-group-item list-group-item-warning"><strong>Equipment:</strong> <?php echo $row['equipment_name'];?> at the <?php echo $row['floor']?></li>
					  <li class="list-group-item list-group-item-warning"><strong>Issue:</strong> <?php echo $row['issue'];?></li>
					  <li class="list-group-item list-group-item-warning"><strong>Issue Description:</strong> <?php echo $row['issue description'];?></li>
					</ul>
					<?php
				  ?>
				  </p>
				  <hr>
				  <p class="mb-0">Made a mistake?<strong> <a href= "#">UNDO</a></strong></p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
    <?php
	}
?>
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