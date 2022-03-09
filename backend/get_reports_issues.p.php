<?php
	include 'dbh.p.php';
	
	if(isset($_GET['page'])){
		$min = 10 * ($_GET['page'] - 1);
	}else{
		$min = 0;
	}
	
	if($_GET['site'] == "My Reports"){
		$sql = "SELECT report_id, reports.machine_id, reports.task, reports.date_created, reports.task_due, reports.date_submitted, reports.assigned_user, reports.report_status, equipment.equipment_id, equipment.equipment_name, equipment.location_id, location.location_id, location.floor,location.room_number, users.users_id, users.username 
		FROM `reports`, `users`,`location`,`equipment` 
		WHERE users.users_id = ".$_SESSION['userId']." AND reports.assigned_user = ".$_SESSION['userId']." AND equipment.equipment_id = reports.machine_id AND equipment.location_id = location.location_id AND reports.report_status = 'done'
		ORDER BY reports.date_submitted DESC 
		LIMIT ".$min.", 10";
	}else if($_GET['site'] == "My Issues Reported"){
		$sql = "SELECT issue.issue_id, issue.machine_id, issue.issue, issue.issue_status, issue.assigned_to, issue.date_created, issue.date_due, issue.date_issue_resolved, equipment.equipment_id, equipment.equipment_name, equipment.location_id, location.location_id, location.floor,location.room_number, users.users_id, users.username, issue.assigned_to 
		FROM `issue`, `users`,`location`,`equipment` 
		WHERE users.users_id = ".$_SESSION['userId']." AND issue.submitted_by = ".$_SESSION['userId']." AND equipment.equipment_id = issue.machine_id AND equipment.location_id = location.location_id
		ORDER BY issue.date_created DESC 
		LIMIT ".$min.", 10 ";
	}
	
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo 'error connecting the database';
	}else{
		$result = mysqli_query($conn, $sql);
		
		if($_GET['site'] == "My Reports"){
			if($result->num_rows > 0){
				while($row = mysqli_fetch_array($result)){
					?>
					<tr role="button" data-href="viewPastReports.php?r=<?php echo $row['report_id'];?>&e=<?php echo $row['machine_id'];?>&site=My%20Past%20Reports">
						<td><?php echo $row['task'];?></td>
						<td><?php echo $row['equipment_name'];?></td>
						<td><?php echo $row['floor'];?></td>
						<td><?php echo $row['room_number'];?></td>
						<td><?php echo $row['date_created'];?></td>
						<td><?php echo $row['task_due'];?></td>
						<td><?php echo $row['date_submitted'];?></td>
						<td><?php echo 'Resolved';?></td>
					</tr>
				<?php
				}
			}else{
			?>
				<tr>
					<td colspan="7" class="text-center"> There are no reports submitted by you yet.</td>
				</tr>
			<?php
			}
		}else if($_GET['site'] == "My Issues Reported"){
			if($result->num_rows > 0){
				while($row = mysqli_fetch_array($result)){
					?>
					<tr role="button" >
						<td><?php echo $row['issue'];?></td>
						<td><?php echo $row['equipment_name'];?></td>
						<td><?php echo $row['floor'];?></td>
						<td><?php echo $row['room_number'];?></td>
						<td><?php echo $row['date_created'];?></td>
						<td><?php 
						
						if($row['issue_status']){
							echo 'resolved';
						}else{
							echo 'unresolved';
						}
							?></td>
						<td>
						<?php 
						
						if($row['issue_status'] || !is_null($row['assigned_to'])){
							//getting the username of specific record
							$sql_user = "SELECT * FROM `users` WHERE users_id = ".$row['assigned_to']."";
	
							if(!mysqli_stmt_prepare($stmt, $sql_user)){
								echo 'error connecting to database users';
							}else{	
							$result_user = mysqli_query($conn, $sql_user);
							$row_user = mysqli_fetch_assoc($result_user);
							}
							echo $row_user['username'];
						}else{
							echo 'To be assigned';
						}
							?> 
						
						</td>
					</tr>

				<div class="modal fade" id="<?php echo $row['issue_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Deleting issue</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <div class="modal-body">
						Are you sure you want to delete the issue you reported? 
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-danger " data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
						<a href ="backend/delete_issue.p.php?id=<?php echo $row['issue_id'];?>" role="button" class="btn btn-primary"><i class="fas fa-check"></i> Delete Issue</a></td>
					  </div>
					</div>
				  </div>
				</div>
				<?php
				}
			}else{
			?>
				<tr>
					<td colspan="7" class="text-center"> There are no issues submitted by you yet.</td>
				</tr>
			<?php
			}
		}
	}
?>