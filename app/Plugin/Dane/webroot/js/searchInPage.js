(function ($) {
    var searchInPage = $('#searchInPage'),
        searchInPageNav = searchInPage.find('.searchInPageContent .nav');

    searchInPage.css('marginTop', '-' + searchInPage.height() / 2 + 'px');

    function searchAndHighlight(button, searchTerm) {
        if (searchTerm) {
            //var wholeWordOnly = new RegExp("\\g"+searchTerm+"\\g","ig"); //matches whole word only
            //var anyCharacter = new RegExp("\\g["+searchTerm+"]\\g","ig"); //matches any word with any of search chars characters
            var selector = ".objectsPageWindow" || "body",                             //use body as selector if none provided
                searchTermRegEx = new RegExp("(" + searchTerm + ")", "gi"),
                match = 0,
                helper = {};

            helper.doHighlight = function (node, searchTerm) {
                if (node.nodeType === 3) {
                    if (node.nodeValue.match(searchTermRegEx)) {
                        match++;
                        var tempNode = document.createElement('span');
                        tempNode.innerHTML = node.nodeValue.replace(searchTermRegEx, '<span class="markedSearchWord">$1</span>');
                        node.parentNode.insertBefore(tempNode, node);
                        node.parentNode.removeChild(node);
                    }
                }
                else if (node.nodeType === 1 && node.childNodes && !/(style|script)/i.test(node.tagName)) {
                    $.each(node.childNodes, function (i, v) {
                        helper.doHighlight(node.childNodes[i], searchTerm);
                    });
                }
            };

            $.each($(selector).children(), function (index, val) {
                helper.doHighlight(this, searchTerm);
            });

            button.data('searchMatch', match);
        }
        return false;
    }

    searchInPage.find('a.slider').click(function () {
        var button = $(this);
        if (button.hasClass('closed')) {
            button.removeClass('closed');
            searchInPage.animate({
                left: searchInPage.data('left')
            })
        } else {
            button.addClass('closed');
            searchInPage.data('left', searchInPage.css('left'));
            searchInPage.animate({
                left: -(searchInPage.width() - button.width())
            })
        }
    });
    searchInPageNav.find(' > li > a').click(function (e) {
        var that = $(this),
            markedSearchWord = "markedSearchWord";

        e.preventDefault();

        if (!that.parent().hasClass('active')) {
            if (searchInPageNav.find('li.active').length > 0) {
                searchInPageNav.find('li.active').removeClass('active');

                $('.' + markedSearchWord).removeClass(markedSearchWord);     //Remove old search highlights
            }

            /*ADD ACTIVE MARKER AT CURRENT ONE*/
            that.parent().addClass('active');
            that.data('searchNodesPos', -1);

            searchAndHighlight(that, $.trim(that.text()));
        }

        var newPos = Number(that.data('searchNodesPos')) + 1;

        if (newPos >= Number(that.data('searchMatch')))
            newPos = 0;

        $('html, body').stop(true, true).animate({
            scrollTop: $($('.' + markedSearchWord)[newPos]).offset().top - 80
        }, 800);

        that.data('searchNodesPos', newPos);

    });
}(jQuery));

