/*global chartData*/
$(document).ready(function () {
    if (typeof chartData !== 'undefined' && chartData.length != 0) {
        $('#highchartContainer').highcharts('StockChart', {
            rangeSelector: {
                selected: 0
            },

            title: {
                text: mPHeart.translation.LC_ZAMOWIENIA_PUBLICZNE_LICZBA_ZAMOWIEN
            },

            series: [
                {
                    name: mPHeart.translation.LC_ZAMOWIENIA_PUBLICZNE_LICZBA_ZAMOWIEN,
                    data: chartData
                }
            ],

            yAxis: {
                min: 0
            }
        });
    }
});