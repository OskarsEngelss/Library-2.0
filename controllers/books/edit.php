<?php
auth();
is_admin();

require "../Core/Validator.php";
require "../Core/Database.php";
$config = require("../config.php");
$db = new Database($config);

$query = "SELECT books.*, authors.name as author FROM books JOIN authors ON books.author=authors.id WHERE books.id=:id";
$params = [
  ":id" => $_GET["id"]
];
$book = $db->execute($query, $params)->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
  $errors = [];

  $query = "SELECT id FROM authors WHERE name = :author;";
  $params = [
    ":author" => $_POST["author"]
  ];
  $authorName = $db->execute($query, $params)->fetch();
  if (empty($authorName) && !isset($_POST["is_new"])) $errors["author"] = "Author not found!";
  if (!empty($authorName) && isset($_POST["is_new"])) $errors["author"] = "Author already exists!";

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

    $query = "UPDATE books SET title = :title, author = (SELECT id FROM authors WHERE name = :author), released = :released, availability = :availability WHERE id = :id;";
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

$differentStyle = "auth-admin";
$title = "Edit the book";
require "../views/books/edit.view.php";
?>