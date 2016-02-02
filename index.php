<?php 
include("session.php");
include("header.php");
include("searchbar.php");
//check if get variable is set so we can show 
if(isset($_GET["category"])){
    $chosen = $_GET["category"];
}
else{
    $chosen = "0";
}

//get pages from db to show content
$contentquery = "SELECT id,name,title,link,content FROM pages WHERE link='$currentpage'";
$content = $dbconnection->query($contentquery);

if($content->num_rows > 0){
   while($row = $content->fetch_assoc()) {
        $contentid = $row["id"];
        $contentname = $row["name"];
        $contenttitle = $row["title"];
        $contentlink = $row["link"];
        $contenttext = $row["content"];
    }
}

//get products from database, limit to 3
$productsquery = "SELECT id,stocklevel,category,name,sellprice,image FROM products ORDER BY sellprice DESC LIMIT 6";
$products = $dbconnection->query($productsquery);
?>
<main class="main">
    <div class="container">
        
        <div class="row">
            <div class="col-xs-12">
                 <h1>
                    <?php echo $contenttitle;?>
                </h1>
                <p>
                    <?php echo $contenttext;?>
                </p>
            </div>
        </div>
        <!--row of products-->
        <div class="row">
            <?php
            if($products->num_rows>0){
                while($row = $products->fetch_assoc()){
                    $productid = $row["id"];
                    $productname = $row["name"];
                    $productprice = $row["sellprice"];
                    $productimage = $row["image"];
                    //render product data 
                    echo 
                    "<div class=\"col-sm-4 front-products\" data-id=\"$productid\">".
                        "<h3>$productname</h3>".
                        "<a href=\"productview.php?id=$productid\">
                        <img src=\"products/$productimage\">
                        </a>";
                    echo "<p class=\"price text-right\">$productprice</p>";
                        // buttons for detail, buy and wish
                    echo "<div class=\"product-buttons\">".
                            
                            "<button class=\"btn btn-default wish-button\" data-id=\"$productid\">
                            <i class=\"fa fa-heart-o\"></i> Add to Wishlist
                            </button>".

                            "<button class=\"btn btn-default buy-button\" data-id=\"$productid\">
                            <i class=\"fa fa-shopping-basket\"></i> 
                            Buy It 
                            </button>".
                            "<select class=\"form-control quantity\" data-id=\"$productid\">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>".

                        "</div>".
                    "</div>";
                }
            }
            ?>
        </div>    
    </div>
</main>
<?php include("footer.php"); ?>
<script src="scripts/shopping-cart.js"></script>
</body>
</html>