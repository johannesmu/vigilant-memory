<?php 
include("header.php");

//check if get variable is set so we can show 
if(isset($_GET["category"])){
    $chosen = $_GET["category"];
}
else{
    $chosen = "0";
}

?>
<main class="main">
    <div class="container">
        <h1>Hello Bootstrap</h1>
        <p>
            <?php
            echo $chosen;
            ?>
        </p>
    </div>
</main>
<?php include("footer.php"); ?>
</body>
</html>