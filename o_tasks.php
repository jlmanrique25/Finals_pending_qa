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
	
	$sql_e = "SELECT * FROM `reports`,`equipment`,`users` WHERE task_due < now() AND reports.machine_id = equipment.equipment_id AND reports.assigned_user = users_id AND date_submitted is NULL ORDER BY date_created DESC";
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql_e)){
		echo 'error connecting to database';
	}else{
		$results = mysqli_query($conn, $sql_e);
	
?>

<div class="container-fluid py-4 overflow-hidden">
	<i class="fa-solid fa-chevrons-left"></i><a class="btn btn-primary"  href="index.php?site=Dashboard&page=1"><< Back</a>
	<br /><br />
	<table id="o_tasks_table">
		<thead class="thead-dark">
				<tr>
				<th scope="col">Task</th>
				<th scope="col">Equipment</th>
				<th scope="col">Asset</th>
				<th scope="col">Date Created</th>
				<th scope="col">Date Due</th>
				<th scope="col">Assignee</th>
				</tr>
			</thead>
			<tbody>
				<?php
					if($results->num_rows > 0){
						while($row = mysqli_fetch_array($results)){
							?>
								<tr role="button" data-href="machines.php?page=1&site=Equipment%20Information&e_id=<?php echo $row['equipment_id']?>&t=issues">
									<td><?php echo $row['task'];?></td>
									<td><?php echo $row['equipment_name'];?></td>
									<td><?php echo $row['asset'];?></td>
									<td><?php echo $row['date_created'];?></td>
									<td><?php echo $row['task_due'];?></td>
									<td><?php echo $row['username'];?></td>
								</tr>
							<?php
						}
					}else{
						echo 'No overdue tasks';
					}
				?>
			</tbody>
	</table>
	
</div>

<?php

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
					{ type: 'date', locale: 'en', format: '{dd}-{MM}-{yyyy|yy}' },
					{ type: 'date', locale: 'en', format: '{dd}-{MM}-{yyyy|yy}' },
					'string'],
		watermark: ['(e.g. Not functioning)', '(e.g. Generator Set 1)', '', '(e.g. >2022-01-01)', '(e.g. >2022-01-01)'],
		responsive: true,
		msg_filter: 'Filtering...',
        extensions:[{ name: 'sort' }]
	};
	
	var tf = new TableFilter('o_tasks_table', filtersConfig);
    tf.init();
</script>