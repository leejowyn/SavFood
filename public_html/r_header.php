<!DOCTYPE html>
<html lang="en">
<head>
	<meta-charset="UTF-8">
	<title>Admin</title>
	<link rel="stylesheet" href="style.css">
	<meta name="viewport" content="width=device-width, initial-scale=0.5">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
	<meta name="viewport" content="width=device-width, initial-scale=0.5">
</head>

<body class="body-index">		
<?php
//connect database
$dbc = mysqli_connect('localhost', 'root', 'newinti2020');
mysqli_select_db($dbc, 'savfood');
session_start();

if (isset($_POST['logout'])) {
    session_destroy();
?>
    <script>
    window.location.href = 'restaurantlogin.php';
    </script>
<?php
}

if (isset($_SESSION['rest_id'])) {
    $rest_id = $_SESSION['rest_id'];
}

$query = "SELECT restaurant_name, restaurant_status FROM restaurant WHERE restaurant_id = $rest_id";

if ($r = mysqli_query($dbc, $query)) {
    $row = mysqli_fetch_array($r);
    $rest_name = $row['restaurant_name'];
    $rest_status = $row['restaurant_status'];
}
else {
    echo "Error because: <br/>" . mysqli_error($dbc) . "The query was: " . $query;
}
?>
<button class="btn m-4" style="background-color: #b5c1e6;" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBackdrop" aria-controls="offcanvasWithBackdrop"><i class="bi bi-list"></i></button>
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasWithBackdrop" style="background-color: #b5c1e6;" aria-labelledby="offcanvasWithBackdropLabel">
  <div class="offcanvas-header">
    <h3 class="offcanvas-title fs-1 p-2 pt-3 fw-bold" id="offcanvasWithBackdropLabel" style="color: #FFFFFF;"><?php echo $rest_name; ?></h3>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body" style="color:#FFFFFF">
  <ul>
					<li class="p-2">
					<span class="fs-4">Status: <?php echo $rest_status; ?></span>
					</li>
					<li class="p-2">
						<a href="restaurantstatus.php">
							<span class="fs-4" style="color:#535b7a">Order Status</span>
						</a>
					</li>
					<li class="p-2">
						<a href="foodbox.php">
							<span class="fs-4" style="color:#535b7a">FoodBox</span>
						</a>
					</li>
					<li class="p-2">
						<a href="restaurantinfo.php">
							<span class="fs-4" style="color:#535b7a">Restaurant Info</span>
						</a>
					</li>
                    <li class="p-2">
						<a href="help.php">
							<span class="fs-4" style="color:#535b7a">Help</span>
						</a>
					</li>
					<li class="p-2 pt-5 ">
						<a href="logout.php">
							<span class="fs-4" style="color:#535b7a">Logout</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	
  </div>
</div>

</body>
</html>