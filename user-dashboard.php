<?php
include("session.php");
include("header.php");
include("searchbar.php");

//check if user is logged in, otherwise redirect to home
$redirectto = "index.php";
if($_SESSION["user"]==false){
    header('Location: '.$redirectto);
    die();
}
//show user data:
//account details
//
?>
<main class="main" role="main">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2>My Account </h2>
            </div>
            <div class="col-md-6">
                <h2>Wishlist</h2>
            </div>
        </div>
    </div>
</main>
<?php include("footer.php"); ?>
</body>
</html>