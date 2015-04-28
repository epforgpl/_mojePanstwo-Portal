jQuery(document).ready(function () {
    var headerExtend = $('.appappHeader.extended'),
        $mobileMenu;

    if (headerExtend.length) {
        headerExtend.css('max-height', headerExtend.css('min-height'));
        headerExtend.css('min-height', Math.floor(parseInt(headerExtend.css('max-height')) - ($(window).scrollTop() * .5)));

        $(window).scroll(function () {
            var scroll = $(window).scrollTop(),
                newHeight = Math.floor(parseInt(headerExtend.css('max-height')) - (scroll * .5));

            headerExtend.css('min-height', (newHeight > headerExtend.css('max-scroll') ? headerExtend.css('max-scroll') : (newHeight < 0 ? 0 : newHeight + 'px')));
        });
    }

    if (($mobileMenu = $('.mobileMenu > a')).length) {
        $mobileMenu.click(function (e) {
            var menu = $(this).parents('ul.nav');

            e.preventDefault();
            if (menu.hasClass('full'))
                menu.removeClass('full');
            else
                menu.addClass('full');
        })
    }
});