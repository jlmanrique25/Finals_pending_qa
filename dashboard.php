<head>
<title>Dashboard</title>
</head>
<body>
	<div class="container py-4">
	<!--START OF CODE FOR DASHBOARD DATA-->
		<div class="p-5 mb-3 bg-light rounded-3 shadow-sm">
		  <div class="container-fluid py-3 overflow-hidden">
		  <h4> The reports are the following as of: <?php 
		  date_default_timezone_set('Asia/Hong_Kong');
			$date_created = date('Y-m-d h:i:s a', time());
			echo date('F d, Y', strtotime($date_created));
		  ?></h4>
			<div class="row mb-2">
				<div class="col text-light p-2">
					<a class="container btn btn-primary rounded-3 d-flex gap-3 p-4" href="n_issues.php?site=New%20Issues&page=1" role="button"
					style="margin-bottom:4px;white-space: normal;">
						<p class="display-3  font-weight-bold"><?php include 'backend/count_new_issues.p.php';?></p>
						<div class=" text-left">
							<h4 class="mb-0 text-uppercase">new issues</h6>
							<p class="mb-0 text-light">The total number of unassigned issues</p>
						</div>
						
					</a>
				</div>
				<div class="col text-light p-2">
					<a class="container btn btn-primary rounded-3 d-flex gap-3 p-4" href="p_issues.php?site=Pending%20Issues&page=1" role="button"
					style="margin-bottom:4px;white-space: normal;">
						<p class="display-3  font-weight-bold"><?php include 'backend/count_issues.p.php';?></p>
						<div class=" text-left">
							<h4 class="mb-0 text-uppercase">pending issues</h6>
							<p class="mb-0 text-light">The total number of unresolved issues</p>
						</div>
						
					</a>
				</div>
				<div class="col text-light p-2">
					<a class="container btn btn-primary rounded-3 d-flex gap-3 p-4" href="o_issues.php?site=Overdue%20Issues&page=1" role="button"
					style="margin-bottom:4px;white-space: normal;">
						<p class="display-3  font-weight-bold"><?php include 'backend/count_overdue_issues.p.php';?></p>
						<div class=" text-left">
							<h4 class="mb-0 text-uppercase">overdue issues</h6>
							<p class="mb-0 text-light">The total number of overdue issues</p>
						</div>
						
					</a>
				</div>
				
			</div>
			<div class="row">
				<div class="col text-light p-2">
					<a class="container btn btn-primary rounded-3 d-flex gap-3 p-4" href="i_users.php?site=Available%20Staff&page=1" role="button"
					style="margin-bottom:4px;white-space: normal;">
						<p class="display-3  font-weight-bold"><?php
							include 'backend/idle_users.p.php';
						?></p>
						<div class=" text-left">
							<h4 class="mb-0 text-uppercase">Available Staff</h6>
							<p class="mb-0 text-light">The number of users with no assigned tasks</p>
						</div>
					</a>
				</div>
				<div class="col text-light p-2">
					<a class="container btn btn-primary rounded-3 d-flex gap-3 p-4" href="u_tasks.php?site=Pending%20Tasks&page=1" role="button"
					style="margin-bottom:4px;white-space: normal;">
						<p class="display-3  font-weight-bold"><?php 
							include 'backend/count_unfinished.p.php';
						?></p>
						<div class=" text-left">
							<h4 class="mb-0 text-uppercase">pending tasks</h6>
							<p class="mb-0 text-light">The number of unresolved tasks of employees</p>
						</div>
					</a>
				</div>
				<div class="col text-light p-2">
					<a class="container btn btn-primary rounded-3 d-flex gap-3 p-4" href="o_tasks.php?site=Overdue%20Tasks&page=1" role="button"
					style="margin-bottom:4px; white-space: normal;">
						<p class="display-3 font-weight-bold"><?php
							include 'backend/count_equipment_issues.p.php';
						?>
						</p>
						<div class=" text-left">
							<h4 class="mb-0 text-uppercase">Overdue tasks</h6>
							<p class="mb-0 text-light">Total number of overdue tasks</p>
						</div>
					</a>
				</div>
			</div>
		  </div>
		  </div>
		  <!--START OF CODE FOR UPDATE FIELD-->
		  <div class="my-3 p-3 bg-body rounded shadow-sm">
			<h6 class="border-bottom pb-2 mb-0">Activities (last 7 days)</h6>
			
			<!--
			!!!!!!
			WHERE YOU'LL INSERT THE FOR LOOP TO PRINT MULTIPLE UPDATES
			!!!!!!
			-->
			
			<?php
				include 'backend/filter_report_issues.p.php';
			?>
			
			<small class="d-block text-end mt-3">
				<?php
					include 'backend/count_weekly_updates.p.php';
                ?>
			</small>
		  </div>
		</div>
</body>

	<!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>-->

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
