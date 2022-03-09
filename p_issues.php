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
	
	$sql_i = "SELECT * FROM `issue`,`equipment`,`users` WHERE issue.machine_id = equipment.equipment_id AND (issue.assigned_to = users.users_id OR issue.assigned_to = NULL) AND issue.issue_status = 0 ORDER BY date_due ASC LIMIT ".$min.",10";
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql_i)){
		echo 'error connecting to database';
	}else{
		$results = mysqli_query($conn, $sql_i);
	
?>

<div class="container-fluid py-4 overflow-hidden">
	<table class="table rounded-3 shadow-lg table-hover mb-5">
		<thead class="thead-dark">
				<tr>
					<th scope="col">Issue</th>
					<th scope="col">Equipment</th>
					<th scope="col">Asset</th>
					<th scope="col">Date Created</th>
					<th scope="col">Date due</th>
					<th scope="col">Assigned to</th>
				</tr>
			</thead>
			<tbody>
				<?php
					if($results->num_rows > 0){
						while($row = mysqli_fetch_array($results)){
							?>
								<tr role="button" role="button" data-href="viewPendingIssue.php?site=Pending%20Issue%20Report&i_id=<?php echo $row['issue_id']?>" data-toggle="modal" data-target="#<?php echo $row_issue['issue'];?>">
									<td><?php echo $row['issue'];?></td>
									<td><?php echo $row['equipment_name'];?></td>
									<td><?php echo $row['asset'];?></td>
									<td><?php echo $row['date_created'];?></td>
									<td><?php echo $row['date_due'];?></td>
									<td><?php echo $row['username'];?></td>
								</tr>
								<div class="modal fade" id="<?php echo $row_issue['issue'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
							<?php
						}
					}else{
						?>
							<tr>
								<td colspan="6" class="text-center"> There are no Tasks to be done.</td>
							</tr>
						<?php
					}
				?>
			</tbody>
	</table>
	
</div>

<?php

	$sql = "SELECT count(*) as total FROM `issue`,`equipment`,`users` WHERE issue.machine_id = equipment.equipment_id AND issue.assigned_to = users.users_id ORDER BY date_due ASC";
	
	
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
						echo 'p_issues.php?site=Pending%20Tasks&page='.$new_page.'';
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
					?>><a class="page-link" href="p_issues.php?site=Pending%20Tasks&page=<?php echo $i;?>"><?php echo $i;
					?></a></li>
					
			  
			  <?php
		}
		?>
			<li class="page-item"><a class="page-link" href="<?php
					if(($_GET['page']+1) > $pages){
						echo '#';
					}else{
						$new_page = $_GET['page'] + 1;
						echo 'p_issues.php?site=Pending%20Tasks&page='.$new_page.'';
					}
				  ?>">Next</a></li>
				  </ul>
			  </nav>
		<?php
		}
	}
?>