<?php 
include("session.php");
include("header.php");


//check if there is a variable for product id set or sent from another page, via productview.php?id=2
if(isset($_GET["id"])){
    $producttoshow = $_GET["id"];
}
//if no product id is set, redirect to store page.
else{
    $url = "http://$_SERVER[HTTP_HOST]/store.php";
    header("Location: ".$url);
}

//get product from database using the id
$productsquery = "SELECT * FROM products WHERE id='$producttoshow'";
//we only have one product here
$product = $dbconnection->query($productsquery);

if($product->num_rows>0){
  while($row = $product->fetch_assoc()){  
        $productid = $row["id"];
        $productname = $row["name"];
        $productprice = $row["sellprice"];
        $productspecialprice = $row["specialprice"];
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
        echo "<h2>$productname</h2>";
        ?>
            </div>
        </div>
        
        <div class="row">
        <?php 
        echo 
        "<div class=\"col-md-4 col-md-offset-2\">".
        "<img class=\"product-detail-image responsive-image\" src=\"products/$image\">".
        "</div>".
         "<div class=\"col-md-4 product-detail\">".
         "<p>$desc</p>";
         echo "<div class=\"row\">";
         if($productspecialprice){
             echo "<div class=\"col-sm-6\">
                    <div class=\"price strike\">
                        $productprice
                    </div>
                </div>";
             echo "<div class=\"col-sm-6\">
             <div class=\"special price\">
             $productspecialprice
             </div>
             </div>";
         }
         else{
             echo "<h4 class=\"price\">$productprice</h4>";
         }
         echo "</div>";
        echo
        "<div class=\"product-buttons\">".
            "<button  
            class=\"btn btn-default wish-button\" data-id=\"$productid\">Add to Wishlist</button>".
            "<button  
            class=\"btn btn-default buy-button\" data-id=\"$productid\">Buy It</button>".
            "<select class=\" quantity\" data-id=\"$productid\">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>".
        "</div>";
        echo "</div>";
        ?>   
        </div>
    </div>
</main>
<?php include("footer.php"); ?>
<script src="scripts/shopping-cart.js"></script>
</body>
</html>