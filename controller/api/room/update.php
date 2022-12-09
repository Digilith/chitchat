<?php
//controller, interacts w/ the model in objects
// accessed by anybody
// TODO: proper access
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../objects/Database.php';
include_once '../objects/Room.php';

//instantiate & connect to db
$database = new Database();
$db = $database->connect();

//instantiate person
$room = new Room($db);

//get id
$data = json_decode(file_get_contents("php://input"));

// set id for the update
$room->id = $data->id;

// set properties for the update
$room->room_name = $data->room_name;
$room->room_desc = $data->room_desc;

// update room
if($room->update()) {
    echo json_encode(
        array('message' => 'Update successful!')
    );
} else {
    echo json_encode(
        array('message' => 'Failed to update')
    );
}