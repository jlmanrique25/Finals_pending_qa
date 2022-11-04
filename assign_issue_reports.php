<?php
	if(!isset($_SESSION['role'])){
		session_start();
	}
	include 'header.php';
?>

<head>
	<title>Assign Issue Report</title>

</head>

	<?php
		if(isset($_GET['del']) && $_GET['del'] == 'true'){
			?>
			<div class="alert alert-success" role="alert" id="update_alert">
			  <strong> issue deleted</strong >

			 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>

			</div>
			<?php
		}
	?>
	
	<?php
		if(isset($_GET['update'])&& $_GET['update'] == "success"){
			include 'backend/dbh.p.php';
			
			$sql_update = "SELECT issue_id, issue.issue, users.users_id, users.username, issue.date_due FROM `issue`, `users` WHERE issue_id = ".$_GET['i']." AND users.users_id = ".$_GET['u_id']."";
			$stmt = mysqli_stmt_init($conn);
			
			$result_update = mysqli_query($conn, $sql_update);
			$row_update = mysqli_fetch_assoc($result_update)
			?>
			<div class="alert alert-success update_alert" role="alert" id="update_alert">
			  <h4 class="alert-heading">Issue assigned!</h4>
			  <p>You have assigned issue: <strong><?php echo $row_update['issue'];?></strong> to user <strong><?php echo $row_update['username'];?></strong> due on <strong><?php echo $row_update['date_due'];?></strong>.</p>
			  <hr>
			  <p class="mb-0">Made a mistake? <a href="backend/undo_issue.p.php?i=<?php echo $_GET['i'];?>" class="alert-link">UNDO</a>.</p>
			</div>
			<?php
		}else if(isset($_GET['update'])&& $_GET['update'] == "undo"){
			?>
				<div class="alert alert-warning" role="alert" id="update_alert">
				  Assigned user removed.
				</div>
			<?php
		}
	?>
	<div class= "container py-4 ">

	<h2> <text style="font-weight:bold;">Unassigned Issue Reports</text> </h2> <br>

	<!-- <table class="table rounded-3 shadow table-hover mb-5" id="issue_reports">-->
	<table  id="issue_reports">
	  <thead class="thead-dark">
		<tr>
		  <th scope="col">Issue ID</th>
		  <th scope="col">Issue</th>
		  <th scope="col">Equipment</th>
		  <th scope="col">Asset</th>
		  <th scope="col">Date Created</th>
		  <th scope="col">Action</th>
		</tr>
	  </thead>
	  <tbody>
	  
		<?php
			include 'backend/assign_unassigned_issues.p.php';
        ?>
	  </tbody>
	</table>
	
</div>
</div>
<script type ="text/javascript">
	$(document).ready(function(){
		setTimeout(function() {
			const alert = document.getElementById("update_alert");
			
			alert.style.display = 'none';
		}, 3000)
	});
</script>

<script src="tablefilter/tablefilter.js"></script>

<script data-config>
	var filtersConfig = {
		base_path: 'tablefilter/',
		responsive: true,
		paging: {
          results_per_page: ['Records: ', [10, 25, 50, 100]]
        },
		col_2: 'select',
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
					'string'
		],
		col_widths: [
            '350px', '200px', '200px',
            '200px', '200px'
        ],
		watermark: ['(e.g. Not functioning)', '(e.g. Generator Set 1)', '', '(e.g. >2022-01-01)', '(e.g. >2022-01-01)', '(e.g. >2022-01-01)',],
		msg_filter: 'Filtering...',
		auto_filter: {
            delay: 1000 //milliseconds
		},
		single_filter: true,
        extensions:[{ name: 'sort' }]
	};
	/** var tf = new TableFilter(document.querySelector('.table'), tfConfig);*/
	var tf = new TableFilter('issue_reports', filtersConfig);
    tf.init();
</script>

	<!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>-->

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
