<head>
	<title>Users</title>
</head>

<?php
	session_start();
	include 'header.php';
?>
<div class= "container py-4 overflow-hidden">

	<h2>List of <text style="font-weight:bold;">Users and their Roles</text> </h2> <br>

	<table id="users_table">
	  <thead class="thead-dark">
		<tr>
		  <th scope="col">Username</th>
		  <th scope="col">Email</th>
		  <th scope="col">Role</th>
		  <th scope="col">Change Role</th>
		</tr>
	  </thead>
	  <tbody>
	  
		<?php
			include 'backend/get_users.p.php';
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
		col_2: 'select',
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
					{ type: 'date', locale: 'en', format: '{dd}-{MM}-{yyyy|yy}' },
					'string'
		],
		
		watermark: ['(e.g. Christian Paul Duria)', '(e.g. crduria@email.com)', '', ''],
		msg_filter: 'Filtering...',
        extensions:[{ name: 'sort' }]
	};

	var tf = new TableFilter('users_table', filtersConfig);
    tf.init();
</script>
