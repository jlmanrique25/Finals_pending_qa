<?php
	if(!isset($_SESSION['role'])){
		session_start();
	}
	include 'header.php';
?>

<head>
	<title>Assign Issue Report</title>

</head>

<div class="container-fluid py-4">
	<?php
		if(isset($_GET['update'])&& $_GET['update'] == "success"){
			include 'backend/dbh.p.php';
			
			$sql_update = "SELECT issue_id, issue.issue, users.users_id, users.username, issue.date_due FROM `issue`, `users` WHERE issue_id = ".$_GET['i']." AND users.users_id = ".$_GET['u_id']."";
			$stmt = mysqli_stmt_init($conn);
			
			$result_update = mysqli_query($conn, $sql_update);
			$row_update = mysqli_fetch_assoc($result_update)
			?>
			<div class="alert alert-success update_alert" role="alert" id="update_alert">
			  <h4 class="alert-heading">Issue assigned!</h4>
			  <p>You have assigned issue: <strong><?php echo $row_update['issue'];?></strong> to user <strong><?php echo $row_update['username'];?></strong> due on <strong><?php echo $row_update['date_due'];?></strong>.</p>
			  <hr>
			  <p class="mb-0">Made a mistake? <a href="backend/undo_issue.p.php?i=<?php echo $_GET['i'];?>" class="alert-link">UNDO</a>.</p>
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
	
	<table class="table rounded-3 shadow-lg table-hover mb-5">
	  <thead class="thead-dark">
		<tr>
		  <th scope="col">Issue</th>
		  <th scope="col">Equipment</th>
		  <th scope="col">Asset</th>
		  <th scope="col">Date Created</th>
		  <th scope="col">Action</th>
		</tr>
	  </thead>
	  <tbody>
	  
		<?php
			include 'backend/assign_unassigned_issues.p.php';
		?>
	  </tbody>
	</table>
	<?php
			include 'backend/unassigned_issues_pagination.p.php';
		?>
</div>
<script type ="text/javascript">
	$(document).ready(function(){
		setTimeout(function() {
			const alert = document.getElementById("update_alert");
			
			alert.style.display = 'none';
		}, 3000)
	});
</script>