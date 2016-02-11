<?php
include("session.php");
include("db/dbconnection.php");

$data = array();
$errors = array();
// if shopping cart session does not exist, create the object
//as an array in a session variable
//debug only
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
                $match = false;
                if($itemdata["id"]==$item["id"]){
                    //if an item is already in the cart
                    $match=true;
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
        if($action == "list"){
            $items = array();
            foreach($_SESSION["shopping-cart"] as $row){
                $id = $row["id"];
                $quantity = $row["quantity"];
                $productquery = "SELECT name,image,sellprice,specialprice,brand
                                FROM products WHERE id='$id'";
                $productresult = $dbconnection->query($productquery);
                $result = $productresult->fetch_assoc();
                $result["id"] = $id;
                $result["quantity"] = $quantity;
                array_push($items,json_encode($result));
            }
            $data["success"] = "true";
            $data["result"] = $items;
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