<?php

class Person
{
    //db connection
    private ?mysqli $conn;
    private string $table = "person";

    //properties
    public int $id;
    public string $email;
    public string $nickname;
    public string $password_hash;

    //constructor w/ db
    public function __construct($db) {
        $this->conn = $db;
    }

    //used for creating a new user account upon registration
    public function create(): bool {
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
        }

        //print error if something goes wrong
        printf("Error: " . $stmt->error);

        return false;
    }

    //lists all the users in a room
    //function read($room_id)
    // TODO: implement query that lists users only in a given room
    public function read(): array
    {
        $query = "SELECT id, nickname 
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

    // update account info (nickname)
    // TODO: access only for the account owner
    public function update(): bool {
        $query = "UPDATE " . $this->table . " 
                  SET nickname = ?
                  WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        //clean user-posted data before insertion
        $this->nickname = htmlspecialchars($this->nickname);
        $this->id = htmlspecialchars($this->id);

        $stmt->bind_param("si",$this->nickname, $this->id);

        if($stmt->execute()){
            return true;
        }

        //print error if something goes wrong
        printf("Error: " . $stmt->error);

        return false;
    }

    //delete an account
    public function delete(): bool{
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