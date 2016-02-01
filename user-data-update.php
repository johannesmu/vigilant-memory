<?php
//we include session to check on the token
//and the user session variable
include("session.php");
//include dbconnection.php to get user data
include("db/dbconnection.php");
$errors = array();
$data = array();

$currenttoken = $_SESSION["token"];
$usertoken = $_POST["token"];
$data["token"] = $usertoken;

$data["actionrequested"] = $_POST["action"];
if($usertoken==$currenttoken){
//connect to database to get user data if action is "get"
    if($_POST["action"]=="get" && $_POST["token"]==$_SESSION["token"]){
            //if action in the data is "get" (ie read data from the database)
        $userdataquery = "SELECT * FROM users WHERE id='".$_POST["id"]."'";
        $userdata = $dbconnection->query($userdataquery);
        if($userdata->num_rows > 0){
            $data["success"] = "true";
            while($row = $userdata->fetch_assoc()){
                //on the left is name of data to be returned
                //on the right is column names in database table users
                $data["id"] = $row["id"];
                $data["name"] = $row["username"];
                $data["email"] = $row["email"];
                //for security reason, we return a fake password
                $data["password"] = "password";
                $data["first"] = $row["firstname"];
                $data["last"] = $row["lastname"];
                $data["apartment"] = $row["apartment"];
                $data["streetnumber"] = $row["streetnumber"];
                $data["streetname"] = $row["streetname"];
                $data["suburb"] = $row["suburb"];
                $data["state"] = $row["state"];
                $data["postcode"] = $row["postcode"];
                $data["country"] = $row["country"];
            }
        }
        else{
            $errors["message"]="no data recovered";
            $data["success"] = "false";
            $data["errors"] = $errors;
        }
       returnData($data,$errors);
    }
    //connect to update user record in database if action is "set"
    //see user-data.js and user-dashboard.php
    if($_POST["action"]=="set"){
        //if action in the data is "set" collect data from javascript request
        $id = $_POST["id"];
        $name = $_POST["user"];
        $email = $_POST["email"];
        if($_POST["password"]){
            $password = password_hash($_POST["password"],PASSWORD_DEFAULT);
        }
        $first = $_POST["first"];
        $last = $_POST["last"];
        $apartment = $_POST["apartment"];
        $number = $_POST["number"];
        $street = $_POST["street"];
        $suburb = $_POST["suburb"];
        $state = $_POST["state"];
        $postcode = $_POST["postcode"];
        $country = $_POST["country"];
        //if no password submitted, don't update password
        if(!$password){
            $userupdatequery = "UPDATE users SET
            email='$email',
            firstname='$first',
            lastname='$last',
            apartment='$apartment',
            streetnumber='$number',
            streetname='$street',
            suburb='$suburb',
            state='$state',
            postcode='$postcode',
            country='$country'
            WHERE id='$id'";
        }
        elseif($password){
            $userupdatequery = "UPDATE users SET
            email='$email',
            password=$password;
            firstname='$first',
            lastname='$last',
            apartment='$apartment',
            streetnumber='$number',
            streetname='$street',
            suburb='$suburb',
            state='$state',
            postcode='$postcode',
            country='$country'
            WHERE id='$id'";
        }
        else{
            //catch other cases and return an error
            $error["message"] = "no query performed";
            $userupdatequery = "";
            returnData($data,$errors);
            die();
        }
        //run query against the database
        $updateresult = $dbconnection->query($userupdatequery);
        $data["query"] = $userupdatequery;
        $data["success"]="true";
        //echo json_encode($data);
        returnData($data,$errors);
    }
    //if user wants to reset their password via forgot password link
    if($_POST["action"]=="password"){
        //check if user exists
        
    }
    
}
else{
    $errors["message"] = "tokens don't match";
    
    returnData($data,$errors);
}
function returnData($output,$errors){
    //collect all errors
    $output["error"] = $errors;
    echo json_encode($output);
}
?>