$(document).ready(function () {

    var url = window.location.href;
    url = url + '.json';

    Highcharts.setOptions({
        global: {
            useUTC: false
        }
    });

    function pageReload() {
        $.getJSON(url, function (data) {
            obj = data.analyzer.AnalyzerExecution['data'];
            obj = JSON.parse(obj);
            $.each(obj, function (key, value) {
                var series = [];
                if (value['avg1'][0]) {
                    $.each(value['avg1'], function (k, v) {
                        var date = String(value['insert_ts'][k]).replace(/-/g, "/");
                        series.push({
                            "x": new Date(date),
                            "y": parseFloat(v)
                        });
                    });
                    var options = {
                        chart: {},
                        credits: {
                            enabled: false
                        },
                        legend: {
                            enabled: false
                        },
                        title: {
                            text: 'Obciążenie serwera - ' + key + '',
                            x: -20 //center
                        },
                        xAxis: {
                            type: 'datetime'
                        },
                        yAxis: {
                            title: {
                                text: 'Obciążenie Serwera'
                            },
                            plotLines: [{
                                value: 0,
                                width: 1,
                                color: '#808080'
                            }]
                        },
                        tooltip: {},
                        series: [
                            {
                                name: "Test",
                                data: series
                            }
                        ]
                    };
                    options.chart.renderTo = "" + key + "_la";
                    var chart = new Highcharts.Chart(options);
                }

                if (value['space_free'][0]) {

                    var sf = parseFloat(value['space_free'][Object.keys(value['space_free']).length - 1]);
                    var su = parseFloat(value['space_usage'][Object.keys(value['space_usage']).length - 1]);

                    var options = {
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false
                        },
                        credits: {
                            enabled: false
                        },
                        legend: {
                            enabled: false
                        },
                        title: {
                            text: 'Wykorzystanie dysku na serwerze ' + key + ''
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true,
                                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                    style: {
                                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                    }
                                },
                                size: 250
                            }
                        },
                        series: [{
                            type: 'pie',
                            name: 'Zajetość dysku',
                            data: [
                                ['Zajęte', su],
                                {
                                    name: 'Wolne',
                                    y: sf,
                                    sliced: true,
                                    selected: true,
                                    color: "#90ed7d",
                                },
                            ]
                        }]
                    };

                    options.chart.renderTo = "" + key + "_fs";
                    var chart = new Highcharts.Chart(options);

                }
            })
        })
    }

    pageReload();

    setInterval(function () {
            pageReload();
        }
        , 60 * 1000);


})