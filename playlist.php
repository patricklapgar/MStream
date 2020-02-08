<?php include("includes/includedFiles.php");

    if(isset($_GET['id'])) {
        $playlistId = $_GET['id'];
    } else {
        header("Location: index.php");
    }
  
    $playlist = new Playlist($con, $playlistId);
    $owner = new User($con, $playlist->getOwner());
    
?>

<div class="entityInfo">
    
    <div class="leftSection">
        <div class="playlistImage">
            <img src="assets/images/icons/playlist.png" alt="">
        </div>
    </div>

    <div class="rightSection">
        <h2><?php echo $playlist->getName(); ?></h2>
        <p>By <?php  echo $playlist->getOwner(); ?> </p>
        <p><?php echo $playlist->getNumberOfSongs(); ?> Songs</p>
        <button class="button buttonSpecial" onclick="deletePlaylist('<?php echo $playlistId; ?>')">DELETE PLAYLIST</button>
    </div>

</div>

<div class="tracklistContainer">
    <ul class="trackList">
        <?php 
            $songIdArray = $playlist->getSongIds();

            // counter variable 
            $i = 1;
            foreach($songIdArray as $songId){
                // Creating song object
                $playlistSong = new Song($con, $songId);
                $songArtist = $playlistSong->getArtist();

                echo "<li class='tracklistRow'> 
                        <div class='trackCount'>
                            <img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $playlistSong->getId() . "\", tempPlaylist, true)'>
                            <span class='trackNumber'>$i</span>
                        </div>

                        <div class='trackInfo'>
                            <span class='trackName'>" . $playlistSong->getTitle() . "</span>
                            <span class='artistName'>" . $songArtist->getName() . "</span>
                        </div>

                        <div class='trackOptions'>
                            <img class='optionsButton' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
                        </div>

                        <div class='trackDuration'>
                            <span class='songDuration'>" . $playlistSong->getDuration() . "</span>                        
                        </div>

                     </li>";

                $i++;

            }
            
        ?>

            <script>
                var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
                tempPlaylist = JSON.parse(tempSongIds);
                
                
            </script>

    </ul>
</div>