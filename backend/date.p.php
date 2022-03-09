<?php
	if(isset($_POST['submit'])){
		$start = $_POST['start']. " 00:00:00";
		$end = $_POST['end']. " 23:59:59";
		
		
		if($_GET['site'] == 'issue'){
			header("Location:../issues.php?site=Issues&page=1&time=date&s=".$start."&e=".$end."");
			exit();
		}else{
			header("Location:../reports.php?site=Reports&page=1&time=date&s=".$start."&e=".$end."");
			exit();
		}
		
	}else{
		header("Location:../reports.php?site=Reports&page=1&time=day");
		exit();
	}
?>