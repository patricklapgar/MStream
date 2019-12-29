var currentPlaylist = new Array();
var shufflePlaylist = new Array();
var tempPlaylist = new Array();
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var userLoggedIn;

// This function will allow seamless page transition from one page to another
function openPage(url) {
    if(url.indexOf("?") == -1){
        url = url + "?";
    }
        var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
        $("#mainContent").load(encodedUrl);
        $("#body").scrollTop(0);
        history.pushState(null, null, url);
}

function formatTime(seconds) {
    var time = Math.round(seconds);
    var minutes = Math.floor(time / 60); // Rounds down
    var seconds = time - minutes * 60;

    var extraZero = (seconds < 10) ? "0" : "";

    return minutes + ":" + extraZero + seconds;
}

function updateTimeProgressBar(audio){
    $(".progressTime.current").text(formatTime(audio.currentTime));
    $(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime));    

    var progress = audio.currentTime / audio.duration * 100;
    $(".playbackBar .progress").css("width", progress + "%");
}

function updateVolumeProgressBar(audio){ 
    var volume = audio.volume * 100;
    $(".volumeBar .progress").css("width", volume + "%");
}

// Audio class
function Audio() {

    this.currentlyPlaying;
    this.audio = document.createElement('audio');

    this.audio.addEventListener("ended", function() {
        nextSong();
    });

    // Event listeners
    this.audio.addEventListener("canplay", function() {
        // 'this' refers to the object that the event was called on
        // In this case, that object is the 'audio' object
        var duration = formatTime(this.duration);
        $(".progressTime.remaining").text(duration);
    });

    this.audio.addEventListener("timeupdate", function() {
        if(this.duration ) {
            updateTimeProgressBar(this);
        }
    });

    this.audio.addEventListener("volumechange", function(){
        updateVolumeProgressBar(this);
    });

    // This function will be called everytime a new song is selected
    this.setTrack = function(track) {
        this.currentlyPlaying = track;
        this.audio.src = track.path;
    }

    this.play = function() {
        this.audio.play();
    }

    this.pause = function() {
        this.audio.pause();
    }

    this.setTime = function(seconds) {
        this.audio.currentTime = seconds;
    }

}