/*global $,jQuery,window,document*/

function getQueryVariable(variable) {
	var query = window.location.search.substring(1);
	var vars = query.split("&");
	for (var i=0;i<vars.length;i++) {
		var pair = vars[i].split("=");
		if (pair[0] == variable) {
			return pair[1];
		}
	} 
	return false;
}

function getLocation(href) {
    var match = href.match(/^(https?\:)\/\/(([^:\/?#]*)(?:\:([0-9]+))?)(\/[^?#]*)(\?[^#]*|)(#.*|)$/);
    return match && {
        protocol: match[1],
        host: match[2],
        hostname: match[3],
        port: match[4],
        pathname: match[5],
        search: match[6],
        hash: match[7]
    }
}

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
	
	
	$('.block.expandable').each(function(){
		
		var height = $(this).find('section').height();
		
		if( height > 160 ) {
		
			var exp_buttons_div = $('<div class="expandable-buttons"><a class="more" href="#">&darr; Rozwiń</a><a class="less" href="#">&uarr; Zwiń</a></div>');
			exp_buttons_div.find('a').click(function(event){
				
				event.preventDefault();
				
				var a = $(event.target).closest('a');
				var block = a.parents('.block');
				
				if( a.hasClass('more') ) {
					
					a.hide();
					block.removeClass('expandable-close').removeClass('expandable-complete').addClass('expandable-open').find('.expandable-buttons .less').css({display: 'block'});
					
					block.find('section').animate({
						height: height + 30
					}, 1000, function() {
						block.addClass('expandable-complete');
					});
										
				} else if( a.hasClass('less') ) {
					
					a.hide();
					block.removeClass('expandable-open').removeClass('expandable-complete').addClass('expandable-close').find('.expandable-buttons .more').css({display: 'block'});
					
					block.find('section').animate({
						height: 130
					}, 1000, function() {
						block.addClass('expandable-complete');
					});
					
				}
				
				
							
			});
			
			$(this).addClass('expandable-active').addClass('expandable-close').data('height', height).append( exp_buttons_div );
		
		}
		
	});
	
	
		
});
