<head>
	<title>Past Reports</title>

</head>
<?php
	if(!isset($_SESSION['role'])){
		session_start();
	}
	include 'header.php';
?>
<!--
<div class="container-fluid py-4 overflow-hidden">
	<?php
		if(isset($_GET['del']) && $_GET['del'] == 'true'){
			?>
			<div class="alert alert-success" role="alert" id="update_alert">
			  <strong> issue deleted</strong >

			 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>

			</div>
			<?php
		}
	?>
	-->
	<?php
	if($_GET['site'] == "My Reports"){
		?>
		<a href="assign_issue.php?site=Report%20Equipment%20Issue" type="button" class="btn btn-danger btn-lg my-2">Report an equipment issue</a>
		<table class="table rounded-3 shadow-lg table-hover mb-5">
			<thead class="thead-dark">
				<tr role="button" data-href="viewPastReports.php?r=<?php echo $row['report_id'];?>&e=<?php echo $row['machine_id'];?>&site=My%20Past%20Reports">
				<th scope="col">Tasks</th>
				<th scope="col">Equipment</th>
				<th scope="col">Floor</th>
				<th scope="col">Room</th>
				<th scope="col">Date created</th>
				<th scope="col">Due date</th>
				<th scope="col">Date submitted</th>
				<th scope="col">Status</th>
				</tr>
			</thead>
			<tbody>
				<?php
					include 'backend/get_reports_issues.p.php';
				?>
			</tbody>
		</table>
		<?php
			include 'backend/reports_issues_pagination.p.php';
		?>
		<?php
	}else if($_GET['site'] == "My Issues Reported"){
		?>
		<a href="assign_issue.php?site=Report%20Equipment%20Issue" type="button" class="btn btn-danger btn-lg my-2">Report an equipment issue</a>
		<table class="table rounded-3 shadow-lg table-hover mb-5">
			<thead class="thead-dark">
				<tr>
				<th scope="col">Issues</th>
				<th scope="col">Equipment</th>
				<th scope="col">Floor</th>
				<th scope="col">Room</th>
				<th scope="col">Date created</th>
				<th scope="col">Status</th>
				<th scope="col">Assigned to</th>
				</tr>
			</thead>
			<tbody>
				<?php
					include 'backend/get_reports_issues.p.php';
				?>
			</tbody>
		</table>
		<?php
			include 'backend/reports_issues_pagination.p.php';
		?>
		<?php
	}
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