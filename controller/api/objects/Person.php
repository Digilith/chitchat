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

    function create() {

    }

    function read()
    {
        $query = "SELECT id, nickname FROM " . $this->table . " ";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    function read_one() {

    }


    function update() {

    }

    function delete() {

    }
}