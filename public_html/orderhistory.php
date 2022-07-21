<!DOCTYPE html>
<html>
<head>

	<title>SavFood</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" 
	integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="style.css">
    <style>
	table th, td {
		padding: 10px;
	}
	tbody [rowspan],
	tbody [rowspan] ~ th,
	tbody [rowspan] ~ td {
		border-top: 1px solid #d4d4d4;
	}
	table th {
		background: #ededed;
	}
    .image{
        width:80px;
    }
    .text1{
        max-width:75%;
    }
    @media (max-width: 380px) {
    .image{
    width:30px;
    }
    .text1{
        max-width:25%;
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
	
	if (isset($_POST['picked-up'])) {
		$query = "UPDATE order_details 
					SET status = 'Picked-up'
					WHERE order_id = {$_POST['order_id']} 
					AND box_id = {$_POST['box_id']}";
		if (!mysqli_query($dbc, $query)) {
				echo mysqli_error($dbc) . "The query was: " . $query;
		}
	}
	
	echo '
	<br/>
	<h1 class="col-9 mx-auto">Order History</h1>
	<br/>
	<div class="table-responsive">
	<table class="mx-auto text1">
		<tr>
			<th width="6%" class="text-center">Order ID</th>
			<th width="12%" class="text-center">Restaurant\'s Image</th>
			<th width="22%">Restaurant\'s Name</th>
			<th width="11%" class="text-center">Order Datetime</th>
			<th width="7%" class="text-center">Total (RM)</th>
			<th width="15%" class="text-center">Action</th>
			<th width="2%"></th>
		</tr>
		</div>';
		
	$query = "SELECT * FROM orders WHERE cust_id = $cust_id ORDER BY order_id DESC";
	
	if ($r = mysqli_query($dbc, $query)) {
		if (mysqli_num_rows($r) > 0) {
			while ($row = mysqli_fetch_array($r)) {
				$order_id[] = $row['order_id'];
				$order_datetime[] = $row['order_datetime'];		
				
			}
			$totalprice = array();
			$size = count($order_id);
		}
		else {
			echo '<tr><td colspan="5" class="text-center"><br/><br/><br/><br/><br/>No result found.<br/><br/><br/><br/></td></tr>';
			$size = 0;
		}
	}
	else {
		echo mysqli_error($dbc) . "The query was: " . $query;
	}
	
	for ($i = 0; $i < $size; $i++) {
			$totalprice[$i] = 0;
			$counter = 0;
			$query = "SELECT * FROM restaurant r, foodbox f, order_details od 
						WHERE r.restaurant_id = f.restaurant_id 
						AND r.restaurant_id = od.restaurant_id 
						AND od.box_id = f.box_id 
						AND order_id = $order_id[$i]";
						
			if ($r = mysqli_query($dbc, $query)) {
				$typesOfItem_count = mysqli_num_rows($r);
				echo '
				<tr>
					<td class="text-center" rowspan="' . $typesOfItem_count . '">#'. $order_id[$i] .'</td>';	
			}
			else {
				echo mysqli_error($dbc) . "The query was: " . $query;
			}
			if ($r = mysqli_query($dbc, $query)) {
				while ($row = mysqli_fetch_array($r)) {
					$rest_id = $row['restaurant_id'];
					$rest_image = $row['restaurant_image'];
					$rest_name = $row['restaurant_name'];
					$qty_selected = $row['quantity'];
					$unit_price = $row['box_price'];
					$box_id = $row['box_id'];
					$rate = $row['rate'];
					$status = $row['status'];
					$totalprice[$i] = number_format($totalprice[$i] + ($qty_selected * $unit_price), 2);
					
					if ($counter > 0) {
						echo '<tr>
						<td class="text-center"><img src="img/' . $rest_image . '" class="img-thumbnail" width="80px"></td>
						<td>' . $rest_name . '</a></td>';
						
						if ($status == "Pending") {
							echo '
							<td class="text-center">
								<form action="orderhistory.php" method="post">
									<button type="submit" class="btn alert-success"><i class="fa fa-check-square-o"></i> Mark as Picked-up</button>
									<input type="hidden" name="order_id" value="'.$order_id[$i].'">
									<input type="hidden" name="box_id" value="'.$box_id.'">
									<input type="hidden" name="picked-up" value="true">
								</form>
							</td>
							';
						}
						else {
							if ($rate == 0) {
								$rate_btn_class = "btn alert-primary";	
							}
							else {
								$rate_btn_class = "btn btn-secondary disabled";
							}
							echo '
							<td class="text-center"><a href="review.php?order_id=' . $order_id[$i] . '&box_id='.$box_id.'&rest_id='.$rest_id.'" class="'.$rate_btn_class.'"><i class="fa fa-commenting-o"></i> Rate & Review</a></td>';
						}
					}
					else {
						echo '
							<td class="text-center"><img src="img/' . $rest_image . '" class="image"></td>
							<td>' . $rest_name . '</a></td>
							<td class="text-center" rowspan="' . $typesOfItem_count . '">' . $order_datetime[$i] . '</td>';
						
						echo '<td class="text-center" rowspan="' . $typesOfItem_count . '" id="totalprice'.$i.'"></td>';
						
						if ($status == "Pending") {
							echo '
							<td class="text-center">
								<form action="orderhistory.php" method="post">
									<button type="submit" class="btn alert-success"><i class="fa fa-check-square-o"></i> Mark as Picked-up</button>
									<input type="hidden" name="order_id" value="'.$order_id[$i].'">
									<input type="hidden" name="box_id" value="'.$box_id.'">
									<input type="hidden" name="picked-up" value="true">
								</form>
							</td>
							';
						}
						else {
							if ($rate == 0) {
								$rate_btn_class = "btn alert-primary";	
							}
							else {
								$rate_btn_class = "btn btn-secondary disabled";
							}
							echo '
							<td class="text-center"><a href="review.php?order_id=' . $order_id[$i] . '&box_id='.$box_id.'&rest_id='.$rest_id.'" class="'.$rate_btn_class.'"><i class="fa fa-commenting-o"></i> Rate & Review</a></td>';
						}

						echo '
							<td rowspan="' . $typesOfItem_count . '"><a href="orderhistorydetails.php?order_id=' . $order_id[$i] . '"><button class="btn btn-primary rounded-circle" style="width:38px;height:38px"><i class="fa fa-angle-right text-light" style="font-size:14pt"></i></button></a></td>
						</tr>';
					}
					$counter++;
				}
			}
			else {
				echo mysqli_error($dbc) . "The query was: " . $query;
			}
			
	}
	
	echo "</table><br/><br/><br/><br/>";
	include('footer.php');
?>

<script type="text/javascript">
	//Access the array in php
	var totalprice = <?php echo json_encode($totalprice); ?>;
		   
	//Display the array
	for(var i = 0; i < totalprice.length; i++){
		document.getElementById("totalprice" + i).innerHTML = totalprice[i];
	}
</script>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>