<?php
include 'dbh.p.php';

$sql = "SELECT * FROM `issue`, `equipment`, `users`, location
		WHERE 	issue.machine_id = equipment.equipment_id AND
        		equipment.location_id = location.location_id AND
				assigned_to = users.users_id
			ORDER by date_created desc";
$stmt = mysqli_stmt_init($conn);

if(!mysqli_stmt_prepare($stmt, $sql)){
    echo $sql;
}else{
    $results = mysqli_query($conn, $sql);

    if($results->num_rows != 0)
	{
        while($row = mysqli_fetch_array($results)){
?>
<tr >
    <td>
        I-<?php echo $row['issue_id'];?>
    </td><td>
        <?php echo $row['issue'];?>
    </td>
    <td>
        <?php echo $row['equipment_name'];?>
    </td><td>
        <?php echo $row['floor'];?>
    </td>

    <?php if(is_null($row['issue_status'])){
              echo '<td>--</td>';
          }else{
    ?><td>
        <?php
              if($row['issue_status'] == 1){
                  echo 'Done';
              }else{
                  echo 'Not Resolved';
              }
        ?>
    </td><?php
          }?>
    <td>
        <?php echo $row['date_created'];?>
    </td>
    <td>
        <?php echo $row['date_due'];?>
    </td>
    <?php if(!$row['date_issue_resolved']){
              echo '<td>--</td>';
          }else{
    ?><td>
        <?php echo $row['date_issue_resolved'];?>
    </td><?php
          }?>

    <?php
            if(is_null($row['username'])){
    ?>
    <td>
        <a href="createIssue.php?site=Create issue log" class="btn btn-success" role="button" aria-pressed="true">Create issue log</a>
    </td>
    <?php
            }else{
    ?>
    <td>
        <?php echo $row['username'];?>
    </td>
    <td>
        <a role="button" href="viewPendingIssue.php?site=Issue%20Report&i_id=<?php echo $row['issue_id'];?>" class="btn btn-primary">
            <i class="fa fa-eye" aria-hidden="true"></i>

        </a>
        <a role="button" href="view_issue.php?site=Edit%20Report&id=<?php echo $row['issue_id'];?>" class="btn btn-success">
            <i class="fas fa-edit"></i>
        </a>
    </td>
    <?php
					}
    ?>

</tr>

<?php
        }
    }
    else
    {
?>
<tr>
    <td class="text-center">
        
    </td>
    <td class="text-center">
        
    </td>
    <td class="text-center">
        
    </td>
    <td class="text-center">
        There are no issues
    </td>
    <td class="text-center">
        
    </td>
    <td class="text-center">
        
    </td>
    <td class="text-center">
        
    </td>
    <td class="text-center">
        
    </td>
    
</tr>
<?php
   }
}
?>