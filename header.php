<?php
	if (isset($_SESSION['role'])){
		
?>

<html lang="en">
<head>
	<title>header</title>
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
	
</head>
<body style="background-color: rgba(0, 0, 0, .1);">	
	<nav class="navbar navbar-dark" style="background-color: rgba(34, 18, 119, 1);">
	  <div class="container-fluid">
		<a class="navbar-toggler" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample" style="margin-right: 16px;">
			<span class="navbar-toggler-icon"></span>
		</a>
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a class="navbar-brand text-capitalize" aria-current="page" href="#">
			<?php 
				if(isset($_GET['site'])){
					echo $_GET['site'];
					}
				else{
					echo 'Dashboard';
				}
			?></a>
          </li>
        </ul>
	  </div>
	  	
	</nav>
  
	<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel" style="background-color: FFE162;">
	  <div class="offcanvas-header">
		<div class="offcanvas-title" id="offcanvasExampleLabel">
			<img src="images/keoms_logo.png" alt="APC Logo" style="width:50px;height:50px;">
			<h5><strong>KEOMS</strong></h5></div>
		<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	  </div>
	  <div class="offcanvas-body">
		<div>
		  Short for Key Equipment Operational Monitoring System, KEOMS is a responsive website that aims to help the BMO with reporting and storing data
		</div>
		<div class="dropdown mt-3">
		<ul class="list-unstyled ps-0">
		<?php
			if($_SESSION['role'] == "Admin" || $_SESSION['role'] == "Head"){
		?>
		
		
		  <li class="mb-1">
			<a class="btn btn-toggle align-items-center rounded" href="index.php?site=Dashboard&page=1">
			  Dashboard
			</a>
		  </li>
		  <li class="mb-1">
			<a class="btn btn-toggle align-items-center rounded" href="reports.php?site=Reports&page=1&time=day">
			  Reports
			</a>
		  <!--
			<button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
			  Reports
			</button>
			<div class="collapse" id="dashboard-collapse">
			  <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
				<li><a href="#" class="link-dark rounded">Daily</a></li>
				<li><a href="#" class="link-dark rounded">Weekly</a></li>
				<li><a href="#" class="link-dark rounded">Monthly</a></li>
				<li><a href="#" class="link-dark rounded">All Reports</a></li>
			  </ul>
			</div>
			-->
		  </li>
		  
		  <li class="mb-1">
		  <a class="btn btn-toggle align-items-center rounded" href="issues.php?site=Issues&page=1&time=month">
			  Issues
			</a>
		  <!--
			<button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#issues-collapse" aria-expanded="false">
			  Issues
			</button>
			<div class="collapse" id="issues-collapse">
			  <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
				<li><a href="#" class="link-dark rounded">New</a></li>
				<li><a href="#" class="link-dark rounded">Pending</a></li>
				<li><a href="#" class="link-dark rounded">Done</a></li>
				<li><a href="#" class="link-dark rounded">All issue reports</a></li>
			  </ul>
			</div>
			-->
		  </li>
		  
		  <li class="mb-1">
			<a class="btn btn-toggle align-items-center rounded" href="equipment.php?site=Equipment&page=1">
			  Equipment Inventory
			</a>
			<!--
			<button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
			  Machines/Equipment
			</button>
			<div class="collapse" id="orders-collapse">
			  <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
				<li><a href="#" class="link-dark rounded">HVAC</a></li>
				<li><a href="#" class="link-dark rounded">Gensets</a></li>
				<li><a href="#" class="link-dark rounded">Plumbing</a></li>
				<li><a href="#" class="link-dark rounded">Pumps</a></li>
				<li><a href="#" class="link-dark rounded">All machines</a></li>
			  </ul>
			</div>
			-->
		  </li>
		  
		  <li class="mb-1">
			<button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
			  Management
			</button>
			<div class="collapse" id="orders-collapse">
			  <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
				<li><a href="tasks.php?site=Unresolved%20Issues&page=1" class="link-dark rounded">Tasks <span class="badge badge-danger"><?php 
					
					include 'backend/count_task_assigned_admin.p.php';
					
				?></span></a></li>
				<li><a href="assign_new_task.php?site=Assign%20new%20task" class="link-dark rounded">Assign New Task</a></li>
				<?php if($_SESSION['role'] == "Head"){?>
				<li><a href="assign_issue_reports.php?site=Unassigned%20Reports" class="link-dark rounded">Assign Issue Report</a></li>
				<?php	}
				?>
				<li><a href="add_new_equipment.php?site=Add%20New%20Equipment" class="link-dark rounded">Add New Equipment</a></li>
				<li><a href="assign_issue.php?site=Report%20Issue" class="link-dark rounded">Create Issue Report</a></li>
				<?php if($_SESSION['role'] == "Head"){?>
				<li><a href="users.php?page=1&site=Users" class="link-dark rounded">Manage Users</a></li>
				<?php	}
				?>
			  </ul>
			</div>
		  </li>
		  
		  
			<!--<ul class="nav nav-pills flex-column mb-auto">
				<li class="nav-item">
					<a href="#" class="nav-link active" aria-current="page">
					<svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
					Employees
					</a>

			
			</ul>
			
			<button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#users-collapse" aria-expanded="false">
			  Employees
			</button>
			
			<div class="collapse" id="users-collapse">
			  <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
				<li><a href="#" class="link-dark rounded">Normal users</a></li>
				<li><a href="#" class="link-dark rounded">Admin users</a></li>
				<li><a href="#" class="link-dark rounded">All users</a></li>
			  </ul>
			</div>-->
		

			</li>

		  
		  
		  
		  <?php
			} else{
		  ?>
			
			<ul class="nav nav-pills flex-column mb-auto">
			  <li class="nav-item">
				<a href="tasks.php?site=Tasks&page=1" class="nav-link <?php 
					if(isset($_GET['site'])){
						if($_GET['site'] == "Tasks"){
							echo 'active';
						}
					}
				?>" aria-current="page">
				  <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
				  Tasks
				</a>
			  </li>
			  <li>
				<a href="technician_reports.php?site=Reports&page=1" class="nav-link <?php 
					if(isset($_GET['site'])){
						if($_GET['site'] == "Reports"){
							echo 'active';
						}
					}else{
						echo 'link-dark';
					}
				?>">
				  <svg class="bi me-2" width="16" height="16"><use xlink:href="#speedometer2"/></svg>
				  Reports
				</a>
			  </li>
			  <li>
				<a href="technician_reports.php?site=Issue%20Reports&page=1" class="nav-link <?php 
					if(isset($_GET['site'])){
						if($_GET['site'] == "Issue Reports"){
							echo 'active';
						}
					}else{
						echo 'link-dark';
					}
				?>">
				  <svg class="bi me-2" width="16" height="16"><use xlink:href="#speedometer2"/></svg>
				  Issues
				</a>
			  </li>
			</ul>
			
			
			
			<?php
			}
			?>
		  <li class="border-top my-3"></li>
		 
		
		
		  <div class="d-grid gap-2">
			<a class="btn btn-primary btn-large" href="backend/logout.p.php">
			  Sign out
			</a>
			
		  </div>
		</ul>
		</div>
	  </div>
	</div>
	
	
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
	<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	
	<script type="text/javascript">
	
		$('#myModal').on('shown.bs.modal', function () {
		  $('#myInput').trigger('focus')
		})
	</script>
  
  <script type="text/javascript">
	(function () {
	  'use strict'
	  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
	  tooltipTriggerList.forEach(function (tooltipTriggerEl) {
		new bootstrap.Tooltip(tooltipTriggerEl)
	  })
	})()
	
	document.addEventListener("DOMContentLoaded", () =>{
		const rows = document.querySelectorAll("tr[data-href]");
		
		rows.forEach(row => {
			row.addEventListener("click", ()=>{
				window.location.href = row.dataset.href;
			});
		});
	});
  </script>

<?php

	}else{
		header("Location: login.php");
		exit();
	}
?>