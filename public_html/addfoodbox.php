<!DOCTYPE html>
<html lang="en">
<title>Restaurant Admin</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" 
	integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">	
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<body>

<?php

include 'r_header.php';

$price = "";
$quantity = "";
$allergy = "";
$start = ""; 
$end ="";
$rid ="";
$msg = "";
$addFoodBox = true;

if (isset($_SESSION['rest_id'])) {
	$rest_id=$_SESSION['rest_id'];
}

$db = mysqli_connect('localhost', 'root', 'newinti2020');
mysqli_select_db($db, 'savfood');


if (isset($_POST['add_foodbox'])) {
  date_default_timezone_set("Asia/Kuala_Lumpur");
  $price = $_POST['price'];
  $quantity = $_POST['quantity'];
  $allergy = $_POST['allergy'];
  $start = date('Y-m-d H:i:00', strtotime($_POST['start']));
  $end = date('Y-m-d H:i:00', strtotime($_POST['end']));

  $tdyDate = date("Y-m-d 00:00:00");
	  
	if ($end > $start) {
		$query = "SELECT * FROM foodbox WHERE restaurant_id = '$rest_id' ORDER BY box_id DESC LIMIT 1";
		
		if ($r = mysqli_query($db, $query)) {
			if (mysqli_num_rows($r) > 0) {
				$row = mysqli_fetch_array($r);
				$latestStartTime = $row['box_startTime'];
				
				if ($latestStartTime > $tdyDate) {
					$msg = "Failed to add food box. You can only add one food box per day. ";
					$addFoodBox = false;
				}
			}
			if ($addFoodBox) {
				$query = "INSERT INTO foodbox (box_id, box_price, box_qty, box_allergy, box_startTime, box_endTime, restaurant_id) 
				  VALUES(null, '$price', '$quantity', '$allergy', '$start', '$end', '$rest_id')";
				  
				if (mysqli_query($db, $query)) {
					$msg = "Food box added successfully!";
				}
				else {
					echo "Error: <br/>" . mysqli_error($db) . "The query was: " . $query;
				}
			}
		}
		else {
			echo "Error: <br/>" . mysqli_error($db) . "The query was: " . $query;
		}
		
	}
	else {
		$msg = "End time cannot be before start time.";
	}
}

?>

<!-- !PAGE CONTENT! -->
<div class="w3-main col-sm-10 mx-auto">

<!-- Add foodbox-->
  <div class="w3-container" id="contact" style="margin-top:15px">

    <h1 class="w3-xxxlarge"><b>Add Foodbox</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
	<?php echo '<p>' . $msg . '</p>'; ?>
    <p>Fill in your foodbox details below for sale.</p>
    
	<form action="addfoodbox.php" class="col-4" method="post">
	<div class="w3-section">	  
      <div class="w3-section">
        <label>Price</label>
        <input class="w3-input w3-border" type="number" name="price" step="any" required>
      </div>
	  
      <div class="w3-section">
        <label>Quantity</label>
        <input class="w3-input w3-border" type="number" name="quantity" required>
      </div>
	  
	  <div class="w3-section">
        <label>Allergies</label>
        <input class="w3-input w3-border" type="text" name="allergy" required>
      </div>
	  
	  <div class="w3-section">
         <label>Start Time:</label>
		<input class="w3-input w3-border" type="time" name="start" required>
      </div>
	  
	  <div class="w3-section">
         <label>End Time:</label>
		<input class="w3-input w3-border" type="time" name="end" required>
      </div>
	  
    <input type="submit" class="btn" style="background-color: #b5c1e6;" value="Add">
	<input type="hidden" name="add_foodbox" value="true">
	</div>
  
  </form> 
 </div>
 </div>
  
</body>
</html>