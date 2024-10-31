<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../config/database.php';
  
// instantiate event object
include_once '../objects/event.php';
  
$database = new Database();
$db = $database->getConnection();
  
$event = new Event($db);
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
  
// make sure data is not empty
if(
    !empty($data->name) &&
    !empty($data->image) &&
    !empty($data->description) &&
    !empty($data->startdatetime) &&
    !empty($data->endtime) &&
    !empty($data->campus_id) &&
    !empty($data->capacity)
){
  
    // set event property values
    $event->name = $data->name;
    $event->image = $data->image;
    $event->description = $data->description;
    $event->startdatetime = $data->startdatetime;
    $event->endtime = $data->endtime;
    $event->campus_id = $data->campus_id;
    $event->capacity = $data->capacity;
    $event->status = "Published"; // Set status to published
  
    // create the event
    if($event->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "Event was created."));
    }
  
    // if unable to create the event, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("message" => "Unable to create event."));
    }
}
  
// tell the user data is incomplete
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create event. Data is incomplete."));
}
?>