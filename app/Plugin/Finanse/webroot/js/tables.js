var TableBrowser = Class.extend({
	init: function() {
		
		var tables = $('#tables table');
		for( var i=0; i<tables.length; i++ ) {
			this.initTable( tables[i] );			
		}	
		
	},
	initTable(table) {
		
		table = $(table);
		var trs = table.find('tr:not(.header)');
		
		for( var i=0; i<trs.length; i++ ) {
			
			var tr = $(trs[i]);
			var parent_id = tr.data('parent_id');
			var depth = Number( tr.data('depth') );
			var _depth = false;
			
			if( parent_id ) {
								
				for( var j=i-1; j>=0; j-- ) {
					
					var _tr = $(trs[j]);					
					if( _tr.data('id') == parent_id ) {
												
						_depth = Number(_tr.attr('data-depth')) + 1;
						break;
						
					}
					
				}
								
				if( (_depth!==false) && (depth!=_depth) ) {
					tr.attr('data-depth', _depth).addClass('child-' + _depth);
				}
			
			}
			
		}
		
	}
});

var _browser;
$(document).ready(function(){
	_browser = new TableBrowser();
});