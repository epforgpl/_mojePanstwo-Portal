var Dataliner = Class.extend({
    init: function (div) {
        this.div = $(div);
        this.timeline_div = this.div.find('.timeline');
        this.filters_div = this.div.find('.filters');

        this.requestData = this.div.data('requestdata');
        this.filterField = this.div.data('filterfield');

        this.initData = [];

        var lis = this.timeline_div.find('ul li');

        for (var i = 0; i < lis.length; i++) {
            var li = jQuery(lis[i]);
            this.initData.push({
                type: li.data('type') ? li.data('type') : 'Element',
                date: li.find('> .date').html(),
                title: li.find('> .title').html(),
                content: li.find('> .content').html()
            });
        }

        this.timeline_div.html('').show();

        if (this.filters_div) {
            this.filters_div_select = this.filters_div.find('select');
            if (this.filters_div_select) {
                this.filters_div_select.selectpicker();
                this.filters_div.slideDown();
            }
        }

        this.timeline = new Timeline(this.timeline_div, this.initData);
        this.timeline.setOptions({
            order: 'desc'
        });
        this.timeline.display();
    },

    loadData: function (page) {
        var data = this.requestData;

        if (this.filters_div_select.val() !== undefined) {
            data['conditions'][this.filterField] = this.filters_div_select.val();
        }

        data['page'] = page;

        $.ajax('/dane/dataliner/index.json', {
            type: 'GET',
            dataType: 'json',
            data: data,
            success: $.proxy(function (page, data) {
                if (data.length > 0) {
                    if (page == 1) {
                        this.timeline = new Timeline(this.timeline_div, data);
                        this.timeline.setOptions({
                            order: 'desc'
                        });
                        this.timeline_div.html('');
                        this.timeline.display();
                        $('.endlessLoader').data('page', 1);
                    } else {
                        this.timeline.appendData(data);
                    }
                } else {
                    $('.endlessLoader').hide();
                    intervalRunable = false;
                }
            }, this, page)
        });
    }
});

var __dataliners = [], intervalMain, intervalRunable = true;

$(document).ready(function () {
    var elements = $('.dataliner');
    for (var i = 0; i < elements.length; i++) {
        var dataliner = new Dataliner(elements[i]);
        $(elements[i]).find('.bootstrap-select .dropdown-menu a').click(function (e) {
            e.preventDefault();
            $.proxy(dataliner.loadData(1), this);
        });
        __dataliners.push(dataliner);
        if (jQuery('.endlessLoader').length) {
            var $endlessLoader = jQuery('.endlessLoader');
            if ($endlessLoader.data('page') == undefined) $endlessLoader.data('page', 1);
            intervalMain = setInterval(function () {
                if (isElementVisibled('.endlessLoader') && intervalRunable) {
                    intervalRunable = false;
                    $endlessLoader.data('page', $endlessLoader.data('page') + 1);
                    dataliner.loadData($endlessLoader.data('page'));
                }
            }, 1500);
        }

    }

});