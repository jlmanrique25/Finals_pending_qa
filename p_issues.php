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
	
	$sql_i = "SELECT * FROM `issue`,`equipment`,`users` WHERE issue.machine_id = equipment.equipment_id AND (issue.assigned_to = users.users_id OR issue.assigned_to = NULL) AND issue.issue_status = 0 ORDER BY date_due DESC";
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql_i)){
		echo 'error connecting to database';
	}else{
		$results = mysqli_query($conn, $sql_i);
?>

<div class="container py-4 overflow-hidden">
	<i class="fa-solid fa-chevrons-left"></i><input type="button" class="btn btn-secondary" onclick="history.back()" value="<< Back">
	<br /><br />

	<h2><text style="font-weight:bold;">Unresolved Issue Reports</text> </h2> 

	<br>
	<div class="container py-4">
	<table id="p_issues_table" width="100%">
			<thead class="thead-dark">
				<tr>
					<th scope="col">Issue</th>
					<th scope="col">Equipment</th>
					<th scope="col">Asset</th>
					<th scope="col">Date Created</th>
					<th scope="col">Date due</th>

					<th scope="col">Assignee</th>
					<th scope="col">Action</th>

				</tr>
			</thead>
			<tbody>
				<?php
					if($results->num_rows > 0){
						while($row = mysqli_fetch_array($results)){
							?>
								<tr role="button" role="button" data-href="viewPendingIssue.php?site=Pending%20Issue%20Report&i_id=<?php echo $row['issue_id']?>" data-toggle="modal" data-target="#<?php echo $row_issue['issue'];?>">
									<td><?php echo $row['issue'];?></td>
									<td><?php echo $row['equipment_name'];?></td>
									<td><?php echo $row['asset'];?></td>
									<td><?php echo $row['date_created'];?></td>
									<td><?php echo $row['date_due'];?></td>
									<td><?php echo $row['username'];?></td>
									<td><a href ="viewPendingIssue.php?site=Pending%20Issue%20Report&i_id=<?php echo $row['issue_id']?>" class="btn btn-info">View Issue</a></td>
								</tr>
							<?php
						}
					}else{
						?>
							<tr>
								<td colspan="6" class="text-center"> There are no issues to be done.</td>
							</tr>
						<?php
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
	
	var tf = new TableFilter('p_issues_table', filtersConfig);
    tf.init();
</script>