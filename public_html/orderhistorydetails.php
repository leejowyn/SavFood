<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>SavFood - Order History Details</title>
	
	<style>
	.print_title *{
		display: none;
	}
	@media print {
		body * {
			visibility: hidden;
		}
		.receipt *{
			visibility: visible;
		}
		.print_title *{
			display: block;
			visibility: visible;
		}
    }
	</style>

</head>

<body>

<?php
	include 'header.php';
	
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
	
	if (isset($_GET['order_id'])) {
		$order_id = $_GET['order_id'];
		$totalprice = 0;
		
		$query = "SELECT * FROM customer c, orders o 
					WHERE c.cust_id = o.cust_id 
					AND o.cust_id = $cust_id";
		
		if ($r = mysqli_query($dbc, $query)) {
			$row = mysqli_fetch_array($r);
			$cust_name = $row['cust_fname'] . " " . $row['cust_lname'];
			$cust_phone = $row['cust_phone'];
			$cust_email = $row['cust_email'];
			$order_datetime = $row['order_datetime'];
		}
		else {
			echo mysqli_error($dbc) . "The query was: " . $query;
		}
		
		echo '
			<div class="col-sm-4 col-lg-6 mx-auto">
				<br/>
				<div class="print_title d-flex justify-content-center align-items-center flex-column">
					<h4>SavFood Company</h4>
					<p class="mb-1">Jalan Khoo Teik Ee, Pudu, 11600 Pulau Pinang, Pulau Pinang.</p>
					<p>019-1565951</p>
				</div>
				<div class="receipt border rounded p-5">
					<h4>Receipt</h4>
					<hr>
					<div class="row">
						<div class="col">
							<p class="fw-bold">Order ID</p>
							<p>Date & Time</p>
							<p>Name</p>
							<p>Mobile No</p>
							<p>E-mail</p>
						</div>
						<div class="col text-end">
							<p class="fw-bold">#' . $order_id . '</p>
							<p>' . $order_datetime . '</p>
							<p>' . $cust_name . '</p>
							<p>' . $cust_phone . '</p>
							<p>' . $cust_email . '</p>
						</div>
					</div>

					<br/>
					<div class="table-responsive">
					<table class="table col-12">
						<tr class="table-active">
							<th>No</th>
							<th>Restaunt\'s Name</th>
							<th class="text-center">Food Box ID</th>
							<th class="text-center">Quantity</th>
							<th class="text-center">Unit Price (RM)</th>
							<th class="text-center">Price (RM)</th>
						</tr></div>';
						
			$query = "SELECT * FROM customer c, orders o, order_details od, foodbox f, restaurant r
						WHERE od.box_id = f.box_id 
						AND od.restaurant_id = r.restaurant_id 
						AND o.order_id = od.order_id 
						AND o.cust_id = c.cust_id 
						AND c.cust_id = $cust_id 
						AND od.order_id = $order_id";
			$receipt_no = 1;
			
			if ($r = mysqli_query($dbc, $query)) { 
				while ($row = mysqli_fetch_array($r)) {
					$rest_name = $row['restaurant_name'];
					$box_id = $row['box_id'];
					$qty_selected = $row['quantity'];
					$unit_price = number_format($row['box_price'], 2);
					$price = number_format($qty_selected * $unit_price, 2);
					$totalprice = number_format($totalprice + ($qty_selected * $unit_price), 2);
					
					echo '
						<tr>
							<td>' . $receipt_no . '</td>
							<td>' . $rest_name . '</td>
							<td class="text-center">#' . $box_id . '</td>
							<td class="text-center">' . $qty_selected . '</td>
							<td class="text-center">' . $unit_price . '</td>
							<td class="text-center">' . $price . '</td>
						</tr>';
					$receipt_no++;
				}
			}
			else {
				echo mysqli_error($dbc) . "The query was: " . $query;
			}	
				echo '
						<tr>
							<th colspan="4"></th>
							<th class="fs-5 text-center">Total (RM)</th>
							<th class="fs-5 text-center">' . $totalprice . '</th>
						</tr>
					</table>
				</div>

				<br/>

				<div class="row">
					<div class="col-6 text-end">
						<a href="orderhistory.php"><button type="button" class="btn btn-primary text-light">Back to Order History</button></a>
					</div>
					<div class="col-6">
						<a href="#"><button type="button" class="btn btn-primary text-light" onclick="window.print()">Print Receipt</button></a>
					</div>
				</div>
			</div>
			</div>';
	}
	include('footer.php');
?>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>