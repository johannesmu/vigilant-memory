<?php
include("session.php");
include("db/dbconnection.php");

$data = array();
$errors = array();
//check for token
$servertoken = $_SESSION["token"];
$usertoken = $_POST["token"];
if($usertoken!=$servertoken){
    $errors["message"]="tokens don't match!";
    $errors["userid"]=$_POST["userid"];
    $errors["action"]=$_POST["action"];
    $errors["usertoken"]=$usertoken;
    $errors["servertoken"]=$servertoken;
    returnData($data,$errors);
    die();
}
else{
    //if tokens are matching
    //check if there is a POST request
    if(count($_POST)>0){
        $userid = $_POST["userid"];
        $productid = $_POST["productid"];
        $action = $_POST["action"];
        $data["action"] = $action;
        if($action == "set"){
            //prepare data for database
            $userid = filter_var($userid, FILTER_SANITIZE_STRING);
            $productid = filter_var($productid, FILTER_SANITIZE_STRING);
            $datecreated = date("Y-m-d H:i:s");
            //check if item is already in wishlist
            $checkidquery = "SELECT productid FROM wishlist WHERE userid='$userid' AND productid='$productid'";
            $checkidresult = $dbconnection->query($checkidquery);
                //if item des not exist in the wishlist
                if($checkidresult->num_rows==0){
                    //insert wishlist item into database
                    //prepare query
                    $wishaddquery = "INSERT INTO wishlist (productid,userid,datecreated) 
                    VALUES ('$productid','$userid','$datecreated')";
                    //run query against the database
                    if (!$dbconnection->query($wishaddquery) === TRUE) {
                        //check errors again
                        $errors["database"] = $dbconnection->error;
                    }
                    else{
                        $data["success"] = "true";
                        $data["message"] = "item added to wishlist";
                    }
                    //get all items that the user has added to wishlist
                    //to return to the ajax request to update the wishlist item
                    $countwishquery = "SELECT productid FROM wishlist WHERE userid='$userid'";
                    $countwish = $dbconnection->query($countwishquery);
                    $countwishtotal = $countwish->num_rows;
                    $data["total"] = $countwishtotal;
                }
                else{
                    $errors["message"]="item already in your wishlist";
                }
        }
        if($action=="get"){
            $userid = filter_var($userid, FILTER_SANITIZE_STRING);
            //get product information by joining wishlist and products table
            $wishgetquery = "SELECT products.id,name,brand,sellprice,specialprice,image FROM `products` 
            INNER JOIN wishlist ON products.id=wishlist.productid WHERE wishlist.userid='$userid'";
            //get the data using the query
            $wishresult = $dbconnection->query($wishgetquery);
            if($wishresult->num_rows>0){
                $result = array();
                while($row = $wishresult->fetch_assoc()){
                    $id = $row["id"];
                    $name = $row["name"];
                    $brand = $row["brand"];
                    $sellprice = $row["sellprice"];
                    $specialprice = $row["specialprice"];
                    $image = $row["image"];
                    $product = array(
                                "id"=>$id,
                                "name"=>$name,
                                "brand"=>$brand,
                                "sellprice"=>$sellprice,
                                "specialprice"=>$specialprice,
                                "image"=>$image);
                    array_push($result,json_encode($product));
                }
                //if there is data set success to true
                $data["success"]="true";
                $data["result"]=$result;
             }
             else{
                 $data["success"]="false";
                 $data["user"]=$userid;
                 $data["message"]="no data";
             }
        }
        if($action=="remove"){
            $removequery = "DELETE FROM wishlist WHERE productid='$productid' 
                            AND userid='$productid'";
            if($dbconnection->query($removequery)){
                $data["success"]="true";
                $data["message"]="Item removed from wishlist";
            }
            else{
                $errors["message"]="An error occured";
            }
        }
    }
    returnData($data,$errors);
}

function returnData($data,$errors){
    if(count($errors)>0){
        $data["error"] = $errors;
    }
    echo json_encode($data);
}
?>