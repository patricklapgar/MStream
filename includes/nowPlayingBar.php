<?php 
    // Create a playlist of 10 random songs from the database
    $songQuery = mysqli_query($con, "SELECT * FROM songs ORDER BY RAND() LIMIT 10");
    $resultArray = array();

    // Convert the result of the 'songQuery' variable into an array
    while($row = mysqli_fetch_array($songQuery)){
        // Push the id of each random song into the result array
        array_push($resultArray, $row['id']);
    }

    // Convert PHP array into JSON array
    $jsonArray = json_encode($resultArray);
?>

<script>
    $(document).ready(function() {
        // Remember this variable below is an array of song IDs
        var newPlaylist = <?php echo $jsonArray; ?>;
        audioElement = new Audio();

        // Set tracklist
        setTrack(newPlaylist[0], newPlaylist, false);
        updateVolumeProgressBar(audioElement.audio);

        
        $("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e) {
            e.preventDefault();
        });

        // The jQuery blocks below will let the user drag the playbar progress other points in the song
       $(".playbackBar .progressBar").mousedown(function() {
            mouseDown = true;
       });

       $(".playbackBar .progressBar").mousemove(function(e) {
        if(mouseDown) {
                // Set time of song, depending on position of mouse
                timeFromOffset(e, this);
            }
       });

       $(".playbackBar .progressBar").mouseup(function(e) {
           timeFromOffset(e, this);
       });
        

    //   Volume button control functions
    $(".volumeBar .progressBar").mousedown(function() {
            mouseDown = true;
       });

    $(".volumeBar .progressBar").mousemove(function(e) {
        if(mouseDown) {
            var percentage = e.offsetX / $(this).width();
            if(percentage >= 0 && percentage <= 1){
                    audioElement.audio.volume = percentage;
                }
            }
       });

       $(".volumeBar .progressBar").mouseup(function(e) {
            var percentage = e.offsetX / $(this).width();
            if(percentage >= 0 && percentage <= 1){
                audioElement.audio.volume = percentage;
            }
       });
        
       $(document).mouseup(function() {
            mouseDown = false;
       });

    });

    function timeFromOffset(mouse, progressBar) {
        var percentage = mouse.offsetX / $(progressBar).width() * 100;
        var seconds = audioElement.audio.duration * (percentage / 100);
        audioElement.setTime(seconds);
    }

    // previous song function
    function previousSong() {
        if(audioElement.audio.currentTime >= 3 || currentIndex == 0) {
            audioElement.setTime(0);
        } else {
            currentIndex = currentIndex - 1;
            setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
        }
    }

     // skip song function
    function nextSong() {

        if(repeat == true) {
            audioElement.setTime(0);
            playSong();
            return;
        }

        if(currentIndex == currentPlaylist.length - 1) {
            currentIndex = 0;
        }else {
            currentIndex++;
        }

        var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
        setTrack(trackToPlay, currentPlaylist, true);
    }

    // Shuffle song function
    function setShuffle() {
        shuffle = !shuffle;
        var imageName = shuffle ? "shuffle-active.png" : "shuffle.png";
        $(".controlButton.shuffle img").attr("src", "assets/images/icons/" + imageName);
    
        if(shuffle) {
            // randomize playlist
            shuffleArray(shufflePlaylist);
            currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
        } else {
            // shuffle is deactivated
            // go back to regular playlist
            currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
        }
    }

    // Repeat song function
    function setRepeat() {
        repeat = !repeat;
        var imageName = repeat ? "repeat-active.png" : "repeat.png";
        $(".controlButton.repeat img").attr("src", "assets/images/icons/" + imageName);
    }

    function shuffleArray(array) {
        var j, x, i;
        for(i = array.length; i; i--) {
            j = Math.floor(Math.random() * i);
            x = array[i - 1];
            array[i - 1] = array[j];
            array[j] = x;
        }

    }

    // Mute song function
    function setMute() {
        audioElement.audio.muted = !audioElement.audio.muted;
        var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
        $(".controlButton.volume img").attr("src", "assets/images/icons/" + imageName);
    }

    // Public set track function
    function setTrack(trackId, newPlaylist, play) {

        if(newPlaylist != currentPlaylist) { 
            currentPlaylist = newPlaylist;
            shufflePlaylist = currentPlaylist.slice();
            shuffleArray(shufflePlaylist);
        }

        if(shuffle == true) {
            currentIndex = shufflePlaylist.indexOf(trackId);
        } else {
            currentIndex = currentPlaylist.indexOf(trackId);
        }
        
        pauseSong();

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

                $(".trackInfo .artistName span").text(artist.name);
                $(".trackInfo .artistName span").attr("onclick", "openPage('artist.php?id=" + artist.id + "')");
            });

            $.post("includes/handlers/ajax/getAlbumJson.php", { albumId: track.album }, function(data) {
                var album = JSON.parse(data);
                $(".content .albumLink img").attr("src", album.artworkPath);
                $(".content .albumLink img").attr("onclick", "openPage('album.php?id=" + album.id + "')");
                $(".trackInfo .trackName span").attr("onclick", "openPage('album.php?id=" + album.id + "')");
            });

            audioElement.setTrack(track);
            
            // If the play button has been pressed, then play the current song
            if(play == true) {
                playSong();
            }
        });
     }

     function playSong() {
        if(audioElement.audio.currentTime == 0){
            // ajax call to update play count each time a song is played
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
                        <img role="link" tabindex="0" src="" class="albumArtwork" width="57px">
                    </span>

                    <div class="trackInfo">
                        <span class="trackName">
                            <span role="link" tabindex="0"></span>
                        </span>

                        <span class="artistName">
                            <span role="link" tabindex="0"></span>
                        </span>
                    </div>

                </div>
        </div>

        <div id="nowPlayingCenter">
            <div class="content playerControls">

                <div class="buttons">
                    <button class="controlButton shuffle" title="Shuffle" onclick="setShuffle()">
                        <img src="assets/images/icons/shuffle.png" alt="shuffle">
                    </button>

                    <button class="controlButton previous" title="Take it back a bit" onclick="previousSong()">
                        <img src="assets/images/icons/previous.png" alt="previous">
                    </button>
                    
                    <button class="controlButton play" title="Play dat song" onclick="playSong()">
                        <img src="assets/images/icons/play.png" alt="play">
                    </button>

                    <button class="controlButton pause" title="Hold up!" style="display: none;" onclick="pauseSong()">
                        <img src="assets/images/icons/pause.png" alt="pause">
                    </button>
                    
                    <button class="controlButton next" title="Thank u, next" onclick="nextSong()">
                        <img src="assets/images/icons/next.png" alt="next">
                    </button>
                    
                    <button class="controlButton repeat" title="Repeat song" onclick="setRepeat()">
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
                <button class="controlButton volume" title="Volume button" onclick="setMute()">
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