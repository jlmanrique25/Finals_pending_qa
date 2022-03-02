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
	
	$sql_e = "SELECT * FROM `equipment`, `location` where equipment.condition = 'with issues/abnormal reading' AND equipment.location_id = location.location_id LIMIT ".$min.",10";
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql_e)){
		echo 'error connecting to database';
	}else{
		$results = mysqli_query($conn, $sql_e);
	
?>

<div class="container-fluid py-4 overflow-hidden">
	<table class="table rounded-3 shadow-lg table-hover mb-5">
		<thead class="thead-dark">
				<tr>
				<th scope="col">Equipment</th>
				<th scope="col">Asset</th>
				<th scope="col">Floor</th>
				<th scope="col">Room number</th>
				<th scope="col">Room classification</th>
				<th scope="col">Date installed</th>
				<th scope="col">Condition</th>
				</tr>
			</thead>
			<tbody>
				<?php
					if($results->num_rows > 0){
						while($row = mysqli_fetch_array($results)){
							?>
								<tr role="button" data-href="machines.php?page=1&site=Equipment%20Information&e_id=<?php echo $row['equipment_id']?>&t=issues">
									<td><?php echo $row['equipment_name'];?></td>
									<td><?php echo $row['asset'];?></td>
									<td><?php echo $row['floor'];?></td>
									<td><?php echo $row['room_number'];?></td>
									<td><?php echo $row['room_classification'];?></td>
									<td><?php echo $row['date_of_purchase'];?></td>
									<td><?php echo $row['condition'];?></td>
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

	$sql = "SELECT count(*) as total FROM `equipment`, `location` where equipment.condition = 'with issues/abnormal reading' AND equipment.location_id = location.location_id";
	
	
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
						echo 'equipment_issues.php?site=Equipment%20with%20issues&page='.$new_page.'';
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
					?>><a class="page-link" href="equipment_issues.php?site=Equipment%20with%20issues&page=<?php echo $i;?>"><?php echo $i;
					?></a></li>
					
			  
			  <?php
		}
		?>
			<li class="page-item"><a class="page-link" href="<?php
					if(($_GET['page']+1) > $pages){
						echo '#';
					}else{
						$new_page = $_GET['page'] + 1;
						echo 'equipment_issues.php?site=Equipment%20with%20issues&page='.$new_page.'';
					}
				  ?>">Next</a></li>
				  </ul>
			  </nav>
		<?php
		}
	}
?>