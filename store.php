<?php
//include session for login and account
include("session.php");
//include hearder for navigation
include("header.php");
//include search bar to show search bar on this page
include("searchbar.php");
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
//get categories from db to show in side bar
$categoriesquery = "SELECT id,name FROM categories ORDER BY id";
$categories = $dbconnection->query($categoriesquery);

//check if a category variable has been sent from this page or another page via GET request
//ie if this page is called using url such as thispage.php?id=7, etc
//if yes, store the variable after the question mark in $currentcategoryid
if(isset($_GET["category"])){
    $currentcategoryid = $_GET["category"];
}
//get the name of the currently selected category
$categorynamequery = "SELECT name FROM categories WHERE id='$currentcategoryid'";
$currentcategory = $dbconnection->query($categorynamequery);
if($currentcategory->num_rows > 0){
    while($row = $currentcategory->fetch_assoc()){
        $currentcategoryname = $row["name"];
    }
}

//get products from store db
$productsquery ="SELECT * FROM products WHERE category='$currentcategoryid'";
//if cateogry name is all, then change query to show all products
if($currentcategoryname == "all" || $currentcategoryname == ""){
    $productsquery = "SELECT * FROM products";
}
$products = $dbconnection->query($productsquery)
?>
<main class="main">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2><?php echo $contenttitle;?></h2>
            </div>
            <div class="col-md-12">
                <p>
                    <?php echo $contenttext;?>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <!--categories sidebar menu-->
                <nav>
                    <ul class="nav nav-pills nav-stacked">
                        <?php
                        if($categories->num_rows > 0){
                            while($row = $categories->fetch_assoc()){
                                $categoryid = $row["id"];
                                $categoryname = $row["name"];
                                $categorylink = "category=$id";
                                if($currentcategoryid==$categoryid){
                                    $class="active";
                                }
                                elseif($categoryname == "all" && !$currentcategoryid){
                                    $class="active";
                                }
                                else{
                                    $class="";
                                }
                                echo "<li class=\"$class caps\">
                                    <a href=\"$currentpage?category=$categoryid\">
                                        $categoryname
                                    </a>
                                    </li>";
                            }
                        }
                        ?>
                    </ul>
                </nav>
            </div>
            <div class="col-md-10 store-front">
                <?php
                if($products->num_rows > 0){
                    $count = 0;
                    while($row = $products->fetch_assoc()){
                       $productid = $row["id"];
                       $productname = $row["name"];
                       $productimage = $row["image"];
                       $productprice = $row["sellprice"];
                       $productspecialprice = $row["specialprice"];
                       if($count == 0){
                           echo "<div class=\"row\">";
                       }
                       if($count<4){
                           echo "<div class=\"col-sm-3 product\">";
                           echo "<h3>$productname</h3>
                                <a class=\"store-product\" href=\"productview.php?id=$productid\">
                                <img class=\"store-product-image responsive-image\" 
                                src=\"products/$productimage\">
                                </a>";
                                //if there is special price
                                if($productspecialprice){
                                    echo "<p class=\"price strike\">$productprice</p>";
                                    echo "<p class=\"price special\">$productspecialprice</p>";
                                }
                                else{
                                    echo "<p class=\"price\">$productprice</p>";
                                }
                           echo "<div class=\"product-buttons\">
                                    <button title=\"add this item to wish list\"
                                            class=\"btn btn-default wish-button\" data-id=\"$productid\">
                                        <i class=\"fa fa-heart\"></i>
                                    </button>
                                    <button title=\"add this item to shopping cart\"
                                            class=\"btn btn-default buy-button\" data-id=\"$productid\">
                                        <i class=\"fa fa-shopping-bag\"></i>
                                    </button>
                                    <select class=\"form-control quantity\" data-id=\"$productid\">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                </div>";
                             echo "<div class=\"alert\"></div>";
                            echo "</div>";
                            $count++;
                       }
                       if($count>=4){
                            echo "</div>";
                            $count = 0;
                       }
                          
                    }
                }
                ?>
            </div>
        </div>
    </div>
</main>
<?php include("footer.php");?>
</body>
</html>
