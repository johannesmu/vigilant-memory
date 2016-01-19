<?php
include("header.php");
include("searchbar.php");
//get pages from db to show content
$contentquery = "SELECT id,name,title,link,content FROM pages WHERE link='$currentpage'";
$content = $dbconnection->query($contentquery);
if($content->num_rows > 0){
   while($row = $content->fetch_assoc()) {
        $contentid = $row["id"];
        $contentname = $row["name"];
        $contenttitle = $row["title"];
        $contentlink = $row["link"];
        $contenttext = $row["content"];
    }
}
?>
<main class="main">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2><?php echo $contenttitle;?></h2>
            </div>
            <div class="col-md-12">
                <p>
                    <?php echo $contenttext;?>
                </p>
            </div>
        </div>
    </div>
</main>
<?php
include("footer.php");
?>