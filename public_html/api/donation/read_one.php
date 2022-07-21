<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/donation.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare donation object
$donation = new Donation($db);
  
// set donation_id property of record to read
$donation->donation_id = isset($_GET['donation_id']) ? $_GET['donation_id'] : die();
  
// read the details of donation to be edited
$donation->readOne();
  
if($donation->donation_amount!=null){
    // create array
    $donation_arr = array(
        "donation_id" =>  $donation->donation_id,
        "donation_amount" => $donation->donation_amount,
        "donation_datetime" => $donation->donation_datetime,
    );
  
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($donation_arr);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user donation does not exist
    echo json_encode(array(
        "donation" => "Donation does not exist."));
}
?>