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
    }


    $('#teryt_search_input').val('');

    var autocomplete = jQuery("#teryt_search_input"),
        cache = {};

    autocomplete.autocomplete({
        minLength: 2,
        source: function (request, response) {
            var term = request.term;
            if (term in cache) {
                response(cache[term]);
                return;
            }
            $('.teryt .btn-primary').addClass('loading');
            jQuery.getJSON("/moja_gmina/search.json?q=" + request.term, function (data) {
                var results = jQuery.map(data, function (item) {
                    return {
                        name: item.nazwa,
                        label: item.nazwa + " (" + item.typ + ")",
                        value: item.id
                    }
                });
                $('.teryt .btn-primary').removeClass('loading');
                if (results.length == 0)
                    results = [
                        {label: mPHeart.translation.LC_FINANSE_SEARCH_BRAK_WYNIKOW, value: null}
                    ];
                cache[term] = results;
                response(results);
            });
        },
        focus: function (event, ui) {
            if (ui.item.value !== null)
                autocomplete.val(ui.item.name);
            return false;
        },
        select: function (event, ui) {
            if(ui.item.value === null)
                return false;

            $("#teryt_search_input").val(ui.item.name);

            $.getJSON(api_url + 'finanse/finanse/getCommuneData?id=' + ui.item.value, function(data) {

                if(!data || data.length === 0) {
                    $('#section_' + _dzial_id + '_addon').css('display', 'none');
                    return false;
                }

                for(var i = 0; i < data.length; i++) {
                    var _dzial_id = parseInt(data[i].dzial_id);
                    var _sum_wydatki = parseInt(data[i].sum_wydatki);
                    $('#section_' + _dzial_id + '_addon').css('display', 'block');
                    $('#section_' + _dzial_id + '_addon .n').html(ui.item.name);
                    $('#section_' + _dzial_id + '_addon .v').html(number_format(_sum_wydatki, 0, '.', ' '));
                    // calc left
                    var _min = parseInt($('#section_' + _dzial_id + ' ul.addons .min').data('int'));
                    var _max = parseInt($('#section_' + _dzial_id + ' ul.addons .max').data('int'));
                    var _left = parseInt((_sum_wydatki / (_max - _min)) * 100);
                    $('#section_' + _dzial_id + '_addon').css('left', _left + '%');
                }

            });

            return false;
        }
    }).autocomplete("widget").addClass("autocompleteFinanseDzialy");

    // alert close event test
    $('#gmina_alert').on('closed.bs.alert', function () {
        alert(1);
    });

});