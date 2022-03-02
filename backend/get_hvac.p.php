<?php
	include 'dbh.p.php';
	
	$sql = "SELECT * FROM `equipment`, `location` where asset = 'HVAC' AND location.location_id = equipment.location_id AND equipment.condition != 'not available' ORDER BY location.floor";
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo 'error connecting to the database';
	}else{
		$result = mysqli_query($conn, $sql);
		
		while($row = mysqli_fetch_array($result)){
			
			?>
				<option value="<?php echo $row['equipment_id'];?>"><?php echo $row['equipment_name'], " ", $row['room_number'];?></option>
			<?php
		}
	}
?>