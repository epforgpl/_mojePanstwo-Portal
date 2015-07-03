/** BDL WSKAZNIKI PAGE CODE */
jQuery(document).ready(function () {
    var main = jQuery('#bdl-wskazniki'),
        wskazniki = main.find('.wskaznik');

    wskazniki.each(function (index) {

        var el = $(this),
            data = el.data('years'),
            id = el.data('dim_id');

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

    $('.dropdown').on({
        "click": function (e) {
            if ($(e.target).hasClass('btn')) {
                this.closable = true;
            } else {
                this.closable = false;
            }
        },
        "hide.bs.dropdown": function () {
            return this.closable;
        }
    });
});