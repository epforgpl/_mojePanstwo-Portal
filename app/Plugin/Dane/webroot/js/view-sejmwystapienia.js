/*LOAD YOUTUBE BASIC JS*/
var tag = document.createElement('script');
tag.src = "//www.youtube.com/player_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

/*GENERATE YT IFRAME*/
function onYouTubeIframeAPIReady() {
    var player = new YT.Player('pb_player', {
        videoId: jQuery('#pb_player').data('youtube')
    });
}