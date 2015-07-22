String.prototype.capitalizeFirstLetter = function () {
    "use strict";
    return this.charAt(0).toUpperCase() + this.slice(1);
};

var BDLapp = function () {
    this.variable = {
        jsScrollHandler: null,
        jsScrollTarget: null
    };

    this.init = function () {
        this.setup();
        this.treeLoad();
    };

    this.setup = function () {
    };
    this.treeLoad = function () {
        var self = this,
            $leftSideAccordion = $('#leftSideAccordion'),
            $tempItemOpisModal = $('#temp_item_opis_modal'),
            tree = $('#tree'),
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
                        'id': 'link_id=' + podgrupyKey,
                        'a_attr': {
                            'href': '/dane/bdl_wskazniki/' + podgrupyKey + '#kategoria_id=' + itemKey + '&grupa_id=' + grupyKey + '&link_id=' + podgrupyKey,
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


        tree.jstree({
            'core': {
                'data': rootData
            },
            "json_data": {
                "progressive_render": true
            },
            "plugins": ["themes", "json_data", "ui"]
        }).bind("select_node.jstree", function (e, item) {
            if (item.node.a_attr.href.charAt(0) === '#') {
                e.preventDefault();
                if (History.pushState !== undefined) {
                    var obj = {Page: item.node.text, Url: item.node.a_attr.href};
                    History.pushState(obj, obj.Page, obj.Url);
                }
                tree.jstree("open_node", item.node.id);
            } else {
                self.itemLoad(item.node.data.id);
            }
            self.treeScrollReload();
        }).bind("loaded.jstree", function () {
            var $treeBlock = $('.treeBlock');

            if (window.location.href.indexOf('#') > 0) {
                var link = window.location.href.slice(window.location.href.indexOf('#') + 1);

                if (link.slice(link.indexOf('&') + 1)) {
                    link = link.split('&');
                }

                $.each(link, function () {
                    if (this.match("link_id=")) {
                        $('a[id="' + this + '_anchor"]').addClass('jstree-active')
                    } else {
                        tree.jstree("open_node", this);
                    }
                    self.variable.jsScrollTarget = link[link.length - 1];
                    self.treeScrollReload();
                });
            }

            $leftSideAccordion.removeClass('init').find('h3 span').remove();

            $leftSideAccordion.find('.accordion').accordion({
                heightStyle: "fill",
                create: function () {
                    $treeBlock.css('height', $('.noOverflow').outerHeight() - $('.noOverflow .suggesterBlock').outerHeight() - 5);
                    $('.jScrollPane').jScrollPane();
                    self.treeScrollReload();
                }
            });

            $(window).resize(function () {
                $treeBlock.css('height', 'auto');
                $leftSideAccordion.find('.accordion').accordion("refresh");
                $treeBlock.css('height', $('.noOverflow').outerHeight() - $('.noOverflow .suggesterBlock').outerHeight() - 5);
                self.treeScrollReload();
            });
        });

        if ($tempItemOpisModal.length) {
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

            $(".import_input").bind('click', function () {
                $(".input_url").removeClass('hidden');
            });

            $(".bdl_input").bind('click', function () {
                $(".input_url").addClass('hidden');
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

            $("#new_temp_item").click(function () {
                $('#temp_item_opis_modal').modal('show');
            });
        }
    };
    this.treeScrollReload = function () {
        var self = this,
            api = $('.jScrollPane').data('jsp');
        if (api) {
            setTimeout(function () {
                api.reinitialise();
                if (self.variable.jsScrollTarget !== null) {
                    clearTimeout(self.variable.jsScrollHandler);
                    self.variable.jsScrollHandler = setTimeout(function () {
                        var linkPos = $('a[id="' + self.variable.jsScrollTarget + '_anchor"]').parents('li').offset().top - $('.suggesterBlock').outerHeight() - ($('.noOverflow').outerHeight() / 2);
                        api.scrollTo(0, linkPos, 'ease');
                        self.variable.jsScrollTarget = null;
                    }, 250);
                }
            }, 200);
        }
    };
    this.treeFocus = function () {
    };
    this.itemLoad = function (item) {
        var self = this;
        console.log(item);
        self.itemInit();
    };
    this.itemInit = function () {
    };
    this.subitemLoad = function () {
        var self = this;
        self.subitemInit();
    };
    this.subitemInit = function () {
    };

    this.init();
};

(function ($) {
    var _bdl_app = new BDLapp();
}(jQuery));