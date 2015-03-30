/*global _mPHeart*/
(function ($) {
    var _mPCockpit = $('#_mPCockpit'),
        _mPApplication = _mPCockpit.find('._mPApplication'),
        _homeHandler = $('#_handler'),
        animateDelay = 500;

    _mPApplication.find('> ._appBlock').click(function () {
        var option = $(this);

        if (option.hasClass('_mPSearch')) {
            if ($('._mPSearchOutside').length)
                $('._mPSearchOutside input').focus();
            else {
                $('.suggesterBlockModal').modal('toggle');
            }
            $('.suggesterBlockModal').on('shown.bs.modal', function () {
                $('.suggesterBlockModal input').focus();
            }).on('hidden.bs.modal', function () {
                $('.suggesterBlockModal input').val('');
            })
        } else if (option.hasClass('_mPAppsList')) {
            /*var _mPAppList = $('._mPAppList');
             if (_mPAppList.hasClass('open')) {
             _mPAppList.stop(true, false).animate({
             left: 0
             }, {
             queue: false,
             duration: animateDelay
             });
             _homeHandler.animate({
             'margin-left': 0
             }, {
             queue: false,
             duration: animateDelay
             });
             _mPAppList.removeClass('open')
             } else {
             var pos = _mPCockpit.find('._mPBasic').outerWidth();

             _mPAppList.stop(true, false).animate({
             left: pos
             }, {
             queue: false,
             duration: animateDelay
             });
             _homeHandler.animate({
             'margin-left': pos
             }, {
             queue: false,
             duration: animateDelay
             });
             _mPAppList.addClass('open');
             }*/
        } else if (option.hasClass('_mPFavorite ')) {
            //favorite
        }
    });
    $('#_mPCockpitMobile ._mPShowMenu > button').click(function () {
        var that = $(this);

        if (that.hasClass('open')) {
            that.removeClass('tcon-transform open');

            $('#_main').stop(true, false).animate({
                'margin-left': '0'
            }, {queue: false});
            $('#_mPCockpit ._mPBasic').stop(true, false).animate({
                'margin-left': '-100px'
            }, {queue: false});
        } else {
            that.addClass('tcon-transform open');
            $('#_main').stop(true, false).animate({
                'margin-left': '100px'
            }, {queue: false});
            $('#_mPCockpit ._mPBasic').stop(true, false).animate({
                'margin-left': '0'
            }, {queue: false});
        }
    })
})(jQuery);