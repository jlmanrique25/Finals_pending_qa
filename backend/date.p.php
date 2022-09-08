<?php
	if(isset($_POST['submit'])){
		$start = $_POST['start']. " 00:00:00";
		$end = $_POST['end']. " 23:59:59";


		if(isset($_GET['status']) && isset($_GET['equipment'])  && isset($_GET['floor']) )
        {
            $floor = 'floor='. $_GET['floor'];
			$status = 'status='.$_GET['status'];
			$equipment = 'equipment='.$_GET['equipment'];

            if($_GET['site'] == 'issue')
            {
			header("Location:../issues.php?site=Issues&page=1&time=date&s=".$start."&e=".$end."&floor=".$floor."&status=".$status."&equipment=".$equipment."");
			exit();
			}
			else
            {
			header("Location:../reports.php?site=Reports&page=1&time=date&s=".$start."&e=".$end."&floor".$floor."&status=".$status."&equipment=".$equipment."");
			exit();
			}
        }
		else if(isset($_GET['status']) && isset($_GET['equipment']))
        {
            $status = 'status='.$_GET['status'];
			$equipment = 'equipment='.$_GET['equipment'];

			if($_GET['site'] == 'issue')
            {
			header("Location:../issues.php?site=Issues&page=1&time=date&s=".$start."&e=".$end."&status=".$status."&equpment=".$equipment."");
			exit();
			}
			else
            {
			header("Location:../reports.php?site=Reports&page=1&time=date&s=".$start."&e=".$end."&status=".$status."&equipment=".$equipment."");
			exit();
			}
        }
		else if(isset($_GET['equipment'])  && isset($_GET['floor']))
        {
            $floor = 'floor='.$_GET['floor'];
			$equipment = 'equipment='.$_GET['equipment'];

			if($_GET['site'] == 'issue')
            {
			header("Location:../issues.php?site=Issues&page=1&time=date&s=".$start."&e=".$end."&floor=".$floor."&status=".$equipment."");
			exit();
			}
			else
            {
				header("Location:../reports.php?site=Reports&page=1&time=date&s=".$start."&e=".$end."&floor=".$floor."&status=".$equipment."");
				exit();
			}
        }
		else if(isset($_GET['status']) && isset($_GET['floor']) )
        {
            $floor = $_GET['floor'];
			$status = $_GET['status'];

			if($_GET['site'] == 'issue')
            {
			header("Location:../issues.php?site=Issues&page=1&time=date&s=".$start."&e=".$end."&floor=".$floor."&status=".$status."");
			exit();
			}
			else
            {
				header("Location:../reports.php?site=Reports&page=1&time=date&s=".$start."&e=".$end."&floor".$floor."&status=".$status."");
				exit();
			}
        }
		else if(isset($_GET['status'])){
            $status = $_GET['status'];

			if($_GET['site'] == 'issue')
            {
			header("Location:../issues.php?site=Issues&page=1&time=date&s=".$start."&e=".$end."&status=".$status."");
			exit();
			}
			else
            {
				header("Location:../reports.php?site=Reports&page=1&time=date&s=".$start."&e=".$end."&status=".$status."");
				exit();
			}
        }
		else if(isset($_GET['equipment']))
        {
            $equipment = $_GET['equipment'];

			if($_GET['site'] == 'issue')
            {
			header("Location:../issues.php?site=Issues&page=1&time=date&s=".$start."&e=".$end."&equipment=".$equipment."");
			exit();
			}
			else
            {
				header("Location:../reports.php?site=Reports&page=1&time=date&s=".$start."&e=".$end."&equipment=".$equipment."");
				exit();
			}
        }
		else if(isset($_GET['floor']))
        {
            $floor = $_GET['floor'];

			if($_GET['site'] == 'issue')
            {
			header("Location:../issues.php?site=Issues&page=1&time=date&s=".$start."&e=".$end."&floor=".$floor."");
			exit();
			}
			else
            {
				header("Location:../reports.php?site=Reports&page=1&time=date&s=".$start."&e=".$end."&floor=".$floor."");
				exit();
			}
        }
		else if($_GET['site'] == 'issue')
        {
			header("Location:../issues.php?site=Issues&page=1&time=date&s=".$start."&e=".$end."");
			exit();
		}
		else
        {
			header("Location:../reports.php?site=Reports&page=1&time=date&s=".$start."&e=".$end."");
			exit();
		}




	}else{
		header("Location:../reports.php?site=Reports&page=1&time=day");
		exit();
	}
?>