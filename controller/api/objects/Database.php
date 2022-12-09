<?php
//todo: put db in config
class Database
{
    // db credentials
    private string $host = "db";
    private string $dbname = "chitchat_db";
    private string $username = "root";
    private string $password = "password";
    //connection
    public ?mysqli $conn;

    public function connect(): ?mysqli{

        $this->conn = null;

        try{
            $this->conn = new mysqli($this->host,
                                     $this->username,
                                     $this->password,
                                     $this->dbname);
        } catch (mysqli_sql_exception $err) {
            echo "Connection error: " . $err->getMessage();
        }

        return $this->conn;
    }
}