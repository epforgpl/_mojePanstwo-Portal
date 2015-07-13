var _obj;

$(document).ready(function () {
    $('.dataFeed .loadMoreContent button').click(function (obj) {

        _obj = obj;

        var element = $(obj.target).closest('.loadMoreContent');
        var page = Number(element.data('nextpage'));

        element.find('.button').hide();
        element.find('.spinner').show();

        $.ajax({
            url: location.pathname + '.json',
            data: {
                'page': page,
                'perPage': Number(element.data('perpage')),
                'direction': element.data('direction'),
            },
            dataType: 'json',
            success: $.proxy(function (data) {

                this.element.closest('.dataFeed').find('ul.dataFeed-ul').append(data.html);
                this.element.data('nextpage', this.nextpage);

                element.find('.spinner').hide();
                element.find('.button').show();

                try {
                    $SG.update();
                }
                catch (err) {
                }


            }, {
                'element': element,
                'nextpage': page + 1,
            })
        });

    });
});