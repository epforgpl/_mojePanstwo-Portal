/*global jQuery, History*/

String.prototype.capitalizeFirstLetter = function () {
    "use strict";
    return this.charAt(0).toUpperCase() + this.slice(1);
};

(function ($) {
    "use strict";
    var tree = $('#tree'),
        json = tree.data('structure'),
        rootData = [];

    /** @namespace json.kategorie */
    $.each(json.kategorie, function (itemKey, itemData) {
        /** @namespace itemData.dane */
        var item = {
            'data ': {id: itemKey},
            'text': itemData.dane.tytul.toLowerCase().capitalizeFirstLetter(),
            'id': 'kategoria_id=' + itemKey,
            'a_attr': {'href': '#kategoria_id=' + itemKey},
            'children': true
        }, itemChildren = [];

        /** @namespace itemData.grupy */
        $.each(itemData.grupy, function (grupyKey, grupyData) {
            var grupy = {
                'data': {'id': grupyKey},
                'text': grupyData.dane.tytul.toLowerCase().capitalizeFirstLetter(),
                'id': 'grupa_id=' + grupyKey,
                'a_attr': {'href': '#kategoria_id=' + itemKey + '&grupa_id=' + grupyKey},
                'children': true
            }, grupyChildren = [];

            /** @namespace grupyData.podgrupy */
            $.each(grupyData.podgrupy, function (podgrupyKey, podgrupyData) {
                var podgrupy;
                podgrupy = {
                    data: {'id': podgrupyKey},
                    'text': podgrupyData.dane.tytul.toLowerCase().capitalizeFirstLetter(),
                    'a_attr': {'href': '/dane/bdl_wskazniki/' + podgrupyKey, 'target': '_self'}
                };
                grupyChildren.push(podgrupy);
            });

            grupy.children = grupyChildren;
            itemChildren.push(grupy);
        });

        item.children = itemChildren;
        rootData.push(item);
    });

    tree.jstree({
        'core': {
            'data': rootData
        },
        "json_data": {
            "progressive_render": true
        },
        "plugins": ["themes", "json_data", "ui"]
    }).bind("select_node.jstree", function (e, data) {
        if (data.node.a_attr.href.charAt(0) === '#') {
            e.preventDefault();
            if (History.pushState !== undefined) {
                var obj = {Page: data.node.text, Url: data.node.a_attr.href};
                History.pushState(obj, obj.Page, obj.Url);
            }
            tree.jstree("open_node", data.node.id);
        } else {
            document.location.href = data.node.a_attr.href;
        }
    }).bind("loaded.jstree", function () {
        if (window.location.href.indexOf('#') > 0) {
            var link = window.location.href.slice(window.location.href.indexOf('#') + 1);

            if (link.slice(link.indexOf('&') + 1)) {
                link = link.split('&');
            }

            $.each(link, function () {
                tree.jstree("open_node", this);
            });

            $("html, body").animate({
                scrollTop: $('[id="' + link[link.length - 1] + '_anchor"]').offset().top
            }, 1000);
        }
    });
}(jQuery));

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