$(document).ready(function(){
	$('.dataset-observe-button').click(function(event){
		
		console.log('dataset-observe-button click');
		
		event.preventDefault();
		$('#observeModal').modal('show');
		
	});
});