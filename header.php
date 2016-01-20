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


?>
<!doctype html>
<html>
<head>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Welcome</title>
    <link href="components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="components/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    
<header class="header">
    <div class="navbar navbar-default">
        <div class="container">
            <?php
                echo "<a href=\"index.php\" class=\"navbar-brand\">
                <img class=\"navbar-image\" src=\"images/ShopLogo.svg\">
                </a>";
            ?>
            <ul class="nav navbar-nav capitalize">
               <?php 
               if($pages->num_rows > 0){
                   while($row = $pages->fetch_assoc()) {
                        $id = $row["id"];
                        $name = $row["name"];
                        $link = $row["link"];
                        // if the link matches the current page, set the class to active
                        if($link == $currentpage){
                            $class="active";
                        }
                        else{
                            $class="";
                        }
                        echo "<li class=\"$class\"><a href=\"$link\">$name</a></li>";
                    }
               }
               ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href=""><i class="fa fa-shopping-cart"></i> Cart</a></li>
                <li><a href="login.php"><i class="fa fa-user"></i> Login</a></li>
                <li><a href="login.php#register"><i class="fa fa-user-plus"></i> Register</a></li>
            </ul>
        </div>
    </div>
    
</header>
