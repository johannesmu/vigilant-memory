<?php
//get current page name
$currentpage = basename($_SERVER['PHP_SELF']);
//include the script for database connection
include("db/dbconnection.php");
// get pages from db to show in navigation
$pagequery = "SELECT id,name,link,content,image FROM pages";
$pages = $dbconnection->query($pagequery);

//start session
session_start();
//if no token, generate one

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
        <div class="container">
            <ul class="nav navbar-nav capitalize">
               <?php 
               if($pages->num_rows > 0){
                   while($row = $pages->fetch_assoc()) {
                        $id = $row["id"];
                        $name = $row["name"];
                        $link = $row["link"];
                        echo "<li><a href=\"$link\">$name</a></li>";
                    }
               }
               ?>
            </ul>
        </div>
    </div>
</header>