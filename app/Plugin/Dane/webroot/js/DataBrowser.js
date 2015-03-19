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
                )
            ];
        }

        $('#browser_pie_chart').highcharts({
            chart: {
                backgroundColor: null,
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false
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

});