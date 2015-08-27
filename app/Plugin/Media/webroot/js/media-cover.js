$(document).ready(function() {
	
	// STICKY
	
	$('#accountsSwitcher').sticky({
		widthFromWrapper: false
	});
	
	$('.sticky').sticky();
	
	
	// TAGS CLOUD
	
	var tagsCloud = $("#tagsCloud");
	if( tagsCloud.length )
		tagsCloud.cloud({
			hwratio: .3,
			fog: .4
		});

});
