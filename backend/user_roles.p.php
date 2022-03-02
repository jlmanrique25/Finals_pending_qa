<?php
	include 'dbh.p.php';

		$u_id = $_GET['u_id'];
	
		$output = '';
		$sql = "SELECT * FROM `users` WHERE users_id = ".$u_id."";
		$stmt = mysqli_stmt_init($conn);
		
		if(!mysqli_stmt_prepare($stmt, $sql)){
			echo 'error connecting to the database';
		}else{
			$results = mysqli_query($conn, $sql);
			$row = mysqli_fetch_assoc($results);
			
			?>
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Change employee role</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			<div class="modal-body" id="change_user">
				Are you sure you want to change employee: <strong><?php echo $row['username'];?></strong> role?	
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
				<button type="button" class="btn btn-primary"><i class="fas fa-edit"></i> Save changes</button>
			</div>
			<?php
		}
	
		
?>