<?php
include 'dbh.p.php';
$sql_pages = "SELECT count(*) as total FROM `users`WHERE role != 'Head' ORDER BY username LIMIT ".$min.", 10";
$stmt = mysqli_stmt_init($conn);
	
	if(!mysqli_stmt_prepare($stmt, $sql_pages)){
		echo 'error counting pages';
	}else{
		$result = mysqli_query($conn, $sql_pages);
		$row_count = mysqli_fetch_assoc($result);
		
		$pages = ceil($row_count['total']/10);
		
		?>
			<nav aria-label="Page navigation example">
				  <ul class="pagination justify-content-center">
				  <li class="page-item"><a class="page-link" href="<?php
					if(($_GET['page']-1) == 0){
						echo '#';
					}else{
						$new_page = $_GET['page'] - 1;
						echo 'equipment.php?site=Reports&page='.$new_page.'&time='.$_GET['time'].'';
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
					?>><a class="page-link" href="equipment.php?page=<?php echo $i;?>&site=Reports&time=<?php echo $_GET['time']?>"><?php echo $i;
					?></a></li>
					
			  
			  <?php
		}
		?>
			<li class="page-item"><a class="page-link" href="<?php
					if(($_GET['page']+1) > $pages){
						echo '#';
					}else{
						$new_page = $_GET['page'] + 1;
						echo 'equipment.php?site=Reports&page='.$new_page.'&time='.$_GET['time'].'';
					}
				  ?>">Next</a></li>
				  </ul>
			  </nav>
		<?php
	}
?>
