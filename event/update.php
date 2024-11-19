<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/event.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare event object
$event = new Event($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set ID property of event to be edited
$event->id = $data->id;

// check if the event exists
$event->readOne();

if ($event->name == null) {
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user
    echo json_encode(array("message" => "Unable to update event. ID not found."));
    exit();
}

// make sure data is not empty
if (
    !empty($data->name) &&
    !empty($data->image) &&
    !empty($data->description) &&
    !empty($data->startdatetime) &&
    !empty($data->endtime) &&
    !empty($data->campus_id) &&
    !empty($data->capacity)
) {
    // set event property values
    $event->name = $data->name;
    $event->image = $data->image;
    $event->description = $data->description;
    $event->startdatetime = $data->startdatetime;
    $event->endtime = $data->endtime;
    $event->campus_id = $data->campus_id;
    $event->capacity = $data->capacity;
    $event->status = "Published"; // Explicitly set status to "Published"

    // update the event
    if ($event->update()) {
        // set response code - 200 ok
        http_response_code(200);

        // tell the user
        echo json_encode(array("message" => "Event was updated."));
    } else {
        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to update event."));
    }
} else {
    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to update event. Data is incomplete."));
}
?>