<?php
//controller, interacts w/ the model in objects
// accessed by anybody
// TODO: proper access
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//TODO: put db in config and person model in model
include_once '../objects/Database.php';
include_once '../objects/Message.php';

//instantiate & connect to db
$database = new Database();
$db = $database->connect();

//instantiate message
$message = new Message($db);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

$message->person_id = $data->person_id;
$message->room_id = $data->room_id;
$message->message_txt = $data->message_txt;

//create person
if($message->create()) {
    echo json_encode(
        array('message' => 'Message sent!')
    );
} else {
    echo json_encode(
        array('message' => 'Failed to send the message')
    );
}