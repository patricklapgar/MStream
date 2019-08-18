<?php include("includes/header.php"); ?>
					
<h1 class="pageHeadingBig">You Might Also Like</h1>

<!-- 
    In later versions, create functionality where user hovers 
    over a tab in the navigation bar and sees a preview of the following page.

    Also, see about changing black background to biege and using the same hover functionality
    for the music/albums.
-->

<div class="gridViewContainer">

    <?php 
        $albumQuery = mysqli_query($con, "SELECT * FROM albums ORDER BY RAND() LIMIT 10");

        while($row = mysqli_fetch_array($albumQuery)) {
            // The . syntax joins two or more strings together

            echo "<div class='gridViewItem'>
                    <a href='album.php?id=" . $row['id'] ."'>
                        <img src='" . $row['artworkPath'] . "'>

                        <div class='gridViewInfo'>"
                            . $row['title'] .
                        "</div>
                    </a>
            </div>";
        }
    ?>

</div>

<?php include("includes/footer.php"); ?>