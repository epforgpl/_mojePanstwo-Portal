/*global mPHeart, window, document, $*/

$(document).ready(function () {
	var $podatki = $('#podatki'),
		$stripe = $('.stripe'),
		$chartArea = $('.chart_area');

	function btnAction() {
		$podatki.find('input[type="number"]:not(".blurEffect")').addClass('blurEffect').on('blur', function () {
			var el = $(this);
			el.val(Number(el.val()).toFixed(2).replace(',', '.'));
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
			e.preventDefault();
			var parent = $(this).closest('.row.additional');
			$(this).parent().slideUp(function () {
				parent.remove();
			});
		});
	}

	function resultPie() {
		var res = $chartArea.attr('data-result');

		if (typeof res !== "undefined" && res !== false) {
			res = $.parseJSON(res);

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
						dataLabels: false
					}
				},
				colors: [res.us_color, res.zus_color, res.pit_color, res.vat_color, res.akcyza_color],
				series: [{
					name: "Kwota",
					colorByPoint: true,
					data: [{
						name: mPHeart.translation.LC_PODATKI_RESULTS_PIE_US,
						y: Number(res.us)
					}, {
						name: mPHeart.translation.LC_PODATKI_RESULTS_PIE_ZUS,
						y: Number(res.zus)
					}, {
						name: mPHeart.translation.LC_PODATKI_RESULTS_PIE_PIT,
						y: Number(res.pit)
					}, {
						name: mPHeart.translation.LC_PODATKI_RESULTS_PIE_VAT,
						y: Number(res.vat)
					}, {
						name: mPHeart.translation.LC_PODATKI_RESULTS_PIE_AKCYZA,
						y: Number(res.akcyza)
					}]
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
				$('<div></div>').addClass('col-xs-12 col-sm-6 col-sm-offset-2 col-md-2 col-md-offset-5 text-center nopadding').append(
					$('<input />').addClass('form-control').attr({
						'type': "number",
						'patern': "[0-9]+([\.|,][0-9]{2}+)?",
						'step': '0.01',
						'name': name,
						'title': mPHeart.translation.LC_PODATKI_INPUT_FLOAT,
						'id': id
					})
				)
			).append(
				$('<div></div>').addClass('col-xs-12 col-sm-4 col-md-3').append(
					$('<a></a>').addClass('closeAdditional glyphicon glyphicon-remove').attr({
						href: '#',
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

	btnAction();
	resultPie();
});
