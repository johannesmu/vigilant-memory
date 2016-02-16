<?php
include("session.php");
include("db/dbconnection.php");

$data = array();
$errors = array();
// if shopping cart session does not exist, create the object
//as an array in a session variable
//uncomment the following line for debug only (to flush the shopping cart)
//unset($_SESSION["shopping-cart"]);
if(isset($_SESSION["shopping-cart"])==false){
    $_SESSION["shopping-cart"] = array();
}
//check for token
$servertoken = $_SESSION["token"];
$usertoken = $_POST["token"];
if($usertoken!=$servertoken){
    $errors["message"]="tokens don't match!";
    returnData($data,$errors);
    die();
}
else{
    //if tokens are matching
    //check if there is a POST request
    if(count($_POST)>0){
        $id = $_POST["id"];
        $quantity = $_POST["quantity"];
        $action = $_POST["action"];
        //ADD AN ITEM TO THE SHOPPING CART
        if($action == "set"){
            $item = array("id"=>$id,"quantity"=>$quantity);
            // to do: check if item already in cart, if not add it, if yes, just update quantity
            //find item with the same id in the array and return its index
            //check how many items in cart
            $itemnumbers = count($_SESSION["shopping-cart"]);
            for($i=0;$i<$itemnumbers;$i++){
                $itemincart = $_SESSION["shopping-cart"][$i];
                //$checkitemincart = updateCartQuantity($itemincart,$item,$i);
                //set match variable to see if the id of item clicked
                //already is in shopping cart
                $match = false;
                if($itemdata["id"]==$item["id"]){
                    //if an item is already in the cart
                    $match=true;
                    //update only the quantity instead of creating duplicate
                    //items in the shopping cart
                    $quantity = $itemdata["quantity"] + $item["quantity"];
                    $item = array("id"=>$itemdata["id"],"quantity"=>$quantity);
                    $_SESSION["shopping-cart"][$i]=$item;
                }
            }
            if(!$match){
                array_push($_SESSION["shopping-cart"],$item);
            }
            $data["cart"] = json_encode($_SESSION["shopping-cart"]);
            $data["success"] = true;
        }
        if($action == "get"){
            $data["cart"] = json_encode($_SESSION["shopping-cart"]);
            $data["success"] = true;
        }
        //LIST ALL SHOPPING CART ITEMS
        //action "list" is to show shopping cart with each item having a complete data set
        if($action == "list"){
            //get all data from SESSION variable called "shopping-cart" and send back
            //as an array of objects
            //create the array
            $items = array();
            //create total price variable
            $totalprice = 0;
            foreach($_SESSION["shopping-cart"] as $cart){
                $quantity = $cart["quantity"];
                $result = getCartItemData($cart,$dbconnection);
                if($result["specialprice"]){
                    $totalprice += $result["specialprice"]*$quantity;
                }
                else{
                    $totalprice += $result["sellprice"]*$quantity;
                }
                //add $result array to $items array in a json format
                array_push($items,json_encode($result));
            }
            $data["success"] = "true";
            $data["result"] = $items;
            $data["totalprice"] = $totalprice;
        }
        if($action == "update"){
            //update an item quantity
            //find item in the cart and update its quantity
        }
        //DELETING ITEM FROM CART
        if($action == "delete"){
            //this action is to remove an item from the shopping cart
            //get id of item to be deleted
            $id = $_POST["id"];
            //id
            $id = $_POST["id"];
            //find the number of items in shopping cart
            $length = count($_SESSION["shopping-cart"]);
            for($i=0;$i<$length;$i++){
                $currentrow = $_SESSION["shopping-cart"][$i];
                if($currentrow["id"]==$id){
                    unset($_SESSION["shopping-cart"][$i]["id"]);
                    unset($_SESSION["shopping-cart"][$i]["quantity"]);
                    unset($_SESSION["shopping-cart"][$i]);
                    $_SESSION["shopping-cart"] = array_values($_SESSION["shopping-cart"]);
                    $data["message"]="item deleted";
                }
                else{
                    $item = array("id"=>$id);
                    $data["message"]="wtf ";
                }
            }
            $data["length"]=count($_SESSION["shopping-cart"]);
            $data["success"]="true";
            $data["totalprice"]=getCartTotalPrice($_SESSION["shopping-cart"],$dbconnection);
        }
        if($action == "update"){
            $total = getCartTotalPrice($_SESSION["shopping-cart"],$dbconnection);
            if($total>0){
            }
        }
        if($action == "empty"){
            unset($_SESSION["shopping-cart"]);
            $data["success"]="true";
        }
        returnData($data,$errors);
    }
}
//function to return data request as JSON 
function returnData($data,$errors){
    if(count($errors)>0){
        $data["error"] = $errors;
    }
    echo json_encode($data);
}

function updateCartQuantity($cartid,$requestid,$index){
    if($cartid==$requestid){
        //update only the quantity instead of creating duplicate
        //items in the shopping cart
        $quantity = $itemdata["quantity"] + $item["quantity"];
        $item = array("id"=>$itemdata["id"],"quantity"=>$quantity);
        //$_SESSION["shopping-cart"][$i]=$item;
    }
}

//this function retrieves a cart item (id and quantity) information using a database connection
function getCartItemData($cartitem,$connection){
    $id = $cartitem["id"];
    if($cartitem["quantity"]){
        $quantity = $cartitem["quantity"];
    }
    $itemquery = "SELECT name,image,sellprice,specialprice,brand FROM products WHERE id='$id'";
    $itemresult = $connection->query($itemquery);
    if($itemresult->num_rows>0){
        $infoarray = $itemresult->fetch_assoc();
        //add id and quantity to the info array
        $infoarray["id"]=$id;
        if($cartitem["quantity"]){
            $infoarray["quantity"]=$quantity;
        }
    }
    else{
        //no matching data in the database
        $infoarray["error"]="sorry bro, no data found";
    }
    return $infoarray;
}
//this function gets tht total price of cart items
function getCartTotalPrice($array,$connection){
    $totalprice=0;
    foreach($_SESSION["shopping-cart"] as $cart){
        $id = $cart["id"];
        $quantity = $cart["quantity"];
        //get the item price from database
        $query = "SELECT sellprice,specialprice FROM products WHERE id='$id'";
        $result = $connection->query($query);
        $row = $result->fetch_assoc();
        $specialprice = $row["specialprice"];
        $sellprice = $row["sellprice"];
        if($specialprice){
            $totalprice+=$specialprice*$quantity;
        }
        else{
            $totalprice+=$sellprice*$quantity;
        }
        
    }
    return $totalprice;
}
?>