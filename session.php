<?php
//make sure this file is the first include in every page that uses session
//start session
session_start();
$currenttoken;
$currenttimestamp;
//maintain session variables for security and check for timestamp
if(!isset($_SESSION["token"])){
    $_SESSION["token"] = generateToken();
    $currenttoken = $_SESSION["token"];
}
if(!isset($_SESSION['timestamp'])){
     $_SESSION["timestamp"]= generateTimeStamp();
     $currenttimeStamp = $_SESSION["timestamp"];
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
    //$ts = $date->getTimestamp();
    $ts = $_SERVER["REQUEST_TIME"];
    return $ts;
}
//function to check the amount of time elapsed,
//so we can destroy session after a certain amount of time
//eg log someone out of their account
function timeElapsed($timestamp){
    //generate new time stamp
    $now = generateTimeStamp();
    //calculate difference between new and stored timestamps
    $difference = $now-$currentTimeStamp;
    return $difference;
}
?>