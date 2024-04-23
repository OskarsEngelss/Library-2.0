<?php
date_default_timezone_set('Europe/Moscow');
require "../Core/Database.php";
$config = require("../config.php");
$db = new Database($config);

$query = "SELECT * FROM books";
$params = [];

if (isset($_SESSION["user"])) {
    $books = $db->execute($query, $params)->fetchAll();

    $userQuery = "SELECT * FROM users WHERE id=:id";
    $params = [
        ":id" => $_SESSION["user_id"]
    ];
    $user = $db->execute($userQuery, $params)->fetch();

    $taken_books_query = "SELECT books.*, taken_books.reserveTime, taken_books.id AS taken_id FROM books JOIN taken_books ON books.id=taken_books.book_id AND taken_books.user_id=:id";
    $params = [
        ":id" => $_SESSION["user_id"]
    ];
    $taken_books = $db->execute($taken_books_query, $params)->fetchAll();

} else {
    $books = $db->execute($query, $params)->fetchAll();
}

$differentStyle = "mainStyle";
$title = "List of books";
require "../views/books/index.view.php";
?>