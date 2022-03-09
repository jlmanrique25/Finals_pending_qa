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
			  <p>Finished issue: <strong><?php echo $row_update['issue'];?></strong> today!</p>
			  <hr>
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
				if($_SESSION['role'] == "Admin" || $_SESSION['role'] == "Head"){
					?>
					<a class="btn btn-warning dropdown-toggle btn-lg m-2" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Select type of issue reports
				  </a>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<a class="dropdown-item" href="tasks.php?site=Unresolved%20Issues&page=1&i_status=0">Unresolved issues</a>
						<a class="dropdown-item" href="tasks.php?site=Resolved%20Issues&page=1&i_status=1">Finished issue reports</a>
					  </div>
					<?php
				}
			?>
		  
	<table class="table rounded-3 shadow-lg table-hover mb-5">
		<thead class="thead-dark">
			<tr>
			<?php
				if($_SESSION['role'] == "Admin" || $_SESSION['role'] == "Head"){
					?>
						<th scope="col">Issues</th>
					<?php
				}else{
					?>
						<th scope="col">Tasks</th>
					<?php
				}
			?>
			<th scope="col">Equipment</th>
			<th scope="col">Floor</th>
			<th scope="col">Room</th>
			<th scope="col">Date Created</th>
			<th scope="col">Due Date</th>
			<th scope="col">Date Submitted</th>
			<th scope="col">Status</th>
			</tr>
		</thead>
		<tbody>
			<?php
				include 'backend/get_tasks_issues.p.php';
			?>
		</tbody>
	</table>
	<?php
		include 'backend/tasks_issues_pagination.p.php';
	?>
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