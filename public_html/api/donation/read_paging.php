<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/donation.php';
  
// utilities
$utilities = new Utilities();
  
// instantiate database and donation object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$donation = new Donation($db);
  
// query donation
$stmt = $donation->readPaging($from_record_num, $records_per_page);
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // donation array
    $donation_arr=array();
    $donation_arr["records"]=array();
    $donation_arr["paging"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $donation_item=array(
            "donation_id" => $donation_id,
            "donation_amount" => $donation_amount,
        );
  
        array_push($donation_arr["records"], $donation_item);
    }
  
  
    // include paging
    $total_rows=$donation->count();
    $page_url="{$home_url}donation/read_paging.php?";
    $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $donation_arr["paging"]=$paging;
  
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($donation_arr);
}
  
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user donation does not exist
    echo json_encode(
        array("donation" => "No donation found.")
    );
}
?>