String.prototype.capitalizeFirstLetter = function () {
    return this.charAt(0).toUpperCase() + this.slice(1);
};

(function ($) {
    var tree = $('#tree'),
        json = tree.data('structure'),
        rootData = [];

    $.each(json, function (key, data) {
        $.each(data, function (itemKey, itemData) {
            var item = {
                'data ': {
                    id: itemKey
                },
                'text': itemData['dane']['tytul'].toLowerCase().capitalizeFirstLetter(),
                'id': 'kategoria_id=' + itemKey,
                'a_attr': {
                    'href': '#kategoria_id=' + itemKey
                },
                'children': true
            }, itemChildren = [];

            $.each(itemData['grupy'], function (grupyKey, grupyData) {
                var grupy = {
                    'data': {
                        'id': grupyKey
                    },
                    'text': grupyData['dane']['tytul'].toLowerCase().capitalizeFirstLetter(),
                    'id': 'grupa_id=' + grupyKey,
                    'a_attr': {
                        'href': '#grupa_id=' + grupyKey
                    },
                    'children': true
                }, grupyChildren = [];

                $.each(grupyData['podgrupy'], function (podgrupyKey, podgrupyData) {
                    var podgrupy = {
                        data: {
                            'id': podgrupyKey
                        },
                        'text': podgrupyData['dane']['tytul'].toLowerCase().capitalizeFirstLetter(),
                        'a_attr': {
                            'href': '/dane/bdl_wskazniki/' + podgrupyKey,
                            'target': '_self'
                        }
                    };
                    grupyChildren.push(podgrupy);
                });

                grupy.children = grupyChildren;
                itemChildren.push(grupy);
            });

            item.children = itemChildren;
            rootData.push(item);
        });
    });

    tree.jstree({
        'core': {
            'data': rootData
        }
    }).bind("select_node.jstree", function (e, data) {
        if (data.node.a_attr.href.charAt(0) == '#') {
            if (typeof (History.pushState) != "undefined") {
                var obj = {Page: data.node.text, Url: data.node.a_attr.href};
                History.pushState(obj, obj.Page, obj.Url);
            }
        } else {
            document.location.href = data.node.a_attr.href;
        }
    }).bind("loaded.jstree", function () {
        if (window.location.href.slice(window.location.href.indexOf('#') + 1)) {
            var link = '[id="' + window.location.href.slice(window.location.href.indexOf('#') + 1) + '_anchor"]';
            tree.jstree("open_node", $(link));
        }
    });
}(jQuery));
