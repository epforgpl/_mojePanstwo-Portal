/*global $, jQuery, mPHeart*/
(function ($) {
    var main = $('.user_options_votes');

    main.find('.options .vote').click(function () {
        var that = $(this);
        if (!that.hasClass('disabled')) {
            $.ajax({
                url: mPHeart.constant.ajax.api + '/krakow/glosy/save',
                method: 'POST',
                data: {
                    druk_id: $('.htmlexDoc').attr('data-document-id'),
                    user_id: mPHeart.user_id,
                    vote: that.attr('data-vote')
                },
                beforeSend: function () {
                    main.find('.options .vote').addClass('disabled')
                },
                success: function () {
                    main.find('.options .vote').removeClass('disabled')
                }
            })
        }
    });

    //api/krakow/glosy/view/(id_druku)
}(jQuery));