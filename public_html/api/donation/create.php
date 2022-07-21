<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../config/database.php';
  
// instantiate donation object
include_once '../objects/donation.php';
  
$database = new Database();
$db = $database->getConnection();
  
$donation = new Donation($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if(
    !empty($data->donation_amount) &&
    !empty($data->donation_datetime) &&
    !empty($data->cust_id)

){
  
    // set donation property values
    $donation->donation_amount = $data->donation_amount;
    $donation->donation_datetime = $data->donation_datetime;
    $donation->cust_id = $data->cust_id;

    // create the donation
    if($donation->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array(
            "success" => "1",    
            "donation" => "Donation was created."));
    }
  
    // if unable to create the donation, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array(
            "success" => "0",
            "donation" => "Unable to create donation."));
    }
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array(
        "success" => "0",
        "donation" => "Unable to create donation. Data is incomplete."));
}
?>