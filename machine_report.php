<html lang="en">
<head>
	<title>Equipment Report</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/a076d05399.js"></script>
	<link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/sidebars/">
	<link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link href="style.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="{your path to tablefilter}/style/tablefilter.css" />
</head>
<?php
	session_start();
	include 'backend/dbh.p.php';

	$sql_equipment = "SELECT * FROM `equipment` WHERE equipment_id = ".$_GET['e_id']."";
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql_equipment)){
		echo 'error connecting to the database';
	}else{
		$result_equipment = mysqli_query($conn, $sql_equipment);
		$row_equipment = mysqli_fetch_assoc($result_equipment);
		
		$sql_location = "SELECT * FROM `location` WHERE location_id = ".$row_equipment['location_id']."";
		
		if(!mysqli_stmt_prepare($stmt, $sql_location)){
			echo 'error connecting to database location';
		}else{
			
			$result_loc = mysqli_query($conn, $sql_location);
			$row_loc = mysqli_fetch_assoc($result_loc);
			?>

<body style="background-color: rgba(0, 0, 0, .1);">	
	<div class="container-fluid py-4 overflow-hidden">

		<header class="d-flex align-items-center pb-3  border-bottom border-dark">
		<p class="d-flex align-items-center text-dark text-decoration-none  fw-b">
		  <span class="fs-3 fw-bold"><?php echo $row_equipment['equipment_name']?></span>
		  	<a onclick="window.print()" type="button" class="btn btn-success btn-lg m-2" id="printButton">
		  		Print Report
		  	</a>
		</p>
		</header>
		<div class="container col-xxl-8 px-4 py-5">
		<div class="row flex-lg-row-reverse align-items-center g-5 py-5">
		  <div class="col-10 col-sm-8 col-lg-6">
			<img src="equip_img/equipment_placeholder.png" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
		  </div>
		  <div class="col-lg-6">
			<p class="text-uppercase h5"><b>asset: </b> <small class="lead"><?php echo $row_equipment['asset'];?></small></p>
			<p class="text-uppercase h5"><b>Number of repairs: </b> <small class="lead"><?php echo $row_equipment['num_of_repairs'];?></small></p>
			<p class="text-uppercase h5"><b>brand: </b> <small class="lead"><?php echo $row_equipment['brand'];?></small></p>
			<p class="text-uppercase h5"><b>machine description: </b> <small class="lead"><?php echo $row_equipment['machine_description'];?></small></p>
			<p class="text-uppercase h5"><b>floor: </b> <small class="lead"><?php echo $row_loc['floor'];?></small></p>
			<p class="text-uppercase h5"><b>room number: </b> <small class="lead"><?php echo $row_loc['room_number'];?></small></p>
			<p class="text-uppercase h5"><b>Model number: </b> <small class="lead"><?php echo $row_equipment['model_no'];?></small></p>
			<p class="text-uppercase h5"><b>Serial number: </b> <small class="lead"><?php echo $row_equipment['serial_no'];?></small></p>
			<p class="text-uppercase h5"><b>date of purchase: </b> <small class="lead"><?php echo $row_equipment['date_of_purchase'];?></small></p>
			
			<?php 
				if(!is_null($row_equipment['asset'])){
					?>
					<p class="text-uppercase h5"><b>Date last used: </b> <small class="lead"><?php echo $row_equipment['date_last_used'];?></small></p>
					<?php
				}

			?>	
			
			<p class="text-uppercase h5"><b>condition: </b> <small class="lead"><?php echo $row_equipment['condition'];?></small></p>
			<p class="text-uppercase h5"><b>is operating: </b> <small class="lead"><?php 
			if($row_equipment['operating']){
				echo 'Operational';
			}else{
				echo 'Not Operational';
			}
			?></small></p>
		  </div>
		</div>
	  </div>
				<?php
			}
		}
	?>
	<?php 
		if(isset($_GET['t']) && $_GET['t'] == 'reports'){
			?>
			<table id="tasks_table">
			  <thead class="thead-dark">
				<tr>
				  <th scope="col">Task</th>
				  <th scope="col">Report status</th>
				  <th scope="col">Date created</th>
				  <th scope="col">Date due</th>
				  <th scope="col">Date submitted</th>
				  <th scope="col">For repair/with issues</th>
				  <th scope="col">Assignee</th>
				</tr>
			  </thead>
			  <tbody>
			  
				<?php
					include 'backend/get_reports_equip.p.php';
				?>
			  </tbody>
			</table>
			<?php
				include 'backend/indiv_equip_pagination.p.php';
		}
		if(isset($_GET['t']) && $_GET['t'] == 'issues'){
			?>
			<table id="issues_table">
			  <thead class="thead-dark">
				<tr>
				  <th scope="col">Issue</th>
				  <th scope="col">Issue status</th>
				  <th scope="col">Date created</th>
				  <th scope="col">Date due</th>
				  <th scope="col">Date submitted</th>
				  <th scope="col">Assigned to</th>
				</tr>
			  </thead>
			  <tbody>
			  
				<?php
					include 'backend/get_reports_equip.p.php';
				?>
			  </tbody>
			</table>
			<?php
				include 'backend/indiv_equip_pagination.p.php';
		}
            ?>
	

</div>
	</body>

<script src="tablefilter/tablefilter.js"></script>

<script data-config>
	var filtersConfig = {
		base_path: 'tablefilter/',
		responsive: true,
		paging: {
          results_per_page: ['Records: ', [10, 25, 50, 100]]
        },
		col_1: 'select',
		col_5: 'select',
		col_6: 'select',
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
					{ type: 'date', locale: 'en', format: '{dd}-{MM}-{yyyy|yy}' },
					{ type: 'date', locale: 'en', format: '{dd}-{MM}-{yyyy|yy}' },
					{ type: 'date', locale: 'en', format: '{dd}-{MM}-{yyyy|yy}' },
					'string',
					'string',
		],
		col_widths: [
            '350px', '200px', '200px',
            '200px', '200px'
        ],
		watermark: ['(e.g. Fix filters)', '', '(e.g. >2022-01-01)', '(e.g. >2022-01-01)', '(e.g. >2022-01-01)', '', ''],
		msg_filter: 'Filtering...',
        extensions:[{ name: 'sort' }]
	};

	var tf = new TableFilter('tasks_table', filtersConfig);
    tf.init();
</script>

<script data-config>
	var filtersConfig = {
		base_path: 'tablefilter/',
		responsive: true,
		paging: {
          results_per_page: ['Records: ', [10, 25, 50, 100]]
        },
		col_1: 'select',
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
					{ type: 'date', locale: 'en', format: '{dd}-{MM}-{yyyy|yy}' },
					{ type: 'date', locale: 'en', format: '{dd}-{MM}-{yyyy|yy}' },
					{ type: 'date', locale: 'en', format: '{dd}-{MM}-{yyyy|yy}' },
					'string'
		],
		col_widths: [
            '350px', '200px', '200px',
            '200px', '200px', '200px'
        ],
		watermark: ['(e.g. Not functioning)', '', '(e.g. >2022-01-01)', '(e.g. >2022-01-01)', '(e.g. >2022-01-01)', ''],
		msg_filter: 'Filtering...',
        extensions:[{ name: 'sort' }]
	};

	var tf = new TableFilter('issues_table', filtersConfig);
    tf.init();
</script>