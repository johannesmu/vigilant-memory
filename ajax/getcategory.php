<?php
include("dbconnection.php");
session_start();
if($_SESSION["token"]==$_GET["token"]){
    //query to get categories
    $catquery = "SELECT * FROM categories";
    //get items from db and return JSON
    $categories = $conn->query($catquery);
    //if there are categories returned
    if ($categories->num_rows > 0) {
        $jsonarray = [];
        // output data of each row
        while($row = $categories->fetch_assoc()) {
            
            //echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
        }
    } else {
        echo "0 results";
    }
    $conn->close();
}
?>