<head>
	<title>Equipment Inventory</title>
</head>
<?php
	session_start();
	include 'header.php';
?>
<div class="container-fluid py-4 overflow-hidden">
	<table class="table rounded-3 shadow-lg table-hover mb-5">
	  <thead class="thead-dark">
		<tr>
		  <th scope="col">Equipment</th>
		  <th scope="col">Asset</th>
		  <th scope="col">Floor</th>
		  <th scope="col">Room Number</th>
		  <th scope="col">Date Installed</th>
		  <th scope="col">Condition</th>
		  <th scope="col">Operating</th>
		</tr>
	  </thead>
	  <tbody>
	  
		<?php
			include 'backend/get_equipment.p.php';
		?>
	  </tbody>
	</table>
	<?php
		include 'backend/equipment_pagination.p.php';
	?>
</div>