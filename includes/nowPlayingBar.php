<?php 

    // Create a playlist of 10 random songs from the database
    $songQuery = mysqli_query($con, "SELECT * FROM songs ORDER BY RAND() LIMIT 10");
    
    // Playist of random songs
    $resultArray = array();

    // Convert the result of the 'songQuery' variable into an array
    while($row = mysqli_fetch_array($songQuery)){
        // Push the id of each random song into the result array
        array_push($resultArray, $row['id']);
    }

    // Convert PHP variable into JSON to be understood by JavaScript
    $jsonArray = json_encode($resultArray);
?>

<script>
    $(document).ready(function() {
        // Remember this variable below is an array of song IDs
        currentPlaylist = <?php echo $jsonArray; ?>;
        audioElement = new Audio();

        // Set tracklist
        setTrack(currentPlaylist[0], currentPlaylist, true);
    });

    // Public set track function
    function setTrack(trackId, newPlaylist, play) {
        // Ajax call
         /* 
         Ajax calls come in up to 3 pieces : 
         1. The url of the page used when the ajax request is called
         2. The data which is passed into the requested webpage
         3. A callback function which handles the result data
         */
        $.post("includes/handlers/ajax/getSongJson.php", { songId: trackId }, function(data) {
            // Convert json into an object
            var track = JSON.parse(data);

            $(".trackName span").text(track.title);

            $.post("includes/handlers/ajax/getArtistJson.php", { artistId: track.artist }, function(data) {
                var artist = JSON.parse(data);

                $(".artistName span").text(artist.name);
            });

            $.post("includes/handlers/ajax/getAlbumJson.php", { albumId: track.album }, function(data) {
                var album = JSON.parse(data);

            
                $(".albumLink img").attr("src", album.artworkPath);
            });

            audioElement.setTrack(track);
            playSong();
        });

        // If the play button has been pressed, then play the current song
        if(play == true) {
                audioElement.play();
            }
     }

     function playSong() {
        // ajax call to update play count each time a song is played
        if(audioElement.audio.currentTime == 0){
            $.post("includes/handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id });
        }

         $(".controlButton.play").hide();
         $(".controlButton.pause").show();
         audioElement.play();
     }

     function pauseSong() {
        $(".controlButton.play").show();
         $(".controlButton.pause").hide();
         audioElement.pause();
     }
</script>


<div id="nowPlayingBarContainer">
    <div id="nowPlayingBar">
        <div id="nowPlayingLeft">
                <div class="content">
                    <span class="albumLink">
                        <img src="" class="albumArtwork" width="57px">
                    </span>

                    <div class="trackInfo">
                        <span class="trackName">
                            <span></span>
                        </span>

                        <span class="artistName">
                            <span></span>
                        </span>
                    </div>

                </div>
        </div>

        <div id="nowPlayingCenter">
            <div class="content playerControls">

                <div class="buttons">
                    <button class="controlButton shuffle" title="Shuffle">
                        <img src="assets/images/icons/shuffle.png" alt="shuffle">
                    </button>

                    <button class="controlButton previous" title="Take it back a bit">
                        <img src="assets/images/icons/previous.png" alt="previous">
                    </button>
                    
                    <button class="controlButton play" title="Play dat song" onclick="playSong()">
                        <img src="assets/images/icons/play.png" alt="play">
                    </button>

                    <button class="controlButton pause" title="Hold up!" style="display: none;" onclick="pauseSong()">
                        <img src="assets/images/icons/pause.png" alt="pause">
                    </button>
                    
                    <button class="controlButton next" title="Thank u, next">
                        <img src="assets/images/icons/next.png" alt="next">
                    </button>
                    
                    <button class="controlButton repeat" title="Repeat song">
                        <img src="assets/images/icons/repeat.png" alt="repeat">
                    </button>
                </div>

                <div class="playbackBar">
                    <span class="progressTime current">0.00</span>

                    <div class="progressBar">
                        <div class="progressBarBg">
                            <div class="progress"></div>
                        </div>
                    </div>
                    
                    <span class="progressTime remaining">0.00</span>
                </div>

            </div>
        </div>

        <div id="nowPlayingRight">
            <div class="volumeBar">
                <button class="controlButton volume" title="Volume button">
                    <img src="assets/images/icons/volume.png" alt="Volume">
                </button>

                <div class="progressBar">
                    <div class="progressBarBg">
                        <div class="progress"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>