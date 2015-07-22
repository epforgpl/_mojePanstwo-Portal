var map,
    featureStyle = {
        fillColor: '#0000aa',
        fillOpacity: 0.05,
        strokeWeight: 2,
        strokeColor: '#0000aa'
    },
    featureHoverStyle = {
        fillColor: '#0000aa',
        fillOpacity: 0.3,
        strokeWeight: 2,
        strokeColor: '#0000aa'
    };

function mapHoverIn(dzielnicaName) {
    map.data.setStyle(function (feature) {
        var featureName = feature['A']['Name'];

        if (featureName == dzielnicaName) {
            return featureHoverStyle;
        } else {
            return featureStyle;
        }
    });
}
function mapHoverOut() {
    map.data.setStyle(function () {
        return featureStyle;
    });
}

function initialize() {
    var mapOptions = {
        zoom: 11,
        center: {lat: 50.0467656, lng: 20.0048731},
        draggable: true,
        scrollwheel: false,
        navigationControl: true,
        panControl: false,
        zoomControl: true,
        zoomControlOptions: {
            style: google.maps.ZoomControlStyle.SMALL
        },
        mapTypeControl: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scaleControl: false,
        streetViewControl: false,
        overviewMapControl: false
    };

    map = new google.maps.Map(document.getElementById('dzielnice_map'), mapOptions);
    map.data.loadGeoJson('/Dane/files/krakow_dzielnice.geojson');
    map.data.setStyle(featureStyle);

    google.maps.event.addListenerOnce(map, 'idle', function () {
        map.setZoom(11);
    });
    google.maps.event.addListener(map.data, 'click', function (event) {
        $('.dzielniceList a[data-dzielnica="' + event.feature['A']['Name'] + '"]')[0].click();
    });
    google.maps.event.addListener(map.data, 'mouseover', function (event) {
        $('.dzielniceList a[data-dzielnica="' + event.feature['A']['Name'] + '"]').addClass('hover');
        mapHoverIn(event.feature['A']['Name']);
    });
    google.maps.event.addListener(map.data, 'mouseout', function () {
        $('.dzielniceList a.hover').removeClass('hover');
        mapHoverOut();
    });
}

google.maps.event.addDomListener(window, 'load', initialize);

$(document).ready(function () {
    if ($(window).outerWidth() > 728) {
        var dzielniceMap = $('#dzielnice_map'),
            holder = dzielniceMap.parent().find('.holder'),
            fundatorzy = $('#fundatorzy').outerHeight(true);
        var size = $(window).outerHeight() - fundatorzy;

        holder.css('min-height', size);
        dzielniceMap.css('min-height', size);
    }

    $('.dzielniceList a').mouseover(function () {
        mapHoverIn($(this).data('dzielnica'));
    }).mouseout(function () {
        mapHoverOut();
    });
});