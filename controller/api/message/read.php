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

// get the room id if there's any, else die
$message->room_id = $_GET['room_id'] ?? die("No messages found!");

$data = $message->read();

// checking if any messages were fetched
if(! empty($data)){

    echo json_encode($data);

} else {
    echo json_encode(
        array("message" => "No messages found!")
    );
}
