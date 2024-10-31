<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object file
include_once '../config/database.php';
include_once '../objects/event.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare event object
$event = new Event($db);
  
// get event id
$data = json_decode(file_get_contents("php://input"));
  
// set event id to be deleted
$event->id = $data->id;

// check if the event exists
$event->readOne();

if ($event->name == null) {
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user
    echo json_encode(array("message" => "Unable to delete event. ID not found."));
    exit();
}

// delete the event
if($event->delete()){
  
    // set response code - 200 ok
    http_response_code(200);
  
    // tell the user
    echo json_encode(array("message" => "Event was deleted."));
}
  
// if unable to delete the event
else{
  
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("message" => "Unable to delete event."));
}
?>