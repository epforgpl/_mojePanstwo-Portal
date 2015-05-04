/*global $,jQuery*/

jQuery(document).ready(function () {
    "use strict";
    var headerExtend = $('.objectPageHeaderBg.extended'),
        mobileMenu = $('.mobileMenu');

    if (headerExtend && headerExtend.length) {
        headerExtend.css('max-height', headerExtend.css('min-height'));
        headerExtend.css('min-height', Math.floor(parseInt(headerExtend.css('max-height'), 10) - ($(window).scrollTop() * 0.5)));

        $(window).scroll(function () {
            var scroll = $(window).scrollTop(),
                newHeight = Math.floor(parseInt(headerExtend.css('max-height'), 10) - (scroll * 0.5));

            headerExtend.css('min-height', (newHeight > headerExtend.css('max-scroll') ? headerExtend.css('max-scroll') : (newHeight < 0 ? 0 : newHeight + 'px')));
        });
    }

    if (mobileMenu && mobileMenu.length) {
        mobileMenu.find(' > a').click(function (e) {
            var menu = $(this).parents('ul.nav');

            e.preventDefault();
            if (menu.hasClass('full')) {
                menu.removeClass('full');
            } else {
                menu.addClass('full');
            }
        });
    }
});