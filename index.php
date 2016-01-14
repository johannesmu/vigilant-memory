<?php 
include("header.php");

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
        $id = $row["id"];
        $name = $row["name"];
        $title = $row["title"];
        $link = $row["link"];
        $text = $row["content"];
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
                    <?php echo $title;?>
                </h1>
                <p>
                    <?php echo $text;?>
                </p>
            </div>
        </div>
        <!--row of products-->
        <div class="row">
            <?php
            if($products->num_rows>0){
                while($row = $products->fetch_assoc()){
                    $id = $row["id"];
                    $name = $row["name"];
                    $price = $row["sellprice"];
                    $image = $row["image"];
                    echo 
                    "<div class=\"col-sm-4 front-products\">".
                    "<h3>$name</h3>".
                    "<a href=\"productview.php?id=$id\"><img src=\"products/$image\"></a>".
                        // buttons for detail, buy and wish
                        "<div class=\"btn-group pull-right product-buttons\">".
                            "<a href=\"productview.php?id=$id&page=$currentpage\" class=\"btn btn-default\">
                             <i class=\"fa fa-ellipsis-h\"></i> Detail
                            </a>".
                            "<a href=\"wishlist.php?id=$id&page=$currentpage\" class=\"btn btn-default\">
                            <i class=\"fa fa-star-o\"></i> Add to Wishlist
                            </a>".
                            "<a href=\"cart.php?id=$id&page=$currentpage\" class=\"btn btn-default\">
                            <i class=\"fa fa-shopping-basket\"></i> Buy It For<span class=\"price\">$price</span>
                            </a>".
                        "</div>".
                    "</div>";
                }
            }
            ?>
        </div>    
    </div>
</main>
<?php include("footer.php"); ?>
</body>
</html>