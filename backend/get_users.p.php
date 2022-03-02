<?php 
	include 'dbh.p.php';
	
	$min = $_GET['page'] - 1;
	
	$sql = "SELECT * FROM `users` WHERE role != 'Head' ORDER BY username LIMIT ".$min.", 10";
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo 'error connecting to database';
	}else{
		$result = mysqli_query($conn, $sql);
		if($result->num_rows > 0){
			while($row = mysqli_fetch_assoc($result)){
			?>
				<tr class = "table-light" role="button">
				  <td data-title="username"><?php echo $row['username'];?></td>
				  <td data-title="email"><?php echo $row['email'];?></td>
				  <td data-title="role"><?php echo $row['role'];?></td>
				  <td><a class="btn btn-success get_id" data-toggle="modal" href="backend/user_roles.p.php?page=1&site=Users&u_id=<?php echo $row['users_id'];?>" data-target="#<?php echo $row['users_id'];?>" > <i class="fas fa-edit"></i> Change role</a></td>
				</tr>
				
				<div class="modal fade" id="<?php echo $row['users_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Changing user role</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						  <span aria-hidden="true">&times;</span>
						</button>
					  </div>
					  <div class="modal-body">
						Are you sure you want to change employee <strong><?php echo $row['username'];?>'s</strong> role from <?php
							if($row['role'] == 'Admin'){
								echo 'Admin to Technician?';
							}else{
								echo 'Technician to Admin?';
							}
						?>? 
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-danger " data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
						<a href ="backend/update_user.p.php?userid=<?php echo $row['users_id'];?>&role=<?php echo $row['role'];?>" role="button" class="btn btn-primary"><i class="fas fa-check"></i> Change Role</a></td>
					  </div>
					</div>
				  </div>
				</div>
				
			<?php	
			}
			?>
			
			
			
			<?php
			
		}else{
			echo '<tr>
					<td colspan="7" class="text-center"> There are no normal users</td>
				</tr>';
		}
		
		
	}
?>
<script type="text/javascript">
	$( document ).ready(function() {
		
	});
</script>

	