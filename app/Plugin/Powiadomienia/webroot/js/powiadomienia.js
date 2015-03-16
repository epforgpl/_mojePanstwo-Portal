function changeBckgrn($rotate) {
    $rotate.find('.holdBckgrnd').fadeOut(function () {
        $rotate.find('.holdBckgrnd').css('background-image', $rotate.find('.active').data('bckgrnd'));
        $rotate.find('.holdBckgrnd').fadeIn()
    })
}

(function ($) {
    var $powiadomienia = $('#powiadomienia'),
        $rotate = $("#rotate"),
        $rotatePos = $rotate.offset();

    $rotate.append(
        $('<div></div>').addClass('holdBckgrnd').css('width', $rotate.outerWidth())
    );

    $rotate.find('.slice').each(function () {
        $(this).data('bckgrnd', $(this).css('background-image'));
    });

    $(window).scroll(function () {
        if ($(this).scrollTop() > $rotatePos.top && !$rotate.hasClass('hold')) {
            $rotate.addClass('hold');
            $rotate.find('.holdBckgrnd').css('background-image', $rotate.find('.slice:first-child').data('bckgrnd'));
        } else if ($(this).scrollTop() <= $rotatePos.top && $rotate.hasClass('hold')) {
            $rotate.removeClass('hold');
            $rotate.find('.active').removeClass('active');
        }

        if ($(this).scrollTop() > $rotatePos.top && $rotate.hasClass('hold')) {
            if ($rotate.find('.active').length == 0)
                $rotate.find('.slice:first-child').addClass('active');

            if ($rotate.find('.active').prev().hasClass('slice') && ($(this).scrollTop() + ($(this).height() / 2)) < $rotate.find('.active').prev().offset().top + $rotate.find('.active').prev().outerHeight() - 10) {
                $rotate.find('.active').removeClass('active').prev().addClass('active');
                changeBckgrn($rotate);
            } else if ($rotate.find('.active').next().hasClass('slice') && ($(this).scrollTop() + ($(this).height() / 2)) > $rotate.find('.active').next().offset().top) {
                $rotate.find('.active').removeClass('active').next().addClass('active');
                changeBckgrn($rotate);
            }
        }
    });

    $powiadomienia.find('.start a.icon').click(function (e) {
        e.preventDefault();

        $('html, body').animate({
            scrollTop: $rotate.offset().top
        }, 1000);

    });

    $(window).keydown(function (e) {
        var key = e.which,
            scrollStatus = false;

        if ($rotate.hasClass('hold') && (key == 38 || key == 40)) {
            if (key == 38 && $rotate.prev()) {
                scrollStatus = $rotate.find('.active').prev().offset().top;
            } else if (key == 40 && $rotate.next()) {
                scrollStatus = $rotate.find('.active').next().offset().top
            }
            if (scrollStatus && !$rotate.hasClass('animate')) {
                $rotate.addClass('animate');
                $('html, body').animate({
                    scrollTop: scrollStatus
                }, 1000, function () {
                    $rotate.removeClass('animate');
                });
            }
        }
    });
}(jQuery));