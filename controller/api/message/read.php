<?php
//controller, interacts w/ the model in objects
// accessed by anybody
// TODO: proper access
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../objects/Database.php';
include_once '../objects/Message.php';

//instantiate & connect to db
$database = new Database();
$db = $database->connect();

//instantiate message
$message = new Message($db);

// retrieve room id
$room_id = json_decode(file_get_contents("php://input"));
$message->room_id = $room_id;

$data = $message->read();

// checking if any messages were fetched
if(! empty($data)){

    echo json_encode($data);

} else {
    echo json_encode(
        array("message" => "No messages found!")
    );
}
