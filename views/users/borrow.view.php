<?php require "../views/components/head.php" ?>
<?php require "../views/components/navbar.php" ?>

<div>
    <div class="borrowClarification">
        <p>Book: <?=$book["title"]?></p>
        <p>Written by: <?=$book["author"]?></p>
    </div>

    <form method="POST" action="/borrow?id=<?= $book["id"] ?>">
        <input type="hidden" name="id" value="<?= $book["id"] ?>" />
        <label>
            Borrow Time:
            <input type="datetime-local" name="reserveTime" value="<?=($_POST["reserveTime"] ?? "")?>" />
            <?php if(isset($errors["reserveTime"])) { ?> 
                <p class="invalid-data"><?= $errors["reserveTime"] ?></p>
            <?php } ?>
        </label>
        <button>Borrow</button>
    </form>
</div>

<?php require "../views/components/footer.php" ?>