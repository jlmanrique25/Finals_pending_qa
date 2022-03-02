<?php
	include 'dbh.p.php';
	
	$sql = "SELECT * FROM `users` WHERE (users.role = 'Admin' OR users.role = 'Head')  ORDER BY username";
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo 'error connecting to the database';
	}else{
		$result = mysqli_query($conn, $sql);
		
		while($row = mysqli_fetch_array($result)){
			
			?>
				<option value="<?php echo $row['users_id'];?>"><?php echo $row['username'];?></option>
			<?php
		}
	}
?>