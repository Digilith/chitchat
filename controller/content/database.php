<?php

//using 'db' instead of 'localhost' since that what i've linked in the docker-compose
$host = "db";
$dbname = "chitchat_db";
$username = "root";
$password = "password";

$mysqli = new mysqli(hostname: $host,
                     username: $username,
                     password: $password,
                     database: $dbname);
if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_errno);
}

return $mysqli;