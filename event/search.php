<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/event.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare event object
$event = new Event($db);

// get search terms from URL
$name = isset($_GET["name"]) ? $_GET["name"] : "";
$campus = isset($_GET["campus"]) ? $_GET["campus"] : "";

// query events
$stmt = $event->search($name, $campus);
$num = $stmt->rowCount();

// check if more than 0 record found
if($num > 0){

    // events array
    $event_arr = array();
    $event_arr["records"] = array();

    // retrieve our table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        extract($row);

        $event_item = array(
            "id" => $id,
            "name" => $name,
            "image" => $image,
            "description" => html_entity_decode($description),
            "startdatetime" => $startdatetime,
            "endtime" => $endtime,
            "campus_id" => $campus_id,
            "campus_name" => $campus_name,
            "capacity" => $capacity,
            "status" => $status
        );

        array_push($event_arr["records"], $event_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show event data
    echo json_encode($event_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no events found
    echo json_encode(
        array("message" => "No events found.")
    );
}
?>