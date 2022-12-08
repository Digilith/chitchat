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

    function set_params($email, $nickname, $password_hash)
    {
        //clean data
        $this->email = htmlspecialchars(strip_tags($email));
        $this->nickname = htmlspecialchars(strip_tags($nickname));
        $this->password_hash = htmlspecialchars(strip_tags($password_hash));
    }

    function create(): bool {
        $query = "INSERT INTO " . $this->table . " 
                  SET nickname = ?,
                      email = ?,
                      password_hash = ?";

        $stmt = $this->conn->prepare($query);

        //clean data
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

    function read()
    {
        $query = "SELECT id, nickname FROM " . $this->table . " ";

        $stmt = $this->conn->prepare($query);

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