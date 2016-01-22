/*global $,document,window*/
$(document).ready(function () {
	var appsList = $('#homepage .appsList .appBorder'),
		maxHeight = 0;

	function appsHeight() {
		appsList.css('height', 'auto').find('.sideIcon').css('height', 'auto');
		if ($(window).width() >= 992) {
			maxHeight = Math.max.apply(null, appsList.map(function () {
				return $(this).outerHeight();
			}).get());

			appsList.each(function () {
				var el = $(this);

				el.css('height', maxHeight);
				el.find('.sideIcon').css('height', maxHeight - 22);
			});
		}
	}

	$(window).resize(function () {
		appsHeight();
	});

	appsHeight();
});
