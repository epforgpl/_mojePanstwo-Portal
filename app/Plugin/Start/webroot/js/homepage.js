/*global $,document*/
$(document).ready(function () {
	var appsList = $('#homepage .appsList .appBorder'),
		maxHeight = 0;

	maxHeight = Math.max.apply(null, appsList.map(function () {
		return $(this).outerHeight();
	}).get());

	appsList.each(function () {
		var el = $(this);

		el.css('height', maxHeight);
		el.find('.sideIcon').css('height', maxHeight - 22);
	});
});
