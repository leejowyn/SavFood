<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
	<link href="style.css" rel="stylesheet" type="text/css"/>
	<title>SavFood - Order</title>
	
	<style>
	body {
		background: #edeff5
	}
	</style>

</head>

<body>

    <?php
		$page = "restaurantsResult";
		include('header.php');
		function getDistance($user_lat, $user_lon, $rest_lat, $rest_lon) {
			$distance = 0;
			
			$earthRadius = 6371;

			$distanceLat = deg2rad($rest_lat - $user_lat);
			$distanceLon = deg2rad($rest_lon - $user_lon);

			$a = sin($distanceLat/2) * sin($distanceLat/2) + cos(deg2rad($user_lat)) * cos(deg2rad($rest_lat)) * sin($distanceLon/2) * sin($distanceLon/2);
			$c = 2 * asin(sqrt($a));
			$distance = $earthRadius * $c;
			
			return $distance;
		}

        //connect the database
        $dbc = mysqli_connect('localhost', 'root', 'newinti2020');

        if (!$dbc) {
			die("Error: " . mysqli_connect_error($dbc));
		}

        //select the database
        mysqli_select_db($dbc, 'savfood');
		
		date_default_timezone_set("Asia/Kuala_Lumpur");
		$locationDetected = false;
		
		echo '<div class="col-9 mb-4 mt-4" style="margin:auto">
				<h5>Current Location: <span id="currentLocation"></span></h5><br/>';
				
		//$uri = $_SERVER['REQUEST_URI'];
		//echo $uri; // Outputs: URI
		
    	if (isset($_GET['user_lat']) && isset($_GET['user_lon'])) {
			$locationDetected = true;
			$user_lat = $_GET['user_lat'];
			$user_lon = $_GET['user_lon'];
			echo '<iframe class="col-12" height="200px" src="https://maps.google.com/maps?q=' . $user_lat . ', ' . $user_lon . '&output=embed"></iframe>';
			$url = "restaurantsResult.php?user_lat=" . $user_lat . "&user_lon=" . $user_lon;
		}
		else {
			$url = "restaurantsResult.php?";
		}
		echo "</div>";
		
		$search_value = "";
		
		if (isset($_POST['search_rest'])) {
			$search_value = $_POST['search_rest'];
		}
    ?>
    <form class="search_restaurant col-9 mb-4" style="margin:auto" action="<?php echo $url; ?>" method="post">
        <div class="input-group mb-4">
            <span class="input-group-text text-primary"><i style="padding:8px" class="fa fa-search"></i></span>
			<input type="text" class="form-control" name="search_rest" id="search_rest" placeholder="Search for restaurants" value="<?php echo $search_value; ?>">
            <button class="btn btn-outline-primary clearInput" type="button" id="button-addon2" onclick="document.getElementById('search_rest').value = ''"><i style="padding:8px" class="fa fa-times"></i></button>
        </div>
    </form>
	<br/>
	<div class="col-9 mx-auto">
		<nav aria-label="breadcrumb">
		  <ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="homepage.php">Home</a></li>
			<?php
			if (isset($_GET['cuisine'])) {
				echo '
				<li class="breadcrumb-item"><a href="restaurantsResult.php">Restaurant</a></li>
				<li class="breadcrumb-item active" aria-current="page">'.$_GET['cuisine'].'</li>';
			}
			else {
				echo '<li class="breadcrumb-item active" aria-current="page">Restaurant</li>';
			}
			?>
		  </ol>
		</nav>
	</div>
	
	<br/>
		
    <div class="cuisine_cont col-12 mb-5">
        <h1 class="col-9 mb-4">Cuisine</h1>
        <div class="cuisine_content col-9">
            <div class="cuisines col-9 m-2">
			<?php
			$cuisineArr = array("Asian", "Western", "Chinese", "Japanese", "Korean", "Halal", "Vegetarian", "Fast Food", "Beverages", "Dessert");
			$cuisineImgArr = array("asian.jpg", "western.jpg", "chinese.jpg", "japanese.jpg", "korean.jpg", "halal.jpg", "vegetarian.jpg", "fastfood.jpg", "beverages.jpg", "dessert.jpg");
			for ($i = 0; $i < 10; $i++) {
				echo '
					<div class="cuisine" style="background-image: url(\'img/' . $cuisineImgArr[$i] .'\');">
						<a href="' . $url . "&cuisine=" . $cuisineArr[$i] . '" class="text-decoration-none">
							<div class="cuisine_overlay">
								<div class="cuisine_title fw-bold fs-3">' . $cuisineArr[$i] . '</div>
							</div>
						</a>
					</div>
				';
			}
			?>
            </div>
        </div>
    </div>
	
	<table class="table table-striped table-hover align-middle col-sm-6 col-lg-4 mx-auto" style="max-width:75%">
        <tr>
            <th width="20%">Restaurant's Image</th>
            <th width="40%">Restaurant's Name</th>
            <th width="15%">Rating & Distance</th>
        </tr>
