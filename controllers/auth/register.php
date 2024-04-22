<?php
guest();

require "Validator.php";
require "Database.php";
$config = require("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new Database($config);
    $errors = [];

    if (!Validator::string($_POST["username"], min: 1, max: 16 )) $errors["username"] = "Username is 0-16 characters!";
    if (!Validator::email($_POST["email"])) $errors["email"] = "Incorrect email format!";
    if (!Validator::password($_POST["password"])) $errors["password"] = "Password doesn't meet requirements!";
    
    $query = "SELECT * FROM users WHERE email=:email;";
    $params = [
        ":email" => $_POST["email"]
    ];
    $result = $db->execute($query, $params)->fetch();
    if ($result) {
        $errors["email"] = "Email already in use!";
    }

    if (empty($errors)) {
        $query = "INSERT INTO users (username, email, password, is_admin) VALUES (:username, :email, :password, false);";
        $params = [
            ":username" => $_POST["username"],
            ":email" => $_POST["email"],
            ":password" => password_hash($_POST["password"], PASSWORD_BCRYPT)
        ];
        $db->execute($query, $params);

        $_SESSION["flash"] = "Registration complete";
        header("Location: /login");
        die();
    }
}

$differentStyle = "auth-admin";
$title = "Register";
require "views/auth/register.view.php";
?>