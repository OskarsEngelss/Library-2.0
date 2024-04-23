<?php
auth();

require "../Core/Validator.php";
require "../Core/Database.php";
$config = require("../config.php");
$db = new Database($config);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $errors = [];

  if (!Validator::string($_POST["profilePicture"], min: 1)) $errors["profilePicture"] = "You have to input an image link";

  if (empty($errors)) {
    $query = "UPDATE users SET profilePicture = :profilePicture WHERE id=:id;";
    $params = [
        ":id" => $_SESSION["user_id"],
        ":profilePicture" => $_POST["profilePicture"]
    ];

    $db->execute($query, $params);
    header("Location: /");
    die();
  }
}

$differentStyle = "auth-admin";
$title = "Change Profile Picture";
require "../views/users/setPicture.view.php";
?>