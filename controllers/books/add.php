<?php
auth();
is_admin();

require "../Core/Validator.php";
require "../Core/Database.php";
$config = require("../config.php");
$db = new Database($config);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $errors = [];

  $query = "SELECT id FROM authors WHERE name = :author;";
  $params = [
    ":author" => $_POST["author"]
  ];
  $authorName = $db->execute($query, $params)->fetch();
  if (empty($authorName) && !isset($_POST["is_new"])) $errors["author"] = "Author not found!";
  
  if (!Validator::string($_POST["title"], min: 1, max: 255)) $errors["title"] = "Title can't be empty or longer than 255 characters!";
  if (!Validator::string($_POST["author"], min: 1, max: 255)) $errors["author"] = "Author can't be empty or longer than 255 characters!";
  if ($_POST["released"] == "" || !Validator::date($_POST["released"])) $errors["released"] = "Release data has to be a date!";
  if (!Validator::number($_POST["availability"])) $errors["availability"] = "Availability can't be less than less than 0 characters!";

  if (empty($errors)) {
    if (isset($_POST["is_new"])) {
      $query = "INSERT INTO authors (name) VALUES (:author);";
      $params = [
        ":author" => $_POST["author"]
      ];
      $db->execute($query, $params);
    }

    $query = "INSERT INTO books (title, author, released, availability) VALUES (:title, (SELECT id FROM authors WHERE name = :author), :released, :availability);";
    $params = [
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

$differentStyle = "auth-admin";
$title = "Add new book";
require "../views/books/add.view.php";
?>