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
?>

<!-- !PAGE CONTENT! -->
<div class="w3-main col-sm-10 mx-auto">

<!--Foodbox-->
    <h1 class="w3-xxxlarge" style="margin-top:75px"><b>Foodbox Menu</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
	
<?php
	$rest_id = $_SESSION['rest_id'];
    //connect the database
    $dbc = mysqli_connect('localhost', 'root', 'newinti2020');

    if (!$dbc) {
		die("Error: " . mysqli_connect_error($dbc));
	}

    //select the database
    mysqli_select_db($dbc, 'savfood');
	
	if ($rest_status == "Approved") {
		echo '<div>
			<button type="button" class="btn" style="background-color: #b5c1e6;">
			<a class="nav-link" href="addfoodbox.php" style="color:black; font-weight:bold;">Add FoodBox</a>
		</div>';
	}
	else {
		echo '<p>Your restaurant is still pending. You will able to add food box after admin approval.</p>';
	}
?>
	
	<div class="w3-container w3-light-grey" style="margin-top:50px" style="overflow-x: auto;">
	<table width="100%">
    <tr>
      <th>ID</th>
      <th>Price</th>
      <th>Quantity</th>
      <th>Allergy</th>
	  <th>Start Time</th>
	  <th>End Time</th>
    </tr>
  
<?php

	$query = "SELECT * FROM foodbox WHERE restaurant_id=$rest_id";

	if ($r = mysqli_query($dbc, $query)) {
		// output data of each row
		if (mysqli_num_rows($r) > 0) {
			while($row = mysqli_fetch_array($r)) {
				echo "<tr><td>" . $row["box_id"]. "</td><td>" . $row["box_price"]. "</td><td>" . $row["box_qty"] . "</td><td>" .
				$row["box_allergy"]. "</td><td>"  .$row["box_startTime"]. "</td><td>" .$row["box_endTime"]. "</td></tr>" ;
			}
		}
		else {echo "0 results";}
		echo "</table>";
	}
	else {
		echo "Error: <br/>" . mysqli_error($dbc) . "The query was: " . $query;
	}

	//close database
    mysqli_close($dbc);
?>
</div>

</body>
</html>