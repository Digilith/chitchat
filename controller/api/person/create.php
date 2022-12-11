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
include_once '../objects/Person.php';

//TODO: one db entry point
//instantiate & connect to db
$database = new Database();
$db = $database->connect();

//instantiate person
$person = new Person($db);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

$person->email = $data->email;
$person->nickname = $data->nickname;
$person->password_hash = $data->password_hash;

//create person
if($person->create()) {
    echo json_encode(
        array('message' => 'Person added!', 'email' => $person->email)
    );
} else {
    echo json_encode(
        array('message' => 'Failed to add a person')
    );
}