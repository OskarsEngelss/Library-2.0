<?php require "../views/components/head.php" ?>
<?php require "../views/components/navbar.php"?>

<?php function bookList($book) {?>
    <div class="bookInfo">
    <?php if ($book["availability"] > 0) { ?> <a href="/borrow?id=<?= $book["id"] ?>"> <?php } ?>
            <h3><?=$book["title"]?></h3>
            <ul>
                <li>Author: <?=htmlspecialchars($book["author"])?></li>
                <li>Release Date: <?=htmlspecialchars($book["released"])?></li>
                <li>Availability: <?=htmlspecialchars($book["availability"])?></li>
            </ul>
    <?php if ($book["availability"] > 0) { ?> </a> <?php } ?>
    <?php if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) { ?>
        <form method="POST" action="/book-edit?id=<?= $book["id"] ?>" class="edit-form">
            <button class="edit-button">Edit</button>
        </form>
    <?php } ?>
    </div>
<?php } ?>
<?php function takenBookList($book) {?>
    <?php if (new DateTime($book["reserveTime"]) < new DateTime()) { ?>
        <li class="reservedBookExpired">
    <?php } else { ?>
        <li class="reservedBook">
    <?php } ?>
        <div>
            <p>Book: <?=htmlspecialchars($book["title"])?></p>
            <p>Reserved till: <?=htmlspecialchars($book["reserveTime"])?></p>
        </div>
        <form method="POST" action="/return?id=<?=$book["id"]?>&taken_id=<?=$book["taken_id"]?>" class="edit-form">
            <input type="hidden" name="id" value="<?= $book["id"] ?>" />
            <button class="return-button">Return</button>
        </form>
    </li>
<?php } ?>

<body>
    <main>
        <article class="bookList">
            <section class="bookAvailabilityBox">
                <h2>Available Books</h2>
                <?php foreach($books as $book) { ?>
                    <?php if ($book["availability"] > 0) { ?>
                        <?php bookList($book); ?>
                    <?php } ?>
                <?php } ?>
            </section>
            <section class="bookAvailabilityBox">
                <h2>Unavailable Books</h2>
                <?php foreach($books as $book) { ?>
                    <?php if ($book["availability"] <= 0) { ?>
                        <?php bookList($book); ?>
                    <?php } ?>
                <?php } ?>
            </section>
        </article>

        <article class="profile">
            <?php if (isset($_SESSION["user"])) { ?>
                <header class="profileHeader">
                    <h4><?=$user["username"]?></h4>
                    <a  href="/setPicture">
                        <img class="profileImage" src="<?php if (!empty($user["profilePicture"])) { ?> <?= $user["profilePicture"] ?> <?php } else { ?> https://www.pngkey.com/png/full/121-1219231_user-default-profile.png <?php } ?>" />
                    </a>
                </header>
                <section class="reservedInfo">
                    <h2 class="reservedBooksTitle">Reserved books:</h2>
                    <ul class="reservedBooks">
                        <?php if (empty($taken_books)) { ?>
                            <p>Borrow some, by clicking on a book!</p>
                        <?php } else { ?>
                            <?php foreach($taken_books as $book) { ?>
                                <?php takenBookList($book); ?>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </section>
            <?php } else { ?>
                <form class="noAccountOptions" action="/login">
                    <label class="login">
                        You need to log in:
                        <button class="loginButton">Login</button>
                    </label>
                    <a class="registerLink" href="/register">Make a new account</a>
                </form>
            <?php } ?>
        </article>
    </main>
</body>


<?php require "../views/components/footer.php" ?>