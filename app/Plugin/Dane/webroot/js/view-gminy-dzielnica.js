
$(document).ready(function() {

    $('.poparcieRadnychPieChart').each(function() {
        var data = $(this).data(),
            chartData = [];

        for(var a in data['aggs']) {
            chartData.push({
                name: a,
                y: data['aggs'][a]
            });
        }

        $(this).highcharts({
            chart: {
                backgroundColor: null,
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
                margin: [-80, 0, 0, 0],
                spacingTop: 0,
                spacingBottom: 0,
                spacingLeft: 0,
                spacingRight: 0
            },
            credits: {
                enabled: false
            },
            title: null,
            subtitle: null,
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            legend: {
                align: 'left'
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
                name: 'Wartość',
                colorByPoint: true,
                data: chartData
            }]
        });

    });

});
