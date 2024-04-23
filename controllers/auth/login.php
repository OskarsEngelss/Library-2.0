<?php
guest();

require "../Core/Validator.php";
require "../Core/Database.php";
$config = require("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new Database($config);
    $errors = [];

    $query = "SELECT * FROM users WHERE email=:email";
    $params = [
        ":email" => $_POST["email"],
    ];
    $user = $db->execute($query, $params)->fetch();
    if (!$user || !password_verify($_POST["password"], $user["password"])) $errors["email"] = "Wrong info";

    if (empty($errors)) {
        $_SESSION["user"] = true;
        $_SESSION["username"] = $user["username"];
        $_SESSION["email"] = $_POST["email"];
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["is_admin"] = $user["is_admin"];
        
        header("Location: /");
        die();
    }
}

$differentStyle = "auth-admin";
$title = "Login";
require "../views/auth/login.view.php";
?>