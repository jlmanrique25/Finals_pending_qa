<?php
	include 'dbh.p.php';
	
	$sql = "SELECT DISTINCT(asset) FROM `equipment` ORDER by asset";
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo 'error connecting to the database';
	}else{
		$result = mysqli_query($conn, $sql);
		
		while($row = mysqli_fetch_array($result)){
			
			?>
				<option value="<?php echo $row['asset']?>"><?php echo $row['asset']?></option>
			<?php
		}
	}
?>