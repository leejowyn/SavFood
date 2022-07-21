<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../config/database.php';
  
// instantiate customer object
include_once '../objects/customer.php';
  
$database = new Database();
$db = $database->getConnection();
  
$customer = new Customer($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if(
    !empty($data->cust_fname) &&
    !empty($data->cust_lname) &&
    !empty($data->cust_phone) &&
    !empty($data->cust_email) &&
    !empty($data->cust_password)
){
  
    // set customer property values
    $customer->cust_fname = $data->cust_fname;
    $customer->cust_lname = $data->cust_lname;
    $customer->cust_phone = $data->cust_phone;
    $customer->cust_email = $data->cust_email;
    $customer->cust_password = $data->cust_password;
  
    // create the customer
    if($customer->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array(
            "success" => "1",
            "customer" => "Customer was created."));
    }
  
    // if unable to create the customer, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array(
            "success" => "0",
            "customer" => "Unable to create customer."));
    }
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array(
        "success" => "0",
        "customer" => "Unable to create customer. Data is incomplete."));
}
?>