<?php
	include 'dbh.p.php';

		$e_id = $_GET['e_id'];
	
		$output = '';
		$sql = "SELECT * FROM `equipment` WHERE equipment_id = ".$e_id."";
		$stmt = mysqli_stmt_init($conn);
		
		if(!mysqli_stmt_prepare($stmt, $sql)){
			echo 'error connecting to the database';
		}else{
			$results = mysqli_query($conn, $sql);
			$row = mysqli_fetch_assoc($results);
			
			?>
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Archive Equipment</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			<div class="modal-body" id="archive_equipment">
				Are you sure you want to archive equipment <strong><?php echo $row['equipment_name'];?> ?</strong> 	
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancel</button>
				<button type="button" class="btn btn-primary"><i class="fas fa-edit"></i> Save changes</button>
			</div>
			<?php
		}
	
		
?>