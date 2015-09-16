var mapWidthInterval = null;

var googleMapKodyPocztowe = {
    googleMap: $('mapa'),
    map: null,
    geocoder: null,
    marker: null,

    /*CREATE GOOGLE MAP*/
    init: function () {
        var that = this;

        if (that.googleMap) {
            var mapOptions = {
                center: new google.maps.LatLng(51.95972581431439, 18.51660156250001),
                zoom: 6,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            that.map = new google.maps.Map(that.googleMap, mapOptions);
            that.geocoder = new google.maps.Geocoder();

            //Google map center on first "gmina" from list - in most case there will be only one "gmina"
            this.geocoder.geocode({'address': 'Poland, ' + $$('.gminy')[0].readAttribute('_gs')}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    that.map.setCenter(results[0].geometry.location);
                    that.map.setZoom(10);
                }
            });

            this.listConnection();

			$('#map_cont').sticky();

            var mapWidthInterval = setInterval(function () {
                var mapWidth = jQuery('#mapa').css('width');
                jQuery('#map_cont').css('width', mapWidth);

                /*SECURE FOR GOOGLE MAP LOADING SYSTEM - IF MAP IS NOT LOADED YET AND GOT 0px WE RUN CHECK WIDTH AGAIN AFTER SOME SHORT PERIOD OF TIME*/
                if (mapWidth != '0px' && mapWidth != '0')
                    clearInterval(mapWidthInterval);
            }, 500);
        }
    },
    /*RESULT LIST CONNECTED TO MARKER AT GOOGLE MAP*/
    listConnection: function () {
        var that = this;

        $$('#obszary .pnaLi').each(function (li) {
            var a = new Element('a', {href: '#'}).update(li.innerHTML);

            a.observe('click', function (event) {
                var node = event.findElement('a');

                if (node.hasClassName('s')) {
                    $$('#obszary .pnaLi a.s').invoke('removeClassName', 's');
                    if (that.marker)
                        that.marker.setMap(null);
                } else {
                    var gminy = node.up('.gminy');
                    var q = 'Poland, ' + gminy.readAttribute('_gs') + ', ' + node.innerHTML;

                    that.geocoder.geocode({'address': q}, function (results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            $$('#obszary .pnaLi a.s').invoke('removeClassName', 's');
                            this.addClassName('s');

                            that.map.setCenter(results[0].geometry.location);
                            that.map.setZoom(16);

                            if (that.marker)
                                that.marker.setMap(null);

                            that.marker = new google.maps.Marker({
                                map: that.map,
                                position: results[0].geometry.location
                            });
                        } else {
                            var q = 'Poland, ' + gminy.readAttribute('_gs');

                            that.geocoder.geocode({'address': q}, function (results, status) {
                                if (status == google.maps.GeocoderStatus.OK) {

                                    $$('#obszary .pnaLi a.s').invoke('removeClassName', 's');
                                    this.addClassName('s');

                                    that.map.setCenter(results[0].geometry.location);
                                    that.map.setZoom(16);

                                    if (that.marker)
                                        that.marker.setMap(null);

                                    that.marker = new google.maps.Marker({
                                        map: that.map,
                                        position: results[0].geometry.location
                                    });
                                } else {
                                    that.geocoder.geocode({'address': q}, function (results) {
                                        that.map.setCenter(results[0].geometry.location);
                                        that.map.setZoom(16);
                                    });
                                }
                            });
                        }
                    }.bind(a));

                }

                event.stop();
            });
            li.update(a);
        });
    }
};

jQuery(document).ready(function () {
    googleMapKodyPocztowe.init();
});
