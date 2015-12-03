/*global $, document, window*/

$(document).ready(function () {
	var $wpfModal = $('#wpfBigImageModal'),
		el = $wpfModal.find('.wpf-zoom');

	$wpfModal.on('shown.bs.modal', function () {
		el.bigImage('init', {
			zoom: {
				width: el.width(),
				height: el.height(),
				maskElement: function () {
					return $('<div/>', {
						'class': 'wpf-zoom-mask',
						'style': 'margin-left: 1%;'
					});
				}
			}
		});
	});
});
