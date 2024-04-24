<header>
  <h1 class="storeName"><a class="storeNameLink" href="/">Angelss Reads</a></h1>
  <div class="adminPannel">
    <?php if (isset($_SESSION["user"])) { ?>
        <?php if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) { ?>
          <form action="/book-add" class="adminButtonCircle">
            <button class="adminButtons">New Book</button>
          </form>
          <form action="/book-delete" class="adminButtonCircle">
            <button class="adminButtons">Delete</button>
            </form>
        <?php } ?>
        <form method="POST" action="/logout" class="adminButtonCircle">
          <button class="adminButtons">Logout</button>
        </form> 
    <?php } else { ?>
      <form method="POST" action="/" class="adminButtonCircle">
        <button class="adminButtons">Home</button>
      </form> 
    <?php } ?>
  </div>
</header>