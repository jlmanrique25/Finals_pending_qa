<?php
if(!isset($_SESSION['role'])){
    session_start();
}
include 'header.php';
include 'backend/dbh.p.php';
?>	
<div class="container py-4 overflow-hidden">
	<!--START OF CODE FOR DASHBOARD DATA-->
		<div class="p-5 mb-3 bg-light rounded-3 shadow-sm">
		  <div class="container-fluid py-3 overflow-hidden">
		  <h4> The reports are the following as of: <?php 
		  date_default_timezone_set('Asia/Hong_Kong');
			$date_created = date('Y-m-d h:i:s a', time());
			echo date('F d, Y h:i a', strtotime($date_created));
		  ?></h4>
			<div class="row mb-2">
				<div class="col text-light p-2">
					<a class="container btn btn-warning rounded-3 d-flex gap-3 p-4" href="n_issues.php?site=New%20Issues&page=1" role="button"
					style="margin-bottom:4px;white-space: normal; color: white;">
						<p class="display-3  font-weight-bold"><?php include 'backend/count_new_issues.p.php';?></p>
						<div class=" text-left">
							<h4 class="mb-0 text-uppercase">new issues</h6>
							<p class="mb-0 text-light">The total number of unassigned issues</p>
						</div>
						
					</a>
				</div>
				<div class="col text-light p-2">
					<a class="container btn btn-warning rounded-3 d-flex gap-3 p-4" href="p_issues.php?site=Pending%20Issues&page=1" role="button"
					style="margin-bottom:4px;white-space: normal; background-color: #fd7e14; color: white;">
						<p class="display-3  font-weight-bold"><?php include 'backend/count_issues.p.php';?></p>
						<div class=" text-left">
							<h4 class="mb-0 text-uppercase">pending issues</h6>
							<p class="mb-0 text-light">The total number of unresolved issues</p>
						</div>
						
					</a>
				</div>
				<div class="col text-light p-2">
					<a class="container btn btn-danger rounded-3 d-flex gap-3 p-4" href="o_issues.php?site=Overdue%20Issues&page=1" role="button"
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
					<a class="container btn btn-success rounded-3 d-flex gap-3 p-4" href="i_users.php?site=Available%20Staff&page=1" role="button"
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
					<a class="container btn btn-warning rounded-3 d-flex gap-3 p-4" href="u_tasks.php?site=Pending%20Tasks&page=1" role="button"
					style="margin-bottom:4px;white-space: normal; background-color: #fd7e14; color: white;">
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
					<a class="container btn btn-danger rounded-3 d-flex gap-3 p-4" href="o_tasks.php?site=Overdue%20Tasks&page=1" role="button"
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
			<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


		  </div>
		  <!--START OF CODE FOR UPDATE FIELD-->
		  <div class="my-3 p-3 bg-body rounded shadow-sm">
			<h6 class="border-bottom pb-2 mb-0">Activities (last 7 days)</h6>
			
			<?php
                //include 'backend/filter_report_issues.p.php';
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
							<a class="d-flex text-muted pt-3" style="white-space: normal;" href="#">
							  <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#ffdd00"/><text x="50%" y="50%" fill="#007bff" dy=".3em"></text></svg>

							  <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
								<div class="d-flex justify-content-between">
								  <strong class="text-gray-dark"><?php echo $user_assignor;?></strong>
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
								<a class="d-flex text-muted pt-3" style="white-space: normal;" href="#">
									<svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#007bff"/><text x="50%" y="50%" fill="#007bff" dy=".3em"></text></svg>

									<div class="pb-3 mb-0 small lh-sm border-bottom w-100">
									<div class="d-flex justify-content-between">
									<strong class="text-gray-dark"><!--Employee: --><?php echo $row_users['username'];?></strong>
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
							<a class="d-flex text-muted pt-3" style="white-space: normal;" href="#">
							  <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#e70e02"/><text x="50%" y="50%" fill="#007bff" dy=".3em"></text></svg>

							  <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
								<div class="d-flex justify-content-between">
								  <strong class="text-gray-dark"><!--Employee: --><?php echo $row_users['username'];?></strong>
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
							<a class="d-flex text-muted pt-3" style="white-space: normal;" href="#">
							  <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#e70e02"/><text x="50%" y="50%" fill="#007bff" dy=".3em"></text></svg>

							  <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
								<div class="d-flex justify-content-between">
								  <strong class="text-gray-dark"><!--Employee: --><?php echo $row_users['username'];?></strong>
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
								<a class="d-flex text-muted pt-3" style="white-space: normal;" href="#">
								  <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#ffdd00"/><text x="50%" y="50%" fill="#007bff" dy=".3em"></text></svg>

								  <div class="pb-3 mb-0 small lh-sm border-bottom w-100">
									<div class="d-flex justify-content-between">
									  <strong class="text-gray-dark">Trisha Tolentino</strong>
									  <p class="mb-2"><?php echo $row_dates['date_time']?></p>
									</div>
									<span class="d-block">Assigned issue: "<?php echo $row_issue['issue'];?>" to BMO admin: "<?php echo $row_user['username']?>", due on "<?php echo $row_issue['date_due'];?>"</span>
								  </div>
								</a>
								<?php
                                        }
                                        
                                    }else{
                                ?>
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
			?>
			
			<small class="d-block text-end mt-3">
				<?php
                    //include 'backend/count_weekly_updates.p.php';
                $sql = "SELECT count(*) as total FROM `dates`WHERE date_time > now() - INTERVAL 7 day AND (date_type = 'created' OR date_type = 'submitted') ORDER BY date_time DESC";
                $stmt = mysqli_stmt_init($conn);
                
                if(!mysqli_stmt_prepare($stmt, $sql)){
                    echo 'error connecting to server';
                }else{
                    $result = mysqli_query($conn, $sql);
                    $total = mysqli_fetch_assoc($result);
                    $count = 1;
                    $pages = ceil($total['total']/5);
                    
                ?>
			<nav aria-label="Page navigation example">
				  <ul class="pagination">
				  <li class="page-item"><a class="page-link" href="<?php
					if(($_GET['page']-1) == 0){
						echo '#';
					}else{
						$new_page = $_GET['page'] - 1;
						echo 'index.php?site=Dashboard&page='.$new_page.'';
					}
                                                                   ?>">Previous</a></li>
		<?php
                    for($i = 1; $i <= $pages; $i++){
        ?>
			
					
					<li  <?php 
						if(isset($_GET['page'])){
							if($_GET['page'] == $i){
                                echo 'class="page-item active"';
                            }
						}else{
							if( 1 == $i){
                                echo 'class="page-item active"';
                            }
						}
                         ?>><a class="page-link" href="index.php?page=<?php echo $i;?>&site=dashboard"><?php echo $i;
                                                                                                  ?></a></li>
					
			  
			  <?php
                    }
              ?>
			<li class="page-item"><a class="page-link" href="<?php
					if(($_GET['page']+1) > $pages){
						echo '#';
					}else{
						$new_page = $_GET['page'] + 1;
						echo 'index.php?site=Dashboard&page='.$new_page.'';
					}
                                                             ?>">Next</a></li>
				  </ul>
			  </nav>
		<?php
                    
                }
        ?>
                ?>
			</small>
		  </div>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</div>


	
</body>