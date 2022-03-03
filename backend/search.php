
<?php
	include 'dbh.p.php';
	if(isset($_GET['page'])){
		$min = 10 * ($_GET['page'] - 1);
	}
	
	if(isset($_GET['by'])){
		$by = $_GET['by'];
	}else{
		$by = "asc";
	}
	
	$sql_search = "";
	if($_GET['site'] == "Reports"){
		if(isset($_POST['submit'])){
			$search = mysqli_real_escape_string($conn, $_POST['search']);
			$sql_search = "SELECT *
			FROM `dates`,`reports`, `equipment`, `location`, `users`
			WHERE equipment.equipment_name LIKE '%$search%' OR reports.report_status LIKE '%$search%'OR location.floor LIKE '%$search%' OR users.username LIKE '%$search%'  OR task LIKE '%$search%'
	ORDER BY `dates`.`date_time` DESC LIMIT ".$min.",10 ";
		}
	}else if($_GET['site'] == "Issues"){
		
		if(isset($_POST['submit'])){
			$search = mysqli_real_escape_string($conn, $_POST['search']);
			$sql_search = "SELECT * FROM `issue`, `equipment`, `users`, `dates`
			WHERE equipment.equipment_name LIKE '%$search%' OR users.username LIKE '%$search%' OR issue_status LIKE '%$search%' OR issue.issue LIKE '%$search%' AND year(date_time) = year(now()) AND dates.report_issue_id = issue.issue_id AND date_identity = 'issue' AND issue.machine_id = equipment.equipment_id AND assigned_to = users.users_id ORDER by date_created DESC LIMIT ".$min.",10";
		}
		
	}
	
	
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt,$sql_search)){

		echo $sql_search;
	}else{
		$results_dates = mysqli_query($conn, $sql_search);
		
		if($results_dates->num_rows > 0){
			while($row_dates = mysqli_fetch_array($results_dates)){
				if($_GET['site'] == "Reports"){
				?>
				<tr role="button" data-href="index.php?page=1&site=Dashboard">
				  <td><?php echo $row_dates['task'];?></td>
				  <td><?php echo $row_dates['equipment_name'];?></td>
				  <td><?php echo $row_dates['floor'];?></td>
				  <td><?php 
					if(is_null($row_dates['room_number'])){
						echo "--";
					}else{
						echo $row_dates['room_number'];
					}
				  ?></td>
				  <td><?php echo $row_dates['report_status'];?></td>
				  <td><?php echo $row_dates['date_created'];?></td>
				  <?php if(!$row_dates['date_submitted']){
					  echo '<td>--</td>';
				  }else{
					  ?><td><?php echo $row_dates['date_submitted'];?></td><?php
				  }?>
				  <?php if(is_null($row_dates['for_repair'])){
					  echo '<td>--</td>';
				  }else{
					  ?><td><?php 
						if($row_dates['for_repair'] == 1){
							echo 'Yes';
						}else{
							echo 'No';
						}
					  ?></td><?php
				  }?>
				  <td><?php echo $row_dates['username'];?></td>
				</tr>
			<?php
				}else if($_GET['site'] == "Issues"){
					?>
				<tr role="button" data-href="issue_report.php?i_id=<?php echo $row_dates['issue_id']?>&Generator%20set%20II">
				  <td><?php echo $row_dates['issue'];?></td>
				  <td><?php echo $row_dates['equipment_name'];?></td>
				  
				  <?php if(is_null($row_dates['issue_status'])){
					  echo '<td>--</td>';
				  }else{
					  ?><td><?php 
						if($row_dates['issue_status'] == 1){
							echo 'Resolved';
						}else{
							echo 'Not resolved';
						}
					  ?></td><?php
				  }?>
				  <td><?php echo $row_dates['date_created'];?></td>
				  <td><?php echo $row_dates['date_due'];?></td>
				  <?php if(!$row_dates['date_issue_resolved']){
					  echo '<td>--</td>';
				  }else{
					  ?><td><?php echo $row_dates['date_issue_resolved'];?></td><?php
				  }?>
				 
				 <?php
					if(is_null($row_dates['username'])){
						?>
						 <td><a href="createIssue.php?site=Create issue log" class="btn btn-success" role="button" aria-pressed="true">Create issue log</a></td>
						<?php
					}else{
						?>
						<td><?php echo $row_dates['username'];?></td>
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
					<td colspan="7" class="text-center"> There are no reports</td>
				</tr>
			<?php
		}
	}
	
	
?>