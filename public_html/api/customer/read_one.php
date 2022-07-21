<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/customer.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare customer object
$customer = new Customer($db);
  
// set cust_id property of record to read
$customer->cust_id = isset($_GET['cust_id']) ? $_GET['cust_id'] : die();
  
// read the details of customer to be edited
$customer->readOne();
  
if($customer->cust_password!=null){
    // create array
    $cust_arr = array(
        "cust_id" =>  $customer->cust_id,
        "cust_fname" => $customer->cust_fname,
        "cust_lname" => $customer->cust_lname,
        "cust_phone" => $customer->cust_phone,
        "cust_email" => $customer->cust_email,
        "cust_password" => $customer->cust_password,
  
    );
  
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($cust_arr);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user customer does not exist
    echo json_encode(array("customer" => "Customer does not exist."));
}
?>