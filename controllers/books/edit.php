<?php
auth();
is_admin();

require "Validator.php";
require "Database.php";
$config = require("config.php");
$db = new Database($config);

$query = "SELECT * FROM books WHERE id=:id";
$params = [
    ":id" => $_GET["id"]
];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
  $errors = [];

  if (!Validator::string($_POST["title"], min: 1, max: 255)) $errors["title"] = "Title can't be empty or longer than 255 characters!";
  if (!Validator::string($_POST["author"], min: 1, max: 255)) $errors["author"] = "Author can't be empty or longer than 255 characters!";
  if ($_POST["released"] == "" || !Validator::date($_POST["released"])) $errors["released"] = "Release data has to be a date!";
  if (!Validator::number($_POST["availability"])) $errors["availability"] = "Availability can't be less than less than 0 characters!";

  if (empty($errors)) {
    $query = "UPDATE books SET title = :title, author = :author, released = :released, availability = :availability WHERE id = :id;";
    $params = [
        ":id" => $_POST["id"],
        ":title" => $_POST["title"],
        ":author" => $_POST["author"],
        ":released" => $_POST["released"],
        ":availability" => $_POST["availability"],
    ];

    $db->execute($query, $params);
    header("Location: /");
    die();
  }
}

$book = $db->execute($query, $params)->fetch();

$differentStyle = "auth-admin";
$title = "Edit the book";
require "views/books/edit.view.php";
?>