var highchartInit = function () {
    /*RUN HIGHCHART FUNCTION ON EACH SPECIFY ELEMENT*/
    $('.highchart').each(function () {
        var data = $(this).data('chart');
        var series_data = [];

        for (var i = 0; i < data.length; i++) {
            var d = data[i];
            series_data.push({
                name: d['label'],
                y: Number(d['count']),
                color: d['color']
            });
        }

        /*HIGHCHART - CREATE CHART*/
        $(this).highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
				height: 250,
				backgroundColor: null
            },
            title: {
                text: ''
            },
            tooltip: {
                pointFormat: '<b>{point.y}</b> <em>({point.percentage:.1f}%)</em>'
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

            series: [
                {
                    type: 'pie',
                    name: '',
                    data: series_data
                }
            ]
        });
    });
};

(function () {
    highchartInit();
})();
