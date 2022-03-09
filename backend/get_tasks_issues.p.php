<?php
	include 'dbh.p.php';
	
	if(isset($_GET['page'])){
		$min = 10 * ($_GET['page'] - 1);
	}else{
		$min = 0;
	}
	
	if(isset($_GET['i_status'])){
		$s = $_GET['i_status'];
	}else{
		$s = 0;
	}
	
	if ($_SESSION['role'] == "Head" || $_SESSION['role'] == "Admin"){
		$sql = "SELECT issue.issue_id, issue.machine_id, issue.issue, issue.issue_status, issue.assigned_to, issue.date_created, issue.date_due, issue.date_issue_resolved, equipment.equipment_id, equipment.equipment_name, equipment.location_id, location.location_id, location.floor,location.room_number, users.users_id, users.username 
		FROM `issue`, `users`,`location`,`equipment` 
		WHERE users.users_id = ".$_SESSION['userId']." AND issue.assigned_to = ".$_SESSION['userId']." AND equipment.equipment_id = issue.machine_id AND equipment.location_id = location.location_id AND issue.issue_status = ".$s."
		ORDER BY issue.date_created DESC 
		LIMIT ".$min.", 10";
	}else if($_SESSION['role'] == "Technician"){
		$sql = "SELECT report_id, reports.machine_id, reports.task, reports.date_created, reports.task_due, reports.date_submitted, reports.assigned_user, reports.report_status, equipment.equipment_id, equipment.equipment_name, equipment.location_id, location.location_id, location.floor,location.room_number, users.users_id, users.username 
		FROM `reports`, `users`,`location`,`equipment` 
		WHERE users.users_id = ".$_SESSION['userId']." AND reports.assigned_user = ".$_SESSION['userId']." AND equipment.equipment_id = reports.machine_id AND equipment.location_id = location.location_id AND  reports.report_status = 'unresolved'
		ORDER BY reports.date_created DESC 
		LIMIT ".$min.", 10";
	}
	
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo 'error connecting the database';
	}else{
		$result = mysqli_query($conn, $sql);
		
		if($result->num_rows > 0){
			while($row = mysqli_fetch_array($result)){
				if ($_SESSION['role'] == "Head" || $_SESSION['role'] == "Admin"){
				?>
					<tr role="button" data-href="issue_report.php?i_id=<?php echo $row['issue_id'];?>&<?php echo $row['equipment_name'];?>&site=Issue%20Report">
						<td><?php echo $row['issue'];?></td>
						<td><?php echo $row['equipment_name'];?></td>
						<td><?php echo $row['floor'];?></td>
						<td><?php echo $row['room_number'];?></td>
						<td><?php echo $row['date_created'];?></td>
						<td><?php echo $row['date_due'];?></td>
						<td><?php 
							if(!is_null($row['date_issue_resolved'])){
								echo $row['date_issue_resolved'];
							}else{
								echo '--';
							}
						?></td>
						<td><?php 
							if($row['issue_status'] == 0){
								echo 'Unresolved';
							}else{
								echo 'Resolved';
							}?>
						</td>
					</tr>
				<?php
				}else if($_SESSION['role'] == "Technician"){
				?>
					<tr role="button" data-href="createStatusReport.php?task=<?php echo $row['report_id'];?>&e=<?php echo $row['machine_id'];?>&site=Create%20Status%20Report">
						<td><?php echo $row['task'];?></td>
						<td><?php echo $row['equipment_name'];?></td>
						<td><?php echo $row['floor'];?></td>
						<td><?php echo $row['room_number'];?></td>
						<td><?php echo $row['date_created'];?></td>
						<td><?php echo $row['task_due'];?></td>
						<td><?php echo $row['date_submitted'];?></td>
						<td><?php echo $row['report_status'];?>
						</td>
					</tr>
				<?php
				}
				
			}
		}else{
			?>
				<tr>
					<td colspan="7" class="text-center"> There are no Tasks to be done.</td>
				</tr>
			<?php
		}
	}
?>