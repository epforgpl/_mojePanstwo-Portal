$(document).ready(function() {

    if(local_data == undefined || local_data.length == 0)
        return false;

    var geoType =
        local_data.length > 0 ?
            local_data.length > 16 ?
                local_data.length > 380 ?
                    'gminy'
                :
                    'powiaty'
            :
                'wojewodztwa'
        :
            false;

    if(!geoType)
        return false;

    $.getJSON('http://mojepanstwo.pl:4444/geo/geojson/get?quality=4&types=' + geoType, function(data) {
        var geo = Highcharts.geojson(data, 'map');
        var max = 0, min = 9999999999;
        for(var i = 0; i < geo.length; i++) {
            var found = false;
            for(var k = 0; k < local_data.length; k++) {
                if(geo[i].properties.id == local_data[k].local_id) {
                    geo[i].value = parseFloat(local_data[k].lv);
                    geo[i].id = 'o' + geo[i].properties.id;
                    found = true;
                    break;
                }
            }
            if(!found)
                geo[i].value = 0;

            if(geo[i].value > max)
                max = geo[i].value;

            if(geo[i].value < min)
                min = geo[i].value;
        }

        var type = 'linear';
        if(min == 0 && max == 0)
            max = 1;

        var highmap = $('#highmap');

        highmap.highcharts('Map', {
            title: {
                text: ' '
            },
            chart: {
                backgroundColor: '#e9eaed'
            },
            mapNavigation: {
                enabled: true,
                enableMouseWheelZoom: false,
                buttonOptions: {
                    verticalAlign: 'bottom'
                }
            },
            credits: {
                enabled: false
            },
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: '{point.name}: {point.value} ' + (this.unit !== undefined ? this.unit : unitStr),
                headerFormat: ''
            },
            colorAxis: {
                minColor: '#ffffff',
                maxColor: '#006df0',
                min: min,
                max: max,
                type: type
            },
            plotOptions: {
                series: {
                    //allowPointSelect: true,
                    point: {
                        events: {
                            mouseOver: function() {
                                this.graphic.toFront();
                            },
                            mouseOut: function() {

                            },
                            select: function() {
                                this.graphic.toFront();
                            },
                            click: function() {
                                var index = this.index + 1;
                                $('tr.wskaznikStatic').each(function() {
                                    var _this = $(this);
                                    var _index = $(this).attr('data-local_id');
                                    if(_index == index) {
                                        $('html, body').animate({
                                            scrollTop: _this.offset().top
                                        }, 1000);
                                        if(!_this.hasClass('clicked'))
                                            _this.click();
                                        return true;
                                    }

                                    _this
                                        .removeClass('clicked')
                                        .find('.wskaznikChart')
                                        .hide();
                                });
                            }
                        }
                    },
                    states: {
                        select: {
                            borderColor: '#014068',
                            borderWidth: 1
                        },
                        hover: {
                            borderColor: '#014068',
                            borderWidth: 1,
                            brightness: false,
                            color: false
                        }
                    }
                }
            },
            series: [{
                data: geo,
                nullColor: '#ffffff',
                borderWidth: 1
            }]
        });

        // sticky map
        if($(window).width() > 1000) {

            var mapOffset = highmap.offset();
            var t = mapOffset.top;
            var f = false;

            $(window).scroll(function() {

                var top = $(window).scrollTop();

                if(!f && top > t) {
                    highmap.css('top', '50px');
                    highmap.css('position', 'fixed');
                    f = true;
                }

                if(f && top <= t) {
                    highmap.css('position', 'relative');
                    f = false;
                }

            });

        }

        $('tr.wskaznikStatic')
            .on("mouseenter", function() {
                var id = parseInt($(this).attr('data-local_id'));
                highmap
                    .highcharts()
                    .get('o' + id)
                    .select();
            })
            .on( "mouseleave", function() {
                var id = parseInt($(this).attr('data-local_id'));
                highmap
                    .highcharts()
                    .get('o' + id)
                    .select(false);
            });

    });
});