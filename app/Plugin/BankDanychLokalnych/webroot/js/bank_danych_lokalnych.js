$(function () {
    $.getJSON('http://mojepanstwo.pl:4444/geo/geojson/pl', function (geojson) {

        // Prepare the geojson
        var states = Highcharts.geojson(geojson, 'map'),
            rivers = Highcharts.geojson(geojson, 'mapline'),
            cities = Highcharts.geojson(geojson, 'mappoint');

        // Initiate the chart
        $('#mapa').highcharts('Map', {
            title: {
                text: ' '
            },

            chart: {
                backgroundColor: '#000000'
            },

            mapNavigation: {
                enabled: true,
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

            series: [{
                data: states,

                dataLabels: {
                    enabled: true,
                    format: '{point.name}',
                    style: {
                        width: '80px' // force line-wrap
                    }
                },
                tooltip: {
                    pointFormat: '{point.name}'
                }
            }, {
                name: 'Rivers',
                type: 'mapline',
                data: rivers,
                color: Highcharts.getOptions().colors[0],
                tooltip: {
                    pointFormat: '{point.properties.NAME}'
                }
            }, {
                name: 'Cities',
                type: 'mappoint',
                data: cities,
                color: 'black',
                marker: {
                    radius: 2
                },
                dataLabels: {
                    align: 'left',
                    verticalAlign: 'middle'
                },
                animation: false,
                tooltip: {
                    pointFormat: '{point.name}'
                }
            }]
        });
    });
});