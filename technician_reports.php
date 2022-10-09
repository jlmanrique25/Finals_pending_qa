

<head>
	<title>Past Reports</title>

</head>
<?php
	if(!isset($_SESSION['role'])){
		session_start();
	}
	include 'header.php';


?>
<div class="container-fluid py-4 overflow-hidden">
<!--

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
	-->
	<?php
	if($_GET['site'] == "My Reports"){
    ?>
	<div class= "container py-4 ">
		<a href="assign_issue.php?site=Report%20Equipment%20Issue" type="button" class="btn btn-danger btn-lg my-2">Report an equipment issue</a>
    <table  id="reports_table">
        <thead >
            <tr role="button" data-href="viewPastReports.php?r=<?php echo $row['report_id'];?>&e=<?php echo $row['machine_id'];?>&site=My%20Past%20Reports">
                <th scope="col">Tasks</th>
                <th scope="col">Equipment</th>
                <th scope="col">Floor</th>
                <th scope="col">Room</th>
                <th scope="col">Date created</th>
                <th scope="col">Due date</th>
                <th scope="col">Date submitted</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
					include 'backend/get_reports_issues.p.php';
            ?>
        </tbody>
    </table>
		</div>
		<?php
	}else if($_GET['site'] == "My Issues Reported"){
        ?>
	<div class= "container py-4 ">
		<a href="assign_issue.php?site=Report%20Equipment%20Issue" type="button" class="btn btn-danger btn-lg my-2">Report an equipment issue</a>
		<table id="issues_table">
			<thead class="thead-dark">
				<tr>
				<th scope="col">Issues</th>
				<th scope="col">Equipment</th>
				<th scope="col">Floor</th>
				<th scope="col">Room</th>
				<th scope="col">Date created</th>
				<th scope="col">Status</th>
				<th scope="col">Assigned to</th>
				</tr>
			</thead>
			<tbody>
				<?php
					include 'backend/get_reports_issues.p.php';
				?>
			</tbody>
		</table>
		</div>
		<?php
	}
        ?>
	
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
					'string',
					'string',
					{ type: 'date', locale: 'en', format: '{dd}-{MM}-{yyyy|yy}' },
					{ type: 'date', locale: 'en', format: '{dd}-{MM}-{yyyy|yy}' },
					'string',
					'string'
		],
		watermark: ['(e.g. Not functioning)', '(e.g. Generator Set 1)', '', '404-A', '','(e.g. >2022-01-01)', '(e.g. >2022-01-01)', '',''],
		msg_filter: 'Filtering...',
    		auto_filter: {
            delay: 1000 //milliseconds
		},
		single_filter: true,
        extensions:[{ name: 'sort' }]
	};

	var tf = new TableFilter('reports_table', filtersConfig);
    tf.init();
</script>

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
					'string',
					'string',
					{ type: 'date', locale: 'en', format: '{dd}-{MM}-{yyyy|yy}' },
					{ type: 'date', locale: 'en', format: '{dd}-{MM}-{yyyy|yy}' },
					'string',
					'string'
		],
		watermark: ['(e.g. Not functioning)', '(e.g. Generator Set 1)', '', '404-A', '','(e.g. >2022-01-01)', '(e.g. >2022-01-01)', '',''],
		msg_filter: 'Filtering...',
    	auto_filter: {
            delay: 1000 //milliseconds
		},
		single_filter: true,
        extensions:[{ name: 'sort' }]
	};

	var tf = new TableFilter('issues_table', filtersConfig);
    tf.init();
</script>