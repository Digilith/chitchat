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

    function create (): bool
    {
        $query = "INSERT INTO " . $this->table . " 
                  SET person_id = ?,
                      room_id = ?,
                      message_txt = ?";

        $stmt = $this->conn->prepare($query);

        //clean user-posted data before insertion
        $this->person_id = htmlspecialchars($this->person_id);
        $this->room_id = htmlspecialchars($this->room_id);
        $this->message_txt = htmlspecialchars($this->message_txt);

        $stmt->bind_param("iis",$this->person_id, $this->room_id, $this->message_txt);

        if($stmt->execute()){
            return true;
        }

        //print error if something goes wrong
        printf("Error: " . $stmt->error);

        return false;
    }

    // list all messages in the room
    // TODO: join with the person table to retrieve the username
    function read (): array {
        $query = "SELECT person_id, message_txt 
                  FROM " . $this->table . " 
                  WHERE room_id = ?";

        // bind param
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->room_id);

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

    //delete a message
    function delete (): bool{
        $query = "DELETE FROM " . $this->table . "
                  WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        // clean the user-put id
        $this->id = htmlspecialchars($this->id);

        $stmt->bind_param("i",$this->id);

        if($stmt->execute()){
            return true;
        }

        //print error if something goes wrong
        printf("Error: " . $stmt->error);

        return false;
    }
}