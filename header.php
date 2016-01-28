<?php
//get current page name
$currentpage = basename($_SERVER['PHP_SELF']);
//include the script for database connection
include("db/dbconnection.php");
// get pages from db to show in left side navigation
$pagequery = "SELECT id,name,link,content,image,side,loginrequired FROM pages";
$pages = $dbconnection->query($pagequery);

?>
<!doctype html>
<html>
<head>
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Welcome</title>
    <link href="components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="components/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <?php
        $currenttimestamp = $_SESSION["timestamp"];
        $currenttoken = $_SESSION["token"];
        echo "<script>\n";
        echo "var timestamp = \"$currenttimestamp\";\n";
        echo "var token=\"$currenttoken\";\n";
        echo "</script>\n";
    ?>
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
            
           <?php
           //you will need a "side" column in your "pages" table in the db
           //to determine which link will be on left or right hand side of nav
            //we create an array to store the items from "pages" table
           $navitems = array();
           if($pages->num_rows > 0){
               while($row = $pages->fetch_assoc()) {
                    array_push($navitems,$row);
               }
           }
           echo "<ul class=\"nav navbar-nav navbar-left capitalize\">";
           foreach($navitems as $row){
               $name = $row["name"];
               $link = $row["link"];
               $side = $row["side"];
               //render the left side of navigation
               if($side=="left"){
                   if($link == $currentpage){
                       $class="active";
                   }
                   else{
                       $class="";
                   }
                   echo "<li class=\"$class\"><a href=\"$link\">$name</a></li>";
               }
           }
           echo "</ul>";
           echo "<ul class=\"nav navbar-nav navbar-right capitalize\">";
           foreach($navitems as $row){
               $name = $row["name"];
               $link = $row["link"];
               $side = $row["side"];
               $needlogin = $row["loginrequired"];
               //render the right side of navigation
               if($side=="right"){
                   if($link == $currentpage){
                       $class="active";
                   }
                   else{
                       $class="";
                   }
                   //if page does not need login
                   if($needlogin==0){
                       if($name == "login.php" && $_SESSION["user"]==true){
                           //don't render the login link if user is logged in
                           //this section is unfinished
                       }
                       else{
                           echo "<li class=\"$class\"><a href=\"$link\">$name</a></li>";
                       }
                   }
                   //if page needs login
                   elseif($needlogin==1 && $_SESSION["user"]){
                       echo "<li class=\"$class\"><a href=\"$link\">$name</a></li>";
                   }
                   elseif($needlogin==2 && $_SESSION["user"]["isadmin"]=='1'){
                       echo "<li class=\"$class\"><a href=\"$link\">$name</a></li>";
                   }
               }
           }
           ?>
        </div>
    </div>
    <!--we use this to show greeting for the user when logged in-->
    <div class="container user-bar">
        <div class="row">
            <div class="col-xs-12">
        <?php
        
        //display user's name if logged in
        if($_SESSION["user"]){
            if($_SESSION["user"]["firstname"]){
                //if we know firstname display it
                echo "Hello <span class=\"capitalize\">".$_SESSION["user"]["firstname"]."<span>";
            }
            else{
                //if we don't just display username
                echo "Hello <span class=\"capitalize\">".$_SESSION["user"]["name"]."<span>";
            }
        }
        ?>
            </div>
        </div>
    </div>
</header>