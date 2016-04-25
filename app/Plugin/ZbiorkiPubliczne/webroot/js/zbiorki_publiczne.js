/*global $,document, window */

$(document).ready(function () {
	var root = $('#zbiorkiPubliczne'),
		formularz = root.find('.formularz'),
		datepicker = root.find('.datepicker'),
		sections = root.find('.sections'),
		zbiorkiCache = {};

	var validate = function () {
		var valid = true;

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

	formularz.find('input[name="organizacja_nazwa"]').autocomplete({
		minLength: 2,
		source: function (request, response) {
			if (request.term in zbiorkiCache) {
				response(zbiorkiCache[request.term]);
			} else {
				$.ajax({
					url: "/dane/suggest.json",
					data: {'dataset[]': 'krs_podmioty', q: request.term},
					dataType: "json",
					success: function (res) {
						var data = res.options,
							dataArr = [];

						for (var i = 0; i < data.length; i++) {
							dataArr.push({label: data[i].text, value: data[i].payload.object_id});
						}

						zbiorkiCache[request.term] = dataArr;
						response(dataArr);
					},
					error: function () {
						response([]);
					}
				});
			}
		},
		select: function (event, ui) {
			$.ajax({
				url: '/dane/krs_podmioty/' + ui.item.value + '.json',
				success: function (data) {
					if (data.data.firma) {
						formularz.find('input[name="organizacja_nazwa"]').val(data.data.firma);
					}

					if (data.data.adres) {
						formularz.find('input[name="organizacja_miejscowosc"]').val(data.data.adres);
					}

					if (data.data.adres_kraj) {
						formularz.find('input[name="organizacja_kontakt_kraj"]').val(data.data.adres_kraj);
					}

					if (data.data.adres_miejscowosc) {
						formularz.find('input[name="organizacja_kontakt_miejscowosc"]').val(data.data.adres_miejscowosc);
					}

					if (data.data.adres_ulica) {
						formularz.find('input[name="organizacja_kontakt_ulica"]').val(data.data.adres_ulica);
					}

					if (data.data.adres_numer) {
						formularz.find('input[name="organizacja_kontakt_nr_domu"]').val(data.data.adres_numer);
					}

					if (data.data.adres_lokal) {
						formularz.find('input[name="organizacja_kontakt_nr_lokalu"]').val(data.data.adres_lokal);
					}

					if (data.data.adres_kod_pocztowy) {
						formularz.find('input[name="organizacja_kontakt_kod_pocztowy"]').val(data.data.adres_kod_pocztowy);
					}

					if (data.data.email) {
						formularz.find('input[name="organizacja_kontakt_email"]').val(data.data.email);
					}

					if (data.data.www) {
						formularz.find('input[name="organizacja_kontakt_www"]').val(data.data.www);
					}
				},
				error: function () {
					//error
				}
			});

			return false;
		}
	});

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
})
;
