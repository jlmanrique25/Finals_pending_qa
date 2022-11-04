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

<div class="container py-4 overflow-hidden">
	<input type="button" class="btn btn-secondary" onclick="history.back()" value="<< Back"><br><br>

	<h2> <text style="font-weight:bold;">Overdue Tasks</text> </h2> 

	<br>
	<div class="container py-4">
	<table id="o_tasks_table">
		<thead class="thead-dark">
				<tr>
				<th scope="col">Task ID</th>
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
                <tr role="button" data-href="viewPendingTasks.php?r=<?php echo  $row['report_id'];?>&e=10&site=Pending%20Task">
                    <td>R-
                        <?php echo $row['report_id'];?>
                    </td><td>
                        <?php echo $row['task'];?>
                    </td>
                    <td>
                        <?php echo $row['equipment_name'];?>
                    </td>
                    <td>
                        <?php echo $row['asset'];?>
                    </td>
                    <td>
                        <?php echo $row['date_created'];?>
                    </td>
                    <td>
                        <?php echo $row['task_due'];?>
                    </td>
                    <td>
                        <?php echo $row['username'];?>
                    </td>
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
    		auto_filter: {
            delay: 1000 //milliseconds
		},
		single_filter: true,
        extensions:[{ name: 'sort' }]
	};
	
	var tf = new TableFilter('o_tasks_table', filtersConfig);
    tf.init();
</script>

	<!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>-->

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
