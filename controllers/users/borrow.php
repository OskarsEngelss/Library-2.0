<?php
auth();

require "Validator.php";
require "Database.php";
$config = require("config.php");
$db = new Database($config);

$query = "SELECT * FROM books WHERE id=:id;";
$params = [
    ":id" => $_GET["id"]
];
$book = $db->execute($query, $params)->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    if (new DateTime($_POST["reserveTime"]) < new DateTime()) $errors["reserveTime"] = "Can't Borrow The Past!";
    if ($_POST["reserveTime"] == "" || !Validator::date($_POST["reserveTime"])) $errors["reserveTime"] = "Input Borrowing Time!";

    if (empty($errors)) {
        $query = "UPDATE books SET availability = availability - 1 WHERE id=:id; INSERT INTO taken_books (book_id, user_id, reserveTime) VALUES (:id, :user_id, :reserveTime);";

        $params = [
            ":id" => $book["id"],
            ":user_id" => $_SESSION["user_id"],
            ":reserveTime" => $_POST["reserveTime"]
        ];
        $db->execute($query, $params); 
        header("Location: /");
        die();
    }
}

$differentStyle = "auth-admin";
$title = "Borrowing a book";
require "views/users/borrow.view.php";
?>