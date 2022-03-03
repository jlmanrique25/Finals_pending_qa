<head>
	<title>Reports</title>
	<script type="text/javascript" src="Scripts/bootstrap.min.js"></script>
	<script type="text/javascript" src="Scripts/jquery-2.1.1.min.js"></script>
</head>
<?php
	session_start();
	include 'header.php';
?>

<div class="container-fluid py-4 overflow-hidden">
	<div class="container-fluid">
		<div class="row">
			<div class="col p-2">
				<div class="btn-group">
				  <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Floor
				  </button>
				   <div class="dropdown-menu">
					
					<a  class="dropdown-item" 
					<?php
					if(!isset($_GET['floor'])){
						echo 'active';
					}else if($_GET['floor'] == '1st'){
						echo 'active';
					}
					?> href="reports.php?site=Reports&page=1&floor=1st">1st Floor</a>

					<a  class="dropdown-item" 
					<?php
					if(!isset($_GET['floor'])){
						echo 'active';
					}else if($_GET['floor'] == '2nd'){
						echo 'active';
					}
					?> href="reports.php?site=Reports&page=1&floor=2nd">2nd Floor</a>

					<a  class="dropdown-item" 
					<?php
					if(!isset($_GET['floor'])){
						echo 'active';
					}else if($_GET['floor'] == '3rd'){
						echo 'active';
					}
					?> href="reports.php?site=Reports&page=1&floor=3rd">3rd Floor</a>

					<a  class="dropdown-item" 
					<?php
					if(!isset($_GET['floor'])){
						echo 'active';
					}else if($_GET['floor'] == '4th'){
						echo 'active';
					}
					?> href="reports.php?site=Reports&page=1&floor=4th">4th Floor</a>
					
					<a  class="dropdown-item" 
					<?php
					if(!isset($_GET['floor'])){
						echo 'active';
					}else if($_GET['floor'] == '5th'){
						echo 'active';
					}
					?> href="reports.php?site=Reports&page=1&floor=5th">5th Floor</a>
					
					<a  class="dropdown-item" 
					<?php
					if(!isset($_GET['floor'])){
						echo 'active';
					}else if($_GET['floor'] == '6th'){
						echo 'active';
					}
					?> href="reports.php?site=Reports&page=1&floor=6th">6th Floor</a>
					
					<a  class="dropdown-item" 
					<?php
					if(!isset($_GET['floor'])){
						echo 'active';
					}else if($_GET['floor'] == '7th'){
						echo 'active';
					}
					?> href="reports.php?site=Reports&page=1&floor=7th">7th Floor</a>
					
					<a  class="dropdown-item" 
					<?php
					if(!isset($_GET['floor'])){
						echo 'active';
					}else if($_GET['floor'] == '8th'){
						echo 'active';
					}
					?> href="reports.php?site=Reports&page=1&floor=8th">8th Floor</a>
					
					<a  class="dropdown-item" 
					<?php
					if(!isset($_GET['floor'])){
						echo 'active';
					}else if($_GET['floor'] == '9th'){
						echo 'active';
					}
					?> href="reports.php?site=Reports&page=1&floor=9th">9th Floor</a>
					
					<a  class="dropdown-item" 
					<?php
					if(!isset($_GET['floor'])){
						echo 'active';
					}else if($_GET['floor'] == '10th'){
						echo 'active';
					}
					?> href="reports.php?site=Reports&page=1&floor=10th">10th Floor</a>
					
				  </div>
				</div>
			</div>
			<div class="col p-2">
				<div class="dropdown">
				  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Report Status
				  </button>
				  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					
					<a class="dropdown-item" 
					<?php
					if(!isset($_GET['status'])){
						echo 'active';
					}else if($_GET['status'] == 'done'){
						echo 'active';
					}
					?> href="reports.php?site=Reports&page=1&status=done">Done</a>
					
					<a class="dropdown-item" 
					<?php
					if(!isset($_GET['status'])){
						echo 'active';
					}else if($_GET['status'] == 'unresolved'){
						echo 'active';
					}
				?> href="reports.php?site=Reports&page=1&status=unresolved">Unresolved</a>

				  </div>
				</div>
			</div>
			<div class="col p-2">
				<div class="dropdown">
				  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Equipment
				  </button>
				  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					
					<a class="dropdown-item" 
					<?php
					if(!isset($_GET['machine'])){
						echo 'active';
					}else if($_GET['machine'] == 'HVAC'){
						echo 'active';
					}
					?> href="reports.php?site=Reports&page=1&equipment=HVAC">HVAC</a>
					
					<a class="dropdown-item" 
					<?php
					if(!isset($_GET['machine'])){
						echo 'active';
					}else if($_GET['machine'] == 'Genset'){
						echo 'active';
					}
				?> href="reports.php?site=Reports&page=1&status=equipment=Genset">Generator Set</a>

				  </div>
				</div>
			</div>
			<div class="col p-2">
				<form action="backend/date.p.php" method="post">
					<label>Start date</label>
					<input class="form-control mr-sm-2 w-100" type="date" placeholder="Search" aria-label="Search" name = 'start' value="<?php
						if(isset($_GET['s'])){
							$d = date('Y-m-d', strtotime($_GET['s']));
							echo $d;
						}
					?>">

			</div>
			<div class="col p-2">
					<label>End date</label>
					<input class="form-control mr-sm-2 w-100" type="date" placeholder="Search" aria-label="Search" name = 'end' value ="<?php
						if(isset($_GET['e'])){
							$d = date('Y-m-d', strtotime($_GET['e']));
							echo $d;
						}
					?>">
			</div>
			<div class="col p-2">

					<button class="btn btn-primary mb-2" type="submit" name="submit">Go</button>
				</form>
			</div>
			<div class="col p-2">
				<div class="btn-group btn-group" role="group">
			  <a type="button" class="btn btn-info 
				<?php
					if(!isset($_GET['time'])){
						echo 'active';
					}else if($_GET['time'] == 'day'){
						echo 'active';
					}
				?>
			  " href="reports.php?site=Reports&page=1&time=day">Daily</a>
			  <a type="button" class="btn btn-info <?php
					if(isset($_GET['time'])){
						if($_GET['time'] == 'week'){
							echo 'active';
						}
					}
				?>" href="reports.php?site=Reports&page=1&time=week">This Week</a>
			  <a type="button" class="btn btn-info <?php
					if(isset($_GET['time'])){
						if($_GET['time'] == 'month'){
							echo 'active';
						}
					}
				?>" href="reports.php?site=Reports&page=1&time=month">This Month</a>
				
				<a type="button" class="btn btn-info <?php
					if(isset($_GET['time'])){
						if($_GET['time'] == 'year'){
							echo 'active';
						}
					}
				?>" href="reports.php?site=Reports&page=1&time=year">This year</a>
				</div>
			</div>
			
			<div class="col p-2">
				<form class="form-inline" method="POST">
					<input class="form-control mr-sm-2 w-100" type="text" placeholder="Search" name="search">
					<input type="submit" name="submit">
				</form>
			</div>
			
			
			
			
			
		</div>
	</div>
	
	<table class="table rounded-3 shadow-lg table-hover mb-5">
	  <thead class="thead-dark">
		<tr>
		  <th scope="col"><a class="nav-link text-light" href="reports.php?site=Reports&time=<?php
			if(isset($_GET['time'])){
				echo $_GET['time'];
			}else{
				echo 'day';
			}
		  ?>&page=1&order=task&by=<?php
			if(isset($_GET['by'])){
				if($_GET['by'] == 'asc'){
					echo 'desc';
				}else{
					echo 'asc';
				}
			}else{
				echo 'asc';
			}
		  ?>">Task</a></th>
		  <th scope="col"><a class="nav-link text-light" href="reports.php?site=Reports&time=<?php
			if(isset($_GET['time'])){
				echo $_GET['time'];
			}else{
				echo 'day';
			}
		  ?>&page=1&order=equipment_name&by=<?php
			if(isset($_GET['by'])){
				if($_GET['by'] == 'asc'){
					echo 'desc';
				}else{
					echo 'asc';
				}
			}else{
				echo 'asc';
			}
		  ?>">Equipment</a></th>
		  <th scope="col"><a class="nav-link text-light" href="reports.php?site=Reports&time=<?php
			if(isset($_GET['time'])){
				echo $_GET['time'];
			}else{
				echo 'day';
			}
		  ?>&page=1&order=floor&by=<?php
			if(isset($_GET['by'])){
				if($_GET['by'] == 'asc'){
					echo 'desc';
				}else{
					echo 'asc';
				}
			}else{
				echo 'asc';
			}
		  ?>">Floor</a></th>
		  <th scope="col"><a class="nav-link text-light" href="reports.php?site=Reports&time=<?php
			if(isset($_GET['time'])){
				echo $_GET['time'];
			}else{
				echo 'day';
			}
		  ?>&page=1&order=room_number&by=<?php
			if(isset($_GET['by'])){
				if($_GET['by'] == 'asc'){
					echo 'desc';
				}else{
					echo 'asc';
				}
			}else{
				echo 'asc';
			}
		  ?>">Room Number</a></th>
		  <th scope="col"><a class="nav-link text-light" href="reports.php?site=Reports&time=<?php
			if(isset($_GET['time'])){
				echo $_GET['time'];
			}else{
				echo 'day';
			}
		  ?>&page=1&order=report_status&by=<?php
			if(isset($_GET['by'])){
				if($_GET['by'] == 'asc'){
					echo 'desc';
				}else{
					echo 'asc';
				}
			}else{
				echo 'asc';
			}
		  ?>">Report Status</a></th>
		 <th scope="col"><a class="nav-link text-light" href="reports.php?site=Reports&time=<?php
			if(isset($_GET['time'])){
				echo $_GET['time'];
			}else{
				echo 'day';
			}
		  ?>&page=1&order=report_status&by=<?php
			if(isset($_GET['by'])){
				if($_GET['by'] == 'asc'){
					echo 'desc';
				}else{
					echo 'asc';
				}
			}else{
				echo 'asc';
			}
		  ?>">Date Created</a></th>
		  <th scope="col"><a class="nav-link text-light" href="reports.php?site=Reports&time=<?php
			if(isset($_GET['time'])){
				echo $_GET['time'];
			}else{
				echo 'day';
			}
		  ?>&page=1&order=date_submitted&by=<?php
			if(isset($_GET['by'])){
				if($_GET['by'] == 'asc'){
					echo 'desc';
				}else{
					echo 'asc';
				}
			}else{
				echo 'asc';
			}
		  ?>">Date Submitted</a></th>
		  <th scope="col"><a class="nav-link text-light" href="reports.php?site=Reports&time=<?php
			if(isset($_GET['time'])){
				echo $_GET['time'];
			}else{
				echo 'day';
			}
		  ?>&page=1&order=for_repair&by=<?php
			if(isset($_GET['by'])){
				if($_GET['by'] == 'asc'){
					echo 'desc';
				}else{
					echo 'asc';
				}
			}else{
				echo 'asc';
			}
		  ?>">For Repair</a></th>
		  <th scope="col"><a class="nav-link text-light" href="reports.php?site=Reports&time=<?php
			if(isset($_GET['time'])){
				echo $_GET['time'];
			}else{
				echo 'day';
			}
		  ?>&page=1&order=username&by=<?php
			if(isset($_GET['by'])){
				if($_GET['by'] == 'asc'){
					echo 'desc';
				}else{
					echo 'asc';
				}
			}else{
				echo 'asc';
			}
		  ?>">Assigned To</a></th>
		</tr>
	  </thead>
	  <tbody>


		<?php
			include 'backend/dropdown_filter_status.p.php'; 
		?>
	
		<?php
			include 'backend/search.php'; 
		?>
		<?php 
			include 'backend/get_reports.p.php'
		?>

		
	  </tbody>
	</table>
	<?php
		include 'backend/table_pagination_reports.p.php';
	?>
</div>

