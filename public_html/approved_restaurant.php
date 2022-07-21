<!DOCTYPE html>
<html lang="en">
<head>
	<meta-charset="UTF-8">
	<title>Admin</title>
	<link href="sb-admin-2.min.css" rel="stylesheet">
	<link rel="stylesheet" href="style.css">
</head>

<body>
	<?php
		include ('admin_sidebar.html');
		
		session_start();
	?>
	
	<div class="main-content">
		<div id="content-wrapper" class="d-flex flex-column">
			<div id="content" style="margin:20px">
				<div class="container-fluid">
					<br/>
					
					<h1 class="h3 mb-4 text-gray-800">Restaurant Lists</h1>
					<br/>
					<div class="table-responsive">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>No</th>
								<th>Name</th>
								<th>Email</th>
								<th>Image</th>
								<th>Address</th>
								<th>Phone no</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						</div>
						<?php
							$dbc = mysqli_connect('localhost', 'root', 'newinti2020');
							mysqli_select_db($dbc, 'savfood');
							
							$query = 'SELECT * FROM restaurant WHERE restaurant_status="Approved" ORDER BY restaurant_id ASC';
							
							$no = 1;
							
							if ($r = mysqli_query($dbc, $query)) {
								while ($row = mysqli_fetch_array($r)) {
									$address = $row['restaurant_unit'] . ", " . $row['restaurant_building'] . ", " . $row['restaurant_street'] . ", " . $row['restaurant_postcode'] . " " . $row['restaurant_city'] . ", " . $row['restaurant_state'];
									echo "
									
									<tr>
										<td>$no</td>
										<td>{$row['restaurant_name']}</td>
										<td>{$row['restaurant_email']}</a></td>
										<td><img src=\"img/{$row['restaurant_image']}\" width=\"100px\"></td>
										<td>$address</td>
										<td>{$row['restaurant_phone']}</td>
										<td>{$row['restaurant_status']}</td>
										<td>
											<a href=\"delete_restaurant.php?restaurant_id={$row['restaurant_id']}\" class=\"btn btn-danger btn-circle\">
												<i class=\"fas fa-trash\"></i>
											</a>
										</td>
									</tr>
									";
									$no++;
								}
							}
						?>
						
					</table>
				</div>
			</div>
		</div>
	</div>
					
</body>
</html>
