<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <h4>Categories</h4>
                <nav role="navigation">
                    <ul class="nav nav-pills nav-stacked cap">
                        <?php 
                            $categoryquery = "SELECT name,id FROM categories";
                            $catresult = $dbconnection->query($categoryquery);
                            if($catresult->num_rows > 0){
                                while($row = $catresult->fetch_assoc()) {
                                    $id = $row["id"];
                                    $name = $row["name"];
                                    echo "<li><a href=\"store.php?category=$id\">$name</a></li>";
                                }
                            }
                            else {
                                echo "0 results";
                            }
                            
                        ?>
                    </ul>
                </nav>
            </div>
            <div class="col-sm-2">
                <h4>About Us</h4>
                <nav role="navigation">
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="contact.php">Contact Us</a></li>
                        <li><a href="about.php">About Us</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-sm-2">
                <h4>Follow Us</h4>
                <nav>
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="#">Facebook</a></li>
                        <li><a href="#">Instagram</a></li>
                        <li><a href="#">Twitter</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-sm-2">
                <h4>Meta</h4>
                <ul class="nav nav-pills nav-stacked">
                    <li><a href="admin/">Manage</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<?php 
include("scripts/client-scripts.php");
?>
