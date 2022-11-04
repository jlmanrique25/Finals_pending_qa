<?php
	include 'dbh.p.php';
	
	if(isset($_GET['page'])){
		$min = 10 * ($_GET['page'] - 1);
	}else{
		$min = 0;
	}
	
	if(isset($_GET['t']) && $_GET['t'] == 'reports'){
		$sql = "SELECT dates.date_type, dates.date_time, dates.date_identity, dates.report_issue_id, reports.task,  reports.task_due, reports.date_created, reports.date_submitted, reports.report_status, reports.assigned_user, reports.machine_id, reports.report_id, users.users_id, users.username, reports.for_repair, reports.abnormal_data
		FROM `dates`, `reports`, `users`
		WHERE (reports.machine_id = ".$_GET['e_id']." AND dates.report_issue_id = reports.report_id AND dates.date_identity = 'report') AND dates.date_type = 'created' AND reports.assigned_user = users.users_id
		ORDER BY dates.date_time DESC
		LIMIT ".$min.", 10";
	}else if(isset($_GET['t']) && $_GET['t'] == 'issues'){
		$sql = "SELECT dates.date_type, dates.date_time, dates.date_identity, dates.report_issue_id, issue.issue,  issue.date_due, issue.date_created, issue.date_issue_resolved, issue.issue_status, issue.assigned_to, issue.machine_id, issue.issue_id, users.users_id, users.username
		FROM `dates`, `issue`, `users`
		WHERE (issue.machine_id = ".$_GET['e_id']." AND dates.report_issue_id = issue.issue_id AND dates.date_identity = 'issue') AND dates.date_type = 'created' AND issue.assigned_to = users.users_id
		ORDER BY dates.date_time DESC
		LIMIT ".$min.", 10";
	}
	
	
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo 'error connecting to the database';
	}else{
		$result = mysqli_query($conn, $sql);
		
		if($result->num_rows > 0){
			
			if(isset($_GET['t']) && $_GET['t'] == 'reports'){
				while($row = mysqli_fetch_array($result)){
				?>
				<tr role="button" data-href="#">
					<td>R-<?php echo $row['report_id'];?></td>
					<td><?php echo $row['task'];?></td>
					<td><?php echo $row['report_status'];?></td>
					<td><?php echo $row['date_created'];?></td>
					<td><?php echo $row['task_due'];?></td>
					<td><?php 
						if(is_null($row['date_submitted'])){
							echo '--';
						}else{
							echo $row['date_submitted'];
						}?></td>
					<td><?php 
						if(is_null($row['for_repair'])){
							echo '--';
						}else if($row['for_repair'] || $row['abnormal_data']){
							echo 'YES';
						}else{
							echo 'NO';
						}?>
					</td>
					<td><?php echo $row['username'];?></td>
					
					
					
				</tr>

				<?php
				}
			}else if(isset($_GET['t']) && $_GET['t'] == 'issues'){
				while($row = mysqli_fetch_array($result)){
				?>
				<tr role="button" data-href="#">
					<td>I-<?php echo $row['issue_id'];?></td>
					<td><?php echo $row['issue'];?></td>
					<td><?php if($row['issue_status'] == 0){
						echo 'Not resolved';
					}else{
						echo 'Resolved';
					}?></td>
					<td><?php echo $row['date_created'];?></td>
					<td><?php echo $row['date_due'];?></td>
					<td><?php 
						if(is_null($row['date_issue_resolved'])){
							echo '--';
						}else{
							echo $row['date_issue_resolved'];
						}?></td>
					<td><?php echo $row['username'];?></td>
				</tr>

				<?php
				}
			}
			
		}else{
			?>
				<tr>
					<td colspan="7" class="text-center"> There are no reports made yet.</td>
				</tr>
			<?php
		}
		
	}
	
?>