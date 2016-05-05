var goToChapter = function(id) {
		
	var element = $(id);
	if( element ) {
		
		location.hash = id;
		var offset = element.offset();
		var top = Math.round( offset['top'] );
		
		$('html').animate({scrollTop: top-55}, 200);
	
	}
}

$(document).ready(function(){
	
	var spymenu = $('#spy-menu');
	if( spymenu.length ) {
	
		spymenu.sticky({
			topSpacing: 40
		});
		
		$('body').scrollspy({
			target: '#spy-menu',
			offset: 60
		});
		
		spymenu.on('activate.bs.scrollspy', function(event) {
			event.preventDefault();
			var target = $(event.target);
			target = target.find('a');
			// location.hash = target.attr('href');
		});
		
		spymenu.find('.tos a').click(function(event) {
			
			event.preventDefault();
			var target = $(event.target).parents('a');
			var id = target.attr('href');
			
			if( id )
				goToChapter(id);
			
		});
		
		if( location.hash )
			goToChapter(location.hash);
			
	}
		
});