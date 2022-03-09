<head>
	<style>
		#main_content {
			padding: 7%;
		}
	</style>
	<title>Add New Equipment</title>
</head>
<?php
	session_start();
	include 'header.php';
?>
<?php 
    if(isset($_GET['status']) && $_GET['status'] == 'submitted')
    {
    	?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Hey!</strong> Equipment added successfully
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
    <?php
	}
?>
	<div class="container-fluid py-4" id="main_content">
        <div class="info">
					<form action="backend/get_new_equipment.p.php" method="post">
						<h2>Equipment Details</h2>
						<hr class="rounded">
						<div class="form-group">
							<div class="row">
								<div class="col">
									<label>Equipment Name</label>
									<input type="text" class="form-control" name="equipment_name" placeholder="Equipment Name">
								</div>
								<div class="col">
									<label>Asset</label>
									<select class="form-control" name="asset" required>
										<option value="">--</option>
										<option value="HVAC">HVAC</option>
										<option value="Genset">Genset</option>
									</select>
								</div>
							</div><br>
							<div class="row">
								<div class="col">
									<label>Brand</label>
									<input type="text" class="form-control" name="brand" placeholder="Brand">
								</div>
								<div class="col">
									<label>Machine Description</label>
									<input type="text" class="form-control" name="machine_description" placeholder="Machine Description">
								</div>
							</div><br>
							<div class="row">
								<div class="col">
									<label>Model no.</label>
									<input type="text" class="form-control" name="model_no" placeholder="Model no.">
								</div>
								<div class="col">
									<label>Serial no.</label>
									<input type="number" class="form-control" name="serial_no" placeholder="Serial no.">
								</div>
							</div><br>
							<div class="row">
								<div class="col">
									<label>Date of purchase</label>
									<input type="date" class="form-control" name="date_of_purchase">
								</div>
							</div><br>
						<h2>Equipment Location</h2>
						<hr class="rounded">
							<div class="row">
								<div class="col">
									<label>Floor</label>
									<select class="form-control" name="floor" required>
										<option value="">--</option>
										<option value="Basement 3">Basement 3</option>
										<option value="Basement 2">Basement 2</option>
										<option value="Basement 1">Basement 1</option>
										<option value="1st floor">1st floor</option>
										<option value="2nd floor">2nd floor</option>
										<option value="3rd floor">3rd floor</option>
										<option value="4th floor">4th floor</option>
										<option value="5th floor">5th floor</option>
										<option value="6th floor">6th floor</option>
										<option value="7th floor">7th floor</option>
										<option value="8th floor">8th floor</option>
										<option value="9th floor">9th floor</option>
										<option value="10th floor">10th floor</option>
										<option value="11th floor">11th floor</option>
										<option value="12th floor">12th floor</option>
									</select>
								</div>
								<div class="col">
									<label>Room number</label>
									<input type="text" class="form-control" name="room_number" placeholder="Room number">
								</div>
								<div class="col">
									<label>Room Classification</label>
									<input type="text" class="form-control" name="room_classification" placeholder="Room classification">
								</div>
							</div><br>
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