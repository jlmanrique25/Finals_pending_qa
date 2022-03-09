<?php
include 'dbh.p.php';

if(isset($_GET['page'])){
	$min = 5 * ($_GET['page'] - 1);
	
	
	$sql_dates = "SELECT * FROM `dates`WHERE date_time > now() - INTERVAL 7 day AND (date_type = 'created' OR date_type = 'submitted') ORDER BY date_time DESC LIMIT ".$min.", 5";
}else{
	$sql_dates = "SELECT * FROM `dates`WHERE date_time > now() - INTERVAL 7 day AND (date_type = 'created' OR date_type = 'submitted') ORDER BY date_time DESC LIMIT 0, 5";
}


$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $sql_dates)){
	echo 'error connecting to database dates';
}else{
	$result_dates = mysqli_query($conn, $sql_dates);
	
	if($result_dates->num_rows > 0){
		while($row_dates = mysqli_fetch_array($result_dates)){
			$count = 0;
			if($row_dates['date_identity'] == 'report'){
				if($row_dates['date_type'] == 'created'){
					/**
						SELECTING ALL THE CREATED VALUES
					**/
					$sql_report = "SELECT report_id, assigned_by, assigned_user, task_due, task FROM `reports` WHERE report_id = ".$row_dates['report_issue_id']."";
					
					if(!mysqli_stmt_prepare($stmt, $sql_report)){
						echo 'error connecting to database reports';
					}else{
						
						$result_reports = mysqli_query($conn, $sql_report);
						$row_reports = mysqli_fetch_array($result_reports);
						
						/**
						$sql_users = "SELECT * FROM `users` WHERE (users_id = ".$row_reports['assigned_by']." OR users_id = ".$row_reports['assigned_user'].") ORDER by role ASC";
						**/
						
						$sql_users = "SELECT * FROM `users` WHERE users_id = ".$row_reports['assigned_user']." ORDER by role ASC";
						
						$sql_users2 = "SELECT * FROM `users` WHERE users_id = ".$row_reports['assigned_by']."  ORDER by role ASC";
						
						if(!mysqli_stmt_prepare($stmt, $sql_users)){
							echo 'error connecting to the database users';
						}else{
							$result_users = mysqli_query($conn, $sql_users);
							$result_users2 = mysqli_query($conn, $sql_users2);
							$row_users = mysqli_fetch_array($result_users);
							$row_users2 = mysqli_fetch_array($result_users2);
							
							$user_assignor =  $row_users2['username'];
							$assignor_role = $row_users2['role'];
							$user_assignee = $row_users['username'];
							
							?>
							<!--
								ASSIGNING TASKS
							-->
							<head>
								<style>
									a, a:hover {
										text-decoration: none;
									}
								</style>
							</head>
							<a class="d-flex text-muted pt-3" style="white-space: normal;" href="#">
							  <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#ffdd00"/><text x="50%" y="50%" fill="#007bff" dy=".3em"></text></svg>

							  <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
								<div class="d-flex justify-content-between">
								  <strong class="text-gray-dark"><?php echo $assignor_role; ?>: <?php echo $user_assignor;?></strong>
								  <p class="mb-2"><?php echo $row_dates['date_time']?></p>
								</div>
								<span class="d-block">Assigned task: "<?php echo $row_reports['task'];?>" to employee: "<?php echo $user_assignee;?>", due on "<?php echo $row_reports['task_due'];?>"</span>
							  </div>
							</a>
						
						<?php
							
						}
						
					}
					
					
				}else if($row_dates['date_type'] == 'submitted'){
					$sql_report = "SELECT report_id, assigned_by, assigned_user, date_submitted, task, abnormal_data, machine_id, for_repair FROM `reports` WHERE report_id = ".$row_dates['report_issue_id']."";
					
					if(!mysqli_stmt_prepare($stmt,$sql_report)){
						echo 'error connecting to the reports database';
					}else{
						$result_reports = mysqli_query($conn, $sql_report);
						$row_reports = mysqli_fetch_array($result_reports);
						
						$sql_users = "SELECT * FROM `users` WHERE users_id = ".$row_reports['assigned_user']."";
						
						if(!mysqli_stmt_prepare($stmt, $sql_users)){
							echo 'error connecting to the database users';
						}else{
							$result_users = mysqli_query($conn, $sql_users);
							$row_users = mysqli_fetch_array($result_users);
							
							if(!$row_reports['for_repair'] && !$row_reports['abnormal_data']){
								
							
							/******
							
							NORMAL REPORT SUBMITION
							
							******/	
							
							?>
							<head>
								<style>
									a, a:hover {
										text-decoration: none;
									}
								</style>
							</head>
								<a class="d-flex text-muted pt-3" style="white-space: normal;" href="#">
									<svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#007bff"/><text x="50%" y="50%" fill="#007bff" dy=".3em"></text></svg>

									<div class="pb-3 mb-0 small lh-sm border-bottom w-100">
									<div class="d-flex justify-content-between">
									<strong class="text-gray-dark">Employee: <?php echo $row_users['username'];?></strong>
									<p class="mb-2"><?php echo $row_reports['date_submitted']?></p>
									</div>
									<span class="d-block">Submitted report for task: "<?php echo $row_reports['task']?>" of machine: "<?php echo $row_reports['machine_id'],' this is the machine id';?>" at Room: "<?php echo 'this is the machine room supposedly';?>".</span>
									</div>
								</a>
							<?php	
							}else if($row_reports['for_repair'] && $row_reports['abnormal_data']){
							/******
							
							FOR REPORTS REPORTED WITH FOR REPAIR/ISSUES AND HAS DATA ABNORMALITIES
							
							******/
							?>

							<head>
								<style>
									a, a:hover {
										text-decoration: none;
									}
								</style>
							</head>
							
							<a class="d-flex text-muted pt-3" style="white-space: normal;" href="#">
							  <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#e70e02"/><text x="50%" y="50%" fill="#007bff" dy=".3em"></text></svg>

							  <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
								<div class="d-flex justify-content-between">
								  <strong class="text-gray-dark">Employee: <?php echo $row_users['username'];?></strong>
								  <p class="mb-2"><?php echo $row_reports['date_submitted']?></p>
								</div>
								<span class="d-block">Submitted report for task: "<?php echo $row_reports['task']?>" of machine: "Aircon" at Room: "602". Equipment for repair and detected abnormal data</span>
							  </div>
							</a>
							
							<?php	
							}else if($row_reports['for_repair']){ 
							/******
							
							FOR REPORTS REPORTED WITH FOR REPAIR/ISSUES
							
							******/
							?>

							<head>
								<style>
									a, a:hover {
										text-decoration: none;
									}
								</style>
							</head>
							<a class="d-flex text-muted pt-3" style="white-space: normal;" href="#">
							  <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#e70e02"/><text x="50%" y="50%" fill="#007bff" dy=".3em"></text></svg>

							  <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
								<div class="d-flex justify-content-between">
								  <strong class="text-gray-dark">Employee: <?php echo $row_users['username'];?></strong>
								  <p class="mb-2"><?php echo $row_reports['date_submitted']?></p>
								</div>
								<span class="d-block">Submitted report for task: "<?php echo $row_reports['task']?>" of machine: "Aircon" at Room: "602". Equipment for repair</span>
							  </div>
							</a>
							
							<?php
							}else if($row_reports['abnormal_data']){
							/******
							
							FOR REPORTS WITH DETECTED DATA ABNORMALITIES BY KEOMS
							
							******/
							
							?>

							<head>
								<style>
									a, a:hover {
										text-decoration: none;
									}
								</style>
							</head>
							<a class="d-flex text-muted pt-3" style="white-space: normal;" href="#">
							  <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#e70e02"/><text x="50%" y="50%" fill="#007bff" dy=".3em"></text></svg>

							  <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
								<div class="d-flex justify-content-between">
								  <strong class="text-gray-dark">KEOMS</strong>
								  <p class="mb-2"><?php echo $row_reports['date_submitted']?></p>
								</div>
								<span class="d-block">Detected abnormal reading at task: "<?php echo $row_reports['tasks']?>" on field/s: "temperature", machine: "Aircon" at room: "606"</span>
							  </div>
							</a>						
						
						<?php
							}
						}
				}
				}
			}else if($row_dates['date_identity'] == 'issue'){
				if($row_dates['date_type'] == 'created'){
					$sql_issues = "SELECT issue_id, submitted_by, users_id, username, issue, assigned_to, date_due, date_created   FROM `issue`, `users` WHERE issue_id = ".$row_dates['report_issue_id']." AND submitted_by = users_id ORDER by date_created";
					
					if(!mysqli_stmt_prepare($stmt, $sql_issues)){
						echo 'error connecting to database issues';
					}else{
						$result_issue = mysqli_query($conn, $sql_issues);
						$row_issue = mysqli_fetch_array($result_issue);
						
						
						if(isset($row_issue['assigned_to'])){
							$sql_user = "SELECT * FROM `users` WHERE users_id = ".$row_issue['assigned_to']."";
							
							if(!mysqli_stmt_prepare($stmt, $sql_user)){
								echo 'error connecting to user database';
							}else{
								$result_user = mysqli_query($conn, $sql_user);
								$row_user = mysqli_fetch_array($result_user);
								
								?>
								<head>
								<style>
									a, a:hover {
										text-decoration: none;
									}
								</style>
								</head>
								<a class="d-flex text-muted pt-3" style="white-space: normal;" href="#">
								  <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#ffdd00"/><text x="50%" y="50%" fill="#007bff" dy=".3em"></text></svg>

								  <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
									<div class="d-flex justify-content-between">
									  <strong class="text-gray-dark">BMO Head: Trisha Tolentino</strong>
									  <p class="mb-2"><?php echo $row_dates['date_time']?></p>
									</div>
									<span class="d-block">Assigned issue: "<?php echo $row_issue['issue'];?>" to BMO admin: "<?php echo $row_user['username']?>", due on "<?php echo $row_issue['date_due'];?>"</span>
								  </div>
								</a>
								<?php
							}
							
						}else{
							?>
							<head>
								<style>
									a, a:hover {
										text-decoration: none;
									}
								</style>
							</head>
							<a class="d-flex text-muted pt-3" style="white-space: normal;" href="#">
							  <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#e85d04"/><text x="50%" y="50%" fill="#007bff" dy=".3em"></text></svg>

							  <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
								<div class="d-flex justify-content-between">
								  <strong class="text-gray-dark">KEOMS</strong>
								  <?php if(isset($row_issue['date_created']) & isset($row_issue['username']) & isset($row_issue['issue'])) { ?>
								  <p><?php echo $row_issue['date_created']?></p>
								</div>
								<span class="d-block">Employee 
								<?php echo $row_issue['username']?> submitted an  Unassigned issue: 
								<?php echo $row_issue['issue']?></span>
								<?php } else {?>
									<p class="mb-2">This issue has been deleted</p>
								</div>	
								<?php  }?>
							  </div>
							</a>
							<?php
						}
					}					
				}else if($row_dates['date_type'] == 'submitted'){
					$sql_issues = "SELECT issue_id, issue, assigned_to, date_issue_resolved  FROM `issue` WHERE issue_id = ".$row_dates['report_issue_id']." ORDER by date_created";
					
					if(!mysqli_stmt_prepare($stmt, $sql_issues)){
						echo 'error connecting to the database';
					}else{
						$result_issue = mysqli_query($conn, $sql_issues);
						$row_issue = mysqli_fetch_array($result_issue);
						
						$sql_users = "SELECT * FROM `users` WHERE users_id = ".$row_issue['assigned_to']."";
						
						if(!mysqli_stmt_prepare($stmt, $sql_users)){
							echo 'failed to connect to database users';
						}else{
							$result_issue = mysqli_query($conn, $sql_users);
							$row_users = mysqli_fetch_array($result_issue);
							
							?>
							<head>
								<style>
									a, a:hover {
										text-decoration: none;
									}
								</style>
							</head>
							<a class="d-flex text-muted pt-3" style="white-space: normal;" href="#">
							  <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#2dc653"/><text x="50%" y="50%" fill="#007bff" dy=".3em"></text></svg>

							  <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
								<div class="d-flex justify-content-between">
								  <strong class="text-gray-dark"><?php echo $row_users['role'];?>: <?php echo $row_users['username']?></strong>
								  <p class="mb-2"><?php echo $row_dates['date_time'];?></p>
								</div>
								<span class="d-block">Resolved issue: "<?php echo $row_issue['issue'];?>" of machine: "Aircon" at room: "801"</span>
							  </div>
							</a>
							
							<?php
						}
					}
				}
			}
		}
	}else{
		echo 'No updates for the last 7 days';
	}
}