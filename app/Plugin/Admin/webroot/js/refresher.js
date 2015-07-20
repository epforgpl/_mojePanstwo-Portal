$(document).ready(function () {

    var url = window.location.href;
    url=url.split('?')[0];
    url = url + '.json';


    function pageReload() {
        $.getJSON(url, function (data) {
            obj = data.analyzer.AnalyzerExecution['data'];

            obj = JSON.parse(obj);

            $.each(obj, function (key, value) {

                if (key.indexOf('err') != -1) {
                    if (value[0] !== undefined) {
                        var html = value[0][Object.keys(value[0])[0]];
                        $("#" + key + "").html(dict[key][value[0][Object.keys(value[0])][Object.keys(html)[0]]] + ": " + $.timeago(value[0][Object.keys(value[0])][Object.keys(html)[1]]));
                    } else {
                        $("#" + key + "").removeClass('label-danger');
                    }
                } else if (key.indexOf('corr') != -1) {

                    if (value[0] !== undefined) {
                        var html = value[0][Object.keys(value[0])[0]];
                        $("#" + key + "").html(dict[key][value[0][Object.keys(value[0])][Object.keys(html)[0]]] + ": " + $.timeago(value[0][Object.keys(value[0])][Object.keys(html)[1]]));
                    } else {
                        $("#" + key + "").removeClass('label-success');
                    }

                } else if (key.indexOf('wydania') != -1) {

                    var html = value[0][Object.keys(value[0])[0]];
                    $("#" + key + "").html("Najnowsze pobrane: " + $.timeago(value[0][Object.keys(value[0])][Object.keys(html)[0]]));

                } else if (key.indexOf('downloads') != -1) {
                    $('#krs_downloads_day').html('');

                    $('#krs_downloads_day').highcharts({


                        chart: {
                            type: 'gauge',
                            plotBackgroundColor: null,
                            plotBackgroundImage: null,
                            plotBorderWidth: 0,
                            plotShadow: false
                        },

                        credits: {
                            enabled: false
                        },

                        title: {
                            text: 'KRS Pobrania Dzień'
                        },

                        pane: {
                            startAngle: -150,
                            endAngle: 150,
                            background: [{
                                backgroundColor: {
                                    linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
                                    stops: [
                                        [0, '#FFF'],
                                        [1, '#333']
                                    ]
                                },
                                borderWidth: 0,
                                outerRadius: '109%'
                            }, {
                                backgroundColor: {
                                    linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
                                    stops: [
                                        [0, '#333'],
                                        [1, '#FFF']
                                    ]
                                },
                                borderWidth: 1,
                                outerRadius: '107%'
                            }, {
                                // default background
                            }, {
                                backgroundColor: '#DDD',
                                borderWidth: 0,
                                outerRadius: '105%',
                                innerRadius: '103%'
                            }]
                        },

                        // the value axis
                        yAxis: {
                            min: 0,
                            max: 10000,

                            minorTickInterval: 'auto',
                            minorTickWidth: 1,
                            minorTickLength: 10,
                            minorTickPosition: 'inside',
                            minorTickColor: '#666',

                            tickPixelInterval: 30,
                            tickWidth: 2,
                            tickPosition: 'inside',
                            tickLength: 10,
                            tickColor: '#666',
                            labels: {
                                step: 2,
                                rotation: 'auto'
                            },
                            title: {
                                text: 'pobrań/dzień'
                            },
                            plotBands: [{
                                from: 0,
                                to: 5000,
                                color: '#55BF3B' // green
                            }, {
                                from: 5000,
                                to: 8000,
                                color: '#DDDF0D' // yellow
                            }, {
                                from: 8000,
                                to: 10000,
                                color: '#DF5353' // red
                            }]
                        },

                        series: [{
                            name: 'Dzień',
                            data: [parseInt(value["downloadD"])],
                            tooltip: {
                                valueSuffix: ' pobrań'
                            }
                        }]
                    });
                    $('#krs_downloads_hour').highcharts({

                        chart: {
                            type: 'gauge',
                            plotBackgroundColor: null,
                            plotBackgroundImage: null,
                            plotBorderWidth: 0,
                            plotShadow: false
                        },

                        credits: {
                            enabled: false
                        },

                        title: {
                            text: 'KRS Pobrania Godzina'
                        },

                        pane: {
                            startAngle: -150,
                            endAngle: 150,
                            background: [{
                                backgroundColor: {
                                    linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
                                    stops: [
                                        [0, '#FFF'],
                                        [1, '#333']
                                    ]
                                },
                                borderWidth: 0,
                                outerRadius: '109%'
                            }, {
                                backgroundColor: {
                                    linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
                                    stops: [
                                        [0, '#333'],
                                        [1, '#FFF']
                                    ]
                                },
                                borderWidth: 1,
                                outerRadius: '107%'
                            }, {
                                // default background
                            }, {
                                backgroundColor: '#DDD',
                                borderWidth: 0,
                                outerRadius: '105%',
                                innerRadius: '103%'
                            }]
                        },

                        // the value axis
                        yAxis: {
                            min: 0,
                            max: 400,

                            minorTickInterval: 'auto',
                            minorTickWidth: 1,
                            minorTickLength: 10,
                            minorTickPosition: 'inside',
                            minorTickColor: '#666',

                            tickPixelInterval: 30,
                            tickWidth: 2,
                            tickPosition: 'inside',
                            tickLength: 10,
                            tickColor: '#666',
                            labels: {
                                step: 2,
                                rotation: 'auto'
                            },
                            title: {
                                text: 'pobrań/godzinę'
                            },
                            plotBands: [{
                                from: 0,
                                to: 200,
                                color: '#55BF3B' // green
                            }, {
                                from: 200,
                                to: 320,
                                color: '#DDDF0D' // yellow
                            }, {
                                from: 320,
                                to: 400,
                                color: '#DF5353' // red
                            }]
                        },

                        series: [{
                            name: 'Godzina',
                            data: [parseInt(value['downloadH'])],
                            tooltip: {
                                valueSuffix: ' pobrań'
                            }
                        }]


                    });
                    $('#krs_downloads_minute').highcharts({

                        chart: {
                            type: 'gauge',
                            plotBackgroundColor: null,
                            plotBackgroundImage: null,
                            plotBorderWidth: 0,
                            plotShadow: false
                        },

                        credits: {
                            enabled: false,
                        },

                        title: {
                            text: 'KRS Pobrania Minuta'
                        },

                        pane: {
                            startAngle: -150,
                            endAngle: 150,
                            background: [{
                                backgroundColor: {
                                    linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
                                    stops: [
                                        [0, '#FFF'],
                                        [1, '#333']
                                    ]
                                },
                                borderWidth: 0,
                                outerRadius: '109%'
                            }, {
                                backgroundColor: {
                                    linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
                                    stops: [
                                        [0, '#333'],
                                        [1, '#FFF']
                                    ]
                                },
                                borderWidth: 1,
                                outerRadius: '107%'
                            }, {
                                // default background
                            }, {
                                backgroundColor: '#DDD',
                                borderWidth: 0,
                                outerRadius: '105%',
                                innerRadius: '103%'
                            }]
                        },

                        // the value axis
                        yAxis: {
                            min: 0,
                            max: 15,

                            minorTickInterval: 'auto',
                            minorTickWidth: 1,
                            minorTickLength: 10,
                            minorTickPosition: 'inside',
                            minorTickColor: '#666',

                            tickPixelInterval: 30,
                            tickWidth: 2,
                            tickPosition: 'inside',
                            tickLength: 10,
                            tickColor: '#666',
                            labels: {
                                step: 2,
                                rotation: 'auto'
                            },
                            title: {
                                text: 'pobrań/minutę'
                            },
                            plotBands: [{
                                from: 0,
                                to: 7.5,
                                color: '#55BF3B' // green
                            }, {
                                from: 7.5,
                                to: 12,
                                color: '#DDDF0D' // yellow
                            }, {
                                from: 12,
                                to: 15,
                                color: '#DF5353' // red
                            }]
                        },

                        series: [{
                            name: 'Minuta',
                            data: [parseInt(value['downloadM'])],
                            tooltip: {
                                valueSuffix: ' pobrań'
                            }
                        }]

                    });
                } else {


                    var serie = '{"series":[';

                    $.each(value, function (key1, val1) {
                        $.each(val1, function (key2, val2) {
                            if ('count' in val2) {
                                count = val2['count'];
                            } else {
                                status = val2['status'];
                                if (status in dict[key]) {
                                    name = dict[key][status];
                                } else {
                                    name = 'Nieznany Błąd';
                                }
                            }
                        });
                        name += " (" + status + ")";
                        if (name.indexOf('OK') != -1) {
                            serie += '{ "name" : "' + name + '", "data" : [' + parseInt(count) + '], "color" : "#90ed7d" },';

                        } else if (name.indexOf('Nieprzetwarzane') != -1 || name.indexOf('Nieprzetwarzany') !== -1) {
                            serie += '';
                        }
                        else {
                            serie += '{ "name" : "' + name + '", "data" : [' + parseInt(count) + ']},';
                        }


                    });
                    serie = serie.substring(0, serie.length - 1);
                    serie += ']}';
                    var dane = JSON.parse(serie);

                    var options = {
                        chart: {
                            type: 'bar',
                            height: 250,
                        },
                        colors: ['#7cb5ec', '#434348', '#f7a35c', '#8085e9',
                            '#f15c80', '#e4d354', '#2b908f', '#f45b5b', '#91e8e1'],
                        credits: {
                            enabled: false
                        },
                        title: {
                            text: dict[key]['title']
                        },
                        xAxis: {
                            categories: [' ']

                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'Liczba rejestrów'
                            }
                        },
                        legend: {
                            reversed: true
                        },
                        plotOptions: {
                            series: {
                                stacking: 'normal'
                            }
                        },
                        tooltip: {
                            headerFormat: '',
                            pointFormat: '{series.name}: {point.y}'
                        },
                        series: [{}]
                    };
                    options.series = dane.series;
                    options.chart.renderTo = "" + key + "";
                    var chart = new Highcharts.Chart(options);
                }
            });
        });
    }

    pageReload();
    setInterval(function () {
            pageReload();
        }
        , 5 * 60 * 1000);
});