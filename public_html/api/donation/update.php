<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/donation.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare donation object
$donation = new Donation($db);
  
// get id of donation to be edited
$data = json_decode(file_get_contents("php://input"));
  
// set ID property of donation to be edited
$donation->donation_id = $data->donation_id;
  
// set donation property values
$donation->donation_amount = $data->donation_amount;

// update the donation
if($donation->update()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("donation" => "Donation was updated."));
}
  
// if unable to update the donation, tell the user
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("donation" => "Unable to update donation."));
}
?>