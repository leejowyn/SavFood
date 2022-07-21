<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>SavFood - Cart</title>
	
	<style>
		input::-webkit-outer-spin-button,
		input::-webkit-inner-spin-button {
		  -webkit-appearance: none;
		  margin: 0;
		}
			body {
		background: #edeff5
	}
	</style>
</head>

<body>

<?php
	include('header.php');
	
	echo '
	<br/>
	<form action="checkout.php" method="post">
    <div class="col-9 mx-auto">   
        <h1 class="m-2">Cart</h1>';

	//connect the database
    $dbc = mysqli_connect('localhost', 'root', 'newinti2020');

    if (!$dbc) {
		die("Error: " . mysqli_connect_error($dbc));
	}

    //select the database
    mysqli_select_db($dbc, 'savfood');

	if (isset($_SESSION['cust_id'])) {
		$cust_id = $_SESSION['cust_id'];
	
	date_default_timezone_set("Asia/Kuala_Lumpur");
	
	if (isset($_GET['box_id']) && isset($_GET['qty_selected'])) {
		$query = "UPDATE cart SET qty = {$_GET['qty_selected']} 
					WHERE box_id = {$_GET['box_id']} 
					AND cust_id = $cust_id";
		if (!mysqli_query($dbc, $query)) {
			echo mysqli_error($dbc) . "The query was: " . $query;
		}
	}
	
	if (isset($_GET['delete'])) {
		$query = "DELETE FROM cart 
					WHERE box_id = {$_GET['box_id']} 
					AND cust_id = $cust_id";
		if (mysqli_query($dbc, $query)) {
			?>
			<script>
			window.location = 'cart.php';
			</script>
			<?php
		}
		else {
			echo mysqli_error($dbc) . "The query was: " . $query;
		}
	}
	
	$query = "SELECT * FROM customer cust, cart cart, foodbox f, restaurant r  
				WHERE cust.cust_id = cart.cust_id 
				AND cart.box_id = f.box_id 
				AND f.restaurant_id = r.restaurant_id
				AND cart.cust_id = $cust_id";

    if ($r = mysqli_query($dbc, $query)) {
        if (mysqli_num_rows($r) > 0) {
			echo'
				<br/>
				<div class="table-responsive">
				<table class="table table-hover align-middle" style="display: block; height: 70vh; overflow: auto;">
					<tr>
						<th></th>
						<th>Restaurant\'s Logo</th>
						<th>Restaurant\'s Name</th>
						<th>Quantity</th>
						<th>Unit Price</th>
						<th></th>
					</tr> </div>';
				
			while ($row = mysqli_fetch_array($r)) {
				$rest_id = $row['restaurant_id'];
				$rest_image = $row['restaurant_image'];
				$rest_name = $row['restaurant_name'];
				$rest_unit = $row['restaurant_unit'];
				$rest_building = $row['restaurant_building'];
				$rest_street = $row['restaurant_street'];
				$rest_postcode = $row['restaurant_postcode'];
				$rest_city = $row['restaurant_city'];
				$rest_state = $row['restaurant_state'];		
				$rest_add = $rest_unit . ", " . $rest_building . ", " . $rest_street . ", " . $rest_postcode . " " . $rest_city . ", " . $rest_state;

				$box_id = $row['box_id'];
				$box_price = number_format($row['box_price'], 2);
				$box_endTime = $row['box_endTime'];
				$box_qty = $row['box_qty'];
				$qty_selected = $row['qty'];
				$currentDateTime = date('Y-m-d H:i');

						if ($box_qty == 0) {
							echo '
							<tr>
								<td></td>
								<td class="col-2 pt-3 pb-3">
									<img src="img/' . $rest_image . '" class="img-thumbnail" alt="">
								</td>
								<td class="col-6">
									<p class="fs-5 fw-bold"><a href="restaurant.php?rest_id=' . $rest_id . '" class="text-decoration-none text-dark">' . $rest_name . '</a></p>
									<p class="text-muted">' . $rest_add . '</p>
								</td>
								<td class="col-4" colspan="2">
									<div class="alert alert-danger" role="alert">Sorry. This food box has been sold out.</div>
								</td>';
						}
						else if ($box_endTime < $currentDateTime) {
							echo '
							<tr>
								<td></td>
								<td class="col-2 pt-3 pb-3">
									<img src="img/' . $rest_image . '" class="img-thumbnail" alt="">
								</td>
								<td class="col-6">
									<p class="fs-5 fw-bold"><a href="restaurant.php?rest_id=' . $rest_id . '" class="text-decoration-none text-dark">' . $rest_name . '</a></p>
									<p class="text-muted">' . $rest_add . '</p>
								</td>
								<td class="col-4" colspan="2">
									<div class="alert alert-danger" role="alert">Sorry. The sale period of this food box has end.</div>
								</td>';
						}
						else {
							echo '
							<tr>
								<td>
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="box_selected[]" value="' . $box_id . '" onclick="calcTotalPrice(this.id, '. $qty_selected . ', ' . $box_price . ')" id="cart' . $box_id . '">
									</div>
								</td>
								<td class="col-2 pt-3 pb-3">
									<img src="img/' . $rest_image . '" class="img-thumbnail" alt="">
								</td>
								<td class="col-6">
									<p class="fs-5 fw-bold"><a href="restaurant.php?rest_id=' . $rest_id . '" class="text-decoration-none text-dark">' . $rest_name . '</a></p>
									<p class="text-muted">' . $rest_add . '</p>
								</td>';
							if ($box_qty < $qty_selected) {
								$qty_selected = $box_qty;
								$query = "UPDATE cart SET qty = $qty_selected 
											WHERE box_id = $box_id 
											AND cust_id = $cust_id";
								if (!mysqli_query($dbc, $query)) {
									echo mysqli_error($dbc) . "The query was: " . $query;
								}
							}
							echo '
							<td class="col-3">
								<div class="input-group" style="width:40%" >
								<a href="cart.php?box_id=' . $box_id . '&qty_selected=' . ($qty_selected - 1) . '"><button class="btn btn-outline-primary" type="button">-</button></a>
									<input class="form-control text-center" type="text" value="' . $qty_selected . '" aria-label="Disabled input example" disabled readonly>							
									<a href="cart.php?box_id=' . $box_id . '&qty_selected=' . ($qty_selected + 1) . '"><button class="btn btn-outline-primary" type="button">+</button></a>
								</div>
							</td>
							<td class="col-1">
								<p class="fs-5 fw-bold">RM ' . $box_price . '</p>
							</td>
							';
							
						}
						echo '
						<td class="col-1">
							<a href="cart.php?delete=true&box_id=' . $box_id . '" class="btn btn-danger rounded-circle">
								<i class="fa fa-trash"></i>
							</a>
						</td>
					</tr>';	
			}
			echo '</table>';
        }
		else {
			echo '
			<hr>
				<div class="col-12 d-flex justify-content-center align-items-center flex-column" style="height: 55vh;">
					<img src="img/emptycart.png" width="20%">
					<span class="mt-4 mb-2 text-muted">Oops, your shopping cart is empty.</span>
					<span class="mb-4 text-muted">Browse our awesome mystery food box now!</span>
					<a href="restaurantsResult.php"><button class="btn btn-primary text-light" type="button" style="box-shadow: -1px 8px 20px 1px rgba(143,159,209,0.66);">Browse</button></a>
				</div>
			';			
		}
    }
    else {
        echo 'Error: '.mysqli_error($dbc);
    }
	}
	else {
			echo '
			<hr>
				<div class="col-12 d-flex justify-content-center align-items-center flex-column" style="height: 50vh;">
					<img src="img/emptycart.png" width="20%">
					<span class="mt-4 mb-2 text-muted">Oops, you haven\'t login yet.</span>
					<span class="mb-4 text-muted">Login and browse our awesome mystery food box now!</span>
					<a href="userlogin.php"><button class="btn btn-primary text-light" type="button" style="box-shadow: -1px 8px 20px 1px rgba(143,159,209,0.66);">Login</button></a>
				</div>
			';	
	}
		
	echo '
    </div>
	
    <div class="row col-9 fixed-bottom mx-auto d-flex align-items-center flex-column text-end">
        <hr>
        <div class="ps-4 pe-5">
            <span class="fs-4 fw-bold">Total : &nbsp; RM</span>
			<span class="fs-4 fw-bold" id="totalprice">0</span>
        </div>
        <div class="pt-3 pb-3 pe-4">
            <input type="submit" value="Check Out" class="btn btn-primary text-light" style="box-shadow: -1px 8px 20px 1px rgba(143,159,209,0.66);">
			<input type="hidden" name="checkout" value="true">
        </div>        
    </div>
</form>';
	
?>
    
    <script>

		var totalprice = document.getElementById("totalprice");
		var total = parseFloat(totalprice.innerHTML);
		
		window.onload = function(){
		   var checkbox = document.getElementsByTagName("input");

		   for(var i=0; i<checkbox.length; i++) {
			  if(checkbox[i].type == "checkbox") {
				  checkbox[i].checked = false;
			  }
		   }
		}
		
		function calcTotalPrice(checkbox_id, qty_selected, box_price) {
			var checkbox = document.getElementById(checkbox_id);

			if (checkbox.checked==true) {
				total = total + (qty_selected * box_price);
				totalprice.innerHTML = total.toFixed(2);
			}
			else {
				total = total - (qty_selected * box_price);
				totalprice.innerHTML = total.toFixed(2);
			}
			
		}

    </script>
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
</body>

</html>