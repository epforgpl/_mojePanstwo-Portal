var gabinetypolityczneTimer;

(function ($) {
    var gabinetypolityczne = $('.gabinety-polityczne'),
        ministerstwa = gabinetypolityczne.find('.ministerstwa'),
        ministerstwaHeight = -1;

    function _scrollSystemGo(curr, el) {
        if (gabinetypolityczne.data('scrolling') != true) {
            gabinetypolityczne.data('scrolling', true);

            curr.data('onscreen', false);

            $('html, body').animate({
                scrollTop: el.offset().top - $('#epaszport').outerHeight() - $('.header').outerHeight()
            }, 800, function () {
                el.data('onscreen', true);
                gabinetypolityczne.data({'scrollable': true, 'scrolling': false});
            });
        }
    }

    function _ministerstwaSetHeights() {
        /*RESET HEIGHT ATTR*/
        ministerstwa.find('.list .point').removeAttr('style');

        ministerstwa.find('.list').each(function () {
            $(this).find('.point').each(function () {
                ministerstwaHeight = ministerstwaHeight > $(this).height() ? ministerstwaHeight : $(this).height();
            });
        });

        ministerstwa.find('.list').each(function () {
            $(this).find('.point').height(Math.round(ministerstwaHeight + 10));
        });
    }

    function _flipper(flipParent) {
        flipParent.find('.btn.doswiadczenie').click(function (e) {
            var flipParent = $(this).parents('.point').find('.flipbox');

            e.preventDefault();

            flipParent.flippy({
                color_target: "#02486c",
                duration: "750",
                depth: 1,
                verso: flipParent.find('.reverse').html(),
                onStart: function () {
                    flipParent.addClass('flipped');
                },
                onFinish: function () {
                    flipParent.find('.btn.wroc').click(function (e) {
                        var flipParent = $(this).parents('.point').find('.flipbox');

                        e.preventDefault();

                        if (flipParent.hasClass('flipped')) {
                            flipParent.flippyReverse();
                        }
                    });
                },
                onReverseFinish: function () {
                    flipParent.removeClass('flipped');
                    _flipper(flipParent);
                }
            });
        });
    }

    function globalBlockHeight() {
        var viewPortHeight;

        if (typeof window.innerWidth != 'undefined') {
            viewPortHeight = window.innerHeight;
        } else if (typeof document.documentElement != 'undefined' && typeof document.documentElement.clientWidth != 'undefined' && document.documentElement.clientWidth != 0) {
            viewPortHeight = document.documentElement.clientHeight;
        } else {
            viewPortHeight = document.getElementsByTagName('body')[0].clientHeight;
        }

        gabinetypolityczne.find('.slider').css('minHeight', viewPortHeight - 20 + 'px');
    }

    function scrollSystem() {
        $(document).on('scroll', function () {
            clearTimeout(gabinetypolityczneTimer);
            gabinetypolityczneTimer = setTimeout(function () {
                var gabinetypolityczne = $('.gabinety-polityczne');

                if (gabinetypolityczne.data('scrollable') != false) {
                    var scrollPos = jQuery(window).scrollTop() + $('#epaszport').outerHeight() + $('.header').outerHeight(),
                        scrollHeight = jQuery(window).height(),
                        active = gabinetypolityczne.find('.slider:data("onscreen")');

                    if (active.length == 0)
                        active = gabinetypolityczne.find('.slider:first').data('onscreen', true);

                    var prevBorder = scrollPos + (scrollHeight * .2),
                        nextBorder = scrollPos + (scrollHeight * .4);

                    if (active.offset().top > prevBorder) {
                        var prevSlide = active.prev();
                        if (prevSlide.length != 0) {
                            gabinetypolityczne.data('scrollable', false);
                            _scrollSystemGo(active, prevSlide);
                        }
                    } else if (active.offset().top + active.children().outerHeight() < nextBorder) {
                        var nextSlide = active.next();
                        if (nextSlide.length != 0) {
                            gabinetypolityczne.data('scrollable', false);
                            _scrollSystemGo(active, nextSlide);
                        }
                    }
                }
            }, 400);
        });
    }

    function _sort(parent, childSelector, keySelector) {
        var items = parent.children(childSelector).sort(function (a, b) {
            var vA = $(keySelector, a).text();
            var vB = $(keySelector, b).text();
            return (vA < vB) ? -1 : (vA > vB) ? 1 : 0;
        });
        parent.append(items);
    }

    function ministerstwaAddon() {
        _ministerstwaSetHeights();

        gabinetypolityczne.find('.przegladaj .sorting button').click(function () {
            var that = $(this);
            if (that.hasClass('name')) {
                _sort($('.przegladaj .ministerstwa'), ".slide", "h3.head");
            } else if (that.hasClass('people')) {
                _sort($('.przegladaj .ministerstwa'), ".slide", ".options .people > strong");
            } else if (that.hasClass('age')) {
                _sort($('.przegladaj .ministerstwa'), ".slide", ".options .age > strong");
            }
        });

        ministerstwa.find('h3.head').click(function () {
            ($(this).next().is(':visible')) ? $(this).removeClass('open') : $(this).addClass('open');

            $(this).next().stop(true, true).slideToggle('slow');

            return false;
        }).next().hide();

        _flipper(ministerstwa.find('.list .point'));
    }

    function publikowanieAddon() {
        $('.publikowanie table .icon > img').tooltip();
    }

    /*INIT*/
    globalBlockHeight();
    //scrollSystem();

    ministerstwaAddon();
    publikowanieAddon();
}(jQuery));