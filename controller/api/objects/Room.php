<?php

class Room
{
    //db connection
    private ?mysqli $conn;
    private string $table = "room";

    //properties
    public int $id;
    public int $admin_id;
    public string $room_name;
    public string $room_desc;

    //constructor w/ db
    public function __construct($db) {
        $this->conn = $db;
    }

    // create a room
    function create(): bool{
        $query = "INSERT INTO " . $this->table . " 
                  SET admin_id = ?,
                      room_name = ?,
                      room_desc = ?";

        $stmt = $this->conn->prepare($query);

        //clean user-posted data before insertion
        $this->admin_id = htmlspecialchars($this->admin_id);
        $this->room_name = htmlspecialchars($this->room_name);
        $this->room_desc = htmlspecialchars($this->room_desc);

        $stmt->bind_param("iss",$this->admin_id, $this->room_name, $this->room_desc);

        if($stmt->execute()){
            return true;
        }

        //print error if something goes wrong
        printf("Error: " . $stmt->error);

        return false;
    }

    // list all the rooms
    function read(): array{
        $query = "SELECT room_name, room_desc 
                  FROM " . $this->table . " 
                  ORDER BY id DESC";

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

    //edit room's name and description
    function update(): bool {
        $query = "UPDATE " . $this->table . " 
                  SET room_name = ?,
                      room_desc = ?
                  WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        //clean user-posted data before insertion
        $this->room_name = htmlspecialchars($this->room_name);
        $this->room_desc = htmlspecialchars($this->room_desc);
        $this->id = htmlspecialchars($this->id);

        $stmt->bind_param("ssi",$this->room_name, $this->room_desc, $this->id);

        if($stmt->execute()){
            return true;
        }

        //print error if something goes wrong
        printf("Error: " . $stmt->error);

        return false;
    }

    //delete the room
    function delete(): bool {
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