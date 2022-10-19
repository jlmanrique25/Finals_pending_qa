<?php
include 'dbh.p.php';

$sql = "SELECT
            issue.issue_id,
            issue.machine_id,
            issue.issue,
            issue.issue_status,
            issue.assigned_to,
            issue.date_created,
            issue.date_due,
            issue.date_issue_resolved,
            equipment.equipment_id,
            equipment.equipment_name,
            equipment.location_id,
            location.location_id,
            location.floor,
            location.room_number,
            users.users_id,
            users.username
	FROM `issue`, `users`,`location`,`equipment`
	WHERE users.users_id = ".$_SESSION['userId']." AND issue.assigned_to = ".$_SESSION['userId']." AND equipment.equipment_id = issue.machine_id AND equipment.location_id = location.location_id AND issue.issue_status = 1
	ORDER BY issue.date_created DESC";




$stmt = mysqli_stmt_init($conn);

$result = mysqli_query($conn, $sql);

if($result->num_rows > 0){
    while($row = mysqli_fetch_array($result)){
?>

<tr role="button" data-href="issue_report.php?i_id=<?php echo $row['issue_id'];?>&<?php echo $row['equipment_name'];?>&site=Issue%20Report">
    <td>
        <?php echo $row['issue'];?>
    </td>
    <td>
        <?php echo $row['equipment_name'];?>
    </td>
    <td>
        <?php echo $row['floor'];?>
    </td>
    <td>
        <?php echo $row['room_number'];?>
    </td>
    <td>
        <?php echo $row['date_created'];?>
    </td>
    <td>
        <?php echo $row['date_due'];?>
    </td>
    <td>
        <?php
        if(!is_null($row['date_issue_resolved'])){
            echo $row['date_issue_resolved'];
        }else{
            echo '--';
        }
        ?>
    </td>
    <td>
        <?php
        if($row['issue_status'] == 0){
            echo 'Unresolved';
        }else{
            echo 'Resolved';
        }?>
    </td>
</tr>
<?php
    }
}else{
?>
<tr>
    <td class="text-center"></td>
    <td class="text-center"></td>
    <td class="text-center"></td>
    <td class="text-center"> There are no reports to be done.</td>
    <td class="text-center"></td>
    <td class="text-center"></td>
    <td class="text-center"></td>
    <td class="text-center"></td>
</tr>
<?php
}



