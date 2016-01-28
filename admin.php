<?php 
include("session.php");
include("header.php");

$redirectto = "index.php";
if($_SESSION["user"]["isadmin"]==false){
    header('Location: '.$redirectto);
    die();
}
?>
<!--check here if the visitor has logged on as admin-->

<!doctype html>
<html>
    <head>
        <title>Admin Panel</title>
        <link rel="stylesheet" href="../components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../style.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h1>Admin Interface</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h2>Products</h2>
                    
                </div>
            </div>
        </div>
        <script src="../components/jquery/dist/jquery.min.js"></script>
    </body>
</html>