<?php
//this page produces only plain text response in JSON format
//so there is no need for header, as this page is only called via javascript
include("session.php");
include("db/dbconnection.php");
//create arrays for errors and data
$currenttoken = $_SESSION["token"];
$errors = array();
$data = array();
//check submitted data if it contains token
if($_POST["user-token"]!=$_SESSION["token"]){
    $errors["token"] = "token not equal";
}
//if token matches the server generated one
else{
   $data["token"] = "true";
   //check if there is data POSTed to this page
   if(count($_POST)>0){
       //store user name in $user
       $user = $_POST["name"];
       //store password in $password
       $data["user"] = $user;
       $password = $_POST["password"];
       //create a query to check with database
       $loginquery = "SELECT id,username,password,email FROM users WHERE username='$user'";
       $data["query"] = $loginquery;
       $loginresult = $dbconnection->query("$loginquery");
       if($loginresult->num_rows > 0){
           //there is a user with that name, check if password matches
           while($row = $loginresult->fetch_assoc()){
               $storeduserid = $row["id"];
               $storedusername = $row["username"];
               $storedpassword = $row["password"];
               $storedemail = $row["email"];
           }
           //check if submitted password matches the stored one
           if(password_verify ( $password , $storedpassword )){
               //password matches
               $data["success"] = "true";
               //set user information as array
               $userarray = ["id"=>$storeduserid,"name"=>$storedusername,"email"=>$storedemail];
               //set session variable to indicate the user is logged in
               $_SESSION["user"] = $userarray;
           }
           else{
               $errors["message"] = "Either user name or password is incorrect";
           }
       }
       else{
           $errors["message"] = "User does not exist";
       }
   }
}
//if there are errors
if(count($errors)>0){
    $data["errors"] = $errors;
}
echo json_encode($data);
?>