$(document).ready(function() {

    var data = _chartImpEksData;
    var categories = [];
    var series;
    var seriesImportData = [];
    var seriesExportData = [];
    var apiHost = 'http://mojepanstwo.pl:4444/';

    for(var i = 0; i < data.length; i++) {
        $('#selectYear').append('<option value="' + data[i].rocznik + '">' + data[i].rocznik + '</option>');
        categories.push(parseInt(data[i].rocznik));
        seriesImportData.push(parseInt(data[i].import_pln));
        seriesExportData.push(parseInt(data[i].eksport_pln));
    }

    series = [
        {
            name: 'Import',
            data: seriesImportData
        },
        {
            name: 'Eksport',
            data: seriesExportData
        }
    ];

    $('#highchartImportExport').highcharts({
        title: {
            text: 'Import i Eksport'
        },
        xAxis: {
            categories: categories
        },
        yAxis: {
            title: {
                text: 'Wartość (zł)'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        credits: {
            enabled: false
        },
        tooltip: {
            valueSuffix: ' zł'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: series
    });

    var loadTopData = function(year) {
        $.getJSON(apiHost + 'handel_zagraniczny/stats/panstwa.json?symbol_id=' + _objectData.id + '&rocznik=' + year + '&order=import', function( data ) {
            $('#topImportList').html('');
            $.each(data, function(key, val) {
                $('#topImportList').append('<li class="list-group-item"><span class="badge">' + pl_currency_format(val.wartosc_pln) + ' zł</span>' + val.nazwa + '</li>');
            });
        });

        $.getJSON(apiHost + 'handel_zagraniczny/stats/panstwa.json?symbol_id=' + _objectData.id + '&rocznik=' + year + '&order=eksport', function( data ) {
            $('#topExportList').html('');
            $.each(data, function(key, val) {
                $('#topExportList').append('<li class="list-group-item"><span class="badge">' + pl_currency_format(val.wartosc_pln) + ' zł</span>' + val.nazwa + '</li>');
            });
        });
    };

    $('#selectYear').change(function() {
        var year = $(this).find("option:selected").text();
        loadTopData(year);
    });

    $('#selectYear').val(_year);
    loadTopData(parseInt(_year)); // default


    function pl_currency_format(n) {
        var str = '';
        var mld = 0;
        var mln = 0;
        var tys = 0;

        if(n > 1000000000) {
            mld = Math.floor(n / 1000000000);
            n -= mld * 1000000000;
        }

        if(n > 1000000) {
            mln = Math.floor(n / 1000000);
            n -= mln * 1000000;
        }

        if(n > 1000) {
            tys = Math.floor(n / 1000);
            n -= tys * 1000;
        }

        if(mld > 0)
            str += mld + ' mld ';
        if(mln  > 0)
            str += mln + ' mln ';
        if(tys > 0 && mld === 0)
            str += tys + ' tys';

        if(mld === 0 && mln === 0 && tys === 0)
            str += number_format(n);

        return str.trim();
    };

    function number_format(number, decimals, dec_point, thousands_sep) {
        number = (number + '')
            .replace(/[^0-9+\-Ee.]/g, '');
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

});
