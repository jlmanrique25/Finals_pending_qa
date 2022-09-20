<head>
	<style>
		#filters{
			display: flex;
			align-items: baseline;
		}
	</style>
	<title>Reports</title>
	<script type="text/javascript" src="Scripts/bootstrap.min.js"></script>
	<script type="text/javascript" src="Scripts/jquery-2.1.1.min.js"></script>
	
	<!-- Font awesome elements link -->
	<link href="/elements/css/fontawesome.css" rel="stylesheet">
	<link href="/elements/css/all.min.css" rel="stylesheet">
	<link href="/elements/css/brands.css" rel="stylesheet">
	<link href="/elements/css/solid.css" rel="stylesheet">
</head>
<?php
	session_start();
	include 'header.php';
?>

<!--<div class="container-fluid py-4 overflow-hidden"> -->
	<div class="container py-4">
	<input type="button" class="btn btn-secondary" onclick="history.back()" value="<< Back" /><br /><br />
    <h2>
        This page consists of all the<text style="font-weight:bold;"> Equipment reports</text>
    </h2>
    <i class="bi bi-info-circle-fill"></i>
    <br />
	<table  id="reports_table">
	  <thead class="thead-dark">
		<tr>
		  <th scope="col">Task</th>
		  <th scope="col">Equipment</th>
		  <th scope="col">Floor</th>
		  <th scope="col">Room Number</i></th>
		  <th scope="col">Report Status</th>
		 <th scope="col">Date Created</th>
		  <th scope="col">Date Submitted</th>
		  <th scope="col">For Repair</th>
		  <th scope="col">Assignee</th>
		  <th scope="col">Action</th>
		</tr>
	  </thead>
	  <tbody>


		<?php
			//include 'backend/dropdown_filter_status.p.php'; 
		?>
	
		<?php
			//include 'backend/search.php'; 
		?>

		<?php 
			include 'backend/fetch_reports.p.php'
		?>

		<?php 
			//include 'backend/dropdown_filters.p.php'
		?>

	  </tbody>
	</table>
	
</div>

<script src="tablefilter/tablefilter.js"></script>

<script data-config>
	var filtersConfig = {
		base_path: 'tablefilter/',
		responsive: true,
		paging: {
          results_per_page: ['Records: ', [10, 25, 50, 100]]
        },
		col_2: 'select',
		col_4: 'select',
		col_7: 'select',
		col_8: 'select',
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
        extensions:[{ name: 'sort' }]
	};

	var tf = new TableFilter('reports_table', filtersConfig);
    tf.init();
</script>

