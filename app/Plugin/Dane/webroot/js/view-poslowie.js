jQuery(document).ready(function () {

    $('.objectTagsCloud').cloud({
        hwratio: .3,
        fog: .4
    });

    var menu = $('.objectsPageContent .objectMenu'),
        menuAutoScroll = true,
        headerHeight = $('header').outerHeight(),
        timelineEmbed;

    /*STICKY MENU*/
	$('#stickyMenu').sticky();

    menu.find('.nav a').click(function (event) {
        var target = jQuery(this).attr('href'),
            padding = 10;
        event.preventDefault();

        menuAutoScroll = false;
        menu.find('li.active').removeClass('active');
        jQuery(this).parent('li').addClass('active');

        jQuery('body, html').stop(true, true).animate({
            scrollTop: jQuery(target).offset().top - jQuery('header').outerHeight() - padding
        }, 800, function () {
            menuAutoScroll = true;
        });
    });
    $(window).scroll(function () {
        if (menuAutoScroll) {
            var windscroll = $(window).scrollTop(),
                searchHeight = ($('._mojePanstwoCockpitSearchInput:visible') ? $('._mojePanstwoCockpitSearchInput').outerHeight() : 0);
            if (windscroll >= 100) {
                $('.objectsPageContent .object > .block').each(function (i) {
                    if ($(this).position().top <= windscroll + headerHeight + searchHeight + 60) {
                        menu.find('li.active').removeClass('active');
                        menu.find('li').eq(i).addClass('active');
                    }
                });
            } else {
                menu.find('li.active').removeClass('active');
                menu.find('li:first').addClass('active');
            }
        }
    }).scroll();

    if ((timelineEmbed = jQuery("#timeline-embed")).length > 0) {
        createStoryJS({
            start_at_end: true,
            width: "100%",
            height: '500',
            source: timelineEmbed.data("source") + '/timeline.json',
            embed_id: 'timeline-embed',
            css: '/plugins/TimelineJS/build/css/timeline.css',
            js: '/plugins/TimelineJS/build/js/timeline-min.js',
            lang: mPHeart.language.twoDig
        });
    }
});
