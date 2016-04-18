/*global $,jQuery,window,document*/

$(document).ready(function () {
	/*SIDEMENU - SCROLL IF HEIGHT BIGGER THAN VIEWPORT*/
	var sidebar = $('#_main .app-sidebar'),
		sidebarScroll = sidebar.find('.app-sidebar-scroll');
	
	if( sidebar.length ) {
	
		$(window).on("load resize scroll", function () {
			if ($(window).width() >= 768) {
				var windowTop = $(window).scrollTop(),
					windowHeight = $(window).height(),
					headerHeight = $('#portal-header-sticky-wrapper').outerHeight(),
					sidebarLogoHeight = sidebar.find('.app-logo').outerHeight(),
					sidebarScrollHeight = sidebarScroll.outerHeight();
	
				if (windowHeight < sidebarScrollHeight+20) {
					if (windowHeight - headerHeight - sidebarLogoHeight > sidebarScrollHeight - windowTop) {
						sidebarScroll.css('margin-top', -(sidebarScrollHeight - (windowHeight - headerHeight - sidebarLogoHeight)));
					} else {
						sidebarScroll.css('margin-top', -windowTop);
					}
				}
			} else {
				sidebarScroll.animate({
					'marginTop': 0
				}, 500);
			}
		});
	
		/*MOBILE MENU*/
		$('.app-sidebar ._mobile').click(function (e) {
			var that = $(this);
			e.preventDefault();
	
			if (that.hasClass('_mobile-show')) {
				that.removeClass('_mobile-show');
				that.parents('.app-sidebar').find('.app-list').hide();
			} else {
				that.addClass('_mobile-show');
				that.parents('.app-sidebar').find('.app-list').show();
			}
		});
	
	}
	
});
