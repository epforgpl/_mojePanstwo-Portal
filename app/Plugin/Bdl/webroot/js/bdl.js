/*global $, document, window, history, mPHeart, bdlClick*/

$(document).ready(function () {
	var $bdl = $('.bdlClickEngine');

	if( window.location.hash ) {
		var hash = window.location.hash.substring(1);
		if( hash.length ) {
			var parts = hash.split(',');
			hash = parts[0];

			var item = $bdl.find('.item[name=' + hash + ']');
			if( item.length ) {
				bdlClick(item.parents('.bdlBlock')[0]);
			} else {
				history.pushState("", document.title, window.location.pathname);
			}
		}
	}

	$bdl.find('.item .inner').click(function (e) {
		bdlClick($(e.target).parents('.bdlBlock')[0]);
	});
});
