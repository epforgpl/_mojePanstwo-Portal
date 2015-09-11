$(document).ready(function(){
	$('#twitterSuggestionsForm select').each(function(){
	  var select = $(this);
	  var option = select.find('option[selected]').attr('value');
	  console.log('option', option);
	  select.val(option);
	});
	
});

