<?php
	include 'dbh.p.php';
	if(isset($_GET['page'])){
		$min = 10 * ($_GET['page'] - 1);
	}
	
	if($_GET['site'] == "Reports"){
		if(isset($_GET['status'])){
			$resolve_status = $_GET['status'];
			$sql_status = "SELECT report_id, task, machine_id, task_due, date_submitted, report_status, for_repair, assigned_user, dates.date_identity,dates.date_type, dates.report_issue_id, date_time, equipment.equipment_name, equipment.equipment_id, location.location_id, location.floor, location.room_number, reports.report_status, users.username, users.users_id 
				FROM `dates`,`reports`, `equipment`, `location`, `users` 
				WHERE reports.report_status = '". $resolve_status. "'
				ORDER by date_created DESC LIMIT ".$min.",10";
	
		}
	}else if($_GET['site'] == "Issues"){
		if(isset($_GET['status'])){
			$resolve_status = $_GET['status'];
			$sql_status = "SELECT issue_id, machine_id, issue, issue_status, date_due, date_created, date_issue_resolved, assigned_to, equipment.equipment_id, equipment.equipment_name, users.users_id, users.username, dates.date_time, dates.report_issue_id, dates.date_identity FROM `issue`, `equipment`, `users`, `dates` WHERE year(date_time) = year(now()) AND issue.machine_id = equipment.equipment_id AND assigned_to = users.users_id AND issue.issue_status = ".$_GET['status']." ORDER by date_created DESC LIMIT ".$min.",10";
		}
		
	}
	
	
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt,$sql_status)){
		echo 'Error connecting to database.';
	}else{
		$results_status = mysqli_query($conn, $sql_status);
		
		if($results_status->num_rows > 0){
			while($row_status = mysqli_fetch_array($results_status)){
				if($_GET['site'] == "Reports"){
				?>
				<tr role="button" data-href="index.php?page=1&site=Dashboard">
				  <td><?php echo $row_status['task'];?></td>
				  <td><?php echo $row_status['equipment_name'];?></td>
				  <td><?php echo $row_status['floor'];?></td>
				  <td><?php echo $row_status['room_number'];?></td>
				  <td><?php echo $row_status['report_status'];?></td>
				  <?php if(!$row_status['date_submitted']){
					  echo '<td>--</td>';
				  }else{
					  ?><td><?php echo $row_status['date_submitted'];?></td><?php
				  }?>
				  <?php if(is_null($row_status['for_repair'])){
					  echo '<td>--</td>';
				  }else{
					  ?><td><?php 
						if($row_status['for_repair'] == 1){
							echo 'Yes';
						}else{
							echo 'No';
						}
					  ?></td><?php
				  }?>
				  <td><?php echo $row_status['username'];?></td>
				</tr>
			<?php
				}else if($_GET['site'] == "Issues"){
					?>
				<tr role="button" data-href="index.php?page=1&site=Dashboard">
				  <td><?php echo $row_status['issue'];?></td>
				  <td><?php echo $row_status['equipment_name'];?></td>
				  <?php if(is_null($row_status['issue_status'])){
					  echo '<td>--</td>';
				  }else{
					  ?><td><?php 
						if($row_status['issue_status'] == 1){
							echo 'Resolved';
						}else{
							echo 'Not resolved';
						}
					  ?></td><?php
				  }?>
				  <td><?php echo $row_status['date_created'];?></td>
				  <td><?php echo $row_status['date_due'];?></td>
				  <?php if(!$row_status['date_issue_resolved']){
					  echo '<td>--</td>';
				  }else{
					  ?><td><?php echo $row_status['date_issue_resolved'];?></td><?php
				  }?>
				 
				 <?php
					if(is_null($row_status['username'])){
						?>
						 <td><a href="createIssue.php?site=Create issue log" class="btn btn-success" role="button" aria-pressed="true">Create issue log</a></td>
						<?php
					}else{
						?>
						<td><?php echo $row_status['username'];?></td>
						<?php
					}
				 ?>
				  
				</tr>
			<?php
				}
			}
			
		}else{
			?>
				<tr>
					<td colspan="7" class="text-center"> There are no reports here</td>
				</tr>
			<?php
		}
	}
	
	
?>