/*global jQuery,window*/

(function ($) {
    "use strict";

    if (window.screen.width > 768) {
        var appMenu = $('.appMenu'),
            appMenuLi = appMenu.find('ul.nav > li'),
            appMenuLiTop;

        if (appMenuLi.length > 0) {
            if (appMenuLi.first().offset().top !== appMenuLi.last().offset().top) {
                appMenuLiTop = appMenuLi.first().offset().top;
                $.each(appMenuLi, function () {
                    if ($(this).offset().top !== appMenuLiTop) {
                        $(this).addClass('hideMenu');
                    }
                });
                appMenu.find('.hideMenu:first').prev().addClass('hideMenu first').before(
                    $('<li></li>').addClass('show_hide').append(
                        $('<a></a>').attr({
                            'href': '#',
                            'data-status': 'more'
                        }).click(function () {
                            if ($(this).data('status') === 'more') {
                                $(this).data('status', 'less');
                                appMenu.find('.hideMenu').stop(true, true).slideDown();
                            } else {
                                $(this).data('status', 'more');
                                appMenu.find('.hideMenu').stop(true, true).slideUp();
                            }
                        })
                    )
                );
                appMenu.find('.hideMenu').hide();
            }
        }
    }
}(jQuery));