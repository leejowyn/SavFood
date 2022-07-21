<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>SavFood - Mcdonald's</title>
	
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
	
	if (isset($_SESSION['cust_id'])) {
		$cust_id = $_SESSION['cust_id'];
	}
	
if (isset($_GET['rest_id'])) {
	
	//connect the database
    $dbc = mysqli_connect('localhost', 'root', 'newinti2020');

    if (!$dbc) {
		die("Error: " . mysqli_connect_error($dbc));
	}

    //select the database
    mysqli_select_db($dbc, 'savfood');
	
	$rest_id = $_GET['rest_id'];
	
	$query = "SELECT * FROM restaurant r, foodbox f 
				WHERE r.restaurant_id = f.restaurant_id
				AND r.restaurant_id = $rest_id 
				ORDER BY f.box_id DESC LIMIT 1";
	
	if ($r = mysqli_query($dbc, $query)) { 
		$row = mysqli_fetch_array($r);
								
		$rest_image = $row['restaurant_image'];
		$rest_name = $row['restaurant_name'];
		$rest_cuisine = $row['restaurant_cuisine'];
		
		$box_id = $row['box_id'];
		$box_price = number_format($row['box_price'], 2);
		$box_allergy = $row['box_allergy'];
		$box_endTime = $row['box_endTime'];
		$box_qty = $row['box_qty'];
		
		$rest_desc = $row['restaurant_desc'];
		$rest_unit = $row['restaurant_unit'];
		$rest_building = $row['restaurant_building'];
		$rest_street = $row['restaurant_street'];
		$rest_postcode = $row['restaurant_postcode'];
		$rest_city = $row['restaurant_city'];
		$rest_state = $row['restaurant_state'];
		$rest_rate = number_format($row['restaurant_rate'], 1);
		$rest_phone = $row['restaurant_phone'];
		
		$rest_add = $rest_unit . ", " . $rest_building . ", " . $rest_street . ", " . $rest_postcode . " " . $rest_city . ", " . $rest_state;
		
	}
	else {
		echo mysqli_error($dbc) . "The query was: " . $query;
	}	
	
	$query = "SELECT AVG(rate) AS avgrate FROM order_details 
				WHERE rate > 0 
				AND restaurant_id = $rest_id";
	
	if (isset($_POST['add_to_cart'])) {
		
		if (isset($_SESSION['cust_id'])) {

			$query = "SELECT * FROM cart
						WHERE box_id = $box_id
						AND cust_id = $cust_id";
						
			if ($r = mysqli_query($dbc, $query)) {
				if (mysqli_num_rows($r) == 0) {
					$query = "INSERT INTO cart (qty, box_id, cust_id)
								VALUES ({$_POST['qty']}, $box_id, $cust_id)";
					if (mysqli_query($dbc, $query)) {
						?>
						<script>
						window.location = window.location;
						</script>
						<?php
					}
					else {
						echo mysqli_error($dbc) . "The query was: " . $query;
					}
				}
				else {
					$row = mysqli_fetch_array($r);
					$qty_selected = $_POST['qty'] + $row['qty'];
					$query = "UPDATE cart SET qty = $qty_selected 
								WHERE box_id = $box_id 
								AND cust_id = $cust_id";
					if (mysqli_query($dbc, $query)) {
						echo '<br/><div class="alert alert-success col-9 mx-auto" role="alert">' . $_POST['qty'] . ' food box has been successfully added to the cart!</div>';
					}
					else {
						echo mysqli_error($dbc) . "The query was: " . $query;
					}
				}
			}
			else {
				echo mysqli_error($dbc) . "The query was: " . $query;
			}
		}
		else {
			?>
			<script>
			alert("Please login to your account before adding item to cart.");
			window.location.href = 'userlogin.php';
			</script>
			<?php
		}
	}

	echo '
	<br/><br/> 
	<div class="col-9 ps-4 mx-auto">
		<nav aria-label="breadcrumb">
		  <ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="homepage.php">Home</a></li>
			<li class="breadcrumb-item"><a href="restaurantsResult.php">Restaurant</a></li>
			<li class="breadcrumb-item active" aria-current="page">'.$rest_name.'</li>
		  </ol>
		</nav>
	</div>
	<br/> 
    <div class="row col-9 mx-auto ps-4 pe-4 pb-4">
        <div class="col-3">
            <img src="img/' . $rest_image . '" class="img-thumbnail" alt="">
        </div>
        <div class="col-6 my-auto">
            <p class="fs-4 fw-bold">' . $rest_name . '</p>
            <p class="badge bg-primary"> ' . $rest_cuisine . ' </p>
        </div>
        <div class="col-3 my-auto text-center">
            <i class="fa fa-star"></i>&nbsp;&nbsp;<span class="fs-5">' . $rest_rate . '</span>
        </div>
    </div>

    <div class="row col-sm-2 col-lg-9 mx-auto">
        <ul class="nav nav-tabs d-flex justify-content-center" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="mysterybox-tab" data-bs-toggle="tab" data-bs-target="#mysterybox" type="button" role="tab" aria-controls="mysterybox" aria-selected="true">Mystery Box</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab" aria-controls="info" aria-selected="false">Information</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="rating-tab" data-bs-toggle="tab" data-bs-target="#rating" type="button" role="tab" aria-controls="rating" aria-selected="false">Rating & Reviews</button>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="mysterybox" role="tabpanel" aria-labelledby="mysterybox-tab">
                <div class="row p-4">
                    <div class="col-lg-4">
                        <img src="img/foodbox.png" class="img-thumbnail" alt="">
                    </div>
					
                    <div class="col-sm-2 col-lg-4 my-auto ps-5">
                        <p class="fs-5 fw-bold">RM ' . $box_price . '</p>
                        <br/>
                        <p class="text-muted">Allergy&nbsp;:&nbsp;&nbsp;&nbsp;' . $box_allergy . ' </p>
                        <p class="text-muted">End at&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;' . $box_endTime . '</p>
						<p class="text-muted">Stock &nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;' . $box_qty . '</p>
                    </div>
				
					<form class="col-4" action="restaurant.php?rest_id=' . $rest_id .'" method="post">
                    <div class="pt-5 pb-5 d-flex justify-content-center align-items-center flex-column">
						<span>Quantity: </span>
                        <div class="input-group mt-2 mb-3" style="width:32%" >
                            <button class="btn btn-outline-primary" type="button" id="minus" onclick="minusQty()">-</button>
                            <input type="number" name="qty" class="form-control text-center" placeholder="" value="1" max="' . $box_qty . '" id="qty" required>
                            <button class="btn btn-outline-primary" type="button" id="plus" onclick="addQty()">+</button>
                        </div>		
                    </div>
					<br/>
					<div class="pt-5 text-end">
						<input type="submit" value="Add to Cart" class="btn btn-primary text-light" style="box-shadow: -1px 6px 15px 1px rgba(143,159,209,0.66);">
						<input type="hidden" name="add_to_cart" value="true">
					</div>
					</form>
                </div>
            </div>

            <div class="tab-pane fade p-4" id="info" role="tabpanel" aria-labelledby="info-tab">
                <br/>
                <h4>Description</h4>
                <p class="pt-3 pb-2 text-muted">' . $rest_desc . '</p>
                <hr>
                <br/>
                <h4>Address</h4>
                <p class="pt-3 pb-2 text-muted"> ' . $rest_add . ' </p>
				<iframe class="col-12" height="200px" src="https://maps.google.com/maps?q=' . $rest_add . '&output=embed"></iframe>
                <hr>
                <br/>
                <h4>Contact</h4>
                <p class="pt-3 pb-2 text-muted"><a href="tel:' . $rest_phone . '">' . $rest_phone . '</a></p>
            </div>';
			
	$query = "SELECT COUNT(rate) AS total_rate FROM order_details 
				WHERE rate > 0 
				AND restaurant_id = $rest_id";
	if ($r = mysqli_query($dbc, $query)) { 
		$row = mysqli_fetch_array($r);
		echo '
            <div class="tab-pane fade p-4" id="rating" role="tabpanel" aria-labelledby="rating-tab">
                <h4 class="text-muted">'.$row['total_rate'].' reviews</h4>
                <hr class="mb-0">
                <table class="table">';
	}
	else {
		echo mysqli_error($dbc) . "The query was: " . $query;
	}
	
	$query = "SELECT * FROM customer c, orders o, order_details od 
				WHERE c.cust_id = o.cust_id 
				AND o.order_id = od.order_id
				AND od.restaurant_id = $rest_id 
				ORDER BY o.order_id DESC";
				
	if ($r = mysqli_query($dbc, $query)) { 
		while ($row = mysqli_fetch_array($r)) {

			$cust_fname = $row['cust_fname'];
			$cust_lname = $row['cust_lname'];
			$order_rate = $row['rate'];
			$order_review = $row['review'];
			$cust_name = substr_replace($cust_fname . " " . $cust_lname, "****", 2, -2);
			
			if ($order_rate != 0) {
				echo'
				<tr>
					<td class="pt-4 pb-4">
						<span class="fw-bold">' . $cust_name . '</span><br/>
						<span class="d-inline-block pt-2">' . $order_review . '</span><br/>
					</td>
					<td class="pt-4 text-center">
						<span class="d-flex align-items-center"><i class="fa fa-star"></i>&nbsp;' . $order_rate .'</span>
					</td>
				</tr>';
			}
		}
	}
	else {
		echo mysqli_error($dbc) . "The query was: " . $query;
	}
            echo '</table>
            </div>
        </div>
    </div>
	';

}
include('footer.php');
?>

    <script>
        var qtyInput = document.getElementById("qty");
        var qty = 0;
		var stock = <?php echo $box_qty; ?>;

        function addQty() {
			qty = parseInt(qtyInput.value);
			if (qty < stock) {
                qty = qty+1;
				qtyInput.value=qty;
            }
        }

        function minusQty() {
			qty = parseInt(qtyInput.value);
            if (qty > 1) {
                qty = qty-1;
                qtyInput.value=qty;
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>