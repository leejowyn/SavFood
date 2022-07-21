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

<?

include 'displayprofile.php';

?>

<!-- !PAGE CONTENT! -->
<div class="w3-main col-sm-10 mx-auto">

<!--Foodbox-->
    <h1 class="w3-xxxlarge" style="margin-top:15px"><b>Restaurant Profile</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
	
	
	<div class="w3-container w3-light-grey" style="margin-top:40px">

	
<?php

$rest_id=$_SESSION['rest_id'];
$connection = mysqli_connect("localhost", "root", "newinti2020", "savfood");
// Check connection
if ($connection->connect_error) {
die("Connection failed: " . $connection->connect_error);
}
$sql = "SELECT restaurant_id, restaurant_name, restaurant_desc, restaurant_cuisine, restaurant_unit, restaurant_building, restaurant_street,
		restaurant_postcode, restaurant_city, restaurant_state, restaurant_phone, restaurant_image,
		restaurant_email FROM restaurant WHERE restaurant_id=$rest_id";
$result = $connection->query($sql);
if ($result->num_rows > 0) {
// output data of each row
while($row = $result->fetch_assoc()) {
	$address = $row["restaurant_unit"] . ", " . $row["restaurant_building"] . ", " .$row["restaurant_street"] . ", " .$row["restaurant_postcode"] . ", " .$row["restaurant_city"] . ", " .$row["restaurant_state"];
echo "<div class=\"row\">
	<div class=\"col\" style=\"display:flex;justify-content:center;align-items:center\">
		<img src=\"img/" . $row["restaurant_image"] . "\" width=\"400px\">
	</div>
	<div class=\"col\" style=\"padding:20px\">
	<p><b>Id: </b>" . $row["restaurant_id"] . "</p>
	<p><b>Name: </b>" . $row["restaurant_name"] . "</p>
	<p><b>Description: </b>" . $row["restaurant_desc"] . "</p>
	<p><b>Cuisine: </b>" . $row["restaurant_cuisine"] . "</p>
	<p><b>Address: </b>" . $address . "</p>
	<p><b>Phone: </b>" . $row["restaurant_phone"] . "</p>
	<p><b>Email: </b>" . $row["restaurant_email"] . "</p>
	</div>
	
	</div>
	";

}
} else { echo "0 results"; }
$connection->close();
?>

  </div>



</body>
</html>