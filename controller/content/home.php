<?php

session_start();

if (isset($_SESSION["id"])) {
    $mysqli = require __DIR__ . "/database.php";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>chitchat</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <form action="post">
        <div>
            <p>your message:</p> <br>
            <label for="msg-input"></label>
            <textarea id="msg-input" name="msg-input" rows="1" cols="50">

            </textarea>
        </div>

        <div>
            <h2>latest messages:</h2>
        </div>
    </form>
</body>
</html>
