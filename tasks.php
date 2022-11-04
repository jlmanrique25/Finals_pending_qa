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

        <?php
		if(isset($_GET['submition']) && $_GET['submition'] == "success"){
			include 'backend/dbh.p.php';

			$sql_update = "SELECT * FROM `issue`, `users` WHERE issue_id = ".$_GET['i']."";
			$stmt = mysqli_stmt_init($conn);

			$result_update = mysqli_query($conn, $sql_update);
			$row_update = mysqli_fetch_assoc($result_update)
        ?>
        <div class="alert alert-success update_alert" role="alert" id="update_alert">
            <h4 class="alert-heading">Issue done!</h4>
            <p>
                Finished issue: <strong>
                    <?php echo $row_update['issue'];?>
                </strong> today!
            </p>
            <hr />
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

        <a href="assign_issue.php?site=Report%20Equipment%20Issue" type="button" class="btn btn-danger btn-lg my-2">Report an equipment issue</a>


        <?php
				if($_SESSION['role'] == "Admin"){
        ?>
        <a class="btn btn-warning dropdown-toggle btn-lg m-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Select type of reports <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="tasks.php?site=task%20reports&page=1&i_status=0">Task Reports</a>
            <a class="dropdown-item" href="tasks.php?site=issue%20reports&page=1&i_status=1">Issue Reports</a>
        </div>
        <?php
				}
        ?>

        <table id="tasks_table">
            <thead class="thead-dark">
                <tr>
                    <?php
				if($_SESSION['role'] == "Head"){
                    ?>
                    <th scope="col">Issues</th>
                    <th scope="col">Equipment</th>
                    <th scope="col">Floor</th>
                    <th scope="col">Room</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">Due Date</th>
                    <th scope="col">Date Submitted</th>
                    <th scope="col">Status</th>
                    <?php
				}
				else if($_SESSION['role'] == "Admin")
                {
                    if($_GET['site'] == 'task reports'){
                    ?>

                    <th scope="col">Tasks</th>
                    <th scope="col">Equipment</th>
                    <th scope="col">Floor</th>
                    <th scope="col">Room</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">Due Date</th>
                    <th scope="col">Date Submitted</th>
                    <th scope="col">Status</th>

                    <?php
                    }else{
                    ?>
                    <th scope="col">Issues</th>
                    <th scope="col">Equipment</th>
                    <th scope="col">Floor</th>
                    <th scope="col">Room</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">Due Date</th>
                    <th scope="col">Date Submitted</th>
                    <th scope="col">Status</th>
                    <?php
                    }

                }

				else{
                    ?>
                    <th scope="col">Tasks</th>
                    <th scope="col">Equipment</th>
                    <th scope="col">Floor</th>
                    <th scope="col">Room</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">Due Date</th>
                    <th scope="col">Date Submitted</th>
                    <th scope="col">Status</th>
                    <?php
				}
                    ?>

                </tr>
            </thead>
            <tbody>
                <?php
				include 'backend/get_tasks_issues.p.php';
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
		col_7: 'select',
		alternate_rows: true,
		rows_counter: true,
		sticky_headers: true,
		btn_reset: true,
		loader: true,
		status_bar: true,
		mark_active_columns: true,
		highlight_keywords: true,
        single_filter: true,
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
		//single_filter: true,

		on_filters_loaded: function(tf){
            tf.setFilterValue(7, 'Unresolved');
            tf.filter();
        }
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
