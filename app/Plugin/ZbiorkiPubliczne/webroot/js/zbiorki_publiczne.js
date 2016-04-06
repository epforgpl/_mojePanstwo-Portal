/*global $,document */

$(document).ready(function () {
	var root = $('#zbiorkiPubliczne'),
		sections = root.find('.sections');

	sections.find('.radio label').click(function () {
		if (sections.find('.section:visible:last input:checked')) {
			sections.find('.section:hidden:first').removeClass('hide').hide().slideDown();
		}

		console.log((sections.find('.section:hidden').length === 0), (sections.find('.section input:checked').length === 3), (sections.find('.section:hidden').length === 0) && (sections.find('.section input:checked').length === 3));

		if ((sections.find('.section:hidden').length === 0) && (sections.find('.section input:checked').length === 3)) {
			root.find('.sectionsBtn .btn').removeClass('disabled');
		}
	});
	root.find('.sectionsBtn .btn').click(function (e) {
		if ($(this).hasClass('disabled')) {
			e.preventDefault();
		}
	});
});
