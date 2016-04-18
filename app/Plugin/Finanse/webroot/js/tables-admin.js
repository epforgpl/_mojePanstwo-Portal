var TableBrowserAdmin = Class.extend({
	mode: 'browse',
	init: function() {
		
		var self = this;	
		
		/*
		$('#btn-switchers .btn').click(function(event){
			
			event.preventDefault();
			var btn = $(event.target);
			
			$('#btn-switchers .btn').removeClass('btn-success').addClass('btn-default');
			btn.removeClass('btn-default').addClass('btn-success');
			
			self.mode = btn.data('mode');
			
			if( self.mode == 'browse' ) {
				self.removeEditControls();
			} else if( self.mode == 'edit' ) {
				self.addEditControls();
			}
			
		});
		*/
		
		$('#tables table tr td, #tables table tr th').click(function(event){			
			if( self.mode == 'edit' ) {
				
				event.preventDefault();
				
				console.log('click');
				
			}
		});
		
	},
	addEditControls: function() {
				
		var trs = $('#tables table tr');
		for( var i=0; i<trs.length; i++ ) {
			
			var tr = $( trs[i] );
			tr.prepend('<td class="control-edit">&nbsp;</td>');
			
		}
		
	},
	removeEditControls: function() {

		$('#tables table tr td.control-edit').remove();

	}
});

var _browser_admin;
$(document).ready(function(){
	_browser_admin = new TableBrowserAdmin();
});