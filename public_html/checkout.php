<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <title>SavFood - Check Out</title>
</head>

<body>

<?php
	include('header.php');
	
	//connect the database
    $dbc = mysqli_connect('localhost', 'root', 'newinti2020');

    if (!$dbc) {
		die("Error: " . mysqli_connect_error($dbc));
	}

    //select the database
    mysqli_select_db($dbc, 'savfood');
	
	if (isset($_SESSION['cust_id'])) {
		$cust_id = $_SESSION['cust_id'];
	}
	
	$query = "SELECT * FROM customer WHERE cust_id = $cust_id";
	
	if ($r = mysqli_query($dbc, $query)) { 
		$row = mysqli_fetch_array($r);
		$cust_name = $row['cust_fname'] . " " . $row['cust_lname'];
		$cust_phone = $row['cust_phone'];
		$cust_email = $row['cust_email'];
	}
	else {
		echo mysqli_error($dbc) . "The query was: " . $query;
	}	

	if (isset($_POST['checkout'])) {
		if (isset($_POST['box_selected'])) {
		$box_selected = $_POST['box_selected'];
		$_SESSION['box_selected'] = $box_selected;

		$totalprice = 0;
		
			echo '
			<br/>
			<div class="col-6 mx-auto">
				<h1>Check Out</h1>
				<hr>

				<h4>Personal Details</h4>
				<br/>
				<div class="row">
					<div class="col">
						<p>Name</p>
						<p>Mobile No</p>
						<p>E-mail</p>
					</div>
					<div class="col text-end">
						<p>' . $cust_name . '</p>
						<p>' . $cust_phone . '</p>
						<p>' . $cust_email . '</p>
					</div>
				</div>
				
				<hr>

				<h4>Order Details</h4>
				<br/>';

			foreach ($box_selected as $box_id) {
				
				$query = "SELECT * FROM cart c, foodbox f, restaurant r  
							WHERE c.box_id = f.box_id 
							AND f.restaurant_id = r.restaurant_id
							AND c.cust_id = $cust_id 
							AND f.box_id = $box_id";
							
				if ($r = mysqli_query($dbc, $query)) { 
					$row = mysqli_fetch_array($r); 
						
						$rest_image = $row['restaurant_image'];
						$rest_name = $row['restaurant_name'];
						$qty_selected = $row['qty']; 
						$box_id = $row['box_id'];
						$box_price = number_format($row['box_price'], 2);
						$box_endTime = $row['box_endTime'];
						
						echo '       
						<div class="row d-flex align-items-center">
							<div class="col-2">
								<img src="img/' . $rest_image . '" class="img-thumbnail">
							</div>
							<div class="col-7">
								<p class="fw-bold">' . $rest_name . '</p>   
								<p class="">Box #' . $box_id . '<p>   
							</div>
							<div class="col-1">
								<p class="fw-bold text-end">x ' . $qty_selected . '</p>    
							</div>
							<div class="col-2">
								<p class="fw-bold text-end">RM ' . $box_price . '</p>    
							</div>
						</div>
						<hr/>';
						$totalprice = $totalprice + ($qty_selected * $box_price);
					
				}
				else {
					echo mysqli_error($dbc) . "The query was: " . $query;
				}	
			}
			
				echo '
			<form action="receipt.php" method="post">
				<div class="row">
					<div class="col-9">
						<h4>Payment Method</h4>  
					</div>
					<div class="col-3">
						<select class="form-select" name="pay_method">
							<option value="online_banking">Online Banking</option>
							<option value="credit_card">Credit Card</option>
							<option value="cash">Cash</option>
						</select>
					</div>
				</div>
				
				<hr>

				<div class="row">
					<div class="col">
						<h4>Total Price</h4>
					</div>
					<div class="col text-end">
						<h4>RM ' . number_format($totalprice, 2) . '</h4>
					</div>
				</div>

				<br/>

				<div class="row text-end">
					<div class="col">
						<input type="submit" value="Place Order" class="btn btn-primary text-light" style="box-shadow: -1px 8px 20px 1px rgba(143,159,209,0.66);">
						<input type="hidden" name="place_order" value="true">
					</div>
				</div>
		  
			</div>
			</form>';
		}
		else {
					echo '
					<br/><br/><br/>
					<div class="col-6 mx-auto">
						<div class="alert alert-danger" role="alert">
							<i class="bi bi-exclamation-triangle" style="font-size: 15pt;"></i>&nbsp;&nbsp;&nbsp;Please select at least 1 item from the cart.
						</div>
						<div class="d-flex justify-content-center">
							<a href="cart.php"><button class="btn btn-primary text-light" style="box-shadow: -1px 8px 20px 1px rgba(143,159,209,0.66);">Back to Cart</button></a>
						</div>
					</div>
					<br/><br/><br/><br/><br/><br/>';
		}
	}

	include('footer.php');
?>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>