<?php
require_once "../vendor/autoload.php";

use GuzzleHttp\Client;

session_start();
include 'dbh.p.php';

if(isset($_POST['submit']))
{
    $r_id = $_GET['r_id'];
    $e_id = $_GET['e_id'];
	$volt = $_POST['volt'];
	$pressure = $_POST['pressure'];
	$temp = $_POST['temp'];
    if($_POST['repair_remarks'] == ''){
        $repair_remarks = 'N/A';
    }else{
        $repair_remarks = $_POST['repair_remarks'];
    }

    $other_remarks = $_POST['other_remarks'];
    $report_status = "done";
    if($_POST['for_repair'] != NULL){
        $for_repair = $_POST['for_repair'];
    }else{
        $for_repair = 0;
    }
    $zero = 0;


    date_default_timezone_set('Asia/Hong_Kong');
    $time_submitted = date('Y-m-d h:i:s a', time());

    $stmt = mysqli_stmt_init($conn);


    //FIRST CHECK IF DATA SUBMITTED IS ABNORMAL OR NOT
    $sql_monitor = "SELECT * FROM `equipment_monitoring` WHERE asset = 'HVAC'";

    if(!mysqli_stmt_prepare($stmt, $sql_monitor)){
		echo 'error connecting to the database equipment monitoring';
	}else{
		$result_monitor = mysqli_query($conn, $sql_monitor);
		$row_monitor = mysqli_fetch_assoc($result_monitor);
	}


    //checking if user submitted a report about the machine with an issue
    if($for_repair){
        //update equipment condition to 'with issues/abnormal reading'
        $sql = "UPDATE `equipment` SET `condition` = 'with issues/abnormal reading' WHERE `equipment_id` = ".$e_id."";

        mysqli_query($conn, $sql);

        //update report to abnormal data found and submission
        $sql = "UPDATE `reports` SET `abnormal_data` = 1, report_status='done', date_submitted='".$time_submitted."', for_repair=".$for_repair." WHERE `report_id` = ".$r_id."";
        mysqli_query($conn, $sql);

        //email properties
        $sql_id= "SELECT `AUTO_INCREMENT`
                    FROM  INFORMATION_SCHEMA.TABLES
                    WHERE TABLE_SCHEMA = 'final_pending'
                    AND   TABLE_NAME   = 'issue'";
        $results_id = mysqli_query($conn, $sql_id);
        $row_id = mysqli_fetch_array($results_id);

        //create an issue for the abnormal data
        $sql_report = "SELECT * FROM `reports` WHERE report_id = ".$r_id."";
        $result_report = mysqli_query($conn, $sql_report);
        $row_report = mysqli_fetch_assoc($result_report);

        $issue = 'Abnormal Reading of temperature';

        $sql = "INSERT INTO `issue`( `machine_id`, `report_id`, `issue`, `issue description`, `submitted_by`, `issue_status`, `date_created`) VALUES (?,?,?,?,?,?,?)";
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "iissiis",$e_id, $r_id, $issue, $repair_remarks,$_SESSION['userId'],$zero,$time_submitted);
        mysqli_stmt_execute($stmt);

        //insert data into equipment readings
        $sql = "INSERT into `equipment_readings_aircon` (`equipment_id`,`report_id`, `volt`, `pressure`, `temp`, `for_repair`, `repair_remarks`, `other_remarks`, `date_created`, `assigned_to`) VALUES (?,?,?,?,?,?,?,?,?,?)";
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "iiiidsssss", $e_id, $r_id, $volt, $pressure, $temp, $for_repair, $repair_remarks, $other_remarks, $time_submitted, $_SESSION['userId']);
        mysqli_stmt_execute($stmt);


        $e_subject = "ANOMALY DETECTED OF REPORT: ".$row_report["task"]."";
        $e_body = '<h3>WARNING ABNORMAL READING OF EQUIPMENT</h3>Abnormal reading of temperature on report "'.$row_report["task"].'" submitted by '.$_SESSION['username'].' on '.$time_submitted.' <a href="http://localhost:8080/Finals_pending/assign_new_issue.php?site=Assign%20New%20Issue&id='.$row_id['id'].'">you can check out the report here</a><br><h3>User report</h3>'.$repair_remarks.'';

        //insert guzzler mailer

        $body = [
            'Messages' => [
                [
                'From' => [
                    'Email' => "jasffer.test@gmail.com",
                    'Name' => "KEOMS"
                ],
                'To' => [
                    [
                        'Email' => "jasfferp@gmail.com",
                        'Name' => "Jasffer"
                    ]
                ],
                'Subject' => $e_subject,
                'HTMLPart' => $e_body
                ]
            ]
        ];

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://api.mailjet.com/v3.1/',
        ]);

        $response = $client->request('POST', 'send', [
            'json' => $body,
            'auth' => ['748818f4f48b3ab03f1488de59e8ef27', 'af0625c3712d54db4a4426b8a1045826']
        ]);

        if($response->getStatusCode() == 200) {
            $body = $response->getBody();
            $response = json_decode($body);
            if ($response->Messages[0]->Status == 'success') {
                echo "Email sent successfully.";
            }
        }


        //redirect to page
        header('Location:../createStatusReport.php?task='.$r_id.'&e='.$e_id.'&site=Create%20Status%20Report&abnormal=true');
        exit();

    }

    //determining if abnormal reading
    else if($temp < $row_monitor['lower_bound'] or $temp > $row_monitor['upper_bound'])
    {
        //update equipment condition to 'with issues/abnormal reading'
        $sql = "UPDATE `equipment` SET `condition` = 'with issues/abnormal reading' WHERE `equipment_id` = ".$e_id."";

        mysqli_query($conn, $sql);

        //update report to abnormal data found and submission
        $sql = "UPDATE `reports` SET `abnormal_data` = 1, report_status='done', date_submitted='".$time_submitted."', for_repair=".$for_repair." WHERE `report_id` = ".$r_id."";
        mysqli_query($conn, $sql);

        //create an issue for the abnormal data
        $sql_report = "SELECT * FROM `reports` WHERE report_id = ".$r_id."";
        $result_report = mysqli_query($conn, $sql_report);
        $row_report = mysqli_fetch_assoc($result_report);

        $issue = 'Abnormal Reading of temperature';
        $issue_desc = 'Abnormal reading of temperature on report "'.$row_report["task"].'" submitted by '.$_SESSION['username'].' on '.$time_submitted.'';


        //getting the id of the ticket
        $sql_ticket ="SELECT `AUTO_INCREMENT` as id
            FROM  INFORMATION_SCHEMA.TABLES
            WHERE TABLE_SCHEMA = 'final_pending'
            AND   TABLE_NAME   = 'issue'";
        $ticket_results = mysqli_query($conn, $sql_ticket);
		$ticket = mysqli_fetch_assoc($ticket_results);


        $sql = "INSERT INTO `issue`( `machine_id`, `report_id`, `issue`, `issue description`, `submitted_by`, `issue_status`, `date_created`) VALUES (?,?,?,?,?,?,?)";
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "iissiis",$e_id, $r_id, $issue, $issue_desc,$_SESSION['userId'],$zero,$time_submitted);
        mysqli_stmt_execute($stmt);

        //add the instance to the date table


        //insert data into equipment readings
        $sql = "INSERT into `equipment_readings_aircon` (`equipment_id`,`report_id`, `volt`, `pressure`, `temp`, `for_repair`, `repair_remarks`, `other_remarks`, `date_created`, `assigned_to`) VALUES (?,?,?,?,?,?,?,?,?,?)";
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "iiiidsssss", $e_id, $r_id, $volt, $pressure, $temp, $for_repair, $repair_remarks, $other_remarks, $time_submitted, $_SESSION['userId']);
        mysqli_stmt_execute($stmt);

        //email properties
        $e_subject = "ANOMALY DETECTED OF REPORT: ".$row_report["task"]."";
        $e_body = '<h3>WARNING ABNORMAL READING OF EQUIPMENT - Issue #'.$ticket['id'].'</h3>Abnormal reading of temperature on report "'.$row_report["task"].'" submitted by '.$_SESSION['username'].' on '.$time_submitted.'  <a href="http://localhost:8080/Finals_pending/assign_new_issue.php?site=Assign%20New%20Issue&id='.$ticket['id'].'">you can check out the issue #'.$ticket['id'].' here</a><br><h3>User report</h3>'.$repair_remarks.'';

        //insert guzzler mailer

        $body = [
            'Messages' => [
                [
                'From' => [
                    'Email' => "jasffer.test@gmail.com",
                    'Name' => "KEOMS"
                ],
                'To' => [
                    [
                        'Email' => "jasfferp@gmail.com",
                        'Name' => "Jasffer"
                    ]
                ],
                'Subject' => $e_subject,
                'HTMLPart' => $e_body
                ]
            ]
        ];

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://api.mailjet.com/v3.1/',
        ]);

        $response = $client->request('POST', 'send', [
            'json' => $body,
            'auth' => ['748818f4f48b3ab03f1488de59e8ef27', 'af0625c3712d54db4a4426b8a1045826']
        ]);

        if($response->getStatusCode() == 200) {
            $body = $response->getBody();
            $response = json_decode($body);
            if ($response->Messages[0]->Status == 'success') {
                echo "Email sent successfully.";
            }
        }


        //redirect to page
        header('Location:../createStatusReport.php?task='.$r_id.'&e='.$e_id.'&site=Create%20Status%20Report&abnormal=true');
        exit();
    }

    //IF DATA IS NORMAL
    else
    {
        //update report
        $sql = "UPDATE `reports` SET `abnormal_data` = 0, report_status='done', date_submitted='".$time_submitted."', for_repair=".$for_repair." WHERE `report_id` = ".$r_id."";
        mysqli_query($conn, $sql);

        //insert data into equipment readings
        $sql = "INSERT into `equipment_readings_aircon` (`equipment_id`,`report_id`, `volt`, `pressure`, `temp`, `for_repair`, `repair_remarks`, `other_remarks`, `date_created`, `assigned_to`) VALUES (?,?,?,?,?,?,?,?,?,?)";
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "iiiidsssss", $e_id, $r_id, $volt, $pressure, $temp, $for_repair, $repair_remarks, $other_remarks, $time_submitted, $_SESSION['userId']);
        mysqli_stmt_execute($stmt);

        //redirect to page
        header('Location:../createStatusReport.php?task='.$r_id.'&e='.$e_id.'&site=Create%20Status%20Report&data=normal');
        exit();
    }


    //IF ABNORMAL CREATE AN ISSUE


    //IF DATA SUBMITTED IS ABNORMAL NOTIFY BMO ADMINS


    //CREATE AN INSTANCE IN THE DATE DATABASE THAT THE SYSTEM IDENTIFIED AN ABNORMAL DATA


    //INSERT DATA IN AIRCON READINGS TABLE


    //UPDATE DATA IN THE REPORTS TABLE

    //echo $r_id. $e_id. $volt.$pressure.$temp.$repair_remarks.$other_remarks.$report_status.$time_submitted.$for_repair.$_SESSION['username'];
}
else
{
    header('Location:../index.php');
    exit();
}
