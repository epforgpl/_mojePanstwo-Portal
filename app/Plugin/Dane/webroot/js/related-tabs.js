(function ($) {
    var relatedTab;

    if ((relatedTab = $('.objectMenu .nav li.related')).length > 0) {
        var objectMenu = $('.objectMenu .nav'),
            objectsPageContent = $('.objectsPageContent');

        relatedTab.find('> a').click(function (e) {
            e.preventDefault();

            History.pushState({
                'target': 'related',
                page: "DaneTabs"
            }, $(document).find("title").html(), objectMenu.find('li.related > a').attr('href'));

            objectMenu.find('li.active').removeClass('active');
            objectMenu.find('li.related').addClass('active');

            objectsPageContent.find('>div:visible').hide();
            objectsPageContent.find('.related_div').show();
        });

        History.Adapter.bind(window, 'statechange', function () {
            var State = History.getState();

            if (State.data.page != "DaneTabs" && State.data.target != 'related')
                location.reload();
        });
    }
}(jQuery));