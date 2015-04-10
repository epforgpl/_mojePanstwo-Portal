var map;

function initialize() {
    var mapOptions = {
        zoom: 11,
        draggable: true,
        disableDefaultUI: true,
        scrollwheel: false,
        navigationControl: true,
        mapTypeControl: false,
        scaleControl: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById('dzielnice_map'), mapOptions);

    var kmlUrl = 'http://mojepanstwo.pl/files/dzielnice_administracyjne.kml';
    var kmlOptions = {
        suppressInfoWindows: true,
        preserveViewport: false,
        map: map
    };

    var kmlLayer = new google.maps.KmlLayer(kmlUrl, kmlOptions);

    google.maps.event.addListenerOnce(map, 'idle', function () {
        map.setZoom(11);
    });
    google.maps.event.addListener(kmlLayer, 'click', function (kmlEvent) {
        $('.dzielniceList a[data-dzielnica="' + kmlEvent.featureData['name'] + '"]')[0].click();
    });

}

google.maps.event.addDomListener(window, 'load', initialize);


$(document).ready(function () {
    var header = $('.objectPageHeaderBg').outerHeight(true),
        holder = $('.holder'),
        dzielniceMap = $('#dzielnice_map'),
        fundatorzy = $('#fundatorzy').outerHeight(true);

    var size = $(window).outerHeight() - header - fundatorzy;

    holder.css('height', size);
    dzielniceMap.css('height', size);
});