$(document).ready(function(){
	
	$('body').scrollspy({ target: '#mp-page-menu' });
	
	$('#mp-page-menu a').click(function(e){
		e.preventDefault();
		var id = $(e.target).attr('href');
		
		if( id ) {
			
			var target = $(id);
			if( target ) {
				
				$('html, body').animate({
			        scrollTop: target.offset().top - 20
			    }, 500);
				
			}
			
		}
		
	});
	
	$('.btn-editable').click(function(e){
		
		e.preventDefault();
		var btn = $(this);
				
		var target = $('#_editable_' + btn.attr('data-target'));		
		aloha(target[0]);
		
	});
			
});