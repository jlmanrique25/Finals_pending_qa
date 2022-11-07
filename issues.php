<head>
	<title>Issues</title>
</head>
<?php
	session_start();
	include 'header.php';
?>

	<div class="container py-4">
    <!--<table class="table rounded-3 shadow-lg table-hover mb-5" id="issues_table"> -->
    <input type="button" class="btn btn-secondary" onclick="history.back()" value="<< Back" /><br /><br />
    <h2>
        <text style="font-weight:bold;"> Issue reports <input type="button" class="btn btn-success" value="Export Table" onclick="$('#issues_table').tableExport({type:'csv'});" /></text>
    </h2>
    <i class="bi bi-info-circle-fill"></i>
    <br />
        <table id="issues_table" class="std_table"
            data-toggle="table"
            data-maintain-selected="true"
            data-sort-name="Zeitpunkt"
            data-sort-order="asc"
            data-search="true"
            data-show-pagination-switch="true"
            data-pagination="true"
            data-page-list="[10, 25, 50, 100, ALL]"
            data-page-size="25"
            data-show-footer="false"
            data-side-pagination="client"
            data-show-export="true"
            data-export-types="['excel', 'pdf']"
            data-export-options="{
              }"
            data-click-to-select="true">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Issue ID</th>
                    <th scope="col">Issue</th>
                    <th scope="col">Equipment</th>
                    <th scope="col">Floor</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">Date Due</th>
                    <th scope="col">Date Resolved</th>
                    <th scope="col">Assignee</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
			include 'backend/fetch_issues.p.php'
                ?>
            </tbody>
        </table>

</div>
<script src="tableExport.js"></script>
<script src="tablefilter/tablefilter.js"></script>

<script data-config>
	var filtersConfig = {
		base_path: 'tablefilter/',
		responsive: true,
		paging: {
          results_per_page: ['Records: ', [10, 25, 50, 100]]
        },
    	single_filter: true,
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
					{ type: 'date', locale: 'en', format: '{dd}-{MM}-{yyyy|yy}' },
					{ type: 'date', locale: 'en', format: '{dd}-{MM}-{yyyy|yy}' },
					'string',
					'string'
		],
		watermark: ['(e.g. Not functioning)', '(e.g. Generator Set 1)', '', '(e.g. >2022-01-01)', '(e.g. >2022-01-01)', '(e.g. >2022-01-01)',],
		msg_filter: 'Filtering...',
    		auto_filter: {
            delay: 1000 //milliseconds
        },
        extensions:[{ name: 'sort' }]
	};

	var tf = new TableFilter('issues_table', filtersConfig);
    tf.init();
</script>

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="js/tableexport.js"></script>