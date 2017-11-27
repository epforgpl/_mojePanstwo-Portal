/*global $,jQuery,mPHeart,google,googleMapAdres*/
var googleMap, panorama, addLatLng, marker;

function initialize() {
    "use strict";
    //SETTING DEFAULT CENTER TO GOOGLE MAP AT POLAND//
	
	$('.mp-adres').each(function(){
		var el = $(this);
		var bg = el.find('.bg');
		if( el.length && bg.length ) {
			var url = el.data('adres');
			if( url ) {
				
				var width = bg.width();
				bg.append('<img class="googleMapImage" src="https://maps.googleapis.com/maps/api/staticmap?center=' + url + '&markers=' + url + '&zoom=15&sensor=false&scale=2&feature:road&size=' + width + 'x270&language=' + mPHeart.language.twoPerThreeDig + '" />');
				
			}
		}
	});
	
    var infowindow,
        element,
        contentStringHeightTemp,
        polandLatlng = new google.maps.LatLng(51.919438, 19.145136),
        mapOptions = {
            zoom: 15,
            center: polandLatlng
        },
        geocoder = new google.maps.Geocoder(),
        contentString = document.createElement("div");

    googleMap = new google.maps.Map(document.getElementById('googleMap'), mapOptions);

    contentString.innerHTML = googleMapAdres + '<a href="https://maps.google.com/maps?key=' + mPHeart.keys.google.maps + '&daddr=' + googleMapAdres.replace(/ /g, '+') + '&t=m" target="_blank" class="btn btn-info">Dojazd</a>';
    contentString.id = "googleMapsContent";
    contentString.style.width = "360px";

    /*GETTING HEIGHT OF CONTENT*/
    contentStringHeightTemp = contentString.cloneNode(true);
    contentStringHeightTemp.style.visibility = "hidden";
    document.body.appendChild(contentStringHeightTemp);

    /*ADDING HEIGHT TO ORIGIN NODE*/
    contentString.style.height = contentStringHeightTemp.clientHeight;

    /*REMOVING CLONED NODE*/
    element = document.getElementById("googleMapsContent");
    element.parentNode.removeChild(element);

    infowindow = new google.maps.InfoWindow({
        content: contentString
    });

    function wrapAngle(angle) {
        if (angle >= 360) {
            angle -= 360;
        } else if (angle < 0) {
            angle += 360;
        }
        return angle;
    }

    function computeAngle(endLatLng, startLatLng) {
        var DEGREE_PER_RADIAN = 57.2957795,
            RADIAN_PER_DEGREE = 0.017453,
            dlat = endLatLng.lat() - startLatLng.lat(),
            dlng = endLatLng.lng() - startLatLng.lng(),
            yaw;
        // We multiply dlng with cos(endLat), since the two points are very closeby,
        // so we assume their cos values are approximately equal.
        yaw = Math.atan2(dlng * Math.cos(endLatLng.lat() * RADIAN_PER_DEGREE), dlat) * DEGREE_PER_RADIAN;
        return wrapAngle(yaw);
    }

    function showPanoData(panoData, status) {
        if (status !== google.maps.StreetViewStatus.OK) {
            $('#streetView').html(mPHeart.translation.LC_DANE_VIEW_KRSPODMIOTY_NO_STREETVIEW_PICTURE_AVAILABLE).attr('style', 'text-align:center;font-weight:bold,position: relative; top: 50%; margin-top: -10px').show();
            return;
        }

        var angle = computeAngle(addLatLng, panoData.location.latLng),
            panoOptions = {
                position: addLatLng,
                addressControl: false,
                linksControl: false,
                panControl: false,
                zoomControlOptions: {
                    style: google.maps.ZoomControlStyle.SMALL
                },
                pov: {
                    heading: angle,
                    pitch: 10,
                    zoom: 1
                },
                enableCloseButton: false,
                visible: true
            };

        panorama.setOptions(panoOptions);
    }

    function createStreetview(lat, lng) {
        panorama = new google.maps.StreetViewPanorama(document.getElementById("streetView"));
        addLatLng = new google.maps.LatLng(lat, lng);
        var service = new google.maps.StreetViewService();
        service.getPanoramaByLocation(addLatLng, 50, showPanoData);
    }

    geocoder.geocode({'address': googleMapAdres}, function (results, status) {
        if (status === google.maps.GeocoderStatus.OK) {
            var gps = results[0].geometry.location;
            marker = new google.maps.Marker({
                map: googleMap,
                position: gps
            });

            createStreetview(gps.lat(), gps.lng());

            //CENTER ON MARKER
            googleMap.setCenter(results[0].geometry.location);

            google.maps.event.addListener(marker, 'click', function () {
                infowindow.open(googleMap, marker);
            });

            google.maps.event.addListenerOnce(googleMap, 'idle', function () {
                $('#googleMapBtnModal').removeClass('show');
            });
        }
    });
}

//ASYNC INIT GOOGLE MAP JS//
function loadScript() {
    "use strict";
    if ((typeof google !== "undefined") && google.maps) {
        initialize();
    } else {
        var script = document.createElement('script');
        script.type = 'text/javascript';
		script.src = 'https://maps.googleapis.com/maps/api/js?v=3.21&key=' + mPHeart.keys.google.maps + '&sensor=false&language=' + mPHeart.language.twoPerThreeDig + '&' + 'callback=initialize';
        document.body.appendChild(script);
    }
}

jQuery(document).ready(function () {
    "use strict";
    var banner = jQuery('.mp-adres'),
        mapsOptions = $('.mapsOptions '),
        googleViewBtn = $('.googleViewBtn'),
        googleMapBtnModal = $('#googleMapBtnModal');

    if (banner.length > 0) {
        banner.find('.bg img').css({'width': banner.outerWidth() + 'px', 'height': banner.outerHeight() + 'px'});

        window.load = loadScript();

        $('.googleMapBtnModal').click(function (e) {
            var self = $(this);

            e.preventDefault;

            googleMapBtnModal.on('shown.bs.modal', function () {
                if (self.hasClass('reload')) {
                    self.removeClass('reload');

                    google.maps.event.trigger(googleMap, 'resize');
                    google.maps.event.trigger(panorama, 'resize');

                    google.maps.event.trigger(marker, 'click');
                }
            });
            googleMapBtnModal.modal('show');
        });


        googleViewBtn.find('.btn').click(function () {
            var self = $(this);

            if (!self.hasClass('.active')) {
                if (self.hasClass('showGoogleMap')) {
                    $('#streetView').animate({
                        left: '-100%'
                    });
                    self.addClass('active');
                    googleViewBtn.find('.showStreetView').removeClass('active')
                } else {
                    $('#streetView').animate({
                        left: '0'
                    });
                    self.addClass('active');
                    googleViewBtn.find('.showGoogleMap').removeClass('active')
                }
            }
        })
    }
});
