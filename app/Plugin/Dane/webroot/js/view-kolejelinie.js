var googleMapKolejeLinie = {
    googleMap: $('mapa'),
    map: null,
    geocoder: null,

    /*CREATE GOOGLE MAP*/
    init: function () {
        var that = this;

        if (this.googleMap) {
            var mapOptions = {
                center: new google.maps.LatLng(51.95972581431439, 18.51660156250001),
                zoom: 6,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            that.map = new google.maps.Map(that.googleMap, mapOptions);
            that.geocoder = new google.maps.Geocoder();

            that.stationLine();
        }
    },
    /*ADD STATION WITH CUSTOM INFOVIEW*/
    stationLine: function () {
        var stationData = jQuery.parseJSON(stationLineData),
            that = this,
            stationPos,
            stationBounds = new google.maps.LatLngBounds(),
            infowindow;

        for (var i = 0; i < stationData.length; i++) {
            stationPos = new google.maps.LatLng(stationData[i].b.loc_lat, stationData[i].b.loc_lng);
            if (Number(stationData[i].b.loc_lat !== 0 && Number(stationData[i].b.loc_lng) !== 0))
                stationBounds.extend(stationPos);
            var stationName = stationData[i].a.stacja;

            var stationContent = '<div class="infoWindowBox"><strong>' + stationName + '</strong>';
            if (stationData[i].a.przyjazd_str != '')
                stationContent += ('<span>' + mPHeart.translation.LC_KOLEJLINIE_PRZYJAZD + ': ' + stationData[i].a.przyjazd_str + '</span>');
            if (stationData[i].a.odjazd_str != '')
                stationContent += ('<span>' + mPHeart.translation.LC_KOLEJLINIE_ODJAZD + ': ' + stationData[i].a.odjazd_str + '</span>');
            stationContent += '</div>';

            infowindow = new google.maps.InfoWindow({content: "<div><strong>' + stationName + '</strong><span>" + mPHeart.translation.LC_KOLEJELINIE_PRZYJAZD + ": --:--</span><span>" + mPHeart.translation.LC_KOLEJELINIE_ODJAZD + ": --:--</span></div>"});

            marker = new google.maps.Marker({
                map: that.map,
                position: stationPos,
                content: stationContent,
                title: stationName
            });

            google.maps.event.addListener(marker, 'click', function () {
                infowindow.setContent(this.content);
                infowindow.open(that.map, this);
            });
            that.map.fitBounds(stationBounds);
        }
    }
};

jQuery(document).ready(function () {
    googleMapKolejeLinie.init();
});