/*global jQuery */

(function ($) {
    "use strict";
    var $powiadomienia = $('#powiadomienia'),
        $rotate = $("#rotate"),
        $rotatePos = $rotate.offset(),
        offest = 0.9;

    function changeBackground() {
        if (!$rotate.hasClass('changing')) {
            $rotate.addClass('changing');
            $rotate.find('.holdBckgrnd').append(
                $('<div></div>').addClass('temp').css({
                    'display': 'none',
                    'background-image': $rotate.find('.active').data('bckgrnd')
                })
            );
            $rotate.find('.holdBckgrnd .temp').fadeIn(function () {
                $rotate.find('.holdBckgrnd').css('background-image', $rotate.find('.active').data('bckgrnd'));
                $rotate.find('.holdBckgrnd .temp').remove();
            });
        }
    }

    function scrollSlice(scrollStatus) {
        if (!$rotate.hasClass('animate')) {
            $rotate.addClass('animate');

            $('html, body').animate({
                scrollTop: scrollStatus
            }, 1000, function () {
                $rotate.removeClass('animate changing');
            });

            setTimeout(function () {
                if ($rotate.hasClass('animate') || $rotate.hasClass('changing')) {
                    $rotate.removeClass('animate changing');
                }
            }, 1200);
        }
    }

    $rotate.append(
        $('<div></div>').addClass('holdBckgrnd').css('width', $rotate.outerWidth())
    );

    $rotate.find('.slice').each(function () {
        $(this).data('bckgrnd', $(this).css('background-image'));
    });

    $powiadomienia.find('.start a.icon').click(function (e) {
        e.preventDefault();

        $('html, body').animate({
            scrollTop: $rotate.offset().top
        }, 1000);

    });

    $(window).scroll(function () {
        if ($(this).scrollTop() > $rotatePos.top && !$rotate.hasClass('hold')) {
            $rotate.addClass('hold');
            $rotate.find('.holdBckgrnd').css('background-image', $rotate.find('.slice:first-child').data('bckgrnd'));
        } else if ($(this).scrollTop() <= $rotatePos.top && $rotate.hasClass('hold')) {
            $rotate.removeClass('hold');
            $rotate.find('.active').removeClass('active');
            $rotate.find('.slice:first-child').addClass('active');
        }

        if ($(this).scrollTop() > $rotatePos.top && $rotate.hasClass('hold') && !$rotate.hasClass('changing')) {
            if ($rotate.find('.active').length === 0) {
                $rotate.find('.slice:first-child').addClass('active');
            }
            if ($rotate.find('.active').prev().hasClass('slice') && ($(this).scrollTop()) < $rotate.find('.active').prev().offset().top + ($rotate.find('.active').prev().outerHeight() * offest)) {
                $rotate.find('.active').removeClass('active').prev().addClass('active');
                changeBackground();
            } else if ($rotate.find('.active').next().hasClass('slice') && ($(this).scrollTop() + ($(this).height() * offest)) > $rotate.find('.active').next().offset().top) {
                $rotate.find('.active').removeClass('active').next().addClass('active');
                changeBackground();
            }
        }
    });

    $(window).keydown(function (e) {
        var key = e.keyCode || e.which,
            scrollStatus = false;

        if ($rotate.hasClass('hold') && !$rotate.hasClass('animate')) {
            if ((key === 38 || key === 33 || key === 36) && $rotate.find('.active').prev()) {
                scrollStatus = $rotate.find('.active').prev().offset().top;
            } else if ((key === 40 || key === 34 || key === 35) && $rotate.find('.active').next()) {
                scrollStatus = $rotate.find('.active').next().offset().top;
            }

            if (scrollStatus) {
                scrollSlice(scrollStatus);
            }
        }
    });

    $(window).mousewheel(function () {
        if ($rotate.hasClass('hold') && !$rotate.hasClass('animate')) {
            var activePos = $rotate.find('.active').offset().top,
                screenPos = $(this).scrollTop(),
                scrollStatus = false;

            if ((activePos > screenPos) && $rotate.find('.active').prev()) {
                scrollStatus = $rotate.find('.active').prev().offset().top;
            } else if ((activePos < screenPos) && $rotate.find('.active').next()) {
                scrollStatus = $rotate.find('.active').next().offset().top;
            }

            if (scrollStatus) {
                scrollSlice(scrollStatus);
            }
        }
    });
}(jQuery));