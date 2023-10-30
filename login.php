<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $mysqli = require __DIR__ . "/database.php";

    $email = $mysqli->real_escape_string($_POST["email"]);
    $password = $_POST["password"];

    $sql = sprintf("SELECT * FROM user WHERE email = '%s'", $email);

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($password, $user["password_hash"])) {
            session_start();
            session_regenerate_id();
            $_SESSION["user_id"] = $user["id"];
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
    <title>Login</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, install-scale=1.0">
    <link rel="stylesheet" href="stylesheet_login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<div class="wrapper">
    <form method="post">
        <h1>Login</h1>

        <div class="input-box">
            <input type="text" placeholder="Username" required>
            <i class='bx bxs-user-circle' ></i>
        </div>
        <div class="input-box">
            <input type="password" placeholder="Password" required>
            <i class='bx bxs-lock-alt' ></i>
        </div>
        <button type="submit" class="btn">Login</button>
        <?php if($is_invalid): ?>
            <em>Invalid Login</em>
        <?php endif; ?>
        <div class="register-link">
            <p>Don't have an Account!
                <a href="signup.html">Register</a>
            </p>
        </div>
    </form>
</div>
</body>
</html>
