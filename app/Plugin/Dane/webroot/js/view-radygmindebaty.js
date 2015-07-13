/*LOAD YOUTUBE BASIC JS*/
var tag = document.createElement('script');
tag.src = "http://www.youtube.com/player_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
var player;

/*GENERATE YT IFRAME*/
function onYouTubePlayerAPIReady() {
    var videoId = jQuery('#player').data('youtube');

    player = new YT.Player('player', {
        videoId: videoId,
        events: {
            'onReady': function () {
                /*SEAK AND JUMP TO SPECIFY SEC AT MOVIE*/
                var hash = window.location.hash;

                if (hash) {
                    var a = jQuery('.wystapienia ul li a[href=' + hash + ']');
                    seeker(jQuery(a).data('video-position'));
                }

                jQuery('.wystapienia ul').find('li a').click(function () {
                    seeker(jQuery(this).data('video-position'));
                    return false;
                });

                // sticky('#ytVideo', 'down');
            }
        }
    });
}

function seeker(frame) {
    if (player.getPlayerState() != 1) {
        if (player.getPlayerState() != 3)
            player.playVideo();
        setTimeout(function () {
            seeker(frame)
        }, 1000);
    } else {
        player.seekTo(frame)
    }
}