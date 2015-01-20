jQuery(document).ready(function () {
    var headerExtend = $('.objectPageHeaderBg.extended');

    if (headerExtend.length) {
        headerExtend.css('max-height', headerExtend.css('min-height'));
        headerExtend.css('min-height', Math.floor(parseInt(headerExtend.css('max-height')) - ($(window).scrollTop() * .5)));

        $(window).scroll(function (event) {
            var scroll = $(window).scrollTop(),
                newHeight = Math.floor(parseInt(headerExtend.css('max-height')) - (scroll * .5));

            headerExtend.css('min-height', (newHeight > headerExtend.css('max-scroll') ? headerExtend.css('max-scroll') : (newHeight < 0 ? 0 : newHeight + 'px')));
        });
    }
});