/*global $,document, window */

$(document).ready(function () {
	var root = $('#zbiorkiPubliczne'),
		datepicker = root.find('.datepicker'),
		sections = root.find('.sections');

	var validate = function () {
		var formularz = root.find('.formularz'),
			valid = true;

		formularz.find('input[required="required"]').each(function () {
			if (this.value === '') {
				$(this).addClass('has-error').change(function () {
					var el = $(this);

					if (el.val().length > 0) {
						el.removeClass('has-error').unbind('change');
					}
				});
				valid = false;
			}
		});

		if (formularz.find('.has-error:first').length) {
			$('html, body').animate({
				scrollTop: formularz.find('.has-error:first').offset().top - 100
			}, 500);
		}

		return valid;
	};

	sections.find('.radio label').click(function () {
		if (sections.find('.section:visible:last input:checked')) {
			sections.find('.section:hidden:first').removeClass('hide').hide().slideDown();
		}

		window.setTimeout(function () {
			if ((sections.find('.section:hidden').length === 0) && (sections.find('.section input:checked').length === 3)) {
				root.find('.sectionsBtn .btn').removeClass('disabled');
			}
		}, 0);
	});
	root.find('.sectionsBtn .btn').click(function (e) {
		if ($(this).hasClass('disabled')) {
			e.preventDefault();
		}
	});

	$.datepicker.regional.pl = {
		closeText: 'Zamknij',
		prevText: '&#x3c;Poprzedni',
		nextText: 'Następny&#x3e;',
		currentText: 'Dzień',
		changeMonth: true,
		monthNames: ['stycznia', 'lutego', 'marca', 'kwietnia', 'maja', 'czerwca', 'lipca', 'sierpnia', 'września', 'października', 'listopada', 'grudnia'],
		monthNamesShort: ['Sty', 'Lu', 'Mar', 'Kw', 'Maj', 'Cze',
			'Lip', 'Sie', 'Wrz', 'Pa', 'Lis', 'Gru'],
		dayNames: ['Niedziela', 'Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota'],
		dayNamesShort: ['Nie', 'Pn', 'Wt', 'Śr', 'Czw', 'Pt', 'So'],
		dayNamesMin: ['N', 'Pn', 'Wt', 'Śr', 'Cz', 'Pt', 'So'],
		weekHeader: 'Tydz',
		dateFormat: 'd MM yy',
		altField: '#datepickerAlt',
		altFormat: "yy-mm-dd",
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
	};
	$.datepicker.setDefaults($.datepicker.regional.pl);

	datepicker.each(function () {
		var el = $(this);

		if (el.hasClass('range')) {
			el.find(".from").datepicker({
				dateFormat: 'yy-mm-dd',
				onClose: function (selectedDate) {
					el.find(".to").datepicker("option", "minDate", selectedDate);
				}
			});
			el.find(".to").datepicker({
				dateFormat: 'yy-mm-dd',
				onClose: function (selectedDate) {
					el.find(".from").datepicker("option", "maxDate", selectedDate);
				}
			});
		} else {
			el.datepicker({
				dateFormat: 'yy-mm-dd'
			});
		}
	});

	root.find('.viewForm').click(function () {
		return validate();
	});

	root.find('.printForm').click(function () {
		window.print();
		return false;
	});
});
