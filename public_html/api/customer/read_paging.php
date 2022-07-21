<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/customer.php';
  
// utilities
$utilities = new Utilities();
  
// instantiate database and customer object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$customer = new Customer($db);
  
// query customer
$stmt = $customer->readPaging($from_record_num, $records_per_page);
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // customer array
    $cust_arr=array();
    $cust_arr["records"]=array();
    $cust_arr["paging"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $cust_item=array(
            "cust_id" => $cust_id,
            "cust_fname" => $cust_fname,
            "cust_lname" => $cust_lname,
            "cust_phone" => $cust_phone,
            "cust_email" => html_entity_decode($cust_email),
            "cust_password" => $cust_password,
        );
  
        array_push($cust_arr["records"], $cust_item);
    }
  
  
    // include paging
    $total_rows=$customer->count();
    $page_url="{$home_url}customer/read_paging.php?";
    $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $cust_arr["paging"]=$paging;
  
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($cust_arr);
}
  
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user customer does not exist
    echo json_encode(
        array("customer" => "No customer found.")
    );
}
?>