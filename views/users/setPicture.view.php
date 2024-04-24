<?php require "../views/components/head.php" ?>
<?php require "../views/components/navbar.php" ?>

<div>
    <h1><?=$title?></h1>
    <form method="POST" action="/setPicture?>">
        <label>
            Image link:
            <input type="text" name="profilePicture" value="<?=($_POST["profilePicture"] ?? "")?>" />
            <?php if(isset($errors["profilePicture"])) { ?> 
                <p class="invalid-data"><?= $errors["profilePicture"] ?></p>
            <?php } ?>
        </label>
        <button>Set</button>
    </form>
</div>

<?php require "../views/components/footer.php" ?>