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

$result = $person->read();

// get the amount of registered users
$person_count = $result->num_rows();

//TODO: make it work!!!
if($person_count > 0){
    $person_arr = array();
    $person_arr["data"] = array();

    while($row = $result->fetch_assoc()) {
        extract($row);

        $person_item = array(
            "id" => $id,
            "nickname" => $email
        );

        // push to "data"
        array_push($person_arr["data"], $person_item);
    }

    // turn to JSON & output
    echo json_encode($person_arr);

} else {
    echo json_encode(
        array("message" => $result)
    );
}
