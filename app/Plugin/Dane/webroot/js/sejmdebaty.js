$(document).ready(function () {
	
	History.Adapter.bind(window,'statechange',function(){ // Note: We are using statechange instead of popstate
        var State = History.getState(); // Note: We are using History.getState() instead of event.state
    });
	
	var bar = $('.stickybar');
	if( bar.length ) 
		bar.sticky({topSpacing:35});
	
	var debata_div = $('.debata-wystapienia');
	var debata_id = debata_div.attr('did');
	var id = debata_div.attr('wid');
	
	if( id ) {
		
		var wdiv = debata_div.find('.sejm_debata_wystapienie[oid=' + id + ']');
		if( wdiv )
			$("html, body").animate({ scrollTop: wdiv.offset().top - 55 }, 500);
		
	}
	
	debata_div.find('.sejm_debata_wystapienie a.load').click(function(event){
		
		event.preventDefault();
		var a = $(event.target);
		
		var wdiv = a.closest('.sejm_debata_wystapienie');
		var id = wdiv.attr('oid');
				
	    History.pushState({state: id}, wdiv.find('.text').text(), '/dane/instytucje/3214,sejm/debaty/' + debata_id + '/wystapienia/' + id);
		$("html, body").animate({ scrollTop: wdiv.offset().top - 55 }, 500);
		
		wdiv.find('.sw_content').addClass('_loading').addClass('_disabled');
		$.get('/dane/sejm_wystapienia/' + id + '.json', function(data) {
			
			var id = data['data']['id'];
			var html = data['layers']['html'];
			
			if( id && html ) {
								
				var div = debata_div.find('.sejm_debata_wystapienie[oid=' + id + ']');
				var div_text = div.find('.text');
				
				
				
				if( !div.attr('data-html') ) 
					div.attr('data-html', div_text.html());
				
				div_text.fadeOut(300, function(){
					
					div.find('.sw_content').removeClass('_loading');
					div_text.html(html);
					div.find('.sw_content').addClass('expanded');
					div_text.fadeIn(300, function(){
						div.find('.sw_content').removeClass('_disabled');
					});
					
					
				});
				
				
				
			}
			
		});
		
	});
	
	debata_div.find('.sejm_debata_wystapienie a.unload').click(function(event){
		
		event.preventDefault();
		var a = $(event.target);
		
		var div = a.closest('.sejm_debata_wystapienie');
		var div_text = div.find('.text');
				
		div.find('.sw_content').addClass('_disabled');
		
		
		div_text.fadeOut(300, function(){
			
			div.find('.sw_content').removeClass('expanded');
			$("html, body").animate({ scrollTop: div.offset().top - 55 }, 500);
			
			div_text.html(div.attr('data-html'));
			div_text.fadeIn(300, function(){
				div.find('.sw_content').removeClass('_disabled');
			});
			
		});
		
	    History.pushState({state: null}, $.trim($('.objectPageHeader .title').text()).replace(/[ ]+/g,' '), $('.objectPageHeader .title a').attr('href'));
		
	});
	
});