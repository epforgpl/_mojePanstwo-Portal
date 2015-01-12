var $SG;

var _SG = Class.extend({
    init: function () {

        this.update();

    },
    update: function () {

        var elements = $('.sejm_glosowanie-voting.sgvq');
        for (var i = 0; i < elements.length; i++)
            this.process(elements[i]);

    },
    process: function (el) {

        el = $(el);

        el.find('.highchart').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                spacing: [0, 0, 0, 0]
            },
            title: {
                text: ''
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: false
                }
            },
            series: [{
                type: 'pie',
                name: 'Liczba głosów',
                data: el.data('stats')
            }],
            credits: {
                enabled: false,
            },
            colors: ['#109618', '#DC3912', '#3366CC', '#DDDDDD']
        });

        console.log('process', el);

        el.removeClass('sgvq');

    }
});

$(document).ready(function () {
    $SG = new _SG();
});