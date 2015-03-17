(function ($) {
    if ($('.appHeader .menu li').length > 0) {
        var $appHeader = $('.appHeader'),
            $appHeaderHeight = $appHeader.outerHeight() - $appHeader.find('.menu').outerHeight(),
            $window = $(window);

        $window.scroll(function () {
            if ($(this).scrollTop() > $appHeaderHeight && !$appHeader.hasClass('stick')) {
                $appHeader.addClass('stick');
            } else if ($(this).scrollTop() <= $appHeaderHeight && $appHeader.hasClass('stick')) {
                $appHeader.removeClass('stick');
            }
        });
    }
}(jQuery));