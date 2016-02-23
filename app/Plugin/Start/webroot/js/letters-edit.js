function fillDateValue(year, month, day) {
	$('#letter-date').val( day + ' ' + _months[month-1] + ' ' + year );
}

var _months = ['stycznia', 'lutego', 'marca', 'kwietnia', 'maja', 'czerwca', 'lipca', 'sierpnia', 'września', 'października', 'listopada', 'grudnia'];

$(document).ready(function() {
	
	$('#letter-date').pickadate({
		hiddenName: true,
		formatSubmit: 'yyyy-mm-dd',
		onSet: function(thingSet) {
			
			var d = new Date(thingSet.select);
			var year = d.getFullYear() 
			var month = d.getMonth()+1;
			var day = d.getDate();
			
			fillDateValue(year, month, day);
			
		}
	});
	
	var init = $('#letter-date').data('value');
		
	if( init ) {
		
		var match = init.match('^([0-9]{4})\-([0-9]{2})\-([0-9]{2})$');
		if( match ) {
			
			var year = Number( match[1] );
			var month = Number( match[2] );
			var day = Number( match[3] );
			
			fillDateValue(year, month, day);
			
		}
		
	} else {
		
		$('#letter-date').val('');
		
	}
	
});