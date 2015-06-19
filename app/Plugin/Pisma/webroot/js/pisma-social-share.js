jQuery(document).ready(function () {
    var shoutItBox = jQuery('.shareIt');

    if (shoutItBox.length) {
        /* ShoutIt on Facebook - loading Facebook JS*/
        /* Added as absolute link at \app\Plugin\Pisma\View\Pisma\view.ctp */

        /* ShoutIt on Twitter - loading Twitter JS*/
        !function () {
            var js, fjs = document.getElementsByTagName("script")[0], p = /^http:/.test(document.location) ? 'http' : 'https';
            if (!document.getElementById("twitter-wjs")) {
                js = document.createElement("script");
                js.id = "twitter-wjs";
                js.src = p + '://platform.twitter.com/widgets.js';
                fjs.parentNode.insertBefore(js, fjs);
            }
        }();

        /* ShoutIt on Wykop - generate wykop iframe *sic* */
        /* Added as absolute link at \app\Plugin\Pisma\View\Pisma\view.ctp */
    }
});