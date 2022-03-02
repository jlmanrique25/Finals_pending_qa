<?php
	
	if($_GET['site'] == "Reports"){
		$sql = "SELECT count(*) as total
		FROM `reports`, `users`,`location`,`equipment` 
		WHERE users.users_id = ".$_SESSION['userId']." AND reports.assigned_user = ".$_SESSION['userId']." AND equipment.equipment_id = reports.machine_id AND equipment.location_id = location.location_id AND reports.report_status = 'done'";
	}else if($_GET['site'] == "Issue Reports"){
		$sql = "SELECT count(*) as total
		FROM `issue`, `users`,`location`,`equipment` 
		WHERE users.users_id = 6 AND issue.submitted_by = 6 AND equipment.equipment_id = issue.machine_id AND equipment.location_id = location.location_id";
	}
	
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo 'error connecting to the database';
	}else{
		$result = mysqli_query($conn,$sql);
		$row = mysqli_fetch_assoc($result);
		
		$pages = ceil($row['total']/10);
		
		if($_GET['site'] == "Reports"){
			?>
			<nav aria-label="Page navigation example">
				  <ul class="pagination justify-content-center">
				  <li class="page-item"><a class="page-link" href="<?php
					if(($_GET['page']-1) == 0){
						echo '#';
					}else{
						$new_page = $_GET['page'] - 1;
						echo 'technician_reports.php?site=Reports&page='.$new_page.'';
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
					?>><a class="page-link" href="technician_reports.php?page=<?php echo $i;?>&site=Reports"><?php echo $i;
					?></a></li>
					
			  
			  <?php
		}
		?>
			<li class="page-item"><a class="page-link" href="<?php
					if(($_GET['page']+1) > $pages){
						echo '#';
					}else{
						$new_page = $_GET['page'] + 1;
						echo 'technician_reports.php?site=Reports&page='.$new_page.'';
					}
				  ?>">Next</a></li>
				  </ul>
			  </nav>
		<?php
		
		
		
		
		
		}else if($_GET['site'] == "Issue Reports"){
			?>
			<nav aria-label="Page navigation example">
				  <ul class="pagination justify-content-center">
				  <li class="page-item"><a class="page-link" href="<?php
					if(($_GET['page']-1) == 0){
						echo '#';
					}else{
						$new_page = $_GET['page'] - 1;
						echo 'technician_reports.php?site=Issue%20Reports&page='.$new_page.'';
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
					?>><a class="page-link" href="technician_reports.php?site=Issue%20Reports&page=<?php echo $i;?>"><?php echo $i;
					?></a></li>
					
			  
			  <?php
		}
		?>
			<li class="page-item"><a class="page-link" href="<?php
					if(($_GET['page']+1) > $pages){
						echo '#';
					}else{
						$new_page = $_GET['page'] + 1;
						echo 'technician_reports.php?site=Issue%20Reports&page='.$new_page.'';
					}
				  ?>">Next</a></li>
				  </ul>
			  </nav>
		<?php
		}
		
	}
?>