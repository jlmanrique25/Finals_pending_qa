<?php
	if(!isset($_SESSION['role'])){
		session_start();
	}
	if(isset($_GET['page'])){
		$min = 10 * ($_GET['page'] - 1);
	}else{
		$min = 0;
	}
	include 'backend/dbh.p.php';
	include 'header.php';
	
	$sql_i = "SELECT * FROM `issue` WHERE assigned_to is null ORDER BY date_created DESC";
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql_i)){
		echo 'error connecting to database';
	}else{
		$results = mysqli_query($conn, $sql_i);
	
?>

<div class="container py-4 overflow-hidden">
	<i class="fa-solid fa-chevrons-left"></i>

	<input type="button" class="btn btn-secondary" onclick="history.back()" value="<< Back"><br><br>

	<h2><text style="font-weight:bold;">New Issue Reports</text> </h2> 

	<br>
	<div class="container py-4">
	<table  id="n_issues_table">
		<thead class="thead-dark">
				<tr>
					<th scope="col">Issue</th>
					<th scope="col">Equipment</th>
					<th scope="col">Asset</th>
					<th scope="col">Date Created</th>
					<th scope="col">Submitted by</th>
					<th scope="col">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
					if($results->num_rows > 0){
						while($row = mysqli_fetch_array($results)){
							?>
								<tr role="button" data-toggle="modal" data-target="#<?php echo $row_issue['issue_id'];?>">
									<td><?php echo $row['issue'];?></td>
									<td><?php

									$sql_e = "SELECT equipment_name,asset, location_id FROM `equipment` WHERE equipment_id = ".$row['machine_id']."";
									$sql_u = "SELECT username FROM `users` WHERE users_id = ".$row['submitted_by']."";

									$results_e = mysqli_query($conn, $sql_e);
									$row_e = mysqli_fetch_array($results_e);

									$results_u = mysqli_query($conn, $sql_u);
									$row_u = mysqli_fetch_array($results_u);
									
									echo $row_e['equipment_name'];
									
									?></td>
									<td><?php echo $row_e['asset'];?></td>
									<td><?php echo $row['date_created'];?></td>
									<td><?php echo $row_u['username'];?></td>
									
									<?php
										if(is_null($row['assigned_to'])){?>
											<td><a href="assign_new_issue.php?site=Assign%20New%20Issue&id=<?php echo $row['issue_id'];?>" type="button" class="btn btn-success" >
											  <i class="fas fa-paper-plane"></i> Assign to employee
											</a></td>
										<?php
										}
									?>
									
								</tr>
				<div class="modal fade" id="<?php echo $row['issue_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel"><?php echo $row['issue'];?></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <div class="modal-body">
						  <div class="form-group">
							  <h5>Description</h5>
								<?php 
								$sql_f = 'select * from location where location_id = '.$row_e['location_id'].'';
								$results_f = mysqli_query($conn, $sql_f);
                                $row_f = mysqli_fetch_array($results_f);
								echo $row['issue description']. '<br/><br/><h5>Location</h5>'.$row_f['floor'].' room '.$row_f['room_number'].''; ?>
							</div> 
						<form action="backend/assign_new_issue.p.php" method="POST">
							<div class="form-group">
								<input type="text" class="form-control" name="i_id" value = "<?php echo $row['issue_id'];?>" hidden>
							</div> 
							
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
								<input type="date" class="form-control" name="dueDate" required>
							</div> 
							
							
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
							<button class="btn btn-primary" type="submit" name="submit"><i class="fas fa-check"></i> Finish</button>
						</form>
					  </div>
					</div>
				  </div>
				  
				
				  
				  
				</div>
							<?php
						};
					}else{
						?>
				<tr>
					<td colspan="0" class="text-center"></td>
					<td colspan="0" class="text-center"></td>
					<td colspan="0" class="text-center"> There are no new issue reports.</td>
					<td colspan="0" class="text-center"></td>
					<td colspan="0" class="text-center"></td>
					<td colspan="0" class="text-center"></td>
				</tr>
			<?php
					}
				?>
			</tbody>
	</table>
	</div>
	
	
	
</div>

<?php
	}
?>


<script src="tablefilter/tablefilter.js"></script>

<script data-config>
	var filtersConfig = {
		base_path: 'tablefilter/',
		responsive: true,
		paging: {
          results_per_page: ['Records: ', [10, 25, 50, 100]]
		},
		col_2: 'select',
		alternate_rows: true,
		rows_counter: true,
		btn_reset: true,
		loader: true,
		status_bar: true,
		mark_active_columns: true,
		highlight_keywords: true,

		col_types: ['string',
					'string',
					'string',
					{ type: 'date', locale: 'en', format: '{dd}-{MM}-{yyyy|yy}' },
					'string',
					'string'
		],
		watermark: ['(e.g. Not functioning)', '(e.g. Generator Set 1)', '', '(e.g. >2022-01-01)', '(e.g. >2022-01-01)', '(e.g. >2022-01-01)'],
		msg_filter: 'Filtering...',
		auto_filter: {
            delay: 1000 //milliseconds
		},
		single_filter: true,
        extensions:[{ name: 'sort' }]
	};

	var tf = new TableFilter('n_issues_table', filtersConfig);
    tf.init();
</script>

	<!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>-->

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
