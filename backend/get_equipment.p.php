<?php
	
	include 'dbh.p.php';
	
	if(isset($_GET['page'])){
		$min = 10 * ($_GET['page'] - 1);
	}else{
		$min = 0;
	}
	
	$sql = "SELECT equipment_id, equipment_name, asset, equipment.location_id, location.floor, location.location_id as locID, location.room_number, date_of_purchase, equipment.condition, equipment.operating FROM `equipment`, `location` WHERE location.location_id = equipment.location_id AND operating ORDER BY asset LIMIT ".$min.", 10";
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo 'error connecting to the database';
	}else{
		$result = mysqli_query($conn, $sql);
		if($result->num_rows > 0){
			while($row = mysqli_fetch_assoc($result)){
				?>
				<tr role="button" data-href="machines.php?page=1&site=Equipment Information&e_id=<?php echo $row['equipment_id'];?>&t=reports">
				  <td><?php echo $row['equipment_name'];?></td>
				  <td><?php echo $row['asset'];?></td>
				  <td><?php echo $row['floor'];?></td>
				  <td><?php echo $row['room_number'];?></td>
				  <td><?php echo $row['date_of_purchase'];?></td>
				  <td><?php echo $row['condition'];?></td>
				  <td><?php 
					if($row['operating'] == 0){
						echo 'out of commission'; 
					}else{
						echo 'operating';
					}?></td>
				</tr>
			<?php
			}
		}else{
			?>
				<tr>
					<td colspan="7" class="text-center"> There are no issue reports</td>
				</tr>
			<?php
		}
		
	}
	
	
?>