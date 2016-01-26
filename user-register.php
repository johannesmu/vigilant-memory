<?php
include("session.php");
include("db/dbconnection.php");
//create arrays for errors and data
$currenttoken = $_SESSION["token"];
$errors = array();
$data = array();
//check submitted data
if($_POST["user-token"]!=$_SESSION["token"]){
    $errors["token"] = "token not equal";
}
else{
    //if tokens match
    $data["token"] = "true";
    //collect data from form
    //if there is data in the post
    if(count($_POST)>0){
        //the name of the form element becomes the key in the post data
        //eg <input name="reg-user-name"> becomes $_POST["reg-user-name"];
        //we store it in $username for easy reference
        $username = $_POST["user-name"];
        //check if username exists in the database already as there cannot be two users
        //with the same name, if it exists add an error with a message to $errors
        if(checkUserTable($username,"username",$dbconnection)){
            $errors["name"] = "user name is already taken";
        }
        //check if email is already used eg if checkUserTable returns true
        //email will also be used to recover forgotten password, so must be unique
        $email = $_POST["user-email"];
        if(checkUserTable($email,"email",$dbconnection)){
            $errors["email"] = "that email address has already been used";
        }
        //check the password here. In this case, we only check for length (8 or more characters)
        $password = $_POST["user-password"];
        if(strlen($password) < 8){
            $errors["password"] = "the password is too short, we recommend a minimum of 8 characters";
        }
        if(count($errors)>0){
            //if there are errors
            $data["errors"] = $errors;
        }
        //if no errors encountered in the data sent from form
        else{
            //prepare data for database
            $username = $username;
            //hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            //create account creation date, also lastactive date
            $datecreated = date("Y-m-d H:i:s");
            $datemodified = $datecreated;
            //create the query to insert
            $createuserquery = 
            "INSERT INTO users (username,password,email) 
            VALUES ('$username','$hashed_password','$email')";
            //run query against database
            //if query is successful
            if (!$dbconnection->query($createuserquery) === TRUE) {
                //check errors again
                $errors["database"] = $dbconnection->error;
            }
            else {
                $data["success"] = "true";
                $data["message"] = "Yay! your account has been created!<br>
                Hey, you wanna go <a href=\"store.php\">shopping</a>?";
            }
            
        }
    }
    
}
echo json_encode($data);

//this function needs two parameters, the data to be checked and the name of the field to check
//will return true if exists and false if not
function checkUserTable($item,$fieldname,$connection){
    $checkquery = "SELECT ".$fieldname." FROM users WHERE ".$fieldname."="."'$item'";
    $result = $connection->query($checkquery);
    if($result->num_rows>0){
        return true;
    }
    else{
        return false;
    }
}


?>