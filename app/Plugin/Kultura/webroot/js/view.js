var CultureBrowser = Class.extend({
	
	div: false,
	filtersDiv: false,
	filtersForm: false,
	captionsDiv: false,
	file_id: false,
	
	init: function(div) {
		
		this.div = $(div);
		this.filtersDiv = this.div.find('.filters');
		this.filtersForm = this.div.find('.filtersForm');
		this.captionsDiv = this.div.find('.captions');
		
		this.file_id = this.div.data('file_id');
		
		var self = this;
		
		this.filtersDiv.find('a.title').click(function(event){
			event.preventDefault();
			self.filterToogle( $(event.target).parents('li').data('filter_id') );
		});
		
		var filterInputs = this.filtersDiv.find('input');
		for( var i=0; i<filterInputs.length; i++ ) {
			
			var inp = $( filterInputs[i] );
			
			if( inp.val() == '-' ) {
				inp.prop('checked', true);
			} else {
				inp.prop('checked', null);				
			}
						
			inp.change(function(event){
				var inp = $(event.target);
				if( inp.val()=='-' ) {
					self.filterClose( inp.parents('li.fliterLi').data('filter_id') );
				}
				self.loadData();
			});
			
		}		
		
		this.loadData();
		
	},
	
	getFilterLi: function(id) {
		return this.filtersDiv.find('li[data-filter_id=' + id + ']');
	},
	
	filterToogle: function(id){
		
		var li = this.getFilterLi(id);
		if( li.hasClass('open') ) {
			this.filterClose(id);
		} else {
			this.filterOpen(id);
		}
		
	},
	
	filterOpen: function(id) {
		
		var li = this.getFilterLi(id);
		var a = li.find('a.title');
		var ul = li.find('ul');
		
		li.addClass('open');
		ul.slideDown();
		
	},
	
	filterClose: function(id) {
		
		var li = this.getFilterLi(id);
		var a = li.find('a.title');
		var ul = li.find('ul');
		
		li.removeClass('open');
		ul.slideUp();
		
	},
	
	loadData: function() {
		
		this.captionsDiv.find('.spinner').show();
				
		var self = this;
		$.get('/kultura/data/' + this.file_id + '.json?' + this.filtersForm.serialize(), function(data){
			
			self.captionsDiv.find('.spinner').hide();
			var lis = self.captionsDiv.find('li');
			
			for( var i=0; i<lis.length; i++ ) {
				
				var li = $(lis[i]);
				var p = li.find('.value');
				var caption_id = li.data('caption_id');
				
				if( typeof data['captions'][caption_id] != 'undefined' ) {
					
					if( data['captions'][caption_id] ) {
									
						p.removeClass('zero').css({
							width: Math.round(data['captions'][caption_id]) + '%'
						}).text( Math.round(data['captions'][caption_id]*10)/10 + '%' ).show();
					
					} else {
						
						p.addClass('zero').css({
							width: '100%'
						}).text('0').show();
						
					}
					
					li.show();
					
				} else {
					
					li.hide();
					
				}
				
			}
			
		});
		
	}
	
});

var _browser;
$(document).ready(function(){
	_browser = new CultureBrowser('#cultureBrowser');
});