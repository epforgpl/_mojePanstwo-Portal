$(document).ready(function () {
    var autoscrollBlocker = false,
        spisTresci = $('#spis_tresci'),
        searchEngineInput = $('._mojePanstwoCockpitSearchInput'),
        searchOutput = (searchEngineInput.is(':visible') ? 60 : 0),
        searchEngineHeight = searchEngineInput.css('height');

    $("#tagsCloud").cloud({
        hwratio: .3,
        fog: .4
    });

    spisTresci.find('li a').click(function (e) {
        e.preventDefault();
        if ($(this).attr('href') != '#') {
            spisTresci.find('li.active').removeClass('active');
            $(this).parent('li').addClass('active');
            if ($(this).parents('ul:first').attr('class') == 'dropdown-menu')
                $(this).parents('ul:first').parent('li').addClass('active');
            autoscrollBlocker = true;
            $("html, body").animate({scrollTop: $($(this).attr('href')).offset().top - $('header').outerHeight() - spisTresci.outerHeight()}, 1000, function () {
                autoscrollBlocker = false;
            });
        }
    });

    $(window).scroll(function () {
        var securePadding = 20,
            windscroll = $(window).scrollTop(),
            headerFixed = $('header').outerHeight() + searchOutput,
            mainMenuFixed = spisTresci.find('> div').outerHeight(),
            fromBottom = $(document).height() - ($(window).scrollTop() + $(window).height());
        if (!autoscrollBlocker) {
            if (fromBottom == 0) {     // <-- scrolled to the bottom
                spisTresci.find('.nav > li.active').removeClass('active');
                spisTresci.find('.nav > li:last').addClass('active');
            } else if (windscroll > 34) {
                $('#_main').find('> .chapter').each(function (i) {
                    if ($(this).position().top <= windscroll + headerFixed + mainMenuFixed + securePadding) {
                        spisTresci.find('.nav > li.active').removeClass('active');
                        spisTresci.find('.nav > li').eq(i).addClass('active');
                    }
                });
            } else {
                spisTresci.find('.nav > li.active').removeClass('active');
                spisTresci.find('.nav > li:first').addClass('active');
            }
        }
    }).scroll();

    spisTresci.affix({
        offset: {
            top: function () {
                return (this.top = $('#_main').find('.plate').outerHeight(true) - spisTresci.outerHeight(true))
            },
            bottom: function () {
                return (this.bottom = $('footer').outerHeight(true))
            }
        }
    });

    $('#twitter_na_swiecie').find('.twitter-people').each(function () {
        var background = $(this).find('.profile-header-inner');
        background.css('background-image', background.data("background-image"));
    });

    $('._mojePanstwoCockpitSearchContentButton').click(function () {
        if ($(this).hasClass('active')) {
            searchOutput = searchEngineHeight;
            spisTresci.find('>div').animate({'marginTop': searchEngineHeight}, 400, function () {
                spisTresci.addClass('searchDisplay');
                spisTresci.find('>div').css('marginTop', 0);
            });
        } else {
            searchOutput = 0;
            spisTresci.removeClass('searchDisplay');
            spisTresci.find('>div').css('marginTop', '60px').animate({'marginTop': 0}, 400);
        }
    })
});