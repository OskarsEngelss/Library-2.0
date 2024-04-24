<?php require "../views/components/head.php" ?>
<?php require "../views/components/navbar.php" ?>

<div>
    <h1>Edit the book:</h1>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $book["id"] ?>" />
        <label>
            Title:
            <input name='title' value="<?=($_POST["title"] ?? $book["title"])?>"/>
            <?php if(isset($errors["title"])) { ?> 
                <p class="invalid-data"><?= $errors["title"] ?></p>
            <?php } ?>
        </label>
        <label>
            Author:
            <input name='author' value="<?=($_POST["author"] ?? $book["author"])?>"/>
            <?php if(isset($errors["author"])) { ?> 
                <p class="invalid-data"><?= $errors["author"] ?></p>
            <?php } ?>
        </label>
        <label class="is_new_label">
            New Author: 
            <input name='is_new' class="is_new" type="checkbox" <?php if(isset($_POST["is_new"])) { ?> checked="true" <?php } ?>/>
        </label>
        <label> 
            Release Date:
            <input type="date" name='released' value="<?=($_POST["released"] ?? $book["released"])?>"/>
            <?php if(isset($errors["released"])) { ?> 
                <p class="invalid-data"><?= $errors["released"] ?></p>
            <?php } ?>
        </label>
        <label>
            Amount of available books:
            <input type="number" name='availability' value="<?=($_POST["availability"] ?? $book["availability"])?>"/>
            <?php if(isset($errors["availability"])) { ?> 
                <p class="invalid-data"><?= $errors["availability"] ?></p>
            <?php } ?>
        </label>
        
        <button>Update</button>
    </form>
</div>

<?php require "../views/components/footer.php" ?>