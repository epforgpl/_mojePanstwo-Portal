function number_format(number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + (Math.round(n * k) / k)
                .toFixed(prec);
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
        .split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '')
            .length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1)
            .join('0');
    }
    return s.join(dec);
}

function pl_currency_format(n) {
    var str = '';
    var mld = 0;
    var mln = 0;
    var tys = 0;

    if(n > 1000000000) {
        mld = Math.round(n / 1000000000, 2);
        n -= mld * 1000000000;
        return mld + ' Mld';
    }

    if(n > 1000000) {
        mln = Math.round(n / 1000000, 2);
        n -= mln * 1000000;
        return mln + ' M';
    }

    if(n > 1000) {
        tys = Math.round(n / 1000, 2);
        n -= tys * 1000;
        return tys + ' k';
    }

    if(mld > 0)
        str += mld + ' Mld ';
    if(mln  > 0)
        str += mln + ' M ';
    if(tys > 0 && mld === 0)
        str += tys + ' k';

    if(mld === 0 && mln === 0 && tys === 0)
        str += number_format(n);

    return str.trim();
};
$(document).ready(function() {
    'use strict';

    var api_url = 'http://mojepanstwo.pl:4444/';

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
        var _max =  parseInt(section.find('ul.addons .max').data('int'));
        // var _left = parseInt((_sum_wydatki / (_max - _min)) * 100);
        if(_sum_wydatki <= _min)
            var _left = 0;
        else
            var _left = parseInt(((_sum_wydatki - _min) / (_max - _min)) * 100);

        section.find('.section_addon').css('left', _left + '%');
    }

});