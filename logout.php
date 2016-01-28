<?php
include("session.php");
include("db/dbconnection.php");
//get the referer page so can redirect after logout
$refererpage = $_SERVER['HTTP_REFERER'];
//unset the user session variable ie log user out
unset($_SESSION["user"]);
//redirect to the page where user logs out
header('Location: '.$refererpage);
die();
?>