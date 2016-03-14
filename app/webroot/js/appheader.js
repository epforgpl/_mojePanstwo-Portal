/*global jQuery,window*/

(function ($) {
    "use strict";

	var appHeader = $('.appHeader'),
		dataHighlightHidden = $('.dataHighlight-hidden');

	if (dataHighlightHidden.length) {
		dataHighlightHidden.find('.dataHighlight-hidden-button > .btn').click(function () {
			
			if( dataHighlightHidden.hasClass('_visible') ) {
				dataHighlightHidden.removeClass('_visible').find('.dataHighlight-content').slideUp();
				dataHighlightHidden.find('.dataHighlight-hidden-button-show').show();
				dataHighlightHidden.find('.dataHighlight-hidden-button-hide').hide();
			} else {
				dataHighlightHidden.addClass('_visible').find('.dataHighlight-content').slideDown();
				dataHighlightHidden.find('.dataHighlight-hidden-button-show').hide();
				dataHighlightHidden.find('.dataHighlight-hidden-button-hide').show();
			}
						
		})
	}

    if (window.screen.width > 768) {
        var statusBar = appHeader.find('.status'),
            statusLi = statusBar.find('ul.dataHighlights > li'),
            statusLiTop,
            appMenu = $('.appMenu'),
            appMenuLi = appMenu.find('ul.nav > li'),
            appMenuLiTop,
            appMenuLiActive;

        if (statusLi.length > 0) {
            if (statusLi.first().offset().top !== statusLi.last().offset().top) {
                statusLiTop = statusLi.first().offset().top;
                $.each(statusLi, function () {
                    if ($(this).offset().top > statusLiTop) {
                        $(this).addClass('hideMenu');
                    }
                });
                statusBar.find('.hideMenu:first').addClass('first');
                statusBar.find('.hideMenu:last').after(
                    $('<li></li>').addClass('dataHighlight show_hide_status').append(
                        $('<a></a>').addClass('glyphicon glyphicon-chevron-down').attr({
                            'href': '#',
                            'data-status': 'more'
                        }).click(function (e) {
                            e.preventDefault();
                            if ($(this).data('status') === 'more') {
                                $(this).data('status', 'less').addClass('glyphicon-chevron-up').removeClass('glyphicon-chevron-down');
                                statusBar.find('.hideMenu').stop(true, true).slideDown();
                            } else {
                                $(this).data('status', 'more').addClass('glyphicon-chevron-down').removeClass('glyphicon-chevron-up');
                                statusBar.find('.hideMenu').stop(true, true).slideUp();
                            }
                        })
                    )
                );
                statusBar.find('.hideMenu').hide();
            }
        }

        if (appMenuLi.length > 0) {
            if (appMenuLi.first().offset().top !== appMenuLi.last().offset().top) {
                appMenuLiTop = appMenuLi.first().offset().top;
                $.each(appMenuLi, function () {
                    if ($(this).offset().top > appMenuLiTop) {
                        $(this).addClass('hideMenu');
                    }
                });
                appMenu.find('.hideMenu:first').prev().addClass('hideMenu first').before(
                    $('<li></li>').addClass('show_hide').append(
                        $('<a></a>').attr({
                            'href': '#'
                        }).click(function (e) {
                            e.preventDefault();

                            if ($(this).data('status') === 'more') {
                                $(this).data('status', 'less');
                                appMenu.find('.hideMenu').stop(true, true).slideDown();
                            } else {
                                $(this).data('status', 'more');
                                appMenu.find('.hideMenu').stop(true, true).slideUp();
                            }
                        })
                    )
                );
                appMenuLi.map(function (index, block) {
                    if ($(block).hasClass('active')) {
                        appMenuLiActive = $(block).offset().top;
                    }
                });
                if (!appMenuLiActive || (appMenuLiActive && (appMenuLiTop == appMenuLiActive))) {
                    appMenu.find('a.show_hide').attr('data-status', 'more');
                    appMenu.find('.hideMenu').hide();
                } else {
                    appMenu.find('a.show_hide').attr('data-status', 'less');
                }
            }
        }
    }
}(jQuery));
