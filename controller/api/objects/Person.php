<?php

class Person
{
    //db connection
    private ?mysqli $conn;
    private $table = "person";

    //properties
    public $id;
    public $email;
    public $nickname;
    public $password_hash;

    //constructor w/ db
    public function __construct($db) {
        $this->conn = $db;
    }

    //used for creating a new user account upon registration
    function create(): bool {
        //inserting values into the person table
        $query = "INSERT INTO " . $this->table . " 
                  SET nickname = ?,
                      email = ?,
                      password_hash = ?";

        $stmt = $this->conn->prepare($query);

        //clean user-posted data before insertion
        $this->email = htmlspecialchars($this->email);
        $this->nickname = htmlspecialchars($this->nickname);
        $this->password_hash = htmlspecialchars($this->password_hash);

        $stmt->bind_param("sss",$this->nickname, $this->email, $this->password_hash);

        if($stmt->execute()){
            return true;
        };

        //print error if something goes wrong
        printf("Error: " . $stmt->error);

        return false;
    }

    //lists all the users in a room
    //function read($room_id)
    function read(room_id)
    {
        $query = "SELECT id, nickname 
                  FROM " . $this->table . "
                  ORDER BY id DESC";

        //TODO: implement this PROPERLY, redesign the db
//        $query = "SELECT id, nickname
//                  FROM " . $this->table . " as p
//                  FULL OUTER JOIN person_room
//                  ON p.id = person_room.id
//                  WHERE person_room.room_id = ?
//                  ORDER BY id DESC
//                  ";

        $stmt = $this->conn->prepare($query);

//      $stmt->bind_param("i", $room_id);

        $stmt->execute();

        return $stmt;
    }

    function read_one() {
        $query = "SELECT id, nickname 
                  FROM " . $this->table . "
                  WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("i", $this->id);

        $stmt->execute();

        return $stmt;
    }


    function update() {

    }

    function delete() {

    }
}