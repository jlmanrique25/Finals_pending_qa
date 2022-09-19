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

	<input type="button" class="btn btn-secondary" onclick="document.location.href='/Finals_pending/equipment.php?site=Equipment&page=1'" value="<< Back"><br><br>

        <div class="info">
					<form class="needs-validation" action="backend/get_new_equipment.p.php" method="post" novalidate>
						<h2>Equipment Details</h2>
						<hr class="rounded">
						<div class="form-group">
							<div class="row">
								<div class="col">
									<label>Enter Equipment Name<text style="color:red;"> *</text></label>
									<input type="text" class="form-control" name="equipment_name" placeholder="E.g. FUJI-75 Aircon" required>
								</div>
								<div class="col">
									<label>Choose Asset<text style="color:red;"> *</text></label>
									<select class="form-control" name="asset" required>
										<option value="">--</option>
										<option value="HVAC">HVAC</option>
										<option value="Genset">Genset</option>
									</select><div class="invalid-feedback">
								      Please choose from the list
								    </div>
								</div>
							</div><br>
							<div class="row">
								<div class="col">
									<label>Brand of the Equipment<text style="color:red;"> *</text></label>
									<input type="text" class="form-control" name="brand" placeholder="E.g. Toshiba" required>
									<div class="invalid-feedback">
								      Please fill in this field
								    </div>
								</div>
								<div class="col">
									<label>Machine Description (Optional)</label>
									<input type="text" class="form-control" name="machine_description" placeholder="Describe here the equipment">
								</div>
							</div><br>
							<div class="row">
								<div class="col">
									<label>Model no.<text style="color:red;"> *</text></label>
									<input type="text" class="form-control" name="model_no" placeholder="E.g. FUJI752022" required>
									<div class="invalid-feedback">
								      Please fill in this field
								    </div>
								</div>
								<div class="col">
									<label>Serial no.<text style="color:red;"> *</text></label>
									<input type="number" class="form-control" name="serial_no" placeholder="E.g. 61977" required>
									<div class="invalid-feedback">
								      Please fill in this field
								    </div>
								</div>
							</div><br>
							<div class="row">
								<div class="col">
									<label>Date of purchase<text style="color:red;"> *</text></label>
									<input type="date" class="form-control" name="date_of_purchase"required>
								</div>
								<div class="invalid-feedback">
								      Please fill in this field
								 </div>
							</div><br>
						<h2>Equipment Location</h2>
						<hr class="rounded">
							<div class="row">
								<div class="col">
									<label>Floor<text style="color:red;"> *</text></label>
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
									<div class="invalid-feedback">
								      Please choose from the list
								    </div>
								</div>
								<div class="col">
									<label>Room number<text style="color:red;"> *</text></label>
									<input type="text" class="form-control" name="room_number" placeholder="E.g. 309-A" required>
									<div class="invalid-feedback">
								      Please fill in this field
								    </div>
								</div>
								<div class="col">
									<label>Room Classification<text style="color:red;"> *</text></label>
									<input type="text" class="form-control" name="room_classification" placeholder="E.g. computer lab" required>
									<div class="invalid-feedback">
								      Please fill in this field
								    </div>
								</div>
								</div>
							</div><br>
						</div>
						
						<button class="btn btn-primary mb-2" type="submit" name="submit" onclick="alert('Are you sure you want to submit?')">Submit</button>
						<button type="reset" class="btn btn-danger mb-2" onclick="alert('Are you sure you want to reset?')">Reset</button>
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