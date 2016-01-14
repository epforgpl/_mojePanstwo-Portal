/*global $, document*/

$(document).ready(function () {
	var transferujModalForm = $("#transferujModal form"),
		kwota = transferujModalForm.find('input#transferujModalKwota');

	kwota.on('blur', function () {
		if (kwota.val() <= 0) {
			kwota.val(0.01);
		} else {
			kwota.val(parseFloat(kwota.val()).toFixed(2));
		}
	});
});
