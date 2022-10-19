<?php
include 'dbh.p.php';

$sql = "SELECT report_id, reports.machine_id, reports.task, reports.date_created, reports.task_due, reports.date_submitted, reports.assigned_user, reports.report_status, equipment.equipment_id, equipment.equipment_name, equipment.location_id, location.location_id, location.floor,location.room_number, users.users_id, users.username
			FROM `reports`, `users`,`location`,`equipment`
			WHERE users.users_id = ".$_SESSION['userId']." AND reports.assigned_user = ".$_SESSION['userId']." AND equipment.equipment_id = reports.machine_id AND equipment.location_id = location.location_id AND  reports.report_status = 'done'
			ORDER BY reports.date_created DESC";


$stmt = mysqli_stmt_init($conn);

$result = mysqli_query($conn, $sql);

if($result->num_rows > 0){
    while($row = mysqli_fetch_array($result)){
?>
<tr role="button" data-href="createStatusReport.php?task=<?php echo $row['report_id'];?>&e=<?php echo $row['machine_id'];?>&site=Create%20Status%20Report">
    <td>
        <?php echo $row['task'];?>
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
        <?php echo $row['task_due'];?>
    </td>
    <td>
        <?php echo $row['date_submitted'];?>
    </td>
    <td>
        <?php echo $row['report_status'];?>
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



