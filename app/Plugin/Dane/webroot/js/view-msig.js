var MSIG_BROWSER_CLASS = function(div){
	this.init(div);
};

$.extend(MSIG_BROWSER_CLASS.prototype, {
	init: function(div){
		
		var that = this;
		this.div = $(div);
		this.id = this.div.data('id');
		
		this.div.find('.chapters_ul li.chapter >a').click(function(event){
			
			event.preventDefault();
			var li = $(event.target).closest('li.chapter');
			that.toggleChapter(li.data('id'));
			
		});
		
				
	},
	toggleChapter: function(id) {

		console.log('toggleChapter', id);
		
		var li = this.getChapterDiv(id);
		if( li.length ) {
			
			if( li.hasClass('open') ) {
				this.closeChapter(li);
			} else {
				this.openChapter(li);
			}
			
		}
				
	},
	openChapter: function(id) {
		
		console.log('openChapter', id);
		
		var li = this.getChapterDiv(id);
		if( li.length ) {
			
			li.addClass('open');
			
			this.loadChapter(li);
			
		}
		
	},
	closeChapter: function(id) {

		console.log('closeChapter', id);

		var li = this.getChapterDiv(id);
		if( li.length ) {
			
			li.removeClass('open').removeClass('load').removeClass('loaded');
			
			var results_cont = li.find('.results_cont');
			
			results_cont.slideUp({
				duration: 300,
				complete: function(){
					console.log('completed');
				}
			});
			
			
		}
		console.log('closeChapter', li);

	},
	getChapterDiv: function(id) {
				
		if( (typeof(id)=='number') || (typeof(id)=='string') )
			return this.div.find('.chapters_ul li.chapter[data-id=' + id + ']');
		else
			return $(id);
		
	},
	loadChapter: function(id) {
		
		console.log('loadChapter', id);
		
		var that = this;
		var li = this.getChapterDiv(id);
		var id = li.data('id');
		
		if( !li.hasClass('loaded') ) {
		
			$.get('/dane/msig/' + this.id + '/dzialy/' + id + '.json', function(data){
				
				console.log('loadChapter data', data);
				li.addClass('loaded');
				
				var results_cont = li.find('.results_cont');
				var results_div = results_cont.find('.results').html('');
				
				for( var i=0; i<data.pozycje.length; i++ ) {
					
					var p = data.pozycje[i];
					
					var result = $('<li class="result"><p class="title">' + p.data.skrot + '</p></li>');
					
					results_div.append(result);
					
					
				}
				
				results_cont.slideDown({
					duration: 1000
				});
				
				setTimeout(function(){
					li.removeClass('load');
				}, 200);
				
			});
		
		}
		
		li.addClass('load');
		
		
	}
});

var msig_browser;
$(document).ready(function(){
	msig_browser = new MSIG_BROWSER_CLASS('#msig_browser');	
});