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
	
	$sql_i = "SELECT * FROM `users` WHERE users.users_id NOT IN (SELECT assigned_user FROM `reports`) AND role != 'head'AND role != 'admin' ORDER BY username LIMIT ".$min.",10";
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql_i)){
		echo 'error connecting to database';
	}else{
		$results = mysqli_query($conn, $sql_i);
	
?>

<div class="container py-4 overflow-hidden">
	<table class="table rounded-3 shadow-lg table-hover mb-5">
		<thead class="thead-dark">
				<tr>
					<th scope="col">Username</th>
					<th scope="col">Email</th>
					<th scope="col">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
					if($results->num_rows > 0){
						while($row = mysqli_fetch_array($results)){
							?>
								<tr role="button">
									<td><?php echo $row['username'];?></td>
									<td><?php echo $row['email'];?></td>
									<td>
										<a type="button" class="btn btn-success" href="assign_new_task.php?site=Assign%20new%20task&u_id=<?php echo $row['users_id'];?>&username=<?php echo $row['username'];?>">
										<i class="fas fa-paper-plane"></i> Assign a task to employee
										</a>
									</td>
								</tr>
							<?php
						}
					}else{
						echo ' there are no results';
					}
				?>
			</tbody>
	</table>
	
</div>

<?php

	$sql = "SELECT count(users_id) as total FROM `users` WHERE users.users_id NOT IN (SELECT assigned_user FROM `reports`) AND role != 'head'AND role != 'admin'";
	
	
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo 'error connecting to the database';
	}else{
		$result = mysqli_query($conn,$sql);
		$row = mysqli_fetch_assoc($result);
		
		$pages = ceil($row['total']/10);?>
		<nav aria-label="Page navigation example">
				  <ul class="pagination justify-content-center">
				  <li class="page-item"><a class="page-link" href="<?php
					if(($_GET['page']-1) == 0){
						echo '#';
					}else{
						$new_page = $_GET['page'] - 1;
						echo 'i_users.php?site=Inactive%20Users&page='.$new_page.'';
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
					?>><a class="page-link" href="i_users.php?site=Inactive%20Users&page=<?php echo $i;?>"><?php echo $i;
					?></a></li>
					
			  
			  <?php
		}
		?>
			<li class="page-item"><a class="page-link" href="<?php
					if(($_GET['page']+1) > $pages){
						echo '#';
					}else{
						$new_page = $_GET['page'] + 1;
						echo 'i_users.php?site=Inactive%20Users&page='.$new_page.'';
					}
				  ?>">Next</a></li>
				  </ul>
			  </nav>
		<?php
		}
	}
?>