<?php

//IF THE USER TRIES TO ACCESS THE SITE ILLEGALLY

if(! isset($_GET['id']))
{
    header('Location: reports.php?site=Reports&page=1&time=day#');
    exit();
}

//IF THE USER ACCESSED THE SITE THROUGH THE LINK PROVIDED

else
{
    include 'dbh.p.php';


    //IF THE USER ONLY WANTS TO VIEW THE REPORT

    if(isset($_GET['view']) && $_GET['view'] == 'true')         //THIS WILL VIEW THE DATA THAT WAS INPUTTED IN THE REPORT
    {


        echo 'you are in the view only of the issue status';


    }

    //IF THE USER WANTS TO EDIT THE REPORT

    else                                //THIS WILL SHOW THE ASSIGN TASK PAGE BUT WITH REPORTS AND WITH REPORT VALUES
    {


        $sql = 'SELECT issue, `issue description` as issue_desc, date_created, issue_status, date_due, machine_id, assigned_to FROM `issue` WHERE issue_id = '.$_GET['id'].'';
        $stmt = mysqli_stmt_init($conn);


        // CHECKS IF THE DATABASE CAN BE CONNECTED
        if(!mysqli_stmt_prepare($stmt,$sql))
        {
            echo 'error connecting to database in view issue page backend';
            echo $sql;
        }


        // IF CONNECTION TO THE DATABASE HAS BEEN ESTABLISHED
        else
        {
            $result_r = mysqli_query($conn, $sql);
            $row_i = mysqli_fetch_array($result_r);

            //echo $row_r['task'].$row_r['task_desc'].$row_r['report_status'].$row_r['task_due'].$row_r['machine_id'].$row_r['assigned_user'];

            //echo $sql;
            //echo $row_i['issue'].$row_i['issue description'].$row_i['issue_status'].$row_i['date_due'].$row_i['machine_id'].$row_i['assigned_to'];

        }

    }

}