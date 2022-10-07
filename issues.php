<head>
	<title>Issues</title>
</head>
<?php
	session_start();
	include 'header.php';
?>

	<div class="container py-4">

    <!--
	 
 

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
					}else if($_GET['floor'] == '1st floor'){
						echo 'active';
					}
                    ?> href="issues.php?site=Issues&page=1&floor=1stfloor">1st Floor</a>

					<a  class="dropdown-item" 
					<?php
					if(!isset($_GET['floor'])){
						echo 'active';
					}else if($_GET['floor'] == '2nd floor'){
						echo 'active';
					}
                    ?> href="issues.php?site=Issues&page=1&floor=2ndfloor">2nd Floor</a>

					<a  class="dropdown-item" 
					<?php
					if(!isset($_GET['floor'])){
						echo 'active';
					}else if($_GET['floor'] == '3rd floor'){
						echo 'active';
					}
                    ?> href="issues.php?site=Issues&page=1&floor=3rdfloor">3rd Floor</a>

					<a  class="dropdown-item" 
					<?php
					if(!isset($_GET['floor'])){
						echo 'active';
					}else if($_GET['floor'] == '4th floor'){
						echo 'active';
					}
                    ?> href="issues.php?site=Issues&page=1&floor=4thfloor">4th Floor</a>
					
					<a  class="dropdown-item" 
					<?php
					if(!isset($_GET['floor'])){
						echo 'active';
					}else if($_GET['floor'] == '5th floor'){
						echo 'active';
					}
                    ?> href="issues.php?site=Issues&page=1&floor=5thfloor">5th Floor</a>
					
					<a  class="dropdown-item" 
					<?php
					if(!isset($_GET['floor'])){
						echo 'active';
					}else if($_GET['floor'] == '6th floor'){
						echo 'active';
					}
                    ?> href="issues.php?site=Issues&page=1&floor=6thfloor">6th Floor</a>
					
					<a  class="dropdown-item" 
					<?php
					if(!isset($_GET['floor'])){
						echo 'active';
					}else if($_GET['floor'] == '7th floor'){
						echo 'active';
					}
                    ?> href="issues.php?site=Issues&page=1&floor=7thfloor">7th Floor</a>
					
					<a  class="dropdown-item" 
					<?php
					if(!isset($_GET['floor'])){
						echo 'active';
					}else if($_GET['floor'] == '8th floor'){
						echo 'active';
					}
                    ?> href="issues.php?site=Issues&page=1&floor=8thfloor">8th Floor</a>
					
					<a  class="dropdown-item" 
					<?php
					if(!isset($_GET['floor'])){
						echo 'active';
					}else if($_GET['floor'] == '9th floor'){
						echo 'active';
					}
                    ?> href="issues.php?site=Issues&page=1&floor=9thfloor">9th Floor</a>
					
					<a  class="dropdown-item" 
					<?php
					if(!isset($_GET['floor'])){
						echo 'active';
					}else if($_GET['floor'] == 'floor'){
						echo 'active';
					}
                    ?> href="issues.php?site=Issues&page=1&floor=10th">10th Floor</a>
					
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
					}else if($_GET['status'] == '1'){
						echo 'active';
					}
                    ?> href="issues.php?site=Issues&page=1&status=1">Resolved</a>
					
					<a class="dropdown-item" 
					<?php
					if(!isset($_GET['status'])){
						echo 'active';
					}else if($_GET['status'] == '0'){
						echo 'active';
					}
                    ?> href="issues.php?site=Issues&page=1&status=0">Not Resolved</a>

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
                    ?> href="issues.php?site=Issues&page=1&equipment=HVAC">HVAC</a>
					
					<a class="dropdown-item" 
					<?php
					if(!isset($_GET['machine'])){
						echo 'active';
					}else if($_GET['machine'] == 'Genset'){
						echo 'active';
					}
                    ?> href="issues.php?site=Issues&page=1&equipment=Genset">Generator Set</a>

				  </div>
				</div>
			</div>
			
			<div class="col p-2">
				<form action="backend/date.p.php?site=issue" method="post">
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
			  " href="issues.php?site=Issues&page=1&time=day">Daily</a>
			  <a type="button" class="btn btn-info <?php
                                                   if(isset($_GET['time'])){
                                                       if($_GET['time'] == 'week'){
                                                           echo 'active';
                                                       }
                                                   }
                                                   ?>" href="issues.php?site=Issues&page=1&time=week">This Week</a>
			  <a type="button" class="btn btn-info <?php
                                                   if(isset($_GET['time'])){
                                                       if($_GET['time'] == 'month'){
                                                           echo 'active';
                                                       }
                                                   }
                                                   ?>" href="issues.php?site=Issues&page=1&time=month">This Month</a>
				
				<a type="button" class="btn btn-info <?php
                                                     if(isset($_GET['time'])){
                                                         if($_GET['time'] == 'year'){
                                                             echo 'active';
                                                         }
                                                     }
                                                     ?>" href="issues.php?site=Issues&page=1&time=year">This Year</a>
			</div>
			</div>
			
			
			<div class="col p-2">
				<form class="form-inline" method="POST">
					<input class="form-control mr-sm-2 w-100" type="text" placeholder="Search" name="search">
					<input type="submit" name="submit">
				</form>
			</div>
			
			
			
			
        		</div>	
		</div> -->
	
		
		
    <!--<table class="table rounded-3 shadow-lg table-hover mb-5" id="issues_table"> -->
    <input type="button" class="btn btn-secondary" onclick="history.back()" value="<< Back" /><br /><br />
    <h2>
        <text style="font-weight:bold;"> Issue reports </text>
    </h2>
    <i class="bi bi-info-circle-fill"></i>
    <br />
    <table id="issues_table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Issue</th>
                <th scope="col">Equipment</th>
                <th scope="col">Status</th>
                <th scope="col">Date Created</th>
                <th scope="col">Date Due</th>
                <th scope="col">Date Resolved</th>
                <th scope="col">Assignee</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>

            <!---
        			<?php
                    include 'backend/dropdown_filter_status.p.php'; 
                    ?>
		<?php
        include 'backend/dropdown_filter_equip.p.php';
		?>
			-->


            
            <?php
			include 'backend/fetch_issues.p.php'
            ?>
        </tbody>
    </table>

</div>

<script src="tablefilter/tablefilter.js"></script>

<script data-config>
	var filtersConfig = {
		base_path: 'tablefilter/',
		responsive: true,
		paging: {
          results_per_page: ['Records: ', [10, 25, 50, 100]]
        },
		col_2: 'select',
		col_6: 'select',
		alternate_rows: true,
		rows_counter: true,
		sticky_headers: true,
		btn_reset: true,
		loader: true,
		status_bar: true,
		mark_active_columns: true,
		highlight_keywords: true,

		col_types: ['string',
					'string',
					'string',
					'string',
					{ type: 'date', locale: 'en', format: '{dd}-{MM}-{yyyy|yy}' },
					{ type: 'date', locale: 'en', format: '{dd}-{MM}-{yyyy|yy}' },
					'string',
					'string'
		],
		watermark: ['(e.g. Not functioning)', '(e.g. Generator Set 1)', '', '(e.g. >2022-01-01)', '(e.g. >2022-01-01)', '(e.g. >2022-01-01)',],
		msg_filter: 'Filtering...',
        extensions:[{ name: 'sort' }]
	};

	var tf = new TableFilter('issues_table', filtersConfig);
    tf.init();
</script>

	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>