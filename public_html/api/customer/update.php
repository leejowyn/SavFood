<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/customer.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare customer object
$customer = new Customer($db);
  
// get id of customer to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of customer to be edited
$customer->cust_id = $data->cust_id;
  
// set customer property values
$customer->cust_fname = $data->cust_fname;
$customer->cust_lname = $data->cust_lname;
$customer->cust_phone = $data->cust_phone;
$customer->cust_email = $data->cust_email;
$customer->cust_password = $data->cust_password;
  
// update the customer
if($customer->update()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array(
        "success" => "1",
        "customer" => "Customer was updated."));
}
  
// if unable to update the customer, tell the user
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array(
        "success" => "0",
        "customer" => "Unable to update customer."));
}
?>