<?php
//include the script for database connection
include("db/dbconnection.php");
//start session
session_start();
//if no token, generate one
if(!isset($_SESSION["token"])){
    $_SESSION["token"] = generateToken();
}
//function to generate token
function generateToken(){
    $binary = openssl_random_pseudo_bytes(16);
    $token = bin2hex($binary);
    return $token;
}
?>
<!doctype html>
<html>
<head>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Welcome</title>
    <link href="components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    
<header class="header">
    <div class="navbar navbar-default">
        <ul class="nav navbar-nav">
           <!--add navigation here-->
        </ul>
    </div>
</header>