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
        if($action == "set"){
            $item = array("id"=>$id,"quantity"=>$quantity);
            // to do: check if item already in cart, if not add it, if yes, just update quantity
            //find item with the same id in the array and return its index
            //check how many items in cart
            $itemnumbers = count($_SESSION["shopping-cart"]);
            for($i=0;$i<$itemnumbers;$i++){
                $itemdata = $_SESSION["shopping-cart"][$i];
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
        //action "list" is to show shopping cart with each item having a complete data set
        if($action == "list"){
            //get all data from SESSION variable called "shopping-cart" and send back
            //as an array of objects
            //create the array
            $items = array();
            //create total price variable
            $totalprice = 0;
            foreach($_SESSION["shopping-cart"] as $cart){
                //get the id of item from shopping cart
                $id = $cart["id"];
                //get the quantity of the item
                $quantity = $cart["quantity"];
                //query to retrieve product info from database
                $productquery = "SELECT name,image,sellprice,specialprice,brand
                                FROM products WHERE id='$id'";
                //retrieve the info
                $productresult = $dbconnection->query($productquery);
                
                //store result as an associative array in $result
                $result = $productresult->fetch_assoc();
                //add product id and quantity to associative array
                $result["id"] = $id;
                $result["quantity"] = $quantity;
                if($result["specialprice"]){
                    $totalprice += $result["specialprice"];
                }
                else{
                    $totalprice += $result["sellprice"];
                }
                //add $result array to $items array in a json format
                array_push($items,json_encode($result));
            }
            $data["success"] = "true";
            $data["result"] = $items;
            $data["totalprice"] = $totalprice;
        }
        if($action == "delete"){
            //this action is to remove an item from the shopping cart
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


?>