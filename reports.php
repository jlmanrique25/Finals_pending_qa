<head>

	<title>Reports</title>
</head>
<?php
	session_start();
	include 'header.php';
?>

<!--<div class="container-fluid py-4 overflow-hidden"> -->
	<div class="container py-4">
	<input type="button" class="btn btn-secondary" onclick="history.back()" value="<< Back" /><br /><br />
    <h2>
        <!--<text style="font-weight:bold;">Equipment reports   <input type="button" class="btn btn-success" value="Export Table" onclick="$('#reports_table').tableExport({type:'csv'});"/></text>-->
		<text style="font-weight:bold;"> Equipment reports <input type="button" class="btn btn-success" value="Export Table" onclick="$('#reports_table').tableExport({type:'csv',escape:'false'});" /></text>
    </h2>
    <i class="bi bi-info-circle-fill"></i>
    <br />
	<table  id="reports_table" >
	  <thead >
		<tr>
		  <th scope="col">Report ID</th>
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
			include 'backend/fetch_reports.p.php'
        ?>
	  </tbody>
	</table>
	
</div>
<script src="tableexport/tableExport.js"></script>
<script src="tablefilter/tablefilter.js"></script>


<script data-config>
	var filtersConfig = {
		base_path: 'tablefilter/',
		responsive: true,
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
		paging: {
          results_per_page: ['Records: ', [10, 25, 50, 100]]
		},
		
		alternate_rows: true,
		rows_counter: true,
		btn_reset: true,
		loader: true,
		status_bar: true,
		mark_active_columns: true,
		highlight_keywords: true,

		watermark: ['(e.g. Not functioning)', '(e.g. Generator Set 1)', '', '404-A', '','(e.g. >2022-01-01)', '(e.g. >2022-01-01)', '',''],
		msg_filter: 'Filtering...',
		extensions: [{ name: 'sort' }],
		auto_filter: {
            delay: 1000 //milliseconds
        },
		single_filter: true
		
	};

	var tf = new TableFilter('reports_table', filtersConfig);
    tf.init();
</script>

	<!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>-->

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<!--<script src="js/tableexport.js"></script>-->
	
    <script type="text/javascript" src="tableExport.js"></script>
    <script type="text/javascript" src="jquery.base64.js"></script>