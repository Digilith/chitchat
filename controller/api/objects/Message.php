<?php

class Message
{
    //db connection
    private ?mysqli $conn;
    private string $table = "message";

    //properties
    public int $id;
    public int $person_id;
    public int $room_id;
    public string $message_txt;

    //constructor w/ db
    public function __construct($db) {
        $this->conn = $db;
    }

    function create () {

    }

    // list all messages in the room
    // TODO: join with the person table to retrieve the username
    function read (): array {
        $query = "SELECT person_id, message_txt 
                  FROM " . $this->table . " 
                  WHERE room_id = ?
                  ORDER BY id DESC";

        // bind the room id
        $stmt = $this->conn->prepare($query);
        $stmt->bind_params("i", $this->room_id);

        // retrieving an array of rows
        $stmt = $this->conn->query($query);


        // storing them in data
        $data = [];

        // array of row data
        while ($row = $stmt->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    function delete () {

    }
}