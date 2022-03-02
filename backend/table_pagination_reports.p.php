<?php
	include 'dbh.p.php';
	
	
	if($_GET['site'] == 'Reports'){
		if($_GET['time'] == 'date'){
			$sql = "SELECT count(*) as total FROM `reports`, `equipment`, `location`, `users` WHERE reports.date_created BETWEEN '".$_GET['s']."'AND '".$_GET['e']."' AND reports.machine_id = equipment.equipment_id AND location.location_id = equipment.location_id  AND users.users_id = assigned_user LIMIT ".$min.",10";
		}else{
		
			$sql = "SELECT count(*) as total FROM `dates` WHERE ".$_GET['time']."(date_time) = ".$_GET['time']."(now()) and date_type = 'created' and date_identity = 'report'";
		}
	}else if($_GET['site'] == "Issues"){
		if($_GET['time'] == 'date'){
			$sql = "SELECT count(*) as total FROM `issue`, `equipment`, `location`, `users` 
			WHERE issue.date_created BETWEEN '".$_GET['s']."' AND '".$_GET['e']."' AND issue.machine_id = equipment.equipment_id AND location.location_id = equipment.location_id  AND issue.submitted_by = users.users_id";
		}else{
			$sql = "SELECT count(*) as total FROM `dates` WHERE ".$_GET['time']."(date_time) = ".$_GET['time']."(now()) and date_type = 'created' and date_identity = 'issue'";
		}
		
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
						if($_GET['site'] == 'Reports'){
							if(isset($_GET['s'])){
								?>
								reports.php?site=Reports&page=<?php echo $new_page;?>&time=<?php echo $_GET['time'];?>&s=<?php echo $_GET['s'];?>&e=<?php echo $_GET['e'];?>
								<?php
							}else{
							?><?php
							echo 'reports.php?site=Reports&page='.$new_page.'&time='.$_GET['time'].'';
							}
							
							
						}else if($_GET['site'] == "Issues"){
							if(isset($_GET['s'])){
								?>
								issues.php?site=Issues&page=<?php echo $new_page;?>&time=<?php echo $_GET['time'];?>&s=<?php echo $_GET['s'];?>&e=<?php echo $_GET['e'];?>
								<?php
							}else{
							?><?php
							echo 'issues.php?site=Issues&page='.$new_page.'&time='.$_GET['time'].'';
							}
						}
						
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
					?>><a class="page-link" href="reports.php?page=<?php echo $i;?>&site=Reports&time=<?php echo $_GET['time']?>"><?php echo $i;
					?></a></li>
					
			  
			  <?php
		}
		?>
			<li class="page-item"><a class="page-link" href="
			<?php
					if(($_GET['page']+1) > $pages){
						echo '#';
					}else{
						$new_page = $_GET['page'] + 1;
						if($_GET['site'] == 'Reports'){
							if(isset($_GET['s'])){
								?>
								reports.php?site=Reports&page=<?php echo $new_page;?>&time=<?php echo $_GET['time'];?>&s=<?php echo $_GET['s'];?>&e=<?php echo $_GET['e'];?>
								<?php
							}else{
							?><?php
							echo 'reports.php?site=Reports&page='.$new_page.'&time='.$_GET['time'].'';
							}
						}else if($_GET['site'] == "Issues"){
							if(isset($_GET['s'])){
								?>
								issues.php?site=Issues&page=<?php echo $new_page;?>&time=<?php echo $_GET['time'];?>&s=<?php echo $_GET['s'];?>&e=<?php echo $_GET['e'];?>
								<?php
							}else{
							?><?php
							echo 'issues.php?site=Issues&page='.$new_page.'&time='.$_GET['time'].'';
							}
						}
						
						
					}
				  ?>&order=<?php 
				  if(isset($_GET['order'])){
					  echo $_GET['order'];
				  }else{
					  echo 'date_time';
				  }
				  
				  ?>&by=<?php
					if(isset($_GET['by'])){
						if($_GET['by'] == 'asc'){
							echo 'desc';
						}else{
							echo 'asc';
						}
					}else{
						echo 'asc';
					}
				  ?>">Next</a></li>
				  </ul>
			  </nav>
		<?php
	}
?>