<?php

		if (isset($_POST['search_rest'])) {
			$query = "SELECT * FROM restaurant r, foodbox f
						WHERE restaurant_name LIKE '%" . $_POST['search_rest'] . "%' 
						AND r.restaurant_id = f.restaurant_id 
						AND restaurant_status = 'Approved'";
		}
		else if (isset($_GET['cuisine'])) {
			$query = "SELECT * FROM restaurant r, foodbox f
						WHERE restaurant_cuisine='" . $_GET['cuisine'] . "' 
						AND r.restaurant_id = f.restaurant_id 
						AND restaurant_status = 'Approved'";
		}
		else {
			$query = "SELECT * FROM restaurant r, foodbox f
						WHERE r.restaurant_id = f.restaurant_id 
						AND restaurant_status = 'Approved'";
		}
		
		$recordFound = false;
		
			if ($r = mysqli_query($dbc, $query)) {

					//$currentTime = date_create("now");
					$currentDateTime = date('Y-m-d H:i');
					
					if ($locationDetected) {
						while ($row = mysqli_fetch_array($r)) {
							$rest_id = $row['restaurant_id'];
							$rest_image = $row['restaurant_image'];
							$rest_name = $row['restaurant_name'];
							$rest_rate = number_format($row['restaurant_rate'], 1);
							$box_qty = $row['box_qty'];
							$box_startTime = date("Y-m-d H:i", strtotime($row['box_startTime']));
							$box_endTime = date("Y-m-d H:i", strtotime($row['box_endTime']));

							if (isset($user_lat) && isset($user_lon)) {
								$rest_lat = $row['restaurant_latitude'];
								$rest_lon = $row['restaurant_longitude'];
								$distance = getDistance($user_lat, $user_lon, $rest_lat, $rest_lon);
								$distance = number_format($distance, 2);

								if ($distance < 10 && $box_qty > 0 && $box_startTime < $currentDateTime && $box_endTime > $currentDateTime) {
									echo '
									<tr onclick="window.location=\'restaurant.php?rest_id=' . $rest_id . '\'" style="cursor:pointer" >
										<td class="p-4"><img src="img/' . $rest_image . '" class="img-thumbnail" width="200px" alt="..."></td>
										<td class="fs-4">' . $rest_name . '</td>
										<td class="ps-5"><i class="fa fa-star"></i>&nbsp;'. $rest_rate .'<br/>' . $distance . ' km</td>
									</tr>';
									$recordFound = true;
								}
							}
							else {
								if (($box_qty > 0) && ($box_startTime < $currentDateTime) && ($box_endTime > $currentDateTime)) {
								echo '
									<tr onclick="window.location=\'restaurant.php?rest_id=' . $rest_id . '\'" style="cursor:pointer">
										<td class="p-4"><img src="img/' . $rest_image . '" class="img-thumbnail" width="200px" alt="..."></td>
										<td class="fs-4">' . $rest_name . '</td>
										<td class="ps-5"><i class="fa fa-star"></i>&nbsp;'. $rest_rate .'<br/></td>
									</tr>';
								$recordFound = true;
								}
							}	
						}
						if (!$recordFound) {
							echo '<tr>
									<td colspan="3" class="text-center p-5">
										<img src="img/no_result_found.png">
										<br/>
										<span class="text-muted">Couldn\'t Find Results.<br/>Let\'s try a different restaurant.</span>
									</td>
								 </tr>';
						}
					}
					else {
						echo '<tr>
								<td colspan="3" class="text-center p-5">
									<img src="img/no_result_found.png">
									<br/>
									<span class="text-muted">Couldn\'t Find Results.<br/>Please allow location access to start your order.</span>
								</td>
							 </tr>';
					}

			}
			else {
				echo "Error: <br/>" . mysqli_error($dbc) . "The query was: " . $query;
			}				
	echo "</table>";
	include('footer.php');
?>
    <script type="text/javascript">
        var locationError = document.getElementById("currentLocation");
		var locationDetected = "<?php echo $locationDetected; ?>";

		if (!locationDetected) {
			getLocation();
		}

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.watchPosition(updatePageInfo, showError);
            }
            else { 
                locationError.innerHTML = "Geolocation is not supported by this browser.";
            }
        }      
		
        function updatePageInfo(position) {
            window.location = "restaurantsResult.php?user_lat=" + position.coords.latitude + "&user_lon=" + position.coords.longitude;
        }
		
		function showError(error) {
			if (error.code == error.PERMISSION_DENIED) {
				locationError.innerHTML = "You have denied the request for Geolocation.";
			}
		}
    </script>
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>