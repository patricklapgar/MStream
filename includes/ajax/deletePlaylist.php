<?php 
    include("../../config.php");

    if(isset($_POST['playlistId'])) {
        $playlistId = $_POST['playlistId'];

        // Delete playist and songs associated with that playlist when the deletePlaylist function is called
        $playlistQuery = mysqli_query($con, "DELETE FROM playlists WHERE id='$playlistId'");
        $songsQuery = mysqli_query($con, "DELETE FROM playlistSongs WHERE playlistId='$playlistId'");

    }else {
        echo "Playlist ID was not passed into deletePlaylist.php";
    }
?>