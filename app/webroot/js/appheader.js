/*global jQuery,window*/

(function ($) {
    "use strict";

    var appHeader = $('.appHeader');

    if (window.screen.width > 768) {
        var appMenu = $('.appMenu'),
            appMenuLi = appMenu.find('ul.nav > li'),
            appMenuLiTop,
            appMenuLiActive;

        if (appMenuLi.length > 0) {
            if (appMenuLi.first().offset().top !== appMenuLi.last().offset().top) {
                appMenuLiTop = appMenuLi.first().offset().top;
                $.each(appMenuLi, function () {
                    if ($(this).offset().top > appMenuLiTop) {
                        $(this).addClass('hideMenu');
                    }
                });
                appMenu.find('.hideMenu:first').prev().addClass('hideMenu first').before(
                    $('<li></li>').addClass('show_hide').append(
                        $('<a></a>').attr({
                            'href': '#'
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
                appMenuLi.map(function (index, block) {
                    if ($(block).hasClass('active')) {
                        appMenuLiActive = $(block).offset().top;
                    }
                });
                if (!appMenuLiActive || (appMenuLiActive && (appMenuLiTop == appMenuLiActive))) {
                    appMenu.find('a.show_hide').attr('data-status', 'more');
                    appMenu.find('.hideMenu').hide();
                } else {
                    appMenu.find('a.show_hide').attr('data-status', 'less');
                }
            }
        }
    }

    if (appHeader.hasClass('dataobject-cover')) {
        var changeBackground = $('#modalAdminAddBackground');

        if (changeBackground.length) {
            appHeader.find('.addBackgroundBtn').click(function () {
                changeBackground.modal('show');
            });
            changeBackground.find('.image-editor').cropit({
                imageState: {
                    src: 'http://lorempixel.com/1500/400/'
                },
                width: 750,
                height: 200,
                exportZoom: 2
            });
            changeBackground.find('.export').click(function () {
                var imageData = changeBackground.find('.image-editor').cropit('export', {
                    type: 'image/jpeg',
                    quality: .9
                });
                changeBackground.find('.modal-footer').append($('<img/>').attr('src', imageData));
            });
        }
    }
}(jQuery));