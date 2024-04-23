<?php
auth();

require "../Core/Database.php";
$config = require("../config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new Database($config);

    $queryUpdate = "UPDATE books SET availability = availability + 1 WHERE id=:id;";
    $db->execute($queryUpdate, [":id" => $_POST["id"]]);

    $queryDelete = "DELETE FROM taken_books WHERE id=:taken_id;";
    $db->execute($queryDelete, [":taken_id" => $_GET["taken_id"]]);

    header("Location: /");
    die();
}
?>