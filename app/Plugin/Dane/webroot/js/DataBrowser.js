$(document).ready(function() {

    if(_pie_chart_data !== undefined) {
        var pie_chart_data = [];
        var sum = 0;

        for(var i = 0; i < _pie_chart_data.buckets.length; i++) {
            sum += _pie_chart_data.buckets[i].typ_nazwa.buckets[0].doc_count;
        }

        for(var i = 0; i < _pie_chart_data.buckets.length; i++) {
            pie_chart_data[i] = [
                _pie_chart_data.buckets[i].typ_nazwa.buckets[0].key,
                parseFloat(
                    (_pie_chart_data.buckets[i].typ_nazwa.buckets[0].doc_count * 100) / sum
                ),
                _pie_chart_data.buckets[i].key
            ];
        }

        $('#browser_pie_chart').highcharts({
            chart: {
                backgroundColor: null,
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                events: {
                    click: function(e) {
                        console.log(e);
                    }
                }
            },
            title: {
                text: ''
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                type: 'pie',
                name: 'Udział',
                data: pie_chart_data
            }]
        });
    }

    if(_columns_vertical_data !== undefined) {
        var columns_vertical_data = [];
        var columns_vertical_categories = [];

        for(var i = 0; i < _columns_vertical_data.buckets.length; i++) {
            columns_vertical_categories[i] = _columns_vertical_data.buckets[i].typ_nazwa.buckets[0].key;
            columns_vertical_data[i] = _columns_vertical_data.buckets[i].typ_nazwa.buckets[0].doc_count;
        }

        $('#browser_columns_vertical').highcharts({
            chart: {
                type: 'column',
                backgroundColor: null
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: columns_vertical_categories,
                title: {
                    text: null
                },
                labels: {
                    rotation: -45
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: null
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' '
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Ilość',
                data: columns_vertical_data
            }]
        });
    }

    if(_columns_horizontal_data !== undefined) {
        var columns_horizontal_data = [];
        var columns_horizontal_categories = [];

        for(var i = 0; i < _columns_horizontal_data.buckets.length; i++) {
            columns_horizontal_categories[i] = _columns_horizontal_data.buckets[i].typ_nazwa.buckets[0].key;
            columns_horizontal_data[i] = _columns_horizontal_data.buckets[i].typ_nazwa.buckets[0].doc_count;
        }

        $('#browser_columns_horizontal').highcharts({
            chart: {
                type: 'bar',
                backgroundColor: null
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                categories: columns_horizontal_categories,
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: null
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' '
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Ilość',
                data: columns_horizontal_data
            }]
        });
    }

    if(_histogram_data !== undefined) {

        histogram_data = [];
        var max = 0;
        for(var i = 0; i < _histogram_data.buckets.length; i++) {
            histogram_data[i] = parseInt(_histogram_data.buckets[i].doc_count);
            if(max < histogram_data[i])
                max = histogram_data[i];
        }

        $('#browser_histogram').highcharts({
            chart: {
                zoomType: 'x',
                backgroundColor: null
            },
            title: {
                text: ''
            },
            credits: {
                enabled: false
            },
            subtitle: {
                text: ''/*document.ontouchstart === undefined ?
                    'Click and drag in the plot area to zoom in' :
                    'Pinch the chart to zoom in'*/
            },
            xAxis: {
                type: 'datetime',
                minRange: 365 * 24 * 3600000 // one year
            },
            yAxis: {
                title: {
                    text: ''
                },
                min: 0,
                max: max
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    marker: {
                        radius: 2
                    },
                    lineWidth: 1,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },

            series: [{
                type: 'area',
                name: 'Ilość',
                pointInterval: 383 * 24 * 3600000,
                pointStart: Date.UTC(1918, 0, 1),
                data: histogram_data
            }]
        });
    }

});