<?php
include("db/dbconnection.php");
//this function needs two parameters, the data to be checked and the name of the field to check
//will return true if exists and false if not
function checkUserTable($item,$fieldname,$connection){
    $checkquery = "SELECT * FROM users WHERE ".$fieldname."= '$item'";
    echo $checkquery;
    $result = $connection->query($checkquery);
    if($result->num_rows>0){
        echo "true";
        //return true;
    }
    else{
        echo "false";
        //return false;
    }
}
checkUserTable("admin","username",$dbconnection);
?>