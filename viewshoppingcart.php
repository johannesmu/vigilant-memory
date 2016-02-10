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
    echo var_dump($row);
    //echo $id."&nbsp".$quantity."<br>";
    //get image and description for each item
    $query = "SELECT id,name,description,price,specialprice,image FROM products WHERE id='$id'";
    // $result = $dbconnection->query($query);
    //     $dbrow = $result->fetch_assoc();
    //     $productid = $dbrow["id"];
    //     echo $productid;
    }
}

?>
<main class="main">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 cart-container">
                <h1>Items in your Cart</h1>
                <div class="row cart-row">
                    <div class="col-xs-2">
                        
                    </div>
                    <div class="col-xs-4">
                        Item Name
                    </div>
                    <div class="col-xs-2">
                        Quantity
                    </div>
                </div>
                 <div class="row cart-row">
                    <div class="col-xs-2">
                        Item Img
                    </div>
                    <div class="col-xs-4">
                        Item Name
                    </div>
                    <div class="col-xs-2">
                        <input class="form-control" type="number">
                    </div>
                     <div class="col-xs-2">
                        <button class="btn btn-default">&times;</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
include("footer.php");
?>