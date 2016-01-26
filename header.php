<?php
//get current page name
$currentpage = basename($_SERVER['PHP_SELF']);
//include the script for database connection
include("db/dbconnection.php");
// get pages from db to show in navigation
$pagequery = "SELECT id,name,link,content,image FROM pages";
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
               if($pages->num_rows > 0){
                   $count=0;
                   while($row = $pages->fetch_assoc()) {
                       if($count==0){
                           echo "<ul class=\"nav navbar-nav capitalize\">";
                       }
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
                        $count++;
                    }
                    //close the nav
                    echo "</ul>";
               }
               ?>
           
            <ul class="nav navbar-nav navbar-right capitalize">
                <?php
                //since the navigation items are not in the database, we create them here
                //as an associative array in the form of "name"=>"link" format
                $items = ["cart"=>"shoppingcart.php","login/register"=>"login.php"];
                //render the items here and add the active class if the link
                //match the $currentpage variable defined on the top of this page
                foreach($items as $name=>$link){
                    if($link == $currentpage){
                        $class="active";
                    }
                    else{
                        $class="";
                    }
                    echo "<li class=\"$class\"><a href=\"$link\">$name</a></li>";
                }
                ?>
            </ul>
            
        </div>
    </div>
    
</header>
