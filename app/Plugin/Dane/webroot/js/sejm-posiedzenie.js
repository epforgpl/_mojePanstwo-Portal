$(document).ready(function(){
	
	$('#punkty .btns .btn-more').click(function(event){
		
		event.preventDefault();
		
		$('#punkty .add_div').slideDown();
			
		$('#punkty .btns .btn-more').slideUp();	
		$('#punkty .btns .btn-less').slideDown();
		$(window).trigger('resize');
		
	});
	
	$('#punkty .btns .btn-less').click(function(event){
		
		event.preventDefault();
		
		$('#punkty .add_div').slideUp();
			
		$('#punkty .btns .btn-more').slideDown();	
		$('#punkty .btns .btn-less').slideUp();
		
	});
	
});