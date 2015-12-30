/*global jQuery*/
(function ($) {
	var _mPCockpit = $('#portal-header');

	_mPCockpit.find('._mPSearch').click(function (e) {
		var suggesterBlockModal = $('.suggesterBlockModal');

		e.preventDefault();

		if ($('._mPSearchOutside').length) {
			$('._mPSearchOutside input').focus();
		} else {
			$('.suggesterBlockModal').modal('toggle');
		}

		suggesterBlockModal.on('shown.bs.modal', function () {
			suggesterBlockModal.find('input').focus();
		}).on('hidden.bs.modal', function () {
			suggesterBlockModal.find('input').val('');
		});
	});
})(jQuery);
