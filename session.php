<?php
//start session
session_start();
//maintain session variables for security and check for timestamp
if(!isset($_SESSION["token"])){
    $_SESSION["token"] = generateToken();
}
if(!isset($_SESSION['timestamp'])){
     $_SESSION["timestamp"]= generateTimeStamp();
}

//function to generate token
function generateToken(){
    $binary = openssl_random_pseudo_bytes(16);
    $token = bin2hex($binary);
    return $token;
}
//function to generate timestamp
function generateTimeStamp(){
    $date = new DateTime();
    $ts = $date->getTimestamp();
    return $ts;
}
?>