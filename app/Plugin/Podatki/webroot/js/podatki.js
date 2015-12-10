/*global mPHeart, window, document, $, confirm, bdlClick*/

$(document).ready(function () {
	var $podatki = $('#podatki'),
		$stripe = $('.stripe'),
		$chartArea = $('.pie_chart'),
		$bdl = $('.bdlClickEngine');

	function btnAction() {
		$podatki.find('input.currency:not(".blurEffect")').addClass('blurEffect').on('keydown', function (e) {
			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 188, 190]) !== -1 ||
				(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
				(e.keyCode === 67 && (e.ctrlKey === true || e.metaKey === true)) ||
				(e.keyCode === 86 && (e.ctrlKey === true || e.metaKey === true)) ||
				(e.keyCode === 88 && (e.ctrlKey === true || e.metaKey === true)) ||
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
		var res = $chartArea.attr('data-series');

		if (typeof res !== "undefined" && res !== false) {
			res = $.parseJSON(res);

			var suma = $chartArea.attr('data-suma'),
				podatek = $chartArea.attr('data-podatek'),
				categories = [],
				data = [],
				i, bLen,
				seriesData,
				series = [],
				j, vLen;

			for (i = 0, bLen = res.length; i < bLen; i++) {
				categories.push(res[i].nazwa);
				data.push({
					name: res[i].nazwa,
					y: parseFloat(((res[i].kwota / suma) * podatek).toFixed(0)),
					drilldown: (typeof res[i].subdzialy !== "undefined") ? res[i].nazwa : null
				});
				if (typeof res[i].subdzialy !== "undefined") {
					seriesData = [];
					for (j = 0, vLen = res[i].subdzialy.length; j < vLen; j++) {
						seriesData.push([res[i].subdzialy[j].nazwa.replace(/\(.*\)/g, ''), parseFloat(((res[i].subdzialy[j].kwota / suma) * podatek).toFixed(0))]);
					}
					series.push({
						name: res[i].nazwa,
						id: res[i].nazwa,
						data: seriesData
					});
				}
			}

			$chartArea.css('min-height', ($chartArea.width() * 0.7));
			var chart = new Highcharts.Chart({
				credits: false,
				chart: {
					backgroundColor: null,
					marginTop: 100,
					renderTo: 'pie_chart',
					type: 'column'
				},
				title: {
					text: ' '
				},
				plotOptions: {
					column: {
						depth: 25
					}
				},
				xAxis: {
					categories: categories,
					labels: {
						rotation: -45,
						align: 'right'
					}
				},
				yAxis: {
					title: {
						text: 'zł'
					}
				},
				legend: {
					enabled: false
				},
				tooltip: {
					pointFormat: '<span>Koszt</span>: <b>{point.y}</b> zł<br/>'
				},
				series: [{
					name: ' ',
					colorByPoint: true,
					data: data
				}],
				drilldown: {
					drillUpButton: {
						relativeTo: 'spacingBox',
						position: {
							y: 0,
							x: 0
						},
						theme: {
							fill: '#007ab9',
							'stroke-width': 1,
							stroke: '#007ab9',
							r: 3,
							style: {
								color: '#ffffff',
								'font-size': '14px',
								'font-weight': 400,
								'line-height': '1em'
							},
							states: {
								hover: {
									fill: '#006da5'
								}
							}
						}
					},
					series: series
				}
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

	$bdl.find('.item .inner.clickable').click(function (e) {
		bdlClick($(e.target).parents('.block')[0]);
	});

	$podatki.find('button[type="submit"]').click(function () {
		var state = $podatki.serializeArray().filter(function (e) {
			var val = parseFloat(e.value.replace(',', '.'));
			if (val > 0) {
				return val;
			}
		}).length;

		return (state > 0);
	});

	$bdl.find('.block').each(function () {
		$(this).find('.wskazniki li .col-xs-9 .href').each(function () {
			var textBlock = $(this);
			if (textBlock.text().indexOf("(") > -1) {
				var tooltip = $('<span></span>').attr({
					'title': textBlock.text().match(/\(([^)]+)\)/)[1],
					'data-placement': 'top',
					'data-toggle': 'tooltip'
				}).addClass('tooltipIcon').text('i');
				textBlock.text(textBlock.text().replace(/ *\([^)]*\) */g, "")).append(tooltip);
			}
		});
	});

	$bdl.find('.block').click(function () {
		$('[data-toggle="tooltip"]').tooltip();
	});

	btnAction();
	resultPie();
});
