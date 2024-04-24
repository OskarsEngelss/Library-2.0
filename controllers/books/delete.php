<?php
auth();
is_admin();

require "../Core/Database.php";
$config = require("../config.php");
$db = new Database($config);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    $is_taken_query = "SELECT * FROM taken_books WHERE book_id=:id";
    $params = [
        ":id" => $_POST["id"]
    ];
    $taken_books = $db->execute($is_taken_query, $params)->fetchAll();

    if (!empty($taken_books)) $errors["taken_book"] = "Borrowed books can't be deleted!";

    if (empty($errors)) {
        $query = "DELETE FROM books WHERE id=:id";
        $params = [
            ":id" => $_POST["id"]
        ];
        
        $db->execute($query, $params);
        
        header("Location: /book-delete");
        die();
    }
}

$query = "SELECT * FROM books";
$params = [];
$books = $db->execute($query, $params)->fetchAll();

$differentStyle = "mainStyle";
$title = "Delete Book";
require "../views/books/delete.view.php";
?>