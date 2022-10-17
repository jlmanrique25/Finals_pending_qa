<?php
if(!isset($_SESSION['role'])){
    session_start();
}
include 'header.php';
?>

<div class="container-fluid py-4 overflow-hidden">
    <div class="container py-4 ">
        <h2>
            <text style="font-weight:bold; text-transform: capitalize;">
                <?php echo $_GET['site'];?>
            </text>
        </h2><br />
        <a href="assign_issue.php?site=Report%20Equipment%20Issue" type="button" class="btn btn-danger btn-lg my-2">Report an equipment issue</a>

        <table id="tasks">
            <thead>
                <th scope="col">Tasks</th>
                <th scope="col">Equipment</th>
                <th scope="col">Floor</th>
                <th scope="col">Room</th>
                <th scope="col">Date Created</th>
                <th scope="col">Due Date</th>
                <th scope="col">Date Submitted</th>
                <th scope="col">Status</th>
            </thead>
            <tbody>
                <?php
				    include 'backend/get_tasks_issues.p.php';
                ?>
            </tbody>
        </table>
    </div>
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
		col_7: 'select',
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
					{ type: 'date', locale: 'en', format: '{dd}-{MM}-{yyyy|yy}' },
					'string'
		],
		watermark: ['(e.g. Not functioning)', '(e.g. Generator Set 1)', '', '404-A', '(e.g. >2022-01-01)','(e.g. >2022-01-01)', '(e.g. >2022-01-01)', ''],
		msg_filter: 'Filtering...',
		//extensions: [{ name: 'sort' }],
  //          auto_filter: {
  //          delay: 1000 //milliseconds
		//},
		single_filter: true,

		on_filters_loaded: function(tf){
            tf.setFilterValue(7, 'Unresolved');
            tf.filter();
        }
	};

	var tf = new TableFilter('tasks', filtersConfig);
    tf.init();
</script>