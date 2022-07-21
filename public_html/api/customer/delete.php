<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object file
include_once '../config/database.php';
include_once '../objects/customer.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare customer object
$customer = new Customer($db);
  
// get customer cust_id
$data = json_decode(file_get_contents("php://input"));
  
// set customer cust_id to be deleted
$customer->cust_id = $data->cust_id;

// delete the customer
if($customer->delete()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array(
        "success" => "1",
        "customer" => "Customer was deleted."));
}
  
// if unable to delete the customer
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array(
        "success" => "0",
        "customer" => "Unable to delete customer."));
}
?>