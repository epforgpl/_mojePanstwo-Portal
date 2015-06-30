/*global $,JQuery, mPHeart, google*/
var googleMap,
    geolocalizateMe,
    markers = [];

function initialize() {
    var polandLatlng = new google.maps.LatLng(51.919438, 19.145136),
        mapOptions = {
            zoom: 6,
            center: polandLatlng
        },
        markerImage = {
            url: 'http://maps.gstatic.com/mapfiles/place_api/icons/geocode-71.png',
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(25, 25)
        };

    googleMap = new google.maps.Map(document.getElementById('googleMap'), mapOptions);

    google.maps.event.addListenerOnce(googleMap, 'idle', function () {
        $('.googleBtn').fadeIn();
        $('.googleMapElement').addClass('loaded');
    });

    google.maps.event.addListener(googleMap, "click", function (event) {
        clearMarkers();
        markers = [];

        var marker = new google.maps.Marker({
            map: googleMap,
            icon: markerImage,
            position: event.latLng
        });

        markers.push(marker);
    });

    var input = document.getElementById('pac-input');
    googleMap.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    var searchBox = new google.maps.places.SearchBox(input);
    google.maps.event.addListener(searchBox, 'places_changed', function () {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }
        for (var i = 0, marker; marker = markers[i]; i++) {
            marker.setMap(null);
        }

        clearMarkers();
        markers = [];

        var bounds = new google.maps.LatLngBounds();
        for (var i = 0, place; place = places[i]; i++) {
            var marker = new google.maps.Marker({
                map: googleMap,
                icon: markerImage,
                title: place.name,
                position: place.geometry.location
            });

            markers.push(marker);
            bounds.extend(place.geometry.location);
        }
        googleMap.fitBounds(bounds);
    });

    google.maps.event.addListener(googleMap, 'bounds_changed', function () {
        var bounds = googleMap.getBounds();
        searchBox.setBounds(bounds);
    });

    geolocalizateMe = function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var pos = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

                clearMarkers();
                markers = [];

                var bounds = new google.maps.LatLngBounds();
                var marker = new google.maps.Marker({
                    map: googleMap,
                    icon: markerImage,
                    position: pos
                });

                markers.push(marker);

                bounds.extend(pos);
                googleMap.fitBounds(bounds);
            }, function () {
                handleNoGeolocation(true);
            });
        } else {
            // Browser doesn't support Geolocation
            handleNoGeolocation(false);
        }

        function handleNoGeolocation(errorFlag) {
            var content = '';

            if (errorFlag) {
                content = 'Błąd: System geolokalizacji nie odpowiada.';
            } else {
                content = 'Błąd: Twoja przeglądarka nie wspiera geolokalizacji.';
            }

            var options = {
                map: googleMap,
                position: polandLatlng,
                content: content,
                zoom: 6
            };

            var infowindow = new google.maps.InfoWindow(options);
            googleMap.setCenter(options.position);
        }
    };
}

function clearMarkers() {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(null);
    }
}


//ASYNC INIT GOOGLE MAP JS//
function loadScript() {
    if ((typeof google !== "undefined") && google.maps) {
        initialize();
    } else {
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = 'https://maps.googleapis.com/maps/api/js?sensor=false&language=' + mPHeart.language.twoDig + '&libraries=places&callback=initialize';
        document.body.appendChild(script);
    }
}

$(document).ready(function () {
    var objectMain = $('.objectMain'),
        form = objectMain.find('form'),
        imageEditor = objectMain.find('.image-editor'),
        imageAlert = imageEditor.find('.alert.alert-danger'),
        imageChoosed = imageEditor.find('input[name="cover_photo"]'),
        googleBtn = $('.googleBtn'),
        googleLocMeBtn = $('#loc'),
        googleMapBlock = $('.googleMapElement'),

        cropItErrorMsg = function () {
            if (mPHeart.language.twoDig == 'pl') {
                if (error.code === 0) {
                    error.message = 'Błąd ładowowania zdjęcia - proszę spróbować inne.'
                } else if (error.code === 1) {
                    error.message = 'Zdjęcie nie spełnia zalecanej wielkości.'
                }
            }

            if (alert.length) {
                alert.text(error.message);
            } else {
                imageAlert = $('<div></div>').addClass('alert alert-danger').text(error.message);

                el.find('.image-editor').prepend(
                    imageAlert.slideDown()
                );
            }
        };


    if (imageEditor.length) {
        var imageWidth = 874,
            imageHeight = 347,
            imgEditorWidth = imageEditor.width(),
            imgEditorHeight = imageHeight * (imageEditor.width() / imageWidth),
            exportZoom = imageWidth / imageEditor.width();

        imageEditor.css({'width': imgEditorWidth, height: imgEditorHeight}).cropit({
            imageState: {
                src: (imageChoosed.val() !== "") ? imageChoosed.val() : ''
            },
            width: imgEditorWidth,
            height: imgEditorHeight,
            exportZoom: exportZoom,
            onImageLoaded: function () {
                imageEditor.find('.alert').slideUp("normal", function () {
                    $(this).remove();
                });
            },
            onFileReaderError: function (evt) {
                cropItErrorMsg(evt);
            },
            onImageError: function (evt) {
                cropItErrorMsg(evt);
            }
        });
        objectMain.find('.submitBtn').click(function (e) {
            e.preventDefault();
            imageChoosed.val(imageEditor.cropit('export', {
                type: 'image/jpeg',
                quality: .9
            }));

            if (markers.length) {
                googleMapBlock.find('input[name="geo_lat"]').val(markers[0].getPosition().lat());
                googleMapBlock.find('input[name="geo_lng"]').val(markers[0].getPosition().lng());
            }

            objectMain.find('form').submit();
        })
    }
    googleBtn.click(function () {
        var $pac = $('#pac-input');

        googleMapBlock.slideToggle();
        $('#loc').css('left', $pac.position().left + $pac.outerWidth() - 8);
        $('html, body').animate({
            scrollTop: $('#googleMap').offset().top
        });
    });

    googleLocMeBtn.click(function () {
        geolocalizateMe();
    });

    form.submit(function () {
        var header = $('.appHeader.dataobject').first(),
            dataset = header.attr('data-dataset'),
            object_id = header.attr('data-object_id'),
            inputs = $(this).serializeArray();

        $.ajax({
            url: '/dane/' + dataset + '/' + object_id + '/dzialania.json',
            method: 'POST',
            data: inputs,
            success: function (res) {

                console.log(res);

            }
        });

        return false;
    });

    /*ASYNCHRONIZE ACTION FOR GOOGLE MAP*/
    window.onload = loadScript();
});