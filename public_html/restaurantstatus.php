<!DOCTYPE html>
<html lang="en">
<title>Restaurant Admin</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" 
	integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">	
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="style.css">

<body>

<?php

include 'r_header.php';

?>

<!-- !PAGE CONTENT! -->
<div class="w3-main col-sm-10 mx-auto">

    <h1 class="w3-xxxlarge" style="margin-top:15px"><b>Orders</b></h1>
    <hr style="width:50px;border:5px solid red" class="w3-round">
	<div class="w3-container w3-light-grey" style="margin-top:80px">
	<table width="100%">
    <tr>
	<th>Order ID</th>
	<th>Quantity</th>
	<th>Box ID</th>
	<th>Order Datetime</th>
	<th>Customer ID</th>
	<th>Status</th>
    </tr>
	
<?php

$rest_id=$_SESSION['rest_id'];
$connection = mysqli_connect("localhost", "root", "newinti2020", "savfood");
// Check connection
if ($connection->connect_error) {
die("Connection failed: " . $connection->connect_error);
}
$sql = "SELECT * FROM orders o, order_details od 
		WHERE o.order_id = od.order_id
		AND restaurant_id=$rest_id";
$result = $connection->query($sql);
if ($result->num_rows > 0) {
// output data of each row
while($row = $result->fetch_assoc()) {
echo "<tr><td>" . $row["order_id"]. "</td><td>" . $row["quantity"] . "</td><td>"
. $row["box_id"]. "</td><td>"  . $row["order_datetime"] . "</td><td>"  . $row["cust_id"] . "</td><td>" . $row["status"]. "</td></tr>";
}
echo "</table>";
} else { echo "0 results"; }
$connection->close();
?>
  </div>
</body>
</html>
