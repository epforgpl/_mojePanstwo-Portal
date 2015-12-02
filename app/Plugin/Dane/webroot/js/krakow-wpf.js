/*global $, document, window*/

$(document).ready(function () {
	var $wpfModal = $('#wpfBigImageModal'),
		el = $wpfModal.find('.wpf-zoom');

	$wpfModal.on('shown.bs.modal', function () {
		var modalW = $wpfModal.find('.modal-body').width(),
			w = el.width();

		el.bigImage('init', {
			zoom: {
				width: modalW,
				height: el.height() * (modalW / w),
				maskElement: function () {
					return $('<div/>', {
						'class': 'wpf-zoom-mask',
						'style': 'margin-left: -' + (w + ((modalW - w) / 2)) + 'px; margin-top: ' + el.height() + 'px;'
					});
				}
			}
		});
	});
});
