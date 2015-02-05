/*global _mPHeart*/

var _mPGrid = function (main, elements, options) {
        this.cluster = [];
        this.size = {
            width: Math.floor((main.outerWidth() - (2 * options.margin)) / (options.width + options.margin)),
            height: Math.floor((main.outerHeight() - (2 * options.margin)) / (options.width + options.margin))
        };

        this.init = function () {
            this.collection();
        };

        this.widget = function (module) {
            var w = jQuery('<div></div>').addClass('widget module-' + module.id).css({
                left: (module.x * (options.width + 2 * options.margin)) + (2 * options.margin),
                top: (module.y * (options.height + 2 * options.margin)) + (2 * options.margin),
                width: module.sizeX * options.width + ((module.sizeX - 1) * (2 * options.margin)),
                height: module.sizeY * options.height + ((module.sizeY - 1) * (2 * options.margin))
            }).html(module.content);

            w.draggable({
                    containment: main,
                    scroll: false,
                    span: true,
                    grid: [options.width + options.margin, options.height + options.margin]
                    //handle: ".widget-handler"
                }
            );

            w.appendTo(main);
        };

        this.collection = function () {
            var that = this;
            $.each(elements.find('li'), function (index) {
                that.cluster.push({
                    id: index,
                    x: $(this).data('x'),
                    y: $(this).data('y'),
                    sizeX: ($(this).data('row')) ? $(this).data('row') : 1,
                    sizeY: ($(this).data('col')) ? $(this).data('col') : 1,
                    content: $(this).html()
                })
            });

            for (var i = 0; i < that.cluster.length; i++) {
                that.widget(that.cluster[i]);
            }
        };
    }
    ;


var grid;

jQuery(function () {
    jQuery('#home').find('.apps .appFolder').click(function (event) {
        event.preventDefault();
        _mojePanstwoCockpitSlider.showDialogBox(event);
    });

    var $gridster = jQuery('.grid'),
        gridCluster = $gridster.find('ul'),
        gridOptions = {
            width: 120,
            height: 120,
            margin: 10
        };

    grid = new _mPGrid($gridster, gridCluster, gridOptions);
    grid.init();
});