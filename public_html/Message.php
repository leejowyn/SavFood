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
					
					<h1 class="h3 mb-4 text-gray-800">Message</h1>
					<br/>
					<div class="table-responsive">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>No</th>
								<th>Name</th>
								<th>Email</th>
								<th>Phone no</th>
								<th>Comments</th>
							</tr>
						</thead>
						</div>
						<?php
							$dbc = mysqli_connect('localhost', 'root', 'newinti2020');
							mysqli_select_db($dbc, 'savfood');
							
							$query = 'SELECT * FROM message';
							
							$no = 1;
							
							if ($r = mysqli_query($dbc, $query)) {
								while ($row = mysqli_fetch_array($r)) {
									echo "
									
									<tr>
										<td>$no</td>
										<td>{$row['m_name']}</td>
										<td>{$row['m_email']}</a></td>
										<td>{$row['m_phone']}</td>
										<td>{$row['m_comment']}</td>
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
