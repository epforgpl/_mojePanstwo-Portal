
function parsePolyStrings(ps){var i,j,lat,lng,tmp,tmpArr,arr=[],m=ps.match(/\([^\(\)]+\)/g);if(m!==null){for(i=0;i<m.length;i++){tmp=m[i].match(/-?\d+\.?\d*/g);if(tmp!==null){for(j=0,tmpArr=[];j<tmp.length;j+=2){lat=Number(tmp[j]);lng=Number(tmp[j+1]);tmpArr.push(new google.maps.LatLng(lng, lat))}arr.push(tmpArr)}}}return arr}

var GminyKrakowOkregi = function(id) {
    this.id = id;
    this.el = $('#' + this.id);
    this.data = [];
    this.polygons = [];
    this.map = null;
};

GminyKrakowOkregi.prototype.initialize = function() {
    var _this = this;
    this.el.html(this.getSpinner());


    _this.data =$('div[data-name="okregi"]').data('content');
    _this.groupDataByYears();
    _this.el.html(_this.getContent());
    _this.map = new google.maps.Map(
        document.getElementById(_this.id + '_map'), {
            zoom: 11,
            panControl: false,
            zoomControl: true,
            scrollwheel: true,
            draggable: true,
            mapTypeControl: false,
            scaleControl: false,
            streetViewControl: false,
            overviewMapControl: false,
            zoomControlOptions: {
                style: google.maps.ZoomControlStyle.SMALL,
                position: google.maps.ControlPosition.RIGHT_TOP
            },
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                position: google.maps.ControlPosition.LEFT_BOTTOM
            },
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            backgroundColor: '#F8F8F8',
            center: new google.maps.LatLng(
                50.0467656,
                20.0048731
            )
        }
    );

    _this.showAreasOnMapByYear('2014');

    $('#kadencjaSelect').change(function() {
        var year = $(this).val();
        $('#' + _this.id + '_areas_list').html(
            _this.getAreasListByYear(year)
        );

        _this.showAreasOnMapByYear(year);
    });

};

GminyKrakowOkregi.prototype.showAreasOnMapByYear = function(year) {
    var _this = this;

    if(this.data[year] === undefined)
        return false;

    // clear
    if(this.polygons.length) {
        for(var m = 0; m < this.polygons.length; m++)
            this.polygons[m].setMap(null);
        this.polygons = [];
    }

    for (var i = 0; i < this.data[year].length; i++) {
        if (this.data[year].hasOwnProperty(i)) {
            var p = parsePolyStrings(this.data[year][i][3]);

            for(var s = 0; s < p.length; s++) {
                var options = {
                    fillColor: '#0000aa',
                    fillOpacity: 0.05,
                    strokeWeight: 2,
                    strokeColor: '#0000aa',
                    path: p[s],
                    number: this.data[year][i][2]
                };

                var poly = new google.maps.Polygon(options);
                poly.setMap(this.map);

                google.maps.event.addListener(poly, 'click', function (event) {
                    $('#' + _this.id + '_areas_list a[data-number="' + this.number + '"]')[0].click()
                });

                google.maps.event.addListener(poly, "mouseover", function() {
                    _this.hoverIn(this.number);
                });

                google.maps.event.addListener(poly, "mouseout", function() {
                    _this.hoverOut(this.number);
                });

                this.polygons.push(poly);
            }
        }
    }

    $('#' + _this.id + '_areas_list a').mouseover(function () {
        _this.hoverIn($(this).data('number'));
    }).mouseout(function () {
        _this.hoverOut($(this).data('number'));
    });
};

GminyKrakowOkregi.prototype.getAreasListByYear = function(year) {
    var html = [];
    if(this.data[year] !== undefined) {
        for(var i = 0; i < this.data[year].length; i++) {
            html.push('<li><a href="okregi/' + this.data[year][i][0] + '" data-number="' + this.data[year][i][2] + '">' + this.data[year][i][2] + ' (Dzielnice ' + this.data[year][i][4] + ')</a></li>');
        }
    }
    return html.join('');
};

GminyKrakowOkregi.prototype.hoverIn = function(number) {
    if(this.polygons.length === 0)
        return false;

    for(var i = 0; i < this.polygons.length; i++) {
        if(number == this.polygons[i].number) {
            this.polygons[i].setOptions({
                fillColor: '#0000aa',
                fillOpacity: 0.3,
                strokeWeight: 2,
                strokeColor: '#0000aa'
            });

            $('#' + this.id + '_areas_list a[data-number="' + number + '"]').addClass('hover');
        }
    }
};

GminyKrakowOkregi.prototype.hoverOut = function(number) {
    if(this.polygons.length === 0)
        return false;

    for(var i = 0; i < this.polygons.length; i++) {
        if(number == this.polygons[i].number) {
            this.polygons[i].setOptions({
                fillColor: '#0000aa',
                fillOpacity: 0.05,
                strokeWeight: 2,
                strokeColor: '#0000aa'
            });

            $('#' + this.id + '_areas_list a[data-number="' + number + '"]').removeClass('hover');
        }
    }
};

GminyKrakowOkregi.prototype.getContent = function() {
    var html = [
        '<div class="map-panel-holder"><div class="map-panel"><div class="form-group"><label for="kadencjaSelect">Kadencja</label><select class="form-control" id="kadencjaSelect"><option value="2014" selected>2014</option><option value="2010">2010</option></select></div><div class="form-group margin-bottom-0"><label>Okręgi</label><ul id="' + this.id + '_areas_list">' + this.getAreasListByYear('2014') + '</ul></div></div></div><div class="krakow-map" id="' + this.id + '_map"></div>'
    ];

    return html.join('');
};

GminyKrakowOkregi.prototype.groupDataByYears = function() {
    var d = this.data;

    var n = {
        2014: [],
        2010: []
    };

    for(var i = 0; i < d.length; i++) {
        var y = d[i][1];
        n[y].push(d[i]);
    }

    this.data = n;
};

GminyKrakowOkregi.prototype.getSpinner = function() {
    return '<div class="spinner grey margin-top-30"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>';
};

$(document).ready(function() {

    if($('div[data-name="okregi"]').length > 0) {
        var o = new GminyKrakowOkregi('kto_tu_rzadzi');
        o.initialize();
    } else if($('div[data-name="okreg"]').length > 0) {

        var okreg = $('div[data-name="okreg"]').data('content');

        var map = new google.maps.Map(
            document.getElementById('okreg_map'), {
                zoom: 10,
                panControl: false,
                zoomControl: true,
                scrollwheel: true,
                draggable: true,
                mapTypeControl: false,
                scaleControl: false,
                streetViewControl: false,
                overviewMapControl: false,
                zoomControlOptions: {
                    style: google.maps.ZoomControlStyle.SMALL,
                    position: google.maps.ControlPosition.RIGHT_TOP
                },
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                    position: google.maps.ControlPosition.LEFT_BOTTOM
                },
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                backgroundColor: '#F8F8F8',
                center: new google.maps.LatLng(
                    50.0467656,
                    19.9548731
                )
            }
        );

        var polygons = [];
        var p = parsePolyStrings(okreg);

        for(var s = 0; s < p.length; s++) {
            var poly = new google.maps.Polygon({
                fillColor: '#0000aa',
                fillOpacity: 0.05,
                strokeWeight: 2,
                strokeColor: '#0000aa',
                path: p[s]
            });
            poly.setMap(map);
            polygons.push(poly);
        }

    }

});
