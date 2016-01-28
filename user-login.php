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
    //set token to true in $data list
   $data["token"] = "true";
   //check if there is data POSTed to this page
   if(count($_POST)>0){
       //store user name in $user
       //clean input of any code to prevent hacks
       $user = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
       $data["suser"] = $user;
       //store password in $password
        //clean input of any code to prevent hacks
       $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
       $data["spass"] = $password;
       //create a query to check with database 
       //if user exists and if so, retrive id,username,passwd and email
       $loginquery = "SELECT * FROM users WHERE username='$user'";
       $loginresult = $dbconnection->query("$loginquery");
       if($loginresult->num_rows > 0){
           while($row = $loginresult->fetch_assoc()){
               //store retrieved data in $stored.. variables
               $storeduserid = $row["id"];
               $storedusername = $row["username"];
               $storedfirstname = $row["firstname"];
               $storedpassword = $row["password"];
               $storedemail = $row["email"];
               $isadmin = $row["isadmin"];
           }
           //check if submitted password matches the stored one
           if(password_verify ( $password , $storedpassword )){
               //password matches
               $data["success"] = "true";
               //set user information as array
               $userarray = ["id"=>$storeduserid,
                            "name"=>$storedusername,
                            "firstname"=>$storedfirstname,
                            "email"=>$storedemail,
                            "isadmin"=>$isadmin];
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
//if there are errors include it in data
if(count($errors)>0){
    $data["errors"] = $errors;
}
echo json_encode($data);
?>