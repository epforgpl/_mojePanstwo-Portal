/*global Highcharts, mPHeart, window, document, $, confirm, bdlClick*/

$(document).ready(function () {
	var $podatki = $('#podatki'),
		$stripe = $('.stripe'),
		$chartArea = $('.pie_chart'),
		$bdl = $('.bdlClickEngine'),
		chart;

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
		var res = $chartArea.attr('data-series'),
			categories = [],
			data = [],
			dataSeries = [],
			userSeries = [];

		if (typeof res !== "undefined" && res !== false) {
			res = $.parseJSON(res);

			var suma = $chartArea.attr('data-suma'),
				podatek = $chartArea.attr('data-podatek'),
				i, bLen;

			for (i = 0, bLen = res.length; i < bLen; i++) {
				categories.push(res[i].nazwa);
				dataSeries.push(parseFloat(((res[i].kwota / suma) * podatek).toFixed(0)));
				userSeries.push(0);
			}

			data.push({
				name: 'Koszt wg. Państwa',
				data: dataSeries
			}, {
				name: 'Koszt sugerowany wg. użytkownika',
				data: userSeries,
				color: '#f0ad4e',
				draggableY: true,
				dragMinY: 0,
				visible: false,
				cursor: 'ns-resize',
				dataLabels: {
					borderRadius: 5,
					backgroundColor: 'rgba(255, 255, 255, 0.75)',
					zIndex: 7
				}
			});

			chart = new Highcharts.Chart({
				credits: false,
				chart: {
					renderTo: 'pie_chart',
					type: 'column',
					backgroundColor: 'transparent',
					height: 700,
					marginTop: 50,
					spacingBottom: 30,
					marginLeft: 0,
					options3d: {
						enabled: true,
						alpha: 10,
						beta: 25,
						depth: 70
					},
					events: {}
				},
				title: {
					text: ' '
				},
				plotOptions: {
					column: {
						depth: 25,
						dataLabels: {
							align: 'center',
							enabled: true,
							crop: false,
							overflow: 'none',
							allowOverlap: 10,
							formatter: function () {
								return Highcharts.numberFormat(this.y, 0) + ' zł';
							}
						}
					},
					series: {
						point: {
							events: {
								dblclick: function (e) {
									if (this.series.index === 1) {
										var index = this.index,
											y = this.y,
											$div = $('<div></div>')
												.dialog({
													title: ' ',
													width: 400,
													height: 200,
													dialogClass: 'modal-dialog',
													close: function (event, ui) {
														$(this).dialog('destroy').remove();
													}
												});

										$div.append(
											$('<div></div>').addClass('form-group').append(
												$('<label></label>').attr('for', 'newY').text('Podaj nową wartość')
											).append(
												$('<input>').attr({
													type: 'number',
													class: 'form-control',
													placeholder: y,
													id: 'newY'
												})
											)
										).append(
											$('<div></div>').addClass('modal-footer').append(
												$('<button></button>').addClass('btn btn-success margin-top-10 pull-right').text('Zapisz').click(function () {
													var newY = Math.round($('#newY').val()),
														maxSum = 0,
														pod = Math.round(podatek);

													for (var i = 0; i < userSeries.length; i++) {
														if (typeof userSeries[i] === "object") {
															maxSum += Math.round(userSeries[i].y);
														} else {
															maxSum += Math.round(userSeries[i]);
														}
													}

													maxSum = maxSum + (newY - Math.round(y));

													if (newY < 0) {
														chart.series[1].data[index].update(0);
														chart.redraw();
														$div.dialog("close");
														return;
													} else if (maxSum > pod) {
														var correct = Math.round(newY) - (maxSum - pod);

														if (correct < 0) {
															correct = 0;
														}
														chart.series[1].data[index].update(Math.round(correct));
														chart.redraw();
														$div.dialog("close");
														return;
													}
													chart.series[1].data[index].update(Math.round(newY));
													chart.redraw();
													$div.dialog("close");
												})
											)
										);
									}
								},
								drag: function (e) {
									if (e.y < 0) {
										this.y = 0;
										return false;
									}
								},
								drop: function () {
									var maxSum = 0,
										pod = Math.round(podatek);

									for (var i = 0; i < userSeries.length; i++) {
										if (typeof userSeries[i] === "object") {
											maxSum += Math.round(userSeries[i].y);
										} else {
											maxSum += Math.round(userSeries[i]);
										}
									}

									this.y = Math.round(this.y);

									if (this.y < 0) {
										this.y = 0;
										chart.series[1].data[this.index].update({
											x: Math.round(this.x),
											y: Math.round(this.y)
										});
										chart.redraw();

										maxSum = 0;
										for (var i = 0; i < userSeries.length; i++) {
											if (typeof userSeries[i] === "object") {
												maxSum += Math.round(userSeries[i].y);
											} else {
												maxSum += Math.round(userSeries[i]);
											}
										}

										$moneyLeft.attr('data-sum', pod - maxSum).find('span').text(pod - maxSum);

										return false;
									} else if (maxSum > pod) {
										var correct = Math.round(this.y) - (maxSum - pod);
										if (correct < 0) {
											this.y = 0;
										} else {
											this.y = correct;
										}
										chart.series[1].data[this.index].update({
											x: Math.round(this.x),
											y: Math.round(this.y)
										});
										chart.redraw();

										maxSum = 0;
										for (var i = 0; i < userSeries.length; i++) {
											if (typeof userSeries[i] === "object") {
												maxSum += Math.round(userSeries[i].y);
											} else {
												maxSum += Math.round(userSeries[i]);
											}
										}
										$moneyLeft.attr('data-sum', pod - maxSum).find('span').text(pod - maxSum);

										return false;
									}
									chart.series[1].data[this.index].update({
										x: Math.round(this.x),
										y: Math.round(this.y)
									});
									chart.redraw();

									maxSum = 0;
									for (var i = 0; i < userSeries.length; i++) {
										if (typeof userSeries[i] === "object") {
											maxSum += Math.round(userSeries[i].y);
										} else {
											maxSum += Math.round(userSeries[i]);
										}
									}
									$moneyLeft.attr('data-sum', pod - maxSum).find('span').text(pod - maxSum);
								}
							}
						},
						stickyTracking: false
					}
				},
				xAxis: {
					categories: categories,
					labels: {
						rotation: -45,
						align: 'right'
					},
					title: {
						text: ''
					},
					crosshair: true
				},
				yAxis: {
					min: 0,
					title: {
						text: 'zł'
					}
				},
				tooltip: {
					enabled: false
				},
				legend: {
					enabled: false
				},
				series: data
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
			scrollTop: $stripe.offset().top - 40
		}, 600);
	}

	$bdl.find('.item .inner.clickable').click(function (e) {
		bdlClick($(e.target).parents('.bdlBlock')[0]);
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

	$bdl.find('.bdlBlock').each(function () {
		$(this).find('.wskazniki li .wskaznikText .href').each(function () {
			var textBlock = $(this);
			if (textBlock.text().indexOf("(") > -1) {

				var tooltip = $('<span></span>').attr({
					'title': textBlock.text().match(/\(([^)]+)\)/)[1],
					'data-placement': 'bottom',
					'data-toggle': 'tooltip'
				}).addClass('tooltipIcon').text('i');
				textBlock.text(textBlock.text().replace(/ *\([^)]*\) */g, "")).append(tooltip);
			}
		});
	});

	$bdl.find('.bdlBlock').click(function () {
		$('[data-toggle="tooltip"]').mouseover(function () {
			$('.infoBlock .content').css('overflow', 'visible');
		}).mouseout(function () {
			$('.infoBlock .content').css('overflow', 'hidden');
		}).tooltip();
	});

	var $userChart = $('.userChart'),
		$userChartBlock = $('.userChartBlock'),
		$moneyLeft = $('.moneyLeft');

	$userChart.click(function () {
		for (var k = 0; k < chart.series[1].data.length; k++) {
			chart.series[1].data[k].update(0);
		}
		chart.series[1].show();
		$moneyLeft.show();
		$userChart.addClass('disabled hide');
		$userChartBlock.removeClass('hide');
	});

	$userChartBlock.find('.userChartCancel').click(function () {
		var podatek = Math.round($chartArea.attr('data-podatek'));

		if ($(this).hasClass('userOptions')) {
			for (var k = 0; k < chart.series[1].data.length; k++) {
				chart.series[1].data[k].update(null);
			}
			chart.series[1].hide();
			$moneyLeft.hide().attr('data-sum', podatek).find('span').text(podatek);

			$userChart.removeClass('disabled hide');
		} else {
			chart.series[1].options.cursor = 'default';
			chart.series[1].options.draggableY = false;
			$('.userChartTitle').hide();
			$moneyLeft.hide().attr('data-sum', podatek).find('span').text(podatek);
		}
		$userChartBlock.find('.alert').removeClass('alert-error alert-warning alert-success').addClass('hide').text('');
		$userChartBlock.addClass('hide');
	});
	$userChartBlock.find('.userChartSave').click(function () {
		var btn = $(this),
			btnParent = $(this).parent(),
			sUserSetup = $('.userSetup :input').serializeArray(),
			sUser = [],
			sSex = $('#inputSex').val(),
			sAge = $('#inputAge').val();

		if (!btn.hasClass('disabled')) {
			$.each(chart.series[1].data, function () {
				sUser.push(this.y);
			});

			if (Number($moneyLeft.attr('data-sum')) === 0) {
				$.ajax({
					url: "/podatki.json",
					method: "POST",
					data: {
						'_action': 'send',
						userSetup: sUserSetup,
						userGraph: sUser,
						userSex: sSex,
						userAge: sAge
					},
					beforeSend: function () {
						btnParent.find('.btn').addClass('disabled');
					},
					success: function (res) {
						if (res.status) {
							btnParent.find('.alert').removeClass('hide alert-danger alert-warning').addClass('alert-success').text('Dziękujemy. Dane zostały poprawnie zapisane na serwerze.');
							btnParent.find('.btn.userOptions').remove();
							btnParent.find('.btn:not(".userOptions")').removeClass('hide');
						} else {
							btnParent.find('.alert').removeClass('hide alert-success alert-warning').addClass('alert-danger').text('Wystąpił błąd podczas zapisywania danych - prosze spróbować ponownie później.');
						}
					},
					complete: function () {
						btnParent.find('.btn').removeClass('disabled');
					}
				});
			} else {
				btnParent.find('.alert').removeClass('hide alert-success alert-danger').addClass('alert-warning').text('Przed wysłaniem rozdysponuj wszystkie Twoje podatki.');
			}
		}
	});

	btnAction();
	resultPie();
})
;
