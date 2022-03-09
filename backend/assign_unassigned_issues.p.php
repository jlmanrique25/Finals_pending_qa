<?php
	include 'dbh.p.php';
	
	if(isset($_GET['page'])){
		$min = 10 * ($_GET['page'] - 1);
	}else{
		$min = 0;
	}
	
	$sql_issue = "SELECT issue.issue_id, issue.issue, issue.machine_id, equipment.equipment_id, equipment.equipment_name, location.location_id,equipment.asset, equipment.location_id, location.floor, location.room_number, issue.date_created FROM `issue`, `location`, `equipment` WHERE issue.assigned_to IS NULL AND issue.machine_id = equipment.equipment_id AND equipment.location_id = location.location_id ORDER BY issue.date_created DESC";
	
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql_issue)){
		echo 'error connecting to database';
	}else{
		$result_issue = mysqli_query($conn, $sql_issue);
		if($result_issue->num_rows > 0){
			while($row_issue = mysqli_fetch_assoc($result_issue)){
			?>
				<tr class="table-light" role="button">
				  <td><?php echo $row_issue['issue'];?></td>
				  <td><?php echo $row_issue['equipment_name'];?></td>
				  <td><?php echo $row_issue['asset'];?></td>
				  <td><?php echo $row_issue['date_created'];?></td>
				  <td><button type="button" class="btn btn-success" data-toggle="modal" data-target="#<?php echo $row_issue['issue_id'];?>">
					  <i class="fas fa-paper-plane"></i> Assign to employee
					</button>
					<a type="button" class="btn btn-danger btn-sm " data-target="#del.<?php echo $row_issue['issue_id'];?>" data-toggle="modal"><i class="fas fa-trash-alt h6" style="font-color:red;"></i></a>	
				</td>
				</tr>
			
				<div class="modal fade" id="<?php echo $row_issue['issue_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel"><?php echo $row_issue['issue'];?></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <div class="modal-body">
						<form action="backend/assign_new_issue.p.php?id=<?php echo $row_issue['issue_id'];?>" method="POST">
							<div class="form-group">
								<input type="text" class="form-control" name="i_id" value = "<?php echo $row_issue['issue_id'];?>" hidden>
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
								<input type="datetime-local" class="form-control" name="dueDate" required>
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
				
				<div class="modal fade" id="del.<?php echo $row_issue['issue_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Deleting issue</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <div class="modal-body">
						Are you sure you want to delete this reported issue? 
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-danger " data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
						<a href ="backend/delete_issue.p.php?id=<?php echo $row_issue['issue_id'];?>" role="button" class="btn btn-primary"><i class="fas fa-check"></i> Delete Issue</a></td>
					  </div>
					</div>
				  </div>
				</div>
				
			<?php	
			}
			
		}else{
			echo '<tr>
					<td colspan="7" class="text-center"> There are no issue reports</td>
				</tr>';
		}
		
		
	}
?>