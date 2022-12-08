<?php

//flag for checking credentials
$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $mysqli = require __DIR__ . "/database.php";

    //query with sql-injection protection
    $sql = sprintf("SELECT * FROM person
            WHERE nickname = '%s'",
            $mysqli->real_escape_string($_POST["nickname"]));

    //getting an associative array
    $result = $mysqli->query($sql);

    $person = $result->fetch_assoc();

    //using special method password_verify
    if ($person) {
        if (password_verify($_POST["password"], $person["password_hash"])) {
            //starting or resuming the session
            //storing the user's id in the super-global
            session_start();

            //preventing session fixation attack
            session_regenerate_id();

            $_SESSION["id"] = $person["id"];

            header("Location: index.php");
            exit;
        }
    }

    $is_invalid = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>chitchat|login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1> login </h1>
    <!--displaying a message about invalid credentials-->
    <?php if($is_invalid): ?>
        <em>Invalid login</em>
    <?php endif; ?>
    <form method="post">
         <!--saving the filled nickname form-->
        <div>
            <label for="nickname">nickname</label>
            <input type="text" id="nickname" name="nickname"
                   value="<?= htmlspecialchars($_POST["nickname"] ?? "") ?>">
        </div>

        <div>
            <label for="password">password</label>
            <input type="password" id="password" name="password">
        </div>

        <button>login</button>
    </form>
</body>