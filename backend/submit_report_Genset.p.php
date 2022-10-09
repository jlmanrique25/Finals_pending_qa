<?php
require_once "../vendor/autoload.php";

use GuzzleHttp\Client;

session_start();
include 'dbh.p.php';

if(isset($_POST['submit']))
{
    $r_id = $_GET['r_id'];
    $e_id = $_GET['e_id'];
	$v1 = $_POST['v1'];
    $v2 = $_POST['v2'];
    $v3 = $_POST['v3'];
	$c1 = $_POST['c1'];
    $c2 = $_POST['c2'];
    $c3 = $_POST['c3'];
    $frequency = $_POST['frequency'];
    $battery_voltage = $_POST['battery_voltage'];
    $running_hours = $_POST['running_hours'];
    $oil_pressure = $_POST['oil_pressure'];
    $oil_temperature = $_POST['oil_temperature'];
    $oil_rotation = $_POST['rotation'];
    $fuel_level = $_POST['fuel_level'];
    $repair_remarks = $_POST['repair_remarks'];
    $other_remarks = $_POST['other_remarks'];
    $report_status = "done";
    $zero = 0;

    date_default_timezone_set('Asia/Hong_Kong');
    $time_submitted = date('Y-m-d h:i:s a', time());

    //initialize connection
    $stmt = mysqli_stmt_init($conn);

    $check1 = isset($_POST['for_repair']) ? "checked" : "unchecked";
    if ($check1 == "unchecked") {
        $for_repair = 0;
    } else {
        $for_repair = $_POST['for_repair'];
    }

    $check2 = isset($_POST['abnormal_sound']) ? "checked" : "unchecked";
    if ($check2 == "unchecked") {
        $abnormal_sound = 0;
    } else {
        $abnormal_sound = $_POST['abnormal_sound'];
    }

    $check3 = isset($_POST['gas_leak']) ? "checked" : "unchecked";
    if ($check3 == "unchecked") {
        $gas_leak = 0;
    } else {
        $gas_leak = $_POST['gas_leak'];
    }


    //check if user submitted the report with issue
    if($for_repair)
    {

        //updates equipment info
        $sql = "UPDATE `equipment` SET `condition` = 'with issues/abnormal reading' WHERE `equipment_id` = ".$e_id."";

        mysqli_query($conn, $sql);


        //update report info
        $sql = "UPDATE `reports` SET `abnormal_data` = 1, report_status='done', date_submitted='".$time_submitted."', for_repair=".$for_repair." WHERE `report_id` = ".$r_id."";
        mysqli_query($conn, $sql);


        //CREATING AN ISSUE


        //check if user submitted report with issue and gas leak and abnormal sound
        if($gas_leak && $abnormal_sound)
        {
            $for_repair = 1;

            //getting report info
            $sql_report = "SELECT * FROM `reports` WHERE report_id = ".$r_id."";
            $result_report = mysqli_query($conn, $sql_report);
            $row_report = mysqli_fetch_assoc($result_report);


            //getting equipment info
            $sql_report = "SELECT * FROM `equipment` WHERE equipment_id = ".$e_id."";
            $result_report = mysqli_query($conn, $sql_report);
            $row_equipment = mysqli_fetch_assoc($result_report);


            //creating an issue report
            $issue = "Abnormal report detected";
            $issue_desc = "BMO technician reported abnormal readings or issues of the Report: ".$row_report["task"].", of equipment: ".$row_equipment['equipment_name'].". BMO techinician also reported abnormal sounds detected and gas leaks. See report: <br /><br /><br /> ".$repair_remarks."";

            $sql = "INSERT INTO `issue`( `machine_id`, `report_id`, `issue`, `issue description`, `submitted_by`, `issue_status`, `date_created`) VALUES (?,?,?,?,?,?,?)";
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, "iissiis",$e_id, $r_id, $issue, $issue_desc,$_SESSION['userId'],$zero,$time_submitted);
            mysqli_stmt_execute($stmt);


            //send email notification to BMO head
            $e_subject = "ANOMALY DETECTED OF REPORT: ".$row_report["task"]."";
            $e_body = '<h3>WARNING EQUIPMENT ISSUE</h3>BMO technician issue detected on report "'.$row_report["task"].'" submitted by '.$_SESSION['username'].' on '.$time_submitted.'<br/><br/>'.$issue_desc.'';


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


            //creating genset report form
            $gensetReadings = "INSERT into `equipment_readings_genset` (`equipment_id`,`report_id`, `voltage_line_1`, `voltage_line_2`, `voltage_line_3`, `current_line_1`, `current_line_2`, `current_line_3`, `frequency`, `battery_voltage`, `running_hours`, `oil_pressure`, `oil_temperature`, `rotation`, `fuel_level`, `abnormal_sound`, `gas_leak`, `for_repair`, `repair_remarks`, `other_remarks`, `date_created`, `assigned_to`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

            if(!mysqli_stmt_prepare($stmt, $gensetReadings)){
                header("Location: ../createStatusReport.php?&error=insert%20genset%20readings");
                exit();
            }else{
                mysqli_stmt_bind_param($stmt, "iidddddddddidiisssssss", $e_id, $r_id, $v1, $v2, $v3, $c1, $c2, $c3, $frequency, $battery_voltage, $running_hours, $oil_pressure, $oil_temperature, $oil_rotation, $fuel_level, $abnormal_sound, $gas_leak, $for_repair, $repair_remarks, $other_remarks, $time_submitted, $_SESSION['userId']);
                mysqli_stmt_execute($stmt);
            }

            //redirect to page
            header('Location:../createStatusReport.php?task='.$r_id.'&e='.$e_id.'&site=Create%20Status%20Report&abnormal=true&gas=true&sound=true');
            exit();
        }


        //check if user submitted report with abnormal sound only
        else if($abnormal_sound)
        {

            //getting report info
            $sql_report = "SELECT * FROM `reports` WHERE report_id = ".$r_id."";
            $result_report = mysqli_query($conn, $sql_report);
            $row_report = mysqli_fetch_assoc($result_report);


            //getting equipment info
            $sql_report = "SELECT * FROM `equipment` WHERE equipment_id = ".$e_id."";
            $result_report = mysqli_query($conn, $sql_report);
            $row_equipment = mysqli_fetch_assoc($result_report);


            //creating an issue report

            //if user also reported a gas leak
            $issue = "Abnormal report detected";
            $issue_desc = "BMO technician reported abnormal readings or issues of the Report: ".$row_report["task"].", of equipment: ".$row_equipment['equipment_name'].". BMO techinician also reported abnormal sounds detected. See report: <br /><br /><br /> ".$repair_remarks."";


            $sql = "INSERT INTO `issue`( `machine_id`, `report_id`, `issue`, `issue description`, `submitted_by`, `issue_status`, `date_created`) VALUES (?,?,?,?,?,?,?)";
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, "iissiis",$e_id, $r_id, $issue, $issue_desc,$_SESSION['userId'],$zero,$time_submitted);
            mysqli_stmt_execute($stmt);


            //send email notification to BMO head
            $e_subject = "ANOMALY DETECTED OF REPORT: ".$row_report["task"]."";
            $e_body = '<h3>WARNING EQUIPMENT ISSUE</h3>BMO technician issue detected on report "'.$row_report["task"].'" submitted by '.$_SESSION['username'].' on '.$time_submitted.'<br/><br/>'.$issue_desc.'';


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

            //creating genset report form
            $gensetReadings = "INSERT into `equipment_readings_genset` (`equipment_id`,`report_id`, `voltage_line_1`, `voltage_line_2`, `voltage_line_3`, `current_line_1`, `current_line_2`, `current_line_3`, `frequency`, `battery_voltage`, `running_hours`, `oil_pressure`, `oil_temperature`, `rotation`, `fuel_level`, `abnormal_sound`, `gas_leak`, `for_repair`, `repair_remarks`, `other_remarks`, `date_created`, `assigned_to`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

            if(!mysqli_stmt_prepare($stmt, $gensetReadings)){
                header("Location: ../createStatusReport.php?&error=insert%20genset%20readings");
                exit();
            }else{
                mysqli_stmt_bind_param($stmt, "iidddddddddidiisssssss", $e_id, $r_id, $v1, $v2, $v3, $c1, $c2, $c3, $frequency, $battery_voltage, $running_hours, $oil_pressure, $oil_temperature, $oil_rotation, $fuel_level, $abnormal_sound, $gas_leak, $for_repair, $repair_remarks, $other_remarks, $time_submitted, $_SESSION['userId']);
                mysqli_stmt_execute($stmt);
            }


            //redirect to page
            header('Location:../createStatusReport.php?task='.$r_id.'&e='.$e_id.'&site=Create%20Status%20Report&abnormal=true&sound=true');
            exit();
        }


        //else if issue was created with gas leaks only
        else
        {
            //getting report info
            $sql_report = "SELECT * FROM `reports` WHERE report_id = ".$r_id."";
            $result_report = mysqli_query($conn, $sql_report);
            $row_report = mysqli_fetch_assoc($result_report);


            //getting equipment info
            $sql_report = "SELECT * FROM `equipment` WHERE equipment_id = ".$e_id."";
            $result_report = mysqli_query($conn, $sql_report);
            $row_equipment = mysqli_fetch_assoc($result_report);


            //creating an issue report

            //if user also reported a gas leak
            $issue = "Abnormal report detected";
            $issue_desc = "BMO technician reported abnormal readings or issues of the Report: ".$row_report["task"].", of equipment: ".$row_equipment['equipment_name'].". BMO techinician also reported Gas leaks. See report: <br /><br /><br /> ".$repair_remarks."";

            $sql = "INSERT INTO `issue`( `machine_id`, `report_id`, `issue`, `issue description`, `submitted_by`, `issue_status`, `date_created`) VALUES (?,?,?,?,?,?,?)";
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, "iissiis",$e_id, $r_id, $issue, $issue_desc,$_SESSION['userId'],$zero,$time_submitted);
            mysqli_stmt_execute($stmt);


            //send email notification to BMO head
            $e_subject = "ANOMALY DETECTED OF REPORT: ".$row_report["task"]."";
            $e_body = '<h3>WARNING EQUIPMENT ISSUE</h3>BMO technician issue detected on report "'.$row_report["task"].'" submitted by '.$_SESSION['username'].' on '.$time_submitted.'<br/><br/>'.$issue_desc.'';


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

            //creating genset report form
            $gensetReadings = "INSERT into `equipment_readings_genset` (`equipment_id`,`report_id`, `voltage_line_1`, `voltage_line_2`, `voltage_line_3`, `current_line_1`, `current_line_2`, `current_line_3`, `frequency`, `battery_voltage`, `running_hours`, `oil_pressure`, `oil_temperature`, `rotation`, `fuel_level`, `abnormal_sound`, `gas_leak`, `for_repair`, `repair_remarks`, `other_remarks`, `date_created`, `assigned_to`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

            if(!mysqli_stmt_prepare($stmt, $gensetReadings)){
                header("Location: ../createStatusReport.php?&error=insert%20genset%20readings");
                exit();
            }else{
                mysqli_stmt_bind_param($stmt, "iidddddddddidiisssssss", $e_id, $r_id, $v1, $v2, $v3, $c1, $c2, $c3, $frequency, $battery_voltage, $running_hours, $oil_pressure, $oil_temperature, $oil_rotation, $fuel_level, $abnormal_sound, $gas_leak, $for_repair, $repair_remarks, $other_remarks, $time_submitted, $_SESSION['userId']);
                mysqli_stmt_execute($stmt);
            }


            //redirect to page
            header('Location:../createStatusReport.php?task='.$r_id.'&e='.$e_id.'&site=Create%20Status%20Report&abnormal=true&sound=true');
            exit();
        }


    }


    //check if user submitted the report with abnormal sound and possibly gas leaks
    else if($abnormal_sound)
    {
        $for_repair = 1;

        //updates equipment info
        $sql = "UPDATE `equipment` SET `condition` = 'with issues/abnormal reading' WHERE `equipment_id` = ".$e_id."";

        mysqli_query($conn, $sql);

        //getting report info
        $sql_report = "SELECT * FROM `reports` WHERE report_id = ".$r_id."";
        $result_report = mysqli_query($conn, $sql_report);
        $row_report = mysqli_fetch_assoc($result_report);


        //getting equipment info
        $sql_report = "SELECT * FROM `equipment` WHERE equipment_id = ".$e_id."";
        $result_report = mysqli_query($conn, $sql_report);
        $row_equipment = mysqli_fetch_assoc($result_report);


        //creating an issue report

        //if user also reported a gas leak
        if($gas_leak)
        {
            $issue = "Abnormal report detected";
            $issue_desc = "BMO technician reported abnormal readings or issues of the Report: ".$row_report["task"].", of equipment: ".$row_equipment['equipment_name'].". BMO techinician also reported abnormal sounds detected and gas leaks. See report: <br /><br /><br /> ".$repair_remarks."";
        }
        else
        {
            $issue = "Abnormal report detected";
            $issue_desc = "BMO technician reported abnormal readings or issues of the Report: ".$row_report["task"].", of equipment: ".$row_equipment['equipment_name'].". BMO techinician also reported abnormal sounds detected. See report: <br /><br /><br /> ".$repair_remarks."";
        }


        $sql = "INSERT INTO `issue`( `machine_id`, `report_id`, `issue`, `issue description`, `submitted_by`, `issue_status`, `date_created`) VALUES (?,?,?,?,?,?,?)";
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "iissiis",$e_id, $r_id, $issue, $issue_desc,$_SESSION['userId'],$zero,$time_submitted);
        mysqli_stmt_execute($stmt);


        //send email notification to BMO head
        $e_subject = "ANOMALY DETECTED OF REPORT: ".$row_report["task"]."";
        $e_body = '<h3>WARNING EQUIPMENT ISSUE</h3>BMO technician issue detected on report "'.$row_report["task"].'" submitted by '.$_SESSION['username'].' on '.$time_submitted.'<br/><br/>'.$issue_desc.'';


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


        //creating genset report form
        $gensetReadings = "INSERT into `equipment_readings_genset` (`equipment_id`,`report_id`, `voltage_line_1`, `voltage_line_2`, `voltage_line_3`, `current_line_1`, `current_line_2`, `current_line_3`, `frequency`, `battery_voltage`, `running_hours`, `oil_pressure`, `oil_temperature`, `rotation`, `fuel_level`, `abnormal_sound`, `gas_leak`, `for_repair`, `repair_remarks`, `other_remarks`, `date_created`, `assigned_to`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        if(!mysqli_stmt_prepare($stmt, $gensetReadings)){
            header("Location: ../createStatusReport.php?&error=insert%20genset%20readings");
            exit();
        }else{
            mysqli_stmt_bind_param($stmt, "iidddddddddidiisssssss", $e_id, $r_id, $v1, $v2, $v3, $c1, $c2, $c3, $frequency, $battery_voltage, $running_hours, $oil_pressure, $oil_temperature, $oil_rotation, $fuel_level, $abnormal_sound, $gas_leak, $for_repair, $repair_remarks, $other_remarks, $time_submitted, $_SESSION['userId']);
            mysqli_stmt_execute($stmt);
        }

        //redirect to page
        header('Location:../createStatusReport.php?task='.$r_id.'&e='.$e_id.'&site=Create%20Status%20Report&abnormal=true&sound=true');
        exit();
    }


    //check if user submitted the report with gas leak
    else if($gas_leak)
    {
        $for_repair = 1;

        //updates equipment info
        $sql = "UPDATE `equipment` SET `condition` = 'with issues/abnormal reading' WHERE `equipment_id` = ".$e_id."";

        mysqli_query($conn, $sql);

        //getting report info
        $sql_report = "SELECT * FROM `reports` WHERE report_id = ".$r_id."";
        $result_report = mysqli_query($conn, $sql_report);
        $row_report = mysqli_fetch_assoc($result_report);


        //getting equipment info
        $sql_report = "SELECT * FROM `equipment` WHERE equipment_id = ".$e_id."";
        $result_report = mysqli_query($conn, $sql_report);
        $row_equipment = mysqli_fetch_assoc($result_report);


        //creating an issue report

        //if user also reported a gas leak
        $issue = "Abnormal report detected";
        $issue_desc = "BMO technician reported abnormal readings or issues of the Report: ".$row_report["task"].", of equipment: ".$row_equipment['equipment_name'].". BMO techinician also reported Gas leaks. See report: <br /><br /><br /> ".$repair_remarks."";

        $sql = "INSERT INTO `issue`( `machine_id`, `report_id`, `issue`, `issue description`, `submitted_by`, `issue_status`, `date_created`) VALUES (?,?,?,?,?,?,?)";
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "iissiis",$e_id, $r_id, $issue, $issue_desc,$_SESSION['userId'],$zero,$time_submitted);
        mysqli_stmt_execute($stmt);


        //send email notification to BMO head
        $e_subject = "ANOMALY DETECTED OF REPORT: ".$row_report["task"]."";
        $e_body = '<h3>WARNING EQUIPMENT ISSUE</h3>BMO technician issue detected on report "'.$row_report["task"].'" submitted by '.$_SESSION['username'].' on '.$time_submitted.'<br/><br/>'.$issue_desc.'';


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


        //creating genset report form
        $gensetReadings = "INSERT into `equipment_readings_genset` (`equipment_id`,`report_id`, `voltage_line_1`, `voltage_line_2`, `voltage_line_3`, `current_line_1`, `current_line_2`, `current_line_3`, `frequency`, `battery_voltage`, `running_hours`, `oil_pressure`, `oil_temperature`, `rotation`, `fuel_level`, `abnormal_sound`, `gas_leak`, `for_repair`, `repair_remarks`, `other_remarks`, `date_created`, `assigned_to`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        if(!mysqli_stmt_prepare($stmt, $gensetReadings)){
            header("Location: ../createStatusReport.php?&error=insert%20genset%20readings");
            exit();
        }else{
            mysqli_stmt_bind_param($stmt, "iidddddddddidiisssssss", $e_id, $r_id, $v1, $v2, $v3, $c1, $c2, $c3, $frequency, $battery_voltage, $running_hours, $oil_pressure, $oil_temperature, $oil_rotation, $fuel_level, $abnormal_sound, $gas_leak, $for_repair, $repair_remarks, $other_remarks, $time_submitted, $_SESSION['userId']);
            mysqli_stmt_execute($stmt);
        }

        //redirect to page
        header('Location:../createStatusReport.php?task='.$r_id.'&e='.$e_id.'&site=Create%20Status%20Report&abnormal=true&sound=true');
        exit();
    }


    //if user submitted the report with no issue at all
    else
    {
        // update report status to done
        $sql = "UPDATE `reports` SET `date_submitted` = '".$time_submitted."',`report_status` = '".$report_status."'  WHERE `report_id` = ".$r_id."";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)){
            echo 'error updating reports database';
        }else{
            mysqli_query($conn, $sql);
            //echo 'reports date submitted set';
        }

        $stmt = mysqli_stmt_init($conn);

        //creating genset report form
        $gensetReadings = "INSERT into `equipment_readings_genset` (`equipment_id`,`report_id`, `voltage_line_1`, `voltage_line_2`, `voltage_line_3`, `current_line_1`, `current_line_2`, `current_line_3`, `frequency`, `battery_voltage`, `running_hours`, `oil_pressure`, `oil_temperature`, `rotation`, `fuel_level`, `abnormal_sound`, `gas_leak`, `for_repair`, `repair_remarks`, `other_remarks`, `date_created`, `assigned_to`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        if(!mysqli_stmt_prepare($stmt, $gensetReadings)){
            header("Location: ../createStatusReport.php?&error=insert%20genset%20readings");
            exit();
        }else{
            mysqli_stmt_bind_param($stmt, "iidddddddddidiisssssss", $e_id, $r_id, $v1, $v2, $v3, $c1, $c2, $c3, $frequency, $battery_voltage, $running_hours, $oil_pressure, $oil_temperature, $oil_rotation, $fuel_level, $abnormal_sound, $gas_leak, $for_repair, $repair_remarks, $other_remarks, $time_submitted, $_SESSION['userId']);
            mysqli_stmt_execute($stmt);
        }


        if(!mysqli_stmt_prepare($stmt, $sql)){
            //header('Location:../users.php?updatenotsuccessful&page=1&site=Users');
            exit();
        }else{
            $result = mysqli_query($conn,$sql);
            header('Location:../createStatusReport.php?task='.$r_id.'&e='.$e_id.'&site=Create%20Status%20Report&data=normal');
            exit();
        }
    }






}
