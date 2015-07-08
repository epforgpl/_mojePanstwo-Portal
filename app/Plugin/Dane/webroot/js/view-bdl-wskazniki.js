/** BDL WSKAZNIKI PAGE CODE */
jQuery(document).ready(function () {
    var bdlWskazniki = jQuery('#bdl-wskazniki'),
        wskazniki = bdlWskazniki.find('.wskaznik');

    wskazniki.each(function () {
        var el = $(this),
            data = el.data('years');

        if (data) {
            var chart_div = el.find('.chart'),
                label = [],
                value = [];

            jQuery.each(data, function () {
                label.push(this[0]);
                value.push(Number(this[1]));
            });

            chart_div.highcharts({
                title: {
                    text: ''
                },
                chart: {
                    backgroundColor: null
                },
                credits: {
                    enabled: false
                },
                xAxis: {
                    categories: label
                },
                yAxis: {
                    title: ''
                },
                tooltip: {
                    valueSuffix: ''
                },
                legend: {
                    enabled: false,
                    align: 'left'
                },
                series: [
                    {
                        name: "Wartość",
                        data: value
                    }
                ]
            });
        }
    });
});