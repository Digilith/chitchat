<?php

//starting or resuming the session
session_start();

if (isset($_SESSION["id"])) {

    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM person
            WHERE id = {$_SESSION["id"]}";

    $result = $mysqli->query($sql);

    $person = $result->fetch_assoc();

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
    <h1>chitchat</h1>
    <!--if the user's logged in, display the app, else prompt them to log in-->
    <?php if (isset($person)): ?>
        <p>Hello, <?= htmlspecialchars($person["nickname"]) ?></p>

        <a href="logout.php">Log out</a>
    <?php else: ?>
        <p><a href="login.php">Log in</a> or
        <a href="signup.html">sign up</a></p>
    <?php endif; ?>
</body>
</html>
