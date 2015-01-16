/*global chartData*/
$(document).ready(function () {
    if (typeof chartData !== 'undefined' && chartData.length != 0) {
        $('#highchartContainer').highcharts('StockChart', {
            rangeSelector: {
                selected: 0
            },

            title: {
                text: _mPHeart.translation.LC_ZAMOWIENIA_PUBLICZNE_LICZBA_ZAMOWIEN
            },

            series: [
                {
                    name: _mPHeart.translation.LC_ZAMOWIENIA_PUBLICZNE_LICZBA_ZAMOWIEN,
                    data: chartData
                }
            ],

            yAxis: {
                min: 0
            }
        });
    }
});