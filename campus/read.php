<?php
// required header
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
include_once '../config/database.php';
include_once '../objects/campus.php';
  
// instantiate database and campus object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$campus = new Campus($db);
  
// query campuss
$stmt = $campus->read();
$num = $stmt->rowCount();
  
// check if more than 0 record found
if($num>0){
  
    // products array
    $campus_arr=array();
    $campus_arr["records"]=array();
  
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $campus_item=array(
            "id" => $id,
            "name" => $name,
        );
  
        array_push($campus_arr["records"], $campus_item);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show campuses data in json format
    echo json_encode($campus_arr);
}
  
else{
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no campuses found
    echo json_encode(
        array("message" => "No campuses found.")
    );
}
?>