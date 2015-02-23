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


var zakresy = [
    [0, 20000],
    [20000, 50000],
    [50000, 100000],
    [100000, 500000],
    [500000, 999999999]
];

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
                    offset: 20,
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
                        {label: _mPHeart.translation.LC_FINANSE_SEARCH_BRAK_WYNIKOW, value: null}
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
            $('#gmina_alert p').html('');
            $('#gmina_alert .close').hide();
            $('#gmina_alert p').addClass('loading');
            $('#gmina_alert').show();
            $('#sections').hide();

            $.getJSON(api_url + 'finanse/finanse/getCommuneData?id=' + ui.item.value, function(data) {
                $('#gmina_alert p').removeClass('loading');
                $('#gmina_alert .close').show();

                if(!data || data.length === 0) {
                    $('#section_' + _dzial_id + '_addon').css('display', 'none');
                    $('#gmina_alert p').html('Wystąpił błąd. Spróbuj ponownie za kilka minut.');
                    return false;
                }

                var zakres = zakresy[parseInt(data.sections[0].zakres)];
                $('#gmina_alert p').html('Zestawienie wydatków gminy ' + ui.item.name + ' z innymi gminami o liczbie mieszkańców z przedziału od ' + zakres[0] + ' do ' + zakres[1]);

                for(var i = 0; i < data.sections.length; i++) {
                    var d = data.sections[i];
                    var e = $('#dsection_' + d.id);
                    e.find('p.dsum').html(pl_currency_format(d.sum_wydatki));
                    e.find('ul.addons li.min .n').html(d.min_nazwa);
                    e.find('ul.addons li.min .v').html(pl_currency_format(d.min));
                    e.find('ul.addons li.max .n').html(d.max_nazwa);
                    e.find('ul.addons li.max .v').html(pl_currency_format(d.max));
                    e.find('ul.addons li.section_addon .n').html(ui.item.name);
                    e.find('ul.addons li.section_addon .v').html(pl_currency_format(d.commune));

                    var _min = parseInt(d.min);
                    var _sum_wydatki = parseInt(d.commune);
                    var _max =  parseInt(d.max);
                    if(_sum_wydatki <= _min)
                        var _left = 0;
                    else
                        var _left = parseInt(((_sum_wydatki - _min) / (_max - _min)) * 100);

                    e.find('ul.addons li.section_addon').css('left', _left + '%');

                    var charts_data = [];
                    for(var s = 0; s < d.buckets.length; s++) {
                        charts_data.push(Number(d.buckets[s].height));
                    }

                    chart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'dhistogram_' + d.id,
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
                                    'font-weight': '300',
                                    'margin-left': '-50px'
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

                $('#dsections').show();
            });

            return false;
        }
    }).autocomplete("widget").addClass("autocompleteFinanseDzialy");

    // alert close event test
    $('#gmina_alert .close').on('click', function () {
        $("#teryt_search_input").val('');
        $('#dsections').hide();
        $('#sections').show();
        $('#gmina_alert').hide();
        return false;
    });

});