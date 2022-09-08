<?php
	include 'dbh.p.php';
	
	//$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


	if($_GET['site'] == 'Reports'){

		///// THIS IS FOR THE MANUALLY INPUTTED DATE
		if($_GET['time'] == 'date'){


			///// CHECK IF THERE ARE ANY ACTIVE FILTERS SUCH AS FLOORS EQUIPMENT OR STATUS

			if (isset($_GET['status']) || isset($_GET['equipment']) || isset($_GET['floor'])) {
                if (isset($_GET['equipment']) & isset($_GET['floor'])) {



					$sql = "SELECT count(*) as total
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								reports.date_created BETWEEN '".$_GET['s']."'AND '".$_GET['e']."' AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id AND
								`floor` = '".$_GET['floor']."'
							ORDER BY date_created DESC";


                }else if (isset($_GET['floor'])) {

                    $sql = "SELECT count(*) as total
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								reports.date_created BETWEEN '".$_GET['s']."'AND '".$_GET['e']."' AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id AND
								`floor` = '".$_GET['floor']."'
							ORDER BY date_created DESC ";

                }else if (isset($_GET['equipment'])) {

                    $sql = "SELECT count(*) as total
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								reports.date_created BETWEEN '".$_GET['s']."'AND '".$_GET['e']."' AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id AND
								`asset` = '".$_GET['equipment']."'
							ORDER BY date_created DESC ";

                }else if (isset($_GET['status'])) {

                    $sql = "SELECT count(*) as total
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								reports.date_created BETWEEN '".$_GET['s']."'AND '".$_GET['e']."' AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id
								AND `report_status` = '".$_GET['status']."'
							ORDER BY date_created DESC";

                }
            } else {
                $sql = "SELECT count(*) as total FROM `reports`, `equipment`, `location`, `users` WHERE reports.date_created BETWEEN '".$_GET['s']."'AND '".$_GET['e']."' AND reports.machine_id = equipment.equipment_id AND location.location_id = equipment.location_id  AND users.users_id = assigned_user";
            }


			

			$stmt = mysqli_stmt_init($conn);
            
            if(!mysqli_stmt_prepare($stmt, $sql)){
                echo 'error connecting to the database';
            }else{
                $result = mysqli_query($conn,$sql);
                $row = mysqli_fetch_assoc($result);

                $pages = ceil($row['total']/10);
              
				
			?>

			<!--- THIS IS FORE THE PREVIOUS BUTTON OF THE PAGINATION OF THE PAGE-->
			<nav aria-label="Page navigation example">
				  <ul class="pagination justify-content-center">
				  <li class="page-item"><a class="page-link" href="<?php
                if(($_GET['page']-1) == 0){
                    echo '#';
                }else{
                    $new_page = $_GET['page'] - 1;
					?>
						reports.php?site=Reports&page=<?php echo $new_page;?>&time=<?php echo $_GET['time'];?>&s=<?php echo $_GET['s'];?>&e=<?php echo $_GET['e'];?>
                    <?php
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
                         ?>>
					  
		   
						<a class="page-link" href="reports.php?site=Reports&page=<?php echo $i;?>&time=<?php echo $_GET['time']?>&s=<?php echo $_GET['s'];?>&e=<?php echo $_GET['e'];?>"><?php echo $i;
                                                                                                                                   ?>
					  </a></li>
					
			  
			  <?php
            }}
              ?>
			<li class="page-item"><a class="page-link" href="
			<?php
				///// THIS IS FOR THE NEXT BUTTON OF THE PAGINATION

                if(($_GET['page']+1) > $pages){
                    echo '#';
                }else{
                    $new_page = $_GET['page'] + 1;?>
						reports.php?site=Reports&page=<?php echo $new_page;?>&time=<?php echo $_GET['time'];?>&s=<?php echo $_GET['s'];?>&e=<?php echo $_GET['e'];?>
						<?php   
                }
                              ?>&order=<?php 
                if(isset($_GET['order'])){
                    echo $_GET['order'];
                }else{
                    echo 'date_created';
                }
                
                           ?>&by=<?php
                if(isset($_GET['by'])){
                    if($_GET['by'] == 'asc'){
                        echo 'desc';
                    }else{
                        echo 'asc';
                    }
                }else{
                    echo 'asc';
                }
                        ?>">Next</a></li>
				  </ul>
			  </nav>
		<?php
            

		/////	THIS IS THE PAGINATION FOR THE REPORTS WITH PRESELECTED DAILY WEEKLY MONTHLY AND YEARLY
		}else{
            if(! isset($_GET['time']))
            {
				$sql = "SELECT count(*) as total FROM `reports` WHERE ".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND MONTH(date_created) = MONTH(now()) AND YEAR(date_created) = year(now())";
            }

			///// IF THE USER WANTS TO SEE THE REPORTS OF THE DAY

			else if($_GET['time'] == 'day')
            {

				///// CHECK IF THERE ARE ANY ACTIVE FILTERS SUCH AS FLOORS EQUIPMENT OR STATUS

                if (isset($_GET['status']) || isset($_GET['equipment']) || isset($_GET['floor'])) {
                    if (isset($_GET['equipment']) & isset($_GET['floor'])) {



                        $sql = "SELECT count(*) as total
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
							ORDER BY date_created DESC";


                    }else if (isset($_GET['floor'])) {

                        $sql = "SELECT count(*) as total
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
							ORDER BY date_created DESC";

                    }else if (isset($_GET['equipment'])) {

                        $sql = "SELECT count(*) as total
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
							ORDER BY date_created DESC ";

                    }else if (isset($_GET['status'])) {

                        $sql = "SELECT count(*) as total
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
							ORDER BY date_created DESC";

                    }
                } else {
                    $sql = "SELECT count(*) as total FROM `reports` WHERE ".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND WEEK(date_created) = WEEK(now()) AND MONTH(date_created) = MONTH(now()) AND YEAR(date_created) = year(now())";
                }



            }

			///// IF THE USER WANTS TO SEE THE REPORTS OF THE CURRENT MONTH

			else if($_GET['time'] == 'month')
            {

				
                ///// CHECK IF THERE ARE ANY ACTIVE FILTERS SUCH AS FLOORS EQUIPMENT OR STATUS

                if (isset($_GET['status']) || isset($_GET['equipment']) || isset($_GET['floor'])) {
                    if (isset($_GET['equipment']) & isset($_GET['floor'])) {



                        $sql_dates = "SELECT count(*) as total
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								YEAR(date_created) = year(now()) AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id AND
								`floor` = '".$_GET['floor']."'
							ORDER BY date_created DESC";


                    }else if (isset($_GET['floor'])) {

                        $sql_dates = "SELECT count(*) as total
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								YEAR(date_created) = year(now()) AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id AND
								`floor` = '".$_GET['floor']."'
							ORDER BY date_created DESC";

                    }else if (isset($_GET['equipment'])) {

                        $sql_dates = "SELECT count(*) as total
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								YEAR(date_created) = year(now()) AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id AND
								`asset` = '".$_GET['equipment']."'
							ORDER BY date_created DESC";

                    }else if (isset($_GET['status'])) {

                        $sql = "SELECT count(*) as total
							WHERE
								".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								YEAR(date_created) = year(now()) AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id
								AND `report_status` = '".$_GET['status']."'
							ORDER BY date_created DESC";

                    }
                } else {
                    $sql = "SELECT count(*) as total FROM `reports` WHERE ".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND YEAR(date_created) = year(now())";
                }
                }


			///// IF THE USER WANTS TO SEE THE CURRENT YEAR REPORTS
               
			else if($_GET['time'] == 'year')
            {

				
                ///// CHECK IF THERE ARE ANY ACTIVE FILTERS SUCH AS FLOORS EQUIPMENT OR STATUS

                if (isset($_GET['status']) || isset($_GET['equipment']) || isset($_GET['floor'])) {
                    if (isset($_GET['equipment']) & isset($_GET['floor'])) {



                        $sql = "SELECT count(*) as total
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id AND
								`floor` = '".$_GET['floor']."'
							ORDER BY date_created DESC";


                    }else if (isset($_GET['floor'])) {

                        $sql = "SELECT count(*) as total
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id AND
								`floor` = '".$_GET['floor']."'
							ORDER BY date_created DESC";

                    }else if (isset($_GET['equipment'])) {

                        $sql = "SELECT count(*) as total
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id AND
								`asset` = '".$_GET['equipment']."'
							ORDER BY date_created DESC";

                    }else if (isset($_GET['status'])) {

                        $sql = "SELECT count(*) as total
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id
								AND `report_status` = '".$_GET['status']."'
							ORDER BY date_created ";

                    }
                } else {
                    $sql = "SELECT count(*) as total FROM `reports` WHERE ".$_GET['time']."(date_created) = ".$_GET['time']."(now())";
                }


               
            }

			///// IF THE USER WANT TO SEE THE WEEKLY REPORTS

			else
            {

				///// CHECK IF THERE ARE ANY ACTIVE FILTERS SUCH AS FLOORS EQUIPMENT OR STATUS

                if (isset($_GET['status']) || isset($_GET['equipment']) || isset($_GET['floor'])) {
                    if (isset($_GET['equipment']) & isset($_GET['floor'])) {



                        $sql = "SELECT count(*) as total
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								month(date_created) = month(now()) AND
								YEAR(date_created) = year(now()) AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id AND
								`floor` = '".$_GET['floor']."'
							ORDER BY date_created DESC ";


                    }else if (isset($_GET['floor'])) {

                        $sql = "SELECT count(*) as total
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								month(date_created) = month(now()) AND
								YEAR(date_created) = year(now()) AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id AND
								`floor` = '".$_GET['floor']."'
							ORDER BY date_created DESC ";

                    }else if (isset($_GET['equipment'])) {

                        $sql = "SELECT count(*) as total
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								month(date_created) = month(now()) AND
								YEAR(date_created) = year(now()) AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id AND
								`asset` = '".$_GET['equipment']."'
							ORDER BY date_created DESC";

                    }else if (isset($_GET['status'])) {

                        $sql = "SELECT count(*) as total
							FROM `reports`,`equipment`,`location`,`users`
							WHERE
								".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND
								month(date_created) = month(now()) AND
								YEAR(date_created) = year(now()) AND
								reports.machine_id = equipment.equipment_id AND
								reports.assigned_user = users.users_id AND
								equipment.location_id = location.location_id
								AND `report_status` = '".$_GET['status']."'
							ORDER BY date_created DESC ";

                    }
                } else {
                    $sql = "SELECT count(*) as total FROM `reports` WHERE ".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND MONTH(date_created) = MONTH(now()) AND YEAR(date_created) = year(now())";
                }


                
            }

			//$sql = "SELECT count(*) as total FROM `reports` WHERE ".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND YEAR(date_created) = year(now())";

			$stmt = mysqli_stmt_init($conn);
            

            if(!mysqli_stmt_prepare($stmt, $sql)){
                echo 'error connecting to the database';
				echo $sql;
            }else{
                $result = mysqli_query($conn,$sql);
                $row = mysqli_fetch_assoc($result);
                
                $pages = ceil($row['total']/10);
                
?>
			<nav aria-label="Page navigation example">
				  <ul class="pagination justify-content-center">
				  <li class="page-item"><a class="page-link" href="<?php
                if(($_GET['page']-1) == 0){
                    echo '#';
                }else{
                    $new_page = $_GET['page'] - 1;
                    if($_GET['site'] == 'Reports'){
                        if(isset($_GET['s'])){
                                                                   ?>
								reports.php?site=Reports&page=<?php echo $new_page;?>&time=<?php echo $_GET['time'];?>&s=<?php echo $_GET['s'];?>&e=<?php echo $_GET['e'];?>
								<?php
                        }else{
                                ?><?php
							echo 'reports.php?site=Reports&page='.$new_page.'&time='.$_GET['time'].'';
                        }
                        
                        
                    }else if($_GET['site'] == "Issues"){
                        if(isset($_GET['s'])){
                              ?>
								issues.php?site=Issues&page=<?php echo $new_page;?>&time=<?php echo $_GET['time'];?>&s=<?php echo $_GET['s'];?>&e=<?php echo $_GET['e'];?>
								<?php
                        }else{
                                ?><?php
							echo 'issues.php?site=Issues&page='.$new_page.'&time='.$_GET['time'].'';
                        }
                    }
                    
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
                         ?>>
					  
		   
						<a class="page-link" href="reports.php?page=<?php echo $i;?>&site=Reports&time=<?php echo $_GET['time']?>"><?php echo $i;
                                                                                                                                   ?>
					  </a></li>
					
			  
			  <?php
                }

				///// BUTTON FOR THE NEXT PAGE
              ?>
			<li class="page-item"><a class="page-link" href="
			<?php
                if(($_GET['page']+1) > $pages){
                    echo '#';
                }else{
                    $new_page = $_GET['page'] + 1;
							echo 'reports.php?site=Reports&page='.$new_page.'&time='.$_GET['time'].'';         
                }
                        ?>">Next</a></li>
				  </ul>
			  </nav>
		<?php
            }

    }
	}

		///// FOR THE ISSUES OF THE BMO

		else if($_GET['site'] == "Issues"){
		

		///// IF THE DATE WAS MANUALLY TYPED IN BY THE USER
		if($_GET['time'] == 'date'){
			$sql = "SELECT count(*) as total FROM `issue`, `equipment`, `location`, `users` 
			WHERE issue.date_created BETWEEN '".$_GET['s']."' AND '".$_GET['e']."' AND issue.machine_id = equipment.equipment_id AND location.location_id = equipment.location_id  AND issue.submitted_by = users.users_id";
			

			$stmt = mysqli_stmt_init($conn);
            
            if(!mysqli_stmt_prepare($stmt, $sql)){
                echo 'error connecting to the database issues manual';
            }else{
                $result = mysqli_query($conn,$sql);
                $row = mysqli_fetch_assoc($result);

                $pages = ceil($row['total']/10);
                
				
        ?>

			<!--- THIS IS FORE THE PREVIOUS BUTTON OF THE PAGINATION OF THE PAGE-->
			<nav aria-label="Page navigation example">
				  <ul class="pagination justify-content-center">
				  <li class="page-item"><a class="page-link" href="<?php
                if(($_GET['page']-1) == 0){
                    echo '#';
                }else{
                    $new_page = $_GET['page'] - 1;
                                                                   ?>
						issues.php?site=Issues&page=<?php echo $new_page;?>&time=<?php echo $_GET['time'];?>&s=<?php echo $_GET['s'];?>&e=<?php echo $_GET['e'];?>
                    <?php
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
                         ?>>
					  
		   
						<a class="page-link" href="issues.php?site=Issues&page=<?php echo $i;?>&time=<?php echo $_GET['time']?>&s=<?php echo $_GET['s'];?>&e=<?php echo $_GET['e'];?>"><?php echo $i;
                                                                                                                                                                                         ?>
					  </a></li>
					
			  
			  <?php
                }
            }
              ?>
			<li class="page-item"><a class="page-link" href="
			<?php
            ///// THIS IS FOR THE NEXT BUTTON OF THE PAGINATION

            if(($_GET['page']+1) > $pages){
                echo '#';
            }else{
                $new_page = $_GET['page'] + 1;?>
						issues.php?site=Issues&page=<?php echo $new_page;?>&time=<?php echo $_GET['time'];?>&s=<?php echo $_GET['s'];?>&e=<?php echo $_GET['e'];?>
						<?php   
				}
                                 ?>">Next</a></li>
				  </ul>
			  </nav>
		<?php
            



		///// FOR THE DAILY WEEKLY MONTHLY YEARLY ISSUES OF THE BMO

		}else{

			if(! isset($_GET['time'])){
				$sql = "SELECT count(*) as total FROM `issue` WHERE ".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND MONTH(date_created) = MONTH(now()) AND YEAR(date_created) = year(now())";
            }else if($_GET['time'] == 'day'){
                $sql = "SELECT count(*) as total FROM `issue` WHERE ".$_GET['time']."(date_created) = ".$_GET['time']."(now())  AND MONTH(date_created) = MONTH(now()) AND YEAR(date_created) = year(now())";
            }else if($_GET['time'] == 'month'){
                $sql = "SELECT count(*) as total FROM `issue` WHERE ".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND YEAR(date_created) = year(now())";
            }else if($_GET['time'] == 'year'){
                $sql = "SELECT count(*) as total FROM `issue` WHERE ".$_GET['time']."(date_created) = ".$_GET['time']."(now())";
            }else{
                $sql = "SELECT count(*) as total FROM `issue` WHERE ".$_GET['time']."(date_created) = ".$_GET['time']."(now()) AND MONTH(date_created) = MONTH(now()) AND YEAR(date_created) = year(now())";
            }

			//$sql = "SELECT count(*) as total FROM `dates` WHERE ".$_GET['time']."(date_time) = ".$_GET['time']."(now()) and date_type = 'created' and date_identity = 'issue'";

			$stmt = mysqli_stmt_init($conn);
			
            if(!mysqli_stmt_prepare($stmt, $sql)){
                echo 'error connecting to the database issues daily';
				echo $sql;
            }else{
                $result = mysqli_query($conn,$sql);
                $row = mysqli_fetch_assoc($result);
                
                $pages = ceil($row['total']/10);
                
        ?>
			<nav aria-label="Page navigation example">
				  <ul class="pagination justify-content-center">
				  <li class="page-item"><a class="page-link" href="<?php
                if(($_GET['page']-1) == 0){
                    echo '#';
                }else{
                    $new_page = $_GET['page'] - 1;
					echo 'issues.php?site=Issues&page='.$new_page.'&time='.$_GET['time'].'';
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
                         ?>>
					  
		   
						<a class="page-link" href="issues.php?page=<?php echo $i;?>&site=Issues&time=<?php echo $_GET['time']?>"><?php echo $i;
                                                                                                                                   ?>
					  </a></li>
					
			  
			  <?php
                }

				///// BUTTON FOR THE NEXT PAGE
              ?>
			<li class="page-item"><a class="page-link" href="
			<?php
                if(($_GET['page']+1) > $pages){
                    echo '#';
                }else{
                    $new_page = $_GET['page'] + 1;
                    echo 'issues.php?site=Issues&page='.$new_page.'&time='.$_GET['time'].'';         
                }
            ?>">Next</a></li>
				  </ul>
			  </nav>
		<?php
            }
		}
		
	}
	?><?php
	/**
	
$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql)){
		echo 'error connecting to the database';
	}else{
		$result = mysqli_query($conn,$sql);
		$row = mysqli_fetch_assoc($result);
		
		$pages = ceil($row['total']/10);
		
		?>
			<nav aria-label="Page navigation example">
				  <ul class="pagination justify-content-center">
				  <li class="page-item"><a class="page-link" href="<?php
					if(($_GET['page']-1) == 0){
						echo '#';
					}else{
						$new_page = $_GET['page'] - 1;
						if($_GET['site'] == 'Reports'){
							if(isset($_GET['s'])){
								?>
								reports.php?site=Reports&page=<?php echo $new_page;?>&time=<?php echo $_GET['time'];?>&s=<?php echo $_GET['s'];?>&e=<?php echo $_GET['e'];?>
								<?php
							}else{
							?><?php
							echo 'reports.php?site=Reports&page='.$new_page.'&time='.$_GET['time'].'';
							}
							
							
						}else if($_GET['site'] == "Issues"){
							if(isset($_GET['s'])){
								?>
								issues.php?site=Issues&page=<?php echo $new_page;?>&time=<?php echo $_GET['time'];?>&s=<?php echo $_GET['s'];?>&e=<?php echo $_GET['e'];?>
								<?php
							}else{
							?><?php
							echo 'issues.php?site=Issues&page='.$new_page.'&time='.$_GET['time'].'';
							}
						}
						
					}
				  ?>">Previous</a></li>
		<?php
		
		for($i = 1; $i <= $pages; $i++){
			?>
			
					
					<li  <?php 
						if(isset($_GET['page'])){
							if($_GET['page'] == $i){
							echo 'class="page-item active"';}
						}else{
							if( 1 == $i){
							echo 'class="page-item active"';}
						}
					?>>
					  
		   
						<a class="page-link" href="reports.php?page=<?php echo $i;?>&site=Reports&time=<?php echo $_GET['time']?>"><?php echo $i;
                                                                                                                                   ?>
					  </a></li>
					
			  
			  <?php
		}
		?>
			<li class="page-item"><a class="page-link" href="
			<?php
					if(($_GET['page']+1) > $pages){
						echo '#';
					}else{
						$new_page = $_GET['page'] + 1;
						if($_GET['site'] == 'Reports'){
							if(isset($_GET['s'])){
								?>
								reports.php?site=Reports&page=<?php echo $new_page;?>&time=<?php echo $_GET['time'];?>&s=<?php echo $_GET['s'];?>&e=<?php echo $_GET['e'];?>
								<?php
							}else{
							?><?php
							echo 'reports.php?site=Reports&page='.$new_page.'&time='.$_GET['time'].'';
							}
						}else if($_GET['site'] == "Issues"){
							if(isset($_GET['s'])){
								?>
								issues.php?site=Issues&page=<?php echo $new_page;?>&time=<?php echo $_GET['time'];?>&s=<?php echo $_GET['s'];?>&e=<?php echo $_GET['e'];?>
								<?php
							}else{
							?><?php
							echo 'issues.php?site=Issues&page='.$new_page.'&time='.$_GET['time'].'';
							}
						}
						
						
					}
				  ?>&order=<?php 
				  if(isset($_GET['order'])){
					  echo $_GET['order'];
				  }else{
					  echo 'date_time';
				  }
				  
				  ?>&by=<?php
					if(isset($_GET['by'])){
						if($_GET['by'] == 'asc'){
							echo 'desc';
						}else{
							echo 'asc';
						}
					}else{
						echo 'asc';
					}
				  ?>">Next</a></li>
				  </ul>
			  </nav>
		<?php
	}
?>

	 */
?>