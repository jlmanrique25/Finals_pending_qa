<?php
	include 'dbh.p.php';
	
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
							echo 'class="page-item active"';}
						}else{
							if( 1 == $i){
							echo 'class="page-item active"';}
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