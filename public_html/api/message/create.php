<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../config/database.php';
  
// instantiate message object
include_once '../objects/message.php';
  
$database = new Database();
$db = $database->getConnection();
  
$message = new Message($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if(
    !empty($data->m_name) &&
    !empty($data->m_email) &&
    !empty($data->m_phone) &&
    !empty($data->m_comment)
){
  
    // set message property values
    $message->m_name = $data->m_name;
    $message->m_email = $data->m_email;
    $message->m_phone = $data->m_phone;
    $message->m_comment = $data->m_comment;

    // create the message
    if($message->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array(
            "success" => "1",
            "message" => "Message was created."
        ));
    }
  
    // if unable to create the message, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array(
            "success" => "0",
            "message" => "Unable to create message."));
    }
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array(
        "success" => "0",
        "message" => "Unable to create message. Data is incomplete."));
}
?>