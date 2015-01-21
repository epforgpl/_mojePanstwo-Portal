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
                $('#topImportList').append('<li class="list-group-item"><span class="badge">' + val.wartosc_pln + ' zł</span>' + val.nazwa + '</li>');
            });
        });

        $.getJSON(apiHost + 'handel_zagraniczny/stats/panstwa.json?symbol_id=' + _objectData.id + '&rocznik=' + year + '&order=eksport', function( data ) {
            $('#topExportList').html('');
            $.each(data, function(key, val) {
                $('#topExportList').append('<li class="list-group-item"><span class="badge">' + val.wartosc_pln + ' zł</span>' + val.nazwa + '</li>');
            });
        });
    };

    $('#selectYear').change(function() {
        var year = $(this).find("option:selected").text();
        loadTopData(year);
    });

    $('#selectYear').val('2014');
    loadTopData(2005); // default

});
