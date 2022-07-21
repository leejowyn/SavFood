<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
// include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/message.php';
  
// instantiate database and message object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$message = new Message($db);
  
// get keywords
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";
  
// query message
$stmt = $message->search($keywords);
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // message array
    $message_arr=array();
    $message_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $message_item=array(
            "message_id" => $message_id,
            "m_name" => $m_name,
            "m_email" => html_entity_decode($m_email),
            "m_phone" => $m_phone,
            "m_comment" => $m_comment,
        );
  
        array_push($message_arr["records"], $message_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show message data
    echo json_encode($message_arr);
}
  
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no message found
    echo json_encode(
        array("message" => "No message found.")
    );
}
?>