<?php
	if(!isset($_SESSION['role'])){
		session_start();
	}
	include 'header.php';
	
	include 'backend/dbh.p.php';
	
	$sql = "SELECT issue.issue_id, issue.machine_id, issue.issue, issue.issue description, issue.submitted_by, issue.date_due, issue.date_created, equipment.equipment_id, equipment.equipment_name, users.users_id, users.username, issue.issue_status, issue.recommendation, issue.endorsed_by, issue.date_endorsed_for_repair, issue.date_reinstalled, issue.contracted_company, issue.company_representative, issue.company_representative, issue.service_report_number, issue.date_issue_resolved, assigned_to
	FROM `issue`,`users`,`equipment`
	WHERE issue_id = ".$_GET['i_id']." AND issue.machine_id = equipment.equipment_id AND users.users_id = issue.submitted_by";
	
	$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo 'error connecting to the database first line';
	}else{
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_assoc($result);
		
	}
	
	if($_GET['site'] == "Issue Report"){
?>
<head>
	<style>
		#main_content {
			padding: 7%;
		}
	</style>
</head>
<div class="container-fluid py-4" id="main_content">
	<h2><?php echo $row['issue'], " : equipment ", $row['equipment_name'];?><h2>
	<hr class="rounded">
	<h5>Date issue created: <?php echo $row['date_created']?></h5>
	<?php 
	if(!is_null($row['description'])){
		echo '<h5>',$row['description'],'</h5>';
	}
	?>
	<h5 class="mb-5">Submitted by: <?php echo $row['username'];?></h5>

	<div class="form-group">
	<?php
	
	if($_SESSION['userId'] != $row['assigned_to']){
		?>
		<form method="post" <?php
		if($row['issue_status']){
			?>
			action="backend/redo_issue.p.php?id=<?php echo $row['issue_id']?>">
			<?php
		}else{
			?>
			action="backend/finish_issue.p.php?id=<?php echo $row['issue_id']?>">
			<?php
		}
		?>

		<div class="row mb-4">
			<div class="col">
				<label>Recommendation</label>
				<textarea  class="form-control" name="recommendation" placeholder="Recommendation" required readonly <?php if($row['issue_status']){echo 'readonly';}
				?>><?php if($row['issue_status']){echo $row['recommendation'];}if(!$row['issue_status'] && !is_null($row['endorsed_by'])){echo $row['recommendation'];}?></textarea>
			</div>
			
		</div>
		<div class="row mb-4">
			<div class="col">
				<label>Endorsed by</label>
				<input type="text" class="form-control" name="endorser" required placeholder="Endorsed by" readonly <?php 
				if($row['issue_status'] && !is_null($row['endorsed_by'])){
					echo 'readonly value ="'.$row['endorsed_by'].'"';
				}else if(!$row['issue_status'] && !is_null($row['endorsed_by'])){
					echo ' value ="'.$row['endorsed_by'].'"';
				}
				?>>
				
			</div>
			<div class="col">
				<label>Date Endorsed for repair</label>
				<input type="datetime-local" class="form-control" name="date_repair" required placeholder="Endorsed by"readonly <?php 
				$date_endorsed = date('Y-m-d\TH:i', strtotime($row['date_endorsed_for_repair']));
				if($row['issue_status'] && !is_null($row['date_endorsed_for_repair'])){
					echo 'readonly value ="'.$date_endorsed.'"';
				}else if(!$row['issue_status'] && !is_null($row['date_endorsed_for_repair'])){
					echo 'value ="'.$date_endorsed.'"';
				}else if($row['issue_status'] && is_null($row['contracted_company'])){
					echo 'readonly value="None"';
				}
				?>>
			</div>
		</div>
		<div class="row mb-4">
			<div class="col">
				<label>Contracted company</label>
				<input type="text" class="form-control" name="contact_company" placeholder="Company name" readonly 
				<?php 
				if($row['issue_status'] && !is_null($row['contracted_company'])){
					echo 'readonly value ="'.$row['contracted_company'].'"';
				}else if(!$row['issue_status'] && !is_null($row['contracted_company'])){
					echo ' value="'.$row['contracted_company'].'"';
				}else if($row['issue_status'] && is_null($row['contracted_company'])){
					echo 'readonly value="None"';
				}else if(!$row['issue_status'] && is_null($row['contracted_company'])){
					
				}
				?>>
				
			</div>
			<div class="col">
				<label>Company representative</label>
				<input type="text" class="form-control" name="company" placeholder="Company name" readonly <?php 
				if($row['issue_status'] && !is_null($row['company_representative'])){
					echo 'readonly value ="'.$row['company_representative'].'"';
				}else if(!$row['issue_status'] && !is_null($row['company_representative'])){
					echo ' value="'.$row['company_representative'].'"';
				}else if($row['issue_status'] && is_null($row['company_representative'])){
					echo 'readonly value="None"';
				}else if(!$row['issue_status'] && is_null($row['company_representative'])){
					
				}
				?>>
			</div>
		</div>
		<div class="row mb-5">
			<div class="col">
				<label>Date reinstalled</label>
				<input type="date" class="form-control" name="date_reinstalled" placeholder="Date reisntalled" readonly <?php 
				if($row['issue_status'] && !is_null($row['date_reinstalled'])){
					echo 'readonly value ="'.date('Y-m-d', strtotime($row['date_reinstalled'])).'"';
				}else if(!$row['issue_status'] && !is_null($row['date_reinstalled'])){
					echo ' value="'.date('Y-m-d', strtotime($row['date_reinstalled'])).'"';
				}else if($row['issue_status'] && is_null($row['date_reinstalled'])){
					echo 'readonly value="None"';
				}else if(!$row['issue_status'] && is_null($row['date_reinstalled'])){
					
				}
				?>>
				
			</div>
			<div class="col">
				<label>Service report number</label>
				<input type="text" class="form-control" name="receipt" placeholder="Service report number" readonly<?php 
				if($row['issue_status'] && !is_null($row['service_report_number'])){
					echo 'readonly value ="'.$row['service_report_number'].'"';
				}else if(!$row['issue_status'] && !is_null($row['service_report_number'])){
					echo ' value="'.$row['service_report_number'].'"';
				}else if($row['issue_status'] && is_null($row['service_report_number'])){
					echo 'readonly value="None"';
				}else if(!$row['issue_status'] && is_null($row['service_report_number'])){
					
				}
				?>>
			</div>
		</div>
		<h5>

		
		
		
		</form>
		<?php
	}else if($_SESSION['userId'] == $row['assigned_to']){
	?>
	
	<form method="post" <?php
		if($row['issue_status']){
			?>
			action="backend/redo_issue.p.php?id=<?php echo $row['issue_id']?>">
			<?php
		}else{
			?>
			action="backend/finish_issue.p.php?id=<?php echo $row['issue_id']?>">
			<?php
		}
		?>
	<?php
		if(isset($_GET['redo'])&& $_GET['redo'] == "success"){?>
			<div class="alert alert-success update_alert" role="alert" id="update_alert">
			  <h4 class="alert-heading">Re-opened Issue!</h4>
			  <p>You have Re-opened issue: <strong><?php echo $row['issue'];?></strong> to work on updates.</p>
			  <hr>
			  <p class="mb-0">Made a mistake? <a href="backend/undo_issue_submit.p.php?i=<?php echo $_GET['i_id'];?>" class="alert-link">UNDO</a>.</p>
			</div>
			<?php
		}else if(isset($_GET['update'])&& $_GET['update'] == "undo"){
			?>
				<div class="alert alert-warning" role="alert" id="update_alert">
				  Closed issue
				</div>
			<?php
		}
	?>

		<div class="row mb-4">
			<div class="col">
				<label>Recommendation</label>
				<textarea  class="form-control" name="recommendation" placeholder="Recommendation" required <?php if($row['issue_status']){echo 'readonly';}
				?>><?php if($row['issue_status']){echo $row['recommendation'];}if(!$row['issue_status'] && !is_null($row['endorsed_by'])){echo $row['recommendation'];}?></textarea>
			</div>
			
		</div>
		<div class="row mb-4">
			<div class="col">
				<label>Endorsed by</label>
				<input type="text" class="form-control" name="endorser" required placeholder="Endorsed by" <?php 
				if($row['issue_status'] && !is_null($row['endorsed_by'])){
					echo 'readonly value ="'.$row['endorsed_by'].'"';
				}else if(!$row['issue_status'] && !is_null($row['endorsed_by'])){
					echo ' value ="'.$row['endorsed_by'].'"';
				}
				?>>
				
			</div>
			<div class="col">
				<label>Date Endorsed for repair</label>
				<input type="datetime-local" class="form-control" name="date_repair" required placeholder="Endorsed by" <?php 
				$date_endorsed = date('Y-m-d\TH:i', strtotime($row['date_endorsed_for_repair']));
				if($row['issue_status'] && !is_null($row['date_endorsed_for_repair'])){
					echo 'readonly value ="'.$date_endorsed.'"';
				}else if(!$row['issue_status'] && !is_null($row['date_endorsed_for_repair'])){
					echo 'value ="'.$date_endorsed.'"';
				}else if($row['issue_status'] && is_null($row['contracted_company'])){
					echo 'readonly value="None"';
				}
				?>>
			</div>
		</div>
		<div class="row mb-4">
			<div class="col">
				<label>Contracted company</label>
				<input type="text" class="form-control" name="contact_company" placeholder="Company name" 
				<?php 
				if($row['issue_status'] && !is_null($row['contracted_company'])){
					echo 'readonly value ="'.$row['contracted_company'].'"';
				}else if(!$row['issue_status'] && !is_null($row['contracted_company'])){
					echo ' value="'.$row['contracted_company'].'"';
				}else if($row['issue_status'] && is_null($row['contracted_company'])){
					echo 'readonly value="None"';
				}else if(!$row['issue_status'] && is_null($row['contracted_company'])){
					
				}
				?>>
				
			</div>
			<div class="col">
				<label>Company representative</label>
				<input type="text" class="form-control" name="company" placeholder="Company name" <?php 
				if($row['issue_status'] && !is_null($row['company_representative'])){
					echo 'readonly value ="'.$row['company_representative'].'"';
				}else if(!$row['issue_status'] && !is_null($row['company_representative'])){
					echo ' value="'.$row['company_representative'].'"';
				}else if($row['issue_status'] && is_null($row['company_representative'])){
					echo 'readonly value="None"';
				}else if(!$row['issue_status'] && is_null($row['company_representative'])){
					
				}
				?>>
			</div>
		</div>
		<div class="row mb-5">
			<div class="col">
				<label>Date reinstalled</label>
				<input type="date" class="form-control" name="date_reinstalled" placeholder="Date reisntalled" <?php 
				if($row['issue_status'] && !is_null($row['date_reinstalled'])){
					echo 'readonly value ="'.date('Y-m-d', strtotime($row['date_reinstalled'])).'"';
				}else if(!$row['issue_status'] && !is_null($row['date_reinstalled'])){
					echo ' value="'.date('Y-m-d', strtotime($row['date_reinstalled'])).'"';
				}else if($row['issue_status'] && is_null($row['date_reinstalled'])){
					echo 'readonly value="None"';
				}else if(!$row['issue_status'] && is_null($row['date_reinstalled'])){
					
				}
				?>>
				
			</div>
			<div class="col">
				<label>Service report number</label>
				<input type="text" class="form-control" name="receipt" placeholder="Service report number" <?php 
				if($row['issue_status'] && !is_null($row['service_report_number'])){
					echo 'readonly value ="'.$row['service_report_number'].'"';
				}else if(!$row['issue_status'] && !is_null($row['service_report_number'])){
					echo ' value="'.$row['service_report_number'].'"';
				}else if($row['issue_status'] && is_null($row['service_report_number'])){
					echo 'readonly value="None"';
				}else if(!$row['issue_status'] && is_null($row['service_report_number'])){
					
				}
				?>>
			</div>
		</div>
		<h5>
		
		<?php
		if($row['issue_status']){
			echo 'Date Submitted: ', $row['date_issue_resolved'], '</h5>';
			?>
			
			<button class="btn btn-success mb-2 btn-lg" type="submit" name="submit"><i class="fas fa-clipboard-check"></i> Re-Open Issue</button>
			<?php
		}else{
			echo 'Submit before: ',$row['date_due'], '</h5>';
			?>
			
			<button class="btn btn-success mb-2 btn-lg" type="submit" name="submit"><i class="fas fa-clipboard-check"></i> Submit</button>
			<?php
		}
		?>
		
		
		
		</form><?php
		}
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

	<?php } ?>