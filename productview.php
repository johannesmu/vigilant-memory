<?php 
include("header.php");
include("session.php");

//check if there is a variable for product id set or sent from another page, via productview.php?id=2
if(isset($_GET["id"])){
    $producttoshow = $_GET["id"];
}
//if no product id is set, redirect to store page.
else{
    $url = "http://$_SERVER[HTTP_HOST]/store.php";
    header("Location: ".$url);
}

//get products from database, limit to 3
$productsquery = "SELECT * FROM products WHERE id='$producttoshow'";
$product = $dbconnection->query($productsquery);

if($product->num_rows>0){
  while($row = $product->fetch_assoc()){  
        $id = $row["id"];
        $name = $row["name"];
        $price = $row["sellprice"];
        $image = $row["image"];
        $desc = $row["description"];
  }
}
?>
<main class="main">
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-2">
        <?php
        echo "<h2>$name</h2>";
        ?>
            </div>
        </div>
        
        <div class="row flex">
        <?php 
        echo 
        "<div class=\"col-md-4 col-md-offset-2\">".
        "<img class=\"product-detail-image responsive-image\" src=\"products/$image\">".
        "</div>".
         "<div class=\"col-md-4 product-detail flex-end\">".
         "<p>$desc</p>".
         "<h4 class=\"price\">$price</h4>";
         if($specialprice){
             "<h4 class=\"special price\">$specialprice</h4>";
         }
        echo
        "<div class=\"btn-group\">".
            "<a href=\"wishlist.php?id=$id&page=$currentpage\" class=\"btn btn-default\">Add to Wishlist</a>".
            "<a href=\"shoppingcart.php?id=$id&page=$currentpage\" class=\"btn btn-default\">Buy It</a>".
        "</div>";
        echo "</div>";
        ?>   
        </div>
    </div>
</main>
<?php include("footer.php"); ?>
</body>
</html>