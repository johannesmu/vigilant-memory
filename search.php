<?php
include("session.php");
include("header.php");
include("searchbar.php");

//echo "you searched for ".$_POST["search-query"];
$query = $_POST["search-query"];
$searchquery = "SELECT * FROM products WHERE (description LIKE '%$query%') 
OR (name LIKE '%$query%')";
$result = $dbconnection->query($searchquery);



?>
<main class="main">
    <div class="container">
    <?php
    if($result->num_rows > 0){
        echo "<div class=\"row\">
            <div class=\"col-xs-12 col-md-6 col-md-offset-3\">
                <h4>Products matching your search for <em>$query</em></h4>
            </div>
        </div>";
        while($row = $result->fetch_assoc()){
            $id = $row["id"];
            $name = $row["name"];
            $description = $row["description"];
            $image = $row["image"];
            echo "<div class=\"row search-row\">";
            echo "<div class=\"col-sm-3\">
                <img src=\"products/$image\" class=\"responsive-image\">
                </div>";
            echo "<div class=\"col-sm-3\">
            <h3>$name</h3>
            $description
            </div>";
            echo "</div>";
        }
    }    
    ?>
    </div>
</main>