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
	
	
	
	$('#glosowania .btns .btn-more').click(function(event){
		
		event.preventDefault();
		
		$('#glosowania ul .gls').removeClass('hidden');
			
		$('#glosowania .btns .btn-more').slideUp();	
		$('#glosowania .btns .btn-less').slideDown();
		$(window).trigger('resize');
		
	});
	
	$('#glosowania .btns .btn-less').click(function(event){
		
		event.preventDefault();
		
		$('#glosowania ul .gls.mniej_istotne').addClass('hidden');
			
		$('#glosowania .btns .btn-more').slideDown();	
		$('#glosowania .btns .btn-less').slideUp();
		
	});
	
});