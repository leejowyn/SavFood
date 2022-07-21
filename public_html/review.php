<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">	
    <link rel="stylesheet" href="style.css">
    <title>SavFood - Rate & Review</title>

    <style>
        .checked {
            color: orange;
        }
    </style>
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
	
	echo '
		<br/>
		<div class="col-6 mx-auto">
			<h1>Rate & Review</h1>';

	if (isset($_GET['order_id']) && isset($_GET['box_id']) && isset($_GET['rest_id'])) {
		$order_id = $_GET['order_id'];
		$box_id = $_GET['box_id'];	
		$rest_id = $_GET['rest_id'];
		
		if (isset($_POST['submitted'])) {
			$rate = $_POST['rate'];
			$review = $_POST['review'];
			
			$query = "UPDATE order_details SET rate = '$rate', review = '$review' WHERE order_id = $order_id AND box_id = $box_id";
						
			if (mysqli_query($dbc, $query)) {
				echo '
				<br/><br/>
				<div class="alert alert-success align-middle" role="alert">
					<span class="fs-4 fw-bold"><i class="fa fa-check"></i></span>
					<span>&nbsp;&nbsp;Thank you. Your review has been submitted successfully!</span>
				</div>
				<br/><br/>
				<div class="col-12 text-center">
					<a href="orderhistory.php"><button type="button" class="btn btn-primary text-light">Back to Order History</button></a>
				</div>
				';
			}
			else {
				echo mysqli_error($dbc) . "The query was: " . $query;
			}
			
			$query = "SELECT AVG(rate) AS avgrate FROM order_details 
						WHERE rate > 0 
						AND restaurant_id = $rest_id";
	
			if ($r = mysqli_query($dbc, $query)) { 
				$row = mysqli_fetch_array($r);
				$avg_rate = number_format($row['avgrate'], 1);
			}
			else {
				echo mysqli_error($dbc) . "The query was: " . $query;
			}
			
			$query = "UPDATE restaurant SET restaurant_rate = $avg_rate 
						WHERE restaurant_id = $rest_id";
						
			if (!mysqli_query($dbc, $query)) {
				echo mysqli_error($dbc) . "The query was: " . $query;
			}
		}  
		else {
			$query = "SELECT * FROM orders o, order_details od, restaurant r 
				WHERE o.order_id = od.order_id 
				AND od.restaurant_id = r.restaurant_id 
				AND o.order_id = $order_id 
				AND box_id = $box_id";
					
			if ($r = mysqli_query($dbc, $query)) {
				$row = mysqli_fetch_array($r);
				$rest_name = $row['restaurant_name'];
				$rest_id = $row['restaurant_id'];
				echo '
					<br/>
					<p>How would you rate your experience when ordering from <span class="fw-bold">' . $rest_name . '</span> ?</p>';
			}
			else {
				echo mysqli_error($dbc) . "The query was: " . $query;
			}
			
			echo '
			 <form action="review.php?order_id='. $order_id .'&box_id='. $box_id .'&rest_id='. $rest_id .'" method="post">
				<p class="fw-bold">Rate:</p>
				<!--<span class="fa fa-star checked"></span>
				<span class="fa fa-star checked"></span>
				<span class="fa fa-star checked"></span>
				<span class="fa fa-star"></span>
				<span class="fa fa-star"></span>-->
				
				<div class="rate">
					<input type="radio" id="star5" name="rate" value="5"/>
					<label for="star5" title="text">5 stars</label>
					<input type="radio" id="star4" name="rate" value="4" />
					<label for="star4" title="text">4 stars</label>
					<input type="radio" id="star3" name="rate" value="3" />
					<label for="star3" title="text">3 stars</label>
					<input type="radio" id="star2" name="rate" value="2" />
					<label for="star2" title="text">2 stars</label>
					<input type="radio" id="star1" name="rate" value="1" checked/>
					<label for="star1" title="text">1 star</label>
				</div>
						
				<br/><br/>
				
				<div class="mt-3">
					<p class="fw-bold">Review:</p>
					<textarea class="form-control" name="review" rows="5" placeholder="Share your experience and help others to discover and make better choices!"></textarea>
					<br/>
					<input type="submit" class="btn btn-primary text-light" value="Submit">
					<input type="hidden" name="submitted" value="true">
				</div>
			</form>
			';
		}
	}
       
    echo "</div>";
	
	include('footer.php');

?>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>