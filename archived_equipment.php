<head>
    <title>Equipment Inventory</title>
    <?php
	session_start();
	include 'header.php';
    ?>
</head>

<!--<div class="container-fluid py-4 overflow-hidden"> -->




<div class="container py-4">
    <input type="button" class="btn btn-secondary" onclick="history.back()" value="<< Back" /><br /><br />
    <h2>
        <text style="font-weight:bold;"> Archived Equipment in APC <a class="btn btn-success" href="equipment.php?site=Equipment&page=1">View Operating Equipments</a></text>
    </h2>
    <i class="bi bi-info-circle-fill"></i>
    <br />
    <table id="equipment_table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Equipment</th>
                <th scope="col">Asset</th>
                <th scope="col">Floor</th>
                <th scope="col">Room Number</th>
                <th scope="col">Date Installed</th>
                <th scope="col">Condition</th>
                <th scope="col">Operating</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>

            <?php
			include 'backend/get_archived_equipment.p.php';
            ?>
        </tbody>
    </table>

</div>

<script src="tablefilter/tablefilter.js"></script>

<script data-config>
	var filtersConfig = {
		base_path: 'tablefilter/',
		responsive: true,
		paging: {
          results_per_page: ['Records: ', [10, 25, 50, 100]]
        },
        single_filter: true,
		alternate_rows: true,
		rows_counter: true,
		sticky_headers: true,
		btn_reset: true,
		loader: true,
		status_bar: true,
		mark_active_columns: true,
		highlight_keywords: true,

		col_types: ['string',
					'string',
					'string',
					'string',
					{ type: 'date', locale: 'en', format: '{dd}-{MM}-{yyyy|yy}' },
					'string',
					'string'
		],
		watermark: ['(e.g. Generator Set I)', '(e.g. HVAC, Genset)', '', '404-A', '(e.g. >2022-01-01)', '', ''],
		msg_filter: 'Filtering...',
    		auto_filter: {
            delay: 1000 //milliseconds
        },
        extensions:[{ name: 'sort' }]
	};

	var tf = new TableFilter('equipment_table', filtersConfig);
    tf.init();
</script>

<!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>-->

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
