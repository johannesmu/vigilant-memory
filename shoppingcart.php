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
    $id = $_POST["id"];
    $quantity = $_POST["quantity"];
    $action = $_POST["action"];
    if($action == "add"){
        $item = array("id"=>$id,"quantity"=>$quantity);
        // to do check if item already in cart, if not add it, if yes, just update quantity
        array_push($_SESSION["shopping-cart"],$item);
        $data["cart"] = json_encode($_SESSION["shopping-cart"]);
        $data["success"] = true;
    }
    if($action == "read"){
        $data["cart"] = json_encode($_SESSION["shopping-cart"]);
        $data["success"] = true;
    }
    returnData($data,$errors);
}
function returnData($data,$errors){
    if(count($errors)>0){
        $data["error"] = $errors;
    }
    echo json_encode($data);
}
//get the GET variable
//check actions
//add items to $cart variable and return number of items
//if required, display the items in a list

?>