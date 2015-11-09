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