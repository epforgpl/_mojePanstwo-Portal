/*global $, document*/

$(document).ready(function () {
	$('#wpfBigImageModal').on('show.bs.modal', function () {
		$('#wpfBigImageModal .wpf-zoom').bigImage({
			zoom: {
				width: 600,
				height: 400,
				maskElement: function () {
					return $('<div/>', {'class': 'wpf-zoom-mask'});
				}
			}
		});
	});
});
