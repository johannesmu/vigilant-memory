<?php
//this file is to connect to the database to retrieve and write data
//this is the address of the database. since the database is on the same host, we can use "localhost"
$host = "localhost";
//this is the database user that the website will use
$dbuser = "storeuser";
//this is the password for the database user
$dbpassword = "password";
//this is the name of the database
$database = "store";

$dbconnection = mysqli_connect($host,$dbuser,$dbpassword,$database);

// Check connection
if ($dbconnection->connect_error)
{
  die("There was a problem connecting to db: " . $dbconnection->connect_error);
}

?>