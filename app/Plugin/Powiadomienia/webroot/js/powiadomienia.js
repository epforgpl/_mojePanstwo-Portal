function changeBckgrn($rotate) {
    $rotate.find('.holdBckgrnd').fadeOut(function () {
        $rotate.find('.holdBckgrnd').css('background-image', $rotate.find('.active').data('bckgrnd'));
        $rotate.find('.holdBckgrnd').fadeIn()
    })
}

(function ($) {
    var $rotate = $("#rotate"),
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
    })
}(jQuery));