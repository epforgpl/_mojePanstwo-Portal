/** BDL WSKAZNIKI PAGE CODE */
jQuery(document).ready(function () {
    var $leftSideAccordion = $('#leftSideAccordion'),
        bdlWskazniki = jQuery('#bdl-wskazniki'),
        wskazniki = bdlWskazniki.find('.wskaznik');

    $leftSideAccordion.find(' > section').accordion({
        heightStyle: "fill",
        create: function () {
            $('#tree').bind("loaded.jstree", function () {
                $('.jScrollPane').jScrollPane();
            });
        }
    });

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