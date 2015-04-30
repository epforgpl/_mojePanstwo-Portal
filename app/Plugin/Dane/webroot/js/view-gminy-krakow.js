/*global $,jQuery,mPHeart,google*/

var map;

function initMap() {
    "use strict";
    var mapOptions = {
            zoom: 11,
            draggable: true,
            disableDefaultUI: true,
            scrollwheel: false,
            navigationControl: true,
            mapTypeControl: false,
            scaleControl: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        },
        kmlOptions,
        kmlUrl,
        kmlLayer,
        text;

    map = new google.maps.Map(document.getElementById('dzielnice_map'), mapOptions);

    kmlUrl = 'http://mojepanstwo.pl/files/dzielnice_administracyjne.kml';
    kmlOptions = {
        suppressInfoWindows: true,
        preserveViewport: false,
        map: map
    };

    kmlLayer = new google.maps.KmlLayer(kmlUrl, kmlOptions);

    google.maps.event.addListenerOnce(map, 'idle', function () {
        map.setZoom(11);
    });

    google.maps.event.addListener(kmlLayer, 'click', function (kmlEvent) {
        text = kmlEvent.featureData;
    });
}

function initialize() {
    "use strict";
    google.maps.event.addDomListener(window, 'load', initMap);
}

function loadScript() {
    "use strict";
    if (google.maps) {
        initialize();
    } else {
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&language=' + mPHeart.language.twoDig + '&' + 'callback=initialize';
        document.body.appendChild(script);
    }
}

$(document).ready(function () {
    "use strict";
    if ($('dzielnice_map').length) {
        window.onload = loadScript();
    }
});