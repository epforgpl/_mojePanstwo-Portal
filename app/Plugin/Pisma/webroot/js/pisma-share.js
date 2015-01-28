$(document).ready(function () {
    $('.share').on('mouseup', function () {
        var t = false;

        if (window.getSelection) {
            t = window.getSelection();
        } else if (document.getSelection) {
            t = document.getSelection();
        } else if (document.selection) {
            t = document.selection.createRange().htmlText;
        }

        if (t && (t + '').length > 0) {
            if (t.rangeCount) {
                var range = t.getRangeAt(0),
                    container = document.createElement("span");
                container.setAttribute('class', 'anonim');
                for (var i = 0, len = t.rangeCount; i < len; ++i) {
                    container.appendChild(t.getRangeAt(i).cloneContents());
                }

                range.deleteContents();
                range.insertNode(container);
            } else {
                t.pasteHTML('<span class="anonim">' + t.htmlText + '</span>');
            }

            $('.anonim .anonim').contents().unwrap();

            $('.anonim').each(function () {
                if ($(this).next() && $(this).next().hasClass('anonim')) {
                    var ch1 = $(this);
                    var ch2 = $(this).next();
                    var contents = ch1.parent().contents();
                    var space = contents.slice(contents.index(ch1) + 1, contents.index(ch2));

                    if (space.text().length == 0) {
                        ch1.addClass('group');
                        ch2.addClass('group');
                        $('.group').wrapAll('<span class="anonim"></span>');
                        ch1.contents().unwrap();
                        ch2.contents().unwrap();

                        ch1.find('b b, u u, i i').unwrap();
                        ch2.find('b b, u u, i i').unwrap();
                    }
                }
            }).unbind('click').click(function () {
                if ($(this).hasClass('anonim')) $(this).contents().unwrap();
            });

            t.removeAllRanges();
        }
    });
});