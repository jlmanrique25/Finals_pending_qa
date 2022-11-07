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
	<!--<script src="https://kit.fontawesome.com/a076d05399.js"></script>-->
	<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"></script>-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/sidebars/">
	<link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>
	<link rel="icon" href="images/keoms_logo.png" />
	<link href="style.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="tablefilter/style/tablefilter.css" />
	<script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>
	<script type="text/javascript" src="js/tableExport.min.js"></script>
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

		  <?php
        if($_SESSION['role'] == "Head" || $_SESSION['role'] == "Admin"){
         
          ?>
		  <div class="d-none d-sm-block">

		  
		<nav id="navbar-example2" class="navbar navbar-dark flex-row .d-none .d-md-block .d-lg-none" style="background-color: rgba(34, 18, 119, 1);">
		  <ul class="nav nav-pills">
		  	<li class="nav-item"></li>
		  	 <li class="nav-item dropdown">
		  	 	<a class="navbar-brand" style="color: white;"><?php echo $_SESSION['username'];?></a>
		      <a class="navbar-brand dropdown-toggle" data-toggle="dropdown" href="#" id="dropdownMenuLinkuser" role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user" aria-hidden="true"></i><span class="badge badge-pill badge-danger"><?php 
					
					if($_SESSION['role'] != 'technician'){
                        include 'backend/count_task_assigned_admin.p.php';
                    }else{
                        include 'backend/count_task_assigned_technician.p.php';
                    }
																																																																   
					
                                                                                                                                                                                                                                         ?></span></a>
		      <div class="dropdown-menu" aria-labelledby="dropdownMenuLinkuser">
		        <a href="<?php 
					if($_SESSION['role'] == 'Head'){
                        echo 'head_tasks_table.php?site=Unresolved%20Issues&page=1';
                    }else{
                        echo 'admin_issues_table.php?site=Unresolved%20Issues&table=unresolved';
                    }
				   ?>
				   " class="dropdown-item">My Tasks <span class="badge badge-danger"><?php 
					
					include 'backend/count_task_assigned_admin.p.php';
					
				?></span></a>
				<?php if($_SESSION['role'] == "Head"){?>
				<a href="assign_issue_reports.php?site=Unassigned%20Reports&page=1" class="dropdown-item">Assign Issue Report</a>
				<?php	}
                ?>
				<?php if($_SESSION['role'] == "Head"){?>
				<a href="users.php?site=Users&page=1" class="dropdown-item">Manage Users</a>
				<?php	}
                ?>
		        <div role="separator" class="dropdown-divider"></div>
		        <a class="dropdown-item" href="backend/logout.p.php">Sign out</a>
		      </div>
		    </li>
		  </ul>

		<ul class="nav nav-pills text-center flex-row" >
			<li class="nav-item mr-3 d-none d-lg-block">
				<a class="navbar-brand" href="assign_new_task.php?site=Assign%20new%20task" title="New Task Report"><i class="fa fa-tasks" aria-hidden="true"></i></a>
			</li>
			<li class="nav-item mr-3 d-none d-lg-block">
				<a class="navbar-brand" href="assign_issue.php?site=Create%20Issue%20Report" title="New Issue Report"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>
			</li>
			<li class="nav-item  d-none d-lg-block">
				<a class="navbar-brand" href="add_new_equipment.php?site=Add%20New%20Equipment"><i class="fa fa-plus" aria-hidden="true" title="Add New Equipment"></i></a>
			</li>
		</ul>
		</nav>
			  </div>
		
		<?php
        }
			 ?>

		<?php
        if($_SESSION['role'] == "Technician"){
         
          ?>

		  <div class="d-none d-sm-block">

		  
		<nav id="navbar-example2" class="navbar navbar-dark flex-row .d-none .d-md-block .d-lg-none" style="background-color: rgba(34, 18, 119, 1);">
		  <ul class="nav nav-pills">
		  	<li class="nav-item"></li>
		  	 <li class="nav-item dropdown">
		  	 	<a class="navbar-brand" style="color: white;"><?php echo $_SESSION['username'];?></a>
		      <a class="navbar-brand dropdown-toggle" data-toggle="dropdown" href="#" id="dropdownMenuLinkuser" role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user" aria-hidden="true"></i><span class="badge badge-pill badge-danger"><?php 
					
					include 'backend/count_task_assigned_technician.p.php';
					
                                                                                                                                                                                                                                         ?></span></a>
		      <div class="dropdown-menu" aria-labelledby="dropdownMenuLinkuser">
		        <a href="<?php 
					if($_SESSION['role'] == 'Technician'){
                        echo 'index.php?role=Technician&site=Tasks&page=1';
                    }
				   ?>
				   " class="dropdown-item">My Tasks <span class="badge badge-danger"><?php 
					
					include 'backend/count_task_assigned_technician.p.php';
					
				?></span></a>
				<?php if($_SESSION['role'] == "Head"){?>
				<a href="assign_issue_reports.php?site=Unassigned%20Reports&page=1" class="dropdown-item">Assign Issue Report</a>
				<?php	}
                ?>
				<?php if($_SESSION['role'] == "Head"){?>
				<a href="users.php?site=Users&page=1" class="dropdown-item">Manage Users</a>
				<?php	}
                ?>
		        <div role="separator" class="dropdown-divider"></div>
		        <a class="dropdown-item" href="backend/logout.p.php">Sign out</a>
		      </div>
		    </li>
		  </ul>
		</nav>
			  </div>
		



        <?php
        }
			 ?>
		

	  </div>
	  	
	</nav>

		
	

	<!-- SIDEBAR THAT SHOWS IF USER IS ON MOBILE
		<div class="d-lg-none">
		-->
	
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
			<a class="btn btn align-items-center rounded" href="dashboard.php?site=Dashboard&page=1">
			  Dashboard
			</a>
		  </li>
		  <li class="mb-1">
			<a class="btn btn align-items-center rounded" href="reports.php?site=Reports&page=1&time=day">
			  Reports
			</a>

		  </li>
		  
		  <li class="mb-1">
		  <a class="btn align-items-center rounded" href="issues.php?site=Issues&page=1&time=month">
			  Issues
			</a>

		  </li>
		  
		  <li class="mb-1">
			<a class="btn align-items-center rounded" href="equipment.php?site=Equipment&page=1">
			  Equipment Inventory
			</a>

		  </li>
		  <div class="d-sm-none">
			  <li class="mb-1">
			<button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="false">
			  Management
			</button>
			<div class="collapse" id="orders-collapse">
			  <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
				<li><a href="tasks.php?site=Unresolved%20Issues&page=1" class="link-dark rounded">Tasks <span class="badge badge-danger"><?php 
                
                include 'backend/count_task_assigned_admin.p.php';
                
                                                                                                                                         ?></span></a></li>
				<li><a href="assign_new_task.php?site=Assign%20new%20task" class="link-dark rounded d-lg-none">Assign New Task</a></li>
				<?php if($_SESSION['role'] == "Head"){?>
				<li><a href="assign_issue_reports.php?site=Unassigned%20Reports&page=1" class="link-dark rounded">Assign Issue Report</a></li>
				<?php	}
                ?>
				<li><a href="add_new_equipment.php?site=Add%20New%20Equipment" class="link-dark rounded d-lg-none">Add New Equipment</a></li>
				<li><a href="assign_issue.php?site=Create%20Issue%20Report" class="link-dark rounded d-lg-none">Create Issue Report</a></li>
				<?php if($_SESSION['role'] == "Head"){?>
				<li><a href="users.php?site=Users&page=1" class="link-dark rounded">Manage Users</a></li>
				<?php	}
                ?>
			  </ul>
			</div>
		  </li> 
		  </div>

			</li>

		  
		  
		  
		  <?php
			} else{
		  ?>
			
			<ul class="nav nav-pills flex-column mb-auto">
			  <li class="nav-item">
				<a href="tasks.php?site=My%20Tasks&page=1" class="nav-link <?php 
					if(isset($_GET['site'])){
						if($_GET['site'] == "My Tasks"){
							echo 'active';
						}
					}
				?>" aria-current="page">
				  <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"/></svg>
				  Tasks
				</a>
			  </li>
			  <li>
				<a href="technician_reports.php?site=My%20Reports&page=1" class="nav-link <?php 
					if(isset($_GET['site'])){
						if($_GET['site'] == "My Reports"){
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
				<a href="technician_reports.php?site=My%20Issues%20Reported&page=1" class="nav-link <?php 
					if(isset($_GET['site'])){
						if($_GET['site'] == "My Issues Reported"){
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
	</div>

	<!-- END OF DESIGN OF THE HEADER AND SIDEBAR -->
	
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