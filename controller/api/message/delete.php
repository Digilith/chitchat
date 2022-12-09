<?php
//controller, interacts w/ the model in objects
// accessed by anybody
// TODO: proper access
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//TODO: put db in config and person model in model
include_once '../objects/Database.php';
include_once '../objects/Message.php';

//instantiate & connect to db
$database = new Database();
$db = $database->connect();

//instantiate message
$message = new Message($db);

//get id
$data = json_decode(file_get_contents("php://input"));
$message->id = $data->id;

// delete account
if($message->delete()) {
    echo json_encode(
        array('message' => 'Message deleted!')
    );
} else {
    echo json_encode(
        array('message' => 'Failed to delete the message')
    );
}