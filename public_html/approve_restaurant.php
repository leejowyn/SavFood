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
		
		$restaurant_id = $_GET['restaurant_id'];
		
		//connect and select database
		$dbc = mysqli_connect('localhost', 'root', 'newinti2020');
		mysqli_select_db($dbc, 'savfood');
		
		if (isset($_POST['approve'])) {
			$query = "UPDATE restaurant SET restaurant_status = 'Approved' WHERE restaurant_id = '$restaurant_id'";
			
			if (mysqli_query($dbc, $query)) {
	?>
				<script type="text/javascript">
					alert("The restaurant has been approved successfully.");
					window.location = "pending_restaurant.php";
				</script>
	<?php
			}
			else {
				echo "Fail to approve restaurant because: <br/>" . mysqli_error($dbc) . "The query was: " . $query;
			}
		}
		
		mysqli_close($dbc);

	?>

	<div class="main-content">
		<div id="content-wrapper" class="d-flex flex-column">
			<div id="content">
				<div class="container-fluid">
					<br/>
					
					<h1 class="h3 ml-2 mb-4 text-gray-800">Approve Restaurant</h1>
					<br/>
						
					<div class="col-4 mb-4">
                        <h6 class="m-0 font-weight-bold text-success">Are you sure you want to approve this restaurant?</h6>
                    </div>
							
                    <div class="row">
						<form action="approve_restaurant.php?restaurant_id=<?php echo $restaurant_id; ?>" method="post">
							<button type="submit" class="btn btn-success ml-5 mr-3">Approve</button>
							<input type="hidden" name="approve" value="true">
						</form>
						<button class="btn btn-secondary" onclick="history.go(-1)">Cancel</button>
                    </div>
					
				</div>
			</div>
		</div>
	</div>
					
</body>
</html>
