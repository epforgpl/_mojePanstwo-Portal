(function ($) {
    var $navbar = $('#navbar');

    $navbar.css({'width': $navbar.width()});
    $('body').scrollspy({target: '#navbar', offset: 80});
    $navbar.affix({
        offset: {
            top: function () {
                return (this.top = $('.appHeader').outerHeight(true) + $('.appMenu').outerHeight(true))
            }
        }
    });
    $navbar.find('li > a').click(function (e) {
        e.preventDefault();

        $('html, body').animate({
            scrollTop: Math.floor($($(this).attr('href')).offset().top - 40)
        });
    });
}(jQuery));