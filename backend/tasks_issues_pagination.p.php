<?php
	include 'dbh.p.php';
	
	if ($_SESSION['role'] == "Head" || $_SESSION['role'] == "Admin"){
		$sql = "SELECT count(*) as total
		FROM `issue`, `users`,`location`,`equipment` 
		WHERE users.users_id = ".$_SESSION['userId']." AND issue.assigned_to = ".$_SESSION['userId']." AND equipment.equipment_id = issue.machine_id AND equipment.location_id = location.location_id AND (day(issue.date_created) = day(now()) || issue.issue_status = 0)
		ORDER BY issue.date_created DESC";
	}
	else if($_SESSION['role'] == "Technician"){
		$sql = "SELECT count(*) as total
		FROM `reports`, `users`,`location`,`equipment` 
		WHERE users.users_id = ".$_SESSION['userId']." AND reports.assigned_user = ".$_SESSION['userId']." AND equipment.equipment_id = reports.machine_id AND equipment.location_id = location.location_id AND (day(reports.date_created) = day(now()) || reports.report_status = 'unresolved')
		ORDER BY reports.date_created DESC";
	}
	
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo 'error connecting to the database';
	}else{
		$result = mysqli_query($conn,$sql);
		$row = mysqli_fetch_assoc($result);
		
		$pages = ceil($row['total']/10);
		
		?>
			<nav aria-label="Page navigation example">
				  <ul class="pagination justify-content-center">
				  <li class="page-item"><a class="page-link" href="<?php
					if(($_GET['page']-1) == 0){
						echo '#';
					}else{
						$new_page = $_GET['page'] - 1;
						echo 'tasks.php?site=Tasks&page='.$new_page.'';
					}
				  ?>">Previous</a></li>
		<?php
		
		for($i = 1; $i <= $pages; $i++){
			?>
			
					
					<li  <?php 
						if(isset($_GET['page'])){
							if($_GET['page'] == $i){
							echo 'class="page-item active"';}
						}else{
							if( 1 == $i){
							echo 'class="page-item active"';}
						}
					?>><a class="page-link" href="tasks.php?page=<?php echo $i;?>&site=Tasks&"><?php echo $i;
					?></a></li>
					
			  
			  <?php
		}
		?>
			<li class="page-item"><a class="page-link" href="<?php
					if(($_GET['page']+1) > $pages){
						echo '#';
					}else{
						$new_page = $_GET['page'] + 1;
						echo 'tasks.php?site=Reports&page='.$new_page.'';
					}
				  ?>">Next</a></li>
				  </ul>
			  </nav>
		<?php
	}
?>