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
	
	$sql_i = "SELECT * FROM `users` WHERE users.users_id NOT IN (SELECT assigned_user FROM `reports`) AND role != 'head'AND role != 'admin' ORDER BY username LIMIT ".$min.",10";
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql_i)){
		echo 'error connecting to database';
	}else{
		$results = mysqli_query($conn, $sql_i);
	
?>
<div class="container py-4 overflow-hidden">
	<i class="icon-backward"></i><input type="button" class="btn btn-secondary" onclick="history.back()" value="<< Back"><br /><br />

	<h2><text style="font-weight:bold;">Available Staff</text> </h2> 

	<br>
	
	<table class="table rounded-3 shadow-lg table-hover mb-5">
		<thead class="thead-dark">
				<tr>
					<th scope="col">Username</th>
					<th scope="col">Email</th>
					<th scope="col">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
					if($results->num_rows > 0){
						while($row = mysqli_fetch_array($results)){
							?>
								<tr role="button">
									<td><?php echo $row['username'];?></td>
									<td><?php echo $row['email'];?></td>
									<td>
										<a type="button" class="btn btn-success" href="assign_new_task.php?site=Assign%20new%20task&u_id=<?php echo $row['users_id'];?>&username=<?php echo $row['username'];?>">
										<i class="fas fa-paper-plane"></i> Assign a task to employee
										</a>
									</td>
								</tr>
							<?php
						}
					}else{
						echo '<tr>
					<td colspan="7" class="text-center"> 
					There are no available employees
					</td>
				</tr>';
					}
				?>
			</tbody>
	</table>


<?php

	$sql = "SELECT count(users_id) as total FROM `users` WHERE users.users_id NOT IN (SELECT assigned_user FROM `reports`) AND role != 'head'AND role != 'admin'";
	
	
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
						echo 'i_users.php?site=Free%20Employees&page='.$new_page.'';
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
					?>><a class="page-link" href="i_users.php?site=Free%Employees&page=<?php echo $i;?>"><?php echo $i;
					?></a></li>
					
			  
			  <?php
		}
		?>
			<li class="page-item"><a class="page-link" href="<?php
					if(($_GET['page']+1) > $pages){
						echo '#';
					}else{
						$new_page = $_GET['page'] + 1;
						echo 'i_users.php?site=Free%20Employees&page='.$new_page.'';
					}
				  ?>">Next</a></li>
				  </ul>
			  </nav>
	</div>
		<?php
		}
	}
?>


<script src="tablefilter/tablefilter.js"></script>

<script data-config>
	var filtersConfig = {
		base_path: 'tablefilter/',
		responsive: true,
		paging: {
          results_per_page: ['Records: ', [10, 25, 50, 100]]
        },
		col_2: 'select',
		col_5: 'select',
		alternate_rows: true,
		rows_counter: true,
		sticky_headers: true,
		btn_reset: true,
		loader: true,
		status_bar: true,
		mark_active_columns: true,
		highlight_keywords: true,

		col_types: ['string',
					'string',
					'string',
					,
		watermark: ['(e.g. Username)', '(e.g. Email)', '', '(e.g. Action)'],
		responsive: true,
		msg_filter: 'Filtering...',
        extensions:[{ name: 'sort' }]

        
  		
			
	};
	
	var tf = new TableFilter('i_users_table', filtersConfig);
    tf.init();
</script>
<!-- <div class="col-md-12 text-center">
	<a href="dashboard.php" class="btn btn-info" role="button">Back to Dashboard</a>
</div> -->