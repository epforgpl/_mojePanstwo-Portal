function GenerateMap() {
    this.setup = {
        mapa_div: null,
        polygon: null,
        bounds: null,
        paths: [],
        map: null,
        _init: false
    };
    this.mapOptions = {
        center: new google.maps.LatLng(51.95972581431439, 18.51660156250001),
        zoom: 6,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
}

GenerateMap.prototype = {
    construct: new GenerateMap(),

    /*CREATE GOOGLE MAP WITH DECLARATED PLACES*/
    init: function () {
        var o = this.setup;

        if (!o._init) {
            o._init = true;
            o.mapa_div = $('mapa');

            if (o.mapa_div && _SPAT) {
                o.bounds = new google.maps.LatLngBounds();
                var add_spats = _SPAT['ADD'];
                for (var s = 0; s < add_spats.length; s++) {

                    var path = google.maps.geometry.encoding.decodePath(add_spats[s]);
                    o.paths.push(path);
                    for (var i = 0; i < path.length; i++)
                        o.bounds.extend(new google.maps.LatLng(path[i].lat(), path[i].lng()));

                }

                o.map = new google.maps.Map(o.mapa_div, this.mapOptions);

                o.map.fitBounds(o.bounds);
                for (var j = 0; j < o.paths.length; j++) {

                    o.polygon = new google.maps.Polygon({
                        path: o.paths[j],
                        fillColor: "#FFFFFF",
                        fillOpacity: 0,
                        strokeOpacity: .8,
                        strokeColor: "#9E378B",
                        strokeWeight: 3
                    });

                    o.polygon.setMap(o.map);
                }

                jQuery('#_main').find('.objectsPageContent .object').css('min-height', jQuery('#mapa').outerHeight() + jQuery('.controlButtons').outerHeight());
            }
        }
    },

    /*ZOOM MAP THAT FIT TO CUSTOM SHAPE OF DECLARATED PLACE*/
    getZoomByBounds: function (map, bounds) {
        var MAX_ZOOM = map.mapTypes.get(map.getMapTypeId()).maxZoom || 21;
        var MIN_ZOOM = map.mapTypes.get(map.getMapTypeId()).minZoom || 0;

        var ne = map.getProjection().fromLatLngToPoint(bounds.getNorthEast());
        var sw = map.getProjection().fromLatLngToPoint(bounds.getSouthWest());

        var worldCoordWidth = Math.abs(ne.x - sw.x);
        var worldCoordHeight = Math.abs(ne.y - sw.y);

        //Fit padding in pixels
        var FIT_PAD = 40;

        for (var zoom = MAX_ZOOM; zoom >= MIN_ZOOM; --zoom) {
            if (worldCoordWidth * (1 << zoom) + 2 * FIT_PAD < jQuery(map.getDiv()).width() &&
                worldCoordHeight * (1 << zoom) + 2 * FIT_PAD < jQuery(map.getDiv()).height())
                return zoom;
        }
        return 0;
    },
    /*CENTER MAP AT CENTER OF DECLARATED PLACE*/
    centerMap: function () {
        var o = this.setup;

        o.map.panTo(o.bounds.getCenter());
        o.map.setZoom(this.getZoomByBounds(o.map, o.bounds));

    },
    /*OPEN GOOGLE MAP AT FULL SCREEN OF BROWSER*/
    fullScrMap: function (mode) {
        var o = this.setup,
            $buttons = jQuery('.controlButtons'),
            button = $buttons.find('.fullScrMap'),
            $mapFrame = jQuery(o.map.getDiv()),
            $mainContent = jQuery('#_main').find('.objectsPageContent .object'),
            padding = 60,
            mapTop = Math.floor(jQuery(window).scrollTop() - $mapFrame.offset().top) + padding,
            mapLeft = -Math.floor($mapFrame.offset().left),
            buttonTop = Math.floor(jQuery(window).scrollTop() - $buttons.offset().top),
            buttonRight = -Math.floor((jQuery(window).outerWidth() - $buttons.offset().left) - $buttons.outerWidth()) + (padding * 2);

        if (mode == "screen") {
            $mapFrame.css('position', 'absolute');
            $mapFrame.css({
                'top': Math.floor(jQuery(window).scrollTop() - $mapFrame.offset().top),
                'left': -Math.floor($mapFrame.offset().left),
                'z-index': 100
            }).animate({
                top: $buttons.outerHeight(),
                left: '0px',
                width: $mainContent.outerWidth(),
                height: $mapFrame.data('height')
            }, 500, function () {
                $mapFrame.css('overflow', 'hidden');
                $mapFrame.css({
                    'overflow': 'hidden',
                    'position': 'relative',
                    'width': '100%',
                    'height': $mapFrame.data('height'),
                    'z-index': 0,
                    'top': 0,
                    'left': 0
                });
                google.maps.event.trigger(o.map, 'resize');
                o.map.panTo(o.bounds.getCenter());
            });

            $buttons.css('position', 'absolute');
            $buttons.css({
                'z-index': '101',
                'top': Math.floor(jQuery(window).scrollTop() - $buttons.offset().top),
                'right': -Math.floor((jQuery(window).outerWidth() - $buttons.offset().left) - $buttons.outerWidth()) + (padding * 2)
            }).animate({
                'top': 0,
                'right': 0
            }, 500, function () {
                button.text(mPHeart.translation.LC_GMINY_MAPA_FULL_SCREEN);
                $buttons.css({
                    'position': 'relative',
                    'z-index': 0,
                    'top': 0,
                    'right': 0
                }).show();
            });
            button.data('mode', 'box');

        } else {
            $mapFrame.data('height', $mapFrame.css('height'));
            $mapFrame.css('overflow', 'visible');
            button.text(mPHeart.translation.LC_GMINY_MAPA_MINIMALIZE);
            $mapFrame.css({
                'overflow': 'visible',
                'z-index': 100,
                'margin-top': $buttons.outerHeight()
            }).animate({
                'top': mapTop,
                'left': mapLeft,
                'width': Math.floor(jQuery(window).outerWidth()) + 'px',
                'height': Math.floor(jQuery(window).outerHeight()) + 'px',
                'margin-top': 0
            }, 500, function () {
                $mapFrame.css({
                    'top': 0,
                    'left': 0,
                    'position': 'fixed'
                });
                google.maps.event.trigger(o.map, 'resize');
                o.map.panTo(o.bounds.getCenter());
            });

            $buttons.css({
                'position': 'absolute',
                'z-index': '101',
                'top': 0,
                'right': 0

            }).animate({
                'top': buttonTop,
                'right': buttonRight
            }, 500, function () {
                $buttons.css({
                    'position': 'fixed',
                    'top': 0,
                    'right': (padding * 2)
                })
            });
            button.data('mode', 'screen');
        }
    }
};

var gminaMap;
jQuery(document).ready(function () {
    gminaMap = new GenerateMap();
    gminaMap.init();

    jQuery('.controlButtons .centerMap').click(function () {
        gminaMap.centerMap()
    });
    jQuery('.controlButtons .fullScrMap').click(function () {
        gminaMap.fullScrMap(jQuery(this).data('mode'));
    });
});
