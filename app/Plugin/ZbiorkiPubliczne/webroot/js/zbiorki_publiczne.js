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
					before: function () {
						formularz.find('input[name="organizacja_nazwa"]').addClass('loading');
					},
					success: function (res) {
						var data = res.options,
							dataArr = [],
							i;

						for (i = 0; i < data.length; i++) {
							dataArr.push({label: data[i].text, value: data[i].payload.object_id});
						}

						zbiorkiCache[request.term] = dataArr;
						response(dataArr);
					},
					complete: function () {
						formularz.find('input[name="organizacja_nazwa"]').removeClass('loading');
					},
					error: function () {
						response([]);
					}
				});
			}
		},
		focus: function (event, ui) {
			formularz.find('input[name="organizacja_nazwa"]').val(ui.item.label);
			return false;
		},
		select: function (event, ui) {
			$.ajax({
				url: '/dane/krs_podmioty/' + ui.item.value + '.json',
				before: function () {
					formularz.find('input[name="organizacja_nazwa"]').addClass('loading');
				},
				success: function (data) {
					formularz.find('input[name="organizacja_nazwa"]').val('');
					formularz.find('input[name="organizacja_miejscowosc"]').val('');
					formularz.find('input[name="organizacja_kontakt_kraj"]').val('');
					formularz.find('input[name="organizacja_kontakt_miejscowosc"]').val('');
					formularz.find('input[name="organizacja_kontakt_ulica"]').val('');
					formularz.find('input[name="organizacja_kontakt_nr_domu"]').val('');
					formularz.find('input[name="organizacja_kontakt_nr_lokalu"]').val('');
					formularz.find('input[name="organizacja_kontakt_kod_pocztowy"]').val('');
					formularz.find('input[name="organizacja_kontakt_email"]').val('');
					formularz.find('input[name="organizacja_kontakt_www"]').val('');

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
				complete: function () {
					formularz.find('input[name="organizacja_nazwa"]').removeClass('loading');
				},
				error: function () {
					//error
				}
			});

			return false;
		}
	});

	sections.find('.radio label').click(function () {
		window.setTimeout(function () {
			if (sections.find('.section:visible:last input:checked').length > 0) {
				sections.find('.section:hidden:first').removeClass('hide').hide().slideDown();
			}
			window.setTimeout(function () {
				if ((sections.find('.section:hidden').length === 0) && (sections.find('.section input:checked').length === 3)) {
					root.find('.sectionsBtn .btn').removeClass('disabled');
				}
			}, 10);
		}, 0);
	});
	root.find('.sectionsBtn .btn').click(function (e) {
		if ($(this).hasClass('disabled')) {
			e.preventDefault();
		}
	});

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

	if (root.find('.viewForm').length) {
		root.find('.viewForm').click(function () {
			return validate();
		});
	}

	if (root.find('.printForm').length) {
		root.find('.printForm').click(function () {
			var zbiorkiPrintModal = $('#zbiorkiPrintModal');

			if (zbiorkiPrintModal.length === 0) {
				zbiorkiPrintModal = $('<div></div>').addClass('modal fade').attr({
					id: 'zbiorkiPrintModal',
					tabindex: "-1",
					role: 'dialog'
				}).append(
					$('<div></div>').addClass('modal-dialog').append(
						$('<div></div>').addClass('modal-content').append(
							$('<div></div>').addClass('modal-header margin-top-0').append(
								$('<button><button').addClass('close margin-top-0').attr({
									'data-dismiss': 'modal',
									'aria-label': 'Zamknij'
								}).append(
									$('<span></span>').attr('aria-hidden', 'true').html('&times;')
								)
							)
						).append(
							$('<div></div>').addClass('modal-body text-center').append(
								$('<p></p>').text('Sprawdź czy na sprawozdaniu jest podpis osoby uprawnionej do reprezentowania organizacji, a następnie wyślij sprawozdanie do:')
							).append(
								$('<p></p>').html('<b>Ministerstwa Spraw Wewnetrznych i Administracji,<br/>ul. Batorego 5, 02-591 Warszawa</b>')
							)
						)
					)
				);
			}

			zbiorkiPrintModal.modal('show');
			window.print();

			return false;
		});
	}
});
