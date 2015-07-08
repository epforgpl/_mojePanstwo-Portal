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


    $("#new_temp_item").click(function () {
        $('#temp_item_opis_modal').modal('show');
    });

    $('#temp_item_opis_modal #editor').wysihtml5({
        toolbar: {
            "font-styles": true, //Font styling, e.g. h1, h2, etc.
            "emphasis": true, //Italics, bold, etc.
            "lists": false, //(Un)ordered lists, e.g. Bullets, Numbers.
            "html": false, //Button which allows you to edit the generated HTML.
            "link": true, //Button to insert a link.
            "image": false, //Button to insert an image.
            "color": false, //Button to change color of font
            "blockquote": false
        },
        'locale': 'pl-NEW',
        parser: function (html) {
            return html;
        }
    });

    $(".lista_wskz li")
        .bind('mouseenter', function () {
            $(this).find(".remove_btn").removeClass('hidden');
        })
        .bind('mouseleave', function () {
            $(this).find(".remove_btn").addClass('hidden');
        });

    $("#temp_item_savebtn").click(function () {
        $('#temp_item_opis_modal').modal('hide');
    });
});