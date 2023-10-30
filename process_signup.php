<?php
if (empty($_POST["name"])) {
    die("Name is required!");
}

if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Enter a valid Email");
}

if (strlen($_POST["Password"]) < 8) {
    die("Enter a valid password with a minimum of 8 characters");
}

if (!preg_match("/[a-z]/i", $_POST["Password"])) {
    die("Password must contain at least one character");
}

if (!preg_match("/[0-9]/", $_POST["Password"])) {
    die("Password must contain at least one number");
}

if ($_POST["Password"] !== $_POST["Repeat_Password"]) {
    die("Passwords do not match");
}

$password_hash = password_hash($_POST["Password"], PASSWORD_DEFAULT);

$mysqli = require __DIR__ . "/database.php";

$sql = "INSERT INTO user (name, email, password_hash)
        VALUES (?, ?, ?)";

$stmt = $mysqli->stmt_init();

if (!$stmt->prepare($sql)) {
    die("SQL Error: " . $mysqli->error);
}

$stmt->bind_param("sss", $_POST["name"], $_POST["email"], $password_hash);

if ($stmt->execute()) {
    header("Location: success_signup.html");
    exit();
} else {
    die($mysqli->error . " " . $mysqli->errno);
}
?>
