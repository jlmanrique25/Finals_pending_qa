<?php
session_start();
include 'backend/dbh.p.php';
include 'header.php';
include 'backend/dbh.p.php';

$issue_id = $_GET['id'];


//Get the issue values
$sql_i = "SELECT * FROM `issue` WHERE issue_id =".$issue_id."";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql_i);
$results = mysqli_query($conn, $sql_i);
$row = mysqli_fetch_array($results);


$sql_e = "SELECT equipment_name,asset, location_id FROM `equipment` WHERE equipment_id = ".$row['machine_id']."";

$results_e = mysqli_query($conn, $sql_e);
$row_e = mysqli_fetch_array($results_e);

$sql_f = 'select * from location where location_id = '.$row_e['location_id'].'';
$results_f = mysqli_query($conn, $sql_f);
$row_f = mysqli_fetch_array($results_f);

?>

<div class="container-fluid py-4" id="main_content">
    <div class="info">
		<a type="button" class="btn btn-secondary" onclick='history.back()' href="#"> <i class='fa fa-arrow-left' aria-hidden='true'></i> Back</a>
        <br><br>
        <form action="backend/assign_new_issue.p.php" method="POST">
            <div class="form-group">
                <h2>#<?php echo $row['issue_id'].' - '.$row['issue'];?></h2><br />
                <h4>Issue Description:</h4>
                <p><?php echo $row['issue description'];?></p>
                <h4>Location: <?php echo $row_f['floor'].' Room '.$row_f['room_number'];?></h4>
				<br />
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
					<input type="text" class="form-control" name="i_id" value = "<?php echo $issue_id;?>" hidden>
				</div> 
				<div class="form-group">
					<label for="formGroupExampleInput2">Due date of the Issue<text style="color:red;"> *</text></label>
					<input type="date" class="form-control" min="<?php echo date('Y-m-d')?>" name="dueDate" required>
				</div>
                <div class="form-group">
                    <button class="btn btn-primary mb-2" type="submit" name="submit"  onclick="alert('Are you sure?')">
				        Finish
			        </button>
                    
                </div>
            </div>
        </form>
        <button class="btn btn-danger mb-2" name="submit" onclick="" data-toggle="modal" data-target="#delete">
			Delete Issue
		</button>
    </div>
</div>


<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
		<h5 class="modal-title" id="exampleModalLabel">Are you sure you want to delete Issue #0000</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
		</div>
		<div class="modal-body">
			<div class="form-group">
				<form action="backend/delete_issue_email.p.php?id=<?php echo $issue_id?>" method="POST">
					<div class="form-group">
						<label for="reason">Please state the reason why</label>
						<textarea class="form-control" id="reason" name="reason" rows="3" placeholder="(e.g. Duplicate, not a valid issue)" required></textarea>
					</div>	
				</div>
			</div> 
	
		<div class="modal-footer">
			<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
				<button class="btn btn-primary" type="submit" name="submit"><i class="fas fa-check"></i> Delete</button>
			</form>
		</div>
	</div>
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
