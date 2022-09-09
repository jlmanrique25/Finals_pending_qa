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
        This page consists of all the<text style="font-weight:bold;"> Equipment in APC</text>
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
			include 'backend/get_equipment.p.php';
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
		col_1: 'select',
		col_2: 'select',
		col_5: 'select',
		col_6: 'select',
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
        extensions:[{ name: 'sort' }]
	};

	var tf = new TableFilter('equipment_table', filtersConfig);
    tf.init();
</script>