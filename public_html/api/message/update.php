<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/message.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare message object
$message = new Message($db);
  
// get id of message to be edited
$data = json_decode(file_get_contents("php://input"));
  
// set ID property of message to be edited
$message->message_id = $data->message_id;
  
// set message property values
$message->m_name = $data->m_name;
$message->m_email = $data->m_email;
$message->m_phone = $data->m_phone;
$message->m_comment = $data->m_comment;
  
// update the message
if($message->update()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "Message was updated."));
}
  
// if unable to update the message, tell the user
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("message" => "Unable to update message."));
}
?>