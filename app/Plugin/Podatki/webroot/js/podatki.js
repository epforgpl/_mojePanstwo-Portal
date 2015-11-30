/*global mPHeart, window, document, $, confirm*/

$(document).ready(function () {
	var $podatki = $('#podatki'),
		$stripe = $('.stripe'),
		$chartArea = $('.chart_area');

	function btnAction() {
		$podatki.find('input.currency:not(".blurEffect")').addClass('blurEffect').on('keydown', function (e) {
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 188, 190]) !== -1 ||
				(e.keyCode === 65 && e.ctrlKey === true) ||
				(e.keyCode === 67 && e.ctrlKey === true) ||
				(e.keyCode === 88 && e.ctrlKey === true) ||
				(e.keyCode >= 35 && e.keyCode <= 39)) {
				return;
			}
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		}).on('blur', function () {
			var el = $(this);

			if (el.val() !== '') {
				el.val(parseFloat(el.val().replace(',', '.')).toFixed(2).replace('.', ','));
			}
		});
		$podatki.find('.checkbox:not(".checkEffect")').addClass('checkEffect').on('click', function () {
			var el = $(this);
			if (el.find('input[type="checkbox"]').is(':checked')) {
				el.find('input[type="hidden"]').attr('disabled', 'disabled');
			} else {
				el.find('input[type="hidden"]').removeAttr('disabled');
			}
		});
		$podatki.find('.closeAdditional:not(".closeEffect")').addClass('closeEffect').on('click', function (e) {
			var that = $(this),
				parent = that.closest('.row.additional');

			e.preventDefault();

			if (that.attr('href') === '#zamknij') {
				var confirmBtn;
				parent = $(this).parents('.dzialalnoscGospodarcza');

				if (parent.find('input.currency').filter(function () {
						return $(this).val() !== "";
					}).length > 0) {
					confirmBtn = confirm('Zamknięcie tego pola spowoduje utratę wpisanych danych. Czy na pewno chcesz to zrobić?');
				} else {
					confirmBtn = true;
				}

				if (confirmBtn === true) {
					parent.find('> .text-center a').slideDown();
					parent.find('> .row').slideUp();
					parent.find('input').val('');
				}
			} else {
				parent.slideUp(function () {
					parent.remove();
				});
			}
		});
	}

	function resultPie() {
		var res = $chartArea.attr('data-result');

		if (typeof res !== "undefined" && res !== false) {
			var data = [],
				colors = [];

			res = $.parseJSON(res);

			if (res.zus > 0) {
				data.push({
					name: mPHeart.translation.LC_PODATKI_RESULTS_PIE_ZUS,
					y: Number(res.zus)
				});
				colors.push(res.zus_color);
			}
			if (res.zus_pracodawca > 0) {
				data.push({
					name: mPHeart.translation.LC_PODATKI_RESULTS_PIE_ZUS_PRACODAWCA,
					y: Number(res.zus_pracodawca)
				});
				colors.push(res.zus_pracodawca_color);
			}
			if (res.zdrow > 0) {
				data.push({
					name: mPHeart.translation.LC_PODATKI_RESULTS_PIE_ZDROW,
					y: Number(res.zdrow)
				});
				colors.push(res.zdrow_color);
			}
			if (res.pit > 0) {
				data.push({
					name: mPHeart.translation.LC_PODATKI_RESULTS_PIE_PIT,
					y: Number(res.pit)
				});
				colors.push(res.pit_color);
			}
			if (res.vat > 0) {
				data.push({
					name: mPHeart.translation.LC_PODATKI_RESULTS_PIE_VAT,
					y: Number(res.vat)
				});
				colors.push(res.vat_color);
			}
			if (res.akcyza > 0) {
				data.push({
					name: mPHeart.translation.LC_PODATKI_RESULTS_PIE_AKCYZA,
					y: Number(res.akcyza)
				});
				colors.push(res.akcyza_color);
			}

			$chartArea.find('.pie').highcharts({
				credits: false,
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false,
					backgroundColor: 'transparent',
					type: 'pie'
				},
				title: {
					text: ' '
				},
				tooltip: {
					pointFormat: '{series.name}: <b>{point.y}</b>'
				},
				plotOptions: {
					pie: {
						dataLabels: {
							enabled: true,
							format: '{point.percentage:.1f} %',
							distance: -25
						}
					}
				},
				colors: colors,
				series: [{
					name: "Kwota",
					colorByPoint: true,
					data: data
				}]
			});
		}
	}

	$podatki.find('.section').each(function () {
		var sect = $(this);

		sect.find('.btn').click(function (e) {
			e.preventDefault();

			var $btn = $(this),
				btnType = $btn.attr('data-type'),
				row = $btn.closest('.row'),
				section = $btn.closest('.section'),
				number = Number(row.attr('data-number')) + 1,
				content = $('<div></div>').addClass('additional').addClass('row').css('display', 'none');

			var id, name;

			if (btnType === 'przychody_umowa_o_prace') {
				id = 'przychody_umowa_o_prace_' + number;
				name = 'umowa_o_prace[]';
			} else if (btnType === 'przychody_umowa_zlecenie') {
				id = 'przychody_umowa_zlecenie_' + number;
				name = 'umowa_zlecenie[]';
			} else {
				id = 'przychody_umowa_o_dzielo_' + number;
				name = 'umowa_o_dzielo[]';
			}

			content.append(
				$('<div></div>').addClass('col-xs-10 col-sm-6 col-sm-offset-2 col-md-2 col-md-offset-5 text-center inputpadding').append(
					$('<input />').addClass('form-control currency').attr({
						'type': "text",
						'patern': '^\d+(\.|\,)\d{2}$',
						'step': '0.01',
						'name': name,
						'title': mPHeart.translation.LC_PODATKI_INPUT_FLOAT,
						'id': id
					})
				)
			).append(
				$('<div></div>').addClass('col-xs-2 col-sm-4 col-md-3').append(
					$('<a></a>').addClass('closeAdditional glyphicon glyphicon-remove').attr({
						href: '#usuń',
						'aria-hidden': 'true'
					})
				)
			);

			row.attr('data-number', number);
			section.append(content);
			content.slideDown();
			btnAction();
		});
	});

	$('.dzialalnoscGospodarcza a').click(function (e) {
		e.preventDefault();

		$(this).slideUp();
		$(this).parents('.dzialalnoscGospodarcza').find('.row').slideDown();
	});

	if ($stripe.hasClass('scroll')) {
		$('html, body').animate({
			scrollTop: $stripe.offset().top
		}, 600);
	}

	if ($stripe.find('.btnSzczegoly').length) {
		$stripe.find('.btnSzczegoly').click(function (e) {
			var that = $(this).parent();
			e.preventDefault();
			console.log(that);
		});
	}

	btnAction();
	resultPie();
});
