<?php
	include 'dbh.p.php';
	if(isset($_GET['page'])){
		$min = 10 * ($_GET['page'] - 1);
	}
	
	if($_GET['site'] == "Reports"){
		
		//check which filters are selected
		if (isset($_GET['status']) || isset($_GET['equipment']) || isset($_GET['floor'])) {
			if (isset($_GET['equipment']) & isset($_GET['floor'])) {
				$sql = "SELECT `task`, `equipment_name`, `floor`, `room_number`,`report_status`, `date_created`, `date_submitted`, `for_repair`, `username` FROM `reports`,`equipment`,`location`,`users` WHERE reports.machine_id = equipment.equipment_id AND reports.assigned_user = users.users_id AND equipment.location_id = location.location_id
				AND `floor` = '".$_GET['floor']."'
				ORDER BY date_created DESC LIMIT ".$min.",10";
			}else if (isset($_GET['floor'])) {
				$sql = "SELECT `task`, `equipment_name`, `floor`, `room_number`,`report_status`, `date_created`, `date_submitted`, `for_repair`, `username` FROM `reports`,`equipment`,`location`,`users` WHERE reports.machine_id = equipment.equipment_id AND reports.assigned_user = users.users_id AND equipment.location_id = location.location_id
				AND `floor` = '".$_GET['floor']."'
				ORDER BY date_created DESC LIMIT ".$min.",10";
			}else if (isset($_GET['equipment'])) {
				$sql = "SELECT `task`, `equipment_name`, `floor`, `room_number`,`report_status`, `date_created`, `date_submitted`, `for_repair`, `username` FROM `reports`,`equipment`,`location`,`users` WHERE reports.machine_id = equipment.equipment_id AND reports.assigned_user = users.users_id AND equipment.location_id = location.location_id
				AND `asset` = '".$_GET['equipment']."'
				ORDER BY date_created DESC LIMIT ".$min.",10";
			}else if (isset($_GET['status'])) {
				$sql = "SELECT `task`, `equipment_name`, `floor`, `room_number`,`report_status`, `date_created`, `date_submitted`, `for_repair`, `username` FROM `reports`,`equipment`,`location`,`users` WHERE reports.machine_id = equipment.equipment_id AND reports.assigned_user = users.users_id AND equipment.location_id = location.location_id
				AND `report_status` = '".$_GET['status']."'
				ORDER BY date_created DESC LIMIT ".$min.",10";
			}
		} else {
			$sql = "SELECT `task`, `equipment_name`, `floor`, `room_number`,`report_status`, `date_created`, `date_submitted`, `for_repair`, `username` FROM `reports`,`equipment`,`location`,`users` WHERE reports.machine_id = equipment.equipment_id AND reports.assigned_user = users.users_id AND equipment.location_id = location.location_id
			ORDER BY date_created DESC LIMIT ".$min.",10";
		}

		$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt,$sql)){
		echo 'Error searching database.';
	}else{
		$results = mysqli_query($conn, $sql);

		if($results->num_rows > 0){
			while($row = mysqli_fetch_array($results)){
				?>
				<tr role="button">
				  <td><?php echo $row['task'];?></td>
				  <td><?php echo $row['equipment_name'];?></td>
				  <td><?php echo $row['floor'];?></td>
				  <td><?php echo $row['room_number'];?></td>
				  <td><?php echo $row['report_status'];?></td>
				  <td><?php echo $row['date_created'];?></td>
				  <?php if(!$row['date_submitted']){
					  echo '<td>--</td>';
				  }else{
					  ?><td><?php echo $row['date_submitted'];?></td><?php
				  }?>
				  <?php if(is_null($row['for_repair'])){
					  echo '<td>--</td>';
				  }else{
					  ?><td><?php 
						if($row['for_repair'] == 1){
							echo 'Yes';
						}else{
							echo 'No';
						}
					  ?></td><?php
				  }?>
				  <td><?php echo $row['username'];?></td>
				</tr>
			<?php }
		} else { ?>
			<tr>
				<td colspan="7" class="text-center"> There are no reports here</td>
			</tr>
		<?php }
	} 
} else if($_GET['site'] == "Issues"){ 

}
?>