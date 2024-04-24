<?php require "../views/components/head.php" ?>
<?php require "../views/components/navbar.php" ?>

<div>
    <h1><?=$title?></h1>
    <form method="POST">
        <label>
            Username:
            <input type="text" name='username' value="<?=($_POST["username"] ?? "")?>"/>
            <?php if(isset($errors["username"])) { ?> 
                <p class="invalid-data"><?= $errors["username"] ?></p>
            <?php } ?>
        </label>
        <label>
            Email:
            <input type="email" name='email' value="<?=($_POST["email"] ?? "")?>"/>
            <?php if(isset($errors["email"])) { ?> 
                <p class="invalid-data"><?= $errors["email"] ?></p>
            <?php } ?>
        </label>
        <label>
            Password:
            <input type="password" name='password' value="<?=($_POST["password"] ?? "")?>"/>
            <span>(8 characters, 1 letter, 1 uppercase, 1 lowercase un 1 special symbol.)</span>
            <?php if(isset($errors["password"])) { ?> 
                <p class="invalid-data"><?= $errors["password"] ?></p>
            <?php } ?>
        </label>
        <button>Register</button>
    </form>
    <a href="/login">Login Instead</a>
</div>

<?php require "../views/components/footer.php" ?>