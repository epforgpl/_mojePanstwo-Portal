/**
 * Created by tomekdrazewski on 02/06/15.
 */
$(document).ready(function () {

    var url = window.location.href;
    url = url + '.json';


    function pageReload() {
        $.getJSON(url, function (data) {

            obj = data.analyzer.AnalyzerExecution['data'];

            obj = JSON.parse(obj);

            var nazwy = obj.nazwy;
            var wartosci = obj.wartosci;

            $.each(wartosci, function (key, value) {
                var series = [];

                $.each(value, function (k, v) {
                    if(dict.hasOwnProperty(k)) {
                        var name = dict[k];

                        if (name.indexOf('OK') != -1) {
                            series.push({
                                name: name + '(' + k + ')',
                                data: [parseInt(v)],
                                color: "#90ed7d"
                            });
                        } else if (name.indexOf('Nieprzetwarzane') != -1 || name.indexOf('Nieprzetwarzany') !== -1) {

                        }
                        else {
                            series.push({
                                name: name + '(' + k + ')',
                                data: [parseInt(v)]
                            });
                        }
                    } else alert(k);
                });

                var options = {
                    chart: {
                        type: 'bar',
                        height: 250
                    },
                    colors: ['#7cb5ec', '#434348', '#f7a35c', '#8085e9',
                        '#f15c80', '#e4d354', '#2b908f', '#f45b5b', '#91e8e1'],
                    credits: {
                        enabled: false
                    },
                    title: {},
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
                    series: series
                };
                if (key in nazwy) {
                    options.title.text = nazwy[key]['name'];
                } else {
                    options.title.text = key;
                }
                // options.series = dane.series;
                options.chart.renderTo = "" + key + "";
                var chart = new Highcharts.Chart(options);

            });
        });

    };

    pageReload();

    setInterval(function () {
            pageReload();
        }
        , 5 * 60 * 1000);


});