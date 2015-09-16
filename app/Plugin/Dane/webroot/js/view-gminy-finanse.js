$(document).ready(function () {
    'use strict';

    var sections = jQuery('#sections .section');
    for (var i = 0; i < sections.length; i++) {
        var section = jQuery(sections[i]),
            histogram_div = jQuery(section.find('.histogram')),
            data = histogram_div.data('init'),
            charts_data = [],
            chart;

        for (var d = 0; d < data.length; d++)
            if (data[d])
                charts_data.push(Number(data[d]['height']));


        histogram_div.attr('id', 'h' + i);

        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'h' + i,
                type: 'column',
                height: 150,
                backgroundColor: null,
                spacingTop: 0
            },

            tooltip: {
                enabled: false
            },

            credits: {
                enabled: false
            },

            legend: {
                enabled: false
            },

            title: {
                text: ''
            },

            xAxis: {
                labels: {
                    enabled: false
                },
                gridLineWidth: 0,
                title: null
            },

            yAxis: {
                offset: 20,
                labels: {
                    enabled: false
                },
                gridLineWidth: 0,
                title: {
                    text: 'Liczba gmin',
                    style: {
                        color: '#AAA',
                        'font-family': '"Helvetica Neue",Helvetica,Arial,sans-serif',
                        'font-size': '13px',
                        'font-weight': '300'
                    }
                }
            },

            plotOptions: {
                column: {
                    groupPadding: 0,
                    pointPadding: 0,
                    borderWidth: 0
                }
            },

            series: [{
                data: charts_data
            }]

        });

        var _min = parseInt(section.find('#minmin').data('int'));
        var _sum_wydatki = parseInt(section.find('ul.addons .section_addon').data('int'));
        var _max = parseInt(section.find('ul.addons .max').data('int'));
        // var _left = parseInt((_sum_wydatki / (_max - _min)) * 100);
        if (_sum_wydatki <= _min)
            var _left = 0;
        else
            var _left = parseInt(((_sum_wydatki - _min) / (_max - _min)) * 100);

        section.find('.section_addon').css('left', _left + '%');
    }

});
