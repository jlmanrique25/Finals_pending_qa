
<?php
	include 'dbh.p.php';


	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	if(isset($_GET['page'])){
		$min = 10 * ($_GET['page'] - 1);
	}else{
        $min = 0;
    }

	if(isset($_GET['by'])){
		$by = $_GET['by'];
	}else{
		$by = "DESC";
	}

	///// FOR GETTING THE RESULTS OF THE REPORTS

	if($_GET['site'] == "Reports"){
		if(isset($_GET['order'])){
			$order = $_GET['order'];
		}else{
			$order = "date_created";
		}


		///// CHECK WHAT TYPE OF DATA IS BEING VIEWED

		if(!isset($_GET['time']))
        {
			///// CHECKING IF WHAT TIME THE DATA IS BEING SELECTED

			$sql_dates = "SELECT report_id, task, machine_id, task_due, date_submitted, report_status, for_repair, assigned_user, dates.date_identity,dates.date_type, dates.report_issue_id, date_time, equipment.equipment_name, equipment.equipment_id, location.location_id, location.floor, location.room_number, reports.report_status, users.username, users.users_id, date_created
			FROM `dates`,`reports`, `equipment`, `location`, `users`
			WHERE day(date_time) = day(now()) AND month(date_time) = month(now()) AND date_identity = 'report' AND date_type = 'created' AND dates.report_issue_id = reports.report_id AND reports.machine_id = equipment.equipment_id AND location.location_id = equipment.location_id  AND YEAR(date_time) = year(now()) AND users.users_id = assigned_user
			ORDER BY ".$order." ".$by." LIMIT ".$min.",10";

		}

		///// IF THE DATE WAS MANUALLY INPUTTED BY THE USER


		else if($_GET['time'] == 'date')
        {

			///// CHECK IF THERE ARE ANY ACTIVE FILTERS SUCH AS FLOORS EQUIPMENT OR STATUS

			if (isset($_GET['status']) || isset($_GET['equipment']) || isset($_GET['floor'])) {
                if (isset($_GET['equipment']) & isset($_GET['floor'])) {



					$sql_dates = "SELECT *
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								reports.date_created BETWEEN '".$_GET['s']."'AND '".$_GET['e']."' AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id AND
								`floor` = '".$_GET['floor']."'
							ORDER BY date_created DESC LIMIT ".$min.",10";


                }else if (isset($_GET['floor'])) {

                    $sql_dates = "SELECT `task`, `equipment_name`, `floor`, `room_number`,`report_status`, `date_created`, `date_submitted`, `for_repair`, `username`
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								reports.date_created BETWEEN '".$_GET['s']."'AND '".$_GET['e']."' AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id AND
								`floor` = '".$_GET['floor']."'
							ORDER BY date_created DESC LIMIT ".$min.",10";

                }else if (isset($_GET['equipment'])) {

                    $sql_dates = "SELECT `task`, `equipment_name`, `floor`, `room_number`,`report_status`, `date_created`, `date_submitted`, `for_repair`, `username`
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								reports.date_created BETWEEN '".$_GET['s']."'AND '".$_GET['e']."' AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id AND
								`asset` = '".$_GET['equipment']."'
							ORDER BY date_created DESC LIMIT ".$min.",10";

                }else if (isset($_GET['status'])) {

                    $sql_dates = "SELECT `task`, `equipment_name`, `floor`, `room_number`,`report_status`, `date_created`, `date_submitted`, `for_repair`, `username`
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								reports.date_created BETWEEN '".$_GET['s']."'AND '".$_GET['e']."' AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id
								AND `report_status` = '".$_GET['status']."'
							ORDER BY date_created DESC LIMIT ".$min.",10";

                }
            } else {
                $sql_dates = "SELECT *
							FROM `reports`, `equipment`, `location`, `users`
							WHERE
								reports.date_created BETWEEN '".$_GET['s']."'AND '".$_GET['e']."' AND
								reports.machine_id = equipment.equipment_id AND
								location.location_id = equipment.location_id  AND
								users.users_id = assigned_user
							ORDER BY  ".$order." DESC
							LIMIT ".$min.",10";
            }



        }

		///// IF DAILY WAS SELECTED BY THE USER

		else if($_GET['time'] == 'day')
        {

			///// CHECK IF THERE ARE ANY ACTIVE FILTERS SUCH AS FLOORS EQUIPMENT OR STATUS

			if (isset($_GET['status']) || isset($_GET['equipment']) || isset($_GET['floor'])) {
                if (isset($_GET['equipment']) & isset($_GET['floor'])) {



					$sql_dates = "SELECT *
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								week(date_created) = week(now()) AND
								month(date_created) = month(now()) AND
								YEAR(date_created) = year(now()) AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id AND
								`floor` = '".$_GET['floor']."'
							ORDER BY date_created DESC LIMIT ".$min.",10";


                }else if (isset($_GET['floor'])) {

                    $sql_dates = "SELECT `task`, `equipment_name`, `floor`, `room_number`,`report_status`, `date_created`, `date_submitted`, `for_repair`, `username`
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								week(date_created) = week(now()) AND
								month(date_created) = month(now()) AND
								YEAR(date_created) = year(now()) AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id AND
								`floor` = '".$_GET['floor']."'
							ORDER BY date_created DESC LIMIT ".$min.",10";

                }else if (isset($_GET['equipment'])) {

                    $sql_dates = "SELECT `task`, `equipment_name`, `floor`, `room_number`,`report_status`, `date_created`, `date_submitted`, `for_repair`, `username`
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								week(date_created) = week(now()) AND
								month(date_created) = month(now()) AND
								YEAR(date_created) = year(now()) AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id AND
								`asset` = '".$_GET['equipment']."'
							ORDER BY date_created DESC LIMIT ".$min.",10";

                }else if (isset($_GET['status'])) {

                    $sql_dates = "SELECT `task`, `equipment_name`, `floor`, `room_number`,`report_status`, `date_created`, `date_submitted`, `for_repair`, `username`
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								week(date_created) = week(now()) AND
								month(date_created) = month(now()) AND
								YEAR(date_created) = year(now()) AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id
								AND `report_status` = '".$_GET['status']."'
							ORDER BY date_created DESC LIMIT ".$min.",10";

                }
            } else {
                $sql_dates = "SELECT report_id, task, machine_id, task_due, date_submitted, report_status, for_repair, assigned_user, dates.date_identity,dates.date_type, dates.report_issue_id, date_time, equipment.equipment_name, equipment.equipment_id, location.location_id, location.floor, location.room_number, reports.report_status, users.username, users.users_id, date_created
							FROM `dates`,`reports`, `equipment`, `location`, `users`
							WHERE
								".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								week(date_created) = week(now()) AND
								month(date_created) = month(now()) AND
								date_identity = 'report' AND
								date_type = 'created' AND
								dates.report_issue_id = reports.report_id AND
								reports.machine_id = equipment.equipment_id AND
								location.location_id = equipment.location_id  AND
								YEAR(date_created) = year(now()) AND
								users.users_id = assigned_user
							ORDER BY ".$order." ".$by." LIMIT ".$min.",10";
            }





		}

		///// IF THE USER WANTS TO VIEW THE REPORTS OF THE WEEK
		else if($_GET['time'] == 'week')
        {


			///// CHECK IF THERE ARE ANY ACTIVE FILTERS SUCH AS FLOORS EQUIPMENT OR STATUS

			if (isset($_GET['status']) || isset($_GET['equipment']) || isset($_GET['floor'])) {
                if (isset($_GET['equipment']) & isset($_GET['floor'])) {



					$sql_dates = "SELECT *
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								month(date_created) = month(now()) AND
								YEAR(date_created) = year(now()) AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id AND
								`floor` = '".$_GET['floor']."'
							ORDER BY date_created DESC LIMIT ".$min.",10";


                }else if (isset($_GET['floor'])) {

                    $sql_dates = "SELECT `task`, `equipment_name`, `floor`, `room_number`,`report_status`, `date_created`, `date_submitted`, `for_repair`, `username`
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								month(date_created) = month(now()) AND
								YEAR(date_created) = year(now()) AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id AND
								`floor` = '".$_GET['floor']."'
							ORDER BY date_created DESC LIMIT ".$min.",10";

                }else if (isset($_GET['equipment'])) {

                    $sql_dates = "SELECT `task`, `equipment_name`, `floor`, `room_number`,`report_status`, `date_created`, `date_submitted`, `for_repair`, `username`
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								month(date_created) = month(now()) AND
								YEAR(date_created) = year(now()) AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id AND
								`asset` = '".$_GET['equipment']."'
							ORDER BY date_created DESC LIMIT ".$min.",10";

                }else if (isset($_GET['status'])) {

                    $sql_dates = "SELECT `task`, `equipment_name`, `floor`, `room_number`,`report_status`, `date_created`, `date_submitted`, `for_repair`, `username`
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								month(date_created) = month(now()) AND
								YEAR(date_created) = year(now()) AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id
								AND `report_status` = '".$_GET['status']."'
							ORDER BY date_created DESC LIMIT ".$min.",10";

                }
            } else {
                $sql_dates = "SELECT report_id, task, machine_id, task_due, date_submitted, report_status, for_repair, assigned_user, dates.date_identity,dates.date_type, dates.report_issue_id, date_time, equipment.equipment_name, equipment.equipment_id, location.location_id, location.floor, location.room_number, reports.report_status, users.username, users.users_id, date_created
							FROM `dates`,`reports`, `equipment`, `location`, `users`
							WHERE
								".$_GET['time']."(date_time) = ".$_GET['time']."(now()) AND
								month(date_time) = month(now()) AND
								date_identity = 'report' AND
								date_type = 'created' AND
								dates.report_issue_id = reports.report_id AND
								reports.machine_id = equipment.equipment_id AND
								location.location_id = equipment.location_id  AND
								YEAR(date_time) = year(now()) AND
								users.users_id = assigned_user
							ORDER BY ".$order." ".$by." LIMIT ".$min.",10";
            }


		}

		///// IF THE USER WANTS TO VIEW THE REPORTS OF THE CURRENT MONTH
		else if($_GET['time'] == 'month'){


			///// CHECK IF THERE ARE ANY ACTIVE FILTERS SUCH AS FLOORS EQUIPMENT OR STATUS

			if (isset($_GET['status']) || isset($_GET['equipment']) || isset($_GET['floor'])) {
                if (isset($_GET['equipment']) & isset($_GET['floor'])) {



					$sql_dates = "SELECT *
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								YEAR(date_created) = year(now()) AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id AND
								`floor` = '".$_GET['floor']."'
							ORDER BY date_created DESC LIMIT ".$min.",10";


                }else if (isset($_GET['floor'])) {

                    $sql_dates = "SELECT `task`, `equipment_name`, `floor`, `room_number`,`report_status`, `date_created`, `date_submitted`, `for_repair`, `username`
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								YEAR(date_created) = year(now()) AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id AND
								`floor` = '".$_GET['floor']."'
							ORDER BY date_created DESC LIMIT ".$min.",10";

                }else if (isset($_GET['equipment'])) {

                    $sql_dates = "SELECT `task`, `equipment_name`, `floor`, `room_number`,`report_status`, `date_created`, `date_submitted`, `for_repair`, `username`
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								YEAR(date_created) = year(now()) AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id AND
								`asset` = '".$_GET['equipment']."'
							ORDER BY date_created DESC LIMIT ".$min.",10";

                }else if (isset($_GET['status'])) {

                    $sql_dates = "SELECT `task`, `equipment_name`, `floor`, `room_number`,`report_status`, `date_created`, `date_submitted`, `for_repair`, `username`
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								YEAR(date_created) = year(now()) AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id
								AND `report_status` = '".$_GET['status']."'
							ORDER BY date_created DESC LIMIT ".$min.",10";

                }
            } else {
                $sql_dates = "SELECT report_id, task, machine_id, task_due, date_submitted, report_status, for_repair, assigned_user, dates.date_identity,dates.date_type, dates.report_issue_id, date_time, equipment.equipment_name, equipment.equipment_id, location.location_id, location.floor, location.room_number, reports.report_status, users.username, users.users_id, date_created
							FROM `dates`,`reports`, `equipment`, `location`, `users`
							WHERE
								".$_GET['time']."(date_time) = ".$_GET['time']."(now()) AND
								date_identity = 'report' AND
								date_type = 'created' AND
								dates.report_issue_id = reports.report_id AND
								reports.machine_id = equipment.equipment_id AND
								location.location_id = equipment.location_id  AND
								YEAR(date_created) = year(now()) AND
								users.users_id = assigned_user
							ORDER BY ".$order." ".$by." LIMIT ".$min.",10";
            }

        }

		///// IF THE USER WANTS TO VIEW THE REPORTS MADE IN THAT YEAR
		else{


			///// CHECK IF THERE ARE ANY ACTIVE FILTERS SUCH AS FLOORS EQUIPMENT OR STATUS

			if (isset($_GET['status']) || isset($_GET['equipment']) || isset($_GET['floor'])) {
                if (isset($_GET['equipment']) & isset($_GET['floor'])) {



					$sql_dates = "SELECT *
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id AND
								`floor` = '".$_GET['floor']."'
							ORDER BY date_created DESC LIMIT ".$min.",10";


                }else if (isset($_GET['floor'])) {

                    $sql_dates = "SELECT `task`, `equipment_name`, `floor`, `room_number`,`report_status`, `date_created`, `date_submitted`, `for_repair`, `username`
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id AND
								`floor` = '".$_GET['floor']."'
							ORDER BY date_created DESC LIMIT ".$min.",10";

                }else if (isset($_GET['equipment'])) {

                    $sql_dates = "SELECT `task`, `equipment_name`, `floor`, `room_number`,`report_status`, `date_created`, `date_submitted`, `for_repair`, `username`
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id AND
								`asset` = '".$_GET['equipment']."'
							ORDER BY date_created DESC LIMIT ".$min.",10";

                }else if (isset($_GET['status'])) {

                    $sql_dates = "SELECT `task`, `equipment_name`, `floor`, `room_number`,`report_status`, `date_created`, `date_submitted`, `for_repair`, `username`
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id
								AND `report_status` = '".$_GET['status']."'
							ORDER BY date_created DESC LIMIT ".$min.",10";

                }
            } else {
                $sql_dates = "SELECT report_id, task, machine_id, task_due, date_submitted, report_status, for_repair, assigned_user, dates.date_identity,dates.date_type, dates.report_issue_id, date_time, equipment.equipment_name, equipment.equipment_id, location.location_id, location.floor, location.room_number, reports.report_status, users.username, users.users_id, date_created
							FROM `dates`,`reports`, `equipment`, `location`, `users`
							WHERE
								".$_GET['time']."(date_time) = ".$_GET['time']."(now()) AND
								date_identity = 'report' AND
								date_type = 'created' AND
								dates.report_issue_id = reports.report_id AND
								reports.machine_id = equipment.equipment_id AND
								location.location_id = equipment.location_id  AND
								users.users_id = assigned_user
							ORDER BY ".$order." ".$by." LIMIT ".$min.",10";
            }

        }

	///// FOR GETTING THE RESULTS OF THE ISSUES

	}else if($_GET['site'] == "Issues"){
		if(isset($_GET['order'])){
			$order = $_GET['order'];
		}else{
			$order = "date_created";
		}

		if(!isset($_GET['time']))
        {
			$sql_dates =
				"SELECT * FROM `issue`, `equipment`, `users`, `dates` WHERE day(dates.date_time) = day(now()) AND year(date_time) = year(now()) AND date_type = 'created' AND issue.machine_id = equipment.equipment_id AND assigned_to = users.users_id ORDER by ".$order." ".$by." LIMIT ".$min.",10";
		}
		else if($_GET['time'] == 'date')
        {
			$sql_dates ="SELECT * FROM `issue`, `equipment`, `location`, `users`
			WHERE issue.date_created BETWEEN '".$_GET['s']."' AND '".$_GET['e']."' AND issue.machine_id = equipment.equipment_id AND location.location_id = equipment.location_id AND issue.submitted_by = users.users_id ORDER BY issue.date_created DESC LIMIT ".$min.",10"
			;
		}
		else if($_GET['time'] == 'day')
        {
			$sql_dates = "SELECT * FROM `issue`, `equipment`, `users`
							WHERE ".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
									week(date_created) = week(now()) AND
									month(date_created) = month(now()) AND
									year(date_created) = year(now()) AND
									issue.machine_id = equipment.equipment_id AND
									assigned_to = users.users_id
								ORDER by date_created desc LIMIT ".$min.",10";
		}
		else if($_GET['time'] == 'week')
        {
			$sql_dates = "SELECT * FROM `issue`, `equipment`, `users`
							WHERE ".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								month(date_created) = month(now()) AND
								year(date_created) = year(now()) AND
								issue.machine_id = equipment.equipment_id AND
								assigned_to = users.users_id
							ORDER by date_created desc LIMIT ".$min.",10";
		}
		else if($_GET['time'] == 'month')
        {
			$sql_dates = "SELECT * FROM `issue`, `equipment`, `users`
							WHERE ".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								year(date_created) = year(now()) AND
								issue.machine_id = equipment.equipment_id AND
								assigned_to = users.users_id
							ORDER by date_created desc LIMIT ".$min.",10";
		}
		else
        {
			$sql_dates = "SELECT * FROM `issue`, `equipment`, `users`
							WHERE ".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								issue.machine_id = equipment.equipment_id AND
								assigned_to = users.users_id
							ORDER by date_created desc LIMIT ".$min.",10";
		}


	}


	$stmt = mysqli_stmt_init($conn);

	if(!mysqli_stmt_prepare($stmt,$sql_dates)){
		echo $sql_dates;
	}else{
		$results_dates = mysqli_query($conn, $sql_dates);


		if($results_dates->num_rows > 0){
			while($row_dates = mysqli_fetch_array($results_dates)){
				if($_GET['site'] == "Reports"){

?>

				<tr role="button" data-href="index.php?page=1&site=Dashboard">
				  <td><?php echo $row_dates['task'];?></td>
				  <td><?php echo $row_dates['equipment_name'];?></td>
				  <td><?php echo $row_dates['floor'];?></td>
				  <td><?php 
					if(is_null($row_dates['room_number'])){
						echo "--";
					}else{
						echo $row_dates['room_number'];
					}
				  ?></td>
				  <td><?php echo $row_dates['report_status'];?></td>
				  <td><?php echo $row_dates['date_created'];?></td>
				  <?php if(!$row_dates['date_submitted']){
					  echo '<td>--</td>';
				  }else{
					  ?><td><?php echo $row_dates['date_submitted'];?></td><?php
				  }?>

				  <?php if(is_null($row_dates['for_repair'])){
					  echo '<td>--</td>';
				  }else{
					  ?><td><?php 
						if($row_dates['for_repair'] == 1){
							echo 'Yes';
						}else{
							echo 'No';
						}
					  ?></td><?php
				  }?>
				  <td><?php echo $row_dates['username'];?></td>
				</tr>
			<?php
				}else if($_GET['site'] == "Issues"){
					?>
				<tr role="button" data-href="issue_report.php?i_id=<?php echo $row_dates['issue_id']?>&Generator%20set%20II">
				  <td><?php echo $row_dates['issue'];?></td>
				  <td><?php echo $row_dates['equipment_name'];?></td>
				  
				  <?php if(is_null($row_dates['issue_status'])){
					  echo '<td>--</td>';
				  }else{
					  ?><td><?php 
						if($row_dates['issue_status'] == 1){
							echo 'Resolved';
						}else{
							echo 'Not resolved';
						}
					  ?></td><?php
				  }?>
				  <td><?php echo $row_dates['date_created'];?></td>
				  <td><?php echo $row_dates['date_due'];?></td>
				  <?php if(!$row_dates['date_issue_resolved']){
					  echo '<td>--</td>';
				  }else{
					  ?><td><?php echo $row_dates['date_issue_resolved'];?></td><?php
				  }?>
				 
				 <?php
					if(is_null($row_dates['username'])){
						?>
						 <td><a href="createIssue.php?site=Create issue log" class="btn btn-success" role="button" aria-pressed="true">Create issue log</a></td>
						<?php
					}else{
						?>
						<td><?php echo $row_dates['username'];?></td>
						<?php
					}
				 ?>
				  
				</tr>
			<?php
				}
			}
			
		}else{
			?>
				<tr>
					<td colspan="7" class="text-center"> 
					There are no reports
					</td>
				</tr>
			<?php
		}
	}
	
	
?>