/*global mPHeart*/

$(document).ready(function () {
    var lastChoose,
        $administracja = lastChoose = $('#administracja');

    $.each($administracja.find('.item a'), function () {
        var that = $(this),
			block = that.parents('.blockSlide'),
            items = $(block.parent('.items'));

        that.click(function (e) {
            var next = block.next(),
                targetPos = block.position().top,
                slideMark,
                data = that.data();

            e.preventDefault();

            if (block[0] === lastChoose[0]) {
                lastChoose = false;
                items.removeClass('focus-control');
                items.find('.block.focus').removeClass('focus');
                $administracja.find('.infoBlock').addClass('old').css({
                    'height': 0,
                    'border-width': 0
                }).stop(true, true).animate({'margin-top': 0}, 500, function () {
                    $administracja.find('.infoBlock.old').remove()
                });

                return;
            } else {
                items.find('.block.focus').removeClass('focus');
                items.addClass('focus-control');
                block.addClass('focus');
                lastChoose = block;
            }

            if (next.length == 0) {
                slideMark = block;
            } else {
                while (next.length != 0) {
                    if (next.next().length == 0) {
                        slideMark = next;
                        break;
                    } else {
                        if (next.position().top != targetPos) {
                            slideMark = next.prev();
                            break;
                        }
                        next = next.next();
                    }
                }
            }

            var infoBlock = $('<div></div>').addClass('infoBlock current active col-xs-12').css('height', 0).append(
                $('<div></div>').addClass('arrow')
            ).append(
                $('<div></div>').addClass('content').append(
                    $('<div></div>').addClass('container')
                )
            );

            if ($administracja.find('.infoBlock').length !== 0) {
                if ($administracja.find('.infoBlock').data('marker')[0] === slideMark[0]) {
                    infoBlock = $administracja.find('.infoBlock');
                    infoBlock.addClass('current active');
                } else {
                    $administracja.find('.infoBlock').addClass('old').removeClass('active').css({
                        'height': 0,
                        'border-width': 0
                    }).stop(true, true).animate({'margin-top': 0}, 500, function () {
                        $administracja.find('.infoBlock.old').remove()
                    });
                    slideMark.after(infoBlock);
                }
            } else {
                slideMark.after(infoBlock);
            }

            infoBlock.data('marker', slideMark).find('.container').empty().append(function () {
                var slug = $(this), title = $.trim(data.title), info = data.info
                    ;


                var leftCol = $('<div></div>').addClass('leftSide col-xs-12 col-md-8');
                var rightCol = $('<div></div>').addClass('rightSide col-xs-12 col-md-4');

                leftCol.append(that.find('.text').html());
                rightCol.append('<a href="' + that.attr('href') + '" class="btn btn-md btn-primary">Dowiedz się więcej &raquo;</a>');

                /*
                 leftCol.find('.left').append(
                 $('<a></a>').addClass('btn btn-primary').attr({href: that.attr('href'), target: '_self'}).text(mPHeart.translation.LC_ADMINISTRACJA_INFO_WIECEJ)
                 );
                 */

                slug.append(leftCol).append(rightCol);
            });


            if (infoBlock.position().left != 0) {
                infoBlock.css({'margin-left': -infoBlock.position().left, width: $(window).width()})
            }
            infoBlock.find('.arrow').css('left', block.position().left + (block.outerWidth() / 2) + 'px');
            infoBlock.removeClass('current').css('height', infoBlock.find('.container').outerHeight(true));
        })
    })
})
;
