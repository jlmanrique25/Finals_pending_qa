<?php
if(!isset($_SESSION['role'])){
    session_start();
}
include 'header.php';
?>

<head>
    <title>My Tasks</title>

</head>

<div class="container-fluid py-4 overflow-hidden">
    <div class="container py-4 ">
        <h2>
            <text style="font-weight:bold; text-transform: capitalize;">
                <?php echo $_GET['site'];?>
            </text>
        </h2><br />

        <a href="assign_issue.php?site=Report%20Equipment%20Issue" type="button" class="btn btn-danger btn-lg my-2">Report an equipment issue</a>
        <a class="btn btn-warning dropdown-toggle btn-lg m-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Select type of reports <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="admin_tasks_table.php?site=Unresolved%20Tasks&table=unresolved">Task Reports</a>
            <a class="dropdown-item" href="admin_issues_table.php?site=Unresolved%20Issues&table=unresolved">Issue Reports</a>
        </div>
        <?php
        if(isset($_GET['table']) && $_GET['table'] == 'resolved')
        {
        ?>
            <a href="admin_tasks_table.php?site=Unresolved%20Tasks&table=unresolved" type="button" class="btn btn-warning btn-lg my-2">Unresolved Tasks</a>
            <a href="admin_tasks_table.php?site=Resolved%20Tasks&table=resolved" type="button" class="btn btn-success btn-lg my-2">Resolved Tasks</a>
            <?php
             
        }
        else
        {
            ?>
            <a href="admin_tasks_table.php?site=Unresolved%20Tasks&table=unresolved" type="button" class="btn btn-success btn-lg my-2">Unresolved Tasks</a>
            <a href="admin_tasks_table.php?site=Resolved%20Tasks&table=resolved" type="button" class="btn btn-warning btn-lg my-2">Resolved Tasks</a>
            <?php
        }
        ?>
       

        <table id="tasks_table">
            <thead class="thead-dark">
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
                if(isset($_GET['table']) && $_GET['table'] == 'resolved')
                {
                    include 'backend/get_resolved_tasks.p.php';
                }
                else
                {
                    include 'backend/get_unresolved_tasks.p.php';
                }

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


	};

	var tf = new TableFilter('tasks_table', filtersConfig);
    tf.init();
</script>


<!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>-->

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
