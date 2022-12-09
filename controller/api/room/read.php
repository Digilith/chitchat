<?php
//controller, interacts w/ the model in objects
// accessed by anybody
// TODO: proper access
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../objects/Database.php';
include_once '../objects/Room.php';

//instantiate & connect to db
$database = new Database();
$db = $database->connect();

//instantiate room
$room = new Room($db);

$data = $room->read();

// checking if any users were fetched
if(! empty($data)){

    echo json_encode($data);

} else {
    echo json_encode(
        array("message" => "No rooms found!")
    );
}
