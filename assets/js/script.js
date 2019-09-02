var currentPlaylist = new Array();
var audioElement;

// Audio class
function Audio() {

    this.currentlyPlaying;
    this.audio = document.createElement('audio');

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

}