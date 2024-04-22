<?php require "views/components/head.php" ?>
<?php require "views/components/navbar.php"?>

<?php function bookList($book) {?>
    <div class="bookInfo">
        <h3><?=$book["title"]?></h3>
        <ul>
            <li>Author: <?=htmlspecialchars($book["author"])?></li>
            <li>Release Date: <?=htmlspecialchars($book["released"])?></li>
            <li>Availability: <?=htmlspecialchars($book["availability"])?></li>
        </ul>
        <form method="POST" action="/book-delete" class="delete-form">
            <input type="hidden" name="id" value="<?= $book["id"] ?>"/>
            <button class="edit-button">Delete</button>
        </form>
    </div>
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
    </main>
</body>


<?php require "views/components/footer.php" ?>