<?php
//when people click on the "cart" link, they should be taken to this page
include("session.php");
include("header.php");
//put all items from cart into a new array with images and description
//create array
$cartitems = array();
if(count($_SESSION["shopping-cart"])>0){
    foreach($_SESSION["shopping-cart"] as $row){
    $id = $row["id"];
    $quantity = $row["quantity"];
    
    }
}

?>
<main class="main">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 cart-list">
                <h1>Items in your Cart</h1>
                
            </div>
        </div>
    </div>
</main>
<?php
include("footer.php");
?>