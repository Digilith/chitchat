<?php
//controller, interacts w/ the model in objects
// accessed by anybody
// TODO: proper access
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//TODO: put db in config and person model in model
include_once '../objects/Database.php';
include_once '../objects/Person.php';

//instantiate & connect to db
$database = new Database();
$db = $database->connect();

//instantiate person
$person = new Person($db);

//get id
$data = json_decode(file_get_contents("php://input"));

// set id for the update
$person->id = $data->id;

// set properties for the update
$person->nickname = $data->nickname;

// update person
if($person->update()) {
    echo json_encode(
        array('message' => 'Update successful!')
    );
} else {
    echo json_encode(
        array('message' => 'Failed to update')
    );
}