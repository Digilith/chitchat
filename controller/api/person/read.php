<?php
//controller, interacts w/ the model in objects
// accessed by anybody
// TODO: proper access
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

//TODO: put db in config and person model in model
include_once '../objects/Database.php';
include_once '../objects/Person.php';

//instantiate & connect to db
$database = new Database();
$db = $database->connect();

//instantiate person
$person = new Person($db);

$data = $person->read();

// checking if any users were fetched
if(! empty($data)){

    echo json_encode($data);

} else {
    echo json_encode(
        array("message" => "No users found!")
    );
}
