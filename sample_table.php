<html>
<head><title>Sample Table</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.js"></script>
	<!-- Latest compiled and minified Locales -->
	<script src="https://unpkg.com/bootstrap-table@1.19.1/dist/locale/bootstrap-table-zh-CN.min.js"></script>
	<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.css">
	<script src="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.js"></script>
		<style type="text/css">
		body {
				font-family: 'Josefin Sans', sans-serif;
				background-color: #fff;
			}
		.container { margin: 150px auto; max-width: 960px; }
		a {

			color:#1d2124;
		}
		table {
			width: 100%;
			border-collapse: collapse;
			margin-top: 20px;
			margin-bottom: 20px;
		}
		
		tr[data-href]{
			cursor: pointer;
			transition: background-color 500ms ease-out 100ms;
		}
		tr[data-href]:hover{
			background-color:#e5e5e5;
		}
		th {
			background-color: #ddd;
		}
		th,td {
			padding: 5px;
		}
		button {
			cursor: pointer;
		}
		/*Initial style sort*/
		.tablemanager th.sorterHeader {
			cursor: pointer;
		}
		.tablemanager th.sorterHeader:after {
			content: " \f0dc";
			font-family: "FontAwesome";
		}
		/*Style sort desc*/
		.tablemanager th.sortingDesc:after {
			content: " \f0dd";
			font-family: "FontAwesome";
		}
		/*Style sort asc*/
		.tablemanager th.sortingAsc:after {
			content: " \f0de";
			font-family: "FontAwesome";
		}
		/*Style disabled*/
		.tablemanager th.disableSort {

		}
		#for_numrows {
			padding: 10px;
			float: left;
		}
		#for_filter_by {
			padding: 10px;
			float: right;
		}
		#pagesControllers {
			display: block;
			text-align: center;
		}
	</style>
</head>
<body>
	<table class="tablemanager">
    	<thead>
    		<tr>
						<th class="disableSort">ID</th>
						<th>Task</th>
						<th>Equipment</th>
						<th>Floor</th>
						<th>Room Number</th>
						<th>Date Submitted</th>
						<th>Issue/For Repair</th>
						<th>Issue Status</th>
						<th class="disableFilterBy">Submitted By</th>
			</tr>
    	</thead>
		<tbody>
			<tr>
				<th scope="row">1</th>
				<td>Leak Test</td>
				<td><a href="equipmentInventory_aircon(OK).html">Aircon</a></td>
				<td>9th Floor</td>
				<td>916-A</td>
				<td>January 15, 2022</td>
				<td>No</td>
				<td>Done</td>
				<td>Christian Paul Duria</td>
			</tr>
			<tr data-href="dailyReports_aircon(not_done).html">
								<th scope="row">2</th>
								<td>General Cleaning</td>
								<td><a href="equipmentInventory_aircon(OK).html">Aircon</a></td>
								<td>6th Floor</td>
								<td>608-A</td>
								<td>January 15, 2022</td>
								<td>Yes</td>
								<td>Not Done</td>
								<td>Jan Laurene Manrique</td>
							</tr>
							<tr data-href="dailyReports_genset(done).html">
								<th scope="row">3</th>
								<td>Voltage Test</td>
								<td><a href="equipmentInventory_aircon(OK).html">Generator Set II</a></td>
								<td>Basement 2</td>
								<td>--</td>
								<td>November 15, 2021</td>
								<td>No</td>
								<td>Done</td>
								<td>Demeter Renee Caubang</td>
							</tr>
							<tr data-href="dailyReports_aircon(for_repair).html">
								<th scope="row">4</th>
								<td>Pressure Test</td>
								<td><a href="equipmentInventory_aircon(OK).html">Aircon</a></td>
								<td>2nd Floor</td>
								<td>209-C</td>
								<td>January 15, 2022</td>
								<td>Yes</td>
								<td>Done</td>
								<td>Trisha Nicole Tolentino</td>
							</tr>
							<tr data-href="dailyReports_aircon(for_repair).html">
								<th scope="row">5</th>
								<td>Leak Test</td>
								<td><a href="equipmentInventory_aircon(OK).html">Aircon</a></td>
								<td>4th Floor</td>
								<td>402- A</td>
								<td>January 19, 2022</td>
								<td>No</td>
								<td>Not Done</td>
								<td>Demeter Renee Caubang</td>
							</tr>
							<tr data-href="dailyReports_aircon(for_repair).html">
								<th scope="row">6</th>
								<td>Pressure Test</td>
								<td><a href="equipmentInventory_aircon(OK).html">Aircon</a></td>
								<td>6th Floor</td>
								<td>607-C</td>
								<td>December 10, 2021</td>
								<td>Yes</td>
								<td>Done</td>
								<td>Jasffer Padigdig</td>
							</tr>
		</tbody>
	</table>
	
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> 
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<!-- <script type="text/javascript" src="./js/jquery-1.12.3.min.js"></script> -->
		<script type="text/javascript" src="./tableManager.js"></script>
		<script type="text/javascript">
			// basic usage
			$('.tablemanager').tablemanager({
				firstSort: [[3,0],[2,0],[1,'asc']],
				disable: ["last"],
				appendFilterby: true,
				dateFormat: [[4,"mm-dd-yyyy"]],
				debug: true,
				vocabulary: {
		voc_filter_by: 'Filter By',
		voc_type_here_filter: 'Filter...',
		voc_show_rows: 'Rows Per Page'
	  },
				pagination: true,
				showrows: [5,10,20,50,100],
				disableFilterBy: [1]
			});
			// $('.tablemanager').tablemanager();
		</script>
		<script>
	try {
	  fetch(new Request("https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js", { method: 'HEAD', mode: 'no-cors' })).then(function(response) {
		return true;
	  }).catch(function(e) {
		var carbonScript = document.createElement("script");
		carbonScript.src = "//cdn.carbonads.com/carbon.js?serve=CK7DKKQU&placement=wwwjqueryscriptnet";
		carbonScript.id = "_carbonads_js";
		document.getElementById("carbon-block").appendChild(carbonScript);
	  });
	} catch (error) {
	  console.log(error);
	}
	</script>
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-36251023-1']);
	  _gaq.push(['_setDomainName', 'jqueryscript.net']);
	  _gaq.push(['_trackPageview']);

	  (function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();

	</script>
</body>
</html>