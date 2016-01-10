<?php
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