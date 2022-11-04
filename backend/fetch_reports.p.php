<?php
include 'dbh.p.php';

$sql = "select * from
				`reports`,`equipment`,`location`,`users`
			where
				reports.machine_id = equipment.equipment_id AND
				reports.assigned_user = users.users_id AND
				equipment.location_id = location.location_id
			order by date_created DESC";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)){
    echo $sql;
}else{
   $results = mysqli_query($conn, $sql);

   if($results->num_rows != 0)
	{
        while($row = mysqli_fetch_array($results)){
		?>
	   <tr>
		   <td>R-<?php echo $row['report_id'];?></td>
		   <td> <?php echo $row['task'];?></td>
		   <td> <?php echo $row['equipment_name'];?></td>
		   <td> <?php echo $row['floor'];?></td>
		   <td> <?php
					if(is_null($row['room_number'])){
						echo "--";
					}else{
						echo $row['room_number'];
					}
			?></td>
		   <td> <?php echo $row['report_status'];?></td>
		   <td> <?php echo $row['date_created'];?></td>

			<?php 
			if(!$row['date_submitted'])
            {
					  echo '<td>--</td>';
			}
			else
            {
			?><td>
				<?php echo $row['date_submitted'];?>
			</td><?php
			}?>

			<?php if(is_null($row['for_repair'])){
					  echo '<td>--</td>';
				  }else{
			?><td>
				<?php
					  if($row['for_repair'] == 1){
						  echo 'Yes';
					  }else{
						  echo 'No';
					  }
				?>
			</td><?php
					  }?>

		   <td> <?php echo $row['username'];?></td>
		   <td> 
         <a role="button" href="viewPendingTasks.php?r=<?php echo $row['report_id'];?>&e=<?php echo $row['machine_id'];?>&site=Pending%20Task" class="btn btn-primary">
             <i class="fa fa-eye" aria-hidden="true"></i>
           
         </a>
         <a role="button" href="view_report.php?site=Edit%20Report&id=<?php echo $row['report_id'];?>" class="btn btn-success">
             <i class="fas fa-edit"></i>
         </a>
			   <!--
         		  <a role="button" href="#" class="btn btn-danger">
              <i class="fa fa-trash" aria-hidden="true"></i>
         </a>	
	  
				-->
         
		   </td>
	   </tr>
	   
	   <?php
        }
    }
   else
   {
       ?>
		<tr>
			<td  class="text-center">
				There are no reports
			</td>
		</tr>
		<?php
   }
}
?>