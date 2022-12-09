<?php
//controller, interacts w/ the model in objects
// accessed by anybody
// TODO: proper access
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../objects/Database.php';
include_once '../objects/Room.php';

//instantiate & connect to db
$database = new Database();
$db = $database->connect();

//instantiate room
$room = new Room($db);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

$room->admin_id = $data->admin_id;
$room->room_name = $data->room_name;
$room->room_desc = $data->room_desc;

//create room
if($room->create()) {
    echo json_encode(
        array('message' => 'Room added!')
    );
} else {
    echo json_encode(
        array('message' => 'Failed to add a room')
    );
}