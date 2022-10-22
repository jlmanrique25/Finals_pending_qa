<?php
require_once "../vendor/autoload.php";

use GuzzleHttp\Client;
include 'dbh.p.php';
session_start();


$reason = $_POST['reason'];
$sql = "DELETE FROM `issue` WHERE issue_id = ".$_GET['id']."";
$stmt = mysqli_stmt_init($conn);

$sql_i = "SELECT * FROM `issue` WHERE issue_id =".$_GET['id']."";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $sql_i);
$results = mysqli_query($conn, $sql_i);
$row = mysqli_fetch_array($results);

$sql_u = "SELECT username FROM `users` WHERE users_id = ".$row['submitted_by']."";
$results_u = mysqli_query($conn, $sql_u);
$row_u = mysqli_fetch_array($results_u);

$e_subject = "Issue #".$_GET['id']." - ".$row['issue']." deleted";
$e_body = 'User '.$_SESSION['username'].' Deleted the issue. Reason stated below:<br/><br/>'.$reason.'';

echo $e_subject.$e_body;

//Guzzler Email
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


mysqli_query($conn, $sql);

$sql = "DELETE FROM dates WHERE report_issue_id = ".$_GET['id']." AND date_identity = 'issue' and date_type = 'created'";


mysqli_query($conn, $sql);

header("Location: ../n_issues.php?site=New%20Issues&page=1");
exit();
